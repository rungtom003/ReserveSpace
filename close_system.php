<?php
date_default_timezone_set("Asia/Bangkok");
include("./layout/static_path.php");
session_start();
$user = (isset($_SESSION['user'])) ? unserialize($_SESSION['user']) : null;
$startDate = (isset($_SESSION['os_StartDateTime'])) ? $_SESSION['os_StartDateTime'] : null;
$EndDate = (isset($_SESSION['os_EndDateTime'])) ? $_SESSION['os_EndDateTime'] : null;

if ($user == null) {
    header('location: ' . $host_path . '/login.php');
}

if ($user["ur_Id"] == "R002") {
    header('location: ' . $host_path . '/dashboard.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include("./layout/css.php"); ?>
    <title>ระบบปิดให้บริการ</title>
</head>

<body style="font-family: kanit-Regular;">
    <div class="text-light d-flex flex-column justify-content-center align-items-center vh-100 vw-100 bg-dark">
        <div>
            <h1>ระบบปิดให้บริการ</h1>
        </div>

    </div>
    <?php include("./layout/script.php"); ?>
    <script>
    </script>
</body>

</html>