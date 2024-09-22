<?php
include "includes/header.php";
include "includes/nav.php";
$me = new Authentication();
$myData = $me->getMe($_SESSION['user_id']);
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
            <h1>Status</h1>
        </div>
        <?php
    }
    ?>
</div>

<?php
include "includes/footer.php";
?>
