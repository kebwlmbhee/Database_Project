import pandas as pd
import numpy as np
import csv

data = pd.read_csv('data.csv')
dataframe=data.loc[:,['City','CitySn','Town','TownSn']]
list=dataframe.to_dict('records')
list = [dict(t) for t in set([tuple(d.items()) for d in list])]
keys = list[0].keys()
w =open('location.csv','w')
dict_writer = csv.DictWriter(w, keys)
dict_writer.writeheader()
dict_writer.writerows(list)
w.close()

#讀取local.csv


data = pd.read_csv('data.csv')
dataframe=data.loc[:,['InfoDate','InfoTime']]
list=dataframe.to_dict('records')
list = [dict(t) for t in set([tuple(d.items()) for d in list])]
keys = list[0].keys()
w =open('datetime.csv','w')
dict_writer = csv.DictWriter(w, keys)
dict_writer.writeheader()
dict_writer.writerows(list)
w.close()
  #讀取DateTime.csv  
data = pd.read_csv('data.csv')
dataframe=data.loc[:,['Lat','Lon','LatWGS84','LonWGS84','StationID',  'LocationName','ELEV','City','Town']]
list=dataframe.to_dict('records')
list = [dict(t) for t in set([tuple(d.items()) for d in list])]
keys = list[0].keys()
w =open('station.csv','w')
dict_writer = csv.DictWriter(w, keys)
dict_writer.writeheader()
dict_writer.writerows(list)
w.close()
 #讀取station.csv                              #dataframe.to_csv("station.csv",index=False,encoding='big5')



data = pd.read_csv('data.csv')
dataframe=data.loc[:,['ObsTime','WDIR','WDSD','Temp',"HUMD",'PRES','StationID']]
list=dataframe.to_dict('records')
list = [dict(t) for t in set([tuple(d.items()) for d in list])]
keys = list[0].keys()      #list[0] is <class 'dict'>

w =open('obs.csv','w')
dict_writer = csv.DictWriter(w, keys)
dict_writer.writeheader()
dict_writer.writerows(list)
w.close()
##讀取ObsWeather.csv




path = 'data.csv'
f = open(path, 'r')
rows = csv.DictReader(f, delimiter=',')
list=[]
a=0
for row in rows:
    a=a+1
    if len(row["H_FX"])!=0 and len(row["H_XD"])!=0:   #row is <class 'collections.OrderedDict'>
        #print(type(row))   
        list.append(row)
list = [dict(t) for t in set([tuple(d.items()) for d in list])]
keys = list[0].keys()
w =open('note.csv','w')
dict_writer = csv.DictWriter(w, keys)
dict_writer.writeheader()
dict_writer.writerows(list)
w.close()
data = pd.read_csv('note.csv')
dataframe=data.loc[:,['H_FX','H_XD','StationID','InfoTime']]
dataframe.to_csv("note.csv",index=False,encoding='big5')
#讀取note.csv  



path = 'data.csv'
f = open(path, 'r')
rows = csv.DictReader(f, delimiter=',')
list=[]
for row in rows:
    if row['ObsTime'] =='2021/12/14 0:00'  or row['ObsTime'] =='2021/12/12 0:00' or row['ObsTime'] =='2021/12/13 0:00' or row['ObsTime'] =='2021/12/18 0:00' or row['ObsTime'] =='2021/12/15 0:00':  
       list.append(row)
list = [dict(t) for t in set([tuple(d.items()) for d in list])]
keys = list[0].keys()
w =open('record.csv','w')
dict_writer = csv.DictWriter(w, keys)
dict_writer.writeheader()
dict_writer.writerows(list)
w.close()
data = pd.read_csv('record.csv')
dataframe=data.loc[:,['D_TX','D_TN','H24R','InfoDate','StationID']]
dataframe.to_csv("record.csv",index=False,encoding='big5')
   #record :把每個站0點時的紀錄取出來，再處理之後可以得到H24R。DTX。DTN 




