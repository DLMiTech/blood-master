<!-- Footer Start -->
<section id="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="foot-info">
                    <img src="imgs/logo.png" alt="">
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quos ut sit natus earum ea cum
                        doloremque fugit. Sit non ex suscipit fugiat molestias, ipsa rerum tempore voluptates
                        adipisci rem cum?</p>
                </div>
            </div>
            <div class="col-md-3">
                <ul class="menu">
                    <a href="index.php">
                        <li>Home</li>
                    </a>
                    <a href="about.php">
                        <li>About Us</li>
                    </a>
                    <a href="#articles">
                        <li>Articles</li>
                    </a>
                    <a href="requests.html">
                        <li>Donations</li>
                    </a>
                    <a href="who-we-are.html">
                        <li>Who We Are?</li>
                    </a>
                    <a href="contact-us.html">
                        <li>Contact Us</li>
                    </a>
                </ul>
            </div>
            <div class="col-md-4">
                <ul class="options">
                    <li>
                        <h5>Available On</h5>
                    </li>
                    <li><img src="imgs/ios1.png" alt=""></li>
                    <li><img src="imgs/google1.png" alt=""></li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- Footer End -->

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="js/jquery-3.7.1.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script type="text/javascript" src="js/swiper.min.js"></script>
<script type="text/javascript" src="js/wow.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>
<script src="js/sweetalert.js"></script>
</body>
</html>


<script>
    $(document).on('click', '#logoutBtn', function (){
        // let user_id = $(this).val();

        Swal.fire({
            title: "Confirm logout",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Logout!"
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    type: "GET",
                    url: "private/api/auth.php?logoutBtn",
                    success: function(response) {
                        let res = jQuery.parseJSON(response);
                        if (res.status === 400) {
                            Swal.fire({
                                icon: "error",
                                text: res.message,
                            });
                        } else if (res.status === 200) {
                            Swal.fire({
                                icon: "success",
                                text: res.message,
                            }).then((result) => {
                                if (result.isConfirmed) {

                                    window.location.href = 'index.php';
                                }
                            });

                        }
                    }
                });

            }
        });


    });
</script>
