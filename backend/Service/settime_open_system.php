<?php
include "../class/resp.php";
include "connectdb.php";
session_start();

$resp = new Resp();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($connect_status == "success") {

        $os_StartDateTime = $_POST["os_StartDateTime"];
        $os_EndDateTime = $_POST["os_EndDateTime"];

        $sql = "UPDATE `kkmuni_street`.`tb_openSystem` SET `os_StartDateTime` = '".$os_StartDateTime."', `os_EndDateTime` = '".$os_EndDateTime."' WHERE (`os_Id` = 'OS001');";

        if ($conn->query($sql) === TRUE) {

            $_SESSION["os_StartDateTime"] = $os_StartDateTime;
            $_SESSION["os_EndDateTime"] = $os_EndDateTime;

            $resp->set_message("บันทึกข้อมูลสำเร็จ");
            $resp->set_status("success");
        } else {
            $resp->set_message("ไม่สามารถบันทึกข้อมูลได้");
            $resp->set_status("fail");
        }
    } else {
        $resp->set_message("connection database fail.");
        $resp->set_status("fail");
    }
} else {
    $resp->set_message("Request method fail.");
    $resp->set_status("fail");
}

echo json_encode($resp);
