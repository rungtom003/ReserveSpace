<?php
include "../class/resp.php";
include "connectdb.php";

$resp = new Resp();
$dataUsers = array();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($connect_status == "success") {
        $a_Id = $_POST["a_Id"];
        $sql = "SELECT a.r_Id,a.r_Note,a.r_Status,a.r_DateTime,b.a_Id,b.a_Name,b.a_Number,b.a_Detail,b.a_ReserveStatus,c.z_Id,c.z_Name, d.u_Id,d.u_FirstName,d.u_LastName,d.u_CardNumber,d.u_Phone,d.u_Prefix,d.u_Birthday,d.u_Img,d.u_Address,d.u_Road,d.u_SubDistrict,d.u_District,d.u_Province,d.u_ShopName,d.u_ProductName  FROM kkmuni_street.tb_reserve as a   INNER JOIN kkmuni_street.tb_area as b ON a.a_Id = b.a_Id  INNER JOIN kkmuni_street.tb_zone as c ON b.z_Id = c.z_Id  INNER JOIN kkmuni_street.tb_user as d ON d.u_Id = a.u_Id  WHERE b.a_Id = '".$a_Id."' AND (a.r_Status = '1' OR a.r_Status = '2' OR a.r_Status = '9' OR a.r_Status = '8');";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            //$row = $result->fetch_assoc();
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
