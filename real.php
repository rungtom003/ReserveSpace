<?php
session_start();
$user = (isset($_SESSION['user'])) ? unserialize($_SESSION['user']) : null;
if ($user == null) {
    header('location: /ReserveSpace/login.php');
}
$titleHead = "รูปพื้นที่จริง";
$active_index = "active";
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Index</title>
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
                <div class="card">
                    <div class="card-body">
                        <div class="row" id="images" data-masonry='{"percentPosition": true }'>
                            <div class="col-lg-3 my-1"><img  class="img-thumbnail" src="./src/img/real/tibet-1.jpg" alt="Picture 1"></div>
                            <div class="col-lg-3 my-1"><img  class="img-thumbnail" src="./src/img/real/tibet-2.jpg" alt="Picture 2"></div>
                            <div class="col-lg-3 my-1"><img  class="img-thumbnail" src="./src/img/real/tibet-3.jpg" alt="Picture 3"></div>
                            <div class="col-lg-3 my-1"><img  class="img-thumbnail" src="./src/img/real/tibet-4.jpg" alt="Picture 4"></div>
                            <div class="col-lg-3 my-1"><img  class="img-thumbnail" src="./src/img/real/tibet-5.jpg" alt="Picture 5"></div>
                            <div class="col-lg-3 my-1"><img  class="img-thumbnail" src="./src/img/real/tibet-6.jpg" alt="Picture 6"></div>
                            <div class="col-lg-3 my-1"><img  class="img-thumbnail" src="./src/img/real/tibet-7.jpg" alt="Picture 7"></div>
                            <div class="col-lg-3 my-1"><img  class="img-thumbnail" src="./src/img/real/tibet-8.jpg" alt="Picture 8"></div>
                            <div class="col-lg-3 my-1"><img  class="img-thumbnail" src="./src/img/real/tibet-9.jpg" alt="Picture 9"></div>
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
        const viewer = new Viewer(document.getElementById('images'));
    </script>
</body>

</html>