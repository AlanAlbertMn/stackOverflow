CREATE DATABASE stackOverflow;

CREATE TABLE IF NOT EXISTS User (
  idUser INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(100),
  password VARCHAR(75),
  PRIMARY KEY (idUser)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Question (
idQ INT UNSIGNED NOT NULL AUTO_INCREMENT,
idUser INT UNSIGNED NOT NULL,
qtitle VARCHAR(100),
qcontent VARCHAR(255),
PRIMARY KEY (idQ),
FOREIGN KEY (idUser)
    REFERENCES User(idUser)
) ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS Answer (
  idA INT UNSIGNED NOT NULL AUTO_INCREMENT,
  idQ INT UNSIGNED NOT NULL,
  idUser INT UNSIGNED NOT NULL,
  aContent VARCHAR(255),
  PRIMARY KEY (idA),
  FOREIGN KEY (idQ)
	  REFERENCES Question(idQ),
  FOREIGN KEY (idUser)
	  REFERENCES User(idUser)
) ENGINE = InnoDB;

-- Users
insert into User (name, password) values ("Alan", "alan1");
insert into User (name, password) values ("Rodrigo", "rodrigo2021");

-- Questions
INSERT INTO Question(idUser, qtitle, qcontent) VALUES 
(2, "How do I submit a question?", "I have been trying to submit a question but can't find the way to actually submit it. Someone help?");

-- Answers
INSERT INTO Answer(idQ, idUser, aContent) VALUES 
(1, 1, "Simply click on the 'Submit question' button!");
INSERT INTO Answer(idQ, idUser, aContent) VALUES 
(1, 1, "Nevermind, it's now on the 'Question here' button...");

select question.idQ, question.qtitle, question.qcontent, answer.acontent from question join answer on question.idQ = answer.idQ;