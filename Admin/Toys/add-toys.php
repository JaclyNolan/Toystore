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
                <h2 class="tm-block-title d-inline-block">Add Song</h2>
              </div>
            </div>
            <div class="row tm-edit-product-row">
              <div class="col-xl-6 col-lg-6 col-md-12">
                <form action="" class="tm-edit-product-form" method="POST" enctype="multipart/form-data">
                  <div class="form-group mb-3">
                    <label for="toy_name">Toy Name
                    </label>
                    <input id="toy_name" name="toy_name" type="text" class="form-control validate" required />
                  </div>
                  <div class="form-group mb-3">
                    <label for="toy_description">Description</label>
                    <textarea class="form-control validate" name="toy_description" rows="3"></textarea>
                  </div>
                  <div class="form-group mb-3">
                    <label for="toy_provider">Provider</label>
                    <select class="custom-select tm-select-accounts" id="toy_provider" name="toy_provider">
                      <option selected>Select a Provider</option>
                      <?php
                      $sql = "SELECT id, name FROM provider";
                      $result = mysqli_query($connect, $sql);
                      while ($provider = mysqli_fetch_array($result)) {
                        echo "<option value='" . $provider['id'] . "'>" . $provider['name'] . "</option>";
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group mb-3">
                    <label for="toy_genre">Genres</label>
                    <select class="custom-select tm-select-accounts" id="toy_genre" name="toy_genre">
                      <option selected>Select a gerne</option>
                      <?php
                      $sql = "SELECT genre_name, genre_id FROM genre";
                      $result = mysqli_query($connect, $sql);
                      while ($genre = mysqli_fetch_array($result)) {
                        echo "<option value='" . $genre['genre_id'] . "'>" . $genre['genre_name'] . "</option>";
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group mb-3">
                    <label for="toy_price">Toy Price
                    </label>
                    <input id="toy_price" name="toy_price" type="text" class="form-control validate" required />
                  </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-12 mx-auto mb-4">
                <div class="form-group mb-3">
                  <label for="toy_image">Toy Image:</label>
                  <input id="fileInput" class="btn btn-primary btn-block mx-auto" type="file" name="toy_image">

                </div>
              </div>
              <div class="col-12">
                <input type="submit" name="add_toy" id="submit_button" class="btn btn-primary btn-block text-uppercase" value="ADD SONG NOW">
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
    if (isset($_POST['add_toy'])) {
      $toy_image_path = "..\..\Image\Toy_Image\\";
      $toy_name = $_POST['toy_name'];
      $toy_description = $_POST['toy_description'];
      $toy_price = $_POST['toy_price'];
      $toy_image = $_FILES['toy_image']['name'];
      $toy_image_tmp = $_FILES['toy_image']['tmp_name'];
      $toy_provider = $_POST['toy_provider'];
      $toy_genre = $_POST['toy_genre'];
      $sql = "INSERT INTO toy VALUES(NULL,'$toy_name','$toy_description','$toy_price','$toy_image','$toy_genre','$toy_provider')";
      $result = mysqli_query($connect, $sql);
      if ($result) {
        move_uploaded_file($toy_image_tmp, $toy_image_path . $toy_image);
        echo "<script> alert('Toy added successfully')</script>";
        echo "<script>window.open('toy.php','_self')</script>";
      } else {
        echo "<script> alert('ERROR!')</script>";
      }
    }
    ?>
  </body>

  </html>

<?php } ?>