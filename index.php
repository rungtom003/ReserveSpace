<?php
session_start();
$user = (isset($_SESSION['user'])) ? unserialize($_SESSION['user']) : null;
if ($user == null) {
    header('location: /ReserveSpace/login.php');
}

$titleHead = "จองพื้นที่ขาย";
$active_index = "active";
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $titleHead ?></title>
    <?php include("./layout/css.php"); ?>
    <style>
        div.reserve-box-green {
            width: 80px;
            height: 80px;
            background: #229954;
            border-radius: 10px;
            margin: 5px;
            cursor: pointer;
            font-family: kanit-Regular;
            transition: background-color 0.5s
        }

        div.reserve-box-green:hover {
            background-color: #52BE80;
        }


        div.reserve-box-red {
            width: 80px;
            height: 80px;
            background: #CB4335;
            border-radius: 10px;
            margin: 5px;
            cursor: pointer;
            font-family: kanit-Regular;
            transition: background-color 0.5s
        }

        div.reserve-box-red:hover {
            background-color: #EC7063;
        }
    </style>
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
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-end">
                            <div id="img-content" class="d-flex flex-column justify-content-center align-items-center">
                                <img id="image" src="./src/img/tibet-1.jpg" alt="Cuo Na Lake" style="width: 80px;">
                                <a href="/ReserveSpace/real.php" style="font-family: kanit-Regular;">ดูพื้นที่จริง</a>
                            </div>

                            <div class="d-flex justify-content-center align-items-center reserve-box-green">
                                <span class="text-light">ว่าง</span>
                            </div>
                            <div class="d-flex justify-content-center align-items-center reserve-box-red">
                                <span class="text-light">จองเเล้ว</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card my-1">
                    <div class="card-body">
                        <div class="d-flex align-content-start flex-wrap" id="reserve-content">
                            <div class="d-flex justify-content-center align-items-center reserve-box-green">
                                <span class="text-light">01</span>
                            </div>
                            <div class="d-flex justify-content-center align-items-center reserve-box-red" data-bs-toggle="modal" data-bs-target="#reserve-detail-modal">
                                <span class="text-light">02</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end: Graph -->
            </div>
            <!-- end: Content -->
        </div>
    </main>
    <!-- end: Main -->

    <!-- Modal -->
    <div class="modal fade" id="reserve-detail-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="reserve-detail-modal-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="reserve-detail-modal-label">รายละเอียดการจอง</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <?php if ($user["ur_Id"] == "R002") { ?>
                        <button type="button" class="btn btn-primary">เพิ่มเติม</button>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <?php include("./layout/script.php"); ?>
    <script>
        const viewer = new Viewer(document.getElementById('image'));
    </script>
</body>

</html>