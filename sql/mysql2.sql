CREATE TABLE `xquiz_answers2` (
  `id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL,
  `quiz_id` int(30) NOT NULL,
  `question_id` int(30) NOT NULL,
  `option_id` int(30) NOT NULL,
  `is_right` tinyint(1) NOT NULL COMMENT ' 1 = right, 0 = wrong',
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `xquiz_history` (
  `id` int(30) NOT NULL,
  `quiz_id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL,
  `score` int(5) NOT NULL,
  `total_score` int(5) NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `xquiz_questions2` (
  `id` int(30) NOT NULL,
  `question` text NOT NULL,
  `qid` int(30) NOT NULL,
  `order_by` int(11) NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `xquiz_question_opt` (
  `id` int(30) NOT NULL,
  `option_txt` text NOT NULL,
  `question_id` int(30) NOT NULL,
  `is_right` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1= right answer',
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `xquiz_quiz_list` (
  `id` int(30) NOT NULL,
  `title` varchar(200) NOT NULL,
  `qpoints` int(11) NOT NULL DEFAULT 1,
  `user_id` int(20) NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `xquiz_quiz_user_list` (
  `id` int(30) NOT NULL,
  `quiz_id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE xquiz_quizzes (
  id int(10) unsigned NOT NULL auto_increment,
  name varchar(45) character set utf8 collate utf8_bin NOT NULL,
  cid int(10) unsigned NOT NULL,
  description text character set utf8 collate utf8_bin,
  bdate datetime NOT NULL,
  edate datetime NOT NULL,
  weight int(11) default '0',
  PRIMARY KEY  (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE xquiz_score (
  id int(10) unsigned NOT NULL,
  userid int(11) unsigned NOT NULL,
  score int(11) NOT NULL,
  date datetime NOT NULL,
  PRIMARY KEY  (id,userid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE xquiz_categories (
  cid int(11) unsigned NOT NULL auto_increment,
  pid int(11) unsigned NOT NULL default '0',
  title varchar(100) NOT NULL default '',
  imgurl varchar(255) NOT NULL default '',
  description text NOT NULL,
  weight int(11) NOT NULL default '0',
  PRIMARY KEY  (cid),
  KEY pid (pid)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE xquiz_questions (
  question_id int(10) unsigned NOT NULL auto_increment,
  quiz_id int(10) unsigned NOT NULL,
  score int(10) default '1',
  qnumber int(5) unsigned default '1',
  question_type varchar(2) default NULL,
  question text,
  PRIMARY KEY  (question_id),
  KEY quiz_id (quiz_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE xquiz_answers (
  answer_id int(10) NOT NULL auto_increment,
  question_id int(10) NOT NULL,
  is_correct tinyint(1) default '0',
  answer varchar(255) default NULL,
  PRIMARY KEY  (answer_id),
  KEY question_id (question_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;