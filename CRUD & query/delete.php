<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>delete_php</title>
  </head>
  <body>
    <!---資料庫連接 --->
    <?php
    include("connectMySQL.php");
    ?>
    <!---資料庫連接 --->

    <!---刪除資料--->
    <?php
           if(isset($_REQUEST["chosen_db"])){
           $act=strval($_REQUEST["chosen_db"]);
           $act=str_replace(' ', '', $act);
           switch($act){
               //weather表格
               case "obsweather":{
                        $ObsTime=$_REQUEST["ObsTime"];
                        $WDIR=$_REQUEST["WDIR"];
                        $WDSD=$_REQUEST["WDSD"];
                        $Temp=$_REQUEST["Temp"];
                        $HUMD=$_REQUEST["HUMD"];
                        $PRES=$_REQUEST["PRES"];
                        $StationNum=$_REQUEST["StationNum"];
                        $sql_query="Select * From `obsweather` Where "."Obstime ='".$ObsTime."' and WDIR like ".$WDIR." and WDSD like "
                                                                .$WDSD." and Temp like ".$Temp." and HUMD like ".$HUMD." and PRES like ".$PRES
                                                                ." and StationNum like '".$StationNum."'";
                        $delete_query="Delete From `obsweather` Where "."Obstime ='".$ObsTime."' and WDIR like ".$WDIR." and WDSD like "
                                                                .$WDSD." and Temp like ".$Temp." and HUMD like ".$HUMD." and PRES like ".$PRES
                                                                ." and StationNum like '".$StationNum."'";
                        $result = mysqli_query( $db_link, $sql_query);
                        if($db_link->query($sql_query) == TRUE){
                            if(mysqli_num_rows($result)!=0){
                                echo "已刪除下列資料：<br>";
                                echo '<table border="1" align = "left">
                                <tr>
                                    <th>ObsTime</th>
                                    <th>WDIR</th>
                                    <th>WDSD</th>
                                    <th>Temp</th>
                                    <th>HUMD</th>
                                    <th>PRES</th>
                                    <th>StationNum</th>
                                </tr>';
                                while($row_result = mysqli_fetch_array($result)) {
                                    echo "<tr>";
                                    for($i=0;$i<mysqli_num_fields($result);$i++)
                                    echo "<td>".$row_result[$i]."</td>";
                                    echo "</tr>";
                                }
                                mysqli_query($db_link,$delete_query);
                            }
                            else{
                                echo "要刪除的資料不在此表格中!";
                            }
                        }
                        else{
                            echo "刪除資料錯誤: " . $db_link->error;
                        }
                    }
                    break;
                //station表格
               case "station":{
                        $Lat=$_REQUEST["Lat"];
                        $Lon=$_REQUEST["Lon"];
                        $LatWGS84=$_REQUEST["LatWGS84"];
                        $LonWGS84=$_REQUEST["LonWGS84"];
                        $LocationName=$_REQUEST["StationName"];
                        $StationID=$_REQUEST["StationID"];
                        $ELEV=$_REQUEST["ELEV"];
                        $S_City=$_REQUEST["S_City"];
                        $S_Town=$_REQUEST["S_Town"];
                        $sql_query="Select * From `station` Where Lat like ".$Lat." and Lon like ".$Lon." and LatWGS84 like "
                                    .$LatWGS84." and ELEV like ".$ELEV." and StationName like '".$LocationName."' and StationID like '"
                                    .$StationID."' and S_City like '".$S_City."' and S_Town like ".$S_Town."'";
                        $delete_query="Delete From `station` Where Lat like ".$Lat." and Lon like ".$Lon." and LatWGS84 like "
                                    .$LatWGS84." and ELEV like ".$ELEV." and StationName like '".$LocationName."' and StationID like '"
                                    .$StationID."' and S_City like '".$S_City."' and S_Town like ".$S_Town."'";
                        $stationJoinWeather="SELECT * FROM station,obsweather WHERE station.StationID=obsweather.StationNum 
                                    and station.StationID='".$StationID."'";
                        $stationJoinNote="SELECT * FROM station,note WHERE station.StationID=note.N_StationID 
                                    and station.StationID='".$StationID."'";
                        $stationJoinRecord="SELECT * FROM station,record WHERE station.StationID=record.R_StationID
                                    and station.StationID='".$StationID."'";

                        $num_station_fkweather=mysqli_num_rows(mysqli_query($db_link,$stationJoinWeather));
                        $num_station_fknote=mysqli_num_rows(mysqli_query($db_link,$stationJoinNote));
                        $num_station_fkrecord=mysqli_num_rows(mysqli_query($db_link,$stationJoinRecord));
                        //echo $num_station_fkweather.",".$num_station_fknote.",".$num_station_fkrecord.'<br>';
                        if($num_station_fkweather!=0||$num_station_fknote!=0||$num_station_fkrecord!=0){
                            $err_message="不能刪除此資料因爲";
                            if(($num_station_fkweather==0&&$num_station_fknote==0)||
                                ($num_station_fkrecord==0&&$num_station_fknote==0)||
                                ($num_station_fkweather==0&&$num_station_fkrecord==0)){
                                if($num_station_fkweather!=0)
                                    $err_message.="weather表格";
                                else if($num_station_fknote!=0)
                                    $err_message.="note表格";
                                else if($num_station_fkrecord!=0)
                                    $err_message.="record表格";
                                $err_message.="參考到此資料<br>";
                            }
                            else{
                                if($num_station_fkweather!=0)
                                    $err_message.="weather ";
                                if($num_station_fknote!=0)
                                    $err_message.="note ";
                                if($num_station_fkrecord!=0)
                                    $err_message.="record ";
                                $err_message.="這些表格參考到此資料<br>";
                            }
                            echo $err_message;
                        }
                        else{
                            $result = mysqli_query( $db_link, $sql_query);
                            if($db_link->query($sql_query) == TRUE){
                                if(mysqli_num_rows($result)!=0){
                                    echo "已刪除下列資料：<br>";
                                    echo '<table border="1" align = "left">
                                    <tr>
                                        <th>Lat</th>
                                        <th>Lon</th>
                                        <th>LatWGS84</th>
                                        <th>LonWGS84</th>
                                        <th>StationID</th>
                                        <th>StationName</th>
                                        <th>ELEV</th>
                                        <th>S_city</th>
                                        <th>S_Town</th>
                                    </tr>';
                                    while($row_result = mysqli_fetch_array($result)) {
                                        echo "<tr>";
                                        for($i=0;$i<mysqli_num_fields($result);$i++)
                                        echo "<td>".$row_result[$i]."</td>";
                                        echo "</tr>";
                                    }
                                    mysqli_query($db_link,$delete_query);
                                }
                                else{
                                    echo "要刪除的資料不在此表格中!";
                                }
                            }
                            else{
                                echo "刪除資料錯誤: " . $db_link->error;
                            }
                        }
                    }
                    break;
                //location表格
               case "location":{
                        $City=$_REQUEST["City"];
                        $CitySn=$_REQUEST["CitySn"];
                        $Town=$_REQUEST["Town"];
                        $TownSn=$_REQUEST["TownSn"];
                        $sql_query="Select * From `location` Where City like '".$City."' and CitySn like ".$CitySn." and Town like '"
                                                                .$Town."' and TownSn like ".$TownSn;
                        $delete_query="Delete From `location` Where City like '".$City."' and CitySn like ".$CitySn." and Town like '"
                                                                .$Town."' and TownSn like ".$TownSn;
                        $locationJoinStation="SELECT * FROM location,station where location.City=station.S_City and location.Town=station.S_Town 
                                                and location.City='".$City."' and location.Town='".$Town."'";
                        $num_fkstation=mysqli_num_rows(mysqli_query($db_link,$locationJoinStation));
                        //echo $num_fkstation."<br>";
                        if($num_fkstation>0){
                            echo "不能刪除資料因爲station表格參考到此資料<br>";
                        }
                        else{
                            $result = mysqli_query( $db_link, $sql_query);
                            if($db_link->query($sql_query) == TRUE){
                                if(mysqli_num_rows($result)!=0){
                                    echo "已刪除下列資料：<br>";
                                    echo '<table border="1" align = "left" >
                                    <tr>
                                        <th>City</th>
                                        <th>Citysn</th>
                                        <th>Town</th>
                                        <th>Townsn</th>
                                    </tr>';
                                    while($row_result = mysqli_fetch_array($result)) {
                                        echo "<tr>";
                                        for($i=0;$i<mysqli_num_fields($result);$i++)
                                        echo "<td>".$row_result[$i]."</td>";
                                        echo "</tr>";
                                    }
                                    mysqli_query($db_link,$delete_query);
                                }
                                else{
                                    echo "要刪除的資料不在此表格中!";
                                }
                            }
                            else{
                                echo "刪除資料錯誤: " . $db_link->error;
                            }
                        }
                    }
                    break;
                //datetime表格
               case "datetime":{
                        $InfoTime=$_REQUEST["InfoTime"];
                        $InfoDate=$_REQUEST["InfoDate"];
                        $sql_query="Select * From `datetime` Where Infodate ='".$InfoDate."' and Infotime = '".$InfoTime.":00'";
                        $delete_query="Delete From `datetime` Where Infodate ='".$InfoDate."' and Infotime = '".$InfoTime.":00'";
                        $dateJoinNote="Select * From `datetime`, `note` Where datetime.InfoTime=note.N_Time 
                                            and datetime.InfoTime='".$InfoTime."'";
                        $dateJoinWeather="Select * From `datetime`, obsweather Where datetime.InfoTime=obsweather.ObsTime 
                                            and datetime.InfoTime='".$InfoTime."'";
                        $num_fkNote=mysqli_num_rows(mysqli_query($db_link,$dateJoinNote));
                        $num_fkWeather=mysqli_num_rows(mysqli_query($db_link,$dateJoinWeather));
                        //echo $num_fkNote.",".$num_fkWeather.'<br>';
                        if($num_fkNote>0&&$num_fkWeather>0){
                            echo "不能刪除此資料因爲Note和Weather表格參考到此資料<br>";
                        }
                        else if($num_fkNote>0&&$num_fkWeather==0){
                            echo "不能刪除此資料因爲Note表格參考到此資料<br>";
                        }
                        else if($num_fkNote==0&&$num_fkWeather>0){
                            echo "不能刪除此資料因爲Weather表格參考到此資料<br>";
                        }
                        else{
                            $result = mysqli_query( $db_link, $sql_query);
                            if($db_link->query($sql_query) == TRUE){
                                if(mysqli_num_rows($result)!=0){
                                    echo "已刪除下列資料：<br>";
                                    echo '<table border="1" align = "left">
                                    <tr>
                                        <th>Infodate</th>
                                        <th>Infotime</th>
                                    </tr>';
                                    while($row_result = mysqli_fetch_array($result)) {
                                        echo "<tr>";
                                        for($i=0;$i<mysqli_num_fields($result);$i++)
                                        echo "<td>".$row_result[$i]."</td>";
                                        echo "</tr>";
                                    }
                                    mysqli_query($db_link,$delete_query);
                                }
                                else{
                                    echo "要刪除的資料不在此表格中!";
                                }
                            }
                            else{
                                echo "刪除資料錯誤: " . $db_link->error;
                            }
                        }
                    }
                    break;
                //note表格
               case "note":{
                        $H_FX=$_REQUEST["H_FX"];
                        $H_XD=$_REQUEST["H_XD"];
                        $N_StationID=$_REQUEST["N_StationID"];
                        $N_Time=$_REQUEST["N_Time"];
                        $sql_query="Select * From `note` Where H_FX like ".$H_FX." and H_XD like ".$H_XD
                                    ." and N_StationID = '".$N_StationID."' and N_Time = '".$N_Time."'";
                        $delete_query="Delete From `note` Where H_FX like ".$H_FX." and H_XD like ".$H_XD
                                    ." and N_StationID = '".$N_StationID."' and N_Time = '".$N_Time."'";
                        $result = mysqli_query( $db_link, $sql_query);
                        if($db_link->query($sql_query) == TRUE){
                            if(mysqli_num_rows($result)!=0){
                                echo "已刪除下列資料：<br>";
                                echo '<table border="1" align = "left">
                                <tr>
                                    <th>H_FX</th>
                                    <th>H_XD</th>
                                    <th>N_StationID</th>
                                    <th>N_Time</th>
                                </tr>';
                                while($row_result = mysqli_fetch_array($result)) {
                                    echo "<tr>";
                                    for($i=0;$i<mysqli_num_fields($result);$i++)
                                    echo "<td>".$row_result[$i]."</td>";
                                    echo "</tr>";
                                }
                                mysqli_query($db_link,$delete_query);
                            }
                            else{
                                echo "要刪除的資料不在此表格中!";
                            }
                        }
                        else{
                            echo "刪除資料錯誤: " . $db_link->error;
                        }
                    }
                    break;
                //record表格
               case "record":{
                        $D_TX=$_REQUEST["D_TX"];
                        $D_TN=$_REQUEST["D_TN"];
                        $H24R=$_REQUEST["H24R"];
                        $R_Date=$_REQUEST["R_Date"];
                        $R_StationID=$_REQUEST["R_StationID"];
                        $sql_query="Select * From `record` Where D_TX like ".$D_TX." and D_TN like ".$D_TN." and H24R like ".$H24R.
                                    " and R_Date ='".$R_Date."' and R_StationID ='".$R_StationID."'";
                        $delete_query="Delete From `record` Where D_TX like ".$D_TX." and D_TN like ".$D_TN." and H24R like ".$H24R.
                                    " and R_Date ='".$R_Date."' and R_StationID ='".$R_StationID."'";            
                        $result = mysqli_query( $db_link, $sql_query);
                        if($db_link->query($sql_query) == TRUE){
                            if(mysqli_num_rows($result)!=0){
                                echo "已刪除下列資料：<br>";
                                echo '<table border="1" align = "left">
                                <tr>
                                    <th>D_TX</th>
                                    <th>D_TN</th>
                                    <th>H24R</th>
                                    <th>R_Date</th>
                                    <th>R_StationID</th>
                                </tr>';
                                while($row_result = mysqli_fetch_array($result)) {
                                    echo "<tr>";
                                    for($i=0;$i<mysqli_num_fields($result);$i++)
                                    echo "<td>".$row_result[$i]."</td>";
                                    echo "</tr>";
                                }
                                mysqli_query($db_link,$delete_query);
                            }
                            else{
                                echo "要刪除的資料不在此表格中!";
                            }
                        }
                        else{
                            echo "刪除資料錯誤: " . $db_link->error;
                        }
                    }
                    break;
                default:
                    echo "<br>no table select!";
                    break;
                }  
           }

    ?>
    <!---返回read.php
    <a href="read.php" οnclick="javascript:location.replace(this.href);event.returnValue=false; ">返回主頁</a>
    --->

    <!---返回上一頁 但不會重新整理(按F5才能看到刪除后的更改結果)--->
    <input type ="button" onclick="history.back()" value="回到上一頁"></input><br>

    <!---刪除資料--->
</body>
</html>

