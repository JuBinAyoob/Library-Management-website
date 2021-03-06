-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2016 at 01:04 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `library`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `Accepted_Cancel`(IN `bkid` VARCHAR(15), IN `usid` VARCHAR(15), OUT `Fusr` VARCHAR(15))
BEGIN
	DECLARE cou,F,R,i INT;
    
	SET cou=0;
    SET i=1;
    WHILE (i<=5 and cou!=1) DO
    	SET @sql = CONCAT('UPDATE transaction SET Trans_No=Trans_No-1, bookrequest',i,'= "" WHERE ID ="',usid,'" and bookrequest',i,'="',bkid,'"');
        PREPARE stmt FROM @sql;
        EXECUTE stmt;
        SELECT ROW_COUNT() into cou;
        DEALLOCATE PREPARE stmt;
        SET i=i+1;
    END WHILE;
        
    IF (cou=1)THEN
    	DELETE FROM notification WHERE userid=usid and bookid=bkid and type='accepted';
        SELECT frontpoint,rearpoint INTO F,R FROM bookrequests WHERE mainid=bkid;
        IF (F!=-1)THEN
        	IF F=0 THEN
        		SELECT c0 INTO Fusr FROM bookrequests WHERE mainid =bkid;
            ELSEIF F=1 THEN
        		SELECT c1 INTO Fusr FROM bookrequests WHERE mainid =bkid;
            ELSEIF F=2 THEN
        		SELECT c2 INTO Fusr FROM bookrequests WHERE mainid =bkid;
            ELSEIF F=3 THEN
        		SELECT c3 INTO Fusr FROM bookrequests WHERE mainid =bkid;
            ELSEIF F=4 THEN
        		SELECT c4 INTO Fusr FROM bookrequests WHERE mainid =bkid;
            ELSEIF F=5 THEN
        		SELECT c5 INTO Fusr FROM bookrequests WHERE mainid =bkid;
           	ELSEIF F=6 THEN
        		SELECT c6 INTO Fusr FROM bookrequests WHERE mainid =bkid;
            ELSEIF F=7 THEN
        		SELECT c7 INTO Fusr FROM bookrequests WHERE mainid =bkid;
            ELSEIF F=8 THEN
        		SELECT c8 INTO Fusr FROM bookrequests WHERE mainid =bkid;
            ELSEIF F=9 THEN
        		SELECT c9 INTO Fusr FROM bookrequests WHERE mainid =bkid;
            ELSEIF F=10 THEN
        		SELECT c10 INTO Fusr FROM bookrequests WHERE mainid =bkid;
            ELSEIF F=11 THEN
        		SELECT c11 INTO Fusr FROM bookrequests WHERE mainid =bkid;
            ELSEIF F=12 THEN
        		SELECT c12 INTO Fusr FROM bookrequests WHERE mainid =bkid;
            ELSEIF F=13 THEN
        		SELECT c13 INTO Fusr FROM bookrequests WHERE mainid =bkid;
            ELSEIF F=14 THEN
        		SELECT c14 INTO Fusr FROM bookrequests WHERE mainid =bkid;
            ELSEIF F=15 THEN
        		SELECT c15 INTO Fusr FROM bookrequests WHERE mainid =bkid;
            END IF;
            
            INSERT INTO notification (userid,bookid,type) VALUES(Fusr,bkid,'accepted');
            UPDATE notification SET not_date=DATE_ADD(now(),INTERVAL 1 DAY) WHERE userid=Fusr and bookid=bkid and type='accepted';
            
            IF R=F THEN
            	SET @sql = CONCAT('UPDATE bookrequests SET c',F,'="",frontpoint=-1,rearpoint=-1 WHERE mainid ="',bkid,'"');
        		PREPARE stmt FROM @sql;
        		EXECUTE stmt;
        		DEALLOCATE PREPARE stmt;
            ELSE
            	SET @sql = CONCAT('UPDATE bookrequests SET c',F,'="",frontpoint=',((F+1)%16),' WHERE mainid ="',bkid,'"');
        		PREPARE stmt FROM @sql;
        		EXECUTE stmt;
        		DEALLOCATE PREPARE stmt;
            END IF;
        ELSE
        	SET @sql = CONCAT('UPDATE bookrequests SET available_books=available_books+1 WHERE mainid ="',bkid,'"');
        	PREPARE stmt FROM @sql;
        	EXECUTE stmt;
        	DEALLOCATE PREPARE stmt;
            
            SET Fusr='-1';
        END IF;
    ELSE
		SET Fusr='-1';    
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Book_Give`(IN `bkid` VARCHAR(15), IN `usid` VARCHAR(15), IN `subdate` DATE)
BEGIN
	DECLARE i,j,cou INT;
    SELECT COUNT( * )INTO cou FROM transaction WHERE bookathand1="" and ID=usid;
    IF cou=0 THEN
    	SELECT COUNT( * )INTO cou FROM transaction WHERE bookathand2="" and ID=usid;
        IF cou=0 THEN
    		SELECT COUNT( * )INTO cou FROM transaction WHERE bookathand3="" and ID=usid;
            IF cou=1 THEN
            	SET i=3;
            ELSE
            	SET i=4;
            END IF;
    	ELSE
    		SET i=2;
   		END IF;
    ELSE
    	SET i=1;
    END IF;
    
    IF i!=4 THEN
    	SET j=1;
        SET cou=0;
        WHILE (j<6 and cou!=1) DO
    		SET @sql = CONCAT('UPDATE transaction SET bookathand',i,'= "',bkid,'", bookrequest',j,'="" WHERE ID ="',usid,'" and bookrequest',j,'="',SUBSTRING(bkid,1,8),'"');
       		PREPARE stmt FROM @sql;
        	EXECUTE stmt;
        	SELECT ROW_COUNT() into cou;
        	DEALLOCATE PREPARE stmt;
        	SET j=j+1;
    	END WHILE;
        
        IF cou=1 THEN
        	UPDATE books SET currentuserid=usid,submissiondate=subdate,renewtimes=0 WHERE subid=bkid;
            DELETE FROM notification WHERE userid=usid and bookid=SUBSTRING(bkid,1,8) and type='accepted';
        END IF;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Book_Return`(IN `bkid` VARCHAR(15), IN `usid` VARCHAR(15))
BEGIN
	DECLARE i,cou,R,F,T,no_dates INT;
    DECLARE subdate DATE;
	SET i=1;
    
    SET cou=0;
    WHILE (i<=3 and cou!=1) DO
   
    	SET @sql = CONCAT('UPDATE transaction SET Trans_No=Trans_No-1, bookathand',i,'= "" WHERE ID ="',usid,'" and bookathand',i,'="',bkid,'"');
        PREPARE stmt FROM @sql;
        EXECUTE stmt;
        SELECT ROW_COUNT() into cou;
        DEALLOCATE PREPARE stmt;
        SET i=i+1;
    END WHILE;
    
    IF cou=1 THEN
    	SELECT submissiondate INTO subdate FROM books WHERE subid=bkid;
        
        SELECT DATEDIFF(now(),subdate) INTO no_dates;
        
        IF no_dates>0 THEN
        UPDATE staffandstudent SET Fine=Fine+no_dates WHERE ID=usid;
        INSERT INTO notification (userid,bookid,fine) VALUES(usid,bkid,no_dates);
        END IF;
        
        DELETE FROM notification WHERE userid=usid and bookid=bkid and type='submission';
    	UPDATE books SET currentuserid="",submissiondate="",renewtimes=0 WHERE subid=bkid;
        UPDATE bookrequests SET available_books=available_books+1 WHERE mainid= SUBSTRING(bkid,1,8);
    END IF;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Cancel_Request`(IN `bkid` VARCHAR(15), IN `usid` VARCHAR(15))
BEGIN
DECLARE f,r,i,cou,rear INT;
DECLARE c_0,c_1,c_2,c_3,c_4,c_5,c_6,c_7,c_8,c_9,c_10,c_11, c_12,c_13,c_14,c_15 VARCHAR(15); 
/*------------------bookrequests table----------------------*/
SELECT frontpoint,rearpoint,c0,c1,c2,c3,c4,c5,c6,c7,c8,c9,c10,c11, c12,c13,c14,c15 INTO f,r,c_0,c_1,c_2,c_3,c_4,c_5,c_6,c_7, c_8,c_9,c_10,c_11,c_12,c_13,c_14,c_15 FROM bookrequests WHERE mainid=bkid;

IF f=r THEN
	SET @sql = CONCAT('UPDATE bookrequests SET rearpoint=-1,frontpoint=-1,c',f,'=NULL WHERE mainid="',bkid,'" and C',f,'="',usid,'"');
	PREPARE stmt FROM @sql;
	EXECUTE stmt;
    SELECT ROW_COUNT() into cou ;
	DEALLOCATE PREPARE stmt;
    SELECT cou;
ELSE
  	SET @sql = CONCAT('UPDATE bookrequests SET frontpoint=',((f+1)%16),',c',f,'=NULL WHERE mainid="',bkid,'" and C',f,'="',usid,'"');
  	PREPARE stmt FROM @sql;
  	EXECUTE stmt;
  	SELECT ROW_COUNT() into cou ;
  	DEALLOCATE PREPARE stmt;
  	SELECT cou;
  
  
  	IF cou=0 THEN
  		IF (r-1)=-1 THEN
    		SET rear=15;
    	ELSE
    		SET rear=r-1;
    	END IF;
    
   		SET @sql = CONCAT('UPDATE bookrequests SET rearpoint=',rear,',c',r,'=NULL WHERE mainid="',bkid,'" and C',r,'="',usid,'"');
  		PREPARE stmt FROM @sql;
  		EXECUTE stmt;
 		SELECT ROW_COUNT() into cou ;
  		DEALLOCATE PREPARE stmt;
    	SELECT cou;
  	END IF;
  
  
 	IF cou=0 THEN
  		SET i=(f+1)%16;
  	
  		checki:  LOOP
    		IF(i=0 and c_0=usid)THEN
				LEAVE  checki;
        	ELSEIF(i=1 and c_1=usid)THEN
				LEAVE  checki;
        	ELSEIF(i=2 and c_2=usid)THEN
				LEAVE  checki;
        	ELSEIF(i=3 and c_3=usid)THEN
				LEAVE  checki;
     	   	ELSEIF(i=4 and c_4=usid)THEN
				LEAVE  checki;
       		ELSEIF(i=5 and c_5=usid)THEN
				LEAVE  checki;
        	ELSEIF(i=6 and c_6=usid)THEN
				LEAVE  checki;
			ELSEIF(i=7 and c_7=usid)THEN
				LEAVE  checki;
			ELSEIF(i=8 and c_8=usid)THEN
				LEAVE  checki;
     	  	ELSEIF(i=9 and c_9=usid)THEN
				LEAVE  checki;
        	ELSEIF(i=10 and c_10=usid)THEN
				LEAVE  checki;
      	  	ELSEIF(i=11 and c_11=usid)THEN
				LEAVE  checki;
        	ELSEIF(i=12 and c_12=usid)THEN
				LEAVE  checki;
        	ELSEIF(i=13 and c_13=usid)THEN
				LEAVE  checki;
       	 	ELSEIF(i=14 and c_14=usid)THEN
				LEAVE  checki;
        	ELSEIF(i=15 and c_15=usid)THEN
				LEAVE  checki;
        	ELSEIF(i=(r+1)%16)THEN
				LEAVE  checki;
        	END IF;
            
			SET  i=(i+1)%16;

		END LOOP;
    
    	IF i!=(r+1)%16 THEN
    		WHILE(i!=(r+1)%16)DO
  				IF(i=0)THEN
					UPDATE bookrequests SET c0=c_1 WHERE mainid=bkid;
        		ELSEIF(i=1)THEN
					UPDATE bookrequests SET c1=c_2 WHERE mainid=bkid;
       	 		ELSEIF(i=2)THEN
					UPDATE bookrequests SET c2=c_3 WHERE mainid=bkid;
        		ELSEIF(i=3)THEN
					UPDATE bookrequests SET c3=c_4 WHERE mainid=bkid;
        		ELSEIF(i=4)THEN
					UPDATE bookrequests SET c4=c_5 WHERE mainid=bkid;
       			ELSEIF(i=5)THEN
					UPDATE bookrequests SET c5=c_6 WHERE mainid=bkid;
        		ELSEIF(i=6)THEN
					UPDATE bookrequests SET c6=c_7 WHERE mainid=bkid;
				ELSEIF(i=7)THEN
					UPDATE bookrequests SET c7=c_8 WHERE mainid=bkid;
				ELSEIF(i=8)THEN
					UPDATE bookrequests SET c8=c_9 WHERE mainid=bkid;
        		ELSEIF(i=9)THEN
					UPDATE bookrequests SET c9=c_10 WHERE mainid=bkid;
        		ELSEIF(i=10)THEN
					UPDATE bookrequests SET c10=c_11 WHERE mainid=bkid;
        		ELSEIF(i=11)THEN
					UPDATE bookrequests SET c11=c_12 WHERE mainid=bkid;
        		ELSEIF(i=12)THEN
					UPDATE bookrequests SET c12=c_13 WHERE mainid=bkid;
        		ELSEIF(i=13)THEN
					UPDATE bookrequests SET c13=c_14 WHERE mainid=bkid;
        		ELSEIF(i=14)THEN
					UPDATE bookrequests SET c14=c_15 WHERE mainid=bkid;
        		ELSEIF(i=15)THEN
					UPDATE bookrequests SET c15=c_0 WHERE mainid=bkid;
        		END IF;  
            	SET i=(i+1)%16;
    		END WHILE;
    	END if;
 
  
  		IF (r-1)=-1 THEN
    		SET rear=15;
    	ELSE
    		SET rear=r-1;
    	END IF;
    
   		SET @sql = CONCAT('UPDATE bookrequests SET rearpoint=',rear,',c',r,'=NULL WHERE mainid="',bkid,'"');
  		PREPARE stmt FROM @sql;
  		EXECUTE stmt;
 		SELECT ROW_COUNT() into cou ;
  		DEALLOCATE PREPARE stmt;
    	SELECT cou;
  	END IF;
END IF;



IF cou=1 THEN
	SET i=1;
    WHILE i<=5 DO
    
    	SET @sql = CONCAT('UPDATE transaction SET Trans_No=Trans_No-1, bookrequest',i,'="" WHERE ID="',usid,'" and bookrequest',i,'="',bkid,'"');
  		PREPARE stmt FROM @sql;
  		EXECUTE stmt;
  		DEALLOCATE PREPARE stmt;
    	SET i=i+1;
	END WHILE;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Check_Transaction`(IN `bkid` VARCHAR(15), IN `usid` VARCHAR(15), OUT `flag` TINYINT)
BEGIN
	DECLARE cou int;
	SET flag=0;
	SELECT count(*) into cou FROM transaction WHERE ((bookathand1  LIKE CONCAT('%',bkid,'%') or bookathand2  LIKE CONCAT('%',bkid,'%') or bookathand3  LIKE CONCAT('%',bkid,'%')) and ID=usid);
	IF cou!=0 THEN
		SET flag=1;
	ELSEIF cou=0 THEN
		SELECT count(*) into cou FROM transaction WHERE ((bookrequest1 =bkid or bookrequest2=bkid or bookrequest3=bkid or bookrequest4=bkid or bookrequest5=bkid) and ID=usid);
		IF cou!=0 THEN
        	SELECT count(*) into cou FROM notification WHERE bookid=bkid and userid=usid;
            IF cou=1 THEN
            	SET flag=4;
            ELSE
				SET flag=2;
            END IF;
        ELSEIF cou=0 THEN
			SELECT count(*) into cou FROM transaction WHERE bookathand1!="" and bookathand2!="" and bookathand3!="" and ID=usid;
        	IF cou=1 THEN
				SET flag=3;
            ELSE
            	SELECT Trans_No into cou FROM transaction WHERE ID=usid;
                IF cou>=5 THEN
					SET flag=3;
                END IF;
			END IF;
        END IF;
	END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Message_Delete`(IN `from1` VARCHAR(15), IN `subject1` VARCHAR(30))
    NO SQL
BEGIN
DELETE FROM messages WHERE (frm=from1 or too=from1) and subject=subject1 and status=0;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Message_Send`(IN `from1` VARCHAR(15), IN `fromdet` VARCHAR(60), IN `to1` VARCHAR(15), IN `subject1` VARCHAR(50), IN `message1` VARCHAR(150), IN `stat` TINYINT)
    NO SQL
BEGIN
	IF (stat=1) THEN
		INSERT INTO messages (frm,frm_details,too,subject,message,status_admin) VALUES(from1,fromdet,to1,subject1,message1,1);
	ELSE
		INSERT INTO messages (frm,frm_details,too,subject,message,status_user) VALUES(from1,fromdet,to1,subject1,message1,1);
	END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Renew_Book`(IN `bkid` VARCHAR(15), IN `usid` VARCHAR(15))
BEGIN
	DECLARE subdate,renewdate DATE;
    
	SELECT submissiondate INTO subdate FROM books WHERE subid=bkid;
    
	SELECT DATE_ADD(subdate,INTERVAL 7 DAY) INTO renewdate;
    
    UPDATE books SET submissiondate=renewdate,renewtimes=renewtimes+1 WHERE subid=bkid;
    
    DELETE FROM notification WHERE userid=usid and bookid=bkid and type='renew';

	INSERT INTO notification (userid,bookid,type) VALUES('admin',bkid,usid);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Req_Book`(IN `bkid` VARCHAR(15), IN `usid` VARCHAR(15))
BEGIN
	DECLARE i,cou,R,F,T INT;
	SET i=1;
    
    SELECT rearpoint,frontpoint INTO R,F FROM bookrequests WHERE mainid=bkid;
    SET T=(R+1)%16;
    IF (R=-1)THEN
    	UPDATE bookrequests SET rearpoint=0, frontpoint=0, c0=usid WHERE mainid=bkid;
        SELECT ROW_COUNT() into cou ;
    ELSEIF (T!=F) THEN
       	SET @sql = CONCAT('UPDATE bookrequests SET rearpoint=',T,', c',T,'="',usid,'" WHERE mainid="',bkid,'"');
        PREPARE stmt FROM @sql;
  		EXECUTE stmt;
  		SELECT ROW_COUNT() into cou ;
  		DEALLOCATE PREPARE stmt;
    END IF;
    
    IF (cou=1)THEN
    	SET cou=0;
    	WHILE (i<=5 and cou!=1) DO
   
    		SET @sql = CONCAT('UPDATE transaction SET Trans_No=Trans_No+1, bookrequest',i,'= "',bkid,'" WHERE ID ="',usid,'" and bookrequest',i,'=""');
        	PREPARE stmt FROM @sql;
        	EXECUTE stmt;
        	SELECT ROW_COUNT() into cou;
        	DEALLOCATE PREPARE stmt;
        	SET i=i+1;
    	END WHILE;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Show_Request`()
BEGIN
DECLARE i INT;
SET i = 0;
SET @sql = CONCAT('SELECT mainid,c',i, ' FROM bookrequests where c',i,'="SCS13218"');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SELECT ((0-1) % 16),((3+1) % 16),((15+1) % 16),((14+1) % 16);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Test_Show`()
BEGIN
SELECT DATEDIFF(now(),'2016-04-01');
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `bookrequests`
--

CREATE TABLE IF NOT EXISTS `bookrequests` (
  `mainid` varchar(10) NOT NULL,
  `total_books` int(11) NOT NULL DEFAULT '1',
  `available_books` int(11) NOT NULL DEFAULT '1',
  `frontpoint` tinyint(4) NOT NULL DEFAULT '-1',
  `rearpoint` tinyint(4) NOT NULL DEFAULT '-1',
  `c0` varchar(10) NOT NULL,
  `c1` varchar(10) NOT NULL,
  `c2` varchar(10) NOT NULL,
  `c3` varchar(10) NOT NULL,
  `c4` varchar(10) NOT NULL,
  `c5` varchar(10) NOT NULL,
  `c6` varchar(10) NOT NULL,
  `c7` varchar(10) NOT NULL,
  `c8` varchar(10) NOT NULL,
  `c9` varchar(10) NOT NULL,
  `c10` varchar(10) NOT NULL,
  `c11` varchar(10) NOT NULL,
  `c12` varchar(10) NOT NULL,
  `c13` varchar(10) NOT NULL,
  `c14` varchar(10) NOT NULL,
  `c15` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bookrequests`
--

INSERT INTO `bookrequests` (`mainid`, `total_books`, `available_books`, `frontpoint`, `rearpoint`, `c0`, `c1`, `c2`, `c3`, `c4`, `c5`, `c6`, `c7`, `c8`, `c9`, `c10`, `c11`, `c12`, `c13`, `c14`, `c15`) VALUES
('CSES6101', 2, 2, -1, -1, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('CSES6102', 1, 1, -1, -1, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('CSES6103', 1, 1, -1, -1, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('CSES6121', 2, 2, -1, -1, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('CSES6122', 1, 1, -1, -1, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('CSES6123', 1, 1, -1, -1, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('CSES6125', 1, 1, -1, -1, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
('CSES6129', 1, 1, -1, -1, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE IF NOT EXISTS `books` (
  `subid` varchar(12) NOT NULL,
  `mainid` varchar(10) NOT NULL,
  `name` varchar(65) NOT NULL,
  `author` varchar(65) NOT NULL,
  `publication` varchar(30) NOT NULL,
  `edition` varchar(10) NOT NULL,
  `price` smallint(5) unsigned NOT NULL,
  `department` varchar(15) NOT NULL,
  `sem` varchar(5) NOT NULL,
  `subject` varchar(65) NOT NULL,
  `currentuserid` varchar(10) NOT NULL,
  `submissiondate` date NOT NULL,
  `renewtimes` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`subid`, `mainid`, `name`, `author`, `publication`, `edition`, `price`, `department`, `sem`, `subject`, `currentuserid`, `submissiondate`, `renewtimes`) VALUES
('CSES610101', 'CSES6101', 'fundamentals of database systems', 'ramez elmasri,shamkant b. Navathe', 'pearson', '4th', 350, 'CSE', 'S6', 'database management systems', '', '0000-00-00', 0),
('CSES610102', 'CSES6101', 'fundamentals of database systems', 'ramez elmasri,shamkant b. Navathe', 'pearson', '4th', 400, 'CSE', 'S6', 'database management systems', '', '0000-00-00', 0),
('CSES610201', 'CSES6102', 'compilers: principles, techniques and tools', 'aho a v, sethi r, ullman j d', 'addison wesley', '', 500, 'CSE', 'S6', 'compiler design', '', '0000-00-00', 0),
('CSES610301', 'CSES6103', 'Computer Graphics', 'Hearn D, Baker P M', 'Prentice Hall India', '', 350, 'CSE', 'S6', 'Computer Graphics', '', '0000-00-00', 0),
('CSES612101', 'CSES6121', 'computer networks a systems approach', 'larry l peterson, bruce s davie', 'morgan kaufmann', '4', 250, 'CSE', 'S6', 'computer networks', '', '0000-00-00', 0),
('CSES612102', 'CSES6121', 'computer networks a systems approach', 'larry l peterson, bruce s davie', '', '', 250, 'CSE', 'S6', '', '', '0000-00-00', 0),
('CSES612201', 'CSES6122', 'embedded system design: a unified hardware/software introduction', 'frank vahid, tony givargis', 'wiley', '2002', 199, 'CSE', 'S6', 'embedded systems', '', '0000-00-00', 0),
('CSES612301', 'CSES6123', 'Operating Systems - A Modern Perspective', 'Nutt G J', 'Addison Wesley', '', 500, 'CSE', 'S6', 'Systems Lab(practical)', '', '0000-00-00', 0),
('CSES612501', 'CSES6125', 'Digital Image Processing', 'R C Gonzalez, R E Woods', 'Prentice Hall of India, New De', '2nd', 530, 'CSE', 'S7', 'Digital Image Processing', '', '0000-00-00', 0),
('CSES612901', 'CSES6129', 'Introduction to Neural Networks using Matlab', 'S N Shivanandam, S Sumati, S N Deepa', 'Tata McGraw Hill', '', 600, 'CSE', 'S7', 'Artificial Neural Networks', '', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
`sno` int(11) NOT NULL,
  `frm` varchar(15) NOT NULL,
  `frm_details` varchar(60) NOT NULL,
  `too` varchar(15) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `message` varchar(150) NOT NULL,
  `status_admin` tinyint(4) NOT NULL,
  `status_user` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE IF NOT EXISTS `notification` (
`Sno` int(10) unsigned NOT NULL,
  `userid` varchar(10) NOT NULL,
  `bookid` varchar(12) NOT NULL,
  `fine` smallint(5) unsigned NOT NULL,
  `not_date` date NOT NULL,
  `type` varchar(10) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Triggers `notification`
--
DELIMITER //
CREATE TRIGGER `not_date_created` BEFORE INSERT ON `notification`
 FOR EACH ROW set new.`not_date` = now()
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `staffandstudent`
--

CREATE TABLE IF NOT EXISTS `staffandstudent` (
  `ID` varchar(10) NOT NULL,
  `username` varchar(30) NOT NULL,
  `Fine` smallint(5) unsigned NOT NULL DEFAULT '0',
  `department` varchar(15) NOT NULL,
  `sem` varchar(5) NOT NULL,
  `admissiondate` date DEFAULT NULL,
  `universityno` varchar(15) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `mobno` bigint(12) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staffandstudent`
--

INSERT INTO `staffandstudent` (`ID`, `username`, `Fine`, `department`, `sem`, `admissiondate`, `universityno`, `email`, `mobno`) VALUES
('SCS12028', 'Gadeyan', 0, 'CSE', '', '2013-07-22', '', '', 0),
('SCS12030', 'Sanoop', 0, 'CSE', '', '2013-07-22', '', '', 0),
('SCS13030', 'Shaqir', 10, 'CSE', 'S6', '2013-07-22', 'SYANECS030', 'saqir@gmail.com', 9645755595),
('SCS13031', 'Nikhil S Varrier', 0, 'CSE', 'S6', '2013-07-22', 'SYANECS031', 'nikhilvarier@gmail.com', 8547309751),
('SCS13044', 'Sreejith', 0, 'CSE', '', '2013-07-22', 'SYANECS044', 'sreeju220@gmail.com', 9567182972),
('SCS13218', 'Jubin Ayoob', 52, 'CSE', 'S6', '2013-07-22', 'SYANECS028', 'jubinayoob369@gmail.com', 8129062800),
('SCS14001', 'Vinay Prakash', 2, 'CSE', 'S3', '2014-06-22', NULL, NULL, 8281834185),
('TCS10303', 'Ashmy Antony', 0, 'CSE', '', NULL, NULL, 'ashmyantony@simat.ac.in', 9496334275),
('TCS10309', 'Aparna', 0, 'CSE', '', '2010-07-22', '', '', 0),
('TCS10312', 'Jayanthan Ks', 36, 'CSE', '', NULL, NULL, 'jayanthan.ks@simat.ac.in', 9947970101);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE IF NOT EXISTS `transaction` (
  `ID` varchar(10) NOT NULL,
  `Trans_No` tinyint(4) NOT NULL DEFAULT '0',
  `bookathand1` varchar(10) NOT NULL,
  `bookathand2` varchar(10) NOT NULL,
  `bookathand3` varchar(10) NOT NULL,
  `bookrequest1` varchar(10) NOT NULL,
  `bookrequest2` varchar(10) NOT NULL,
  `bookrequest3` varchar(10) NOT NULL,
  `bookrequest4` varchar(10) NOT NULL,
  `bookrequest5` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`ID`, `Trans_No`, `bookathand1`, `bookathand2`, `bookathand3`, `bookrequest1`, `bookrequest2`, `bookrequest3`, `bookrequest4`, `bookrequest5`) VALUES
('SCS12028', 0, '', '', '', '', '', '', '', ''),
('SCS12030', 0, '', '', '', '', '', '', '', ''),
('SCS13030', 0, '', '', '', '', '', '', '', ''),
('SCS13031', 0, '', '', '', '', '', '', '', ''),
('SCS13044', 0, '', '', '', '', '', '', '', ''),
('SCS13218', 0, '', '', '', '', '', '', '', ''),
('SCS14001', 0, '', '', '', '', '', '', '', ''),
('TCS10303', 0, '', '', '', '', '', '', '', ''),
('TCS10309', 0, '', '', '', '', '', '', '', ''),
('TCS10312', 0, '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `ID` varchar(10) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `username`, `password`) VALUES
('ADM13333', 'Yadu P Dev', '147'),
('SCS12028', 'Gadeyan', 'SCS12028'),
('SCS12030', 'Sanoop', 'SCS12030'),
('SCS13030', 'Shaqir', '11111'),
('SCS13031', 'Nikhil S Varrier', 'SCS13031'),
('SCS13044', 'Sreejith', 'SCS13044'),
('SCS13218', 'Jubin Ayoob', '123456'),
('SCS14001', 'Vinay Prakash', 'SCS14001'),
('TCS10303', 'Ashmy Antony', '321'),
('TCS10309', 'Aparna', 'TCS10309'),
('TCS10312', 'Jayanthan Ks', 'TCS10312');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookrequests`
--
ALTER TABLE `bookrequests`
 ADD PRIMARY KEY (`mainid`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
 ADD PRIMARY KEY (`subid`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
 ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
 ADD PRIMARY KEY (`Sno`);

--
-- Indexes for table `staffandstudent`
--
ALTER TABLE `staffandstudent`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`ID`), ADD KEY `ID` (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
MODIFY `Sno` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `staffandstudent` (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
