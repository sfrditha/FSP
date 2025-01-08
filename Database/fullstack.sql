-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2025 at 10:06 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `esport`
--

-- --------------------------------------------------------

--
-- Table structure for table `achievement`
--

CREATE TABLE `achievement` (
  `idachievement` int(11) NOT NULL,
  `idteam` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `achievement`
--

INSERT INTO `achievement` (`idachievement`, `idteam`, `name`, `date`, `description`) VALUES
(1, 1, 'Valorant Masters Runner-Up', '2024-08-09', 'Finished second in the Valorant Masters'),
(2, 2, 'Dota 2 International Champion', '2024-10-20', 'Won the Dota 2 International'),
(3, 3, 'CSGO Major Semi-Finalist', '2024-09-05', 'Reached semifinals in CSGO Major Championship'),
(4, 4, 'Rocket League World Cup Winner', '2024-11-05', 'Won the Rocket League World Cup'),
(5, 5, 'PUBG Continental Series Finalist', '2024-12-15', 'Reached finals in PUBG Continental Series'),
(7, 7, 'Rainbow Six Invitational Champion', '2024-10-15', 'Won the Rainbow Six Invitational'),
(8, 8, 'Starcraft II World Championship Third Place', '2024-09-28', 'Secured third place in Starcraft II World Championship'),
(13, 1, 'menangg', '2024-09-16', 'tralala'),
(14, 5, 'PMSL Fall', '2024-09-26', 'Juara 1, Road to PMGC');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `idevent` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`idevent`, `name`, `date`, `description`) VALUES
(1, 'Valorant Masters', '2024-08-05', 'Major Valorant tournament'),
(2, 'Dota 2 International', '2024-10-15', 'The premier Dota 2 tournament'),
(3, 'CSGO Major Championship', '2024-09-01', 'Top CSGO teams compete for the major title'),
(4, 'Rocket League World Cup', '2024-11-01', 'Global Rocket League championship'),
(5, 'PUBG Continental Series', '2024-12-12', 'Regional PUBG tournaments leading to global finals'),
(6, 'Warzone Showdown', '2024-11-20', 'Top Warzone players battle for glory'),
(7, 'Rainbow Six Invitational', '2024-10-09', 'The biggest event for Rainbow Six Siege'),
(9, 'lalala1233', '2025-04-23', 'lalala22222'),
(10, 'PMSL Fall', '2024-09-21', 'PMSL Fall, Surabaya');

-- --------------------------------------------------------

--
-- Table structure for table `event_teams`
--

CREATE TABLE `event_teams` (
  `idevent` int(11) NOT NULL,
  `idteam` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `event_teams`
--

INSERT INTO `event_teams` (`idevent`, `idteam`) VALUES
(1, 1),
(1, 2),
(2, 3),
(2, 4),
(3, 5),
(4, 7),
(4, 8),
(5, 1),
(5, 2),
(6, 3),
(6, 4),
(7, 5);

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE `game` (
  `idgame` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `game`
--

INSERT INTO `game` (`idgame`, `name`, `description`) VALUES
(1, 'Valorant', 'A tactical first-person shooter by Riot Games wowwww'),
(2, 'Dota 2', 'A 5v5 MOBA game by Valve Corporation'),
(3, 'Counter-Strike: Global Offensive', 'A competitive first-person shooter by Valve Corporation'),
(4, 'Rocket League', 'A vehicular soccer game by Psyonix'),
(5, 'PUBG', 'A battle royale game by PUBG Corporation'),
(6, 'Call of Duty: Warzone', 'A free-to-play battle royale by Activision'),
(7, 'Rainbow Six Siege', 'A tactical shooter by Ubisoft');

-- --------------------------------------------------------

--
-- Table structure for table `join_proposal`
--

CREATE TABLE `join_proposal` (
  `idjoin_proposal` int(11) NOT NULL,
  `idmember` int(11) NOT NULL,
  `idteam` int(11) NOT NULL,
  `description` varchar(100) DEFAULT 'role preference: support, attacker, dll',
  `status` enum('waiting','approved','rejected') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `join_proposal`
--

INSERT INTO `join_proposal` (`idjoin_proposal`, `idmember`, `idteam`, `description`, `status`) VALUES
(1, 2, 1, 'Experienced initiator looking for a team', 'approved'),
(2, 3, 2, 'Pro support player with experience in top tournaments', 'approved'),
(3, 4, 3, 'Seeking a new challenge as a sniper', 'rejected'),
(4, 5, 4, 'Looking to join a competitive Rocket League team', 'rejected'),
(5, 6, 5, 'Strong PUBG player, excels in team strategies', 'approved'),
(7, 8, 7, 'Looking for Siege team to join', 'rejected'),
(8, 9, 8, 'Starcraft player with strong Zerg strategies', 'approved'),
(9, 20, 5, 'saya mau masuk sini', 'waiting'),
(10, 20, 5, 'saya mau masuk sini', 'waiting'),
(11, 21, 5, 'Bantaiii', 'rejected'),
(12, 21, 5, 'Bantaiii', 'waiting'),
(13, 22, 5, 'Saya mau gabung disini broo', 'waiting'),
(14, 24, 7, 'Mid', 'approved'),
(15, 25, 13, 'Tanker', 'rejected'),
(16, 24, 5, 'Sniper', 'waiting'),
(17, 24, 3, 'Snipper', 'waiting');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `idmember` int(11) NOT NULL,
  `fname` varchar(45) DEFAULT NULL,
  `lname` varchar(45) DEFAULT NULL,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `profile` enum('admin','member') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`idmember`, `fname`, `lname`, `username`, `password`, `profile`) VALUES
(1, 'Charlotte', 'Edwards', 'cedwards', 'password21', 'member'),
(2, 'John', 'Smith', 'jsmith', 'password22', 'admin'),
(3, 'Maria', 'Garcia', 'mgarcia', 'password23', 'member'),
(4, 'Michael', 'Johnson', 'mjohnson', 'password24', 'member'),
(5, 'Linda', 'Williams', 'lwilliams', 'password25', 'admin'),
(6, 'David', 'Jones', 'djones', 'password26', 'member'),
(7, 'Emily', 'Davis', 'edavis', 'password27', 'member'),
(8, 'Robert', 'Martinez', 'rmartinez', 'password28', 'member'),
(9, 'James', 'Lopez', 'jlopez', 'password29', 'member'),
(10, 'Jennifer', 'Gonzalez', 'jgonzalez', 'password30', 'admin'),
(11, 'Patricia', 'Lee', 'plee', 'password31', 'member'),
(12, 'Christopher', 'Walker', 'cwalker', 'password32', 'member'),
(13, 'Barbara', 'Hall', 'bhall', 'password33', 'member'),
(14, 'William', 'Young', 'wyoung', 'password34', 'admin'),
(15, 'Elizabeth', 'Allen', 'eallen', 'password35', 'member'),
(16, 'DItha', 'tralala', 'lala', '$2y$10$xxxVjy5KWPqhTwEZp/Nz6OnHE6ICIX7IjprFuC', 'member'),
(18, 'sapa', 'aku', '123', '$2y$10$laTgSZwNVQhi/iG4182C8ONBzLPDBfoJV.4X67', 'member'),
(19, 'coba', 'coba2', 'tes', '$2y$10$.FaG1eAbAapVtTX3j4OcgOpTqnU2R6aRcF8XsG', 'member'),
(20, 'tata', 'alla', 'tata', 'tata123', 'member'),
(21, 'tata', 'dita', 'tatadita', 'password1234', 'member'),
(22, 'Bangkit', 'Dari Kubur', 'bangkit', 'bangkit123', 'member'),
(23, 'John', 'English', 'jhony', '$2y$10$fPHagRqHcD6XyHVtI.4ife6TlDzrU70GIgKghJHiyg0vefpiEcs/.', 'admin'),
(24, 'Tom', 'Holland', 'Hollande', '$2y$10$S7sPNtlKoZT/Z/NuB7CcJeUrnxGO35EjMrxg/PaRhoT9YnUxariUS', 'member'),
(25, 'Lulu', 'Trilili', 'troll', '$2y$10$3HB/LfVI0xCqN.yITABpG.rwLTjD5I/GEf8OvOxXtLI2Ost7Akjsa', 'member'),
(26, 'tralala', 'lili', 'lili123', '$2y$10$Oir5rWs.3KvAjs.nVUW/cuhWU1jxQ2LDey9YH56nD7eTnggp0c1XS', 'member');

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `idteam` int(11) NOT NULL,
  `idgame` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`idteam`, `idgame`, `name`) VALUES
(1, 1, 'Valorant Vipers 123'),
(2, 2, 'Dota Destroyers'),
(3, 3, 'CSGO Sharpshooters'),
(4, 4, 'Rocket Racers'),
(5, 5, 'PUBG Predators'),
(7, 7, 'Siege Specialists'),
(8, 5, 'Starcraft Strategists'),
(11, 1, 'vallue'),
(13, 6, 'Call Kami'),
(14, 6, 'COD WOW');

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `idteam` int(11) NOT NULL,
  `idmember` int(11) NOT NULL,
  `description` varchar(75) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`idteam`, `idmember`, `description`) VALUES
(1, 1, 'Initiator'),
(1, 2, 'Duelist'),
(2, 3, 'Carry'),
(2, 4, 'Support'),
(3, 5, 'AWPer'),
(3, 6, 'Rifler'),
(4, 7, 'Forward'),
(4, 8, 'Goalie'),
(5, 9, 'Scout'),
(5, 10, 'Sniper'),
(7, 13, 'Breacher'),
(7, 14, 'Anchor'),
(7, 24, 'Mid'),
(8, 15, 'Zerg Player'),
(8, 16, 'Terran Player');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `achievement`
--
ALTER TABLE `achievement`
  ADD PRIMARY KEY (`idachievement`),
  ADD KEY `fk_achievement_team1_idx` (`idteam`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`idevent`);

--
-- Indexes for table `event_teams`
--
ALTER TABLE `event_teams`
  ADD PRIMARY KEY (`idevent`,`idteam`),
  ADD KEY `fk_event_has_team_team1_idx` (`idteam`),
  ADD KEY `fk_event_has_team_event1_idx` (`idevent`);

--
-- Indexes for table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`idgame`);

--
-- Indexes for table `join_proposal`
--
ALTER TABLE `join_proposal`
  ADD PRIMARY KEY (`idjoin_proposal`),
  ADD KEY `fk_join_proposal_member1_idx` (`idmember`),
  ADD KEY `fk_join_proposal_team1_idx` (`idteam`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`idmember`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`idteam`),
  ADD KEY `fk_team_game1_idx` (`idgame`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`idteam`,`idmember`),
  ADD KEY `fk_team_has_member_member1_idx` (`idmember`),
  ADD KEY `fk_team_has_member_team_idx` (`idteam`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `achievement`
--
ALTER TABLE `achievement`
  MODIFY `idachievement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `idevent` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `game`
--
ALTER TABLE `game`
  MODIFY `idgame` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `join_proposal`
--
ALTER TABLE `join_proposal`
  MODIFY `idjoin_proposal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `idmember` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `idteam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `achievement`
--
ALTER TABLE `achievement`
  ADD CONSTRAINT `fk_achievement_team1` FOREIGN KEY (`idteam`) REFERENCES `team` (`idteam`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event_teams`
--
ALTER TABLE `event_teams`
  ADD CONSTRAINT `fk_event_has_team_event1` FOREIGN KEY (`idevent`) REFERENCES `event` (`idevent`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_event_has_team_team1` FOREIGN KEY (`idteam`) REFERENCES `team` (`idteam`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `join_proposal`
--
ALTER TABLE `join_proposal`
  ADD CONSTRAINT `fk_join_proposal_member1` FOREIGN KEY (`idmember`) REFERENCES `member` (`idmember`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_join_proposal_team1` FOREIGN KEY (`idteam`) REFERENCES `team` (`idteam`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `team`
--
ALTER TABLE `team`
  ADD CONSTRAINT `fk_team_game1` FOREIGN KEY (`idgame`) REFERENCES `game` (`idgame`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `team_members`
--
ALTER TABLE `team_members`
  ADD CONSTRAINT `fk_team_has_member_member1` FOREIGN KEY (`idmember`) REFERENCES `member` (`idmember`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_team_has_member_team` FOREIGN KEY (`idteam`) REFERENCES `team` (`idteam`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
