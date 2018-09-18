## 1. Copy all the shell scripts create-env.sh,destroy-env.sh and install-app-env.sh to the shared folder of the vagrant box into the '/home/vagrant' directory.

## 2. Execute the 'create-env.sh' file to create environment with following listed parameters:
## $1 is count for number of instances
## $2 is key-pair name
## $3 is security-group ID
## $4 is IAM instance profile name
## $5 is desired launch configuration name

## 3. Notice the Public DNS of any instance, copy the link and open it in the browser.

## 4. Execute the file '/index.php'.
	#  1. sns_queue.php file is which is used to find the NumberOfMessagesSent using Cloudwatch Metrics.
	#  2. sqs_queue.php file is which is used to find the JobVisibe using Cloudwatch Metrics.
	#  3. cloudwatch_cpu file is which is used to find the Cpu Utilization using Cloudwatch Metrics.
	#  4. Dashboard.php file have the details of jobs using read replica of the database and link to details of 
	      Cpu utilization,number of message send and number of messages visible.
	#  5. logout.php file auto closes in Internet explorer.
	#  6. chart.html file is to generate chart for three metrics sns_queue,sqs_queue and cloudwatch_cpu.
		
## 5. To destroy all the environment, execute the 'destroy-env.sh' file with $5 which is given as launch configuration name as parameters in creating the environment.