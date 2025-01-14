-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2024 at 03:31 PM
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
(190, 57, 246, NULL, 'tekst'),
(191, 57, 247, 1, 'Koszta administracyjne'),
(192, 57, 248, 1, '7000'),
(193, 57, 249, 1, '100'),
(194, 57, 250, 1, '6900'),
(195, 57, 247, 2, 'inne'),
(196, 57, 248, 2, '1000'),
(197, 57, 249, 2, '1000'),
(198, 57, 250, 2, '0'),
(199, 57, 256, NULL, NULL),
(200, 57, 257, 1, 'Rafał'),
(201, 57, 257, 2, 'Pezda'),
(202, 57, 257, 3, 'rafal.pezda@tarkon.pl'),
(203, 57, 257, 4, '123456789'),
(204, 57, 258, NULL, '3'),
(205, 57, 259, NULL, 'Tak'),
(206, 57, 260, 1, '1,1'),
(207, 57, 261, 2, '1,2'),
(208, 57, 262, 3, '1,3'),
(209, 57, 263, NULL, 'tak'),
(210, 58, 246, NULL, 'tekst'),
(211, 58, 247, 1, 'Koszta administracyjne'),
(212, 58, 248, 1, '7000'),
(213, 58, 249, 1, '100'),
(214, 58, 250, 1, '6900'),
(215, 58, 247, 2, 'inne'),
(216, 58, 248, 2, '1000'),
(217, 58, 249, 2, '1000'),
(218, 58, 250, 2, '0'),
(219, 58, 256, NULL, NULL),
(220, 58, 257, 1, 'Rafał'),
(221, 58, 257, 2, 'Pezda'),
(222, 58, 257, 3, 'rafal.pezda@tarkon.pl'),
(223, 58, 257, 4, '123456789'),
(224, 58, 258, NULL, '3'),
(225, 58, 259, NULL, 'Tak'),
(226, 58, 260, 1, '1,1'),
(227, 58, 261, 2, '1,2'),
(228, 58, 262, 3, '1,3'),
(229, 58, 263, NULL, 'tak');

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
(9, 210, 'tek', 'nwm'),
(10, 211, 'sds', 'sd'),
(11, 215, 'nie inne', 'wdsds'),
(12, 190, 'tek', 'nwm'),
(13, 191, 'sds', 'sd'),
(14, 195, 'nie inne', 'wdsds');

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
(80, 'wniosek', 1, '2024-12-09 13:54:57', '2025-12-31 00:00:00', 0),
(82, 'wniosek', 1, '2024-12-09 13:54:57', '2025-12-31 00:00:00', 0);

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
(3, 'Organizacja', 0);

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
(243, 'tak', 1, 1),
(244, 'tak', 1, 1),
(245, 'punkt1', 11, 0),
(246, 'tekst', 1, 0),
(247, 'Rodzaj kosztu', 7, 0),
(248, 'Wartość w PLN', 7, 0),
(249, 'Z dotacji z PLN', 7, 0),
(250, 'Środki własne w PLN', 7, 0),
(251, '10', 7, 0),
(252, '7000', 7, 0),
(253, 'Jednokrotny wybór', 0, 0),
(254, '1', 3, 0),
(255, '2', 3, 0),
(256, '3', 3, 0),
(257, 'Dane', 8, 0),
(258, 'Organizacja', 9, 0),
(259, 'czy dobre', 10, 0),
(260, 'pole1', 11, 0),
(261, 'pole2', 11, 0),
(262, 'pole3', 11, 0),
(263, 'czy wszystko zrobione', 1, 1);

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
(250, 80, 246, 1, 1),
(251, 80, 247, 2, 1),
(252, 80, 248, 2, 1),
(253, 80, 249, 2, 1),
(254, 80, 250, 2, 1),
(255, 80, 251, 2, 1),
(256, 80, 252, 2, 1),
(257, 80, 253, 3, 1),
(258, 80, 254, 5, 1),
(259, 80, 255, 5, 1),
(260, 80, 256, 5, 1),
(261, 80, 257, 6, 1),
(262, 80, 258, 7, 1),
(263, 80, 259, 8, 1),
(264, 80, 260, 9, 1),
(265, 80, 261, 9, 1),
(266, 80, 262, 9, 1),
(267, 80, 263, 10, 1),
(300, 82, 246, 1, 1),
(301, 82, 247, 2, 1),
(302, 82, 248, 2, 1),
(303, 82, 249, 2, 1),
(304, 82, 250, 2, 1),
(305, 82, 251, 2, 1),
(306, 82, 252, 2, 1),
(307, 82, 253, 3, 1),
(308, 82, 254, 5, 1),
(309, 82, 255, 5, 1),
(310, 82, 256, 5, 1),
(311, 82, 257, 6, 1),
(312, 82, 258, 7, 1),
(313, 82, 259, 8, 1),
(314, 82, 260, 9, 1),
(315, 82, 261, 9, 1),
(316, 82, 262, 9, 1),
(317, 82, 263, 10, 1);

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
(57, 3, 80, 3, 6, '2024-12-09 14:18:02'),
(58, 1, 80, 2, 6, '2024-12-09 14:18:02');

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
-- Dumping data for table `workspacejson`
--

INSERT INTO `workspacejson` (`workspacejsonID`, `readyapplicationID`, `json`, `userID`) VALUES
(4, 66, '{\"1\":\"123\",\"id\":\"66\",\"number\":\"1\",\"\":\"Wr\\u00f3\\u0107\"}', 1),
(5, 45, '{\"id\":\"45\",\"number\":\"0\"}', 1),
(6, 78, '{\"id\":\"78\",\"number\":\"0\"}', 1),
(7, 52, '{\"id\":\"52\",\"number\":\"0\"}', 1),
(8, 80, '{\"10\":\"tak, lub nie\",\"id\":\"80\",\"number1\":\"10\",\"readyID\":\"57\"}', 1),
(9, 57, '{\"id\":\"57\",\"number\":\"0\"}', 1),
(10, 82, '{\"1\":\"\",\"5\":\"256\",\"7\":\"0\",\"2[]\":[\"Koszta administracyjne\",\"\",\"\",\"\"],\"a2[]\":[\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"],\"\":\"\",\"6[]\":[\"Rafa\\u0142\",\"Pezda\",\"rafal.pezda@tarkon.pl\",\"123456789\"],\"id\":\"82\",\"number\":\"7\"}', 1);

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
  MODIFY `answerconnectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=230;

--
-- AUTO_INCREMENT for table `answercorrect`
--
ALTER TABLE `answercorrect`
  MODIFY `answercorrectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `application`
--
ALTER TABLE `application`
  MODIFY `applicationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

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
  MODIFY `questID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=265;

--
-- AUTO_INCREMENT for table `questconnect`
--
ALTER TABLE `questconnect`
  MODIFY `questconnectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=318;

--
-- AUTO_INCREMENT for table `readyapplication`
--
ALTER TABLE `readyapplication`
  MODIFY `readyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `workspacejson`
--
ALTER TABLE `workspacejson`
  MODIFY `workspacejsonID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
