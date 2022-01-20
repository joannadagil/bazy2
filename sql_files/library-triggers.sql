DROP SEQUENCE did_seq;
DROP SEQUENCE aid_seq;
DROP SEQUENCE mid_seq;
DROP SEQUENCE bid_seq;
DROP SEQUENCE biid_seq;

--departament

CREATE SEQUENCE did_seq
START WITH 1
INCREMENT BY 1;

CREATE OR REPLACE TRIGGER did_trigger
BEFORE INSERT ON department
FOR EACH ROW
BEGIN
    SELECT did_seq.nextval INTO :NEW.did FROM dual;
END;
/

CREATE OR REPLACE TRIGGER d_delete_trigger
BEFORE DELETE ON department
FOR EACH ROW
DECLARE
book_no NUMBER;
BEGIN
    book_no := 0;
    SELECT COUNT(1) INTO book_no FROM bookinstance WHERE bookinstance.department = :OLD.did;
    IF (book_no > 0) THEN
      raise_application_error(-20000, book_no || ' books in this department. First move or delete the book');
    END IF;
END;
/

--author

CREATE SEQUENCE aid_seq
START WITH 1
INCREMENT BY 1;

CREATE OR REPLACE TRIGGER aid_trigger
BEFORE INSERT ON author
FOR EACH ROW
BEGIN
    SELECT aid_seq.nextval INTO :NEW.aid FROM dual;
END;
/

CREATE OR REPLACE TRIGGER a_delete_trigger
BEFORE DELETE ON author
FOR EACH ROW
DECLARE
book_no NUMBER;
BEGIN
    book_no := 0;
    SELECT COUNT(1) INTO book_no FROM authorship WHERE authorship.idauthor = :OLD.aid;
    IF (book_no > 0) THEN
      raise_application_error(-20000, book_no || ' books authored by this author. First delete the authorship');
    END IF;
END;
/

--book

CREATE SEQUENCE bid_seq
START WITH 1
INCREMENT BY 1;

CREATE OR REPLACE TRIGGER bid_trigger
BEFORE INSERT ON book
FOR EACH ROW
BEGIN
    SELECT bid_seq.nextval INTO :NEW.bid FROM dual;
END;
/

CREATE OR REPLACE TRIGGER b_delete_trigger
BEFORE DELETE ON book
FOR EACH ROW
DECLARE
acount NUMBER;
bcount NUMBER;
ccount NUMBER;
BEGIN
    acount := 0;
    SELECT COUNT(1) INTO acount FROM bookinstance WHERE bookinstance.book = :OLD.bid;
    IF (acount > 0) THEN
      raise_application_error(-20000, acount || ' instances of this book. First delete the instance');
    END IF;
    bcount := 0;
    SELECT COUNT(1) INTO bcount FROM authorship WHERE authorship.idbook = :OLD.bid;
    IF (bcount > 0) THEN
      raise_application_error(-20000, bcount || ' authorships of this book. First delete the authorship');
    END IF;
    ccount := 0;
    SELECT COUNT(1) INTO ccount FROM rating WHERE rating.idbook = :OLD.bid;
    IF (ccount > 0) THEN
      raise_application_error(-20000, ccount || ' ratings of this book. First delete the rating');
    END IF;
END;
/

--authorship

--bookinstance

CREATE SEQUENCE biid_seq
START WITH 1
INCREMENT BY 1;

CREATE OR REPLACE TRIGGER biid_trigger
BEFORE INSERT ON bookinstance
FOR EACH ROW
BEGIN
    SELECT biid_seq.nextval INTO :NEW.biid FROM dual;
END;
/

CREATE OR REPLACE TRIGGER bi_delete_trigger
BEFORE DELETE ON bookinstance
FOR EACH ROW
DECLARE
borrowing_no NUMBER;
BEGIN
    borrowing_no := 0;
    SELECT COUNT(1) INTO borrowing_no FROM borrowing WHERE borrowing.idbook = :OLD.biid;
    IF (borrowing_no > 0) THEN
      raise_application_error(-20000, borrowing_no || ' borrowings of this book instance. First delete the borrowing');
    END IF;
END;
/

--member

CREATE SEQUENCE mid_seq
START WITH 1
INCREMENT BY 1;

CREATE OR REPLACE TRIGGER mid_trigger
BEFORE INSERT ON member
FOR EACH ROW
BEGIN
    SELECT mid_seq.nextval INTO :NEW.mid FROM dual;
END;
/

CREATE OR REPLACE TRIGGER m_delete_trigger
BEFORE DELETE ON member
FOR EACH ROW
DECLARE
borrowing_no NUMBER;
BEGIN
    borrowing_no := 0;
    SELECT COUNT(1) INTO borrowing_no FROM borrowing WHERE borrowing.idlender = :OLD.mid;
    IF (borrowing_no > 0) THEN
      raise_application_error(-20000, borrowing_no || ' borrowings by this member. First delete the borrowing');
    END IF;
END;
/

--rating

--borrowing

CREATE OR REPLACE TRIGGER check_borrowing 
BEFORE INSERT OR UPDATE ON borrowing
FOR EACH ROW
BEGIN
    IF :NEW.borrow IS NOT NULL AND :NEW.return IS NOT NULL THEN
      IF :NEW.borrow > :NEW.return THEN
        raise_application_error(-20000,'Return date must be latter then borrow date');
      END IF;
    END IF;
END;
/
COMMIT;

