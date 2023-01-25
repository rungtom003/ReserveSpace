<?php
include "../class/resp.php";
include "connectdb.php";

$resp = new Resp();
$dataarea = array();
$data_type_product = array();
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if ($connect_status == "success") {
        $sql = "SELECT a.a_Id,b.z_Name,a.a_Name,a.a_ReserveStatus FROM reserve_space.tb_area as a inner join reserve_space.tb_zone as b on a.z_Id = b.z_Id;";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($dataarea,$row);
            }

            $sql2 = "SELECT * FROM reserve_space.tb_ProductType;";
            $result2 = $conn->query($sql2);
            if($result2->num_rows > 0)
            {
                while($row2 = $result2->fetch_assoc()) {
                    array_push($data_type_product,$row2);
                }
            }

            $dataarr = array('area'=>$dataarea,'product_type'=>$data_type_product);
            $resp->data = $dataarr;
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
