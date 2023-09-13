<!-- Rodrigo Onate
     CPSC 491
     Aobuild project -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Aobuild-Login</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="logo1">
            <p>Aobuild</p>
        </div>
        <div class="container">
            <div class="box form-box">
                <header>Login</header>
                <form action="login.php" method="POST">
                    <?php
						if (isset($_GET["error"])){
                            if($_GET["error"] == "incorrectusernamepw"){
                                echo "<p> Invalid username or password </p>";
                            }
						}
					?>
                    <div class="field input validate-input" data-validate = "Valid username required">
                        <label for="username" >Username</label>
                        <input class="input100" type="text" name="username" id="username" required>
                    </div>
                    <div class="field input validate-input" data-validate = "Password is required">
                        <label for="password">Password</label>
                        <input class="input100" type="password" name="pass" id="password" required>
                    </div>
                    <div class="field">
                        <input type="submit" class="btn" name="submit" value="Login" required>
                    </div>
                    <div class="links">
                        Don't have account? <a href="register.php">Sign up!</a>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>