<?php
include "../class/resp.php";
include "connectdb.php";
session_start();

$resp = new Resp();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($connect_status == "success") {

        $u_Id = $_POST['u_Id'];
        $u_FirstName = $_POST["u_FirstName"];
        $u_LastName = $_POST["u_LastName"];
        $u_Username = $_POST["u_Username"];
        $u_CardNumber = $_POST["u_CardNumber"];
        $u_OfficerId = $_POST["u_OfficerId"];
        $u_Position = $_POST["u_Position"];
        $u_Phone = $_POST["u_Phone"];
        $u_Prefix = $_POST["u_Prefix"];
        $u_Birthday = $_POST["u_Birthday"];
        $u_Address = $_POST["u_Address"];
        $u_Road = $_POST["u_Road"];
        $u_SubDistrict = $_POST["u_SubDistrict"];
        $u_District = $_POST["u_District"];
        $u_Province = $_POST["u_Province"];
        $z_Id = $_POST["z_Id"];
        $u_ShopName = $_POST["u_ShopName"];
        $u_ProductName = $_POST["u_ProductName"];
        $u_IdWalkin = $_POST["u_IdWalkin"];

        if ($u_Birthday == "") {
            $u_Birthday = "NULL";
        } else {
            $u_Birthday = "'" . $u_Birthday . "'";
        }

        $sql = "UPDATE `kkmuni_street`.`tb_user` SET `u_FirstName` = '" . $u_FirstName . "', u_LastName = '" . $u_LastName . "', `u_OfficerId` = '" . $u_OfficerId . "', ";
        $sql .= "`u_Position` = '" . $u_Position . "',  `u_Phone` = '" . $u_Phone . "', `u_Prefix` = '" . $u_Prefix . "', `u_Birthday` = " . $u_Birthday . ", `u_IdWalkin` = '".$u_IdWalkin."', ";
        $sql .= "`u_Address` = '" . $u_Address . "', `u_Road` = '" . $u_Road . "', `u_SubDistrict` = '" . $u_SubDistrict . "', `u_District` = '" . $u_District . "', `u_Province` = '" . $u_Province . "', ";
        $sql .= "`z_Id` = '" . $z_Id . "', `u_ShopName` = '" . $u_ShopName . "', `u_ProductName` = '" . $u_ProductName . "',`u_Username` = '" . $u_Username . "',`u_CardNumber` = '" . $u_CardNumber . "' ";
        $sql .= "WHERE `u_Id` = '" . $u_Id . "';";

        $sqlCheckWalkIn  = "SELECT * FROM kkmuni_street.tb_user where u_IdWalkin = '" . $u_IdWalkin . "' and u_Id != '".$u_Id."' ;";
        $resultWalkIn  = $conn->query($sqlCheckWalkIn);

        if ($resultWalkIn->num_rows > 0) {
            $resp->set_message("รหัส Walk-in ซ้ำ");
            $resp->set_status("Duplicate");
        } else{
            if ($conn->query($sql) === TRUE) {
                $resp->set_message("บันทึกข้อมูลสำเร็จ");
                $resp->set_status("success");
            } else {
                $resp->set_message("ไม่สามารถบันทึกข้อมูลได้");
                $resp->set_status("fail");
            }
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
