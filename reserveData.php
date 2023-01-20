<?php
session_start();
$user = (isset($_SESSION['user'])) ? unserialize($_SESSION['user']) : null;
if ($user == null) {
    header('location: /ReserveSpace/login.php');
}
$titleHead = "ข้อมูลการจอง";
$active_reserveData = "active";
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ข้อมูลการจอง</title>
    <?php include("./layout/css.php"); ?>
</head>

<body style="font-family: kanit-Regular;">
    <?php include("./layout/head.php"); ?>
    <!-- start: Main -->
    <main class="bg-light">
        <div class="p-2">
            <?php include("./layout/navmain.php"); ?>
            <!-- start: Content -->
            <div class="py-1" style="font-family: kanit-Regular;">
                <div class="my-2 d-flex flex-column align-items-center">
                    <div class="card text-bg-success mb-3 w-75">
                        <div class="card-body">
                            <h5 class="card-title text-center">หมายเลขพื้นที่ 01</h5>
                            <hr class="border border-primary border-3 opacity-75">
                            <ul class="list-group">
                                <li class="list-group-item"><span>ชื่อผู้จอง : สมชาย วงดี</span></li>
                                <li class="list-group-item"><span>รายละเอียดการจอง : สมชาย วงดี</span></li>
                                <li class="list-group-item"><span>หมายเหตุ : สมชาย วงดี</span></li>
                                <li class="list-group-item"><span>วันเวลาจอง : 2023-01-01 12:00:00</span></li>
                                <li class="list-group-item"><span>สถานะการจอง : <span class="text-success">สำเร็จ</span></span></li>
                            </ul>
                        </div>
                    </div>

                    <div class="card text-bg-warning mb-3 w-75">
                        <div class="card-body">
                            <h5 class="card-title text-center">หมายเลขพื้นที่ 02</h5>
                            <hr class="border border-primary border-3 opacity-75">
                            <ul class="list-group">
                                <li class="list-group-item"><span>ชื่อผู้จอง : สมชาย วงดี</span></li>
                                <li class="list-group-item"><span>รายละเอียดการจอง : สมชาย วงดี</span></li>
                                <li class="list-group-item"><span>หมายเหตุ : สมชาย วงดี</span></li>
                                <li class="list-group-item"><span>วันเวลาจอง : 2023-01-01 12:00:00</span></li>
                                <li class="list-group-item"><span>สถานะการจอง : <span class="text-warning">รอดำเนินการ</span></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
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