<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    session_start();
    session_unset();
    session_destroy();
    header('location: /ReserveSpace/login.php');
    exit();
} else {
    $resp->set_message("Request method fail.");
    $resp->set_status("");
}
