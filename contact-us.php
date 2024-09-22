<?php
include "includes/header.php";
include "includes/nav.php";
$me = new Authentication();
$myData = $me->getMe($_SESSION['user_id']);
?>


<!-- Navigator Start -->
<section id="navigator">
    <div class="container">
        <div class="path">
            <div class="path-main" style="color: darkred; display:inline-block;">Home</div>
            <div class="path-directio" style="color: grey; display:inline-block;"> / Contact Us</div>
        </div>

    </div>
</section>
<!-- Navigator End -->

<!-- login Start -->
<section id="contact">
    <div class="container">
        <div class="row">
            <div class="col-md-6 call">
                <div class="title">Head</div>
                <img src="imgs/logo.png" alt="">
                <hr>
                <h4>Mobile: +20 127 245 6884</h4>
                    <h4>Fax: +2 455 6646</h4>
                        <h4>Email: InfoBloodBank@gmail.com</h4>
                            <hr>
                            <h3>Find Us On</h3>
                            <div class="icons">
                                <i class="fab fa-facebook-square fa-3x"></i>
                                <i class="fab fa-google-plus-square fa-3x"></i>
                                <i class="fab fa-twitter-square fa-3x"></i>
                                <i class="fab fa-whatsapp-square fa-3x"></i>
                                <i class="fab fa-youtube-square fa-3x"></i>
                            </div>
            </div>
            <div class="col-md-6 info">
                <div class="title">Message</div>
                <form action="" id="messageForm" method="post" autocomplete="off">
                    <input type="text" value="<?= $myData[0]['name']?>" name="name" id="" placeholder="Name" required="">
                    <input type="email" value="<?= $myData[0]['email']?>" name="email" id="" placeholder="Email">
                    <input type="number" value="<?= $myData[0]['phone']?>" name="phone" id="" placeholder="Phone" required="">
                    <input type="text" name="title" id="" placeholder="Title" required="">
                    <textarea name="message" id="" cols="10" rows="5" placeholder="Message"></textarea>
                    <div class="reg-group">
                        <button id="messageBtn" type="submit">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- login End -->



<?php
include "includes/footer.php";
?>

<script>
    $(document).on('submit', '#messageForm', function (e) {
        e.preventDefault();

        let button = $("#messageBtn");
        button.prop("disabled", true).html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> <span class="fw-light">Loading...</span>');
        let formData = new FormData(this);
        formData.append("messageBtn", true);

        $.ajax({
            type: "POST",
            url: "private/api/message.php",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                //alert(response);
                let res = jQuery.parseJSON(response);

                if (res.status === 400) {
                    button.prop("disabled", false).html('Send');
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

                            button.prop("disabled", false).html('Send');
                            // $('#messageForm')[0].reset();
                            window.location.href = 'contact-us.php';
                        }
                    });

                }
            }
        });
    });
</script>
