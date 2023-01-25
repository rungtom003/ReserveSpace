<?php
session_start();
$user = (isset($_SESSION['user'])) ? unserialize($_SESSION['user']) : null;
if ($user == null) {
    header('location: /ReserveSpace/login.php');
}
$titleHead = "จองพื้นที่ขาย";
$active_index = "active";
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $titleHead ?></title>
    <?php include("./layout/css.php"); ?>
    <style>
        div.reserve-box-green {
            width: 80px;
            height: 80px;
            background: #229954;
            border-radius: 10px;
            margin: 5px;
            cursor: pointer;
            font-family: kanit-Regular;
            transition: background-color 0.5s
        }

        div.reserve-box-green:hover {
            background-color: #52BE80;
        }

        div.reserve-box-yellow {
            width: 80px;
            height: 80px;
            background: #F1C40F;
            border-radius: 10px;
            margin: 5px;
            cursor: pointer;
            font-family: kanit-Regular;
            transition: background-color 0.5s
        }

        div.reserve-box-yellow:hover {
            background-color: #F7DC6F;
        }


        div.reserve-box-red {
            width: 80px;
            height: 80px;
            background: #CB4335;
            border-radius: 10px;
            margin: 5px;
            cursor: pointer;
            font-family: kanit-Regular;
            transition: background-color 0.5s
        }

        div.reserve-box-red:hover {
            background-color: #EC7063;
        }

        div.reserve-box-primary {
            width: 80px;
            height: 80px;
            background: #3498DB;
            border-radius: 10px;
            margin: 5px;
            cursor: pointer;
            font-family: kanit-Regular;
            transition: background-color 0.5s
        }

        div.reserve-box-primary:hover {
            background-color: #85C1E9;
        }
    </style>
</head>

<body style="font-family: kanit-Regular;">
    <?php include("./layout/head.php"); ?>
    <!-- start: Main -->
    <main class="bg-light">
        <div class="p-2">
            <?php include("./layout/navmain.php"); ?>
            <!-- start: Content -->
            <div class="py-1">
                <!-- start: Graph -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-end">
                            <!-- <div id="img-content" class="d-flex flex-column justify-content-center align-items-center">
                                <img id="image" src="./src/img/tibet-1.jpg" alt="Cuo Na Lake" style="width: 80px;">
                                <a href="/ReserveSpace/real.php" style="font-family: kanit-Regular;">ดูพื้นที่จริง</a>
                            </div> -->


                            <div class="d-flex justify-content-center align-items-center reserve-box-green">
                                <span class="text-light text-center">ว่าง</span>
                            </div>
                            <div class="d-flex justify-content-center align-items-center reserve-box-red">
                                <span class="text-light text-center">จองเเล้ว</span>
                            </div>
                            <div class="d-flex justify-content-center align-items-center reserve-box-yellow">
                                <span class="text-light text-center">รอดำเนินการ</span>
                            </div>
                            <div class="d-flex justify-content-center align-items-center reserve-box-primary">
                                <span class="text-light text-center">รายการที่เลือก</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card my-1">
                    <div class="card-body">
                        <div class="d-flex align-content-start flex-wrap" id="reserve-content">


                        </div>
                    </div>
                </div>
                <!-- end: Graph -->
            </div>
            <!-- end: Content -->
        </div>
    </main>
    <!-- end: Main -->

    <!-- Modal -->
    <div class="modal fade" id="reserve-detail-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="reserve-detail-modal-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="reserve-detail-modal-label">รายละเอียดการจอง</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul>
                        <li class="fw-bold">ชื่อผู้จอง : <span class="fw-normal" id="u_Name"></span></li>
                        <li class="fw-bold">ล็อค : <span class="fw-normal" id="a_Name"></span></li>
                        <li class="fw-bold">โซน : <span class="fw-normal" id="z_Name"></span></li>
                        <li class="fw-bold">ประเภทสินค้า : <span class="fw-normal" id="pt_Name"></span></li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <?php if ($user["ur_Id"] == "R002") { ?>
                        <button type="button" class="btn btn-primary">เพิ่มเติม</button>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal จอง -->
    <div class="modal fade" id="reserve-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="reserve-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form class="needs-validation" novalidate>
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="reserve-modal-label">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h4>ประเภทสินค้า</h4>
                        <div class="col-md-2">
                            <select class="form-select" aria-label="Default select example" id="type-product">
                            </select>
                            <div class="invalid-feedback">
                                กรุณากรอก ประเภทสินค้า
                            </div>
                        </div>
                        <br />
                        <h4>รายละเอียดการจอง</h4>
                        <div class="row g-2 p-2">
                            <input type="text" class="form-control" placeholder="ล็อค" id="a_Id" readonly hidden>
                            <div class="col-md">
                                <label class="form-label">ล็อค</label>
                                <input type="text" class="form-control" placeholder="ล็อค" id="a_Name" readonly>
                                <!-- <div class="form-text">Enter your Full name</div> -->
                            </div>
                            <div class="col-md">
                                <label class="form-label">โซน</label>
                                <input type="text" class="form-control" placeholder="โซน" id="z_Name" readonly>
                                <!-- <div  class="form-text">Enter your Last name</div> -->
                            </div>
                        </div>

                        <div class="row g-2 p-2">
                            <div class="col-md-2">
                                <label class="form-label">คำนำหน้า</label>
                                <select class="form-select" aria-label="Default select example" id="Prefix" disabled>
                                    <option selected value="<?= $user["u_Prefix"] ?>"><?= $user["u_Prefix"] ?></option>
                                    <option value="นาย">นาย</option>
                                    <option value="นาง">นาง</option>
                                    <option value="นางสาว">นางสาว</option>
                                </select>
                                <!-- <div class="form-text">Enter your Full name</div> -->
                            </div>
                            <div class="col-md">
                                <label for="u_FullName" class="form-label">ชื่อ</label>
                                <input type="text" class="form-control" placeholder="Full name" id="u_FullName" value="<?= $user["u_FirstName"] ?>" readonly>

                            </div>
                            <div class="col-md">
                                <label class="form-label">นามสกุล</label>
                                <input type="text" class="form-control" placeholder="Last name" id="u_Last" value="<?= $user["u_LastName"] ?>" readonly>

                            </div>
                        </div>
                        <div class="row g-2 p-2">
                            <div class="col-md">
                                <label class="form-label">เลขบัตรประจำตัวประชาชน</label>
                                <input type="text" class="form-control" placeholder="" id="u_CardNumber" value="<?= $user["u_CardNumber"] ?>" readonly>

                            </div>
                            <div class="col-md">
                                <label class="form-label">วัน/เดือน/ปีเกิด</label>
                                <input type="date" class="form-control" placeholder="" id="u_Birthday" value="<?= $user["u_Birthday"] ?>" readonly>

                            </div>
                        </div>

                        <div class="row g-2 p-2">
                            <div class="col-md">
                                <div class="col-md">
                                    <label class="form-label">บ้านเลขที่/หมู่</label>
                                    <input type="text" class="form-control" placeholder="" id="u_Address" value="<?= $user["u_Address"] ?>" readonly>

                                </div>
                            </div>
                            <div class="col-md">
                                <div class="col-md">
                                    <label class="form-label">ถนน</label>
                                    <input type="text" class="form-control" placeholder="" id="u_Road" value="<?= $user["u_Road"] ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="col-md">
                                    <label class="form-label">ตำบล</label>
                                    <input type="text" class="form-control" placeholder="" id="u_SubDistrict" value="<?= $user["u_SubDistrict"] ?>" readonly>

                                </div>
                            </div>

                        </div>
                        <div class="row g-2 p-2">
                            <div class="col-md">
                                <div class="col-md">
                                    <label class="form-label">อำเภอ</label>
                                    <input type="text" class="form-control" placeholder="" id="u_District" value="<?= $user["u_District"] ?>" readonly>

                                </div>
                            </div>
                            <div class="col-md">
                                <div class="col-md">
                                    <label class="form-label">จังหวัด</label>
                                    <input type="text" class="form-control" placeholder="" id="u_Province" value="<?= $user["u_Province"] ?>" readonly>

                                </div>
                            </div>
                            <div class="col-md">
                                <div class="col-md">
                                    <label class="form-label">เบอร์โทรศัพท์</label>
                                    <input type="text" class="form-control" placeholder="" id="u_Phone" value="<?= $user["u_Phone"] ?>" readonly>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-primary" id="add-cart">เพิ่มการจอง</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <?php include("./layout/script.php"); ?>
    <script>
        $.ajax({
            url: "/ReserveSpace/backend/Service/areaList_api.php",
            type: "GET",
            dataType: "json",
            success: function(res) {
                let order = '<?= (isset($_SESSION['order'])) ? json_encode(unserialize($_SESSION['order'])) : "" ?>';
                if (order === "") {
                    order = [];
                } else {
                    order = JSON.parse(order);
                }

                const data_product_type = res.data.product_type;
                let txt_product_type = "<option selected disabled value=''>เลือกประเภทสินค้า</option>";
                $.each(data_product_type, function(key, val) {
                    txt_product_type += `<option value="${val.pt_Id}">${val.pt_Name}</option>`;
                })
                $("#type-product").html(txt_product_type);

                const data = res.data.area;
                let txt_content = "";
                $.each(data, function(key, val) {
                    let order_obj = order.find(i => i.a_Id === val.a_Id);
                    if (val.a_ReserveStatus === "0") {
                        if (order_obj !== undefined) {
                            txt_content += `<div class="d-flex justify-content-center align-items-center reserve-box-primary">
                                            <span class="text-light">${val.a_Name}</span>
                                        </div>`;
                        } else {
                            txt_content += `<div class="d-flex justify-content-center align-items-center reserve-box-green" data-bs-toggle="modal" data-bs-target="#reserve-modal" data-bs-whatever='${JSON.stringify(val)}'>
                                            <span class="text-light">${val.a_Name}</span>
                                        </div>`;
                        }

                    } else {
                        if (val.a_ReserveStatus === "2") {
                            txt_content += `<div class="d-flex justify-content-center align-items-center reserve-box-yellow">
                                            <span class="text-light">${val.a_Name}</span>
                                        </div>`;
                        } else {
                            txt_content += `<div class="d-flex justify-content-center align-items-center reserve-box-red" data-bs-toggle="modal" data-bs-target="#reserve-detail-modal" data-bs-whatever='${val.a_Id}'>
                                            <span class="text-light">${val.a_Name}</span>
                                        </div>`;
                        }

                    }
                })
                $("#reserve-content").html(txt_content);
            }
        });

        const reserve_modal = document.getElementById('reserve-modal')
        reserve_modal.addEventListener('show.bs.modal', event => {
            // Button that triggered the modal
            const button = event.relatedTarget;
            // Extract info from data-bs-* attributes
            const recipient = button.getAttribute('data-bs-whatever');
            const data = JSON.parse(recipient);
            const modalTitle = reserve_modal.querySelector('.modal-title');

            modalTitle.textContent = `ล็อค ${data.a_Name} # ${data.z_Name}`;
            $("#a_Id").val(data.a_Id);
            $("#a_Name").val(data.a_Name);
            $("#z_Name").val(data.z_Name);
        });

        $("#add-cart").click(function(e) {
            e.preventDefault();
            const type_product = $("#type-product").val();
            const data = {
                pt_Id: $("#type-product").val(),
                a_Id: $("#a_Id").val(),
                a_Name: $("#a_Name").val(),
                z_Name: $("#z_Name").val(),
                u_Name: '<?= $user["u_FirstName"] ?> <?= $user["u_LastName"] ?>'
            }
            if (type_product === null) {
                Swal.fire(
                    'ประเภทสินค้า',
                    'กรุณาเลือกประเภทสินค้า',
                    'warning'
                )
            } else {
                $.ajax({
                    url: "/ReserveSpace/backend/Service/cart_api.php",
                    type: "POST",
                    dataType: "json",
                    data: data,
                    success: function(res) {
                        $('#reserve-modal').modal('hide');
                        const myModalEl = document.getElementById('reserve-modal')
                        myModalEl.addEventListener('hidden.bs.modal', event => {
                            window.location.reload();
                        });
                    }
                });
            }

        });

        const reserve_modal_detail = document.getElementById('reserve-detail-modal')
        reserve_modal_detail.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const a_Id = button.getAttribute('data-bs-whatever');

            $.ajax({
                url: "/ReserveSpace/backend/Service/reserveFind.php",
                type: "POST",
                dataType: "json",
                data: {
                    a_Id: a_Id
                },
                success: function(res) {
                    const data_arr = res.data;
                    if (res.status === "seccess") {
                        $("#u_Name").html(`${data_arr.u_FirstName} ${data_arr.u_LastName}`);
                        $("#a_Name").html(data_arr.a_Name);
                        $("#z_Name").html(data_arr.z_Name);
                        $("#pt_Name").html(data_arr.pt_Name);
                    }
                }
            });
        });
        reserve_modal_detail.addEventListener('hidden.bs.modal', event => {
            $("#u_Name").html("");
            $("#a_Name").html("");
            $("#z_Name").html("");
            $("#pt_Name").html("");
        });
    </script>
</body>

</html>