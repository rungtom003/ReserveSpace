<?php
session_start();
$user = (isset($_SESSION['user'])) ? unserialize($_SESSION['user']) : null;
if($user != null){
    header('location: /ReserveSpace/index.php');
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link href="./src/assets/bootstrap-5.3.0/css/bootstrap.min.css" rel="stylesheet">
  <link href="./src/assets/sweetalert2-11.7.0/sweetalert2.min.css" rel="stylesheet">
  <link href="./src/css/main.css" rel="stylesheet">
  <link href="./src/css/sign-in.css" rel="stylesheet">
</head>


<body class="text-center" style="font-family: kanit-Regular;">

  <main class="form-signin w-100 m-auto">
    <form>
      <img class="mb-4" src="../assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
      <h1 class="h3 mb-3 fw-normal">เข้าสู่ระบบ</h1>

      <div class="form-floating">
        <input type="email" class="form-control" id="input_user" placeholder="User">
        <label for="floatingInput">ชื่อผู้ใช้</label>
      </div>
      <div class="form-floating mb-3">
        <input type="password" class="form-control" id="input_password" placeholder="Password">
        <label for="floatingPassword">รหัสผ่าน</label>
      </div>
      <button class="w-100 btn btn-lg btn-primary" type="submit" id="btn_Login">เข้าสู่ระบบ</button>
      <p class="mt-3 text-muted">ยังไม่มีบัญชีผู้ใช้?&nbsp; <a href=""> สร้างบัญชี</a></p>
    </form>
  </main>

  <script src="./src/assets/bootstrap-5.3.0/js/bootstrap.bundle.min.js"></script>
  <script src="./src/assets/sweetalert2-11.7.0/sweetalert2.min.js"></script>
  <script src="./src/assets/jquery-3.6.3/jquery-3.6.3.min.js"></script>
  <script src="./src/js/main.js"></script>

  <script>
    function Singin() {
      let user = $('#input_user').val();
      let password = $('#input_password').val();
      $.ajax({
        url: "/ReserveSpace/backend/Service/loginapi.php",
        type: "POST",
        data: {
          u_Username: user,
          u_Password: password
        },
        dataType: "json",
        success: function(data) {
          let message = data.message;
          if (data.status == "fail") {
            Swal.fire({
              icon: 'error',
              title: 'เเจ้งเตือน',
              text: message,
              footer: 'ยังไม่มีบัญชีผู้ใช้?&nbsp; <a href=""> สร้างบัญชี</a>'
            })
          } else {
            window.location.href = "/ReserveSpace/index.php"
          }
        }

      })

    }

    $('#btn_Login').click(function(event) {
      event.preventDefault();
      Singin();
    })
  </script>

</body>

</html>