<?php
include "../class/resp.php";
include "connectdb.php";
// Start the session
session_start();

$resp = new Resp();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($connect_status == "success") {
        $pt_Id = $_POST["pt_Id"];
        $a_Id = $_POST["a_Id"];
        $a_Name = $_POST["a_Name"];
        $z_Name = $_POST["z_Name"];
        $u_Name = $_POST["u_Name"];

        $order_data = array(array('pt_Id'=>$pt_Id,'a_Id'=>$a_Id,'a_Name'=>$a_Name,'z_Name'=>$z_Name,'u_Name'=>$u_Name));
        if(isset($_SESSION["order"]))
        {
            $order_data_old = unserialize($_SESSION['order']);
            array_push($order_data_old,array('pt_Id'=>$pt_Id,'a_Id'=>$a_Id,'a_Name'=>$a_Name,'z_Name'=>$z_Name,'u_Name'=>$u_Name));
            $_SESSION["order"] = serialize($order_data_old);
        }
        else
        {
            $_SESSION["order"] = serialize($order_data);
        }

        $resp->set_message("Add cart success.");
        $resp->set_status("success");
        $resp->data = unserialize($_SESSION['order']);

    } else {
        $resp->set_message("connection database fail.");
        $resp->set_status("fail");
    }
}
else
{
    $resp->set_message("Request method fail.");
    $resp->set_status("");
}

echo json_encode($resp);
