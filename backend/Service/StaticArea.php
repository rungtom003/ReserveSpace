<?php
include "../class/resp.php";
include "connectdb.php";
session_start();

$resp = new Resp();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($connect_status == "success") {

        $r_Id = $_POST["r_Id"];
        $a_Id = $_POST["a_Id"];

        $sql = "UPDATE `kkmuni_street`.`tb_area` SET `a_ReserveStatus` = '2' WHERE (`a_Id` = '".$a_Id."');";
        $sql .= "UPDATE `kkmuni_street`.`tb_reserve` SET `r_Status` = '2' WHERE (`r_Id` = '".$r_Id."');";

        if ($conn->multi_query($sql) === TRUE) {
            $resp->set_message("อัพเดทเป็นล็อคประจำสำเร็จ.");
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
