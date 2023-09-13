<!-- Rodrigo Onate
     CPSC 491
     Aobuild project  -->
<?php
	$username = $_POST['username'];
	$email = $_POST['email'];
	$pass = $_POST['pass'];
	$hashedpw = password_hash($pass, PASSWORD_DEFAULT);
	$confirmpass = $_POST['confirmpass'];
	$hashconpw = password_hash($confirmpass, PASSWORD_DEFAULT);

	//Database connection
	
	$dbServername = "localhost";
	$dbUsername = "root";
	$dbPassword = "";
	$dbName = "aobuild_database";
	$conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
	if(mysqli_connect_error()){
		die('Connection Failed: '.mysqli_connect_error());
	}else{
		//password confirm
		if($pass !== $confirmpass)
		{
			echo "Passwords do not match";
			header('Location: register.php?error=passwordsdontmatch');
			exit();
		}
		
		//duplicate check
		$dup =  "SELECT * from userprofile where email = ?;";
		$stmt = mysqli_stmt_init($conn);
		mysqli_stmt_prepare($stmt, $dup);
		mysqli_stmt_bind_param($stmt, "s", $email);
		mysqli_stmt_execute($stmt);
		$resultData = mysqli_stmt_get_result($stmt);
		if(mysqli_fetch_assoc($resultData)){
			echo "This email is already taken ";
			header('Location: register.php?error=emailalreadytaken');
			exit();
		}
		$dup2 = "SELECT * from userprofile where username = ?; ";
		$stmt = mysqli_stmt_init($conn);
		mysqli_stmt_prepare($stmt, $dup2);
		mysqli_stmt_bind_param($stmt, "s", $username);
		mysqli_stmt_execute($stmt);
		$resultData = mysqli_stmt_get_result($stmt);
		if(mysqli_fetch_assoc($resultData)){
			echo "This username is already taken ";
			header('Location: register.php?error=usernamealreadytaken');
			exit();
		}else{
			
		//Registration sucesss insert statements
		$INSERT = "INSERT INTO userprofile (username, email, pass) 
			values(?,?,?)";
		$stmt = $conn->prepare($INSERT);
		$stmt->bind_param("sss", $username, $email, $hashedpw);
		$stmt->execute();
		
		echo "registration successfully...";
		
		$ID = mysqli_real_escape_string($conn, $email);
		$sql = "SELECT * FROM userprofile WHERE email = '$ID' ";
		$result = mysqli_query($conn, $sql) or die("Bad Query: $sql");
		$row = mysqli_fetch_array($result);
		$Userid = $row['username'];
		
		$stmt->close();		
		$conn->close();
		
		session_start();
		$_SESSION['uid'] = $Userid;		
		header("Location: home.php?ID=$Userid");
		exit();
		
		}
		
	}
?>
