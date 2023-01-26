<?php
session_start();
$user = (isset($_SESSION['user'])) ? unserialize($_SESSION['user']) : null;
if ($user == null) {
    header('location: /ReserveSpace/login.php');
}
if ($user["ur_Id"] == "R001") {
    header('location: /ReserveSpace/noaccess.php');
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
        function loadOrder() {
            $.ajax({
                url: "/ReserveSpace/backend/Service/reserveList_api.php",
                type: "GET",
                dataType: "json",
                success: function(res) {
                    console.log(res);
                    LoadTable(res.data);
                }
            });

            const LoadTable = (data) => {
                $('#table-Order').DataTable({
                    data: data,
                    dom: 'Bfrtip',
                    buttons: ['copy', 'csv', 'excel', 'colvis'],
                    responsive: true,
                    language: {
                        url: './src/assets/DataTables/LanguageTable/th.json'
                    },
                    columnDefs: [{
                            targets: 0,
                            title: "บล็อค",
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
                            title: "เลขประจำตัวประชาชนน",
                            data: "u_CardNumber",
                        },
                        {
                            targets: 7,
                            title: "เบอร์โทร",
                            data: "u_Phone",
                        },
                        {
                            targets: 8,
                            title: "สถานะ",
                            data: null,
                            defaultContent: "",
                            render: function(data, type, row, meta) {
                                let txtHTML = "";
                                if (row.r_Status === "0") {
                                    txtHTML = "<span class='text-danger'>ยกเลิก</span>";
                                } else if (row.r_Status === "1") {
                                    txtHTML = "<span class='text-success'>จองสำเร็จ</span>";
                                } else if (row.r_Status === "2") {
                                    txtHTML = "<span class='text-primary'>ล็อคประจำ</span>";
                                } else {
                                    txtHTML = "";
                                }
                                return txtHTML;
                            }
                        },
                        {
                            targets: 9,
                            title: "#",
                            data: null,
                            defaultContent: "",
                            render: function(data, type, row, meta) {
                                const obj = {
                                    r_Id: row.r_Id,
                                    a_Id: row.a_Id
                                }
                                let txtHTML = "";
                                if (row.r_Status === "0") {
                                    txtHTML = "";
                                } else if (row.r_Status === "1" && row.a_ReserveStatus === "1") {
                                    txtHTML = `<div class="d-grid gap-2 d-md-block" >
                                                <button class="btn btn-danger" type="button" onclick="fcCancel(this)" value='${JSON.stringify(obj)}'>ยกเลิก</button>
                                                <button class="btn btn-primary" type="button" onclick="fcStaticArea(this)" value='${JSON.stringify(obj)}'>ให้สถานะล็อคประจำ</button>
                                            </div>`;
                                } else if (row.r_Status === "2" && row.a_ReserveStatus === "2") {
                                    txtHTML = `<div class="d-grid gap-2 d-md-block" >
                                                <button class="btn btn-primary" type="button"  onclick="fcCancelTemporary(this)" value='${JSON.stringify(obj)}'>ยกเลิกช่วงคราว</button>
                                                <button class="btn btn-danger" type="button"  onclick="fcCancel(this)" value='${JSON.stringify(obj)}'>ยกเลิก</button>
                                            </div>`;
                                } else if (row.r_Status === "2" && row.a_ReserveStatus === "4") {
                                    txtHTML = `<span class='text-danger'>ล็อคประจำถูกจอง</span>`;
                                } else if (row.r_Status === "1" && row.a_ReserveStatus === "4") {
                                    txtHTML = `<div class="d-grid gap-2 d-md-block" >
                                                <button class="btn btn-primary" type="button" onclick="fcReturn(this)" value='${JSON.stringify(obj)}'>คืนล็อคประจำ</button>
                                            </div>`;
                                } else if (row.r_Status === "2" && row.a_ReserveStatus === "3") {
                                    txtHTML = `<div class="d-grid gap-2 d-md-block" >
                                                <button class="btn btn-primary" type="button" onclick="fcReturnNoReserve(this)" value='${JSON.stringify(obj)}'>คืนล็อคประจำ</button>
                                            </div>`;
                                }
                                else {
                                    txtHTML = "";
                                }
                                return txtHTML;
                            }
                        }
                    ]
                });
            }
        }
        loadOrder();

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
                        url: "/ReserveSpace/backend/Service/cancelReserve.php",
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
                                    $('#table-Order').DataTable().destroy();
                                    loadOrder();
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
                        url: "/ReserveSpace/backend/Service/approveReserve_api.php",
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
                                    $('#table-Order').DataTable().destroy();
                                    loadOrder();
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
                        url: "/ReserveSpace/backend/Service/CancelTemporary.php",
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
                                    $('#table-Order').DataTable().destroy();
                                    loadOrder();
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
                title: 'ยืนยันการคืนล็อค?',
                text: "คุณต้องการยืนยันการคืนล็อคหรือไม่",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่',
                cancelButtonText: 'ไม่'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/ReserveSpace/backend/Service/returnArea.php",
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
                                    $('#table-Order').DataTable().destroy();
                                    loadOrder();
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
                title: 'ยืนยันการคืนล็อค?',
                text: "คุณต้องการยืนยันการคืนล็อคหรือไม่",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่',
                cancelButtonText: 'ไม่'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/ReserveSpace/backend/Service/StaticArea.php",
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
                                    $('#table-Order').DataTable().destroy();
                                    loadOrder();
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
                title: 'ยืนยันการคืนล็อค?',
                text: "คุณต้องการยืนยันการคืนล็อคหรือไม่",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่',
                cancelButtonText: 'ไม่'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/ReserveSpace/backend/Service/returnAreaNoReserve.php",
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
                                    $('#table-Order').DataTable().destroy();
                                    loadOrder();
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
        

        //====================================  สถานะล็อค
        //a_ReserveStatus 0 -> ล็อคว่างปกติ
        //a_ReserveStatus 1 -> จองปกติ
        //a_ReserveStatus 2 -> ล็อคประจำ
        //a_ReserveStatus 3 -> ปลดล็อคประจำให้จองได้ หรือ ล็อคประจำว่าง
        //a_ReserveStatus 4 -> จองล็อคประจำ

        //====================================  สถานะการจอง
        //r_Status 0 -> ยกเลิกการจอง
        //r_Status 1 -> จองแบบปกติ
        //r_Status 2 -> จองแบบล็อคประจำ
    </script>
</body>

</html>