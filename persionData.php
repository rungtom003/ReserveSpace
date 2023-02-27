<?php
date_default_timezone_set("Asia/Bangkok");
include("./layout/static_path.php");
session_start();
$user = (isset($_SESSION['user'])) ? unserialize($_SESSION['user']) : null;
$startDate = (isset($_SESSION['os_StartDateTime'])) ? $_SESSION['os_StartDateTime'] : null;
$EndDate = (isset($_SESSION['os_EndDateTime'])) ? $_SESSION['os_EndDateTime'] : null;

if ($user == null) {
    header('location: ' . $host_path . '/login.php');
}else {
    if ($startDate != null && $EndDate != null && $user["ur_Id"] != "R002") {

        $StartTimestamp = strtotime(date('Y-m-d H:i:s', strtotime($startDate)));
        $EndTimestamp = strtotime(date('Y-m-d H:i:s', strtotime($EndDate)));
        $currentTimestamp = strtotime(date('Y-m-d H:i:s'));

        // Check if the current timestamp is greater than or equal to the set timestamp
        if ($currentTimestamp < $StartTimestamp) {
            header('location: ' . $host_path . '/countdow_time.php');
        }

        if($currentTimestamp > $EndTimestamp)
        {
            header('location: ' . $host_path . '/close_system.php');
        }
    }
}

$titleHead = "ข้อมูลส่วนตัว";
$active_persionData = "active";
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $titleHead ?></title>
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
                <div class="content d-flex flex-column flex-column-fluid">
                    <div class="d-flex justify-content-center">
                        <div class="card">
                            <div class="card-header">
                                ข้อมูลส่วนตัว
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="d-flex justify-content-center">
                                        <img class="img-fluid" id="img" alt="" src="<?= $host_path ?>/src/img/upload/<?= $user["u_Img"] ?>" style="height: 150px">
                                    </div>
                                    <span hidden id="ur_ID"><?= $user["ur_Id"] ?></span>
                                    <?php if ($user["ur_Id"] != "R001") { ?>
                                        <div class="row g-2 p-2">
                                            <div class="col-md-3">
                                                <label class="form-label">รหัสเจ้าหน้าที่</label>
                                                <input type="text" class="form-control" placeholder="" id="u_OfficerId" value="<?= $user["u_OfficerId"] ?>" readonly>
                                                <!-- <div class="form-text">Enter your Full name</div> -->
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php if ($user["ur_Id"] != "R002") { ?>
                                        <div class="row g-2 p-2">
                                            <div class="col-md-3">
                                                <label class="form-label">รหัส Walk in</label>
                                                <input type="text" class="form-control" placeholder="" id="u_IdWalkin" value="<?= $user["u_IdWalkin"] ?>">
                                                <!-- <div class="form-text">Enter your Full name</div> -->
                                            </div>
                                        </div>
                                    <?php } ?>
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

                                    <div class="row g-2 p-2 d-flex align-items-end">
                                        <div class="col-md">
                                            <label class="form-label">ชื่อผู้ใช้</label>
                                            <input type="Username" class="form-control" placeholder="Username" id="u_Username" value="<?= $user["u_Username"] ?>">
                                            <!-- <div class="form-text">Enter your Full name</div> -->
                                        </div>
                                        <!-- <div class="col-md-3">
                                            <label class="form-label"></label>
                                            <button type="button" class="btn btn-primary" id="btnEditUser">แก้ไขชื่อผู้ใช้</button>
                                        </div> -->
                                    </div>
                                    <div class="row g-2 p-2 d-flex align-items-end">
                                        <div class="col-md">
                                            <label class="form-label">รหัสผ่านเดิม</label>
                                            <input type="Username" class="form-control" placeholder="********" id="u_PasswordOld">
                                            <!-- <div class="form-text">Enter your Full name</div> -->
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label">รหัสผ่านใหม่</label>
                                            <input type="Username" class="form-control" placeholder="" id="u_PasswordNew">
                                            <!-- <div class="form-text">Enter your Full name</div> -->
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label"></label>
                                            <button type="button" class="btn btn-primary" id="btnEditPassword">แก้ไขรหัสผ่าน</button>
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
                                    <?php if ($user["ur_Id"] == "R001") { ?>
                                        <div class="row g-2 p-2">
                                            <div class="col-md">
                                                <label class="form-label">ชื่อร้าน</label>
                                                <input type="text" class="form-control" placeholder="" value="<?= $user["u_ShopName"] ?>" id="u_ShopName" required>
                                                <div class="invalid-feedback">
                                                    กรุณากรอก ชื่อร้าน
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <span hidden id="zoneID"><?= $user["z_Id"] ?></span>
                                                <label class="form-label">โซน</label>
                                                <select class="form-select" aria-label="Default select example" id="selectZoneName" readonly required>
                                                    <option selected value="<?= $user["z_Id"] ?>"></option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    กรุณาเลือก โซน
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-2 p-2">
                                            <div class="mb-3">
                                                <label for="u_ProductName" class="form-label">รายละเอียดสินค้า</label>
                                                <textarea class="form-control" id="u_ProductName" rows="3" required><?= $user["u_ProductName"] ?></textarea>
                                            </div>
                                            <div class="invalid-feedback">
                                                กรุณาเลือก รายละเอียดสินค้า
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <div class="row g-2 p-2">
                                        <?php if ($user["ur_Id"] != "R001") { ?>
                                            <div class="col-md">
                                                <label class="form-label">ตำแหน่ง</label>
                                                <input type="text" class="form-control" placeholder="" id="u_Position" value="<?= $user["u_Position"] ?>">
                                                <!-- <div  class="form-text">Enter your Last name</div> -->
                                            </div>
                                        <?php } ?>
                                        <div class="col-md">
                                            <label class="form-label">เลขบัตรประจำตัวประชาชน</label>
                                            <input type="text" class="form-control" placeholder="" id="u_CardNumber" value="<?= $user["u_CardNumber"] ?>">
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

                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">อัพโหลดรูป</label>
                                        <input class="form-control" type="file" id="formFile">
                                    </div>

                                    <div hidden>
                                        <h2>Original Image</h2>
                                        <img style="margin-top: 5px;" id="originalImage" crossorigin="anonymous" />
                                    </div>
                                    <div class="d-flex flex-column align-items-center">
                                        <img id="compressedImage" />
                                    </div>

                                    <div class="row g-2 p-2">
                                        <button type="submit" class="btn btn-primary" id="btn_update">บันทึก</button>
                                    </div>

                                </form>
                            </div>
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
        let compressedImageBlob;
        let fileIMG = null;

        function loadZone() {
            let zoneID = $('#zoneID').html();
            $.ajax({
                url: "<?= $host_path ?>/backend/Service/zone_api.php",
                type: "POST",
                dataType: "json",
                success: function(res) {
                    let length = res.data.length;

                    $('#selectZoneName').empty()
                    for (let i = 0; i < length; i++) {
                        if (zoneID === res.data[i].z_Id) {
                            $('#selectZoneName').append(`<option selected value="${res.data[i].z_Id}">${res.data[i].z_Name}</option>`);
                        }
                    }
                }
            });
        }

        function UpdatePersionData() {
            let u_Id = "<?= $user["u_Id"] ?>";
            let role = "<?= $user["ur_Id"] ?>";
            let u_OfficerId = "";
            let u_Position = "";
            if (role === "R002") {
                u_OfficerId = $('#u_OfficerId').val();
                u_Position = $('#u_Position').val();
            }

            let u_FirstName = $('#u_FullName').val();
            let u_LastName = $('#u_Last').val();
            let u_Username = $('#u_Username').val();
            let u_CardNumber = $('#u_CardNumber').val();
            let u_Phone = $('#u_Phone').val();
            let u_Prefix = $('#Prefix').val();
            let u_Birthday = $('#u_Birthday').val();
            let u_Img = "";
            let u_Address = $('#u_Address').val();
            let u_Road = $('#u_Road').val();
            let u_SubDistrict = $('#u_SubDistrict').val();
            let u_District = $('#u_District').val();
            let u_Province = $('#u_Province').val();

            let z_Id = "";
            let u_ShopName = "";
            let u_ProductName = "";
            let u_IdWalkin = "";

            if (role === "R001") {
                z_Id = $('#selectZoneName').val();
                u_ShopName = $('#u_ShopName').val();
                u_ProductName = $('#u_ProductName').val();
                u_IdWalkin = $('#u_IdWalkin').val();
            }

            if (fileIMG !== null) {
                u_Img = fileIMG;
            }

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

            const formData = new FormData();
            formData.append('u_Id',u_Id);
            formData.append('u_FirstName',u_FirstName);
            formData.append('u_LastName',u_LastName);
            formData.append('u_Username',u_Username);
            formData.append('u_CardNumber',u_CardNumber);
            formData.append('u_OfficerId',u_OfficerId);
            formData.append('u_Position',u_Position);
            formData.append('u_Phone',u_Phone);
            formData.append('u_Prefix',u_Prefix);
            formData.append('u_Birthday',u_Birthday);
            formData.append('u_Address',u_Address);
            formData.append('u_Road',u_Road);
            formData.append('u_SubDistrict',u_SubDistrict);
            formData.append('u_District',u_District);
            formData.append('u_Province',u_Province);
            formData.append('z_Id',z_Id);
            formData.append('u_ShopName',u_ShopName);
            formData.append('u_ProductName',u_ProductName);
            formData.append('u_IdWalkin',u_IdWalkin);
            formData.append('u_Img',u_Img);
            formData.append('deleteImg',"<?=$user["u_Img"]?>");


            $.ajax({
                url: "<?= $host_path ?>/backend/Service/persionData_api.php",
                type: "POST",
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
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
        loadZone();

        function update_User() {
            let u_Id = "<?= $user["u_Id"] ?>";
            let u_Username = $('#u_Username').val();
            $.ajax({
                url: "<?= $host_path ?>/backend/Service/updateUser_api.php",
                type: "POST",
                data: {
                    u_Id: u_Id,
                    u_Username: u_Username
                },
                dataType: "json",
                success: function(res) {
                    let message = res.message;
                    let status = res.status;
                    if (status == "success") {
                        Swal.fire({
                            icon: 'success',
                            title: message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then((result) => {
                            window.location.href = "<?= $host_path ?>/backend/Service/logout_api.php"
                        })

                    } else if (status == "Duplicate user") {
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

        function update_Password() {
            let u_Id = "<?= $user["u_Id"] ?>";
            let u_PasswordOld = $('#u_PasswordOld').val();
            let u_PasswordNew = $('#u_PasswordNew').val();

            $.ajax({
                url: "<?= $host_path ?>/backend/Service/updatePassword_api.php",
                type: "POST",
                data: {
                    status: "user",
                    u_Id: u_Id,
                    u_Password: u_PasswordOld,
                    u_PasswordNew: u_PasswordNew
                },
                dataType: "json",
                success: function(res) {
                    //console.log(res)
                    let message = res.message;
                    let status = res.status;
                    if (status == "success") {
                        Swal.fire({
                            icon: 'success',
                            title: message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then((result) => {
                            window.location.href = "<?= $host_path ?>/backend/Service/logout_api.php"
                        })

                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'เเจ้งเตือน',
                            text: message
                        })
                    }


                }
            });
        }

        $('#btn_update').click(function(event) {
            event.preventDefault();
            UpdatePersionData();
        })

        $('#btnEditUser').prop('disabled', true);
        let u_Username = $('#u_Username').val()
        $('#u_Username').keyup(function() {
            let val = $("#u_Username").val();
            if (event.key != "Enter") {
                if (val == "" || val == u_Username) {
                    $('#btnEditUser').prop('disabled', true);
                } else {
                    $('#btnEditUser').prop('disabled', false);
                }
            }
        })

        $('#btnEditPassword').prop('disabled', true);
        let u_PasswordOld = $('#u_PasswordOld').val()
        let u_PasswordNew = $('#u_PasswordNew').val()
        $('#u_PasswordOld').keyup(function() {
            let valOld = $("#u_PasswordOld").val();
            let valNew = $("#u_PasswordNew").val();
            if (event.key != "Enter") {
                if (valOld == "" || valNew == "") {
                    $('#btnEditPassword').prop('disabled', true);
                } else {
                    $('#btnEditPassword').prop('disabled', false);
                }
            }
        })

        $('#u_PasswordNew').keyup(function() {
            let valOld = $("#u_PasswordOld").val();
            let valNew = $("#u_PasswordNew").val();
            if (event.key != "Enter") {
                if (valOld == "" || valNew == "") {
                    $('#btnEditPassword').prop('disabled', true);
                } else {
                    $('#btnEditPassword').prop('disabled', false);
                }
            }
        })

        $('#btnEditUser').click(function(event) {
            event.preventDefault();
            update_User()
        })

        $('#btnEditPassword').click(function(event) {
            event.preventDefault();
            update_Password()
        })

        const fileInput = document.querySelector("#formFile");
        const originalImage = document.querySelector("#originalImage");

        const compressedImage = document.querySelector("#compressedImage");

        let resizingFactor = 0.8;
        let quality = 0.8;

        fileInput.addEventListener("change", async (e) => {
            const [file] = fileInput.files;

            //storing the original image
            originalImage.src = await fileToDataUri(file);

            // compressing the uplodaded image
            originalImage.addEventListener("load", () => {
                compressImage(originalImage, resizingFactor, quality);
            });

            return false;
        });

        function compressImage(imgToCompress, resizingFactor, quality) {
            // showing the compressed image
            const canvas = document.createElement("canvas");
            const context = canvas.getContext("2d");

            const originalWidth = imgToCompress.width;
            const originalHeight = imgToCompress.height;

            let resizingFactor_fill = 100;

            for (let i = 0; i < 100; i++) {
                resizingFactor = parseInt(resizingFactor_fill) / 100;
                const canvasWidth = originalWidth * resizingFactor;
                const canvasHeight = originalHeight * resizingFactor;

                if (canvasWidth <= 300) {
                    canvas.width = canvasWidth;
                    canvas.height = canvasHeight;

                    context.drawImage(
                        imgToCompress,
                        0,
                        0,
                        originalWidth * resizingFactor,
                        originalHeight * resizingFactor
                    );

                    const file = document.getElementById("formFile").files[0];

                    // reducing the quality of the image
                    canvas.toBlob(
                        (blob) => {
                            if (blob) {
                                compressedImageBlob = blob;
                                compressedImage.src = URL.createObjectURL(compressedImageBlob);
                                //document.querySelector("#size").innerHTML = bytesToSize(blob.size);
                                fileIMG = new File([blob], file.name, {
                                    type: 'image/jpeg'
                                });
                            }
                        },
                        "image/jpeg",
                        quality
                    );
                    break;
                }
                resizingFactor_fill = resizingFactor_fill - 1;
            }
        }

        function fileToDataUri(field) {
            return new Promise((resolve) => {
                const reader = new FileReader();
                reader.addEventListener("load", () => {
                    resolve(reader.result);
                });
                reader.readAsDataURL(field);
            });
        }

        function bytesToSize(bytes) {
            var sizes = ["Bytes", "KB", "MB", "GB", "TB"];

            if (bytes === 0) {
                return "0 Byte";
            }

            const i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));

            return Math.round(bytes / Math.pow(1024, i), 2) + " " + sizes[i];
        }


    </script>
</body>

</html>