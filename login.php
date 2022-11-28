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
    <title>Login Page</title>
    <!--Made with love by Mutiullah Samim -->

    <!--Bootsrap 4 CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!--Custom styles-->
    <link rel="stylesheet" type="text/css" href="login.css">
</head>

<body>
    <?php
    include('Admin/connect.php');
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
                        <div class="row align-items-center remember">
                            <input type="checkbox">Remember Me
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Login" class="btn float-right login_btn" name="login">
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-center links">
                        Don't have an account?<a href="register.php">Sign Up</a>
                    </div>
                    <!-- <div class="d-flex justify-content-center">
					<a href="#">Forgot your password?</a>
				</div> -->
                </div>
            </div>
        </div>
        <?php
        if (isset($_POST['login']) && isset($_POST['username']) && isset($_POST['password'])) {
                $username = $_POST['username'];
                $password = $_POST['password'];
                $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
                $result = mysqli_query($connect, $sql);
                $num_rows = mysqli_num_rows($result);
                if ($num_rows == 0) {
                    echo "<script> alert('Log in unsuccessfully')</script>";
                } else {
                    $username = "SELECT username FROM users WHERE username = '$username' AND password = '$password'";
                    $result = mysqli_fetch_array(mysqli_query($connect, $sql));
                    $username = $result['username'];
                    $_SESSION['username'] = $username;
                    echo "<script> alert('Log in successfully! ". $_SESSION['username'] ."')</script>";
                    echo "<script>window.open('index.php','_self')</script>";
                }
            } else {

            }
        ?>
    </div>
</body>

</html>