<?php
include "../class/resp.php";
include "connectdb.php";
session_start();

$resp = new Resp();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($connect_status == "success") {

        $status = $_POST["status"];
        $u_Id = $_POST["u_Id"];
        $u_Password = $_POST["u_Password"];
        $u_PasswordNew = $_POST["u_PasswordNew"];

        $u_Password_hash = hash("sha256", $u_PasswordNew);

        $sql = "UPDATE `kkmuni_street`.`tb_user` SET `u_Password` = '" . $u_Password_hash . "' WHERE (`u_Id` = '" . $u_Id . "');";

        if ($status == "admin") {
            if ($conn->query($sql) === TRUE) {
                $resp->set_message("แก้ไขรหัสผ่านสำเร็จ.");
                $resp->set_status("success");
            } else {
                $resp->set_message("มีข้อผิดพลาดเกิดขึ้น.");
                $resp->set_status("fail");
            }
        } else if ($status == "user") {

            $sqlCheck = "SELECT * FROM kkmuni_street.tb_user where u_Id = '" . $u_Id . "';";
            $result = $conn->query($sqlCheck);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if (hash_equals(hash("sha256", $u_Password), $row["u_Password"]) == true) {

                    if ($conn->query($sql) === TRUE) {
                        $resp->set_message("แก้ไขรหัสผ่านสำเร็จ.");
                        $resp->set_status("success");
                    } else {
                        $resp->set_message("มีข้อผิดพลาดเกิดขึ้น.");
                        $resp->set_status("fail");
                    }
                } else {
                    $resp->set_status("fail");
                    $resp->set_message("รหัสผ่านเดิมไม่ถูกต้อง.");
                }
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
