<?php 
  session_start(); 

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
	header("location: login.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="style.css">
     <style>
	    body {
	          background-color: #B0F4DC;
        }
     p{
		 color: red;
		 text-align: center;
		 
	 }
	 h1{
		 color: violet;
		 text-align: center;
		 font-style: italic;
	 }
     </style>
	</head>
<body>

<div class="header">
	<h2>Home Page</h2>
</div>
<div class="content">
  	<!-- notification message -->
  	<?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
      	<h3>
          <?php 
          	echo $_SESSION['success']; 
          	unset($_SESSION['success']);
          ?>
      	</h3>
      </div>
  	<?php endif ?>

    <!-- logged in user information -->
    <?php  if (isset($_SESSION['username'])) : ?>
    	<h1>Welcome <strong><?php echo $_SESSION['username'];?></strong></h1>
        <p> This is your profile</p>
	    <p> <a href="index.php?logout='1'" style="color : green;">logout
	     </a> </p>
    <?php endif ?>
</div>
		
</body>
</html>
