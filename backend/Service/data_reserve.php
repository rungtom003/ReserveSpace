<?php
include "../class/resp.php";
include "connectdb.php";

$resp = new Resp();
$dataUsers = array();
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if ($connect_status == "success") {
        $sql = "SELECT a.r_Id,a.r_Note,a.r_Status,a.r_DateTime,b.a_Id,b.a_Name,b.a_ReserveStatus,c.z_Name,d.u_FirstName,d.u_LastName,d.u_CardNumber,d.u_Phone,d.u_Prefix,d.u_Birthday,d.u_Address,d.u_Road,d.u_SubDistrict,d.u_District,d.u_Province,d.u_ShopName,d.u_ProductName FROM reserve_space.tb_reserve as a  INNER JOIN reserve_space.tb_area as b ON a.a_Id = b.a_Id INNER JOIN reserve_space.tb_zone as c ON b.z_Id = c.z_Id INNER JOIN reserve_space.tb_user as d ON d.u_Id = a.u_Id ;";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $status = "";
                if(($row['r_Status'] == "1" && $row['a_ReserveStatus'] == "1") || ($row['r_Status'] == "1" && $row['a_ReserveStatus'] == "4"))
                {
                    $status = "จองสำเร็จ";
                }
                else if(($row['r_Status'] == "0" && $row['a_ReserveStatus'] == "1") || ($row['r_Status'] == "0" && $row['a_ReserveStatus'] == "0"))
                {
                    $status = "ยกเลิกการจอง";
                }
                else if(($row['r_Status'] == "2" && $row['a_ReserveStatus'] == "2"))
                {
                    $status = "จองล็อคประจำสำเร็จ";
                }
                else if(($row['r_Status'] == "2" && $row['a_ReserveStatus'] == "3"))
                {
                    $status = "ยกเลิกล็อคประจำชั่วคราว";
                }
                else if(($row['r_Status'] == "2" && $row['a_ReserveStatus'] == "4"))
                {
                    $status = "ล็อคประจำถูกจอง";
                }

                $arrCustom = array(
                    'r_Id' => $row['r_Id'],
                    'r_Note' => $row['r_Note'],
                    'r_DateTime' => $row['r_DateTime'],
                    'a_Id' => $row['a_Id'],
                    'a_Name' => $row['a_Name'],
                    'z_Name' => $row['z_Name'],
                    'u_FirstName' => $row['u_FirstName'],
                    'u_LastName' => $row['u_LastName'],
                    'u_CardNumber' => $row['u_CardNumber'],
                    'u_Phone' => $row['u_Phone'],
                    'u_Prefix' => $row['u_Prefix'],
                    'u_Birthday' => $row['u_Birthday'],
                    'u_Address' => $row['u_Address'],
                    'u_Road' => $row['u_Road'],
                    'u_SubDistrict' => $row['u_SubDistrict'],
                    'u_District' => $row['u_District'],
                    'u_Province' => $row['u_Province'],
                    'u_ShopName' => $row['u_ShopName'],
                    'u_ProductName' => $row['u_ProductName'],
                    'status' => $status
                );
                array_push($dataUsers,$arrCustom);
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
