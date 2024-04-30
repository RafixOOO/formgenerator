-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2024 at 03:10 PM
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
(30, 'MIW', 2, '2024-04-30 13:38:15', '2024-05-30 00:00:00', 0);

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

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `organizationdata`
--

CREATE TABLE `organizationdata` (
  `OrganizationID` int(11) NOT NULL,
  `Name` text NOT NULL,
  `accept` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, '$2y$10$U28DAGDgFvMQLYOCJaPgKe4ZBy70pZs0ZGcz7csDqBhZUlGLAgXbO'),
(2, '$2y$10$cNE1gy/tsUqC27BJWJZ74eFMDJTTy7c37ShYwRbNVjnFlGnmMV5vy');

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
(55, 'tab4', 4, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `questconnect`
--

CREATE TABLE `questconnect` (
  `questconnectID` int(11) NOT NULL,
  `applicationID` int(11) NOT NULL,
  `questID` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `req` tinyint(1) NOT NULL DEFAULT 0
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
(55, 30, 55, 5, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `readyapplication`
--

CREATE TABLE `readyapplication` (
  `readyID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `applicationID` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'Rafał', 'Pezda', '123456789', 'rafal.pezda@tarkon.pl', 1, 1),
(2, 'tomasz', 'Pruś', '502116255', 'tomasz.prus@tarkon.pl', 1, 1);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `answerconnect`
--
ALTER TABLE `answerconnect`
  ADD PRIMARY KEY (`answerconnectID`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answerconnect`
--
ALTER TABLE `answerconnect`
  MODIFY `answerconnectID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `application`
--
ALTER TABLE `application`
  MODIFY `applicationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `organizationconnect`
--
ALTER TABLE `organizationconnect`
  MODIFY `organizationconnectID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `organizationdata`
--
ALTER TABLE `organizationdata`
  MODIFY `OrganizationID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quest`
--
ALTER TABLE `quest`
  MODIFY `questID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `questconnect`
--
ALTER TABLE `questconnect`
  MODIFY `questconnectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `readyapplication`
--
ALTER TABLE `readyapplication`
  MODIFY `readyID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
