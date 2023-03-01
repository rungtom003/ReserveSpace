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
    // if ($startDate != null && $EndDate != null && $user["ur_Id"] != "R002") {

    //     $StartTimestamp = strtotime(date('Y-m-d H:i:s', strtotime($startDate)));
    //     $EndTimestamp = strtotime(date('Y-m-d H:i:s', strtotime($EndDate)));
    //     $currentTimestamp = strtotime(date('Y-m-d H:i:s'));

    //     // Check if the current timestamp is greater than or equal to the set timestamp
    //     if ($currentTimestamp < $StartTimestamp) {
    //         header('location: ' . $host_path . '/countdow_time.php');
    //     }

    //     if($currentTimestamp > $EndTimestamp)
    //     {
    //         header('location: ' . $host_path . '/close_system.php');
    //     }
    // }
}

$titleHead = "ข้อมูลการจอง";
$active_reserveData = "active";
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ข้อมูลการจอง</title>
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

                <!-- <div class="d-flex flex-column align-items-center" id="data-reserve-content">
                </div> -->

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
        const u_Id = "<?= $user["u_Id"] ?>";
        $('#table-Order').DataTable({
            ajax: {
                url: '<?=$host_path?>/backend/Service/reserveUser.php',
                type: 'POST',
                data: {
                    u_Id: u_Id
                }
            },
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'colvis'],
            responsive: true,
            language: {
                url: './src/assets/DataTables/LanguageTable/th.json'
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
                        } else if (row.r_Status === "1" && row.a_ReserveStatus === "1") {
                            txtHTML = "<span class='text-success'>จองสำเร็จ</span>";
                        } else if (row.r_Status === "1" && row.a_ReserveStatus === "4") {
                            txtHTML = "<span class='text-success'>จองล็อกประจำสำเร็จ</span>";
                        } else if (row.r_Status === "2" && row.a_ReserveStatus === "2") {
                            txtHTML = "<span class='text-primary'>ล็อกประจำ</span>";
                        } else if (row.r_Status === "2" && row.a_ReserveStatus === "3") {
                            txtHTML = "<span class='text-danger'>ล็อกประจำ(ยกเลิกชั่วคราว)</span>";
                        } else if (row.r_Status === "2" && row.a_ReserveStatus === "4") {
                            txtHTML = `<span class='text-danger'>ล็อกประจำถูกจอง</span>`;
                        } else {
                            txtHTML = "";
                        }
                        return txtHTML;
                    }
                }
            ]
        });
        // $.ajax({
        //     url: "/ReserveSpace/backend/Service/reserveUser.php",
        //     type: "POST",
        //     dataType: "json",
        //     data: {
        //         u_Id: u_Id
        //     },
        //     success: function(res) {
        //         console.log(res)
        //         let txtContent = "";
        //         const dataarr = res.data;
        //         $.each(dataarr, function(key, val) {
        //             if (val.r_Status === "0") {
        //                 txtContent += `<div class="card text-bg-danger my-2 w-100">
        //                 <div class="card-body">
        //                     <h5 class="card-title text-center">ล็อก ${val.a_Name}</h5>
        //                     <hr class="border border-primary border-3 opacity-75">
        //                     <ul class="list-group">
        //                         <li class="list-group-item"><span>ชื่อผู้จอง : ${val.u_FirstName} ${val.u_LastName}</span></li>
        //                         <li class="list-group-item"><span>ล็อก : ${val.a_Name}</span></li>
        //                         <li class="list-group-item"><span>โซน : ${val.z_Name}</span></li>
        //                         <li class="list-group-item"><span>ชื่อร้าน : ${val.u_ShopName}</span></li>
        //                         <li class="list-group-item"><span>สินค้าที่ขาย : ${val.u_ProductName}</span></li>
        //                         <li class="list-group-item"><span>หมายเหตุ : ${val.r_Note===null?"":val.r_Note}</span></li>
        //                         <li class="list-group-item"><span>วันเวลาจอง : ${val.r_DateTime}</span></li>
        //                         <li class="list-group-item"><span>สถานะการจอง : <span class="text-danger">ยกเลิกการจอง</span></span></li>
        //                     </ul>
        //                 </div>
        //             </div>`;
        //             } else if (val.r_Status === "1") {
        //                 txtContent += `<div class="card text-bg-success my-2 w-100">
        //                 <div class="card-body">
        //                     <h5 class="card-title text-center">ล็อก ${val.a_Name}</h5>
        //                     <hr class="border border-primary border-3 opacity-75">
        //                     <ul class="list-group">
        //                         <li class="list-group-item"><span>ชื่อผู้จอง : ${val.u_FirstName} ${val.u_LastName}</span></li>
        //                         <li class="list-group-item"><span>ล็อก : ${val.a_Name}</span></li>
        //                         <li class="list-group-item"><span>โซน : ${val.z_Name}</span></li>
        //                         <li class="list-group-item"><span>ชื่อร้าน : ${val.u_ShopName}</span></li>
        //                         <li class="list-group-item"><span>สินค้าที่ขาย : ${val.u_ProductName}</span></li>
        //                         <li class="list-group-item"><span>หมายเหตุ : ${val.r_Note===null?"":val.r_Note}</span></li>
        //                         <li class="list-group-item"><span>วันเวลาจอง : ${val.r_DateTime}</span></li>
        //                         <li class="list-group-item"><span>สถานะการจอง : <span class="text-success">สำเร็จ</span></span></li>
        //                     </ul>
        //                 </div>
        //             </div>`;
        //             } else {
        //                 txtContent += `<div class="card text-bg-primary my-2 w-100">
        //                 <div class="card-body">
        //                     <h5 class="card-title text-center">ล็อก ${val.a_Name}</h5>
        //                     <hr class="border border-primary border-3 opacity-75">
        //                     <ul class="list-group">
        //                         <li class="list-group-item"><span>ชื่อผู้จอง : ${val.u_FirstName} ${val.u_LastName}</span></li>
        //                         <li class="list-group-item"><span>ล็อก : ${val.a_Name}</span></li>
        //                         <li class="list-group-item"><span>โซน : ${val.z_Name}</span></li>
        //                         <li class="list-group-item"><span>ชื่อร้าน : ${val.u_ShopName}</span></li>
        //                         <li class="list-group-item"><span>สินค้าที่ขาย : ${val.u_ProductName}</span></li>
        //                         <li class="list-group-item"><span>หมายเหตุ : ${val.r_Note===null?"":val.r_Note}</span></li>
        //                         <li class="list-group-item"><span>วันเวลาจอง : ${val.r_DateTime}</span></li>
        //                         <li class="list-group-item"><span>สถานะการจอง : <span class="text-primary">สำเร็จ (ล็อกประจำ)</span></span></li>
        //                     </ul>
        //                 </div>
        //             </div>`;
        //             }

        //         });
        //         $("#data-reserve-content").html(txtContent);
        //     }
        // });

        const cancelOrder = (elm) => {
            const obj_json = elm.value;
            const obj = JSON.parse(obj_json);

            Swal.fire({
                title: 'ยืนยัน?',
                text: "คุณต้องการยกเลิกหรือไม่",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่',
                cancelButtonText: 'ไม่'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?=$host_path?>/backend/Service/cancelReserve.php",
                        type: "POST",
                        dataType: "json",
                        data: {
                            rd_Id: obj.rd_Id,
                            a_Id: obj.a_Id
                        },
                        success: function(res) {
                            if (res.status === "success") {
                                window.location.reload();
                            } else {
                                Swal.fire(
                                    'เกิดข้อผิดพลาด',
                                    `${res.message}`,
                                    'warning'
                                )
                            }
                        }
                    });

                }
            });
        }
    </script>
</body>

</html>