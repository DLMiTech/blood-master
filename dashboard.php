<?php

use Couchbase\User;

include "includes/header.php";
include "includes/nav.php";
$user = new Authentication();
$users = $user->getAllUser();
$book = new Booking();
$booking = $book->allBooking();
$totalBlood = $book->totalBlood();
$totalO = $book->totalGroup("O");
$totalA = $book->totalGroup("A");
$totalB = $book->totalGroup("B");
$totalAB = $book->totalGroup("AB");
?>

<div class="container py-5">
    <div class="card">
        <div class="card-header">
            <h4>Dashboard</h4>
        </div>
        <div class="card-body">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-rooms" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Users</button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-FandF" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Booking</button>
                    <button class="nav-link" id="nav-dash-tab" data-bs-toggle="tab" data-bs-target="#nav-Dash" type="button" role="tab" aria-controls="nav-dash" aria-selected="false">Dashboard</button>
                </div>
            </nav>

            <div class="tab-content p-2" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-rooms" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                    <div class="card my-2">
                        <div class="card-header">
                            <h4>Users</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped align-middle">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (count($users) > 0){
                                    foreach ($users as $user){
                                        ?>
                                        <tr>
                                            <td><?= $user['user_id'];?></td>
                                            <td><?= $user['name'];?></td>
                                            <td><?= $user['phone'];?></td>
                                            <td><?= $user['email'];?></td>
                                            <td>
                                                <?php
                                                if ($user['status'] == 1){
                                                    ?><button id="verifiedBtn" type="button" class="btn btn-sm btn-success disabled">Verified</button><?php
                                                }else{
                                                    ?><button id="verifiedBtn"
                                                              data-user-id="<?= $user['user_id'];?>"
                                                              data-user-name="<?= $user['name'];?>"
                                                              data-user-email="<?= $user['email'];?>"
                                                              data-user-phone="<?= $user['phone'];?>"
                                                              type="button" class="btn btn-dark btn-sm">Not Verified</button><?php
                                                }
                                                ?>

                                            </td>
                                            <td><button value="<?= $user['user_id'];?>" class="btn btn-danger btn-sm">DEL</button></td>
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
                                        <td><button type="button" id="changeStatusBtn"
                                                    data-booking-id="<?= $item['id'];?>"
                                                    class="btn btn-sm btn-danger">CHANGE</button></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>

                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="tab-pane fade" id="nav-Dash" role="tabpanel" aria-labelledby="nav-dash-tab" tabindex="0">
                    <div class="card p-3 shadow">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="text-center p-5 border shadow">
                                    <h2>Total Blood</h2>
                                    <h1><?= $totalBlood?></h1>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="text-center p-5 border shadow">
                                    <h2>Total O Blood</h2>
                                    <h1><?= $totalO?></h1>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="text-center p-5 border shadow">
                                    <h2>Total A Blood</h2>
                                    <h1><?= $totalA?></h1>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="text-center p-5 border shadow">
                                    <h2>Total B Blood</h2>
                                    <h1><?= $totalB?></h1>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="text-center p-5 border shadow">
                                    <h2>Total AB Blood</h2>
                                    <h1><?= $totalAB?></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="verifyUserModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">User verification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" id="verifyForm">
                <div class="modal-body">
                    <input type="hidden" name="id" id="viewUserId" class="form-control mb-2" readonly>

                    <label for="viewUserName">User Name</label>
                    <input type="text" name="name" id="viewUserName" class="form-control mb-2" readonly>

                    <input type="hidden" value="1" name="status" id="" class="form-control mb-2" readonly>

                    <label for="group">Select Blood Group</label>
                    <select name="group" id="group" class="form-select" required>
                        <option value="">Select blood group</option>
                        <option value="O">O</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="AB">AB</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button id="verifyBtn" type="submit" class="btn btn-primary">SUBMIT</button>
                </div>
            </form>

        </div>
    </div>
</div>




<!-- Modal -->
<div class="modal fade" id="changeStatusModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Change Donation Booking Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" id="changeBookingForm">
                <div class="modal-body">

                    <input type="hidden" name="id" id="viewBookingId" class="form-control mb-2" readonly>

                    <label for="group">Select Status</label>
                    <select name="group" id="group" class="form-select" required>
                        <option value="">Select status</option>
                        <option value="0">Pending</option>
                        <option value="1">Approved</option>
                        <option value="2">Completed</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button id="changeBookingBtn" type="submit" class="btn btn-primary">SUBMIT</button>
                </div>
            </form>

        </div>
    </div>
</div>


<?php
include "includes/footer.php";
?>

<script>
    $(document).ready(function () {

        $(document).on('click', '#verifiedBtn', function () {
            // alert("Hello");
            let button = $(this);
            let user_id = button.data('user-id');
            let user_name = button.data('user-name');


            $('#viewUserId').val(user_id);
            $('#viewUserName').val(user_name);


            $('#verifyUserModel').modal('show');
        })


        $(document).on('submit', '#verifyForm', function (e) {
            e.preventDefault();

            let button = $("#verifyBtn");
            button.prop("disabled", true).html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> <span class="fw-light">Loading...</span>');

            let formData = new FormData(this);
            formData.append("verifyBtn", true);

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
                        button.prop("disabled", false).html('SUBMIT');
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

                                button.prop("disabled", false).html('SUBMIT');
                                $('#verifyForm')[0].reset();
                                $('#verifyUserModel').modal('hide');
                                window.location.href = 'dashboard.php';
                            }
                        });

                    }
                }
            });
        })



        $(document).on('click', '#changeStatusBtn', function () {
            // alert("Hello");
            let button = $(this);
            let booking_id = button.data('booking-id');


            $('#viewBookingId').val(booking_id);


            $('#changeStatusModel').modal('show');
        })



        $(document).on('submit', '#changeBookingForm', function (e) {
            e.preventDefault();

            let button = $("#changeBookingBtn");
            button.prop("disabled", true).html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> <span class="fw-light">Loading...</span>');

            let formData = new FormData(this);
            formData.append("changeBookingBtn", true);

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
                        button.prop("disabled", false).html('SUBMIT');
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

                                button.prop("disabled", false).html('SUBMIT');
                                $('#changeBookingForm')[0].reset();
                                $('#changeStatusModel').modal('hide');
                                window.location.href = 'dashboard.php';
                            }
                        });

                    }
                }
            });
        })
    });
</script>