<?php
include "../class/resp.php";
include "connectdb.php";

$resp = new Resp();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($connect_status == "success") {

        $a_Id = $_POST["a_Id"];
        $a_ReserveStatus = $_POST["a_ReserveStatus"];


        if($a_ReserveStatus == 5){
            $a_ReserveStatus = 0;
            $mesage = "เปิดบล็อคสำเร็จ";
        }else if($a_ReserveStatus == 0){
            $a_ReserveStatus = 5;
            $mesage = "ปิดบล็อคสำเร็จ";
        }

        $sql = "UPDATE `kkmuni_street`.`tb_area` SET `a_ReserveStatus`= '".$a_ReserveStatus."' ";
        $sql .= "WHERE `a_Id` = '".$a_Id."';";
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
