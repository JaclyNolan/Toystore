<?php
session_start();
?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html>

<head>
    <title>Register Page</title>
    <!--Made with love by Mutiullah Samim -->

    <!--Bootsrap 4 CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!--Custom styles-->
    <link rel="stylesheet" type="text/css" href="register.css">
</head>

<body>
    <?php
    $connect = mysqli_connect('localhost', 'root', '', 'Defko_Music');
    // if ($connect) {
    //     echo "Successful connection";
    // } else {
    //     echo "Unsuccessful connection";
    // }
    ?>
    <div class="container">
        <div class="d-flex h-10"><a href="index.php"><button class="btn btn-white">Home</button></a></div>
        <div class="d-flex justify-content-center h-100">
            <div class="card">
                <div class="card-header">
                    <h3>Sign In</h3>
                    <div class="d-flex justify-content-end social_icon">
                        <span><i class="fab fa-facebook-square"></i></span>
                        <span><i class="fab fa-google-plus-square"></i></span>
                        <span><i class="fab fa-twitter-square"></i></span>
                    </div>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Full Name" name="full-name">
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Username" name="username">
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" class="form-control" placeholder="Password" name="password">
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" class="form-control" placeholder="Comfirm Password" name="confirm-password">
                        </div>
                        <div class="row align-items-center remember">
                            <input type="checkbox">Remember Me
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Register" class="btn float-right login_btn" name="register">
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-center links">
                        Already have an account?<a href="login.php">Sign in</a>
                    </div>
                    <!-- <div class="d-flex justify-content-center">
					<a href="#">Forgot your password?</a>
				</div> -->
                </div>
            </div>
        </div>
        <?php
        if (isset($_POST['register']) && isset($_POST['full-name']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirm-password'])) {
            $isInvalid = false;
            $invalid_chars = '(){}[]|`¬¦! "£$%^&*"<>:;#~_-+=,';
            $fullname = $_POST['full-name'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm-password'];
            if (!$isInvalid) {
                for ($i = 0; $i < strlen($invalid_chars); $i++) {
                    if (strpos($username, $invalid_chars[$i]) != false) {
                        echo "Invalid Username";
                        $isInvalid = true;
                        break;
                    }
                    if (strpos($password, $invalid_chars[$i]) != false) {
                        echo "Invalid Password";
                        $isInvalid = true;
                        break;
                    }
                }
            }
            if (!$isInvalid) {
                if (strlen($username) < 4 || strlen($username) > 32) {
                    echo "Username must be in 4-32 characters long";
                    $isInvalid = true;
                }
                if (strlen($password) < 4 || strlen($password) > 32) {
                    echo "Password must be in 4-16 characters long";
                    $isInvalid = true;
                }
            }
            if (!$isInvalid) {
                $sql = "SELECT * FROM users WHERE username = '$username'";
                $result = mysqli_query($connect, $sql);
                if (mysqli_num_rows($result) > 0) {
                    echo "Username is taken";
                } else {
                    if ($password != $confirm_password) {
                        echo "Password doesn't match confirm password";
                    } else {
                        $sql = "INSERT INTO users VALUES (NULL, '$username', '$password', '$fullname', NULL, 'user');";
                        $result = mysqli_query($connect, $sql);

                        // echo "Register successfully. Moving you to the login page...";
                        // sleep(5);
                        // header("Location: login.php");
                        echo "<script> alert('Sign up successfully')</script>";
                        echo "<script>window.open('login.php','_self')</script>";
                    }
                }
            }
        }
        ?>
    </div>
</body>

</html>