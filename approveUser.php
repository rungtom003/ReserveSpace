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

            <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="detailModalLabel">รายละเอียดเพิ่มเติม</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="d-flex justify-content-center">
                                    <img class="img-fluid" id="img" alt="" src="" style="height: 150px" >
                                </div>

                                <div class="row g-2 p-2">
                                    <div class="col-md-3">
                                        <label class="form-label">รหัสเจ้าหน้าที่</label>
                                        <input type="text" class="form-control" placeholder="ID" id="u_OfficerId" readonly>
                                        <!-- <div class="form-text">Enter your Full name</div> -->
                                    </div>
                                </div>
                                <div class="row g-2 p-2">
                                    <div class="col-md-2">
                                        <label class="form-label">คำนำหน้า</label>
                                        <input type="text" class="form-control" id="Prefix" readonly>
                                        <!-- <div class="form-text">Enter your Full name</div> -->
                                    </div>
                                    <div class="col-md">
                                        <label class="form-label">ชื่อ</label>
                                        <input type="text" class="form-control" placeholder="Full name" id="u_FullName" readonly>
                                        <!-- <div class="form-text">Enter your Full name</div> -->
                                    </div>
                                    <div class="col-md">
                                        <label class="form-label">นามสกุล</label>
                                        <input type="text" class="form-control" placeholder="Last name" id="u_Last" readonly>
                                        <!-- <div  class="form-text">Enter your Last name</div> -->
                                    </div>
                                </div>

                                <div class="row g-2 p-2">
                                    <div class="col-md">
                                        <label class="form-label">ชื่อผู้ใช้</label>
                                        <input type="Username" class="form-control" placeholder="Username" id="u_Username" readonly>
                                        <!-- <div class="form-text">Enter your Full name</div> -->
                                    </div>
                                </div>
                                <div class="g-2 p-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="RadioAdmin" value="R002" disabled>
                                        <label class="form-check-label" for="RadioAdmin">Admin</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="RadioUser" value="R001" disabled>
                                        <label class="form-check-label" for="RadioUser">User</label>
                                    </div>
                                </div>
                                <div class="row g-2 p-2">
                                    <div class="col-md">
                                        <label class="form-label">ชื่อร้าน</label>
                                        <input type="text" class="form-control" placeholder="" id="u_ShopName" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">โซน</label>
                                        <input type="text" class="form-control" id="ZoneName" readonly>
                                    </div>
                                </div>
                                <div class="row g-2 p-2">
                                    <div class="mb-3">
                                        <label for="u_ProductName" class="form-label">รายละเอียดสินค้า</label>
                                        <textarea class="form-control" id="u_ProductName" rows="3" readonly></textarea>
                                    </div>
                                </div>
                                <div class="row g-2 p-2">
                                    <div class="col-md">
                                        <label class="form-label">ตำแหน่ง</label>
                                        <input type="text" class="form-control" placeholder="" id="u_Position" readonly>
                                        <!-- <div  class="form-text">Enter your Last name</div> -->
                                    </div>
                                    <div class="col-md">
                                        <label class="form-label">เลขบัตรประจำตัวประชาชน</label>
                                        <input type="text" class="form-control" placeholder="" id="u_CardNumber" readonly>
                                        <!-- <div class="form-text">Enter your Full name</div> -->
                                    </div>
                                    <div class="col-md">
                                        <label class="form-label">วัน/เดือน/ปีเกิด</label>
                                        <input type="date" class="form-control" placeholder="" id="u_Birthday" readonly>
                                        <!-- <div  class="form-text">Enter your Last name</div> -->
                                    </div>
                                </div>

                                <div class="row g-2 p-2">
                                    <div class="col-md">
                                        <div class="col-md">
                                            <label class="form-label">บ้านเลขที่/หมู่</label>
                                            <input type="text" class="form-control" placeholder="" id="u_Address" readonly>
                                            <!-- <div  class="form-text">Enter your Last name</div> -->
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="col-md">
                                            <label class="form-label">ถนน</label>
                                            <input type="text" class="form-control" placeholder="" id="u_Road" readonly>
                                            <!-- <div  class="form-text">Enter your Last name</div> -->
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="col-md">
                                            <label class="form-label">ตำบล</label>
                                            <input type="text" class="form-control" placeholder="" id="u_SubDistrict" readonly>
                                            <!-- <div  class="form-text">Enter your Last name</div> -->
                                        </div>
                                    </div>

                                </div>
                                <div class="row g-2 p-2">
                                    <div class="col-md">
                                        <div class="col-md">
                                            <label class="form-label">อำเภอ</label>
                                            <input type="text" class="form-control" placeholder="" id="u_District" readonly>
                                            <!-- <div  class="form-text">Enter your Last name</div> -->
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="col-md">
                                            <label class="form-label">จังหวัด</label>
                                            <input type="text" class="form-control" placeholder="" id="u_Province" readonly>
                                            <!-- <div  class="form-text">Enter your Last name</div> -->
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="col-md">
                                            <label class="form-label">เบอร์โทรศัพท์</label>
                                            <input type="text" class="form-control" placeholder="" id="u_Phone" readonly>
                                            <!-- <div  class="form-text">Enter your Last name</div> -->
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

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
                                if (data === "0") {
                                    txtHTML = "<span class='text-danger'>ยังไม่อนุมัติ</span>";
                                } else {
                                    txtHTML = "<span class='text-success'>อนุมัติเเล้ว</span>";
                                }
                                return txtHTML;
                            }
                        },
                        {
                            targets: 6,
                            title: "รายละเอียด",
                            data: null,
                            defaultContent: "",
                            render: function(data, type, row, meta) {
                                const u_Id = row.u_Id;
                                return `<div class="d-grid gap-2 d-md-block" >
                                            <button class="btn btn-link" type="button" data-bs-toggle="modal" data-bs-target="#detailModal" onclick="detailUser(this)" value="${u_Id}">เพิ่มเติม</button>
                                        </div>`;
                            }
                        },
                        {
                            targets: 7,
                            title: "#",
                            data: null,
                            defaultContent: "",
                            render: function(data, type, row, meta) {
                                let status = row.u_Approve;
                                const u_Id = row.u_Id;
                                let txtHTML = "";
                                if (status === "0") {
                                    txtHTML = `<button class="btn btn-primary" type="button" id="btn_Approve" onclick="fcApprove(this)" value="${u_Id}">อนุมัติ</button>`;
                                } else {
                                    txtHTML = `<button class="btn btn-warning" type="button" id="btn_Cancel" onclick="cancelUser(this)" value="${u_Id}">ยกเลิก</button>`;
                                }


                                return `<div class="d-grid gap-2 d-md-block" >` + txtHTML + `
                                        <button class="btn btn-danger" type="button" id="btn_Delete" onclick="deleteUser(this)" value="${u_Id}">ลบ</button>
                                        </div>`;
                            }
                        }
                    ]
                });
            }

        }

        loadUser();

        const fcApprove = (elm) => {
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

        const cancelUser = (elm) => {
            let u_Id = elm.value;

            $.ajax({
                url: "/ReserveSpace/backend/Service/cancelUser_api.php",
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

        const deleteUser = (elm) => {
            let u_Id = elm.value;
            Swal.fire({
                title: 'แจ้งเตือน',
                text: `ต้องการลบข้อมูลผู้ใช้ใช่หรือไม่`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก',
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: "/ReserveSpace/backend/Service/userDelete_api.php",
                        type: "POST",
                        data: {
                            u_Id: u_Id
                        },
                        dataType: "json",
                        success: function(res) {
                            //console.log(res);
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
            })
        }

        const detailUser = (elm) => {
            let u_Id = elm.value;
            $.ajax({
                url: "/ReserveSpace/backend/Service/user_api.php",
                type: "POST",
                data: {
                    u_Id: u_Id
                },
                dataType: "json",
                success: function(res) {

                    let message = res.message;
                    let status = res.status;
                    let ur_Id = res.data.ur_Id;
                    let zoneID = res.data.z_Id;
                    let u_Img = "/ReserveSpace/src/img/upload/" + res.data.u_Img;

                    $.ajax({
                        url: "/ReserveSpace/backend/Service/zone_api.php",
                        type: "POST",
                        dataType: "json",
                        success: function(res_Zone) {
                            let length = res_Zone.data.length;
                            for (let i = 0; i < length; i++) {
                                if (zoneID === res_Zone.data[i].z_Id) {
                                    $('#ZoneName').val(res_Zone.data[i].z_Name);
                                }
                            }
                        }
                    });

                    if (res.status == "success") {
                        $('#img').attr("src", u_Img);
                        $('#u_OfficerId').val(res.data.u_OfficerId);
                        $('#Prefix').val(res.data.u_Prefix);
                        $('#u_FullName').val(res.data.u_FirstName);
                        $('#u_Last').val(res.data.u_LastName);
                        $('#u_Username').val(res.data.u_Username);
                        if (ur_Id == "R001") {
                            $('#RadioUser').prop("checked", true);
                        } else if (ur_Id == "R002") {
                            $('#RadioAdmin').prop("checked", true);
                        }
                        $('#u_ShopName').val(res.data.u_ShopName);

                        $('#u_ProductName').html(res.data.u_ProductName);
                        $('#u_Position').val(res.data.u_Position);
                        $('#u_CardNumber').val(res.data.u_CardNumber);
                        $('#u_Birthday').val(res.data.u_Birthday);
                        $('#u_Address').val(res.data.u_Address);
                        $('#u_Road').val(res.data.u_Road);
                        $('#u_SubDistrict').val(res.data.u_SubDistrict);
                        $('#u_District').val(res.data.u_District);
                        $('#u_Province').val(res.data.u_Province);
                        $('#u_Phone').val(res.data.u_Phone);

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