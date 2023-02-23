<?php
date_default_timezone_set("Asia/Bangkok");
include("./layout/static_path.php");
session_start();
$user = (isset($_SESSION['user'])) ? unserialize($_SESSION['user']) : null;
$startDate = (isset($_SESSION['os_StartDateTime'])) ? $_SESSION['os_StartDateTime'] : null;
$EndDate = (isset($_SESSION['os_EndDateTime'])) ? $_SESSION['os_EndDateTime'] : null;

// Get the current date and time
//$current_datetime = new DateTime();

//echo $current_datetime->format("Y-m-d H:i:s");

if ($user == null) {
    header('location: ' . $host_path . '/login.php');
}else {
    if ($startDate != null && $EndDate != null && $user["ur_Id"] != "R002") {

        $StartTimestamp = strtotime(date('Y-m-d H:i:s', strtotime($startDate)));
        $EndTimestamp = strtotime(date('Y-m-d H:i:s', strtotime($EndDate)));
        $currentTimestamp = strtotime(date('Y-m-d H:i:s'));

        // Check if the current timestamp is greater than or equal to the set timestamp
        if ($currentTimestamp > $StartTimestamp) {
            header('location: ' . $host_path . '/index.php');
        }

        if($currentTimestamp > $EndTimestamp)
        {
            header('location: ' . $host_path . '/close_system.php');
        }
    }
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
            <h1>ระบบจะเปิดในเวลา</h1>
        </div>
        <div class="d-flex flex-row" id="countdow">
            <h1 id="countdow_time"></h1>
        </div>

    </div>
    <?php include("./layout/script.php"); ?>
    <script>
        // // Set the date and time for the countdown
        // var countDownDate = new Date().getTime();

        // // Update the countdown every second
        // var x = setInterval(function() {

        //     // Get the current date and time
        //     let now = new Date().getTime();

        //     // Calculate the time remaining between now and the countdown date
        //     var distance = countDownDate - now;

        //     // Calculate days, hours, minutes, and seconds remaining
        //     var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        //     var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        //     var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        //     var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        //     document.getElementById("countdow_time").innerHTML = `${days} วัน : ${hours} ชั่วโมง : ${minutes} นาที : ${seconds} วินาที`;

        //     // If the countdown is finished, display a message
        //     if (distance < 0) {
        //         clearInterval(x);
        //         window.location = "/index.php";
        //     }
        // }, 1000);
        document.getElementById("countdow_time").innerHTML = `${moment("<?=$_SESSION["os_StartDateTime"]?>").format('DD/MM/YYYY HH:mm:ss')}`;
    </script>
</body>

</html>