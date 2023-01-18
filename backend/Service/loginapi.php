<?php
include "../class/resp.php";
include "connectdb.php";

$resp = new Resp();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($connect_status == "success") {
        $username = $_POST["u_Username"];
        $password = $_POST["u_Password"];

        $sql = "SELECT * FROM reserve_space.tb_user where u_Username = '" . $username . "' and u_Password = '" . $password . "';";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $resp->data = $row;
        }
        else{
            $resp->set_message("not found");

        }
        $resp->set_status("success");
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
