DROP DATABASE forum;
CREATE DATABASE forum;

USE forum;

CREATE TABLE leaderboard (
  id INTEGER NOT NULL auto_increment,
  rank_num INTEGER NOT NULL,
  user_name varchar(100) default NULL,
  user_score INTEGER NOT NULL,
  datetime varchar(25) NOT NULL default '',
  PRIMARY KEY (id)
) ENGINE=MyISAM;

CREATE TABLE response (
  id INTEGER NOT NULL auto_increment,
  topic_id INTEGER NOT NULL,
  member_id INTEGER NOT NULL,
  response longtext NOT NULL,
  datetime varchar(25) NOT NULL default '',
  PRIMARY KEY (id),
  FOREIGN KEY (topic_id) REFERENCES topic(id) ON DELETE CASCADE,
  FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE
) ENGINE=MyISAM;

CREATE TABLE members (
  member_id INTEGER unsigned NOT NULL auto_increment,
  firstname varchar(100) default NULL,
  lastname varchar(100) default NULL,
  login varchar(100) NOT NULL default '',
  passwd varchar(32) NOT NULL default '',
  PRIMARY KEY (member_id)
) ENGINE=MyISAM;

