<?php
include "../class/resp.php";
include "connectdb.php";

$resp = new Resp();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($connect_status == "success") {

        $u_Id = $_POST["u_Id"];
        $u_Img = $_POST["u_Img"];

        $sql = "DELETE FROM `kkmuni_street`.`tb_user` WHERE `u_Id` = '" . $u_Id . "'; ";

        if ($conn->query($sql) === TRUE) {
            $filename = "../../src/img/upload/".$u_Img;
            unlink($filename);
            $resp->set_message("ลบข้อมูลสำเร็จ");
            $resp->set_status("success");
        } else {
            $resp->set_message("ไม่สามารถลบข้อมูลได้");
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
