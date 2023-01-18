<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="./src/assets/bootstrap-5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="./src/assets/sweetalert2-11.7.0/sweetalert2.min.css" rel="stylesheet">
    <link href="./src/css/main.style" rel="stylesheet">
    <link href="./src/css/sign-in.css" rel="stylesheet">
  </head>


  <body class="text-center">

  <main class="form-signin w-100 m-auto">
  <form>
    <img class="mb-4" src="../assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
    <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

    <div class="form-floating">
      <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">Email address</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Password</label>
    </div>

    <div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="remember-me"> Remember me
      </label>
    </div>
    <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2017–2022</p>
  </form>
</main>

    <script src="./src/assets/bootstrap-5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="./src/assets/sweetalert2-11.7.0/sweetalert2.min.js"></script>
    <script src="./src/assets/jquery-3.6.3/jquery-3.6.3.min.js"></script>
    <script src="./src/js/main.js"></script>
    <script>
      $.ajax({
        url: "/ReserveSpace/backend/Service/loginapi.php",
        type: "POST",
        data:JSON.stringify({u_Username: "", u_Password: ""}),
        dataType: "json",
        success: function(data){
          console.log(data);
        }

      })
    </script>
    
  </body>
</html>