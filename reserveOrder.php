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
if ($user["ur_Id"] == "R001") {
    header('location: ' . $host_path . '/noaccess.php');
}
$titleHead = "รายการจอง";
$active_reserveOrder = "active";
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>รายการจอง</title>
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
                        <div class="d-flex flex-wrap">
                            <button class="btn btn-primary m-1" id="reset-all" onclick="resetAll()">รีเซ็ตการจองทั้งหมด</button>
                            <button class="btn btn-primary m-1" id="reset-static" onclick="resetStatic()">รีเซ็ตการจองล็อกประจำ</button>
                            <button class="btn btn-primary m-1" id="reset-non-static" onclick="resetNonStatic()">รีเซ็ตการจองล็อกไม่ประจำ</button>
                        </div>

                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <table id="table-Order" class="table table-striped w-100 text-nowrap"></table>
                    </div>
                </div>
            </div>
            <!-- end: Content -->
        </div>
    </main>
    <!-- end: Main -->
    <?php include("./layout/script.php"); ?>
    <script>
        const dt_table = $('#table-Order').DataTable({
            ajax: "<?= $host_path ?>/backend/Service/reserveList_api.php",
            //processing: true,
            //serverSide: true,
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'colvis'],
            responsive: true,
            language: {
                url: './src/assets/DataTables/LanguageTable/th.json'
            },
            order: [
                [1, 'asc']
            ],
            rowGroup: {
                dataSrc: 'z_Name'
            },
            initComplete: function() {
                $("#table-Order_filter").append(`<label id="select-group" class="my-2 w-100"></label>`);

                this.api().columns(1).every(function() {
                    var column = this;
                    var select = $('<select class="form-select form-select-sm w-50" aria-label="เลือกโซน" id="selectZone"><option value=""></option></select>').appendTo($("#select-group").empty()).on('change', function() {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                        column.search(val ? '^' + val + '$' : '', true, false).draw();
                    });

                    column.data().unique().sort().each(function(d, j) {
                        select.append('<option value="' + d + '">' + d + '</option>')
                    });
                })
                //$("#select-group").prepend(`<label for="selectZone" class="form-label">โซน : </label>`);
                $("#select-group").prepend(`โซน`);
            },
            columnDefs: [{
                    targets: 0,
                    title: "ล็อก",
                    data: "a_Name",
                },
                {
                    targets: 1,
                    title: "โซน",
                    data: "z_Name",

                },
                {
                    targets: 2,
                    title: "ชื่อร้าน",
                    data: "u_ShopName",
                },
                {
                    targets: 3,
                    title: "สินค้า",
                    data: "u_ProductName",
                },
                {
                    targets: 4,
                    title: "ชื่อ",
                    data: "u_FirstName",
                },
                {
                    targets: 5,
                    title: "สกุล",
                    data: "u_LastName",
                },
                {
                    targets: 6,
                    title: "เลขประจำตัวประชาชน",
                    data: "u_CardNumber",
                },
                {
                    targets: 7,
                    title: "เบอร์โทร",
                    data: "u_Phone",
                },
                {
                    targets: 8,
                    title: "วันที่จอง",
                    data: "r_DateTime",
                },
                {
                    targets: 9,
                    title: "สถานะ",
                    data: null,
                    defaultContent: "",
                    render: function(data, type, row, meta) {
                        let txtHTML = "";
                        if (row.r_Status === "0") {
                            txtHTML = "<span class='text-danger'>ยกเลิกการจอง</span>";
                        } else if (row.r_Status === "1" && row.a_ReserveStatus === "1") {
                            txtHTML = "<span class='text-success'>จองสำเร็จ</span>";
                        } else if (row.r_Status === "1" && row.a_ReserveStatus === "4") {
                            txtHTML = "<span class='text-success'>จองล็อกประจำสำเร็จ</span>";
                        } else if (row.r_Status === "2" && row.a_ReserveStatus === "2") {
                            txtHTML = "<span class='text-primary'>ล็อกประจำ</span>";
                        } else if (row.r_Status === "2" && row.a_ReserveStatus === "3") {
                            txtHTML = "<span class='text-danger'>ล็อกประจำ(ยกเลิกชั่วคราว)</span>";
                        } else if ((row.r_Status === "2" && row.a_ReserveStatus === "4") || (row.r_Status === "2" && row.a_ReserveStatus === "8")) {
                            txtHTML = `<span class='text-danger'>ล็อกประจำถูกจอง</span>`;
                        } else if ((row.r_Status === "9" && row.a_ReserveStatus === "9") || (row.r_Status === "8" && row.a_ReserveStatus === "8")) {
                            txtHTML = `<span class='text-warning'>รอชำระเงิน</span>`;
                        } else {
                            txtHTML = "";
                        }
                        return txtHTML;
                    }
                },
                {
                    targets: 10,
                    title: "#",
                    data: null,
                    defaultContent: "",
                    render: function(data, type, row, meta) {
                        const obj = {
                            r_Id: row.r_Id,
                            a_Id: row.a_Id
                        }
                        const obj_pay = {
                            u_CardNumber: row.u_CardNumber,
                            a_Name: row.a_Name
                        }
                        let txtHTML = "";
                        if (row.r_Status === "0") {
                            txtHTML = "";
                        } else if (row.r_Status === "1" && row.a_ReserveStatus === "1") {
                            txtHTML = `<div class="d-grid gap-2 d-md-block" >
                                                <button class="btn btn-danger" type="button" onclick="fcCancel(this)" value='${JSON.stringify(obj)}'>ยกเลิกการจอง</button>
                                                <button class="btn btn-primary" type="button" onclick="fcStaticArea(this)" value='${JSON.stringify(obj)}'>ให้สถานะล็อกประจำ</button>
                                            </div>`;
                        } else if (row.r_Status === "2" && row.a_ReserveStatus === "2") {
                            txtHTML = `<div class="d-grid gap-2 d-md-block" >
                                                <button class="btn btn-primary" type="button"  onclick="fcCancelTemporary(this)" value='${JSON.stringify(obj)}'>ยกเลิกช่วงคราว</button>
                                                <button class="btn btn-danger" type="button"  onclick="fcCancel(this)" value='${JSON.stringify(obj)}'>ยกเลิกการจอง</button>
                                            </div>`;
                        } else if (row.r_Status === "1" && row.a_ReserveStatus === "4") {
                            txtHTML = `<div class="d-grid gap-2 d-md-block" >
                                                <button class="btn btn-primary" type="button" onclick="fcReturn(this)" value='${JSON.stringify(obj)}'>คืนล็อกประจำ</button>
                                            </div>`;
                        } else if (row.r_Status === "2" && row.a_ReserveStatus === "3") {
                            txtHTML = `<div class="d-grid gap-2 d-md-block" >
                                                <button class="btn btn-primary" type="button" onclick="fcReturnNoReserve(this)" value='${JSON.stringify(obj)}'>คืนล็อกประจำ</button>
                                            </div>`;
                        } else if ((row.r_Status === "9" && row.a_ReserveStatus === "9")) {
                            txtHTML = `<div class="d-grid gap-2 d-md-block" >
                                                <button class="btn btn-danger" type="button" onclick="fcCancel(this)" value='${JSON.stringify(obj)}'>ยกเลิกการจอง</button>
                                                <button class="btn btn-primary" type="button" onclick="confirm_pay(this)" value='${JSON.stringify(obj_pay)}'>ชำระเงินแล้ว</button>
                                            </div>`;
                        } else if ((row.r_Status === "8" && row.a_ReserveStatus === "8")) {
                            txtHTML = `<div class="d-grid gap-2 d-md-block" >
                                                <button class="btn btn-danger" type="button" onclick="fcCancel_static(this)" value='${JSON.stringify(obj)}'>ยกเลิกการจอง</button>
                                                <button class="btn btn-primary" type="button" onclick="confirm_pay(this)" value='${JSON.stringify(obj_pay)}'>ชำระเงินแล้ว</button>
                                            </div>`;
                        } else {
                            txtHTML = "";
                        }
                        return txtHTML;
                    }
                }
            ]
        });

        const fcCancel = (elm) => {

            const obj_json = elm.value;
            const obj = JSON.parse(obj_json);

            let r_Id = obj.r_Id;
            let a_Id = obj.a_Id;

            Swal.fire({
                title: 'ยืนยันการยกเลิก?',
                text: "คุณต้องการยืนยันการยกเลิกหรือไม่",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่',
                cancelButtonText: 'ไม่'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= $host_path ?>/backend/Service/cancelReserve.php",
                        type: "POST",
                        data: {
                            r_Id: r_Id,
                            a_Id: a_Id
                        },
                        dataType: "json",
                        success: function(res) {
                            let message = res.message;
                            let status = res.status;

                            if (status == "success") {
                                Swal.fire({
                                    icon: 'success',
                                    title: message,
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then((result) => {
                                    dt_table.ajax.reload();
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'เเจ้งเตือน',
                                    text: message
                                })
                            }
                        }
                    });
                }
            });
        }

        const fcApprove = (elm) => {
            const obj_json = elm.value;
            const obj = JSON.parse(obj_json);

            let r_Id = obj.r_Id;
            let a_Id = obj.a_Id;

            Swal.fire({
                title: 'ยืนยันอนุมัติ?',
                text: "คุณต้องการยืนยันการอนุมัติหรือไม่",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่',
                cancelButtonText: 'ไม่'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= $host_path ?>/backend/Service/approveReserve_api.php",
                        type: "POST",
                        data: {
                            r_Id: r_Id,
                            a_Id: a_Id
                        },
                        dataType: "json",
                        success: function(res) {
                            let message = res.message;
                            let status = res.status;

                            if (status == "success") {
                                Swal.fire({
                                    icon: 'success',
                                    title: message,
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then((result) => {
                                    dt_table.ajax.reload();
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'เเจ้งเตือน',
                                    text: message
                                })
                            }
                        }
                    });
                }
            });
        }

        const fcCancelTemporary = (elm) => {
            const obj_json = elm.value;
            const obj = JSON.parse(obj_json);

            let r_Id = obj.r_Id;
            let a_Id = obj.a_Id;

            Swal.fire({
                title: 'ยืนยันการยกเลิกชั่วคราว?',
                text: "คุณต้องการยืนยันการยกเลิกชั่วคราวหรือไม่",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่',
                cancelButtonText: 'ไม่'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= $host_path ?>/backend/Service/CancelTemporary.php",
                        type: "POST",
                        data: {
                            r_Id: r_Id,
                            a_Id: a_Id
                        },
                        dataType: "json",
                        success: function(res) {
                            let message = res.message;
                            let status = res.status;

                            if (status == "success") {
                                Swal.fire({
                                    icon: 'success',
                                    title: message,
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then((result) => {
                                    dt_table.ajax.reload();
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'เเจ้งเตือน',
                                    text: message
                                })
                            }
                        }
                    });
                }
            });
        }

        const fcReturn = (elm) => {
            const obj_json = elm.value;
            const obj = JSON.parse(obj_json);

            let r_Id = obj.r_Id;
            let a_Id = obj.a_Id;

            Swal.fire({
                title: 'ยืนยันการคืนล็อก?',
                text: "คุณต้องการยืนยันการคืนล็อกหรือไม่",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่',
                cancelButtonText: 'ไม่'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= $host_path ?>/backend/Service/returnArea.php",
                        type: "POST",
                        data: {
                            r_Id: r_Id,
                            a_Id: a_Id
                        },
                        dataType: "json",
                        success: function(res) {
                            let message = res.message;
                            let status = res.status;

                            if (status == "success") {
                                Swal.fire({
                                    icon: 'success',
                                    title: message,
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then((result) => {
                                    dt_table.ajax.reload();
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'เเจ้งเตือน',
                                    text: message
                                })
                            }
                        }
                    });
                }
            });
        }

        const fcStaticArea = (elm) => {
            const obj_json = elm.value;
            const obj = JSON.parse(obj_json);

            let r_Id = obj.r_Id;
            let a_Id = obj.a_Id;

            Swal.fire({
                title: 'ยืนยันการให้สถานะล็อกประจำ?',
                text: "คุณต้องการยืนยันการให้สถานะล็อกประจำหรือไม่",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่',
                cancelButtonText: 'ไม่'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= $host_path ?>/backend/Service/StaticArea.php",
                        type: "POST",
                        data: {
                            r_Id: r_Id,
                            a_Id: a_Id
                        },
                        dataType: "json",
                        success: function(res) {
                            let message = res.message;
                            let status = res.status;

                            if (status == "success") {
                                Swal.fire({
                                    icon: 'success',
                                    title: message,
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then((result) => {
                                    dt_table.ajax.reload();
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'เเจ้งเตือน',
                                    text: message
                                })
                            }
                        }
                    });
                }
            });
        }

        const fcReturnNoReserve = (elm) => {
            const obj_json = elm.value;
            const obj = JSON.parse(obj_json);

            let r_Id = obj.r_Id;
            let a_Id = obj.a_Id;

            Swal.fire({
                title: 'ยืนยันการคืนล็อก?',
                text: "คุณต้องการยืนยันการคืนล็อกหรือไม่",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่',
                cancelButtonText: 'ไม่'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= $host_path ?>/backend/Service/returnAreaNoReserve.php",
                        type: "POST",
                        data: {
                            r_Id: r_Id,
                            a_Id: a_Id
                        },
                        dataType: "json",
                        success: function(res) {
                            let message = res.message;
                            let status = res.status;

                            if (status == "success") {
                                Swal.fire({
                                    icon: 'success',
                                    title: message,
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then((result) => {
                                    dt_table.ajax.reload();
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'เเจ้งเตือน',
                                    text: message
                                })
                            }
                        }
                    });
                }
            });
        }

        const resetAll = () => {
            Swal.fire({
                title: 'ยืนยันรีเซ็ตการจองทั้งหมด?',
                text: "คุณต้องการยืนยันรีเซ็ตการจองทั้งหมดหรือไม่",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่',
                cancelButtonText: 'ไม่'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= $host_path ?>/backend/Service/reset_all.php",
                        type: "POST",
                        dataType: "json",
                        success: function(res) {
                            let message = res.message;
                            let status = res.status;

                            if (status == "success") {
                                Swal.fire({
                                    icon: 'success',
                                    title: message,
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then((result) => {
                                    dt_table.ajax.reload();
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'เเจ้งเตือน',
                                    text: message
                                })
                            }
                        }
                    });
                }
            });
        }

        const resetNonStatic = () => {
            Swal.fire({
                title: 'ยืนยันรีเซ็ตการจองล็อกไม่ประจำทั้งหมด?',
                text: "คุณต้องการยืนยันรีเซ็ตการจองล็อกไม่ประจำทั้งหมดหรือไม่",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่',
                cancelButtonText: 'ไม่'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= $host_path ?>/backend/Service/reset_non_static.php",
                        type: "POST",
                        dataType: "json",
                        success: function(res) {
                            let message = res.message;
                            let status = res.status;

                            if (status == "success") {
                                Swal.fire({
                                    icon: 'success',
                                    title: message,
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then((result) => {
                                    dt_table.ajax.reload();
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'เเจ้งเตือน',
                                    text: message
                                })
                            }
                        }
                    });
                }
            });
        }

        const resetStatic = () => {
            Swal.fire({
                title: 'ยืนยันรีเซ็ตการจองล็อกประจำทั้งหมด?',
                text: "คุณต้องการยืนยันรีเซ็ตการจองล็อกประจำทั้งหมดหรือไม่",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่',
                cancelButtonText: 'ไม่'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= $host_path ?>/backend/Service/reset_static.php",
                        type: "POST",
                        dataType: "json",
                        success: function(res) {
                            let message = res.message;
                            let status = res.status;

                            if (status == "success") {
                                Swal.fire({
                                    icon: 'success',
                                    title: message,
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then((result) => {
                                    dt_table.ajax.reload();
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'เเจ้งเตือน',
                                    text: message
                                })
                            }
                        }
                    });
                }
            });
        }

        const fcCancel_static = (elm) => {
            const obj_json = elm.value;
            const obj = JSON.parse(obj_json);

            let r_Id = obj.r_Id;
            let a_Id = obj.a_Id;

            Swal.fire({
                title: 'ยืนยันการยกเลิก?',
                text: "คุณต้องการยืนยันการยกเลิกหรือไม่",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่',
                cancelButtonText: 'ไม่'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= $host_path ?>/backend/Service/cancelReserve_static.php",
                        type: "POST",
                        data: {
                            r_Id: r_Id,
                            a_Id: a_Id
                        },
                        dataType: "json",
                        success: function(res) {
                            let message = res.message;
                            let status = res.status;

                            if (status == "success") {
                                Swal.fire({
                                    icon: 'success',
                                    title: message,
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then((result) => {
                                    dt_table.ajax.reload();
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'เเจ้งเตือน',
                                    text: message
                                })
                            }
                        }
                    });
                }
            });
        }

        const confirm_pay = (elm) => {
            const obj_json = elm.value;
            const obj = JSON.parse(obj_json);

            let u_CardNumber = obj.u_CardNumber;
            let a_Name = obj.a_Name;
            console.log(obj)

            Swal.fire({
                title: 'ยืนยันการชำระเงิน?',
                text: "คุณต้องการยืนยันการชำระเงินหรือไม่",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่',
                cancelButtonText: 'ไม่'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= $host_path ?>/backend/Service/api_pay_confirm.php",
                        type: "POST",
                        data: {
                            u_CardNumber: u_CardNumber,
                            a_Name: a_Name
                        },
                        dataType: "json",
                        success: function(res) {
                            let message = res.message;
                            let status = res.status;

                            if (status == "success") {
                                Swal.fire({
                                    icon: 'success',
                                    title: message,
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then((result) => {
                                    dt_table.ajax.reload();
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'เเจ้งเตือน',
                                    text: message
                                })
                            }
                        }
                    });
                }
            });
        }



        //====================================  สถานะล็อก
        //a_ReserveStatus 0 -> ล็อกว่างปกติ
        //a_ReserveStatus 1 -> จองปกติ
        //a_ReserveStatus 2 -> ล็อกประจำ
        //a_ReserveStatus 3 -> ปลดล็อกประจำให้จองได้ หรือ ล็อกประจำว่าง
        //a_ReserveStatus 4 -> จองล็อกประจำ
        //a_ReserveStatus 5 -> จองล็อกประจำ
        //a_ReserveStatus 9 -> รอชำระเงิน
        //a_ReserveStatus 8 -> รอชำระเงินล็อคประจำ

        //====================================  สถานะการจอง
        //r_Status 0 -> ยกเลิกการจอง
        //r_Status 1 -> จองแบบปกติ
        //r_Status 2 -> จองล็อกประจำ
        //r_Status 9 -> รอชำระเงิน
        //r_Status 8 -> รอชำระเงินล็อคประจำ
    </script>
</body>

</html>