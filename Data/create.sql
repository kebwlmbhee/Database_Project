CREATE TABLE location(
	City varchar(256) NOT NULL,
	CitySn int NOT NULL,
	Town varchar(256) NOT NULL,
	TownSn int NOT NULL,
	PRIMARY KEY(City,Town)
);

Create table station(
	Lat float not null,
	Lon float not null,
	LatWGS84 float not null,
	LonWGS84 float not null,
	StationID  varchar(256) primary key,
	StationName varchar(256) not null,
	ELEV float not null,
	S_City varchar(256) not null ,
	S_Town varchar(256) not null,
	CONSTRAINT PFK 
       FOREIGN KEY (S_City, S_Town) 
       REFERENCES location ( City, Town) on update cascade 
);


create table datetime(
	InfoDate date not null,
	InfoTime timestamp primary key
);


CREATE TABLE obsweather(
	ObsTime timestamp not null,
	WDIR float,
	WDSD float ,
	Temp float ,
	HUMD float ,
	PRES float ,
	StationNum varchar(256) not null,
	primary key(ObsTime,StationNum),
	CONSTRAINT fk_station_weather FOREIGN KEY(StationNum) references station(StationID) on delete restrict on update cascade,
	CONSTRAINT fk_DateTime_weather FOREIGN KEY(ObsTime) references datetime(InfoTime) on update cascade
);



create table note(
	H_FX float,
	H_XD float,
	N_StationID varchar(256) not null,
	N_Time timestamp not null,
	primary key(N_StationID,N_Time),
	CONSTRAINT fk_station_note FOREIGN KEY(N_StationID) references station(StationID) on delete restrict on update cascade,
	constraint fk_datetime_note FOREIGN KEY(N_Time) references datetime(Infotime) on update cascade
);


create table record(
	D_TX float,
	D_TN float,
	H24R float,
	R_Date date not NULL,
	R_StationID varchar(256) not NULL,
	primary key(R_StationID,R_Date),
	CONSTRAINT fk_station_record FOREIGN KEY(R_StationID) references station(StationID) on delete restrict on update cascade
);
