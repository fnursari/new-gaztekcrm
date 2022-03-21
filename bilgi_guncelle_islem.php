<?
header("Content-Type: text/html; charset=utf-8"); session_start();
include_once "config.php";
include_once "../classes/ez_sql_core.php";  
include_once "../classes/ez_sql_mysql.php";  
$db = new ezSQL_mysql($cfg["DatabaseUsername"],$cfg["DatabasePassword"],$cfg["DatabaseName"],$cfg["DatabaseHost"]."");
$db->query("set names utf8");
if(canUserAccessAdminArea()) {
   $user_id=$_SESSION["user"]["user_id"];
   $user_name=$_POST['user_name'];
   $user_pass_eski=md5(trim($_POST["user_pass_eski"]));
   $user_pass_yeni=md5(trim($_POST["user_pass_yeni"]));
   $user_pass=$db->get_var("select user_pass from u1s9e2r6 where user_id='$user_id'"); 
   if($user_pass==$user_pass_eski)
	{
	  $kullanici_guncelle="update u1s9e2r6 set user_name='$user_name',user_pass='$user_pass_yeni' where user_id='$user_id'"; 
	  $db->query($kullanici_guncelle);
	  $result="guncellendi"; 
	}	
   else
	{
	  $result="eski_sifre_yanlis";
	}
	header("location:admin.php?cmd=bilgi_guncelle&result=$result");

}

?>



