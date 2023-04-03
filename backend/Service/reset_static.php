<?php
include "../class/resp.php";
include "connectdb.php";

$resp = new Resp();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($connect_status == "success") {

        $sql = "UPDATE kkmuni_street.tb_reserve SET r_Status = '0' WHERE r_Status = '2';";
        $sql .= "UPDATE kkmuni_street.tb_area SET a_ReserveStatus = '0' WHERE a_ReserveStatus = '2';";

        $sql2 = "UPDATE kkmuni_street.tb_reserve SET r_Status = '9' WHERE r_Status = '8';";
        $sql2 .= "UPDATE kkmuni_street.tb_area SET a_ReserveStatus = '9' WHERE a_ReserveStatus = '8';";

        $sql3 = "UPDATE kkmuni_street.tb_area SET a_ReserveStatus = '1' WHERE a_ReserveStatus = '4';";

        if ($conn->multi_query($sql) === TRUE) {
            $conn->next_result();
            if ($conn->multi_query($sql2) === TRUE) {
                $conn->next_result();
                if ($conn->query($sql3) === TRUE) {
                    $resp->set_message("รีเซ็ตการจองสำเร็จ");
                    $resp->set_status("success");
                }
            }
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
$conn->close();
echo json_encode($resp);
