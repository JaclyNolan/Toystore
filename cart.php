<?php
session_start();
?>
<!doctype html>
<html class="no-js">

<head>

    <title>Cart</title>
    <link rel="stylesheet" type="text/css" href="https://www.yoox.com/_css_/1/12d967f33a34c8d872f91f047c7a4f07/dist/corelib.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="https://www.yoox.com/_css_/1/5b565430917f50c0e41846e9f472a3c4/dist/checkoutlib_16.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="https://www.yoox.com/_css_/1/78c78f49218f99a77b7db2fc3bbd2e21/dist/cart16lib.css" media="screen" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">

    <style>
        #IsSelected {
            width: 20px;
            height: 20px;
        }

        #priceCol {
            width: 0px !important;
            text-align: right !important;
        }
    </style>

<body id="cart" class="checkout hideUserbarOnLoad lang-EN lang-latin ">
    <?php
    include('Admin/connect.php');
    if ($connect) {
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

        <section id="scrollContent">
            <main id="mainContainer" class="fixedWidth">
                <div id="CartPage" class="checkoutPadding OpcNewHead">
                    <div class="submenuTop">
                        <div class="submenu isPaymentDisabled hideIfEmpty">
                            <span class="font-bold text-uppercase ">My Cart</span>
                            <div class="hideIfEmpty floatRight">

                                <span class="orSeparator hide">or</span>
                                <a href="/vn/Checkout/Waitframe/PaypalExpress" class="btn btnPaypalExpress js-track-me  hide" data-tracking-label="payment method paypal express top">

                                    <img class="paypal-image" src=https://www.yoox.com/media/yoox16/logos/paypal_logo_txt.png?v=1 alt="PayPal" /> <span>CHECK OUT</span>
                                </a>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div id="CartContainer">
                        <div id="cartContent">
                            <div id="boxOrder" class="upper-gray-separator lateral-padding">
                                <?php
                                $sql = "SELECT * FROM cart";
                                $result = mysqli_query($connect, $sql);
                                ?>
                                <h2 class="font-bold">
                                    <span class="fontLight text-uppercase step-title">
                                        Items added to your Shopping Bag (<?php echo mysqli_num_rows($result) ?>)
                                    </span>
                                </h2>
                                <?php
                                $username = $_SESSION['username'];
                                $sql = "SELECT user_id FROM users WHERE username = '$username'";
                                $user_id = mysqli_fetch_array(mysqli_query($connect, $sql))['user_id'];
                                $sql = "SELECT * FROM cart";
                                $result = mysqli_query($connect, $sql);
                                while ($cart = mysqli_fetch_array($result)) {
                                    $song_id = $cart['song_id'];
                                    $sql = "SELECT * FROM song WHERE song_id = $song_id";
                                    $song = mysqli_fetch_array(mysqli_query($connect, $sql));
                                    $song_image_path = "Image/Song_Image/";
                                    $genre_id = $song['genre_id'];
                                    $sql = "SELECT genre_name FROM genre WHERE genre_id = $genre_id";
                                    $genre_name = mysqli_fetch_array(mysqli_query($connect, $sql))['genre_name'];
                                ?>
                                    <div id="itemList">
                                        <div class="table relative">
                                            <div class="tableGroup">
                                                <div class="itemInfo rowTable" id="cod_45633910CI_1" data-cod10="45633910CI" data-sizeid="1" data-classsizeid="65" data-category="Handbags" data-categoryid="113" data-microcategoryid="brsmn" data-microcategory="Handbags" data-macrocategoryid="brs" data-macrocategory="HANDBAGS" data-brand="JACQUEMUS" data-brandid="26995" data-quantity="1" data-unitdiscountprice="682.71" data-marketplace="{&quot;seller_id&quot;:0,&quot;seller_name&quot;:&quot;##yooxName##&quot;,&quot;type&quot;:&quot;1P&quot;}">
                                                    <div class="itemboxCol innerCellTable js-track-me relative" data-tracking-label="item preview">
                                                        <input type="checkbox" id="IsSelected" class="mt-3" />
                                                        <img src="<?php echo $song_image_path . $song['song_img'] ?>" class="itemImgCart itemZoom ml-4" alt="lole" />
                                                        <div class="itemTitle itemZoom absolute">
                                                            <div class="brand font-bold pl-2"><?php echo $song['song_name'] ?></div>
                                                        </div>
                                                    </div>
                                                    <div class="colorCol innerCellTable font-sans"><?php echo $genre_name ?></div>
                                                    <div class="priceCol innerCellTable" id="priceCol">
                                                        <div class="priceCol_price-wrapper">
                                                            <div class="font-bold price">US$ <?php echo $song['song_price'] ?></div>
                                                        </div>
                                                    </div>
                                                    <div class="qtaCol innerCellTable" style="width: 0px;">
                                                        <form method="POST">
                                                            <button style="display: none;" id="delButton<?php echo $song_id ?>" type="submit" name="delButton<?php echo $song_id ?>"></button>
                                                            <a onclick="document.getElementById('delButton<?php echo $song_id ?>').click()"  class="delItem text-uppercase js-track-me" data-cod10="45633910CI" data-sizeid="1" data-category="Handbags" data-categoryid="113" data-brand="JACQUEMUS" data-brandid="26995" data-discountprice="682.71" data-quantity="1" data-tracking-label="delete">
                                                                <svg class="icon icon-close icon-size-xxs">
                                                                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-close"></use>
                                                                </svg>
                                                                Remove
                                                            </a>
                                                            <?php
                                                            if (isset($_POST['delButton' . $song_id])) {
                                                                $sql = "DELETE FROM cart WHERE user_id = $user_id AND song_id = $song_id";
                                                                $result = mysqli_query($connect, $sql);
                                                                if ($result) {
                                                                    echo "<script> alert('The selected song has successfully been removed from cart') </script>";
                                                                    echo "<script>window.open('cart.php','_self')</script>";

                                                                } else {
                                                                    echo "<script> alert('ERROR!') </script>";
                                                                }
                                                            }
                                                            ?>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                                <!-- <div>
                                 <div id="giftWrappingOptionContainer" class="IsAvailable singleOpt js-track-me">
                                    <div id="newGiftWrappingChkImg" class="checkbox">
                                        <input type="checkbox" id="IsSelected" data-value="False" class="js-track-me isAvaiable" data-tracking-action="checkout page" data-tracking-label-checked="giftwrappingactivated" />
                                        <label for="IsSelected">
                                            <span></span>
                                        </label>
                                    </div>
                                    <div id="newGiftWrappingTitle" class="font-bold text-uppercase">Buying a gift?</div>
                                    <div class="clear"></div>
                                    <div id="giftWrappingLayer" class="selectorContaier">
                                        <div class="optBox">


                                            <div id="giftSection" class="rowTable isEnabled">
                                                <div class="cellTable sectionCol">
                                                    <div class="giftInnerCellTable TypeCol">
                                                        <div class="optInformation cellTable">
                                                            <a class="opt fontSans font-bold text-uppercase">
                                                                <span class="optText text-uppercase">Gift pack -</span>
                                                                <span class="optText text-uppercase no-linebreak">US$ 4,00<br />(VND 93.431,97)</span>

                                                                <div id="popupInfoGift" class="giftCellTable popupInfo" rel="popupInfoGiftBox"></div>

                                                            </a>


                                                            <div class="clear"></div>
                                                            <div class="chooseInfo padding-top">
                                                                <div>
                                                                    Gift wrap your order, removing all prices, and add a greeting card.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="giftCellTable"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="popupInfoGiftBox" title="Gift pack">
                                                <div class="boxTxt">The gift pack comprises a paper shopper (with yoox.com logo) measuring up to 57x46x17 cm and a light grey greeting card with a dark grey envelope (featuring yoox.com logo). Check that the products in your order will fit into the shopper.</div>
                                                <div class="banner">
                                                    <div id="banner_giftwrapBanner" class="banner"><img height="164px" id="img_giftwrapBanner" src="https://www.yoox.com/images/yoox80/banners/517_2_YM13_giftwrapping.jpg?634485886897069995" width="269px" /></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="giftDisabledReason" class="text-size-l">
                                    </div>

                                </div>
                            </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="hideIfEmpty">
                        <div class="submenuBottom">
                            <div class="submenu isPaymentDisabled">
                                <a id="trkBackBottom" href="index.php" class="trackback js-track-me" data-tracking-label="back to shopping bottom">
                                    <span class="font-bold text-uppercase action-link">Back to shopping</span>
                                </a>
                                <div class="hideIfEmpty floatRight">
                                    <a id="trkNextBottom" data-checkoutflow="True" data-checkoutflow-label="" data-checkoutflow-title="" href="/vn/Checkout/Proceed/NextStep?step=cart" class="button button-primary button-arrow-right text-uppercase floatRight js-track-me" data-tracking-label="proceed order bottom">
                                        <span>Proceed with your order</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- <div id="FullCart" class="js-active reccomendationWrapper" data-action-url="/VN/Common/Recommendations/RecommendedBaynote?template=PT_FullCart&amp;gender=D&amp;cod10List=45633910CI&amp;configurationJson=%7B%22ItemPreview%22%3Atrue%2C%22IsScrollable%22%3Afalse%2C%22ShowViewMoreButton%22%3Afalse%2C%22ShowSizes%22%3Atrue%2C%22DisableFallback%22%3Atrue%2C%22FallBackWidgetId%22%3A%22allFallBack%22%2C%22FallBackLabelTitle%22%3A%22%22%2C%22FallBackLabelSubTitle%22%3A%22%22%2C%22EnableBaynoteDebug%22%3Afalse%2C%22ImageFormat%22%3Anull%2C%22Lite%22%3Afalse%2C%22LabelsFileName%22%3Anull%2C%22ItemsToShow%22%3A8%2C%22RandomOffset%22%3Afalse%2C%22NoExternalLinks%22%3Afalse%2C%22WidgetIds%22%3A0%2C%22ExcludeSoldout%22%3Afalse%2C%22CartPage%22%3Afalse%2C%22AddToCartSuccess%22%3Anull%2C%22AddToCartFail%22%3Anull%2C%22NoSocials%22%3Afalse%2C%22TotalLookWidgetId%22%3A%22PDLook%22%2C%22ItemsPerSlide%22%3A4%2C%22TrackingAction%22%3A%22recommendations%22%2C%22TrackingLabel%22%3Anull%7D&amp;productsPerPage=4">
                    </div>
                    <div id="boxedService">
                        <div class="serviceBox">
                            <p class="text-uppercase font-bold margin-double-top margin-bottom">
                                Customer Care
                            </p>
                            <div class="content font-sans">
                                <div class="line">If you have any questions you can send us an e-mail (Mon-Fri, 9am to 9pm Sydney Time)</div>
                            </div>
                        </div>

                    </div> -->
                    </div>
                </div>
            </main>
            <!-- <footer id="cartFooter" class="backgroundGrey">
            <div id="subfooter-wrapper" class="bg-primary">
                <div id="footer-copyright" class="fixed-width text-size-s">
                    <div class="row">
                        <div class="col-1-1 text-uppercase text-center">
                            <div id="copyContainer">
                                <a href="http://www.ynap.com/pages/about-us/what-we-do/" TARGET="_blank">Powered by YOOX NET-A-PORTER GROUP</a> - <a id="copyright" href="javascript:;">Copyright</a> © 2000-2022 <a id="yooxspa" href="javascript:;">YOOX NET-A-PORTER GROUP S.p.A.</a> - All Rights Reserved - SIAE Licence # 401/I/526
                            </div>



                            <div id="legalPrivacy">


                                <a class="ta-footer-legal" href="/vn/Legal/Salesterms" rel="nofollow">Legal Area</a>
                                <span class="divider">/</span>
                                <a class="ta-footer-privacy" href="/vn/Legal/Privacypolicy" rel="nofollow">Privacy Policy</a>

                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="footerCYCContainer">
            </div>

        </footer> -->
        </section>
        </div>

    <?php
    }
    ?>


</body>

</html>