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
                            <button class="btn btn-primary me-md-2" type="button" data-bs-toggle="modal" data-bs-target="#addAreakModal">เพิ่มล็อก</button>
                            <button class="btn btn-primary me-md-2" type="button" data-bs-toggle="modal" data-bs-target="#updateModal">เปิด - ปิดล็อกทั้งหมด</button>
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
                        <h1 class="modal-title fs-5" id="addAreakModalLabel">เพิ่มล็อก</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="selectZoneName" class="col-form-label">โซน</label>
                                <select class="form-select" aria-label="Default select example" id="selectZoneName">
                                    <option selected value="">เลือกโซน</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="inputAreaName" class="col-form-label">ล็อก:</label>
                                <input class="form-control" id="inputAreaName"></input>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btn_Add">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="updateModalLabel">เปิด - ปิดล็อก</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="selectZoneName" class="col-form-label">โซน</label>
                                <select class="form-select" aria-label="Default select example" id="selectZoneUpdateAll">
                                    <option selected value="">เลือกโซน</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-success me-md-2" type="button" onclick="area_StatusAll(this)" value="5">เปิดล็อกทั้งหมด</button>
                                <button class="btn btn-danger me-md-2" type="button" onclick="area_StatusAll(this)" value="0">ปิดล็อกทั้งหมด</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- end: Main -->
    <?php include("./layout/script.php"); ?>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        const dt_table = $('#table-area').DataTable({
            ajax: "<?= $host_path ?>/backend/Service/area_api.php",
            //processing: true,
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'colvis'],
            responsive: true,
            language: {
                url: './src/assets/DataTables/LanguageTable/th.json'
            },
            order: [
                [0, 'asc']
            ],
            rowGroup: {
                dataSrc: 'z_Name'
            },
            initComplete: function() {
                $("#table-area_filter").append(`<label id="select-group" class="my-2 w-100"></label>`);

                this.api().columns(0).every(function() {
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
                    title: "โซน",
                    data: "z_Name",
                },
                {
                    targets: 1,
                    title: "ล็อก",
                    data: "a_Name",
                    render: function(data, type, row, meta) {
                        return '<td class=""><span id="a_Name">' + data + '</span><input class="form-control" id="inputA_Name" type="text" value="' + data + '" style="display: none; width: 100 % "></td>';
                    }
                },
                {
                    targets: 2,
                    title: "สถานะ",
                    data: null,
                    defaultContent: "",
                    render: function(data, type, row, meta) {
                        let a_ReserveStatus = row.a_ReserveStatus;
                        let txt = "";
                        if (a_ReserveStatus == 0) {
                            txt = `<p class="text-success">ว่าง</p>`
                        } else{
                            txt = `<p class="text-danger">ไม่ว่าง</p>`
                        }

                        return txt;
                    }
                },
                {
                    targets: 3,
                    title: "เปิด - ปิด",
                    data: null,
                    defaultContent: "",
                    render: function(data, type, row, meta) {
                        let a_ReserveStatus = row.a_ReserveStatus;
                        let txt = "";
                        if (a_ReserveStatus == 0) {
                            txt = `<div class="d-grid gap-2 d-md-block" >
                                        <button class="btn btn-danger" type="button" onclick="area_Status(this)" value='${JSON.stringify(row)}' id="btn-status-close" >ไม่ว่าง</button>
                                    </div>
                                    <button class="btn btn-danger" type="button" disabled hidden id="btn-status-load">
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        <span class="visually-hidden">Loading...</span>
                                    </button>`
                        } else if (a_ReserveStatus == 5) {
                            txt = `<div class="d-grid gap-2 d-md-block" >
                                        <button class="btn btn-primary" type="button" onclick="area_Status(this)" value='${JSON.stringify(row)}' id="btn-status-open" >ว่าง</button>
                                    </div>
                                    <button class="btn btn-primary" type="button" disabled hidden id="btn-status-load">
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        <span class="visually-hidden">Loading...</span>
                                    </button>`
                        }

                        return txt;
                    }
                },
                {
                    targets: 4,
                    title: "ปุ่มสถานะ",
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

        function loadZone() {
            $.ajax({
                url: "<?= $host_path ?>/backend/Service/zone_api.php",
                type: "POST",
                dataType: "json",
                success: function(res) {
                    let length = res.data.length;

                    $('#selectZoneName').empty()
                    for (let i = 0; i < length; i++) {
                        $('#selectZoneName').append(`<option value="${res.data[i].z_Id}">${res.data[i].z_Name}</option>`);
                    }
                    $('#selectZoneUpdateAll').empty()
                    for (let i = 0; i < length; i++) {
                        $('#selectZoneUpdateAll').append(`<option value="${res.data[i].z_Id}">${res.data[i].z_Name}</option>`);
                    }
                }
            });
        }
        loadZone();

        function area_Status(elm) {
            let obj = JSON.parse(elm.value);
            let a_Id = obj.a_Id;
            let a_ReserveStatus = obj.a_ReserveStatus;
            let a_Name = obj.a_Name;
            let txt = "";
            if (a_ReserveStatus == 5) {
                txt = "เปิด"
            } else if (a_ReserveStatus == 0) {
                txt = "ปิด"
            }
            
            $.ajax({
                url: "<?= $host_path ?>/backend/Service/areaStatus_api.php",
                type: "POST",
                data: {
                    a_Id: a_Id,
                    a_ReserveStatus: a_ReserveStatus
                },
                dataType: "json",
                beforeSend:function(){
                    $("button#btn-status-close").hide();
                    $("button#btn-status-open").hide();
                    $("button#btn-status-load").prop('hidden',false);
                },
                success: function(res) {
                    //console.log(res);
                    let message = res.message;
                    let status = res.status;

                    if (status == "success") {
                        Toast.fire({
                            icon: 'success',
                            title: message
                        });
                        dt_table.ajax.reload();
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: message
                        });
                        //dt_table.ajax.reload();

                    }
                }
            });

        }

        function area_StatusAll(elm) {
            let z_Id = $('#selectZoneUpdateAll').val();
            let a_ReserveStatus = elm.value;
            let txt = "";
            if (a_ReserveStatus == 5) {
                txt = "เปิด"
            } else if (a_ReserveStatus == 0) {
                txt = "ปิด"
            }
            Swal.fire({
                title: 'แจ้งเตือน',
                html: `ต้องการ${txt}ล็อกทั้งหมดใช่หรือไม่`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก',
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: "<?= $host_path ?>/backend/Service/areaUpdateStatusAll_api.php",
                        type: "POST",
                        data: {
                            z_Id: z_Id,
                            a_ReserveStatus: a_ReserveStatus
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
                                    dt_table.ajax.reload();
                                    $('#updateModal').modal('hide');
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

        //Btn_Add
        $('#btn_Add').click(function(event) {
            event.preventDefault();
            let z_Id = $('#selectZoneName').val();
            let a_Name = $('#inputAreaName').val();
            //console.log(`Zone ID: ${z_Id}, Area Name: ${a_Name}`);
            $.ajax({
                url: "<?= $host_path ?>/backend/Service/areaAdd_api.php",
                type: "POST",
                data: {
                    z_Id: z_Id,
                    a_Name: a_Name
                },
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
                            dt_table.ajax.reload();
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
            row.find("#btn_Update").prop('disabled', true).show();
            row.find("#btn_Cancel").show();

            let input = row.find("#inputA_Name").val();
            row.find('#inputA_Name').keyup(function() {
                let val = row.find("#inputA_Name").val();
                if (event.key != "Enter") {
                    if (val == input) {
                        row.find("#btn_Update").prop('disabled', true).show();
                    } else {
                        row.find("#btn_Update").prop('disabled', false).show();
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
                    url: "<?= $host_path ?>/backend/Service/areaUpdate_api.php",
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

        //Btn Delete
        $("body").on("click", "#table-area #btn_Delete", function() {
            var row = $(this).closest("tr");
            let data = $('#table-area').DataTable().row(row).data();
            let a_Id = data.a_Id;
            let z_Name = data.z_Name;
            let a_Name = data.a_Name;

            Swal.fire({
                title: 'แจ้งเตือน',
                text: `ต้องการลบข้อมูล ${z_Name} ล็อก ${a_Name} ใช่หรือไม่`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก',
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: "<?= $host_path ?>/backend/Service/areaDelete_api.php",
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
            })

        });
    </script>
</body>

</html>