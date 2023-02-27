<?php
include "../class/resp.php";
include "connectdb.php";
session_start();

function uniqidReal($lenght = 13)
{
    if (function_exists("random_bytes")) {
        $bytes = random_bytes(ceil($lenght / 2));
    } elseif (function_exists("openssl_random_pseudo_bytes")) {
        $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
    } else {
        throw new Exception("no cryptographically secure random function available");
    }
    return substr(bin2hex($bytes), 0, $lenght);
}

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
        $u_Img = "";
        $deleteImg = $_POST["deleteImg"];

        if ($u_Birthday == "") {
            $u_Birthday = "NULL";
        } else {
            $u_Birthday = "'" . $u_Birthday . "'";
        }

        $sql = "";

        isset($_FILES['u_Img']) ? $file = $_FILES['u_Img'] : $file = null;
        $file_name_custom = null;

        if (isset($file) && $file != null) {

            if (filesize($file["tmp_name"]) > 0) {
                $file_name_custom = "[" . uniqidReal() . "]" . $file["name"];

                $checkupload = move_uploaded_file(
                    $file["tmp_name"],
                    "../../src/img/upload/" . $file_name_custom
                );
                if ($checkupload) {
                    $u_Img = $file_name_custom;
                    if ($deleteImg != "") {
                        unlink("../../src/img/upload/" . $deleteImg);
                    }
                }
            }
        }

        if ($u_Img == "") {
            $sql = "UPDATE `kkmuni_street`.`tb_user` SET `u_FirstName` = '" . $u_FirstName . "', u_LastName = '" . $u_LastName . "', `u_OfficerId` = '" . $u_OfficerId . "', ";
            $sql .= "`u_Position` = '" . $u_Position . "',  `u_Phone` = '" . $u_Phone . "', `u_Prefix` = '" . $u_Prefix . "', `u_Birthday` = " . $u_Birthday . ", `u_IdWalkin` = '" . $u_IdWalkin . "', ";
            $sql .= "`u_Address` = '" . $u_Address . "', `u_Road` = '" . $u_Road . "', `u_SubDistrict` = '" . $u_SubDistrict . "', `u_District` = '" . $u_District . "', `u_Province` = '" . $u_Province . "', ";
            $sql .= "`z_Id` = '" . $z_Id . "', `u_ShopName` = '" . $u_ShopName . "', `u_ProductName` = '" . $u_ProductName . "',`u_Username` = '" . $u_Username . "',`u_CardNumber`='" . $u_CardNumber . "' ";
            $sql .= "WHERE `u_Id` = '" . $u_Id . "';";
        } else {
            $sql = "UPDATE `kkmuni_street`.`tb_user` SET `u_FirstName` = '" . $u_FirstName . "', u_LastName = '" . $u_LastName . "', `u_OfficerId` = '" . $u_OfficerId . "', ";
            $sql .= "`u_Position` = '" . $u_Position . "',  `u_Phone` = '" . $u_Phone . "', `u_Prefix` = '" . $u_Prefix . "', `u_Birthday` = " . $u_Birthday . ", `u_IdWalkin` = '" . $u_IdWalkin . "', ";
            $sql .= "`u_Address` = '" . $u_Address . "', `u_Road` = '" . $u_Road . "', `u_SubDistrict` = '" . $u_SubDistrict . "', `u_District` = '" . $u_District . "', `u_Province` = '" . $u_Province . "', ";
            $sql .= "`z_Id` = '" . $z_Id . "', `u_ShopName` = '" . $u_ShopName . "', `u_ProductName` = '" . $u_ProductName . "',`u_Username` = '" . $u_Username . "',`u_CardNumber`='" . $u_CardNumber . "', `u_Img` = '" . $u_Img . "' ";
            $sql .= "WHERE `u_Id` = '" . $u_Id . "';";
        }

        $sqlCheckUser = "SELECT * FROM kkmuni_street.tb_user where u_Username = '" . $u_Username . "' and u_Id != '" . $u_Id . "'; ";
        $resultUser = $conn->query($sqlCheckUser);

        $sqlCheckCardId = "SELECT * FROM kkmuni_street.tb_user where u_CardNumber = '" . $u_CardNumber . "' and u_Id != '" . $u_Id . "'; ";
        $resultCardId = $conn->query($sqlCheckCardId);

        $sqlCheckWalkIn  = "SELECT * FROM kkmuni_street.tb_user where u_IdWalkin = '" . $u_IdWalkin . "' and u_Id != '" . $u_Id . "' ;";
        $resultWalkIn  = $conn->query($sqlCheckWalkIn);

        if ($resultWalkIn->num_rows > 0 && $u_IdWalkin != "") {
            $resp->set_message("รหัส Walk-in ซ้ำ");
            $resp->set_status("Duplicate");
        } else if ($resultUser->num_rows > 0) {
            $resp->set_message("ชื่อผู้ใช้นี้ มีผู้ใช้งานแล้ว");
            $resp->set_status("Duplicate");
        } else if ($resultCardId->num_rows > 0) {
            $resp->set_message("รหัสประจำตัวประชาชนมีผู้ใช้งานแล้ว");
            $resp->set_status("Duplicate");
        } else {
            if ($conn->query($sql) === TRUE) {
                $resp->set_message("บันทึกข้อมูลสำเร็จ");
                $resp->set_status("success");

                $sqlSelect = "SELECT * FROM kkmuni_street.tb_user where `u_Id` = '" . $u_Id . "' ;";
                $result = $conn->query($sqlSelect);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $resp->data = $row;
                    $_SESSION["user"] = serialize($row);
                }
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
    $resp->set_status("fail");
}

echo json_encode($resp);
