<?php
include "../class/resp.php";
include "connectdb.php";
// Start the session
session_start();

$resp = new Resp();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($connect_status == "success") {
        $a_Id = $_POST["a_Id"];

        if (isset($_SESSION["order"])) {
            $order_data_old = unserialize($_SESSION['order']);
            $count_order = count($order_data_old);

            if ($count_order > 1) {
                $found_key = array_search($a_Id, array_column($order_data_old, 'a_Id'));
                if ($found_key !== false) {
                    unset($order_data_old[$found_key]);
                }
                $_SESSION["order"] = serialize(array_values($order_data_old));
            }
            else
            {
                unset($_SESSION["order"]);
            }
            
            $resp->set_message("remove cart success.");
        }


        $resp->set_status("success");
        $resp->data = unserialize($_SESSION['order']);
    } else {
        $resp->set_message("connection database fail.");
        $resp->set_status("fail");
    }
} else {
    $resp->set_message("Request method fail.");
    $resp->set_status("");
}

echo json_encode($resp);
