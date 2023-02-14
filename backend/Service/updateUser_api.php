<?php
include "../class/resp.php";
include "connectdb.php";
session_start();

$resp = new Resp();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($connect_status == "success") {

        $u_Id = $_POST["u_Id"];
        $u_Username = $_POST["u_Username"];

        $sql = "UPDATE `kkmuni_street`.`tb_user` SET `u_Username` = '".$u_Username."' WHERE (`u_Id` = '".$u_Id."');";

        $sqlCheckUser = "SELECT * FROM kkmuni_street.tb_user where u_Username = '" . $u_Username . "';";
        $resultUser = $conn->query($sqlCheckUser);

        if ($resultUser->num_rows > 0) {
            $resp->set_message("ชื่อผู้ใช้นี้ มีผู้ใช้งานแล้ว");
            $resp->set_status("Duplicate user");
        } else {
            if ($conn->query($sql) === TRUE) {
                $resp->set_message("แก้ไขชื่อผู้ใช้สำเร็จ");
                $resp->set_status("success");
            } else {
                $resp->set_message("ไม่สามารถแก้ไขชื่อผู้ใช้ได้");
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
