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
            <h1>ระบบกำลังจะเปิดใน</h1>
        </div>
        <div class="d-flex flex-row" id="countdow">
            <h1 id="countdow_time"></h1>
        </div>

    </div>
    <?php include("./layout/script.php"); ?>
    <script>
        // Set the date and time for the countdown
        var countDownDate = new Date("<?=$_SESSION["os_StartDateTime"]?>").getTime();

        // Update the countdown every second
        var x = setInterval(function() {

            // Get the current date and time
            var now = new Date().getTime();

            // Calculate the time remaining between now and the countdown date
            var distance = countDownDate - now;

            // Calculate days, hours, minutes, and seconds remaining
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("countdow_time").innerHTML = `${days} วัน : ${hours} ชั่วโมง : ${minutes} นาที : ${seconds} วินาที`;

            // If the countdown is finished, display a message
            if (distance < 0) {
                clearInterval(x);
                window.location = "<?=$host_path?>/index.php";
            }
        }, 1000);
    </script>
</body>

</html>