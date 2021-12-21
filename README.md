# 自動氣象站 

## 題目說明 
建立資料庫以整合由不同氣象觀測站所觀測到的氣象條件，以利於通過分析氣象變化趨勢來預測未來的天氣情況。由於資料權限問題，僅收集12.12-12.18這一週內觀測到的氣象狀況。 

## 資料需求分析 
### Station-觀測站：所觀測到的氣象來自不同氣象站，因此需要對不同測站建立table 
| Attribute | Property |
| --------- | -------- |
| Lat-緯度(座標系統採TWD67) | DOUBLE，不可為NULL |
| Lon-經度(座標系統採TWD67) | DOUBLE，不可為NULL | 
| LatWGS84-緯度(座標系統採WGS84) | DOUBLE，不可為NULL | 
| LonWGS84-(座標系統採WGS84) | DOUBLE，不可為NULL | 
| LocationName-測站名稱 | STRING，不可為NULL，unique | 
| StationID-測站編號 | STRING，不可為NULL，unique | 
| ELEV-海拔高度(公尺) | DOUBLE，不可為NULL，positive | 

 

### Weather-測站觀測之氣象 
| Attribute | Property |
| --------- | -------- |
| WDIR-風向(度) | DOUBLE，0表示無風，大於0表示一般風向，nonnegative | 
| WDSD-風速(公尺/秒) | DOUBLE，0表示無風，nonnegative | 
| Temp-溫度(攝氏) | DOUBLE，不可為NULL | 
| HUMD-相對濕度(百分比) | DOUBLE，max=1，positive | 
| PRES-測站氣壓(百帕) | DOUBLE，不可為NULL | 

 

### Record-當日氣象情況 
| Attribute | Property |
| --------- | -------- |
| D_TX 本日最高溫 | DOUBLE，不可為NULL | 
| D_TN 本日最低溫 | DOUBLE，不可為NULL | 
| H24R-日累積雨量 | DOUBLE，可為NULL | 
| R_Date 當日日期 | DATE，不可為NULL | 



### Note-小時氣象情況(並非每小時都會回傳，可當作是附加的資料） 
| Attribute | Property |
| --------- | -------- |
| H_FX-小時最大陣風風速 | DOUBLE | 
| H_XD-小時最大陣風風向 | DOUBLE | 



### Location-氣象紀錄的地點(縣市、鄉鎮) 
| Attribute | Property |
| --------- | -------- |
| City-縣市 | DOUBLE，不可為NULL | 
| CitySn-縣市編號 | INTERGER，不可為NULL（非unique) | 
| Town-鄉鎮 | STRING，不可為NULL | 
| TownSn-鄉鎮編號 | INTEGER，不可為NULL(非unique) | 



### DateTime-與該紀錄相關聯之時間 
| Attribute | Property |
| --------- | -------- |
| InfoTime-資料代表時間 | DATETIME，不可為NULL | 
| InfoDate-資料代表日期 | DATE，不可為NULL | 

## 系統功能性分析 

+ 可查詢某日某地的氣象情況，如溫度、濕度、下雨情況等
+ 可統計某段時間內某地的降水量和下雨天數
+ 可查詢某日某縣市的最高溫、最低溫 

 

## [來源](https://ticp.motc.gov.tw/ConvergeProj/dataService/viewdata?setId=00974&title=%E8%87%AA%E5%8B%95%E6%B0%A3%E8%B1%A1%E7%AB%99-%E6%B0%A3%E8%B1%A1%E8%A7%80%E6%B8%AC%E8%B3%87%E6%96%99&metadata=00974)