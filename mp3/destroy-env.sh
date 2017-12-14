#!/bin/bash

aws autoscaling detach-load-balancers --auto-scaling-group-name itmo-544-cloud-as --load-balancer-name itmo-544-elb

aws autoscaling delete-auto-scaling-group --auto-scaling-group-name itmo-544-cloud-as --force-delete

aws autoscaling delete-launch-configuration --launch-configuration-name $1

cloud=`aws ec2 describe-instances  --query 'Reservations[*].Instances[].InstanceId' --filters "Name=instance-state-name, Values=pending" --output text`

aws elb deregister-instances-from-load-balancer --load-balancer-name itmo-544-elb --instances $itmoCloud

aws elb delete-load-balancer-listeners --load-balancer-name itmo-544-elb --load-balancer-ports 80

aws elb delete-load-balancer --load-balancer-name itmo-544-elb

aws ec2 terminate-instances --instance-ids $itmoCloud

aws rds delete-db-instance --db-instance-identifier mydb --skip-final-snapshot

aws rds wait db-instance-deleted --db-instance-identifier mydb

aws s3 rb s3://itmo-544-msingh --force
aws s3 rb s3://itmo-544-trans --force