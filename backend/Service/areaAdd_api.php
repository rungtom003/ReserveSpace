<?php
include "../class/resp.php";
include "connectdb.php";

function uniqidReal($lenght = 13) {
    if (function_exists("random_bytes")) {
        $bytes = random_bytes(ceil($lenght / 2));
    } elseif (function_exists("openssl_random_pseudo_bytes")) {
        $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
    } else {
        throw new Exception("no cryptographically secure random function available");
    }
    return substr(bin2hex($bytes), 0, $lenght);
}

$resp = new Resp();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($connect_status == "success") {

        $z_Id = $_POST["z_Id"];
        $a_Name = $_POST["a_Name"];

        // for($i = 0; $i <= 42; $i++){
        //     $name = $a_Name.$i;
        //     $sql = "INSERT INTO `reserve_space`.`tb_area` (`z_Id`,`a_Name` ) VALUES ('".$z_Id."', '" . $name . "');";
        //     if ($conn->query($sql) === TRUE) {
        //         $resp->set_message("บันทึกข้อมูลสำเร็จ > ".$i);
        //         $resp->set_status("success");
        //     } else {
        //         $resp->set_message("ไม่สามารถบันทึกข้อมูลได้");
        //         $resp->set_status("fail");
        //     }
        // }

        $sql = "INSERT INTO `reserve_space`.`tb_area` (`a_Id`,`z_Id`,`a_Name` ) VALUES ('" . uniqidReal() . "','" . $z_Id . "', '" . $a_Name . "');";

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
