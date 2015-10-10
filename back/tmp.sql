create table User (
	id	int,
	transactions	int,
	gender	int,
	username	char(10),
	password	char(20),
	primary key (id)
);

create table Sell (
	itemid	int,
	postdate	datetime,
	userid	char(10),
	primary key (itemid)
);

create table Buy (
	itemid	int,
	solddate	datetime,
	userid	char(10),
	primary key (itemid)
);

create table Item (
	itemid 	int,
	material	char(10),
	price	float,
	gender	int,
	sold 	bool,
	status	char(10),
	count	int,
	views	int,
	userid	int,
	primary key (itemid)
);

create table Top (
	itemid 	int,
	style	char(10),
	size 	char(10),
	primary key (itemid)
);

create table Bottom (
	itemid 	int,
	style	char(10),
	size 	char(10),
	primary key (itemid)
);

create table Shoes (
	itemid 	int,
	style	char(10),
	size 	float,
	primary key (itemid)	
);

create table Message (
	fromid	int,
	toid	int,
	content	char(200),
	time	datetime,
	primary key (fromid, toid)
);

create table Picture (
	itemid	int,
	url		char(10),
	primary key (itemid)
);
