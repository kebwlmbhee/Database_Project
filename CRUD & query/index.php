<?php
# remove warning 
error_reporting(0); 

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<!-- lang 代表網頁主要語言 -->
<html lang="zh-Hant-TW">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome !!</h1>
        <h1>Page Redirect to <a href="read.php">自動氣象站</a> After 10 Seconds</h1>
        <br></br>
        <h2>or click the link to jump directly</h2>
        <?php header('Refresh: 10; url=read.php'); ?>

</html>


<?php
// 載入 connectMysql.php 連接資料庫
require_once 'connectMysql.php';
?>

<?php 


?>

<body>
<p>
    <br></br>
        <br></br>
        <br></br>
        <br></br>
        <br></br>
        <a href="reset_password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p>
</body>