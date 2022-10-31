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
</head>

<body>
	<?php
	$connect = mysqli_connect('localhost', 'root', "", "defko_music");
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

				<form class="form-inline my-2 my-lg-0 mr-4" method="POST">
					<input class="form-control mr-sm-2" type="search" value=<?php echo $_GET['search'] ?> placeholder="Search" aria-label="Search" name="search_input">
					<button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="search">Search</button>
				</form>
				<?php
					if (isset($_POST['search'])) {
						$search_input = $_POST['search_input'];
						echo "<script>window.open('search.php?search=$search_input','_self')</script>";
					}
				?>
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
	<!-- list product -->
	<div class="container">
		<div class="row mt-5">
			<h2 class="list-product-title">Search result</h2>
			<div class="product-group">
				<div class="row">
					<?php
					if ($connect) {
						$song_image_path = "Image\Song_Image";
						$song_audio_path = "Audio";
						$singer_image_path = "Image\Singer_Image";
						$search_input = $_GET['search'];
						$sql = "SELECT * FROM song WHERE song_name LIKE '%{$search_input}%'";
						$song_result = mysqli_query($connect, $sql);
						while ($song = mysqli_fetch_array($song_result)) {
							$sql = "SELECT * FROM singer WHERE singer_id = '$song[singer_id]'";
							$singer_result = mysqli_query($connect, $sql);
							$singer = mysqli_fetch_array($singer_result);
					?>
							<div class="col-md-3 col-sm-6 col-12">
								<div class="card card-product mb-3">
									<img class="card-img-top" src=<?php echo "'" . $song_image_path . "\\" . $song['song_img'] . "'" ?> alt=<?php echo $song['song_name'] ?>>
									<div class="card-body">
										<h5 class="card-title"><?php echo $song['song_name'] ?></h5>
										<p class="card-text">by <?php echo $singer['singer_name'] ?>. </p>
										<p>
											<audio controls controlsList="nodownload" style="width: 250px;" ontimeupdate="myAudio(this)">
												<source src=<?php echo "'" . $song_audio_path . "\\" . $song['song_audio'] . "'" ?> type="audio/mpeg">
											</audio>
											<script type="text/javascript">
												function myAudio(event) {
													if (event.currentTime > 30) {
														event.currentTime = 0;
														event.pause();
														alert("Buy premium to enjoy the rest of the song!")
													}
												}
											</script>
										</p>
										<a href="detail.php?id=<?php echo $song['song_id'] ?>" class="btn btn-primary">Details</a>
									</div>
								</div>
							</div>
					<?php
						};
					};
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