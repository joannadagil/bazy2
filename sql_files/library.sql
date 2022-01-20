DROP TABLE RATING;
DROP TABLE BORROWING;
DROP TABLE AUTHORSHIP;
DROP TABLE BOOKINSTANCE;
DROP TABLE DEPARTMENT;
DROP TABLE AUTHOR;
DROP TABLE BOOK;
DROP TABLE MEMBER;


CREATE TABLE DEPARTMENT
(
  DID NUMBER(4) PRIMARY KEY,
  DNAME VARCHAR2(200),
  DADDRESS VARCHAR2(100)
);

CREATE TABLE AUTHOR
(
  AID NUMBER(6) PRIMARY KEY,
  ANAME VARCHAR2(500)
);

CREATE TABLE BOOK
(
  BID NUMBER(6) PRIMARY KEY,
  BTITLE VARCHAR2(200),
  ISBN VARCHAR2(10) NOT NULL,
  ISBN13 NUMBER(13) NOT NULL,
  BGENRE VARCHAR2(21)
);

CREATE TABLE AUTHORSHIP
(
  IDAUTHOR NUMBER(6) NOT NULL REFERENCES AUTHOR,
  IDBOOK NUMBER(6) NOT NULL REFERENCES BOOK
);

CREATE TABLE BOOKINSTANCE
(
  BIID NUMBER(10) PRIMARY KEY,
  BOOK NUMBER(6) NOT NULL REFERENCES BOOK,
  DEPARTMENT NUMBER(4) NOT NULL REFERENCES DEPARTMENT
);

CREATE TABLE MEMBER
(
  MID NUMBER(6) PRIMARY KEY,
  MNAME VARCHAR2(100),
  BIRTH DATE
);

CREATE TABLE RATING
(
  RATE NUMBER(1) NOT NULL,
  RDATE DATE NOT NULL,
  IDRATER NUMBER(6) NOT NULL REFERENCES MEMBER,
  IDBOOK NUMBER(6) NOT NULL REFERENCES BOOK
);

CREATE TABLE BORROWING
(
  BORROW DATE NOT NULL,
  RETURN DATE NULL,
  IDLENDER NUMBER(6) NOT NULL REFERENCES MEMBER,
  IDBOOK NUMBER(10) NOT NULL REFERENCES BOOKINSTANCE
);
COMMIT;
