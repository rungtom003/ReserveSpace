<?php
date_default_timezone_set("Asia/Bangkok");
include("./layout/static_path.php");
session_start();
$user = (isset($_SESSION['user'])) ? unserialize($_SESSION['user']) : null;
$startDate = (isset($_SESSION['os_StartDateTime'])) ? $_SESSION['os_StartDateTime'] : null;
$EndDate = (isset($_SESSION['os_EndDateTime'])) ? $_SESSION['os_EndDateTime'] : null;

if ($user == null) {
    header('location: '.$host_path.'/login.php');
}else {
    if ($startDate != null && $EndDate != null && $user["ur_Id"] != "R002") {

        $StartTimestamp = strtotime(date('Y-m-d H:i:s', strtotime($startDate)));
        $EndTimestamp = strtotime(date('Y-m-d H:i:s', strtotime($EndDate)));
        $currentTimestamp = strtotime(date('Y-m-d H:i:s'));

        // Check if the current timestamp is greater than or equal to the set timestamp
        if ($currentTimestamp < $StartTimestamp) {
            header('location: ' . $host_path . '/countdow_time.php');
        }

        if($currentTimestamp > $EndTimestamp)
        {
            header('location: ' . $host_path . '/close_system.php');
        }
    }
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