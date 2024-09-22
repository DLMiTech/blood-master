<?php

use Couchbase\User;

include "includes/header.php";
include "includes/nav.php";
$user = new Authentication();
$users = $user->getAllUser();
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
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-FandF" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Features & Facilities</button>
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
                    <h1>Two</h1>
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
    });
</script>