<?php
session_start();
$user = (isset($_SESSION['user'])) ? unserialize($_SESSION['user']) : null;
if ($user == null) {
    header('location: /ReserveSpace/login.php');
}
if ($user["ur_Id"] == "R001") {
    header('location: /ReserveSpace/noaccess.php');
}
$titleHead = "Area";
$active_area = "active";
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
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button class="btn btn-primary me-md-2" type="button" data-bs-toggle="modal" data-bs-target="#addAreakModal">เพิ่มบล็อค</button>
                        </div>
                        <table id="table-area" class="table table-striped w-100"></table>
                    </div>
                </div>
            </div>
            <!-- end: Content -->
        </div>
        <div class="modal fade" id="addAreakModal" tabindex="-1" aria-labelledby="addAreakModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addAreakModalLabel">เพิ่มบล็อค</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="selectZoneName" class="col-form-label">โซน:</label>
                                <select class="form-select" aria-label="Default select example" id="selectZoneName">
                                    <option selected value="">เลือกโซน</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="inputAreaName" class="col-form-label">บล็อค:</label>
                                <input class="form-control" id="inputAreaName"></input>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id ="btn_Add">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- end: Main -->
    <?php include("./layout/script.php"); ?>
    <script>
        function loadArea() {
            $.ajax({
                url: "/ReserveSpace/backend/Service/area_api.php",
                type: "GET",
                dataType: "json",
                success: function(res) {
                    //console.log(res);
                    LoadTable(res.data);
                }
            });

            const LoadTable = (data) => {
                $('#table-area').DataTable({
                    data: data,
                    dom: 'Bfrtip',
                    buttons: ['copy', 'csv', 'excel', 'colvis'],
                    responsive: true,
                    language: {
                        url: './src/assets/DataTables/LanguageTable/th.json'
                    },
                    columnDefs: [{
                            targets: 0,
                            title: "โซน",
                            data: "z_Name",
                        },
                        {
                            targets: 1,
                            title: "บล็อค",
                            data: "a_Name",
                            render: function(data, type, row, meta) {
                                return '<td class=""><span id="a_Name">' + data + '</span><input class="form-control" id="inputA_Name" type="text" value="' + data + '" style="display: none; width: 100 % "></td>';
                            }
                        },
                        {
                            targets: 2,
                            title: "a_Number",
                            data: "a_Number",
                        },
                        {
                            targets: 3,
                            title: "a_Detail",
                            data: "a_Detail",
                        },
                        {
                            targets: 4,
                            title: "a_ReserveStatus",
                            data: "a_ReserveStatus",
                        },
                        {
                            targets: 5,
                            title: "#",
                            data: null,
                            defaultContent: "",
                            render: function(data, type, row, meta) {
                                return `<div class="d-grid gap-2 d-md-block" >
                                        <button class="btn btn-warning" type="button" id="btn_Edit" >แก้ไข</button>
                                        <button class="btn btn-danger" type="button" id="btn_Delete" >ลบ</button>
                                    </div>
                                    <div class="d-grid gap-2 d-md-block">
                                        <button class="btn btn-success" type="button" id="btn_Update" style='display: none' >ยืนยัน</button>
                                        <button class="btn btn-danger" type="button" id="btn_Cancel" style='display: none' >ยกเลิก</button>
                                    </div>`;
                            }
                        }
                    ]
                });
            }

        }

        function loadZone() {
            $.ajax({
                url: "/ReserveSpace/backend/Service/zone_api.php",
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

        loadArea();
        loadZone();

        //Btn_Add
        $('#btn_Add').click(function(event) {
            event.preventDefault();
            let z_Id = $('#selectZoneName').val();
            let a_Name = $('#inputAreaName').val();
            //console.log(`Zone ID: ${z_Id}, Area Name: ${a_Name}`);
            $.ajax({
                url: "/ReserveSpace/backend/Service/areaAdd_api.php",
                type: "POST",
                data: {z_Id:z_Id, a_Name:a_Name},
                //data: null,
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
                                $('#table-area').DataTable().destroy();
                                loadArea();
                                $('#addAreakModal').modal('hide');
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

        //Btn Edit
        $("body").on("click", "#table-area #btn_Edit", function() {
            var row = $(this).closest("tr");


            $("td", row).each(function() {
                if ($(this).find("input").length > 0) {
                    $(this).find("input").show();
                    $(this).find("span").hide();
                }
            });

            row.find("#btn_Edit").hide();
            row.find("#btn_Delete").hide();
            row.find("#btn_Update").hide();
            row.find("#btn_Cancel").show();

            let input = row.find("#inputA_Name").val();
            row.find('#inputA_Name').keyup(function() {
                let val = row.find("#inputA_Name").val();
                if (event.key != "Enter") {
                    if (val == input) {
                        row.find("#btn_Update").hide();
                    } else {
                        row.find("#btn_Update").show();
                    }
                }
            })
        });

        //Btn Cancel
        $("body").on("click", "#table-area #btn_Cancel", function() {
            var row = $(this).closest("tr");
            $("td", row).each(function() {
                if ($(this).find("input").length > 0) {
                    $(this).find("input").hide();
                    $(this).find("span").show();
                }
            });
            row.find("#btn_Edit").show();
            row.find("#btn_Delete").show();
            row.find("#btn_Update").hide();
            row.find("#btn_Cancel").hide();

            let aName = row.find('#a_Name').html();
            row.find("#inputA_Name").val(aName);
        });

        //Btn Update
        $("body").on("click", "#table-area #btn_Update", function() {
            var row = $(this).closest("tr");
            let data = $('#table-area').DataTable().row(row).data();
            let a_Id = data.a_Id;
            let a_Name = row.find("#inputA_Name").val();

            if (a_Name == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'เเจ้งเตือน',
                    text: 'ไม่มีข้อมูลที่จะแก้ไข'
                })
            } else {
                $.ajax({
                    url: "/ReserveSpace/backend/Service/areaUpdate_api.php",
                    type: "POST",
                    data: {
                        a_Id: a_Id,
                        a_Name: a_Name
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
                                $('#table-area').DataTable().destroy();
                                loadArea();
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

        //Btn Delete
        $("body").on("click", "#table-area #btn_Delete", function() {
            var row = $(this).closest("tr");
            let data = $('#table-area').DataTable().row(row).data();
            let a_Id = data.a_Id;
            let z_Name = data.z_Name;
            let a_Name = data.a_Name;

            Swal.fire({
                title: 'แจ้งเตือน',
                text: `ต้องการลบข้อมูล ${z_Name} บล็อค ${a_Name} ใช่หรือไม่`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก',
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: "/ReserveSpace/backend/Service/areaDelete_api.php",
                        type: "POST",
                        data: {
                            a_Id: a_Id
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
                                    $('#table-area').DataTable().destroy();
                                    loadArea();
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

        });
    </script>
</body>

</html>