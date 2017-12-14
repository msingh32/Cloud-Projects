
#!/bin/bash

aws rds create-db-instance --db-name db1 --db-instance-identifier mydb --allocated-storage 20 --db-instance-class db.t2.micro --engine mysql --master-username msingh --master-user-password asdf1234 --availability-zone us-west-2a

aws rds wait db-instance-available --db-instance-identifier mydb

aws s3 mb s3://itmo-544-msingh --region us-west-2
aws s3 mb s3://itmo-544-trans --region us-west-2

aws ec2 run-instances --count $1 --image-id ami-6e1a0117 --key-name $2 --security-group-ids $3 --instance-type t2.micro --iam-instance-profile Name=$4 --user-data file://install-app-env.sh

itmoCloud=`aws ec2 describe-instances  --query 'Reservations[*].Instances[].InstanceId' --filters "Name=instance-state-name, Values=pending" --output text`

aws ec2 wait instance-running --instance-ids $itmoCloud

aws elb create-load-balancer --load-balancer-name itmo-544-elb --listeners "Protocol=HTTP,LoadBalancerPort=80,InstanceProtocol=HTTP,InstancePort=80" --availability-zones us-west-2a --security-groups $3

aws elb register-instances-with-load-balancer --load-balancer-name itmo-544-elb --instances $itmoCloud

aws elb create-lb-cookie-stickiness-policy --load-balancer-name itmo-544-elb --policy-name enable-stickiness-cookie-policy --cookie-expiration-period 60

aws elb set-load-balancer-policies-of-listener --load-balancer-name itmo-544-elb --load-balancer-port 80 --policy-names enable-stickiness-cookie-policy

aws autoscaling create-launch-configuration --launch-configuration-name $5 --image-id ami-6e1a0117 --key-name $2 --instance-type t2.micro --user-data file://install-app-env.sh --security-groups $3 --iam-instance-profile $4

aws autoscaling create-auto-scaling-group --auto-scaling-group-name itmo-544-cloud-as --launch-configuration-name $5 --availability-zones us-west-2a --min-size 0 --max-size 5 --desired-capacity 1

aws autoscaling attach-instances --instance-ids $itmoCloud --auto-scaling-group-name itmo-544-cloud-as

aws autoscaling attach-load-balancers --load-balancer-names itmo-544-elb --auto-scaling-group-name itmo-544-cloud-as