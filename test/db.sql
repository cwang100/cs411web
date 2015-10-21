CREATE TABLE User (
	id INT( 20 ) NOT NULL AUTO_INCREMENT ,
	username VARCHAR ( 50 ) NOT NULL,
	email VARCHAR( 100 ) NOT NULL ,
	password VARCHAR( 255 ) NOT NULL ,
	PRIMARY KEY (id)
);

CREATE TABLE Item (
	id INT( 20 ) NOT NULL AUTO_INCREMENT ,
	name VARCHAR( 50 ) NOT NULL ,
	material VARCHAR( 100 ) ,
	gender VARCHAR( 20 ) ,
	count INT( 50 ) NOT NULL ,
	detail TEXT( 50 ) ,
	ownerid int( 20 ) NOT NULL ,
	sold BOOLEAN NOT NULL ,
	img VARCHAR(512),
	style VARCHAR(100),
	size VARCHAR(50),
	type VARCHAR(20),
	price FLOAT,
	PRIMARY KEY (id),
	FOREIGN KEY (ownerid) REFERENCES User(id)
);

CREATE TABLE Buy (
	itemid int(20) NOT NULL,
	buyerid int(20) NOT NULL,
	buydate timestamp NOT NULL default CURRENT_TIMESTAMP,
	PRIMARY KEY (itemid, buyerid)
);

CREATE TABLE Sell (
	itemid int(20) NOT NULL,
	posterid int(20) NOT NULL,
	postdate timestamp NOT NULL default CURRENT_TIMESTAMP,
	PRIMARY KEY (itemid, posterid)
);