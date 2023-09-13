<!-- Rodrigo Onate
     CPSC 491
     Aobuild project -->
<?php
	$username= $_POST['username'];
	$pass= $_POST['pass'];

	//Database connection
	
	$dbServername = "localhost";
	$dbUsername = "root";
	$dbPassword = "";
	$dbName = "aobuild_database";
	$conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
	if(mysqli_connect_error()){
		die('Connection Failed: '.mysqli_connect_error());
	}else{
		$stmt = $conn->prepare("select * from userprofile where username = ?");
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$stmt_result = $stmt->get_result();
		if($stmt_result->num_rows > 0){
			$data = $stmt_result->fetch_assoc();
			$pwdcheck = password_verify($pass, $data['pass']);
			if($pwdcheck == true){
				//dynamic log in
				$ID = mysqli_real_escape_string($conn, $username);
				$sql = "SELECT * FROM userprofile WHERE username = '$ID' ";
				$result = mysqli_query($conn, $sql) or die("Bad Query: $sql");
				$row = mysqli_fetch_array($result);
				$Userid = $row['username'];
				session_start();
				$_SESSION['uid'] = $Userid;
				echo "<h2>Login Successfully</h2>";
				header("Location: home.php?ID=$Userid");
				exit();
			}else{
				echo "<h2>Invalid username or password</h2>";
				header('Location: index.php?error=incorrectusernamepw');
				exit();
			}
		}else{
			echo "<h2>Invalid username or password</h2>";
			header('Location: index.php?error=incorrectusernamepw');
			exit();
		}
		$stmt->close();
		$conn->close();
		
	}
?>
