<?php
include "../config/init.php";
$book = new Booking();

if ($_SERVER['REQUEST_METHOD'] && isset($_POST['bookingBtn'])){
    $form_data = $book->filterInputData($_POST);

    $result = $book->bookNow($form_data);
}
elseif ($_SERVER['REQUEST_METHOD'] && isset($_POST['changeBookingBtn'])){
    $form_data = $book->filterInputData($_POST);

    $result = $book->changeBookingStatus($form_data);
}
else{
    $result = "";
}



//sleep(1);
echo json_encode($result);
return;
