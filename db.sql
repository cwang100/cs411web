DROP TABLE IF EXISTS `User`;
CREATE TABLE User (
	id INT( 20 ) NOT NULL AUTO_INCREMENT ,
	username VARCHAR ( 50 ) NOT NULL,
	email VARCHAR( 100 ) NOT NULL ,
	password VARCHAR( 255 ) NOT NULL ,
	PRIMARY KEY (id)
);

DROP TABLE IF EXISTS `Item`;
CREATE TABLE Item (
	id INT( 20 ) NOT NULL AUTO_INCREMENT ,
	name VARCHAR( 50 ) NOT NULL ,
	material VARCHAR( 100 ) ,
	gender VARCHAR( 20 ) ,
	count INT( 50 ) NOT NULL ,
	detail TEXT( 50 ) ,
	ownerid int( 20 ) NOT NULL ,
	img VARCHAR(512),
	style VARCHAR(100),
	size VARCHAR(50),
	type VARCHAR(20),
	price FLOAT,
	PRIMARY KEY (id),
	FOREIGN KEY (ownerid) REFERENCES User(id)
);

DROP TABLE IF EXISTS `Buy`;
CREATE TABLE Buy (
	itemid int(20) NOT NULL,
	buyerid int(20) NOT NULL,
	buydate timestamp NOT NULL default CURRENT_TIMESTAMP,
	PRIMARY KEY (itemid, buyerid)
);

DROP TABLE IF EXISTS `Sell`;
CREATE TABLE Sell (
	itemid int(20) NOT NULL,
	posterid int(20) NOT NULL,
	postdate timestamp NOT NULL default CURRENT_TIMESTAMP,
	PRIMARY KEY (itemid, posterid)
);

DROP TABLE IF EXISTS `Msg`;
CREATE TABLE Msg (
	msgid int(20) NOT NULL AUTO_INCREMENT,
	msg VARCHAR(512) NOT NULL,
	senderid int(20) NOT NULL,
	recverid int(20) NOT NULL,
	postertime timestamp NOT NULL default CURRENT_TIMESTAMP,
	readed boolean NOT NULL default 0,
	PRIMARY KEY (msgid)
);

DROP TABLE IF EXISTS `Chat`;
CREATE TABLE `Chat` (
  `id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `from` VARCHAR(255) NOT NULL DEFAULT '',
  `to` VARCHAR(255) NOT NULL DEFAULT '',
  `message` TEXT NOT NULL,
  `sent` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `recd` INTEGER UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
)
