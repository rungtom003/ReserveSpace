<?php
include "../class/resp.php";
include "connectdb.php";

$resp = new Resp();
$dataUsers = array();
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if ($connect_status == "success") {
        
        $sql = "SELECT tb_zone.z_Id, tb_zone.z_Name,tb_area.a_Id, tb_area.a_Name, tb_area.a_Number, tb_area.a_Detail, tb_area.a_ReserveStatus FROM kkmuni_street.tb_area ";
        $sql .= "inner join kkmuni_street.tb_zone on kkmuni_street.tb_area.z_Id = kkmuni_street.tb_zone.z_Id ;";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($dataUsers,$row);
            }
            $resp->data = $dataUsers;
            $resp->set_status("seccess");
        }
        else{
            $resp->set_status("fail");
        }
    } else {
        $resp->set_message("connection database fail.");
        $resp->set_status("fail");
    }
}
else
{
    $resp->set_message("Request method fail.");
    $resp->set_status("");
}

echo json_encode($resp);
