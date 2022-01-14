<?php

$db_host = 'mysql5045.site4now.net';
$db_userName = 'a7f1e3_nccudb';
$db_password = 'Smarter123456'; 
$db_name = 'db_a7f1e3_projec';

$db_link = @mysqli_connect($db_host, $db_userName, $db_password, $db_name);


if (!$db_link) {
    die('connected failed');
}/* else {
   echo 'connected successfully!';
}
*/
mysqli_query($db_link, "SET NAMES 'utf8mb4'");

?>