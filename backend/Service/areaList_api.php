<?php
include "../class/resp.php";
include "connectdb.php";

$resp = new Resp();
$dataarea = array();
$data_type_product = array();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($connect_status == "success") {
        $z_Id = $_POST["z_Id"];
        $a_Name = $_POST["a_Name"];

        //$sql = "SELECT b.z_Id,a.a_Id,b.z_Name,a.a_Name,a.a_ReserveStatus FROM kkmuni_street.tb_area as a inner join kkmuni_street.tb_zone as b on a.z_Id = b.z_Id where b.z_Id = '".$z_Id."' and a.a_Name LIKE '%".$a_Name."%';";
        $sql = "SELECT  CONVERT(SUBSTRING(a.a_Name,1,1), NCHAR) as subcar, CONVERT(SUBSTRING(a.a_Name,2), UNSIGNED) as subnum, a.a_Id, a.z_Id, a.a_Name, a.a_ReserveStatus, a.a_DateTime, b.z_Name  FROM kkmuni_street.tb_area as a   inner join tb_zone as b on a.z_Id = b.z_Id  where a.z_Id = '".$z_Id."' and a.a_Name LIKE '%".$a_Name."%'  order by subcar,subnum ";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($dataarea,$row);
            }
            $resp->data = $dataarea;
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
