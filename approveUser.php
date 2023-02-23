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
                                    <img class="img-fluid" id="img" alt="" src="" style="height: 150px">
                                </div>
                                <span id="u_Id" hidden></span>
                                <div class="row g-2 p-2 d-flex align-items-end">
                                    <div class="col-md" id="u_OfficerId-content">
                                        <label class="form-label">รหัสเจ้าหน้าที่</label>
                                        <input type="text" class="form-control" placeholder="" id="u_OfficerId">
                                        <!-- <div class="form-text">Enter your Full name</div> -->
                                    </div>
                                    <div class="col-md" id="u_IdWalkin-content">
                                        <label class="form-label">รหัส Walk in</label>
                                        <input type="text" class="form-control" placeholder="" id="u_IdWalkin">
                                        <!-- <div class="form-text">Enter your Full name</div> -->
                                    </div>
                                </div>
                                <div class="row g-2 p-2">
                                    <div class="col-md-2">
                                        <label class="form-label">คำนำหน้า</label>
                                        <select class="form-select" aria-label="Default select example" id="Prefix">
                                        </select>
                                        <!-- <div class="form-text">Enter your Full name</div> -->
                                    </div>
                                    <div class="col-md">
                                        <label class="form-label">ชื่อ</label>
                                        <input type="text" class="form-control" placeholder="Full name" id="u_FullName">
                                        <!-- <div class="form-text">Enter your Full name</div> -->
                                    </div>
                                    <div class="col-md">
                                        <label class="form-label">นามสกุล</label>
                                        <input type="text" class="form-control" placeholder="Last name" id="u_Last">
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
                                <div class="row g-2 p-2" id="password-content">
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" placeholder="********" id="u_Password">
                                        <!-- <div class="form-text">Enter your Full name</div> -->
                                    </div>
                                    <div class="col-md">
                                        <button type="button" class="btn btn-primary" id="btnEditPassword">แก้ไขรหัสผ่าน</button>
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
                                <div class="row g-2 p-2" id="u_Shop-content">
                                    <div class="col-md">
                                        <label class="form-label">ชื่อร้าน</label>
                                        <input type="text" class="form-control" placeholder="" id="u_ShopName">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">โซน</label>
                                        <select class="form-select" aria-label="Default select example" id="zoneName">
                                        </select>
                                    </div>
                                </div>
                                <div class="row g-2 p-2" id="shop_Detail-content">
                                    <div class="mb-3">
                                        <label for="u_ProductName" class="form-label">รายละเอียดสินค้า</label>
                                        <textarea class="form-control" id="u_ProductName" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="row g-2 p-2">
                                    <div class="col-md" id="u_Position-content">
                                        <label class="form-label">ตำแหน่ง</label>
                                        <input type="text" class="form-control" placeholder="" id="u_Position">
                                        <!-- <div  class="form-text">Enter your Last name</div> -->
                                    </div>
                                    <div class="col-md">
                                        <label class="form-label">เลขบัตรประจำตัวประชาชน</label>
                                        <input type="text" class="form-control" placeholder="" id="u_CardNumber">
                                        <!-- <div class="form-text">Enter your Full name</div> -->
                                    </div>
                                    <div class="col-md">
                                        <label class="form-label">วัน/เดือน/ปีเกิด</label>
                                        <input type="date" class="form-control" placeholder="" id="u_Birthday">
                                        <!-- <div  class="form-text">Enter your Last name</div> -->
                                    </div>
                                </div>

                                <div class="row g-2 p-2">
                                    <div class="col-md">
                                        <div class="col-md">
                                            <label class="form-label">บ้านเลขที่/หมู่</label>
                                            <input type="text" class="form-control" placeholder="" id="u_Address">
                                            <!-- <div  class="form-text">Enter your Last name</div> -->
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="col-md">
                                            <label class="form-label">ถนน</label>
                                            <input type="text" class="form-control" placeholder="" id="u_Road">
                                            <!-- <div  class="form-text">Enter your Last name</div> -->
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="col-md">
                                            <label class="form-label">ตำบล</label>
                                            <input type="text" class="form-control" placeholder="" id="u_SubDistrict">
                                            <!-- <div  class="form-text">Enter your Last name</div> -->
                                        </div>
                                    </div>

                                </div>
                                <div class="row g-2 p-2">
                                    <div class="col-md">
                                        <div class="col-md">
                                            <label class="form-label">อำเภอ</label>
                                            <input type="text" class="form-control" placeholder="" id="u_District">
                                            <!-- <div  class="form-text">Enter your Last name</div> -->
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="col-md">
                                            <label class="form-label">จังหวัด</label>
                                            <input type="text" class="form-control" placeholder="" id="u_Province">
                                            <!-- <div  class="form-text">Enter your Last name</div> -->
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="col-md">
                                            <label class="form-label">เบอร์โทรศัพท์</label>
                                            <input type="text" class="form-control" placeholder="" id="u_Phone">
                                            <!-- <div  class="form-text">Enter your Last name</div> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 p-2">
                                    <button type="button" class="btn btn-primary" onclick="updatePersionData()" id="btn_Add">บันทึก</button>
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
        const dt_table = $('#table-users').DataTable({
            ajax: "<?= $host_path ?>/backend/Service/usersList_api.php",
            //processing: true,
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'colvis'],
            responsive: true,
            language: {
                url: './src/assets/DataTables/LanguageTable/th.json'
            },
            initComplete: function() {
                $("#table-users_filter").append(`<label id="select-group" class="my-2 w-100"></label>`);

                this.api().columns(5).every(function() {
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
                    title: "โซน",
                    data: "z_Name",
                },
                {
                    targets: 6,
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
                    targets: 7,
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
                    targets: 8,
                    title: "ใบสมัคร",
                    data: null,
                    defaultContent: "",
                    render: function(data, type, row, meta) {
                        return `<a href="/ReserveSpace/document_signup.php">พิมพ์ใบสมัคร</a>`;
                    }
                },
                {
                    targets: 9,
                    title: "ปุ่มสถานะ",
                    data: null,
                    defaultContent: "",
                    render: function(data, type, row, meta) {
                        let status = row.u_Approve;
                        const u_Id = row.u_Id;
                        const ur_Id = row.ur_Id;
                        const u_Img = row.u_Img;
                        let txtBtn = "";
                        let txtHTML = "";
                        if (row.u_Username !== "admin") {
                            if (status === "0") {
                                txtBtn = `<button class="btn btn-primary" type="button" id="btn_Approve" onclick="fcApprove(this)" value="${u_Id}">อนุมัติ</button>`;
                            } else {
                                txtBtn = `<button class="btn btn-warning" type="button" id="btn_Cancel" onclick="cancelUser(this)" value="${u_Id}">ยกเลิก</button>`;
                            }
                            txtHTML = `<div class="d-grid gap-2 d-md-block" >` + txtBtn + `
                                        <button class="btn btn-danger" type="button" id="btn_Delete" onclick="deleteUser(this)" value="${u_Id}" data-u_Img="${u_Img}">ลบ</button>
                                        </div>`
                        }
                        return txtHTML;
                    }
                }
            ],
            order: [
                [5, 'asc']
            ],
            rowGroup: {
                dataSrc: 'z_Name'
            },
        });

        const fcApprove = (elm) => {
            let u_Id = elm.value;

            $.ajax({
                url: "<?= $host_path ?>/backend/Service/approveUser_api.php",
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

        const cancelUser = (elm) => {
            let u_Id = elm.value;

            $.ajax({
                url: "<?= $host_path ?>/backend/Service/cancelUser_api.php",
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

        const deleteUser = (elm) => {
            let u_Id = elm.value;
            let u_Img = $(elm).attr("data-u_Img");
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
                        url: "<?= $host_path ?>/backend/Service/userDelete_api.php",
                        type: "POST",
                        data: {
                            u_Id: u_Id,
                            u_Img: u_Img
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

        const checkRole = (ur_Id) => {
            if (ur_Id == "R001") {
                $('#RadioUser').prop("checked", true);
                $('#u_OfficerId-content').hide();
                $('#u_Position-content').hide();
                $('#u_IdWalkin-content').show();
                $('#u_Shop-content').show();
                $('#shop_Detail-content').show();
                $('#btn_Add').show();
            } else if (ur_Id == "R002") {
                $('#RadioAdmin').prop("checked", true);
                $('#u_OfficerId-content').show();
                $('#u_Position-content').show();
                $('#u_IdWalkin-content').hide();
                $('#u_Shop-content').hide();
                $('#shop_Detail-content').hide();
                $('#btn_Add').hide();
            }
        }
        const detailUser = (elm) => {
            let u_Id = elm.value;
            $.ajax({
                url: "<?= $host_path ?>/backend/Service/user_api.php",
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
                    let u_Img = "<?= $host_path ?>/src/img/upload/" + res.data.u_Img;

                    if (res.status == "success") {

                        $.ajax({
                            url: "<?= $host_path ?>/backend/Service/zone_api.php",
                            type: "POST",
                            dataType: "json",
                            success: function(res_Zone) {
                                let length = res_Zone.data.length;
                                $('#zoneName').empty();
                                for (let i = 0; i < length; i++) {
                                    if (zoneID === res_Zone.data[i].z_Id) {
                                        $('#zoneName').append(`<option selected value="${res_Zone.data[i].z_Id}">${res_Zone.data[i].z_Name}</option>`);
                                    } else {
                                        $('#zoneName').append(`<option value="${res_Zone.data[i].z_Id}">${res_Zone.data[i].z_Name}</option>`);
                                    }
                                }
                            }
                        });

                        $('#Prefix').empty();
                        $('#Prefix').append(`<option selected value="${res.data.u_Prefix}">${res.data.u_Prefix}</option>`);
                        $('#Prefix').append(`<option value="นาย">นาย</option>`);
                        $('#Prefix').append(`<option value="นาง">นาง</option>`);
                        $('#Prefix').append(`<option value="นางสาว">นางสาว</option>`);

                        $('#u_Password').val("");
                        $('#u_Id').html(res.data.u_Id);
                        $('#img').attr("src", u_Img);
                        $('#u_OfficerId').val(res.data.u_OfficerId);
                        $('#Prefix').val(res.data.u_Prefix);
                        $('#u_FullName').val(res.data.u_FirstName);
                        $('#u_Last').val(res.data.u_LastName);
                        $('#u_Username').val(res.data.u_Username);
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
                        $('#u_IdWalkin').val(res.data.u_IdWalkin);
                        checkRole(ur_Id);
                        if (res.data.u_Approve == 0) {
                            $("#password-content").prop('hidden', true);
                        } else {
                            $("#password-content").prop('hidden', false);
                        }

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

        $('#btnEditPassword').prop('disabled', true);
        $('#u_Password').keyup(function() {
            let val = $("#u_Password").val();
            if (event.key != "Enter") {
                if (val == "") {
                    $('#btnEditPassword').prop('disabled', true);
                } else {
                    $('#btnEditPassword').prop('disabled', false);
                }
            }
        })
        $('#btnEditPassword').click(function() {
            let u_Id = $('#u_Id').html();
            let u_PasswordNew = $('#u_Password').val();

            $.ajax({
                url: "/ReserveSpace/backend/Service/updatePassword_api.php",
                type: "POST",
                data: {
                    status: "admin",
                    u_Id: u_Id,
                    u_Password: "",
                    u_PasswordNew: u_PasswordNew
                },
                dataType: "json",
                success: function(res) {
                    let message = res.message;
                    let status = res.status;

                    if (status == "success") {
                        $('#detailModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: message,
                            showConfirmButton: true,
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
        })

        const updatePersionData = () => {
            let u_Id = $('#u_Id').html();
            let u_FirstName = $('#u_FullName').val();
            let u_LastName = $('#u_Last').val();
            let u_Username = $('#u_Username').val();
            let u_CardNumber = $('#u_CardNumber').val();
            let u_OfficerId = $('#u_OfficerId').val();
            let u_Position = $('#u_Position').val();
            let u_Phone = $('#u_Phone').val();
            let u_Prefix = $('#Prefix').val();
            let u_Birthday = $('#u_Birthday').val();
            let u_Address = $('#u_Address').val();
            let u_Road = $('#u_Road').val();
            let u_SubDistrict = $('#u_SubDistrict').val();
            let u_District = $('#u_District').val();
            let u_Province = $('#u_Province').val();
            let z_Id = $('#zoneName').val();
            let u_ShopName = $('#u_ShopName').val();
            let u_ProductName = $('#u_ProductName').val();
            let u_IdWalkin = $('#u_IdWalkin').val();

            let data = {
                u_Id: u_Id,
                u_FirstName: u_FirstName,
                u_LastName: u_LastName,
                u_Username: u_Username,
                u_CardNumber: u_CardNumber,
                u_OfficerId: u_OfficerId,
                u_Position: u_Position,
                u_Phone: u_Phone,
                u_Prefix: u_Prefix,
                u_Birthday: u_Birthday,
                u_Address: u_Address,
                u_Road: u_Road,
                u_SubDistrict: u_SubDistrict,
                u_District: u_District,
                u_Province: u_Province,
                z_Id: z_Id,
                u_ShopName: u_ShopName,
                u_ProductName: u_ProductName,
                u_IdWalkin: u_IdWalkin
            }
            $.ajax({
                url: "<?= $host_path ?>/backend/Service/updatePersionData_api.php",
                type: "POST",
                data: data,
                dataType: "json",
                success: function(res) {
                    let message = res.message;
                    let status = res.status;

                    if (status == "success") {
                        $('#detailModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: message,
                            showConfirmButton: true,
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
    </script>
</body>

</html>