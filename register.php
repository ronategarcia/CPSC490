<!-- Rodrigo Onate
     CPSC 491
     Aobuild project -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Aobuild-Register</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="logo1">
            <p>Aobuild</p>
        </div>
        <div class="container">
            <div class="box form-box">
                <header>Sign Up</header>
                <form action="connect.php" method="POST">
                    <?php
                        if (isset($_GET["error"])){
                            if($_GET["error"] == "passwordsdontmatch"){
                                echo "<p> Passwords do not match! </p>";
                            }
                            elseif($_GET["error"] == "emailalreadytaken"){
                                echo "<p> Email is already taken! </p>";
                            }
                            elseif($_GET["error"] == "usernamealreadytaken"){
                                echo "<p> Username is already taken! </p>";
                            }
                        }
                    ?> 
                    <div class="field input validate-input">
                        <label for="username" >Username</label>
                        <input class="input100" type="text" name="username" id="username" maxlength="15" autcomplete="off" required>
                    </div>
                    <div class="field input validate-input" data-validate="Valid email is required: ex@abc.xyz">
                        <label for="email" >Email</label>
                        <input class="input100" type="email" name="email" id="email" autcomplete="off" required>
                    </div>
                    <div class="field input validate-input" data-validate="Password required">
                        <label for="password">Password</label>
                        <input class="input100" type="password" name="pass" id="password" autcomplete="off" required>
                    </div>
                    <div class="field input validate-input" data-validate="Password required">
                        <label for="password">Confirm Password</label>
                        <input class="input100" type="password" name="confirmpass" id="password" autcomplete="off" required>
                    </div>
                    <div class="field">
                        <input type="submit" class="btn" name="submit" value="Sign up" required>
                    </div>
                    <div class="links">
                        Already have an account? <a href="index.php">Log in!</a>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>