-- MySQL Workbench Synchronization
-- Generated: 2024-09-13 09:34
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: hdinata

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `esport` DEFAULT CHARACTER SET utf8 ;

CREATE TABLE IF NOT EXISTS `esport`.`member` (
  `idmember` INT(11) NOT NULL AUTO_INCREMENT,
  `fname` VARCHAR(45) NULL DEFAULT NULL,
  `lname` VARCHAR(45) NULL DEFAULT NULL,
  `username` VARCHAR(45) NULL DEFAULT NULL,
  `password` VARCHAR(45) NULL DEFAULT NULL,
  `profile` ENUM('admin', 'member') NULL DEFAULT NULL,
  PRIMARY KEY (`idmember`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `esport`.`team` (
  `idteam` INT(11) NOT NULL AUTO_INCREMENT,
  `idgame` INT(11) NOT NULL,
  `name` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`idteam`),
  INDEX `fk_team_game1_idx` (`idgame` ASC),
  CONSTRAINT `fk_team_game1`
    FOREIGN KEY (`idgame`)
    REFERENCES `esport`.`game` (`idgame`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `esport`.`game` (
  `idgame` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL DEFAULT NULL,
  `description` VARCHAR(200) NULL DEFAULT NULL,
  PRIMARY KEY (`idgame`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `esport`.`team_members` (
  `idteam` INT(11) NOT NULL,
  `idmember` INT(11) NOT NULL,
  `description` VARCHAR(75) NULL DEFAULT NULL,
  PRIMARY KEY (`idteam`, `idmember`),
  INDEX `fk_team_has_member_member1_idx` (`idmember` ASC),
  INDEX `fk_team_has_member_team_idx` (`idteam` ASC),
  CONSTRAINT `fk_team_has_member_team`
    FOREIGN KEY (`idteam`)
    REFERENCES `esport`.`team` (`idteam`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_team_has_member_member1`
    FOREIGN KEY (`idmember`)
    REFERENCES `esport`.`member` (`idmember`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `esport`.`event` (
  `idevent` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL DEFAULT NULL,
  `date` DATE NULL DEFAULT NULL,
  `description` VARCHAR(200) NULL DEFAULT NULL,
  PRIMARY KEY (`idevent`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `esport`.`event_teams` (
  `idevent` INT(11) NOT NULL,
  `idteam` INT(11) NOT NULL,
  PRIMARY KEY (`idevent`, `idteam`),
  INDEX `fk_event_has_team_team1_idx` (`idteam` ASC),
  INDEX `fk_event_has_team_event1_idx` (`idevent` ASC),
  CONSTRAINT `fk_event_has_team_event1`
    FOREIGN KEY (`idevent`)
    REFERENCES `esport`.`event` (`idevent`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_event_has_team_team1`
    FOREIGN KEY (`idteam`)
    REFERENCES `esport`.`team` (`idteam`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `esport`.`achievement` (
  `idachievement` INT(11) NOT NULL AUTO_INCREMENT,
  `idteam` INT(11) NOT NULL,
  `name` VARCHAR(45) NULL DEFAULT NULL,
  `date` DATE NULL DEFAULT NULL,
  `description` VARCHAR(200) NULL DEFAULT NULL,
  PRIMARY KEY (`idachievement`),
  INDEX `fk_achievement_team1_idx` (`idteam` ASC),
  CONSTRAINT `fk_achievement_team1`
    FOREIGN KEY (`idteam`)
    REFERENCES `esport`.`team` (`idteam`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `esport`.`join_proposal` (
  `idjoin_proposal` INT(11) NOT NULL AUTO_INCREMENT,
  `idmember` INT(11) NOT NULL,
  `idteam` INT(11) NOT NULL,
  `description` VARCHAR(100) NULL DEFAULT 'role preference: support, attacker, dll',
  `status` ENUM('waiting', 'approved', 'rejected') NULL DEFAULT NULL,
  PRIMARY KEY (`idjoin_proposal`),
  INDEX `fk_join_proposal_member1_idx` (`idmember` ASC),
  INDEX `fk_join_proposal_team1_idx` (`idteam` ASC),
  CONSTRAINT `fk_join_proposal_member1`
    FOREIGN KEY (`idmember`)
    REFERENCES `esport`.`member` (`idmember`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_join_proposal_team1`
    FOREIGN KEY (`idteam`)
    REFERENCES `esport`.`team` (`idteam`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

-- Dummy Data for `esport` Schema

-- Data for `member` Table
INSERT INTO `esport`.`member` (`fname`, `lname`, `username`, `password`, `profile`) VALUES
('Charlotte', 'Edwards', 'cedwards', 'password21', 'member'),
('John', 'Smith', 'jsmith', 'password22', 'admin'),
('Maria', 'Garcia', 'mgarcia', 'password23', 'member'),
('Michael', 'Johnson', 'mjohnson', 'password24', 'member'),
('Linda', 'Williams', 'lwilliams', 'password25', 'admin'),
('David', 'Jones', 'djones', 'password26', 'member'),
('Emily', 'Davis', 'edavis', 'password27', 'member'),
('Robert', 'Martinez', 'rmartinez', 'password28', 'member'),
('James', 'Lopez', 'jlopez', 'password29', 'member'),
('Jennifer', 'Gonzalez', 'jgonzalez', 'password30', 'admin'),
('Patricia', 'Lee', 'plee', 'password31', 'member'),
('Christopher', 'Walker', 'cwalker', 'password32', 'member'),
('Barbara', 'Hall', 'bhall', 'password33', 'member'),
('William', 'Young', 'wyoung', 'password34', 'admin'),
('Elizabeth', 'Allen', 'eallen', 'password35', 'member');

-- Data for `game` Table
INSERT INTO `esport`.`game` (`name`, `description`) VALUES
('Valorant', 'A tactical first-person shooter by Riot Games'),
('Dota 2', 'A 5v5 MOBA game by Valve Corporation'),
('Counter-Strike: Global Offensive', 'A competitive first-person shooter by Valve Corporation'),
('Rocket League', 'A vehicular soccer game by Psyonix'),
('PUBG', 'A battle royale game by PUBG Corporation'),
('Call of Duty: Warzone', 'A free-to-play battle royale by Activision'),
('Rainbow Six Siege', 'A tactical shooter by Ubisoft'),
('Starcraft II', 'A real-time strategy game by Blizzard Entertainment');

-- Data for `team` Table
INSERT INTO `esport`.`team` (`idgame`, `name`) VALUES
(1, 'Valorant Vipers'),
(2, 'Dota Destroyers'),
(3, 'CSGO Sharpshooters'),
(4, 'Rocket Racers'),
(5, 'PUBG Predators'),
(6, 'Warzone Warriors'),
(7, 'Siege Specialists'),
(8, 'Starcraft Strategists');

-- Data for `team_members` Table
INSERT INTO `esport`.`team_members` (`idteam`, `idmember`, `description`) VALUES
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
(6, 11, 'Support'),
(6, 12, 'Attacker'),
(7, 13, 'Breacher'),
(7, 14, 'Anchor'),
(8, 15, 'Zerg Player'),
(8, 16, 'Terran Player');

-- Data for `event` Table
INSERT INTO `esport`.`event` (`name`, `date`, `description`) VALUES
('Valorant Masters', '2024-08-05', 'Major Valorant tournament'),
('Dota 2 International', '2024-10-15', 'The premier Dota 2 tournament'),
('CSGO Major Championship', '2024-09-01', 'Top CSGO teams compete for the major title'),
('Rocket League World Cup', '2024-11-01', 'Global Rocket League championship'),
('PUBG Continental Series', '2024-12-12', 'Regional PUBG tournaments leading to global finals'),
('Warzone Showdown', '2024-11-20', 'Top Warzone players battle for glory'),
('Rainbow Six Invitational', '2024-10-10', 'The biggest event for Rainbow Six Siege'),
('Starcraft II World Championship', '2024-09-25', 'Top players compete for the Starcraft II title');

-- Data for `event_teams` Table
INSERT INTO `esport`.`event_teams` (`idevent`, `idteam`) VALUES
(1, 1),
(1, 2),
(2, 3),
(2, 4),
(3, 5),
(3, 6),
(4, 7),
(4, 8),
(5, 1),
(5, 2),
(6, 3),
(6, 4),
(7, 5),
(7, 6),
(8, 7),
(8, 8);

-- Data for `achievement` Table
INSERT INTO `esport`.`achievement` (`idteam`, `name`, `date`, `description`) VALUES
(1, 'Valorant Masters Runner-Up', '2024-08-10', 'Finished second in the Valorant Masters'),
(2, 'Dota 2 International Champion', '2024-10-20', 'Won the Dota 2 International'),
(3, 'CSGO Major Semi-Finalist', '2024-09-05', 'Reached semifinals in CSGO Major Championship'),
(4, 'Rocket League World Cup Winner', '2024-11-05', 'Won the Rocket League World Cup'),
(5, 'PUBG Continental Series Finalist', '2024-12-15', 'Reached finals in PUBG Continental Series'),
(6, 'Warzone Showdown MVP', '2024-11-22', 'Most Valuable Player in Warzone Showdown'),
(7, 'Rainbow Six Invitational Champion', '2024-10-15', 'Won the Rainbow Six Invitational'),
(8, 'Starcraft II World Championship Third Place', '2024-09-28', 'Secured third place in Starcraft II World Championship');

-- Data for `join_proposal` Table
INSERT INTO `esport`.`join_proposal` (`idmember`, `idteam`, `description`, `status`) VALUES
(2, 1, 'Experienced initiator looking for a team', 'waiting'),
(3, 2, 'Pro support player with experience in top tournaments', 'approved'),
(4, 3, 'Seeking a new challenge as a sniper', 'rejected'),
(5, 4, 'Looking to join a competitive Rocket League team', 'waiting'),
(6, 5, 'Strong PUBG player, excels in team strategies', 'approved'),
(7, 6, 'Warzone player with high KD ratio', 'waiting'),
(8, 7, 'Looking for Siege team to join', 'rejected'),
(9, 8, 'Starcraft player with strong Zerg strategies', 'approved');


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
