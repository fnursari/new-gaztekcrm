<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
$config = getConfig();
if(canUserAccessAdminArea()) {
    header("location:admin.php");
}
else {
    ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Yönetim Paneli</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="author" />
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="assets/css/login-4.min.css" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" href="../favicon.ico" /> </head>

    <body class=" login">
        <div class="logo">
                <h1><?=$config["company_name"]?></h1>
                <h2>Yönetim Paneli</h2>
           
        </div>
        <div class="content">
            <form class="login-form" action="logincontrol.php" method="post">
                <?php 
                    $token=md5(session_id()."mersoy");
                ?>
                <input type="hidden" name="token_login" value="<?=$token?>"/>
                <?php
                    if ($_GET['err']=='1') {
                ?>
                    <div class="alert alert-danger">
                        <span>Hatalı Giriş!</span><br>Lütfen kullanıcı adı ve şifrenizi kontrol ediniz.
                    </div>
                <?php }?>                
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Kullanıcı Adı</label>
                    <div class="input-icon">
                        <i class="fa fa-user"></i>
                        <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Kullanıcı Adı" name="user_name" id="user_name" /> </div>
                </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Şifre</label>
                    <div class="input-icon">
                        <i class="fa fa-lock"></i>
                        <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Şifre" id="user_pass" name="user_pass" /> </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn green pull-right"> Giriş </button>
                </div>
            </form>
        </div>
        <div class="copyright"> 2018 &copy; <strong>Vizyoner</strong></div>

        <script src="assets/js/jquery.min.js" type="text/javascript"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="assets/js/js.cookie.min.js" type="text/javascript"></script>
        <script src="assets/js/login-4.min.js" type="text/javascript"></script>
    </body>

</html>
<?php
}?>