CREATE TABLE question (
  id int(10) unsigned NOT NULL auto_increment,
  qid int(10) unsigned NOT NULL,
  question varchar(200) character set utf8 collate utf8_bin NOT NULL,
  qnumber int(10) unsigned NOT NULL ,
  score int(10) unsigned NOT NULL ,
  ans1 varchar(200) character set utf8 collate utf8_bin default NULL,
  ans2 varchar(200) character set utf8 collate utf8_bin default NULL,
  ans3 varchar(200) character set utf8 collate utf8_bin default NULL,
  ans4 varchar(200) character set utf8 collate utf8_bin default NULL,
  answer enum('1','2','3','4') NOT NULL,
  PRIMARY KEY  (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE quiz (
  id int(10) unsigned NOT NULL auto_increment,
  name varchar(45) character set utf8 collate utf8_bin NOT NULL,
  cid int(10) unsigned NOT NULL,
  description text character set utf8 collate utf8_bin,
  bdate datetime NOT NULL,
  edate datetime NOT NULL,
  weight int(11) default '0',
  PRIMARY KEY  (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE quiz_users (
  id int(10) unsigned NOT NULL,
  userid int(11) unsigned NOT NULL,
  score int(11) NOT NULL,
  date datetime NOT NULL,
  PRIMARY KEY  (id,userid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE quiz_cat (
  cid int(11) unsigned NOT NULL auto_increment,
  pid int(11) unsigned NOT NULL default '0',
  title varchar(100) NOT NULL default '',
  imgurl varchar(255) NOT NULL default '',
  description text NOT NULL,
  weight int(11) NOT NULL default '0',
  PRIMARY KEY  (cid),
  KEY pid (pid)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


CREATE TABLE question_user (
  questId int(10) NOT NULL,
  quizId int(10) NOT NULL,
  userId int(11) NOT NULL,
  userAns enum('1','2','3','4') NOT NULL,
  PRIMARY KEY  (questId,quizId,userId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE quiz_questions (
  question_id int(10) unsigned NOT NULL auto_increment,
  quiz_id int(10) unsigned NOT NULL,
  score int(10) default '1',
  qnumber int(5) unsigned default '1',
  question_type varchar(2) default NULL,
  question text,
  PRIMARY KEY  (question_id),
  KEY quiz_id (quiz_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE quiz_answers (
  answer_id int(10) NOT NULL auto_increment,
  question_id int(10) NOT NULL,
  is_correct tinyint(1) default '0',
  answer varchar(255) default NULL,
  PRIMARY KEY  (answer_id),
  KEY question_id (question_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;