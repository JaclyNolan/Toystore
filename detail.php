<?php

use LDAP\Result;

session_start();
?>
<!DOCTYPE html>
<html>

<head>
	<title>Defko</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="index.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<style type="text/css">
		.images-detail img {
			margin-top: 5%;
			width: 100%;
			align-items: center;
			border-radius: 100%;
			margin-bottom: 30px;
			animation: app-logo-spin infinite 20s linear
		}

		@keyframes app-logo-spin {
			from {
				transform: rotate(0deg);
			}

			to {
				transform: rotate(360deg);
			}
		}
	</style>

</head>

<body>
	<?php
	include('Admin/connect.php');
	?>
	<!-- menu -->
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container">
			<a class="navbar-brand" href="index.php">Defko</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link" href="#"> Home <span class="glyphicon glyphicon-home sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#"> <span class="glyphicon glyphicon-user"></span>Link</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link" href="#" id="navbarDropdown">
							Dropdown
						</a>
						<div class="dropdown-content">
							<a class="dropdown-item" href="#">Action</a>
							<a class="dropdown-item" href="#">Another action</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="#">Something else here</a>
						</div>
					</li>
				</ul>

				<form class="form-inline my-2 my-lg-0 mr-4">
					<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
					<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
				</form>
				<div>
					<?php
					if (!isset($_SESSION['username'])) {
						echo "<div><a href='login.php'><button class='btn btn-outline-primary my-2 my-sm-0'>Login</button></a>
								<a href='register.php'><button class='btn btn-primary'>Register</button></a></div>";
					} else {
						$image_url = "Image\User_Image\Default_Avatar.jpg";
						$username = $_SESSION['username'];
						$sql = "SELECT image, role FROM users WHERE username = '$username'";
						$result = mysqli_fetch_array(mysqli_query($connect, $sql));
						$avatar = $result['image'];
						$role = $result['role'];
						if (!$avatar == "") {
							$image_url = 'Image\User_Image\\' . $avatar;
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
						</div>
					</div>";
					}
					?>

				</div>
			</div>
		</div>
	</nav>
	<!-- end menu -->
	<!-- slide -->

	<!-- end slide -->
	<!-- list product -->
	<div class="container">
		<div class="row mt-5">
			<div class="product-group">
				<div class="row">
					<?php
					$song_image_path = "Image\Song_Image\\";
					$song_audio_path = "Audio\\";
					$id = $_GET["id"];
					$sql = "SELECT * FROM song,singer,genre WHERE song.genre_id = genre.genre_id and song.singer_id = singer.singer_id and song_id = {$id}";
					$result = mysqli_query($connect, $sql);
					$row = mysqli_fetch_array($result);
					$id = $row['song_id'];
					?>
					<div class="col-md-6 col-lg-9" style="text-align: left;">
						<h2> Name of Music: <?php echo $row['song_name']; ?> </h2>
						<p>Price: <?php echo $row['song_price']; ?> </p>
						<audio controls controlsList="nodownload" ontimeupdate="myAudio(this)" style="width: 250px;">
							<source src="<?php echo $song_audio_path . $row['song_audio']; ?>" type="audio/mpeg">
						</audio>
						<script type="text/javascript">
							function MyAudio(event) {
								if (event.currentTime > 30) {
									event.currentTime = 0;
									event.pause();
									alert("Bạn phải trả phí để nghe cả bài")
								}
							}
						</script>
						<h5> Singer:<?php echo $row["singer_name"]; ?></h5>
						<h4> Genre:<?php echo $row["genre_name"]; ?></h4>
						<textarea cols="40" rows="10" disabled><?php echo $row["song_description"]; ?></textarea>


					</div>
					<div class="col-md-6 col-lg-3">
						<!-- cho ảnh quay tròn-->
						<div class="images-detail">
							<img src="<?php echo $song_image_path . $row['song_img'] ?>" style="width: 350px; height: 350px;">
						</div>
					</div>
				</div>

				<div class="row mt-5">
					<form method="POST">
						<button type="submit" name="buy" class='btn btn-primary'><i class="fas fa-cart-plus"></i> Add to cart</button>
					</form>
					<?php
					if (isset($_POST['buy'])) {
						if ($_SESSION['username']) {
							$username = $_SESSION['username'];
							$sql = "SELECT user_id FROM users WHERE username = '$username'";
							$user_id = mysqli_fetch_array(mysqli_query($connect, $sql))['user_id'];
							$song_id = $_GET['id'];
							$song_name = $row['song_name'];
							$date = date('y-m-d');
							$sql = "SELECT * FROM cart WHERE user_id = $user_id AND song_id = $song_id";
							if (mysqli_num_rows(mysqli_query($connect,$sql)) == 0) {
								$sql = "INSERT INTO cart VALUES ($user_id,$song_id,'$date')";
								$result = mysqli_query($connect, $sql);
								if ($result) {
									echo "<script> alert('$song_name has been successfully added to cart') </script>";
									echo "<script>window.open('index.php','_self')</script>";
								} else {
									echo "<script> alert('ERROR!') </script>";
								}
							} else {
								echo "<script> alert('You already added this product to cart or owned it') </script>";
							}
							
						} else {
							echo "<script> alert('Please log in to add this song to your cart') </script>";
							echo "<script> window.open('login.php','_self') </script>";
						}
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<!-- end list product -->

	<!-- Load jquery trước khi load bootstrap js -->
	<script src="jquery-3.3.1.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
</body>

</html>