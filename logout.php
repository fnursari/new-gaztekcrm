<?php
session_start();
if($_SESSION["user"]["auth"]==sha1(md5(session_id()."vizyoner")))
{
	unset($_SESSION['user']);
	session_unset();
    session_destroy();
    header("location:loginform.php");
}
?>

