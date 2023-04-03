<?php
// ================================================================= class response BEGIN
class Resp
{
    public $ref;
    public $data;
    public $message;
    public $status;
    public $status_code;
    public $date;

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

    function __construct()
    {
        $this->date = date("Y-m-d H:i:s");
        $this->ref = $this->uniqidReal(18);
        $this->status_code = null;
    }

    function set_message($message)
    {
        $this->message = $message;
    }
    function get_message()
    {
        return $this->message;
    }

    function set_status($status)
    {
        $this->status = $status;
    }
    function get_status()
    {
        return $this->status;
    }

    function set_status_code($status_code)
    {
        $this->status_code = $status_code;
    }
    function get_status_code()
    {
        return $this->status_code;
    }

    function set_data($data)
    {
        $this->data = $data;
    }
    function get_data()
    {
        return $this->data;
    }
}
// ================================================================= class response END

$servername = "";
$username = "";
$password = "";
$db = "";
$port = "3306";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $db, $port);
$connect_status = "";
$connect_message = "";
// Check connection
if (!$conn) {
    $connect_status = "failed";
    $connect_message = "Connection failed: " . mysqli_connect_error();
} else {
    $connect_status = "success";
    $connect_message = "Connection success";
    $conn->set_charset("utf8");
}

$resp = new Resp();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($connect_status == "success") {

        //$r_Id = $_POST["r_Id"];
        $tra_code = $_POST["tra_code"];
        $lock_name = $_POST["lock_name"];
        $wa_date = $_POST["wa_date"];
        $wa_code = $_POST["r_Id"];
        $Zone = $_POST["Zone"];
        $l_id = "";

        $sql = "SELECT * FROM";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        }

        $sql = "INSERT INTO `database_name`.`table_name` (`tra_code`, `lock_name`, `wa_date`, `wa_code`, `Zone`) VALUES ('".$tra_code."', '".$lock_name."', '".$wa_date."', '".$wa_code."', '".$Zone."');";

        if ($conn->query($sql) === TRUE) {
            $resp->set_message("บันทึกข้อมูลสำเร็จ");
            $resp->set_status("success");
        } else {
            $resp->set_message("ไม่สามารถบันทึกข้อมูลได้");
            $resp->set_status("fail");
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
