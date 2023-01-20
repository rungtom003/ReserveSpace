<?php
session_start();
$user = (isset($_SESSION['user'])) ? unserialize($_SESSION['user']) : null;
if ($user == null) {
    header('location: /ReserveSpace/login.php');
}
$titleHead = "ข้อมูลส่วนตัว";
$active_persionData = "active";
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $$titleHead ?></title>
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
                                        <input type="text" class="form-control" placeholder="ID" id="u_OfficerId" value="<?= $user["u_OfficerId"] ?>">
                                        <!-- <div class="form-text">Enter your Full name</div> -->
                                    </div>
                                </div>
                                <div class="row g-2 p-2">
                                    <div class="col-md-2">
                                        <label class="form-label">คำนำหน้า</label>
                                        <select class="form-select" aria-label="Default select example" id="Prefix">
                                            <option selected value="<?= $user["u_Prefix"] ?>"><?= $user["u_Prefix"] ?></option>
                                            <option value="นาย">นาย</option>
                                            <option value="นาง">นาง</option>
                                            <option value="นางสาว">นางสาว</option>
                                        </select>
                                        <!-- <div class="form-text">Enter your Full name</div> -->
                                    </div>
                                    <div class="col-md">
                                        <label class="form-label">ชื่อ</label>
                                        <input type="text" class="form-control" placeholder="Full name" id="u_FullName" value="<?= $user["u_FirstName"] ?>">
                                        <!-- <div class="form-text">Enter your Full name</div> -->
                                    </div>
                                    <div class="col-md">
                                        <label class="form-label">นามสกุล</label>
                                        <input type="text" class="form-control" placeholder="Last name" id="u_Last" value="<?= $user["u_LastName"] ?>">
                                        <!-- <div  class="form-text">Enter your Last name</div> -->
                                    </div>
                                </div>

                                <div class="row g-2 p-2">
                                    <div class="col-md">
                                        <label class="form-label">ชื่อผู้ใช้</label>
                                        <input type="Username" class="form-control" placeholder="Username" id="u_Username" value="<?= $user["u_Username"] ?>" readonly>
                                        <!-- <div class="form-text">Enter your Full name</div> -->
                                    </div>
                                </div>
                                <div class="g-2 p-2">
                                    <?php if ($user["ur_Id"] == "R002") {
                                    ?>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="RadioAdmin" value="R002" checked>
                                            <label class="form-check-label" for="RadioAdmin">Admin</label>
                                        </div>
                                    <?php
                                    } else {
                                    ?>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="RadioUser" value="R001" checked>
                                            <label class="form-check-label" for="RadioUser">User</label>
                                        </div>

                                    <?php
                                    }
                                    ?>
                                </div>

                                <div class="row g-2 p-2">
                                    <div class="col-md">
                                        <label class="form-label">ตำแหน่ง</label>
                                        <input type="text" class="form-control" placeholder="" id="u_Position" value="<?= $user["u_Position"] ?>">
                                        <!-- <div  class="form-text">Enter your Last name</div> -->
                                    </div>
                                    <div class="col-md">
                                        <label class="form-label">เลขบัตรประจำตัวประชาชน</label>
                                        <input type="text" class="form-control" placeholder="" id="u_CardNumber" value="<?= $user["u_CardNumber"] ?>" readonly>
                                        <!-- <div class="form-text">Enter your Full name</div> -->
                                    </div>
                                    <div class="col-md">
                                        <label class="form-label">วัน/เดือน/ปีเกิด</label>
                                        <input type="date" class="form-control" placeholder="" id="u_Birthday" value="<?= $user["u_Birthday"] ?>">
                                        <!-- <div  class="form-text">Enter your Last name</div> -->
                                    </div>
                                </div>

                                <div class="row g-2 p-2">
                                    <div class="col-md">
                                        <div class="col-md">
                                            <label class="form-label">บ้านเลขที่/หมู่</label>
                                            <input type="text" class="form-control" placeholder="" id="u_Address" value="<?= $user["u_Address"] ?>">
                                            <!-- <div  class="form-text">Enter your Last name</div> -->
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="col-md">
                                            <label class="form-label">ถนน</label>
                                            <input type="text" class="form-control" placeholder="" id="u_Road" value="<?= $user["u_Road"] ?>">
                                            <!-- <div  class="form-text">Enter your Last name</div> -->
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="col-md">
                                            <label class="form-label">ตำบล</label>
                                            <input type="text" class="form-control" placeholder="" id="u_SubDistrict" value="<?= $user["u_SubDistrict"] ?>">
                                            <!-- <div  class="form-text">Enter your Last name</div> -->
                                        </div>
                                    </div>

                                </div>
                                <div class="row g-2 p-2">
                                    <div class="col-md">
                                        <div class="col-md">
                                            <label class="form-label">อำเภอ</label>
                                            <input type="text" class="form-control" placeholder="" id="u_District" value="<?= $user["u_District"] ?>">
                                            <!-- <div  class="form-text">Enter your Last name</div> -->
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="col-md">
                                            <label class="form-label">จังหวัด</label>
                                            <input type="text" class="form-control" placeholder="" id="u_Province" value="<?= $user["u_Province"] ?>">
                                            <!-- <div  class="form-text">Enter your Last name</div> -->
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="col-md">
                                            <label class="form-label">เบอร์โทรศัพท์</label>
                                            <input type="text" class="form-control" placeholder="" id="u_Phone" value="<?= $user["u_Phone"] ?>">
                                            <!-- <div  class="form-text">Enter your Last name</div> -->
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary" id="btn_update">บันทึก</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            <!-- end: Content -->
        </div>
    </main>
    <!-- end: Main -->
    <?php include("./layout/script.php"); ?>
    <script>
        function UpdatePersionData() {
            let u_FirstName = $('#u_FullName').val();
            let u_LastName = $('#u_Last').val();
            let u_Username = $('#u_Username').val();
            let u_CardNumber = $('#u_CardNumber').val();
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

            let data = {
                u_FirstName: u_FirstName,
                u_LastName: u_LastName,
                u_Username: u_Username,
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

            $.ajax({
                url: "/ReserveSpace/backend/Service/persionData_api.php",
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
                        }).then((result) => {
                            window.location.reload();
                        })

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'เเจ้งเตือน',
                            text: message
                        })
                    }


                }

            })
        }

        $('#btn_update').click(function(event) {
            event.preventDefault();
            UpdatePersionData();
        })
    </script>
</body>

</html>