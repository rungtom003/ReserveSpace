<?php
include "../class/resp.php";
include "connectdb.php";

$resp = new Resp();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($connect_status == "success") {

        $ur_Id = $_POST["ur_Id"];
        $u_FirstName = $_POST["u_FirstName"];
        $u_LastName = $_POST["u_LastName"];
        $u_Username = $_POST["u_Username"];
        $u_Password = $_POST["u_Password"];

        $u_Password_hash = hash("sha256", $u_Password);
        $sql = "INSERT INTO `reserve_space`.`tb_user` (`ur_Id`, `u_FirstName`, `u_LastName`, `u_Username`, `u_Password`) VALUES ('".$ur_Id."', '".$u_FirstName."', '".$u_LastName."', '".$u_Username."', '".$u_Password_hash."');";

        if ($conn->query($sql) === TRUE) {
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
    $resp->set_status("");
}

echo json_encode($resp);
