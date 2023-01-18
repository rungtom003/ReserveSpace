<?php
session_start();
$user = (isset($_SESSION['user'])) ? unserialize($_SESSION['user']) : null;
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
                                            <option selected>เลือก</option>
                                            <option value="1">นาย</option>
                                            <option value="2">นาง</option>
                                            <option value="3">นางสาว</option>
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
                                        <label class="form-label">Username</label>
                                        <input type="Username" class="form-control" placeholder="Username" id="u_Username">
                                        <!-- <div class="form-text">Enter your Full name</div> -->
                                    </div>
                                </div>
                                <div class="row g-2 p-2">
                                    <div class="col-md">
                                        <label class="form-label">Password</label>
                                        <input type="Password" class="form-control" placeholder="Password" id="u_Password">

                                    </div>
                                </div>
                                <div class="g-2 p-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                        <label class="form-check-label" for="inlineRadio1">Admin</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                                        <label class="form-check-label" for="inlineRadio2">User</label>
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
                                        <input type="text" class="form-control" placeholder="" id="u_Birthday">
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
                                <button type="submit" class="btn btn-primary">Submit</button>
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
    </script>
</body>

</html>