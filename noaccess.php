<?php
date_default_timezone_set("Asia/Bangkok");
include("./layout/static_path.php");
    session_start();
    $user = (isset($_SESSION['user'])) ? unserialize($_SESSION['user']) : null;
    $startDate = (isset($_SESSION['os_StartDateTime'])) ? $_SESSION['os_StartDateTime'] : null;
$EndDate = (isset($_SESSION['os_EndDateTime'])) ? $_SESSION['os_EndDateTime'] : null;

    if($user == null){
        header('location: '.$host_path.'/login.php');
    }
    $titleHead = "";
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ไม่มีสิทธิ์เข้าถึง</title>
    <?php include("./layout/css.php"); ?>
</head>

<body style="font-family: kanit-Regular;">
    <?php include("./layout/head.php"); ?>
        <!-- start: Main -->
        <main class="bg-light">
        <div class="p-2">
        <?php include("./layout/navmain.php"); ?>
            <!-- start: Content -->
            <div class="py-1">
                <!-- start: Graph -->
                <div class="d-flex justify-content-center align-items-center" style="height: 80vh;">
                    <h1 class="text-danger" style="font-family: kanit-Regular;">ไม่มีสิทธิ์เข้าถึง</h1>
                </div>
                <!-- end: Graph -->
            </div>
            <!-- end: Content -->
        </div>
    </main>
    <!-- end: Main -->
    <?php include("./layout/script.php"); ?>
    <script>
    </script>
</body>

</html>