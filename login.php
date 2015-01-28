<?php
	require_once('Common_Function.php');
	
	setcookie("userid",$_POST['userid'],time()+3600);
	
	$regexUserID = "/^[PDpd][0-9]{3}$/";
	$firstChar = $_POST['userid'][0];
	
	$id = isset($_POST['userid'])? $_POST['userid'] : NULL;
	$password = isset($_POST['password'])? $_POST['password'] : NULL;
	
	$errorMsg = NULL;
	
	echo print_r($_SESSION);
	
	if(isset($_POST['login'])) {
		try {
			if($id == NULL){throw new customException("Empty ID!");}
			if($password == NULL){throw new customException("Empty password!");}
			if ($firstChar=="P")
				passengerLogin($id,$password);
			elseif ($firstChar=="D") {
				driverLogin($id,$password);
			}
		}
		catch(customException $e) {
			$errorMsg = $e->error();
		}
	} 
	
	if(isset($_POST['logout'])) {
		logout();
		header('Location: index.php');
	}
?>


<!Doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="./css/mystyle.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">
		<title>Passenger View</title>
	</head>
	
	<body>
		<div style="background-color: white">
			<div id="container">
			
			<?php include './include/top.inc';?>
			
			<?php
				if( $errorMsg == NULL && (!isset($_SESSION['passenger']['status']) || $_SESSION['passenger']['status']==false ) && ( !isset($_SESSION['driver']['status']) || $_SESSION['driver']['status']==false)){
			?>
				
				<div id="universalLogin">
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="pure-form pure-form-aligned">
						<div class="pure-control-group">
							<label for="userid"> USER ID: </label>
							<input type="text" name="userid" value="<?php echo $_COOKIE['userid'] ?>"/>
						</div>
						<div class="pure-control-group">
							<label for="password"> PASSWORD: </label>
							<input type="password" name="password"/>
						</div>
						<div class="pure-controls">
							<button type="submit" name="login" value="submit" class="pure-button pure-button-primary" style="background-color: #cc0000"> SIGN IN </div>
						</div>
					</form>
				</div>
				
			<?php
				}
				elseif($_SESSION['passenger']['status']) {
			?>
				<div id="universalLogin">
					<style scoped>
						.button-success {
							color: white;
							border-radius: 4px;
							text-shadow: 0 1px 1px rgba(0,0,0,0.2);
						}
						.button-success{background: rgb(28,184,65);}
							
					</style>
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
						<div class="pure-control-group">
							HELLO, <?php echo $_SESSION['passenger']['id'] ?> ! <br>
							WELCOME BACK!
						</div>
						<button class="button-success pure-button"> <a href="booking.php"> BOOK BUS </a> </button>
						<br/>
						<button type="submit" name="logout" value="logout" class="pure-button pure-button-primary" style="background-color: #cc0000"> LOGOUT </div>
					</form>
				</div>
			<?php
				} elseif($_SESSION['driver']['status']) {
			?>
				<div id="universalLogin">
					<form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
						<div class="pure-control-group">
							<?php echo $_SESSION['driver']['id'] ?>, Login Successfully! <br>
							Your today's job shown below.
						</div>
						<div id="JobList">
							<?php displayDriverRoute(); ?>
						</div>
						<br>
						<button type="submit" name="logout" value="logout" class="pure-button pure-button-primary" style="background-color: #cc0000"> LOGOUT </div>
						<br>
					</form>
				</div>
		
			<?php
				} else {
			?>
				<div id="universalLogin">
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
						<?php echo $errorMsg; ?>
						<br/>
						<button class="button-success pure-button"> <a href='login.php'> Try again </a> </button>
					</form>
				</div>
			<?php
				}
			?>

			
			</div>
			
			<?php include './include/footer.inc';?>
			
		</div>
	
	</body>
</html>