<?php
	require_once('Common_Function.php');
	
	setcookie("driverId",$_POST['driverId'],time()+3600);

	$id = isset($_POST['driverId'])? $_POST['driverId'] : NULL;
	$password = isset($_POST['password'])? $_POST['password'] : NULL;

	
	$errorMsg = NULL;
	if(isset($_POST['login']))
	{
		try
		{
			if($id == NULL){throw new customException("Empty ID!");}
			if($password == NULL){throw new customException("Empty Password!");}
			driverLogin($id,$password);
			/*loadDriverRoute();*/
		}
		catch(customException $e)
		{
			$errorMsg = $e->error();
		}
	}
	if(isset($_POST['logout']))
	{
		logout();
		header('Location: index.php');
	}
?>
	
<!Doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="./css/mystyle.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="./js/refreshDriverRoute.js"></script>
<title>Driver View</title>
</head>

<body <?php if ($errorMsg == NULL && $_SESSION['driver']['status'] == true) {echo 'onload="refreshJob(';echo $_SESSION['driver']['status']? "'true')\"":"'false')\"";}?> >

<div id="container">

<?php include './include/top.inc';?>

<div id="mainContent">
	<p><b>Driver Login:</b></p>
<?php 
	if($errorMsg == NULL && 
		(!isset($_SESSION['driver']['status']) || $_SESSION['driver']['status'] == false))
	{
?>

	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		Driver ID: <input type="text" name="driverId" value="<?php echo $_COOKIE['driverId'] ?>"/>
		<br/>
		Password: <input type="password" name="password"/>
		<br/>
		<input type="submit" name="login" value="submit"/>
	</form>
	
<?php
	}
	elseif($errorMsg == NULL && $_SESSION['driver']['status'] == true)
	{

		echo "login Successful!!";
		echo "<br/>";
		echo "Hello ".$_SESSION['driver']['id'];
		echo "<br/>";
?>

	<div id="JobList">
<?php		displayDriverRoute(); ?>
	</div>

		<br/>
		<form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<input type="submit" name="logout" value="logout"/>
		</form>
		
<?php
	}
	else
	{
		echo $errorMsg;
		echo "<br/>";
		echo "<a href='driverLogin.php'>Try again</a>";
	}
?>

</div>

<?php include './include/footer.inc';?>

</div>

</body>
</html>