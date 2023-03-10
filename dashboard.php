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

$titleHead = "หน้าแรก";
$active_Dashboard = "active";

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

        div.reserve-box-yellow {
            width: 80px;
            height: 80px;
            background: #F1C40F;
            border-radius: 10px;
            margin: 5px;
            cursor: pointer;
            font-family: kanit-Regular;
            transition: background-color 0.5s
        }

        div.reserve-box-yellow:hover {
            background-color: #F7DC6F;
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

        div.reserve-box-primary {
            width: 80px;
            height: 80px;
            background: #3498DB;
            border-radius: 10px;
            margin: 5px;
            cursor: pointer;
            font-family: kanit-Regular;
            transition: background-color 0.5s
        }

        div.reserve-box-primary:hover {
            background-color: #85C1E9;
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
                            <!-- <div id="img-content" class="d-flex flex-column justify-content-center align-items-center">
                                <img id="image" src="./src/img/tibet-1.jpg" alt="Cuo Na Lake" style="width: 80px;">
                                <a href="/ReserveSpace/real.php" style="font-family: kanit-Regular;">ดูพื้นที่จริง</a>
                            </div> -->


                            <div class="d-flex justify-content-center align-items-center reserve-box-green">
                                <span class="text-light text-center">ว่าง</span>
                            </div>
                            <div class="d-flex justify-content-center align-items-center reserve-box-red">
                                <span class="text-light text-center">จองเเล้ว</span>
                            </div>
                            <!-- <div class="d-flex justify-content-center align-items-center reserve-box-yellow">
                                <span class="text-light text-center">ปิดล็อก</span>
                            </div> -->
                            <!-- <div class="d-flex justify-content-center align-items-center reserve-box-primary">
                                <span class="text-light text-center">ล็อกประจำ</span>
                            </div> -->
                        </div>
                        <div class="d-flex my-3">
                            <input class="form-control text-center" type="text" placeholder="ค้นหา" id="input_find" value="">
                            <button class="btn btn-primary mx-3" onclick="fcFind()">ค้นหา</button>
                        </div>

                        <select class="form-select" id="select-zone">
                        </select>

                    </div>
                </div>
                <div class="card my-1">
                    <div class="card-body">
                        <div class="d-flex justify-content-center flex-wrap" id="reserve-content">


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
                    <ul id="ul-detail-content-1">
                    </ul>

                    <ul id="ul-detail-content-2">
                    </ul>
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

    <!-- Modal จอง -->
    <div class="modal fade" id="reserve-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="reserve-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form class="needs-validation" novalidate>
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="reserve-modal-label">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h4>รายละเอียดการจอง</h4>
                        <div class="row g-2 p-2">
                            <input type="text" class="form-control" placeholder="ล็อก" id="a_Id" readonly hidden>
                            <input type="text" class="form-control" placeholder="ล็อกประจำ" id="area_static" readonly hidden>
                            <div class="col-md">
                                <label class="form-label">ล็อก</label>
                                <input type="text" class="form-control" placeholder="ล็อก" id="a_Name-reserve-modal" readonly>
                                <!-- <div class="form-text">Enter your Full name</div> -->
                            </div>
                            <div class="col-md">
                                <label class="form-label">โซน</label>
                                <input type="text" class="form-control" placeholder="โซน" id="z_Name-reserve-modal" readonly>
                                <!-- <div  class="form-text">Enter your Last name</div> -->
                            </div>
                        </div>
                        <div class="row g-2 p-2">
                            <input type="text" class="form-control" placeholder="ล็อก" id="a_Id" readonly hidden>
                            <div class="col-md">
                                <label class="form-label">ชื่อร้าน</label>
                                <input type="text" class="form-control" placeholder="ชื่อร้าน" id="u_ShopName" value="<?= $user["u_ShopName"] ?>" readonly>
                                <!-- <div class="form-text">Enter your Full name</div> -->
                            </div>
                            <div class="col-md">
                                <label class="form-label">สินค้า</label>
                                <input type="text" class="form-control" placeholder="สินค้า" id="u_ProductName" value="<?= $user["u_ProductName"] ?>" readonly>
                                <!-- <div  class="form-text">Enter your Last name</div> -->
                            </div>
                        </div>

                        <div class="row g-2 p-2">
                            <div class="col-md-2">
                                <label class="form-label">คำนำหน้า</label>
                                <select class="form-select" aria-label="Default select example" id="Prefix" disabled>
                                    <option selected value="<?= $user["u_Prefix"] ?>"><?= $user["u_Prefix"] ?></option>
                                    <option value="นาย">นาย</option>
                                    <option value="นาง">นาง</option>
                                    <option value="นางสาว">นางสาว</option>
                                </select>
                                <!-- <div class="form-text">Enter your Full name</div> -->
                            </div>
                            <div class="col-md">
                                <label for="u_FullName" class="form-label">ชื่อ</label>
                                <input type="text" class="form-control" placeholder="Full name" id="u_FullName" value="<?= $user["u_FirstName"] ?>" readonly>

                            </div>
                            <div class="col-md">
                                <label class="form-label">นามสกุล</label>
                                <input type="text" class="form-control" placeholder="Last name" id="u_Last" value="<?= $user["u_LastName"] ?>" readonly>

                            </div>
                        </div>
                        <div class="row g-2 p-2">
                            <div class="col-md">
                                <label class="form-label">เลขบัตรประจำตัวประชาชน</label>
                                <input type="text" class="form-control" placeholder="" id="u_CardNumber" value="<?= $user["u_CardNumber"] ?>" readonly>

                            </div>
                            <div class="col-md">
                                <label class="form-label">วัน/เดือน/ปีเกิด</label>
                                <input type="date" class="form-control" placeholder="" id="u_Birthday" value="<?= $user["u_Birthday"] ?>" readonly>

                            </div>
                        </div>

                        <div class="row g-2 p-2">
                            <div class="col-md">
                                <div class="col-md">
                                    <label class="form-label">บ้านเลขที่/หมู่</label>
                                    <input type="text" class="form-control" placeholder="" id="u_Address" value="<?= $user["u_Address"] ?>" readonly>

                                </div>
                            </div>
                            <div class="col-md">
                                <div class="col-md">
                                    <label class="form-label">ถนน</label>
                                    <input type="text" class="form-control" placeholder="" id="u_Road" value="<?= $user["u_Road"] ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="col-md">
                                    <label class="form-label">ตำบล</label>
                                    <input type="text" class="form-control" placeholder="" id="u_SubDistrict" value="<?= $user["u_SubDistrict"] ?>" readonly>

                                </div>
                            </div>

                        </div>
                        <div class="row g-2 p-2">
                            <div class="col-md">
                                <div class="col-md">
                                    <label class="form-label">อำเภอ</label>
                                    <input type="text" class="form-control" placeholder="" id="u_District" value="<?= $user["u_District"] ?>" readonly>

                                </div>
                            </div>
                            <div class="col-md">
                                <div class="col-md">
                                    <label class="form-label">จังหวัด</label>
                                    <input type="text" class="form-control" placeholder="" id="u_Province" value="<?= $user["u_Province"] ?>" readonly>

                                </div>
                            </div>
                            <div class="col-md">
                                <div class="col-md">
                                    <label class="form-label">เบอร์โทรศัพท์</label>
                                    <input type="text" class="form-control" placeholder="" id="u_Phone" value="<?= $user["u_Phone"] ?>" readonly>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-primary" id="add-cart">จอง</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <?php include("./layout/script.php"); ?>
    <script>
        const z_Id = "<?= $user["z_Id"] ?>";
        const btnfind = $("#input_find").val();

        const fcFind = () => {
            $.ajax({
                url: "<?= $host_path ?>/backend/Service/areaList_api.php",
                type: "POST",
                dataType: "json",
                data: {
                    z_Id: $("#select-zone").val(),
                    a_Name: $("#input_find").val()
                },
                beforeSend: function() {
                    let txtHTML = `<div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                    </div>`;
                    $("#reserve-content").html(txtHTML);
                },
                success: function(res) {
                    const data = res.data;
                    let txt_content = "";
                    $.each(data, function(key, val) {
                        if (val.a_ReserveStatus === "0") {
                            txt_content += `<div class="d-flex justify-content-center align-items-center reserve-box-green">
                                                <span class="text-light">${val.a_Name}</span>
                                            </div>`;
                        } else if (val.a_ReserveStatus === "1") {
                            txt_content += `<div class="d-flex justify-content-center align-items-center reserve-box-red" data-bs-toggle="modal" data-bs-target="#reserve-detail-modal" data-bs-whatever='${val.a_Id}'>
                                                <span class="text-light">${val.a_Name}</span>
                                            </div>`;
                        } else if (val.a_ReserveStatus === "2") {
                            txt_content += `<div class="d-flex justify-content-center align-items-center reserve-box-red" data-bs-toggle="modal" data-bs-target="#reserve-detail-modal" data-bs-whatever='${val.a_Id}'>
                                                <span class="text-light">${val.a_Name}</span>
                                            </div>`;
                        } else if (val.a_ReserveStatus === "3") {
                            txt_content += `<div class="d-flex justify-content-center align-items-center reserve-box-green" data-bs-toggle="modal" data-bs-target="#reserve-modal" data-bs-area_static="1" data-bs-whatever='${JSON.stringify(val)}'>
                                                <span class="text-light">${val.a_Name}</span>
                                            </div>`;
                        } else if (val.a_ReserveStatus === "5") {
                            // txt_content += `<div class="d-flex justify-content-center align-items-center reserve-box-yellow">
                            //                     <span class="text-light">${val.a_Name}</span>
                            //                 </div>`;
                            txt_content += "";
                        } else {
                            txt_content += `<div class="d-flex justify-content-center align-items-center reserve-box-red" data-bs-toggle="modal" data-bs-target="#reserve-detail-modal" data-bs-whatever='${val.a_Id}'>
                                                <span class="text-light">${val.a_Name}</span>
                                            </div>`;
                        }
                    })
                    $("#reserve-content").html(txt_content);
                }
            });
        }
        fcFind();

        const reserve_modal_detail = document.getElementById('reserve-detail-modal')
        reserve_modal_detail.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const a_Id = button.getAttribute('data-bs-whatever');

            $.ajax({
                url: "<?= $host_path ?>/backend/Service/reserveFind.php",
                type: "POST",
                dataType: "json",
                data: {
                    a_Id: a_Id
                },
                success: function(res) {
                    //console.log(res)
                    const data_arr = res.data;
                    if (res.status === "seccess") {
                        let txtHTML = "";
                        let txtHTML2 = "";
                        $.each(data_arr, function(key, val) {
                            if (val.r_Status === "1") {
                                txtHTML += `<li class="fw-bold">ชื่อผู้จอง : <span class="fw-normal" id="u_Name">${val.u_FirstName} ${val.u_LastName}</span></li>
                                        <li class="fw-bold">ชื่อร้าน : <span class="fw-normal" id="u_ShopName">${val.u_ShopName}</span></li>
                                        <li class="fw-bold">ล็อก : <span class="fw-normal" id="a_Name">${val.a_Name}</span></li>
                                        <li class="fw-bold">โซน : <span class="fw-normal" id="z_Name">${val.z_Name}</span></li>
                                        <li class="fw-bold">สินค้าที่ขาย : <span class="fw-normal" id="u_ProductName">${val.u_ProductName}</span></li>`;
                            } else if (val.r_Status === "2") {
                                txtHTML2 += `<li class="fw-bold">เจ้าของล็อกประจำ : <span class="fw-normal" >${val.u_FirstName} ${val.u_LastName}</span></li>
                                        <li class="fw-bold">ชื่อร้าน : <span class="fw-normal" >${val.u_ShopName}</span></li>
                                        <li class="fw-bold">สินค้าที่ขาย : <span class="fw-normal" >${val.u_ProductName}</span></li>`;
                            } else {
                                txtHTML += "";
                            }
                        });
                        $("#ul-detail-content-1").html(txtHTML);
                        $("#ul-detail-content-2").html(txtHTML2);
                    }
                }
            });
        });
        reserve_modal_detail.addEventListener('hidden.bs.modal', event => {
            $("#u_Name").html("");
            $("#a_Name").html("");
            $("#z_Name").html("");
            $("#pt_Name").html("");
        });


        $(document).ready(function() {
            $.ajax({
                url: "<?= $host_path ?>/backend/Service/zone_api.php",
                dataType: "json",
                type: "POST",
                success: function(res) {
                    let option = '<option disabled selected value="">เลือกโซน</option>';
                    $.each(res.data, function(key, val) {
                        option += `<option value="${val.z_Id}">${val.z_Name}</option>`;
                    });
                    $("#select-zone").html(option);
                }
            });
        });

        $("#select-zone").change(function() {
            fcFind();
        });
    </script>
</body>

</html>