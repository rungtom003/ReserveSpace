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
$titleHead = "ประวัติการจอง";
$active_reserve_history = "active";
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

                <!-- <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-wrap">
                            <button class="btn btn-primary m-1" id="reset-all" onclick="resetAll()">รีเซ็ตการจองทั้งหมด</button>
                            <button class="btn btn-primary m-1" id="reset-static" onclick="resetStatic()">รีเซ็ตการจองล็อกประจำ</button>
                            <button class="btn btn-primary m-1" id="reset-non-static" onclick="resetNonStatic()">รีเซ็ตการจองล็อกไม่ประจำ</button>
                        </div>

                    </div>
                </div> -->

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary" onclick="btndelete()">ลบ</button>
                        </div>
                        <table id="table-Order" class="table w-100 text-nowrap"></table>
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
            ajax: "<?= $host_path ?>/backend/Service/history_reserve_api.php",
            //processing: true,
            //serverSide: true,
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'colvis'],
            //responsive: true,
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

                this.api().columns(2).every(function() {
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
            select: {
                style: 'multi',
                selector: 'td:first-child'
            },
            "scrollX": true,
            columnDefs: [{
                    targets: 0,
                    title: "เลือก",
                    orderable: false,
                    className: 'select-checkbox',
                    data: null,
                    defaultContent: "",
                },
                {
                    targets: 1,
                    title: "ล็อก",
                    data: "a_Name",
                },
                {
                    targets: 2,
                    title: "โซน",
                    data: "z_Name",

                },
                {
                    targets: 3,
                    title: "ชื่อร้าน",
                    data: "u_ShopName",
                },
                {
                    targets: 4,
                    title: "สินค้า",
                    data: "u_ProductName",
                },
                {
                    targets: 5,
                    title: "คำนำหน้า",
                    data: "u_Prefix",
                },
                {
                    targets: 6,
                    title: "ชื่อ",
                    data: "u_FirstName",
                },
                {
                    targets: 7,
                    title: "สกุล",
                    data: "u_LastName",
                },
                {
                    targets: 8,
                    title: "เลขประจำตัวประชาชนน",
                    data: "u_CardNumber",
                },
                {
                    targets: 9,
                    title: "เบอร์โทร",
                    data: "u_Phone",
                },
                {
                    targets: 10,
                    title: "ที่อยู่",
                    data: "u_Address",
                },
                {
                    targets: 11,
                    title: "ถนน",
                    data: "u_Road",
                },
                {
                    targets: 12,
                    title: "ตำบล",
                    data: "u_SubDistrict",
                },
                {
                    targets: 13,
                    title: "อำเภอ",
                    data: "u_District",
                },
                {
                    targets: 14,
                    title: "จังหวัด",
                    data: "u_Province",
                },
                {
                    targets: 15,
                    title: "วันที่จอง",
                    data: "r_DateTime",
                }
            ]
        });

        const btndelete = () => {
            //alert(dt_table.rows('.selected').data().length + ' row(s) selected');
            let Arrr_Id = [];
            const data = dt_table.rows('.selected').data();
            $.each(data, function(key, val) {
                Arrr_Id.push(val.r_Id);
            });

            Swal.fire({
                title: 'ลบข้อมูล?',
                text: "ยืนยันการลบข้อมูล!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่',
                cancelButtonText: 'ไม่'
            }).then((result) => {
                if (result.isConfirmed) {
                    if (Arrr_Id.length === 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'เลือก',
                            text: 'กรุณาเลือกรายการที่จะลบ'
                        });
                    } else {
                        $.ajax({
                            url: "<?= $host_path ?>/backend/Service/api_delete_history.php",
                            type: "POST",
                            dataType: "json",
                            data: {
                                arrr_Id: Arrr_Id
                            },
                            success: function(res) {
                                if (res.status === "success") {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'สำเร็จ',
                                        text: res.message,
                                        didClose: () => {
                                            dt_table.ajax.reload();
                                        }
                                    })
                                } else {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'ไม่สำเร็จ',
                                        text: res.message
                                    });
                                }
                            }
                        });
                    }

                }
            })


        }

        //====================================  สถานะล็อก
        //a_ReserveStatus 0 -> ล็อกว่างปกติ
        //a_ReserveStatus 1 -> จองปกติ
        //a_ReserveStatus 2 -> ล็อกประจำ
        //a_ReserveStatus 3 -> ปลดล็อกประจำให้จองได้ หรือ ล็อกประจำว่าง
        //a_ReserveStatus 4 -> จองล็อกประจำ
        //a_ReserveStatus 5 -> จองล็อกประจำ

        //====================================  สถานะการจอง
        //r_Status 0 -> ยกเลิกการจอง
        //r_Status 1 -> จองแบบปกติ
        //r_Status 2 -> จองแล็อกประจำ
    </script>
</body>

</html>