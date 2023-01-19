<?php
session_start();
$user = (isset($_SESSION['user'])) ? unserialize($_SESSION['user']) : null;
if($user == null){
    header('location: /ReserveSpace/login.php');
}
$titleHead = "เพิ่มผู้ใช้งาน";
$active_signup = "active";
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Index</title>
    <?php include("./layout/css.php"); ?>
</head>

<body style="font-family: kanit-Regular;">
    <?php include("./layout/head.php"); ?>
    <!-- start: Main -->
    <main class="bg-light">
        <div class="p-2">
            <?php include("./layout/navmain.php"); ?>
            <div class="py-2">
                <!-- start: Content -->
                <div class="d-flex justify-content-center">
                    <div class="card w-75">
                        <div class="card-header">
                            Featured
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row g-2 p-2">
                                    <div class="col-md-3">
                                        <label class="form-label">รหัสเจ้าหน้าที่</label>
                                        <input type="text" class="form-control" placeholder="ID" id="u_OfficerId">
                                        <!-- <div class="form-text">Enter your Full name</div> -->
                                    </div>
                                </div>
                                <div class="row g-2 p-2">
                                    <div class="col-md-2">
                                        <label class="form-label">คำนำหน้า</label>
                                        <select class="form-select" aria-label="Default select example" id="Prefix">
                                            <option selected value="">เลือก</option>
                                            <option value="นาย">นาย</option>
                                            <option value="นาง">นาง</option>
                                            <option value="นางสาว">นางสาว</option>
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
                                        <input type="Username" class="form-control" placeholder="Username" id="u_Username">
                                        <!-- <div class="form-text">Enter your Full name</div> -->
                                    </div>
                                </div>
                                <div class="row g-2 p-2">
                                    <div class="col-md">
                                        <label class="form-label">รหัสผ่าน</label>
                                        <input type="Password" class="form-control" placeholder="Password" id="u_Password">

                                    </div>
                                </div>
                                <div class="g-2 p-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="RadioAdmin" value="R002">
                                        <label class="form-check-label" for="RadioAdmin">Admin</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="RadioUser" value="R001">
                                        <label class="form-check-label" for="RadioUser">User</label>
                                    </div>
                                </div>

                                <div class="row g-2 p-2">
                                    <div class="col-md">
                                        <label class="form-label">ตำแหน่ง</label>
                                        <input type="text" class="form-control" placeholder="" id="u_Position">
                                        <!-- <div  class="form-text">Enter your Last name</div> -->
                                    </div>
                                    <div class="col-md">
                                        <label class="form-label">เลขบัตรประจำตัวประชาชน</label>
                                        <input type="text" class="form-control" placeholder="" id="u_CarNumber">
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
                                <button type="submit" class="btn btn-primary" id="btn_signup">สร้างบัญชี</button>
                            </form>
                        </div>
                    </div>

                </div>
                <!-- end: Content -->
            </div>
        </div>
    </main>
    <!-- end: Main -->
    <?php include("./layout/script.php"); ?>
    <script>
        function signup() {
            let ur_Id = "";
            let u_FirstName = $('#u_FullName').val();
            let u_LastName = $('#u_Last').val();
            let u_Username = $('#u_Username').val();
            let u_Password = $('#u_Password').val();
            let u_CardNumber = $('#u_CarNumber').val();
            let u_OfficerId = $('#u_OfficerId').val();
            let u_Position = $('#u_Position').val();
            let u_Phone = $('#u_Phone').val();
            let u_Prefix = $('#Prefix').val();
            let u_Birthday = $('#u_Birthday').val();
            let u_Img = "";
            let u_Address = $('#u_Address').val();
            let u_Road = $('#u_Road').val();
            let u_SubDistrict = $('#u_SubDistrict').val();
            let u_District = $('#u_District').val();
            let u_Province = $('#u_Province').val();

            let RadioAdmin = $('#RadioAdmin').prop('checked')
            let RadioUser = $('#RadioUser').prop('checked')
            if (RadioAdmin == true && RadioUser == false) {
                ur_Id = $('#RadioAdmin').val();
            } else if (RadioAdmin == false && RadioUser == true) {
                ur_Id = $('#RadioUser').val();
            }

            let data = {
                ur_Id: ur_Id,
                u_FirstName: u_FirstName,
                u_LastName: u_LastName,
                u_Username: u_Username,
                u_Password: u_Password,
                u_CardNumber: u_CardNumber,
                u_OfficerId: u_OfficerId,
                u_Position: u_Position,
                u_Phone: u_Phone,
                u_Prefix: u_Prefix,
                u_Birthday: u_Birthday,
                u_Img: u_Img,
                u_Address: u_Address,
                u_Road: u_Road,
                u_SubDistrict: u_SubDistrict,
                u_District: u_District,
                u_Province: u_Province
            }

            if (ur_Id == "" || u_Username == "" || u_Password == "" || u_CardNumber == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'เเจ้งเตือน',
                    text: "กรอกข้อมูลไม่ครบ"
                })

            } else {
                $.ajax({
                    url: "/ReserveSpace/backend/Service/signup_api.php",
                    type: "POST",
                    data: data,
                    dataType: "json",
                    success: function(res) {
                        let message = res.message;

                        if (res.status == "success") {
                            Swal.fire({
                                icon: 'success',
                                title: message,
                                showConfirmButton: false,
                                timer: 1500
                            })

                        } else if (res.status == "Duplicate user") {
                            Swal.fire({
                                icon: 'warning',
                                title: 'เเจ้งเตือน',
                                text: message
                            })

                        } else if (res.status == "Duplicate card number") {
                            Swal.fire({
                                icon: 'warning',
                                title: 'เเจ้งเตือน',
                                text: message
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


        }

        $('#RadioAdmin').change(function() {
            $('#u_OfficerId').prop('readonly', false).attr('placeholder', 'ID').val("");
            $('#u_Position').prop('readonly', false);
            $('#u_Birthday').prop('readonly', true);
            $('#u_Address').prop('readonly', true).val("-");
            $('#u_Road').prop('readonly', true).val("-");
            $('#u_SubDistrict').prop('readonly', true).val("-");
            $('#u_District').prop('readonly', true).val("-");
            $('#u_Province').prop('readonly', true).val("-");
        })

        $('#RadioUser').change(function() {
            $('#u_OfficerId').prop('readonly', true).val("-");
            $('#u_Position').prop('readonly', true).val("-");
            $('#u_Birthday').prop('readonly', false);
            $('#u_Address').prop('readonly', false).val("");
            $('#u_Road').prop('readonly', false).val("");
            $('#u_SubDistrict').prop('readonly', false).val("");
            $('#u_District').prop('readonly', false).val("");
            $('#u_Province').prop('readonly', false).val("");
        })

        $('#btn_signup').click(function(even) {
            event.preventDefault();
            signup();
        })
    </script>
</body>

</html>