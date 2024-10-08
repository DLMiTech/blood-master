<?php
include "includes/header.php";
include "includes/nav.php";
$me = new Authentication();
$book = new Booking();
$myData = $me->getMe($_SESSION['user_id']);
$booking = $book->myBooking($_SESSION['user_id']);
?>

<div class="container py-5">
    <?php
    if ($myData[0]['status'] == 0) {
        ?>
        <div class="text-center py-3">
            <h1>Hello <?= $myData[0]['name']?></h1>
            <h4>Welcome To Blood Bank Master</h4>
            <p>Visit any nearest hospital for your blood group And health verification to start your donation</p>
        </div>
        <?php
    }else{
        ?>
        <div class="">
            <div class="card-body">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-rooms" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Donate</button>
                        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-FandF" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Donation Info</button>
                    </div>
                </nav>

                <div class="tab-content p-2" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-rooms" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                        <div class="card">
                            <div class="card-header">
                                Book Appointment
                            </div>
                            <div class="card-body">
                                <form action="" id="bookingForm">
                                    <div class="row">
                                        <input type="hidden" value="<?= $myData[0]['user_id']?>" id="id" name="id" class="form-control" readonly>
                                        <div class="col-md-6 mb-3">
                                            <label for="name">Name</label>
                                            <input type="text" value="<?= $myData[0]['name']?>" id="name" name="name" class="form-control" readonly>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="phone">Phone</label>
                                            <input value="<?= $myData[0]['phone']?>" type="text" id="phone" name="phone" class="form-control" readonly>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="email">Email</label>
                                            <input value="<?= $myData[0]['email']?>" type="text" id="email" name="email" class="form-control" readonly>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="group">Blood group</label>
                                            <input value="<?= $myData[0]['blood_group']?>" type="text" id="group" name="group" class="form-control" readonly>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="date">Date</label>
                                            <input type="date" id="date" name="date" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="time">Time</label>
                                            <select name="time" id="time" class="form-select mb-3" required>
                                                <option value="">Select appointment time</option>
                                                <option value="6AM to 8AM">6AM to 8AM</option>
                                                <option value="10AM to 12PM">10AM to 12PM</option>
                                                <option value="3PM to 5PM">3PM to 5PM</option>
                                            </select>
                                        </div>

                                        <div class="text-end">
                                            <button id="bookingBtn" type="submit" class="btn btn-dark">BOOK NOW</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-FandF" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                        <div class="card p-3 shadow">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>On</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (count($booking) > 0){
                                    foreach ($booking as $item){
                                        ?>
                                        <tr>
                                            <td><?= $item['id'];?></td>
                                            <td><?= $item['booked_at'];?></td>
                                            <td>
                                                <?php
                                                if ($item['status'] == 0){
                                                    ?>
                                                    <button class="btn btn-sm btn-warning">Pending</button>
                                                    <?php
                                                }elseif ($item['status'] == 1){
                                                    ?>
                                                    <button class="btn btn-sm btn-primary">Approved</button>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <button class="btn btn-sm btn-secondary">Completed</button>
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                            <td><?= $item['date'];?></td>
                                            <td><?= $item['time'];?></td>
                                            <td><button class="btn btn-sm btn-danger">DEL</button></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</div>

<?php
include "includes/footer.php";
?>
<script>
    $(document).ready(function () {

        $(document).on('submit', '#bookingForm', function (e) {
            e.preventDefault();

            let button = $("#bookingBtn");
            button.prop("disabled", true).html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> <span class="fw-light">Loading...</span>');


            let formData = new FormData(this);
            formData.append("bookingBtn", true);


            $.ajax({
                type: "POST",
                url: "private/api/booking.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    //alert(response);
                    let res = jQuery.parseJSON(response);

                    if (res.status === 400) {
                        button.prop("disabled", false).html('BOOK NOW');
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

                                button.prop("disabled", false).html('BOOK NOW');
                                // $('#bookingForm')[0].reset();
                                window.location.href = 'donation.php';
                            }
                        });

                    }
                }
            });
        })
    })
</script>