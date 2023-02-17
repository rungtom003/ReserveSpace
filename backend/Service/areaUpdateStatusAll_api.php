<?php
include "../class/resp.php";
include "connectdb.php";

$resp = new Resp();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($connect_status == "success") {

        $a_ReserveStatus = $_POST["a_ReserveStatus"];
        $z_Id = $_POST["z_Id"];
        $status;


        if($a_ReserveStatus == 5){
            $status = 0;
            $mesage = "เปิดบล็อคทั้งหมดสำเร็จ";
        }else if($a_ReserveStatus == 0){
            $status = 5;
            $mesage = "ปิดบล็อคทั้งหมดสำเร็จ";
        }

        $sql = "UPDATE `kkmuni_street`.`tb_area` SET `a_ReserveStatus`= '".$status."' ";
        $sql .= "where `z_Id` = '".$z_Id."' and `a_ReserveStatus` = '".$a_ReserveStatus."';";
        if ($conn->query($sql) === TRUE) {
            $resp->set_message($mesage);
            $resp->set_status("success");

        } else {
            $resp->set_message("เกิดข้อผิดพลาด.");
            $resp->set_status("fail");
        }
    } else {
        $resp->set_message("connection database fail.");
        $resp->set_status("fail");
    }
} else {
    $resp->set_message("Request method fail.");
    $resp->set_status("");
}

echo json_encode($resp);
