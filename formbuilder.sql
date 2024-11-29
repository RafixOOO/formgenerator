-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Lis 13, 2024 at 11:56 AM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `formbuilder`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `answerconnect`
--

CREATE TABLE `answerconnect` (
  `answerconnectID` int(11) NOT NULL,
  `readyID` int(11) NOT NULL,
  `questID` int(11) NOT NULL,
  `tablerow` int(11) DEFAULT NULL,
  `answer` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `answerconnect`
--

INSERT INTO `answerconnect` (`answerconnectID`, `readyID`, `questID`, `tablerow`, `answer`) VALUES
(1, 11, 106, NULL, 'tak'),
(21, 27, 104, 4, '123456789'),
(22, 28, 104, 1, 'Rafał'),
(23, 28, 104, 2, 'Pezda'),
(24, 28, 104, 3, 'rafal.pezda@tarkon.pl'),
(25, 28, 104, 4, '123456789'),
(26, 28, 105, NULL, '3'),
(27, 29, 104, 1, 'Rafał'),
(28, 29, 104, 2, 'Pezda'),
(29, 29, 104, 3, 'rafal.pezda@tarkon.pl'),
(30, 29, 104, 4, '123456789'),
(31, 29, 105, NULL, '3'),
(32, 30, 104, 1, 'Andrzej'),
(33, 30, 104, 2, 'Kowalski'),
(34, 30, 104, 3, 'sfi81124@ilebi.com'),
(35, 30, 104, 4, '123456789'),
(36, 30, 105, NULL, '3'),
(45, 32, 124, NULL, 'ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss'),
(46, 32, 125, NULL, 'ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss'),
(47, 33, 124, NULL, '1'),
(48, 33, 125, NULL, '2'),
(49, 34, 124, NULL, 'w3ewewe'),
(50, 34, 125, NULL, 'brak'),
(51, 35, 195, NULL, NULL),
(52, 35, 196, NULL, NULL),
(53, 36, 198, NULL, NULL),
(54, 37, 202, 1, '0'),
(55, 37, 202, 1, '0'),
(56, 37, 202, 1, '0'),
(57, 38, 206, NULL, 'tak'),
(58, 38, 207, NULL, 'nie'),
(59, 39, 206, NULL, '1'),
(60, 39, 207, NULL, '2'),
(61, 40, 206, NULL, '1'),
(62, 40, 207, NULL, '2'),
(63, 41, 208, NULL, 'dsdsdsds'),
(64, 42, 208, NULL, 'fgdfgdfg'),
(65, 43, 208, NULL, 'dfgdfgsdfdsfgs'),
(66, 44, 208, NULL, 'qwerty'),
(67, 45, 208, NULL, 'qwerty'),
(98, 31, 120, NULL, 'Nie'),
(99, 31, 121, 1, '3,1'),
(100, 31, 122, 2, '3,2'),
(101, 31, 123, 3, '3,3'),
(106, 31, 120, NULL, 'Tak'),
(107, 31, 121, 1, '2,33'),
(108, 31, 122, 2, '2,34'),
(109, 31, 123, 3, '2,234'),
(118, 46, 209, 1, '1'),
(119, 46, 210, 1, '2'),
(120, 46, 211, 1, '3'),
(121, 46, 209, 2, '4'),
(122, 46, 210, 2, '5'),
(123, 46, 211, 2, '6'),
(124, 46, 209, 3, '7'),
(125, 46, 210, 3, '8'),
(126, 46, 211, 3, '9'),
(127, 46, 209, 4, '10'),
(128, 46, 210, 4, '11'),
(129, 46, 211, 4, '12'),
(134, 47, 212, NULL, 'Tak'),
(135, 47, 213, 1, '3,1'),
(136, 47, 214, 2, '3,2'),
(137, 47, 215, 3, '3,3'),
(142, 47, 212, NULL, 'Tak'),
(143, 47, 213, 1, '1,1'),
(144, 47, 214, 2, '1,2'),
(145, 47, 215, 3, '1,3'),
(146, 48, 228, 1, 'Koszta administracyjne'),
(147, 48, 229, 1, '505'),
(148, 48, 230, 1, '45'),
(149, 48, 232, 1, 'brak'),
(150, 48, 233, 1, 'brak'),
(151, 48, 228, 2, 'ffff'),
(152, 48, 229, 2, '5'),
(153, 48, 230, 2, '5'),
(154, 48, 232, 2, 'brak'),
(155, 48, 233, 2, 'brak'),
(156, 49, 236, NULL, 'halo'),
(157, 49, 237, NULL, 'Nie'),
(158, 49, 238, NULL, 'Nie'),
(159, 49, 239, 1, '1,7'),
(160, 49, 240, 2, '1,2'),
(161, 49, 241, 3, '1,5'),
(162, 50, 236, NULL, 'sdwwdsasd');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `answercorrect`
--

CREATE TABLE `answercorrect` (
  `answercorrectID` int(11) NOT NULL,
  `answerconnectID` int(11) NOT NULL,
  `answer` text NOT NULL,
  `reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `answercorrect`
--

INSERT INTO `answercorrect` (`answercorrectID`, `answerconnectID`, `answer`, `reason`) VALUES
(7, 156, '222', 'fgdfgdfgdfg');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `application`
--

CREATE TABLE `application` (
  `applicationID` int(11) NOT NULL,
  `name` text NOT NULL,
  `userID` int(11) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `datetimedo` datetime NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `application`
--

INSERT INTO `application` (`applicationID`, `name`, `userID`, `datetime`, `datetimedo`, `deleted`) VALUES
(29, 'Wniosek 1', 1, '2024-04-30 13:31:40', '2024-05-03 00:00:00', 0),
(30, 'MIW', 2, '2024-04-30 13:38:15', '2024-12-30 00:00:00', 0),
(31, 'wniosek', 1, '2024-06-14 00:00:00', '2024-06-28 00:00:00', 1),
(32, 'wniosek', 1, '2024-06-14 00:00:00', '2024-06-21 00:00:00', 1),
(33, 'wniiosek', 1, '2024-06-14 00:00:00', '2024-06-21 00:00:00', 1),
(34, 'wniosek2', 1, '2024-06-14 00:00:00', '2024-06-21 00:00:00', 2),
(35, 'tea', 1, '2024-07-04 00:00:00', '2024-06-21 00:00:00', 2),
(36, 'Wniosektest', 1, '2024-07-01 09:07:48', '2024-07-05 00:00:00', 1),
(37, 'testwniosek', 1, '2024-07-01 09:21:16', '2024-07-05 00:00:00', 1),
(38, 'testwniosek', 1, '2024-07-01 09:24:23', '2024-07-05 00:00:00', 1),
(39, 'test', 1, '2024-07-01 10:14:22', '2024-07-05 00:00:00', 1),
(40, 'test2', 1, '2024-07-01 11:26:28', '2024-10-05 00:00:00', 1),
(41, 'test3', 1, '2024-07-01 11:29:37', '2024-07-05 00:00:00', 1),
(42, 'test1', 1, '2024-07-04 00:00:00', '2024-07-05 00:00:00', 2),
(43, 'test2', 1, '2024-07-01 00:00:00', '2024-07-05 00:00:00', 0),
(44, 'test3', 1, '2024-07-03 12:40:30', '2024-07-12 00:00:00', 0),
(45, 'nazwa', 1, '2024-07-03 00:00:00', '2024-07-12 00:00:00', 2),
(48, 'test3', 1, '2024-07-03 14:56:13', '2024-07-12 00:00:00', 2),
(49, 'test3', 1, '2024-07-03 14:57:48', '2024-07-12 00:00:00', 2),
(50, 'wwww', 1, '2024-07-09 08:32:41', '2024-07-12 00:00:00', 1),
(51, 'wwww', 1, '2024-07-09 00:00:00', '2024-07-12 00:00:00', 1),
(52, 'weewewewe', 1, '2024-07-09 08:33:50', '2024-07-12 00:00:00', 0),
(53, 'wweweewewssss', 1, '2024-07-09 08:39:39', '2024-07-12 00:00:00', 0),
(54, 'wwwwwwddssdsda', 1, '2024-07-09 08:50:21', '2024-07-12 00:00:00', 0),
(55, 'Opowiedz - moja przestrzeń działania Edycja 1 – 2024', 1, '2024-07-09 09:52:07', '2024-08-19 00:00:00', 0),
(56, 'klkl', 1, '2024-07-11 09:07:25', '2024-07-12 00:00:00', 0),
(57, '321', 1, '2024-07-11 09:43:44', '2024-07-19 00:00:00', 0),
(58, 'dsdsdsad', 1, '2024-08-23 10:10:48', '2024-08-30 00:00:00', 0),
(59, 'gdghdfgh', 2, '2024-08-28 10:26:45', '2024-08-30 00:00:00', 0),
(60, 'wniosek', 1, '2024-08-30 14:28:53', '2024-10-01 00:00:00', 0),
(61, 'wniosektest', 1, '2024-09-23 11:46:27', '2024-10-31 00:00:00', 0),
(62, 'www', 1, '2024-09-25 08:36:21', '2024-09-26 00:00:00', 0),
(63, 'ww3', 1, '2024-09-25 08:42:47', '2024-09-27 00:00:00', 0),
(64, 'dddddddddd', 2, '2024-09-25 08:48:18', '2024-09-30 00:00:00', 0),
(65, 'test3', 1, '2024-10-08 11:40:28', '2024-10-18 00:00:00', 0),
(66, 'wniosek test', 1, '2024-10-10 08:07:53', '2024-12-31 00:00:00', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `organizationconnect`
--

CREATE TABLE `organizationconnect` (
  `organizationconnectID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `role` int(11) NOT NULL,
  `OrganizationID` int(11) NOT NULL,
  `accept` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organizationconnect`
--

INSERT INTO `organizationconnect` (`organizationconnectID`, `UserID`, `role`, `OrganizationID`, `accept`) VALUES
(1, 1, 3, 1, 1),
(2, 1, 3, 2, 1),
(3, 1, 3, 3, 1),
(4, 3, 1, 3, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `organizationdata`
--

CREATE TABLE `organizationdata` (
  `OrganizationID` int(11) NOT NULL,
  `Name` text NOT NULL,
  `accept` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organizationdata`
--

INSERT INTO `organizationdata` (`OrganizationID`, `Name`, `accept`) VALUES
(1, 'organizacja1', 2),
(2, '', 2),
(3, 'Organizacja', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `password`
--

CREATE TABLE `password` (
  `passwordID` int(11) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password`
--

INSERT INTO `password` (`passwordID`, `password`) VALUES
(0, 'Tarkon2021'),
(1, '$2y$10$WI.nqoP9mDFu19cDqbv5VeOiZz7Ic9uXnavUZgTLEZvw70CgO.GOi'),
(2, '$2y$10$WI.nqoP9mDFu19cDqbv5VeOiZz7Ic9uXnavUZgTLEZvw70CgO.GOi'),
(3, '$2y$10$WI.nqoP9mDFu19cDqbv5VeOiZz7Ic9uXnavUZgTLEZvw70CgO.GOi');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `quest`
--

CREATE TABLE `quest` (
  `questID` int(11) NOT NULL,
  `quest` text NOT NULL,
  `type` int(11) NOT NULL,
  `constant` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quest`
--

INSERT INTO `quest` (`questID`, `quest`, `type`, `constant`) VALUES
(43, 'to jest tekst', 1, 0),
(44, '1', 4, 0),
(45, '2', 4, 0),
(46, '3', 4, 0),
(47, 'czy  organiczacja non profit', 2, 0),
(48, 'inna', 2, 0),
(49, 'Imie', 1, 0),
(50, 'Nazwisko', 1, 0),
(51, 'opis', 1, 0),
(52, 'tab1', 4, 0),
(53, 'tab2', 4, 0),
(54, 'tab3', 4, 0),
(55, 'tab4', 4, 0),
(78, 'nie', 1, 0),
(79, 'tak', 1, 0),
(80, 'moze', 1, 0),
(81, 'nie', 1, 0),
(82, 'tak', 1, 0),
(94, 'tak', 1, 0),
(95, '1', 4, 0),
(96, '2', 4, 0),
(97, '3', 4, 0),
(98, 'nie', 1, 0),
(99, 'Tak?', 10, 0),
(100, 'Nie?', 10, 0),
(101, 'czy mial to', 11, 0),
(102, 'czy mial tamto', 11, 0),
(103, 'czy dobrze?', 11, 0),
(104, 'Dane', 8, 0),
(105, 'Organizacja', 9, 0),
(106, 'tak', 1, 0),
(107, 'Dane', 8, 0),
(108, 'Organizacja', 9, 0),
(109, 'tak', 1, 0),
(110, 'tajk', 1, 0),
(111, 'nie', 1, 0),
(120, 'czy tak', 10, 0),
(121, 'pierwszy', 11, 0),
(122, 'drugi', 11, 0),
(123, 'trzeci', 11, 0),
(124, 'tekst1', 1, 0),
(125, 'tekst2', 1, 0),
(179, 'tyrt', 4, 0),
(180, 'ytrytyr', 4, 0),
(181, 'czxczxczxc', 1, 0),
(182, 'Dane', 8, 0),
(183, 'Organizacja', 9, 0),
(184, 'teresfdsf', 10, 0),
(185, '', 3, 0),
(186, 'nn', 1, 0),
(187, 'tt', 1, 0),
(188, 'tak', 1, 0),
(189, 'Dane', 8, 0),
(192, 'wwwwww', 3, 0),
(193, 'wwww', 3, 0),
(194, 'wwww', 3, 0),
(195, 'ewewe', 2, 0),
(196, 'ewewewe', 2, 0),
(197, '1', 3, 0),
(198, '2', 3, 0),
(199, '3', 3, 0),
(200, 'czy', 10, 0),
(201, 'czy', 10, 0),
(202, 'tak?', 11, 0),
(203, '1', 4, 0),
(204, '2', 4, 0),
(205, '3', 4, 0),
(206, 'tak', 1, 0),
(207, 'nie', 1, 0),
(208, 'sdsdd', 1, 0),
(209, 'nazwa', 4, 0),
(210, 'pole', 4, 0),
(211, 'ostatni', 4, 0),
(212, 'aaaaaaaaaaaaaaaaaaaaa', 10, 0),
(213, '1', 11, 0),
(214, '2', 11, 0),
(215, '3', 11, 0),
(216, 'nazwa', 7, 0),
(217, 'pole1', 7, 0),
(218, 'pole2', 7, 0),
(219, 'pole3', 7, 0),
(220, '10', 7, 0),
(221, '7500', 7, 0),
(222, 'nazwa', 5, 0),
(223, 'pole1', 5, 0),
(224, 'pole2', 5, 0),
(225, 'nazwa', 6, 0),
(226, 'pole1', 6, 0),
(227, 'pole2', 6, 0),
(228, 'rodzaj koszytu', 7, 0),
(229, 'wartosc w PLN', 7, 0),
(230, 'z dotacji w pln', 7, 0),
(231, 'środki własne', 7, 0),
(232, '10', 7, 0),
(233, '7500', 7, 0),
(234, 'pole1', 1, 0),
(235, 'pole2', 1, 0),
(236, 'halo', 1, 0),
(237, 'czy ma to', 10, 0),
(238, 'czy ma tamto', 10, 0),
(239, '1 pole', 11, 0),
(240, '2 pole', 11, 0),
(241, '3 pole', 11, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `questconnect`
--

CREATE TABLE `questconnect` (
  `questconnectID` int(11) NOT NULL,
  `applicationID` int(11) NOT NULL,
  `questID` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `req` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questconnect`
--

INSERT INTO `questconnect` (`questconnectID`, `applicationID`, `questID`, `number`, `req`) VALUES
(43, 29, 43, 1, 1),
(44, 29, 44, 2, 1),
(45, 29, 45, 2, 1),
(46, 29, 46, 2, 1),
(47, 30, 47, 1, 1),
(48, 30, 48, 1, 1),
(49, 30, 49, 2, 1),
(50, 30, 50, 3, 1),
(51, 30, 51, 4, 1),
(52, 30, 52, 5, 1),
(53, 30, 53, 5, 1),
(54, 30, 54, 5, 1),
(55, 30, 55, 5, 1),
(78, 0, 78, 1, 1),
(79, 0, 79, 2, 1),
(80, 0, 80, 3, 1),
(81, 0, 81, 1, 1),
(82, 0, 82, 2, 1),
(94, 34, 94, 1, 1),
(95, 34, 95, 2, 1),
(96, 34, 96, 2, 1),
(97, 34, 97, 2, 1),
(98, 34, 98, 3, 1),
(99, 36, 99, 3, 1),
(100, 36, 100, 4, 1),
(101, 36, 101, 5, 1),
(102, 36, 102, 5, 1),
(103, 36, 103, 5, 1),
(104, 38, 104, 1, 1),
(105, 38, 105, 2, 1),
(106, 39, 106, 1, 1),
(107, 40, 107, 1, 1),
(108, 40, 108, 2, 1),
(109, 40, 109, 3, 1),
(110, 41, 110, 1, 1),
(111, 41, 111, 2, 1),
(120, 43, 120, 1, 1),
(121, 43, 121, 2, 1),
(122, 43, 122, 2, 1),
(123, 43, 123, 2, 1),
(124, 44, 124, 1, 1),
(125, 44, 125, 2, 1),
(179, 45, 179, 1, 1),
(180, 45, 180, 1, 1),
(181, 45, 181, 2, 1),
(182, 45, 182, 3, 1),
(183, 45, 183, 4, 1),
(184, 45, 184, 5, 1),
(185, 49, 124, 1, 1),
(186, 49, 125, 2, 1),
(187, 0, 185, 2, 1),
(188, 35, 186, 1, 1),
(189, 35, 187, 2, 1),
(190, 42, 188, 1, 1),
(191, 42, 189, 2, 1),
(192, 50, 190, 1, 1),
(193, 50, 191, 1, 1),
(197, 51, 192, 1, 1),
(198, 51, 193, 1, 1),
(199, 51, 194, 1, 1),
(200, 52, 195, 1, 1),
(201, 52, 196, 1, 1),
(202, 53, 197, 1, 1),
(203, 53, 198, 1, 1),
(204, 53, 199, 1, 1),
(205, 54, 200, 1, 1),
(206, 54, 201, 2, 1),
(207, 54, 202, 3, 1),
(208, 56, 203, 1, 1),
(209, 56, 204, 1, 1),
(210, 56, 205, 1, 1),
(211, 57, 206, 1, 1),
(212, 57, 207, 2, 1),
(213, 58, 208, 1, 1),
(214, 60, 209, 1, 1),
(215, 60, 210, 1, 1),
(216, 60, 211, 1, 1),
(217, 61, 212, 1, 1),
(218, 61, 213, 2, 1),
(219, 61, 214, 2, 1),
(220, 61, 215, 2, 1),
(221, 62, 216, 1, 1),
(222, 62, 217, 1, 1),
(223, 62, 218, 1, 1),
(224, 62, 219, 1, 1),
(225, 62, 220, 1, 1),
(226, 62, 221, 1, 1),
(227, 63, 222, 1, 1),
(228, 63, 223, 1, 1),
(229, 63, 224, 1, 1),
(230, 63, 225, 2, 1),
(231, 63, 226, 2, 1),
(232, 63, 227, 2, 1),
(233, 64, 228, 1, 1),
(234, 64, 229, 1, 1),
(235, 64, 230, 1, 1),
(236, 64, 231, 1, 1),
(237, 64, 232, 1, 1),
(238, 64, 233, 1, 1),
(239, 65, 234, 1, 1),
(240, 65, 235, 2, 1),
(241, 66, 236, 1, 1),
(242, 66, 237, 2, 1),
(243, 66, 238, 3, 1),
(244, 66, 239, 4, 1),
(245, 66, 240, 4, 1),
(246, 66, 241, 4, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `readyapplication`
--

CREATE TABLE `readyapplication` (
  `readyID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `applicationID` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `createdate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `readyapplication`
--

INSERT INTO `readyapplication` (`readyID`, `userID`, `applicationID`, `status`, `type`, `createdate`) VALUES
(1, 1, 38, 1, 0, '2024-07-09 00:00:00'),
(2, 1, 38, 1, 0, '2024-07-09 00:00:00'),
(3, 1, 38, 1, 0, '2024-07-09 00:00:00'),
(4, 1, 38, 1, 0, '2024-07-09 00:00:00'),
(5, 1, 38, 1, 0, '2024-07-09 00:00:00'),
(6, 1, 38, 1, 0, '2024-07-09 00:00:00'),
(7, 1, 38, 1, 0, '2024-07-09 00:00:00'),
(8, 1, 38, 1, 0, '2024-07-09 00:00:00'),
(9, 1, 38, 1, 0, '2024-07-09 00:00:00'),
(10, 1, 38, 1, 0, '2024-07-09 00:00:00'),
(11, 1, 39, 1, 0, '2024-07-09 00:00:00'),
(12, 1, 38, 1, 0, '2024-07-09 00:00:00'),
(13, 1, 38, 1, 0, '2024-07-09 00:00:00'),
(14, 1, 38, 1, 0, '2024-07-09 00:00:00'),
(15, 1, 38, 1, 0, '2024-07-09 00:00:00'),
(16, 1, 38, 1, 0, '2024-07-09 00:00:00'),
(17, 1, 38, 1, 0, '2024-07-09 00:00:00'),
(18, 1, 38, 1, 0, '2024-07-09 00:00:00'),
(19, 1, 38, 1, 0, '2024-07-09 00:00:00'),
(20, 3, 38, 1, 0, '2024-07-09 00:00:00'),
(21, 3, 38, 1, 0, '2024-07-09 00:00:00'),
(22, 3, 38, 1, 0, '2024-07-09 00:00:00'),
(23, 3, 38, 1, 0, '2024-07-09 00:00:00'),
(24, 3, 38, 1, 0, '2024-07-09 00:00:00'),
(25, 3, 38, 1, 0, '2024-07-09 00:00:00'),
(26, 1, 38, 1, 0, '2024-07-09 00:00:00'),
(27, 1, 38, 1, 0, '2024-07-09 00:00:00'),
(28, 1, 38, 1, 0, '2024-07-09 00:00:00'),
(29, 1, 38, 1, 0, '2024-07-09 00:00:00'),
(30, 3, 38, 0, 0, '2024-07-09 00:00:00'),
(31, 3, 43, 1, 36, '2024-07-09 00:00:00'),
(32, 3, 44, 0, 0, '2024-07-09 00:00:00'),
(33, 1, 44, 1, 0, '2024-07-09 00:00:00'),
(34, 2, 44, 2, 5, '2024-07-09 08:31:54'),
(35, 3, 52, 0, 0, '2024-07-09 08:34:43'),
(36, 3, 53, 0, 0, '2024-07-09 08:39:44'),
(37, 1, 54, 1, 0, '2024-07-09 08:50:27'),
(38, 1, 57, 1, 0, '2024-07-16 12:56:19'),
(39, 1, 57, 1, 0, '2024-07-16 13:15:03'),
(40, 1, 57, 1, 0, '2024-07-16 13:17:19'),
(41, 1, 58, 1, 0, '2024-08-23 10:10:54'),
(42, 2, 58, 0, 0, '2024-08-23 10:17:59'),
(43, 2, 58, 0, 0, '2024-08-23 10:18:02'),
(44, 1, 58, 1, 0, '2024-08-26 08:43:33'),
(45, 1, 58, 2, 8, '2024-08-26 08:44:10'),
(46, 3, 60, 0, 0, '2024-08-30 14:29:10'),
(47, 2, 61, 2, 6, '2024-09-23 11:46:51'),
(48, 2, 64, 1, 0, '2024-09-25 08:50:11'),
(49, 2, 66, 2, 0, '2024-10-10 08:08:49'),
(50, 1, 66, 1, 0, '2024-11-04 08:53:28');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `name` text NOT NULL,
  `surname` text NOT NULL,
  `phone` text NOT NULL,
  `email` text NOT NULL,
  `role` int(11) NOT NULL DEFAULT 0,
  `verify` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `name`, `surname`, `phone`, `email`, `role`, `verify`) VALUES
(1, 'Rafał', 'Pezda', '123456789', 'rafal.pezda@tarkon.pl', 3, 1),
(2, 'tomasz', 'Pruś', '502116255', 'tomasz.prus@tarkon.pl', 2, 1),
(3, 'Andrzej', 'Kowalski', '123456789', 'sfi81124@ilebi.com', 1, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `workspacejson`
--

CREATE TABLE `workspacejson` (
  `workspacejsonID` int(11) NOT NULL,
  `readyapplicationID` int(11) NOT NULL,
  `json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`json`)),
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `answerconnect`
--
ALTER TABLE `answerconnect`
  ADD PRIMARY KEY (`answerconnectID`);

--
-- Indeksy dla tabeli `answercorrect`
--
ALTER TABLE `answercorrect`
  ADD PRIMARY KEY (`answercorrectID`);

--
-- Indeksy dla tabeli `application`
--
ALTER TABLE `application`
  ADD PRIMARY KEY (`applicationID`);

--
-- Indeksy dla tabeli `organizationconnect`
--
ALTER TABLE `organizationconnect`
  ADD PRIMARY KEY (`organizationconnectID`);

--
-- Indeksy dla tabeli `organizationdata`
--
ALTER TABLE `organizationdata`
  ADD PRIMARY KEY (`OrganizationID`);

--
-- Indeksy dla tabeli `password`
--
ALTER TABLE `password`
  ADD PRIMARY KEY (`passwordID`);

--
-- Indeksy dla tabeli `quest`
--
ALTER TABLE `quest`
  ADD PRIMARY KEY (`questID`);

--
-- Indeksy dla tabeli `questconnect`
--
ALTER TABLE `questconnect`
  ADD PRIMARY KEY (`questconnectID`);

--
-- Indeksy dla tabeli `readyapplication`
--
ALTER TABLE `readyapplication`
  ADD PRIMARY KEY (`readyID`);

--
-- Indeksy dla tabeli `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

--
-- Indeksy dla tabeli `workspacejson`
--
ALTER TABLE `workspacejson`
  ADD PRIMARY KEY (`workspacejsonID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answerconnect`
--
ALTER TABLE `answerconnect`
  MODIFY `answerconnectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT for table `answercorrect`
--
ALTER TABLE `answercorrect`
  MODIFY `answercorrectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `application`
--
ALTER TABLE `application`
  MODIFY `applicationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `organizationconnect`
--
ALTER TABLE `organizationconnect`
  MODIFY `organizationconnectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `organizationdata`
--
ALTER TABLE `organizationdata`
  MODIFY `OrganizationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `quest`
--
ALTER TABLE `quest`
  MODIFY `questID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=242;

--
-- AUTO_INCREMENT for table `questconnect`
--
ALTER TABLE `questconnect`
  MODIFY `questconnectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT for table `readyapplication`
--
ALTER TABLE `readyapplication`
  MODIFY `readyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `workspacejson`
--
ALTER TABLE `workspacejson`
  MODIFY `workspacejsonID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
