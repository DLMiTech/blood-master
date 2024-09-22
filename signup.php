<?php
include "includes/header.php";
include "includes/nav.php";
?>


<!-- Navigator Start -->
<section id="navigator">
    <div class="container">
        <div class="path">
            <div class="path-main" style="color: darkred; display:inline-block;">Home</div>
            <div class="path-directio" style="color: grey; display:inline-block;"> / Sign up</div>
        </div>

    </div>
</section>
<!-- Navigator End -->

<!-- Sign Up Start -->
<section id="sign-up">
    <div class="container">
        <img src="imgs/logo.png" alt="">
        <form action="" method="post" id="registerForm">
            <input type="text" name="name" placeholder="Name">
            <input type="text" name="username" placeholder="Username">
            <input type="text" name="email" placeholder="Email">
            <input type="text" name="phone" placeholder="Phone Number">
            <input type="password" name="password" placeholder="Password">
            <input type="password" name="confirm_password" placeholder="Confirm password">
            <div class="reg-group">
                <button id="registerBtn" class="submit" type="submit" style="background-color: rgb(51, 58, 65);">Submit</button>
            </div>
        </form>
    </div>
</section>
<!-- Sign Up End -->



<?php
include "includes/footer.php";
?>


<script>
    $(document).on('submit', '#registerForm', function (e) {
        e.preventDefault();

        let button = $("#registerBtn");
        button.prop("disabled", true).html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> <span class="fw-light">Loading...</span>');
        let formData = new FormData(this);
        formData.append("registerBtn", true);

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
                            $('#registerForm')[0].reset();
                            window.location.href = 'login.php';
                        }
                    });

                }
            }
        });
    });
</script>
