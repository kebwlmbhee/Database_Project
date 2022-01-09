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

<?php
    include("connectMySQL.php");
?>
 
<!DOCTYPE html>
<html> 
<head> 
    <meta charset="UTF-8">
    <title>自動氣象站</title>
</head>

<body>
<CENTER><h1>Hi, <?php echo htmlspecialchars($_SESSION["username"]); ?></CENTER></h1>
<h1 align = "center">自動氣象站</h1>

<!--
<form align = "center" action = "read.php" method="post">
    請選擇欲顯示的資料庫: 
    <select name="chosen_db" onchange = "this.form.submit();">
        <option> &nbsp </option>    
        <option> datetime </option>
        <option> location </option>
        <option> note </option>
        <option> obsweather </option>
        <option> record </option>
        <option> station </option>
    </select>

</form>
 -->

<form align = "center" action = "read.php" method="post">
    <!-- Removing warning -->
    <?php error_reporting(0); ?>
    
    請選擇欲顯示的資料庫: 
    <select name="chosen_db" onchange = "this.form.submit();"> 
        <option value='datetime' 
            <?php if($_POST['chosen_db']=='datetime') echo 'selected="selected"';?> > datetime </option>
        <option value='location' 
            <?php if($_POST['chosen_db']=='location') echo 'selected="selected"';?>> location </option>
        <option value='note'  
            <?php if($_POST['chosen_db']=='note') echo 'selected="selected"';?>> note </option>
        <option value='obsweather' 
            <?php if($_POST['chosen_db']=='obsweather') echo 'selected="selected"';?>> obsweather </option>
        <option value='record' 
            <?php if($_POST['chosen_db']=='record') echo 'selected="selected"';?>> record </option>
        <option value='station' 
            <?php if($_POST['chosen_db']=='station') echo 'selected="selected"';?>> station </option>

    </select>
</form>

<?php
    $db_name = isset($_POST["chosen_db"]) ? $_POST["chosen_db"]: 'datetime';
    $sql_query = "SELECT * FROM $db_name";
    $result = mysqli_query($db_link, $sql_query);
    $total_records = mysqli_num_rows($result);
?>

<p align= "center">目前資料筆數：<?php echo $total_records;?> &emsp;
<a href='create.php'>新增資料</a> &emsp;
<a href='query.php'>Query</a></p>



<h2 align = "center"> <?php echo "$db_name"?> </h1>
<table border="1" align = "center">

<?php
echo "<tr>";
if($db_name == "datetime") {
    echo "<th> InfoDate </th>";
    echo "<th> InfoTime </th>";
    while($row_result = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>".$row_result['InfoDate']."</td>";
        echo "<td>".$row_result['InfoTime']."</td>";
        echo "<td><a href='update.php'>修改</a> ";
        echo "<a href='delete.php?"
                        ."chosen_db=datetime&InfoDate=$row_result[InfoDate] & InfoTime=$row_result[InfoTime]"
                        ."'>刪除</a></td>";
        echo "</tr>";
    }
}
else if($db_name == "location"){
    echo "<th> City </th>";
    echo "<th> CitySn </th>";
    echo "<th> Town </th>";
    echo "<th> TownSn </th>";
    while($row_result = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>".$row_result['City']."</td>";
        echo "<td>".$row_result['CitySn']."</td>";
        echo "<td>".$row_result['Town']."</td>";
        echo "<td>".$row_result['TownSn']."</td>";
        echo "<td><a href='update.php'>修改</a> ";
        echo "<a href='delete.php?"
                        ."chosen_db=location & City=$row_result[City] & CitySn=$row_result[CitySn]&"
                        ."Town=$row_result[Town] & TownSn=$row_result[TownSn]"
                        ."'>刪除</a></td>";
        echo "</tr>";
    }
}
else if($db_name == "note"){
    echo "<th> H_FX </th>";
    echo "<th> H_XD </th>";
    echo "<th> N_StationID </th>";
    echo "<th> N_Time </th>";
    while($row_result = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>".$row_result['H_FX']."</td>";
        echo "<td>".$row_result['H_XD']."</td>";
        echo "<td>".$row_result['N_StationID']."</td>";
        echo "<td>".$row_result['N_Time']."</td>";
        echo "<td><a href='update.php'>修改</a> ";
        echo "<a href='delete.php?"
                        ."chosen_db=note & H_FX=$row_result[H_FX] & H_XD=$row_result[H_XD]&"
                        ."N_StationID=$row_result[N_StationID] & N_Time=$row_result[N_Time]"
                        ."'>刪除</a></td>";
        echo "</tr>";
    }
}
else if($db_name == "obsweather"){
    echo "<th> ObsTime </th>";
    echo "<th> WDIR </th>";
    echo "<th> WDSD </th>";
    echo "<th> Temp </th>";
    echo "<th> HUMD </th>";
    echo "<th> PRES </th>";
    echo "<th> StationNum </th>";
    while($row_result = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>".$row_result['ObsTime']."</td>";
        echo "<td>".$row_result['WDIR']."</td>";
        echo "<td>".$row_result['WDSD']."</td>";
        echo "<td>".$row_result['Temp']."</td>";
        echo "<td>".$row_result['HUMD']."</td>";
        echo "<td>".$row_result['PRES']."</td>";
        echo "<td>".$row_result['StationNum']."</td>";
        echo "<td><a href='update.php'>修改</a> ";
        echo "<a href='delete.php?"
                        ."chosen_db=obsweather & ObsTime=$row_result[ObsTime] & WDIR=$row_result[WDIR]&"
                        ."WDSD=$row_result[WDSD] & Temp=$row_result[Temp] & HUMD=$row_result[HUMD] &"
                        ."PRES=$row_result[PRES] & StationNum=$row_result[StationNum]"
                        ."'>刪除</a></td>";
        echo "</tr>";
    }
}
else if($db_name == "record"){
    echo "<th> D_TX </th>";
    echo "<th> D_TN </th>";
    echo "<th> H24R </th>";
    echo "<th> R_Date </th>";
    echo "<th> R_StationID </th>";
    while($row_result = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>".$row_result['D_TX']."</td>";
        echo "<td>".$row_result['D_TN']."</td>";
        echo "<td>".$row_result['H24R']."</td>";
        echo "<td>".$row_result['R_Date']."</td>";
        echo "<td>".$row_result['R_StationID']."</td>";
        echo "<td><a href='update.php'>修改</a> ";
        echo "<a href='delete.php?"
                        ."chosen_db=record & D_TX=$row_result[D_TX] & D_TN=$row_result[D_TN]&"
                        ."H24R=$row_result[H24R] & R_Date=$row_result[R_Date] & R_StationID=$row_result[R_StationID]"
                        ."'>刪除</a></td>";
        echo "</tr>";
    }
}
else if($db_name == "station"){
    echo "<th> Lat </th>";
    echo "<th> Lon </th>";
    echo "<th> LatWGS84 </th>";
    echo "<th> LonWGS84 </th>";
    echo "<th> StationID </th>";
    echo "<th> StationName </th>";
    echo "<th> ELEV </th>";
    echo "<th> S_City </th>";
    echo "<th> S_Town </th>";
    while($row_result = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>".$row_result['Lat']."</td>";
        echo "<td>".$row_result['Lon']."</td>";
        echo "<td>".$row_result['LatWGS84']."</td>";
        echo "<td>".$row_result['LonWGS84']."</td>";
        echo "<td>".$row_result['StationID']."</td>";
        echo "<td>".$row_result['StationName']."</td>";
        echo "<td>".$row_result['ELEV']."</td>";
        echo "<td>".$row_result['S_City']."</td>";
        echo "<td>".$row_result['S_Town']."</td>";
        echo "<td><a href='update.php'>修改</a> ";
        echo "<a href='delete.php?"
                        ."chosen_db=station & Lat=$row_result[Lat] & Lon=$row_result[Lon] & LonWGS84=$row_result[LonWGS84]&"
                        ."LatWGS84=$row_result[LatWGS84] & StationID=$row_result[StationID] & StationName=$row_result[StationName] &"
                        ."ELEV=$row_result[ELEV] & S_City=$row_result[S_City] & S_Town=$row_result[S_Town]"
                        ."'>刪除</a></td>";
        echo "</tr>";
    }
}
echo "</tr>";
?>

</table>
</body>
</html>
