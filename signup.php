<?php
date_default_timezone_set("Asia/Bangkok");
include("./layout/static_path.php");
session_start();
$user = (isset($_SESSION['user'])) ? unserialize($_SESSION['user']) : null;
$startDate = (isset($_SESSION['os_StartDateTime'])) ? $_SESSION['os_StartDateTime'] : null;
$EndDate = (isset($_SESSION['os_EndDateTime'])) ? $_SESSION['os_EndDateTime'] : null;

if ($user == null) {
    header('location: '.$host_path.'/login.php');
}

if ($user["ur_Id"] == "R001") {
    header('location: '.$host_path.'/noaccess.php');
}

$titleHead = "เพิ่มผู้ใช้งาน";
$active_signup = "active";
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$titleHead?></title>
    <?php include("./layout/css.php"); ?>
</head>

<body style="font-family: kanit-Regular;">
    <?php include("./layout/head.php"); ?>
    <!-- start: Main -->
    <main class="bg-light">
        <div class="p-2">
            <?php include("./layout/navmain.php"); ?>
            <div class="py-2" style="font-family: kanit-Regular;">
                <!-- start: Content -->
                <div class="d-flex justify-content-center">
                    <div class="card w-75">
                        <div class="card-header">
                            เพิ่มผู้เข้าใช้งาน
                        </div>
                        <div class="card-body">
                            <form class="needs-validation" novalidate>
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
                                <div class="row g-2 p-2" id="u_OfficerId-content" hidden>
                                    <div class="col-md-3">
                                        <label class="form-label">รหัสเจ้าหน้าที่</label>
                                        <input type="text" class="form-control" placeholder="ID" id="u_OfficerId">
                                        <div class="invalid-feedback">
                                            กรุณากรอก รหัสเจ้าหน้าที่
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 p-2" id="u_IdWalkin-content" hidden>
                                    <div class="col-md-3">
                                        <label class="form-label">รหัส Walk in</label>
                                        <input type="text" class="form-control" placeholder="" id="u_IdWalkin">
                                    </div>
                                </div>
                                <div class="row g-2 p-2" id="fullname-content" hidden>
                                    <div class="col-md-2">
                                        <label class="form-label">คำนำหน้า</label>
                                        <select class="form-select" id="Prefix" required>
                                            <option selected disabled value="">เลือก</option>
                                            <option value="นาย">นาย</option>
                                            <option value="นาง">นาง</option>
                                            <option value="นางสาว">นางสาว</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            เลิอก คำนำหน้า
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <label class="form-label">ชื่อ</label>
                                        <input type="text" class="form-control" placeholder="Full name" id="u_FullName">
                                        <div class="invalid-feedback">
                                            กรุณากรอก ชื่อ
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <label class="form-label">นามสกุล</label>
                                        <input type="text" class="form-control" placeholder="Last name" id="u_Last">
                                        <div class="invalid-feedback">
                                            กรุณากรอก นามสกุล
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-2 p-2" id="username-content" hidden>
                                    <div class="col-md">
                                        <label class="form-label">ชื่อผู้ใช้</label>
                                        <input type="Username" class="form-control" placeholder="Username" id="u_Username">
                                        <div class="invalid-feedback">
                                            กรุณากรอก ชื่อผู้ใช้
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 p-2" id="password-content" hidden>
                                    <div class="col-md">
                                        <label class="form-label">รหัสผ่าน</label>
                                        <input type="Password" class="form-control" placeholder="Password" id="u_Password">
                                        <div class="invalid-feedback">
                                            กรุณากรอก รหัสผ่าน
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-2 p-2" id="shop-content" hidden>
                                <div class="row g-2 p-2">
                                    <div class="col-md" id="g-u_ShopName" hidden>
                                        <label class="form-label">ชื่อร้าน</label>
                                        <input type="text" class="form-control" placeholder="" id="u_ShopName">
                                        <div class="invalid-feedback">
                                            กรุณากรอก ชื่อร้าน
                                        </div>
                                    </div>
                                    <div class="col-md-3" id="g-selectZoneName" hidden>
                                        <label class="form-label">โซน</label>
                                        <select class="form-select" aria-label="Default select example" id="selectZoneName">
                                            <option selected disabled value="">เลือก.....</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            กรุณาเลือก โซน
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 p-2" id="g-u_ProductName" hidden>
                                    <div class="mb-3">
                                        <label for="u_ProductName" class="form-label">รายละเอียดสินค้า</label>
                                        <textarea class="form-control" id="u_ProductName" rows="3"></textarea>
                                    </div>
                                    <div class="invalid-feedback">
                                        กรุณาเลือก รายละเอียดสินค้า
                                    </div>
                                </div>
                                </div>

                                
                                <div class="row g-2 p-2">
                                    <div class="col-md" id="position-content" hidden>
                                        <label class="form-label">ตำแหน่ง</label>
                                        <input type="text" class="form-control" placeholder="" id="u_Position">
                                        <div class="invalid-feedback">
                                            กรุณากรอก ตำแหน่ง
                                        </div>
                                    </div>
                                    <div class="col-md" id="idcard-content" hidden>
                                        <label class="form-label">เลขบัตรประจำตัวประชาชน</label>
                                        <input type="text" class="form-control" placeholder="" id="u_CarNumber">
                                        <div class="invalid-feedback">
                                            กรุณากรอก เลขบัตรประจำตัวประชาชน
                                        </div>
                                    </div>
                                    <div class="col-md" id="u_Birthday-content" hidden>
                                        <label class="form-label">วัน/เดือน/ปีเกิด</label>
                                        <input type="date" class="form-control" placeholder="" id="u_Birthday">
                                        <div class="invalid-feedback">
                                            กรุณากรอก วัน/เดือน/ปีเกิด
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-2 p-2" id="address-content1" hidden>
                                    <div class="col-md">
                                        <div class="col-md">
                                            <label class="form-label">บ้านเลขที่/หมู่</label>
                                            <input type="text" class="form-control" placeholder="" id="u_Address">
                                            <div class="invalid-feedback">
                                                กรุณากรอก ที่อยู่
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="col-md">
                                            <label class="form-label">ถนน</label>
                                            <input type="text" class="form-control" placeholder="" id="u_Road">
                                            <div class="invalid-feedback">
                                                กรุณากรอก ถนน
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="col-md">
                                            <label class="form-label">ตำบล</label>
                                            <input type="text" class="form-control" placeholder="" id="u_SubDistrict">
                                            <div class="invalid-feedback">
                                                กรุณากรอก ตำบล
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row g-2 p-2" id="address-content2" hidden>
                                    <div class="col-md">
                                        <div class="col-md">
                                            <label class="form-label">อำเภอ</label>
                                            <input type="text" class="form-control" placeholder="" id="u_District">
                                            <div class="invalid-feedback">
                                                กรุณากรอก อำเภอ
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="col-md">
                                            <label class="form-label">จังหวัด</label>
                                            <input type="text" class="form-control" placeholder="" id="u_Province">
                                            <div class="invalid-feedback">
                                                กรุณากรอก จังหวัด
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="col-md">
                                            <label class="form-label">เบอร์โทรศัพท์</label>
                                            <input type="text" class="form-control" placeholder="" id="u_Phone">
                                            <div class="invalid-feedback">
                                                กรุณากรอก เบอร์โทรศัพท์
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3" id="upload-content" hidden>
                                    <label for="formFile" class="form-label">อัพโหลดรูปผู้ประกอบการ</label>
                                    <input class="form-control" type="file" id="formFile">
                                </div>

                                <div hidden>
                                    <h2>Original Image</h2>
                                    <img style="margin-top: 5px;" id="originalImage" crossorigin="anonymous" />
                                </div>

                                <div class="d-flex flex-column align-items-center" id="content-submit">
                                    <h2 hidden id="compimg">Compressed Image</h2>
                                    <!-- <div><b>Size:</b> <span id="size"></span></div> -->
                                    <img id="compressedImage" />
                                    <button type="submit" class="btn btn-primary my-3" id="btn_signup" hidden>สร้างบัญชี</button>
                                </div>
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
        let compressedImageBlob;
        let fileIMG = null;

        function checkRole() {
            if ($("#RadioAdmin").prop('checked') === false && $("#RadioUser").prop('checked') === false) {
                $("#btn_signup").prop('hidden', true);

                $("#u_OfficerId-content").prop('hidden', true);
                $("#fullname-content").prop('hidden', true);
                $("#username-content").prop('hidden', true);
                $("#password-content").prop('hidden', true);
                $("#position-content").prop('hidden', true);
                $("#idcard-content").prop('hidden', true);
                $("#u_Birthday-content").prop('hidden', true);
                $("#address-content1").prop('hidden', true);
                $("#address-content2").prop('hidden', true);
                $("#upload-content").prop('hidden', true);
                $("#g-u_ShopName").prop('hidden', true);
                $("#g-selectZoneName").prop('hidden', true);
                $("#g-u_ProductName").prop('hidden', true);
                $("#compimg").prop('hidden', true);


            } else if ($("#RadioAdmin").prop('checked') === true && $("#RadioUser").prop('checked') === false) {
                $("#btn_signup").prop('hidden', false);

                $("#u_OfficerId-content").prop('hidden', false);
                $("#fullname-content").prop('hidden', false);
                $("#username-content").prop('hidden', false);
                $("#password-content").prop('hidden', false);
                $("#position-content").prop('hidden', false);
                $("#idcard-content").prop('hidden', false);
                $("#u_Birthday-content").prop('hidden', false);
                $("#address-content1").prop('hidden', false);
                $("#address-content2").prop('hidden', false);
                $("#upload-content").prop('hidden', false);

                $('#u_IdWalkin-content').prop('hidden', true);
                $('#shop-content').prop('hidden', true);
                $("#u_OfficerId").prop("required", true);
                $("#u_FullName").prop("required", true);
                $("#u_Last").prop("required", true);
                $("#u_Username").prop("required", true);
                $("#u_Password").prop("required", true);
                $("#u_Position").prop("required", true);
                $("#u_CarNumber").prop("required", true);
                $("#u_Birthday").prop("required", true);
                $("#u_Address").prop("required", true);
                $("#u_SubDistrict").prop("required", true);
                $("#u_District").prop("required", true);
                $("#u_Province").prop("required", true);
                $("#u_Phone").prop("required", true);

                $("#u_OfficerId").prop("value", "");
                $("#u_FullName").prop("value", "");
                $("#u_Last").prop("value", "");
                $("#u_Username").prop("value", "");
                $("#u_Password").prop("value", "");
                $("#u_Position").prop("value", "");
                $("#u_CarNumber").prop("value", "");
                $("#u_Birthday").prop("value", "");
                $("#u_Address").prop("value", "");
                $("#u_Road").prop("value", "");
                $("#u_SubDistrict").prop("value", "");
                $("#u_District").prop("value", "");
                $("#u_Province").prop("value", "");
                $("#u_Phone").prop("value", "");
                $("#u_ShopName").prop("value", "");
                $("#selectZoneName").prop("value", "");
                $("#u_ProductName").prop("value", "");

                $("#compimg").prop('hidden', false);

            } else {
                $("#btn_signup").prop('hidden', false);

                $("#u_OfficerId-content").prop('hidden', true);
                $('#u_IdWalkin-content').prop('hidden', false);
                $("#fullname-content").prop('hidden', false);
                $("#username-content").prop('hidden', false);
                $("#password-content").prop('hidden', false);
                $("#position-content").prop('hidden', true);
                $("#idcard-content").prop('hidden', false);
                $("#u_Birthday-content").prop('hidden', false);
                $("#address-content1").prop('hidden', false);
                $("#address-content2").prop('hidden', false);
                $("#upload-content").prop('hidden', false);
                $("#g-u_ShopName").prop('hidden', false);
                $("#g-selectZoneName").prop('hidden', false);
                $("#g-u_ProductName").prop('hidden', false);
                $('#shop-content').prop('hidden', false);

                $("#u_OfficerId").prop("required", false);
                $("#u_FullName").prop("required", true);
                $("#u_Last").prop("required", true);
                $("#u_Username").prop("required", true);
                $("#u_Password").prop("required", true);
                $("#u_Position").prop("required", false);
                $("#u_CarNumber").prop("required", true);
                $("#u_Birthday").prop("required", true);
                $("#u_Address").prop("required", true);
                $("#u_SubDistrict").prop("required", true);
                $("#u_District").prop("required", true);
                $("#u_Province").prop("required", true);
                $("#u_Phone").prop("required", true);
                $("#u_ShopName").prop('required', true);
                $("#selectZoneName").prop('required', true);
                $("#u_ProductName").prop('required', true);

                $("#u_OfficerId").prop("value", "");
                $("#u_FullName").prop("value", "");
                $("#u_Last").prop("value", "");
                $("#u_Username").prop("value", "");
                $("#u_Password").prop("value", "");
                $("#u_Position").prop("value", "");
                $("#u_CarNumber").prop("value", "");
                $("#u_Birthday").prop("value", "");
                $("#u_Address").prop("value", "");
                $("#u_Road").prop("value", "");
                $("#u_SubDistrict").prop("value", "");
                $("#u_District").prop("value", "");
                $("#u_Province").prop("value", "");
                $("#u_Phone").prop("value", "");
                $("#u_ShopName").prop("value", "");
                $("#selectZoneName").prop("value", "");
                $("#u_ProductName").prop("value", "");

                $("#compimg").prop('hidden', false);
            }
        }

        function loadZone() {
            $.ajax({
                url: "<?=$host_path?>/backend/Service/zone_api.php",
                type: "POST",
                dataType: "json",
                success: function(res) {
                    let length = res.data.length;
                    $('#selectZoneName').empty()
                    for (let i = 0; i < length; i++) {
                        $('#selectZoneName').append(`<option value="${res.data[i].z_Id}">${res.data[i].z_Name}</option>`);
                    }
                }
            });
        }

        function signup() {
            const file = document.getElementById("formFile").files[0];
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
            let u_Img = null;
            let u_Address = $('#u_Address').val();
            let u_Road = $('#u_Road').val();
            let u_SubDistrict = $('#u_SubDistrict').val();
            let u_District = $('#u_District').val();
            let u_Province = $('#u_Province').val();
            let z_Id = $('#selectZoneName').val();
            let u_ShopName = $('#u_ShopName').val();
            let u_ProductName = $('#u_ProductName').val();
            let u_IdWalkin = $('#u_IdWalkin').val()

            let RadioAdmin = $('#RadioAdmin').prop('checked')
            let RadioUser = $('#RadioUser').prop('checked')
            if (RadioAdmin == true && RadioUser == false) {
                ur_Id = $('#RadioAdmin').val();
            } else if (RadioAdmin == false && RadioUser == true) {
                ur_Id = $('#RadioUser').val();
            }

            if (fileIMG !== null) {
                u_Img = fileIMG;
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
                u_Province: u_Province,
                z_Id: z_Id,
                u_ShopName: u_ShopName,
                u_ProductName: u_ProductName,
                u_IdWalkin:u_IdWalkin
            }

            const formData = new FormData();
            formData.append("ur_Id", data.ur_Id);
            formData.append("u_FirstName", data.u_FirstName);
            formData.append("u_LastName", data.u_LastName);
            formData.append("u_Username", data.u_Username);
            formData.append("u_Password", data.u_Password);
            formData.append("u_CardNumber", data.u_CardNumber);
            formData.append("u_OfficerId", data.u_OfficerId);
            formData.append("u_Position", data.u_Position);
            formData.append("u_Phone", data.u_Phone);
            formData.append("u_Prefix", data.u_Prefix);
            formData.append("u_Birthday", data.u_Birthday);
            formData.append("u_Address", data.u_Address);
            formData.append("u_Road", data.u_Road);
            formData.append("u_SubDistrict", data.u_SubDistrict);
            formData.append("u_District", data.u_District);
            formData.append("u_Province", data.u_Province);
            formData.append("u_Img", data.u_Img);
            formData.append("z_Id", data.z_Id);
            formData.append("u_ShopName", data.u_ShopName);
            formData.append("u_ProductName", data.u_ProductName);
            formData.append("u_IdWalkin", data.u_IdWalkin);

            $.ajax({
                url: "<?=$host_path?>/backend/Service/signup_api.php",
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

        $('#RadioAdmin').change(function() {
            checkRole();
        })

        $('#RadioUser').change(function() {
            checkRole();
        })

        loadZone();

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                event.preventDefault()
                event.stopPropagation()
                if (form.checkValidity()) {
                    signup();
                }
                form.classList.add('was-validated');
            }, false)
        })


        const fileInput = document.querySelector("#formFile");
        const originalImage = document.querySelector("#originalImage");

        const compressedImage = document.querySelector("#compressedImage");

        //const resizingElement = document.querySelector("#resizingRange");
        //const qualityElement = document.querySelector("#qualityRange");
        //const uploadButton = document.querySelector("#uploadButton");

        let resizingFactor = 0.8;
        let quality = 0.8;

        // initializing the compressed image
        //compressImage(originalImage, resizingFactor, quality);

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

        // resizingElement.oninput = (e) => {
        //     resizingFactor = parseInt(e.target.value) / 100;
        //     compressImage(originalImage, resizingFactor, quality);
        // };

        // qualityElement.oninput = (e) => {
        //     quality = parseInt(e.target.value) / 100;
        //     compressImage(originalImage, resizingFactor, quality);
        // };

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