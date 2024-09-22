<?php
$pages = substr($_SERVER['SCRIPT_NAME'], strripos($_SERVER['SCRIPT_NAME'], "/")+1);
?>

<!-- Navbar 1 Start -->
<section id="Nav1">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container">
            <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <i class="fas fa-phone-volume" style="border-right: 1px solid gray;"> +233 1234 56987
                            &nbsp; &nbsp; </i>
                    </li>
                    <li class="nav-item">
                        <i class="far fa-envelope" style="padding-left: 15px;"> InfoBloodBank@gmail.com</i>
                    </li>
                </ul>
            </div>
            <div class="mx-auto order-0 navbar-brand mx-auto">
                <a href="https://www.instagram.com/"><i
                        class="fab fa-instagram github">&nbsp;&nbsp;</i></a>
                <a href="https://www.facebook.com/"><i
                        class="fab fa-facebook-f facebook">&nbsp;&nbsp;</i></a>
                <a href="https://twitter.com/"><i class="fab fa-twitter twitter">&nbsp;&nbsp;</i></a>
                <a href="https://api.whatsapp.com/send?phone=+233559574121"><i
                        class="fab fa-whatsapp whats">&nbsp;&nbsp;</i></a>
            </div>
            <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link selected" style="border-right: 1px solid gray;" href="#">EN &nbsp;</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="padding-left: 15px;" href="#">AR</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</section>
<!-- Navbar 1 End -->

<!-- Navbar 2 Start -->
<section id="Nav2">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <img src="imgs/logo.png" width="18%"></img>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link <?= $pages == "index.php"? 'selected':'';?>" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $pages == "about.php"? 'selected':'';?>" href="about.php">About Us</a>
                </li>

                <?php
                if (isset($_SESSION['user_id'])) {
                    if ($_SESSION['role'] == 0) {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $pages == "profile.php"? 'selected':'';?>" href="profile.php">Profile</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link <?= $pages == "donation.php"? 'selected':'';?>" href="donation.php">Donations</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link <?= $pages == "contact-us.php"? 'selected':'';?>" href="contact-us.php">Contact Us</a>
                        </li>
                        <?php
                    }else{
                        ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $pages == "profile.php"? 'selected':'';?>" href="profile.php">Profile</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link <?= $pages == "dashboard.php"? 'selected':'';?>" href="dashboard.php">Admin Dashboard</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link <?= $pages == "message.php"? 'selected':'';?>" href="message.php">Messages</a>
                        </li>
                        <?php
                    }
                }
                ?>

            </ul>

            <?php
            if (isset($_SESSION['user_id'])) {
                ?>
                <button id="logoutBtn" class="btn login">Logout</button>
                <?php
            }else{
                ?>
                <button class="btn signup" onclick= "window.location.href = 'signup.php';">New Account</button>
                <button class="btn login" onclick= "window.location.href = 'login.php';">Login</button>
                <?php
            }
            ?>

        </div>
    </nav>
</section>
<!-- Navbar 2 End -->
