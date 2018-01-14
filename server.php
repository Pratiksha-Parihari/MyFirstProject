<?php
session_start();

// variable declaration
$severname= "localhost";
$dbname= "registration";
$username = "";
$email    = "";
$errors   = array(); 
$_SESSION['success'] = "";

// connect to database
$db = mysqli_connect('localhost', 'root', '', 'registration');

// REGISTER USER
if (isset($_POST['reg_user'])) {
 // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

 // form validation: ensure that the form is correctly filled
  if (empty($username)) { array_push($errors, "username is required");
   }
   else {
	   if(!preg_match("/^[a-zA-Z ]*$/", $username)){
       array_push($errors, "username should contain alphabets and whitespace");
	   }
        else{
		$sql= " SELECT *from users WHERE username='$username' ";
		$result=mysqli_query($db,$sql);
		$resultcheck= mysqli_num_rows($result);
		if($resultcheck>0) {
		 array_push($errors,"username is already exist");
		
			
   }}}
  if (empty($email)) { array_push($errors, "Email is required"); }
  else {
		$sql= " SELECT *from users WHERE email='$email'";
		$result=mysqli_query($db,$sql);
		$resultcheck= mysqli_num_rows($result);
		if($resultcheck > 0) {
		 array_push($errors,"email is already exist");
	}}
  if (empty($password_1)) { array_push($errors, "Password is required"); }
   else if(!preg_match("/^[0-9]{8,}$/", $password_1)){
	   array_push($errors, "Password should contain atleast 8 characters");
   }
  
  
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  
  
  // register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database
  	$query = "INSERT INTO users (username, email, password) 
  			  VALUES('$username', '$email', '$password')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
	$_SESSION['success'] = "You are now logged in";
  	header('location: index.php');
  }

}
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
  	array_push($errors, "username is required");
  }
  
  if (empty($password)) {
  	array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
  	$password = md5($password);
  	$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  	$results = mysqli_query($db, $query);
  	if (mysqli_num_rows($results) == 1) {
  	  $_SESSION['username'] = $username;
	  $_SESSION['success'] = "You are now logged in";
  	  header('location: index.php');
  	}else {
  		array_push($errors, "Wrong username/password combination");
  	}
  }
}
?>


