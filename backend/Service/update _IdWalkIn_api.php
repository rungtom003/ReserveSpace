<?php
include "../class/resp.php";
include "connectdb.php";
session_start();

$resp = new Resp();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($connect_status == "success") {
        $u_Id = $_POST["u_Id"];
        $u_IdWalkin = $_POST["u_IdWalkin"];

        $sql = "UPDATE `kkmuni_street`.`tb_user` SET `u_IdWalkin` = '" . $u_IdWalkin . "' WHERE (`u_Id` = '" . $u_Id . "' and `u_Approve` = 1);";

        $sqlCheckWalkIn  = "SELECT * FROM kkmuni_street.tb_user where u_IdWalkin = '" . $u_IdWalkin . "' and u_Id != '".$u_Id."' ;";
        $resultWalkIn  = $conn->query($sqlCheckWalkIn);

        if ($resultWalkIn->num_rows > 0) {
            $resp->set_message("รหัส Walk-in ซ้ำ");
            $resp->set_status("Duplicate");
        } else{
            if ($conn->query($sql) === TRUE) {
                $resp->set_message("แก้ไขรหัส Walk-in สำเร็จ.");
                $resp->set_status("success");
            } else {
                $resp->set_message("มีข้อผิดพลาดเกิดขึ้น.");
                $resp->set_status("fail");
            }
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
