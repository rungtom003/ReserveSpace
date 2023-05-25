<?php
$full_name = $_GET["fullname"]; //ชื่อ-สกุล
$tra_code=$_GET['tra_code'];	//เลขที่บัตรประชาชนผู้ประกอบการ
$phone = $_GET["phone"]; //เบอร์โทร
$product = $_GET["product"];//สินค้าที่ขาย
//$addres = $_GET["addres"];//ที่อยู่
$img = $_GET["img"];//ลิงค์รูป
$lock_name=$_GET['lock_name'];	//เลขที่ล็อคที่จอง
$wa_date=$_GET['wa_date'];	//วันเดือนปีที่ขาย
$wa_code=$_GET['wa_code'];	//รหัสwalkin
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test</title>
    <link href="./src/assets/bootstrap-5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="./src/css/main.style" rel="stylesheet">
    <link href="./src/css/sidebars.css">
  </head>
  
  <body>

    <h5><?=$full_name?></h5>
    <h5><?=$tra_code?></h5>
    <h5><?=$phone?></h5>
    <h5><?=$product?></h5>
    <img src="<?=$img?>">
    <h5><?=$lock_name?></h5>
    <h5><?=$wa_date?></h5>
    <h5><?=$wa_code?></h5>

    <script src="./src/assets/bootstrap-5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="./src/assets/jquery-3.6.3/jquery-3.6.3.min.js"></script>
    <script src="./src/js/main.js"></script>
    <script src="./src/js/sidebars.js"></script>
  </body>
</html>