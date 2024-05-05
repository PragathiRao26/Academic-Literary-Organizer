SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `academic_records`
--
CREATE DATABASE IF NOT EXISTS `academic_records` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `academic_records`;

-- --------------------------------------------------------

--
-- Table structure for table `userdata`
--

DROP TABLE IF EXISTS `userdata`;
CREATE TABLE `userdata` (
  `sno` int(11) NOT NULL AUTO_INCREMENT,
  `Emailid` varchar(50) NOT NULL,
  `Password` text NOT NULL,
  `Type` text NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`sno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userdata`
--

INSERT INTO `userdata` (`sno`, `Emailid`, `Password`, `Type`, `name`) VALUES
(1, 'admin@somaiya.edu', 'admin123', 'admin', 'admin'),
(2, 'student@somaiya.edu', 'student123', 'student', 'Name');

-- --------------------------------------------------------

--
-- Table structure for table `todolist`
--

DROP TABLE IF EXISTS `todolist`;
CREATE TABLE `todolist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `priority` varchar(50) NOT NULL,
  `due_date` date NOT NULL,
  `username` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

DROP TABLE IF EXISTS `subjectdata`;
CREATE TABLE `subjectdata` (
  `sno` int(11) NOT NULL AUTO_INCREMENT,
  `Semester` int(11) DEFAULT NULL,
  `Branch` varchar(50) DEFAULT NULL,
  `Subject` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`sno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjectdata`
--

INSERT INTO `subjectdata` (`Semester`, `Branch`, `Subject`) VALUES
(1, 'COMPS', 'Applied Mathematics 1'),
(1, 'COMPS', 'Engineering Chemistry'),
(1, 'COMPS', 'Engineering Drawing'),
(1, 'COMPS', 'Elements of Electrical and Electronics Engineering'),
(1, 'COMPS', 'Programming in C'),
(1, 'COMPS', 'Workshop-1'),
(2, 'COMPS', 'Applied Mathematics 2'),
(2, 'COMPS', 'Engineering Physics'),
(2, 'COMPS', 'Engineering Mechanics'),
(2, 'COMPS', 'Programming in Python'),
(2, 'COMPS', 'Workshop-2'),
(3, 'COMPS', 'Integral Transfer and Vector Calculus'),
(3, 'COMPS', 'Data Structures'),
(3, 'COMPS', 'Computer Organization and Architecture'),
(3, 'COMPS', 'Object Oriented Programming Methodology'),
(3, 'COMPS', 'Discrete Mathematics'),
(3, 'COMPS', 'Digital Design'),
(4, 'COMPS', 'Probability, Statistics and Optimizations Techniques'),
(4, 'COMPS', 'Analysis of Algorithms'),
(4, 'COMPS', 'Relational Database Management Systems'),
(4, 'COMPS', 'Theory of Automata and Compiler Design'),
(4, 'COMPS', 'Web Programming'),
(4, 'COMPS', 'Mini Project'),
(5, 'COMPS', 'Software Engineering'),
(5, 'COMPS', 'Computer Networks'),
(5, 'COMPS', 'Operating System'),
(5, 'COMPS', 'Departmental Elective-I'),
(5, 'COMPS', 'OET'),
(5, 'COMPS', 'OEHM'),
(5, 'COMPS', 'Full Stack Development Lab'),
(6, 'COMPS', 'Digital Signal & Image Processing'),
(6, 'COMPS', 'Information Security'),
(6, 'COMPS', 'Artificial Intelligence'),
(6, 'COMPS', 'Departmental Elective'),
(6, 'COMPS', 'OET'),
(6, 'COMPS', 'OEHM'),
(1, 'IT', 'Applied Mathematics 1'),
(1, 'IT', 'Engineering Chemistry'),
(1, 'IT', 'Engineering Drawing'),
(1, 'IT', 'Elements of Electrical and Electronics Engineering'),
(1, 'IT', 'Programming in C'),
(1, 'IT', 'Workshop-1'),
(2, 'IT', 'Applied Mathematics 2'),
(2, 'IT', 'Engineering Physics'),
(2, 'IT', 'Engineering Mechanics'),
(2, 'IT', 'Programming in Python'),
(2, 'IT', 'Workshop-2'),
(3, 'IT', 'Applied Mathematics 3'),
(3, 'IT', 'Data Structures'),
(3, 'IT', 'Data Communication and Network'),
(3, 'IT', 'Database Management System'),
(3, 'IT', 'Programming Language'),
(4, 'IT', 'Applied Mathematics 4'),
(4, 'IT', 'Information Theory and Coding'),
(4, 'IT', 'Advanced Databases'),
(4, 'IT', 'Web Programming-I'),
(4, 'IT', 'Competitive Programming Language'),
(5, 'IT', 'Theory Of Computation'),
(5, 'IT', 'Operation System'),
(5, 'IT', 'Information and Network Security'),
(5, 'IT', 'Department Elective-I'),
(5, 'IT', 'Web Programming-II Lab'),
(5, 'IT', 'OET'),
(5, 'IT', 'OEHM'),
(6, 'IT', 'Object Oriented Software Engineering'),
(6, 'IT', 'Modeling and Simulation'),
(6, 'IT', 'Cloud Computing'),
(6, 'IT', 'Departmental Elective'),
(6, 'IT', 'OET'),
(6, 'IT', 'OEHM'),
(1, 'ETRX', 'Applied Mathematics 2'),
(1, 'ETRX', 'Engineering Physics'),
(1, 'ETRX', 'Engineering Mechanics'),
(1, 'ETRX', 'Programming in Python'),
(1, 'ETRX', 'Workshop-2'),
(2, 'ETRX', 'Applied Mathematics 1'),
(2, 'ETRX', 'Engineering Chemistry'),
(2, 'ETRX', 'Engineering Drawing'),
(2, 'ETRX', 'Elements of Electrical and Electronics Engineering'),
(2, 'ETRX', 'Programming in C'),
(2, 'ETRX', 'Workshop-1'),
(3, 'ETRX', 'Mathematics for Electronics Engineering-I'),
(3, 'ETRX', 'Electrical Networks'),
(3, 'ETRX', 'Basic of Electronics Circuit'),
(3, 'ETRX', 'Digital Electronics'),
(3, 'ETRX', 'Signals and Systems'),
(3, 'ETRX', 'Programming Laboratory'),
(4, 'ETRX', 'Mathematics for Electronics Engineering-II'),
(4, 'ETRX', 'Analog Electronics Circuits'),
(4, 'ETRX', 'Control System Engineering'),
(4, 'ETRX', 'Analog and Digital Communication'),
(4, 'ETRX', 'Microcontroller and Applications'),
(4, 'ETRX', 'Designing with Programmable Logic Lab Course'),
(5, 'ETRX', 'Electromagnetic Engineering'),
(5, 'ETRX', 'Digital Signal Processing'),
(5, 'ETRX', 'Power Electronics'),
(5, 'ETRX', 'Department Elective-I'),
(5, 'ETRX', 'OET'),
(5, 'ETRX', 'OEHM'),
(5, 'ETRX', 'Virtual Instrumentation and Industrial Automation Lab Course'),
(6, 'ETRX', 'Basics of VLSI'),
(6, 'ETRX', 'Analog Integrated Circuits and Applications'),
(6, 'ETRX', 'Introduction to Automation and Mechatronics'),
(6, 'ETRX', 'Department Elective-II'),
(6, 'ETRX', 'OET'),
(6, 'ETRX', 'OEHM'),
(1, 'EXTC', 'Applied Mathematics 2'),
(1, 'EXTC', 'Engineering Physics'),
(1, 'EXTC', 'Engineering Mechanics'),
(1, 'EXTC', 'Programming in Python'),
(1, 'EXTC', 'Workshop-2'),
(2, 'EXTC', 'Applied Mathematics 1'),
(2, 'EXTC', 'Engineering Chemistry'),
(2, 'EXTC', 'Engineering Drawing'),
(2, 'EXTC', 'Elements of Electrical and Electronics Engineering'),
(2, 'EXTC', 'Programming in C'),
(2, 'EXTC', 'Workshop-1'),
(3, 'EXTC', 'Mathematics for Communication Engineering I'),
(3, 'EXTC', 'Basic Electronic Circuits'),
(3, 'EXTC', 'Digital Logic Design'),
(3, 'EXTC', 'Microprocessor and Microcontroller'),
(3, 'EXTC', 'Electrical Network Theory'),
(3, 'EXTC', 'Data Structures and Analysis of Algorithms Laboratory'),
(4, 'EXTC', 'Mathematics for Communication Engineering II'),
(4, 'EXTC', 'Analog Electronics'),
(4, 'EXTC', 'Communication Systems'),
(4, 'EXTC', 'Signals and Systems'),
(4, 'EXTC', 'Electromagnetic Field Theory'),
(4, 'EXTC', 'Hardware Description Language Laboratory'),
(5, 'EXTC', 'Digital Communication'),
(5, 'EXTC', 'RF Filters and Antennas'),
(5, 'EXTC', 'Digital Signal Processing'),
(5, 'EXTC', 'Departmental Elective-I'),
(5, 'EXTC', 'OET'),
(5, 'EXTC', 'OEHM'),
(5, 'EXTC', 'Advanced Microcontroller Laboratory'),
(6, 'EXTC', 'Wireless Communication'),
(6, 'EXTC', 'Computer Communication Networks'),
(6, 'EXTC', 'Optical fibre Communication'),
(6, 'EXTC', 'Departmental Elective-II'),
(6, 'EXTC', 'OET'),
(6, 'EXTC', 'OEHM'),
(1, 'MECH', 'Applied Mathematics 2'),
(1, 'MECH', 'Engineering Physics'),
(1, 'MECH', 'Engineering Mechanics'),
(1, 'MECH', 'Programming in Python'),
(1, 'MECH', 'Workshop-2'),
(2, 'MECH', 'Applied Mathematics 1'),
(2, 'MECH', 'Engineering Chemistry'),
(2, 'MECH', 'Engineering Drawing'),
(2, 'MECH', 'Elements of Electrical and Electronics Engineering'),
(2, 'MECH', 'Programming in C'),
(2, 'MECH', 'Workshop-1'),
(3, 'MECH', 'Mathematics for Mechanical Engineering-I'),
(3, 'MECH', 'Strength of Materials'),
(3, 'MECH', 'Material science and metallurgy'),
(3, 'MECH', 'Thermodynamics'),
(3, 'MECH', 'Production Engineering-I'),
(3, 'MECH', 'Computer Aided Machine Drawing Laboratory'),
(3, 'MECH', 'Machine Shop Practice-I'),
(4, 'MECH', 'Mathematics for Mechanical Engineering-II'),
(4, 'MECH', 'Theory of Machines-I'),
(4, 'MECH', 'Fluid Mechanics'),
(4, 'MECH', 'Production Engineering-II'),
(4, 'MECH', 'Heat and Mass Transfer'),
(4, 'MECH', 'Machine Shop practice-II');

-- --------------------------------------------------------

DROP TABLE IF EXISTS `linksdata`;
CREATE TABLE `linksdata` (
  `id` int(11) NOT NULL,
  `branch` varchar(255) DEFAULT NULL,
  `option` varchar(255) NOT NULL,
  `Link` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `semester` int(11) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `linksdata`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `linksdata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

DROP TABLE IF EXISTS `bookinfo`;
CREATE TABLE `bookinfo` (
  `bname` varchar(50) NOT NULL,
  `author` varchar(50) NOT NULL,
  `genre` varchar(50) NOT NULL,
  `totalrating` int NOT NULL,
  `rno` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `image` VARCHAR(50) NOT NULL,
  `pdf` VARCHAR(50)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `bookinfo` (`bname`, `author`, `genre`, `totalrating`, `rno`, `name`, `image`, `pdf`) VALUES
('Book 1', 'author 1', 'subject 1', 30, 6, 'user', 'book1', 'out');

DROP TABLE IF EXISTS `discussion`;
CREATE TABLE `discussion` (
  `id` int(11) NOT NULL,
  `parent_comment` varchar(500) NOT NULL,
  `student` varchar(1000) NOT NULL,
  `post` varchar(1000) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `discussion`
--

INSERT INTO `discussion` (`parent_comment`, `student`, `post`, `date`) 
VALUES ('130', 'Eng. Vince', 'So, kindly, hurry and sign up', '2021-08-05 10:27:43');


--
-- Indexes for dumped tables
--

--
-- Indexes for table `discussion`
--
ALTER TABLE `discussion`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `discussion`
--
ALTER TABLE `discussion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;
COMMIT;
('Book 1', 'author 1', 'subject 1', 30, 6, 'user', 'book1', 'out');
