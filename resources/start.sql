SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- --------------------------------------------------------

--
-- Table structure for table `responses`
--

CREATE TABLE `responses` (
  `responseID` int(11) NOT NULL AUTO_INCREMENT,
  `subjectID` int(11) NOT NULL,
  `question1` decimal(3,1) DEFAULT NULL,
  `question2` decimal(3,1) DEFAULT NULL,
  PRIMARY KEY (`responseID`),
  UNIQUE KEY `subjectID` (`subjectID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=74 ;

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subjectID` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `completed` tinyint(1) NOT NULL,
  `treatment` tinyint(1) NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `athlete` tinyint(1) NOT NULL,
  PRIMARY KEY (`subjectID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=919 ;
