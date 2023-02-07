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
        $uuid_order = uniqidReal();
        $user = unserialize($_SESSION["user"]);

        $z_Id = $user["z_Id"];
        $a_Id = $_POST["a_Id"];
        $area_static = $_POST["area_static"]; // 0 >> ล็อคประจำ  1 >> ล็อคไม่ประจำ

        $sql_select_area = "SELECT * FROM reserve_space.tb_area where (a_ReserveStatus = '1' OR a_ReserveStatus = '4') AND a_Id = '" . $a_Id . "'";
        $result_select_area = $conn->query($sql_select_area);
        if ($result_select_area->num_rows > 0) {
            //ถ้ามีจองอยู่เเล้ว
            $resp->set_message("มีคนจองพื้นที่ไปแล้ว");
            $resp->set_status("fail");
        } else {
            if ($z_Id == "2dacd150-9b8b-11ed-8054-0242ac110004" && $area_static == "0") //โซนอาหาร
            {
                $sql_select_reserve = "SELECT * FROM reserve_space.tb_reserve as a   INNER JOIN reserve_space.tb_area as b ON a.a_Id = b.a_Id  INNER JOIN reserve_space.tb_zone as c ON b.z_Id = c.z_Id  INNER JOIN reserve_space.tb_user as d ON d.u_Id = a.u_Id  WHERE c.z_Id = '2dacd150-9b8b-11ed-8054-0242ac110004' AND d.u_Id = '".$user["u_Id"]."' AND (a.r_Status = '1' OR a.r_Status = '2');";
                $result = $conn->query($sql_select_reserve);
                if ($result->num_rows > 0) {
                    $resp->set_message("ไม่สามารถจองพื้นที่เพิ่มได้เนื่องจาก 1 คน ต่อ 1 ล็อค ในโซนอาหาร");
                    $resp->set_status("fail");
                } else {
                    $sql_insert_TBreserve = "INSERT INTO `reserve_space`.`tb_reserve` (`r_Id`, `u_Id`, `a_Id`, `r_Status`) VALUES ('" . $uuid_order . "', '" . $user["u_Id"] . "', '" . $a_Id . "', '1');";
                    $sql_insert_TBreserve .= "UPDATE `reserve_space`.`tb_area` SET `a_ReserveStatus` = '1' WHERE (`a_Id` = '" . $a_Id . "');";
                    //สถานะ 1 จองสำเร็จ
                    if ($conn->multi_query($sql_insert_TBreserve) === TRUE) {
                        $resp->set_message("จองพื้นที่สำเร็จ.");
                        $resp->set_status("success");
                    } else {
                        $resp->set_message("มีข้อผิดพลาดเกิดขึ้น.");
                        $resp->set_status("fail");
                    }
                }
            } else {
                if ($area_static == "1") {
                    //ถ้าเป็นล็อคประจำ
                    $sql_select_static = "SELECT * FROM reserve_space.tb_reserve where u_Id = '" . $user["u_Id"] . "' AND a_Id = '" . $a_Id . "' AND r_Status = '2';";
                    $result_select_static = $conn->query($sql_select_static);
                    if ($result_select_static->num_rows > 0) {
                        //ถ้า user มีล็อคประจำอยู่เเล้ว
                        $resp->set_message("คุณมีล็อคนี้เป็นล็อคประจำอยู่เเล้วโปรดแจ้งเจ้าหน้าที่");
                        $resp->set_status("fail");
                    } else {
                        $sql_insert_TBreserve = "INSERT INTO `reserve_space`.`tb_reserve` (`r_Id`, `u_Id`, `a_Id`, `r_Status`) VALUES ('" . $uuid_order . "', '" . $user["u_Id"] . "', '" . $a_Id . "', '1');";
                        $sql_insert_TBreserve .= "UPDATE `reserve_space`.`tb_area` SET `a_ReserveStatus` = '4' WHERE (`a_Id` = '" . $a_Id . "');";
                        //สถานะ 3 จองล็อคประจำที่ว่างสำเร็จ
                        if ($conn->multi_query($sql_insert_TBreserve) === TRUE) {
                            $resp->set_message("จองพื้นที่สำเร็จ.");
                            $resp->set_status("success");
                        } else {
                            $resp->set_message("มีข้อผิดพลาดเกิดขึ้น.");
                            $resp->set_status("fail");
                        }
                    }
                } else {
                    $sql_insert_TBreserve = "INSERT INTO `reserve_space`.`tb_reserve` (`r_Id`, `u_Id`, `a_Id`, `r_Status`) VALUES ('" . $uuid_order . "', '" . $user["u_Id"] . "', '" . $a_Id . "', '1');";
                    $sql_insert_TBreserve .= "UPDATE `reserve_space`.`tb_area` SET `a_ReserveStatus` = '1' WHERE (`a_Id` = '" . $a_Id . "');";
                    //สถานะ 1 จองสำเร็จ
                    if ($conn->multi_query($sql_insert_TBreserve) === TRUE) {
                        $resp->set_message("จองพื้นที่สำเร็จ.");
                        $resp->set_status("success");
                    } else {
                        $resp->set_message("มีข้อผิดพลาดเกิดขึ้น.");
                        $resp->set_status("fail");
                    }
                }
            }
        }
        $conn->close();
    } else {
        $resp->set_message("connection database fail.");
        $resp->set_status("fail");
    }
} else {
    $resp->set_message("Request method fail.");
    $resp->set_status("");
}

echo json_encode($resp);
