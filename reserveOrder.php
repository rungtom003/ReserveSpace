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
            <div class="py-1">
            <div class="card">
                    <div class="card-body">
                        <table id="table-Order" class="table table-striped w-100"></table>
                    </div>
                </div>
            </div>
            <!-- end: Content -->
        </div>
    </main>
    <!-- end: Main -->
    <?php include("./layout/script.php"); ?>
    <script>
        function loadOrder(){
            $.ajax({
                url: "/ReserveSpace/backend/Service/reserveList_api.php",
                type: "GET",
                dataType: "json",
                success: function(res) {
                    //console.log(res);
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
                            title: "ประเภท",
                            data: "pt_Name",
                        },
                        {
                            targets: 3,
                            title: "ชื่อ",
                            data: "u_FirstName",
                        },
                        {
                            targets: 4,
                            title: "สกุล",
                            data: "u_LastName",
                        },
                        {
                            targets: 5,
                            title: "เลขประจำตัวประชาชนน",
                            data: "u_CardNumber",
                        },
                        {
                            targets: 6,
                            title: "เบอร์โทร",
                            data: "u_Phone",
                        },
                        {
                            targets: 7,
                            title: "RD Status",
                            data: "rd_Status",
                        },
                        {
                            targets: 8,
                            title: "ReserveStatus",
                            data: "a_ReserveStatus",
                        },
                        {
                            targets: 9,
                            title: "#",
                            data: null,
                            defaultContent: "",
                            render: function(data, type, row, meta) {
                                return `<div class="d-grid gap-2 d-md-block" >
                                        <button class="btn btn-primary" type="button" id="btn_Approve" >อนุมัติ</button>
                                        <button class="btn btn-danger" type="button" id="btn_Cancel" >ยกเลิก</button>
                                    </div>`;
                            }
                        }
                    ]
                });
            }
        }
        loadOrder();

        //Btn Approve
        $("body").on("click", "#table-Order #btn_Approve", function() {
            var row = $(this).closest("tr");
            let data = $('#table-Order').DataTable().row(row).data();
            let rd_Id = data.rd_Id;
            let a_Id = data.a_Id;

            $.ajax({
                    url: "/ReserveSpace/backend/Service/approveReserve_api.php",
                    type: "POST",
                    data: {
                        rd_Id: rd_Id,
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
                                showConfirmButton: true,
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

        });

        //Btn Cancel
        $("body").on("click", "#table-Order #btn_Cancel", function() {
            var row = $(this).closest("tr");
            let data = $('#table-Order').DataTable().row(row).data();
            let rd_Id = data.rd_Id;
            let a_Id = data.a_Id;
            
            $.ajax({
                    url: "/ReserveSpace/backend/Service/cancelReserve.php",
                    type: "POST",
                    data: {
                        rd_Id: rd_Id,
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
                                showConfirmButton: true,
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

        });

    </script>
</body>

</html>