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
	include('Admin/connect.php');
	?>
	<!-- menu -->
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container">
			<a class="navbar-brand" href="index.php">Defko Toys</a>
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
					<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search_input">
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
						<a class='btn btn-outline-dark dropdown-toggle' role='button' id='dropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
							<img class='user-avatar' src='" . $image_url . "'>
							<span class=user-name>" . $_SESSION['username'] . "</span>
						</a>

						<div class='dropdown-content' aria-labelledby='dropdownMenuLink'>
							<a class='dropdown-item' href='user.php'>Account</a>
							<a class='dropdown-item' href='cart.php'>Cart</a>";
						// how do I make this more secure??? it is pretty shit I rely entirely on session for the authentication
						if ($role == "admin") {
							echo "<a class='dropdown-item' href='Admin/Toys/toy.php'>Admin</a>";
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
	<div id="carouselExampleIndicators" class="carousel slide mt-1" data-ride="carousel">
		<ol class="carousel-indicators">
			<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
			<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
			<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
		</ol>
		<div class="carousel-inner">
			<?php
			function correctString(string $name)
			{
				$i = 0;
				while ($i < strlen($name)) {
					if ($name[$i] == "'") {
						for ($j = strlen($name); $j > $i; $j--) {
							$name[$j] = $name[$j - 1];
						}
						$name[$i] = "\\";
						$i++;
					}
					$i++;
				}
				return $name;
			}
			$slide_image_path = "Image\Slide_Image";
			$sql = "SELECT * FROM slide";
			$slide_result = mysqli_query($connect, $sql);
			$bool = true;
			while ($slide = mysqli_fetch_array($slide_result)) {
			?>
				<div class=<?php if ($bool) {
								echo "'" . "carousel-item active" . "'";
								$bool = false;
							} else echo "'" . "carousel-item" . "'";
							?>>
					<img style="width: 300px;" class="d-block w-100" src=<?php echo "'" . $slide_image_path . "\\" . $slide["slide_image"] . "'" ?> alt=<?php echo $slide["slide_id"] ?>>
				</div>
			<?php
			};
			?>
		</div>
		<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>
	<!-- end slide -->
	<!-- list product -->
	<div class="container">
		<div class="row mt-5">
			<h2 class="list-product-title">Featured toys</h2>
			<div class="list-product-subtitle">
				<p>Top toys in 2022</p>
			</div>
			<div class="product-group">
				<div class="row">
					<?php
					if ($connect) {
						$toy_image_path = "Image\Toy_Image";
						$sql = "SELECT * FROM toy";
						$toy_result = mysqli_query($connect, $sql);
						while ($toy = mysqli_fetch_array($toy_result)) {
					?>
							<div class="col-md-3 col-sm-6 col-12">
								<div class="card card-product mb-3">
									<img class="card-img-top" src=<?php echo "'" . $toy_image_path . "\\" . $toy['image'] . "'" ?> alt=<?php echo $toy['image'] ?>>
									<div class="card-body">
										<h5 class="card-title"><?php echo $toy['name'] ?></h5>
										<p class="card-text">Price: <?php echo $toy['price'] ?>VND </p>
										<a href="detail.php?id=<?php echo $toy['id'] ?>" class="btn btn-primary">Details</a>
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