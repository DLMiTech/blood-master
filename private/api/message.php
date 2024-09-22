<?php
include "../config/init.php";
$message = new Message();

if ($_SERVER['REQUEST_METHOD'] && isset($_POST['messageBtn'])){
    $form_data = $message->filterInputData($_POST);

    $result = $message->addMessage($form_data);
}
else{
    $result = "";
}



//sleep(1);
echo json_encode($result);
return;

