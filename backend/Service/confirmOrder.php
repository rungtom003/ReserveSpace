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
        $dataArea = array();

        $uuid_order = uniqidReal();
        $user = unserialize($_SESSION["user"]);
        $order = unserialize($_SESSION["order"]);

        $z_Id = $_POST["z_Id"];

        if($z_Id == "2dacd150-9b8b-11ed-8054-0242ac110004") //โซนอาหาร
        {
            
        }

        $count_loop = 0;
        $count_order = count($order);
        $sql_concat = "";
        foreach ($order as $item) {
            $count_loop++;
            if ($count_loop == $count_order) {
                $sql_concat .= "a_Id = '" . $item["a_Id"] . "'";
            } else {
                $sql_concat .= "a_Id = '" . $item["a_Id"] . "' or ";
            }
        }

        $sql_select = "SELECT * FROM reserve_space.tb_area where (a_ReserveStatus != '0') and (".$sql_concat.");";
        $result = $conn->query($sql_select);
        if ($result->num_rows > 0) {
            $messageFail = "";
            while($row = $result->fetch_assoc()) {
                array_push($dataArea,$row);
                $messageFail .= " ".$row["a_Name"]."";
            }
            unset($_SESSION["order"]);
            $resp->set_message("พื้นที่ ".$messageFail." จองไปเเล้ว");
            $resp->set_status("fail");
            $resp->data = $dataArea;
        } else {
            $sql = "INSERT INTO `reserve_space`.`tb_reserve` (`r_Id`, `u_Id`) VALUES ('" . $uuid_order . "', '" . $user["u_Id"] . "');";

            foreach ($order as $item) {
                $sql .= "INSERT INTO `reserve_space`.`tb_reserveDetail` (`r_Id`, `pt_Id`, `a_Id`) VALUES ('" . $uuid_order . "', '" . $item["pt_Id"] . "', '" . $item["a_Id"] . "');";
                $sql .= "UPDATE `reserve_space`.`tb_area` SET `a_ReserveStatus` = '2' WHERE (`a_Id` = '" . $item["a_Id"] . "');";
            }

            if ($conn->multi_query($sql) === TRUE) {
                unset($_SESSION["order"]);
                $resp->set_message("จองพื้นที่สำเร็จ.");
                $resp->set_status("success");
            } else {
                $resp->set_message("มีข้อผิดพลาดเกิดขึ้น.");
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
    $resp->set_status("");
}

echo json_encode($resp);
