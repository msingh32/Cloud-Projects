## 1. Copy all the shell scripts create-env.sh,destroy-env.sh and install-app-env.sh to the shared folder of the vagrant box into the '/home/vagrant' directory.

## 2. Execute the 'create-env.sh' file to create environment with following listed parameters:
## $1 is count for number of instances
## $2 is key-pair name
## $3 is security-group ID
## $4 is IAM instance profile name
## $5 is desired launch configuration name

## ami-d933e5a1 AMIID created by aws webcaunsole.

## 3. Notice the Public DNS of any instance, copy the link and open it in the browser.

## 4. Execute the file '/index.php'.
	# Index.php has 3 links:
		# Submit.Php which is used for inserting the email id,phone number and the original picture.
		# In submit page I am redirecting it to insert.php where data is getting in queue and inserted 
		  as raw in the bucket and in table by re directing to process.php where message is receive from
		  the queue ,transformed to black and white, inserted to finish image bucket,after deleting from the 
		  queue sns is send throught email.
		# Gall.php which is used to accept the email id from the user and redirect to gallery.php to show all
		  the finished and original images of the particular email id specified by the user.
		# Logout.php It is used to auto close in windows internet explorer.

## 5. To destroy all the environment, execute the 'destroy-env.sh' file with $5 which is given as launch configuration name as parameters in creating the environment.