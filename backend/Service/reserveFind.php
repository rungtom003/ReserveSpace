<?php
include "../class/resp.php";
include "connectdb.php";

$resp = new Resp();
$dataUsers = array();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($connect_status == "success") {
        $a_Id = $_POST["a_Id"];
        $sql = "SELECT a.r_Id,c.u_Id,b.pt_Id,b.a_Id,e.z_Id,f.pt_Id,d.a_Name,e.z_Name,f.pt_Name,b.rd_Detail,b.rd_Note,b.rd_Status,d.a_ReserveStatus,b.rd_DateTime,c.u_Prefix,c.u_FirstName,c.u_LastName,c.u_CardNumber,c.u_Phone,c.u_Birthday,c.u_Img,c.u_Address,c.u_Road,c.u_SubDistrict,c.u_District,c.u_Province FROM reserve_space.tb_reserve as a  INNER JOIN reserve_space.tb_reserveDetail as b ON a.r_Id = b.r_Id INNER JOIN reserve_space.tb_user as c ON a.u_Id = c.u_Id INNER JOIN reserve_space.tb_area as d ON b.a_Id = d.a_Id INNER JOIN reserve_space.tb_zone as e ON d.z_Id = e.z_Id INNER JOIN reserve_space.tb_ProductType as f ON b.pt_Id = f.pt_Id  WHERE b.a_Id = '".$a_Id."';";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $resp->data = $row;
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
