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
# check account permission
if($_SESSION["username"] == "kebwlmbhee"){

?>
 


<html>
<head>
    <meta charset="UTF-8" />
    <title>自動氣象站</title>
<head>
<body>
<CENTER><h1>Hi, <?php echo htmlspecialchars($_SESSION["username"]); ?></CENTER></h1>
<form action="" method="post" name="formAdd" id="formAdd">
<font size="6"><b>自動氣象站</b></font><br><br>

<b>◆新增氣象資料：</b><br>
請輸入縣市：<input type="text" name="City" id="City"><br/>
請輸入縣市編號：<input type="number" name="CitySn" id="CitySn"><br/>
請輸入鄉鎮：<input type="text" name="Town" id="Town"><br/>
請輸入鄉鎮編號：<input type="number" name="TownSn" id="TownSn"><br/>
請輸入經度(TWD67)：<input type="number" step= 0.000000000001 name="lon" id="lon"><br/>
請輸入緯度(TWD67)：<input type="number" step= 0.000000000001 name="lat" id="lat"><br/>
請輸入經度(WGS84)：<input type="number" step= 0.000000000001 name="lonWGS84" id="lonWGS84"><br/>
請輸入緯度(WGS84)：<input type="number" step= 0.000000000001 name="latWGS84" id="latWGS84"><br/>
請輸入測站名稱：<input type="text" name="StationName" id="StationName"><br/>
請輸入測站編號：<input type="text" pattern="[a-zA-Z0-9]+" name="StationID" id="StationID"><br/>
請輸入海拔高度(公尺)：<input type="number" step=0.0001 min = 0 name="ELEV" id="ELEV"><br/>
請輸入溫度：<input type="number" step= 0.0001 name="Temp" id="Temp"><br/>
請輸入測站氣壓：<input type="number" step= 0.0001 name="PRES" id="PRES"><br/>
請輸入本日最高溫：<input type="number" step= 0.0001 name="D_TX" id="D_TX"><br/>
請輸入本日最低溫：<input type="number" step= 0.0001 name="D_TN" id="D_TN"><br/>
請輸入日累積雨量：<input type="number" step= 0.0001 min = 0 name="H24R" id="H24R"><br/>
請輸入日期時間：<input type="datetime-local" name="R_Date" id="R_Date"><br/>

請輸入相對溼度(%)：<input type="number" step= 0.0001  max =1 min = 0 name="HUMD" id="HUMD"><br/>
請輸入風向：<input type="number" step= 0.0001 name="WDIR" min = 0 id="WDIR"><br/>
請輸入風速：<input type="number" step= 0.0001 name="WDSD" min = 0 id="WDSD"><br/>
請輸入⼩時最⼤陣風風速：<input type="number" step= 0.0001 name="H_FX" id="H_FX"><br/>
請輸入⼩時最⼤陣風風向：<input type="number" step= 0.0001 name="H_XD" id="H_XD"><br/>

<input type="hidden" name="action" value="add">
<input type="submit" name="button" value="新增">
</form>
</body>
</html>

<?php
}
?>


<?php
    if (isset($_POST["action"])&&($_POST['action']=="add")){ //check if null number
        if (!empty($_POST["City"]) && !empty($_POST["lon"])&& !empty($_POST["lat"]) && !empty($_POST["lonWGS84"]) && !empty($_POST["latWGS84"])
        && !empty($_POST["StationName"]) && !empty($_POST["StationID"]) && !empty($_POST["ELEV"]) && !empty($_POST["Temp"])
        && !empty($_POST["PRES"]) && !empty($_POST["D_TX"]) && !empty($_POST["D_TN"]) && !empty($_POST["H24R"]) && !empty($_POST["R_Date"]) 
        && !empty($_POST["CitySn"]) && !empty($_POST["Town"]) && !empty($_POST["TownSn"])){
            
            include("connectMysql.php");
            
            $StationName= $_POST['StationName'];
            $StationID = $_POST['StationID'];
            
            $infoTime = $_POST['R_Date'];

            $infoDate = $_POST['R_Date'];
            $date=strtotime($infoDate);
            $DateforSQL=date("Y-m-d",$date);
            
            $City = $_POST['City'];
            $CitySn = $_POST['CitySn'];
            $Town = $_POST['Town'];
            $TownSn = $_POST['TownSn'];
            $lon = $_POST['lon'];
            $lat = $_POST['lat'];
            $lonWGS84 = $_POST['lonWGS84'];
            $latWGS84 = $_POST['latWGS84'];
            $ELEV = $_POST['ELEV'];
            $Temp = $_POST['Temp'];
            $PRES = $_POST['PRES'];
            $D_TX = $_POST['D_TX'];
            $D_TN = $_POST['D_TN'];
            $H24R = $_POST['H24R'];

            $HUMD = $_POST['HUMD'];
            $WDIR = $_POST['WDIR'];
            $WDSD = $_POST['WDSD'];
            $H_FX = $_POST['H_FX'];
            $H_XD = $_POST['H_XD'];
            

            $sql_query = "INSERT INTO station (Lat, Lon, LatWGS84, LonWGS84, StationName, StationID, ELEV, S_City, S_Town) 
                        VALUES ('$lat', '$lon','$latWGS84', '$lonWGS84', '$StationName', '$StationID', '$ELEV', '$City', '$Town')";
                        
            $sql_query2 ="INSERT INTO obsweather (ObsTime, WDIR, WDSD, Temp, HUMD, PRES, StationNum) 
                        VALUES ('$infoTime', '$WDIR', '$WDSD','$Temp', '$HUMD', '$PRES', '$StationID')";

            $sql_query3 =  "INSERT INTO record (D_TX, D_TN, H24R, R_Date, R_StationID) 
                        VALUES ('$D_TX', '$D_TN','$H24R','$DateforSQL','$StationID')";
                        
            $sql_query4 = "INSERT INTO note (H_FX, H_XD, N_StationID, N_Time) 
                        VALUES ('$H_FX', '$H_XD', '$StationID','$infoTime')";
        
            $sql_query5 = "INSERT INTO location (City, CitySn, Town, TownSn) 
                        VALUES ('$City', '$CitySn', '$Town', '$TownSn')";

            $sql_query6 = "INSERT INTO datetime (infoTime, infoDate) 
                        VALUES ('$infoTime', '$DateforSQL')";


            mysqli_query($db_link,$sql_query);
            mysqli_query($db_link,$sql_query2);
            mysqli_query($db_link,$sql_query3);
            mysqli_query($db_link,$sql_query4);
            mysqli_query($db_link,$sql_query5);
            mysqli_query($db_link,$sql_query6);
            
            header("Location: index.php");
            }
        else{
            echo 'not allow null number';
        }
}

if($_SESSION["username"] != "kebwlmbhee"){


?>

<html>
<head>
<body>
    <br></br>
    <p><CENTER><h1>Permission denied !   <br></br> <br></br>
       Please Contact Administrator. </h1></CENTER><p>
</body>
</head>
</html>

<?php
}
?>
