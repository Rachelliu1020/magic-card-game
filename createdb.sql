CREATE DATABASE IF NOT EXISTS magic_card_db;
USE magic_card_db;

CREATE TABLE IF NOT EXISTS leaderboard (
  id INTEGER NOT NULL auto_increment,
  user_name varchar(100) default NULL,
  user_score INTEGER NOT NULL,
  datetime varchar(25) NOT NULL default '',
  PRIMARY KEY (id)
) ENGINE=MyISAM;



