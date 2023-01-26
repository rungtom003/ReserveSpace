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

        if($z_Id == "2dacd150-9b8b-11ed-8054-0242ac110004") //โซนอาหาร
        {
            $sql_food = "SELECT b.rd_Id,a.r_Id,c.u_Id,b.a_Id,e.z_Id,d.a_Name,e.z_Name,b.rd_Detail,b.rd_Note,b.rd_Status,d.a_ReserveStatus,b.rd_DateTime,c.u_Prefix,c.u_FirstName,c.u_LastName,c.u_CardNumber,c.u_Phone,c.u_Birthday,c.u_Img,c.u_Address,c.u_Road,c.u_SubDistrict,c.u_District,c.u_Province  FROM reserve_space.tb_reserve as a INNER JOIN reserve_space.tb_reserveDetail as b ON a.r_Id = b.r_Id  INNER JOIN reserve_space.tb_user as c ON a.u_Id = c.u_Id  INNER JOIN reserve_space.tb_area as d ON b.a_Id = d.a_Id  INNER JOIN reserve_space.tb_zone as e ON d.z_Id = e.z_Id WHERE b.rd_Status = '1' AND d.z_Id = '2dacd150-9b8b-11ed-8054-0242ac110004'";
            $result_food = $conn->query($sql_food);
            if($result_food->num_rows > 0)
            {
                //ถ้า user มีการจองไปแล้ว 1 ล็อค ในโซนของอาหาร
            }
            else
            {
                //ถ้า user ยังไม่มีการจองในโซนของอาหาร
            }
        }
        else //ไม่ใช่โซนอาหาร
        {

        }

        $sql = "SELECT b.z_Id,a.a_Id,b.z_Name,a.a_Name,a.a_ReserveStatus FROM reserve_space.tb_area as a inner join reserve_space.tb_zone as b on a.z_Id = b.z_Id where b.z_Id = '".$z_Id."' and a.a_Name LIKE '%".$a_Name."%';";
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
