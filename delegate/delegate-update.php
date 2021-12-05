<?php

require_once "../classes/Delegate.php";

session_start();

$obj = new Delegate();
$obj->setDelegateId($_SESSION["delegate_id"]);

if($obj->markPresent()) {
    $_SESSION["is_present"] = 1;
    header('location:dashboard.php');
}
else {
    header('location:error.php');
}

?>