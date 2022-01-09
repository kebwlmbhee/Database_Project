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
        <b>◆更新氣象資料：</b><br>
    
        請輸入縣市：<input type="text" name="City" id="City" value=" <?php echo $City ?>" ><br/>
        請輸入縣市編號：<input type="number" name="CitySn" id="CitySn" value=" <?php echo $CitySn ?>" ><br/>
        請輸入鄉鎮：<input type="text" name="Town" id="Town" value= " <?php echo $Town ?>" ><br/>
        請輸入鄉鎮編號：<input type="number" name="TownSn" id="TownSn" value= " <?php echo $TownSn ?>" ><br/>
        請輸入經度(TWD67)：<input type="number" step= 0.000000000001 name="lon" id="lon" value= " <?php echo $lon ?>" ><br/>
        請輸入緯度(TWD67)：<input type="number" step= 0.000000000001 name="lat" id="lat" value= " <?php echo $lat ?>" ><br/>
        請輸入經度(WGS84)：<input type="number" step= 0.000000000001 name="lonWGS84" id="lonWGS84" value= " <?php echo $lonWGS84 ?>" ><br/>
        請輸入緯度(WGS84)：<input type="number" step= 0.000000000001 name="latWGS84" id="latWGS84" value= " <?php echo $latWGS84 ?>" ><br/>
        請輸入測站名稱：<input type="text" name="StationName" id="StationName" value= " <?php echo $StationName ?>" ><br/>
        請輸入測站編號：<input type="text" pattern="[a-zA-Z0-9]+" name="StationID" id="StationID" value= " <?php echo $StationID ?>" ><br/>
        請輸入海拔高度(公尺)：<input type="number" step=0.0001 min = 0 name="ELEV" id="ELEV" value= " <?php echo $ELEV ?>" ><br/>
        請輸入溫度：<input type="number" step= 0.0001 name="Temp" id="Temp" value= " <?php echo $Temp ?>" ><br/>
        請輸入測站氣壓：<input type="number" step= 0.0001 name="PRES" id="PRES" value= " <?php echo $PRES ?>" ><br/>
        請輸入本日最高溫：<input type="number" step= 0.0001 name="D_TX" id="D_TX" value= " <?php echo $D_TX ?>" ><br/>
        請輸入本日最低溫：<input type="number" step= 0.0001 name="D_TN" id="D_TN" value= " <?php echo $D_TN ?>" ><br/>
        請輸入日累積雨量：<input type="number" step= 0.0001 min = 0 name="H24R" id="H24R" value= " <?php echo $H24R ?>" ><br/>
        請輸入日期時間：<input type="datetime-local" name="R_Date" id="R_Date" value= " <?php echo $DateforSQL ?>" ><br/>
        
        請輸入相對溼度(%)：<input type="number" step= 0.0001  max =1 min = 0 name="HUMD" id="HUMD" value= " <?php echo $HUMD ?>" ><br/>
        請輸入風向：<input type="number" step= 0.0001 name="WDIR" min = 0 id="WDIR" value= " <?php echo $WDIR ?>" ><br/>
        請輸入風速：<input type="number" step= 0.0001 name="WDSD" min = 0 id="WDSD" value= " <?php echo $WDSD ?>" ><br/>
        請輸入⼩時最⼤陣風風速：<input type="number" step= 0.0001 name="H_FX" id="H_FX" value= " <?php echo $H_FX ?>" ><br/>
        請輸入⼩時最⼤陣風風向：<input type="number" step= 0.0001 name="H_XD" id="H_XD" value= " <?php echo $H_XD ?>" ><br/>
        
        <input type="hidden" name="action" value="update">
        <input type="submit" name="button" value="更新資料">

    </form>
</body>
</html>

<?php
}
?>

<?php

if (isset($_POST["action"])&&($_POST['action']=="update")){ //check if null number
    if (!empty($_POST["City"]) && !empty($_POST["lon"])&& !empty($_POST["lat"]) && !empty($_POST["lonWGS84"]) && !empty($_POST["latWGS84"])
    && !empty($_POST["StationName"]) && !empty($_POST["StationID"]) && !empty($_POST["ELEV"]) && !empty($_POST["Temp"])
    && !empty($_POST["PRES"]) && !empty($_POST["D_TX"]) && !empty($_POST["D_TN"]) && !empty($_POST["H24R"]) && !empty($_POST["R_Date"]) 
    && !empty($_POST["CitySn"]) && !empty($_POST["Town"]) && !empty($_POST["TownSn"])){

        include "connMySQL.php";

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
        
        
        $sql_query = "UPDATE station SET Lat = '$lat', Lon = '$lon', LatWGS84 = '$latWGS84', LonWGS84 = '$lonWGS84' ,StationName = '$StationName' , ELEV = '$ELEV', S_City = '$City', S_Town= '$Town' WHERE  StationID = $StationID";
                    
        $sql_query2 = "UPDATE obsweather SET WDIR = '$WDIR', WDSD = '$WDSD', Temp = '$Temp', HUMD = '$HUMD', PRES = '$PRES' WHERE StationNum =  $StationID && ObsTime = $infoTime" ;

        $sql_query3 = "UPDATE record SET D_TX = '$D_TX', D_TN = '$D_TN', H24R = '$H24R' WHERE R_StationID = $StationID && R_Date = $DateforSQL"; 
                    
        $sql_query4 = "UPDATE note SET H_FX = '$H_FX', H_XD = '$H_XD' WHERE N_StationID = $StationID && N_Time = $infoTime "; 
    
        $sql_query5 = "UPDATE location SET  CitySn = '$CitySn', TownSn = '$TownSn' WHERE Town = $Town && City= $City";

        $sql_query6 = "UPDATE datetime SET infoTime = '$infoTime' WHERE infoDate = $DateforSQL";


        mysqli_query($db_link,$sql_query);
        mysqli_query($db_link,$sql_query2);
        mysqli_query($db_link,$sql_query3);
        mysqli_query($db_link,$sql_query4);
        mysqli_query($db_link,$sql_query5);
        mysqli_query($db_link,$sql_query6);

        $db_link->close();

        
        header("Location: index.php");
        }
    else{
        echo 'not allow null number';
    }
}

else{

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

