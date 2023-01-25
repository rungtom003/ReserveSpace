<?php
include "../class/resp.php";
include "connectdb.php";
session_start();

$resp = new Resp();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($connect_status == "success") {

        $rd_Id = $_POST["rd_Id"];
        $a_Id = $_POST["a_Id"];

        $sql = "UPDATE `reserve_space`.`tb_area` SET `a_ReserveStatus` = '1' WHERE (`a_Id` = '".$a_Id."');";
        $sql .= "UPDATE `reserve_space`.`tb_reserveDetail` SET `rd_Status` = '1' WHERE (`rd_Id` = '".$rd_Id."');";

        if ($conn->multi_query($sql) === TRUE) {
            unset($_SESSION["order"]);
            $resp->set_message("อนุมัติจองพื้นที่สำเร็จ.");
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
