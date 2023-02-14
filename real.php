<?php
include("./layout/static_path.php");
session_start();
$user = (isset($_SESSION['user'])) ? unserialize($_SESSION['user']) : null;
if ($user == null) {
    header('location: '.$host_path.'/login.php');
}
$titleHead = "รูปพื้นที่จริง";
$active_real = "active";

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $titleHead ?></title>
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
                            <?php
                            $fileList = glob('./src/img/real/*.jpg');
                            foreach ($fileList as $filename) {
                                if (is_file($filename)) {
                                    //echo $filename, '<br>';
                            ?>
                            <div class="col-lg-3 my-1"><img class="img-thumbnail" src="<?=$filename?>" ></div>
                            <?php }} ?>
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