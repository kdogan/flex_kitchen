CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `price` float UNSIGNED NOT NULL,
  `count` int(10) UNSIGNED NOT NULL,
  `category` int(11) NOT NULL,
  `img_path` varchar(100) NOT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `article` (`name`, `price`, `count`, `category`, `img_path`) VALUES
('Clup Matte', 1, 20, 1, 'clup_matte.jpg'),
('Caffee', 1.35, 20, 2, 'caffee.jpg'),
('Tee', 0.35, 18, 2, 'cay.jpg'),
('Wasser 1 lt', 1, 18, 1, 'wasser.jpg');

CREATE USER 'flex_kitchen'@'localhost' IDENTIFIED BY 'root' grant all privileges on flex_kitchen.* to flex_kitchen@'%' identified by 'root';

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'cold drinks'),
(2, 'warm drinks');

CREATE TABLE `person` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `tel_no` int(10) UNSIGNED NOT NULL,
  `img_path` varchar(100) DEFAULT NULL,
  `account_balance` float DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT NULL,
  `user_pw` char(96) DEFAULT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `person` (`firstname`, `lastname`, `email`, `tel_no`, `img_path`, `account_balance`, `is_admin`, `user_pw`) VALUES
('Test', 'Person', 'testperson@flex.de', 1234, 'userImg1.png', -5.7, 0, 'cfcd208495d565ef66e7dff9f98764da'),
('Mike', 'Hans', 'mikehans@flex.de', 72199, 'userImg2.png', -17.45, 0, 'cfcd208495d565ef66e7dff9f98764da'),
('Hatun', 'Hanim', 'hatun@flex.de', 8783, 'userImg3.png', 1, 0, 'cfcd208495d565ef66e7dff9f98764da'),
('admin', 'flex', 'admin@flex.de', 111, 'admin.png', 0, 1, '897a779351421523cadbafccdce22efe');


CREATE TABLE `person_article_matrix` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `buy_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `person_article_matrix` (`person_id`, `article_id`, `count`, `buy_date`) VALUES
(1, 3, 1, '2017-12-30 13:50:15'),
(1, 1, 1, '2017-12-30 13:54:21'),
(1, 3, 1, '2018-01-07 00:00:00');


DELIMITER $$
CREATE TRIGGER `update_person_balance` AFTER INSERT ON `person_article_matrix` FOR EACH ROW begin
 DECLARE oldBalance FLOAT;
 DECLARE articlePrice FLOAT;
 DECLARE articleCount INT;
 DECLARE newBalance FLOAT;
 
 SET oldBalance = (SELECT account_balance FROM person WHERE id = NEW.person_id); 
 SET articlePrice = (SELECT price from article where id = NEW.article_id);
 SET articleCount = (SELECT count from article where id = NEW.article_id);
 SET newBalance = oldBalance - articlePrice; 
 UPDATE person
 SET person.account_balance = newBalance
 WHERE person.id = NEW.person_id;
 
 UPDATE article
 SET article.count = articleCount-1
 WHERE article.id = NEW.article_id;
      
END
$$
DELIMITER ;