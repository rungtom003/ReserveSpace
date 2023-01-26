<?php
session_start();
$user = (isset($_SESSION['user'])) ? unserialize($_SESSION['user']) : null;
if ($user == null) {
    header('location: /ReserveSpace/login.php');
}
if ($user["ur_Id"] == "R001") {
    header('location: /ReserveSpace/noaccess.php');
}
$titleHead = "Appove User";
$active_approve = "active";
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Appove User</title>
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
                        <table id="table-users" class="table table-striped w-100"></table>
                    </div>
                </div>
            </div>
            <!-- end: Content -->
        </div>
    </main>
    <!-- end: Main -->
    <?php include("./layout/script.php"); ?>
    <script>
        function loadUser() {
            $.ajax({
                url: "/ReserveSpace/backend/Service/usersList_api.php",
                type: "GET",
                dataType: "json",
                success: function(res) {
                    //console.log(res);
                    LoadTable(res.data);
                }
            });

            const LoadTable = (data) => {
                $('#table-users').DataTable({
                    data: data,
                    dom: 'Bfrtip',
                    buttons: ['copy', 'csv', 'excel', 'colvis'],
                    responsive: true,
                    language: {
                        url: './src/assets/DataTables/LanguageTable/th.json'
                    },
                    columnDefs: [{
                            targets: 0,
                            title: "ชื่อ",
                            data: "u_FirstName",
                        },
                        {
                            targets: 1,
                            title: "สกุล",
                            data: "u_LastName",
                        },
                        {
                            targets: 2,
                            title: "สิทธิ์",
                            data: "ur_Id",
                            render: function(data, type, row, meta) {
                                let role = data === "R001" ? "User" : "Admin"
                                return role;
                            }
                        },
                        {
                            targets: 3,
                            title: "Username",
                            data: "u_Username",
                        },
                        {
                            targets: 4,
                            title: "เลขบัตรประชาชน",
                            data: "u_CardNumber",
                        },
                        {
                            targets: 5,
                            title: "Approve",
                            data: "u_Approve",
                            render: function(data, type, row, meta) {
                                let txtHTML = "";
                                if(data === "0")
                                {
                                    txtHTML = "<span class='text-danger'>ยังไม่อนุมัติ</span>";
                                }
                                else
                                {
                                    txtHTML = "<span class='text-success'>อนุมัติเเล้ว</span>";
                                }
                                return txtHTML;
                            }
                        },
                        {
                            targets: 6,
                            title: "#",
                            data: null,
                            defaultContent: "",
                            render: function(data, type, row, meta) {
                                const u_Id = row.u_Id;
                                return `<div class="d-grid gap-2 d-md-block" >
                                        <button class="btn btn-primary" type="button" id="btn_Approve" onclick="fcApprove(this)" value="${u_Id}">อนุมัติ</button>
                                    </div>`;
                            }
                        }
                    ]
                });
            }

        }

        loadUser();

        //Btn Approve
        // $("body").on("click", "#table-users #btn_Approve", function() {
        //     var row = $(this).closest("tr");
        //     let data = $('#table-users').DataTable().row(row).data();
        //     let u_Id = data.u_Id;

        //     $.ajax({
        //         url: "/ReserveSpace/backend/Service/approveUser_api.php",
        //         type: "POST",
        //         data: {
        //             u_Id: u_Id
        //         },
        //         dataType: "json",
        //         success: function(res) {
        //             let message = res.message;
        //             let status = res.status;

        //             if (status == "success") {
        //                 Swal.fire({
        //                     icon: 'success',
        //                     title: message,
        //                     showConfirmButton: true,
        //                     timer: 1500
        //                 }).then((result) => {
        //                     $('#table-users').DataTable().destroy();
        //                     loadUser();
        //                 })
        //             } else {
        //                 Swal.fire({
        //                     icon: 'error',
        //                     title: 'เเจ้งเตือน',
        //                     text: message
        //                 })
        //             }
        //         }
        //     });

        // });

        const fcApprove = (elm) =>{
            let u_Id = elm.value;

            $.ajax({
                url: "/ReserveSpace/backend/Service/approveUser_api.php",
                type: "POST",
                data: {
                    u_Id: u_Id
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
                            $('#table-users').DataTable().destroy();
                            loadUser();
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
    </script>
</body>

</html>