<!-- Rodrigo Onate
     CPSC 491
     Aobuild project -->
<?php
	session_start();
    date_default_timezone_set('America/Los_Angeles');
	$dbServername = "localhost";
	$dbUsername = "root";
	$dbPassword = "";
	$dbName = "aobuild_database";
	$conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
	if(mysqli_connect_error()){
		die('Connection Failed: '.mysqli_connect_error());
	}
    if(!isset($_GET["ID"])){
        header('Location: index.php');
        exit();
    }
    $ID = mysqli_real_escape_string($conn, $_GET['ID']);
    $sql = "SELECT * FROM userprofile WHERE username = '$ID' ";
    $result = mysqli_query($conn, $sql) or die("Bad Query: $sql");
    if (mysqli_num_rows($result) == 0){
        die('No such user');
    }
    $row = mysqli_fetch_array($result); 

    $query = "SELECT u.username, u.image, p.time_posted, p.post_message, p.post_image, p.id FROM userprofile AS u,
                    user_post AS p WHERE u.username = p.username ORDER BY p.id DESC";
    $results = $conn -> query($query);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Aobuild-Home</title>
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.6/css/unicons.css">
        <link rel="stylesheet" href="style2.css">
    </head>
    <body>
        <nav>
            <div class="container">
                <h2 class="log">
                    Aobuild
                </h2>
                <div class="search-bar">
                    <i class="uil uil-search"></i>
                    <input type="search" placeholder="What build are you looking for today, username?">
                </div>
                <div class="create">
                    <label class="btn btn-primary" for="search-bar">Search</label>
                    <div class="profile-photo">
                        <?php
                            if($row['image'] == NULL){?>
                                <img src="./images/signup.jpg"> <?php
                            }else{
                                echo "<img src=".($row['image']).">";
                            }  
                        ?>
                    </div>
                </div>
            </div>
        </nav>
        <main>
            <div class="container">
                <!-- Left side of the page -->
                <div class="left">
                    <a class="profile">
                        <div class="profile-photo">
                            <?php
                                if($row['image'] == NULL){?>
                                    <img src="./images/signup.jpg"> <?php
                                }else{
                                    echo "<img src=".($row['image']).">";
                                }  
                            ?>
                        </div>
                        <div class="handle">
                            <h4>@<?php echo $row['username']; ?></h4> 
                        </div>
                    </a>
                    <!-- side bar-->
                    <div class="sidebar">
                        <a class="menu-item active">
                            <span><i class="uil uil-home"></i></span><h3>Home</h3>
                        </a>
                        <a class="menu-item" id="notifications">
                            <span><i class="uil uil-bell"><small class="notification-count">9+</small></i></span><h3>Notifications</h3>
                            <!-- notification popup -->
                            <div class="notifications-popup">
                                <div>
                                    <div class="profile-photo">
                                        <img src="./images/profile2.jpg">
                                    </div>
                                    <div class="notification-body">
                                        <b>Mark Stof</b> accepted your friend request
                                        <small class="text-muted"> 2 DAYS AGO </small>
                                    </div>
                                </div>
                                <div>
                                    <div class="profile-photo">
                                        <img src="./images/profile3.jpg">
                                    </div>
                                    <div class="notification-body">
                                        <b>Rodrigo</b> commented on your post
                                        <small class="text-muted"> 2 HOURS AGO </small>
                                    </div>
                                </div>
                                <div>
                                    <div class="profile-photo">
                                        <img src="./images/profile4.jpg">
                                    </div>
                                    <div class="notification-body">
                                        <b>Michael</b> commented on your post
                                        <small class="text-muted">4 HOURS AGO </small>
                                    </div>
                                </div>
                                <div>
                                    <div class="profile-photo">
                                        <img src="./images/profile5.jpg">
                                    </div>
                                    <div class="notification-body">
                                        <b>Sav Schre</b> and <b>283 others </b>
                                        <small class="text-muted">2 HOURS AGO</small>
                                    </div>
                                </div>
                            </div>
                        <!-- End popup-->
                        </a>
                        <a class="menu-item" id="messages-notification">
                            <span><i class="uil uil-envelope-alt"><small class="notification-count">6</small></i></span><h3>Message</h3>
                        </a>
                        <a class="menu-item" id="see-friends">
                            <span><i class="uil uil-users-alt"></i></span><h3>Friends</h3>
                        </a>
                        <a class="menu-item" id="see-bookmarks">
                            <span><i class="uil uil-bookmark"></i></span><h3>Bookmarks</h3>
                        </a>
                        <a class="menu-item" id="setup-settings">
                            <span><i class="uil uil-setting"></i></span><h3>Settings</h3>
                        </a>
                        <a class="menu-item" id="theme">
                            <span><i class="uil uil-palette"></i></span><h3>Theme</h3>
                        </a>
                    </div>
                    <?php
                        if (isset($_SESSION["uid"])){
                            if($_SESSION["uid"] == $ID){
                                $Userid = $row['username'];
                                echo "<li><a href='logout.php'class='btn btn-primary'>Log Out</a></li>";
                            }
                        }
                    ?>
                </div>
                <!-- Middle of the page -->
                <div class="middle">
                    <!-- Create posts -->
                    <form action="posts.php" method="post" enctype="multipart/form-data">
                        <div class="create-post">
                            <div class="profile-photo">
                                <?php
                                    if($row['image'] == NULL){?>
                                        <img src="./images/signup.jpg"> <?php
                                    }else{
                                        echo "<img src=".($row['image']).">";
                                    }  
                                ?>
                            </div>
                            <input type="text" name="post_message" placeholder="Couldn't find your build? Ask away!" id="create-post">
                            <label class="uil uil-image">
                                <input type="file" name="post_image" style="display:none">
                            </label>
                            <input type="submit" value="Post" name="Post" class="btn btn-primary">
                        </div>
                    </form>
                    <!-- End of create posts-->
                    <!-- Feed 1 -->
                    <div class="feeds">
                        <?php  
                            while($row_post = mysqli_fetch_array($results)){
                                $post_time = new DateTime($row_post['time_posted']);
                                $current_time = new DateTime();
                                $time_diff = $current_time->diff($post_time);
                                ?>
                                <div class="feed">
                                    <div class="head">
                                        <div class="user">
                                            <div class="profile-photo">;
                                                <?php
                                                    if($row_post['image'] == NULL){?>
                                                        <img src="./images/signup.jpg"> <?php
                                                    }else{
                                                        echo "<img src=".($row_post['image']).">";
                                                    }  
                                                ?>
                                            </div>
                                            <div class="info">
                                                <h3><?php echo $row_post['username']; ?></h3>
                                                <small> <?php if ($time_diff->y > 0) {
                                                    echo $time_diff->y . ' year' . ($time_diff->y > 1 ? 's' : '') . ' ago';
                                                    } elseif ($time_diff->m > 0) {
                                                    echo $time_diff->m . ' month' . ($time_diff->m > 1 ? 's' : '') . ' ago';
                                                    } elseif ($time_diff->d > 0) {
                                                    echo $time_diff->d . ' day' . ($time_diff->d > 1 ? 's' : '') . ' ago';
                                                    } elseif ($time_diff->h > 0) {
                                                    echo $time_diff->h . ' hour' . ($time_diff->h > 1 ? 's' : '') . ' ago';
                                                    } elseif ($time_diff->i > 0) {
                                                    echo $time_diff->i . ' minute' . ($time_diff->i > 1 ? 's' : '') . ' ago';
                                                    } else {
                                                        echo 'Just now';
                                                    }?></small>
                                            </div>
                                        </div>
                                        <span class="edit">
                                            <i class="uil uil-ellipsis-h"></i>
                                        </span>
                                    </div>
                                    <div class="caption">
                                        <p><?php echo $row_post['post_message']; ?>
                                       <!-- <span class="hash-tag">#helpme</span></p> -->
                                    </div>
                                    <div class="photo">
                                        <?php if(empty($row_post['post_image'])):?>
                                            <img src="">
                                        <?php else :?>
                                            <img src="uploads/<?=$row_post['post_image']?>">
                                        <?php endif;?>
                                    </div>
                                    <div class="action-buttons">
                                        <div class="interaction-buttons">
                                            <span><i class="uil uil-heart"></i></span>
                                            <span><i class="uil uil-comment-dots"></i></span>
                                            <span><i class="uil uil-share-alt"></i></span>
                                        </div>
                                        <div class="bookmark">
                                            <span><i class="uil uil-bookmark-full"></i></span>
                                        </div>
                                    </div>
                                    <div class="liked-by">
                                        <p><b>324 likes</b></p>
                                    </div>
                                    <div class="comments text-muted">
                                        View all 400 comments
                                    </div>
                                </div>
                            <?php
                            }
                        ?>
                    </div>
                    <!-- End of feed 1 -->
                </div>
                <!-- Right side of the page-->
                <div class="right">
                    <div class="messages">
                        <div class="heading">
                            <h4>Messages</h4><i class="uil uil-edit"></i>
                        </div>
                        <!-- Search bar for chat -->
                        <div class="search-bar">
                            <i class="uil uil-search"></i>
                            <input type="search" placeholder="Search messages" id="message-search">
                        </div>
                        <!-- Messages by category-->
                        <div class="category">
                            <h6 class="active">Primary</h6>
                            <h6>General</h6>
                            <h6 class="message-requests">Requests(7)</h6>
                        </div>
                        <!-- Message -->
                        <div class="message">
                            <div class="profile-photo">
                                <img src="./images/profile20.jpg">
                            </div>
                            <div class="message-body">
                                <h5>Felipe Castro</h5>
                                <p class="text-bold">Hello hello!</p>
                            </div>
                        </div>
                        <!-- Message -->
                        <div class="message">
                            <div class="profile-photo">
                                <img src="./images/profile24.jpg">
                                <div class="active"></div>
                            </div>
                            <div class="message-body">
                                <h5>Vicente</h5>
                                <p class="text-muted">what are you up to?</p>
                            </div>
                        </div>
                        <!-- Message -->
                        <div class="message">
                            <div class="profile-photo">
                                <img src="./images/profile40.jpg">
                            </div>
                            <div class="message-body">
                                <h5>Edem Quist</h5>
                                <p class="text-muted">How is it going!?</p>
                            </div>
                        </div>
                    </div>
                    <!-- End of messages section-->
                    <div class="friend-requests">
                        <h4>Friend requests</h4>
                        <div class="request">
                            <div class="info">
                                <div class="profile-photo">
                                    <img src="./images/profile30.jpg">
                                </div>
                                <div>
                                    <h5>Moises Esteves </h5>
                                    <p class="text-muted">
                                        5 mutual friends
                                    </p>
                                </div>
                            </div>
                            <div class="action">
                                <button class="btn btn-primary">
                                    Accept
                                </button>
                                <button class="btn">
                                    Decline
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <!-- Theme customization-->
        <div class="customize-theme">
            <div class="card">
                <h2>Customize your theme</h2>
                <p class="text-muted">Customize font size, color, and background.</p>
                <!-- Font sizes -->
                <div class="font-size">
                    <h4>Font Size</h4>
                    <div>
                        <h6>Aa</h6>
                    <div class="choose-size">
                        <span class="font-size-1"></span>
                        <span class="font-size-2"></span>
                        <span class="font-size-3 active"></span>
                        <span class="font-size-4"></span>
                        <span class="font-size-5"></span>
                    </div>
                    <h3>Aa</h3>
                    </div>
                </div>
                <!-- Color -->
                <div class="color">
                    <h4>Color</h4>
                    <div class="choose-color">
                        <span class="color-1 active"></span>
                        <span class="color-2"></span>
                        <span class="color-3"></span>
                        <span class="color-4"></span>
                        <span class="color-5"></span>
                    </div>
                </div>
                <!-- Background color -->
                <div class="background">
                    <h4>Background color</h4>
                    <div class="choose-bg">
                        <div class="bg-1 active">
                            <span></span>
                            <h5 for="bg-1">Light</h5>
                        </div>
                        <div class="bg-2">
                            <span></span>
                            <h5>Dim</h5>
                        </div>
                        <div class="bg-3">
                            <span></span>
                            <h5 for="bg-3">Lights Off</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="customize-settings">
            <div class="card">
                <h2>Settings</h2>
                <p class="text-muted">Change your profile picture, email and/or password.</p>
                <div class="change-proimage">
                    <h4>Image</h4>
                    <input></input>
                </div>
                <div class="change-email">
                    <h4>Email</h4>
                </div>
                <div class="change-password">
                    <h4>Password</h4>
                </div>
            </div>
        </div> -->
        <script src="./home.js"></script>
    </body>
</html>