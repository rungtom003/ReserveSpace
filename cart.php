<?php
date_default_timezone_set("Asia/Bangkok");
include("./layout/static_path.php");
session_start();
$user = (isset($_SESSION['user'])) ? unserialize($_SESSION['user']) : null;
$startDate = (isset($_SESSION['os_StartDateTime'])) ? $_SESSION['os_StartDateTime'] : null;
$EndDate = (isset($_SESSION['os_EndDateTime'])) ? $_SESSION['os_EndDateTime'] : null;

if ($user == null) {
    header('location: '.$host_path.'/login.php');
}
$titleHead = "ตระกล้าการจองพื้นที่ขาย";
$active_index = "active";

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Index </title>
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
                <div class="card">
                    <div class="card-body">
                        <ul class="list-group" id="item-order">
                            <?php if ($count_order > 0) {
                                foreach ($order as $item_order) {
                            ?>
                                    <li class="list-group-item">
                                        <div class="d-flex flex-row" id="item-order-content">
                                            <div class="d-flex flex-column w-75">
                                                <input class="form-control" type="text" value="<?= $item_order["a_Id"] ?>" id="input-a_Id" hidden />
                                                <input class="form-control" type="text" value="<?= $item_order["pt_Id"] ?>" id="input-pt_Id" hidden />
                                                <span class="fw-bold">ชื่อ : <span class="fw-normal"><?= $item_order["u_Name"] ?></span></span>
                                                <span class="fw-bold">ล็อก : <span class="fw-normal"><?= $item_order["a_Name"] ?></span> </span>
                                                <span class="fw-bold">โซน : <span class="fw-normal"><?= $item_order["z_Name"] ?></span></span>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-end w-100">
                                                <button onclick="deleteSession(this)" class="btn btn-danger" id="delete-item" value="<?= $item_order["a_Id"] ?>">ลบ</button>
                                            </div>
                                        </div>

                                    </li>
                            <?php }
                            } ?>
                        </ul>
                        <div class="row my-3">
                            <div class="col-12">
                                <h4>การจัดเก็บรายได้/ล็อก</h4>
                                <ul>
                                    <li>ค่าเช่าแผงค้า และค่าบริการรักษาความสะอาด :
                                        <ul>
                                            <li>ทั่วไป 60 บาท (เก็บรวม 80)</li>
                                            <li>คัดสรร 20 (เก็บรวม 40)</li>
                                            <li>ค่าบริการรักษาความสะอาด 20 บาท</li>
                                        </ul>
                                    </li>
                                    <li>ค่าเครื่องใช้ไฟฟ้าเครื่องละ 20 บาท</li>
                                    <li>ค่าไฟฟ้าหลอดไฟละ 5 บาท</li>
                                    <li>ค่าบริหารจัดการโครงการถนนฅนเดินขอนแก่น 20 บาท</li>
                                </ul>
                            </div>
                        </div>
                        <?php if ($count_order > 0) { ?>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-primary" id="save-reserve" onclick="saveReserve()">จอง</button>
                            </div>
                        <?php } ?>
                    </div>
                </div>

            </div>
            <!-- end: Content -->
        </div>
    </main>
    <!-- end: Main -->
    <?php include("./layout/script.php"); ?>
    <script>
        const item_order_json = sessionStorage.getItem('order');
        let item_order_obj = [];
        if (item_order_json !== null) {
            item_order_obj = JSON.parse(item_order_json);
            let txt_content = "";
            $.each(item_order_obj, function(key, val) {
                txt_content += `<li class="list-group-item">${val.a_Name}</li>`;
            });
            $("#item-order").html(txt_content);
        }

        const saveReserve = () => {
            Swal.fire({
                title: 'ยืนยันการจอง?',
                text: "คุณต้องการยืนยันการจองหรือไม่",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่',
                cancelButtonText: 'ไม่'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?=$host_path?>/backend/Service/confirmOrder.php",
                        type: "POST",
                        dataType: "json",
                        success: function(res) {
                            console.log(res)
                            if (res.status === "success") {
                                Swal.fire({
                                    icon: 'success',
                                    title: res.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then((result) => {
                                    window.location.reload();
                                })
                            } else {
                                Swal.fire(
                                    'จองไม่สำเร็จ',
                                    `${res.message}`,
                                    'warning'
                                );
                            }

                        }
                    });

                }
            });
        }

        const deleteSession = (elm) => {
            const a_Id = elm.value;
            $.ajax({
                url: "<?=$host_path?>/backend/Service/removeCart_api.php",
                type: "POST",
                dataType: "json",
                data: {
                    a_Id: a_Id
                },
                success: function(res) {
                    window.location.reload();
                }
            });
        }
    </script>
</body>

</html>