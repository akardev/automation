<?php
session_start();
if (isset($_SESSION['admin'])) {
    header("Location:index");
    exit;
}
require_once 'netting/crud.php';
$db = new Crud();

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AKARDEV | Login</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

    <style type="text/css">
        .login-page {

            background-image: url(dimg/login/login2.png);
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
        }

        body {
            overflow: hidden;
        }
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition login-page">
    <div class="login-box">

        <div class="login-logo">
            <a href="login"><b>AKAR</b>DEV</a>
        </div>

        <div class="login-box-body">


            <?php
            // print_r(json_decode(@$_COOKIE['adminLogin']));

            if (isset($_COOKIE['adminLogin'])) {
                $login = json_decode($_COOKIE['adminLogin']);
            }


            if (isset($_POST['login'])) {

                $result = $db->adminLogin(htmlspecialchars($_POST['adminUsername']), htmlspecialchars($_POST['adminPass']), isset($_POST['rememberMe']));
                if ($result['status']) {

                    header('Location:index');
                    exit;
                } else { ?>

                    <div class="alert alert-danger">
                        <strong>Kullanıcı adı veya şifre hatalı!</strong>
                    </div>

            <?php  }
            }   ?>


            <form action="" method="post">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="adminUsername" <?php if (isset($_COOKIE['adminLogin'])) {
                                                                                        echo 'value="' . $login->adminUsername . '"';
                                                                                    } else {
                                                                                        echo 'placeholder="Kullanıcı adı"';
                                                                                    } ?>>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="adminPass" <?php if (isset($_COOKIE['adminLogin'])) {
                                                                                        echo 'value="' . $login->adminPass . '"';
                                                                                    } else {
                                                                                        echo 'placeholder="Şifre"';
                                                                                    } ?>>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>

                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox" <?= isset($_COOKIE['adminLogin']) ? "checked" : "" ?> name="rememberMe"> Beni Hatırla
                            </label>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <button type="submit" name="login" class="btn btn-primary btn-block btn-flat">Giriş Yap</button>
                    </div>
                </div>
            </form>

        </div>
    </div>



    <!-- jQuery 3 -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js"></script>
    <script>
        $(function() {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' /* optional */
            });
        });
    </script>
</body>

</html>