<?php
include "../class/resp.php";
include "connectdb.php";

$resp = new Resp();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($connect_status == "success") {
        $u_Id = $_POST["u_Id"];

        $sql = "SELECT * FROM kkmuni_street.tb_user as a inner join tb_zone as b on a.z_Id = b.z_Id where a.u_Id = '".$u_Id."';";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $resp->set_status("success");
            $resp->data = $row;
        } else {
            $resp->set_status("fail");
            $resp->set_message("ไม่มีข้อมูล");
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
