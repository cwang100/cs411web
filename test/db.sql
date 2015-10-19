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
	owner VARCHAR( 50 ) NOT NULL ,
	sold BOOLEAN NOT NULL ,
	img VARCHAR(512),
	style VARCHAR(100),
	size VARCHAR(50),
	type VARCHAR(20),
	price FLOAT,
	PRIMARY KEY (id)
);

