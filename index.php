<?php
date_default_timezone_set("Asia/Bangkok");
include("./layout/static_path.php");
session_start();
$user = (isset($_SESSION['user'])) ? unserialize($_SESSION['user']) : null;
$startDate = (isset($_SESSION['os_StartDateTime'])) ? $_SESSION['os_StartDateTime'] : null;
$EndDate = (isset($_SESSION['os_EndDateTime'])) ? $_SESSION['os_EndDateTime'] : null;

if ($user == null) {
    header('location: ' . $host_path . '/login.php');
} else {
    // if ($startDate != null && $EndDate != null && $user["ur_Id"] != "R002") {

    //     $StartTimestamp = strtotime(date('Y-m-d H:i:s', strtotime($startDate)));
    //     $EndTimestamp = strtotime(date('Y-m-d H:i:s', strtotime($EndDate)));
    //     $currentTimestamp = strtotime(date('Y-m-d H:i:s'));

    //     // Check if the current timestamp is greater than or equal to the set timestamp
    //     if ($currentTimestamp < $StartTimestamp) {
    //         header('location: ' . $host_path . '/countdow_time.php');
    //     }

    //     if ($currentTimestamp > $EndTimestamp) {
    //         header('location: ' . $host_path . '/close_system.php');
    //     }
    // }
}

if ($user["ur_Id"] == "R002") {
    header('location: ' . $host_path . '/dashboard.php');
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
            <div class="py-1" style="font-family: kanit-Regular;">
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
                    </div>
                </div>
                <?php
                if ($startDate != null && $EndDate != null && $user["ur_Id"] != "R002") {

                    $StartTimestamp = strtotime(date('Y-m-d H:i:s', strtotime($startDate)));
                    $EndTimestamp = strtotime(date('Y-m-d H:i:s', strtotime($EndDate)));
                    $currentTimestamp = strtotime(date('Y-m-d H:i:s'));

                    // Check if the current timestamp is greater than or equal to the set timestamp
                    if ($currentTimestamp < $StartTimestamp) {
                ?>
                        <div class="card my-1">
                            <div class="card-body">
                                <div class="d-flex justify-content-center flex-wrap" id="">
                                    <h1>ระบบจะเปิดให้บริการในเวลา <?=date_format(date_create($startDate),"d/m/Y H:i:s")?></h1>
                                </div>
                            </div>
                        </div>
                    <?php
                    } else if ($currentTimestamp > $EndTimestamp) {
                    ?>
                        <div class="card my-1">
                            <div class="card-body">
                                <div class="d-flex justify-content-center flex-wrap" id="">
                                    <h1>ระบบปิดให้บริการ</h1>
                                </div>
                            </div>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="card my-1">
                            <div class="card-body">
                                <div class="d-flex justify-content-center flex-wrap" id="reserve-content">
                                </div>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
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
                    <div id="modal-body-load" class="d-flex justify-content-center"></div>
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
                        <!-- <div class="row g-2 p-2">
                            <div class="col-md">
                                <label class="form-label">เลขบัตรประจำตัวประชาชน</label>
                                <input type="text" class="form-control" placeholder="" id="u_CardNumber" value="" readonly>

                            </div>
                            <div class="col-md">
                                <label class="form-label">วัน/เดือน/ปีเกิด</label>
                                <input type="date" class="form-control" placeholder="" id="u_Birthday" value="" readonly>

                            </div>
                        </div> -->

                        <!-- <div class="row g-2 p-2">
                            <div class="col-md">
                                <div class="col-md">
                                    <label class="form-label">บ้านเลขที่/หมู่</label>
                                    <input type="text" class="form-control" placeholder="" id="u_Address" value="" readonly>

                                </div>
                            </div>
                            <div class="col-md">
                                <div class="col-md">
                                    <label class="form-label">ถนน</label>
                                    <input type="text" class="form-control" placeholder="" id="u_Road" value="" readonly>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="col-md">
                                    <label class="form-label">ตำบล</label>
                                    <input type="text" class="form-control" placeholder="" id="u_SubDistrict" value="" readonly>

                                </div>
                            </div>

                        </div> -->
                        <!-- <div class="row g-2 p-2">
                            <div class="col-md">
                                <div class="col-md">
                                    <label class="form-label">อำเภอ</label>
                                    <input type="text" class="form-control" placeholder="" id="u_District" value="" readonly>

                                </div>
                            </div>
                            <div class="col-md">
                                <div class="col-md">
                                    <label class="form-label">จังหวัด</label>
                                    <input type="text" class="form-control" placeholder="" id="u_Province" value="" readonly>

                                </div>
                            </div>
                            <div class="col-md">
                                <div class="col-md">
                                    <label class="form-label">เบอร์โทรศัพท์</label>
                                    <input type="text" class="form-control" placeholder="" id="u_Phone" value="" readonly>

                                </div>
                            </div>
                        </div> -->
                    </div>
                    <div class="modal-footer">
                        <div id="btn-loadding" hidden>
                            <button class="btn btn-primary" type="button" disabled>
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Loading...
                            </button>
                        </div>
                        <div id="btn-unloadding">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                            <button type="submit" class="btn btn-primary" id="add-cart">จอง</button>
                        </div>
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
                    z_Id: z_Id,
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
                            txt_content += `<div class="d-flex justify-content-center align-items-center reserve-box-green" data-bs-toggle="modal" data-bs-target="#reserve-modal" data-bs-area_static="0" data-bs-whatever='${JSON.stringify(val)}'>
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

        const reserve_modal = document.getElementById('reserve-modal')
        reserve_modal.addEventListener('show.bs.modal', event => {
            // Button that triggered the modal
            const button = event.relatedTarget;
            // Extract info from data-bs-* attributes
            const recipient = button.getAttribute('data-bs-whatever');
            const data = JSON.parse(recipient);
            const area_static = button.getAttribute('data-bs-area_static');
            const modalTitle = reserve_modal.querySelector('.modal-title');

            modalTitle.textContent = `ล็อก ${data.a_Name} # ${data.z_Name}`;
            $("#a_Id").val(data.a_Id);
            $("#area_static").val(area_static);
            $("#a_Name-reserve-modal").val(data.a_Name);
            $("#z_Name-reserve-modal").val(data.z_Name);
        });

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
                beforeSend: function() {
                    let txtHTML = `<div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                    </div>`;
                    $("#modal-body-load").html(txtHTML);
                },
                success: function(res) {
                    //console.log(res)
                    const data_arr = res.data;
                    if (res.status === "seccess") {
                        $("#modal-body-load").html("");
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

        document.getElementById("add-cart").addEventListener('click', (e) => {
            e.preventDefault();
            const data = {
                a_Id: $("#a_Id").val(),
                area_static: $("#area_static").val()
            }
            $.ajax({
                url: "<?= $host_path ?>/backend/Service/confirmOrder.php",
                type: "POST",
                dataType: "json",
                data: data,
                beforeSend: function() {
                    $("#btn-loadding").prop("hidden", false);
                    $("#btn-unloadding").prop("hidden", true);
                    $(".btn-close").prop("hidden", true);
                },
                success: function(res) {
                    $("#btn-loadding").prop("hidden", true);
                    $("#btn-unloadding").prop("hidden", false);
                    $(".btn-close").prop("hidden", false);
                    if (res.status === "success") {
                        // Swal.fire({
                        //     icon: 'success',
                        //     title: res.message,
                        //     showConfirmButton: false,
                        //     timer: 1500
                        // }).then((result) => {
                        //     // $('#reserve-modal').modal('hide');
                        //     // const myModalEl = document.getElementById('reserve-modal')
                        //     // myModalEl.addEventListener('hidden.bs.modal', event => {
                        //     //     window.location.reload();
                        //     // });
                        //     window.location.reload();
                        // });
                        Swal.fire({
                            icon: 'success',
                            title: 'สำเร็จ',
                            text: res.message,
                            didClose: () => {
                                window.location.reload();
                            }
                        });
                    } else {
                        // Swal.fire({
                        //     icon: 'warning',
                        //     title: 'เเจ้งเตือน',
                        //     text: res.message
                        // });
                        Swal.fire({
                            icon: 'warning',
                            //title: 'ข',
                            text: res.message,
                            didClose: () => {
                                window.location.reload();
                            }
                        });
                    }
                }
            });
        });
    </script>
</body>

</html>