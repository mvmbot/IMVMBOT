<?php
session_start();
error_reporting(0);
include("dbconnection.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $mobile = $_POST['phone'];
  $gender = $_POST['gender'];
  $query = mysqli_query($con, "select email from user where email='$email'");
  $num = mysqli_fetch_array($query);
  if ($num > 1) {
    echo "<script>alert('Correo electrónico ya registrado con nosotros. Intente con una identificación de correo electrónico diferente.');</script>";
    echo "<script>window.location.href='registration.php'</script>";
  } else {
    mysqli_query($con, "insert into user(name,email,password,mobile,gender) values('$name','$email','$password','$mobile','$gender')");
    echo "<script>alert('Tu cuenta ha sido creada correctamente');</script>";
    echo "<script>window.location.href='login.php'</script>";
  }
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
  <meta charset="utf-8" />
  <title>CWEB Registration</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <meta content="" name="description" />
  <meta content="" name="author" />
  <link href="assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen" />
  <link href="assets/plugins/boostrapv3/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="assets/plugins/boostrapv3/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
  <link href="assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
  <link href="assets/css/animate.min.css" rel="stylesheet" type="text/css" />
  <link href="assets/css/style.css" rel="stylesheet" type="text/css" />
  <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />
  <link href="assets/css/custom-icon-set.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript">
    function checkpass() {
      if (document.signup.password.value != document.signup.cpassword.value) {
        alert('Los campos Nueva contraseña y Nueva contraseña no coinciden');
        document.signup.cpassword.focus();
        return false;
      }
      return true;
    }
  </script>

</head>

<body class="error-body no-top">
  <div class="container">
    <div class="login-container">
      <div class="col-md-5">
        <h2 class="text-center text-white"><strong>Crear una Cuenta</strong></h2>
        <hr style="border-color:#ebe7e7">
        <p class="text-center">Ya tienes una cuenta?<a href="login.php"> Accede aquí!</a></p>


      </div>
      <div class="col-md-5 "> <br>
        <form id="signup" name="signup" class="login-form" onsubmit="return checkpass();" method="post">
          <div class="form-group">
            <label for="name" class="control-label">Nombre</label>
            <input type="text" class="form-control rounded-0" id="name" name="name" required="required">
          </div>
          <div class="form-group">
            <label for="email" class="control-label">Correo</label>
            <input type="text" class="form-control rounded-0" id="email" name="email" required="required">
          </div>
          <div class="form-group">
            <label for="password" class="control-label">Contraseña</label>
            <input type="password" class="form-control rounded-0" id="password" name="password" required="required">
          </div>
          <div class="form-group">
            <label for="password" class="control-label">Confirmar Contraseña</label>
            <input type="password" class="form-control rounded-0" id="cpassword" name="cpassword" required="required">
          </div>
          <div class="form-group">
            <label for="phone" class="control-label">Número de Contacto</label>
            <input type="text" class="form-control rounded-0" id="phone" name="phone" required="required">
          </div>

          <div class="form-group">
            <label for="gender" class="control-label">Genero</label>
            <select class="form-control" name="gender" id="gender" required>
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
          </div>
          <div class="form-group text-center">
            <button class="btn btn-primary rounded-pill">Crear Cuenta</button>
          </div>
        </form>
      </div>


    </div>
  </div>
  <script src="assets/plugins/jquery-1.8.3.min.js" type="text/javascript"></script>
  <script src="assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
  <script src="assets/plugins/pace/pace.min.js" type="text/javascript"></script>
  <script src="assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
  <script src="assets/js/login.js" type="text/javascript"></script>
</body>

</html>