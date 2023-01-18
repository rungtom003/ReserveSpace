<?php
include "../class/resp.php";
include "connectdb.php";
// Start the session
session_start();

$resp = new Resp();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($connect_status == "success") {
        $username = $_POST["u_Username"];
        $password = $_POST["u_Password"];

        $sql = "SELECT * FROM reserve_space.tb_user where u_Username = '" . $username . "' and u_Approve = '1';";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if(hash_equals(hash("sha256",$password),$row["u_Password"]) == true)
            {
                $resp->set_status("success");
                $resp->data = $row;
                $_SESSION["user"] = serialize($row);
            }
            else
            {
                $resp->set_status("fail");
                $resp->set_message("รหัสผ่านไม่ถูกต้อง ");
            }
            
        }
        else{
            $resp->set_status("fail");
            $resp->set_message("ไม่มีชื่อผู้ใช้");
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
