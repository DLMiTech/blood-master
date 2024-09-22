<?php
include "includes/header.php";
include "includes/nav.php";
?>


<!-- Navigator Start -->
<section id="navigator">
    <div class="container">
        <div class="path">
            <div class="path-main" style="color: darkred; display:inline-block;">Home</div>
            <div class="path-directio" style="color: grey; display:inline-block;"> / Login</div>
        </div>

    </div>
</section>
<!-- Navigator End -->

<!-- Login Start -->
<section id="login">
    <div class="container">
        <img src="imgs/logo.png" alt="">
        <form action="" method="post" id="loginForm">
            <input class="username" type="text" placeholder="Username" name="username">
            <input class="password" type="Password" placeholder="Password" name="password">
            <input class="check" type="checkbox">Remember me
            <a href="#">Forget Password ?</a><br>
            <div class="reg-group">
                <button type="submit" id="loginBtn" style="background-color: darkred;">Login</button>
                <button style="background-color: rgb(51, 58, 65);" onclick="window.location.href = 'signup.php'">Make new account</button>
            </div>
        </form>
    </div>
</section>
<!-- Login End -->


<?php
include "includes/footer.php";
?>


<script>
    $(document).on('submit', '#loginForm', function (e) {
        e.preventDefault();

        let button = $("#loginBtn");
        button.prop("disabled", true).html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> <span class="fw-light">Loading...</span>');
        let formData = new FormData(this);
        formData.append("loginBtn", true);

        $.ajax({
            type: "POST",
            url: "private/api/auth.php",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                //alert(response);
                let res = jQuery.parseJSON(response);

                if (res.status === 400) {
                    button.prop("disabled", false).html('Submit');
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

                            button.prop("disabled", false).html('Submit');
                            $('#loginForm')[0].reset();
                            window.location.href = 'login.php';
                        }
                    });

                }
            }
        });
    });
</script>
