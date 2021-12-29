<?php error_reporting(0); ?>
<?php
$host = 'localhost';
$dbuser = 'jamesong1012';
$dbpassword = 'l0986661274';
$dbname = 'weather';
$link = mysqli_connect($host, $dbuser, $dbpassword, $dbname);

if ($link) {
    mysqli_query($link, 'SET NAMES utf8mb4');
    // echo "正確連接資料庫";
} else {
    echo "不正確連接資料庫</br>" . mysqli_connect_error();
}
?>

<html>

<head>
    <meta charset="UTF-8" />
    <title>
        自動氣象站
    </title>

    <head>

    <body>
        <form action="query.php" method="post" name="formAdd" id="formAdd">
            <font size="6"><b>自動氣象站查詢平台</b></font><br><br>

            <b>◆查詢某地點的氣象情況（最高低溫度、濕度、下雨情況）：</b>
            <br>請輸入日期：<input type="date" name="infoDate" id="infoDate"><br />
            請選擇地點：<select name="City" id="City"><br />
                <br>
                <br>
                <option selected value="">選擇縣市</option>
                <?php
                $sql = "SELECT DISTINCT city
                    FROM location
                    ORDER BY city"; //DISTINCT可選出欄位中具有不同名稱的資料，本例中會挑出TV與Player
                $result = mysqli_query($link, $sql) or die("資料選取錯誤！" . mysqli_error($link));
                while ($data = mysqli_fetch_assoc($result)) {
                ?>
                    <option value="<?= $data['city'] ?>"><?= $data['city'] ?></option>
                <?php
                }
                ?>
            </select>
            <input type="submit" name="button1" value="搜尋">
            <br><br />

            <?php
            if ($_POST["City"] && $_POST["infoDate"]) {
                $infoDate = $_POST['infoDate'];
                $City = $_POST['City'];
                //echo $infoDate . $City;
                $infoDate = $_POST['infoDate'];
                $City = $_POST['City'];

                echo "<table border=\"1\">";
                echo "<tr>";

                echo "<tr>";
                echo "<th>" . $City . " " . $infoDate . "</th>";
                echo "</tr>";

                echo "<th>鄉鎮</th>";
                echo "<th>最高溫度 (C)</th>";
                echo "<th>最低溫度 (C)</th>";
                echo "<th>平均溫度 (C)</th>";
                echo "<th>相對濕度 (%)</th>";
                echo "<th>氣壓 (hPa)</th>";
                echo "<th>風速 (m/s)</th>";
                echo "</tr>";

                $sql_query = "SELECT s_city, s_town, MAX(d_tx) as highest, MIN(d_tn) as lowest, AVG(temp), AVG(humd), AVG(pres), AVG(wdsd)
                FROM obsweather as obs, station as sta, record as rec
                where date(obs.obstime) = '$infoDate' 
                    AND date(obs.obstime) = rec.r_date
                    AND obs.stationnum = sta.stationid
                    AND rec.r_stationid = sta.stationid
                    AND sta.s_city = '$City' 
                GROUP BY s_city, s_town
                ORDER BY s_town";

                $result = mysqli_query($link, $sql_query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row["s_town"] . "</td>";
                        //intval($row["highest"] * ($p = pow(10, 2))) / $p;
                        echo "<td>" . $row["highest"] . "</td>";
                        echo "<td>" . $row["lowest"] . "</td>";
                        echo "<td>" . number_format((float) $row["AVG(temp)"], 2, '.', '') . "</td>";
                        echo "<td>" . number_format((float) $row["AVG(humd)"], 2, '.', '') . "</td>";
                        echo "<td>" . number_format((float) $row["AVG(pres)"], 2, '.', '') . "</td>";
                        echo "<td>" . number_format((float) $row["AVG(wdsd)"], 2, '.', '') . "</td>";
                        echo "</tr>";
                        //echo "Town: " . $row["s_town"] . "<br>" . " 降水量: " . $row["SUM(h24r)"] . " (mm)" .
                        //  "<br>" . "下雨天數:" . $row["raining_days"] . " 天" . "<br>" . "<br>";
                    }
                } else {
                    echo "0 results";
                }
            }

            ?>
            <br><br />
            <b>◆查詢某地點的降水量、下雨天數：</b><br>
            請輸入時段：<input type="date" name="infoDate2" id="infoDate2"> 至 <input input type="date" name="infoDate3" id="infoDate3">
            <br />
            請選擇地點：<select name="City2" id="City2"><br />

                <option selected value="">選擇縣市</option>
                <?php
                $sql = "SELECT DISTINCT city
                    FROM location
                    ORDER BY city"; //DISTINCT可選出欄位中具有不同名稱的資料，本例中會挑出TV與Player
                $result = mysqli_query($link, $sql) or die("資料選取錯誤！" . mysqli_error($link));
                while ($data = mysqli_fetch_assoc($result)) {
                ?>
                    <option value="<?= $data['city'] ?>"><?= $data['city'] ?></option>
                <?php
                }
                ?>

            </select>
            <input type="submit" name="button2" value="搜尋">
            <br><br />

            <?php
            if ($_POST["City2"] && $_POST["infoDate2"] && $_POST["infoDate3"]) {
                $infoDate2 = $_POST['infoDate2'];
                $infoDate3 = $_POST['infoDate3'];
                $City2 = $_POST['City2'];
                //echo $infoDate2 . " to " . $infoDate3 . $City2;
                $sql_query2 = "SELECT s_city, s_town, SUM(h24r), COUNT(*) as raining_days
                FROM record as rec, station as sta
                WHERE (rec.r_date BETWEEN '$infoDate2' AND '$infoDate3') 
                    AND sta.s_city = '$City2'
                    AND sta.stationid = rec.r_stationid
                    AND rec.h24r != 0
                GROUP BY s_city, s_town";

                echo "<table border=\"1\">";

                echo "<tr>";
                echo "<th>" . $City2 . " " . $infoDate2 . " 到 " . $infoDate3 . "</th>";
                echo "</tr>";

                echo "<tr>";
                echo "<th>鄉鎮</th>";
                echo "<th>降水量 (mm)</th>";
                echo "<th>下雨天數 (天)</th>";
                echo "</tr>";

                $result2 = mysqli_query($link, $sql_query2);

                if (mysqli_num_rows($result2) > 0) {
                    while ($row = mysqli_fetch_assoc($result2)) {
                        echo "<tr>";
                        echo "<td>" . $row["s_town"] . "</td>";
                        echo "<td>" . $row["SUM(h24r)"] . "</td>";
                        echo "<td>" . $row["raining_days"] . "</td>";
                        echo "</tr>";
                        //echo "Town: " . $row["s_town"] . "<br>" . " 降水量: " . $row["SUM(h24r)"] . " (mm)" .
                        //  "<br>" . "下雨天數:" . $row["raining_days"] . " 天" . "<br>" . "<br>";
                    }
                } else {
                    echo "0 results";
                }
            }
            ?>
        </form>
    </body>

</html>



<?php

/*
if (isset($_POST["button1"]) && ($_POST['button1'] == "搜尋")) {


    $infoDate = $_POST['infoDate'];
    $City = $_POST['City'];

    $sql_query = "SELECT City, min(Temp), max(Temp), infoDate, HUMD
                  FROM location, weather, datetime
                  WHERE City='City' and infoDate='infoDate'";

    $result = mysqli_query($link, $sql_query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "City: " . $row["City"] . "<br>" . " infoDate: " . $row["infoDate"] .
                "<br>" . "Max Temp:" . $row["max(Temp)"] . "<br>" . "Min Temp:" . $row["min(Temp)"] . "<br>" .
                "Humidity: " . $row["HUMD"];
        }
    }
}

if (isset($_POST["button2"]) && ($_POST['button2'] == "搜尋")) {


    $infoDate2 = $_POST['infoDate2'];
    $infoDate3 = $_POST['infoDate3'];
    $City2 = $_POST['City2'];


    $sql_query2 = "SELECT City, sum(H24R), count(H24R)
                   FROM location, record, datetime
                   WHERE City='City' and infoDate between 'infoDate2' and 'infoDate3'";

    $result2 = mysqli_query($link, $sql_query2);

    if (mysqli_num_rows($result2) > 0) {
        while ($row = mysqli_fetch_assoc($result2)) {
            echo "City: " . $row["City"] . "<br>" . " 降水量: " . $row["sum(H24R)"] .
                "<br>" . "下雨天數:" . $row["count(H24R)"] . "<br>";
        }
    } else {
        echo "0 results";
    }
}*/
?>