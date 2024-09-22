<?php
include "includes/header.php";
include "includes/nav.php";
$message = new Message();
$messages = $message->getAllMessages();
?>

<div class="container py-5">
    <div class="card shadow">
        <div class="card-header">
            <h3>Messages</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Contact</th>
                    <th>Title</th>
                    <th>Message</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (count($messages) > 0){
                    foreach ($messages as $message){
                        ?>
                        <tr>
                            <td><?= $message['id'];?></td>
                            <td><?= $message['name'];?></td>
                            <td><?= $message['phone'];?></td>
                            <td><?= $message['title'];?></td>
                            <td><?= $message['message'];?></td>
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

<?php
include "includes/footer.php";
?>
