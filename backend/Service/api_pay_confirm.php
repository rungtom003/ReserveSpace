<?php
include "../class/resp.php";
include "connectdb.php";

$resp = new Resp();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($connect_status == "success") {

        $u_CardNumber = $_POST["u_CardNumber"];
        $a_Name = $_POST["a_Name"];

        $sql_select_area = "SELECT a.r_Id,a.r_Note,a.r_Status,a.r_DateTime,b.a_Id,b.a_Name,b.a_Number,b.a_Detail,b.a_ReserveStatus,c.z_Id,c.z_Name, d.u_Id,d.u_FirstName,d.u_LastName,d.u_CardNumber,d.u_Phone,d.u_Prefix,d.u_Birthday,d.u_Img,d.u_Address,d.u_Road,d.u_SubDistrict,d.u_District,d.u_Province,d.u_ShopName,d.u_ProductName   FROM kkmuni_street.tb_reserve as a    INNER JOIN kkmuni_street.tb_area as b ON a.a_Id = b.a_Id   INNER JOIN kkmuni_street.tb_zone as c ON b.z_Id = c.z_Id   INNER JOIN kkmuni_street.tb_user as d ON d.u_Id = a.u_Id   WHERE (a.r_Status = '9' or a.r_Status = '8') and d.u_CardNumber = '" . $u_CardNumber . "' and a_Name = '" . $a_Name . "';";
        $result_select_area = $conn->query($sql_select_area);

        if ($result_select_area->num_rows == 1) {
            $row = $result_select_area->fetch_assoc();
            if ($row["a_ReserveStatus"] == "9") //a_ReserveStatus -> 9 = รอชำระเงิน
            {
                $sql_insert_TBreserve = "UPDATE `kkmuni_street`.`tb_reserve` SET `r_Status` = '1' WHERE (`r_Id` = '" . $row["r_Id"] . "');";
                $sql_insert_TBreserve .= "UPDATE `kkmuni_street`.`tb_area` SET `a_ReserveStatus` = '1' WHERE (`a_Id` = '" . $row["a_Id"] . "');";
                //สถานะ 1 จองสำเร็จ
                if ($conn->multi_query($sql_insert_TBreserve) === TRUE) {
                    $resp->set_message("จองพื้นที่สำเร็จ.");
                    $resp->set_status("success");
                } else {
                    $resp->set_message("มีข้อผิดพลาดเกิดขึ้น.");
                    $resp->set_status("fail");
                }
            } else if ($row["a_ReserveStatus"] == "8") {
                $sql_insert_TBreserve = "UPDATE `kkmuni_street`.`tb_reserve` SET `r_Status` = '1' WHERE (`r_Id` = '" . $row["r_Id"] . "');";
                $sql_insert_TBreserve .= "UPDATE `kkmuni_street`.`tb_area` SET `a_ReserveStatus` = '4' WHERE (`a_Id` = '" . $row["a_Id"] . "');";
                //สถานะ 1 จองสำเร็จ
                if ($conn->multi_query($sql_insert_TBreserve) === TRUE) {
                    $resp->set_message("จองพื้นที่สำเร็จ.");
                    $resp->set_status("success");
                } else {
                    $resp->set_message("มีข้อผิดพลาดเกิดขึ้น.");
                    $resp->set_status("fail");
                }
            } else {
                $resp->set_message("จองพื้นที่ไม่สำเร็จ");
                $resp->set_status("fail");
            }
        }
        $conn->close();
    } else {
        $resp->set_message("connection database fail.");
        $resp->set_status("fail");
    }
} else {
    $resp->set_message("Request method fail.");
    $resp->set_status("fail");
}

echo json_encode($resp);
