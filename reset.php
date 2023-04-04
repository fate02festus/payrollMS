<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Admin | Employee's Payroll Management System</title>
 	

<?php include('./header.php'); ?>
<?php include('./db_connect.php'); ?>
<?php 
$username=$_GET['username'];
$phone=$_GET['phone'];
$qry = $conn->query("SELECT * FROM `users` WHERE `username` = '$username' && `contact` = '$phone'") or die(mysqli_error());
 $fetch = $qry->fetch_array();
 $isValid = $qry->num_rows;

if($isValid <= 0)
{
		echo " <script>alert('Username or Phone number do not exist> kindly check');</script>";
	  echo " <script>setTimeout(\"location.href='login.php';\",150);</script>";
}
session_start();
if(isset($_SESSION['login_id']))
header("location:index.php?page=home");

if(ISSET($_POST['save_house']))
{
	   $password=$_POST['password'];
	   $cpassword=$_POST['cpassword'];
	   $conn->query("update users set password='$password' where username='$username'") or die(mysqli_error());

		if($writex)
	   {
	    echo " <script>alert('Password Successfully Changed..');</script>";
	   echo " <script>setTimeout(\"location.href='login.php';\",150);</script>";
	  }
		else 
	  {
	    echo " <script>alert('Error insering records..');</script>";
	    echo " <script>setTimeout(\"location.href='forget_pass.php';\",150);</script>";
	  }

}
?>

</head>
<style>
	body{
		width: 100%;
	    height: calc(100%);
	    /*background: #007bff;*/
	}
	main#main{
		width:100%;
		height: calc(100%);
		background:white;
	}
	#login-right{
		position: absolute;
		right:0;
		width:40%;
		height: calc(100%);
		background:white;
		display: flex;
		align-items: center;
	}
	#login-left{
		position: absolute;
		left:0;
		width:60%;
		height: calc(100%);
		background:#59b6ec61;
		display: flex;
		align-items: center;
	background: url(payroll-cover.png);
	    background-repeat: no-repeat;
	    background-size: cover;
	}
	#login-right .card{
		margin: auto;
		z-index: 1
	}
	.logo {
    margin: auto;
    font-size: 8rem;
    background: white;
    padding: .5em 0.7em;
    border-radius: 50% 50%;
    color: #000000b3;
    z-index: 10;
}
div#login-right::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: calc(100%);
    height: calc(100%);
    background: #9fa3a7e0;
}

</style>

<body>


  <main id="main" class=" bg-dark">
  		<div id="login-left">
  			
  		</div>

  		<div id="login-right">
  			<div class="card col-md-8">
  				<div class="card-body">
  					<img src="ap.png">
  						<h2 class="text-black text-center"><b> Reset Password </b></h2>	
  					<form id="login-formm" action="reset.pdf" >
  						<div class="form-group">
  							<label for="username" class="control-label">Username</label>
  							<input type="text" id="un" name="un" value="<?php echo $username ?>" disabled="disabled" class="form-control">
  						</div>
  						<div class="form-group">
  							<label for="username" class="control-label">Password</label>
  							<input type="Password" id="Password" name="Password" class="form-control">
  						</div>
  						<div class="form-group">
  							<label for="username" class="control-label">Confirm Password</label>
  							<input type="Password" id="cpassword" name="cpassword" class="form-control">
  						</div>
  						
  						<center><button class="btn-sm btn-block btn-wave col-md-4 btn-primary">Save</button></center>
  					</form>
  				</div>
  			</div>
  		</div>
   

  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


</body>

</html>