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
    <title>Add Product - Dashboard HTML Template</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700" />
    <title>Login Page</title>
    <!--Made with love by Mutiullah Samim -->

    <!--Bootsrap 4 CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!--Custom styles-->
    <link rel="stylesheet" type="text/css" href="add-song.css">
    <!--
	Product Admin CSS Template
	https://templatemo.com/tm-524-product-admin
	-->
</head>

<body>
    <nav class="navbar navbar-expand-xl">
        <div class="container h-100">
            <a class="navbar-brand" href="../../index.php">
                <h1 class="tm-site-title mb-0">Defko Admin</h1>
            </a>
            <button class="navbar-toggler ml-auto mr-0" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars tm-nav-icon"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto h-100">
                    <li class="nav-item">
                        <a class="nav-link active" href="../Songs/song.php">
                            <i class="fas fa-music"></i> Songs
                        </a>
                    </li>
                    <li class="nav-item">
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
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link d-block" href="login.html">
                            Admin, <b>Logout</b>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container tm-mt-big tm-mb-big">
        <div class="row">
            <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 mx-auto">
                <div class="tm-bg-primary-dark tm-block tm-block-h-auto">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="tm-block-title d-inline-block">Edit Song</h2>
                        </div>
                    </div>
                    <?php
                    if ($connect) {
                        $song_id = $_SESSION['song_id'];
                        $sql = "SELECT * FROM song WHERE song_id = '$song_id'";
                        $song = mysqli_fetch_array(mysqli_query($connect, $sql));
                        $song_name = $song['song_name'];
                        $song_description = $song['song_description'];
                        $singer_id = $song['singer_id'];
                        $genre_id = $song['genre_id'];
                        $song_price = $song['song_price'];
                        $song_image = $song['song_img'];
                        $song_autdio = $song['song_audio'];
                    }
                    ?>
                    <div class="row tm-edit-product-row">
                        <div class="col-xl-6 col-lg-6 col-md-12">
                            <form action="" class="tm-edit-product-form" method="POST" enctype="multipart/form-data">
                                <div class="form-group mb-3">
                                    <label for="song_name">Song Name
                                    </label>
                                    <input id="song_name" name="song_name" type="text" value="<?php echo $song_name ?>" class="form-control validate" required />
                                </div>
                                <div class="form-group mb-3">
                                    <label for="song_description">Description</label>
                                    <textarea class="form-control validate" name="song_description" rows="3"><?php echo $song_description ?></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="song_author">Author</label>
                                    <select class="custom-select tm-select-accounts" id="song_author" name="song_author">
                                        <option <?php if ($singer_id == NULL) echo "selected" ?>>Select an author</option>
                                        <?php
                                        $sql = "SELECT singer_id, singer_name FROM singer";
                                        $result = mysqli_query($connect, $sql);
                                        while ($singer = mysqli_fetch_array($result)) {
                                            if ($singer_id == $singer['singer_id'])
                                                echo "<option value='" . $singer['singer_id'] . "' selected>" . $singer['singer_name'] . "</option>";
                                            else
                                                echo "<option value='" . $singer['singer_id'] . "'>" . $singer['singer_name'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="song_genre">Genres</label>
                                    <select class="custom-select tm-select-accounts" id="song_genre" name="song_genre">
                                        <option <?php if ($genre_id == NULL) echo "selected" ?>>Select a gerne</option>
                                        <?php
                                        $sql = "SELECT genre_name, genre_id FROM genre";
                                        $result = mysqli_query($connect, $sql);
                                        while ($genre = mysqli_fetch_array($result)) {
                                            if ($genre_id == $genre['genre_id'])
                                                echo "<option value='" . $genre['genre_id'] . "' selected>" . $genre['genre_name'] . "</option>";
                                            else
                                                echo "<option value='" . $genre['genre_id'] . "'>" . $genre['genre_name'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="song_price">Song Price
                                    </label>
                                    <input id="song_price" name="song_price" type="text" value=<?php echo "'" . $song_price . "'" ?> class="form-control validate" required />
                                </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 mx-auto mb-4">
                            <div class="form-group mb-3">
                                <label for="song_image">Song Image:</label>
                                <input id="fileInput" class="btn btn-primary btn-block mx-auto" value = "<?php echo $song_image_path . $song_image ?>" type="file" name="song_image">

                            </div>
                            <div class="form-group mb-3">
                                <label for="song_audio">Song Audio:</label>
                                <input id="fileInput" class="btn btn-primary btn-block mx-auto" value = "<?php echo $song_audio_path . $song_audio ?>" type="file" name="song_audio">
                            </div>
                        </div>
                        <div class="col-12">
                            <input type="submit" name="add_song" id="submit_button" class="btn btn-primary btn-block text-uppercase" value="CONFIRM EDIT">
                        </div>
                        </form>
                    </div>
                </div>
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
    <?php
    if (isset($_POST['add_song'])) {
        include("../connect.php");
        include("../correctString.php");
        $song_image_path = "..\..\Image\Song_Image\\";
        $song_audio_path = "..\..\Audio\\";
        $song_name = $_POST['song_name'];
        $song_name = correctString($song_name);
        $song_description = $_POST['song_description'];
        $song_description = correctString($song_description);
        $song_price = $_POST['song_price'];
        $song_author = $_POST['song_author'];
        $song_genre = $_POST['song_genre'];
        echo $song_name;
        $sql = "UPDATE song SET song_name = '$song_name', song_description = '$song_description', song_price = '$song_price', singer_id = '$song_author', genre_id = '$song_genre' WHERE song_id = $song_id";
        $result = mysqli_query($connect, $sql);
        // if ($_FILES['song_image']) {
        //     $song_image = $_FILES['song_image']['name'];
        //     $song_image_tmp = $_FILES['song_image']['tmp_name'];
        //     $sql = "UPDATE song SET song_img = '$song_image'";
        //     $result = mysqli_query($connect, $sql);
        //     echo "<script> alert('ERROR!')</script>";
        //     if ($result) {
        //         move_uploaded_file($song_image_tmp, "$song_image_path $song_image");
        //     }
        // }
        // if ($_FILES['song_audio']) {
        //     $song_audio = $_FILES['song_audio']['name'];
        //     $song_audio_tmp = $_FILES['song_audio']['tmp_name'];
        //     $sql = "UPDATE song SET song_audio = '$song_audio'";
        //     $result = mysqli_query($connect, $sql);
        //     if ($result) {
        //         move_uploaded_file($song_audio_tmp, "$song_audio_path $song_audio");
        //     }
        // }
        if ($result) {
            echo "<script> alert('Edit song successfully')</script>";
            echo "<script>window.open('song.php','_self')</script>";
        } else {
            echo "<script> alert('ERROR!')</script>";
        }
    }
    ?>
</body>

</html>

<?php } ?>