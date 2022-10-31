<?php
session_start();
include("../connect.php");
$username = $_SESSION['username'];
$sql = "SELECT role FROM users WHERE username = '$username'";
$user = mysqli_fetch_array(mysqli_query($connect, $sql));
if ($user['role'] == "admin") {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>Product Page - Admin HTML Template</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700" />
        <!--Bootsrap 4 CDN-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <!--Fontawesome CDN-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

        <!--Custom styles-->
        <link rel="stylesheet" href="song.css">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
        <!--
	Product Admin CSS Template
	https://templatemo.com/tm-524-product-admin
	-->
    </head>

    <body id="reportsPage">
        <?php
        ?>
        <nav class="navbar navbar-expand-xl">
            <div class="container h-100">
                <a class="navbar-brand" href="../../index.php">
                    <h1 class="tm-site-title mb-0">Defko Admin</h1>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars tm-nav-icon"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto h-100">
                        <li class="nav-item">
                            <a class="nav-link active" href="../Songs/song.php">
                                <i class="fas fa-music"></i> Songs
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="../Singers/singer.php">
                                <i class="fas fa-microphone"></i> Singers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../Genres/genre.php">
                                <i class="fas fa-table"></i> Genres
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="../Users/user.php">
                                <i class="far fa-user"></i> Users
                            </a>
                        </li>
                    </ul>
                    <!-- <ul class="navbar-nav">
                        <li class="nav-item">
                            <?php
                            $user_image_path = "..\..\Image\User_Image\\";
                            $username = $_SESSION['username'];
                            $sql = "SELECT image, role FROM users WHERE username = '$username'";
                            $result = mysqli_fetch_array(mysqli_query($connect, $sql));
                            $avatar = $result['image'];
                            $role = $result['role'];
                            if (!$avatar == "") {
                                $image_url = $user_image_path . $avatar;
                            } else {
                                $image_url = $user_image_path . "Default_Avatar.jpg";
                            }
                            echo "<div class='dropdown show'>
						<a class='btn btn-outline-dark dropdown-toggle' href='#' role='button' id='dropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
							<img class='user-avatar' src='" . $image_url . "'>
							<span class=user-name>" . $_SESSION['username'] . "</span>
						</a>

						<div class='dropdown-menu' aria-labelledby='dropdownMenuLink'>
							<a class='dropdown-item' href='user.php'>Account</a>
							<a class='dropdown-item' href='cart.php'>Cart</a>";
                            // how do I make this more secure??? it is pretty shit I rely entirely on session for the authentication
                            if ($role == "admin") {
                                echo "<a class='dropdown-item' href='Admin/Songs/song.php'>Admin</a>";
                            }
                            echo "<div class='dropdown-divider'></div>
							<a class='dropdown-item' href='logout.php'>Logout</a>
						</div>"
                            ?>
                        </li>
                    </ul> -->
                </div>
            </div>
        </nav>
        <div class="container mt-5">
            <div class="row tm-content-row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 tm-block-col">
                    <div class="tm-bg-primary-dark tm-block tm-block-products">
                        <form method="POST">
                            <div class="tm-product-table-container">
                                <table class="table table-hover tm-table-small tm-product-table">
                                    <thead>
                                        <tr>
                                            <th scope="col">&nbsp;</th>
                                            <th scope="col">SONG NAME</th>
                                            <th scope="col">AUTHOR</th>
                                            <th scope="col">GENRE</th>
                                            <th scope="col">PRICE</th>
                                            <th scope="col">IMAGE</th>
                                            <th scope="col">AUDIO</th>
                                            <th scope="col">&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($connect) {
                                            $sql = "SELECT * FROM song";
                                            $result = mysqli_query($connect, $sql);
                                            while ($song = mysqli_fetch_array($result)) {
                                                $song_id = $song['song_id'];
                                                $singer_id = $song['singer_id'];
                                                $genre_id = $song['genre_id'];
                                                $sql = "SELECT singer_name FROM singer WHERE singer_id = '$singer_id'";
                                                $singer = mysqli_fetch_array(mysqli_query($connect, $sql));
                                                $sql = "SELECT genre_name FROM genre WHERE genre_id = '$genre_id'";
                                                $genre = mysqli_fetch_array(mysqli_query($connect, $sql));
                                        ?>
                                                <tr>
                                                    <th scope="row"><input type="checkbox" name="song_check_list[]" value="<?php echo $song_id ?>" /></th>
                                                    <td class="tm-product-name"><?php echo $song['song_name'] ?></td>
                                                    <td><?php echo $singer['singer_name'] ?></td>
                                                    <td><?php echo $genre['genre_name'] ?></td>
                                                    <td><?php echo $song['song_price'] ?></td>
                                                    <td><?php echo $song['song_img'] ?></td>
                                                    <td><?php echo $song['song_audio'] ?></td>
                                                    <td>
                                                        <button class="tm-product-delete-link" type="submit" name="<?php echo 'edit-button-' . $song_id ?>">
                                                            <i class="fas fa-wrench tm-product-delete-icon"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                        <?php
                                                if (isset($_POST['edit-button-' . $song_id])) {
                                                    $_SESSION['song_id'] = $song_id;
                                                    echo "<script>window.open('edit-song.php','_self')</script>";
                                                }
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- table container -->
                            <a href="add-songs.php" class="btn btn-primary btn-block text-uppercase mb-3">Add new song</a>
                            <button class="btn btn-primary btn-block text-uppercase" name="delete-button">
                                Delete selected song
                            </button>
                            <?php
                            if (isset($_POST['delete-button'])) {
                                if (!empty($_POST['song_check_list'])) {
                                    // Counting number of checked checkboxes.
                                    $checked_count = count($_POST['song_check_list']);
                                    // Loop to store and display values of individual checked checkbox.
                                    foreach ($_POST['song_check_list'] as $song_id) {
                                        $sql = "DELETE FROM song WHERE song_id = $song_id";
                                        $result = mysqli_query($connect, $sql);
                                    }
                                    echo "<script>alert('You have deleted the folllowing " . $checked_count . " option(s)')</script>";
                                    echo "<script>window.open('song.php','_self')</script>";
                                    //echo "<br/><b>Note :</b> <span>Similarily, You Can Also Perform CRUD Operations using These Selected Values.</span>";
                                } else {
                                    //echo "<b>Please Select Atleast One Option.</b>";
                                    echo "<script>alert('Nothing is selected')</script>";
                                }
                            }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
            <footer class="tm-footer row tm-mt-small">
                <div class="col-12 font-weight-light">
                    <p class="text-center text-white mb-0 px-4 small">
                        Copyright &copy; <b>2018</b> All rights reserved.

                        Design: <a rel="nofollow noopener" href="https://templatemo.com" class="tm-footer-link">Template Mo</a>
                    </p>
                </div>
            </footer>

            <script src="js/jquery-3.3.1.min.js"></script>
            <!-- https://jquery.com/download/ -->
            <script src="js/bootstrap.min.js"></script>
            <!-- https://getbootstrap.com/ -->
            <script>
                $(function() {
                    $(".tm-product-name").on("click", function() {
                        window.location.href = "edit-product.html";
                    });
                });
            </script>
    </body>

    </html>
<?php
}
?>