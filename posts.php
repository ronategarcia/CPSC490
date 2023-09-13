<!-- Rodrigo Onate
     CPSC 491
     Aobuild project -->
<?php
    // Get the post data from the form
    session_start();
    if(!isset($_SESSION['uid'])){
        header("Location: index.php");
        exit();
    }
    $username = $_SESSION['uid']; 
    $post_message = $_POST['post_message'];
    $time_posted = date('Y-m-d H:i:s'); 

    // database connection
	$dbServername = "localhost";
	$dbUsername = "root";
	$dbPassword = "";
	$dbName = "aobuild_database";

    $conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }else{
        $file = $_FILES['post_image'];
			
        $fileName = $_FILES['post_image']['name'];
        $fileTmpName = $_FILES['post_image']['tmp_name'];
        $fileSize = $_FILES['post_image']['size'];
        $fileError = $_FILES['post_image']['error'];
        $fileType = $_FILES['post_image']['type'];
        
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        
        $allowed = array('jpg', 'jpeg', 'png', 'gif');
        
        if(in_array($fileActualExt, $allowed)){
            if($fileError === 0){
                if($fileSize < 10000000){
                    $fileNameNew = uniqid('', true).".".$fileActualExt;
                    $fileDestination = 'uploads/'.$fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);
                }else{
                    echo "File size too big";
                }
            }else{
                echo "File upload error";
            }
        }else{
            echo "File type not allowed";
        }

        $sql = "INSERT INTO user_post (username, post_message, time_posted, post_image) 
                VALUES ('$username', '$post_message', '$time_posted', '$fileNameNew')";

        if (mysqli_query($conn, $sql)) {
            header("Location: home.php?ID=$username");
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        mysqli_close($conn);
    }
?>