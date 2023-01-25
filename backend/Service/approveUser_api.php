<?php
include "../class/resp.php";
include "connectdb.php";
session_start();

$resp = new Resp();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($connect_status == "success") {

        $u_Id = $_POST["u_Id"];

        $sql = "UPDATE `reserve_space`.`tb_user` SET `u_Approve` = '1' WHERE (`u_Id` = '".$u_Id."');";

        if ($conn->multi_query($sql) === TRUE) {
            $resp->set_message("อนุมัติผู้ใช้สำเร็จ.");
            $resp->set_status("success");
        } else {
            $resp->set_message("มีข้อผิดพลาดเกิดขึ้น.");
            $resp->set_status("fail");
        }
        $conn->close();
    } else {
        $resp->set_message("connection database fail.");
        $resp->set_status("fail");
    }
} else {
    $resp->set_message("Request method fail.");
    $resp->set_status("");
}

echo json_encode($resp);
