<?php
include "../class/resp.php";
include "connectdb.php";
session_start();

$resp = new Resp();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($connect_status == "success") {

        $arrr_Id = $_POST["arrr_Id"];

        $sql = "";

        for($i = 0 ; $i < count($arrr_Id) ; $i++)
        {
            $sql .= "DELETE FROM `kkmuni_street`.`tb_reserve` WHERE (`r_Id` = '".$arrr_Id[$i]."');";
        }

        if ($conn->multi_query($sql) === TRUE) {
            $resp->set_message("ลบข้อมูลสำเร็จ.");
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
    $resp->set_status("fail");
}

echo json_encode($resp);
