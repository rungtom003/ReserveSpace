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
        $.ajax({
            url: "/ReserveSpace/backend/Service/usersList_api.php",
            type: "GET",
            dataType: "json",
            success: function(res) {
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
                    }
                ]
            });
        }
    </script>
</body>

</html>