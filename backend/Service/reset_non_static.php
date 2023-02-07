<?php
include "../class/resp.php";
include "connectdb.php";

$resp = new Resp();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($connect_status == "success") {

        $sql = "UPDATE reserve_space.tb_reserve SET r_Status = '0' WHERE r_Status = '1';";
        $sql .= "UPDATE reserve_space.tb_area SET a_ReserveStatus = '0' WHERE a_ReserveStatus = '1';";

        if ($conn->multi_query($sql) === TRUE) {

            $resp->set_message("รีเซ็ตการจองสำเร็จ");
            $resp->set_status("success");

        } else {
            $resp->set_message("ไม่สามารถรีเซ็ตการจองได้");
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
