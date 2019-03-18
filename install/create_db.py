import mysql.connector

def getCreationQueryForCategoryTable():
  query = """CREATE TABLE category (
            id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            name varchar(30) NOT NULL,
            PRIMARY KEY (id))"""
  return query  

def getCreationQueryForPersonTable():
  query = """CREATE TABLE person (
              id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
              firstname varchar(30) NOT NULL,
              lastname varchar(30) NOT NULL,
              email varchar(50) NOT NULL,
              tel_no int(10) UNSIGNED NOT NULL,
              img_path varchar(100) DEFAULT NULL,
              account_balance float DEFAULT NULL,
              is_admin tinyint(1) DEFAULT NULL,
              user_pw char(96) DEFAULT NULL,
              is_active tinyint(1) NOT NULL,
              PRIMARY KEY (id))"""
  return query

def getCreationQueryForArticleTable():
  query = """CREATE TABLE article (
             id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
             name varchar(50) NOT NULL,
             price float UNSIGNED NOT NULL,
             count int(10) UNSIGNED NOT NULL,
             category int(11) UNSIGNED NOT NULL,
             img_path varchar(100) NOT NULL,
             PRIMARY KEY (id),
             FOREIGN KEY (category) REFERENCES category(id))"""
  return query


def getCreationQueryForPAMTable():
  query = """CREATE TABLE person_article_matrix (
            id int(11) NOT NULL AUTO_INCREMENT,
            person_id int(11) UNSIGNED NOT NULL,
            article_id int(11) UNSIGNED NOT NULL,
            count int(11) NOT NULL,
            buy_date datetime NOT NULL,
            price double NOT NULL,
            account_balance double NOT NULL,
            PRIMARY KEY (id),
            FOREIGN KEY (person_id) REFERENCES person(id),
            FOREIGN KEY (article_id) REFERENCES article(id))"""
  return query


def getCreationQueryForPPMTable():
  query = """CREATE TABLE person_payment_matrix (
          id int(11) NOT NULL UNSIGNED AUTO_INCREMENT,
          person_id int(11) UNSIGNED NOT NULL,
          amount float NOT NULL,
          pay_date datetime NOT NULL,
          account_balance_state double NOT NULL,
          PRIMARY KEY (id),
          FOREIGN KEY (person_id) REFERENCES person(id))"""
  return query


def getTrieger():
  query = """
 DELIMITER $$
 CREATE TRIGGER update_person_balance AFTER INSERT ON person_article_matrix FOR EACH ROW begin
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
DELIMITER ;"""
  return query


if __name__ == "__main__":
   dbName ="db_drinks"
   dbConnection = mysql.connector.connect(
    host= "localhost",
    user="root",
    passwd=""
   )
   cursor = dbConnection.cursor()
   try:
     cursor.execute("DROP DATABASE IF EXISTS "+dbName)
     cursor.execute("CREATE DATABASE "+dbName)
     cursor.execute("USE "+dbName)
     cursor.execute(getCreationQueryForCategoryTable())
     cursor.execute(getCreationQueryForPersonTable())
     cursor.execute(getCreationQueryForArticleTable())
     cursor.execute(getCreationQueryForPAMTable())
     cursor.execute(getCreationQueryForPPMTable())
     cursor.execute(getTrieger())
     dbConnection.commit()
   except mysql.connector.Error as identifier:
    print(identifier)
   finally:
    cursor.close()
