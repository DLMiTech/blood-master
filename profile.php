<?php
include "includes/header.php";
include "includes/nav.php";
$me = new Authentication();
$myData = $me->getMe($_SESSION['user_id']);
?>

<div class="container py-5">
    <?php
    if ($myData[0]['status'] == 0 && $myData[0]['role'] == 0) {
        ?>
        <h5 class="mb-3">Blood Group</h5>
        <div class="card p-3 shadow mb-4">
            <div class="text-center py-3">
                <h1>Hello <?= $myData[0]['name']?></h1>
                <h4>Welcome To Blood Bank Master</h4>
                <p>Visit any nearest hospital for your blood group And health verification to start your donation</p>
            </div>
        </div>
        <?php
    }elseif($myData[0]['status'] == 1 && $myData[0]['role'] == 0){
        ?>
        <div class="card p-3 shadow mb-3 text-center">
            <h4>Blood Group</h4>
            <h1><?= $myData[0]['blood_group'];?></h1>
        </div>
        <?php
    }
    ?>

    <h5 class="mt-3">Account Info</h5>
    <div class="card p-3 shadow mb-5">
        <div class="" id="myProfile">
            <img src="imgs/person.jpeg" class="rounded-pill" alt="img" style="width: 4rem;">
            <p class="mb-0"><strong>Name :</strong><?= $myData[0]['name']?></p>
            <p class="mb-0"><strong>Username :</strong><?= $myData[0]['username']?></p>
            <p class="mb-0"><strong>Contact :</strong><?= $myData[0]['phone']?></p>
            <div class="d-flex align-items-center justify-content-between">
                <?php
                if ($myData[0]['role'] == 1){
                    ?><p class="mb-0"><strong>User type :</strong>Admin</p><?php
                }else{
                    ?><p class="mb-0"><strong>User type :</strong>User</p><?php
                }
                ?>

                <button value="<?= $_SESSION['user_id']?>" class="btn btn-success btn-sm editBtn">Edit Profile</button>
            </div>
        </div>
    </div>
    <h5 class="mb-3">Change Password</h5>
    <div class="card shadow p-3 mb-4">
        <form action="" id="changePasswordForm">
            <div class="row">
                <input type="hidden" name="user_id" value="<?= $_SESSION['user_id']?>">
                <div class="col-12">
                    <div class="mb-3">
                        <label>Old password:</label>
                        <input type="password" name="old_password" placeholder="Enter old password" class="form-control shadow-none">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label>New password:</label>
                        <input type="password" name="new_password" placeholder="Enter new password" class="form-control shadow-none">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label>Confirm new password:</label>
                        <input type="password" name="c_new_password" placeholder="Confirm new password" class="form-control shadow-none">
                    </div>
                </div>

                <div class="text-end">
                    <button id="changePasswordBtn" class="btn btn-danger">CHANGE PASSWORD</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
include "includes/footer.php";
?>


<script>
    $(document).on('click', '.editBtn', function (){
        let user_id = $(this).val();

        $.ajax({
            type: "GET",
            url: "private/api/auth.php?getUserById=" + user_id,

            success: function (response){
                let res = jQuery.parseJSON(response);

                if(res.status === 400){
                    Swal.fire({
                        icon: "error",
                        text: res.message,
                    });
                }else if(res.status === 200){
                    $('#editId').val(res.data.user_id);
                    $('#editName').val(res.data.name);
                    // $('#editRole').val(res.data.role);
                    $('#editPhone').val(res.data.phone);
                    // $('#editPassword').val(res.data.password);
                    $('#updateUserModal').modal('show');
                }
            }
        });
    });

    $(document).on('submit', '#updateUserForm', function (e) {
        e.preventDefault();

        let button = $("#updateUserBtn");
        button.prop("disabled", true).html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> <span class="fw-light">Loading...</span>');
        let formData = new FormData(this);
        formData.append("updateMyProfileBtn", true);

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
                    button.prop("disabled", false).html('ADD USER');
                    Swal.fire({
                        icon: "error",
                        text: res.message,
                    });
                } else if (res.status === 200) {
                    button.prop("disabled", false).html('ADD USER');
                    Swal.fire({
                        icon: "success",
                        text: res.message,
                    });

                    $('#updateUserForm')[0].reset();
                    $('#updateUserModal').modal('hide');
                    $('#myProfile').load(location.href + " #myProfile");
                }
            }
        });
    });

    $(document).on('submit', '#changePasswordForm', function (e) {
        e.preventDefault();

        let button = $("#changePasswordBtn");
        button.prop("disabled", true).html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> <span class="fw-light">Loading...</span>');
        let formData = new FormData(this);
        formData.append("changePasswordBtn", true);

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
                    button.prop("disabled", false).html('CHANGE PASSWORD');
                    Swal.fire({
                        icon: "error",
                        text: res.message,
                    });
                } else if (res.status === 200) {
                    button.prop("disabled", false).html('CHANGE PASSWORD');
                    Swal.fire({
                        icon: "success",
                        text: res.message,
                    });

                    $('#changePasswordForm')[0].reset();
                }
            }
        });
    });
</script>

<!-- Modal -->
<div class="modal fade" id="updateUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Update User</h1>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="updateUserForm">
                    <div class="row">
                        <input type="hidden" id="editId" name="user_id" placeholder="Enter user full name" class="form-control shadow-none">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Full name:</label>
                                <input type="text" id="editName" name="name" placeholder="Enter user full name" class="form-control shadow-none">
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Phone number:</label>
                                <input type="text" id="editPhone" name="phone" placeholder="Enter phone number" class="form-control shadow-none">
                            </div>
                        </div>


                        <div class="text-end">
                            <button id="updateUserBtn" class="btn btn-danger">UPDATE PROFILE</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

