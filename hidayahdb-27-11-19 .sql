-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2019 at 06:41 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hidayahdb`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `cityShortcuts` (IN `city_id` INT, IN `city` VARCHAR(150), IN `district` VARCHAR(150), IN `state` VARCHAR(100), IN `pincode` INT, IN `param` VARCHAR(50))  BEGIN
DECLARE ckeck VARCHAR(100);
DECLARE checks VARCHAR(100);

IF city IS NULL THEN
	SET ckeck = '';
ELSE
	SELECT city_name INTO checks from tbl_city WHERE id = city_id;
	IF param = 'insert' AND checks <=> NULL THEN
    	SELECT state_name INTO checks from tbl_state WHERE state_name = state;
		IF checks <=> NULL THEN
            INSERT INTO tbl_state 
			(`state_name`,
 			`created_at`) 	
        	VALUES(state,
            	SYSDATE());
         END IF;  
       	SELECT LAST_INSERT_ID() INTO ckeck;
	
    	SELECT dist_name INTO checks from tbl_district WHERE dist_name = district;
		IF checks <=> NULL THEN
       		INSERT INTO tbl_district 
                (`state_id`,
                `dist_name`,
                `created_at`) 	
                VALUES(ckeck,
                district,
                SYSDATE());
        END IF;    
        call last_dist_id(district, @out_value);
		select @out_value;
       
        INSERT INTO tbl_city 
		(`dist_id`,
         `city_name`,
 		`created_at`) 	
        VALUES(@out_value,
            city,
            SYSDATE());
            
        SELECT LAST_INSERT_ID() INTO ckeck;
        
        INSERT INTO tbl_pincode 
		(`city_id`,
         `pincode`,
 		`created_at`) 	
        VALUES(ckeck,
            pincode,
            SYSDATE());
 	END IF;
 END IF;
 SELECT ckeck;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `countDependents` (IN `hfid` VARCHAR(50), IN `type` VARCHAR(50), IN `s` INT, IN `param` VARCHAR(50))  NO SQL
BEGIN
 IF param = 'dep' THEN
	SELECT COUNT(p.id) as counts from tbl_families_personals p
 	WHERE p.hfid =  hfid AND p.fam_category = type AND p.status = s;
 ELSEIF param = 'stud' THEN
 	SELECT COUNT(p.id) as counts from tbl_families_personals p
    LEFT JOIN tbl_familiesfuture_infos f ON p.id = f.person_id
 	WHERE p.hfid =  hfid AND p.fam_category = type AND p.status = s
    AND f.occupation_name = 'Student';
 ELSEIF param = 'emp' THEN
	SELECT COUNT(p.id) as counts from tbl_families_personals p
    INNER JOIN tbl_familiesfuture_infos f ON p.id = f.person_id
 	WHERE p.hfid =  hfid AND p.fam_category = type AND p.status = s
    AND f.occupation_name = 'Employee';
 ELSEIF param = 'drop' THEN
	SELECT COUNT(p.id) as counts from tbl_families_personals p
    INNER JOIN tbl_general_educations g ON p.id = g.student_id
 	WHERE p.hfid =  hfid AND p.fam_category = type AND p.status = s
    AND g.present_status = 'Dropout';
 ELSE
 	SELECT COUNT(p.id) as counts from tbl_families_personals p
 	WHERE p.hfid =  hfid AND p.fam_category = type AND p.status = s
    AND p.gender = param;
 END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `families_edit` (IN `id` VARCHAR(50), IN `statuses` INT, IN `type` VARCHAR(100))  SQL SECURITY INVOKER
BEGIN
	SELECT tfp.*,tfg.qualification,tfg.year  FROM tbl_families_personals tfp 
    LEFT JOIN  (SELECT * FROM tbl_general_educations WHERE `year` IN 
    (SELECT max(year) FROM tbl_general_educations)) tfg ON tfg.student_id = tfp.id
    WHERE tfp.id = id AND tfp.fam_category = type AND tfp.status = statuses;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fam_details` (IN `hfid` VARCHAR(50), IN `status` INT, IN `type` VARCHAR(100), IN `field` VARCHAR(100))  BEGIN
 SELECT tfp.*,
tfh.present_door,tfh.income,tfh.income_source,tfh.ration_no,tfh.familial_relation,tfh.shelter,tfh.self_reliant,tfh.health_status,tfh.reason,
tff.occupation_name,tff.hobbies,tff.goal, tfg.id as stdid,tfg.qualification,tfg.course_name,tfg.standard_grade,tfg.stage,tfg.strength,tfg.weakness,tfg.present_status,tfg.performance,tfg.year,
tfb.id as service_id,
tfi.id as inst_id,tfi.institution_name,tfi.location,tfi.sector,tfi.institution_category,tfi.street as inst_street,tfi.community_type,tfi.city as inst_city,tfi.district as inst_district,tfi.state as inst_state,tfi.pin_code, tfr.description as feedback,tfa.door_no,tfa.street_area,tfa.belongs_to,tfa.city,tfa.state,tfa.district,tfa.nation,tfa.pincode FROM tbl_families_personals tfp 
  LEFT JOIN tbl_history_status tfh ON tfp.id = tfh.fam_id 
  LEFT JOIN tbl_families_address tfa ON tfa.person_id = tfp.id 
  LEFT JOIN tbl_familiesfuture_infos tff ON tff.person_id = tfp.id
  LEFT JOIN tbl_general_educations tfg ON tfg.student_id = tfp.id
  LEFT JOIN tbl_project_beneficiaries tfb ON tfb.person_id = tfp.id
  LEFT JOIN tbl_institutions_infos tfi ON tfi.id = tfg.college_id
  LEFT JOIN tbl_feedback_remarks tfr ON tfr.id = tfp.id
  WHERE (CASE WHEN field = 'hfid' THEN tfp.hfid = hfid ELSE tfp.id = hfid END) AND tfp.fam_category = type AND tfp.status = status GROUP BY tfp.id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `future_info` (IN `person_id` INT, IN `occupation_name` VARCHAR(150), IN `hobbies` LONGTEXT, IN `goal` VARCHAR(250), IN `fam_category` VARCHAR(100), IN `hfid_link` VARCHAR(100), IN `param` VARCHAR(50))  BEGIN
DECLARE ckeck VARCHAR(100);
IF hobbies IS NULL AND occupation_name IS NULL THEN
	SET ckeck = '';
ELSE
	IF param = 'insert' THEN
		INSERT INTO tbl_familiesfuture_infos 
		(`person_id`,
 		`occupation_name`,
 		`hobbies`,
 		`goal`,
 		`fam_category`,
 		`hfid_link`,
 		`created_at`) 	
        VALUES(person_id,
            occupation_name,
           	hobbies,
            goal,
            fam_category,
            hfid_link,
            SYSDATE());
          
          SET ckeck = param;
 	ELSE 
          UPDATE tbl_familiesfuture_infos tf 
            SET `occupation_name` = occupation_name, 
            `hobbies` = hobbies, 
            `goal` = goal,
            `fam_category` = fam_category, 
            `hfid_link` = hfid_link,
            `updated_at` = SYSDATE()
            WHERE tf.person_id = person_id AND tf.hfid_link = hfid_link;
            
            SET ckeck = param;
 	END IF;
 END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `general_education_info` (IN `stdid` INT, IN `cid` INT, IN `course` VARCHAR(150), IN `grade` VARCHAR(150), IN `qualification` VARCHAR(100), IN `stage` VARCHAR(100), IN `strength` LONGTEXT, IN `weakness` LONGTEXT, IN `education_status` VARCHAR(100), IN `performance` VARCHAR(100), IN `edu_year` YEAR, IN `fam_category` VARCHAR(100), IN `hfid_link` VARCHAR(100), IN `param` VARCHAR(50))  NO SQL
BEGIN
DECLARE ckeck VARCHAR(100);
IF qualification IS NULL AND grade IS NULL THEN
	SET ckeck = '';
ELSE
	IF param = 'insert' THEN
		INSERT INTO tbl_general_educations 
		(`student_id`,
 		`college_id`,
 		`course_name`,
 		`standard_grade`,
 		`qualification`,
 		`stage`,
		`strength`,
 		`weakness`,
 		`present_status`,
 		`performance`,
         `year`,
        `fam_category`,
        `hfid_link`,
 		`created_at`) 	
        VALUES(stdid,
            cid,
            course,
           	grade,
            qualification,
            stage,
            strength,
            weakness,
            education_status,
            performance,
            edu_year,
            fam_category,
            hfid_link,
            SYSDATE());
 	ELSE 
 		UPDATE tbl_general_educations tg
    	SET `college_id` = cid,
    	`course_name` = course, 
    	`standard_grade` = grade,
  		`qualification` = qualification, 
  		`stage` = stage,
    	`strength` = strength,
    	`weakness` = weakness,
    	`present_status` = education_status,
    	`performance` = performance,
    	`year` = edu_year,
    	`updated_at` = SYSDATE()
    	WHERE tg.student_id = stdid AND tg.fam_category = fam_category or tg.year = edu_year;
 	END IF;
 END IF;
 SELECT ckeck;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllServiceConcerns` (IN `hfid` VARCHAR(50), IN `type` VARCHAR(50), IN `serv` VARCHAR(50))  NO SQL
BEGIN
	SELECT tfp.fname,tfp.lname,tfb.id as service_id,
    tfb.service_type,tfb.project_type,tfb.description,tfb.created_at
    FROM tbl_families_personals tfp 
    LEFT JOIN tbl_service_conserns tfb ON tfb.person_id = tfp.id
    WHERE tfp.hfid = hfid 
    AND tfp.fam_category = type
    AND tfb.service_type = serv
    ORDER BY tfb.created_at DESC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getFamiliesAllCounts` (IN `hfid` VARCHAR(50), IN `type` VARCHAR(50), IN `statuses` INT)  NO SQL
BEGIN
	SELECT
    COUNT(CASE WHEN p.gender = 'Male' THEN p.id END) AS males,
    COUNT(CASE WHEN p.gender = 'Female' THEN p.id END) AS females,
    COUNT(CASE WHEN f.occupation_name = 'Student' THEN f.id END) AS students,
    COUNT(CASE WHEN f.occupation_name = 'Employee' THEN f.id END) AS employees,
    COUNT(*) AS Total
    FROM tbl_families_personals p 
    INNER JOIN tbl_familiesfuture_infos f ON p.id = f.person_id
    WHERE p.fam_category = type AND p.hfid = hfid AND p.status = statuses;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getServiceConcerns` (IN `id` INT, IN `hfid` VARCHAR(100), IN `status` INT)  NO SQL
BEGIN
	SELECT ts.hfid_link,ts.person_id,ts.description,ts.project_type,ts.service_type FROM tbl_service_conserns ts WHERE ts.person_id = id AND ts.hfid_link = hfid AND ts.status = status;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getServicesAndConserns` (IN `hfid` VARCHAR(50), IN `type` VARCHAR(50), IN `project` VARCHAR(100), IN `statuses` INT)  NO SQL
BEGIN
	SELECT tfp.fname,tfp.lname,tfb.id as service_id,
    tfb.service_type,tfb.project_type,tfb.description
    FROM tbl_families_personals tfp 
    LEFT JOIN tbl_service_conserns tfb ON tfb.person_id = tfp.id
    WHERE tfp.hfid = hfid 
    AND tfp.fam_category = type 
    AND tfp.status = statuses
    AND tfb.project_type = LOWER(project) 
    AND tfb.status = statuses;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `head_history_info` (IN `fam_id` INT, IN `present_door` VARCHAR(50), IN `ration_no` VARCHAR(100), IN `ration_image` VARCHAR(250), IN `familial` VARCHAR(100), IN `income` INT, IN `income_source` VARCHAR(100), IN `HealthStatus` VARCHAR(100), IN `Shelter` VARCHAR(100), IN `SelfReliant` VARCHAR(100), IN `type` VARCHAR(100), IN `hfid` VARCHAR(100), IN `actions` VARCHAR(50), IN `reason` LONGTEXT)  BEGIN
DECLARE ckeck VARCHAR(100);
DECLARE checks VARCHAR(100);
IF present_door IS NULL THEN
	SET ckeck = '';
ELSE
	IF actions = 'insert' THEN
		INSERT INTO tbl_history_status 
		(`fam_id`,
 		`present_door`,
         `reason`,
 		`ration_no`,
 		`ration_image`,
 		`familial_relation`,
 		`income`,
		`income_source`,
 		`health_status`,
 		`shelter`,
 		`self_reliant`,
        `fam_category`,
        `hfid_link`,
 		`created_at`) 	
        VALUES(fam_id,
            present_door,
            reason,
            ration_no,
           	ration_image,
            familial,
            income,
            income_source,
            HealthStatus,
            Shelter,
            SelfReliant,
            type,
            hfid,
            SYSDATE());
 	ELSE 
          UPDATE tbl_history_status th
            SET `present_door` = present_door, 
            `reason` = reason,
            `ration_no` = ration_no, 
            `ration_image` = ration_image,
            `familial_relation` = familial, 
            `income` = income,
            `income_source` = income_source,
            `health_status` = HealthStatus,
            `shelter` = Shelter,
            `self_reliant` = SelfReliant,
            `fam_category` = type,
            `hfid_link` = hfid,
            `updated_at` = SYSDATE()
            WHERE th.fam_id = fam_id AND th.hfid_link = hfid;
        
 	END IF;
 END IF;
 SELECT ckeck;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `institution_info` (IN `id` VARCHAR(100), IN `name` VARCHAR(200), IN `location` VARCHAR(100), IN `sector` VARCHAR(100), IN `inst_type` VARCHAR(100), IN `community` VARCHAR(100), IN `street` VARCHAR(100), IN `city` VARCHAR(100), IN `district` VARCHAR(100), IN `state` VARCHAR(100), IN `pincode` INT)  NO SQL
BEGIN
DECLARE ckeck VARCHAR(100);
DECLARE checks VARCHAR(100);
IF name IS NULL THEN
	SET ckeck = '';
ELSE
	SELECT institution_check(id,location) INTO checks;
	IF checks IS NULL OR checks <= 0 THEN
		INSERT INTO tbl_institutions_infos 
		(`institution_name`,
 		`location`,
 		`sector`,
 		`institution_category`,
 		`community_type`,
 		`street`,
		`city`,
 		`district`,
 		`state`,
 		`pin_code`,
 		`created_at`) 	
        VALUES(name,
            location,
            sector,
           	inst_type,
            community,
            street,
            city,
            district,
            state,
            pincode,
            SYSDATE());
            
   		SELECT LAST_INSERT_ID() INTO ckeck;
 	ELSE 
 		UPDATE tbl_institutions_infos ti
    	SET `institution_name` = name, 
    	`location` = location, 
    	`sector` = sector,
  		`institution_category` = inst_type, 
  		`community_type` = community,
    	`street` = street,
    	`city` = city,
    	`district` = district,
    	`state` = state,
    	`pin_code` = pincode,
    	`updated_at` = SYSDATE()
    	WHERE ti.institution_name = name AND ti.location = location;
        
        SET ckeck = id;
 	END IF;
 END IF;
 SELECT ckeck;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `last_dist_id` (IN `name` VARCHAR(200), OUT `param` INT)  NO SQL
BEGIN
	DECLARE lid VARCHAR(100);
	SELECT id into param from tbl_district ti WHERE ti.dist_name = name;
    SELECT param;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `last_record_id` (IN `hfid` VARCHAR(200), IN `status` INT)  NO SQL
BEGIN
	DECLARE lid VARCHAR(100);
	SELECT id into lid from tbl_families_personals ti WHERE ti.hfid = hfid AND ti.status = status;
    SELECT lid;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sample_proc` (IN `hfid` VARCHAR(50), IN `type` VARCHAR(100))  NO SQL
BEGIN
	SELECT hfid,fname from tbl_families_personals p WHERE p.hfid = hfid AND p.fam_category = type;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spAcademiInfo` (IN `aid` INT, IN `personid` INT, IN `grade` VARCHAR(100), IN `performance` VARCHAR(100), IN `years` DATE, IN `hfid` VARCHAR(150), IN `type` VARCHAR(150), IN `statuses` TINYINT, IN `param` VARCHAR(100))  NO SQL
BEGIN
	DECLARE ins VARCHAR(100);
	DECLARE y VARCHAR(100);

	IF years IS NULL THEN
		SET y = CURDATE();
	ELSE
		SET y = years;
	END IF;

    IF grade IS NULL AND performance IS NULL THEN
        SET ins = '';
    ELSE
    	IF param = 'insert' THEN
            INSERT INTO tbl_academics
                (`madrasa_id`,
                `student_id`,
                `grade`,
                `performance`,
                `academic_year`,
                `hfid`,
                `type`,
                `status`,
                `created_at`) 	
            VALUES
                ( aid, personid, grade, performance, y, 
                 hfid, type, statuses, SYSDATE());

              SET ins = param;
        ELSE 
              UPDATE tbl_familiesfuture_infos tf 
                SET `grade` = grade, 
                `performance` = performance, 
                `academic_year` = years,
                `updated_at` = SYSDATE()
                WHERE tf.student_id = personid 
                AND tf.hfid = hfid;

                SET ins = param;
       	END IF;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spTarbiyyahInfo` (IN `aid` INT, IN `personid` INT, IN `tajveed` VARCHAR(100), IN `arabic` VARCHAR(100), IN `fiqh` VARCHAR(100), IN `years` DATE, IN `type` VARCHAR(150), IN `hfid` VARCHAR(150), IN `statuses` TINYINT, IN `param` VARCHAR(100))  BEGIN
	DECLARE ins VARCHAR(100);
	DECLARE y VARCHAR(100);

	IF years IS NULL THEN
		SET y = CURDATE();
	ELSE
		SET y = years;
	END IF;

    IF tajveed IS NULL AND fiqh IS NULL AND arabic IS NULL THEN
        SET ins = '';
    ELSE
    	IF param = 'insert' THEN
            INSERT INTO tbl_tarbiyyah
                (`madrasa_id`,
                `student_id`,
                `tajveed`,
                `arabic`,
                `fiqh`,
                `t_year`,
                `hfid`,
                `type`,
                `status`,
                `created_at`) 	
            VALUES
                ( aid, personid, tajveed, arabic,fiqh, y, 
                 hfid, type, statuses, SYSDATE());

              SET ins = param;
        ELSE 
              UPDATE tbl_tarbiyyah tf 
                SET `tajveed` = tajveed, 
                `arabic` = arabic, 
                `fiqh` = fiqh,
                `t_year` = years,
                `updated_at` = SYSDATE()
                WHERE tf.student_id = personid 
                AND tf.hfid = hfid;

                SET ins = param;
       	END IF;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `unique_family_check` (IN `hfid` VARCHAR(200), IN `fname` VARCHAR(150), IN `lname` VARCHAR(150), IN `dob` DATE, IN `statuses` INT)  NO SQL
BEGIN
	DECLARE f_id VARCHAR(50);
    SELECT COUNT(ti.id) into f_id from tbl_families_personals ti WHERE ti.hfid = hfid AND ti.fname = fname OR ti.lname = lname AND ti.dob = dob AND ti.status = statuses;
    SELECT f_id;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `institution_check` (`id` VARCHAR(200), `location` VARCHAR(150)) RETURNS INT(11) NO SQL
BEGIN
	DECLARE ckeck VARCHAR(100);
	SELECT COUNT(id) into ckeck from tbl_institutions_infos ti WHERE ti.id = id AND ti.location = location;
    
    RETURN ckeck;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` int(10) UNSIGNED NOT NULL,
  `door` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `street` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taluk` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postcode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `add_status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `door`, `street`, `state`, `taluk`, `postcode`, `add_status`, `created_at`, `updated_at`) VALUES
(1, '23', 'Uppinangady', 'Karnataka', 'Bantval', '574231', 1, '2019-06-07 06:17:46', '2019-06-07 06:17:46'),
(2, '12', 'Kavalkatte', 'Karnataka', 'Bantval', '574265', 1, '2019-06-07 06:20:41', '2019-06-07 06:20:41'),
(3, '-', 'Mallige Majalu', 'Karnataka', 'Belthangady', '574214', 1, '2019-06-07 10:31:54', '2019-06-07 10:31:54'),
(4, '01', 'Kavalkatte', 'Karnataka', 'Bantval', '574265', 1, '2019-06-07 11:09:07', '2019-06-07 11:09:07'),
(5, '03', 'Kavalkatte', 'Karnataka', 'Bantval', '574265', 1, '2019-06-08 05:54:44', '2019-06-08 05:54:44'),
(6, '02', 'Kavalkatte', 'Karnataka', 'Bantval', '574265', 1, '2019-06-08 06:28:30', '2019-06-08 06:28:30'),
(7, '04', 'Kavalkatte', 'Karnataka', 'Bantval', '574265', 1, '2019-06-08 07:28:07', '2019-06-08 07:28:07'),
(8, '05', 'Kavalkatte', 'Karnataka', 'Bantval', '574265', 1, '2019-06-08 10:06:54', '2019-06-08 10:06:54'),
(9, '06', 'Kavalkatte', 'Karnataka', 'Bantval', '574265', 1, '2019-06-08 10:42:57', '2019-06-08 10:42:57'),
(10, '07', 'Kavalkatte', 'Karnataka', 'Bantval', '574265', 1, '2019-06-08 11:44:17', '2019-06-08 11:44:17'),
(11, '08', 'Kavalkatte', 'Karnataka', 'Bantval', '574265', 1, '2019-06-08 12:34:06', '2019-06-08 12:34:06'),
(12, '-08', 'Kavalkatte', 'Karnataka', 'Bantval', '574265', 1, '2019-06-09 04:40:54', '2019-06-09 04:40:54'),
(13, '09', 'Kavalkatte', 'Karnataka', 'Bantval', '574265', 1, '2019-06-09 05:45:54', '2019-06-09 05:45:54'),
(14, '10', 'Kavalkatte', 'Karnataka', 'Bantval', '574265', 1, '2019-06-09 06:52:08', '2019-06-09 06:52:08'),
(15, '11', 'Kavalkatte', 'Karnataka', 'Bantval', '574265', 1, '2019-06-09 08:10:42', '2019-06-09 08:10:42'),
(16, '13', 'Kavalkatte', 'Karnataka', 'Bantval', '574265', 1, '2019-06-09 10:37:22', '2019-06-09 10:37:22'),
(17, '14', 'Kavalkatte', 'Karnataka', 'Bantval', '574265', 1, '2019-06-09 11:26:36', '2019-06-09 11:26:36'),
(18, '15', 'Kavalkatte', 'Karnataka', 'Bantval', '574265', 1, '2019-06-09 11:49:57', '2019-06-09 11:49:57'),
(19, 'P- 16', 'Hirubandadi', 'Karnataka', 'Putthuru', '574241', 1, '2019-06-10 10:53:30', '2019-06-10 10:53:30'),
(20, 'P-  16', 'Kuvettu Solpadi', 'Karnataka', 'karkala', '', 1, '2019-06-10 11:25:52', '2019-06-10 11:25:52'),
(21, 'P-18', 'Pathrathota House .', 'Karnataka', 'Bantwal', '574211', 1, '2019-06-10 11:53:37', '2019-06-10 11:53:37'),
(22, 'P-15', 'Narasimha Raja Mohalla', 'Karnataka', 'Mysore', '570007', 1, '2019-06-11 05:01:25', '2019-06-11 05:01:25'),
(23, 'P-16', 'Shanthi Nagara', 'Karnataka', 'Chikamagaluru', '577101', 1, '2019-06-11 05:20:55', '2019-06-11 05:20:55');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `role`, `email`, `password`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'swab', 'Sudo', 'admin1234@gmail.com', '$2y$10$GjRIP3wh3TNBpSZb64YCt.8zGSUZjkGG8YAuPB0AFChAhMva.VgC2', '2019-09-13 05:14:25', 'ys9MP3ixqlYMD1e0MvfBQzQzFEh5b7tDTvULVTKJ6bc1OxsUmcvRjnQB8nx5', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `att_students_class_assessment`
--

CREATE TABLE `att_students_class_assessment` (
  `id` int(11) NOT NULL,
  `stud_id` int(11) NOT NULL,
  `course` varchar(150) NOT NULL,
  `class` varchar(100) NOT NULL,
  `arabic_knowledge` varchar(150) NOT NULL,
  `islamic_knowledge` varchar(150) NOT NULL,
  `english` varchar(150) NOT NULL,
  `sem1` int(11) NOT NULL,
  `sem2` int(11) NOT NULL,
  `sem3` int(11) NOT NULL,
  `status` int(11) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `core_skills`
--

CREATE TABLE `core_skills` (
  `id` int(10) UNSIGNED NOT NULL,
  `person_id` int(11) NOT NULL,
  `year` date NOT NULL,
  `basic_name` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `basic_perfomance` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'student',
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `families_models`
--

CREATE TABLE `families_models` (
  `id` int(11) NOT NULL,
  `hfId` varchar(10) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `lname` varchar(100) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(10) NOT NULL,
  `mobile` bigint(15) DEFAULT NULL,
  `phone` bigint(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `hobbies` varchar(100) DEFAULT NULL,
  `goal` varchar(100) DEFAULT NULL,
  `living` varchar(50) DEFAULT NULL,
  `birth_place` varchar(250) DEFAULT NULL,
  `nationality` varchar(50) DEFAULT NULL,
  `relegion` varchar(50) DEFAULT NULL,
  `mother_tongue` varchar(50) DEFAULT NULL,
  `relation` varchar(50) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `category` varchar(50) NOT NULL,
  `related_category` varchar(50) DEFAULT NULL,
  `marital_status` varchar(50) DEFAULT NULL,
  `helps` varchar(100) DEFAULT NULL,
  `occupation` varchar(100) DEFAULT NULL,
  `ration_no` varchar(100) DEFAULT NULL,
  `ration_image` varchar(200) DEFAULT NULL,
  `adhar_no` bigint(20) DEFAULT NULL,
  `adhar_image` varchar(200) DEFAULT NULL,
  `dojHSCC` date DEFAULT NULL,
  `reason` varchar(100) DEFAULT NULL,
  `familial` varchar(50) DEFAULT NULL,
  `income` int(11) DEFAULT '0',
  `income_source` varchar(100) DEFAULT NULL,
  `healthstatus` varchar(100) DEFAULT NULL,
  `qualification` varchar(100) DEFAULT NULL,
  `shelter` varchar(50) DEFAULT NULL,
  `selfReliant` varchar(50) DEFAULT NULL,
  `services` varchar(100) DEFAULT NULL,
  `blood_group` varchar(100) DEFAULT NULL,
  `presentStatus` varchar(200) DEFAULT NULL,
  `presentFamilyDoor` varchar(10) DEFAULT NULL,
  `present_street` varchar(100) DEFAULT NULL,
  `present_city` varchar(100) DEFAULT NULL,
  `district` varchar(100) DEFAULT NULL,
  `present_state` varchar(100) DEFAULT NULL,
  `present_pincode` int(11) DEFAULT NULL,
  `previousFamilyDoor` varchar(10) DEFAULT NULL,
  `previousStreet` varchar(100) DEFAULT NULL,
  `previousState` varchar(100) DEFAULT NULL,
  `previousCity` varchar(100) DEFAULT NULL,
  `previousPin` int(11) DEFAULT NULL,
  `user_name` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `families_models`
--

INSERT INTO `families_models` (`id`, `hfId`, `full_name`, `lname`, `image`, `dob`, `gender`, `mobile`, `phone`, `email`, `hobbies`, `goal`, `living`, `birth_place`, `nationality`, `relegion`, `mother_tongue`, `relation`, `role`, `category`, `related_category`, `marital_status`, `helps`, `occupation`, `ration_no`, `ration_image`, `adhar_no`, `adhar_image`, `dojHSCC`, `reason`, `familial`, `income`, `income_source`, `healthstatus`, `qualification`, `shelter`, `selfReliant`, `services`, `blood_group`, `presentStatus`, `presentFamilyDoor`, `present_street`, `present_city`, `district`, `present_state`, `present_pincode`, `previousFamilyDoor`, `previousStreet`, `previousState`, `previousCity`, `previousPin`, `user_name`, `password`, `status`, `created_at`, `updated_at`) VALUES
(4, 'HFSCC01', 'Sumayya', NULL, NULL, '1984-01-11', 'Female', 8139968219, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', '-', 'Rolling Beedi', 'BLT14122115', NULL, 946333449438, NULL, '2017-09-19', 'He is an Alcoholic', 'Abandoned', 15000, '15000', 'Healthy', '5th', 'Rent', 'Yes', 'Free House, Monthly Ration, Free water Supply,Self- help Group ,', NULL, 'Now she is happy about her life, Her husband also supportive to her', '01', '', '', NULL, '', 0, '-', NULL, NULL, NULL, NULL, 'Sumayya', '0984-01-11', 1, '2019-06-07 10:31:54', '2019-06-08 16:08:07'),
(5, 'HFSCC01', 'Fathimathul Rinsha', NULL, NULL, '2010-08-19', 'Female', NULL, 0, '', 'Dance', 'Teacher', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 974219517239, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Healthy', '4th STD', 'null', 'null', 'null', NULL, 'null', '01', '', '', NULL, '', 0, '-', '', '', '', 0, 'Fathimathul Rinsha', '2010-08-19', 1, '2019-06-07 11:09:07', '2019-06-22 22:09:36'),
(6, 'HFSCC01', 'Ayishathul shafa', NULL, NULL, '2011-11-20', 'Female', NULL, 0, '', 'Dancing', 'Doctor', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 644776831152, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Healthy', '3rd STD', 'null', 'null', 'null', NULL, 'null', '01', '', '', NULL, '', 0, 'P-01', '', '', '', 0, 'Ayishathul shafa', '2011-11-20', 1, '2019-06-07 11:11:59', '2019-06-22 11:01:43'),
(7, 'HFSCC01', 'Fathimath Rifa', NULL, NULL, '2013-08-25', 'Female', NULL, 0, '', 'Writing', 'Doctor', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 370880218481, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Healthy', '1st STD', 'null', 'null', 'null', NULL, 'null', '01', '', '', NULL, '', 0, '-', '', '', '', 0, 'Fathimath Rifa', '2013-08-25', 1, '2019-06-07 11:45:30', '2019-06-22 22:10:35'),
(8, 'HFSCC03', 'Hajira', NULL, NULL, '1978-01-01', 'Female', 9591602829, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', 'Breathing Problerm', 'Rolling beedi', 'BTLR00115497', NULL, 289354076793, NULL, '1978-01-01', 'Expired', 'Widowed', 15000, 'Beedi Rolling', 'Healthy', '4th STD', 'None', 'Yes', 'Free house, Monthly Ration, Free water supply, Self - help Group.', NULL, 'She is happy and leading better life.', '03', '', '', NULL, '', 0, '-', NULL, NULL, NULL, NULL, 'Hajira', '1978-01-01', 1, '2019-06-08 05:54:44', NULL),
(9, 'HFSCC03', 'Fathimath Nisha', NULL, NULL, '2002-10-14', 'Female', NULL, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 575609496283, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Healthy', '2nd PUC', 'null', 'null', 'null', NULL, 'null', '03', '', '', NULL, '', 0, '-', NULL, NULL, NULL, NULL, 'Fathimath Nisha', '2002-10-14', 1, '2019-06-08 06:00:06', NULL),
(10, 'HFSCC03', 'Aboobakkar Siddique', NULL, NULL, '1995-07-06', 'Male', NULL, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Son', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Coolie', NULL, NULL, 620460277306, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Healthy', '2nd PUC & ITI', 'null', 'null', 'null', NULL, 'null', '03', '', '', NULL, '', 0, '-', NULL, NULL, NULL, NULL, 'Aboobakkar Siddique', '1995-07-06', 1, '2019-06-08 06:06:01', '2019-06-08 13:24:08'),
(11, 'HFSCC02', 'Salika', NULL, NULL, '1987-01-01', 'Female', 9741485643, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', '-', 'Rolling Beedi', '-', NULL, 834504419029, NULL, '2019-05-15', 'Her husband was not taking care of her and children\'s.', 'Abandoned', 8000, 'Rolling Beedi', 'Healthy', 'None', 'None', 'Yes', 'Free house, Monthly Ration, Free water supply.', NULL, 'She feel secure for her life and also for children', '02', '', '', NULL, '', 0, '-', NULL, NULL, NULL, NULL, 'salika', '1987-01-01', 1, '2019-06-08 06:28:30', NULL),
(12, 'HFSCC02', 'Mahammad Shahid', NULL, NULL, '2009-03-28', 'Male', NULL, 0, '', 'Singing', 'Driver', 'Alive', NULL, NULL, NULL, NULL, 'Son', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 738062956037, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Vision Problem', '5th STD', 'null', 'null', 'null', NULL, 'null', '02', '', '', NULL, '', 0, '-', '', '', '', 0, 'Mahammad Shahid', '2009-03-28', 1, '2019-06-08 07:07:14', '2019-06-22 22:12:22'),
(13, 'HFSCC04', 'Asiyamma', NULL, NULL, '1974-01-01', 'Female', 9901972688, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', '-', 'Working as a Cook at Hidayah Special need center', 'BTL14146426', NULL, 692337664087, NULL, '2012-07-10', 'Expired', 'Widowed', 12000, 'Coock at Hidayah special need', 'Healthy', '4th STD', 'Rented', 'Yes', 'Free house, Monthly Ration, Free water supply, Self - help Group.', NULL, 'She is happy and leading better life', '04', '', '', NULL, '', 0, '-', NULL, NULL, NULL, NULL, 'Asiyamma', '1974-01-01', 1, '2019-06-08 07:28:07', NULL),
(14, 'HFSCC04', 'Shameera', NULL, NULL, '1993-04-05', 'Female', NULL, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Tailor', NULL, NULL, 671265618748, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Healthy', '10th', 'null', 'null', 'null', NULL, 'null', '04', '', '', NULL, '', 0, '-', NULL, NULL, NULL, NULL, 'Shameera', '1993-04-05', 1, '2019-06-08 07:49:50', '2019-06-08 16:09:13'),
(15, 'HFSCC05', 'Dulaikha', NULL, NULL, '1972-01-01', 'Female', 8971684873, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', 'Treatment for health issues', '-', '110100131452', NULL, 573017978341, NULL, '1972-06-16', 'her Husband was mentally ill, he went somewhere and did not came back.', 'Abandoned', 10000, 'son is working in abroad.', 'Unhealthy', '2nd STD', 'Rented', 'Yes', 'Free house, Monthly Ration, Free water supply, Self - help Group.', NULL, 'She is happy about her life, and She verily need the medical treatment for her health.', '05', '', '', NULL, '', 0, '-', NULL, NULL, NULL, NULL, 'Dulaikha', '1972-01-01', 1, '2019-06-08 10:06:54', NULL),
(16, 'HFSCC06', 'Jameela', NULL, NULL, '1985-01-01', 'Female', 7760144313, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', '-', '-', 'MNG04105138', NULL, 959357416640, NULL, '2015-11-01', '-', '-', 10000, 'Husband is working', 'Healthy', '2nd STD', 'Owned', 'Yes', 'Free house, Monthly Ration, Free water supply, Self - help Group.', 'Not Provided', 'She is Happy for her Children\'s that they are getting the special education,and  she is Leading better life,', '06', '', '', NULL, '', 0, '-', NULL, NULL, NULL, NULL, 'Jameela', '1985-01-01', 1, '2019-06-08 10:42:57', '2019-09-12 09:24:57'),
(17, 'HFSCC05', 'Fathimath Shareena', NULL, NULL, '2004-01-01', 'Female', NULL, 0, '', 'Dance', 'Teacher', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 262472907094, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Healthy', '10th', 'null', 'null', 'null', NULL, 'null', '05', '', '', NULL, '', 0, 'P-05', '', '', '', 0, 'Fathimath Shareena', '2004-01-01', 1, '2019-06-08 10:59:43', '2019-06-23 16:56:47'),
(18, 'HFSCC05', 'Mahammad Shahid', NULL, NULL, '2008-06-10', 'Male', NULL, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 407880751980, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Healthy', '6th', 'null', 'null', 'null', NULL, 'null', '05', '', '', NULL, '', 0, '-', '', '', '', 0, 'Mahammad Shahid', '2008-06-10', 1, '2019-06-08 11:04:18', '2019-06-13 16:03:50'),
(19, 'HFSCC07', 'Balkees', NULL, NULL, '1975-01-01', 'Female', 7899938843, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', '-', 'She is working', 'BTLR00115495', NULL, 561886135397, NULL, '2012-01-01', 'Her husband was not taking care of her and children  , He showed negligence towards family.', 'Domestic Violence', 10000, 'self employed', 'Healthy', '5th', 'Rented', 'Yes', 'Free house, Monthly Ration, Free water supply, Self - help Group.', NULL, 'She is happy for her life, also for children\'s', '07', '', '', NULL, '', 0, '-', NULL, NULL, NULL, NULL, 'Balkees', '1975-01-01', 1, '2019-06-08 11:44:17', NULL),
(20, 'HFSCC07', 'Fathima', NULL, NULL, '1999-01-24', 'Female', NULL, 0, '', 'Reading', 'Lecture', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 573100289950, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Healthy', 'B.Com', 'null', 'null', 'null', NULL, 'null', '07', '', '', NULL, '', 0, 'P-07', '', '', '', 0, 'Fathima', '1999-01-24', 1, '2019-06-08 11:53:00', '2019-06-23 17:04:08'),
(21, 'HFSCC07', 'Afreena Mariyam', NULL, NULL, '2002-05-23', 'Female', NULL, 0, '', 'Drawing', 'C.A', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 404948947113, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Healthy', '2nd PUC', 'null', 'null', 'null', NULL, 'null', '07', '', '', NULL, '', 0, 'P-07', '', '', '', 0, 'Afreena Mariyam', '2002-05-23', 1, '2019-06-08 11:56:20', '2019-06-23 17:11:03'),
(22, 'HFSCC07', 'Asura Beebi', NULL, NULL, '2004-02-27', 'Female', NULL, 0, '', 'Participating in any competition', 'Teacher', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 504893185335, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Healthy', '1st PUC', 'null', 'null', 'null', NULL, 'null', '07', '', '', NULL, '', 0, 'P-07', '', '', '', 0, 'Asura Beebi', '2004-02-27', 1, '2019-06-08 12:04:05', '2019-06-23 17:20:06'),
(23, 'HFSCC08', 'Naseema', NULL, NULL, '1982-01-01', 'Female', 8722641402, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', '-', 'Rolling beedi', 'BTLR00115498', NULL, 694288180559, NULL, '2012-01-01', 'Drug Addiction', 'Domestic Violence', 5000, 'Rolling Beedi', 'Healthy', '6th STD', 'Rented', 'Yes', 'Free house, Monthly Ration, Free water supply, Self - help Group.', NULL, 'She is happy and leading Better life.', '08', '', '', NULL, '', 0, '-', NULL, NULL, NULL, NULL, 'Naseema', '1982-01-01', 1, '2019-06-08 12:34:06', NULL),
(24, 'HFSCC08', 'Mashoofa', NULL, NULL, '2001-08-20', 'Female', NULL, 0, '', 'Reading', 'Arabic Teacher', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 970882962191, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', 'Diploma Education in Arabic Language', 'null', 'null', 'null', NULL, 'null', '08', '', '', NULL, '', 0, 'P-08', '', '', '', 0, 'Mashoofa', '2001-08-20', 1, '2019-06-09 04:38:39', '2019-06-23 17:21:30'),
(25, 'HFSCC08', 'Mishriya', NULL, NULL, '2003-02-03', 'Female', NULL, 0, '', 'Writing', 'Teacher', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 577725799504, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '2nd PUC', 'null', 'null', 'null', NULL, 'null', '08', '', '', NULL, '', 0, 'P-08', '', '', '', 0, 'Mishriya', '2003-02-03', 1, '2019-06-09 04:40:54', '2019-06-23 17:22:22'),
(26, 'HFSCC08', 'Afreena', NULL, NULL, '2004-05-30', 'Female', NULL, 0, '', 'Reading Story books', 'Teacher', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 425791284241, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '1st PUC', 'null', 'null', 'null', NULL, 'null', '08', '', '', NULL, '', 0, 'P-08', '', '', '', 0, 'Afreena', '2004-05-30', 1, '2019-06-09 04:44:04', '2019-06-25 10:52:29'),
(27, 'HFSCC08', 'Naseefa', NULL, '', '2006-05-14', 'Female', NULL, 0, '', 'Drawing', 'Teacher', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 509166553450, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '9th STD', 'null', 'null', 'null', NULL, 'null', '08', '', '', NULL, '', 0, 'P-08', '', '', '', 0, 'Naseefa', '2006-05-14', 1, '2019-06-09 04:46:03', '2019-06-25 10:56:39'),
(28, 'HFSCC06', 'Abdul Latheef', NULL, NULL, '1975-01-01', 'Male', NULL, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Father', 'Member', 'HSCC', '', 'Married', NULL, 'Coolie', NULL, NULL, 273307474066, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '3rd STD', 'null', 'null', 'null', NULL, 'null', '06', '', '', NULL, '', 0, '-', NULL, NULL, NULL, NULL, 'Abdul Latheef', '1975-01-01', 1, '2019-06-09 04:56:49', '2019-06-09 10:33:38'),
(29, 'HFSCC06', 'Mohammad Sameer', NULL, NULL, '2004-04-05', 'Male', NULL, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Son', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 343163658455, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', 'Secondary (Hidayah Special Need Center)', 'null', 'null', 'null', NULL, 'null', '06', '', '', NULL, '', 0, '-', NULL, NULL, NULL, NULL, 'Mohammad Sameer', '2004-04-05', 1, '2019-06-09 05:01:02', NULL),
(30, 'HFSCC06', 'Mohammed Safaz', NULL, NULL, '2006-09-28', 'Male', NULL, 0, '', 'Drawing', 'Engineer', 'Alive', NULL, NULL, NULL, NULL, 'Son', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 343163658455, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '8th STD', 'null', 'null', 'null', NULL, 'null', '06', '', '', NULL, '', 0, 'P-06', '', '', '', 0, 'Mohammed Safaz', '2006-09-28', 1, '2019-06-09 05:06:31', '2019-06-22 11:14:01'),
(31, 'HFSCC06', 'Mohammed Shiabuddeen', NULL, NULL, '2012-07-26', 'Male', NULL, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Son', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 429988207221, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', 'Care Group (Hidayah Special Need Center )', 'null', 'null', 'null', NULL, 'null', '06', '', '', NULL, '', 0, '-', NULL, NULL, NULL, NULL, 'Mohammed Shiabuddeen', '2012-07-26', 1, '2019-06-09 05:20:17', NULL),
(32, 'HFSCC09', 'Shahnaz Banu', NULL, NULL, '1986-01-01', 'Female', 9108679233, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', 'She wants to Study', '-', '260100124112', NULL, 870498642881, NULL, '2019-04-20', 'Her husband was Not Caring & supportive to her, and he does not had any feelings for her.', 'Abandoned', 5000, '-', 'Good', 'BBM', 'None', 'Yes', 'Free house, free water supply,Monthly Ration,', NULL, 'She is Happy Now, she want to study and want a job for lead her life.', '09', '', '', NULL, '', 0, '-', NULL, NULL, NULL, NULL, 'Shahnaz Banu', '1986-01-01', 1, '2019-06-09 05:45:54', NULL),
(33, 'HFSCC09', 'Mohammed Imaz Sheik', NULL, NULL, '2012-03-07', 'Male', NULL, 0, '', 'Drawing', 'Engineer', 'Alive', NULL, NULL, NULL, NULL, 'Son', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 708753780617, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '3rd', 'null', 'null', 'null', NULL, 'null', '09', '', '', NULL, '', 0, 'P-09', '', '', '', 0, 'Mohammed Imaz Sheik', '2012-03-07', 1, '2019-06-09 06:23:50', '2019-06-22 22:21:10'),
(34, 'HFSCC10', 'Jameela', NULL, NULL, '1974-04-01', 'Female', 9663765293, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', '-', 'Rolling Beedi', 'BTLR00116733', NULL, 308853765737, NULL, '2013-09-01', 'Negligence towards Family.', 'Abandoned', 5000, 'Rolling Beedi', 'Good (intellectual disability)', '3rd STD', 'None', 'Yes', 'Free House, Free water Supply, Monthly ration', NULL, 'She is happy , and leading better life', '10', '', '', NULL, '', 0, '-', NULL, NULL, NULL, NULL, 'Jameela', '1974-04-01', 1, '2019-06-09 06:52:08', '2019-06-10 16:26:11'),
(35, 'HFSCC10', 'Mahammad Nihal', NULL, NULL, '2010-01-07', 'Male', NULL, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Son', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 423727648258, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '5th STD', 'null', 'null', 'null', NULL, 'null', '10', '', '', NULL, '', 0, '-', NULL, NULL, NULL, NULL, 'Mahammad Nihal', '2010-01-07', 1, '2019-06-09 07:21:46', NULL),
(36, 'HFSCC11', 'Raziya', NULL, NULL, '1978-01-01', 'Female', 7259554030, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', '-', 'Rolling beedi, tailor', 'BTLR00104091', NULL, 534067739756, NULL, '2012-09-08', 'Expired', 'Widowed', 80000, 'Rolling Beedi, Tailor', 'Good', '5th', 'Owned', 'Yes', 'Free House, Monthly Ration , Free water supply, Facility for self reliant , Self - help Group.', NULL, 'she  is happy and leading better life.', '11', '', '', NULL, '', 0, '-', NULL, NULL, NULL, NULL, 'Raziya', '1978-01-01', 1, '2019-06-09 08:10:42', NULL),
(37, 'HFSCC11', 'Mohammad jeeshan Pasha', NULL, NULL, '2003-09-09', 'Male', NULL, 0, '', 'Cricket', 'Military', 'Alive', NULL, NULL, NULL, NULL, 'Son', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 810803703434, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '10th STD', 'null', 'null', 'null', NULL, 'null', '11', '', '', NULL, '', 0, 'P-11', '', '', '', 0, 'Mohammad jeeshan Pasha', '2003-09-09', 1, '2019-06-09 08:59:21', '2019-06-22 12:48:19'),
(38, 'HFSCC12', 'Fathima Zohra', NULL, NULL, '1986-01-01', 'Female', 8884702032, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', '-', 'Rolling beedi', '-', NULL, 810214729587, NULL, '2019-04-15', 'He is not taking care of her,', 'Abandoned', 8000, 'Rolling beedi', 'Good', '2nd STD', 'Rented', 'Yes', 'Free house, Free water supply, Monthly Ration,', NULL, 'Now She is happy and leading better life.', '12', '', '', NULL, '', 0, '-', NULL, NULL, NULL, NULL, 'Fathima Zohra', '1986-01-01', 1, '2019-06-09 09:31:29', NULL),
(39, 'HFSCC11', 'Thoushin Banu', NULL, NULL, '2005-06-22', 'Female', NULL, 0, '', 'Reading and writing', 'Doctor', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 492474016915, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '9th STD', 'null', 'null', 'null', NULL, 'null', '11', '', '', NULL, '', 0, '-', '', '', '', 0, 'Thoushin Banu', '2005-06-22', 1, '2019-06-09 09:45:45', '2019-06-22 20:30:12'),
(40, 'HFSCC12', 'Jabbar khan', NULL, NULL, '2011-12-10', 'Male', NULL, 0, '', 'Writing', 'Driver', 'Alive', NULL, NULL, NULL, NULL, 'Son', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 585078409719, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '3rd STD', 'null', 'null', 'null', NULL, 'null', '12', '', '', NULL, '', 0, 'P-12', '', '', '', 0, 'Jabbar khan', '2011-12-10', 1, '2019-06-09 09:53:43', '2019-06-22 12:07:06'),
(41, 'HFSCC12', 'Badruddeen', NULL, NULL, '2004-01-14', 'Male', NULL, 0, '', 'Science model', 'Engineer', 'Alive', NULL, NULL, NULL, NULL, 'Son', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 655273109990, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '10th STD', 'null', 'null', 'null', NULL, 'null', '12', '', '', NULL, '', 0, 'P-12', '', '', '', 0, 'Badruddeen', '2004-01-14', 1, '2019-06-09 10:07:04', '2019-06-22 22:19:55'),
(42, 'HFSCC13', 'Ramlath', NULL, NULL, '1987-01-01', 'Female', 8711024108, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', '-', 'Beedi Rolling', '-', NULL, 379374782889, NULL, '2018-08-10', 'He was not taking care of her,', 'Abandoned', 10000, 'Beedi rolling', 'Good', '3rd', 'None', 'Yes', 'Monthly Ration , Free Water Supply, Free house,', NULL, 'She is happy and leading better life.', '13', '', '', NULL, '', 0, '-', NULL, NULL, NULL, NULL, 'Ramlath', '1987-01-01', 1, '2019-06-09 10:37:22', NULL),
(43, 'HFSCC13', 'Aayisha Banu', NULL, NULL, '2008-04-15', 'Female', NULL, 0, '', 'Drawing', 'Teacher', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 770499505752, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '6th STD', 'null', 'null', 'null', NULL, 'null', '13', '', '', NULL, '', 0, '-', '', '', '', 0, 'Aayisha Banu', '2008-04-15', 1, '2019-06-09 10:57:28', '2019-06-22 22:28:38'),
(44, 'HFSCC13', 'Mahammad Shahid', NULL, NULL, '2006-06-02', 'Male', NULL, 0, '', 'Drawing', 'Engineer', 'Alive', NULL, NULL, NULL, NULL, 'Son', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 653696829909, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '4th STD', 'null', 'null', 'null', NULL, 'null', '13', '', '', NULL, '', 0, 'P-13', '', '', '', 0, 'Mahammad Shahid', '2006-06-02', 1, '2019-06-09 11:06:18', '2019-06-22 22:30:14'),
(45, 'HFSCC14', 'Jameela', NULL, NULL, '1973-01-01', 'Female', 9611598639, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', 'her One eye is blind , She need the medical treatment.', 'Beedi Rolling', '887943210236', NULL, NULL, NULL, '2018-12-05', 'Her husband have another wife and he is not taking care of her.', 'Abandoned', 5000, 'Rolling beedi', 'Unhealthy', '6th STD', 'None', 'Yes', 'free house, Free water Supply,  Monthly Ration', NULL, 'She is happy, and leading better life.', '14', '', '', NULL, '', 0, '-', NULL, NULL, NULL, NULL, 'Jameela', '1973-01-01', 1, '2019-06-09 11:26:36', '2019-06-10 16:30:53'),
(46, 'HFSCC14', 'Beepathumma', NULL, NULL, '2009-04-17', 'Female', NULL, 0, '', 'Drawing', 'Teacher', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 702778700563, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '6th STD', 'null', 'null', 'null', NULL, 'null', '14', '', '', NULL, '', 0, '-', '', '', '', 0, 'Beepathumma', '2009-04-17', 1, '2019-06-09 11:34:38', '2019-06-22 22:33:00'),
(47, 'HFSCC15', 'Ayesha', NULL, NULL, '1992-01-01', 'Female', 9606225247, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', '-', 'Rolling beedi', 'MYSI00114019', NULL, 249410067267, NULL, '2018-03-01', 'Expired', 'Widowed', 8000, 'Rolling beedi', 'Good', '5th', 'Rented', 'Yes', 'Free water supply, monthly ration, Free House, Self - help Group.', NULL, 'She is happy and leading better life.', '15', '', '', NULL, '', 0, 'P-15', NULL, NULL, NULL, NULL, 'Ayesha', '1992-01-01', 1, '2019-06-09 11:49:57', '2019-06-10 16:03:05'),
(48, 'HFSCC16', 'Beepathumma', NULL, NULL, '1979-01-01', 'Female', 7338527637, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', '-', 'Beedi rolling', '110400133016', NULL, 328844852086, NULL, '2016-08-16', 'Her Husband Is Alcoholic', 'Abandoned', 5000, 'Rolling Beedi', 'Good', '-', 'None', 'Yes', 'Free House, free water Supply , Monthly Ration, Self-Help Group.', NULL, 'She is Happy And leading better life.', '16', '', '', NULL, '', 0, 'P- 16', NULL, NULL, NULL, NULL, 'Beepathumma', '1979-01-01', 1, '2019-06-10 10:53:30', NULL),
(49, 'HFSCC17', 'Fathima', NULL, NULL, '1967-12-12', 'Female', 9035673460, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', 'Medical Treatment', '-', '-', NULL, 0, NULL, '2017-04-30', 'He was Not taken care of her, negligence of family.', 'Abandoned', 5000, '-', 'unhealthy (Bed Ridden)', '5th  STD', 'Rented', 'Yes', 'Free House, Free water supply,  Monthly ration', NULL, 'She is happy but she is bed ridden and her sister with her to take care of her.', '17', '', '', NULL, '', 0, 'P-  17', NULL, NULL, NULL, NULL, 'Fathima', '1967-12-12', 1, '2019-06-10 11:25:52', '2019-06-10 16:58:48'),
(50, 'HFSCC18', 'Zeenath', NULL, NULL, '1987-01-01', 'Female', 7259366992, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', '-', 'Rolling Beedi & Tailor', 'BTLR0014772', NULL, 811832978520, NULL, '2017-12-05', 'Expired', 'Widowed', 8000, 'Beedi Rolling &', 'Good', '6th STD', 'None', 'Yes', 'Free house, Free water supply, Monthly Ration, Facility for Self reliant , Self- help Group.', NULL, 'She is happy and Leading Better life,.', '18', '', '', NULL, '', 0, 'P-18', NULL, NULL, NULL, NULL, 'Zeenath', '1987-01-01', 1, '2019-06-10 11:53:37', NULL),
(51, 'HFSCC15', 'Fathima Shafa', NULL, NULL, '2013-04-18', 'Female', NULL, 0, '', 'Dancing', 'Teacher', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 314892067629, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', 'UKG', 'null', 'null', 'null', NULL, 'null', '15', '', '', NULL, '', 0, 'P-15', '', '', '', 0, 'Fathima Shafa', '2013-04-18', 1, '2019-06-11 05:01:25', '2019-06-22 11:14:48'),
(52, 'HFSCC15', 'Shafina', NULL, NULL, '2014-06-22', 'Female', NULL, 0, '', 'Dancing', 'Teacher', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 892367354364, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', 'LKG', 'null', 'null', 'null', NULL, 'null', '15', '', '', NULL, '', 0, 'P-15', '', '', '', 0, 'Shafina', '2014-06-22', 1, '2019-06-11 05:08:51', '2019-06-22 22:35:38'),
(53, 'HFSCC16', 'Fahida Banu', NULL, NULL, '2011-01-01', 'Female', NULL, 0, '', 'Drawing', 'Teacher', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 975014783522, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '3rd STD', 'null', 'null', 'null', NULL, 'null', '16', '', '', NULL, '', 0, 'P-16', '', '', '', 0, 'Fahida Banu', '2011-01-01', 1, '2019-06-11 05:20:55', '2019-06-22 22:06:57'),
(54, 'HFSCC16', 'Fahimathul Fida', NULL, NULL, '2014-05-26', 'Female', NULL, 0, '', 'Drawing', 'Teacher', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 601910875048, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', 'UKG', 'null', 'null', 'null', NULL, 'null', '16', '', '', NULL, '', 0, 'P-16', '', '', '', 0, 'Fahimathul Fida', '2014-05-26', 1, '2019-06-11 05:37:21', '2019-06-22 22:07:38'),
(55, 'HFSCC18', 'Fathimath Shahla', NULL, NULL, '2009-09-21', 'Female', NULL, 0, '', 'Reading', 'Doctor', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 784011510199, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '5th STD', 'null', 'null', 'null', NULL, 'null', '18', '', '', NULL, '', 0, 'P-16', '', '', '', 0, 'Fathimath Shahla', '2009-09-21', 1, '2019-06-11 05:47:39', '2019-06-21 22:27:49'),
(56, 'HFSCC18', 'Fathimath Suhaila', NULL, NULL, '2006-10-21', 'Female', NULL, 0, '', 'Reading', 'Doctor', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 377752184531, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '8th STD', 'null', 'null', 'null', NULL, 'null', '18', '', '', NULL, '', 0, 'P-18', '', '', '', 0, 'Fathimath Suhaila', '2006-10-21', 1, '2019-06-11 05:53:18', '2019-06-21 22:29:09'),
(57, 'HFSCC19', 'Nebisa', NULL, NULL, '1973-08-25', 'Female', 8197858682, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', '-', 'Rolling Beedi', 'BTLR00127513', NULL, 915433770379, NULL, '2013-10-31', 'Expired', 'Widowed', 6000, 'Rolling Beedi', 'Good', '5th STD', 'None', 'Yes', 'Free House, free water supply, Monthly Ration, Self-help Group.', NULL, 'She is happy and leading Better life.', '19', '', '', NULL, '', 0, 'P-19', 'Pandavarakallu', 'Karnataka', 'Madanthyar', 574233, 'Nebisa', '1973-08-25', 1, '2019-06-11 09:12:01', NULL),
(58, 'HFSCC19', 'Shahida banu', NULL, NULL, '2002-10-30', 'Female', NULL, 0, '', 'Drawing', 'Doctor', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 578876457400, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '2nd PUC', 'null', 'null', 'null', NULL, 'null', '19', '', '', NULL, '', 0, 'P-19', '', '', '', 0, 'Shahida banu', '2002-10-30', 1, '2019-06-11 09:24:42', '2019-06-22 22:43:48'),
(59, 'HFSCC19', 'Sameeda banu', NULL, NULL, '2009-01-09', 'Female', NULL, 0, '', 'Writing', 'Doctor', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 767257236314, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '6th STD', 'null', 'null', 'null', NULL, 'null', '19', '', '', NULL, '', 0, 'P-19', '', '', '', 0, 'Sameeda banu', '2009-01-09', 1, '2019-06-11 09:28:08', '2019-06-22 22:43:10'),
(60, 'HFSCC19', 'Rizwan', NULL, NULL, '2006-04-04', 'Male', NULL, 0, '', 'Drawing', 'Military', 'Alive', NULL, NULL, NULL, NULL, 'Son', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 858682397368, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '9th STD', 'null', 'null', 'null', NULL, 'null', '19', '', '', NULL, '', 0, 'P-19', '', '', '', 0, 'Rizwan', '2006-04-04', 1, '2019-06-11 09:32:04', '2019-06-22 13:00:49'),
(61, 'HFSCC20', 'Ayisha', NULL, NULL, '1984-10-01', 'Female', 9606225247, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', 'Medical Treatments for Daughter', 'Rolling Beedi', 'BTLR00108939', NULL, 756923090166, NULL, '2017-01-17', 'Her Husband showed negligence towards family. He was not taken care of her.', 'Abandoned', 5000, '5000', 'Good', '5th', 'Rented', 'Yes', 'Free House', NULL, 'She is happy and leading better Life, Over concerned for her child health.', '20', '', '', NULL, '', 0, 'P-20', 'Guringana , Layila', 'Karnataka', 'Belthangady', 574214, 'Ayisha', '1984-10-01', 1, '2019-06-11 09:48:29', '2019-06-12 09:23:56'),
(62, 'HFSCC20', 'Fathimath Rumaiza', NULL, NULL, '2010-06-28', 'Female', NULL, 0, '', 'Playing', NULL, 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 427705062714, NULL, NULL, NULL, NULL, NULL, NULL, 'Good', '4th STD', NULL, NULL, NULL, 'A Positive', NULL, '20', '', '', NULL, '', 0, 'P-20', '', '', '', 0, 'Fathimath Rumaiza', '2010-06-28', 1, '2019-06-11 09:57:47', '2019-09-12 11:56:23'),
(63, 'HFSCC21', 'Athijamma', NULL, NULL, '1976-01-01', 'Female', 8762256773, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', '-', 'Beedi Rolling', 'BTLR14150253', NULL, 676114303335, NULL, '2013-11-10', 'Expired', 'Widowed', 7000, 'Rolling Beedi', 'good', '-', 'None', 'Yes', 'Free House, Free monthly ration,self- help group, Free wate supply.', NULL, 'she is happy and Leading better life.', '21', '', '', NULL, '', 0, 'P-21', 'Mudukodi', 'Karnataka', 'Belthangady', 574242, 'Athijamma', '1976-01-01', 1, '2019-06-11 10:19:54', '2019-06-11 18:05:28'),
(64, 'HFSCC21', 'Rameeza', NULL, NULL, '1994-07-17', 'Female', NULL, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'Married', NULL, 'Housewife', NULL, NULL, 931326413708, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '10th STD', 'null', 'null', 'null', NULL, 'null', '21', '', '', NULL, '', 0, 'P-21', '', '', '', 0, 'Rameeza', '1994-07-17', 1, '2019-06-11 10:23:06', NULL),
(65, 'HFSCC21', 'Shabeer N', NULL, NULL, '1997-04-06', 'Male', NULL, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Son', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Coolie', NULL, NULL, 559331632748, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '-', 'null', 'null', 'null', NULL, 'null', '21', '', '', NULL, '', 0, 'P-21', '', '', '', 0, 'Shabeer N', '1997-04-06', 1, '2019-06-11 10:26:33', NULL),
(66, 'HFSCC22', 'Shamshad', NULL, NULL, '1986-07-11', 'Female', 8277338278, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', '-', 'Tailor', '590100157632', NULL, 2358626825553, NULL, '2018-12-22', 'He is not supportive , and he  used to Torture her.', 'Abandoned', 7000, 'Tailor', 'Good', '7th STD', 'Rented', 'Yes', 'Free House, Free Water supply, Monthly ration,Self- Help Group, Center for self Reliant.', NULL, 'She is Happy and Leading happy life.', '22', '', '', NULL, '', 0, 'P-22', '', '', '', 0, 'Shamshad', '1986-07-11', 1, '2019-06-11 10:53:16', '2019-06-11 17:23:25'),
(67, 'HFSCC22', 'Syed Abrar', NULL, NULL, '2007-04-05', 'Male', NULL, 0, '', 'Cricket', 'Military', 'Alive', NULL, NULL, NULL, NULL, 'Son', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 337295050425, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '10th STD', 'null', 'null', 'null', NULL, 'null', '22', '', '', NULL, '', 0, 'P-22', '', '', '', 0, 'Syed Abrar', '2007-04-05', 1, '2019-06-11 10:59:14', '2019-06-22 11:22:18'),
(68, 'HFSCC22', 'Manha', NULL, NULL, '2010-01-11', 'Female', NULL, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 607351842498, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'good', '5th STD', 'null', 'null', 'null', NULL, 'null', '22', '', '', NULL, '', 0, 'P-22', 'Aladangady', 'Karnataka', 'Belthangady', 574217, 'Manha', '2010-01-11', 1, '2019-06-11 11:04:06', NULL),
(69, 'HFSCC22', 'Thasniya', NULL, NULL, '2012-02-04', 'Female', NULL, 0, '', 'Dancing', 'doctor', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 6567, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '2nd STD', 'null', 'null', 'null', NULL, 'null', '22', '', '', NULL, '', 0, 'P-22', '', '', '', 0, 'Thasniya', '2012-02-04', 1, '2019-06-11 11:06:57', '2019-06-22 11:18:25'),
(70, 'HFSCC24', 'Mumthaz', NULL, NULL, '1993-01-01', 'Female', 9740614425, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', '-', 'Tailor', '110200137986', NULL, 714600645242, NULL, '2016-06-06', 'Extra Marital Affairs.', 'Abandoned', 7000, 'Tailor , Beedi Rolling', 'Good', '10th STD', 'Rented', 'Yes', 'Free house, Free Water supply, center for self reliant, Monthly ration.', NULL, 'She is happy and leading better life.', '24', '', '', NULL, '', 0, 'P-24', '', '', '', 0, 'Mumthaz', '1993-01-01', 1, '2019-06-11 11:33:48', '2019-06-11 17:43:30'),
(71, 'HFSCC24', 'Mohammad Numan', NULL, NULL, '2011-09-04', 'Male', NULL, 0, '', 'Dancing', 'Doctor', 'Alive', NULL, NULL, NULL, NULL, 'Son', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 352973436604, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '3rd STD', 'null', 'null', 'null', NULL, 'null', '24', '', '', NULL, '', 0, 'P-24', '', '', '', 0, 'Mohammad Numan', '2011-09-04', 1, '2019-06-11 11:59:52', '2019-06-22 11:59:46'),
(72, 'HFSCC24', 'Mahammad Nubeen', NULL, NULL, '2014-05-07', 'Male', NULL, 0, '', 'Drawing', 'Engineer', 'Alive', NULL, NULL, NULL, NULL, 'Son', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 219438561459, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', 'UKG', 'null', 'null', 'null', NULL, 'null', '24', '', '', NULL, '', 0, 'P-24', '', '', '', 0, 'Mahammad Nubeen', '2014-05-07', 1, '2019-06-11 12:03:40', '2019-06-21 22:31:19'),
(73, 'HFSCC23', 'Shamshad Banu', NULL, NULL, '2018-09-12', 'Female', 9008520987, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', '-', 'Tailor, Beedi Rolling', '110200137880', NULL, 462144905806, NULL, '1979-07-14', 'Negligence Towards Family', 'Abandoned', 7000, '7000', 'Good', '7th', 'Rented', 'Yes', 'Free house, Free Monthly Ration, Free Water Supply, self- help Group.', NULL, 'She is happy and leading better Life.', '23', '', '', NULL, '', 0, 'P-23', '', '', '', 0, 'Shamshad Banu', '2018-09-12', 1, '2019-06-11 12:26:48', '2019-06-11 17:57:28'),
(74, 'HFSCC23', 'Sabiha sanabil', NULL, NULL, '2008-04-20', 'Female', NULL, 0, '', 'Drawing', 'Teacher', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 281296262308, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '6th STD', 'null', 'null', 'null', NULL, 'null', '23', '', '', NULL, '', 0, 'P-23', '', '', '', 0, 'Sabiha sanabi;l', '2008-04-20', 1, '2019-06-11 12:31:06', '2019-06-25 11:13:28'),
(75, 'HFSCC23', 'Mohammad Faizan Salik', NULL, NULL, '2015-10-20', 'Male', NULL, 0, '', 'Drawing', 'Teacher', 'Alive', NULL, NULL, NULL, NULL, 'Son', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 633220203764, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', 'LKG', 'null', 'null', 'null', NULL, 'null', '23', '', '', NULL, '', 0, 'P-23', '', '', '', 0, 'Mohammad Faizan Salik', '2015-10-20', 1, '2019-06-11 12:33:14', '2019-06-25 11:14:54'),
(76, 'HFSCC25', 'Nebisa', NULL, NULL, '1975-10-10', 'Female', 8971869486, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', '-', 'Rolling Beedi', 'MNG14115087', NULL, 808489817754, NULL, '2013-10-10', 'Not Separated', 'Abandoned', 7000, 'Rolling Beedi', 'Good', '-', 'None', 'Yes', 'Free House, Free water Supply, Monthly Ration, Self - help Group.', NULL, 'She is happy and leading better life.', '25', '', '', NULL, '', 0, 'P-25', 'Kinya', 'Karnataka', 'Natekal', 574150, 'Nebisa', '1975-10-10', 1, '2019-06-12 04:12:51', '2019-06-12 11:56:11'),
(77, 'HFSCC25', 'Sabeena Banu', NULL, NULL, '1996-11-24', 'Female', 8971637636, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Rolling Beedi', NULL, NULL, 236524086004, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '1st PUC', 'null', 'null', 'null', NULL, 'null', '25', '', '', NULL, '', 0, 'P-25', '', '', '', 0, 'Sabeena Banu', '1996-11-24', 1, '2019-06-12 04:24:18', '2019-06-12 11:58:10'),
(78, 'HFSCC25', 'Yasmeen', NULL, NULL, '2000-05-31', 'Female', NULL, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'Married', NULL, 'Housewife', NULL, NULL, 339185693093, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '2nd PUC, Islamic Study course.', 'null', 'null', 'null', NULL, 'null', '25', '', '', NULL, '', 0, 'P-25', '', '', '', 0, 'Yasmeen', '2000-05-31', 1, '2019-06-12 04:28:11', '2019-06-12 11:59:43'),
(79, 'HFSCC25', 'Mahammad sapanulla (Safwan)', NULL, NULL, '1998-06-03', 'Male', NULL, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Son', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Coolie', NULL, NULL, 636407211657, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', 'ITI (2nd Year)', 'null', 'null', 'null', NULL, 'null', '25', '', '', NULL, '', 0, 'P-25', '', '', '', 0, 'Mahammad sapanulla (Safwan)', '1998-06-03', 1, '2019-06-12 04:30:37', '2019-06-12 11:55:31'),
(80, 'HFSCC25', 'Munaf', NULL, NULL, '2008-05-04', 'Male', NULL, 0, '', 'Writing', 'Doctor', 'Alive', NULL, NULL, NULL, NULL, 'Son', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 315197294073, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '6th STD', 'null', 'null', 'null', NULL, 'null', '25', '', '', NULL, '', 0, 'P-25', '', '', '', 0, 'Munaf', '2008-05-04', 1, '2019-06-12 04:39:08', '2019-06-25 11:19:53'),
(81, 'HFSCC26', 'Avvamma', NULL, NULL, '1962-01-01', 'Female', 8150826822, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', 'Medical Treatments (Diabetes)', 'Rolling beedi', 'BLT14114975', NULL, 663484199748, NULL, '2015-12-16', 'Expired', 'Widowed', 5000, 'Rolling Beedi', 'Diabetes', 'None', 'None', 'Yes', 'Free House, Free water Supply, Monthly Ration, Self - help Group.', NULL, 'She is happy And Leading Better life. Also worried for Son\'s health.', '26', '', '', NULL, '', 0, 'P-26', 'Maddadka', 'Karnataka', 'Maddadka', 574224, 'Avvamma', '1962-01-01', 1, '2019-06-12 05:20:48', '2019-06-12 12:02:28'),
(82, 'HFSCC26', 'Mahammad Azaruddeen', NULL, NULL, '1999-12-15', 'Male', NULL, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Son', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Coolie', NULL, NULL, 965877049848, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Stuttering, Blurred Vision.', '10th', 'null', 'null', 'null', NULL, 'null', '26', '', '', NULL, '', 0, 'P-26', '', '', '', 0, 'Mahammad Azaruddeen', '1999-12-15', 1, '2019-06-12 06:02:44', '2019-06-12 12:00:35'),
(83, 'HFSCC25', 'Safreena', NULL, NULL, '2002-01-01', 'Female', NULL, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Tailor', NULL, NULL, 0, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '8th STD', 'null', 'null', 'null', NULL, 'null', '25', '', '', NULL, '', 0, 'P-25', '', '', '', 0, 'Safreena', '2002-01-01', 1, '2019-06-12 06:08:34', '2019-06-12 12:01:27'),
(84, 'HFSCC25', 'Muzammil', NULL, NULL, '2003-09-19', 'Male', NULL, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Son', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Coolie', NULL, NULL, 324414060605, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '9th STD', 'null', 'null', 'null', NULL, 'null', '25', '', '', NULL, '', 0, 'P-25', '', '', '', 0, 'Muzammil', '2003-09-19', 1, '2019-06-12 06:36:37', NULL),
(85, 'HFSCC25', 'Mufeed', NULL, NULL, '2010-12-20', 'Male', NULL, 0, '', 'Singing', 'Driver', 'Alive', NULL, NULL, NULL, NULL, 'Son', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, NULL, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '3rd STD', 'null', 'null', 'null', NULL, 'null', '25', '', '', NULL, '', 0, 'P-25', '', '', '', 0, 'Mufeed', '2010-12-20', 1, '2019-06-12 06:42:57', '2019-06-22 12:19:21'),
(86, 'HFSCC27', 'Ayisha', NULL, NULL, '1980-01-28', 'Female', 7996976203, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', '-', 'Working', '110200142723', NULL, 732689243878, NULL, '2016-05-17', 'Expired', 'Widowed', 5000, 'Working as Aya at Hidayah Special need center', 'Breathing Problem', '4th STD', 'None', 'Yes', 'Free House, Free water supply, Monthly Ration, Self -help group.', NULL, 'She is Happy and feeling secured for children\'s life.', '27', '', '', NULL, '', 0, 'P-27', 'Sajipa', 'Karnataka', 'Bantwal', 574231, 'Ayisha', '1980-01-28', 1, '2019-06-12 07:06:14', '2019-06-12 12:48:12'),
(87, 'HFSCC27', 'Fathimath Naziya', NULL, NULL, '2011-09-17', 'Female', NULL, 0, '', 'Dancing', 'Doctor', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 472023697325, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '3rd STD', 'null', 'null', 'null', NULL, 'null', '27', '', '', NULL, '', 0, 'P-27', '', '', '', 0, 'fathimath Naziya', '2011-09-17', 1, '2019-06-12 07:10:14', '2019-06-21 20:49:09'),
(88, 'HFSCC27', 'Fathima', NULL, NULL, '2014-05-15', 'Female', NULL, 0, '', 'Drawing', 'Teacher', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 672874811318, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', 'UKG', 'null', 'null', 'null', NULL, 'null', '27', '', '', NULL, '', 0, 'P-27', '', '', '', 0, 'Fathima', '2014-05-15', 1, '2019-06-12 07:13:44', '2019-06-21 20:47:22'),
(89, 'HFSCC28', 'P- Isabi', NULL, NULL, '1981-06-01', 'Female', 9632655456, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', '-', 'Cook', '110200219511', NULL, 706665026553, NULL, '2013-04-15', 'He was not Taking care of her and children\'s. he has extra marital affairs.', 'Domestic Violence', 7000, 'Working as a cook in Hidayah Special need center', 'Good', '7th', 'Rented', 'Yes', 'Free House, Free Water Supply,Free Monthly Ration ,Self- help Group.', NULL, 'She is happy And leading better life.', '28', '', '', NULL, '', 0, 'P-28', 'Harihara', 'Karnataka', 'Davanagere', 577601, 'P- Isabi', '1981-06-01', 1, '2019-06-12 07:31:21', '2019-06-12 13:16:37'),
(90, 'HFSCC28', 'Ahmad Zainuddeen', NULL, NULL, '1997-07-01', 'Female', NULL, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Son', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Coolie', NULL, NULL, NULL, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', 'PUC', 'null', 'null', 'null', NULL, 'null', '28', '', '', NULL, '', 0, 'P-28', '', '', '', 0, 'Ahmad Zainuddeen', '1997-07-01', 1, '2019-06-12 07:39:14', NULL),
(91, 'HFSCC28', 'Fathima', NULL, NULL, '2012-12-11', 'Female', NULL, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 371066139315, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '4th STD', 'null', 'null', 'null', NULL, 'null', '28', '', '', NULL, '', 0, '28', '-', '-', '-', 577601, 'Fathima', '2012-12-11', 1, '2019-06-12 07:50:27', NULL),
(92, 'HFSCC30', 'Zeenath', NULL, NULL, '1980-01-01', 'Female', 9880219161, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', '-', 'Rolling beedi', '110200140118', NULL, 946131093103, NULL, '2014-04-01', 'Not separated', '-', 7000, '6000', 'Good', '7th', 'Rented', 'Yes', 'free House, Free water Supply, Monthly ration, Self- help group. Providing  Medical treatments for h', NULL, 'She is happy for children\'s life, And worried About  husband health Problem.', '30', '', '', NULL, '', 0, 'P-30', 'Ujire', 'Karnataka', 'Belthangady', 574240, 'Zeenath', '1980-01-01', 1, '2019-06-12 08:07:46', '2019-06-12 14:14:32'),
(93, 'HFSCC30', 'B. P Ibrahim', NULL, NULL, '1969-01-01', 'Male', 9945962687, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Father', 'Member', 'HSCC', '', 'Married', NULL, '-', NULL, NULL, 808137096281, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Kidney and Heart Problem', '7th STD', 'null', 'null', 'null', NULL, 'null', '30', '', '', NULL, '', 0, 'P-30', '', '', '', 0, 'B. P Ibrahim', '1969-01-01', 1, '2019-06-12 08:41:58', NULL),
(94, 'HFSCC30', 'Mohammad Imthiyaz', NULL, NULL, '2004-04-30', 'Male', NULL, 0, '', 'Drawing', 'Doctor', 'Alive', NULL, NULL, NULL, NULL, 'Son', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 641878081224, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '10th STD', 'null', 'null', 'null', NULL, 'null', '30', '', '', NULL, '', 0, 'P-30', '', '', '', 0, 'Mohammad Imthiyaz', '2004-04-30', 1, '2019-06-12 08:50:06', '2019-06-25 14:47:05'),
(95, 'HFSCC30', 'Mohammad Ejaz', NULL, NULL, '2008-06-06', 'Male', NULL, 0, '', 'Drawing', 'Teacher', 'Alive', NULL, NULL, NULL, NULL, 'Son', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 378700118701, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '6th STD', 'null', 'null', 'null', NULL, 'null', '30', '', '', NULL, '', 0, 'P-30', '', '', '', 0, 'Mohammad Ejaz', '2008-06-06', 1, '2019-06-12 08:54:03', '2019-06-25 14:47:58'),
(96, 'HFSCC30', 'Shainaz', NULL, NULL, '2011-03-04', 'Female', NULL, 0, '', 'Reading', 'Teacher', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 353537727964, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '4th STD', 'null', 'null', 'null', NULL, 'null', '30', '', '', NULL, '', 0, 'P-30', '', '', '', 0, 'Shainaz', '2011-03-04', 1, '2019-06-12 08:56:23', '2019-06-25 14:52:56'),
(97, 'HFSCC29', 'Raziya', NULL, NULL, '1987-05-01', 'Female', 6364373134, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', '-', 'Rolling Beedi', 'BTLR00109197', NULL, 455853515971, NULL, '2018-12-01', 'he is an drug addicted person,  He Used to torture her,', 'Domestic Violence', 7000, 'Rolling beedi', 'Good', '7th STD', 'Owned', 'Yes', 'Free House, Free water supply, Free Monthly  Ration, Self - Help Group.', NULL, 'She is happy for Children\'s. She also Leading better life.', '29', '', '', NULL, '', 0, 'P-29', 'Karvel', 'Karnataka', 'Perne.', 574241, 'Raziya', '1987-05-01', 1, '2019-06-12 09:15:26', NULL),
(98, 'HFSCC29', 'Fathimath Nishana', NULL, NULL, '2008-03-29', 'Female', NULL, 0, '', 'Drawing,  reading Story books.', 'Teacher', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 833434475074, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '8th sTD', 'null', 'null', 'null', NULL, 'null', '29', '', '', NULL, '', 0, 'P-29', '', '', '', 0, 'Fathimath Nishana', '2008-03-29', 1, '2019-06-12 09:18:31', '2019-06-22 20:39:02'),
(99, 'HFSCC29', 'Nash Fana', NULL, NULL, '2010-12-27', 'Female', NULL, 0, '', 'Drawing', 'Doctor', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 292956463761, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '4th STD', 'null', 'null', 'null', NULL, 'null', '29', '', '', NULL, '', 0, 'P-29', '', '', '', 0, 'Nash Fana', '2010-12-27', 1, '2019-06-12 09:23:35', '2019-06-21 22:37:10'),
(100, 'HFSCC29', 'Ayishath Neeha', NULL, NULL, '2014-08-09', 'Female', NULL, 0, '', 'Dancing', 'Doctor', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 953392204440, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', 'LKg', 'null', 'null', 'null', NULL, 'null', '29', '', '', NULL, '', 0, 'P-29', '', '', '', 0, 'Ayishath Neeha', '2014-08-09', 1, '2019-06-12 09:31:02', '2019-06-21 22:35:29');
INSERT INTO `families_models` (`id`, `hfId`, `full_name`, `lname`, `image`, `dob`, `gender`, `mobile`, `phone`, `email`, `hobbies`, `goal`, `living`, `birth_place`, `nationality`, `relegion`, `mother_tongue`, `relation`, `role`, `category`, `related_category`, `marital_status`, `helps`, `occupation`, `ration_no`, `ration_image`, `adhar_no`, `adhar_image`, `dojHSCC`, `reason`, `familial`, `income`, `income_source`, `healthstatus`, `qualification`, `shelter`, `selfReliant`, `services`, `blood_group`, `presentStatus`, `presentFamilyDoor`, `present_street`, `present_city`, `district`, `present_state`, `present_pincode`, `previousFamilyDoor`, `previousStreet`, `previousState`, `previousCity`, `previousPin`, `user_name`, `password`, `status`, `created_at`, `updated_at`) VALUES
(101, 'HFSCC31', 'Rahmath', NULL, NULL, '1975-01-01', 'Female', 9902546980, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', '-', 'Rolling Beedi', 'BtlR00121879', NULL, 600374746906, NULL, '2015-04-10', 'Expired', 'Widowed', 6000, 'Rolling beedi', 'Breathing problem', '1st', 'None', 'Yes', 'Free House, Free Water Supply, Self- help group, Monthly Ration.', NULL, 'She is happy and leading better Life.', '31', '', '', NULL, '', 0, 'P-31', 'Karagatte, Ajjibettu', 'Karnataka', 'B.C road', 574324, 'Rahmath', '1975-01-01', 1, '2019-06-12 09:42:13', NULL),
(102, 'HFSCC31', 'Sajida Banu', NULL, NULL, '2007-08-27', 'Female', NULL, 0, '', 'Drawing', 'Teacher', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 263542500358, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '7th STD', 'null', 'null', 'null', NULL, 'null', '31', '', '', NULL, '', 0, 'P-31', '', '', '', 0, 'Sajida Banu', '2007-08-27', 1, '2019-06-12 09:49:52', '2019-06-25 15:00:59'),
(103, 'HFSCC31', 'Zeenath banu', NULL, NULL, '2006-05-27', 'Female', NULL, 0, '', 'Drawing', 'Teacher', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 648007393125, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '8th STD', 'null', 'null', 'null', NULL, 'null', '31', '', '', NULL, '', 0, 'P-31', '', '', '', 0, 'Zeenath banu', '2006-05-27', 1, '2019-06-12 09:59:09', '2019-06-25 15:02:11'),
(104, 'HFSCC32', 'Zohara', NULL, NULL, '1976-01-01', 'Female', 9164367417, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', '-', 'Beedi rolling', 'BTL24163740', NULL, 453896188229, NULL, '2015-05-01', 'Extra Marital status, Negligence towards Family.', 'Abandoned', 5000, 'Rolling beedi', 'Good', '-', 'None', 'Yes', 'Free House, Free Water Supply, Self- help group, Monthly Ration.', NULL, 'She is Happy and leading better life.', '32', '', '', NULL, '', 0, '15-363', 'B. Mooda', 'Karnataka', 'Bantwal', 574219, 'Zohara', '1976-01-01', 1, '2019-06-12 10:18:54', NULL),
(105, 'HFSCC32', 'Ayisha Anisa', NULL, NULL, '2012-01-16', 'Female', NULL, 0, '', 'Drawing', 'Teacher', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 816413400147, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '2nd STD', 'null', 'null', 'null', NULL, 'null', '32', '', '', NULL, '', 0, '32', '', '', '', 0, 'Ayisha Anisa', '2012-01-16', 1, '2019-06-12 10:30:12', '2019-06-25 15:21:03'),
(106, 'HFSCC33', 'Maimuna', NULL, NULL, '1980-03-04', 'Female', 8296840020, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', '-', 'Rolling beedi', '110200138768', NULL, 835276394663, NULL, '2016-04-10', 'Her husband is an alcoholic', 'Abandoned', 6000, 'Rolling beedi', 'Good', '2nd STD', 'None', 'Yes', 'Free House, Free Water Supply, Self- help group, Monthly Ration.', NULL, 'She is happy and leading better life.', '33', '', '', NULL, '', 0, 'P-33', 'Bengare', 'Karnataka', 'Mangalore', 575001, 'Maimuna', '1980-03-04', 1, '2019-06-12 10:42:51', '2019-06-13 10:41:44'),
(107, 'HFSCC33', 'Fathimathul Ramzeena', NULL, NULL, '2001-02-03', 'Female', NULL, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Tailor', NULL, NULL, 560366431238, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '10th', 'null', 'null', 'null', NULL, 'null', '33', '', '', NULL, '', 0, 'P-33', '', '', '', 0, 'Fathimathul Ramzeena', '2001-02-03', 1, '2019-06-12 10:51:45', '2019-06-12 17:21:56'),
(108, 'HFSCC33', 'Safnaz', NULL, NULL, '2002-09-15', 'Female', NULL, 0, '', 'Drawing', 'Engineer', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 900789146618, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '2nd PUC', 'null', 'null', 'null', NULL, 'null', '33', '', '', NULL, '', 0, 'P-33', '', '', '', 0, 'Safnaz', '2002-09-15', 1, '2019-06-12 10:58:20', '2019-06-25 15:17:16'),
(109, 'HFSCC33', 'Asfiya', NULL, NULL, '2006-09-21', 'Female', NULL, 0, '', 'Dancing,  singing', 'Doctor', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 276380194913, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '33', 'null', 'null', 'null', NULL, 'null', '33', '', '', NULL, '', 0, 'P-33', '', '', '', 0, 'Asfiya', '2006-09-21', 1, '2019-06-12 11:03:52', '2019-06-22 20:32:00'),
(110, 'HFSCC33', 'Ayishath Asriya', NULL, NULL, '2005-02-08', 'Female', NULL, 0, '', 'Reading', 'Teacher', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 363176677169, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '10th STD', 'null', 'null', 'null', NULL, 'null', '33', '', '', NULL, '', 0, 'P-33', '', '', '', 0, 'Ayishath Asriya', '2005-02-08', 1, '2019-06-13 05:40:42', '2019-06-22 12:57:13'),
(111, 'HFSCC34', 'Rukiya', NULL, NULL, '1973-01-01', 'Female', 9591345031, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', NULL, 'Rolling Beedi', NULL, NULL, 677231860599, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '3rd', 'null', 'null', 'null', NULL, 'null', '34', '', '', NULL, '', 0, 'P-34', '', '', '', 0, 'Rukiya', '1973-01-01', 1, '2019-06-13 06:01:45', '2019-06-13 15:45:53'),
(112, 'HFSCC34', 'Kamarunnisa', NULL, NULL, '1993-07-28', 'Female', NULL, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Tailor', NULL, NULL, 294950727176, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '7th STD', 'null', 'null', 'null', NULL, 'null', '34', '', '', NULL, '', 0, 'P-34', '', '', '', 0, 'Kamarunnisa', '1993-07-28', 1, '2019-06-13 07:58:00', NULL),
(113, 'HFSCC34', 'Sapnaz', NULL, NULL, '1998-01-01', 'Female', NULL, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Tailor', NULL, NULL, 642655800798, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '7th STD', 'null', 'null', 'null', NULL, 'null', '34', '', '', NULL, '', 0, 'P-34', '', '', '', 0, 'Sapnaz', '1998-01-01', 1, '2019-06-13 08:30:36', NULL),
(114, 'HFSCC35', 'Isamma', NULL, NULL, '1975-05-04', 'Female', 9164471724, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', NULL, 'Rolling beedi', '110200141051', NULL, 457226776414, NULL, '2014-01-01', 'Not separated', '-', 5000, 'Rolling beedi', 'Good', '-', 'None', 'Yes', 'Free house, Free water supply. Monthly Ration. Self - help Group.', NULL, 'She is happy and leading better life.', '35', '', '', NULL, '', 0, 'P-35', 'B C Road', 'Karnataka', 'Bantwal', 574219, 'Isamma', '1975-05-04', 1, '2019-06-13 10:05:42', NULL),
(115, 'HFSCC35', 'Fathimath Zohara', NULL, NULL, '2006-07-29', 'Female', NULL, 0, '', 'Reading', 'Teacher', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 622577082784, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '7th STD', 'null', 'null', 'null', NULL, 'null', '35', '', '', NULL, '', 0, 'P-35', '', '', '', 0, 'Fathimath Zakiya', '2006-07-29', 1, '2019-06-13 10:14:42', '2019-06-25 15:23:15'),
(116, 'HFSCC35', 'Mahammad', NULL, NULL, '1940-08-15', 'Male', NULL, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Father', 'Member', 'HSCC', '', 'Married', NULL, 'Beedi Rolling', NULL, NULL, 790834195613, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '-', 'null', 'null', 'null', NULL, 'null', '35', '', '', NULL, '', 0, 'P-35', '', '', '', 0, 'Mahammad', '1940-08-15', 1, '2019-06-13 11:15:01', NULL),
(117, 'HFSCC18', 'Fathimath Shameela', NULL, NULL, '2013-02-19', 'Female', NULL, 0, '', 'Dancing', 'Teacher', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, NULL, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '1st STD', 'null', 'null', 'null', NULL, 'null', '18', '', '', NULL, '', 0, 'P-18', '', '', '', 0, 'Fathimath Shameela', '2013-02-19', 1, '2019-06-13 11:17:44', '2019-06-21 22:26:17'),
(118, 'HFSCC04', 'Muhammad Shakir', NULL, NULL, '1995-10-17', 'Male', NULL, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Son', 'Member', 'Workshop', '', 'UnMarried', NULL, 'Coolie', NULL, NULL, NULL, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '10th STD', 'null', 'null', 'null', NULL, 'null', '04', '', '', NULL, '', 0, 'P-04', '-', 'Karnataka', '-', NULL, 'Muhammad Shakir', '1995-10-17', 1, '2019-06-13 11:21:06', NULL),
(119, 'HFSCC04', 'Sabira', NULL, NULL, '1992-04-11', 'Female', NULL, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'Workshop', '', 'Married', NULL, 'House wife', NULL, NULL, NULL, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '8th', 'null', 'null', 'null', NULL, 'null', '04', '', '', NULL, '', 0, 'P-04', '', '', '', 0, 'Sabira', '1992-04-11', 1, '2019-06-13 11:23:21', NULL),
(120, 'HFSCC15', 'Syed Ali', NULL, NULL, '2018-04-20', 'Male', NULL, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Son', 'Member', 'HSCC', '', 'UnMarried', NULL, 'New born Baby', NULL, NULL, NULL, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '-', 'null', 'null', 'null', NULL, 'null', '15', '', '', NULL, '', 0, 'P-15', '', '', '', 0, 'Syed Ali', '2018-04-20', 1, '2019-06-13 11:27:04', NULL),
(121, 'HFSCC13', 'Mahammad Shahid', NULL, NULL, '2006-06-02', 'Male', NULL, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Son', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 653696829909, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '8th STD', 'null', 'null', 'null', NULL, 'null', '33', '', '', NULL, '', 0, 'P-33', '', '', '', 0, 'Mahammad Shahid', '2006-06-02', 1, '2019-06-13 11:54:20', '2019-06-22 22:23:34'),
(122, 'HFSCC36', 'Mahammad Irshad', NULL, NULL, '2001-10-04', 'Male', NULL, 0, '', 'Reading', 'Engineer', 'Alive', NULL, NULL, NULL, NULL, 'Son', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Working at Bangalore', NULL, NULL, 464136062683, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '10th', 'null', 'null', 'null', NULL, 'null', '36', '', '', NULL, '', 0, 'P-36', '', '', '', 0, 'Mahammad Irshad', '2001-10-04', 1, '2019-06-14 11:26:58', '2019-06-25 15:27:22'),
(123, 'HFSCC36', 'Shameema', NULL, NULL, '1983-01-01', 'Female', 9901223124, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', '-', 'Rolling beedi', '110100130604', NULL, 506480184461, NULL, '2013-11-10', 'he is not Taking care of her, he has extra marital status affair.', 'Abandoned', 6000, 'Rolling beedi', 'Good', '4th', 'None', 'Yes', 'Free house, Free monthly ration, Free  water supply,self - help group.', NULL, 'she is happy and leading better life.', '36', '', '', NULL, '', 0, 'P-36', NULL, NULL, NULL, 0, 'Shameema', '1983-01-01', 1, '2019-06-14 11:47:55', '2019-06-22 20:10:31'),
(124, 'HFSCC36', 'Inthiyaz', NULL, NULL, '2006-08-11', 'Male', NULL, 0, '', 'Science model', 'Mechanical engineer', 'Alive', NULL, NULL, NULL, NULL, 'Son', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 224026466266, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '8th STD', 'null', 'null', 'null', NULL, 'null', '36', '', '', NULL, '', 0, 'P-36', '', '', '', 0, 'Inthiyaz', '2006-08-11', 1, '2019-06-14 11:54:26', '2019-06-22 20:24:14'),
(125, 'HFSCC37', 'Maimuna', NULL, NULL, '1978-06-12', 'Female', 9483129363, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', '-', 'Rolling beedi', '110100125890', NULL, 257611582814, NULL, '2019-01-23', 'Expired', 'Widowed', 6000, 'Rolling beedi', 'Good', '4th STD', 'None', 'Yes', 'Free house, free water supply, monthly ration, Self - help group.', NULL, 'She is happy and leading better life.', '37', '', '', NULL, '', 0, 'P-37', 'Shirlalu', 'Karnataka', 'Belthangady', 574217, 'Maimuna', '1978-06-12', 1, '2019-06-17 10:34:33', NULL),
(126, 'HFSCC37', 'Mahammad shafeeq', NULL, NULL, '2007-02-15', 'Male', NULL, 0, '', 'Dancing, Karate.', 'Engineer', 'Alive', NULL, NULL, NULL, NULL, 'Son', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 305784716043, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '7th', 'null', 'null', 'null', NULL, 'null', '37', '', '', NULL, '', 0, 'P-37', '', '', '', 0, 'Mahammad shafeeq', '2007-02-15', 1, '2019-06-17 10:40:23', '2019-06-22 20:42:34'),
(127, 'HFSCC37', 'Mahammad Shahik', NULL, NULL, '2005-11-13', 'Male', NULL, 0, '', 'Singer', 'Engineer', 'Alive', NULL, NULL, NULL, NULL, 'Son', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 408613570549, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '9th STD', 'null', 'null', 'null', NULL, 'null', '37', '', '', NULL, '', 0, 'P-37', '', '', '', 0, 'Mahammad Shahik', '2005-11-13', 1, '2019-06-17 10:56:00', '2019-06-22 12:55:40'),
(128, 'HFSCC37', 'Mahammad Asik', NULL, NULL, '2004-06-10', 'Male', NULL, 0, '', 'Reading', 'Engineer', 'Alive', NULL, NULL, NULL, NULL, 'Son', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 586053684057, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '10th STD', 'null', 'null', 'null', NULL, 'null', '37', '', '', NULL, '', 0, 'P-37', '', '', '', 0, 'Mahammad Asik', '2004-06-10', 1, '2019-06-17 11:12:35', '2019-06-25 15:36:16'),
(129, 'HFSCC39', 'Aathika', NULL, NULL, '1974-08-12', 'Female', 9591172494, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', '-', 'Rolling beedi', 'BTLR00127511', NULL, 990765573563, NULL, '2013-02-10', 'Expired', 'Widowed', 5000, 'Rolling beedi', 'Good', '5th STD', 'None', 'Yes', 'Free house, Monthly Ration, Free water supply, Self - help group.', NULL, 'She is happy and leading better life.', '39', '', '', NULL, '', 0, 'P-39', 'Punjalakatte', 'Karnataka', 'Punjalakatte', 574233, 'Aathika', '1974-08-12', 1, '2019-06-20 05:34:36', NULL),
(130, 'HFSCC39', 'Aashika', NULL, NULL, '2003-03-06', 'Female', NULL, 0, '', 'Helping the Poor', 'Doctor', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 453909511638, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '2nd PUC', 'null', 'null', 'null', NULL, 'null', '39', '', '', NULL, '', 0, 'P-39', '', '', '', 0, 'Aashika', '2003-03-06', 1, '2019-06-20 05:36:56', '2019-06-25 15:41:26'),
(131, 'HFSCC39', 'Jafar', NULL, NULL, '2004-01-23', 'Male', NULL, 0, '', 'Drawing', 'Military', 'Alive', NULL, NULL, NULL, NULL, 'Son', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 470519112942, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '10th STD', 'null', 'null', 'null', NULL, 'null', '39', '', '', NULL, '', 0, 'P-39', '', '', '', 0, 'Jafar', '2004-01-23', 1, '2019-06-20 05:39:39', '2019-06-22 12:41:05'),
(132, 'HFSCC40', 'Zohara', NULL, NULL, '1966-01-01', 'Female', 9663350779, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', '-', 'Gardener', 'BTLR00115493', NULL, 708349969879, NULL, '2013-04-06', 'Expired', 'Widowed', 5000, 'Working as a Gardener in HSCC', 'Good', '-', 'None', 'Yes', 'Free house, Monthly Ration, Free water supply, Self - help group.', NULL, 'Good, She  leading Happy Life.', '40', '', '', NULL, '', 0, 'P-40', 'Venooru', 'Karnataka', 'Venooru', 574242, 'Zohara', '1966-01-01', 1, '2019-06-20 05:49:42', NULL),
(133, 'HFSCC40', 'Naseema', NULL, NULL, '1997-11-18', 'Female', NULL, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'Married', NULL, 'Housewife', NULL, NULL, NULL, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '10th', 'null', 'null', 'null', NULL, 'null', '40', '', '', NULL, '', 0, 'P-40', '', '', '', 0, 'Naseema', '1997-11-18', 1, '2019-06-20 06:27:08', '2019-06-20 12:16:34'),
(134, 'HFSCC41', 'Aasyamma', NULL, NULL, '1968-01-01', 'Female', 9481143179, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', '-', '-', 'BTLR00118222', NULL, 249339385310, NULL, '2012-01-01', 'Expired', 'Widowed', 5000, '-', 'She is aged and have some health problems', '-', 'None', 'Yes', 'Free house, Monthly Ration, Free water supply, Self - help group.', NULL, 'She is happy.', '41', '', '', NULL, '', 0, 'P-41', 'Mavinakatte', 'Karnataka', 'Mavinakatte', 574324, 'Aasyamma', '1968-01-01', 1, '2019-06-20 06:43:23', NULL),
(135, 'HFSCC41', 'Saabira', NULL, NULL, '1991-06-02', 'Female', NULL, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'Married', NULL, 'Housewife', NULL, NULL, 923886269048, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '5th', 'null', 'null', 'null', NULL, 'null', '41', '', '', NULL, '', 0, 'P-41', '', '', '', 0, 'Saabira', '1991-06-02', 1, '2019-06-20 06:45:15', '2019-06-20 12:17:23'),
(136, 'HFSCC42', 'Mariyamma', NULL, NULL, '1984-01-01', 'Female', 9880919439, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', '-', 'Rolling beedi', 'BLTR00107436', NULL, 316999487772, NULL, '2013-05-01', 'Expired', 'Widowed', 5000, 'Rolling Beedi', 'Good', '-', 'None', 'Yes', 'Free house, Monthly Ration, Free water supply, Self - help group.', NULL, 'She is happy and leading better life.', '42', '', '', NULL, '', 0, 'P-42', 'Maaladi', 'Karnataka', 'Madanthyar', 574224, 'Mariyamma', '1984-01-01', 1, '2019-06-20 06:55:39', NULL),
(137, 'HFSCC43', 'Unhi', NULL, NULL, '1962-01-01', 'Female', 9901591743, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', '-', 'Worker', 'MNG14186243', NULL, 623987885943, NULL, '2018-12-14', 'Expired', 'Widowed', 5000, 'Working as aya at HSNC', 'Good', '-', 'None', 'Yes', 'Free house, Monthly Ration, Free water supply, Self - help group.', NULL, 'She is happy and leading better life.', '43', '', '', NULL, '', 0, '43', 'Mulara patna', 'Karnataka', 'Bantwal', 574211, 'Unhi', '1962-01-01', 1, '2019-06-20 07:04:24', NULL),
(138, 'HFSCC45', 'Jameela', NULL, NULL, '1976-06-01', 'Female', 7026157731, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', '-', 'Rolling beedi', NULL, NULL, 235346269257, NULL, '2018-04-26', 'Expired', 'Widowed', 5000, 'Rolling beedi', 'good', '-', 'None', 'Yes', 'Free house, Monthly Ration, Free water supply, Self - help group.', NULL, 'Happy and leading better life', '45', '', '', NULL, '', 0, 'P-45', 'Badyar', 'Karnataka', 'Uppinangady', 574326, 'Jameela', '1976-06-01', 1, '2019-06-20 07:24:32', NULL),
(139, 'HFSCC44', 'Salika', NULL, NULL, '1983-01-01', 'Female', 9591355689, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Mother', 'Head', 'HSCC', '', 'Married', 'Treatment for health issues', '-', 'BTL24163123', NULL, 390234730747, NULL, '2019-05-09', 'He is an Alcoholic , he was not taken care of her, Also he had extra marital status.', 'Domestic Violence', 5000, '-', 'unhealthy.', '-', 'None', 'Yes', 'Free house, Monthly Ration, Free water supply, Self - help group.', NULL, 'She is happy with her child, and leading better life.', '44', '', '', NULL, '', 0, 'P-44', 'Goodina bali', 'Karnataka', 'B. C Road', 574219, 'Salika', '1983-01-01', 1, '2019-06-20 07:36:30', NULL),
(140, 'HFSCC22', 'Husssain Shafi', NULL, NULL, '1949-01-01', 'Male', 8861513086, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'HeadFather', 'Member', 'HSCC', '', 'Married', NULL, '-', NULL, NULL, 458192318117, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '-', 'null', 'null', 'null', NULL, 'null', '22', '', '', NULL, '', 0, 'P-22', '', '', '', 0, 'Husssain Shafi', '1949-01-01', 1, '2019-06-20 07:54:49', NULL),
(141, 'HFSCC22', 'Beepathumma', NULL, NULL, '1966-01-01', 'Female', NULL, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'HeadMother', 'Member', 'HSCC', '', 'Married', NULL, 'Rolling Beedi', NULL, NULL, 847131994714, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '-', 'null', 'null', 'null', NULL, 'null', '22', '', '', NULL, '', 0, 'P-22', '', '', '', 0, 'Beepathumma', '1966-01-01', 1, '2019-06-20 07:56:34', NULL),
(142, 'HFSCC45', 'Fathimathul Naziya', NULL, NULL, '2009-04-15', 'Female', NULL, 0, '', 'reading', 'Doctor', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 202645018521, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '6th STD', 'null', 'null', 'null', NULL, 'null', '45', '', '', NULL, '', 0, 'P-45', '', '', '', 0, 'Fathimathul Naziya', '2009-04-15', 1, '2019-06-20 08:27:59', '2019-06-25 15:54:49'),
(143, 'HFSCC44', 'Muhammad Nihal', NULL, NULL, '2007-04-03', 'Male', NULL, 0, '', 'Cricket', 'Teacher', 'Alive', NULL, NULL, NULL, NULL, 'Son', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 479772919190, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '8th  STD', 'null', 'null', 'null', NULL, 'null', '44', '', '', NULL, '', 0, 'P-44', '', '', '', 0, 'Muhammad Nihal', '2007-04-03', 1, '2019-06-21 12:00:46', '2019-06-25 15:53:21'),
(144, 'HFSCC29', 'Twaiba', NULL, NULL, '2017-07-24', 'Female', NULL, 0, '', '-', '-', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, '-', NULL, NULL, NULL, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '-', 'null', 'null', 'null', NULL, 'null', '29', '', '', NULL, '', 0, 'P-29', '', '', '', 0, 'Twaiba', '2017-07-24', 1, '2019-06-22 05:39:30', NULL),
(145, 'HFSCC21', 'Shanvaz', NULL, NULL, '2008-04-08', 'Male', NULL, 0, '', 'Playing', 'Engineer', 'Alive', NULL, NULL, NULL, NULL, 'Son', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 957631042461, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '6th STD', 'null', 'null', 'null', NULL, 'null', '21', '', '', NULL, '', 0, 'P-21', '', '', '', 0, 'Shanvaz', '2008-04-08', 1, '2019-06-22 15:22:07', '2019-06-22 22:49:00'),
(146, 'HFSCC42', 'Fathimath Sameena', NULL, NULL, '2005-06-06', 'Female', NULL, 0, '', 'Writing', 'Teacher', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'HSCC', '', 'UnMarried', NULL, 'Student', NULL, NULL, 565535140798, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '9th STD', 'null', 'null', 'null', NULL, 'null', '42', '', '', NULL, '', 0, 'P-42', '', '', '', 0, 'Fathimath Sameena', '2005-06-06', 1, '2019-06-23 10:03:53', NULL),
(149, 'HFMR28', 'Ahmad Zainuddeen', NULL, NULL, '1997-07-01', 'Female', NULL, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Son', 'Member', 'MR', '', 'UnMarried', NULL, 'Coolie', NULL, NULL, NULL, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', 'PUC', 'null', 'null', 'null', NULL, 'null', '28', '', '', NULL, '', 0, 'P-28', '', '', '', 0, 'Ahmad Zainuddeen', '1997-07-01', 1, '2019-06-12 07:39:14', NULL),
(150, 'HFMR28', 'Fathima', NULL, NULL, '2012-12-11', 'Female', NULL, 0, '', NULL, NULL, 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'MR', '', 'UnMarried', NULL, 'Student', NULL, NULL, 371066139315, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '4th STD', 'null', 'null', 'null', NULL, 'null', '28', '', '', NULL, '', 0, '28', '-', '-', '-', 577601, 'Fathima', '2012-12-11', 1, '2019-06-12 07:50:27', NULL),
(151, 'HFODB29', 'Fathimath Nishana', NULL, NULL, '2008-03-29', 'Female', NULL, 0, '', 'Drawing,  reading Story books.', 'Teacher', 'Alive', NULL, NULL, NULL, NULL, 'Daughter', 'Member', 'Database', '', 'UnMarried', NULL, 'Student', NULL, NULL, 833434423074, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '8th sTD', 'null', 'null', 'null', NULL, 'null', '29', '', '', NULL, '', 0, 'P-29', '', '', '', 0, 'Fathimath Nishana', '2008-03-29', 1, '2019-06-12 09:18:31', '2019-06-22 20:39:02'),
(153, 'HFOWS22', 'Syed Abrar', NULL, NULL, '2007-04-05', 'Male', NULL, 0, '', 'Cricket', 'Military', 'Alive', NULL, NULL, NULL, NULL, 'Son', 'Member', 'Workshop', '', 'UnMarried', NULL, 'Student', NULL, NULL, 337295050425, NULL, '0000-00-00', 'null', 'null', NULL, 'null', 'Good', '10th STD', 'null', 'null', 'null', NULL, 'null', '22', '', '', NULL, '', 0, 'P-22', '', '', '', 0, 'Syed Abrar', '2007-04-05', 1, '2019-06-11 10:59:14', '2019-06-22 11:22:18'),
(155, 'HFSCC01', 'ATHIKA', NULL, NULL, NULL, 'Female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'INDIAN', 'MUSLIM', 'BEARY', 'Mother', 'Member', 'ATT', '', 'Married', NULL, 'HOUSE WIFE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'A.RAHMAN MANZIL, JALAL BAGH DERALAKATTE MANGALORE', NULL, NULL, NULL, 575018, NULL, NULL, NULL, NULL, NULL, 'ATHIKA', 'HFSCC01', 1, NULL, '2019-09-09 09:59:21'),
(156, 'HFSCC01', 'Fathima kamshida', NULL, NULL, '2000-12-04', 'Male', 9902240819, NULL, '', NULL, NULL, NULL, 'MANGALURU', 'INDIAN', 'MUSLIM', 'BEARY', 'Son', 'Member', 'ATT', '', 'Single', NULL, 'Student', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'A.RAHMAN MANZIL, JALAL BAGH DERALAKATTE MANGALORE', 'MANGALURU', 'Dakshin Kannada', 'Karnataka', 575018, NULL, NULL, NULL, NULL, NULL, '', '2000-12-04', 1, NULL, '2019-09-09 09:59:21'),
(161, 'HFSCC01', 'ASMA HASANABBA', NULL, NULL, NULL, 'Female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'INDIAN', 'MUSLIM', 'BEARY', 'Mother', 'Member', 'ATT', '', 'Married', NULL, 'HOUSE WIFE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'KORAS COLONY, B/H PANDIRAJ BALLAL, HOSPITAL, MUKKACHERY, ULLAL MANGALORE', NULL, NULL, NULL, 575020, NULL, NULL, NULL, NULL, NULL, 'ASMA HASANABBA', 'HFSCC01', 1, NULL, '2019-09-09 11:30:04'),
(162, 'HFSCC01', 'RDERDERDE', NULL, NULL, NULL, 'Male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'INDIAN', 'MUSLIM', 'BEARY', 'Husband', 'Member', 'ATT', '', 'Married', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'KORAS COLONY, B/H PANDIRAJ BALLAL, HOSPITAL, MUKKACHERY, ULLAL MANGALORE', NULL, NULL, NULL, 575020, NULL, NULL, NULL, NULL, NULL, 'RDERDERDE', 'HFSCC01', 1, NULL, '2019-09-09 11:30:04'),
(163, 'HFSCC01', 'M. ABDUL RAHEEM', NULL, NULL, NULL, 'Male', 9845875093, NULL, NULL, NULL, NULL, NULL, NULL, 'INDIAN', 'MUSLIM', 'BEARY', 'Guardian', 'Member', 'ATT', '', 'Married', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'OPP, STATE BANK OF INDIA, MASTIKATTE, ULLAL, MANGALORE', NULL, NULL, NULL, 575020, NULL, NULL, NULL, NULL, NULL, 'M. ABDUL RAHEEM', 'HFSCC01', 1, NULL, '2019-09-09 11:30:04'),
(164, 'HFSCC01', 'FATHIMA SANA', NULL, NULL, '2000-08-09', 'Female', 8971778715, 9110225229, 'asmahasannabba5245@gmail.com', NULL, NULL, NULL, 'ULLAL', 'INDIAN', 'MUSLIM', 'BEARY', 'Daughter', 'Member', 'ATT', '', 'Single', NULL, 'Student', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2nd PU', NULL, NULL, NULL, NULL, NULL, NULL, 'KORAS COLONY, B/H PANDIRAJ BALLAL, HOSPITAL, MUKKACHERY, ULLAL MANGALORE', 'MANGALORE', 'Dakshin Kannada', 'Karnataka', 575020, NULL, NULL, NULL, NULL, NULL, 'asmahasannabba5245@gmail.com', '2000-08-09', 1, NULL, '2019-09-09 11:30:04'),
(165, 'HFATT03', 'SHAMEEMA', NULL, NULL, NULL, 'Female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'INDIAN', 'MUSLIM', 'BEARY', 'Mother', 'Member', 'ATT', '', 'Married', NULL, 'HOUSE WIFE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NEAR KONCHAR MOSQUE, BAJPE MANGALORE', NULL, NULL, NULL, 574142, NULL, NULL, NULL, NULL, NULL, 'SHAMEEMA', 'HFATT03', 1, NULL, '2019-09-09 11:54:11'),
(166, 'HFATT03', 'KHATHIJA AFROZA', NULL, NULL, '2000-12-28', 'Female', 9113214909, NULL, '', NULL, NULL, NULL, 'SURATHKAL', 'INDIAN', 'MUSLIM', 'BEARY', 'Daughter', 'Member', 'ATT', '', 'Single', NULL, 'Student', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2nd PU', NULL, NULL, NULL, NULL, NULL, NULL, 'NEAR KONCHAR MOSQUE, BAJPE MANGALORE', 'MANGALORE', 'Dakshin Kannada', 'Karnataka', 574142, NULL, NULL, NULL, NULL, NULL, '', '2000-12-28', 1, NULL, '2019-09-09 11:54:11'),
(167, 'HFATT04', 'SAIDA BANU', NULL, NULL, NULL, 'Female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'INDIAN', 'MUSLIM', 'URDU', 'Mother', 'Member', 'ATT', '', 'Married', NULL, 'HOUSE WIFE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ABDUL SHAKUR L.I.G 5 BONDEL POST KAVOOR', NULL, NULL, NULL, 5750015, NULL, NULL, NULL, NULL, NULL, 'SAIDA BANU', 'HFATT04', 1, NULL, '2019-09-09 12:07:07'),
(168, 'HFATT04', 'ARSHIYA', NULL, NULL, '2000-03-24', 'Female', 9945902920, 9980431353, '', NULL, NULL, NULL, 'MANGALURU', 'INDIAN', 'MUSLIM', 'URDU', 'Daughter', 'Member', 'ATT', '', 'Single', NULL, 'Student', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2nd PU', NULL, NULL, NULL, NULL, NULL, NULL, 'ABDUL SHAKUR L.I.G 5 BONDEL POST KAVOOR', 'MANGALORE', 'Dakshin Kannada', 'Karnataka', 5750015, NULL, NULL, NULL, NULL, NULL, '', '2000-03-24', 1, NULL, '2019-09-09 12:07:07'),
(169, 'HFATT05', 'HAFSA', NULL, NULL, NULL, 'Female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'INDIAN', 'MUSLIM', 'BEARY', 'Mother', 'Member', 'ATT', '', 'Married', NULL, 'HOUSE WIFE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'HAFSA MANZIL, ARKULA-VALACHIL, PARANGIPETE', NULL, NULL, NULL, 574151, NULL, NULL, NULL, NULL, NULL, 'HAFSA', 'HFATT05', 1, NULL, '2019-09-10 06:20:09'),
(170, 'HFATT05', 'RAFHA JAMEELA', NULL, NULL, '2001-05-21', 'Female', 8867939165, NULL, '', NULL, NULL, NULL, 'BHAT\'s NURSING GANDHINAGAR', 'INDIAN', 'MUSLIM', 'BEARY', 'Daughter', 'Member', 'ATT', '', 'Single', NULL, 'Student', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2nd PU', NULL, NULL, NULL, NULL, NULL, NULL, 'HAFSA MANZIL, ARKULA-VALACHIL, PARANGIPETE', 'MANGALORE', 'Dakshin Kannada', 'Karnataka', 574151, NULL, NULL, NULL, NULL, NULL, '', '2001-05-21', 1, NULL, '2019-09-10 06:20:09'),
(171, 'HFATT06', 'FATHIMA NASRATH', NULL, NULL, NULL, 'Female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'INDIAN', 'MUSLIM', 'BEARY', 'Mother', 'Member', 'ATT', '', 'Married', NULL, 'HOUSE WIFE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'AROMA RESIDENCY, 1st FLOOR KAIKAMBA B.C ROAD BANTWAL', NULL, NULL, NULL, 574219, NULL, NULL, NULL, NULL, NULL, 'FATHIMA NASRATH', 'HFATT06', 1, NULL, '2019-09-10 06:56:07'),
(172, 'HFATT06', 'NAIMA ZULAIKA', NULL, NULL, '2000-10-26', 'Female', 9964865175, NULL, '', NULL, NULL, NULL, 'MANGALORE', 'INDIAN', 'MUSLIM', 'BEARY', 'Daughter', 'Member', 'ATT', '', 'Single', NULL, 'Student', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'AROMA RESIDENCY, 1st FLOOR KAIKAMBA B.C ROAD BANTWAL', 'MANGALORE', 'Dakshin Kannada', 'Karnataka', 574219, NULL, NULL, NULL, NULL, NULL, '', '2000-10-26', 1, NULL, '2019-09-10 06:56:07'),
(173, 'HFATT07', 'ASMATH', NULL, NULL, NULL, 'Female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Indian', 'MUSLIM', 'BEARY', 'Mother', 'Member', 'ATT', '', 'Married', NULL, 'HOUSE WIFE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'MANGALA NAGARA KUDUPU POST VAMANJOOR MANGALORE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ASMATH', 'HFATT07', 1, NULL, '2019-09-10 07:04:36'),
(174, 'HFATT07', 'SHAFA FARVEEN', NULL, NULL, '2000-03-02', 'Female', 8746036709, NULL, '', NULL, NULL, NULL, 'MANGALORE', 'Indian', 'MUSLIM', 'BEARY', 'Daughter', 'Member', 'ATT', '', 'Single', NULL, 'Student', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2nd pu', NULL, NULL, NULL, NULL, NULL, NULL, 'MANGALA NAGARA KUDUPU POST VAMANJOOR MANGALORE', 'MANGALORE', 'Dakshin Kannada', 'Karnataka', NULL, NULL, NULL, NULL, NULL, NULL, '', '2000-03-02', 1, NULL, '2019-09-10 07:04:36'),
(175, 'HFATT08', 'B. FATHIMA', NULL, NULL, NULL, 'Female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'INDIAN', 'MUSLIM', 'BEARY', 'Mother', 'Member', 'ATT', NULL, 'Married', NULL, 'HOUSE WIFE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DIAMOND BEACH RESIDENCY 1st FLOOOR D.NO 105 BASTI[ADPU ULLAL', NULL, NULL, NULL, 575020, NULL, NULL, NULL, NULL, NULL, 'B. FATHIMA', 'HFATT08', 1, NULL, '2019-09-10 07:11:41'),
(176, 'HFATT08', 'FATHIMA SAFANA', NULL, NULL, '2000-09-25', 'Female', 9844689912, NULL, '', NULL, NULL, NULL, 'ULLAL MANGALORE', 'INDIAN', 'MUSLIM', 'BEARY', 'Daughter', 'Member', 'ATT', NULL, 'Single', NULL, 'Student', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2nd PU', NULL, NULL, NULL, NULL, NULL, NULL, 'DIAMOND BEACH RESIDENCY 1st FLOOOR D.NO 105 BASTI[ADPU ULLAL', 'MANGALORE', 'Dakshin Kannada', 'Karnataka', 575020, NULL, NULL, NULL, NULL, NULL, '', '2000-09-25', 1, NULL, '2019-09-10 07:11:41'),
(177, 'HFATT09', 'ASMATH', NULL, NULL, NULL, 'Female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'INDIAN', 'MUSLIM', 'BEARY', 'Mother', 'Member', 'ATT', NULL, 'Married', NULL, 'HOUSE WIFE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1-6A DELUX MANZIL, SHANTI BAGH, MUNDOLI, KUTTAR DERALAKATTE POST, SOMESHWAR VILLAGE, MANGALORE', NULL, NULL, NULL, 575018, NULL, NULL, NULL, NULL, NULL, 'ASMATH', 'HFATT09', 1, NULL, '2019-09-10 07:16:49'),
(178, 'HFATT09', 'FATHIMA SHAHAMA', NULL, NULL, '2000-05-06', 'Female', 9844292064, 8749091746, 'fathimashahama07@gmail.com', NULL, NULL, NULL, 'MANGALORE', 'INDIAN', 'MUSLIM', 'BEARY', 'Daughter', 'Member', 'ATT', NULL, 'Single', NULL, 'Student', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2nd PU', NULL, NULL, NULL, NULL, NULL, NULL, '1-6A DELUX MANZIL, SHANTI BAGH, MUNDOLI, KUTTAR DERALAKATTE POST, SOMESHWAR VILLAGE, MANGALORE', 'MANGALORE', 'Dakshin Kannada', 'Karnataka', 575018, NULL, NULL, NULL, NULL, NULL, 'fathimashahama07@gmail.com', '2000-05-06', 1, NULL, '2019-09-10 07:16:49'),
(179, 'HFATT09', 'MASHOOFA', NULL, NULL, '2001-08-20', 'Female', 8722641402, NULL, '', NULL, NULL, NULL, 'MANGALORE', 'INDIAN', 'MUSLIM', 'BEARY', 'Daughter', 'Member', 'ATT', 'HSCC', 'Single', NULL, 'Student', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'HIDAYA SHARE AND CARE COLONY KAVALAKTTE', 'MANGALORE', 'Dakshin Kannada', 'Karnataka', 575001, NULL, NULL, NULL, NULL, NULL, '8722641402', '2001-08-20', 1, NULL, '2019-09-10 08:18:54');

-- --------------------------------------------------------

--
-- Table structure for table `family_details`
--

CREATE TABLE `family_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `hf_id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` bigint(12) DEFAULT NULL,
  `gender` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qualification` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `occupation` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `relation` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `family_door` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `familycolony` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `income` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `helps` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ration_card_no` int(11) DEFAULT NULL,
  `voter_id` int(11) DEFAULT NULL,
  `Adhar_no` int(11) DEFAULT NULL,
  `family_status` int(11) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `family_details`
--

INSERT INTO `family_details` (`id`, `hf_id`, `fname`, `lname`, `email`, `phone`, `gender`, `qualification`, `occupation`, `age`, `relation`, `status`, `family_door`, `familycolony`, `dob`, `income`, `helps`, `ration_card_no`, `voter_id`, `Adhar_no`, `family_status`, `created_at`, `updated_at`) VALUES
(13, '', 'Navab', NULL, NULL, 0, 'Male', '7th standard', 'no job', 50, 'father', 'married', '39', 'HSCC', NULL, '0', 'nil', 0, 0, 0, 0, '2018-10-26 06:07:58', '2019-03-04 00:55:36'),
(14, '', 'Ashika', NULL, NULL, 0, 'Female', NULL, NULL, 16, 'sister', NULL, '39', 'HSCC', NULL, '0', NULL, 0, 0, 0, 0, '2018-10-26 06:22:02', '2019-03-04 00:55:36'),
(15, '', 'Jafar', NULL, NULL, NULL, 'Male', '10th', NULL, 14, 'brother', NULL, '39', 'HSCC', NULL, '0', NULL, 0, 0, 0, 0, '2018-10-26 06:23:40', '2019-03-04 00:55:36'),
(16, '', 'Athika', NULL, NULL, 9591172494, 'Female', '5th std', 'Rolling Beedi', 10, 'mother', 'married', '39', 'HSCC', '1975-08-12', '0', 'nill', 0, 0, 0, 0, '2018-10-27 04:25:26', '2019-03-04 00:55:36'),
(17, '', 'Usman', NULL, NULL, 9740253314, 'Male', '2nd std', 'coolie', 47, 'father', 'married', '37', 'HSCC', NULL, '0', 'nil', 0, 0, 0, 1, '2018-10-26 23:07:20', '2018-10-26 23:07:20'),
(18, '', 'Khatheeja', NULL, NULL, 9740253314, 'Female', '5th std', 'beedi worker', 40, 'mother', 'married', '37', 'HSCC', NULL, '0', 'nil', 0, 0, 0, 1, '2018-10-26 23:12:54', '2018-10-26 23:12:54'),
(19, '', 'Mohammed', 'Zameer', NULL, NULL, 'Male', '1st PUC', 'Studying', 15, 'brother', 'Unmarried', '37', 'HSCC', NULL, '0', '15', 0, 0, 0, 1, '2018-10-26 23:14:40', '2018-10-26 23:14:40'),
(20, '', 'Muzammil', NULL, NULL, NULL, 'Male', '7th', 'Studying', 12, 'brother', 'Unmarried', '37', 'HSCC', NULL, '0', 'nill', 0, 0, 0, 1, '2018-10-26 23:15:40', '2018-10-26 23:15:40'),
(21, '', 'Fathima', 'Zakiya', NULL, NULL, 'Female', '9th', 'studying', 9, 'sister', 'Unmarried', '37', 'HSCC', NULL, '0', 'nil', 0, 0, 0, 1, '2018-10-26 23:18:22', '2018-10-26 23:18:22'),
(22, '', 'Mohammed', 'Zaahir', NULL, 7158479213, 'Male', '9th', 'Juice Shop', 21, 'brother', 'unmarried', '37', 'HSCC', NULL, '0', 'nil', 0, 0, 0, 1, '2018-10-26 23:20:54', '2018-10-26 23:20:54'),
(23, '', 'Yakoob(Late)', NULL, NULL, NULL, 'Male', NULL, NULL, 47, 'father', 'married', '3', '350 Family', NULL, '0', 'women\'s want to work in their  free time to earn money', 0, 0, 0, 1, '2018-10-26 23:36:10', '2018-11-02 00:33:11'),
(24, '', 'Hajira', NULL, NULL, 9591075286, 'Female', '4th std', NULL, 43, 'mother', 'married', '3', '350 Family', NULL, '0', 'women\'s want to work in their free time to earn money', 0, 0, 0, 1, '2018-10-26 23:38:06', '2018-11-02 00:33:11'),
(25, '', 'Abubabker', 'Siddeeq', NULL, 9591062829, 'Male', 'ITI', 'Coolie', 23, 'brother', 'unmarried', '3', '350 Family', NULL, '0', NULL, 0, 0, 0, 1, '2018-10-26 23:40:35', '2018-11-02 00:33:11'),
(26, '', 'K.Fayaz(Late)', NULL, NULL, NULL, 'Male', '10th std', NULL, 52, 'father', 'married', '28', 'HSCC', NULL, '0', 'Finance in education field', 0, 0, 0, 1, '2018-10-26 23:52:53', '2018-10-31 01:13:17'),
(27, '', 'Ruqya', NULL, NULL, 8105454611, 'Female', '4th', NULL, 41, 'mother', 'married', '28', 'HSCC', NULL, '0', 'No', 0, 0, 0, 1, '2018-10-26 23:54:12', '2018-10-26 23:54:12'),
(28, '', 'Mustafa', NULL, NULL, NULL, 'Male', '7th std', 'Labour', 40, 'father', 'married', '8', 'HSCC', NULL, '0', 'Content', 0, 0, 0, 0, '2018-10-27 00:01:24', '2018-11-02 01:18:30'),
(29, '', 'Naseema', NULL, NULL, 8722641402, 'Female', '6th std', 'rolling beedi', 38, 'mother', 'married', '8', 'HSCC', NULL, '0', 'content', 0, 0, 0, 0, '2018-10-27 00:03:08', '2018-11-02 01:18:30'),
(30, '', 'Afreena', NULL, NULL, NULL, 'Male', '10th', 'Studying', 14, 'sister', 'unmarried', '8', 'HSCC', NULL, '0', 'Content', 0, 0, 0, 0, '2018-10-27 00:04:25', '2018-11-02 01:18:30'),
(31, '', 'Mashoofa', NULL, NULL, NULL, 'Female', 'ATT', 'Studying', 17, 'sister', 'unmarried', '8', 'HSCC', NULL, '0', 'Content', 0, 0, 0, 0, '2018-10-27 00:08:12', '2018-11-02 01:18:30'),
(32, '', 'Nasifa', NULL, NULL, NULL, 'Female', '8th std', 'studyning', 11, 'sister', 'unmarried', '8', 'HSCC', NULL, '0', 'Content', 0, 0, 0, 0, '2018-10-27 00:09:13', '2018-11-02 01:18:30'),
(33, '', 'Ismail(Dk  about him)', NULL, NULL, NULL, 'Male', NULL, NULL, NULL, 'father', 'married', '36', 'MR Family', NULL, '0', 'Need more help in Ration', 0, 0, 0, 1, '2018-10-27 00:15:50', '2018-10-27 00:15:50'),
(34, '', 'Shameema', NULL, NULL, 9901223124, 'Male', '4th std', 'Beedi', 35, 'mother', 'married', '36', 'MR Family', NULL, '0', 'Need more help in Ration', 0, 0, 0, 1, '2018-10-27 00:18:29', '2018-10-27 00:18:29'),
(35, '', 'Imthiyaz', NULL, NULL, 9901223124, 'Male', '7th std', 'Studying', 12, 'brother', 'unmarried', '36', 'MR Family', NULL, '0', 'Need more help in Ration', 0, 0, 0, 1, '2018-10-27 00:20:30', '2018-10-27 00:20:30'),
(36, '', 'Ibrahim', NULL, NULL, 8971869486, 'Male', '10th std', 'cook', 70, 'father', 'married', '9', 'HSCC', NULL, '0', 'Finance in education field', 0, 0, 0, 1, '2018-10-27 00:26:23', '2018-11-05 06:50:42'),
(37, '', 'Nabisa', NULL, NULL, NULL, 'Female', NULL, 'Beedi worker', 35, 'mother', 'married', '9', 'HSCC', NULL, '0', 'Finance in education field', 0, 0, 0, 1, '2018-10-27 00:27:27', '2018-11-05 06:50:42'),
(38, '', 'Muzammil', NULL, NULL, NULL, 'Male', '9th std', 'studying', 18, 'brother', '0', '9', 'HSCC', NULL, '0', 'Finance in education field', 0, 0, 0, 1, '2018-10-27 00:29:36', '2018-11-05 06:50:42'),
(39, '', 'Mumthaz', 'S', 'admin@gmail.com', 123647890, 'Male', '4', 'Housewife', NULL, 'mother', 'Married', '36', 'HSCC', '2019-05-14', '10000', NULL, NULL, NULL, NULL, 1, '2019-05-20 10:00:59', '2019-05-20 10:00:59');

-- --------------------------------------------------------

--
-- Table structure for table `main_skills`
--

CREATE TABLE `main_skills` (
  `id` int(10) UNSIGNED NOT NULL,
  `main_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `main_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#edf1f5',
  `main_status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `main_skills_datas`
--

CREATE TABLE `main_skills_datas` (
  `id` int(10) UNSIGNED NOT NULL,
  `person_id` int(11) NOT NULL,
  `main_year` date NOT NULL,
  `main_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `main_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `main_perfomance` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `main_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#c1c1c1',
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'student',
  `main_status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meeting_announces`
--

CREATE TABLE `meeting_announces` (
  `id` int(10) UNSIGNED NOT NULL,
  `meeting_date` date NOT NULL,
  `meeting_time` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meeting_venue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_id` int(11) NOT NULL,
  `committee_id` int(11) NOT NULL,
  `descriptions` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `member_credits`
--

CREATE TABLE `member_credits` (
  `id` int(10) UNSIGNED NOT NULL,
  `member_id` int(11) NOT NULL,
  `meeting` int(11) NOT NULL,
  `workshop` int(11) NOT NULL,
  `fund_raising_event` int(11) NOT NULL,
  `food_fest_event` int(11) NOT NULL,
  `get_together_event` int(11) NOT NULL,
  `visits` int(11) NOT NULL,
  `food` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_10_04_105749_create_admins_table', 1),
(4, '2018_10_06_042737_create_student_details_table', 2),
(5, '2018_10_06_042926_create_family_details_table', 2),
(6, '2018_10_06_045224_create_addresses_table', 2),
(7, '2018_10_06_045829_drop_student_details_table', 3),
(8, '2018_10_11_110750_create_student_details_table', 4),
(9, '2018_10_12_062543_create_studentskills_table', 5),
(10, '2018_10_12_093147_add_sid_to_studentskills', 6),
(11, '2018_10_12_094444_add_sid_to_studentskills', 7),
(12, '2018_10_13_091752_add_age_to_student_details', 8),
(13, '2018_10_19_150458_create_studentevaluations_table', 9),
(14, '2018_11_02_091108_create_organisation_details_table', 10),
(15, '2018_11_03_041614_create_unit_details_table', 10),
(16, '2018_11_08_035445_create_womens_wings_table', 11),
(17, '2018_11_24_054742_create_tasks_table', 12),
(18, '2019_01_02_120455_create_tbl_committees_table', 13),
(19, '2019_01_04_071319_create_tbl_committees_details_table', 14),
(20, '2019_01_12_043038_create_meeting_announces_table', 15),
(21, '2019_01_22_040644_create_core_skills_table', 16),
(22, '2019_02_02_054421_create_member_credits_table', 17),
(23, '2019_02_12_063900_create_main_skills_table', 17),
(24, '2019_02_12_063935_create_sub_skills_table', 17),
(25, '2019_02_12_064010_create_questionairs_table', 17),
(26, '2019_02_16_085838_create_main_skills_datas_table', 18);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('swabeershine72@gmail.com', '$2y$10$EDQljykTOqu.lxz48Zm71uzB0.3gDTN4KoemMXKfKBimz36tQXNnm', '2019-09-13 05:11:33');

-- --------------------------------------------------------

--
-- Table structure for table `questionairs`
--

CREATE TABLE `questionairs` (
  `id` int(10) UNSIGNED NOT NULL,
  `main_id` int(10) UNSIGNED NOT NULL,
  `basic_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `q_type` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `question_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ans_mark` int(11) NOT NULL,
  `options` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `opt_mark` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `q_status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `studentevaluations`
--

CREATE TABLE `studentevaluations` (
  `id` int(10) UNSIGNED NOT NULL,
  `stdid` int(11) NOT NULL,
  `category` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grade` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stage` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `course` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_college_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weakness` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `strength` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `performance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `madrasa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ibada` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `practices` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` date DEFAULT NULL,
  `remark` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `eval_status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `rank_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rank_list` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `studentevaluations`
--

INSERT INTO `studentevaluations` (`id`, `stdid`, `category`, `grade`, `stage`, `course`, `school_college_name`, `weakness`, `strength`, `performance`, `madrasa`, `ibada`, `practices`, `year`, `remark`, `eval_status`, `created_at`, `updated_at`, `rank_name`, `rank_list`) VALUES
(1, 5, 'HSCC', '7th', 'Primary', NULL, 'St.Aloy', 'Communication', 'Sports', '86', '58', '75', '25', '2018-08-06', '86', 1, NULL, '2019-08-14 19:56:44', NULL, NULL),
(2, 5, 'HSCC', '4th', 'Primary', NULL, 'St.Aloy', 'Communication', 'Sports', '60', '70', '90', '50', '2015-08-06', '86', 1, NULL, '2019-08-14 19:59:08', NULL, NULL),
(3, 5, 'HSCC', '5th', 'Primary', NULL, 'St.Aloy', 'Communication', 'Sports', '95', '45', '75', '25', '2016-08-06', '86', 1, NULL, '2019-08-14 20:05:51', NULL, NULL),
(4, 5, 'HSCC', '6th', 'Primary', NULL, 'St.Aloy', 'Communication', 'Sports', '70', '65', '58', '69', '2017-08-06', '86', 1, NULL, '2019-08-14 20:05:51', NULL, NULL),
(5, 158, 'ATT', '2nd PU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-09-09', NULL, 1, NULL, '2019-09-09 10:01:54', NULL, NULL),
(6, 164, 'ATT', '2nd PU', NULL, NULL, 'HIRA WOMEN\'S COMPOSITE PU COLLEGE', NULL, NULL, NULL, NULL, NULL, NULL, '2019-09-09', NULL, 1, NULL, '2019-09-09 11:30:04', NULL, NULL),
(7, 166, 'ATT', '2nd PU', NULL, NULL, 'ST.JOSEPH', NULL, NULL, NULL, NULL, NULL, NULL, '2019-09-09', NULL, 1, NULL, '2019-09-09 11:54:11', NULL, NULL),
(8, 168, 'ATT', '2nd PU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-09-09', NULL, 1, NULL, '2019-09-09 12:07:07', NULL, NULL),
(9, 170, 'ATT', '2nd PU', NULL, NULL, 'ANUGRAHA WOMENS PU COLLEGE', NULL, NULL, NULL, NULL, NULL, NULL, '2019-09-10', NULL, 1, NULL, '2019-09-10 06:20:09', NULL, NULL),
(10, 174, 'ATT', '2nd pu', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-09-10', NULL, 1, NULL, '2019-09-10 07:04:36', NULL, NULL),
(11, 176, 'ATT', '2nd PU', NULL, NULL, 'SALIHATH GIRLS PU COLLEGE HOODE UDUPI', NULL, NULL, NULL, NULL, NULL, NULL, '2019-09-10', NULL, 1, NULL, '2019-09-10 07:11:41', NULL, NULL),
(12, 178, 'ATT', '2nd PU', NULL, NULL, 'HIRA WOMEN\'S COMPOSITE PU COLLEGE', NULL, NULL, NULL, NULL, NULL, NULL, '2019-09-10', NULL, 1, NULL, '2019-09-10 07:16:49', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `studentskills`
--

CREATE TABLE `studentskills` (
  `id` int(10) UNSIGNED NOT NULL,
  `sid` int(11) NOT NULL,
  `planning` int(191) NOT NULL,
  `presentation` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `networking` int(191) NOT NULL,
  `counclling` int(191) NOT NULL,
  `sharing` float NOT NULL,
  `leadership` int(11) NOT NULL,
  `skill_year` date NOT NULL,
  `skill_status` int(2) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_details`
--

CREATE TABLE `student_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `fname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `age` int(11) NOT NULL,
  `blood_group` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hobbies` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `goal` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `std_door` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `belongs_to` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `colony` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_skills`
--

CREATE TABLE `sub_skills` (
  `id` int(10) UNSIGNED NOT NULL,
  `main_id` int(10) UNSIGNED NOT NULL,
  `sub_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tabl_ranks`
--

CREATE TABLE `tabl_ranks` (
  `id` int(11) NOT NULL,
  `rank_name` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tabl_stud_ranks`
--

CREATE TABLE `tabl_stud_ranks` (
  `id` int(11) NOT NULL,
  `stud_id` int(11) NOT NULL,
  `rank_id` int(11) NOT NULL,
  `performance` varchar(50) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) UNSIGNED NOT NULL,
  `member_id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `assign_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `task_status` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_academics`
--

CREATE TABLE `tbl_academics` (
  `id` int(11) NOT NULL,
  `madrasa_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `grade` varchar(150) NOT NULL,
  `performance` int(11) DEFAULT NULL,
  `academic_year` date NOT NULL,
  `hfid` varchar(150) NOT NULL,
  `type` varchar(150) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_academics`
--

INSERT INTO `tbl_academics` (`id`, `madrasa_id`, `student_id`, `grade`, `performance`, `academic_year`, `hfid`, `type`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 7, '5th', 80, '2019-11-13', 'HFSCC01', 'HSCC', 1, '2019-11-13 08:36:22', '2019-11-13 08:36:22'),
(2, 1, 7, '2', 20, '2018-11-06', 'HFSCC01', 'HSCC', 1, '2019-11-13 14:17:07', '2019-11-13 14:17:07'),
(3, 1, 7, '3', 40, '2019-12-14', 'HFSCC01', 'HSCC', 1, '2019-11-14 06:01:33', '2019-11-14 06:01:33');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_assessments_structure`
--

CREATE TABLE `tbl_assessments_structure` (
  `id` int(11) NOT NULL,
  `assessment_name` varchar(150) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_basic_skills`
--

CREATE TABLE `tbl_basic_skills` (
  `id` int(11) NOT NULL,
  `personid` int(11) NOT NULL,
  `year` date NOT NULL,
  `type` varchar(250) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remark` int(11) NOT NULL,
  `Compassion` int(11) NOT NULL,
  `Goal_Setting` int(11) NOT NULL,
  `Team_work` int(11) NOT NULL,
  `Time_Management` int(11) NOT NULL,
  `Effective_Communication` int(11) NOT NULL,
  `Emotion_Management` int(11) NOT NULL,
  `Patience_and_Tollarence` int(11) NOT NULL,
  `Consistency` int(11) NOT NULL,
  `Confidence_and_Courage` int(11) NOT NULL,
  `Gratitude` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_city`
--

CREATE TABLE `tbl_city` (
  `id` int(11) NOT NULL,
  `dist_id` int(11) NOT NULL,
  `city_name` varchar(150) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_committees_details`
--

CREATE TABLE `tbl_committees_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `member_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `cmt_category` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_district`
--

CREATE TABLE `tbl_district` (
  `id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `dist_name` varchar(150) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_familiesfuture_infos`
--

CREATE TABLE `tbl_familiesfuture_infos` (
  `id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `occupation_name` varchar(250) NOT NULL,
  `hobbies` text,
  `goal` varchar(250) DEFAULT NULL,
  `fam_category` varchar(200) NOT NULL,
  `hfid_link` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_familiesfuture_infos`
--

INSERT INTO `tbl_familiesfuture_infos` (`id`, `person_id`, `occupation_name`, `hobbies`, `goal`, `fam_category`, `hfid_link`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 'Student', '', '', 'HSCC', 'HFSCC01', 1, '2019-06-07 10:31:54', '2019-10-18 10:03:53'),
(2, 8, 'Employee', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-08 05:54:44', '2019-10-15 09:07:39'),
(3, 11, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-08 06:28:30', '2019-10-15 09:07:39'),
(4, 13, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC02', 1, '2019-06-08 07:28:07', '2019-10-15 09:07:39'),
(5, 15, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC02', 1, '2019-06-08 10:06:54', '2019-10-15 09:07:39'),
(6, 16, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC02', 1, '2019-06-08 10:42:57', '2019-10-15 09:07:39'),
(7, 19, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-08 11:44:17', '2019-10-15 09:07:39'),
(8, 23, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-08 12:34:06', '2019-10-15 09:07:39'),
(9, 32, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-09 05:45:54', '2019-10-15 09:07:39'),
(10, 34, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-09 06:52:08', '2019-10-15 09:07:39'),
(11, 36, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-09 08:10:42', '2019-10-15 09:07:39'),
(12, 38, 'Student', NULL, NULL, 'HSCC', 'HFSCC02', 1, '2019-06-09 09:31:29', '2019-10-15 09:07:39'),
(13, 42, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-09 10:37:22', '2019-10-15 09:07:39'),
(14, 45, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-09 11:26:36', '2019-10-15 09:07:39'),
(15, 47, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-09 11:49:57', '2019-10-15 09:07:39'),
(16, 48, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-10 10:53:30', '2019-10-15 09:07:39'),
(17, 49, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-10 11:25:52', '2019-10-15 09:07:39'),
(18, 50, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-10 11:53:37', '2019-10-15 09:07:39'),
(19, 57, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-11 09:12:01', '2019-10-15 09:07:39'),
(20, 61, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-11 09:48:29', '2019-10-15 09:07:39'),
(21, 63, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-11 10:19:54', '2019-10-15 09:07:39'),
(22, 66, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-11 10:53:16', '2019-10-15 09:07:39'),
(23, 70, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-11 11:33:48', '2019-10-15 09:07:39'),
(24, 73, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-11 12:26:48', '2019-10-15 09:07:39'),
(25, 76, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-12 04:12:51', '2019-10-15 09:07:39'),
(26, 81, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-12 05:20:48', '2019-10-15 09:07:39'),
(27, 86, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-12 07:06:14', '2019-10-15 09:07:39'),
(28, 89, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-12 07:31:21', '2019-10-15 09:07:39'),
(29, 92, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-12 08:07:46', '2019-10-15 09:07:39'),
(30, 97, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-12 09:15:26', '2019-10-15 09:07:39'),
(31, 101, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-12 09:42:13', '2019-10-15 09:07:39'),
(32, 104, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-12 10:18:54', '2019-10-15 09:07:39'),
(33, 106, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-12 10:42:51', '2019-10-15 09:07:39'),
(34, 111, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-13 06:01:45', '2019-10-15 09:07:39'),
(35, 114, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-13 10:05:42', '2019-10-15 09:07:39'),
(36, 123, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-14 11:47:55', '2019-10-15 09:07:39'),
(37, 125, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-17 10:34:33', '2019-10-15 09:07:39'),
(38, 129, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-20 05:34:36', '2019-10-15 09:07:39'),
(39, 132, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-20 05:49:42', '2019-10-15 09:07:39'),
(40, 134, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-20 06:43:23', '2019-10-15 09:07:39'),
(41, 136, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-20 06:55:39', '2019-10-15 09:07:39'),
(42, 137, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-20 07:04:24', '2019-10-15 09:07:39'),
(43, 138, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-20 07:24:32', '2019-10-15 09:07:39'),
(44, 139, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-20 07:36:30', '2019-10-15 09:07:39'),
(45, 5, 'Student', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-07 11:09:07', '2019-10-15 09:07:39'),
(46, 6, 'Employee', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-07 11:11:59', '2019-10-15 09:07:39'),
(47, 7, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-07 11:45:30', '2019-10-15 09:07:39'),
(48, 9, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-08 06:00:06', '2019-10-15 09:07:39'),
(49, 10, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-08 06:06:01', '2019-10-15 09:07:39'),
(50, 12, 'Student', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-08 07:07:14', '2019-10-15 09:07:39'),
(51, 14, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-08 07:49:50', '2019-10-15 09:07:39'),
(52, 17, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-08 10:59:43', '2019-10-15 09:07:39'),
(53, 18, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-08 11:04:18', '2019-10-15 09:07:39'),
(54, 20, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-08 11:53:00', '2019-10-15 09:07:39'),
(55, 21, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-08 11:56:20', '2019-10-15 09:07:39'),
(56, 22, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-08 12:04:05', '2019-10-15 09:07:39'),
(57, 24, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-09 04:38:39', '2019-10-15 09:07:39'),
(58, 25, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-09 04:40:54', '2019-10-15 09:07:39'),
(59, 26, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-09 04:44:04', '2019-10-15 09:07:39'),
(60, 27, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-09 04:46:03', '2019-10-15 09:07:39'),
(61, 28, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-09 04:56:49', '2019-10-15 09:07:39'),
(62, 29, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-09 05:01:02', '2019-10-15 09:07:39'),
(63, 30, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-09 05:06:31', '2019-10-15 09:07:39'),
(64, 31, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-09 05:20:17', '2019-10-15 09:07:39'),
(65, 33, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-09 06:23:50', '2019-10-15 09:07:39'),
(66, 35, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-09 07:21:46', '2019-10-15 09:07:39'),
(67, 37, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-09 08:59:21', '2019-10-15 09:07:39'),
(68, 39, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-09 09:45:45', '2019-10-15 09:07:39'),
(69, 40, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-09 09:53:43', '2019-10-15 09:07:39'),
(70, 41, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-09 10:07:04', '2019-10-15 09:07:39'),
(71, 43, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-09 10:57:28', '2019-10-15 09:07:39'),
(72, 44, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-09 11:06:18', '2019-10-15 09:07:39'),
(73, 46, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-09 11:34:38', '2019-10-15 09:07:39'),
(74, 51, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-11 05:01:25', '2019-10-15 09:07:39'),
(75, 52, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-11 05:08:51', '2019-10-15 09:07:39'),
(76, 53, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-11 05:20:55', '2019-10-15 09:07:39'),
(77, 54, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-11 05:37:21', '2019-10-15 09:07:39'),
(78, 55, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-11 05:47:39', '2019-10-15 09:07:39'),
(79, 56, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-11 05:53:18', '2019-10-15 09:07:39'),
(80, 58, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-11 09:24:42', '2019-10-15 09:07:39'),
(81, 59, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-11 09:28:08', '2019-10-15 09:07:39'),
(82, 60, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-11 09:32:04', '2019-10-15 09:07:39'),
(83, 62, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-11 09:57:47', '2019-10-15 09:07:39'),
(84, 64, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-11 10:23:06', '2019-10-15 09:07:39'),
(85, 65, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-11 10:26:33', '2019-10-15 09:07:39'),
(86, 67, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-11 10:59:14', '2019-10-15 09:07:39'),
(87, 68, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-11 11:04:06', '2019-10-15 09:07:39'),
(88, 69, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-11 11:06:57', '2019-10-15 09:07:39'),
(89, 71, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-11 11:59:52', '2019-10-15 09:07:39'),
(90, 72, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-11 12:03:40', '2019-10-15 09:07:39'),
(91, 74, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-11 12:31:06', '2019-10-15 09:07:39'),
(92, 75, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-11 12:33:14', '2019-10-15 09:07:39'),
(93, 77, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-12 04:24:18', '2019-10-15 09:07:39'),
(94, 78, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-12 04:28:11', '2019-10-15 09:07:39'),
(95, 79, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-12 04:30:37', '2019-10-15 09:07:39'),
(96, 80, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-12 04:39:08', '2019-10-15 09:07:39'),
(97, 82, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-12 06:02:44', '2019-10-15 09:07:39'),
(98, 83, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-12 06:08:34', '2019-10-15 09:07:39'),
(99, 84, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-12 06:36:37', '2019-10-15 09:07:39'),
(100, 85, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-12 06:42:57', '2019-10-15 09:07:39'),
(101, 87, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-12 07:10:14', '2019-10-15 09:07:39'),
(102, 88, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-12 07:13:44', '2019-10-15 09:07:39'),
(103, 90, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-12 07:39:14', '2019-10-15 09:07:39'),
(104, 91, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-12 07:50:27', '2019-10-15 09:07:39'),
(105, 93, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-12 08:41:58', '2019-10-15 09:07:39'),
(106, 94, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-12 08:50:06', '2019-10-15 09:07:39'),
(107, 95, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-12 08:54:03', '2019-10-15 09:07:39'),
(108, 96, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-12 08:56:23', '2019-10-15 09:07:39'),
(109, 98, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-12 09:18:31', '2019-10-15 09:07:39'),
(110, 99, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-12 09:23:35', '2019-10-15 09:07:39'),
(111, 100, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-12 09:31:02', '2019-10-15 09:07:39'),
(112, 102, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-12 09:49:52', '2019-10-15 09:07:39'),
(113, 103, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-12 09:59:09', '2019-10-15 09:07:39'),
(114, 105, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-12 10:30:12', '2019-10-15 09:07:39'),
(115, 107, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-12 10:51:45', '2019-10-15 09:07:39'),
(116, 108, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-12 10:58:20', '2019-10-15 09:07:39'),
(117, 109, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-12 11:03:52', '2019-10-15 09:07:39'),
(118, 110, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-13 05:40:42', '2019-10-15 09:07:39'),
(119, 112, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-13 07:58:00', '2019-10-15 09:07:39'),
(120, 113, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-13 08:30:36', '2019-10-15 09:07:39'),
(121, 115, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-13 10:14:42', '2019-10-15 09:07:39'),
(122, 116, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-13 11:15:01', '2019-10-15 09:07:39'),
(123, 117, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-13 11:17:44', '2019-10-15 09:07:39'),
(124, 120, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-13 11:27:04', '2019-10-15 09:07:39'),
(125, 121, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-13 11:54:20', '2019-10-15 09:07:39'),
(126, 122, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-14 11:26:58', '2019-10-15 09:07:39'),
(127, 124, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-14 11:54:26', '2019-10-15 09:07:39'),
(128, 126, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-17 10:40:23', '2019-10-15 09:07:39'),
(129, 127, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-17 10:56:00', '2019-10-15 09:07:39'),
(130, 128, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-17 11:12:35', '2019-10-15 09:07:39'),
(131, 130, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-20 05:36:56', '2019-10-15 09:07:39'),
(132, 131, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-20 05:39:39', '2019-10-15 09:07:39'),
(133, 133, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-20 06:27:08', '2019-10-15 09:07:39'),
(134, 135, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-20 06:45:15', '2019-10-15 09:07:39'),
(135, 140, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-20 07:54:49', '2019-10-15 09:07:39'),
(136, 141, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-20 07:56:34', '2019-10-15 09:07:39'),
(137, 142, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-20 08:27:59', '2019-10-15 09:07:39'),
(138, 143, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-21 12:00:46', '2019-10-15 09:07:39'),
(139, 144, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-22 05:39:30', '2019-10-15 09:07:39'),
(140, 145, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-22 15:22:07', '2019-10-15 09:07:39'),
(141, 146, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-23 10:03:53', '2019-10-15 09:07:39'),
(142, 154, 'Rolling Beedi', NULL, NULL, 'HSCC', 'HFSCC01', 0, '2019-10-13 02:22:14', '2019-10-15 09:07:39'),
(148, 163, 'Beedi Rolling', '', '', 'HSCC', 'HFSCC46', 0, '2019-10-16 12:04:15', '2019-10-16 12:04:15');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_families_address`
--

CREATE TABLE `tbl_families_address` (
  `id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `hfid_link` varchar(100) NOT NULL,
  `door_no` varchar(150) DEFAULT NULL,
  `street_area` text,
  `belongs_to` varchar(250) DEFAULT NULL,
  `city` varchar(200) DEFAULT NULL,
  `district` varchar(200) DEFAULT NULL,
  `state` varchar(200) NOT NULL,
  `nation` varchar(200) DEFAULT 'India',
  `pincode` int(100) DEFAULT NULL,
  `add_type` varchar(50) DEFAULT NULL,
  `fam_category` varchar(150) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_families_address`
--

INSERT INTO `tbl_families_address` (`id`, `person_id`, `hfid_link`, `door_no`, `street_area`, `belongs_to`, `city`, `district`, `state`, `nation`, `pincode`, `add_type`, `fam_category`, `status`, `created_at`, `updated_at`) VALUES
(1, 57, 'HFSCC19', 'P-19', 'Pandavarakallu, Madanthiyar', NULL, 'Bantval', 'Dakshina Kannada', 'Karnataka', 'India', 574233, 'permanent', 'HSCC', 1, '2019-06-11 09:12:01', '2019-09-24 10:22:39'),
(2, 61, 'HFSCC20', 'P-20', 'Guringana , Layila', NULL, 'Belthangady', 'Dakshina Kannada', 'Karnataka', 'India', 574214, 'permanent', 'HSCC', 1, '2019-06-11 09:48:29', '2019-06-12 09:23:56'),
(3, 63, 'HFSCC21', 'P-21', 'Mudukodi', NULL, 'Belthangady', 'Dakshina Kannada', 'Karnataka', 'India', 574242, 'permanent', 'HSCC', 1, '2019-06-11 10:19:54', '2019-06-11 18:05:28'),
(4, 76, 'HFSCC25', 'P-25', 'Kinya', NULL, 'Natekal', 'Dakshina Kannada', 'Karnataka', 'India', 574150, 'permanent', 'HSCC', 1, '2019-06-12 04:12:51', '2019-06-12 11:56:11'),
(5, 81, 'HFSCC26', 'P-26', 'Maddadka', NULL, 'Maddadka', 'Dakshina Kannada', 'Karnataka', 'India', 574224, 'permanent', 'HSCC', 1, '2019-06-12 05:20:48', '2019-06-12 12:02:28'),
(6, 86, 'HFSCC27', 'P-27', 'Sajipa', NULL, 'Bantwal', 'Dakshina Kannada', 'Karnataka', 'India', 574231, 'permanent', 'HSCC', 1, '2019-06-12 07:06:14', '2019-06-12 12:48:12'),
(7, 89, 'HFSCC28', 'P-28', 'Harihara', NULL, 'Davanagere', 'Dakshina Kannada', 'Karnataka', 'India', 577601, 'permanent', 'HSCC', 1, '2019-06-12 07:31:21', '2019-06-12 13:16:37'),
(8, 92, 'HFSCC30', 'P-30', 'Ujire', NULL, 'Belthangady', 'Dakshina Kannada', 'Karnataka', 'India', 574240, 'permanent', 'HSCC', 1, '2019-06-12 08:07:46', '2019-06-12 14:14:32'),
(9, 97, 'HFSCC29', 'P-29', 'Karvel', NULL, 'Perne.', 'Dakshina Kannada', 'Karnataka', 'India', 574241, 'permanent', 'HSCC', 1, '2019-06-12 09:15:26', '2019-09-17 02:20:06'),
(10, 101, 'HFSCC31', 'P-31', 'Karagatte, Ajjibettu', NULL, 'B.C road', 'Dakshina Kannada', 'Karnataka', 'India', 574324, 'permanent', 'HSCC', 1, '2019-06-12 09:42:13', '2019-09-17 02:20:06'),
(11, 104, 'HFSCC32', 'P-32', 'B. Mooda', NULL, 'Bantwal', 'Dakshina Kannada', 'Karnataka', 'India', 574219, 'permanent', 'HSCC', 1, '2019-06-12 10:18:54', '2019-09-17 02:20:06'),
(12, 106, 'HFSCC33', 'P-33', 'Bengare', NULL, 'Mangalore', 'Dakshina Kannada', 'Karnataka', 'India', 575001, 'permanent', 'HSCC', 1, '2019-06-12 10:42:51', '2019-06-13 10:41:44'),
(13, 114, 'HFSCC35', 'P-35', 'B C Road', NULL, 'Bantwal', 'Dakshina Kannada', 'Karnataka', 'India', 574219, 'permanent', 'HSCC', 1, '2019-06-13 10:05:42', '2019-09-17 02:20:06'),
(14, 125, 'HFSCC37', 'P-37', 'Shirlalu', NULL, 'Belthangady', 'Dakshina Kannada', 'Karnataka', 'India', 574217, 'permanent', 'HSCC', 1, '2019-06-17 10:34:33', '2019-09-17 02:20:07'),
(15, 129, 'HFSCC39', 'P-39', 'Punjalakatte', NULL, 'Punjalakatte', 'Dakshina Kannada', 'Karnataka', 'India', 574233, 'permanent', 'HSCC', 1, '2019-06-20 05:34:36', '2019-09-17 02:29:14'),
(16, 132, 'HFSCC40', 'P-40', 'Venooru', NULL, 'Venooru', 'Dakshina Kannada', 'Karnataka', 'India', 574242, 'permanent', 'HSCC', 1, '2019-06-20 05:49:42', '2019-09-17 02:29:14'),
(17, 134, 'HFSCC41', 'P-41', 'Mavinakatte', NULL, 'Mavinakatte', 'Dakshina Kannada', 'Karnataka', 'India', 574324, 'permanent', 'HSCC', 1, '2019-06-20 06:43:23', '2019-09-17 02:29:14'),
(18, 136, 'HFSCC42', 'P-42', 'Maaladi', NULL, 'Madanthyar', 'Dakshina Kannada', 'Karnataka', 'India', 574224, 'permanent', 'HSCC', 1, '2019-06-20 06:55:39', '2019-09-17 02:29:14'),
(19, 11, 'HFSCC02', 'P-02', 'Pandavarakallu', NULL, 'Bantval', 'Dakshina Kannada', 'Karnataka', 'India', 574231, 'permanent', 'HSCC', 1, '2019-09-24 10:17:46', '2019-10-10 07:09:47'),
(20, 8, 'HFSCC03', 'P-03', 'Bangerkatte', NULL, 'Belthangady', 'Dakshina Kannada', 'Karnataka', 'India', 574214, 'permanent', 'HSCC', 1, '2019-09-24 14:33:39', '2019-09-24 14:49:06'),
(22, 152, 'HFSCC54', '546', 'Wefwef', NULL, 'ewfw', 'Dakshina Kannada', 'Karnataka', 'India', 464, 'permanent', 'HSCC', 1, '2019-10-12 13:37:16', '2019-10-12 13:46:57'),
(26, 153, 'HFSCC59', '98', '3r34r', NULL, 'Bantval', 'Dakshina Kannada', 'Karnataka', 'India', 574231, 'permanent', 'HSCC', 1, '2019-10-13 01:29:30', '2019-10-13 01:29:30'),
(27, 154, 'HFSCC69', '100', '3r34r', NULL, 'Bantval', 'Dakshina Kannada', 'Karnataka', 'India', 574231, 'permanent', 'HSCC', 1, '2019-10-13 02:19:45', '2019-10-13 02:19:45'),
(33, 163, 'HFSCC46', 'P-46', 'Kaniyoor', NULL, 'Belthangady', 'Dakshina Kannada', 'Karnataka', 'India', 574214, 'Permanent', 'HSCC', 1, '2019-10-16 12:04:15', '2019-10-16 12:04:15');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_families_personals`
--

CREATE TABLE `tbl_families_personals` (
  `id` int(11) NOT NULL,
  `hfid` varchar(50) NOT NULL,
  `fname` varchar(250) NOT NULL,
  `lname` varchar(200) DEFAULT NULL,
  `image` varchar(250) DEFAULT NULL,
  `gender` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `birth_place` varchar(250) DEFAULT NULL,
  `nationality` varchar(150) DEFAULT NULL,
  `relegion` varchar(150) DEFAULT NULL,
  `mother_tongue` varchar(150) DEFAULT NULL,
  `marital_status` varchar(150) NOT NULL,
  `adhar_no` bigint(20) NOT NULL,
  `adhar_image` varchar(250) DEFAULT NULL,
  `mobile` bigint(20) NOT NULL,
  `phone` bigint(20) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `blood_group` varchar(100) DEFAULT NULL,
  `living` varchar(150) NOT NULL,
  `relation` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `doj` date DEFAULT NULL,
  `fam_category` varchar(100) NOT NULL,
  `hfid_link` varchar(100) DEFAULT NULL,
  `user_name` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_families_personals`
--

INSERT INTO `tbl_families_personals` (`id`, `hfid`, `fname`, `lname`, `image`, `gender`, `dob`, `birth_place`, `nationality`, `relegion`, `mother_tongue`, `marital_status`, `adhar_no`, `adhar_image`, `mobile`, `phone`, `email`, `blood_group`, `living`, `relation`, `role`, `doj`, `fam_category`, `hfid_link`, `user_name`, `password`, `status`, `created_at`, `updated_at`) VALUES
(4, 'HFSCC01', 'Sumayya', '', NULL, 'Female', '1984-01-11', '', 'Indian', 'Islam', 'Beary', 'Married', 946333449438, 'ADHAR_Doc_140254.png', 8139968219, 0, '', NULL, 'Alive', 'Mother', 'Head', '2017-09-19', 'HSCC', '', 'Sumayya', '1984-01-11', 1, '2019-06-07 10:31:54', '2019-10-18 10:03:53'),
(5, 'HFSCC01', 'Fathimathul Rinsha', '', NULL, 'Female', '2010-08-19', '', 'Indian', 'Islam', 'Beary', 'UnMarried', 974219517239, 'ADHAR_HFSCC01_6947234.png', 0, 0, '', NULL, 'Alive', 'Father', 'Member', NULL, 'HSCC', '', 'Fathimathul Rinsha', '2010-08-19', 1, '2019-06-07 11:09:07', '2019-10-10 07:08:25'),
(6, 'HFSCC01', 'Ayishathul shafa', NULL, NULL, 'Female', '2011-11-20', NULL, NULL, NULL, NULL, 'UnMarried', 644776831152, 'ADHAR_Doc_140254.png', 0, 0, '', NULL, 'Alive', 'HeadFather', 'Member', NULL, 'HSCC', '', 'Ayishathul shafa', '2011-11-20', 1, '2019-06-07 11:11:59', '2019-06-22 11:01:43'),
(7, 'HFSCC01', 'Fathimath Rifa', NULL, NULL, 'Female', '2013-08-25', NULL, NULL, NULL, NULL, 'UnMarried', 370880218481, 'ADHAR_Doc_140254.png', 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Fathimath Rifa', '2013-08-25', 1, '2019-06-07 11:45:30', '2019-06-22 22:10:35'),
(8, 'HFSCC03', 'Hajira', '', NULL, 'Female', '1978-01-01', '', 'Indian', 'Islam', 'Beary', 'Married', 289354076793, NULL, 9591602829, 0, '', NULL, 'Alive', 'Mother', 'Head', '1978-01-01', 'HSCC', '', 'Hajira', '1978-01-01', 1, '2019-06-08 05:54:44', '2019-09-24 14:49:06'),
(9, 'HFSCC03', 'Fathimath', 'Nisha', NULL, 'Female', '2002-10-14', '', 'Indian', 'Islam', 'Beary', 'Single', 575609496283, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Fathimath Nisha', '2002-10-14', 1, '2019-06-08 06:00:06', '2019-09-24 14:47:52'),
(10, 'HFSCC03', 'Aboobakkar', 'Siddique', NULL, 'Male', '1995-07-06', '', 'Indian', 'Islam', 'Beary', 'UnMarried', 620460277306, NULL, 0, 0, '', NULL, 'Alive', 'Son', 'Member', NULL, 'HSCC', '', 'Aboobakkar Siddique', '1995-07-06', 1, '2019-06-08 06:06:01', '2019-09-25 05:35:21'),
(11, 'HFSCC02', 'Salika', '', NULL, 'Female', '1987-01-01', '', 'Indian', 'Islam', 'Beary', 'Married', 834504419029, 'ADHAR_HFSCC02_1321587.png', 9741485643, 0, '', NULL, 'Alive', 'Mother', 'Head', '2019-05-15', 'HSCC', '', 'salika', '1987-01-01', 1, '2019-06-08 06:28:30', '2019-10-10 07:09:47'),
(12, 'HFSCC02', 'Mahammad Shahid', NULL, NULL, 'Male', '2009-03-28', NULL, NULL, NULL, NULL, 'UnMarried', 738062956037, NULL, 0, 0, '', NULL, 'Alive', 'Son', 'Member', NULL, 'HSCC', '', 'Mahammad Shahid', '2009-03-28', 1, '2019-06-08 07:07:14', '2019-06-22 22:12:22'),
(13, 'HFSCC04', 'Asiyamma', NULL, NULL, 'Female', '1974-01-01', NULL, NULL, NULL, NULL, 'Married', 692337664087, NULL, 9901972688, 0, '', NULL, 'Alive', 'Mother', 'Head', '2012-07-10', 'HSCC', '', 'Asiyamma', '1974-01-01', 1, '2019-06-08 07:28:07', '2019-09-16 10:04:17'),
(14, 'HFSCC04', 'Shameera', NULL, NULL, 'Female', '1993-04-05', NULL, NULL, NULL, NULL, 'UnMarried', 671265618748, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Shameera', '1993-04-05', 1, '2019-06-08 07:49:50', '2019-06-08 16:09:13'),
(15, 'HFSCC05', 'Dulaikha', NULL, NULL, 'Female', '1972-01-01', NULL, NULL, NULL, NULL, 'Married', 573017978341, NULL, 8971684873, 0, '', NULL, 'Alive', 'Mother', 'Head', '1972-06-16', 'HSCC', '', 'Dulaikha', '1972-01-01', 1, '2019-06-08 10:06:54', '2019-09-16 10:04:17'),
(16, 'HFSCC06', 'Jameela', NULL, NULL, 'Female', '1985-01-01', NULL, NULL, NULL, NULL, 'Married', 959357416640, NULL, 7760144313, 0, '', NULL, 'Alive', 'Mother', 'Head', '2015-11-01', 'HSCC', '', 'Jameela', '1985-01-01', 1, '2019-06-08 10:42:57', '2019-09-12 09:24:57'),
(17, 'HFSCC05', 'Fathimath Shareena', NULL, NULL, 'Female', '2004-01-01', NULL, NULL, NULL, NULL, 'UnMarried', 262472907094, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Fathimath Shareena', '2004-01-01', 1, '2019-06-08 10:59:43', '2019-06-23 16:56:47'),
(18, 'HFSCC05', 'Mahammad Shahid', NULL, NULL, 'Male', '2008-06-10', NULL, NULL, NULL, NULL, 'UnMarried', 407880751980, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Mahammad Shahid', '2008-06-10', 1, '2019-06-08 11:04:18', '2019-06-13 16:03:50'),
(19, 'HFSCC07', 'Balkees', NULL, NULL, 'Female', '1975-01-01', NULL, NULL, NULL, NULL, 'Married', 561886135397, NULL, 7899938843, 0, '', NULL, 'Alive', 'Mother', 'Head', '2012-01-01', 'HSCC', '', 'Balkees', '1975-01-01', 1, '2019-06-08 11:44:17', '2019-09-16 10:04:17'),
(20, 'HFSCC07', 'Fathima', NULL, NULL, 'Female', '1999-01-24', NULL, NULL, NULL, NULL, 'UnMarried', 573100289950, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Fathima', '1999-01-24', 1, '2019-06-08 11:53:00', '2019-06-23 17:04:08'),
(21, 'HFSCC07', 'Afreena Mariyam', NULL, NULL, 'Female', '2002-05-23', NULL, NULL, NULL, NULL, 'UnMarried', 404948947113, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Afreena Mariyam', '2002-05-23', 1, '2019-06-08 11:56:20', '2019-06-23 17:11:03'),
(22, 'HFSCC07', 'Asura Beebi', NULL, NULL, 'Female', '2004-02-27', NULL, NULL, NULL, NULL, 'UnMarried', 504893185335, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Asura Beebi', '2004-02-27', 1, '2019-06-08 12:04:05', '2019-06-23 17:20:06'),
(23, 'HFSCC08', 'Naseema', NULL, NULL, 'Female', '1982-01-01', NULL, NULL, NULL, NULL, 'Married', 694288180559, NULL, 8722641402, 0, '', NULL, 'Alive', 'Mother', 'Head', '2012-01-01', 'HSCC', '', 'Naseema', '1982-01-01', 1, '2019-06-08 12:34:06', '2019-09-16 10:04:17'),
(24, 'HFSCC08', 'Mashoofa', NULL, NULL, 'Female', '2001-08-20', NULL, NULL, NULL, NULL, 'UnMarried', 970882962191, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Mashoofa', '2001-08-20', 1, '2019-06-09 04:38:39', '2019-06-23 17:21:30'),
(25, 'HFSCC08', 'Mishriya', NULL, NULL, 'Female', '2003-02-03', NULL, NULL, NULL, NULL, 'UnMarried', 577725799504, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Mishriya', '2003-02-03', 1, '2019-06-09 04:40:54', '2019-06-23 17:22:22'),
(26, 'HFSCC08', 'Afreena', NULL, NULL, 'Female', '2004-05-30', NULL, NULL, NULL, NULL, 'UnMarried', 425791284241, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Afreena', '2004-05-30', 1, '2019-06-09 04:44:04', '2019-06-25 10:52:29'),
(27, 'HFSCC08', 'Naseefa', NULL, '', 'Female', '2006-05-14', NULL, NULL, NULL, NULL, 'UnMarried', 509166553450, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Naseefa', '2006-05-14', 1, '2019-06-09 04:46:03', '2019-06-25 10:56:39'),
(28, 'HFSCC06', 'Abdul Latheef', NULL, NULL, 'Male', '1975-01-01', NULL, NULL, NULL, NULL, 'Married', 273307474066, NULL, 0, 0, '', NULL, 'Alive', 'Father', 'Member', NULL, 'HSCC', '', 'Abdul Latheef', '1975-01-01', 1, '2019-06-09 04:56:49', '2019-06-09 10:33:38'),
(29, 'HFSCC06', 'Mohammad Sameer', NULL, NULL, 'Male', '2004-04-05', NULL, NULL, NULL, NULL, 'UnMarried', 343163658455, NULL, 0, 0, '', NULL, 'Alive', 'Son', 'Member', NULL, 'HSCC', '', 'Mohammad Sameer', '2004-04-05', 1, '2019-06-09 05:01:02', '2019-09-19 09:43:07'),
(30, 'HFSCC06', 'Mohammed Safaz', NULL, NULL, 'Male', '2006-09-28', NULL, NULL, NULL, NULL, 'UnMarried', 343163658455, NULL, 0, 0, '', NULL, 'Alive', 'Son', 'Member', NULL, 'HSCC', '', 'Mohammed Safaz', '2006-09-28', 1, '2019-06-09 05:06:31', '2019-06-22 11:14:01'),
(31, 'HFSCC06', 'Mohammed Shiabuddeen', NULL, NULL, 'Male', '2012-07-26', NULL, NULL, NULL, NULL, 'UnMarried', 429988207221, NULL, 0, 0, '', NULL, 'Alive', 'Son', 'Member', NULL, 'HSCC', '', 'Mohammed Shiabuddeen', '2012-07-26', 1, '2019-06-09 05:20:17', '2019-09-19 09:43:07'),
(32, 'HFSCC09', 'Shahnaz Banu', NULL, NULL, 'Female', '1986-01-01', NULL, NULL, NULL, NULL, 'Married', 870498642881, NULL, 9108679233, 0, '', NULL, 'Alive', 'Mother', 'Head', '2019-04-20', 'HSCC', '', 'Shahnaz Banu', '1986-01-01', 1, '2019-06-09 05:45:54', '2019-09-16 10:04:17'),
(33, 'HFSCC09', 'Mohammed Imaz Sheik', NULL, NULL, 'Male', '2012-03-07', NULL, NULL, NULL, NULL, 'UnMarried', 708753780617, NULL, 0, 0, '', NULL, 'Alive', 'Son', 'Member', NULL, 'HSCC', '', 'Mohammed Imaz Sheik', '2012-03-07', 1, '2019-06-09 06:23:50', '2019-06-22 22:21:10'),
(34, 'HFSCC10', 'Jameela', NULL, NULL, 'Female', '1974-04-01', NULL, NULL, NULL, NULL, 'Married', 308853765737, NULL, 9663765293, 0, '', NULL, 'Alive', 'Mother', 'Head', '2013-09-01', 'HSCC', '', 'Jameela', '1974-04-01', 1, '2019-06-09 06:52:08', '2019-06-10 16:26:11'),
(35, 'HFSCC10', 'Mahammad Nihal', NULL, NULL, 'Male', '2010-01-07', NULL, NULL, NULL, NULL, 'UnMarried', 423727648258, NULL, 0, 0, '', NULL, 'Alive', 'Son', 'Member', NULL, 'HSCC', '', 'Mahammad Nihal', '2010-01-07', 1, '2019-06-09 07:21:46', '2019-09-19 09:43:07'),
(36, 'HFSCC11', 'Raziya', NULL, NULL, 'Female', '1978-01-01', NULL, NULL, NULL, NULL, 'Married', 534067739756, NULL, 7259554030, 0, '', NULL, 'Alive', 'Mother', 'Head', '2012-09-08', 'HSCC', '', 'Raziya', '1978-01-01', 1, '2019-06-09 08:10:42', '2019-09-16 10:04:17'),
(37, 'HFSCC11', 'Mohammad jeeshan Pasha', NULL, NULL, 'Male', '2003-09-09', NULL, NULL, NULL, NULL, 'UnMarried', 810803703434, NULL, 0, 0, '', NULL, 'Alive', 'Son', 'Member', NULL, 'HSCC', '', 'Mohammad jeeshan Pasha', '2003-09-09', 1, '2019-06-09 08:59:21', '2019-06-22 12:48:19'),
(38, 'HFSCC12', 'Fathima Zohra', NULL, NULL, 'Female', '1986-01-01', NULL, NULL, NULL, NULL, 'Married', 810214729587, NULL, 8884702032, 0, '', NULL, 'Alive', 'Mother', 'Head', '2019-04-15', 'HSCC', '', 'Fathima Zohra', '1986-01-01', 1, '2019-06-09 09:31:29', '2019-09-16 10:04:17'),
(39, 'HFSCC11', 'Thoushin Banu', NULL, NULL, 'Female', '2005-06-22', NULL, NULL, NULL, NULL, 'UnMarried', 492474016915, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Thoushin Banu', '2005-06-22', 1, '2019-06-09 09:45:45', '2019-06-22 20:30:12'),
(40, 'HFSCC12', 'Jabbar khan', NULL, NULL, 'Male', '2011-12-10', NULL, NULL, NULL, NULL, 'UnMarried', 585078409719, NULL, 0, 0, '', NULL, 'Alive', 'Son', 'Member', NULL, 'HSCC', '', 'Jabbar khan', '2011-12-10', 1, '2019-06-09 09:53:43', '2019-06-22 12:07:06'),
(41, 'HFSCC12', 'Badruddeen', NULL, NULL, 'Male', '2004-01-14', NULL, NULL, NULL, NULL, 'UnMarried', 655273109990, NULL, 0, 0, '', NULL, 'Alive', 'Son', 'Member', NULL, 'HSCC', '', 'Badruddeen', '2004-01-14', 1, '2019-06-09 10:07:04', '2019-06-22 22:19:55'),
(42, 'HFSCC13', 'Ramlath', NULL, NULL, 'Female', '1987-01-01', NULL, NULL, NULL, NULL, 'Married', 379374782889, NULL, 8711024108, 0, '', NULL, 'Alive', 'Mother', 'Head', '2018-08-10', 'HSCC', '', 'Ramlath', '1987-01-01', 1, '2019-06-09 10:37:22', '2019-09-16 10:04:17'),
(43, 'HFSCC13', 'Aayisha Banu', NULL, NULL, 'Female', '2008-04-15', NULL, NULL, NULL, NULL, 'UnMarried', 770499505752, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Aayisha Banu', '2008-04-15', 1, '2019-06-09 10:57:28', '2019-06-22 22:28:38'),
(44, 'HFSCC13', 'Mahammad Shahid', NULL, NULL, 'Male', '2006-06-02', NULL, NULL, NULL, NULL, 'UnMarried', 653696829909, NULL, 0, 0, '', NULL, 'Alive', 'Son', 'Member', NULL, 'HSCC', '', 'Mahammad Shahid', '2006-06-02', 1, '2019-06-09 11:06:18', '2019-06-22 22:30:14'),
(45, 'HFSCC14', 'Jameela', NULL, NULL, 'Female', '1973-01-01', NULL, NULL, NULL, NULL, 'Married', 0, NULL, 9611598639, 0, '', NULL, 'Alive', 'Mother', 'Head', '2018-12-05', 'HSCC', '', 'Jameela', '1973-01-01', 1, '2019-06-09 11:26:36', '2019-06-10 16:30:53'),
(46, 'HFSCC14', 'Beepathumma', NULL, NULL, 'Female', '2009-04-17', NULL, NULL, NULL, NULL, 'UnMarried', 702778700563, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Beepathumma', '2009-04-17', 1, '2019-06-09 11:34:38', '2019-06-22 22:33:00'),
(47, 'HFSCC15', 'Ayesha', NULL, NULL, 'Female', '1992-01-01', NULL, NULL, NULL, NULL, 'Married', 249410067267, NULL, 9606225247, 0, '', NULL, 'Alive', 'Mother', 'Head', '2018-03-01', 'HSCC', '', 'Ayesha', '1992-01-01', 1, '2019-06-09 11:49:57', '2019-06-10 16:03:05'),
(48, 'HFSCC16', 'Beepathumma', NULL, NULL, 'Female', '1979-01-01', NULL, NULL, NULL, NULL, 'Married', 328844852086, NULL, 7338527637, 0, '', NULL, 'Alive', 'Mother', 'Head', '2016-08-16', 'HSCC', '', 'Beepathumma', '1979-01-01', 1, '2019-06-10 10:53:30', '2019-09-16 10:04:17'),
(49, 'HFSCC17', 'Fathima', NULL, NULL, 'Female', '1967-12-12', NULL, NULL, NULL, NULL, 'Married', 0, NULL, 9035673460, 0, '', NULL, 'Alive', 'Mother', 'Head', '2017-04-30', 'HSCC', '', 'Fathima', '1967-12-12', 1, '2019-06-10 11:25:52', '2019-06-10 16:58:48'),
(50, 'HFSCC18', 'Zeenath', NULL, NULL, 'Female', '1987-01-01', NULL, NULL, NULL, NULL, 'Married', 811832978520, NULL, 7259366992, 0, '', NULL, 'Alive', 'Mother', 'Head', '2017-12-05', 'HSCC', '', 'Zeenath', '1987-01-01', 1, '2019-06-10 11:53:37', '2019-09-16 10:04:17'),
(51, 'HFSCC15', 'Fathima Shafa', NULL, NULL, 'Female', '2013-04-18', NULL, NULL, NULL, NULL, 'UnMarried', 314892067629, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Fathima Shafa', '2013-04-18', 1, '2019-06-11 05:01:25', '2019-06-22 11:14:48'),
(52, 'HFSCC15', 'Shafina', NULL, NULL, 'Female', '2014-06-22', NULL, NULL, NULL, NULL, 'UnMarried', 892367354364, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Shafina', '2014-06-22', 1, '2019-06-11 05:08:51', '2019-06-22 22:35:38'),
(53, 'HFSCC16', 'Fahida Banu', NULL, NULL, 'Female', '2011-01-01', NULL, NULL, NULL, NULL, 'UnMarried', 975014783522, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Fahida Banu', '2011-01-01', 1, '2019-06-11 05:20:55', '2019-06-22 22:06:57'),
(54, 'HFSCC16', 'Fahimathul Fida', NULL, NULL, 'Female', '2014-05-26', NULL, NULL, NULL, NULL, 'UnMarried', 601910875048, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Fahimathul Fida', '2014-05-26', 1, '2019-06-11 05:37:21', '2019-06-22 22:07:38'),
(55, 'HFSCC18', 'Fathimath Shahla', NULL, NULL, 'Female', '2009-09-21', NULL, NULL, NULL, NULL, 'UnMarried', 784011510199, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Fathimath Shahla', '2009-09-21', 1, '2019-06-11 05:47:39', '2019-06-21 22:27:49'),
(56, 'HFSCC18', 'Fathimath Suhaila', NULL, NULL, 'Female', '2006-10-21', NULL, NULL, NULL, NULL, 'UnMarried', 377752184531, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Fathimath Suhaila', '2006-10-21', 1, '2019-06-11 05:53:18', '2019-06-21 22:29:09'),
(57, 'HFSCC19', 'Nebisa', NULL, NULL, 'Female', '1973-08-25', NULL, NULL, NULL, NULL, 'Married', 915433770379, NULL, 8197858682, 0, '', NULL, 'Alive', 'Mother', 'Head', '2013-10-31', 'HSCC', '', 'Nebisa', '1973-08-25', 1, '2019-06-11 09:12:01', '2019-09-16 10:04:17'),
(58, 'HFSCC19', 'Shahida banu', NULL, NULL, 'Female', '2002-10-30', NULL, NULL, NULL, NULL, 'UnMarried', 578876457400, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Shahida banu', '2002-10-30', 1, '2019-06-11 09:24:42', '2019-06-22 22:43:48'),
(59, 'HFSCC19', 'Sameeda banu', NULL, NULL, 'Female', '2009-01-09', NULL, NULL, NULL, NULL, 'UnMarried', 767257236314, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Sameeda banu', '2009-01-09', 1, '2019-06-11 09:28:08', '2019-06-22 22:43:10'),
(60, 'HFSCC19', 'Rizwan', NULL, NULL, 'Male', '2006-04-04', NULL, NULL, NULL, NULL, 'UnMarried', 858682397368, NULL, 0, 0, '', NULL, 'Alive', 'Son', 'Member', NULL, 'HSCC', '', 'Rizwan', '2006-04-04', 1, '2019-06-11 09:32:04', '2019-06-22 13:00:49'),
(61, 'HFSCC20', 'Ayisha', NULL, NULL, 'Female', '1984-10-01', NULL, NULL, NULL, NULL, 'Married', 756923090166, NULL, 9606225247, 0, '', NULL, 'Alive', 'Mother', 'Head', '2017-01-17', 'HSCC', '', 'Ayisha', '1984-10-01', 1, '2019-06-11 09:48:29', '2019-06-12 09:23:56'),
(62, 'HFSCC20', 'Fathimath Rumaiza', NULL, NULL, 'Female', '2010-06-28', NULL, NULL, NULL, NULL, 'UnMarried', 427705062714, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Fathimath Rumaiza', '2010-06-28', 1, '2019-06-11 09:57:47', '2019-09-12 11:56:23'),
(63, 'HFSCC21', 'Athijamma', NULL, NULL, 'Female', '1976-01-01', NULL, NULL, NULL, NULL, 'Married', 676114303335, NULL, 8762256773, 0, '', NULL, 'Alive', 'Mother', 'Head', '2013-11-10', 'HSCC', '', 'Athijamma', '1976-01-01', 1, '2019-06-11 10:19:54', '2019-06-11 18:05:28'),
(64, 'HFSCC21', 'Rameeza', NULL, NULL, 'Female', '1994-07-17', NULL, NULL, NULL, NULL, 'Married', 931326413708, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Rameeza', '1994-07-17', 1, '2019-06-11 10:23:06', '2019-09-19 09:43:07'),
(65, 'HFSCC21', 'Shabeer N', NULL, NULL, 'Male', '1997-04-06', NULL, NULL, NULL, NULL, 'UnMarried', 559331632748, NULL, 0, 0, '', NULL, 'Alive', 'Son', 'Member', NULL, 'HSCC', '', 'Shabeer N', '1997-04-06', 1, '2019-06-11 10:26:33', '2019-09-19 09:43:07'),
(66, 'HFSCC22', 'Shamshad', NULL, NULL, 'Female', '1986-07-11', NULL, NULL, NULL, NULL, 'Married', 2358626825553, NULL, 8277338278, 0, '', NULL, 'Alive', 'Mother', 'Head', '2018-12-22', 'HSCC', '', 'Shamshad', '1986-07-11', 1, '2019-06-11 10:53:16', '2019-06-11 17:23:25'),
(67, 'HFSCC22', 'Syed Abrar', NULL, NULL, 'Male', '2007-04-05', NULL, NULL, NULL, NULL, 'UnMarried', 337295050425, NULL, 0, 0, '', NULL, 'Alive', 'Son', 'Member', NULL, 'HSCC', '', 'Syed Abrar', '2007-04-05', 1, '2019-06-11 10:59:14', '2019-06-22 11:22:18'),
(68, 'HFSCC22', 'Manha', NULL, NULL, 'Female', '2010-01-11', NULL, NULL, NULL, NULL, 'UnMarried', 607351842498, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Manha', '2010-01-11', 1, '2019-06-11 11:04:06', '2019-09-19 09:43:07'),
(69, 'HFSCC22', 'Thasniya', NULL, NULL, 'Female', '2012-02-04', NULL, NULL, NULL, NULL, 'UnMarried', 6567, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Thasniya', '2012-02-04', 1, '2019-06-11 11:06:57', '2019-06-22 11:18:25'),
(70, 'HFSCC24', 'Mumthaz', NULL, NULL, 'Female', '1993-01-01', NULL, NULL, NULL, NULL, 'Married', 714600645242, NULL, 9740614425, 0, '', NULL, 'Alive', 'Mother', 'Head', '2016-06-06', 'HSCC', '', 'Mumthaz', '1993-01-01', 1, '2019-06-11 11:33:48', '2019-06-11 17:43:30'),
(71, 'HFSCC24', 'Mohammad Numan', NULL, NULL, 'Male', '2011-09-04', NULL, NULL, NULL, NULL, 'UnMarried', 352973436604, NULL, 0, 0, '', NULL, 'Alive', 'Son', 'Member', NULL, 'HSCC', '', 'Mohammad Numan', '2011-09-04', 1, '2019-06-11 11:59:52', '2019-06-22 11:59:46'),
(72, 'HFSCC24', 'Mahammad Nubeen', NULL, NULL, 'Male', '2014-05-07', NULL, NULL, NULL, NULL, 'UnMarried', 219438561459, NULL, 0, 0, '', NULL, 'Alive', 'Son', 'Member', NULL, 'HSCC', '', 'Mahammad Nubeen', '2014-05-07', 1, '2019-06-11 12:03:40', '2019-06-21 22:31:19'),
(73, 'HFSCC23', 'Shamshad Banu', NULL, NULL, 'Female', '2018-09-12', NULL, NULL, NULL, NULL, 'Married', 462144905806, NULL, 9008520987, 0, '', NULL, 'Alive', 'Mother', 'Head', '1979-07-14', 'HSCC', '', 'Shamshad Banu', '2018-09-12', 1, '2019-06-11 12:26:48', '2019-06-11 17:57:28'),
(74, 'HFSCC23', 'Sabiha sanabil', NULL, NULL, 'Female', '2008-04-20', NULL, NULL, NULL, NULL, 'UnMarried', 281296262308, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Sabiha sanabi;l', '2008-04-20', 1, '2019-06-11 12:31:06', '2019-06-25 11:13:28'),
(75, 'HFSCC23', 'Mohammad Faizan Salik', NULL, NULL, 'Male', '2015-10-20', NULL, NULL, NULL, NULL, 'UnMarried', 633220203764, NULL, 0, 0, '', NULL, 'Alive', 'Son', 'Member', NULL, 'HSCC', '', 'Mohammad Faizan Salik', '2015-10-20', 1, '2019-06-11 12:33:14', '2019-06-25 11:14:54'),
(76, 'HFSCC25', 'Nebisa', NULL, NULL, 'Female', '1975-10-10', NULL, NULL, NULL, NULL, 'Married', 808489817754, NULL, 8971869486, 0, '', NULL, 'Alive', 'Mother', 'Head', '2013-10-10', 'HSCC', '', 'Nebisa', '1975-10-10', 1, '2019-06-12 04:12:51', '2019-06-12 11:56:11'),
(77, 'HFSCC25', 'Sabeena Banu', NULL, NULL, 'Female', '1996-11-24', NULL, NULL, NULL, NULL, 'UnMarried', 236524086004, NULL, 8971637636, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Sabeena Banu', '1996-11-24', 1, '2019-06-12 04:24:18', '2019-06-12 11:58:10'),
(78, 'HFSCC25', 'Yasmeen', NULL, NULL, 'Female', '2000-05-31', NULL, NULL, NULL, NULL, 'Married', 339185693093, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Yasmeen', '2000-05-31', 1, '2019-06-12 04:28:11', '2019-06-12 11:59:43'),
(79, 'HFSCC25', 'Mahammad sapanulla (Safwan)', NULL, NULL, 'Male', '1998-06-03', NULL, NULL, NULL, NULL, 'UnMarried', 636407211657, NULL, 0, 0, '', NULL, 'Alive', 'Son', 'Member', NULL, 'HSCC', '', 'Mahammad sapanulla (Safwan)', '1998-06-03', 1, '2019-06-12 04:30:37', '2019-06-12 11:55:31'),
(80, 'HFSCC25', 'Munaf', NULL, NULL, 'Male', '2008-05-04', NULL, NULL, NULL, NULL, 'UnMarried', 315197294073, NULL, 0, 0, '', NULL, 'Alive', 'Son', 'Member', NULL, 'HSCC', '', 'Munaf', '2008-05-04', 1, '2019-06-12 04:39:08', '2019-06-25 11:19:53'),
(81, 'HFSCC26', 'Avvamma', NULL, NULL, 'Female', '1962-01-01', NULL, NULL, NULL, NULL, 'Married', 663484199748, NULL, 8150826822, 0, '', NULL, 'Alive', 'Mother', 'Head', '2015-12-16', 'HSCC', '', 'Avvamma', '1962-01-01', 1, '2019-06-12 05:20:48', '2019-06-12 12:02:28'),
(82, 'HFSCC26', 'Mahammad Azaruddeen', NULL, NULL, 'Male', '1999-12-15', NULL, NULL, NULL, NULL, 'UnMarried', 965877049848, NULL, 0, 0, '', NULL, 'Alive', 'Son', 'Member', NULL, 'HSCC', '', 'Mahammad Azaruddeen', '1999-12-15', 1, '2019-06-12 06:02:44', '2019-06-12 12:00:35'),
(83, 'HFSCC25', 'Safreena', NULL, NULL, 'Female', '2002-01-01', NULL, NULL, NULL, NULL, 'UnMarried', 0, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Safreena', '2002-01-01', 1, '2019-06-12 06:08:34', '2019-06-12 12:01:27'),
(84, 'HFSCC25', 'Muzammil', NULL, NULL, 'Male', '2003-09-19', NULL, NULL, NULL, NULL, 'UnMarried', 324414060605, NULL, 0, 0, '', NULL, 'Alive', 'Son', 'Member', NULL, 'HSCC', '', 'Muzammil', '2003-09-19', 1, '2019-06-12 06:36:37', '2019-09-19 09:43:07'),
(85, 'HFSCC25', 'Mufeed', NULL, NULL, 'Male', '2010-12-20', NULL, NULL, NULL, NULL, 'UnMarried', 0, NULL, 0, 0, '', NULL, 'Alive', 'Son', 'Member', NULL, 'HSCC', '', 'Mufeed', '2010-12-20', 1, '2019-06-12 06:42:57', '2019-06-22 12:19:21'),
(86, 'HFSCC27', 'Ayisha', NULL, NULL, 'Female', '1980-01-28', NULL, NULL, NULL, NULL, 'Married', 732689243878, NULL, 7996976203, 0, '', NULL, 'Alive', 'Mother', 'Head', '2016-05-17', 'HSCC', '', 'Ayisha', '1980-01-28', 1, '2019-06-12 07:06:14', '2019-06-12 12:48:12'),
(87, 'HFSCC27', 'Fathimath Naziya', NULL, NULL, 'Female', '2011-09-17', NULL, NULL, NULL, NULL, 'UnMarried', 472023697325, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'fathimath Naziya', '2011-09-17', 1, '2019-06-12 07:10:14', '2019-06-21 20:49:09'),
(88, 'HFSCC27', 'Fathima', NULL, NULL, 'Female', '2014-05-15', NULL, NULL, NULL, NULL, 'UnMarried', 672874811318, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Fathima', '2014-05-15', 1, '2019-06-12 07:13:44', '2019-06-21 20:47:22'),
(89, 'HFSCC28', 'P- Isabi', NULL, NULL, 'Female', '1981-06-01', NULL, NULL, NULL, NULL, 'Married', 706665026553, NULL, 9632655456, 0, '', NULL, 'Alive', 'Mother', 'Head', '2013-04-15', 'HSCC', '', 'P- Isabi', '1981-06-01', 1, '2019-06-12 07:31:21', '2019-06-12 13:16:37'),
(90, 'HFSCC28', 'Ahmad Zainuddeen', NULL, NULL, 'Female', '1997-07-01', NULL, NULL, NULL, NULL, 'UnMarried', 0, NULL, 0, 0, '', NULL, 'Alive', 'Son', 'Member', NULL, 'HSCC', '', 'Ahmad Zainuddeen', '1997-07-01', 1, '2019-06-12 07:39:14', '2019-09-19 09:43:07'),
(91, 'HFSCC28', 'Fathima', NULL, NULL, 'Female', '2012-12-11', NULL, NULL, NULL, NULL, 'UnMarried', 371066139315, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Fathima', '2012-12-11', 1, '2019-06-12 07:50:27', '2019-09-19 09:43:07'),
(92, 'HFSCC30', 'Zeenath', NULL, NULL, 'Female', '1980-01-01', NULL, NULL, NULL, NULL, 'Married', 946131093103, NULL, 9880219161, 0, '', NULL, 'Alive', 'Mother', 'Head', '2014-04-01', 'HSCC', '', 'Zeenath', '1980-01-01', 1, '2019-06-12 08:07:46', '2019-06-12 14:14:32'),
(93, 'HFSCC30', 'B. P Ibrahim', NULL, NULL, 'Male', '1969-01-01', NULL, NULL, NULL, NULL, 'Married', 808137096281, NULL, 9945962687, 0, '', NULL, 'Alive', 'Father', 'Member', NULL, 'HSCC', '', 'B. P Ibrahim', '1969-01-01', 1, '2019-06-12 08:41:58', '2019-09-19 09:43:07'),
(94, 'HFSCC30', 'Mohammad Imthiyaz', NULL, NULL, 'Male', '2004-04-30', NULL, NULL, NULL, NULL, 'UnMarried', 641878081224, NULL, 0, 0, '', NULL, 'Alive', 'Son', 'Member', NULL, 'HSCC', '', 'Mohammad Imthiyaz', '2004-04-30', 1, '2019-06-12 08:50:06', '2019-06-25 14:47:05'),
(95, 'HFSCC30', 'Mohammad Ejaz', NULL, NULL, 'Male', '2008-06-06', NULL, NULL, NULL, NULL, 'UnMarried', 378700118701, NULL, 0, 0, '', NULL, 'Alive', 'Son', 'Member', NULL, 'HSCC', '', 'Mohammad Ejaz', '2008-06-06', 1, '2019-06-12 08:54:03', '2019-06-25 14:47:58'),
(96, 'HFSCC30', 'Shainaz', NULL, NULL, 'Female', '2011-03-04', NULL, NULL, NULL, NULL, 'UnMarried', 353537727964, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Shainaz', '2011-03-04', 1, '2019-06-12 08:56:23', '2019-06-25 14:52:56'),
(97, 'HFSCC29', 'Raziya', NULL, NULL, 'Female', '1987-05-01', NULL, NULL, NULL, NULL, 'Married', 455853515971, NULL, 6364373134, 0, '', NULL, 'Alive', 'Mother', 'Head', '2018-12-01', 'HSCC', '', 'Raziya', '1987-05-01', 1, '2019-06-12 09:15:26', '2019-09-16 10:04:17'),
(98, 'HFSCC29', 'Fathimath Nishana', NULL, NULL, 'Female', '2008-03-29', NULL, NULL, NULL, NULL, 'UnMarried', 833434475074, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Fathimath Nishana', '2008-03-29', 1, '2019-06-12 09:18:31', '2019-06-22 20:39:02'),
(99, 'HFSCC29', 'Nash Fana', NULL, NULL, 'Female', '2010-12-27', NULL, NULL, NULL, NULL, 'UnMarried', 292956463761, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Nash Fana', '2010-12-27', 1, '2019-06-12 09:23:35', '2019-06-21 22:37:10'),
(100, 'HFSCC29', 'Ayishath Neeha', NULL, NULL, 'Female', '2014-08-09', NULL, NULL, NULL, NULL, 'UnMarried', 953392204440, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Ayishath Neeha', '2014-08-09', 1, '2019-06-12 09:31:02', '2019-06-21 22:35:29'),
(101, 'HFSCC31', 'Rahmath', NULL, NULL, 'Female', '1975-01-01', NULL, NULL, NULL, NULL, 'Married', 600374746906, NULL, 9902546980, 0, '', NULL, 'Alive', 'Mother', 'Head', '2015-04-10', 'HSCC', '', 'Rahmath', '1975-01-01', 1, '2019-06-12 09:42:13', '2019-09-16 10:04:17'),
(102, 'HFSCC31', 'Sajida Banu', NULL, NULL, 'Female', '2007-08-27', NULL, NULL, NULL, NULL, 'UnMarried', 263542500358, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Sajida Banu', '2007-08-27', 1, '2019-06-12 09:49:52', '2019-06-25 15:00:59'),
(103, 'HFSCC31', 'Zeenath banu', NULL, NULL, 'Female', '2006-05-27', NULL, NULL, NULL, NULL, 'UnMarried', 648007393125, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Zeenath banu', '2006-05-27', 1, '2019-06-12 09:59:09', '2019-06-25 15:02:11'),
(104, 'HFSCC32', 'Zohara', NULL, NULL, 'Female', '1976-01-01', NULL, NULL, NULL, NULL, 'Married', 453896188229, NULL, 9164367417, 0, '', NULL, 'Alive', 'Mother', 'Head', '2015-05-01', 'HSCC', '', 'Zohara', '1976-01-01', 1, '2019-06-12 10:18:54', '2019-09-16 10:04:17'),
(105, 'HFSCC32', 'Ayisha Anisa', NULL, NULL, 'Female', '2012-01-16', NULL, NULL, NULL, NULL, 'UnMarried', 816413400147, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Ayisha Anisa', '2012-01-16', 1, '2019-06-12 10:30:12', '2019-06-25 15:21:03'),
(106, 'HFSCC33', 'Maimuna', NULL, NULL, 'Female', '1980-03-04', NULL, NULL, NULL, NULL, 'Married', 835276394663, NULL, 8296840020, 0, '', NULL, 'Alive', 'Mother', 'Head', '2016-04-10', 'HSCC', '', 'Maimuna', '1980-03-04', 1, '2019-06-12 10:42:51', '2019-06-13 10:41:44'),
(107, 'HFSCC33', 'Fathimathul Ramzeena', NULL, NULL, 'Female', '2001-02-03', NULL, NULL, NULL, NULL, 'UnMarried', 560366431238, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Fathimathul Ramzeena', '2001-02-03', 1, '2019-06-12 10:51:45', '2019-06-12 17:21:56'),
(108, 'HFSCC33', 'Safnaz', NULL, NULL, 'Female', '2002-09-15', NULL, NULL, NULL, NULL, 'UnMarried', 900789146618, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Safnaz', '2002-09-15', 1, '2019-06-12 10:58:20', '2019-06-25 15:17:16'),
(109, 'HFSCC33', 'Asfiya', NULL, NULL, 'Female', '2006-09-21', NULL, NULL, NULL, NULL, 'UnMarried', 276380194913, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Asfiya', '2006-09-21', 1, '2019-06-12 11:03:52', '2019-06-22 20:32:00'),
(110, 'HFSCC33', 'Ayishath Asriya', NULL, NULL, 'Female', '2005-02-08', NULL, NULL, NULL, NULL, 'UnMarried', 363176677169, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Ayishath Asriya', '2005-02-08', 1, '2019-06-13 05:40:42', '2019-06-22 12:57:13'),
(111, 'HFSCC34', 'Rukiya', NULL, NULL, 'Female', '1973-01-01', NULL, NULL, NULL, NULL, 'Married', 677231860599, NULL, 9591345031, 0, '', NULL, 'Alive', 'Mother', 'Head', '0000-00-00', 'HSCC', '', 'Rukiya', '1973-01-01', 1, '2019-06-13 06:01:45', '2019-06-13 15:45:53'),
(112, 'HFSCC34', 'Kamarunnisa', NULL, NULL, 'Female', '1993-07-28', NULL, NULL, NULL, NULL, 'UnMarried', 294950727176, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Kamarunnisa', '1993-07-28', 1, '2019-06-13 07:58:00', '2019-09-19 09:43:07'),
(113, 'HFSCC34', 'Sapnaz', NULL, NULL, 'Female', '1998-01-01', NULL, NULL, NULL, NULL, 'UnMarried', 642655800798, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Sapnaz', '1998-01-01', 1, '2019-06-13 08:30:36', '2019-09-19 09:43:07'),
(114, 'HFSCC35', 'Isamma', NULL, NULL, 'Female', '1975-05-04', NULL, NULL, NULL, NULL, 'Married', 457226776414, NULL, 9164471724, 0, '', NULL, 'Alive', 'Mother', 'Head', '2014-01-01', 'HSCC', '', 'Isamma', '1975-05-04', 1, '2019-06-13 10:05:42', '2019-09-16 10:04:17'),
(115, 'HFSCC35', 'Fathimath Zohara', NULL, NULL, 'Female', '2006-07-29', NULL, NULL, NULL, NULL, 'UnMarried', 622577082784, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Fathimath Zakiya', '2006-07-29', 1, '2019-06-13 10:14:42', '2019-06-25 15:23:15'),
(116, 'HFSCC35', 'Mahammad', NULL, NULL, 'Male', '1940-08-15', NULL, NULL, NULL, NULL, 'Married', 790834195613, NULL, 0, 0, '', NULL, 'Alive', 'Father', 'Member', NULL, 'HSCC', '', 'Mahammad', '1940-08-15', 1, '2019-06-13 11:15:01', '2019-09-19 09:43:07'),
(117, 'HFSCC18', 'Fathimath Shameela', NULL, NULL, 'Female', '2013-02-19', NULL, NULL, NULL, NULL, 'UnMarried', 0, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Fathimath Shameela', '2013-02-19', 1, '2019-06-13 11:17:44', '2019-06-21 22:26:17'),
(120, 'HFSCC15', 'Syed Ali', NULL, NULL, 'Male', '2018-04-20', NULL, NULL, NULL, NULL, 'UnMarried', 0, NULL, 0, 0, '', NULL, 'Alive', 'Son', 'Member', NULL, 'HSCC', '', 'Syed Ali', '2018-04-20', 1, '2019-06-13 11:27:04', '2019-09-19 09:43:07'),
(121, 'HFSCC13', 'Mahammad Shahid', NULL, NULL, 'Male', '2006-06-02', NULL, NULL, NULL, NULL, 'UnMarried', 653696829909, NULL, 0, 0, '', NULL, 'Alive', 'Son', 'Member', NULL, 'HSCC', '', 'Mahammad Shahid', '2006-06-02', 1, '2019-06-13 11:54:20', '2019-06-22 22:23:34'),
(122, 'HFSCC36', 'Mahammad Irshad', NULL, NULL, 'Male', '2001-10-04', NULL, NULL, NULL, NULL, 'UnMarried', 464136062683, NULL, 0, 0, '', NULL, 'Alive', 'Son', 'Member', NULL, 'HSCC', '', 'Mahammad Irshad', '2001-10-04', 1, '2019-06-14 11:26:58', '2019-06-25 15:27:22'),
(123, 'HFSCC36', 'Shameema', NULL, NULL, 'Female', '1983-01-01', NULL, NULL, NULL, NULL, 'Married', 506480184461, NULL, 9901223124, 0, '', NULL, 'Alive', 'Mother', 'Head', '2013-11-10', 'HSCC', '', 'Shameema', '1983-01-01', 1, '2019-06-14 11:47:55', '2019-06-22 20:10:31'),
(124, 'HFSCC36', 'Inthiyaz', NULL, NULL, 'Male', '2006-08-11', NULL, NULL, NULL, NULL, 'UnMarried', 224026466266, NULL, 0, 0, '', NULL, 'Alive', 'Son', 'Member', NULL, 'HSCC', '', 'Inthiyaz', '2006-08-11', 1, '2019-06-14 11:54:26', '2019-06-22 20:24:14'),
(125, 'HFSCC37', 'Maimuna', NULL, NULL, 'Female', '1978-06-12', NULL, NULL, NULL, NULL, 'Married', 257611582814, NULL, 9483129363, 0, '', NULL, 'Alive', 'Mother', 'Head', '2019-01-23', 'HSCC', '', 'Maimuna', '1978-06-12', 1, '2019-06-17 10:34:33', '2019-09-16 10:04:17'),
(126, 'HFSCC37', 'Mahammad shafeeq', NULL, NULL, 'Male', '2007-02-15', NULL, NULL, NULL, NULL, 'UnMarried', 305784716043, NULL, 0, 0, '', NULL, 'Alive', 'Son', 'Member', NULL, 'HSCC', '', 'Mahammad shafeeq', '2007-02-15', 1, '2019-06-17 10:40:23', '2019-06-22 20:42:34'),
(127, 'HFSCC37', 'Mahammad Shahik', NULL, NULL, 'Male', '2005-11-13', NULL, NULL, NULL, NULL, 'UnMarried', 408613570549, NULL, 0, 0, '', NULL, 'Alive', 'Son', 'Member', NULL, 'HSCC', '', 'Mahammad Shahik', '2005-11-13', 1, '2019-06-17 10:56:00', '2019-06-22 12:55:40'),
(128, 'HFSCC37', 'Mahammad Asik', NULL, NULL, 'Male', '2004-06-10', NULL, NULL, NULL, NULL, 'UnMarried', 586053684057, NULL, 0, 0, '', NULL, 'Alive', 'Son', 'Member', NULL, 'HSCC', '', 'Mahammad Asik', '2004-06-10', 1, '2019-06-17 11:12:35', '2019-06-25 15:36:16'),
(129, 'HFSCC39', 'Aathika', NULL, NULL, 'Female', '1974-08-12', NULL, NULL, NULL, NULL, 'Married', 990765573563, NULL, 9591172494, 0, '', NULL, 'Alive', 'Mother', 'Head', '2013-02-10', 'HSCC', '', 'Aathika', '1974-08-12', 1, '2019-06-20 05:34:36', '2019-09-16 10:04:17'),
(130, 'HFSCC39', 'Aashika', NULL, NULL, 'Female', '2003-03-06', NULL, NULL, NULL, NULL, 'UnMarried', 453909511638, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Aashika', '2003-03-06', 1, '2019-06-20 05:36:56', '2019-06-25 15:41:26'),
(131, 'HFSCC39', 'Jafar', NULL, NULL, 'Male', '2004-01-23', NULL, NULL, NULL, NULL, 'UnMarried', 470519112942, NULL, 0, 0, '', NULL, 'Alive', 'Son', 'Member', NULL, 'HSCC', '', 'Jafar', '2004-01-23', 1, '2019-06-20 05:39:39', '2019-06-22 12:41:05'),
(132, 'HFSCC40', 'Zohara', NULL, NULL, 'Female', '1966-01-01', NULL, NULL, NULL, NULL, 'Married', 708349969879, NULL, 9663350779, 0, '', NULL, 'Alive', 'Mother', 'Head', '2013-04-06', 'HSCC', '', 'Zohara', '1966-01-01', 1, '2019-06-20 05:49:42', '2019-09-16 10:04:17'),
(133, 'HFSCC40', 'Naseema', NULL, NULL, 'Female', '1997-11-18', NULL, NULL, NULL, NULL, 'Married', 0, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Naseema', '1997-11-18', 1, '2019-06-20 06:27:08', '2019-06-20 12:16:34'),
(134, 'HFSCC41', 'Aasyamma', NULL, NULL, 'Female', '1968-01-01', NULL, NULL, NULL, NULL, 'Married', 249339385310, NULL, 9481143179, 0, '', NULL, 'Alive', 'Mother', 'Head', '2012-01-01', 'HSCC', '', 'Aasyamma', '1968-01-01', 1, '2019-06-20 06:43:23', '2019-09-16 10:04:17'),
(135, 'HFSCC41', 'Saabira', NULL, NULL, 'Female', '1991-06-02', NULL, NULL, NULL, NULL, 'Married', 923886269048, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Saabira', '1991-06-02', 1, '2019-06-20 06:45:15', '2019-06-20 12:17:23'),
(136, 'HFSCC42', 'Mariyamma', NULL, NULL, 'Female', '1984-01-01', NULL, NULL, NULL, NULL, 'Married', 316999487772, NULL, 9880919439, 0, '', NULL, 'Alive', 'Mother', 'Head', '2013-05-01', 'HSCC', '', 'Mariyamma', '1984-01-01', 1, '2019-06-20 06:55:39', '2019-09-16 10:04:17'),
(137, 'HFSCC43', 'Unhi', NULL, NULL, 'Female', '1962-01-01', NULL, NULL, NULL, NULL, 'Married', 623987885943, NULL, 9901591743, 0, '', NULL, 'Alive', 'Mother', 'Head', '2018-12-14', 'HSCC', '', 'Unhi', '1962-01-01', 1, '2019-06-20 07:04:24', '2019-09-16 10:04:17'),
(138, 'HFSCC45', 'Jameela', NULL, NULL, 'Female', '1976-06-01', NULL, NULL, NULL, NULL, 'Married', 235346269257, NULL, 7026157731, 0, '', NULL, 'Alive', 'Mother', 'Head', '2018-04-26', 'HSCC', '', 'Jameela', '1976-06-01', 1, '2019-06-20 07:24:32', '2019-09-16 10:04:17'),
(139, 'HFSCC44', 'Salika', NULL, NULL, 'Female', '1983-01-01', NULL, NULL, NULL, NULL, 'Married', 390234730747, NULL, 9591355689, 0, '', NULL, 'Alive', 'Mother', 'Head', '2019-05-09', 'HSCC', '', 'Salika', '1983-01-01', 1, '2019-06-20 07:36:30', '2019-09-16 10:04:17'),
(140, 'HFSCC22', 'Husssain Shafi', NULL, NULL, 'Male', '1949-01-01', NULL, NULL, NULL, NULL, 'Married', 458192318117, NULL, 8861513086, 0, '', NULL, 'Alive', 'HeadFather', 'Member', NULL, 'HSCC', '', 'Husssain Shafi', '1949-01-01', 1, '2019-06-20 07:54:49', '2019-09-19 09:43:07'),
(141, 'HFSCC22', 'Beepathumma', NULL, NULL, 'Female', '1966-01-01', NULL, NULL, NULL, NULL, 'Married', 847131994714, NULL, 0, 0, '', NULL, 'Alive', 'HeadMother', 'Member', NULL, 'HSCC', '', 'Beepathumma', '1966-01-01', 1, '2019-06-20 07:56:34', '2019-09-19 09:43:07'),
(142, 'HFSCC45', 'Fathimathul Naziya', NULL, NULL, 'Female', '2009-04-15', NULL, NULL, NULL, NULL, 'UnMarried', 202645018521, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Fathimathul Naziya', '2009-04-15', 1, '2019-06-20 08:27:59', '2019-06-25 15:54:49'),
(143, 'HFSCC44', 'Muhammad Nihal', NULL, NULL, 'Male', '2007-04-03', NULL, NULL, NULL, NULL, 'UnMarried', 479772919190, NULL, 0, 0, '', NULL, 'Alive', 'Son', 'Member', NULL, 'HSCC', '', 'Muhammad Nihal', '2007-04-03', 1, '2019-06-21 12:00:46', '2019-06-25 15:53:21'),
(144, 'HFSCC29', 'Twaiba', NULL, NULL, 'Female', '2017-07-24', NULL, NULL, NULL, NULL, 'UnMarried', 0, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Twaiba', '2017-07-24', 1, '2019-06-22 05:39:30', '2019-09-19 09:43:07'),
(145, 'HFSCC21', 'Shanvaz', NULL, NULL, 'Male', '2008-04-08', NULL, NULL, NULL, NULL, 'UnMarried', 957631042461, NULL, 0, 0, '', NULL, 'Alive', 'Son', 'Member', NULL, 'HSCC', '', 'Shanvaz', '2008-04-08', 1, '2019-06-22 15:22:07', '2019-06-22 22:49:00'),
(146, 'HFSCC42', 'Fathimath Sameena', NULL, NULL, 'Female', '2005-06-06', NULL, NULL, NULL, NULL, 'UnMarried', 565535140798, NULL, 0, 0, '', NULL, 'Alive', 'Daughter', 'Member', NULL, 'HSCC', '', 'Fathimath Sameena', '2005-06-06', 1, '2019-06-23 10:03:53', '2019-09-19 09:43:07'),
(152, 'HFSCC54', 'Vsd', 'Vsdfsd', NULL, 'Male', '2019-10-08', 'Sdgsf', 'Indian', 'Islam', 'Beary', 'Married', 345345345435344, NULL, 3453543535, 3453454353, 'admin134@gmail.com', 'A -ve', 'Alive', 'Wife', 'Head', NULL, 'HSCC', NULL, 'vsd vsdfsd', '345345345435344', 1, '2019-10-12 13:36:22', '2019-10-12 13:36:22'),
(153, 'HFSCC59', 'Bgbbg', 'Gbfbfbfb', NULL, 'Male', '2019-10-02', 'Fbfbf', 'Indian', 'Islam', 'Beary', 'Married', 234234324234232, NULL, 3534535353, 5345435345, 'admin123@gmail.com', 'A -ve', 'Alive', 'Wife', 'Head', NULL, 'HSCC', NULL, 'bgbbg gbfbfbfb', '234234324234232', 1, '2019-10-13 01:29:30', '2019-10-13 01:29:30'),
(154, 'HFSCC69', 'Fwrer', 'Rwrewqr', NULL, 'Male', '2019-10-07', 'Fbfbf', 'Indian', 'Islam', 'Beary', 'Married', 23423, NULL, 35345353, 53454353, 'admin125@gmail.com', 'A -ve', 'Alive', 'Wife', 'Head', NULL, 'HSCC', NULL, 'fwrer rwrewqr', '23423', 1, '2019-10-13 02:19:45', '2019-10-13 02:19:45'),
(163, 'HFSCC46', 'Safiya', '', NULL, 'Female', '1992-01-01', 'Kaniyoor', 'Indian', 'Islam', 'Beary', 'Married', 375260784385, NULL, 9741403993, NULL, 'adn16674@gmail.com', NULL, 'Alive', 'Mother', 'Head', NULL, 'HSCC', NULL, 'safiya ', '375260784385', 1, '2019-10-16 12:04:15', '2019-10-16 12:04:15');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_feedback_remarks`
--

CREATE TABLE `tbl_feedback_remarks` (
  `id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `fam_category` varchar(100) NOT NULL,
  `hfid_link` varchar(100) NOT NULL,
  `feedback_type` varchar(150) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_general_educations`
--

CREATE TABLE `tbl_general_educations` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `college_id` int(11) DEFAULT NULL,
  `course_name` varchar(250) DEFAULT NULL,
  `standard_grade` varchar(100) NOT NULL,
  `qualification` varchar(150) DEFAULT NULL,
  `stage` varchar(150) DEFAULT NULL,
  `strength` varchar(250) DEFAULT NULL,
  `weakness` varchar(250) DEFAULT NULL,
  `present_status` varchar(150) DEFAULT 'Completed',
  `performance` varchar(100) DEFAULT NULL,
  `marks_img` varchar(255) DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  `fam_category` varchar(100) NOT NULL,
  `hfid_link` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_general_educations`
--

INSERT INTO `tbl_general_educations` (`id`, `student_id`, `college_id`, `course_name`, `standard_grade`, `qualification`, `stage`, `strength`, `weakness`, `present_status`, `performance`, `marks_img`, `year`, `fam_category`, `hfid_link`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 27, '', '5th', '5th', 'Primary', NULL, '', 'Dropout', NULL, NULL, 2019, 'HSCC', 'HFSCC01', 1, '2019-06-07 10:31:54', '2019-10-18 10:03:53'),
(2, 7, 27, '', '5th', '5th', 'Primary', NULL, '', 'Completed', '75', NULL, 2018, 'HSCC', 'HFSCC03', 1, '2019-06-08 05:54:44', '2019-10-18 10:03:53'),
(3, 11, 0, NULL, 'None', 'None', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC02', 1, '2019-06-08 06:28:30', '2019-10-10 07:09:47'),
(4, 13, NULL, NULL, '4th STD', '4th STD', NULL, '', '', 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC04', 1, '2019-06-08 07:28:07', '2019-09-18 06:09:03'),
(5, 15, NULL, NULL, '2nd STD', '2nd STD', NULL, '', '', 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC05', 1, '2019-06-08 10:06:54', '2019-09-18 06:09:03'),
(6, 16, NULL, NULL, '2nd STD', '2nd STD', NULL, '', '', 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC06', 1, '2019-06-08 10:42:57', '2019-09-12 09:24:57'),
(7, 19, NULL, NULL, '5th', '5th', NULL, '', '', 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC07', 1, '2019-06-08 11:44:17', '2019-09-18 06:09:03'),
(8, 23, NULL, NULL, '6th STD', '6th STD', NULL, '', '', 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC08', 1, '2019-06-08 12:34:06', '2019-09-18 06:09:03'),
(9, 32, NULL, 'BBM', 'BBM', 'BBM', NULL, '', '', 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC09', 1, '2019-06-09 05:45:54', '2019-09-18 06:09:03'),
(10, 34, NULL, NULL, '3rd STD', '3rd STD', NULL, '', '', 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC10', 1, '2019-06-09 06:52:08', '2019-06-10 16:26:11'),
(11, 36, NULL, NULL, '5th', '5th', NULL, '', '', 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC11', 1, '2019-06-09 08:10:42', '2019-09-18 06:09:03'),
(12, 38, NULL, NULL, '2nd STD', '2nd STD', NULL, '', '', 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC12', 1, '2019-06-09 09:31:29', '2019-09-18 06:09:03'),
(13, 42, NULL, NULL, '3rd', '3rd', NULL, '', '', 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC13', 1, '2019-06-09 10:37:22', '2019-09-18 06:09:03'),
(14, 45, NULL, NULL, '6th STD', '6th STD', NULL, '', '', 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC14', 1, '2019-06-09 11:26:36', '2019-06-10 16:30:53'),
(15, 47, NULL, NULL, '5th', '5th', NULL, '', '', 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC15', 1, '2019-06-09 11:49:57', '2019-06-10 16:03:05'),
(17, 49, NULL, NULL, '5th  STD', '5th  STD', NULL, '', '', 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC17', 1, '2019-06-10 11:25:52', '2019-06-10 16:58:48'),
(18, 50, NULL, NULL, '6th STD', '6th STD', NULL, '', '', 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC18', 1, '2019-06-10 11:53:37', '2019-09-18 06:09:03'),
(19, 57, NULL, '', '5th STD', '5th', 'Pre-Primary', NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC19', 1, '2019-06-11 09:12:01', '2019-09-24 11:11:50'),
(20, 61, NULL, NULL, '5th', '5th', NULL, '', '', 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC20', 1, '2019-06-11 09:48:29', '2019-06-12 09:23:56'),
(22, 66, NULL, NULL, '7th STD', '7th STD', NULL, '', '', 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC22', 1, '2019-06-11 10:53:16', '2019-06-11 17:23:25'),
(23, 70, NULL, NULL, '10th STD', '10th STD', NULL, '', '', 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC24', 1, '2019-06-11 11:33:48', '2019-06-11 17:43:30'),
(24, 73, NULL, NULL, '7th', '7th', NULL, '', '', 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC23', 1, '2019-06-11 12:26:48', '2019-06-11 17:57:28'),
(26, 81, NULL, NULL, 'None', 'None', NULL, '', '', 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC26', 1, '2019-06-12 05:20:48', '2019-06-12 12:02:28'),
(27, 86, NULL, NULL, '4th STD', '4th STD', NULL, '', '', 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC27', 1, '2019-06-12 07:06:14', '2019-06-12 12:48:12'),
(28, 89, NULL, NULL, '7th', '7th', NULL, '', '', 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC28', 1, '2019-06-12 07:31:21', '2019-06-12 13:16:37'),
(29, 92, NULL, NULL, '7th', '7th', NULL, '', '', 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC30', 1, '2019-06-12 08:07:46', '2019-06-12 14:14:32'),
(30, 97, NULL, NULL, '7th STD', '7th STD', NULL, '', '', 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC29', 1, '2019-06-12 09:15:26', '2019-09-18 06:09:03'),
(31, 101, NULL, NULL, '1st', '1st', NULL, '', '', 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC31', 1, '2019-06-12 09:42:13', '2019-09-18 06:09:03'),
(33, 106, NULL, NULL, '2nd STD', '2nd STD', NULL, '', '', 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC33', 1, '2019-06-12 10:42:51', '2019-06-13 10:41:44'),
(34, 111, NULL, NULL, '3rd', '3rd', NULL, '', '', 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC34', 1, '2019-06-13 06:01:45', '2019-06-13 15:45:53'),
(36, 123, NULL, NULL, '4th', '4th', NULL, '', '', 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC36', 1, '2019-06-14 11:47:55', '2019-06-22 20:10:31'),
(37, 125, NULL, NULL, '4th STD', '4th STD', NULL, '', '', 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC37', 1, '2019-06-17 10:34:33', '2019-09-18 06:09:03'),
(38, 129, NULL, NULL, '5th STD', '5th STD', NULL, '', '', 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC39', 1, '2019-06-20 05:34:36', '2019-09-18 06:09:03'),
(64, 5, 0, NULL, '4th STD', '4th STD', 'Primary', NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-07 11:09:07', '2019-10-10 07:08:25'),
(65, 6, NULL, NULL, '3rd STD', '3rd STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC01', 1, '2019-06-07 11:11:59', '2019-06-22 11:01:43'),
(66, 7, NULL, NULL, '1st STD', '1st STD', NULL, NULL, NULL, 'Pursuing', NULL, 'MARKS_HFSCC01_6898244.png', 2017, 'HSCC', 'HFSCC01', 1, '2019-06-07 11:45:30', '2019-06-22 22:10:35'),
(67, 9, NULL, '', '2nd PUC', 'PUC', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC03', 1, '2019-06-08 06:00:06', '2019-09-24 14:47:53'),
(68, 10, NULL, '', 'ITI', 'ITI', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC03', 1, '2019-06-08 06:06:01', '2019-09-25 05:35:21'),
(69, 12, NULL, NULL, '5th STD', '5th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC02', 1, '2019-06-08 07:07:14', '2019-06-22 22:12:22'),
(70, 14, NULL, NULL, '10th', '10th', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC04', 1, '2019-06-08 07:49:50', '2019-06-08 16:09:13'),
(71, 17, NULL, NULL, '10th', '10th', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC05', 1, '2019-06-08 10:59:43', '2019-06-23 16:56:47'),
(72, 18, NULL, NULL, '6th', '6th', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC05', 1, '2019-06-08 11:04:18', '2019-06-13 16:03:50'),
(73, 20, NULL, NULL, 'B.Com', 'B.Com', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC07', 1, '2019-06-08 11:53:00', '2019-06-23 17:04:08'),
(74, 21, NULL, NULL, '2nd PUC', '2nd PUC', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC07', 1, '2019-06-08 11:56:20', '2019-06-23 17:11:03'),
(75, 22, NULL, NULL, '1st PUC', '1st PUC', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC07', 1, '2019-06-08 12:04:05', '2019-06-23 17:20:06'),
(76, 24, NULL, NULL, 'Diploma Education in Arabic Language', 'Diploma Education in Arabic Language', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC08', 1, '2019-06-09 04:38:39', '2019-06-23 17:21:30'),
(77, 25, NULL, NULL, '2nd PUC', '2nd PUC', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC08', 1, '2019-06-09 04:40:54', '2019-06-23 17:22:22'),
(78, 26, NULL, NULL, '1st PUC', '1st PUC', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC08', 1, '2019-06-09 04:44:04', '2019-06-25 10:52:29'),
(79, 27, NULL, NULL, '9th STD', '9th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC08', 1, '2019-06-09 04:46:03', '2019-06-25 10:56:39'),
(80, 28, NULL, NULL, '3rd STD', '3rd STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC06', 1, '2019-06-09 04:56:49', '2019-06-09 10:33:38'),
(81, 29, NULL, NULL, 'Secondary (Hidayah Special Need Center)', 'Secondary (Hidayah Special Need Center)', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC06', 1, '2019-06-09 05:01:02', '2019-09-19 11:42:50'),
(82, 30, NULL, NULL, '8th STD', '8th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC06', 1, '2019-06-09 05:06:31', '2019-06-22 11:14:01'),
(83, 31, NULL, NULL, 'Care Group (Hidayah Special Need Center )', 'Care Group (Hidayah Special Need Center )', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC06', 1, '2019-06-09 05:20:17', '2019-09-19 11:42:50'),
(84, 33, NULL, NULL, '3rd', '3rd', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC09', 1, '2019-06-09 06:23:50', '2019-06-22 22:21:10'),
(85, 35, NULL, NULL, '5th STD', '5th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC10', 1, '2019-06-09 07:21:46', '2019-09-19 11:42:50'),
(86, 37, NULL, NULL, '10th STD', '10th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC11', 1, '2019-06-09 08:59:21', '2019-06-22 12:48:19'),
(87, 39, NULL, NULL, '9th STD', '9th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC11', 1, '2019-06-09 09:45:45', '2019-06-22 20:30:12'),
(88, 40, NULL, NULL, '3rd STD', '3rd STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC12', 1, '2019-06-09 09:53:43', '2019-06-22 12:07:06'),
(89, 41, NULL, NULL, '10th STD', '10th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC12', 1, '2019-06-09 10:07:04', '2019-06-22 22:19:55'),
(90, 43, NULL, NULL, '6th STD', '6th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC13', 1, '2019-06-09 10:57:28', '2019-06-22 22:28:38'),
(91, 44, NULL, NULL, '4th STD', '4th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC13', 1, '2019-06-09 11:06:18', '2019-06-22 22:30:14'),
(92, 46, NULL, NULL, '6th STD', '6th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC14', 1, '2019-06-09 11:34:38', '2019-06-22 22:33:00'),
(93, 51, NULL, NULL, 'UKG', 'UKG', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC15', 1, '2019-06-11 05:01:25', '2019-06-22 11:14:48'),
(94, 52, NULL, NULL, 'LKG', 'LKG', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC15', 1, '2019-06-11 05:08:51', '2019-06-22 22:35:38'),
(95, 53, NULL, NULL, '3rd STD', '3rd STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC16', 1, '2019-06-11 05:20:55', '2019-06-22 22:06:57'),
(96, 54, NULL, NULL, 'UKG', 'UKG', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC16', 1, '2019-06-11 05:37:21', '2019-06-22 22:07:38'),
(97, 55, NULL, NULL, '5th STD', '5th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC18', 1, '2019-06-11 05:47:39', '2019-06-21 22:27:49'),
(98, 56, NULL, NULL, '8th STD', '8th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC18', 1, '2019-06-11 05:53:18', '2019-06-21 22:29:09'),
(99, 58, NULL, NULL, '2nd PUC', '2nd PUC', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC19', 1, '2019-06-11 09:24:42', '2019-06-22 22:43:48'),
(100, 59, NULL, NULL, '6th STD', '6th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC19', 1, '2019-06-11 09:28:08', '2019-06-22 22:43:10'),
(101, 60, NULL, NULL, '9th STD', '9th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC19', 1, '2019-06-11 09:32:04', '2019-06-22 13:00:49'),
(102, 62, NULL, NULL, '4th STD', '4th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC20', 1, '2019-06-11 09:57:47', '2019-09-12 11:56:23'),
(103, 64, NULL, NULL, '10th STD', '10th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC21', 1, '2019-06-11 10:23:06', '2019-09-19 11:42:50'),
(105, 67, NULL, NULL, '10th STD', '10th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC22', 1, '2019-06-11 10:59:14', '2019-06-22 11:22:18'),
(106, 68, NULL, NULL, '5th STD', '5th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC22', 1, '2019-06-11 11:04:06', '2019-09-19 11:42:50'),
(107, 69, NULL, NULL, '2nd STD', '2nd STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC22', 1, '2019-06-11 11:06:57', '2019-06-22 11:18:25'),
(108, 71, NULL, NULL, '3rd STD', '3rd STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC24', 1, '2019-06-11 11:59:52', '2019-06-22 11:59:46'),
(109, 72, NULL, NULL, 'UKG', 'UKG', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC24', 1, '2019-06-11 12:03:40', '2019-06-21 22:31:19'),
(110, 74, NULL, NULL, '6th STD', '6th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC23', 1, '2019-06-11 12:31:06', '2019-06-25 11:13:28'),
(111, 75, NULL, NULL, 'LKG', 'LKG', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC23', 1, '2019-06-11 12:33:14', '2019-06-25 11:14:54'),
(112, 77, NULL, NULL, '1st PUC', '1st PUC', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC25', 1, '2019-06-12 04:24:18', '2019-06-12 11:58:10'),
(113, 78, NULL, NULL, '2nd PUC, Islamic Study course.', '2nd PUC, Islamic Study course.', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC25', 1, '2019-06-12 04:28:11', '2019-06-12 11:59:43'),
(114, 79, NULL, NULL, 'ITI (2nd Year)', 'ITI (2nd Year)', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC25', 1, '2019-06-12 04:30:37', '2019-06-12 11:55:31'),
(115, 80, NULL, NULL, '6th STD', '6th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC25', 1, '2019-06-12 04:39:08', '2019-06-25 11:19:53'),
(116, 82, NULL, NULL, '10th', '10th', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC26', 1, '2019-06-12 06:02:44', '2019-06-12 12:00:35'),
(117, 83, NULL, NULL, '8th STD', '8th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC25', 1, '2019-06-12 06:08:34', '2019-06-12 12:01:27'),
(118, 84, NULL, NULL, '9th STD', '9th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC25', 1, '2019-06-12 06:36:37', '2019-09-19 11:42:50'),
(119, 85, NULL, NULL, '3rd STD', '3rd STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC25', 1, '2019-06-12 06:42:57', '2019-06-22 12:19:21'),
(120, 87, NULL, NULL, '3rd STD', '3rd STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC27', 1, '2019-06-12 07:10:14', '2019-06-21 20:49:09'),
(121, 88, NULL, NULL, 'UKG', 'UKG', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC27', 1, '2019-06-12 07:13:44', '2019-06-21 20:47:22'),
(122, 90, NULL, NULL, 'PUC', 'PUC', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC28', 1, '2019-06-12 07:39:14', '2019-09-19 11:42:50'),
(123, 91, NULL, NULL, '4th STD', '4th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC28', 1, '2019-06-12 07:50:27', '2019-09-19 11:42:50'),
(124, 93, NULL, NULL, '7th STD', '7th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC30', 1, '2019-06-12 08:41:58', '2019-09-19 11:42:50'),
(125, 94, NULL, NULL, '10th STD', '10th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC30', 1, '2019-06-12 08:50:06', '2019-06-25 14:47:05'),
(126, 95, NULL, NULL, '6th STD', '6th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC30', 1, '2019-06-12 08:54:03', '2019-06-25 14:47:58'),
(127, 96, NULL, NULL, '4th STD', '4th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC30', 1, '2019-06-12 08:56:23', '2019-06-25 14:52:56'),
(128, 98, NULL, NULL, '8th sTD', '8th sTD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC29', 1, '2019-06-12 09:18:31', '2019-06-22 20:39:02'),
(129, 99, NULL, NULL, '4th STD', '4th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC29', 1, '2019-06-12 09:23:35', '2019-06-21 22:37:10'),
(130, 100, NULL, NULL, 'LKg', 'LKg', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC29', 1, '2019-06-12 09:31:02', '2019-06-21 22:35:29'),
(131, 102, NULL, NULL, '7th STD', '7th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC31', 1, '2019-06-12 09:49:52', '2019-06-25 15:00:59'),
(132, 103, NULL, NULL, '8th STD', '8th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC31', 1, '2019-06-12 09:59:09', '2019-06-25 15:02:11'),
(133, 105, NULL, NULL, '2nd STD', '2nd STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC32', 1, '2019-06-12 10:30:12', '2019-06-25 15:21:03'),
(134, 107, NULL, NULL, '10th', '10th', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC33', 1, '2019-06-12 10:51:45', '2019-06-12 17:21:56'),
(135, 108, NULL, NULL, '2nd PUC', '2nd PUC', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC33', 1, '2019-06-12 10:58:20', '2019-06-25 15:17:16'),
(136, 109, NULL, NULL, '33', '33', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC33', 1, '2019-06-12 11:03:52', '2019-06-22 20:32:00'),
(137, 110, NULL, NULL, '10th STD', '10th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC33', 1, '2019-06-13 05:40:42', '2019-06-22 12:57:13'),
(138, 112, NULL, NULL, '7th STD', '7th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC34', 1, '2019-06-13 07:58:00', '2019-09-19 11:42:50'),
(139, 113, NULL, NULL, '7th STD', '7th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC34', 1, '2019-06-13 08:30:36', '2019-09-19 11:42:50'),
(140, 115, NULL, NULL, '7th STD', '7th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC35', 1, '2019-06-13 10:14:42', '2019-06-25 15:23:15'),
(142, 117, NULL, NULL, '1st STD', '1st STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC18', 1, '2019-06-13 11:17:44', '2019-06-21 22:26:17'),
(144, 121, NULL, NULL, '8th STD', '8th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC13', 1, '2019-06-13 11:54:20', '2019-06-22 22:23:34'),
(145, 122, NULL, NULL, '10th', '10th', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC36', 1, '2019-06-14 11:26:58', '2019-06-25 15:27:22'),
(146, 124, NULL, NULL, '8th STD', '8th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC36', 1, '2019-06-14 11:54:26', '2019-06-22 20:24:14'),
(147, 126, NULL, NULL, '7th', '7th', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC37', 1, '2019-06-17 10:40:23', '2019-06-22 20:42:34'),
(148, 127, NULL, NULL, '9th STD', '9th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC37', 1, '2019-06-17 10:56:00', '2019-06-22 12:55:40'),
(149, 128, NULL, NULL, '10th STD', '10th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC37', 1, '2019-06-17 11:12:35', '2019-06-25 15:36:16'),
(150, 130, NULL, NULL, '2nd PUC', '2nd PUC', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC39', 1, '2019-06-20 05:36:56', '2019-06-25 15:41:26'),
(151, 131, NULL, NULL, '10th STD', '10th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC39', 1, '2019-06-20 05:39:39', '2019-06-22 12:41:05'),
(152, 133, NULL, NULL, '10th', '10th', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC40', 1, '2019-06-20 06:27:08', '2019-06-20 12:16:34'),
(153, 135, NULL, NULL, '5th', '5th', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC41', 1, '2019-06-20 06:45:15', '2019-06-20 12:17:23'),
(156, 142, NULL, NULL, '6th STD', '6th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC45', 1, '2019-06-20 08:27:59', '2019-06-25 15:54:49'),
(157, 143, NULL, NULL, '8th  STD', '8th  STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC44', 1, '2019-06-21 12:00:46', '2019-06-25 15:53:21'),
(159, 145, NULL, NULL, '6th STD', '6th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC21', 1, '2019-06-22 15:22:07', '2019-06-22 22:49:00'),
(160, 146, NULL, NULL, '9th STD', '9th STD', NULL, NULL, NULL, 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC42', 1, '2019-06-23 10:03:53', '2019-09-19 11:42:50'),
(161, 154, 1, 'rwrwer', '3', NULL, 'Pre-Primary', 'wefwe', 'wrw', 'Completed', '45', NULL, NULL, 'HSCC', 'HFSCC69', 1, '2019-10-13 02:49:47', '2019-10-13 02:49:47'),
(163, 163, 0, '', '5th', NULL, 'Primary', NULL, '', 'Completed', NULL, NULL, NULL, 'HSCC', 'HFSCC46', 1, '2019-10-16 12:04:15', '2019-10-16 12:04:15'),
(164, 7, 27, 'MCA', '3rd Year', 'MCA', 'PG', 'Maths', 'Science', 'Pursuing', NULL, 'MARKS_HFSCC01_6898244.png', 2019, 'HSCC', 'HFSCC01', 1, '2019-11-12 06:28:04', '2019-11-12 06:28:04'),
(165, 7, 0, 'MCA', '1rd Year', 'MCA', 'PG', 'Science', 'Maths', 'Completed', '98', 'MARKS_HFSCC01_6898244.png', 2016, 'HSCC', 'HFSCC01', 1, '2019-11-12 06:29:16', '2019-11-12 06:29:16'),
(166, 7, 0, '', '6', 'r5tg', 'Pre-Primary', NULL, '', 'Completed', '56', 'MARKS_HFSCC01_6898244.png', 2015, 'HSCC', 'HFSCC01', 1, '2019-11-21 06:44:10', '2019-11-21 06:44:10');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_health_status`
--

CREATE TABLE `tbl_health_status` (
  `id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `description` longtext NOT NULL,
  `hfid_link` varchar(150) NOT NULL,
  `fam_category` varchar(150) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_health_status`
--

INSERT INTO `tbl_health_status` (`id`, `person_id`, `description`, `hfid_link`, `fam_category`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 'Healthy', 'HFSCC01', 'HSCC', 1, '2019-06-07 10:31:54', '2019-06-08 16:08:07'),
(2, 8, 'Healthy', 'HFSCC03', 'HSCC', 1, '2019-06-08 05:54:44', '2019-09-16 14:56:36'),
(3, 11, 'Healthy', 'HFSCC02', 'HSCC', 1, '2019-06-08 06:28:30', '2019-09-16 14:56:36'),
(4, 13, 'Healthy', 'HFSCC04', 'HSCC', 1, '2019-06-08 07:28:07', '2019-09-16 14:56:36'),
(5, 15, 'Unhealthy', 'HFSCC05', 'HSCC', 1, '2019-06-08 10:06:54', '2019-09-16 14:56:36'),
(6, 16, 'Healthy', 'HFSCC06', 'HSCC', 1, '2019-06-08 10:42:57', '2019-09-12 09:24:57'),
(7, 19, 'Healthy', 'HFSCC07', 'HSCC', 1, '2019-06-08 11:44:17', '2019-09-16 14:56:36'),
(8, 23, 'Healthy', 'HFSCC08', 'HSCC', 1, '2019-06-08 12:34:06', '2019-09-16 14:56:36'),
(9, 32, 'Good', 'HFSCC09', 'HSCC', 1, '2019-06-09 05:45:54', '2019-09-16 14:56:36'),
(10, 34, 'Good (intellectual disability)', 'HFSCC10', 'HSCC', 1, '2019-06-09 06:52:08', '2019-06-10 16:26:11'),
(11, 36, 'Good', 'HFSCC11', 'HSCC', 1, '2019-06-09 08:10:42', '2019-09-16 14:56:36'),
(12, 38, 'Good', 'HFSCC12', 'HSCC', 1, '2019-06-09 09:31:29', '2019-09-16 14:56:36'),
(13, 42, 'Good', 'HFSCC13', 'HSCC', 1, '2019-06-09 10:37:22', '2019-09-16 14:56:36'),
(14, 45, 'Unhealthy', 'HFSCC14', 'HSCC', 1, '2019-06-09 11:26:36', '2019-06-10 16:30:53'),
(15, 47, 'Good', 'HFSCC15', 'HSCC', 1, '2019-06-09 11:49:57', '2019-06-10 16:03:05'),
(16, 48, 'Good', 'HFSCC16', 'HSCC', 1, '2019-06-10 10:53:30', '2019-09-16 14:56:36'),
(17, 49, 'unhealthy (Bed Ridden)', 'HFSCC17', 'HSCC', 1, '2019-06-10 11:25:52', '2019-06-10 16:58:48'),
(18, 50, 'Good', 'HFSCC18', 'HSCC', 1, '2019-06-10 11:53:37', '2019-09-16 14:56:36'),
(19, 57, 'Good', 'HFSCC19', 'HSCC', 1, '2019-06-11 09:12:01', '2019-09-16 14:56:36'),
(20, 61, 'Good', 'HFSCC20', 'HSCC', 1, '2019-06-11 09:48:29', '2019-06-12 09:23:56'),
(21, 63, 'good', 'HFSCC21', 'HSCC', 1, '2019-06-11 10:19:54', '2019-06-11 18:05:28'),
(22, 66, 'Good', 'HFSCC22', 'HSCC', 1, '2019-06-11 10:53:16', '2019-06-11 17:23:25'),
(23, 70, 'Good', 'HFSCC24', 'HSCC', 1, '2019-06-11 11:33:48', '2019-06-11 17:43:30'),
(24, 73, 'Good', 'HFSCC23', 'HSCC', 1, '2019-06-11 12:26:48', '2019-06-11 17:57:28'),
(25, 76, 'Good', 'HFSCC25', 'HSCC', 1, '2019-06-12 04:12:51', '2019-06-12 11:56:11'),
(26, 81, 'Diabetes', 'HFSCC26', 'HSCC', 1, '2019-06-12 05:20:48', '2019-06-12 12:02:28'),
(27, 86, 'Breathing Problem', 'HFSCC27', 'HSCC', 1, '2019-06-12 07:06:14', '2019-06-12 12:48:12'),
(28, 89, 'Good', 'HFSCC28', 'HSCC', 1, '2019-06-12 07:31:21', '2019-06-12 13:16:37'),
(29, 92, 'Good', 'HFSCC30', 'HSCC', 1, '2019-06-12 08:07:46', '2019-06-12 14:14:32'),
(30, 97, 'Good', 'HFSCC29', 'HSCC', 1, '2019-06-12 09:15:26', '2019-09-16 14:56:36'),
(31, 101, 'Breathing problem', 'HFSCC31', 'HSCC', 1, '2019-06-12 09:42:13', '2019-09-16 14:56:36'),
(32, 104, 'Good', 'HFSCC32', 'HSCC', 1, '2019-06-12 10:18:54', '2019-09-16 14:56:36'),
(33, 106, 'Good', 'HFSCC33', 'HSCC', 1, '2019-06-12 10:42:51', '2019-06-13 10:41:44'),
(34, 111, 'Good', 'HFSCC34', 'HSCC', 1, '2019-06-13 06:01:45', '2019-06-13 15:45:53'),
(35, 114, 'Good', 'HFSCC35', 'HSCC', 1, '2019-06-13 10:05:42', '2019-09-16 14:56:36'),
(36, 123, 'Good', 'HFSCC36', 'HSCC', 1, '2019-06-14 11:47:55', '2019-06-22 20:10:31'),
(37, 125, 'Good', 'HFSCC37', 'HSCC', 1, '2019-06-17 10:34:33', '2019-09-16 14:56:36'),
(38, 129, 'Good', 'HFSCC39', 'HSCC', 1, '2019-06-20 05:34:36', '2019-09-16 14:56:36'),
(39, 132, 'Good', 'HFSCC40', 'HSCC', 1, '2019-06-20 05:49:42', '2019-09-16 14:56:36'),
(40, 134, 'She is aged and have some health problems', 'HFSCC41', 'HSCC', 1, '2019-06-20 06:43:23', '2019-09-16 14:56:36'),
(41, 136, 'Good', 'HFSCC42', 'HSCC', 1, '2019-06-20 06:55:39', '2019-09-16 14:56:36'),
(42, 137, 'Good', 'HFSCC43', 'HSCC', 1, '2019-06-20 07:04:24', '2019-09-16 14:56:36'),
(43, 138, 'good', 'HFSCC45', 'HSCC', 1, '2019-06-20 07:24:32', '2019-09-16 14:56:36'),
(44, 139, 'unhealthy.', 'HFSCC44', 'HSCC', 1, '2019-06-20 07:36:30', '2019-09-16 14:56:36'),
(45, 5, 'Healthy', 'HFSCC01', 'HSCC', 1, '2019-06-07 11:09:07', '2019-06-22 22:09:36'),
(46, 6, 'Healthy', 'HFSCC01', 'HSCC', 1, '2019-06-07 11:11:59', '2019-06-22 11:01:43'),
(47, 7, 'Healthy', 'HFSCC01', 'HSCC', 1, '2019-06-07 11:45:30', '2019-06-22 22:10:35'),
(48, 9, 'Healthy', 'HFSCC03', 'HSCC', 1, '2019-06-08 06:00:06', '2019-09-19 11:30:06'),
(49, 10, 'Healthy', 'HFSCC03', 'HSCC', 1, '2019-06-08 06:06:01', '2019-06-08 13:24:08'),
(50, 12, 'Vision Problem', 'HFSCC02', 'HSCC', 1, '2019-06-08 07:07:14', '2019-06-22 22:12:22'),
(51, 14, 'Healthy', 'HFSCC04', 'HSCC', 1, '2019-06-08 07:49:50', '2019-06-08 16:09:13'),
(52, 17, 'Healthy', 'HFSCC05', 'HSCC', 1, '2019-06-08 10:59:43', '2019-06-23 16:56:47'),
(53, 18, 'Healthy', 'HFSCC05', 'HSCC', 1, '2019-06-08 11:04:18', '2019-06-13 16:03:50'),
(54, 20, 'Healthy', 'HFSCC07', 'HSCC', 1, '2019-06-08 11:53:00', '2019-06-23 17:04:08'),
(55, 21, 'Healthy', 'HFSCC07', 'HSCC', 1, '2019-06-08 11:56:20', '2019-06-23 17:11:03'),
(56, 22, 'Healthy', 'HFSCC07', 'HSCC', 1, '2019-06-08 12:04:05', '2019-06-23 17:20:06'),
(57, 24, 'Good', 'HFSCC08', 'HSCC', 1, '2019-06-09 04:38:39', '2019-06-23 17:21:30'),
(58, 25, 'Good', 'HFSCC08', 'HSCC', 1, '2019-06-09 04:40:54', '2019-06-23 17:22:22'),
(59, 26, 'Good', 'HFSCC08', 'HSCC', 1, '2019-06-09 04:44:04', '2019-06-25 10:52:29'),
(60, 27, 'Good', 'HFSCC08', 'HSCC', 1, '2019-06-09 04:46:03', '2019-06-25 10:56:39'),
(61, 28, 'Good', 'HFSCC06', 'HSCC', 1, '2019-06-09 04:56:49', '2019-06-09 10:33:38'),
(62, 29, 'Good', 'HFSCC06', 'HSCC', 1, '2019-06-09 05:01:02', '2019-09-19 11:30:06'),
(63, 30, 'Good', 'HFSCC06', 'HSCC', 1, '2019-06-09 05:06:31', '2019-06-22 11:14:01'),
(64, 31, 'Good', 'HFSCC06', 'HSCC', 1, '2019-06-09 05:20:17', '2019-09-19 11:30:06'),
(65, 33, 'Good', 'HFSCC09', 'HSCC', 1, '2019-06-09 06:23:50', '2019-06-22 22:21:10'),
(66, 35, 'Good', 'HFSCC10', 'HSCC', 1, '2019-06-09 07:21:46', '2019-09-19 11:30:06'),
(67, 37, 'Good', 'HFSCC11', 'HSCC', 1, '2019-06-09 08:59:21', '2019-06-22 12:48:19'),
(68, 39, 'Good', 'HFSCC11', 'HSCC', 1, '2019-06-09 09:45:45', '2019-06-22 20:30:12'),
(69, 40, 'Good', 'HFSCC12', 'HSCC', 1, '2019-06-09 09:53:43', '2019-06-22 12:07:06'),
(70, 41, 'Good', 'HFSCC12', 'HSCC', 1, '2019-06-09 10:07:04', '2019-06-22 22:19:55'),
(71, 43, 'Good', 'HFSCC13', 'HSCC', 1, '2019-06-09 10:57:28', '2019-06-22 22:28:38'),
(72, 44, 'Good', 'HFSCC13', 'HSCC', 1, '2019-06-09 11:06:18', '2019-06-22 22:30:14'),
(73, 46, 'Good', 'HFSCC14', 'HSCC', 1, '2019-06-09 11:34:38', '2019-06-22 22:33:00'),
(74, 51, 'Good', 'HFSCC15', 'HSCC', 1, '2019-06-11 05:01:25', '2019-06-22 11:14:48'),
(75, 52, 'Good', 'HFSCC15', 'HSCC', 1, '2019-06-11 05:08:51', '2019-06-22 22:35:38'),
(76, 53, 'Good', 'HFSCC16', 'HSCC', 1, '2019-06-11 05:20:55', '2019-06-22 22:06:57'),
(77, 54, 'Good', 'HFSCC16', 'HSCC', 1, '2019-06-11 05:37:21', '2019-06-22 22:07:38'),
(78, 55, 'Good', 'HFSCC18', 'HSCC', 1, '2019-06-11 05:47:39', '2019-06-21 22:27:49'),
(79, 56, 'Good', 'HFSCC18', 'HSCC', 1, '2019-06-11 05:53:18', '2019-06-21 22:29:09'),
(80, 58, 'Good', 'HFSCC19', 'HSCC', 1, '2019-06-11 09:24:42', '2019-06-22 22:43:48'),
(81, 59, 'Good', 'HFSCC19', 'HSCC', 1, '2019-06-11 09:28:08', '2019-06-22 22:43:10'),
(82, 60, 'Good', 'HFSCC19', 'HSCC', 1, '2019-06-11 09:32:04', '2019-06-22 13:00:49'),
(83, 62, 'Good', 'HFSCC20', 'HSCC', 1, '2019-06-11 09:57:47', '2019-09-12 11:56:23'),
(84, 64, 'Good', 'HFSCC21', 'HSCC', 1, '2019-06-11 10:23:06', '2019-09-19 11:30:06'),
(85, 65, 'Good', 'HFSCC21', 'HSCC', 1, '2019-06-11 10:26:33', '2019-09-19 11:30:06'),
(86, 67, 'Good', 'HFSCC22', 'HSCC', 1, '2019-06-11 10:59:14', '2019-06-22 11:22:18'),
(87, 68, 'good', 'HFSCC22', 'HSCC', 1, '2019-06-11 11:04:06', '2019-09-19 11:30:06'),
(88, 69, 'Good', 'HFSCC22', 'HSCC', 1, '2019-06-11 11:06:57', '2019-06-22 11:18:25'),
(89, 71, 'Good', 'HFSCC24', 'HSCC', 1, '2019-06-11 11:59:52', '2019-06-22 11:59:46'),
(90, 72, 'Good', 'HFSCC24', 'HSCC', 1, '2019-06-11 12:03:40', '2019-06-21 22:31:19'),
(91, 74, 'Good', 'HFSCC23', 'HSCC', 1, '2019-06-11 12:31:06', '2019-06-25 11:13:28'),
(92, 75, 'Good', 'HFSCC23', 'HSCC', 1, '2019-06-11 12:33:14', '2019-06-25 11:14:54'),
(93, 77, 'Good', 'HFSCC25', 'HSCC', 1, '2019-06-12 04:24:18', '2019-06-12 11:58:10'),
(94, 78, 'Good', 'HFSCC25', 'HSCC', 1, '2019-06-12 04:28:11', '2019-06-12 11:59:43'),
(95, 79, 'Good', 'HFSCC25', 'HSCC', 1, '2019-06-12 04:30:37', '2019-06-12 11:55:31'),
(96, 80, 'Good', 'HFSCC25', 'HSCC', 1, '2019-06-12 04:39:08', '2019-06-25 11:19:53'),
(97, 82, 'Stuttering, Blurred Vision.', 'HFSCC26', 'HSCC', 1, '2019-06-12 06:02:44', '2019-06-12 12:00:35'),
(98, 83, 'Good', 'HFSCC25', 'HSCC', 1, '2019-06-12 06:08:34', '2019-06-12 12:01:27'),
(99, 84, 'Good', 'HFSCC25', 'HSCC', 1, '2019-06-12 06:36:37', '2019-09-19 11:30:06'),
(100, 85, 'Good', 'HFSCC25', 'HSCC', 1, '2019-06-12 06:42:57', '2019-06-22 12:19:21'),
(101, 87, 'Good', 'HFSCC27', 'HSCC', 1, '2019-06-12 07:10:14', '2019-06-21 20:49:09'),
(102, 88, 'Good', 'HFSCC27', 'HSCC', 1, '2019-06-12 07:13:44', '2019-06-21 20:47:22'),
(103, 90, 'Good', 'HFSCC28', 'HSCC', 1, '2019-06-12 07:39:14', '2019-09-19 11:30:06'),
(104, 91, 'Good', 'HFSCC28', 'HSCC', 1, '2019-06-12 07:50:27', '2019-09-19 11:30:06'),
(105, 93, 'Kidney and Heart Problem', 'HFSCC30', 'HSCC', 1, '2019-06-12 08:41:58', '2019-09-19 11:30:06'),
(106, 94, 'Good', 'HFSCC30', 'HSCC', 1, '2019-06-12 08:50:06', '2019-06-25 14:47:05'),
(107, 95, 'Good', 'HFSCC30', 'HSCC', 1, '2019-06-12 08:54:03', '2019-06-25 14:47:58'),
(108, 96, 'Good', 'HFSCC30', 'HSCC', 1, '2019-06-12 08:56:23', '2019-06-25 14:52:56'),
(109, 98, 'Good', 'HFSCC29', 'HSCC', 1, '2019-06-12 09:18:31', '2019-06-22 20:39:02'),
(110, 99, 'Good', 'HFSCC29', 'HSCC', 1, '2019-06-12 09:23:35', '2019-06-21 22:37:10'),
(111, 100, 'Good', 'HFSCC29', 'HSCC', 1, '2019-06-12 09:31:02', '2019-06-21 22:35:29'),
(112, 102, 'Good', 'HFSCC31', 'HSCC', 1, '2019-06-12 09:49:52', '2019-06-25 15:00:59'),
(113, 103, 'Good', 'HFSCC31', 'HSCC', 1, '2019-06-12 09:59:09', '2019-06-25 15:02:11'),
(114, 105, 'Good', 'HFSCC32', 'HSCC', 1, '2019-06-12 10:30:12', '2019-06-25 15:21:03'),
(115, 107, 'Good', 'HFSCC33', 'HSCC', 1, '2019-06-12 10:51:45', '2019-06-12 17:21:56'),
(116, 108, 'Good', 'HFSCC33', 'HSCC', 1, '2019-06-12 10:58:20', '2019-06-25 15:17:16'),
(117, 109, 'Good', 'HFSCC33', 'HSCC', 1, '2019-06-12 11:03:52', '2019-06-22 20:32:00'),
(118, 110, 'Good', 'HFSCC33', 'HSCC', 1, '2019-06-13 05:40:42', '2019-06-22 12:57:13'),
(119, 112, 'Good', 'HFSCC34', 'HSCC', 1, '2019-06-13 07:58:00', '2019-09-19 11:30:06'),
(120, 113, 'Good', 'HFSCC34', 'HSCC', 1, '2019-06-13 08:30:36', '2019-09-19 11:30:06'),
(121, 115, 'Good', 'HFSCC35', 'HSCC', 1, '2019-06-13 10:14:42', '2019-06-25 15:23:15'),
(122, 116, 'Good', 'HFSCC35', 'HSCC', 1, '2019-06-13 11:15:01', '2019-09-19 11:30:06'),
(123, 117, 'Good', 'HFSCC18', 'HSCC', 1, '2019-06-13 11:17:44', '2019-06-21 22:26:17'),
(124, 120, 'Good', 'HFSCC15', 'HSCC', 1, '2019-06-13 11:27:04', '2019-09-19 11:30:06'),
(125, 121, 'Good', 'HFSCC13', 'HSCC', 1, '2019-06-13 11:54:20', '2019-06-22 22:23:34'),
(126, 122, 'Good', 'HFSCC36', 'HSCC', 1, '2019-06-14 11:26:58', '2019-06-25 15:27:22'),
(127, 124, 'Good', 'HFSCC36', 'HSCC', 1, '2019-06-14 11:54:26', '2019-06-22 20:24:14'),
(128, 126, 'Good', 'HFSCC37', 'HSCC', 1, '2019-06-17 10:40:23', '2019-06-22 20:42:34'),
(129, 127, 'Good', 'HFSCC37', 'HSCC', 1, '2019-06-17 10:56:00', '2019-06-22 12:55:40'),
(130, 128, 'Good', 'HFSCC37', 'HSCC', 1, '2019-06-17 11:12:35', '2019-06-25 15:36:16'),
(131, 130, 'Good', 'HFSCC39', 'HSCC', 1, '2019-06-20 05:36:56', '2019-06-25 15:41:26'),
(132, 131, 'Good', 'HFSCC39', 'HSCC', 1, '2019-06-20 05:39:39', '2019-06-22 12:41:05'),
(133, 133, 'Good', 'HFSCC40', 'HSCC', 1, '2019-06-20 06:27:08', '2019-06-20 12:16:34'),
(134, 135, 'Good', 'HFSCC41', 'HSCC', 1, '2019-06-20 06:45:15', '2019-06-20 12:17:23'),
(135, 140, 'Good', 'HFSCC22', 'HSCC', 1, '2019-06-20 07:54:49', '2019-09-19 11:30:06'),
(136, 141, 'Good', 'HFSCC22', 'HSCC', 1, '2019-06-20 07:56:34', '2019-09-19 11:30:06'),
(137, 142, 'Good', 'HFSCC45', 'HSCC', 1, '2019-06-20 08:27:59', '2019-06-25 15:54:49'),
(138, 143, 'Good', 'HFSCC44', 'HSCC', 1, '2019-06-21 12:00:46', '2019-06-25 15:53:21'),
(139, 144, 'Good', 'HFSCC29', 'HSCC', 1, '2019-06-22 05:39:30', '2019-09-19 11:30:06'),
(140, 145, 'Good', 'HFSCC21', 'HSCC', 1, '2019-06-22 15:22:07', '2019-06-22 22:49:00'),
(141, 146, 'Good', 'HFSCC42', 'HSCC', 1, '2019-06-23 10:03:53', '2019-09-19 11:30:06');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_history_status`
--

CREATE TABLE `tbl_history_status` (
  `id` int(11) NOT NULL,
  `fam_id` int(11) NOT NULL,
  `present_door` varchar(150) DEFAULT NULL,
  `reason` longtext,
  `ration_no` varchar(200) DEFAULT NULL,
  `ration_image` varchar(250) DEFAULT NULL,
  `familial_relation` varchar(200) NOT NULL,
  `income` int(11) NOT NULL,
  `income_source` varchar(250) DEFAULT NULL,
  `health_status` text,
  `shelter` varchar(200) NOT NULL,
  `self_reliant` varchar(50) NOT NULL,
  `fam_category` varchar(150) NOT NULL,
  `hfid_link` varchar(200) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_history_status`
--

INSERT INTO `tbl_history_status` (`id`, `fam_id`, `present_door`, `reason`, `ration_no`, `ration_image`, `familial_relation`, `income`, `income_source`, `health_status`, `shelter`, `self_reliant`, `fam_category`, `hfid_link`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, '1', 'Not', 'BLT14122115', 'RATION_HFSCC01_7361901.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Owned', 'Yes', 'HSCC', 'HFSCC01', 1, '2019-06-07 10:31:54', '2019-10-18 10:03:53'),
(2, 8, '1', 'Expired', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-08 05:54:44', '2019-10-10 07:09:47'),
(3, 11, '1', 'Her husband was not taking care of her and childre.', '', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-08 06:28:30', '2019-10-10 07:09:47'),
(4, 13, '1', 'Expired', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-08 07:28:07', '2019-10-10 07:09:47'),
(5, 15, '1', 'her Husband was mentally ill, he went somewhere an...', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-08 10:06:54', '2019-10-10 07:09:47'),
(6, 16, '02', '-', 'BLT14122115', NULL, 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC03', 1, '2019-06-08 10:42:57', '2019-10-10 07:09:47'),
(7, 19, '1', 'Her husband was not taking care of her and childre...', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-08 11:44:17', '2019-10-10 07:09:47'),
(8, 23, '1', 'Drug Addiction', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-08 12:34:06', '2019-10-10 07:09:47'),
(9, 32, '1', 'Her husband was Not Caring & supportive to her, an...', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-09 05:45:54', '2019-10-10 07:09:47'),
(10, 34, '1', 'Negligence towards Family.', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-09 06:52:08', '2019-10-10 07:09:47'),
(11, 36, '1', 'Expired', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-09 08:10:42', '2019-10-10 07:09:47'),
(12, 38, '1', 'He is not taking care of her,', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-09 09:31:29', '2019-10-10 07:09:47'),
(13, 42, '1', 'He was not taking care of her,', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-09 10:37:22', '2019-10-10 07:09:47'),
(14, 45, '1', 'Her husband have another wife and he is not taking...', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-09 11:26:36', '2019-10-10 07:09:47'),
(15, 47, '1', 'Expired', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-09 11:49:57', '2019-10-10 07:09:47'),
(16, 48, '1', 'Her Husband Is Alcoholic', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-10 10:53:30', '2019-10-10 07:09:47'),
(17, 49, '1', 'He was Not taken care of her, negligence of family...', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-10 11:25:52', '2019-10-10 07:09:47'),
(18, 50, '1', 'Expired', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-10 11:53:37', '2019-10-10 07:09:47'),
(19, 57, '1', 'Expired', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-11 09:12:01', '2019-10-10 07:09:47'),
(20, 61, '1', 'Her Husband showed negligence towards family. He w...', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-11 09:48:29', '2019-10-10 07:09:47'),
(21, 63, '1', 'Expired', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-11 10:19:54', '2019-10-10 07:09:47'),
(22, 66, '1', 'He is not supportive , and he  used to Torture her...', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-11 10:53:16', '2019-10-10 07:09:47'),
(23, 70, '1', 'Extra Marital Affairs.', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-11 11:33:48', '2019-10-10 07:09:47'),
(24, 73, '1', 'Negligence Towards Family', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-11 12:26:48', '2019-10-10 07:09:47'),
(25, 76, '1', 'Not Separated', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-12 04:12:51', '2019-10-10 07:09:47'),
(26, 81, '1', 'Expired', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-12 05:20:48', '2019-10-10 07:09:47'),
(27, 86, '1', 'Expired', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-12 07:06:14', '2019-10-10 07:09:47'),
(28, 89, '1', 'He was not Taking care of her and children\'s. he h...', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-12 07:31:21', '2019-10-10 07:09:47'),
(29, 92, '1', 'Not separated', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-12 08:07:46', '2019-10-10 07:09:47'),
(30, 97, '1', 'he is an drug addicted person,  He Used to torture...', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-12 09:15:26', '2019-10-10 07:09:47'),
(31, 101, '1', 'Expired', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-12 09:42:13', '2019-10-10 07:09:47'),
(32, 104, '1', 'Extra Marital status, Negligence towards Family.', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-12 10:18:54', '2019-10-10 07:09:47'),
(33, 106, '1', 'Her husband is an alcoholic', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-12 10:42:51', '2019-10-10 07:09:47'),
(34, 111, '1', '-', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-13 06:01:45', '2019-10-10 07:09:47'),
(35, 114, '1', 'Not separated', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-13 10:05:42', '2019-10-10 07:09:47'),
(36, 123, '1', 'he is not Taking care of her, he has extra marital...', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-14 11:47:55', '2019-10-10 07:09:47'),
(37, 125, '1', 'Expired', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-17 10:34:33', '2019-10-10 07:09:47'),
(38, 129, '1', 'Expired', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-20 05:34:36', '2019-10-10 07:09:47'),
(39, 132, '1', 'Expired', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-20 05:49:42', '2019-10-10 07:09:47'),
(40, 134, '1', 'Expired', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-20 06:43:23', '2019-10-10 07:09:47'),
(41, 136, '1', 'Expired', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-20 06:55:39', '2019-10-10 07:09:47'),
(42, 137, '1', 'Expired', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-20 07:04:24', '2019-10-10 07:09:47'),
(43, 138, '1', 'Expired', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-20 07:24:32', '2019-10-10 07:09:47'),
(44, 139, '1', 'He is an Alcoholic , he was not taken care of her,...', 'BLT14122115', 'RATION_HFSCC02_1529351.png', 'Abandoned', 15000, 'beedi rolling', 'Good', 'Rent', 'Yes', 'HSCC', 'HFSCC02', 1, '2019-06-20 07:36:30', '2019-10-10 07:09:47'),
(45, 154, '67', NULL, 'fd334535dcsdc', NULL, 'Abandoned', 62656565, '34r34r', 'Select', 'Owned', 'No', 'HSCC', 'HFSCC69', 1, '2019-10-13 02:36:01', '2019-10-13 02:36:01'),
(48, 163, '46', 'Her Husband drug addict', 'HASI00149668', NULL, 'Abandoned', 11000, 'Beedi Rolling', 'Healthy', 'Owned', 'Yes', 'HSCC', 'HFSCC46', 1, '2019-10-16 12:04:15', '2019-10-16 12:04:15');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_huqooq_allah`
--

CREATE TABLE `tbl_huqooq_allah` (
  `id` int(11) NOT NULL,
  `spiritual_id` int(11) NOT NULL,
  `salah` int(11) NOT NULL,
  `saum` int(11) NOT NULL,
  `zakath` int(11) DEFAULT '0',
  `person_id` int(11) NOT NULL,
  `h_year` date NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `type` varchar(150) NOT NULL,
  `hfid` varchar(150) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_huqooq_allah`
--

INSERT INTO `tbl_huqooq_allah` (`id`, `spiritual_id`, `salah`, `saum`, `zakath`, `person_id`, `h_year`, `status`, `type`, `hfid`, `created_at`, `updated_at`) VALUES
(1, 1, 20, 40, NULL, 7, '0000-00-00', 1, 'HSCC', 'HFSCC01', NULL, '2019-11-13 08:32:40'),
(3, 1, 60, 40, NULL, 7, '2018-11-06', 1, 'HSCC', 'HFSCC01', '2019-11-14 05:17:01', '2019-11-14 05:17:01'),
(4, 1, 80, 60, 0, 7, '2019-11-14', 1, 'HSCC', 'HFSCC01', '2019-11-14 06:01:33', '2019-11-14 06:01:33');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_huqooq_ibaadh`
--

CREATE TABLE `tbl_huqooq_ibaadh` (
  `id` int(11) NOT NULL,
  `spiritual_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `physical` int(11) NOT NULL,
  `finance` int(11) NOT NULL,
  `intellectual` int(11) NOT NULL,
  `ibaadh_year` date NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `hfid` varchar(150) NOT NULL,
  `type` varchar(150) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_huqooq_ibaadh`
--

INSERT INTO `tbl_huqooq_ibaadh` (`id`, `spiritual_id`, `person_id`, `physical`, `finance`, `intellectual`, `ibaadh_year`, `status`, `hfid`, `type`, `created_at`, `updated_at`) VALUES
(1, 2, 7, 40, 60, 20, '0000-00-00', 1, 'HFSCC01', 'HSCC', '2019-11-13 08:33:35', '2019-11-13 08:33:35'),
(3, 2, 7, 80, 60, 100, '2018-11-13', 1, 'HFSCC01', 'HSCC', '2019-11-14 05:28:57', '2019-11-14 05:28:57'),
(4, 2, 7, 80, 80, 80, '2019-11-14', 1, 'HFSCC01', 'HSCC', '2019-11-14 06:01:33', '2019-11-14 06:01:33');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_institutions_infos`
--

CREATE TABLE `tbl_institutions_infos` (
  `id` int(11) NOT NULL,
  `institution_name` text NOT NULL,
  `location` varchar(250) NOT NULL,
  `sector` varchar(200) DEFAULT NULL,
  `institution_category` varchar(200) DEFAULT NULL,
  `community_type` varchar(100) DEFAULT NULL,
  `street` longtext,
  `city` varchar(250) DEFAULT NULL,
  `district` varchar(200) DEFAULT NULL,
  `state` varchar(200) DEFAULT NULL,
  `nation` varchar(200) NOT NULL DEFAULT 'India',
  `pin_code` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_institutions_infos`
--

INSERT INTO `tbl_institutions_infos` (`id`, `institution_name`, `location`, `sector`, `institution_category`, `community_type`, `street`, `city`, `district`, `state`, `nation`, `pin_code`, `status`, `created_at`, `updated_at`) VALUES
(1, 'AIMIT', 'Beeri', 'Government', 'CBSE', 'Community', NULL, NULL, NULL, NULL, 'India', NULL, 1, '2019-10-04 12:59:41', '2019-10-13 02:49:47'),
(27, 'KIMS', 'Deralakatte', 'Private', 'Community', 'Other', 'Kanachure, Deralakatte', 'Bantval', 'Dakshina Kannada', 'Karnataka', 'India', 574231, 1, '2019-10-04 12:59:41', '2019-11-12 06:28:04');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_lifeskills`
--

CREATE TABLE `tbl_lifeskills` (
  `id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `surveying` varchar(100) DEFAULT NULL,
  `networking` varchar(100) DEFAULT NULL,
  `managing` varchar(100) DEFAULT NULL,
  `leadership` varchar(100) DEFAULT NULL,
  `communication` varchar(100) DEFAULT NULL,
  `organising` varchar(100) DEFAULT NULL,
  `team_player` varchar(100) DEFAULT NULL,
  `fam_category` varchar(100) NOT NULL,
  `hfid_link` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_lifeskills`
--

INSERT INTO `tbl_lifeskills` (`id`, `person_id`, `surveying`, `networking`, `managing`, `leadership`, `communication`, `organising`, `team_player`, `fam_category`, `hfid_link`, `status`, `created_at`, `updated_at`) VALUES
(1, 5, '87', '96', '25', '45', '87', '65', '98', 'HSCC', 'HFSCC01', 1, '2019-09-27 21:24:00', '2019-09-28 09:24:22');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_lifeskills_eval`
--

CREATE TABLE `tbl_lifeskills_eval` (
  `id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `servaying_feasibility` int(11) NOT NULL,
  `networking` int(11) NOT NULL,
  `managing` int(11) NOT NULL,
  `leadership` int(11) NOT NULL,
  `communication` int(11) NOT NULL,
  `organising` int(11) NOT NULL,
  `team_player` int(11) NOT NULL,
  `lifeskill_year` date NOT NULL,
  `hfid` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_lifeskills_eval`
--

INSERT INTO `tbl_lifeskills_eval` (`id`, `person_id`, `servaying_feasibility`, `networking`, `managing`, `leadership`, `communication`, `organising`, `team_player`, `lifeskill_year`, `hfid`, `type`, `status`, `created_at`, `updated_at`) VALUES
(1, 7, 20, 20, 40, 80, 0, 60, 40, '2019-02-16', 'HFSCC01', 'HSCC', 1, '2019-11-16 09:59:04', '2019-11-16 09:59:04'),
(2, 7, 40, 60, 100, 60, 60, 60, 40, '2018-04-17', 'HFSCC01', 'HSCC', 1, '2019-11-16 10:06:23', '2019-11-16 10:06:23');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_madrasa_education`
--

CREATE TABLE `tbl_madrasa_education` (
  `id` int(11) NOT NULL,
  `spiritual_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_madrasa_education`
--

INSERT INTO `tbl_madrasa_education` (`id`, `spiritual_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 3, 'Academics', '2019-09-27 21:13:00', '2019-09-28 09:12:57'),
(2, 3, 'Tarbiyyah/ Practice', '2019-11-13 08:58:08', '2019-11-13 08:58:08');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pincode`
--

CREATE TABLE `tbl_pincode` (
  `id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `pincode` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_project_beneficiaries`
--

CREATE TABLE `tbl_project_beneficiaries` (
  `id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `food` longtext,
  `health` longtext,
  `education` longtext,
  `self_reliant` longtext,
  `infrastructure` longtext,
  `beneficiary_type` varchar(50) NOT NULL,
  `fam_category` varchar(100) NOT NULL,
  `hfid_link` varchar(150) NOT NULL,
  `progress_status` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_project_beneficiaries`
--

INSERT INTO `tbl_project_beneficiaries` (`id`, `person_id`, `food`, `health`, `education`, `self_reliant`, `infrastructure`, `beneficiary_type`, `fam_category`, `hfid_link`, `progress_status`, `status`, `created_at`, `updated_at`) VALUES
(3, 4, 'Monthly Ration', 'Breathing Problerm', 'She wants to Study\r\n', 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC01', 1, 1, '2019-06-07 10:31:54', '2019-09-24 14:11:45'),
(4, 8, 'Getting Monthly Ration', NULL, NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC03', 1, 1, '2019-06-08 05:54:44', '2019-09-24 14:49:06'),
(5, 11, 'Monthly Ration', NULL, NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC02', 1, 1, '2019-06-08 06:28:30', '2019-09-16 12:55:30'),
(6, 13, 'Monthly Ration', NULL, NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC04', 1, 1, '2019-06-08 07:28:07', '2019-09-16 12:55:30'),
(7, 15, 'Monthly Ration', 'Treatment for health issues', NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC05', 1, 1, '2019-06-08 10:06:54', '2019-09-16 12:55:30'),
(8, 16, 'Monthly Ration', NULL, NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC06', 1, 1, '2019-06-08 10:42:57', '2019-09-12 09:24:57'),
(9, 19, 'Monthly Ration', NULL, NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC07', 1, 1, '2019-06-08 11:44:17', '2019-09-16 12:55:30'),
(10, 23, 'Monthly Ration', NULL, NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC08', 1, 1, '2019-06-08 12:34:06', '2019-09-16 12:55:30'),
(11, 32, 'Monthly Ration', NULL, NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC09', 1, 1, '2019-06-09 05:45:54', '2019-09-16 12:55:30'),
(12, 34, 'Monthly Ration', NULL, NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC10', 1, 1, '2019-06-09 06:52:08', '2019-06-10 16:26:11'),
(13, 36, 'Monthly Ration', NULL, NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC11', 1, 1, '2019-06-09 08:10:42', '2019-09-16 12:55:30'),
(14, 38, 'Monthly Ration', NULL, NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC12', 1, 1, '2019-06-09 09:31:29', '2019-09-16 12:55:30'),
(15, 42, 'Monthly Ration', NULL, NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC13', 1, 1, '2019-06-09 10:37:22', '2019-09-16 12:55:30'),
(16, 45, 'Monthly Ration', 'Her One eye is blind , She need the medical treatm', NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC14', 1, 1, '2019-06-09 11:26:36', '2019-06-10 16:30:53'),
(17, 47, 'Monthly Ration', NULL, NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC15', 1, 1, '2019-06-09 11:49:57', '2019-06-10 16:03:05'),
(18, 48, 'Monthly Ration', NULL, NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC16', 1, 1, '2019-06-10 10:53:30', '2019-09-16 12:55:30'),
(19, 49, 'Monthly Ration', 'Medical Treatment', NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC17', 1, 1, '2019-06-10 11:25:52', '2019-06-10 16:58:48'),
(20, 50, 'Monthly Ration', NULL, NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', '', 0, 1, '2019-06-10 11:53:37', '2019-09-16 12:55:30'),
(21, 19, 'Monthly Ration', NULL, NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC19', 1, 1, '2019-06-11 09:12:01', '2019-09-16 12:55:30'),
(22, 20, 'Monthly Ration', 'Medical Treatments for Daughter', NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC20', 1, 1, '2019-06-11 09:48:29', '2019-06-12 09:23:56'),
(23, 21, 'Monthly Ration', NULL, NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC21', 1, 1, '2019-06-11 10:19:54', '2019-06-11 18:05:28'),
(24, 22, 'Monthly Ration', NULL, NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC22', 1, 1, '2019-06-11 10:53:16', '2019-06-11 17:23:25'),
(25, 24, 'Monthly Ration', NULL, NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC24', 1, 1, '2019-06-11 11:33:48', '2019-06-11 17:43:30'),
(26, 23, 'Monthly Ration', NULL, NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC23', 1, 1, '2019-06-11 12:26:48', '2019-06-11 17:57:28'),
(27, 25, 'Monthly Ration', NULL, NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC25', 1, 1, '2019-06-12 04:12:51', '2019-06-12 11:56:11'),
(28, 81, 'Monthly Ration', 'Medical Treatments (Diabetes)', NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC26', 1, 1, '2019-06-12 05:20:48', '2019-06-12 12:02:28'),
(29, 86, 'Monthly Ration', NULL, NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC27', 1, 1, '2019-06-12 07:06:14', '2019-06-12 12:48:12'),
(30, 28, 'Monthly Ration', NULL, NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC28', 1, 1, '2019-06-12 07:31:21', '2019-06-12 13:16:37'),
(31, 30, 'Monthly Ration', NULL, NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC30', 1, 1, '2019-06-12 08:07:46', '2019-06-12 14:14:32'),
(32, 29, 'Monthly Ration', NULL, NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC29', 1, 1, '2019-06-12 09:15:26', '2019-09-16 12:55:30'),
(33, 31, 'Monthly Ration', NULL, NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC31', 1, 1, '2019-06-12 09:42:13', '2019-09-16 12:55:30'),
(34, 32, 'Monthly Ration', NULL, NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC32', 1, 1, '2019-06-12 10:18:54', '2019-09-16 12:55:30'),
(35, 33, 'Monthly Ration', NULL, NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC33', 1, 1, '2019-06-12 10:42:51', '2019-06-13 10:41:44'),
(36, 34, 'Monthly Ration', NULL, NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC34', 1, 1, '2019-06-13 06:01:45', '2019-06-13 15:45:53'),
(37, 35, 'Monthly Ration', NULL, NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC35', 1, 1, '2019-06-13 10:05:42', '2019-09-16 12:55:30'),
(38, 36, 'Monthly Ration', NULL, NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC36', 1, 1, '2019-06-14 11:47:55', '2019-06-22 20:10:31'),
(39, 37, 'Monthly Ration', NULL, NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC37', 1, 1, '2019-06-17 10:34:33', '2019-09-16 12:55:30'),
(40, 39, 'Monthly Ration', NULL, NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC39', 1, 1, '2019-06-20 05:34:36', '2019-09-16 12:55:30'),
(41, 40, 'Monthly Ration', NULL, NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC40', 1, 1, '2019-06-20 05:49:42', '2019-09-16 12:55:30'),
(42, 41, 'Monthly Ration', NULL, NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC41', 1, 1, '2019-06-20 06:43:23', '2019-09-16 12:55:30'),
(43, 42, 'Monthly Ration', NULL, NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC42', 1, 1, '2019-06-20 06:55:39', '2019-09-16 12:55:30'),
(44, 43, 'Monthly Ration', NULL, NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC43', 1, 1, '2019-06-20 07:04:24', '2019-09-16 12:55:30'),
(45, 45, 'Monthly Ration', NULL, NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC45', 1, 1, '2019-06-20 07:24:32', '2019-09-16 12:55:30'),
(46, 44, 'Monthly Ration', 'Treatment for health issues', NULL, 'Free house, Free water supply, Self-help Group', NULL, 'service', 'HSCC', 'HFSCC44', 1, 1, '2019-06-20 07:36:30', '2019-09-16 12:55:30');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ration`
--

CREATE TABLE `tbl_ration` (
  `id` int(11) NOT NULL,
  `donor_id` int(11) NOT NULL,
  `benificiary_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `amount` bigint(20) NOT NULL,
  `proj_category` varchar(150) NOT NULL,
  `beneficiery_type` varchar(150) NOT NULL,
  `status` int(11) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_service_conserns`
--

CREATE TABLE `tbl_service_conserns` (
  `id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `description` longtext NOT NULL,
  `project_type` varchar(150) NOT NULL,
  `service_type` varchar(150) NOT NULL,
  `fam_category` varchar(150) NOT NULL,
  `hfid_link` varchar(150) NOT NULL,
  `progress_status` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '1',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_service_conserns`
--

INSERT INTO `tbl_service_conserns` (`id`, `person_id`, `description`, `project_type`, `service_type`, `fam_category`, `hfid_link`, `progress_status`, `status`, `updated_at`, `created_at`) VALUES
(1, 4, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC01', 1, 1, '2019-10-17 06:41:26', '2019-06-07 10:31:54'),
(2, 4, 'Getting Monthly Ration', 'food', 'concern', 'HSCC', 'HFSCC01', 1, 1, '2019-09-24 14:49:06', '2019-06-08 05:54:44'),
(3, 11, 'Monthly Ration', 'health', 'service', 'HSCC', 'HFSCC02', 1, 1, '2019-10-10 07:09:47', '2019-06-08 06:28:30'),
(4, 13, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC04', 1, 1, '2019-09-16 12:55:30', '2019-06-08 07:28:07'),
(5, 15, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC05', 1, 1, '2019-09-16 12:55:30', '2019-06-08 10:06:54'),
(6, 16, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC06', 1, 1, '2019-09-12 09:24:57', '2019-06-08 10:42:57'),
(7, 19, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC07', 1, 1, '2019-09-16 12:55:30', '2019-06-08 11:44:17'),
(8, 23, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC08', 1, 1, '2019-09-16 12:55:30', '2019-06-08 12:34:06'),
(9, 32, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC09', 1, 1, '2019-09-16 12:55:30', '2019-06-09 05:45:54'),
(10, 34, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC10', 1, 1, '2019-06-10 16:26:11', '2019-06-09 06:52:08'),
(11, 36, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC11', 1, 1, '2019-09-16 12:55:30', '2019-06-09 08:10:42'),
(12, 38, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC12', 1, 1, '2019-09-16 12:55:30', '2019-06-09 09:31:29'),
(13, 42, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC13', 1, 1, '2019-09-16 12:55:30', '2019-06-09 10:37:22'),
(14, 45, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC14', 1, 1, '2019-06-10 16:30:53', '2019-06-09 11:26:36'),
(15, 47, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC15', 1, 1, '2019-06-10 16:03:05', '2019-06-09 11:49:57'),
(16, 48, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC16', 1, 1, '2019-09-16 12:55:30', '2019-06-10 10:53:30'),
(17, 49, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC17', 1, 1, '2019-06-10 16:58:48', '2019-06-10 11:25:52'),
(18, 50, 'Monthly Ration', 'food', 'service', 'HSCC', '', 0, 1, '2019-09-16 12:55:30', '2019-06-10 11:53:37'),
(19, 19, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC19', 1, 1, '2019-09-16 12:55:30', '2019-06-11 09:12:01'),
(20, 20, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC20', 1, 1, '2019-06-12 09:23:56', '2019-06-11 09:48:29'),
(21, 21, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC21', 1, 1, '2019-06-11 18:05:28', '2019-06-11 10:19:54'),
(22, 22, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC22', 1, 1, '2019-06-11 17:23:25', '2019-06-11 10:53:16'),
(23, 24, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC24', 1, 1, '2019-06-11 17:43:30', '2019-06-11 11:33:48'),
(24, 23, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC23', 1, 1, '2019-06-11 17:57:28', '2019-06-11 12:26:48'),
(25, 25, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC25', 1, 1, '2019-06-12 11:56:11', '2019-06-12 04:12:51'),
(26, 81, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC26', 1, 1, '2019-06-12 12:02:28', '2019-06-12 05:20:48'),
(27, 86, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC27', 1, 1, '2019-06-12 12:48:12', '2019-06-12 07:06:14'),
(28, 28, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC28', 1, 1, '2019-06-12 13:16:37', '2019-06-12 07:31:21'),
(29, 30, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC30', 1, 1, '2019-06-12 14:14:32', '2019-06-12 08:07:46'),
(30, 29, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC29', 1, 1, '2019-09-16 12:55:30', '2019-06-12 09:15:26'),
(31, 31, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC31', 1, 1, '2019-09-16 12:55:30', '2019-06-12 09:42:13'),
(32, 32, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC32', 1, 1, '2019-09-16 12:55:30', '2019-06-12 10:18:54'),
(33, 33, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC33', 1, 1, '2019-06-13 10:41:44', '2019-06-12 10:42:51'),
(34, 34, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC34', 1, 1, '2019-06-13 15:45:53', '2019-06-13 06:01:45'),
(35, 35, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC35', 1, 1, '2019-09-16 12:55:30', '2019-06-13 10:05:42'),
(36, 36, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC36', 1, 1, '2019-06-22 20:10:31', '2019-06-14 11:47:55'),
(37, 37, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC37', 1, 1, '2019-09-16 12:55:30', '2019-06-17 10:34:33'),
(38, 39, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC39', 1, 1, '2019-09-16 12:55:30', '2019-06-20 05:34:36'),
(39, 40, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC40', 1, 1, '2019-09-16 12:55:30', '2019-06-20 05:49:42'),
(40, 41, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC41', 1, 1, '2019-09-16 12:55:30', '2019-06-20 06:43:23'),
(41, 42, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC42', 1, 1, '2019-09-16 12:55:30', '2019-06-20 06:55:39'),
(42, 43, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC43', 1, 1, '2019-09-16 12:55:30', '2019-06-20 07:04:24'),
(43, 45, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC45', 1, 1, '2019-09-16 12:55:30', '2019-06-20 07:24:32'),
(44, 44, 'Monthly Ration', 'food', 'service', 'HSCC', 'HFSCC44', 1, 1, '2019-09-16 12:55:30', '2019-06-20 07:36:30'),
(64, 4, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC01', 1, 1, '2019-10-18 10:03:53', '2019-06-07 10:31:54'),
(65, 8, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC03', 1, 1, '2019-09-24 14:49:06', '2019-06-08 05:54:44'),
(66, 11, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC02', 1, 1, '2019-10-10 07:09:47', '2019-06-08 06:28:30'),
(67, 13, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC04', 1, 1, '2019-09-16 12:55:30', '2019-06-08 07:28:07'),
(68, 5, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC05', 1, 1, '2019-09-16 12:55:30', '2019-06-08 10:06:54'),
(69, 6, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC06', 1, 1, '2019-09-12 09:24:57', '2019-06-08 10:42:57'),
(70, 7, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC07', 1, 1, '2019-09-16 12:55:30', '2019-06-08 11:44:17'),
(74, 11, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC11', 1, 1, '2019-09-16 12:55:30', '2019-06-09 08:10:42'),
(75, 12, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC12', 1, 1, '2019-09-16 12:55:30', '2019-06-09 09:31:29'),
(76, 13, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC13', 1, 1, '2019-09-16 12:55:30', '2019-06-09 10:37:22'),
(77, 14, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC14', 1, 1, '2019-06-10 16:30:53', '2019-06-09 11:26:36'),
(78, 15, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC15', 1, 1, '2019-06-10 16:03:05', '2019-06-09 11:49:57'),
(79, 16, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC16', 1, 1, '2019-09-16 12:55:30', '2019-06-10 10:53:30'),
(80, 17, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC17', 1, 1, '2019-06-10 16:58:48', '2019-06-10 11:25:52'),
(81, 18, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC18', 1, 1, '2019-09-16 12:55:30', '2019-06-10 11:53:37'),
(82, 19, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC19', 1, 1, '2019-09-16 12:55:30', '2019-06-11 09:12:01'),
(83, 20, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC20', 1, 1, '2019-06-12 09:23:56', '2019-06-11 09:48:29'),
(84, 21, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC21', 1, 1, '2019-06-11 18:05:28', '2019-06-11 10:19:54'),
(85, 22, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC22', 1, 1, '2019-06-11 17:23:25', '2019-06-11 10:53:16'),
(86, 24, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC24', 1, 1, '2019-06-11 17:43:30', '2019-06-11 11:33:48'),
(87, 23, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC23', 1, 1, '2019-06-11 17:57:28', '2019-06-11 12:26:48'),
(88, 25, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC25', 1, 1, '2019-06-12 11:56:11', '2019-06-12 04:12:51'),
(89, 26, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC26', 1, 1, '2019-06-12 12:02:28', '2019-06-12 05:20:48'),
(90, 27, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC27', 1, 1, '2019-06-12 12:48:12', '2019-06-12 07:06:14'),
(91, 28, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC28', 1, 1, '2019-06-12 13:16:37', '2019-06-12 07:31:21'),
(92, 30, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC30', 1, 1, '2019-06-12 14:14:32', '2019-06-12 08:07:46'),
(93, 29, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC29', 1, 1, '2019-09-16 12:55:30', '2019-06-12 09:15:26'),
(94, 31, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC31', 1, 1, '2019-09-16 12:55:30', '2019-06-12 09:42:13'),
(95, 32, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC32', 1, 1, '2019-09-16 12:55:30', '2019-06-12 10:18:54'),
(96, 33, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC33', 1, 1, '2019-06-13 10:41:44', '2019-06-12 10:42:51'),
(97, 34, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC34', 1, 1, '2019-06-13 15:45:53', '2019-06-13 06:01:45'),
(98, 35, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC35', 1, 1, '2019-09-16 12:55:30', '2019-06-13 10:05:42'),
(99, 36, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC36', 1, 1, '2019-06-22 20:10:31', '2019-06-14 11:47:55'),
(100, 37, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC37', 1, 1, '2019-09-16 12:55:30', '2019-06-17 10:34:33'),
(101, 39, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC39', 1, 1, '2019-09-16 12:55:30', '2019-06-20 05:34:36'),
(102, 40, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC40', 1, 1, '2019-09-16 12:55:30', '2019-06-20 05:49:42'),
(103, 41, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC41', 1, 1, '2019-09-16 12:55:30', '2019-06-20 06:43:23'),
(104, 42, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC42', 1, 1, '2019-09-16 12:55:30', '2019-06-20 06:55:39'),
(105, 43, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC43', 1, 1, '2019-09-16 12:55:30', '2019-06-20 07:04:24'),
(106, 45, 'Free house, Free water supply, Self-help Group', 'self-reliant', 'service', 'HSCC', 'HFSCC45', 1, 1, '2019-09-16 12:55:30', '2019-06-20 07:24:32'),
(107, 44, 'Free house, Free water supply, Self-help Group', 'self-reliance', 'service', 'HSCC', 'HFSCC44', 1, 1, '2019-09-16 12:55:30', '2019-06-20 07:36:30'),
(127, 4, 'Breathing Problerm', 'health', 'concern', 'HSCC', 'HFSCC01', 1, 1, '2019-10-18 10:03:53', '2019-06-08 05:54:44'),
(128, 15, 'Treatment for health issues', 'health', 'concern', 'HSCC', 'HFSCC05', 1, 1, '2019-09-16 12:55:30', '2019-06-08 10:06:54'),
(129, 4, 'She wants to Study', 'education', 'concern', 'HSCC', 'HFSCC01', 1, 1, '2019-10-18 10:03:53', '2019-06-09 05:45:54'),
(130, 45, 'Her One eye is blind , She need the medical treatment.', 'health', 'concern', 'HSCC', 'HFSCC14', 1, 1, '2019-06-10 16:30:53', '2019-06-09 11:26:36'),
(131, 49, 'Medical Treatment', 'health', 'concern', 'HSCC', 'HFSCC17', 1, 1, '2019-06-10 16:58:48', '2019-06-10 11:25:52'),
(132, 61, 'Medical Treatments for Daughter', 'health', 'concern', 'HSCC', 'HFSCC20', 1, 1, '2019-06-12 09:23:56', '2019-06-11 09:48:29'),
(133, 81, 'Medical Treatments (Diabetes)', 'health', 'concern', 'HSCC', 'HFSCC26', 1, 1, '2019-06-12 12:02:28', '2019-06-12 05:20:48'),
(134, 139, 'Treatment for health issues', 'health', 'concern', 'HSCC', 'HFSCC44', 1, 1, '2019-09-16 12:55:30', '2019-06-20 07:36:30');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_spiritual_assessments`
--

CREATE TABLE `tbl_spiritual_assessments` (
  `id` int(11) NOT NULL,
  `stud_id` int(11) NOT NULL,
  `salah` varchar(100) DEFAULT NULL,
  `saum` varchar(100) DEFAULT NULL,
  `physical` varchar(100) DEFAULT NULL,
  `finance` varchar(100) DEFAULT NULL,
  `intellectual` varchar(100) DEFAULT NULL,
  `hfid_link` varchar(100) DEFAULT NULL,
  `fam_category` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_spiritual_assessments`
--

INSERT INTO `tbl_spiritual_assessments` (`id`, `stud_id`, `salah`, `saum`, `physical`, `finance`, `intellectual`, `hfid_link`, `fam_category`, `status`, `created_at`, `updated_at`) VALUES
(1, 5, '56', '78', '50', '98', '45', 'HFSCC01', 'HSCC', 1, '2019-09-27 21:10:18', '2019-09-28 09:10:51');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_spiritual_development`
--

CREATE TABLE `tbl_spiritual_development` (
  `id` int(11) NOT NULL,
  `assess_id` int(11) NOT NULL,
  `spiritual_name` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_spiritual_development`
--

INSERT INTO `tbl_spiritual_development` (`id`, `assess_id`, `spiritual_name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Huqooq-Allah', '2019-11-13 08:28:29', '2019-11-13 08:28:29'),
(2, 1, 'Huqooq-Ul-Ibaadh', '2019-11-13 08:29:15', '2019-11-13 08:29:15'),
(3, 1, 'Madrasa Education', '2019-11-13 08:29:49', '2019-11-13 08:29:49');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_state`
--

CREATE TABLE `tbl_state` (
  `id` int(11) NOT NULL,
  `state_name` varchar(150) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_state`
--

INSERT INTO `tbl_state` (`id`, `state_name`, `created_at`, `updated_at`) VALUES
(1, 'Karnataka', '2019-10-15 05:02:15', '2019-10-15 05:02:15');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tarbiyyah`
--

CREATE TABLE `tbl_tarbiyyah` (
  `id` int(11) NOT NULL,
  `madrasa_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `tajveed` int(11) NOT NULL,
  `arabic` int(11) NOT NULL,
  `fiqh` int(11) NOT NULL,
  `t_year` date NOT NULL,
  `type` varchar(150) NOT NULL,
  `hfid` varchar(150) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_tarbiyyah`
--

INSERT INTO `tbl_tarbiyyah` (`id`, `madrasa_id`, `student_id`, `tajveed`, `arabic`, `fiqh`, `t_year`, `type`, `hfid`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 7, 80, 40, 60, '2019-11-13', 'HSCC', 'HFSCC01', 1, NULL, '2019-11-13 08:59:11'),
(2, 1, 7, 40, 100, 100, '2018-11-06', 'HSCC', 'HFSCC01', 1, '2019-11-13 14:33:12', '2019-11-13 14:33:12'),
(3, 1, 7, 20, 20, 40, '2019-12-14', 'HSCC', 'HFSCC01', 1, '2019-11-14 06:01:33', '2019-11-14 06:01:33');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tarbiyyah_madrasa`
--

CREATE TABLE `tbl_tarbiyyah_madrasa` (
  `id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `tajveed` varchar(100) DEFAULT NULL,
  `fiqh` varchar(100) DEFAULT NULL,
  `arabic` varchar(100) DEFAULT NULL,
  `fam_category` varchar(100) NOT NULL,
  `hfid_link` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_tarbiyyah_madrasa`
--

INSERT INTO `tbl_tarbiyyah_madrasa` (`id`, `person_id`, `tajveed`, `fiqh`, `arabic`, `fam_category`, `hfid_link`, `status`, `created_at`, `updated_at`) VALUES
(1, 5, '65', '45', '87', 'HSCC', 'HFSCC01', 1, '2019-09-27 21:11:25', '2019-09-28 09:11:53');

-- --------------------------------------------------------

--
-- Table structure for table `unit_details`
--

CREATE TABLE `unit_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `unit_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `u_category` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nation` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_pin_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `unit_details`
--

INSERT INTO `unit_details` (`id`, `unit_img`, `unit_name`, `u_category`, `street`, `city`, `state`, `nation`, `unit_pin_code`, `unit_phone`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Mangalore', 'HQ', 'Near Highland Hospital, APS Complex, 2nd Floor, Falnir Road, Highland', 'Mangaluru', 'Karnataka', 'India', '575002', '0824 425 1319', 1, '2019-08-03 02:16:49', '2019-08-03 02:16:49'),
(2, NULL, 'Riyadh', 'Unit', 'Near Highland Hospital, APS Complex, 2nd Floor, Falnir Road, Highland', 'Mangaluru', 'Karnataka', 'India', '575002', '0824 425 1319', 1, '2019-08-03 02:16:49', '2019-08-03 02:16:49'),
(3, NULL, 'Dammam', 'Unit', 'Near Highland Hospital, APS Complex, 2nd Floor, Falnir Road, Highland', 'Mangaluru', 'Karnataka', 'Dammam\r\n', '575002', '0824 425 1319', 1, '2019-08-03 02:16:49', '2019-08-03 02:16:49'),
(4, NULL, 'Jubail', 'Unit', 'Near Highland Hospital, APS Complex, 2nd Floor, Falnir Road, Highland', 'Mangaluru', 'Karnataka', 'Jubail', '575002', '0824 425 1319', 1, '2019-08-03 02:16:49', '2019-08-03 02:16:49'),
(5, NULL, 'Jeddha', 'Unit', 'Near Highland Hospital, APS Complex, 2nd Floor, Falnir Road, Highland', 'Mangaluru', 'Karnataka', 'Jeddha', '575002', '0824 425 1319', 1, '2019-08-03 02:16:49', '2019-08-03 02:16:49'),
(6, NULL, 'Dubai', 'Unit', 'Near Highland Hospital, APS Complex, 2nd Floor, Falnir Road, Highland', 'Mangaluru', 'Karnataka', 'Dubai', '575002', '0824 425 1319', 1, '2019-08-03 02:16:49', '2019-08-03 02:16:49'),
(7, NULL, 'Qatar', 'Unit', 'Near Highland Hospital, APS Complex, 2nd Floor, Falnir Road, Highland', 'Mangaluru', 'Karnataka', 'Qatar', '575002', '0824 425 1319', 1, '2019-08-03 02:16:49', '2019-08-03 02:16:49'),
(8, NULL, 'Muscat', 'Unit', 'Near Highland Hospital, APS Complex, 2nd Floor, Falnir Road, Highland', 'Mangaluru', 'Karnataka', 'Muscat\r\n', '575002', '0824 425 1319', 1, '2019-08-03 02:16:49', '2019-08-03 02:16:49'),
(9, NULL, 'Bahrain', 'Unit', 'Near Highland Hospital, APS Complex, 2nd Floor, Falnir Road, Highland', 'Mangaluru', 'Karnataka', 'Bahrain', '575002', '0824 425 1319', 1, '2019-08-03 02:16:49', '2019-08-03 02:16:49'),
(10, NULL, 'Bangalore', 'Unit', 'Near Highland Hospital, APS Complex, 2nd Floor, Falnir Road, Highland', 'Mangaluru', 'Karnataka', 'Bangalore\r\n', '575002', '0824 425 1319', 1, '2019-08-03 02:16:49', '2019-08-03 02:16:49');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `unit_id` int(11) NOT NULL,
  `member_fname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `member_mname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `member_lname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `hfid` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `member_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `committee` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date NOT NULL,
  `doj` date NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permanent_address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` bigint(20) NOT NULL,
  `p_city` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `p_state` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `p_nation` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `p_residence` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `residence_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` bigint(20) NOT NULL,
  `r_city` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `r_state` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `r_nation` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `r_residence` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qualification` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `working_since` date NOT NULL,
  `expertise` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `skills` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `other_organisation` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `member_since` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position_held` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `password` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `unit_id`, `member_fname`, `member_mname`, `member_lname`, `email`, `email_verified_at`, `hfid`, `photo`, `category`, `member_type`, `committee`, `role`, `dob`, `doj`, `gender`, `permanent_address`, `contact`, `p_city`, `p_state`, `p_nation`, `p_residence`, `residence_address`, `mobile`, `r_city`, `r_state`, `r_nation`, `r_residence`, `qualification`, `designation`, `company_name`, `position`, `working_since`, `expertise`, `skills`, `other_organisation`, `member_since`, `position_held`, `status`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 1, 'Nasreen', 'Ahmed', 'Bawa', 'irsh353@gmail.com', NULL, 'HFWW01', NULL, 'Womens Wing', 'Member', 'Trustee Committee', 'Chairman', '1984-12-22', '2018-04-20', 'Male', 'Nazeela Manzil, behind Badriya Jumma Masjid 7 block Krishnapura', 9632673626, 'Mangalore', 'Karnataka', 'India', 'Krishnapura', 'Nazeela Manzil, behind Badriya Jumma Masjid 7 block Krishnapura', 9632673626, 'Mangalore', 'Karnataka', 'India', 'N', 'MSC, BED, PGDC', 'Principal', 'Hidayah Foundation', 'PPINCIPAL', '2018-01-01', 'PSYCHOLOGY, ISLAMIC STUDIES', 'COUNSELING, TEACHING, TRAINING, SYSTEM DEVELOPMENT, RESEACH', NULL, NULL, NULL, 1, '', NULL, '2019-08-14 14:29:05', '2019-10-03 06:15:51'),
(3, 1, 'Masuda', 'Kauser', '', 'masudakauser1975@gmail.com', NULL, 'HFWW02', NULL, 'Womens Wing', 'Member', 'Trustee Committee', 'Member', '1975-05-31', '2007-12-01', 'Female', 'Badriya House Old Kent Road Pandeshwar Mangalore', 7022462232, 'Mangalore', 'Karnataka', 'India', 'Pandeshwar', 'Badriya House Old Kent Road Pandeshwar Mangalore', 7022468832, 'Mangalore', 'Karnataka', 'India', 'Pandeshwar', '1st puc', 'Member', 'Hidayah Foundation', 'Meember', '2007-12-01', 'N', 'Financially and physically', NULL, NULL, NULL, 1, '', NULL, '2019-08-14 14:46:14', '2019-10-03 06:15:51'),
(5, 1, 'MOHAMMAD', 'ASHIL', '', 'ashilchand1478@gmail.com', NULL, 'HFHQA01', NULL, 'HQ Admin', 'Staff', NULL, NULL, '1998-05-04', '2019-08-03', 'Male', 'ASHIKA MANZIL CHAND COMPLEX DERALAKTTE MANGALORE', 8861631478, 'MANGALORE', 'Karnataka', 'India', 'DERALAKATTE', 'ASHIKA MANZIL CHAND COMPLEX DERALAKTTE MANGALORE', 8861631478, 'Mangalore', 'Karnataka', 'India', 'DERTALAKATTE', 'BBA', 'Working for the post of administrative assistance', 'hidayah foundation', 'Administrative assistance', '2019-08-03', 'COMMUNICATION', '', NULL, NULL, NULL, 1, '', NULL, '2019-08-14 21:52:09', '2019-10-03 06:15:51'),
(7, 1, 'Shaad', 'Ahmed', NULL, 'shaadahmed18@gmail.com', NULL, 'HFYW02', NULL, 'Youth Wing', 'Member', 'Core Committee', 'Member', '1989-12-20', '2017-02-08', 'Male', 'Gallery Apartment, Alape Padil', 7349483558, 'Mangalore', 'Karnataka', 'India', 'Padil', 'Gallery Apartment, Alape Padil', 7349483558, 'Mangalore', 'Karnataka', 'India', 'Padil', 'MCA', 'Business', 'DataQueue Systems', 'Director', '2015-01-14', 'Business Development', 'Presentation', 'MCF', '2018-02-14', 'Member', 1, '', NULL, '2019-08-14 21:49:38', '2019-10-03 06:15:51'),
(8, 2, 'MOHAMMAD', 'RIYZA', '', 'mohammadriyaz@gmail.com', NULL, 'HFOSR01', NULL, 'OverseasRiyadh', 'Member', 'General Committee', 'Member', '1986-06-12', '2016-11-21', 'Male', 'ROSSEVILLA FALNIR MANGALORE', 9988776655, 'mangalore', 'Karnataka', 'India', 'falnir', 'ROSSEVILLA FALNIR MANGALORE', 9988776655, 'Mangalore', 'Karnataka', 'India', 'falnir', 'Degree', 'MANPOWER', 'VINTAGE', 'MANAGER', '2017-02-22', 'MANAGING', '', NULL, NULL, NULL, 1, '', NULL, '2019-08-15 07:54:56', '2019-10-03 06:15:51'),
(9, 3, 'AHMED', 'JABBAR', '', 'jabbar456@gmail.com', NULL, 'HFOSD01', NULL, 'OverseasDammam', 'Member', 'General Committee', 'Member', '1978-02-21', '2017-07-19', 'Male', 'ROSE VILLA FALNIR MANGALORE', 8877665544, 'MANGALORE', 'Karnataka', 'India', 'FALNIR', 'ROSE VILLA FALNIR MANGALORE', 8877665544, 'Mangalore', 'Karnataka', 'India', 'FALNIR', 'DEGREE', 'MANPOWER', 'TEXAS', 'MANAGER', '2016-11-21', 'MARKETING', '', NULL, NULL, NULL, 1, '', NULL, '2019-08-15 08:07:28', '2019-10-03 06:15:51'),
(10, 4, 'SHAHEENA', 'BEGUM', '', 'shahena123@gmail.com', NULL, 'HFOSJ01', NULL, 'OverseasJubail', 'Member', 'General Committee', 'Member', '1998-02-12', '2017-10-30', 'Male', 'ROSE VILLA FALNIR MANGALORE', 9988776650, 'MANGALORE', 'Karnataka', 'India', 'FALNIR', 'ROSE VILLA FALNIR MANGALORE', 9988776650, 'Mangalore', 'Karnataka', 'India', 'FALNIR', 'DEGREE', 'ORGANISING', 'GOOD GALATE', 'ORGANISOR', '2016-02-21', 'MARKETING', '', NULL, NULL, NULL, 1, '', NULL, '2019-08-15 08:11:09', '2019-10-03 06:15:51'),
(11, 5, 'ABDUL', 'RAHMAN', '', 'abdulrahman567@gmail.com', NULL, 'HFOSJD01', NULL, 'OverseasJeddha', 'Staff', NULL, NULL, '1998-01-01', '2017-12-31', 'Male', 'ROSE VILLA FALNIR MANGALORE', 1234567890, 'MANGALORE', 'Karnataka', 'India', 'FALNIR', 'ROSE VILLA FALNIR MANGALORE', 1234567890, 'Mangalore', 'Karnataka', 'India', 'FALNIR', 'DEGREE', 'MANPOWER', 'TEXAS', 'Administrative assistance', '2017-11-21', 'ACCOUNTANT', '', NULL, NULL, NULL, 1, '', NULL, '2019-08-15 08:15:08', '2019-10-03 06:15:51'),
(12, 6, 'MOHAMMAD', 'SHIBIL', '', 'shibil987@gmail.com', NULL, 'HFOSDU01', NULL, 'OverseasDubai', 'Member', 'General Committee', 'Member', '1998-02-12', '2018-11-21', 'Male', 'ROSE VILLA FALNIR MANGALORE', 8877554433, 'MANGALORE', 'Karnataka', 'India', 'FALNIR', 'ROSE VILLA FALNIR MANGALORE', 8877664433, 'Mangalore', 'Karnataka', 'India', 'FALNIR', 'DEGREE', 'MANPOWER', 'TEXAS', 'MEMBER', '2017-02-22', 'ACCOUTANT', '', NULL, NULL, NULL, 1, '', NULL, '2019-08-15 08:18:07', '2019-10-03 06:15:51'),
(13, 7, 'RIYAZ', 'AHMAD', '', 'riyazahmad345@gmail.com', NULL, 'HFOSQ01', NULL, 'OverseasQatar', 'Staff', NULL, NULL, '2000-02-22', '2017-02-22', 'Male', 'ROSE VILLA FALNIR MANGALORE', 8877996600, 'MANGALORE', 'Karnataka', 'India', 'FALNIR', 'ROSE VILLA FALNIR MANGALORE', 9988007700, 'Mangalore', 'Karnataka', 'India', 'FALNIR', 'MBA', 'ORGANISING', 'TEXAS', 'Administrative assistance', '2015-01-31', 'COMMUNICATION', '', NULL, NULL, NULL, 1, '', NULL, '2019-08-15 08:21:30', '2019-10-03 06:15:51'),
(14, 8, 'MOHAMMAD', 'ASHAB', '', 'ashab345@gmail.com', NULL, 'HFOSM01', NULL, 'OverseasMuscat', 'Member', 'General Committee', 'Member', '2000-02-22', '2012-12-21', 'Male', 'ROSE VILLA FALNIR MANGALORE', 9988773322, 'MANGALORE', 'Karnataka', 'India', 'FALNIR', 'ROSE VILLA FALNIR MANGALORE', 9988773322, 'Mangalore', 'Karnataka', 'India', 'FALNIR', 'DEGREE', 'ORGANISING', 'TEXAS', 'MARKETING', '2016-05-04', 'MARKETING', '', NULL, NULL, NULL, 1, '', NULL, '2019-08-15 08:35:55', '2019-10-03 06:15:51'),
(15, 9, 'JASEEL', 'HUSSAIN', '', 'hussain123@gmail.com', NULL, 'HFOSB01', NULL, 'OverseasBahrain', 'Member', 'General Committee', 'Member', '1998-02-21', '2016-02-05', 'Male', 'ROSE VILLA FALNIR MANGALORE', 1122334455, 'MANGALORE', 'Karnataka', 'India', 'FALNIR', 'ROSE VILLA FALNIR MANGALORE', 1122334455, 'Mangalore', 'Karnataka', 'India', 'FALNIR', 'MBA', 'MANPOWER', 'TEXAS', 'MANAGER', '2016-07-31', 'MANAGING', '', NULL, NULL, NULL, 1, '', NULL, '2019-08-15 08:39:15', '2019-10-03 06:15:51'),
(16, 10, 'MOHAMMAD', 'MUTTASIM', '', 'muttasim@gmail.com', NULL, 'HFOSBL01', NULL, 'OverseasBangalore', 'Member', 'General Committee', 'Member', '1998-04-05', '2016-05-04', 'Male', 'ROSE VILLA FALNIR MANGALORE', 7877654434, 'MANGALORE', 'Karnataka', 'India', 'FALNIR', 'ROSE VILLA FALNIR MANGALORE', 7877654434, 'Mangalore', 'Karnataka', 'India', 'FALNIR', 'DEGREE', 'MANPOWER', 'TEXAS', 'ORGANISOR', '2016-05-31', 'MANGING', '', NULL, NULL, NULL, 1, '', NULL, '2019-08-15 08:41:58', '2019-10-03 06:15:51'),
(17, 1, 'Asbah', 'Banu', '', 'admin1234@gmail.com', NULL, 'HFATT01', NULL, 'ATT', 'Staff', NULL, NULL, '2001-01-09', '2017-02-07', 'Female', 'Oppo. Nilgiris, Falnir', 9876543210, 'Mangalore', 'Karnataka', 'India', 'Falnir', 'Oppo. Nilgiris, Falnir', 9876543210, 'Mangalore', 'Karnataka', 'India', 'Falnir', 'BSc', 'Admin', 'ATT', 'Admin', '2017-01-03', 'Managing', 'Communication', NULL, NULL, NULL, 1, '', NULL, '2019-08-15 10:49:31', '2019-10-03 06:15:51'),
(18, 1, 'SAYED', 'SALAMULLA', '', 'karkalasayed@gmail.com', NULL, 'HFHQA02', NULL, 'HQ Admin', 'Staff', NULL, NULL, '1958-07-09', '2016-10-01', 'Male', 'Shivbagh mangalore', 9742780108, 'Mangalore', 'Karnataka', 'Indian', 'Shivbagh', NULL, 9742780108, 'Mangalore', 'Karnataka', NULL, NULL, 'Graduate', 'HQ admin', 'HIDAYA FOUNDATION', 'ACCOUNTANT', '2016-10-01', 'ACCOUNTANT', 'ACCOUNTING', NULL, NULL, NULL, 1, '', NULL, '2019-09-05 15:51:05', '2019-10-03 06:15:51'),
(19, 1, 'ABID', 'ASGAR', '', 'abidasgar702@gmail.com', NULL, 'HFHQA03', NULL, 'HQ Admin', 'Member', 'Trustee Committee', 'Member', '1949-12-18', '2014-01-30', 'Male', '702B NALAPAD KUNIL TOWER NELLIKAI ROAD BUNDER MANGALORE', 9343650321, 'Mangalore', 'Karnataka', 'Indian', 'Mangalore', NULL, 9343650321, 'Mangalore', 'Karnataka', 'India', 'Mangalore', 'Graduate', 'N/A', 'HIDAYA FOUNDATION', 'Trustee', '2014-01-31', 'MANAGING', 'N/A', NULL, NULL, NULL, 1, '', NULL, '2019-09-05 15:59:43', '2019-10-03 06:15:51'),
(20, 1, 'M', 'HYDAR', '', 'hyder@gmail.com', NULL, 'HFHQA04', NULL, 'HQ Admin', 'Staff', NULL, NULL, '1964-04-06', '2019-08-20', 'Male', 'KALAI MAJAL AMANJA POST BANTWAL THALUK MANGALORE', 9901001317, 'Mangalore', 'Karnataka', 'India', 'Mangalore', NULL, 9901001317, 'Mangalore', 'Karnataka', 'India', 'Mangalore', 'School', 'Micro donation collector', 'HIDAYA FOUNDATION', 'Donation collector', '2019-08-20', 'N/A', 'N/A', NULL, NULL, NULL, 1, '', NULL, '2019-09-05 16:04:16', '2019-10-03 06:15:51');

-- --------------------------------------------------------

--
-- Table structure for table `womens_wings`
--

CREATE TABLE `womens_wings` (
  `id` int(10) UNSIGNED NOT NULL,
  `member_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `report_date` date NOT NULL,
  `first_meeting` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `second_meeting` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `coinbox_point` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `box_collected` int(11) DEFAULT NULL,
  `box_submitted` int(11) DEFAULT NULL,
  `sadaqa` int(11) NOT NULL,
  `sadaqa_points` int(11) NOT NULL,
  `donations` int(11) DEFAULT NULL,
  `add_new_member` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `membership_fees` int(11) NOT NULL,
  `membership_fee_point` int(11) NOT NULL DEFAULT '0',
  `visits` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `workshops` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `events` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_workshop_point` int(11) DEFAULT NULL,
  `total_points` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `att_students_class_assessment`
--
ALTER TABLE `att_students_class_assessment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `core_skills`
--
ALTER TABLE `core_skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `families_models`
--
ALTER TABLE `families_models`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `family_details`
--
ALTER TABLE `family_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `main_skills`
--
ALTER TABLE `main_skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `main_skills_datas`
--
ALTER TABLE `main_skills_datas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meeting_announces`
--
ALTER TABLE `meeting_announces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member_credits`
--
ALTER TABLE `member_credits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `questionairs`
--
ALTER TABLE `questionairs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `main_id` (`main_id`);

--
-- Indexes for table `studentevaluations`
--
ALTER TABLE `studentevaluations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studentskills`
--
ALTER TABLE `studentskills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_details`
--
ALTER TABLE `student_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_skills`
--
ALTER TABLE `sub_skills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `main_id` (`main_id`) USING BTREE;

--
-- Indexes for table `tabl_ranks`
--
ALTER TABLE `tabl_ranks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tabl_stud_ranks`
--
ALTER TABLE `tabl_stud_ranks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_academics`
--
ALTER TABLE `tbl_academics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_assessments_structure`
--
ALTER TABLE `tbl_assessments_structure`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_basic_skills`
--
ALTER TABLE `tbl_basic_skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_city`
--
ALTER TABLE `tbl_city`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_committees_details`
--
ALTER TABLE `tbl_committees_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_district`
--
ALTER TABLE `tbl_district`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_familiesfuture_infos`
--
ALTER TABLE `tbl_familiesfuture_infos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_families_address`
--
ALTER TABLE `tbl_families_address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_families_personals`
--
ALTER TABLE `tbl_families_personals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_feedback_remarks`
--
ALTER TABLE `tbl_feedback_remarks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_general_educations`
--
ALTER TABLE `tbl_general_educations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_health_status`
--
ALTER TABLE `tbl_health_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_history_status`
--
ALTER TABLE `tbl_history_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_huqooq_allah`
--
ALTER TABLE `tbl_huqooq_allah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_huqooq_ibaadh`
--
ALTER TABLE `tbl_huqooq_ibaadh`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_institutions_infos`
--
ALTER TABLE `tbl_institutions_infos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_lifeskills`
--
ALTER TABLE `tbl_lifeskills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_lifeskills_eval`
--
ALTER TABLE `tbl_lifeskills_eval`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_madrasa_education`
--
ALTER TABLE `tbl_madrasa_education`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pincode`
--
ALTER TABLE `tbl_pincode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_project_beneficiaries`
--
ALTER TABLE `tbl_project_beneficiaries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_ration`
--
ALTER TABLE `tbl_ration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_service_conserns`
--
ALTER TABLE `tbl_service_conserns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_spiritual_assessments`
--
ALTER TABLE `tbl_spiritual_assessments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_spiritual_development`
--
ALTER TABLE `tbl_spiritual_development`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_state`
--
ALTER TABLE `tbl_state`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_tarbiyyah`
--
ALTER TABLE `tbl_tarbiyyah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_tarbiyyah_madrasa`
--
ALTER TABLE `tbl_tarbiyyah_madrasa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit_details`
--
ALTER TABLE `unit_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `womens_wings`
--
ALTER TABLE `womens_wings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `att_students_class_assessment`
--
ALTER TABLE `att_students_class_assessment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `core_skills`
--
ALTER TABLE `core_skills`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `families_models`
--
ALTER TABLE `families_models`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;

--
-- AUTO_INCREMENT for table `family_details`
--
ALTER TABLE `family_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `main_skills`
--
ALTER TABLE `main_skills`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `main_skills_datas`
--
ALTER TABLE `main_skills_datas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meeting_announces`
--
ALTER TABLE `meeting_announces`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `member_credits`
--
ALTER TABLE `member_credits`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `questionairs`
--
ALTER TABLE `questionairs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `studentevaluations`
--
ALTER TABLE `studentevaluations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `studentskills`
--
ALTER TABLE `studentskills`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_details`
--
ALTER TABLE `student_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_skills`
--
ALTER TABLE `sub_skills`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tabl_ranks`
--
ALTER TABLE `tabl_ranks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tabl_stud_ranks`
--
ALTER TABLE `tabl_stud_ranks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_academics`
--
ALTER TABLE `tbl_academics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_assessments_structure`
--
ALTER TABLE `tbl_assessments_structure`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_basic_skills`
--
ALTER TABLE `tbl_basic_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_city`
--
ALTER TABLE `tbl_city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_committees_details`
--
ALTER TABLE `tbl_committees_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_district`
--
ALTER TABLE `tbl_district`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_familiesfuture_infos`
--
ALTER TABLE `tbl_familiesfuture_infos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT for table `tbl_families_address`
--
ALTER TABLE `tbl_families_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `tbl_families_personals`
--
ALTER TABLE `tbl_families_personals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT for table `tbl_feedback_remarks`
--
ALTER TABLE `tbl_feedback_remarks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_general_educations`
--
ALTER TABLE `tbl_general_educations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;

--
-- AUTO_INCREMENT for table `tbl_health_status`
--
ALTER TABLE `tbl_health_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT for table `tbl_history_status`
--
ALTER TABLE `tbl_history_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `tbl_huqooq_allah`
--
ALTER TABLE `tbl_huqooq_allah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_huqooq_ibaadh`
--
ALTER TABLE `tbl_huqooq_ibaadh`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_institutions_infos`
--
ALTER TABLE `tbl_institutions_infos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tbl_lifeskills`
--
ALTER TABLE `tbl_lifeskills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_lifeskills_eval`
--
ALTER TABLE `tbl_lifeskills_eval`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_madrasa_education`
--
ALTER TABLE `tbl_madrasa_education`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_pincode`
--
ALTER TABLE `tbl_pincode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_project_beneficiaries`
--
ALTER TABLE `tbl_project_beneficiaries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `tbl_ration`
--
ALTER TABLE `tbl_ration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_service_conserns`
--
ALTER TABLE `tbl_service_conserns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `tbl_spiritual_assessments`
--
ALTER TABLE `tbl_spiritual_assessments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_spiritual_development`
--
ALTER TABLE `tbl_spiritual_development`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_state`
--
ALTER TABLE `tbl_state`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_tarbiyyah`
--
ALTER TABLE `tbl_tarbiyyah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_tarbiyyah_madrasa`
--
ALTER TABLE `tbl_tarbiyyah_madrasa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `unit_details`
--
ALTER TABLE `unit_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `womens_wings`
--
ALTER TABLE `womens_wings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
