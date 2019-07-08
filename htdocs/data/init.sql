CREATE DATABASE SOTAdb;
  use SOTAdb;
  CREATE TABLE authors (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL
  );
  CREATE TABLE papers (
  	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  	title VARCHAR(30) NOT NULL,
  	abstract VARCHAR(30),
  	SOTAresult INT(11) NOT NULL
  );
  CREATE TABLE paper_author(
  	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  	author_firstname VARCHAR(30) NOT NULL,
    author_lastname VARCHAR(30) NOT NULL,
  	title VARCHAR(30) NOT NULL
  );
  CREATE TABLE topic_paper(
  	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  	topic_name VARCHAR(30) NOT NULL,
  	title VARCHAR(30) NOT NULL
  );
  CREATE TABLE topics(
  	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  	topic_name VARCHAR(30) NOT NULL,
  	SOTAresult INT(11) NOT NULL
  );

CREATE PROCEDURE coauthorproc(IN firstname CHAR(30), IN lastname CHAR(30))
  BEGIN
    SELECT s1.author_firstname, s1.author_lastname FROM paper_author AS s1 WHERE s1.title IN(SELECT s2.title FROM paper_author AS s2 WHERE s2.author_firstname = firstname AND s2.author_lastname = lastname);
  END;

