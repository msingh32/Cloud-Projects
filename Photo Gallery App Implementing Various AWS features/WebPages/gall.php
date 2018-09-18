<?php session_start(); ?>

<!DOCTYPE html>
<html>
        <head>
                <title>Submit Page</title>
                 <meta charset="utf-8">
                                <meta name="viewport" content="width=device-width, initial-scale=1">
                                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
                                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
                                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        </head>
        <body>
                        <div class="container">
                        <br/><br/>
                                <div class="jumbotron">

                                <center><h3>Enter the Email Id of the Users</h3></center>
                        </div>
                <div class="first_div">
                                        <div class="row">
                                         <div class="col-md-2 col-md-offset-2">
                        <a href="index.php" class="btn btn-primary">Home</a></div>
                                                   <div class="col-md-2 col-md-offset-6">
                        <a href="gallery.php" class="btn btn-primary">Gallery</a>
                                                </div>
                                                </div>
                </div>

                <div>


                                        <div class="row">
                                         <div class="col-md-4 col-md-offset-4">
                                                <div class="jumbotron">
                                                <br/>
                        <form enctype="multipart/form-data" action="gallery.php" method="POST" >
                                                                                               <div class="form-group">


                                                 Email
                                                 <input type="email" class="form-control" name="email" placeholder="Enter your email" />


                                                                                </div>

                                                                                                <br/><br/>
                                                                                                <div class="row">
                                                                                                <div class="col-md-2">
                                                                                                 <button type="submit" class="btn btn-primary">Submit</button></div>
                                                 <div class="col-md-2 col-md-offset-6">
                                                 <button type="submit" class="btn btn-primary">Reset</button></div>

                                 </div>

                        </form>
                                                </div>
                                                </div>
                                                </div>
                </div>
                                </div>
        </body>
</html>


