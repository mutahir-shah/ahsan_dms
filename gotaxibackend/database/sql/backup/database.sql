-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 22, 2022 at 12:51 PM
-- Server version: 8.0.27-0ubuntu0.20.04.1
-- PHP Version: 7.3.33-1+ubuntu20.04.1+deb.sury.org+1

SET
SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET
time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `live_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts`
(
    `id`             int UNSIGNED NOT NULL,
    `name`           varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `email`          varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `mobile`         varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `password`       varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `remember_token` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `created_at`     timestamp NULL DEFAULT NULL,
    `updated_at`     timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `name`, `email`, `mobile`, `password`, `remember_token`, `created_at`, `updated_at`)
VALUES (6, 'philip F Lungu', 'optimyze.zm@gmail.com', '0975168880',
        '$2y$10$M8OtLrY5DzGlvVNAS1UAtObtzqswb6lGfXnikM9GXzJWYpdFHvF2u',
        'u7Ly8jyTXwLJ6sqfCvckXvAJEy9LDqIpNxEqX1MnlxSg0h8tr3sg43xadn0l', '2020-10-18 16:02:45', '2020-10-18 16:02:45');

-- --------------------------------------------------------

--
-- Table structure for table `account_password_resets`
--

CREATE TABLE `account_password_resets`
(
    `email`      varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `token`      varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins`
(
    `id`             int UNSIGNED NOT NULL,
    `name`           varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `email`          varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `password`       varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `picture`        varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `remember_token` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `created_at`     timestamp NULL DEFAULT NULL,
    `updated_at`     timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `picture`, `remember_token`, `created_at`, `updated_at`)
VALUES (1, 'Cheetah', 'admin@cheetahrides.com', '$2y$10$qYXL4vJDNmfaYDCjOkog/OiDMwsTrHXwZCbvAC36BtV8Cm7/Huz8a',
        'app/public/admin/profile/rrdfsxtXNs8n4IVQbAavrTTrMYWPIlVVTr6r9PXW.png',
        'sWD6Y1lFYOAo1fCOiKXes8hfC2JpKgFVtp27kXvXlLLUxjqaTIQ2wRAfL1w5', NULL, '2021-12-17 15:16:10');

-- --------------------------------------------------------

--
-- Table structure for table `bank_accounts`
--

CREATE TABLE `bank_accounts`
(
    `id`             int      NOT NULL,
    `paypal_id`      varchar(1000)     DEFAULT NULL,
    `upi_id`         varchar(1000)     DEFAULT NULL,
    `account_name`   varchar(1000)     DEFAULT NULL,
    `type`           varchar(100)      DEFAULT NULL,
    `bank_name`      varchar(100)      DEFAULT NULL,
    `account_number` varchar(1000)     DEFAULT NULL,
    `IFSC_code`      varchar(500)      DEFAULT NULL,
    `MICR_code`      varchar(500)      DEFAULT NULL,
    `routing_number` int               DEFAULT NULL,
    `provider_id`    int      NOT NULL,
    `status`         enum('WAITING','APPROVED') NOT NULL DEFAULT 'WAITING',
    `country`        varchar(100)      DEFAULT NULL,
    `currency`       varchar(100)      DEFAULT NULL,
    `created_at`     datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`     datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards`
(
    `id`         int UNSIGNED NOT NULL,
    `user_id`    int                                                     NOT NULL,
    `last_four`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `card_id`    varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `brand`      varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci          DEFAULT NULL,
    `is_default` int                                                     NOT NULL DEFAULT '0',
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats`
(
    `id`          int UNSIGNED NOT NULL,
    `request_id`  varchar(55) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `user_id`     int                                                    NOT NULL,
    `provider_id` int                                                    NOT NULL,
    `message`     text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `type`        enum('up','pu') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `delivered`   tinyint(1) NOT NULL,
    `created_at`  timestamp NULL DEFAULT NULL,
    `updated_at`  timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `request_id`, `user_id`, `provider_id`, `message`, `type`, `delivered`, `created_at`,
                     `updated_at`)
VALUES (403, 'KWD670373', 168, 80, 'How far are you?', 'up', 1, NULL, NULL),
       (404, 'KWD670373', 168, 80, '5mins away', 'pu', 1, NULL, NULL),
       (405, 'KWD676728', 273, 101, '5321', 'up', 1, NULL, NULL),
       (406, 'KWD676728', 273, 101, '5321', 'up', 1, NULL, NULL),
       (407, 'KWD676728', 273, 101, '', 'up', 1, NULL, NULL),
       (408, 'KWD106576', 291, 123, 'thank you', 'up', 1, NULL, NULL),
       (409, 'KWD106576', 291, 123, 'thanks ðŸ˜Š', 'up', 1, NULL, NULL),
       (410, 'KWD106576', 291, 123, '', 'up', 1, NULL, NULL),
       (411, 'KWD106576', 291, 123, 'No worries ðŸŽ‰', 'pu', 1, NULL, NULL),
       (412, 'KWD722892', 291, 134, '9539', 'up', 1, NULL, NULL),
       (413, 'KWD722892', 291, 134, '', 'up', 1, NULL, NULL),
       (414, 'KWD722892', 291, 134, 'the code', 'up', 1, NULL, NULL),
       (415, 'KWD722892', 291, 134, '', 'up', 1, NULL, NULL),
       (416, 'KWD722892', 291, 134, '', 'up', 1, NULL, NULL),
       (417, 'KWD135210', 170, 123, '5558', 'up', 1, NULL, NULL),
       (418, 'KWD943171', 290, 130, 'Hi\nHow are you doing', 'up', 1, NULL, NULL),
       (419, 'KWD943171', 290, 130, 'I am fine sir\nwhere do you want to go.', 'pu', 1, NULL, NULL),
       (420, 'KWD943171', 290, 130, 'I want to go xyz place.', 'up', 1, NULL, NULL),
       (421, 'KWD943171', 290, 130, 'Ok Sir, I will be there in 5 minutes.\nThankyou', 'pu', 1, NULL, NULL),
       (422, 'KWD943171', 290, 130, 'You are most welcome. I am waiting.', 'up', 1, NULL, NULL),
       (423, 'KWD407570', 290, 130, 'hi', 'up', 1, NULL, NULL),
       (424, 'KWD407570', 290, 130, 'hello', 'pu', 1, NULL, NULL),
       (425, 'KWD407570', 290, 130, 'this is driver', 'pu', 1, NULL, NULL),
       (426, 'KWD407570', 290, 130, 'this is customer', 'up', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities`
(
    `id`   int         NOT NULL,
    `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`)
VALUES (1, 'Lusaka');

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city`
(
    `id`         int NOT NULL,
    `name`       varchar(500) DEFAULT NULL,
    `state_id`   int          DEFAULT NULL,
    `created_at` datetime     DEFAULT CURRENT_TIMESTAMP,
    `deleted_at` datetime     DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`id`, `name`, `state_id`, `created_at`, `deleted_at`)
VALUES (1, 'Lusaka', 1, '2020-03-07 08:58:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints`
(
    `id`         int  NOT NULL,
    `name`       varchar(50)  DEFAULT NULL,
    `email`      varchar(100) DEFAULT NULL,
    `phone`      varchar(50)  DEFAULT NULL,
    `subject`    varchar(100) DEFAULT NULL,
    `message`    text,
    `attachment` text,
    `type`       varchar(50)  DEFAULT NULL,
    `transfer`   int          DEFAULT NULL,
    `status`     int          DEFAULT NULL,
    `created_at` date NOT NULL,
    `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries`
(
    `id`         int          NOT NULL,
    `name`       varchar(500) NOT NULL,
    `created_at` datetime     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `deleted_at` datetime              DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `created_at`, `deleted_at`)
VALUES (1, 'Zambia', '2020-03-07 08:56:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `custom_pushes`
--

CREATE TABLE `custom_pushes`
(
    `id`             int UNSIGNED NOT NULL,
    `send_to`        enum('ALL','USERS','PROVIDERS') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `condition`      enum('ACTIVE','LOCATION','RIDES','AMOUNT') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `condition_data` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `message`        varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `sent_to`        int NOT NULL                                            DEFAULT '0',
    `schedule_at`    timestamp NULL DEFAULT NULL,
    `created_at`     timestamp NULL DEFAULT NULL,
    `updated_at`     timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dispatchers`
--

CREATE TABLE `dispatchers`
(
    `id`             int UNSIGNED NOT NULL,
    `name`           varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `email`          varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `mobile`         varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `password`       varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `remember_token` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `created_at`     timestamp NULL DEFAULT NULL,
    `updated_at`     timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dispatchers`
--

INSERT INTO `dispatchers` (`id`, `name`, `email`, `mobile`, `password`, `remember_token`, `created_at`, `updated_at`)
VALUES (7, 'Sam', 'sam@example.com', '+260975168880', '$2y$10$f7a5.AsXMJ.T7WJR2Ki/dOrTiXUlzM3rFDV3/1/yy6v02tw73/8HC',
        'cVyQKPlrTynTkZmaQqBSpOk4qjOUOozHAmyibE5Yb73Qi7u1PRrbDc0XUygn', '2021-05-16 22:27:49', '2021-11-08 00:12:20'),
       (8, 'Test', 'Test@kwendazm.com', '+260', '$2y$10$CmPgRhCE38Bba.FyPVyoY.MmtCrwbwSjZSvug.qSgRybPNLQgGfvm',
        'z0DYUBdZlKSaMgaiYsUAcEvr7TDeeZ0x7QlyOojz1lwB5PYjC8ilFsYwxLd5', '2021-12-17 16:00:05', '2021-12-17 16:00:05');

-- --------------------------------------------------------

--
-- Table structure for table `dispatcher_password_resets`
--

CREATE TABLE `dispatcher_password_resets`
(
    `email`      varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `token`      varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents`
(
    `id`         int UNSIGNED NOT NULL,
    `name`       varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `type`       enum('DRIVER','VEHICLE') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `name`, `type`, `created_at`, `updated_at`)
VALUES (21, 'Road Tax', 'VEHICLE', '2020-04-10 06:42:15', '2020-10-15 08:40:54'),
       (12, 'NRC Back', 'DRIVER', '2020-02-18 13:05:51', '2020-10-15 08:43:31'),
       (13, 'NRC Front', 'DRIVER', '2020-03-01 01:58:12', '2020-10-15 08:43:45'),
       (14, 'Vehicle Rear View', 'VEHICLE', '2020-03-23 12:55:31', '2020-10-15 08:42:30'),
       (15, 'Vehicle Front View', 'VEHICLE', '2020-03-23 12:56:01', '2020-10-15 08:42:00'),
       (16, 'Vehicle Insurance', 'VEHICLE', '2020-03-23 12:56:41', '2020-10-15 08:41:38'),
       (17, 'Vehicle Fitness', 'VEHICLE', '2020-03-23 12:57:14', '2020-10-15 08:41:18'),
       (22, 'Drivers License', 'DRIVER', '2020-10-15 08:43:59', '2020-10-15 08:43:59');

-- --------------------------------------------------------

--
-- Table structure for table `favourite_locations`
--

CREATE TABLE `favourite_locations`
(
    `id`       int UNSIGNED NOT NULL,
    `user_id`  int NOT NULL,
    `address`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `latitude` double(15, 8
) DEFAULT NULL,
  `longitude` double(15,8) DEFAULT NULL,
  `type` enum('home','work','recent','others') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'others',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `favourite_locations`
--

INSERT INTO `favourite_locations` (`id`, `user_id`, `address`, `latitude`, `longitude`, `type`, `created_at`,
                                   `updated_at`)
VALUES (109, 70, 'Pindwara, Rajasthan 307022, India', 24.79888390, 73.05151960, 'home', '2020-10-19 00:13:55',
        '2020-10-19 00:13:55'),
       (115, 78, 'Pindwara, Rajasthan 307022, India', 24.79888390, 73.05151960, 'home', '2020-10-25 06:44:09',
        '2020-10-25 06:44:09'),
       (118, 71, 'FedEx Head Office, Lusaka, Zambia', -15.40917350, 28.30886270, 'work', '2020-11-04 18:13:18',
        '2020-11-04 18:13:18'),
       (119, 71, 'Honeybed lodge, 24 Olive Road, Salama Park Lusaka ZM, Lusaka 10101, Zambia', -15.39749760,
        28.38583280, 'home', '2020-11-10 22:04:16', '2020-11-10 22:04:16'),
       (123, 97, 'Lahore, Lahore, Punjab, Pakistan', 31.52036960, 74.35874730, 'home', '2020-11-20 02:34:53',
        '2020-11-20 02:34:53'),
       (124, 97, 'Kasur, Kasur, Punjab, Pakistan', 31.11786530, 74.44083850, 'work', '2020-11-20 02:35:33',
        '2020-11-20 02:35:33'),
       (125, 101, 'Honeybed lodge, 24 Olive Road, Salama Park Lusaka ZM, Lusaka 10101, Zambia', -15.39749760,
        28.38583280, 'home', '2020-11-27 22:11:25', '2020-11-27 22:11:25'),
       (126, 101, 'FedEx New Location, Lusaka, Zambia', -15.40920440, 28.30899750, 'work', '2020-11-27 22:11:48',
        '2020-11-27 22:11:48'),
       (127, 115, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, 'home',
        '2020-12-04 02:44:55', '2020-12-04 02:44:55'),
       (128, 115, 'FedEx New Location, Lusaka, Zambia', -15.40920440, 28.30899750, 'work', '2020-12-04 02:45:11',
        '2020-12-04 02:45:11'),
       (130, 121, 'Unnamed Road, Lusaka, Zambia', -15.39811280, 28.38534090, 'home', '2020-12-08 07:49:01',
        '2020-12-08 07:49:01'),
       (131, 121, 'FedEx Head Office, Lusaka, Zambia', -15.40917350, 28.30886270, 'work', '2020-12-09 03:56:23',
        '2020-12-09 03:56:23'),
       (132, 126, 'Unnamed Road, Lusaka, Zambia', -15.39811280, 28.38534090, 'home', '2020-12-11 00:49:01',
        '2020-12-11 00:49:01'),
       (133, 126, '14 Enock Kavu Rd, Lusaka, Zambia', -15.40916380, 28.30891970, 'work', '2020-12-11 00:49:08',
        '2020-12-11 00:49:08'),
       (172, 131, 'Honeybed lodge, 24 Olive Road, Salama Park Lusaka ZM, Lusaka 10101, Zambia', -15.39749760,
        28.38583280, 'home', '2021-05-23 14:14:03', '2021-05-23 14:14:03'),
       (137, 133, 'Honeybed lodge, 24 Olive Road, Salama Park Lusaka ZM, Lusaka 10101, Zambia', -15.39749760,
        28.38583280, 'home', '2020-12-22 02:39:41', '2020-12-22 02:39:41'),
       (138, 144, 'FedEx Head Office, Lusaka, Zambia', -15.40917350, 28.30886270, 'work', '2021-02-17 17:10:02',
        '2021-02-17 17:10:02'),
       (139, 144, 'Honeybed lodge, 24 Olive Road, Salama Park Lusaka ZM, Lusaka 10101, Zambia', -15.39749760,
        28.38583280, 'home', '2021-02-17 17:10:15', '2021-02-17 17:10:15'),
       (170, 131, 'Liebherr Zambia Ltd, 175 Kudu Rd, Lusaka, Zambia', -15.41049910, 28.34952650, 'work',
        '2021-05-21 11:14:55', '2021-05-21 11:14:55'),
       (149, 151, 'Infocity, Infocity, Gandhinagar, Gujarat 382421, India', 23.19350880, 72.63459140, 'work',
        '2021-03-23 12:46:57', '2021-03-23 12:46:57'),
       (155, 151, 'Infocity, Infocity, Gandhinagar, Gujarat 382421, India', 23.19350880, 72.63459140, 'home',
        '2021-04-13 12:36:35', '2021-04-13 12:36:35'),
       (162, 162, 'Honeybed lodge, 24 Olive Road, Salama Park Lusaka ZM, Lusaka 10101, Zambia', -15.39749760,
        28.38583280, 'home', '2021-05-06 02:56:06', '2021-05-06 02:56:06'),
       (173, 162, 'FedEx New Location, Lusaka, Zambia', -15.40920440, 28.30899750, 'work', '2021-05-27 02:36:17',
        '2021-05-27 02:36:17'),
       (174, 165, '175 Kudu Rd, Lusaka, Zambia', -15.41013340, 28.34916680, 'work', '2021-05-28 15:41:02',
        '2021-05-28 15:41:02'),
       (175, 165, 'Honeybed lodge, 24 Olive Road, Salama Park Lusaka ZM, Lusaka 10101, Zambia', -15.39749760,
        28.38583280, 'home', '2021-05-28 15:41:30', '2021-05-28 15:41:30'),
       (186, 168, 'DHA Phase 6, DHA Phase 6, Lahore, Punjab, Pakistan', 31.47150490, 74.45842450, 'home',
        '2021-12-11 15:38:31', '2021-12-11 15:38:31'),
       (177, 168, 'Liebherr Zambia Ltd, 175 Kudu Rd, Lusaka, Zambia', -15.41049910, 28.34952650, 'work',
        '2021-06-08 02:53:15', '2021-06-08 02:53:15'),
       (178, 234, 'Honeybed lodge, 24 Olive Road, Salama Park Lusaka ZM, Lusaka 10101, Zambia', -15.39749760,
        28.38583280, 'home', '2021-11-15 22:23:24', '2021-11-15 22:23:24'),
       (179, 234, 'Liebherr Zambia Ltd, 175 Kudu Rd, Lusaka, Zambia', -15.41049910, 28.34952650, 'work',
        '2021-11-16 04:19:58', '2021-11-16 04:19:58'),
       (183, 273, 'Pakistan Chowk, Pakistan Chowk, Saddar Karachi, Karachi City, Sindh, Pakistan', 24.85398740,
        67.01241120, 'home', '2021-12-10 13:11:15', '2021-12-10 13:11:15'),
       (181, 273, 'Pakistan, Pakistan', 30.37532100, 69.34511600, 'home', '2021-12-10 12:50:06', '2021-12-10 12:50:06'),
       (185, 273, 'Pakistan Chowk, Pakistan Chowk, Saddar Karachi, Karachi City, Sindh, Pakistan', 24.85398740,
        67.01241120, 'work', '2021-12-10 13:11:46', '2021-12-10 13:11:46'),
       (194, 290, 'DHA Phase 6, DHA Phase 6, Lahore, Punjab, Pakistan', 31.47150490, 74.45842450, 'home',
        '2021-12-17 21:25:27', '2021-12-17 21:25:27'),
       (188, 243, 'Kamwala Primary School, P.O. Box 74, Kenya', -0.36098140, 34.74887260, 'home', '2021-12-13 13:10:48',
        '2021-12-13 13:10:48'),
       (189, 243, 'Woodlands Mall, Chindo Rd, Lusaka, Zambia', -15.43605270, 28.34142110, 'work', '2021-12-13 13:10:57',
        '2021-12-13 13:10:57'),
       (190, 291, 'Liebherr Zambia Ltd, 175 Kudu Rd, Lusaka, Zambia', -15.41049910, 28.34952650, 'work',
        '2021-12-15 06:27:35', '2021-12-15 06:27:35'),
       (191, 291, 'Honeybed lodge, 24 Olive Road, Salama Park Lusaka ZM, Lusaka 10101, Zambia', -15.39749760,
        28.38583280, 'home', '2021-12-15 06:27:49', '2021-12-15 06:27:49'),
       (193, 290, 'Phase 5 D.H.A, Phase 5 D.H.A, Lahore, Punjab, Pakistan', 31.46253890, 74.40859290, 'work',
        '2021-12-17 16:54:50', '2021-12-17 16:54:50'),
       (195, 289, 'Honeybed lodge, 24 Olive Road, Salama Park Lusaka ZM, Lusaka 10101, Zambia', -15.39749760,
        28.38583280, 'home', '2021-12-19 02:12:33', '2021-12-19 02:12:33'),
       (196, 289, 'Liebherr Zambia Ltd, 175 Kudu Rd, Lusaka, Zambia', -15.41049910, 28.34952650, 'work',
        '2021-12-19 02:12:56', '2021-12-19 02:12:56');

-- --------------------------------------------------------

--
-- Table structure for table `fleets`
--

CREATE TABLE `fleets`
(
    `id`             int UNSIGNED NOT NULL,
    `name`           varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `email`          varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `password`       varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `company`        varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `mobile`         varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `logo`           varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `remember_token` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `created_at`     timestamp NULL DEFAULT NULL,
    `updated_at`     timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fleets`
--

INSERT INTO `fleets` (`id`, `name`, `email`, `password`, `company`, `mobile`, `logo`, `remember_token`, `created_at`,
                      `updated_at`)
VALUES (3, 'Fred P Lungu', 'lunguphilip@optimyzetech.com',
        '$2y$10$lpRt/2bye4g4FYg9x.XMAOmKm2iL6/AHWfe/cD62O9gdN337G5dHG', 'Optimyze Technologies Limited', '0975168881',
        'fleet/FOvt1PvOVngygGCwHoYn0ADHKFue7EdEAGdsLVNM.jpeg',
        'RrEFOfLeuDycb97DfWMhYlSZATG2pdPQCBrU6M666xHmLzOgQmftDW3YZ856', '2020-10-18 16:07:24', '2021-04-07 22:59:10'),
       (5, 'Example Vendor', 'vendor@example.com', '$2y$10$nU0w5tF08BtlS4hXIl8ztuncfj5XDzN4jKk5BN5WsjQBRaAwja3Uy',
        'FastShipper', '+442085381905', 'fleet/QTfjnpTgnQtvmCcv0Nh9IDIRN6DJiKLvIORofCda.png',
        'nNxa4RpLgcz9Ad4u283kOWbbF2KX5PYxFMCBdpRUDy0P8RWAG87gj4SI23O9', '2021-05-14 23:07:23', '2021-05-14 23:07:59');

-- --------------------------------------------------------

--
-- Table structure for table `fleet_password_resets`
--

CREATE TABLE `fleet_password_resets`
(
    `email`      varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `token`      varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `frontend`
--

CREATE TABLE `frontend`
(
    `id`      int         NOT NULL,
    `keycode` varchar(50) NOT NULL,
    `value`   text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ltm_translations`
--

CREATE TABLE `ltm_translations`
(
    `id`         int UNSIGNED NOT NULL,
    `status`     int                                                     NOT NULL DEFAULT '0',
    `locale`     varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `group`      varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `key`        varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `value`      text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ltm_translations`
--

INSERT INTO `ltm_translations` (`id`, `status`, `locale`, `group`, `key`, `value`, `created_at`, `updated_at`)
VALUES (457, 0, 'en', 'validation', 'accepted', 'The :attribute must be accepted.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (458, 0, 'en', 'validation', 'active_url', 'The :attribute is not a valid URL.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (459, 0, 'en', 'validation', 'after', 'The :attribute must be a date after :date.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (460, 0, 'en', 'validation', 'after_or_equal', 'The :attribute must be a date after or equal to :date.',
        '2020-02-20 23:35:10', '2020-07-28 04:45:36'),
       (461, 0, 'en', 'validation', 'alpha', 'The :attribute may only contain letters.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (462, 0, 'en', 'validation', 'alpha_dash', 'The :attribute may only contain letters, numbers, and dashes.',
        '2020-02-20 23:35:10', '2020-07-28 04:45:36'),
       (463, 0, 'en', 'validation', 'alpha_num', 'The :attribute may only contain letters and numbers.',
        '2020-02-20 23:35:10', '2020-07-28 04:45:36'),
       (464, 0, 'en', 'validation', 'array', 'The :attribute must be an array.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (465, 0, 'en', 'validation', 'before', 'The :attribute must be a date before :date.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (466, 0, 'en', 'validation', 'before_or_equal', 'The :attribute must be a date before or equal to :date.',
        '2020-02-20 23:35:10', '2020-07-28 04:45:36'),
       (467, 0, 'en', 'validation', 'between.numeric', 'The :attribute must be between :min and :max.',
        '2020-02-20 23:35:10', '2020-07-28 04:45:36'),
       (468, 0, 'en', 'validation', 'between.file', 'The :attribute must be between :min and :max kilobytes.',
        '2020-02-20 23:35:10', '2020-07-28 04:45:36'),
       (469, 0, 'en', 'validation', 'between.string', 'The :attribute must be between :min and :max characters.',
        '2020-02-20 23:35:10', '2020-07-28 04:45:36'),
       (470, 0, 'en', 'validation', 'between.array', 'The :attribute must have between :min and :max items.',
        '2020-02-20 23:35:10', '2020-07-28 04:45:36'),
       (471, 0, 'en', 'validation', 'boolean', 'The :attribute field must be true or false.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (472, 0, 'en', 'validation', 'confirmed', 'The :attribute confirmation does not match.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (473, 0, 'en', 'validation', 'date', 'The :attribute is not a valid date.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (474, 0, 'en', 'validation', 'date_format', 'The :attribute does not match the format :format.',
        '2020-02-20 23:35:10', '2020-07-28 04:45:36'),
       (475, 0, 'en', 'validation', 'different', 'The :attribute and :other must be different.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (476, 0, 'en', 'validation', 'digits', 'The :attribute must be :digits digits.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (477, 0, 'en', 'validation', 'digits_between', 'The :attribute must be between :min and :max digits.',
        '2020-02-20 23:35:10', '2020-07-28 04:45:36'),
       (478, 0, 'en', 'validation', 'dimensions', 'The :attribute has invalid image dimensions.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (479, 0, 'en', 'validation', 'distinct', 'The :attribute field has a duplicate value.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (480, 0, 'en', 'validation', 'email', 'The :attribute must be a valid email address.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (481, 0, 'en', 'validation', 'exists', 'The selected :attribute is invalid.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (482, 0, 'en', 'validation', 'file', 'The :attribute must be a file.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (483, 0, 'en', 'validation', 'filled', 'The :attribute field is required.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (484, 0, 'en', 'validation', 'image', 'The :attribute must be an image.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (485, 0, 'en', 'validation', 'in', 'The selected :attribute is invalid.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (486, 0, 'en', 'validation', 'in_array', 'The :attribute field does not exist in :other.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (487, 0, 'en', 'validation', 'integer', 'The :attribute must be an integer.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (488, 0, 'en', 'validation', 'ip', 'The :attribute must be a valid IP address.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (489, 0, 'en', 'validation', 'json', 'The :attribute must be a valid JSON string.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (490, 0, 'en', 'validation', 'max.numeric', 'The :attribute may not be greater than :max.',
        '2020-02-20 23:35:10', '2020-07-28 04:45:36'),
       (491, 0, 'en', 'validation', 'max.file', 'The :attribute may not be greater than :max kilobytes.',
        '2020-02-20 23:35:10', '2020-07-28 04:45:36'),
       (492, 0, 'en', 'validation', 'max.string', 'The :attribute may not be greater than :max characters.',
        '2020-02-20 23:35:10', '2020-07-28 04:45:36'),
       (493, 0, 'en', 'validation', 'max.array', 'The :attribute may not have more than :max items.',
        '2020-02-20 23:35:10', '2020-07-28 04:45:36'),
       (494, 0, 'en', 'validation', 'mimes', 'The :attribute must be a file of type: :values.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (495, 0, 'en', 'validation', 'mimetypes', 'The :attribute must be a file of type: :values.',
        '2020-02-20 23:35:10', '2020-07-28 04:45:36'),
       (496, 0, 'en', 'validation', 'min.numeric', 'The :attribute must be at least :min.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (497, 0, 'en', 'validation', 'min.file', 'The :attribute must be at least :min kilobytes.',
        '2020-02-20 23:35:10', '2020-07-28 04:45:36'),
       (498, 0, 'en', 'validation', 'min.string', 'The :attribute must be at least :min characters.',
        '2020-02-20 23:35:10', '2020-07-28 04:45:36'),
       (499, 0, 'en', 'validation', 'min.array', 'The :attribute must have at least :min items.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (500, 0, 'en', 'validation', 'not_in', 'The selected :attribute is invalid.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (501, 0, 'en', 'validation', 'numeric', 'The :attribute must be a number.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (502, 0, 'en', 'validation', 'present', 'The :attribute field must be present.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (503, 0, 'en', 'validation', 'regex', 'The :attribute format is invalid.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (504, 0, 'en', 'validation', 'required', 'The :attribute field is required.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (505, 0, 'en', 'validation', 'required_if', 'The :attribute field is required when :other is :value.',
        '2020-02-20 23:35:10', '2020-07-28 04:45:36'),
       (506, 0, 'en', 'validation', 'required_unless', 'The :attribute field is required unless :other is in :values.',
        '2020-02-20 23:35:10', '2020-07-28 04:45:36'),
       (507, 0, 'en', 'validation', 'required_with', 'The :attribute field is required when :values is present.',
        '2020-02-20 23:35:10', '2020-07-28 04:45:36'),
       (508, 0, 'en', 'validation', 'required_with_all', 'The :attribute field is required when :values is present.',
        '2020-02-20 23:35:10', '2020-07-28 04:45:36'),
       (509, 0, 'en', 'validation', 'required_without', 'The :attribute field is required when :values is not present.',
        '2020-02-20 23:35:10', '2020-07-28 04:45:36'),
       (510, 0, 'en', 'validation', 'required_without_all',
        'The :attribute field is required when none of :values are present.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (511, 0, 'en', 'validation', 'same', 'The :attribute and :other must match.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (512, 0, 'en', 'validation', 'size.numeric', 'The :attribute must be :size.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (513, 0, 'en', 'validation', 'size.file', 'The :attribute must be :size kilobytes.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (514, 0, 'en', 'validation', 'size.string', 'The :attribute must be :size characters.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (515, 0, 'en', 'validation', 'size.array', 'The :attribute must contain :size items.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (516, 0, 'en', 'validation', 'string', 'The :attribute must be a string.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (517, 0, 'en', 'validation', 'timezone', 'The :attribute must be a valid zone.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (518, 0, 'en', 'validation', 'unique', 'The :attribute has already been taken.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (519, 0, 'en', 'validation', 'uploaded', 'The :attribute failed to upload.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (520, 0, 'en', 'validation', 'url', 'The :attribute format is invalid.', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (521, 0, 'en', 'validation', 'custom.attribute-name.rule-name', 'custom-message', '2020-02-20 23:35:10',
        '2020-07-28 04:45:36'),
       (522, 0, 'en', 'passwords', 'password', 'Passwords must be at least six characters and match the confirmation.',
        '2020-02-20 23:35:10', '2020-10-26 19:48:59'),
       (523, 0, 'en', 'passwords', 'reset', 'Your password has been reset!', '2020-02-20 23:35:10',
        '2020-10-26 19:48:59'),
       (524, 0, 'en', 'passwords', 'sent', 'We have emailed your password reset link!', '2020-02-20 23:35:10',
        '2020-10-26 19:48:59'),
       (525, 0, 'en', 'passwords', 'token', 'This password reset token is invalid.', '2020-02-20 23:35:10',
        '2020-10-26 19:48:59'),
       (526, 0, 'en', 'passwords', 'user',
        'We can\'t find a user with that email address.', '2020-02-20 23:35:10', '2020-10-26 19:48:59'),
(527, 0, 'en', 'user', 'profile.old_password', 'Old Password', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(528, 0, 'en', 'user', 'profile.password', 'Password', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(529, 0, 'en', 'user', 'profile.confirm_password', 'Confirm Password', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(530, 0, 'en', 'user', 'profile.first_name', 'First Name', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(531, 0, 'en', 'user', 'profile.last_name', 'Last Name', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(532, 0, 'en', 'user', 'profile.email', 'Email', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(533, 0, 'en', 'user', 'profile.mobile', 'Mobile', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(534, 0, 'en', 'user', 'profile.general_information', 'General Information', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(535, 0, 'en', 'user', 'profile.profile_picture', 'Profile Picture', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(536, 0, 'en', 'user', 'profile.wallet_balance', 'Wallet Balance', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(537, 0, 'en', 'user', 'profile.edit', 'Edit', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(538, 0, 'en', 'user', 'profile.save', 'Save', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(539, 0, 'en', 'user', 'profile.edit_information', 'Edit Information', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(540, 0, 'en', 'user', 'profile.change_password', 'Change Password', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(541, 0, 'en', 'user', 'profile.profile', 'Profile', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(542, 0, 'en', 'user', 'profile.logout', 'Logout', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(543, 0, 'en', 'user', 'profile.name', 'Name', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(544, 0, 'en', 'user', 'cash', 'CASH', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(545, 0, 'en', 'user', 'booking_id', 'Booking Id', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(546, 0, 'en', 'user', 'service_number', 'Vehicle Number', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(547, 0, 'en', 'user', 'service_model', 'Vehicle Model', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(548, 0, 'en', 'user', 'card.fullname', 'Full Name', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(549, 0, 'en', 'user', 'card.card_no', 'Card Number', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(550, 0, 'en', 'user', 'card.cvv', 'CVV', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(551, 0, 'en', 'user', 'card.add_card', 'Add Card', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(552, 0, 'en', 'user', 'card.delete', 'Delete', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(553, 0, 'en', 'user', 'card.month', 'Month', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(554, 0, 'en', 'user', 'card.year', 'Year', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(555, 0, 'en', 'user', 'card.default', 'Default', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(556, 0, 'en', 'user', 'fare_breakdown', 'FARE BREAKDOWN', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(557, 0, 'en', 'user', 'ride.finding_driver', 'Finding your Driver', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(558, 0, 'en', 'user', 'ride.accepted_ride', 'Accepted Your Trip', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(559, 0, 'en', 'user', 'ride.arrived_ride', 'Arrived At your Location', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(560, 0, 'en', 'user', 'ride.onride', 'Enjoy your Trip', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(561, 0, 'en', 'user', 'ride.waiting_payment', 'Waiting for Payment', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(562, 0, 'en', 'user', 'ride.rate_and_review', 'Rate and Review', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(563, 0, 'en', 'user', 'ride.ride_now', 'Request Now', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(564, 0, 'en', 'user', 'ride.cancel_request', 'Cancel Request', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(565, 0, 'en', 'user', 'ride.ride_status', 'Booking Status', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(566, 0, 'en', 'user', 'ride.dropped_ride', 'Your Trip is Completed', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(567, 0, 'en', 'user', 'ride.ride_details', 'Booking Details', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(568, 0, 'en', 'user', 'ride.invoice', 'Invoice', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(569, 0, 'en', 'user', 'ride.base_price', 'Base Price', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(570, 0, 'en', 'user', 'ride.tax_price', 'Tax Fare', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(571, 0, 'en', 'user', 'ride.distance_price', 'Distance Price', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(572, 0, 'en', 'user', 'ride.comment', 'Comment', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(573, 0, 'en', 'user', 'ride.detection_wallet', 'Wallet Detection', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(574, 0, 'en', 'user', 'ride.rating', 'Rating', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(575, 0, 'en', 'user', 'ride.km', 'Kilometer', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(576, 0, 'en', 'user', 'ride.total', 'Total', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(577, 0, 'en', 'user', 'ride.amount_paid', 'Amount To Pay:', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(578, 0, 'en', 'user', 'ride.promotion_applied', 'Promotion Applied', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(579, 0, 'en', 'user', 'ride.request_inprogress', 'Trip Already in Progress', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(580, 0, 'en', 'user', 'ride.request_scheduled', 'Trip Has Already Scheduled on this time', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(581, 0, 'en', 'user', 'ride.cancel_reason', 'Cancel Reason', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(582, 0, 'en', 'user', 'ride.wallet_deduction', 'Wallet Deduction', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(583, 0, 'en', 'user', 'dashboard', 'Dashboard', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(584, 0, 'en', 'user', 'payment', 'Payment', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(585, 0, 'en', 'user', 'wallet', 'Wallet', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(586, 0, 'en', 'user', 'my_wallet', 'My Wallet', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(587, 0, 'en', 'user', 'my_trips', 'Trips', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(588, 0, 'en', 'user', 'in_your_wallet', 'in your wallet', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(589, 0, 'en', 'user', 'status', 'Status', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(590, 0, 'en', 'user', 'driver_name', 'Driver Name', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(591, 0, 'en', 'user', 'driver_rating', 'Driver Rating', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(592, 0, 'en', 'user', 'payment_mode', 'Payment Mode', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(593, 0, 'en', 'user', 'add_money', 'Add Money', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(594, 0, 'en', 'user', 'date', 'Date', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(595, 0, 'en', 'user', 'schedule_date', 'Scheduled Date', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(596, 0, 'en', 'user', 'amount', 'Total Amount', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(597, 0, 'en', 'user', 'type', 'Type', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(598, 0, 'en', 'user', 'time', 'Time', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(599, 0, 'en', 'user', 'request_id', 'Request ID', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(600, 0, 'en', 'user', 'paid_via', 'PAID VIA', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(601, 0, 'en', 'user', 'from', 'From', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(602, 0, 'en', 'user', 'total_distance', 'Total Distance', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(603, 0, 'en', 'user', 'eta', 'ETA', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(604, 0, 'en', 'user', 'to', 'To', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(605, 0, 'en', 'user', 'use_wallet_balance', 'Use Wallet Balance', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(606, 0, 'en', 'user', 'available_wallet_balance', 'Available Wallet Balance', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(607, 0, 'en', 'user', 'estimated_fare', 'Estimated Price', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(608, 0, 'en', 'user', 'charged', 'CHARGED', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(609, 0, 'en', 'user', 'payment_method', 'Payment Methods', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(610, 0, 'en', 'user', 'promotion', 'Promo Codes', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(611, 0, 'en', 'user', 'add_promocode', 'Add Promocode', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(612, 0, 'en', 'user', 'upcoming_trips', 'Upcoming trips', '2020-02-20 23:35:10', '2021-03-02 05:18:55'),
(613, 0, 'en', 'servicetypes', 'MIN', 'Per Minute Pricing', '2020-02-20 23:35:10', '2020-03-01 20:44:23'),
(614, 0, 'en', 'servicetypes', 'HOUR', 'Per Hour Pricing', '2020-02-20 23:35:10', '2020-03-01 20:44:23'),
(615, 0, 'en', 'servicetypes', 'DISTANCE', 'Distance Pricing', '2020-02-20 23:35:10', '2020-03-01 20:44:23'),
(616, 0, 'en', 'servicetypes', 'DISTANCEMIN', 'Distance and Per Minute Pricing', '2020-02-20 23:35:10', '2020-03-01 20:44:23'),
(617, 0, 'en', 'servicetypes', 'DISTANCEHOUR', 'Distance and Per Hour Pricing', '2020-02-20 23:35:10', '2020-03-01 20:44:23'),
(618, 0, 'en', 'pagination', 'previous', '&laquo;
Previous
', '
2020-02-20 23:35:10
', '2020-03-01 20:44:23
'),
(619, 0, 'en', 'pagination', 'next', 'Next &raquo;
', '
2020-02-20 23:35:10
', '2020-03-01 20:44:23
'),
(620, 0, 'en', 'auth', 'failed', 'These credentials do not match our records.', '
2020-02-20 23:35:10
', '2020-03-01 20:44:23
'),
(621, 0, 'en', 'auth', 'throttle', 'Too many login attempts. Please try again in :seconds seconds.', '
2020-02-20 23:35:10
', '2020-03-01 20:44:23
'),
(622, 0, 'en', 'admin', 'name', 'Name', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(623, 0, 'en', 'admin', 'email', 'Email', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(624, 0, 'en', 'admin', 'first_name', 'First Name', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(625, 0, 'en', 'admin', 'last_name', 'Last Name', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(626, 0, 'en', 'admin', 'picture', 'Picture', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(627, 0, 'en', 'admin', 'password', 'Password ', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(628, 0, 'en', 'admin', 'mobile', 'Mobile', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(629, 0, 'en', 'admin', 'cancel', 'Cancel', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(630, 0, 'en', 'admin', 'back', 'Back', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(631, 0, 'en', 'admin', 'id', 'ID', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(632, 0, 'en', 'admin', 'edit', 'Edit', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(633, 0, 'en', 'admin', 'gender', 'Gender', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(634, 0, 'en', 'admin', 'address', 'Address', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(635, 0, 'en', 'admin', 'action', 'Action', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(636, 0, 'en', 'admin', 'Enable', 'Enable', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(637, 0, 'en', 'admin', 'Disable', 'Disable', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(638, 0, 'en', 'admin', 'type', 'Type', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(639, 0, 'en', 'admin', 'delete', 'Delete', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(640, 0, 'en', 'admin', 'help', 'Help', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(641, 0, 'en', 'admin', 'status', 'Status', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(642, 0, 'en', 'admin', 'message', 'Message', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(643, 0, 'en', 'admin', 'History', 'History', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(644, 0, 'en', 'admin', 'Statements', 'Statements', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(645, 0, 'en', 'admin', 'amount', 'Amount', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(646, 0, 'en', 'admin', 'account.change_password', 'Change Password', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(647, 0, 'en', 'admin', 'account.old_password', 'Old Password', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(648, 0, 'en', 'admin', 'account.password', 'Password ', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(649, 0, 'en', 'admin', 'account.password_confirmation', 'Password Confirmation', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(650, 0, 'en', 'admin', 'account.update_profile', 'Update Profile', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(651, 0, 'en', 'admin', 'account-manager.add_account_manager', 'Add Account Manager', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(652, 0, 'en', 'admin', 'account-manager.full_name', 'Full Name', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(653, 0, 'en', 'admin', 'account-manager.password_confirmation', 'Password Confirmation', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(654, 0, 'en', 'admin', 'account-manager.update_account_manager', 'Update Account Manager', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(655, 0, 'en', 'admin', 'account-manager.account_manager', 'Account Manager', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(656, 0, 'en', 'admin', 'account-manager.add_new_account_manager', 'Add New Account Manager', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(657, 0, 'en', 'admin', 'auth.reset_password', 'Reset Password', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(658, 0, 'en', 'admin', 'auth.admin_login', 'Admin Login', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(659, 0, 'en', 'admin', 'auth.login_here', 'Login Here', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(660, 0, 'en', 'admin', 'auth.remember_me', 'Remember Me', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(661, 0, 'en', 'admin', 'auth.sign_in', 'Sign In', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(662, 0, 'en', 'admin', 'auth.forgot_your_password', 'Forgot Your Password', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(663, 0, 'en', 'admin', 'auth.request_scheduled', 'Ride Scheduled', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(664, 0, 'en', 'admin', 'auth.request_already_scheduled', 'Ride Already Scheduled', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(665, 0, 'en', 'admin', 'dispatcher.add_dispatcher', 'Add Dispatcher', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(666, 0, 'en', 'admin', 'dispatcher.update_dispatcher', 'Update Dispatcher', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(667, 0, 'en', 'admin', 'dispatcher.dispatcher', 'Dispatcher', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(668, 0, 'en', 'admin', 'dispatcher.add_new_dispatcher', 'Add New Dispatcher', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(669, 0, 'en', 'admin', 'document.add_Document', 'Add Document', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(670, 0, 'en', 'admin', 'document.document_name', 'Document Name', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(671, 0, 'en', 'admin', 'document.document_type', 'Document Type', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(672, 0, 'en', 'admin', 'document.driver_review', 'Driver Review', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(673, 0, 'en', 'admin', 'document.vehicle_review', 'Vehicle Review', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(674, 0, 'en', 'admin', 'document.update_document', 'Update Document', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(675, 0, 'en', 'admin', 'document.document', 'Document', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(676, 0, 'en', 'admin', 'fleet.add_fleet_owner', 'Add Fleet Owner', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(677, 0, 'en', 'admin', 'fleet.company_name', 'Company Name', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(678, 0, 'en', 'admin', 'fleet.company_logo', 'Company Logo', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(679, 0, 'en', 'admin', 'fleet.update_fleet_owner', 'Update Fleet Owner', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(680, 0, 'en', 'admin', 'fleet.update_fleet', 'Update Fleet', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(681, 0, 'en', 'admin', 'fleet.fleet_owners', 'Fleet Owners', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(682, 0, 'en', 'admin', 'fleet.add_new_fleet_owner', 'Add New Fleet Owner', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(683, 0, 'en', 'admin', 'fleet.show_provider', 'Show Provider', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(684, 0, 'en', 'admin', 'include.profile', 'Profile', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(685, 0, 'en', 'admin', 'include.sign_out', 'Sign out', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(686, 0, 'en', 'admin', 'include.admin_dashboard', 'Admin Dashboard', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(687, 0, 'en', 'admin', 'include.dashboard', 'Dashboard', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(688, 0, 'en', 'admin', 'include.dispatcher_panel', 'Dispatcher Panel', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(689, 0, 'en', 'admin', 'include.heat_map', 'Heat Map', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(690, 0, 'en', 'admin', 'include.members', 'Members', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(691, 0, 'en', 'admin', 'include.users', 'Usersss', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(692, 0, 'en', 'admin', 'include.list_users', 'List Users', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(693, 0, 'en', 'admin', 'include.add_new_user', 'Add New User', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(694, 0, 'en', 'admin', 'include.providers', 'Providers', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(695, 0, 'en', 'admin', 'include.list_providers', 'List Providers', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(696, 0, 'en', 'admin', 'include.add_new_provider', 'Add New Provider', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(697, 0, 'en', 'admin', 'include.dispatcher', 'Dispatcher', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(698, 0, 'en', 'admin', 'include.list_dispatcher', 'List Dispatcher', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(699, 0, 'en', 'admin', 'include.add_new_dispatcher', 'Add New Dispatcher', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(700, 0, 'en', 'admin', 'include.fleet_owner', 'Fleet Owner', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(701, 0, 'en', 'admin', 'include.list_fleets', 'List Fleets', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(702, 0, 'en', 'admin', 'include.add_new_fleet_owner', 'Add New Fleet Owner', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(703, 0, 'en', 'admin', 'include.account_manager', 'Account Manager', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(704, 0, 'en', 'admin', 'include.list_account_managers', 'List Account Managers', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(705, 0, 'en', 'admin', 'include.add_new_account_manager', 'Add New Account Manager', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(706, 0, 'en', 'admin', 'include.accounts', 'Accounts', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(707, 0, 'en', 'admin', 'include.statements', 'Statements', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(708, 0, 'en', 'admin', 'include.overall_ride_statments', 'Overall Ride Statments', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(709, 0, 'en', 'admin', 'include.provider_statement', 'Provider Statement', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(710, 0, 'en', 'admin', 'include.daily_statement', 'Daily Statement', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(711, 0, 'en', 'admin', 'include.monthly_statement', 'Monthly Statement', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(712, 0, 'en', 'admin', 'include.yearly_statement', 'Yearly Statement', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(713, 0, 'en', 'admin', 'include.details', 'Details', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(714, 0, 'en', 'admin', 'include.map', 'Map', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(715, 0, 'en', 'admin', 'include.ratings', 'Ratings', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(716, 0, 'en', 'admin', 'include.reviews', 'Reviews', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(717, 0, 'en', 'admin', 'include.user_ratings', 'User Ratings', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(718, 0, 'en', 'admin', 'include.provider_ratings', 'Provider Ratings', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(719, 0, 'en', 'admin', 'include.requests', 'Requests', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(720, 0, 'en', 'admin', 'include.request_history', 'Request History', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(721, 0, 'en', 'admin', 'include.scheduled_rides', 'Scheduled Rides', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(722, 0, 'en', 'admin', 'include.general', 'General', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(723, 0, 'en', 'admin', 'include.service_types', 'Service Types', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(724, 0, 'en', 'admin', 'include.list_service_types', 'List Service Types', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(725, 0, 'en', 'admin', 'include.add_new_service_type', 'Add New Service Type', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(726, 0, 'en', 'admin', 'include.documents', 'Documents', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(727, 0, 'en', 'admin', 'include.list_documents', 'List Documents', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(728, 0, 'en', 'admin', 'include.add_new_document', 'Add New Document', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(729, 0, 'en', 'admin', 'include.promocodes', 'Promocodes', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(730, 0, 'en', 'admin', 'include.list_promocodes', 'List Promocodes', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(731, 0, 'en', 'admin', 'include.add_new_promocode', 'Add New Promocode', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(732, 0, 'en', 'admin', 'include.payment_details', 'Payment Details', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(733, 0, 'en', 'admin', 'include.payment_history', 'Payment History', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(734, 0, 'en', 'admin', 'include.payment_settings', 'Payment Settings', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(735, 0, 'en', 'admin', 'include.settings', 'Settings', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(736, 0, 'en', 'admin', 'include.site_settings', 'Site Settings', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(737, 0, 'en', 'admin', 'include.others', 'Others', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(738, 0, 'en', 'admin', 'include.privacy_policy', 'Privacy Policy', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(739, 0, 'en', 'admin', 'include.help', 'Help', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(740, 0, 'en', 'admin', 'include.custom_push', 'Custom Push', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(741, 0, 'en', 'admin', 'include.translations', 'Translations', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(742, 0, 'en', 'admin', 'include.account', 'Account', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(743, 0, 'en', 'admin', 'include.account_settings', 'Account Settings', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(744, 0, 'en', 'admin', 'include.change_password', 'Change Password', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(745, 0, 'en', 'admin', 'include.logout', 'Logout', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(746, 0, 'en', 'admin', 'pages.pages', 'Pages', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(747, 0, 'en', 'admin', 'payment.payment_history', 'Payment History', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(748, 0, 'en', 'admin', 'payment.request_id', 'Request ID', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(749, 0, 'en', 'admin', 'payment.transaction_id', 'Transaction ID', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(750, 0, 'en', 'admin', 'payment.from', 'From', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(751, 0, 'en', 'admin', 'payment.to', 'To', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(752, 0, 'en', 'admin', 'payment.total_amount', 'Total Amount', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(753, 0, 'en', 'admin', 'payment.provider_amount', 'Provider Amount', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(754, 0, 'en', 'admin', 'payment.payment_mode', 'Payment Mode', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(755, 0, 'en', 'admin', 'payment.payment_status', 'Payment Status', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(756, 0, 'en', 'admin', 'payment.payment_modes', 'Payment Modes', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(757, 0, 'en', 'admin', 'payment.card_payments', 'Stripe (Card Payments)', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(758, 0, 'en', 'admin', 'payment.stripe_secret_key', 'Stripe Secret key', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(759, 0, 'en', 'admin', 'payment.stripe_publishable_key', 'Stripe Publishable key', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(760, 0, 'en', 'admin', 'payment.cash_payments', 'Cash Payments', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(761, 0, 'en', 'admin', 'payment.payment_settings', 'Payment Settings', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(762, 0, 'en', 'admin', 'payment.daily_target', 'Daily Target', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(763, 0, 'en', 'admin', 'payment.tax_percentage', 'Tax percentage(%)', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(764, 0, 'en', 'admin', 'payment.surge_trigger_point', 'Surge Trigger Point', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(765, 0, 'en', 'admin', 'payment.surge_percentage', 'Surge Percentage(%)', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(766, 0, 'en', 'admin', 'payment.commission_percentage', 'Commission Percentage(%)', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(767, 0, 'en', 'admin', 'payment.provider_commission_percentage', 'Provider Commission Percentage(%)', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(768, 0, 'en', 'admin', 'payment.booking_id_prefix', 'Booking ID Prefix', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(769, 0, 'en', 'admin', 'payment.currency', 'Currency', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(770, 0, 'en', 'admin', 'payment.update_site_settings', 'Update Site Settings', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(771, 0, 'en', 'admin', 'promocode.add_promocode', 'Add Promocode', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(772, 0, 'en', 'admin', 'promocode.discount', 'Discount', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(773, 0, 'en', 'admin', 'promocode.expiration', 'Expiration', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(774, 0, 'en', 'admin', 'promocode.promocode', 'Promocode', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(775, 0, 'en', 'admin', 'promocode.update_promocode', 'Update Promocode', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(776, 0, 'en', 'admin', 'promocode.used_count', 'Used Count', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(777, 0, 'en', 'admin', 'promocode.promocodes', 'Promocodes', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(778, 0, 'en', 'admin', 'promocode.discount_type', 'Promocode Use ', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(779, 0, 'en', 'admin', 'provides.provider_name', 'Provider Name', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(780, 0, 'en', 'admin', 'provides.approve', 'Approve', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(781, 0, 'en', 'admin', 'provides.delete', 'Delete', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(782, 0, 'en', 'admin', 'provides.add_provider', 'Add Provider', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(783, 0, 'en', 'admin', 'provides.password_confirmation', 'Password Confirmation', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(784, 0, 'en', 'admin', 'provides.update_provider', 'Update Provider', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(785, 0, 'en', 'admin', 'provides.type_allocation', 'Provider Service Type Allocation', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(786, 0, 'en', 'admin', 'provides.service_name', 'Service Name', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(787, 0, 'en', 'admin', 'provides.service_number', 'Service Number', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(788, 0, 'en', 'admin', 'provides.service_model', 'Service Model', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(789, 0, 'en', 'admin', 'provides.provider_documents', 'Provider Documents', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(790, 0, 'en', 'admin', 'provides.document_type', 'Document Type', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(791, 0, 'en', 'admin', 'provides.providers', 'Providers', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(792, 0, 'en', 'admin', 'provides.add_new_provider', 'add New Provider', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(793, 0, 'en', 'admin', 'provides.total_requests', 'Total Requests', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(794, 0, 'en', 'admin', 'provides.full_name', 'Full Name', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(795, 0, 'en', 'admin', 'provides.accepted_requests', 'Accepted Requests', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(796, 0, 'en', 'admin', 'provides.cancelled_requests', 'Cancelled Requests', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(797, 0, 'en', 'admin', 'provides.service_type', 'Documents / Service Type', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(798, 0, 'en', 'admin', 'provides.online', 'Online', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(799, 0, 'en', 'admin', 'provides.Provider_Details', 'Provider Details', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(800, 0, 'en', 'admin', 'provides.Approved', 'Approved', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(801, 0, 'en', 'admin', 'provides.Not_Approved', 'Not Approved', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(802, 0, 'en', 'admin', 'provides.Total_Rides', 'Total Rides', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(803, 0, 'en', 'admin', 'provides.Total_Earning', 'Total Earning', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(804, 0, 'en', 'admin', 'provides.Commission', 'Commission', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(805, 0, 'en', 'admin', 'provides.Joined_at', 'Joined at', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(806, 0, 'en', 'admin', 'provides.Details', 'Details', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(807, 0, 'en', 'admin', 'request.Booking_ID', 'Booking ID', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(808, 0, 'en', 'admin', 'request.User_Name', 'User Name', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(809, 0, 'en', 'admin', 'request.Date_Time', 'Date &amp;
Time', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(810, 0, 'en', 'admin', 'request.Provider_Name', 'Provider Name', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(811, 0, 'en', 'admin', 'request.Payment_Mode', 'Payment Mode', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(812, 0, 'en', 'admin', 'request.Payment_Status', 'Payment Status', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(813, 0, 'en', 'admin', 'request.Request_Id', 'Request Id', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(814, 0, 'en', 'admin', 'request.Scheduled_Date_Time', 'Scheduled Date & Time', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(815, 0, 'en', 'admin', 'review.Request_ID', 'Request ID', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(816, 0, 'en', 'admin', 'review.Rating', 'Rating', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(817, 0, 'en', 'admin', 'review.Comments', 'Comments', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(818, 0, 'en', 'admin', 'review.Provider_Reviews', 'Provider Reviews', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(819, 0, 'en', 'admin', 'review.User_Reviews', 'User Reviews', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(820, 0, 'en', 'admin', 'service.Add_Service_Type', 'Add Service Type', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(821, 0, 'en', 'admin', 'service.Service_Name', 'Service Name', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(822, 0, 'en', 'admin', 'service.Provider_Name', 'Provider Name', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(823, 0, 'en', 'admin', 'service.Service_Image', 'Service Image', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(824, 0, 'en', 'admin', 'service.Base_Price', 'Base Price', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(825, 0, 'en', 'admin', 'service.Base_Distance', 'Base Distance', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(826, 0, 'en', 'admin', 'service.unit_time', 'Unit Time Pricing (For Rental amount per hour / 60) ', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(827, 0, 'en', 'admin', 'service.unit', 'Unit Distance Price', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(828, 0, 'en', 'admin', 'service.Seat_Capacity', 'Seat Capacity', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(829, 0, 'en', 'admin', 'service.Pricing_Logic', 'Pricing Logic', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(830, 0, 'en', 'admin', 'service.Description', 'Description', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(831, 0, 'en', 'admin', 'service.Update_User', 'Update User', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(832, 0, 'en', 'admin', 'service.Update_Service_Type', 'Update Service Type', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(833, 0, 'en', 'admin', 'setting.Site_Settings', 'Site Settings', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(834, 0, 'en', 'admin', 'setting.Site_Name', 'Site Name', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(835, 0, 'en', 'admin', 'setting.Site_Logo', 'Site Logo', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(836, 0, 'en', 'admin', 'setting.Site_Icon', 'Site Icon', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(837, 0, 'en', 'admin', 'setting.Copyright_Content', 'Copyright Content', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(838, 0, 'en', 'admin', 'setting.Playstore_link', 'Playstore link', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(839, 0, 'en', 'admin', 'setting.Appstore_Link', 'Appstore Link', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(840, 0, 'en', 'admin', 'setting.Provider_Accept_Timeout', 'Provider Accept Timeout', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(841, 0, 'en', 'admin', 'setting.Provider_Search_Radius', 'Provider Search Radius', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(842, 0, 'en', 'admin', 'setting.SOS_Number', 'SOS Number', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(843, 0, 'en', 'admin', 'setting.Contact_Number', 'Contact Number', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(844, 0, 'en', 'admin', 'setting.Contact_Email', 'Contact Email', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(845, 0, 'en', 'admin', 'setting.Social_Login', 'Social Login', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(846, 0, 'en', 'admin', 'setting.Update_Site_Settings', 'Update Site Settings', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(847, 0, 'en', 'admin', 'setting.map_key', 'Google Map Key', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(848, 0, 'en', 'admin', 'setting.fb_app_version', 'FB App Version', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(849, 0, 'en', 'admin', 'setting.fb_app_id', 'FB App ID', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(850, 0, 'en', 'admin', 'setting.fb_app_secret', 'FB App Secret', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(851, 0, 'en', 'admin', 'users.Add_User', 'Add User', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(852, 0, 'en', 'admin', 'users.Update_User', 'Update User', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(853, 0, 'en', 'admin', 'users.Users', 'Users', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(854, 0, 'en', 'admin', 'users.Rating', 'Rating', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(855, 0, 'en', 'admin', 'users.Wallet_Amount', 'Wallet Amount', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(856, 0, 'en', 'admin', 'users.User_Details', 'User Details', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(857, 0, 'en', 'admin', 'users.Wallet_Balance', 'Wallet Balance', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(858, 0, 'en', 'admin', 'dashboard.Rides', 'Total Cancelled Rides', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(859, 0, 'en', 'admin', 'dashboard.Revenue', 'Revenue', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(860, 0, 'en', 'admin', 'dashboard.service', 'No. of Service Types', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(861, 0, 'en', 'admin', 'dashboard.cancel_count', 'User Cancelled Count', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(862, 0, 'en', 'admin', 'dashboard.provider_cancel_count', 'Provider Cancelled Count', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(863, 0, 'en', 'admin', 'dashboard.fleets', 'No. of Fleets', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(864, 0, 'en', 'admin', 'dashboard.scheduled', 'No. of Scheduled Rides', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(865, 0, 'en', 'admin', 'dashboard.Recent_Rides', 'Recent Rides', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(866, 0, 'en', 'admin', 'dashboard.View_Ride_Details', 'View Ride Details', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(867, 0, 'en', 'admin', 'dashboard.No_Details_Found', 'No Details Found', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(868, 0, 'en', 'admin', 'heatmap.Ride_Heatmap', 'Ride Heatmap', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(869, 0, 'en', 'admin', 'push.Push_Notification', 'Push Notification', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(870, 0, 'en', 'admin', 'push.Sent_to', 'Sent to', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(871, 0, 'en', 'admin', 'push.Push_Now', 'Push Now', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(872, 0, 'en', 'admin', 'push.Schedule_Push', 'Schedule Push', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(873, 0, 'en', 'admin', 'push.Condition', 'Condition', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(874, 0, 'en', 'admin', 'push.Notification_History', 'Notification History', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(875, 0, 'en', 'admin', 'push.Sent_on', 'Sent on', '
2020-02-20 23:35:10
', '2020-04-09 20:49:58
'),
(876, 0, 'en', 'api', 'user.incorrect_password', 'Incorrect Password', '
2020-02-20 23:35:10
', '2021-03-05 05:30:40
'),
(877, 0, 'en', 'api', 'user.change_password', 'Required is new password should
\nnot be same as old password', '
2020-02-20 23:35:10
', '2021-03-05 05:30:40
'),
(878, 0, 'en', 'api', 'user.password_updated', 'Password Updated', '
2020-02-20 23:35:10
', '2021-03-05 05:30:40
'),
(879, 0, 'en', 'api', 'user.location_updated', 'Location Updated', '
2020-02-20 23:35:10
', '2021-03-05 05:30:40
'),
(880, 0, 'en', 'api', 'user.profile_updated', 'Profile Updated', '
2020-02-20 23:35:10
', '2021-03-05 05:30:40
'),
(881, 0, 'en', 'api', 'user.user_not_found', 'User Not Found', '
2020-02-20 23:35:10
', '2021-03-05 05:30:40
'),
(882, 0, 'en', 'api', 'user.not_paid', 'User Not Paid', '
2020-02-20 23:35:10
', '2021-03-05 05:30:40
'),
(883, 0, 'en', 'api', 'ride.request_inprogress', 'Already Request in Progress', '
2020-02-20 23:35:10
', '2021-03-05 05:30:40
'),
(884, 0, 'en', 'api', 'ride.no_providers_found', 'No Drivers Found', '
2020-02-20 23:35:10
', '2021-03-05 05:30:40
'),
(885, 0, 'en', 'api', 'ride.request_cancelled', 'Your Ride has been Cancelled', '
2020-02-20 23:35:10
', '2021-03-05 05:30:40
'),
(886, 0, 'en', 'api', 'ride.already_cancelled', 'Already Ride Cancelled', '
2020-02-20 23:35:10
', '2021-03-05 05:30:40
'),
(887, 0, 'en', 'api', 'ride.already_onride', 'You are on your ride.', '
2020-02-20 23:35:10
', '2021-03-05 05:30:40
'),
(888, 0, 'en', 'api', 'ride.provider_rated', 'Driver Rated', '
2020-02-20 23:35:10
', '2021-03-05 05:30:40
'),
(889, 0, 'en', 'api', 'ride.request_scheduled', 'Ride Scheduled', '
2020-02-20 23:35:10
', '2021-03-05 05:30:40
'),
(890, 0, 'en', 'api', 'ride.request_already_scheduled', 'Ride Already Scheduled', '
2020-02-20 23:35:10
', '2021-03-05 05:30:40
'),
(891, 0, 'en', 'api', 'ride.request_modify_location', 'User Changed Destination Address', '
2020-02-20 23:35:10
', '2021-03-05 05:30:40
'),
(892, 0, 'en', 'api', 'something_went_wrong', 'Something Went Wrong', '
2020-02-20 23:35:10
', '2021-03-05 05:30:40
'),
(893, 0, 'en', 'api', 'logout_success', 'Logged out Successfully', '
2020-02-20 23:35:10
', '2021-03-05 05:30:40
'),
(894, 0, 'en', 'api', 'email_available', 'Email Available', '
2020-02-20 23:35:10
', '2021-03-05 05:30:40
'),
(895, 0, 'en', 'api', 'services_not_found', 'Services Not Found', '
2020-02-20 23:35:10
', '2021-03-05 05:30:40
'),
(896, 0, 'en', 'api', 'promocode_applied', 'Promocode Applied', '
2020-02-20 23:35:10
', '2021-03-05 05:30:40
'),
(897, 0, 'en', 'api', 'promocode_expired', 'Promocode Expired', '
2020-02-20 23:35:10
', '2021-03-05 05:30:40
'),
(898, 0, 'en', 'api', 'promocode_already_in_use', 'Promocode Already in Use', '
2020-02-20 23:35:10
', '2021-03-05 05:30:40
'),
(899, 0, 'en', 'api', 'paid', 'Paid', '
2020-02-20 23:35:10
', '2021-03-05 05:30:40
'),
(900, 0, 'en', 'api', 'added_to_your_wallet', 'Added to your Wallet', '
2020-02-20 23:35:10
', '2021-03-05 05:30:40
');
INSERT INTO `ltm_translations` (`id`, `status`, `locale`, `group`, `key`, `value`, `created_at`, `updated_at`) VALUES
(901, 0, 'en', 'api', 'push.request_accepted', 'Your request has been accepted by a Driver.', '
2020-02-20 23:35:10
', '2021-03-05 05:30:40
'),
(902, 0, 'en', 'api', 'push.arrived', 'Driver has Arrived at your Location', '
2020-02-20 23:35:10
', '2021-03-05 05:30:40
'),
(903, 0, 'en', 'api', 'push.dropped', 'Successful Ride! Amount to be paid', '
2020-02-20 23:35:10
', '2021-03-05 05:30:40
'),
(904, 0, 'en', 'api', 'push.incoming_request', 'New Incoming Ride', '
2020-02-20 23:35:10
', '2021-03-05 05:30:40
'),
(905, 0, 'en', 'api', 'push.added_money_to_wallet', ' Added to your Wallet', '
2020-02-20 23:35:10
', '2021-03-05 05:30:40
'),
(906, 0, 'en', 'api', 'push.charged_from_wallet', ' Charged from your Wallet', '
2020-02-20 23:35:10
', '2021-03-05 05:30:40
'),
(907, 0, 'en', 'api', 'push.document_verfied', 'Your Documents are verified, Now you are ready to Start your Business', '
2020-02-20 23:35:10
', '2021-03-05 05:30:40
'),
(908, 0, 'en', 'api', 'push.provider_not_available', 'Sorry for the inconvenience, Our partners are busy. Please try after some time', '
2020-02-20 23:35:10
', '2021-03-05 05:30:40
'),
(909, 0, 'en', 'api', 'push.user_cancelled', 'Client Cancelled the Ride', '
2020-02-20 23:35:10
', '2021-03-05 05:30:40
'),
(910, 0, 'en', 'api', 'push.provider_cancelled', 'Driver Cancelled the request.', '
2020-02-20 23:35:10
', '2021-03-05 05:30:40
'),
(911, 0, 'en', 'api', 'push.schedule_start', 'Your scheduled ride has been started', '
2020-02-20 23:35:10
', '2021-03-05 05:30:40
'),
(912, 0, 'en', 'api', 'ride.ride_cancelled', 'Ride Cancelled', '
2020-02-20 23:35:19
', '2021-03-05 05:30:40
'),
(915, 0, 'en', 'admin', 'Stripe_Payments', 'Stripe Payment', '
2020-04-09 20:47:12
', '2020-04-09 20:49:58
'),
(916, 0, 'en', '_json', 'Total_Revenue', NULL, '
2020-04-19 15:32:37
', '2020-04-19 15:32:37
'),
(917, 0, 'en', '_json', 'Stripe Payments', NULL, '
2020-04-19 15:32:37
', '2020-04-19 15:32:37
'),
(918, 0, 'en', '_json', 'GH', NULL, '
2020-04-19 15:32:37
', '2020-04-19 15:32:37
'),
(919, 0, 'en', '_json', 'KE', NULL, '
2020-04-19 15:32:37
', '2020-04-19 15:32:37
'),
(920, 0, 'en', '_json', 'ZA', NULL, '
2020-04-19 15:32:37
', '2020-04-19 15:32:37
'),
(921, 0, 'en', '_json', 'TZ', NULL, '
2020-04-19 15:32:37
', '2020-04-19 15:32:37
'),
(922, 0, 'en', '_json', 'NG', NULL, '
2020-04-19 15:32:37
', '2020-04-19 15:32:37
'),
(923, 1, 'en', '_json', 'Economy', NULL, '
2020-04-19 15:32:37
', '2020-12-04 04:04:06
'),
(924, 1, 'en', '_json', 'Luxury', NULL, '
2020-04-19 15:32:37
', '2020-12-04 04:03:53
'),
(925, 1, 'en', '_json', 'Extra_seat', NULL, '
2020-04-19 15:32:37
', '2020-12-04 04:04:13
'),
(926, 0, 'en', '_json', 'OutStation', 'Kid
\'s Pickup', '2020-04-19 15:32:37', '2021-03-02 05:15:57'),
(927, 0, 'hi', 'admin', 'name', 'Name', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(928, 0, 'hi', 'admin', 'email', 'Email', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(929, 0, 'hi', 'admin', 'first_name', 'First Name', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(930, 0, 'hi', 'admin', 'last_name', 'Last Name', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(931, 0, 'hi', 'admin', 'picture', 'Picture', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(932, 0, 'hi', 'admin', 'password', 'Password ', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(933, 0, 'hi', 'admin', 'mobile', 'Mobile', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(934, 0, 'hi', 'admin', 'cancel', 'Cancel', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(935, 0, 'hi', 'admin', 'back', 'Back', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(936, 0, 'hi', 'admin', 'id', 'ID', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(937, 0, 'hi', 'admin', 'edit', 'Edit', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(938, 0, 'hi', 'admin', 'gender', 'Gender', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(939, 0, 'hi', 'admin', 'address', 'Address', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(940, 0, 'hi', 'admin', 'action', 'Action', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(941, 0, 'hi', 'admin', 'Enable', 'Enable', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(942, 0, 'hi', 'admin', 'Disable', 'Disable', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(943, 0, 'hi', 'admin', 'type', 'Type', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(944, 0, 'hi', 'admin', 'delete', 'Delete', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(945, 0, 'hi', 'admin', 'help', 'Help', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(946, 0, 'hi', 'admin', 'status', 'Status', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(947, 0, 'hi', 'admin', 'message', 'Message', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(948, 0, 'hi', 'admin', 'History', 'History', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(949, 0, 'hi', 'admin', 'Statements', 'Statements', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(950, 0, 'hi', 'admin', 'amount', 'Amount', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(951, 0, 'hi', 'admin', 'account.change_password', 'Change Password', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(952, 0, 'hi', 'admin', 'account.old_password', 'Old Password', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(953, 0, 'hi', 'admin', 'account.password', 'Password ', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(954, 0, 'hi', 'admin', 'account.password_confirmation', 'Password Confirmation', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(955, 0, 'hi', 'admin', 'account.update_profile', 'Update Profile', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(956, 0, 'hi', 'admin', 'account-manager.add_account_manager', 'Add Account Manager', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(957, 0, 'hi', 'admin', 'account-manager.full_name', 'Full Name', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(958, 0, 'hi', 'admin', 'account-manager.password_confirmation', 'Password Confirmation', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(959, 0, 'hi', 'admin', 'account-manager.update_account_manager', 'Update Account Manager', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(960, 0, 'hi', 'admin', 'account-manager.account_manager', 'Account Manager', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(961, 0, 'hi', 'admin', 'account-manager.add_new_account_manager', 'Add New Account Manager', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(962, 0, 'hi', 'admin', 'auth.reset_password', 'Reset Password', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(963, 0, 'hi', 'admin', 'auth.admin_login', 'Admin Login', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(964, 0, 'hi', 'admin', 'auth.login_here', 'Login Here', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(965, 0, 'hi', 'admin', 'auth.remember_me', 'Remember Me', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(966, 0, 'hi', 'admin', 'auth.sign_in', 'Sign In', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(967, 0, 'hi', 'admin', 'auth.forgot_your_password', 'Forgot Your Password', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(968, 0, 'hi', 'admin', 'auth.request_scheduled', 'Ride Scheduled', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(969, 0, 'hi', 'admin', 'auth.request_already_scheduled', 'Ride Already Scheduled', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(970, 0, 'hi', 'admin', 'dispatcher.add_dispatcher', 'Add Dispatcher', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(971, 0, 'hi', 'admin', 'dispatcher.update_dispatcher', 'Update Dispatcher', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(972, 0, 'hi', 'admin', 'dispatcher.dispatcher', 'Dispatcher', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(973, 0, 'hi', 'admin', 'dispatcher.add_new_dispatcher', 'Add New Dispatcher', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(974, 0, 'hi', 'admin', 'document.add_Document', 'Add Document', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(975, 0, 'hi', 'admin', 'document.document_name', 'Document Name', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(976, 0, 'hi', 'admin', 'document.document_type', 'Document Type', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(977, 0, 'hi', 'admin', 'document.driver_review', 'Driver Review', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(978, 0, 'hi', 'admin', 'document.vehicle_review', 'Vehicle Review', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(979, 0, 'hi', 'admin', 'document.update_document', 'Update Document', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(980, 0, 'hi', 'admin', 'document.document', 'Document', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(981, 0, 'hi', 'admin', 'fleet.add_fleet_owner', 'Add Fleet Owner', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(982, 0, 'hi', 'admin', 'fleet.company_name', 'Company Name', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(983, 0, 'hi', 'admin', 'fleet.company_logo', 'Company Logo', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(984, 0, 'hi', 'admin', 'fleet.update_fleet_owner', 'Update Fleet Owner', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(985, 0, 'hi', 'admin', 'fleet.update_fleet', 'Update Fleet', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(986, 0, 'hi', 'admin', 'fleet.fleet_owners', 'Fleet Owners', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(987, 0, 'hi', 'admin', 'fleet.add_new_fleet_owner', 'Add New Fleet Owner', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(988, 0, 'hi', 'admin', 'fleet.show_provider', 'Show Provider', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(989, 0, 'hi', 'admin', 'include.profile', 'Profile', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(990, 0, 'hi', 'admin', 'include.sign_out', 'Sign out', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(991, 0, 'hi', 'admin', 'include.admin_dashboard', 'Admin Dashboard', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(992, 0, 'hi', 'admin', 'include.dashboard', 'Dashboard', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(993, 0, 'hi', 'admin', 'include.dispatcher_panel', 'Dispatcher Panel', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(994, 0, 'hi', 'admin', 'include.heat_map', 'Heat Map', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(995, 0, 'hi', 'admin', 'include.members', 'Members', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(996, 0, 'hi', 'admin', 'include.users', 'Usersss', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(997, 0, 'hi', 'admin', 'include.list_users', 'List Users', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(998, 0, 'hi', 'admin', 'include.add_new_user', 'Add New User', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(999, 0, 'hi', 'admin', 'include.providers', 'Providers', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1000, 0, 'hi', 'admin', 'include.list_providers', 'List Providers', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1001, 0, 'hi', 'admin', 'include.add_new_provider', 'Add New Provider', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1002, 0, 'hi', 'admin', 'include.dispatcher', 'Dispatcher', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1003, 0, 'hi', 'admin', 'include.list_dispatcher', 'List Dispatcher', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1004, 0, 'hi', 'admin', 'include.add_new_dispatcher', 'Add New Dispatcher', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1005, 0, 'hi', 'admin', 'include.fleet_owner', 'Fleet Owner', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1006, 0, 'hi', 'admin', 'include.list_fleets', 'List Fleets', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1007, 0, 'hi', 'admin', 'include.add_new_fleet_owner', 'Add New Fleet Owner', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1008, 0, 'hi', 'admin', 'include.account_manager', 'Account Manager', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1009, 0, 'hi', 'admin', 'include.list_account_managers', 'List Account Managers', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1010, 0, 'hi', 'admin', 'include.add_new_account_manager', 'Add New Account Manager', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1011, 0, 'hi', 'admin', 'include.accounts', 'Accounts', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1012, 0, 'hi', 'admin', 'include.statements', 'Statements', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1013, 0, 'hi', 'admin', 'include.overall_ride_statments', 'Overall Ride Statments', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1014, 0, 'hi', 'admin', 'include.provider_statement', 'Provider Statement', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1015, 0, 'hi', 'admin', 'include.daily_statement', 'Daily Statement', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1016, 0, 'hi', 'admin', 'include.monthly_statement', 'Monthly Statement', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1017, 0, 'hi', 'admin', 'include.yearly_statement', 'Yearly Statement', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1018, 0, 'hi', 'admin', 'include.details', 'Details', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1019, 0, 'hi', 'admin', 'include.map', 'Map', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1020, 0, 'hi', 'admin', 'include.ratings', 'Ratings', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1021, 0, 'hi', 'admin', 'include.reviews', 'Reviews', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1022, 0, 'hi', 'admin', 'include.user_ratings', 'User Ratings', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1023, 0, 'hi', 'admin', 'include.provider_ratings', 'Provider Ratings', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1024, 0, 'hi', 'admin', 'include.requests', 'Requests', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1025, 0, 'hi', 'admin', 'include.request_history', 'Request History', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1026, 0, 'hi', 'admin', 'include.scheduled_rides', 'Scheduled Rides', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1027, 0, 'hi', 'admin', 'include.general', 'General', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1028, 0, 'hi', 'admin', 'include.service_types', 'Service Types', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1029, 0, 'hi', 'admin', 'include.list_service_types', 'List Service Types', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1030, 0, 'hi', 'admin', 'include.add_new_service_type', 'Add New Service Type', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1031, 0, 'hi', 'admin', 'include.documents', 'Documents', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1032, 0, 'hi', 'admin', 'include.list_documents', 'List Documents', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1033, 0, 'hi', 'admin', 'include.add_new_document', 'Add New Document', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1034, 0, 'hi', 'admin', 'include.promocodes', 'Promocodes', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1035, 0, 'hi', 'admin', 'include.list_promocodes', 'List Promocodes', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1036, 0, 'hi', 'admin', 'include.add_new_promocode', 'Add New Promocode', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1037, 0, 'hi', 'admin', 'include.payment_details', 'Payment Details', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1038, 0, 'hi', 'admin', 'include.payment_history', 'Payment History', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1039, 0, 'hi', 'admin', 'include.payment_settings', 'Payment Settings', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1040, 0, 'hi', 'admin', 'include.settings', 'Settings', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1041, 0, 'hi', 'admin', 'include.site_settings', 'Site Settings', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1042, 0, 'hi', 'admin', 'include.others', 'Others', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1043, 0, 'hi', 'admin', 'include.privacy_policy', 'Privacy Policy', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1044, 0, 'hi', 'admin', 'include.help', 'Help', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1045, 0, 'hi', 'admin', 'include.custom_push', 'Custom Push', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1046, 0, 'hi', 'admin', 'include.translations', 'Translations', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1047, 0, 'hi', 'admin', 'include.account', 'Account', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1048, 0, 'hi', 'admin', 'include.account_settings', 'Account Settings', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1049, 0, 'hi', 'admin', 'include.change_password', 'Change Password', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1050, 0, 'hi', 'admin', 'include.logout', 'Logout', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1051, 0, 'hi', 'admin', 'pages.pages', 'Pages', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1052, 0, 'hi', 'admin', 'payment.payment_history', 'Payment History', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1053, 0, 'hi', 'admin', 'payment.request_id', 'Request ID', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1054, 0, 'hi', 'admin', 'payment.transaction_id', 'Transaction ID', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1055, 0, 'hi', 'admin', 'payment.from', 'From', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1056, 0, 'hi', 'admin', 'payment.to', 'To', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1057, 0, 'hi', 'admin', 'payment.total_amount', 'Total Amount', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1058, 0, 'hi', 'admin', 'payment.provider_amount', 'Provider Amount', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1059, 0, 'hi', 'admin', 'payment.payment_mode', 'Payment Mode', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1060, 0, 'hi', 'admin', 'payment.payment_status', 'Payment Status', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1061, 0, 'hi', 'admin', 'payment.payment_modes', 'Payment Modes', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1062, 0, 'hi', 'admin', 'payment.card_payments', 'Stripe (Card Payments)', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1063, 0, 'hi', 'admin', 'payment.stripe_secret_key', 'Stripe Secret key', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1064, 0, 'hi', 'admin', 'payment.stripe_publishable_key', 'Stripe Publishable key', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1065, 0, 'hi', 'admin', 'payment.cash_payments', 'Cash Payments', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1066, 0, 'hi', 'admin', 'payment.payment_settings', 'Payment Settings', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1067, 0, 'hi', 'admin', 'payment.daily_target', 'Daily Target', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1068, 0, 'hi', 'admin', 'payment.tax_percentage', 'Tax percentage(%)', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1069, 0, 'hi', 'admin', 'payment.surge_trigger_point', 'Surge Trigger Point', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1070, 0, 'hi', 'admin', 'payment.surge_percentage', 'Surge Percentage(%)', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1071, 0, 'hi', 'admin', 'payment.commission_percentage', 'Commission Percentage(%)', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1072, 0, 'hi', 'admin', 'payment.provider_commission_percentage', 'Provider Commission Percentage(%)', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1073, 0, 'hi', 'admin', 'payment.booking_id_prefix', 'Booking ID Prefix', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1074, 0, 'hi', 'admin', 'payment.currency', 'Currency', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1075, 0, 'hi', 'admin', 'payment.update_site_settings', 'Update Site Settings', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1076, 0, 'hi', 'admin', 'promocode.add_promocode', 'Add Promocode', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1077, 0, 'hi', 'admin', 'promocode.discount', 'Discount', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1078, 0, 'hi', 'admin', 'promocode.expiration', 'Expiration', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1079, 0, 'hi', 'admin', 'promocode.promocode', 'Promocode', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1080, 0, 'hi', 'admin', 'promocode.update_promocode', 'Update Promocode', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1081, 0, 'hi', 'admin', 'promocode.used_count', 'Used Count', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1082, 0, 'hi', 'admin', 'promocode.promocodes', 'Promocodes', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1083, 0, 'hi', 'admin', 'promocode.discount_type', 'Promocode Use ', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1084, 0, 'hi', 'admin', 'provides.provider_name', 'Provider Name', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1085, 0, 'hi', 'admin', 'provides.approve', 'Approve', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1086, 0, 'hi', 'admin', 'provides.delete', 'Delete', '2020-05-14 23:59:33', '2020-05-16 00:53:29'),
(1087, 0, 'hi', 'admin', 'provides.add_provider', 'Add Provider', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1088, 0, 'hi', 'admin', 'provides.password_confirmation', 'Password Confirmation', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1089, 0, 'hi', 'admin', 'provides.update_provider', 'Update Provider', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1090, 0, 'hi', 'admin', 'provides.type_allocation', 'Provider Service Type Allocation', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1091, 0, 'hi', 'admin', 'provides.service_name', 'Service Name', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1092, 0, 'hi', 'admin', 'provides.service_number', 'Service Number', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1093, 0, 'hi', 'admin', 'provides.service_model', 'Service Model', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1094, 0, 'hi', 'admin', 'provides.provider_documents', 'Provider Documents', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1095, 0, 'hi', 'admin', 'provides.document_type', 'Document Type', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1096, 0, 'hi', 'admin', 'provides.providers', 'Providers', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1097, 0, 'hi', 'admin', 'provides.add_new_provider', 'add New Provider', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1098, 0, 'hi', 'admin', 'provides.total_requests', 'Total Requests', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1099, 0, 'hi', 'admin', 'provides.full_name', 'Full Name', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1100, 0, 'hi', 'admin', 'provides.accepted_requests', 'Accepted Requests', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1101, 0, 'hi', 'admin', 'provides.cancelled_requests', 'Cancelled Requests', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1102, 0, 'hi', 'admin', 'provides.service_type', 'Documents / Service Type', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1103, 0, 'hi', 'admin', 'provides.online', 'Online', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1104, 0, 'hi', 'admin', 'provides.Provider_Details', 'Provider Details', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1105, 0, 'hi', 'admin', 'provides.Approved', 'Approved', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1106, 0, 'hi', 'admin', 'provides.Not_Approved', 'Not Approved', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1107, 0, 'hi', 'admin', 'provides.Total_Rides', 'Total Rides', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1108, 0, 'hi', 'admin', 'provides.Total_Earning', 'Total Earning', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1109, 0, 'hi', 'admin', 'provides.Commission', 'Commission', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1110, 0, 'hi', 'admin', 'provides.Joined_at', 'Joined at', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1111, 0, 'hi', 'admin', 'provides.Details', 'Details', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1112, 0, 'hi', 'admin', 'request.Booking_ID', 'Booking ID', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1113, 0, 'hi', 'admin', 'request.User_Name', 'User Name', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1114, 0, 'hi', 'admin', 'request.Date_Time', 'Date &amp; Time', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1115, 0, 'hi', 'admin', 'request.Provider_Name', 'Provider Name', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1116, 0, 'hi', 'admin', 'request.Payment_Mode', 'Payment Mode', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1117, 0, 'hi', 'admin', 'request.Payment_Status', 'Payment Status', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1118, 0, 'hi', 'admin', 'request.Request_Id', 'Request Id', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1119, 0, 'hi', 'admin', 'request.Scheduled_Date_Time', 'Scheduled Date & Time', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1120, 0, 'hi', 'admin', 'review.Request_ID', 'Request ID', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1121, 0, 'hi', 'admin', 'review.Rating', 'Rating', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1122, 0, 'hi', 'admin', 'review.Comments', 'Comments', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1123, 0, 'hi', 'admin', 'review.Provider_Reviews', 'Provider Reviews', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1124, 0, 'hi', 'admin', 'review.User_Reviews', 'User Reviews', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1125, 0, 'hi', 'admin', 'service.Add_Service_Type', 'Add Service Type', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1126, 0, 'hi', 'admin', 'service.Service_Name', 'Service Name', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1127, 0, 'hi', 'admin', 'service.Provider_Name', 'Provider Name', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1128, 0, 'hi', 'admin', 'service.Service_Image', 'Service Image', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1129, 0, 'hi', 'admin', 'service.Base_Price', 'Base Price', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1130, 0, 'hi', 'admin', 'service.Base_Distance', 'Base Distance', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1131, 0, 'hi', 'admin', 'service.unit_time', 'Unit Time Pricing (For Rental amount per hour / 60) ', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1132, 0, 'hi', 'admin', 'service.unit', 'Unit Distance Price', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1133, 0, 'hi', 'admin', 'service.Seat_Capacity', 'Seat Capacity', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1134, 0, 'hi', 'admin', 'service.Pricing_Logic', 'Pricing Logic', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1135, 0, 'hi', 'admin', 'service.Description', 'Description', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1136, 0, 'hi', 'admin', 'service.Update_User', 'Update User', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1137, 0, 'hi', 'admin', 'service.Update_Service_Type', 'Update Service Type', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1138, 0, 'hi', 'admin', 'setting.Site_Settings', 'Site Settings', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1139, 0, 'hi', 'admin', 'setting.Site_Name', 'Site Name', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1140, 0, 'hi', 'admin', 'setting.Site_Logo', 'Site Logo', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1141, 0, 'hi', 'admin', 'setting.Site_Icon', 'Site Icon', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1142, 0, 'hi', 'admin', 'setting.Copyright_Content', 'Copyright Content', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1143, 0, 'hi', 'admin', 'setting.Playstore_link', 'Playstore link', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1144, 0, 'hi', 'admin', 'setting.Appstore_Link', 'Appstore Link', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1145, 0, 'hi', 'admin', 'setting.Provider_Accept_Timeout', 'Provider Accept Timeout', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1146, 0, 'hi', 'admin', 'setting.Provider_Search_Radius', 'Provider Search Radius', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1147, 0, 'hi', 'admin', 'setting.SOS_Number', 'SOS Number', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1148, 0, 'hi', 'admin', 'setting.Contact_Number', 'Contact Number', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1149, 0, 'hi', 'admin', 'setting.Contact_Email', 'Contact Email', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1150, 0, 'hi', 'admin', 'setting.Social_Login', 'Social Login', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1151, 0, 'hi', 'admin', 'setting.Update_Site_Settings', 'Update Site Settings', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1152, 0, 'hi', 'admin', 'setting.map_key', 'Google Map Key', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1153, 0, 'hi', 'admin', 'setting.fb_app_version', 'FB App Version', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1154, 0, 'hi', 'admin', 'setting.fb_app_id', 'FB App ID', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1155, 0, 'hi', 'admin', 'setting.fb_app_secret', 'FB App Secret', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1156, 0, 'hi', 'admin', 'users.Add_User', 'Add User', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1157, 0, 'hi', 'admin', 'users.Update_User', 'Update User', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1158, 0, 'hi', 'admin', 'users.Users', 'Users', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1159, 0, 'hi', 'admin', 'users.Rating', 'Rating', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1160, 0, 'hi', 'admin', 'users.Wallet_Amount', 'Wallet Amount', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1161, 0, 'hi', 'admin', 'users.User_Details', 'User Details', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1162, 0, 'hi', 'admin', 'users.Wallet_Balance', 'Wallet Balance', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1163, 0, 'hi', 'admin', 'dashboard.Rides', 'Total Cancelled Rides', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1164, 0, 'hi', 'admin', 'dashboard.Revenue', 'Revenue', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1165, 0, 'hi', 'admin', 'dashboard.service', 'No. of Service Types', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1166, 0, 'hi', 'admin', 'dashboard.cancel_count', 'User Cancelled Count', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1167, 0, 'hi', 'admin', 'dashboard.provider_cancel_count', 'Provider Cancelled Count', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1168, 0, 'hi', 'admin', 'dashboard.fleets', 'No. of Fleets', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1169, 0, 'hi', 'admin', 'dashboard.scheduled', 'No. of Scheduled Rides', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1170, 0, 'hi', 'admin', 'dashboard.Recent_Rides', 'Recent Rides', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1171, 0, 'hi', 'admin', 'dashboard.View_Ride_Details', 'View Ride Details', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1172, 0, 'hi', 'admin', 'dashboard.No_Details_Found', 'No Details Found', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1173, 0, 'hi', 'admin', 'heatmap.Ride_Heatmap', 'Ride Heatmap', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1174, 0, 'hi', 'admin', 'push.Push_Notification', 'Push Notification', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1175, 0, 'hi', 'admin', 'push.Sent_to', 'Sent to', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1176, 0, 'hi', 'admin', 'push.Push_Now', 'Push Now', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1177, 0, 'hi', 'admin', 'push.Schedule_Push', 'Schedule Push', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1178, 0, 'hi', 'admin', 'push.Condition', 'Condition', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1179, 0, 'hi', 'admin', 'push.Notification_History', 'Notification History', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1180, 0, 'hi', 'admin', 'push.Sent_on', 'Sent on', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1181, 0, 'hi', 'admin', 'Stripe_Payments', 'Stripe Payment', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1182, 0, 'hi', 'api', 'user.incorrect_password', 'Incorrect Password', '2020-05-14 23:59:34', '2021-03-05 05:30:40'),
(1183, 0, 'hi', 'api', 'user.change_password', 'Required is new password should \nnot be same as old password', '2020-05-14 23:59:34', '2021-03-05 05:30:40'),
(1184, 0, 'hi', 'api', 'user.password_updated', 'Password Updated', '2020-05-14 23:59:34', '2021-03-05 05:30:40'),
(1185, 0, 'hi', 'api', 'user.location_updated', 'Location Updated', '2020-05-14 23:59:34', '2021-03-05 05:30:40'),
(1186, 0, 'hi', 'api', 'user.profile_updated', 'Profile Updated', '2020-05-14 23:59:34', '2021-03-05 05:30:40'),
(1187, 0, 'hi', 'api', 'user.user_not_found', 'User Not Found', '2020-05-14 23:59:34', '2021-03-05 05:30:40'),
(1188, 0, 'hi', 'api', 'user.not_paid', 'User Not Paid', '2020-05-14 23:59:34', '2021-03-05 05:30:40'),
(1189, 0, 'hi', 'api', 'ride.request_inprogress', 'Already Request in Progress', '2020-05-14 23:59:34', '2021-03-05 05:30:40'),
(1190, 0, 'hi', 'api', 'ride.no_providers_found', 'No Drivers Found', '2020-05-14 23:59:34', '2021-03-05 05:30:40'),
(1191, 0, 'hi', 'api', 'ride.request_cancelled', 'Your Ride has been Cancelled', '2020-05-14 23:59:34', '2021-03-05 05:30:40'),
(1192, 0, 'hi', 'api', 'ride.already_cancelled', 'Already Ride Cancelled', '2020-05-14 23:59:34', '2021-03-05 05:30:40'),
(1193, 0, 'hi', 'api', 'ride.already_onride', 'You are on your ride.', '2020-05-14 23:59:34', '2021-03-05 05:30:40'),
(1194, 0, 'hi', 'api', 'ride.provider_rated', 'Driver Rated', '2020-05-14 23:59:34', '2021-03-05 05:30:40'),
(1195, 0, 'hi', 'api', 'ride.request_scheduled', 'Ride Scheduled', '2020-05-14 23:59:34', '2021-03-05 05:30:40'),
(1196, 0, 'hi', 'api', 'ride.request_already_scheduled', 'Ride Already Scheduled', '2020-05-14 23:59:34', '2021-03-05 05:30:40'),
(1197, 0, 'hi', 'api', 'ride.request_modify_location', 'User Changed Destination Address', '2020-05-14 23:59:34', '2021-03-05 05:30:40'),
(1198, 0, 'hi', 'api', 'something_went_wrong', 'Something Went Wrong', '2020-05-14 23:59:34', '2021-03-05 05:30:40'),
(1199, 0, 'hi', 'api', 'logout_success', 'Logged out Successfully', '2020-05-14 23:59:34', '2021-03-05 05:30:40'),
(1200, 0, 'hi', 'api', 'email_available', 'Email Available', '2020-05-14 23:59:34', '2021-03-05 05:30:40'),
(1201, 0, 'hi', 'api', 'services_not_found', 'Services Not Found', '2020-05-14 23:59:34', '2021-03-05 05:30:40'),
(1202, 0, 'hi', 'api', 'promocode_applied', 'Promocode Applied', '2020-05-14 23:59:34', '2021-03-05 05:30:40'),
(1203, 0, 'hi', 'api', 'promocode_expired', 'Promocode Expired', '2020-05-14 23:59:34', '2021-03-05 05:30:40'),
(1204, 0, 'hi', 'api', 'promocode_already_in_use', 'Promocode Already in Use', '2020-05-14 23:59:34', '2021-03-05 05:30:40'),
(1205, 0, 'hi', 'api', 'paid', 'Paid', '2020-05-14 23:59:34', '2021-03-05 05:30:40'),
(1206, 0, 'hi', 'api', 'added_to_your_wallet', 'Added to your Wallet', '2020-05-14 23:59:34', '2021-03-05 05:30:40'),
(1207, 0, 'hi', 'api', 'push.request_accepted', 'Your request has been accepted by a Driver.', '2020-05-14 23:59:34', '2021-03-05 05:30:40'),
(1208, 0, 'hi', 'api', 'push.arrived', 'Driver has Arrived at your Location', '2020-05-14 23:59:34', '2021-03-05 05:30:40'),
(1209, 0, 'hi', 'api', 'push.dropped', 'Successful Ride! Amount to be paid', '2020-05-14 23:59:34', '2021-03-05 05:30:40'),
(1210, 0, 'hi', 'api', 'push.incoming_request', 'New Incoming Ride', '2020-05-14 23:59:34', '2021-03-05 05:30:40'),
(1211, 0, 'hi', 'api', 'push.added_money_to_wallet', ' Added to your Wallet', '2020-05-14 23:59:34', '2021-03-05 05:30:40'),
(1212, 0, 'hi', 'api', 'push.charged_from_wallet', ' Charged from your Wallet', '2020-05-14 23:59:34', '2021-03-05 05:30:40'),
(1213, 0, 'hi', 'api', 'push.document_verfied', 'Your Documents are verified, Now you are ready to Start your Business', '2020-05-14 23:59:34', '2021-03-05 05:30:40'),
(1214, 0, 'hi', 'api', 'push.provider_not_available', 'Sorry for the inconvenience, Our partners are busy. Please try after some time', '2020-05-14 23:59:34', '2021-03-05 05:30:40'),
(1215, 0, 'hi', 'api', 'push.user_cancelled', 'Client Cancelled the Ride', '2020-05-14 23:59:34', '2021-03-05 05:30:40'),
(1216, 0, 'hi', 'api', 'push.provider_cancelled', 'Driver Cancelled the request.', '2020-05-14 23:59:34', '2021-03-05 05:30:40'),
(1217, 0, 'hi', 'api', 'push.schedule_start', 'Your scheduled ride has been started', '2020-05-14 23:59:34', '2021-03-05 05:30:40'),
(1218, 0, 'hi', 'auth', 'failed', 'These credentials do not match our records.', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1219, 0, 'hi', 'auth', 'throttle', 'Too many login attempts. Please try again in :seconds seconds.', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1220, 0, 'hi', 'pagination', 'previous', '&laquo; Previous', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1221, 0, 'hi', 'pagination', 'next', 'Next &raquo;', '2020-05-14 23:59:34', '2020-05-16 00:53:29'),
(1222, 0, 'hi', 'passwords', 'password', 'Passwords must be at least six characters and match the confirmation.', '2020-05-14 23:59:34', '2020-10-26 19:48:59'),
(1223, 0, 'hi', 'passwords', 'reset', 'Your password has been reset!', '2020-05-14 23:59:34', '2020-10-26 19:48:59'),
(1224, 0, 'hi', 'passwords', 'sent', 'We have emailed your password reset link!', '2020-05-14 23:59:34', '2020-10-26 19:48:59'),
(1225, 0, 'hi', 'passwords', 'token', 'This password reset token is invalid.', '2020-05-14 23:59:34', '2020-10-26 19:48:59'),
(1226, 0, 'hi', 'passwords', 'user', 'We can\'t find a user with that email address.', '
2020-05-14 23:59:34
', '2020-10-26 19:48:59
'),
(1227, 0, 'hi', 'servicetypes', 'MIN', 'Per Minute Pricing', '
2020-05-14 23:59:34
', '2020-05-16 00:53:29
'),
(1228, 0, 'hi', 'servicetypes', 'HOUR', 'Per Hour Pricing', '
2020-05-14 23:59:34
', '2020-05-16 00:53:29
'),
(1229, 0, 'hi', 'servicetypes', 'DISTANCE', 'Distance Pricing', '
2020-05-14 23:59:34
', '2020-05-16 00:53:29
'),
(1230, 0, 'hi', 'servicetypes', 'DISTANCEMIN', 'Distance and Per Minute Pricing', '
2020-05-14 23:59:34
', '2020-05-16 00:53:29
'),
(1231, 0, 'hi', 'servicetypes', 'DISTANCEHOUR', 'Distance and Per Hour Pricing', '
2020-05-14 23:59:34
', '2020-05-16 00:53:29
'),
(1232, 0, 'hi', 'user', 'profile.old_password', 'Old Password', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1233, 0, 'hi', 'user', 'profile.password', 'Password', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1234, 0, 'hi', 'user', 'profile.confirm_password', 'Confirm Password', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1235, 0, 'hi', 'user', 'profile.first_name', 'First Name', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1236, 0, 'hi', 'user', 'profile.last_name', 'Last Name', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1237, 0, 'hi', 'user', 'profile.email', 'Email', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1238, 0, 'hi', 'user', 'profile.mobile', 'Mobile', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1239, 0, 'hi', 'user', 'profile.general_information', 'General Information', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1240, 0, 'hi', 'user', 'profile.profile_picture', 'Profile Picture', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1241, 0, 'hi', 'user', 'profile.wallet_balance', 'Wallet Balance', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1242, 0, 'hi', 'user', 'profile.edit', 'Edit', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1243, 0, 'hi', 'user', 'profile.save', 'Save', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1244, 0, 'hi', 'user', 'profile.edit_information', 'Edit Information', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1245, 0, 'hi', 'user', 'profile.change_password', 'Change Password', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1246, 0, 'hi', 'user', 'profile.profile', 'Profile', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1247, 0, 'hi', 'user', 'profile.logout', 'Logout', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1248, 0, 'hi', 'user', 'profile.name', 'Name', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1249, 0, 'hi', 'user', 'cash', 'CASH', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1250, 0, 'hi', 'user', 'booking_id', 'Booking Id', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1251, 0, 'hi', 'user', 'service_number', 'Car Number', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1252, 0, 'hi', 'user', 'service_model', 'Car Model', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1253, 0, 'hi', 'user', 'card.fullname', 'Full Name', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1254, 0, 'hi', 'user', 'card.card_no', 'Card Number', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1255, 0, 'hi', 'user', 'card.cvv', 'CVV', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1256, 0, 'hi', 'user', 'card.add_card', 'Add Card', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1257, 0, 'hi', 'user', 'card.delete', 'Delete', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1258, 0, 'hi', 'user', 'card.month', 'Month', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1259, 0, 'hi', 'user', 'card.year', 'Year', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1260, 0, 'hi', 'user', 'card.default', 'Default', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1261, 0, 'hi', 'user', 'fare_breakdown', 'FARE BREAKDOWN', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1262, 0, 'hi', 'user', 'ride.finding_driver', 'Finding your Driver', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1263, 0, 'hi', 'user', 'ride.accepted_ride', 'Accepted Your Ride', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1264, 0, 'hi', 'user', 'ride.arrived_ride', 'Arrived At your Location', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1265, 0, 'hi', 'user', 'ride.onride', 'Enjoy your Ride', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1266, 0, 'hi', 'user', 'ride.waiting_payment', 'Waiting for Payment', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1267, 0, 'hi', 'user', 'ride.rate_and_review', 'Rate and Review', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1268, 0, 'hi', 'user', 'ride.ride_now', 'Ride Now', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1269, 0, 'hi', 'user', 'ride.cancel_request', 'Cancel Request', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1270, 0, 'hi', 'user', 'ride.ride_status', 'Ride Status', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1271, 0, 'hi', 'user', 'ride.dropped_ride', 'Your Ride is Completed', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1272, 0, 'hi', 'user', 'ride.ride_details', 'Ride Details', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1273, 0, 'hi', 'user', 'ride.invoice', 'Invoice', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1274, 0, 'hi', 'user', 'ride.base_price', 'Base Fare', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1275, 0, 'hi', 'user', 'ride.tax_price', 'Tax Fare', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1276, 0, 'hi', 'user', 'ride.distance_price', 'Distance Fare', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1277, 0, 'hi', 'user', 'ride.comment', 'Comment', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1278, 0, 'hi', 'user', 'ride.detection_wallet', 'Wallet Detection', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1279, 0, 'hi', 'user', 'ride.rating', 'Rating', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1280, 0, 'hi', 'user', 'ride.km', 'Kilometer', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1281, 0, 'hi', 'user', 'ride.total', 'Total', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1282, 0, 'hi', 'user', 'ride.amount_paid', 'Amount to be Paid', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1283, 0, 'hi', 'user', 'ride.promotion_applied', 'Promotion Applied', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1284, 0, 'hi', 'user', 'ride.request_inprogress', 'Ride Already in Progress', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1285, 0, 'hi', 'user', 'ride.request_scheduled', 'Ride Already Scheduled on this time', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1286, 0, 'hi', 'user', 'ride.cancel_reason', 'Cancel Reason', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1287, 0, 'hi', 'user', 'ride.wallet_deduction', 'Wallet Deduction', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1288, 0, 'hi', 'user', 'dashboard', 'Dashboard', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1289, 0, 'hi', 'user', 'payment', 'Payment', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1290, 0, 'hi', 'user', 'wallet', 'Wallet', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1291, 0, 'hi', 'user', 'my_wallet', 'My Wallet', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1292, 0, 'hi', 'user', 'my_trips', 'My Trips', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1293, 0, 'hi', 'user', 'in_your_wallet', 'in your wallet', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1294, 0, 'hi', 'user', 'status', 'Status', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1295, 0, 'hi', 'user', 'driver_name', 'Driver Name', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1296, 0, 'hi', 'user', 'driver_rating', 'Driver Rating', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1297, 0, 'hi', 'user', 'payment_mode', 'Payment Mode', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1298, 0, 'hi', 'user', 'add_money', 'Add Money', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1299, 0, 'hi', 'user', 'date', 'Date', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1300, 0, 'hi', 'user', 'schedule_date', 'Scheduled Date', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1301, 0, 'hi', 'user', 'amount', 'Total Amount', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1302, 0, 'hi', 'user', 'type', 'Type', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1303, 0, 'hi', 'user', 'time', 'Time', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1304, 0, 'hi', 'user', 'request_id', 'Request ID', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1305, 0, 'hi', 'user', 'paid_via', 'PAID VIA', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1306, 0, 'hi', 'user', 'from', 'From', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1307, 0, 'hi', 'user', 'total_distance', 'Total Distance', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1308, 0, 'hi', 'user', 'eta', 'ETA', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1309, 0, 'hi', 'user', 'to', 'To', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1310, 0, 'hi', 'user', 'use_wallet_balance', 'Use Wallet Balance', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1311, 0, 'hi', 'user', 'available_wallet_balance', 'Available Wallet Balance', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1312, 0, 'hi', 'user', 'estimated_fare', 'Estimated Fare', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1313, 0, 'hi', 'user', 'charged', 'CHARGED', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1314, 0, 'hi', 'user', 'payment_method', 'Payment Methods', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1315, 0, 'hi', 'user', 'promotion', 'Promotions', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1316, 0, 'hi', 'user', 'add_promocode', 'Add Promocode', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1317, 0, 'hi', 'user', 'upcoming_trips', 'Upcoming trips', '
2020-05-14 23:59:34
', '2021-03-02 05:18:55
'),
(1318, 0, 'hi', 'validation', 'accepted', 'The :attribute must be accepted.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1319, 0, 'hi', 'validation', 'active_url', 'The :attribute is not a valid URL.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1320, 0, 'hi', 'validation', 'after', 'The :attribute must be a date after :date.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1321, 0, 'hi', 'validation', 'after_or_equal', 'The :attribute must be a date after or equal to :date.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1322, 0, 'hi', 'validation', 'alpha', 'The :attribute may only contain letters.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1323, 0, 'hi', 'validation', 'alpha_dash', 'The :attribute may only contain letters, numbers, and dashes.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1324, 0, 'hi', 'validation', 'alpha_num', 'The :attribute may only contain letters and numbers.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1325, 0, 'hi', 'validation', 'array', 'The :attribute must be an array.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1326, 0, 'hi', 'validation', 'before', 'The :attribute must be a date before :date.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1327, 0, 'hi', 'validation', 'before_or_equal', 'The :attribute must be a date before or equal to :date.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1328, 0, 'hi', 'validation', 'between.numeric', 'The :attribute must be between :min and :max.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1329, 0, 'hi', 'validation', 'between.file', 'The :attribute must be between :min and :max kilobytes.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1330, 0, 'hi', 'validation', 'between.string', 'The :attribute must be between :min and :max characters.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1331, 0, 'hi', 'validation', 'between.array', 'The :attribute must have between :min and :max items.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1332, 0, 'hi', 'validation', 'boolean', 'The :attribute field must be true or false.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1333, 0, 'hi', 'validation', 'confirmed', 'The :attribute confirmation does not match.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1334, 0, 'hi', 'validation', 'date', 'The :attribute is not a valid date.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1335, 0, 'hi', 'validation', 'date_format', 'The :attribute does not match the format :format.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1336, 0, 'hi', 'validation', 'different', 'The :attribute and :other must be different.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1337, 0, 'hi', 'validation', 'digits', 'The :attribute must be :digits digits.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1338, 0, 'hi', 'validation', 'digits_between', 'The :attribute must be between :min and :max digits.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1339, 0, 'hi', 'validation', 'dimensions', 'The :attribute has invalid image dimensions.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1340, 0, 'hi', 'validation', 'distinct', 'The :attribute field has a duplicate value.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1341, 0, 'hi', 'validation', 'email', 'The :attribute must be a valid email address.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1342, 0, 'hi', 'validation', 'exists', 'The selected :attribute is invalid.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1343, 0, 'hi', 'validation', 'file', 'The :attribute must be a file.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1344, 0, 'hi', 'validation', 'filled', 'The :attribute field is required.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1345, 0, 'hi', 'validation', 'image', 'The :attribute must be an image.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1346, 0, 'hi', 'validation', 'in', 'The selected :attribute is invalid.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1347, 0, 'hi', 'validation', 'in_array', 'The :attribute field does not exist in :other.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1348, 0, 'hi', 'validation', 'integer', 'The :attribute must be an integer.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1349, 0, 'hi', 'validation', 'ip', 'The :attribute must be a valid IP address.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
');
INSERT INTO `ltm_translations` (`id`, `status`, `locale`, `group`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1350, 0, 'hi', 'validation', 'json', 'The :attribute must be a valid JSON string.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1351, 0, 'hi', 'validation', 'max.numeric', 'The :attribute may not be greater than :max.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1352, 0, 'hi', 'validation', 'max.file', 'The :attribute may not be greater than :max kilobytes.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1353, 0, 'hi', 'validation', 'max.string', 'The :attribute may not be greater than :max characters.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1354, 0, 'hi', 'validation', 'max.array', 'The :attribute may not have more than :max items.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1355, 0, 'hi', 'validation', 'mimes', 'The :attribute must be a file of type: :values.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1356, 0, 'hi', 'validation', 'mimetypes', 'The :attribute must be a file of type: :values.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1357, 0, 'hi', 'validation', 'min.numeric', 'The :attribute must be at least :min.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1358, 0, 'hi', 'validation', 'min.file', 'The :attribute must be at least :min kilobytes.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1359, 0, 'hi', 'validation', 'min.string', 'The :attribute must be at least :min characters.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1360, 0, 'hi', 'validation', 'min.array', 'The :attribute must have at least :min items.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1361, 0, 'hi', 'validation', 'not_in', 'The selected :attribute is invalid.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1362, 0, 'hi', 'validation', 'numeric', 'The :attribute must be a number.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1363, 0, 'hi', 'validation', 'present', 'The :attribute field must be present.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1364, 0, 'hi', 'validation', 'regex', 'The :attribute format is invalid.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1365, 0, 'hi', 'validation', 'required', 'The :attribute field is required.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1366, 0, 'hi', 'validation', 'required_if', 'The :attribute field is required when :other is :value.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1367, 0, 'hi', 'validation', 'required_unless', 'The :attribute field is required unless :other is in :values.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1368, 0, 'hi', 'validation', 'required_with', 'The :attribute field is required when :values is present.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1369, 0, 'hi', 'validation', 'required_with_all', 'The :attribute field is required when :values is present.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1370, 0, 'hi', 'validation', 'required_without', 'The :attribute field is required when :values is not present.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1371, 0, 'hi', 'validation', 'required_without_all', 'The :attribute field is required when none of :values are present.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1372, 0, 'hi', 'validation', 'same', 'The :attribute and :other must match.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1373, 0, 'hi', 'validation', 'size.numeric', 'The :attribute must be :size.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1374, 0, 'hi', 'validation', 'size.file', 'The :attribute must be :size kilobytes.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1375, 0, 'hi', 'validation', 'size.string', 'The :attribute must be :size characters.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1376, 0, 'hi', 'validation', 'size.array', 'The :attribute must contain :size items.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1377, 0, 'hi', 'validation', 'string', 'The :attribute must be a string.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1378, 0, 'hi', 'validation', 'timezone', 'The :attribute must be a valid zone.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1379, 0, 'hi', 'validation', 'unique', 'The :attribute has already been taken.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1380, 0, 'hi', 'validation', 'uploaded', 'The :attribute failed to upload.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1381, 0, 'hi', 'validation', 'url', 'The :attribute format is invalid.', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1382, 0, 'hi', 'validation', 'custom.attribute-name.rule-name', 'custom-message', '
2020-05-14 23:59:34
', '2020-07-28 04:45:36
'),
(1418, 0, 'en', 'frontend', 'f_14', 'Lorem Ipsum passages, and more recently with desktop publishing software like aldus pageMaker including versions of all the generators.', '
2020-05-16 00:57:26
', '2020-11-07 23:40:58
'),
(1419, 0, 'en', 'frontend', 'f_15', 'Book for Others', '
2020-05-16 00:57:26
', '2020-11-07 23:40:58
'),
(1417, 0, 'en', 'frontend', 'f_13', 'Download Our App', '
2020-05-16 00:57:26
', '2020-11-07 23:40:58
'),
(1405, 0, 'en', 'frontend', 'f_01', 'More recently with desktop publishing software ncluding versions', '
2020-05-16 00:56:41
', '2020-11-07 23:40:58
'),
(1406, 0, 'en', 'frontend', 'f_02', 'Upto 25% off on first booking through your app', '
2020-05-16 00:57:26
', '2020-11-07 23:40:58
'),
(1407, 0, 'en', 'frontend', 'f_03', 'User App', '
2020-05-16 00:57:26
', '2020-11-07 23:40:58
'),
(1408, 0, 'en', 'frontend', 'f_04', 'Partner App', '
2020-05-16 00:57:26
', '2020-11-07 23:40:58
'),
(1409, 0, 'en', 'frontend', 'f_05', 'Get Booking In 3 Steps', '
2020-05-16 00:57:26
', '2020-11-07 23:40:58
'),
(1410, 0, 'en', 'frontend', 'f_06', 'Lorem Ipsum passages, and more recently with desktop publishing', '
2020-05-16 00:57:26
', '2020-11-07 23:40:58
'),
(1411, 0, 'en', 'frontend', 'f_07', 'Make Reservation', '
2020-05-16 00:57:26
', '2020-11-07 23:40:58
'),
(1412, 0, 'en', 'frontend', 'f_08', 'Enjoy Your Trips', '
2020-05-16 00:57:26
', '2020-11-07 23:40:58
'),
(1413, 0, 'en', 'frontend', 'f_09', 'Vehicle Confirmation', '
2020-05-16 00:57:26
', '2020-11-07 23:40:58
'),
(1414, 0, 'en', 'frontend', 'f_10', 'A more recently with desktop softy like aldus page maker still in their infancy mak versions have evolved.', '
2020-05-16 00:57:26
', '2020-11-07 23:40:58
'),
(1415, 0, 'en', 'frontend', 'f_11', 'A more recently with desktop softy like aldus page maker still in their infancy mak versions have evolved 2
', '2020-05-16 00:57:26
', '2020-11-07 23:40:58
'),
(1416, 0, 'en', 'frontend', 'f_12', 'A more recently with desktop softy like aldus page maker still in their infancy mak versions have evolved 3
', '2020-05-16 00:57:26
', '2020-11-07 23:40:58
'),
(1446, 0, 'en', 'frontend', 'f_42', 'User Login/Registration', '
2020-05-16 01:17:07
', '2020-11-07 23:40:58
'),
(1420, 0, 'en', 'frontend', 'f_16', 'No-Surge Price 24/7
', '2020-05-16 01:01:00
', '2020-11-07 23:40:58
'),
(1421, 0, 'en', 'frontend', 'f_17', 'Chauffeur-drive', '
2020-05-16 01:01:00
', '2020-11-07 23:40:58
'),
(1422, 0, 'en', 'frontend', 'f_18', 'Well maintained Cabs', '
2020-05-16 01:01:00
', '2020-11-07 23:40:58
'),
(1423, 0, 'en', 'frontend', 'f_19', 'Amazing Facts', '
2020-05-16 01:01:00
', '2020-11-07 23:40:58
'),
(1424, 0, 'en', 'frontend', 'f_20', 'Lorem Ipsum passages, and more recently with desktop publishing software like aldus pageMaker.', '
2020-05-16 01:01:00
', '2020-11-07 23:40:58
'),
(1425, 0, 'en', 'frontend', 'f_21', '
100 ', '
2020-05-16 01:01:00
', '2020-11-07 23:40:58
'),
(1426, 0, 'en', 'frontend', 'f_22', '
200', '
2020-05-16 01:01:00
', '2020-11-07 23:40:58
'),
(1427, 0, 'en', 'frontend', 'f_23', '
12,000 ', '
2020-05-16 01:01:00
', '2020-11-07 23:40:58
'),
(1428, 0, 'en', 'frontend', 'f_24', 'Happy Customer', '
2020-05-16 01:01:00
', '2020-11-07 23:40:58
'),
(1429, 0, 'en', 'frontend', 'f_25', 'Luxury Cars', '
2020-05-16 01:01:00
', '2020-11-07 23:40:58
'),
(1430, 0, 'en', 'frontend', 'f_26', 'Kilometers Driven', '
2020-05-16 01:01:00
', '2020-11-07 23:40:58
'),
(1431, 0, 'en', 'frontend', 'f_27', 'Best Price Guaranteed', '
2020-05-16 01:01:00
', '2020-11-07 23:40:58
'),
(1432, 0, 'en', 'frontend', 'f_28', '
24/7 Customer Care', '
2020-05-16 01:01:00
', '2020-11-07 23:40:58
'),
(1433, 0, 'en', 'frontend', 'f_29', 'Easy Bookings', '
2020-05-16 01:01:00
', '2020-11-07 23:40:58
'),
(1434, 0, 'en', 'frontend', 'f_30', 'A more recently with desktop softy like aldus page maker.', '
2020-05-16 01:02:36
', '2020-11-07 23:40:58
'),
(1435, 0, 'en', 'frontend', 'f_31', 'A more recently with desktop softy like aldus page maker.1
', '2020-05-16 01:02:36
', '2020-11-07 23:40:58
'),
(1436, 0, 'en', 'frontend', 'f_32', 'A more recently with desktop softy like aldus page maker.2
', '2020-05-16 01:02:36
', '2020-11-07 23:40:58
'),
(1437, 0, 'en', 'frontend', 'f_33', 'About', '
2020-05-16 01:02:36
', '2020-11-07 23:40:58
'),
(1438, 0, 'en', 'frontend', 'f_34', 'Search for will uncover many web sites variables onto of passages of lorem ipsum available but the majority the words all predefined humour to met chunks recently with desktop.', '
2020-05-16 01:02:36
', '2020-11-07 23:40:58
'),
(1439, 0, 'en', 'frontend', 'f_35', 'Explore', '
2020-05-16 01:02:36
', '2020-11-07 23:40:58
'),
(1440, 0, 'en', 'frontend', 'f_36', 'Contact Us', '
2020-05-16 01:02:36
', '2020-11-07 23:40:58
'),
(1441, 0, 'en', 'frontend', 'f_37', 'Privacy Policy', '
2020-05-16 01:02:36
', '2020-11-07 23:40:58
'),
(1442, 0, 'en', 'frontend', 'f_38', 'Terms & Condition', '
2020-05-16 01:02:36
', '2020-11-07 23:40:58
'),
(1443, 0, 'en', 'frontend', 'f_39', 'Contact', '
2020-05-16 01:02:36
', '2020-11-07 23:40:58
'),
(1444, 0, 'en', 'frontend', 'f_40', 'Copyright 2020 Cheetah', '
2020-05-16 01:02:36
', '2020-11-07 23:40:58
'),
(1445, 0, 'en', 'frontend', 'f_41', 'Email Us', '
2020-05-16 01:04:04
', '2020-11-07 23:40:58
'),
(1447, 0, 'en', 'frontend', 'f_43', 'Login', '
2020-05-16 01:17:07
', '2020-11-07 23:40:58
'),
(1448, 0, 'en', 'frontend', 'f_44', 'Registration', '
2020-05-16 01:17:07
', '2020-11-07 23:40:58
'),
(1449, 0, 'en', 'frontend', 'f_45', 'Register', '
2020-05-16 01:17:07
', '2020-11-07 23:40:58
'),
(1450, 0, 'en', 'frontend', 'f_46', 'Provider Login/Registration', '
2020-05-16 01:17:07
', '2020-11-07 23:40:58
'),
(1451, 0, 'en', 'frontend', 'f_47', 'I accept terms & conditions', '
2020-05-16 01:17:07
', '2020-11-07 23:40:58
'),
(1452, 0, 'en', 'user', 'service_type', 'Service Type', '
2020-05-19 01:18:07
', '2021-03-02 05:18:55
'),
(1453, 0, 'en', 'user', 'distance', 'Distance', '
2020-05-19 01:19:22
', '2021-03-02 05:18:55
'),
(1454, 0, 'en', 'user', 'price', 'Price', '
2020-05-19 01:19:22
', '2021-03-02 05:18:55
'),
(1455, 0, 'en', 'user', 'tax_charges', 'Tax Charges', '
2020-05-19 01:19:22
', '2021-03-02 05:18:55
'),
(1456, 0, 'en', 'user', 'total', 'Total', '
2020-05-19 01:19:22
', '2021-03-02 05:18:55
'),
(1460, 0, 'en', 'user', 'no_available', 'Not Available', '
2020-05-21 03:37:38
', '2021-03-02 05:18:55
'),
(1458, 0, 'en', 'user', 'no_history_available', 'Not Available', '
2020-05-21 03:32:07
', '2021-03-02 05:18:55
'),
(1459, 0, 'en', 'user', 'Coupons', 'Coupons', '
2020-05-21 03:35:58
', '2021-03-02 05:18:55
'),
(1463, 0, 'en', 'user', 'return_again', 'I want to return again', '
2020-05-21 03:55:27
', '2021-03-02 05:18:55
'),
(1464, 0, 'en', 'user', 'Where_are_you_going', 'Where are you going ?', '
2020-05-24 02:11:14
', '2021-03-02 05:18:55
'),
(1465, 0, 'en', 'user', 'Economy', 'Transportation', '
2020-05-24 02:11:14
', '2021-03-02 05:18:55
'),
(1466, 0, 'en', 'user', 'Luxury', 'Delivery', '
2020-05-24 02:11:14
', '2021-03-02 05:18:55
'),
(1467, 0, 'en', 'user', 'Extra_Seat', 'Truck', '
2020-05-24 02:11:14
', '2021-03-02 05:18:55
'),
(1468, 0, 'en', 'user', 'Outstation', 'Kids Pickup', '
2020-05-24 02:11:14
', '2021-03-02 05:18:55
'),
(1469, 0, 'en', 'user', 'Continue', 'Continue', '
2020-05-24 02:11:14
', '2021-03-02 05:18:55
'),
(1470, 0, 'en', 'user', 'surge_extra', 'Note : Due to High Demand the fare may vary!', '
2020-05-24 02:30:55
', '2021-03-02 05:18:55
'),
(1471, 0, 'en', 'user', 'Schedule_a_ride', 'Schedule a Trip', '
2020-05-24 02:32:21
', '2021-03-02 05:18:55
'),
(1472, 0, 'en', 'user', 'Schedule_trip', 'Schedule Trip', '
2020-05-24 02:32:21
', '2021-03-02 05:18:55
'),
(1473, 0, 'en', 'frontend', 'f_48', 'Email Us', '
2020-05-24 02:37:29
', '2020-11-07 23:40:58
'),
(1474, 0, 'en', 'frontend', 'f_49', 'Home', '
2020-05-24 02:39:06
', '2020-11-07 23:40:58
'),
(1475, 0, 'en', 'frontend', 'f_50', 'Ride Now', '
2020-05-24 02:39:06
', '2020-11-07 23:40:58
'),
(1476, 0, 'en', 'frontend', 'f_51', 'Drive', '
2020-05-24 02:39:06
', '2020-11-07 23:40:58
'),
(1477, 0, 'en', 'frontend', 'f_52', 'Contact Us', '
2020-05-24 02:39:06
', '2020-11-07 23:40:58
'),
(1478, 0, 'en', 'frontend', 'f_53', NULL, '
2020-05-24 02:39:06
', '2020-05-24 02:39:06
'),
(1479, 0, 'en', 'frontend', 'f_54', NULL, '
2020-05-24 02:39:06
', '2020-05-24 02:39:06
'),
(1480, 0, 'en', 'frontend', 'f_55', NULL, '
2020-05-24 02:39:06
', '2020-05-24 02:39:06
'),
(1481, 0, 'en', 'user', 'my_profile', 'My Profile', '
2020-05-24 02:42:25
', '2021-03-02 05:18:55
'),
(1482, 0, 'en', 'user', 'history', 'History', '
2020-05-24 02:43:07
', '2021-03-02 05:18:55
'),
(1483, 0, 'en', 'user', 'Promocode', 'Promocode', '
2020-05-24 02:45:56
', '2021-03-02 05:18:55
'),
(1484, 0, 'en', 'user', 'ride.driver_info', 'Driver Info', '
2020-05-24 03:28:19
', '2021-03-02 05:18:55
'),
(1485, 0, 'en', 'user', 'distance_travelled', 'Distance Travelled', '
2020-05-24 04:34:09
', '2021-03-02 05:18:55
'),
(1486, 0, 'en', 'user', 'time_taken', 'Time Taken', '
2020-05-24 04:34:09
', '2021-03-02 05:18:55
'),
(1487, 0, 'en', 'user', 'waiting_charges', 'Waiting charges', '
2020-05-24 04:34:09
', '2021-03-02 05:18:55
'),
(1488, 0, 'en', 'user', 'discount_applied', 'Discount Applied', '
2020-05-24 04:34:09
', '2021-03-02 05:18:55
'),
(1489, 0, 'en', 'user', 'tax_applied', 'Tax Applied', '
2020-05-24 04:34:09
', '2021-03-02 05:18:55
'),
(1490, 0, 'en', 'user', 'wallet_deduction', 'Wallet Detection', '
2020-05-24 04:34:09
', '2021-03-02 05:18:55
'),
(1491, 0, 'en', 'admin', 'remember_me', 'Remember Me', '
2020-05-28 21:16:34
', '2020-05-29 09:45:19
'),
(1492, 0, 'en', 'admin', 'sign_in', 'Sign In', '
2020-05-28 21:16:34
', '2020-05-29 09:45:19
'),
(1493, 0, 'en', 'admin', 'account_login', 'Accountant Panel Login', '
2020-05-28 21:16:34
', '2020-05-29 09:45:19
'),
(1494, 0, 'en', 'admin', 'vendor_login', 'Vendor Panel Login', '
2020-05-28 21:16:34
', '2020-05-29 09:45:19
'),
(1495, 0, 'en', 'admin', 'dispatcher_login', 'Dispatcher Panel Login', '
2020-05-28 21:16:34
', '2020-05-29 09:45:19
'),
(1496, 0, 'en', 'admin', 'or', 'OR', '
2020-05-28 21:16:34
', '2020-05-29 09:45:19
'),
(1497, 0, 'en', 'dashboard', 'Services', 'Services', '
2020-05-28 21:16:34
', '2020-10-18 00:44:47
'),
(1498, 0, 'en', 'dashboard', 'Total_Fleets', 'Total Fleets', '
2020-05-28 21:16:34
', '2020-10-18 00:44:47
'),
(1499, 0, 'en', 'dashboard', 'Total_User', 'Total User', '
2020-05-28 21:16:34
', '2020-10-18 00:44:47
'),
(1500, 0, 'en', 'dashboard', 'Total_Providers', 'Total Providers', '
2020-05-28 21:16:34
', '2020-10-18 00:44:47
'),
(1501, 0, 'en', 'dashboard', 'Total_Bookings', 'Total Bookings', '
2020-05-28 21:16:34
', '2020-10-18 00:44:47
'),
(1502, 0, 'en', 'dashboard', 'Scheduled_Bookings', 'Scheduled_Bookings', '
2020-05-28 21:16:34
', '2020-10-18 00:44:47
'),
(1503, 0, 'en', 'dashboard', 'Provider_Cancelled', 'Provider Cancelled', '
2020-05-28 21:16:34
', '2020-10-18 00:44:47
'),
(1504, 0, 'en', 'dashboard', 'User_Cancelled', 'User Cancelled', '
2020-05-28 21:16:34
', '2020-10-18 00:44:47
'),
(1505, 0, 'en', 'dashboard', 'Total_Revenue', 'Total Revenue', '
2020-05-28 21:16:34
', '2020-10-18 00:44:47
'),
(1506, 0, 'en', 'dashboard', 'Cash_Payments', 'Cash Payments', '
2020-05-28 21:16:34
', '2020-10-18 00:44:47
'),
(1507, 0, 'en', 'dashboard', 'Online_Payments', 'Online Payments', '
2020-05-28 21:16:34
', '2020-10-18 00:44:47
'),
(1508, 0, 'en', 'dashboard', 'Recent_Rides', 'Recent Rides', '
2020-05-28 21:16:34
', '2020-10-18 00:44:47
'),
(1509, 0, 'en', 'dashboard', 'ID', 'ID', '
2020-05-28 21:16:34
', '2020-10-18 00:44:47
'),
(1510, 0, 'en', 'dashboard', 'User', 'User', '
2020-05-28 21:16:34
', '2020-10-18 00:44:47
'),
(1511, 0, 'en', 'dashboard', 'Ride_Detail', 'Ride Details', '
2020-05-28 21:16:34
', '2020-10-18 00:44:47
'),
(1512, 0, 'en', 'dashboard', 'Date', 'Date', '
2020-05-28 21:16:34
', '2020-10-18 00:44:47
'),
(1513, 0, 'en', 'dashboard', 'Time', 'Time', '
2020-05-28 21:16:34
', '2020-10-18 00:44:47
'),
(1514, 0, 'en', 'dashboard', 'Status', 'Status', '
2020-05-28 21:16:34
', '2020-10-18 00:44:47
'),
(1515, 0, 'en', 'dashboard', 'No_Details_Found', 'No Details Found', '
2020-05-28 21:16:34
', '2020-10-18 00:44:47
'),
(1516, 0, 'en', 'dashboard', 's_p_t_u_a', 'Send Push Notification To User Application', '
2020-05-28 21:16:34
', '2020-10-18 00:44:47
'),
(1517, 0, 'en', 'dashboard', 'Title', 'Title', '
2020-05-28 21:16:34
', '2020-10-18 00:44:47
'),
(1518, 0, 'en', 'dashboard', 'Message', 'Message', '
2020-05-28 21:16:34
', '2020-10-18 00:44:47
'),
(1519, 0, 'en', 'dashboard', 'Send', 'Send', '
2020-05-28 21:16:34
', '2020-10-18 00:44:47
'),
(1520, 0, 'en', 'dashboard', 's_p_t_d_a', 'Send Push Notification To Driver Application', '
2020-05-28 21:16:34
', '2020-10-18 00:44:47
'),
(1521, 0, 'en', 'frontend', 'HE', NULL, '
2020-06-28 22:01:51
', '2020-06-28 22:01:51
'),
(1522, 0, 'es', 'user', 'add_money', 'agregar saldo', '
2020-07-28 04:36:00
', '2021-03-02 05:18:55
'),
(1523, 0, 'es', 'user', 'price', 'precio', '
2020-07-28 04:37:24
', '2021-03-02 05:18:55
'),
(1524, 0, 'es', 'validation', 'accepted', 'aceptar', '
2020-07-28 04:45:29
', '2020-07-28 04:45:36
'),
(1525, 0, 'es', 'user', 'Promocode', 'PromoCodigo', '
2020-07-28 04:49:38
', '2021-03-02 05:18:55
'),
(1526, 0, 'es', 'user', 'promotion', 'Promocion', '
2020-07-28 04:49:54
', '2021-03-02 05:18:55
'),
(1527, 0, 'es', 'user', 'add_promocode', 'Ingresa PromoCodigo', '
2020-07-28 04:50:39
', '2021-03-02 05:18:55
'),
(1528, 0, 'es', 'user', 'history', 'Historial', '
2020-07-28 04:51:23
', '2021-03-02 05:18:55
'),
(1530, 1, 'en', 'admin', 'Total', 'Total', '
2020-10-18 00:44:11
', '2020-10-18 00:44:21
'),
(1531, 0, 'en', 'dashboard', 'Total', 'Total', '
2020-10-18 00:44:40
', '2020-10-18 00:44:47
'),
(1532, 0, 'hi', 'user', 'waiting_charges', 'Waiting charges', '
2020-10-23 23:57:16
', '2021-03-02 05:18:55
'),
(1533, 0, 'hi', 'user', 'total', 'Total', '
2020-10-23 23:57:39
', '2021-03-02 05:18:55
'),
(1534, 0, 'hi', 'user', 'time_taken', 'Time Taken', '
2020-10-23 23:57:50
', '2021-03-02 05:18:55
'),
(1535, 0, 'hi', 'user', 'tax_charges', 'Tax Charges', '
2020-10-23 23:58:03
', '2021-03-02 05:18:55
'),
(1536, 0, 'hi', 'user', 'tax_applied', 'Tax Applied', '
2020-10-23 23:58:17
', '2021-03-02 05:18:55
'),
(1537, 0, 'hi', 'user', 'surge_extra', 'Note : Due to High Demand the fare may vary!', '
2020-10-23 23:58:28
', '2021-03-02 05:18:55
'),
(1538, 0, 'hi', 'user', 'service_type', 'Service Type', '
2020-10-23 23:58:45
', '2021-03-02 05:18:55
'),
(1539, 0, 'hi', 'user', 'Schedule_trip', 'Schedule Trip', '
2020-10-23 23:58:55
', '2021-03-02 05:18:55
'),
(1540, 0, 'hi', 'user', 'Schedule_a_ride', 'Schedule a Trip', '
2020-10-23 23:59:06
', '2021-03-02 05:18:55
'),
(1541, 0, 'hi', 'user', 'ride.driver_info', 'Driver Info', '
2020-10-23 23:59:24
', '2021-03-02 05:18:55
'),
(1542, 0, 'hi', 'user', 'return_again', 'I want to return again', '
2020-10-23 23:59:35
', '2021-03-02 05:18:55
'),
(1543, 0, 'hi', 'user', 'Promocode', 'Promocode', '
2020-10-23 23:59:47
', '2021-03-02 05:18:55
'),
(1544, 0, 'hi', 'user', 'price', 'Price', '
2020-10-23 23:59:55
', '2021-03-02 05:18:55
'),
(1545, 0, 'hi', 'user', 'Outstation', 'Kids Pickup', '
2020-10-24 00:00:21
', '2021-03-02 05:18:55
'),
(1546, 0, 'hi', 'api', 'ride.ride_cancelled', 'Ride Cancelled', '
2020-10-24 01:11:35
', '2021-03-05 05:30:40
'),
(1547, 0, 'hi', 'user', 'Extra_Seat', 'Truck', '
2020-11-30 22:42:47
', '2021-03-02 05:18:55
');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_04_02_193005_create_translations_table', 1),
(2, '2014_10_12_000000_create_users_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2015_08_25_172600_create_settings_table', 1),
(5, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(6, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(7, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(8, '2016_06_01_000004_create_oauth_clients_table', 1),
(9, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(10, '2017_01_11_180503_create_admins_table', 1),
(11, '2017_01_11_180511_create_providers_table', 1),
(12, '2017_01_11_181312_create_cards_table', 1),
(13, '2017_01_11_181357_create_chats_table', 1),
(14, '2017_01_11_181558_create_promocodes_table', 1),
(15, '2017_01_11_182454_create_provider_documents_table', 1),
(16, '2017_01_11_182536_create_provider_services_table', 1),
(17, '2017_01_11_182649_create_user_requests_table', 1),
(18, '2017_01_11_182717_create_request_filters_table', 1),
(19, '2017_01_11_182738_create_service_types_table', 1),
(20, '2017_01_25_172422_create_documents_table', 1),
(21, '2017_01_31_122021_create_provider_devices_table', 1),
(22, '2017_02_02_192703_create_user_request_ratings_table', 1),
(23, '2017_02_06_080124_create_user_request_payments_table', 1),
(24, '2017_02_14_135859_create_provider_profiles_table', 1),
(25, '2017_02_21_131429_create_promocode_usages_table', 1),
(26, '2017_06_07_045207_add_social_login_to_providers_tables', 1),
(27, '2017_06_17_151030_create_dispatchers_table', 1),
(28, '2017_06_17_151031_create_dispatcher_password_resets_table', 1),
(29, '2017_06_17_151145_create_fleets_table', 1),
(30, '2017_06_17_151146_create_fleet_password_resets_table', 1),
(31, '2017_06_17_151150_add_fleet_to_providers_table', 1),
(32, '2017_06_19_130022_add_booking_id_to_user_request', 1),
(33, '2017_06_19_155736_add_cancel_reason_to_user_request', 1),
(34, '2017_06_20_154148_create_accounts_table', 1),
(35, '2017_06_20_154149_create_account_password_resets_table', 1),
(36, '2017_08_03_194354_create_custom_pushes_table', 1),
(37, '2017_09_01_190333_create_wallet_passbooks_table', 1),
(38, '2017_09_01_190355_create_promocode_passbooks_table', 1),
(39, '2017_09_15_145235_add_travel_tracking_distance_to_user_requests_table', 1),
(40, '2017_09_15_152718_add_provider_payments_to_user_request_payments_table', 1),
(41, '2017_09_19_104042_add_genders_to_providers_table', 1),
(42, '2017_09_19_104042_add_genders_to_users_table', 1),
(43, '2017_09_26_144027_add_travel_time_to_user_requests_table', 1),
(44, '2017_09_26_160101_create_favourite_locations_table', 1),
(45, '2021_11_27_214822_create_payment_services_table', 2),
(46, '2021_11_27_214943_create_payment_histories_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int DEFAULT NULL,
  `client_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `scopes` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('476bab65e024e810429936c9cbde9b51ad400105d4ebc10408fe7cad52827d402c9b978df9951648', 273, 12, NULL, '[]', 0, '
2021-12-09 00:02:18
', '2021-12-09 00:02:18
', '2021-12-24 00:02:18
'),
('aa2e924f57b8255232f46aaeb5716f10e59ab5c2c40616206bfc14867c3745d59acc7d1e48d389ac', 168, 12, NULL, '[]', 0, '
2021-12-08 23:15:29
', '2021-12-08 23:15:29
', '2021-12-23 23:15:29
'),
('2506bb378a0c427e2fd18fdc4fcf68ca7d1fba2c0ae507de189654420d5fa0add766418a9d9c37d1', 277, 12, NULL, '[]', 0, '
2021-12-08 18:07:25
', '2021-12-08 18:07:25
', '2021-12-23 18:07:25
'),
('ebc62503011ff21a69573111c3a31bf0ff5d6427d5963f979242102ef009adab75f02427231b340d', 277, 12, NULL, '[]', 0, '
2021-12-08 16:28:27
', '2021-12-08 16:28:27
', '2021-12-23 16:28:26
'),
('d187ee06d1b7b419db141094e220f6f5fd72d3ee6920f68e16d6494e5f48343ecdd27e257df69bed', 168, 12, NULL, '[]', 0, '
2021-12-08 13:18:21
', '2021-12-08 13:18:21
', '2021-12-23 13:18:21
'),
('8297e892c8f4152a4dc11d222718a6c170049d1819dad60cd23e8d0ad30c5478805b315023293fb1', 273, 12, NULL, '[]', 1, '
2021-12-08 09:06:06
', '2021-12-08 09:06:06
', '2021-12-23 09:06:06
'),
('3b9b46d3dd78ffe59d88f13ce2aa059b7aa16f768e0825eda2586cb35dde6cfa3ae65fcc3a4825b8', 273, 12, NULL, '[]', 0, '
2021-12-08 09:06:05
', '2021-12-08 09:06:05
', '2021-12-23 09:06:05
'),
('7bf6cea867895cf5f7dc9e21b6bf721a6ca5c50487022c289131ef23e95c17e075d729f96b810980', 273, 12, NULL, '[]', 1, '
2021-12-08 09:06:05
', '2021-12-08 09:06:05
', '2021-12-23 09:06:05
'),
('9d5a56cf86c7e079efac3a336902b8c575f96392a4ac51a154ead7816eb4dd3bcc11bfa0799192af', 276, 12, NULL, '[]', 0, '
2021-12-08 08:54:19
', '2021-12-08 08:54:19
', '2021-12-23 08:54:19
'),
('1dff0a8d812eeaa494391b11a84d651684a40d17c1cab2cb7513111a91733661e1c8ac219ec9d508', 275, 12, NULL, '[]', 0, '
2021-12-08 08:50:32
', '2021-12-08 08:50:32
', '2021-12-23 08:50:32
'),
('1ab24a1b91300d6da2e63d9ae6419c2e3e61808da10a2289b4f222cd4513bee18e5088505df6790d', 274, 12, NULL, '[]', 0, '
2021-12-08 08:43:28
', '2021-12-08 08:43:28
', '2021-12-23 08:43:28
'),
('fc5972b2b9429ea6336dfd94a3619ae11fa38fb9ed4cf0ad07309af19a3a6a56e3ce1244368d042e', 273, 12, NULL, '[]', 0, '
2021-12-08 08:25:40
', '2021-12-08 08:25:40
', '2021-12-23 08:25:40
'),
('b1155d408ee3ce29aa1fcfdde641f3c6351f3c4ef0a11ff9c0e76919a220238ad526dc725108a035', 266, 12, NULL, '[]', 0, '
2021-12-07 22:06:57
', '2021-12-07 22:06:57
', '2021-12-22 22:06:56
'),
('7582a81464387eb1c103214b6eba96e177f86495d1a3491f2dd437eb1451ab9dcacd7e55e7690bb7', 168, 12, NULL, '[]', 0, '
2021-12-07 21:57:19
', '2021-12-07 21:57:19
', '2021-12-22 21:57:19
'),
('e02b236ecea88fcc5857c0290fa7d8a535c9d387fed6ddf3b155342444f6502bbb6c003acc86dae0', 168, 12, NULL, '[]', 0, '
2021-12-07 20:46:10
', '2021-12-07 20:46:10
', '2021-12-22 20:46:10
'),
('830db03342690cc68b1b598986f1fd36a033ddcc1072226e82b7c5aa8dcbcae3b75b71da910a65f1', 255, 12, NULL, '[]', 0, '
2021-12-09 00:35:53
', '2021-12-09 00:35:53
', '2021-12-24 00:35:52
'),
('f2eb48f51d471b179cd87508910b726efdf8f33b0e95c3a7b74e6fb5fc5cda4aa7cb9a0aa0c0efb0', 255, 12, NULL, '[]', 1, '
2021-12-09 00:35:53
', '2021-12-09 00:35:53
', '2021-12-24 00:35:53
'),
('70d46da1244efc948c868a69a8d97a6330a6a1795bd5a5bc55dd46162e9838476891dbddf3f15270', 255, 12, NULL, '[]', 1, '
2021-12-09 00:35:58
', '2021-12-09 00:35:58
', '2021-12-24 00:35:57
'),
('3d8029f1b9ade94beda9ade2ae09381cb3851cf98dd4c53f1d3255b8594fc59270ab52ce774bd715', 255, 12, NULL, '[]', 0, '
2021-12-09 00:36:03
', '2021-12-09 00:36:03
', '2021-12-24 00:36:03
'),
('1eb02aa08085927d4fabf952d053d77e0a552b567b46815ed2ac15641e78a8c3ef26bec4ac46b5dc', 277, 12, NULL, '[]', 0, '
2021-12-09 00:40:46
', '2021-12-09 00:40:46
', '2021-12-24 00:40:46
'),
('c6041fb1cc3ec42069b2aae1925337d3fae38bf33b9d45ec4d9cb873a58f64c8a70d224c9d33a293', 168, 12, NULL, '[]', 0, '
2021-12-09 00:42:54
', '2021-12-09 00:42:54
', '2021-12-24 00:42:54
'),
('5f1bc3ebeec84eb1def3f71ca7551d9e585d954b79679d926db6a20ab9a3a4c43a3abf4ba19c1cc1', 279, 12, NULL, '[]', 0, '
2021-12-09 01:40:19
', '2021-12-09 01:40:19
', '2021-12-24 01:40:19
'),
('c832d7b7644086576b4564a7f7d1708b9c12790551041f9795bee29c65459265575882571b5cb3ff', 273, 12, NULL, '[]', 0, '
2021-12-09 02:34:28
', '2021-12-09 02:34:28
', '2021-12-24 02:34:28
'),
('f3fa8960e68d010c767bf9e52dfb6cdc5b3441553b6164e03635da70fa2b14c54a2c08b10a757ebd', 168, 12, NULL, '[]', 0, '
2021-12-09 02:51:29
', '2021-12-09 02:51:29
', '2021-12-24 02:51:29
'),
('c9657b49aa3b145e245ef447f444fe4308f46007b9ef9802c39f80abfeeb4ed129b6f4fd99fef4d0', 273, 12, NULL, '[]', 0, '
2021-12-09 02:54:25
', '2021-12-09 02:54:25
', '2021-12-24 02:54:25
'),
('2e5a9ae15e04ce550eba564da33ecb0fba08a5c54f4ed1e39451e4e84591ff90a371cd67802dc72f', 263, 12, NULL, '[]', 1, '
2021-12-09 07:16:18
', '2021-12-09 07:16:18
', '2021-12-24 07:16:18
'),
('b4f0ed615aa4df62f8ea60bf66172955a25f0c07568f922e1b34f5dc97f7a19511cc0b7416a97d8f', 263, 12, NULL, '[]', 0, '
2021-12-09 07:16:19
', '2021-12-09 07:16:19
', '2021-12-24 07:16:19
'),
('94eb881884b7d8129d5c8a134f4218187f30682cd1079c764cb28a569092c26fa21ac149b30e052e', 263, 12, NULL, '[]', 0, '
2021-12-09 07:16:20
', '2021-12-09 07:16:20
', '2021-12-24 07:16:20
'),
('9b29a1c2f82d3d231aa7bc0b7c94db29df95a6578f7eb9e74c4530b25d73339ac6fa23105503373c', 168, 12, NULL, '[]', 0, '
2021-12-09 13:20:37
', '2021-12-09 13:20:37
', '2021-12-24 13:20:37
'),
('ea46b74b81a26d6a57f480cf5339522a2e7d96e19df3a5d4d6adcd68ffbd876f1b3c1b2499bc9980', 168, 12, NULL, '[]', 0, '
2021-12-09 14:05:27
', '2021-12-09 14:05:27
', '2021-12-24 14:05:27
'),
('0afa9ed9d48c4a2f84b0409dc2feb58d97ce610f8aef1d1f78d3e2d396a0381dfec630289d4c51b4', 273, 12, NULL, '[]', 0, '
2021-12-09 20:34:39
', '2021-12-09 20:34:39
', '2021-12-24 20:34:39
'),
('d905ab6689bfe3095f216698438ac5f2b939de53f846eaab9cac016297cfeb6445915d2a728de06c', 280, 12, NULL, '[]', 0, '
2021-12-10 16:25:37
', '2021-12-10 16:25:37
', '2021-12-25 16:25:37
'),
('c3024891f02bd7c481651bc58a0d3f3076698c546b7b967f2746bf26b3c72b99ad6672613f21ef4c', 269, 12, NULL, '[]', 1, '
2021-12-10 19:07:27
', '2021-12-10 19:07:27
', '2021-12-25 19:07:27
'),
('e474b8017c78186959df0f379240cbc79edc790d6b1da7c2aa9c59617b4b84b3ebf686eaf8c92125', 269, 12, NULL, '[]', 0, '
2021-12-10 19:07:28
', '2021-12-10 19:07:28
', '2021-12-25 19:07:28
'),
('57061d15fc5a5d8f2b6b03e53b6092a9e78148d56872b21f12399df05b1b59f12bbdf124acf391e5', 269, 12, NULL, '[]', 0, '
2021-12-10 19:07:30
', '2021-12-10 19:07:30
', '2021-12-25 19:07:30
'),
('16b7f634440d55cc61b07199a30b5776a29dc4dfdc60a4a9d80dbb88697e2dbb23ca719dc543045a', 273, 12, NULL, '[]', 0, '
2021-12-11 06:05:36
', '2021-12-11 06:05:36
', '2021-12-26 06:05:36
'),
('18a2107348ccc1cd2d9d3ff3cf3669f6033789912b633246cdef659a7b76d9412bdf7f7250b442de', 281, 12, NULL, '[]', 0, '
2021-12-11 10:46:10
', '2021-12-11 10:46:10
', '2021-12-26 10:46:10
'),
('038e0ea5ba9b9800a2152df1f635468734f2d96521f9fa2303dc46047f94d8c939e59c08d9c5495b', 170, 12, NULL, '[]', 1, '
2021-12-11 11:57:33
', '2021-12-11 11:57:33
', '2021-12-26 11:57:33
'),
('365badb3563a6954e9dd52c919fc00d92d5240a0b96c48c8f6103a9af3f478ec1b36968209857c8e', 170, 12, NULL, '[]', 0, '
2021-12-11 11:57:34
', '2021-12-11 11:57:34
', '2021-12-26 11:57:34
'),
('58076db3bea31746ff64e70386f91dd410a9a2e4c368a812f352d1100d85cd5ab7dd0a4381f2006c', 170, 12, NULL, '[]', 0, '
2021-12-11 11:57:35
', '2021-12-11 11:57:35
', '2021-12-26 11:57:35
'),
('444f4f84f295e868eba4976e1201f7afb6858f8a6ffadb092c035ccc746c7e22accbc135a101a16c', 282, 12, NULL, '[]', 0, '
2021-12-11 14:15:23
', '2021-12-11 14:15:23
', '2021-12-26 14:15:23
'),
('31745f852ef9a0f344a7baec911c45958385ab5b444e82afedcdd88a84dba9254eaf80e200395a77', 168, 12, NULL, '[]', 0, '
2021-12-11 14:46:21
', '2021-12-11 14:46:21
', '2021-12-26 14:46:20
'),
('8c60b2a20090718dd16fb664f1f8dbfd3128cf51dc9be7264d2d20b7f8dcc784a2c4707c8eee158f', 168, 12, NULL, '[]', 0, '
2021-12-11 15:37:33
', '2021-12-11 15:37:33
', '2021-12-26 15:37:33
'),
('998d21a1e5076046472a4d2750b8db55740393f4a08e0d5873e6f7627123f67fc41a2c42833ab582', 283, 12, NULL, '[]', 0, '
2021-12-11 16:49:02
', '2021-12-11 16:49:02
', '2021-12-26 16:49:02
'),
('f35e1b61ab74851f47c37fdea9f150de54670d9e6c874d6c446e2adff6ee1f70bdda89f7d0d27255', 168, 12, NULL, '[]', 0, '
2021-12-11 16:53:05
', '2021-12-11 16:53:05
', '2021-12-26 16:53:05
'),
('948657573ee5a7e5789289d66b7618193d08bd6e59132fa30d8333b8ccb06612ed4704a28652cdb8', 273, 12, NULL, '[]', 0, '
2021-12-11 17:13:43
', '2021-12-11 17:13:43
', '2021-12-26 17:13:43
'),
('e37efc42019c3b044e727c97f8a30c0130338bddada5139a192b7a68493f2118a81925a53ec56ff2', 168, 12, NULL, '[]', 0, '
2021-12-11 19:14:41
', '2021-12-11 19:14:41
', '2021-12-26 19:14:41
'),
('effc3be0dabcf6ce9f3492038bc92928d2ee97a702b34484df6f1274b8e46de3efca3585424225a1', 168, 12, NULL, '[]', 0, '
2021-12-11 19:46:22
', '2021-12-11 19:46:22
', '2021-12-26 19:46:22
'),
('83019217fe2f29a806fd2bd6a125a3334f2ffcbd09120c1e9b717a3671bfb7880915c1e811f35656', 284, 12, NULL, '[]', 0, '
2021-12-11 20:16:54
', '2021-12-11 20:16:54
', '2021-12-26 20:16:54
'),
('f58be4a43f274154c3c09431158f75721cdfaf0f0cd9c217bd479c33dc47cad9637ee8c280ce2083', 168, 12, NULL, '[]', 0, '
2021-12-11 20:23:00
', '2021-12-11 20:23:00
', '2021-12-26 20:23:00
'),
('cd854e71f0fcde61c95be1b77bc614966e10877c777a7fe29d918b9ff744ed086cadc63b5d3ea891', 168, 12, NULL, '[]', 0, '
2021-12-11 20:54:29
', '2021-12-11 20:54:29
', '2021-12-26 20:54:29
'),
('11a47ff6bf9723ca8f4788050ed369e9ab6d94cf34004c74b7b059723b9e9dc3699b8063736b16d9', 273, 12, NULL, '[]', 0, '
2021-12-11 20:57:02
', '2021-12-11 20:57:02
', '2021-12-26 20:57:02
'),
('4956532202b3fa0903513ecea9ca422dea555a494e6109e5761482e255099c5e939c093125fc3bf6', 285, 12, NULL, '[]', 1, '
2021-12-12 07:17:30
', '2021-12-12 07:17:30
', '2021-12-27 07:17:30
'),
('a5d249abbe6a097658a3ce2260994551c08250ef06b615f3f87767ed04c878f4fd2afe382769a3a7', 284, 12, NULL, '[]', 0, '
2021-12-12 07:52:26
', '2021-12-12 07:52:26
', '2021-12-27 07:52:26
'),
('5bd93dba764b36aa48378e038aef036c28f9369768175856cd8b1da0fa7226c25db6a00e2b8b8a18', 286, 12, NULL, '[]', 0, '
2021-12-12 12:24:36
', '2021-12-12 12:24:36
', '2021-12-27 12:24:36
'),
('d73333418af62e0e46cbd961f55449472b163c14ae89b901550d2c4c0c0209afc80cd927a1f34715', 286, 12, NULL, '[]', 0, '
2021-12-12 12:37:48
', '2021-12-12 12:37:48
', '2021-12-27 12:37:48
'),
('2ed2dc7049f50d77356e0492350fb04b19c0c698f3f444362e0c587de4e7ea1a40575d31ad1a5ee1', 287, 12, NULL, '[]', 0, '
2021-12-12 12:57:25
', '2021-12-12 12:57:25
', '2021-12-27 12:57:25
'),
('5e54f4db318dde146b19b794bedb70ded35b4218c7daf2132796c899b07456215048b712c7a64d70', 288, 12, NULL, '[]', 1, '
2021-12-12 13:25:20
', '2021-12-12 13:25:20
', '2021-12-27 13:25:20
'),
('ecf7e77b8fe5f3d512710e6db91f6c7f83680638ce13b5128f7d4de0799e7659a629b994328f8d50', 289, 12, NULL, '[]', 0, '
2021-12-12 16:07:32
', '2021-12-12 16:07:32
', '2021-12-27 16:07:32
'),
('9e80b723b48d3a4b4c37a72dbfcdaf2ea399ff54a8bc7877e7dc514660fd8524c54755983c1ad78c', 289, 12, NULL, '[]', 0, '
2021-12-12 17:37:07
', '2021-12-12 17:37:07
', '2021-12-27 17:37:06
'),
('9b29b5ae5e2845b273e83c639e4dced2a56d9a6848246e23d9021f6f5aeadde65d1660473daa4ca6', 288, 12, NULL, '[]', 1, '
2021-12-12 18:27:45
', '2021-12-12 18:27:45
', '2021-12-27 18:27:45
'),
('75563eb23529985cc1e26019cb353308c6aecfbf7b4be63340f453631c893ec2c4cf5ca07d4c29c4', 288, 12, NULL, '[]', 0, '
2021-12-12 18:27:49
', '2021-12-12 18:27:49
', '2021-12-27 18:27:49
'),
('98aad1c5d2815e4ff4ea1a29300068baddf063e54de863b1cf410b797b0954227b412e9f19a5c4c1', 291, 12, NULL, '[]', 0, '
2021-12-12 18:30:06
', '2021-12-12 18:30:06
', '2021-12-27 18:30:06
'),
('7066d0d78f65698fb4cc3da8393e8da434b090ab8c1bd7f58ed2ad4c29e096dda269285fc3c0be0b', 290, 12, NULL, '[]', 0, '
2021-12-12 19:16:23
', '2021-12-12 19:16:23
', '2021-12-27 19:16:23
'),
('924980f9d7155e89fc62a16b7714675b7597de0cdc23639b4c1a450fb923bdddfca2b5e0e9e549b6', 285, 12, NULL, '[]', 1, '
2021-12-12 20:18:12
', '2021-12-12 20:18:12
', '2021-12-27 20:18:12
'),
('9e5263c7ed4212020f2254d482c8e2b0f7c1512824e57fe54d33dccb9f9b950f3f8ad4999857d8eb', 285, 12, NULL, '[]', 0, '
2021-12-12 20:18:15
', '2021-12-12 20:18:15
', '2021-12-27 20:18:15
'),
('1c741b28bd9561d8d4549eef943aa3010d07cd85c3d13d4f403ea536132a35513cf69dc606dc6f5f', 273, 12, NULL, '[]', 1, '
2021-12-12 22:01:07
', '2021-12-12 22:01:07
', '2021-12-27 22:01:07
'),
('08c81fd22aadc9606adcb54dbedcf765e0f57f73bbfc9278969c3840b3f6f7ad47b74319c658cfcb', 273, 12, NULL, '[]', 0, '
2021-12-12 22:01:11
', '2021-12-12 22:01:11
', '2021-12-27 22:01:11
'),
('2b986b4d7435a07c45f0b07976e60b4577f77a9a9f83a053096fe497a1e692bdeba6dc506700b32a', 292, 12, NULL, '[]', 0, '
2021-12-12 22:02:52
', '2021-12-12 22:02:52
', '2021-12-27 22:02:52
'),
('75e3e47918f113112c855a0c5efcb995888f732f223998531e7106dfe2ffeaa0b1bc7e5bc31dd3ae', 293, 12, NULL, '[]', 0, '
2021-12-13 00:56:25
', '2021-12-13 00:56:25
', '2021-12-28 00:56:25
'),
('b3fa9ad4d95f65563cdefd78137a7a959adec8cf4d4d11b4125e2d5011de7750e703b2b090e2f1b9', 243, 12, NULL, '[]', 0, '
2021-12-13 11:07:20
', '2021-12-13 11:07:20
', '2021-12-28 11:07:20
'),
('78b86df5dbe2fcd75f6c6e5daade2edeb4495c8a5117da2dfdb5174a35334936882b3b5c5d229ca9', 294, 12, NULL, '[]', 0, '
2021-12-13 12:35:16
', '2021-12-13 12:35:16
', '2021-12-28 12:35:16
'),
('b595dfdeef48dbe6ff76a72a593ea67f2fee8787a5091b0385834e6a66ed44ee143e2bfb45658ad0', 289, 12, NULL, '[]', 0, '
2021-12-13 20:51:28
', '2021-12-13 20:51:28
', '2021-12-28 20:51:28
'),
('0ea338a2dabf5a0921a250a443cde0613b5c6dcfbd6eeb38f929d5a5ca7089a99cd5d6a68c95c7fa', 289, 12, NULL, '[]', 0, '
2021-12-13 20:54:14
', '2021-12-13 20:54:14
', '2021-12-28 20:54:14
'),
('93d06aaf79f556080f9e6dbde987319ec7a2b3c6571a2d571f1d30da5a073e79e547ad3a20f79230', 289, 12, NULL, '[]', 0, '
2021-12-14 01:27:00
', '2021-12-14 01:27:00
', '2021-12-29 01:27:00
'),
('daee0560ce5928423737254f1abf045e7a138b35e85f57ecb95c7e83420e24f652dd59c7b57036bd', 291, 12, NULL, '[]', 0, '
2021-12-14 08:38:49
', '2021-12-14 08:38:49
', '2021-12-29 08:38:49
'),
('1d7cbb8e5d68565e42de2a5e66f9309fed7707c11d6216e951d455a187b4717e62cdbc62c8c3e239', 251, 12, NULL, '[]', 1, '
2021-12-14 14:11:02
', '2021-12-14 14:11:02
', '2021-12-29 14:11:02
'),
('cfc666ab94c8387a871168f6214521c4ad3a117511355e02fba45955ecdbcf1d7c27d96ec6d5edfa', 251, 12, NULL, '[]', 0, '
2021-12-14 14:11:03
', '2021-12-14 14:11:03
', '2021-12-29 14:11:03
'),
('34d8d30ac82e3d4ea2f249c7b1eae9609b25467389901bb5f64abe4534803105d4959260d22aeb84', 251, 12, NULL, '[]', 0, '
2021-12-14 14:11:04
', '2021-12-14 14:11:04
', '2021-12-29 14:11:04
'),
('b04be626cc207e0985fdee2198b793068cec1e728d656ad523793ccecab9ba111b4334fb1ad768bd', 295, 12, NULL, '[]', 0, '
2021-12-16 13:05:57
', '2021-12-16 13:05:57
', '2021-12-31 13:05:57
'),
('ec9bb6a36fa7cfe31b4151ad9acd411cfb418c2f2052978b1d1162a3e631a88793ec162c4dba3c4a', 296, 12, NULL, '[]', 0, '
2021-12-16 13:12:15
', '2021-12-16 13:12:15
', '2021-12-31 13:12:15
'),
('b02b78ea343af220aa52ec25a840bbb09a2303e937e65239519358732903d3eabd418d4f0f394b03', 297, 12, NULL, '[]', 0, '
2021-12-16 21:21:05
', '2021-12-16 21:21:05
', '2021-12-31 21:21:05
'),
('827dec378255969fb281d89d142eafd05585df185770f79f0550c9972eb667b1c4c84e95922c1f09', 262, 12, NULL, '[]', 0, '
2021-12-17 08:37:13
', '2021-12-17 08:37:13
', '2022-01-01 08:37:13
'),
('736d488f0b6f659dcac7acc04544744e26ff1f87ae632851f8cd69c2cf56c034647da921a205873c', 290, 12, NULL, '[]', 0, '
2021-12-17 15:48:41
', '2021-12-17 15:48:41
', '2022-01-01 15:48:41
'),
('36daf2502227bd82e40d96bbdb0c36076aaaba609887cb4fd357bab1a705cc663aa573ad3ce8e103', 290, 12, NULL, '[]', 0, '
2021-12-17 16:38:40
', '2021-12-17 16:38:40
', '2022-01-01 16:38:40
'),
('7b81ca2b7672777d0a630f4b81a21a937210e05a64401889552512dabb0805aa531fc7ae5e7da1d5', 290, 12, NULL, '[]', 0, '
2021-12-17 16:44:49
', '2021-12-17 16:44:49
', '2022-01-01 16:44:49
'),
('a009e11adca9d631d7bd65ee5993b4bc850ebb13205748c33b86e7cc8e19ae5743356d2eccbc7200', 298, 12, NULL, '[]', 0, '
2021-12-17 18:32:00
', '2021-12-17 18:32:00
', '2022-01-01 18:32:00
'),
('1336b3f6c459646d643814d69e352b1d8c278d4d9dcde0e24aa3f9b7dbef578c177f75d7d654e570', 300, 12, NULL, '[]', 0, '
2021-12-18 13:25:09
', '2021-12-18 13:25:09
', '2022-01-02 13:25:09
'),
('d068229fe25d266795fe30ce0d97c4f8fc51adf1499306634fa2c26a867f694321614800dd409745', 301, 12, NULL, '[]', 0, '
2021-12-18 14:51:03
', '2021-12-18 14:51:03
', '2022-01-02 14:51:03
'),
('ffdbc7bf57a75b86858468ef6fe83679b4b126ffb7f18f7183732c0335b0d6936a511dcc18622212', 289, 12, NULL, '[]', 0, '
2021-12-18 15:21:46
', '2021-12-18 15:21:46
', '2022-01-02 15:21:46
'),
('469b6e9656cc0ca096669a9c1f348efaf3ed0e2c3a8398d18fe1162b8b15331202bcf6c0619a99c4', 302, 12, NULL, '[]', 0, '
2021-12-18 19:44:27
', '2021-12-18 19:44:27
', '2022-01-02 19:44:27
'),
('015080f8e91b1b928b6bb679c0a285b15737e0b1bacc1f3745f3f7bb28272efb1463c84aeff42775', 303, 12, NULL, '[]', 0, '
2021-12-19 11:05:05
', '2021-12-19 11:05:05
', '2022-01-03 11:05:05
');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `client_id` int NOT NULL,
  `scopes` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `secret` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `redirect` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(11, NULL, 'TaxiTime Personal Access Client', 'u5PzqBmf6uE7VgNkj8Z8JmnEoIuM9gKeD1QcaAWB', 'https://app.cheetahrides.com/', 1, 0, 0, '
2020-05-19 08:51:09
', '2020-05-19 08:51:09
'),
(12, NULL, 'TaxiTime Password Grant Client', 'Vlpw7zY8wRTCxBBZtf0jEvSMaNa2WKYTpQBLub3f', 'https://app.cheetahrides.com/', 0, 1, 0, '
2020-05-19 08:51:09
', '2020-05-19 08:51:09
');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` int UNSIGNED NOT NULL,
  `client_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2019-10-04 10:08:04
', '2019-10-04 10:08:04
'),
(2, 3, '2019-12-11 14:13:55
', '2019-12-11 14:13:55
'),
(3, 5, '2020-02-18 12:03:56
', '2020-02-18 12:03:56
'),
(4, 7, '2020-05-19 08:36:11
', '2020-05-19 08:36:11
'),
(5, 9, '2020-05-19 08:47:24
', '2020-05-19 08:47:24
'),
(6, 11, '2020-05-19 08:51:09
', '2020-05-19 08:51:09
');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `access_token_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `oauth_refresh_tokens`
--

INSERT INTO `oauth_refresh_tokens` (`id`, `access_token_id`, `revoked`, `expires_at`) VALUES
('c7f5ec65e6234c18c504837043df74ccda7fb17c67758e8cf5a8691beec66d1abff30a1bc25765a8', '476bab65e024e810429936c9cbde9b51ad400105d4ebc10408fe7cad52827d402c9b978df9951648', 0, '
2022-03-09 00:02:18
'),
('eb7cdb546cd86db5a8dd4dd4a31ef070557c1712b305574b359c70da2fca0b5a19f9b673401bf9bc', 'aa2e924f57b8255232f46aaeb5716f10e59ab5c2c40616206bfc14867c3745d59acc7d1e48d389ac', 0, '
2022-03-08 23:15:29
'),
('36e2babd0a1ddeae415631c0cb21a668666d5b6084e22e78b0683972c10b9aee163775cd2e20c652', '2506bb378a0c427e2fd18fdc4fcf68ca7d1fba2c0ae507de189654420d5fa0add766418a9d9c37d1', 0, '
2022-03-08 18:07:25
'),
('29140058dcedd2fd5e7187ff612f0ed602000df32e96bc31e07080fe441160832db7b16464652e73', 'ebc62503011ff21a69573111c3a31bf0ff5d6427d5963f979242102ef009adab75f02427231b340d', 0, '
2022-03-08 16:28:26
'),
('3e831d30f2e68bfe83a03b1ace0ada4ae2e72e5a5330fa69038b2bae3cf12e43519a469d0b51342b', 'd187ee06d1b7b419db141094e220f6f5fd72d3ee6920f68e16d6494e5f48343ecdd27e257df69bed', 0, '
2022-03-08 13:18:21
'),
('c411e9b6a0a5baf20debab1d2de62192ea87b44ddb40b18a7ab2221bd955be4594edc810be9fc04d', '8297e892c8f4152a4dc11d222718a6c170049d1819dad60cd23e8d0ad30c5478805b315023293fb1', 1, '
2022-03-08 09:06:06
'),
('5497dec18ab873dc8493d7832b7305ca1daf7f90d103f7033798901cc345bd9575179ce7bd21b272', '3b9b46d3dd78ffe59d88f13ce2aa059b7aa16f768e0825eda2586cb35dde6cfa3ae65fcc3a4825b8', 0, '
2022-03-08 09:06:05
'),
('ef362023dc5fb2985ba5b5f405978d21e39045374c071c344c084c09777c8a744752e501c7d5aac8', '7bf6cea867895cf5f7dc9e21b6bf721a6ca5c50487022c289131ef23e95c17e075d729f96b810980', 1, '
2022-03-08 09:06:05
'),
('f7aed21321c9af00626fde3e86dfaca1b4ef0ccb4a9f12b23fc6e85a6c7f03fd78a8a69e8905348f', '9d5a56cf86c7e079efac3a336902b8c575f96392a4ac51a154ead7816eb4dd3bcc11bfa0799192af', 0, '
2022-03-08 08:54:19
'),
('2ead2a9dfc2b21ce7997bdae9ff7d25044d3ad1395935b0ff525ed0af4275a8430bf97a5b9ba1aec', '1dff0a8d812eeaa494391b11a84d651684a40d17c1cab2cb7513111a91733661e1c8ac219ec9d508', 0, '
2022-03-08 08:50:32
'),
('56cc453ca69162f744f0d05e3a5d4b3d24f6b942e53c6286eee7482b40c684e94c27bacdbdabf6c9', '1ab24a1b91300d6da2e63d9ae6419c2e3e61808da10a2289b4f222cd4513bee18e5088505df6790d', 0, '
2022-03-08 08:43:28
'),
('2f2dc195baee909026857a9ce6d57e406c0ffe84fbe939cbcb1eb141753082f01c9df701a8094756', 'fc5972b2b9429ea6336dfd94a3619ae11fa38fb9ed4cf0ad07309af19a3a6a56e3ce1244368d042e', 0, '
2022-03-08 08:25:40
'),
('01acc17b19ffd08c1e6fd36321e4b8399051b339fd102b91f2ba86965fd2ba2cb67ac00e0710d5ef', 'b1155d408ee3ce29aa1fcfdde641f3c6351f3c4ef0a11ff9c0e76919a220238ad526dc725108a035', 0, '
2022-03-07 22:06:57
'),
('aa24c7e667defa71bb04c8b25b1ee57e3c841b562ec6714b7d6aa121e88396963a7b9b99427220d8', '7582a81464387eb1c103214b6eba96e177f86495d1a3491f2dd437eb1451ab9dcacd7e55e7690bb7', 0, '
2022-03-07 21:57:19
'),
('d68930b86bb3fdc87c240f396fba89cdc20a966e9bbf9c96f646349251f69a8efacfd17cd75f7805', 'e02b236ecea88fcc5857c0290fa7d8a535c9d387fed6ddf3b155342444f6502bbb6c003acc86dae0', 0, '
2022-03-07 20:46:10
'),
('9f8c192d9c7949ccbf28f98e81d38c21bcae794cb2030eb2abf997fa46fbf2433be5ff0985b03fd6', '830db03342690cc68b1b598986f1fd36a033ddcc1072226e82b7c5aa8dcbcae3b75b71da910a65f1', 0, '
2022-03-09 00:35:52
'),
('4dbc880c6db5e1a119b5616648b700edb07eeb6c33c50be54d93a18610ab382bbd52cb52d89574f1', 'f2eb48f51d471b179cd87508910b726efdf8f33b0e95c3a7b74e6fb5fc5cda4aa7cb9a0aa0c0efb0', 1, '
2022-03-09 00:35:53
'),
('2a2e2b304390de71c3e2d93812d6e96ac2afe2684ba20c69fa2d89dbd0466e44d6c9518a79c61842', '70d46da1244efc948c868a69a8d97a6330a6a1795bd5a5bc55dd46162e9838476891dbddf3f15270', 1, '
2022-03-09 00:35:57
'),
('644dca116c75a1cf07680a5a2a069e95460346e6acbab54b6387ef7f322c814fe157477d45800e89', '3d8029f1b9ade94beda9ade2ae09381cb3851cf98dd4c53f1d3255b8594fc59270ab52ce774bd715', 0, '
2022-03-09 00:36:03
'),
('643f678a2c8f864746227d0d0fd6317f7354ee2b7ab0fb772c0c56b0a3e71688380cedd9322115d0', '1eb02aa08085927d4fabf952d053d77e0a552b567b46815ed2ac15641e78a8c3ef26bec4ac46b5dc', 0, '
2022-03-09 00:40:46
'),
('472f93dcd9aab2deb7a709feec3f348f7bcf6344fe7e877eb3fe878767ab3a892234013aef83220e', 'c6041fb1cc3ec42069b2aae1925337d3fae38bf33b9d45ec4d9cb873a58f64c8a70d224c9d33a293', 0, '
2022-03-09 00:42:54
'),
('26f51562bd9b82256b85b20fbaeb227a3a8608da49c501397e87904bf590c5a4b3122b210a5adb96', '5f1bc3ebeec84eb1def3f71ca7551d9e585d954b79679d926db6a20ab9a3a4c43a3abf4ba19c1cc1', 0, '
2022-03-09 01:40:19
'),
('331e5c13ce4188928f20c5a89d01831c470f165010c9a43937db520033bd1ee7bf3c0cf1c6fc7fb9', 'c832d7b7644086576b4564a7f7d1708b9c12790551041f9795bee29c65459265575882571b5cb3ff', 0, '
2022-03-09 02:34:28
'),
('a8d61b95d53ad9054e37f57434fbefe5effe9ccae3614bfc4e71fcbb6a9a14f2b99f7bd03ffc2d7b', 'f3fa8960e68d010c767bf9e52dfb6cdc5b3441553b6164e03635da70fa2b14c54a2c08b10a757ebd', 0, '
2022-03-09 02:51:29
'),
('873baf1844aafbf09d5927955297dd083df2e04a2fd4b67a6c59c23c530e70a68d69c947acced900', 'c9657b49aa3b145e245ef447f444fe4308f46007b9ef9802c39f80abfeeb4ed129b6f4fd99fef4d0', 0, '
2022-03-09 02:54:25
'),
('5fb23b2c696ec90bb76ee74393b1eb9ce9a3a4bfa8cd34df80e1c8e3bf3b7c66d727f0dcf385a96e', '2e5a9ae15e04ce550eba564da33ecb0fba08a5c54f4ed1e39451e4e84591ff90a371cd67802dc72f', 1, '
2022-03-09 07:16:18
'),
('3a4960f136ab9b8b7e42f3327f0c8215d3de3ac00fab6696fb45e1f490a871790cbf841bc0383ee6', 'b4f0ed615aa4df62f8ea60bf66172955a25f0c07568f922e1b34f5dc97f7a19511cc0b7416a97d8f', 0, '
2022-03-09 07:16:19
'),
('60e4224fa26e8da4aab81e892e730f2e9a2bbbfd990c38a90b6d1958464ea2af878c417e9f1abb95', '94eb881884b7d8129d5c8a134f4218187f30682cd1079c764cb28a569092c26fa21ac149b30e052e', 0, '
2022-03-09 07:16:20
'),
('14b921852f56ce1e10dc7a7496862236e46edfe97ac8666b2c3ec4d041f90fd79109250e32d29801', '9b29a1c2f82d3d231aa7bc0b7c94db29df95a6578f7eb9e74c4530b25d73339ac6fa23105503373c', 0, '
2022-03-09 13:20:37
'),
('15fdeda2dbd8dbe853d2aee333c99950c0291c0a99924e3d103f6625b0d9c72a0787041bbaf3583a', 'ea46b74b81a26d6a57f480cf5339522a2e7d96e19df3a5d4d6adcd68ffbd876f1b3c1b2499bc9980', 0, '
2022-03-09 14:05:27
'),
('4743227347f4c6167deb27a90cd92dd22072cbbbad1eeb21f2089449f678fd42e9b81e642dcfbd15', '0afa9ed9d48c4a2f84b0409dc2feb58d97ce610f8aef1d1f78d3e2d396a0381dfec630289d4c51b4', 0, '
2022-03-09 20:34:39
'),
('e38bf0cb7e851cfda7a23d071aa3f9ddc5e83d9921d12bd6458c050923fdd95a0947328d95703f8c', 'd905ab6689bfe3095f216698438ac5f2b939de53f846eaab9cac016297cfeb6445915d2a728de06c', 0, '
2022-03-10 16:25:37
'),
('52bc8734d1475295144b73e809066d7e8dcce0213c265b298e4ca21ed6841c6ac297590dc6ca59b2', 'c3024891f02bd7c481651bc58a0d3f3076698c546b7b967f2746bf26b3c72b99ad6672613f21ef4c', 1, '
2022-03-10 19:07:27
'),
('03be26df4593b685af983c62a3d021cbcbc12490ac84790a831f1a8487a0ba36c4aff749d8c80d55', 'e474b8017c78186959df0f379240cbc79edc790d6b1da7c2aa9c59617b4b84b3ebf686eaf8c92125', 0, '
2022-03-10 19:07:28
'),
('e0ef6cd63b8a3fe8e757df2ca93a2115b34b8d34c4e654e51f1a2e298984a825bce70eba7bb2fa6e', '57061d15fc5a5d8f2b6b03e53b6092a9e78148d56872b21f12399df05b1b59f12bbdf124acf391e5', 0, '
2022-03-10 19:07:30
'),
('77f16bc1f1ffdfe983d50a914c1fa3c0e1b48bcce079c2380893f9bbe60071e65f8e519c84f4cd3d', '16b7f634440d55cc61b07199a30b5776a29dc4dfdc60a4a9d80dbb88697e2dbb23ca719dc543045a', 0, '
2022-03-11 06:05:36
'),
('25ce169a87805f66f51a8b7c54c80ba634ac7d94ec075050a005b7ce794f59cb58983d85505e12bd', '18a2107348ccc1cd2d9d3ff3cf3669f6033789912b633246cdef659a7b76d9412bdf7f7250b442de', 0, '
2022-03-11 10:46:10
'),
('5a3fb54ef01ee26df6a30a01691deaaff0556787477ac74c748c6594fdbfc51bb56a7016440e57d7', '038e0ea5ba9b9800a2152df1f635468734f2d96521f9fa2303dc46047f94d8c939e59c08d9c5495b', 1, '
2022-03-11 11:57:33
'),
('5eeb42861a7163eca9baa8dfb04564fddb742afec118c5d0483d3da182ed97763036353f07c9dfe4', '365badb3563a6954e9dd52c919fc00d92d5240a0b96c48c8f6103a9af3f478ec1b36968209857c8e', 0, '
2022-03-11 11:57:34
'),
('6bc7f0f433a14b7faaab883837afa97d1e2e8a826fcca98c72fedb0b8c32540d9d13e75fa451af67', '58076db3bea31746ff64e70386f91dd410a9a2e4c368a812f352d1100d85cd5ab7dd0a4381f2006c', 0, '
2022-03-11 11:57:35
'),
('252bb2f364af77e17a46f04d7ccfb82a2436ea64561fe2731baced719164b22337cf7749e76b0a0e', '444f4f84f295e868eba4976e1201f7afb6858f8a6ffadb092c035ccc746c7e22accbc135a101a16c', 0, '
2022-03-11 14:15:23
'),
('39a25d6099510a963bec3b1b3255c67b264cf34ec26f7b47fb3680ee398c7c98869f831dd6792655', '31745f852ef9a0f344a7baec911c45958385ab5b444e82afedcdd88a84dba9254eaf80e200395a77', 0, '
2022-03-11 14:46:20
'),
('b620c79033ac0131fb9ec4d2933288178e5e3d1fad12b3e7512ad841e9efab0948017328fab5dd32', '8c60b2a20090718dd16fb664f1f8dbfd3128cf51dc9be7264d2d20b7f8dcc784a2c4707c8eee158f', 0, '
2022-03-11 15:37:33
'),
('0eef6eaf7789a61d0fad1ab942e4668d913d780adcff8c5dcd4777c25a3c091d50a402882e23c292', '998d21a1e5076046472a4d2750b8db55740393f4a08e0d5873e6f7627123f67fc41a2c42833ab582', 0, '
2022-03-11 16:49:02
'),
('63b4c5413526e40da2d451c7d59e7af0576b9eb081e771dd59f4930084cd384937be50d9045eb7d2', 'f35e1b61ab74851f47c37fdea9f150de54670d9e6c874d6c446e2adff6ee1f70bdda89f7d0d27255', 0, '
2022-03-11 16:53:05
'),
('02f6add6c7a5e0ca56a4b72b4444a1bf3744ee3b0a8be8954740b5c0b407929445209a7a71670540', '948657573ee5a7e5789289d66b7618193d08bd6e59132fa30d8333b8ccb06612ed4704a28652cdb8', 0, '
2022-03-11 17:13:43
'),
('2a59ab52d36cb9168c2337461c1704b32fb99985de790118a2309f6f8a845cd651ac92e7b522490f', 'e37efc42019c3b044e727c97f8a30c0130338bddada5139a192b7a68493f2118a81925a53ec56ff2', 0, '
2022-03-11 19:14:41
'),
('89fecf686ba149738e51e5f3337316538666f63e2c49cd976e2ec66c88c776acd4752e6852ccbbd1', 'effc3be0dabcf6ce9f3492038bc92928d2ee97a702b34484df6f1274b8e46de3efca3585424225a1', 0, '
2022-03-11 19:46:22
'),
('8d649c0d31d8ea62013c68095741b120a210821938e5b69ce4aff158d12041ed50181e649952d38e', '83019217fe2f29a806fd2bd6a125a3334f2ffcbd09120c1e9b717a3671bfb7880915c1e811f35656', 0, '
2022-03-11 20:16:54
'),
('bbfe14d6c653b8ac01fa5b6ad619105d2e1f3510d9394bae96e852980c76219c12d5ed237817549d', 'f58be4a43f274154c3c09431158f75721cdfaf0f0cd9c217bd479c33dc47cad9637ee8c280ce2083', 0, '
2022-03-11 20:23:00
'),
('282d032b02be221bb4b230bc837f11c51f15da7be1f397be8e3b1d47887515c5df468563e6e5ad7d', 'cd854e71f0fcde61c95be1b77bc614966e10877c777a7fe29d918b9ff744ed086cadc63b5d3ea891', 0, '
2022-03-11 20:54:29
'),
('f7418698361cd240f0e5970bca0c2a85ffd6d75fe00a0292c2d63e68b80a444009f258fc30685d3c', '11a47ff6bf9723ca8f4788050ed369e9ab6d94cf34004c74b7b059723b9e9dc3699b8063736b16d9', 0, '
2022-03-11 20:57:02
'),
('414dfe18c49778d02d3f3be6ba5f77eb314ccb4ece12840381a9d0f7ea6d788b960874f2792a59af', '4956532202b3fa0903513ecea9ca422dea555a494e6109e5761482e255099c5e939c093125fc3bf6', 1, '
2022-03-12 07:17:30
'),
('795dd617fee7183358df99a5a9248e567e08ef039a75414a8481ea39d334bb27d9e65c1ef8141f18', 'a5d249abbe6a097658a3ce2260994551c08250ef06b615f3f87767ed04c878f4fd2afe382769a3a7', 0, '
2022-03-12 07:52:26
'),
('a1aa12b6b9ee16c599ecebcb6375385b7a65c25ad5e95759ef0db79f91f36317ccee0c0d47a8cc8f', '5bd93dba764b36aa48378e038aef036c28f9369768175856cd8b1da0fa7226c25db6a00e2b8b8a18', 0, '
2022-03-12 12:24:36
'),
('c30def011e0068c1070ff759d697f314e5669ae815a1ba68387212f2fc28092a8e8d77deeb4f9cb9', 'd73333418af62e0e46cbd961f55449472b163c14ae89b901550d2c4c0c0209afc80cd927a1f34715', 0, '
2022-03-12 12:37:48
'),
('121d865b0b59f1f96678093a4d4fd89efb27e6ac44d5526ca925a0c21982bd667b4918fb37e59f75', '2ed2dc7049f50d77356e0492350fb04b19c0c698f3f444362e0c587de4e7ea1a40575d31ad1a5ee1', 0, '
2022-03-12 12:57:25
'),
('97aae7dd93dd068fa42efa8a5c033502d623d579bced6f49ecd9a895e0741ab1403080f1244b9a45', '5e54f4db318dde146b19b794bedb70ded35b4218c7daf2132796c899b07456215048b712c7a64d70', 1, '
2022-03-12 13:25:20
'),
('ac5f69a6d455b4cd69d3e50bf196b4d88f28c011bdf07dae70a44ccbd559936d405452b631017aee', 'ecf7e77b8fe5f3d512710e6db91f6c7f83680638ce13b5128f7d4de0799e7659a629b994328f8d50', 0, '
2022-03-12 16:07:32
'),
('65028ef34ae59d50f046a2204363e68ccac46a9f7643f4f2b45d7be418bd406cf1ad2037dd98235b', '9e80b723b48d3a4b4c37a72dbfcdaf2ea399ff54a8bc7877e7dc514660fd8524c54755983c1ad78c', 0, '
2022-03-12 17:37:06
'),
('9658773afd9197fdeb36904fce2cdd4131b23ffc10570ca22d7e4f094a059387ffc7c642f5929dd2', '9b29b5ae5e2845b273e83c639e4dced2a56d9a6848246e23d9021f6f5aeadde65d1660473daa4ca6', 1, '
2022-03-12 18:27:45
'),
('f88645b10f82bccd3f905dc0bf4a4e9b83e3662d01e8824511d5485b436b954fcb80b41082aac667', '75563eb23529985cc1e26019cb353308c6aecfbf7b4be63340f453631c893ec2c4cf5ca07d4c29c4', 0, '
2022-03-12 18:27:49
'),
('227fbb3643bdb60c95494abce04cc66aec56b01752e942a2b9f4494b6c0235419157437c2e490667', '98aad1c5d2815e4ff4ea1a29300068baddf063e54de863b1cf410b797b0954227b412e9f19a5c4c1', 0, '
2022-03-12 18:30:06
'),
('ecaddda861dd3bfa86da66d10071e2770eef604b5935ae12c6b9611713bf06a907b4615e6840ecba', '7066d0d78f65698fb4cc3da8393e8da434b090ab8c1bd7f58ed2ad4c29e096dda269285fc3c0be0b', 0, '
2022-03-12 19:16:23
'),
('153803e1b702dfa35f4b100c8a7d9926bf7f45b9ca52321b9bea26b8abf2f963b91cbb77368a7884', '924980f9d7155e89fc62a16b7714675b7597de0cdc23639b4c1a450fb923bdddfca2b5e0e9e549b6', 1, '
2022-03-12 20:18:12
'),
('8bf2fdafcbd5250c895ef2ef9fb80892241bb48ee4a6b5a31ac612b2220d22a8c2f323b0a2e5f969', '9e5263c7ed4212020f2254d482c8e2b0f7c1512824e57fe54d33dccb9f9b950f3f8ad4999857d8eb', 0, '
2022-03-12 20:18:15
'),
('49c207ce609329ab6c604c9b52fad14205bc92ccce28a79db89bbfec57b136f321244bf6f15b3942', '1c741b28bd9561d8d4549eef943aa3010d07cd85c3d13d4f403ea536132a35513cf69dc606dc6f5f', 1, '
2022-03-12 22:01:07
'),
('52b524149249ce3c5e2175cea301b72574bec86c9849622823a5746fbf34d425fe73b1f61208ca16', '08c81fd22aadc9606adcb54dbedcf765e0f57f73bbfc9278969c3840b3f6f7ad47b74319c658cfcb', 0, '
2022-03-12 22:01:11
'),
('65cd8eb4e8ff69827e88c84efe33837991ddcbcbb61fd40f4c6aadaa8f6b8421d741d62aa218ae95', '2b986b4d7435a07c45f0b07976e60b4577f77a9a9f83a053096fe497a1e692bdeba6dc506700b32a', 0, '
2022-03-12 22:02:52
'),
('128d7e07a89a63ce7b52d23f20cfb01580d7c1e98a29cc8a059f2ab14abc551f3d05e6bfb8b2bcaa', '75e3e47918f113112c855a0c5efcb995888f732f223998531e7106dfe2ffeaa0b1bc7e5bc31dd3ae', 0, '
2022-03-13 00:56:25
'),
('68d736c5191f167e32e3143875c68c1a1872e49cb52653c9ae98f987fabb63a8c214afb36c915121', 'b3fa9ad4d95f65563cdefd78137a7a959adec8cf4d4d11b4125e2d5011de7750e703b2b090e2f1b9', 0, '
2022-03-13 11:07:20
'),
('0755bd2b5f97d386ff1dda161d6b8bc2e1d30fb4dc6001142a0cb36df1242ab7cf504d3bf333b090', '78b86df5dbe2fcd75f6c6e5daade2edeb4495c8a5117da2dfdb5174a35334936882b3b5c5d229ca9', 0, '
2022-03-13 12:35:16
'),
('b96676de31812271fec8a04ceebc68c0377e60d301f03c10f16a6fb5e38eb23184108c6163474c48', 'b595dfdeef48dbe6ff76a72a593ea67f2fee8787a5091b0385834e6a66ed44ee143e2bfb45658ad0', 0, '
2022-03-13 20:51:28
'),
('589033689f3c3087960bc1727768dfb69818e87d9362eb0078ac20fdc23201f7dd13cfcba122ff0a', '0ea338a2dabf5a0921a250a443cde0613b5c6dcfbd6eeb38f929d5a5ca7089a99cd5d6a68c95c7fa', 0, '
2022-03-13 20:54:14
'),
('7e2ea5beb3da7b8023a92a48c32f0da7a8b32e9c3d14ea65f0b841e749519b217a55c8258ebf066b', '93d06aaf79f556080f9e6dbde987319ec7a2b3c6571a2d571f1d30da5a073e79e547ad3a20f79230', 0, '
2022-03-14 01:27:00
'),
('f6e888ea04b7c8773a28bdae4012caaf3767795668f395abf51464491633411abc1976da6d90e535', 'daee0560ce5928423737254f1abf045e7a138b35e85f57ecb95c7e83420e24f652dd59c7b57036bd', 0, '
2022-03-14 08:38:49
'),
('d05c386ab51cbc6f48a021ac50df85e0ff21503697ba5fd88fdd041c954949fed605f75a012c8312', '1d7cbb8e5d68565e42de2a5e66f9309fed7707c11d6216e951d455a187b4717e62cdbc62c8c3e239', 1, '
2022-03-14 14:11:02
'),
('01d5b3d906137f105da260877becd3a8fca8f07c68667de276c4d3d31aedae6f41ebb3d6a9137dd2', 'cfc666ab94c8387a871168f6214521c4ad3a117511355e02fba45955ecdbcf1d7c27d96ec6d5edfa', 0, '
2022-03-14 14:11:03
'),
('1ebbdb7bb834c4faa8d70b12fe7b58dbf817bd3bb3f72a1bf81f3d28e34c6f27bceab938b32cf7f6', '34d8d30ac82e3d4ea2f249c7b1eae9609b25467389901bb5f64abe4534803105d4959260d22aeb84', 0, '
2022-03-14 14:11:04
'),
('5a9ad7e3a7b3ea4fb5df2ccc16007595aac81b772e947269af601c83046515cc1d89048a6697d59d', 'b04be626cc207e0985fdee2198b793068cec1e728d656ad523793ccecab9ba111b4334fb1ad768bd', 0, '
2022-03-16 13:05:57
'),
('f11dd5268900e1acbcc02e8197e0d3de4a3a41466cd1eadf97a7a281fde274cba015c882e1ddad83', 'ec9bb6a36fa7cfe31b4151ad9acd411cfb418c2f2052978b1d1162a3e631a88793ec162c4dba3c4a', 0, '
2022-03-16 13:12:15
'),
('084819836df72c8470c574db664f0518492833ae505932f18f06f4ca8d3ecc23226a2f71fe709c26', 'b02b78ea343af220aa52ec25a840bbb09a2303e937e65239519358732903d3eabd418d4f0f394b03', 0, '
2022-03-16 21:21:05
'),
('519e0ecf484be8d04340aee438a3f7234dd746ec089f59a13e889d3fcf3f25873aaf0928307523c2', '827dec378255969fb281d89d142eafd05585df185770f79f0550c9972eb667b1c4c84e95922c1f09', 0, '
2022-03-17 08:37:13
'),
('59e3c9d6514775602cd72751628051c08939683f4cf2f8b77bf09941c8018a3d95c587a9210a9712', '736d488f0b6f659dcac7acc04544744e26ff1f87ae632851f8cd69c2cf56c034647da921a205873c', 0, '
2022-03-17 15:48:41
'),
('cc5309ee3969831dc1a5670d23e07fa5320a7ce8f5e086151c151172ac1c72246929ba3ab67f98eb', '36daf2502227bd82e40d96bbdb0c36076aaaba609887cb4fd357bab1a705cc663aa573ad3ce8e103', 0, '
2022-03-17 16:38:40
'),
('7377a8d2d49883b1834ee59b920fdd5685bb85e0b5cbc25bec78994c1ecf13f6bc53fb5b5e0375fc', '7b81ca2b7672777d0a630f4b81a21a937210e05a64401889552512dabb0805aa531fc7ae5e7da1d5', 0, '
2022-03-17 16:44:49
'),
('080e88bd242e8a97a9097f388db7881c265c7044578aa2d81d391d0ccd85a417a1ddabf5b8e094f1', 'a009e11adca9d631d7bd65ee5993b4bc850ebb13205748c33b86e7cc8e19ae5743356d2eccbc7200', 0, '
2022-03-17 18:32:00
'),
('5763fa87c126c22323d2d0eb3ce77d18d11e2daa065a91d9d6919e8116c86de2d04d7e7efa38913d', '1336b3f6c459646d643814d69e352b1d8c278d4d9dcde0e24aa3f9b7dbef578c177f75d7d654e570', 0, '
2022-03-18 13:25:09
'),
('a5189b54b0e79467e1c1402c577dab2054a05dd67d4a6de68b87769452517953690731d1ac928fd5', 'd068229fe25d266795fe30ce0d97c4f8fc51adf1499306634fa2c26a867f694321614800dd409745', 0, '
2022-03-18 14:51:03
'),
('156cb6e10989ffc73179cf540538643344aec9bce65d6371a32524f4ff343e3f65a2c93d66ade4ad', 'ffdbc7bf57a75b86858468ef6fe83679b4b126ffb7f18f7183732c0335b0d6936a511dcc18622212', 0, '
2022-03-18 15:21:46
'),
('a201ea815a1f8fb741d2e061929e221b72229c8476d310db6f1f06de2d2ed44794c3f3258c79ef45', '469b6e9656cc0ca096669a9c1f348efaf3ed0e2c3a8398d18fe1162b8b15331202bcf6c0619a99c4', 0, '
2022-03-18 19:44:27
'),
('a786f2a21a43f577d888e0eae0c7f9abcfcfd5ef777ebf185cbb5214cdcad14769e5e1b45d438395', '015080f8e91b1b928b6bb679c0a285b15737e0b1bacc1f3745f3f7bb28272efb1463c84aeff42775', 0, '
2022-03-19 11:05:05
');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `base_time` varchar(255) DEFAULT NULL,
  `base_distance` varchar(255) DEFAULT NULL,
  `base_price` varchar(255) DEFAULT NULL,
  `after_time_price` varchar(255) DEFAULT NULL,
  `after_distance_price` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `package_services`
--

CREATE TABLE `package_services` (
  `id` int NOT NULL,
  `service_type_id` int DEFAULT NULL,
  `package_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `package_services`
--

INSERT INTO `package_services` (`id`, `service_type_id`, `package_id`, `created_at`, `updated_at`) VALUES
(1, 2, 15, '2020-04-04 11:40:58
', '2020-04-04 11:40:58
');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('lunguphilip@gmail.com', '$2y$10$80L1SChlJZMwugUVh7cN7u0DG4O30xDv/yR2diS/ZWG59jBHMba46', '
2020-05-18 00:29:24
');

-- --------------------------------------------------------

--
-- Table structure for table `payment_histories`
--

CREATE TABLE `payment_histories` (
  `id` int UNSIGNED NOT NULL,
  `payment_service_id` int UNSIGNED NOT NULL,
  `provider_id` int UNSIGNED DEFAULT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `event_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `tx_ref` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `flw_ref` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `order_ref` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `amount` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `charged_amount` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `currency` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `customer_phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `customer_fullname` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `customer_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payment_histories`
--

INSERT INTO `payment_histories` (`id`, `payment_service_id`, `provider_id`, `user_id`, `event_type`, `tx_ref`, `flw_ref`, `order_ref`, `amount`, `charged_amount`, `status`, `currency`, `customer_phone`, `customer_fullname`, `customer_email`, `created_at`, `updated_at`) VALUES
(1, 1, 80, NULL, 'MOBILEMONEYZM_TRANSACTION', 'MC-1556614529471
', 'flwm3s4m0c1556614533770', 'URF_MMGH_1556614532854_4300235', '
50', '
50.72', 'successful', 'ZMW', '+260761231220
', 'Anonymous Customer', 'moobazimba@example.com', '
2021-11-29 04:06:42
', '2021-11-29 04:06:42
'),
(2, 1, 80, NULL, 'MOBILEMONEYZM_TRANSACTION', 'moobazimba@example.com c8b9a6c1-086b-4536-8b71-71bed3eb1a37', 'LUIU8071856162893', 'URF_MMGH_1638134168438_8326335', '
5', '
5.15', 'successful', 'ZMW', '
0761231220', 'Philip Lungu', 'moobazimba@example.com', '
2021-11-29 04:16:38
', '2021-11-29 04:16:38
'),
(3, 1, 80, NULL, 'MOBILEMONEYZM_TRANSACTION', 'moobazimba@example.com 948a7d30-9488-4b4c-a4c4-6b4a0223dacf', 'SBZV3974856166256', 'URF_MMGH_1638134508021_4669935', '
5', '
5.15', 'successful', 'ZMW', '
0761231220', 'Philip Lungu', 'moobazimba@example.com', '
2021-11-29 04:22:20
', '2021-11-29 04:22:20
');

-- --------------------------------------------------------

--
-- Table structure for table `payment_services`
--

CREATE TABLE `payment_services` (
  `id` int UNSIGNED NOT NULL,
  `payment_service` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `payment_service_slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payment_services`
--

INSERT INTO `payment_services` (`id`, `payment_service`, `payment_service_slug`, `created_at`, `updated_at`) VALUES
(1, 'Flutterwave', 'flutterwave', '
2021-11-27 03:00:00
', '2021-11-27 03:00:00
');

-- --------------------------------------------------------

--
-- Table structure for table `promocodes`
--

CREATE TABLE `promocodes` (
  `id` int UNSIGNED NOT NULL,
  `promo_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `discount` double(10,2) NOT NULL DEFAULT '0.00
',
  `discount_type` enum('percent','amount') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'percent',
  `expiration` datetime NOT NULL,
  `max_count` int NOT NULL DEFAULT '
1',
  `status` enum('ADDED','EXPIRED') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `promocodes`
--

INSERT INTO `promocodes` (`id`, `promo_code`, `discount`, `discount_type`, `expiration`, `max_count`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(15, 'Cheetah', 10.00, 'percent', '
2021-03-29 00:00:00
', 5, 'EXPIRED', NULL, '
2021-03-27 01:45:50
', '2021-05-17 21:40:05
');

-- --------------------------------------------------------

--
-- Table structure for table `promocode_passbooks`
--

CREATE TABLE `promocode_passbooks` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `promocode_id` int NOT NULL,
  `status` enum('ADDED','USED','EXPIRED') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `promocode_passbooks`
--

INSERT INTO `promocode_passbooks` (`id`, `user_id`, `promocode_id`, `status`, `created_at`, `updated_at`) VALUES
(6, 131, 15, 'ADDED', '
2021-03-27 01:48:30
', '2021-03-27 01:48:30
'),
(7, 131, 15, 'ADDED', '
2021-03-27 01:49:25
', '2021-03-27 01:49:25
'),
(8, 80, 15, 'USED', '
2021-03-27 01:51:21
', '2021-03-27 01:51:21
'),
(9, 131, 15, 'ADDED', '
2021-03-31 05:21:34
', '2021-03-31 05:21:34
');

-- --------------------------------------------------------

--
-- Table structure for table `promocode_usages`
--

CREATE TABLE `promocode_usages` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `promocode_id` int NOT NULL,
  `status` enum('ADDED','USED','EXPIRED') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `promocode_usages`
--

INSERT INTO `promocode_usages` (`id`, `user_id`, `promocode_id`, `status`, `created_at`, `updated_at`) VALUES
(11, 131, 15, 'EXPIRED', '
2021-03-27 01:48:30
', '2021-11-03 11:56:23
');

-- --------------------------------------------------------

--
-- Table structure for table `providers`
--

CREATE TABLE `providers` (
  `id` int UNSIGNED NOT NULL,
  `first_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `wallet` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0
',
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `rating` decimal(4,2) NOT NULL DEFAULT '5.00
',
  `status` enum('onboarding','approved','banned') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'onboarding',
  `fleet` int NOT NULL DEFAULT '
0',
  `latitude` double(15,8) DEFAULT NULL,
  `longitude` double(15,8) DEFAULT NULL,
  `otp` mediumint NOT NULL DEFAULT '
0',
  `remember_token` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `login_by` enum('manual','facebook','google') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `social_unique_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `providers`
--

INSERT INTO `providers` (`id`, `first_name`, `last_name`, `email`, `mobile`, `wallet`, `password`, `avatar`, `rating`, `status`, `fleet`, `latitude`, `longitude`, `otp`, `remember_token`, `created_at`, `updated_at`, `login_by`, `social_unique_id`) VALUES
(52, 'sammson', 'lungu', 'samsonlungusl@gmail.com', '+260978862185
', '493.2866
', '$2y$10$ic/DTkjPiYopSPo4TwaUHuNX/NMXUNGwx/4ph/0myt/EwtP2Qi.dm', 'app/public/provider/profile/JNQZT5ADWzHTHUbcpON3fN3VRKvi0yxUKoqgHten.jpeg', '
5.00', 'approved', 0, -15.38934167, 28.39489000, 0, NULL, '
2020-11-12 19:29:38
', '2020-11-15 20:45:02
', 'manual', NULL),
(53, 'peter', 'katebe', 'peterkatebe52@gmail.com', '+260973971377
', '500
', '$2y$10$EjeH.0ef0Vtjml5DvHOFS.aTCmubvRdtvyDF1kH0OkQCP1nESpefm', 'app/public/provider/profile/lUVn54EYPRNzEQyOves2H7J2Z18rzJBx0JzHadf6.jpeg', '
5.00', 'approved', 0, -15.40209000, 28.35505167, 0, NULL, '
2020-11-12 19:29:40
', '2020-12-31 18:51:52
', 'manual', NULL),
(54, 'Dennis', 'phiri', 'dennisphiri68@gmail.com', '+260978508254
', '500
', '$2y$10$spm5.IgtPXimc/OBw9ChLe1jbjWQcg4eRpyhf9mIeWgc0GNXguuwO', 'app/public/provider/profile/hyhYiOJA0PsYaTMfoGE2i3btOLxa5pSLpzaqGlxv.jpeg', '
5.00', 'approved', 0, -15.40225020, 28.36756154, 0, NULL, '
2020-11-12 19:41:48
', '2020-11-15 11:28:37
', 'manual', NULL),
(55, 'emmie', 'mwamba', 'emmiekmwamba75@gmail.com', '+260977521045
', '0
', '$2y$10$Mk0ls40rm/2cKENWprq9FuTyoe3LTPCBcfCrkWHOQLeyX6RtFK0VG', NULL, '
5.00', 'onboarding', 0, NULL, NULL, 0, NULL, '
2020-11-12 21:39:16
', '2020-11-12 21:39:16
', 'manual', NULL),
(56, 'choda', 'mwenda', 'chodamwenda23@gmail.com', '+260976647264
', '500
', '$2y$10$jL7KoziVcWhxYetjBTeFTe4ESpxk3OYJLBusQ8aldBJkdFUZJKq/q', NULL, '
5.00', 'approved', 0, -15.42099500, 28.34379000, 0, NULL, '
2020-11-12 21:47:01
', '2020-11-16 13:05:58
', 'manual', NULL),
(57, 'serge Kelvin', 'nyangu', 'kelvinnyangu65@gmail.com', '+260975344677
', '495.5
', '$2y$10$O2kkawb.CTnpym6PjHkEyu3xbd9EP5yNaTud2aBtHCcttuzg39O76', NULL, '
5.00', 'approved', 0, -15.44361500, 28.35582167, 0, NULL, '
2020-11-13 22:24:18
', '2020-11-14 23:38:46
', 'manual', NULL),
(58, 'Abus', 'kapikanya', 'abuskapikanya71@gmail.com', '+260977935449
', '495.5
', '$2y$10$idyYLB/EhUBXbgQFYA7Z8evUXwo7XjenjxFmjvI2S47yD2.cpxM72', NULL, '
5.00', 'approved', 0, -15.43623648, 28.35462901, 0, NULL, '
2020-11-13 23:03:55
', '2020-11-14 14:28:24
', 'manual', NULL),
(59, 'Grivine', 'phiri', 'grivinphiri4@gmail.com', '+260977863876
', '489.8627
', '$2y$10$.pzeEQSBrNfGdY7JMFVqd.4/XfOtnydcD9a.SUYejn4BJVHYdHyli', NULL, '
5.00', 'approved', 0, -15.40680630, 28.37651840, 0, NULL, '
2020-11-13 23:34:39
', '2020-11-15 17:10:06
', 'manual', NULL),
(60, 'Chembe ', 'Kavimba', 'kavimbac@gmail.com', '+260955000085
', '0
', '$2y$10$lVgWjgOurlsqQ29trJa.pe5l0rf.Ols5.G9avQTjkGG8IzTacrlW.', NULL, '
5.00', 'onboarding', 0, NULL, NULL, 0, NULL, '
2020-11-15 01:54:34
', '2020-11-19 13:38:25
', 'manual', NULL),
(95, 'Owen', 'Phiri', 'owenphiri@ymail.com', '+260975434234
', '500
', '$2y$10$tM8SfQMsyaoYCxGHGrekg.D1TMO1xROixI2OIl4RX6Gs5.RcAGyT2', NULL, '
5.00', 'approved', 0, -15.40058700, 28.36051080, 505987, NULL, '
2021-08-22 17:43:02
', '2021-12-14 16:00:34
', 'manual', NULL),
(96, 'Idah', 'Sakala', 'Idahmanda80@gmail.com', '+260977381126
', '500
', '$2y$10$g8hJml3YOazqvVLBt0O.t.3Vy8eeJNmAO34cEhlrN5QWXHN/uB3TK', NULL, '
5.00', 'approved', 0, -15.44510980, 28.31156390, 923614, NULL, '
2021-11-02 13:01:56
', '2021-11-11 18:39:54
', 'manual', NULL),
(97, 'Natasha', 'Phiri', 'phirinatasha7@gmail.com', '+260978750660
', '500
', '$2y$10$klRqm1W6/dIrADOkhAiwP.uUdbw/yiTO/UEJvP2/YrjUcUGfOe7fq', NULL, '
5.00', 'approved', 0, -15.36419340, 28.39207760, 400451, NULL, '
2021-11-02 23:43:36
', '2021-12-07 19:09:49
', 'manual', NULL),
(98, 'Paul', 'phiri', '1paulphiri@gmail.com', '+260978311413
', '0
', '$2y$10$MxqpGwNTp6p4DRvToY4h1.u12Iq/WbHo.OfngaRMmlydsDV9C7.Eu', NULL, '
5.00', 'onboarding', 0, NULL, NULL, 0, NULL, '
2021-11-03 15:10:44
', '2021-11-03 15:10:44
', 'manual', NULL),
(99, 'davis', 'phiri', 'davisphiri246@gmail.com', '+260971800089
', '0
', '$2y$10$o5rdFEz.lPeUIgjSGBBJeu3DRZ1JSXRa8WRek3rkGbzF6XkBhuaTK', NULL, '
5.00', 'onboarding', 0, NULL, NULL, 0, NULL, '
2021-11-03 15:24:13
', '2021-11-03 15:24:13
', 'manual', NULL),
(100, 'James', 'Zulu', 'jameszulu195@gmail.com', '+260973309617
', '0
', '$2y$10$OfliOHVfsik.0EAv9AD43OFeqCKibIbikfDe0fI2zk8D4gU4vLENu', NULL, '
5.00', 'onboarding', 0, NULL, NULL, 0, NULL, '
2021-11-03 15:31:21
', '2021-11-03 15:31:21
', 'manual', NULL),
(103, 'harrison', 'sinyinza', 'seniharrisonmcnbhs@gmail.com', '+260975747476
', '0
', '$2y$10$j8GqesxunAsLqknldC3xzelaaNxJmiXblHo5BocEiFtDh0EJ9VKfW', NULL, '
5.00', 'onboarding', 0, -15.46761000, 28.35072167, 297717, NULL, '
2021-11-11 19:25:38
', '2021-12-17 10:20:17
', 'manual', NULL),
(104, 'Bernard ', 'Makala', 'bernardmakala@gmail.com', '+260979414272
', '0
', '$2y$10$vJmvamLwzfP75GX.6DKu6uuXFCcVOcTYwUSzHku6lqjm59MCjv9F6', NULL, '
5.00', 'onboarding', 0, -15.37922430, 28.38963750, 0, NULL, '
2021-11-19 00:36:16
', '2021-12-05 13:44:27
', 'manual', NULL),
(105, 'Mweemba ', 'Hapompwe ', 'mweemba91@gmail.com', '+260964780119
', '100
', '$2y$10$fB.lN5Fx8g1AyBcgOC1Z5.0dowFvZBOBYpaISop.irF1NYCE34HYq', NULL, '
5.00', 'banned', 0, -15.39813000, 28.38537950, 0, NULL, '
2021-11-23 11:56:28
', '2021-12-12 22:13:14
', 'manual', NULL),
(106, 'MACBORAN', 'MUBANGA', 'macboran94@gmail.com', '+260979548487
', '151
', '$2y$10$8/ghEMMUnmz2KnNajmOUL.DsUPdfmP5RzWsYybRdxrjzcvB4YRMMi', 'app/public/provider/profile/6QBKQfhXMqXhqGx8rWXtUxCA9caCmjuh0smUqwBI.jpeg', '
5.00', 'approved', 0, -15.35464100, 28.27662850, 0, NULL, '
2021-11-29 21:40:38
', '2021-12-18 19:58:29
', 'manual', NULL),
(107, 'Robin ', 'sinyangwe', 'sinyangwerobin03@gmail.com', '+260977205220
', '1
', '$2y$10$ic5jePmaDk/sbPUc1/6zdOFMg.FaeaABOOJ8LSw45aG/djUuaJ2GO', NULL, '
5.00', 'approved', 0, -15.41357980, 28.38289950, 0, NULL, '
2021-11-30 15:53:10
', '2021-12-18 10:49:45
', 'manual', NULL),
(108, 'Fortune', 'Mahembe', 'fortune@zambia.co.zm', '+260972555520
', '1
', '$2y$10$bXxik3hSewP/YjL/GxhcQ.zVlLxeFn.v1mPR7a1JmAMUq9ycj15Yu', NULL, '
5.00', 'approved', 0, -15.44741090, 28.33828860, 0, NULL, '
2021-11-30 19:23:54
', '2021-12-14 17:07:43
', 'manual', NULL),
(109, 'Dennis', 'Chembo', 'dennischembo1@gmail.com', '+260977328120
', '31
', '$2y$10$YB8shioT4eplFemcNXwLFujhKUrHoD.uVMsaf1Si8C444sI3L/XQ.', NULL, '
5.00', 'approved', 0, -15.38754500, 28.32458500, 0, NULL, '
2021-12-01 02:42:07
', '2021-12-19 12:02:28
', 'manual', NULL),
(110, 'Darlington', 'musonda', 'darlingtonmusonda@yahoo.com', '+260972515606
', '0
', '$2y$10$ALbJWuPMye.maXaCKEwqyeFQv/ZcPB5qh7YsS5TNNczR16M0D6fcu', NULL, '
5.00', 'onboarding', 0, NULL, NULL, 0, NULL, '
2021-12-01 12:23:10
', '2021-12-02 02:17:40
', 'manual', NULL),
(111, 'james', 'kombe', 'kabondekombe@gmail.com', '+260973275571
', '0
', '$2y$10$I3OtPHLFYcL0u5k7hZ5NjOSDVAQx55xEfx3/9VPR1EUSIYEafDQvm', NULL, '
5.00', 'onboarding', 0, NULL, NULL, 0, NULL, '
2021-12-01 14:19:34
', '2021-12-01 14:19:34
', 'manual', NULL),
(112, 'Felix', 'Ndhlovu', 'ndhlovufelix@gmail.com', '+260770284670
', '1
', '$2y$10$sIIFlAClBVKX4pPsPpviHeafdrd4oZeHamfGhy6tsgod7PjjM/JOG', NULL, '
5.00', 'approved', 0, -15.45294000, 28.29958330, 0, NULL, '
2021-12-01 18:49:54
', '2021-12-17 15:58:00
', 'manual', NULL),
(113, 'Mwelwa', 'Wapamesa ', 'mwelwawapamesa@gmail.com', '+260979437494
', '1
', '$2y$10$2qGqtI6dk.M3JrUEMgb/Ues1ZxUYziC566IUghi2z4vXfIfBvnygO', NULL, '
5.00', 'approved', 0, -15.44094510, 28.34117630, 0, NULL, '
2021-12-03 20:16:01
', '2021-12-05 11:18:16
', 'manual', NULL),
(114, 'Samson', 'phiri', 'samsonphiriruth1984@gmail.com', '+260978222975
', '0
', '$2y$10$7djzNwdFbPYT9i4Utspkw.7f2ZS3fFMH2dcOeaG8G0po63haTbpM2', NULL, '
5.00', 'onboarding', 0, NULL, NULL, 0, NULL, '
2021-12-04 13:02:46
', '2021-12-04 16:01:42
', 'manual', NULL),
(115, 'Evans ', 'Jere', 'jerrypowers73@gmail.com', '+260976947678
', '0
', '$2y$10$p4/5eS2QC5CxgVf92I3q1.aORoShPr9LlHF0Dcmhg5rjP/WoMO0aO', NULL, '
5.00', 'onboarding', 0, NULL, NULL, 0, NULL, '
2021-12-05 14:14:04
', '2021-12-05 14:14:04
', 'manual', NULL),
(116, 'Bright ', 'Mbuzi ', 'brightmbuzi8@gmail.com', '+260956138363
', '0
', '$2y$10$RbDte8eQfLbLXRvr/xPdv.OX.g.9UOjo3i/XAwAt5VVStMUp/wMre', NULL, '
5.00', 'onboarding', 0, -15.40277750, 28.33332770, 0, NULL, '
2021-12-06 04:16:51
', '2021-12-06 05:11:52
', 'manual', NULL),
(117, 'mulenga ', 'kaoma', 'kaomam65@gmail.com', '+260973562071
', '0
', '$2y$10$0iT6Zlq27QBqKhFgEdYTTuq8PjiEVYhsxErjHg/UHLnx9C7cmpnim', NULL, '
5.00', 'onboarding', 0, NULL, NULL, 0, NULL, '
2021-12-06 11:15:52
', '2021-12-06 15:33:51
', 'manual', NULL),
(118, 'Davies', 'wapanza', 'sichulawapanza@gmail.com', '+260967741989
', '0
', '$2y$10$fBaMGyl8R0nImAsolX1eeuAsmQ15hGK5XUcEwTsFcB8i.UpXLDCbe', NULL, '
5.00', 'onboarding', 0, NULL, NULL, 0, NULL, '
2021-12-06 15:47:08
', '2021-12-06 15:47:08
', 'manual', NULL),
(119, 'Livingi', 'Leonard', 'livingileonard@gmail.com', '+260975097374
', '0
', '$2y$10$O2NfMMzjOrsdOF515Iwhve5BJsj8Y/fTVGK73Uk/C4jukQs98qpPa', NULL, '
5.00', 'onboarding', 0, NULL, NULL, 0, NULL, '
2021-12-06 21:00:51
', '2021-12-06 21:00:51
', 'manual', NULL),
(120, 'nkole', 'kaluba', 'dakaalex9@gmail.com', '+260979724034
', '0
', '$2y$10$dLGswDzLwaArxUE018RdZuCoV5jcc4uHM5YI9NmOVfikU52gH3bpS', NULL, '
5.00', 'onboarding', 0, -15.40616669, 28.27982379, 0, NULL, '
2021-12-07 02:36:16
', '2021-12-07 23:38:06
', 'manual', NULL),
(123, 'Philip', 'Lungu', 'admin@cheetahrides.com', '+260761231220
', '1.9764185000000118
', '$2y$10$yU.Ic3HwO2OGW3n8iQmyjuqcL40IBYCxwBnEVJx4..JpR98L81/gS', 'app/public/provider/profile/FbD9ITziXByjbIVSn8Qak8z0riAo4y7G8UGb8PhR.jpeg', '
5.00', 'approved', 0, -15.40175490, 28.37961280, 275845, NULL, '
2021-12-07 20:17:03
', '2021-12-19 10:17:17
', 'manual', NULL),
(124, 'Mwango', 'Mulenga', 'danielmulengamwango@gmail.com', '+260969608328
', '0
', '$2y$10$DOue3MV2cGixvuHm9o1XoeptXMs4paEVUsTaNkNKE6hrqgPye/vLW', NULL, '
5.00', 'onboarding', 0, -15.42610520, 28.20788730, 0, NULL, '
2021-12-08 11:30:01
', '2021-12-08 20:58:27
', 'manual', NULL),
(126, 'chama ', 'kabwe', 'chm.kabwe@gmail.com', '+260968532735
', '0
', '$2y$10$kw7lHAnelQjsxg3L3KGYOuyv0JGOeuuV8oZebv5qFScuYD09bQMS6', NULL, '
5.00', 'onboarding', 0, -15.41120680, 28.34966470, 0, NULL, '
2021-12-10 20:14:58
', '2021-12-13 13:46:15
', 'manual', NULL),
(127, 'Jude', 'Malewa', 'judemazm@gmail.com', '+260955421580
', '1
', '$2y$10$kSjd.xXy68UqP1IHrxHRT.UmWp84Z/oMGpH7AE9hKeb6cw.QlZ/sy', NULL, '
5.00', 'approved', 0, -15.40042870, 28.30502120, 0, NULL, '
2021-12-11 12:17:59
', '2021-12-14 12:13:25
', 'manual', NULL),
(130, 'Driver', 'App', 'dhdyd@yahs.com', '+260975160001
', '367.14369000000005
', '$2y$10$wgy5JsT1xoH2SNxub7vBa.8gHofPoMdtc57Pi567slUYDSpvKMgeK', 'app/public/provider/profile/s4QyyTH55fUI3FAGmQ6wjgM6KW4hCo91Cfpx9mui.jpeg', '
5.00', 'approved', 0, 31.44289791, 74.39838045, 0, NULL, '
2021-12-12 12:50:33
', '2021-12-18 21:40:57
', 'manual', NULL),
(133, 'Geoffrey', 'miti', 'geoffreymiti02@gmail.com', '+260970162611
', '0
', '$2y$10$1Hx1ayRW5MyIBRY1FaZj7eVegrWYCiHvhWHE/SdgPP9I52l2HpR0i', NULL, '
5.00', 'onboarding', 0, NULL, NULL, 981719, NULL, '
2021-12-12 15:33:51
', '2021-12-12 15:37:22
', 'manual', NULL),
(134, 'Regina', 'Mwale', 'chipashamwale@gmail.com', '+260975168881
', '99.47408000000001
', '$2y$10$KKHkcoHwcE7UUE/lHfTeOecFsQ4U11zYbJnDraO5Fy3cACQf79.n6', NULL, '
5.00', 'approved', 0, -15.39568944, 28.38717596, 0, NULL, '
2021-12-12 18:05:58
', '2021-12-19 10:01:18
', 'manual', NULL),
(135, 'philip', 'lungu', 'lunguphilip@gmail.com', '+260975168880
', '807.3566805000002
', '$2y$10$fmgrthMBb8PETOR0zEtl4uV7ra5izDUuMRuBZRhH2/St1YIF6UJdW', NULL, '
4.84', 'approved', 0, -15.39803650, 28.38533850, 0, NULL, '
2021-12-12 18:25:34
', '2021-12-19 12:09:33
', 'manual', NULL),
(136, 'Bwalya', 'Mulenga', 'chewerancyprecious@gmail.com', '+260971541745
', '0
', '$2y$10$AYGEjPnMnK0NkwHDyDnpTuIDU.2RBHxN9UlltlBvZPgiIplOuUBWC', NULL, '
5.00', 'onboarding', 0, NULL, NULL, 0, NULL, '
2021-12-13 12:06:31
', '2021-12-13 12:06:31
', 'manual', NULL),
(137, 'Edson', 'Tembo', 'temboedson792@gmail.com', '+260776598372
', '0
', '$2y$10$UrMm5XmPe6IHx7DtXPCeo..RAP6uQv74qHXAqUitKKwP4VppdlXZ2', NULL, '
5.00', 'onboarding', 0, NULL, NULL, 0, NULL, '
2021-12-13 16:34:02
', '2021-12-13 16:34:02
', 'manual', NULL),
(138, 'Thomas', 'Ngulube', 'ngulubethomas099@gmail.com', '+260979898702
', '0
', '$2y$10$fO8MGlAx8/DZN0uNPYnei.gcYtSwsb7l0Do0g1yR3rVgOtXYzuKH.', NULL, '
5.00', 'onboarding', 0, NULL, NULL, 0, NULL, '
2021-12-14 10:46:35
', '2021-12-14 10:46:35
', 'manual', NULL),
(139, 'Ethel', 'mtonga', 'etheymtonga15@gmail.com', '+260971579792
', '100
', '$2y$10$OU/QbfhAy5FCl1GXPcIWEeHqb.BGQftIJKMR54D7xRN2dSyqXGMuG', NULL, '
5.00', 'approved', 0, -15.48627600, 28.35938880, 0, NULL, '
2021-12-14 14:11:56
', '2021-12-18 13:36:10
', 'manual', NULL),
(140, 'kapenda', 'lupambo', 'lupambokapenda@gmail.com', '+260972130948
', '0
', '$2y$10$RRrsWTOnf/MSiGK64AE9T.6AZVFKQ2jzGzblci2OfpHShylrmkMAq', NULL, '
5.00', 'onboarding', 0, -15.33592170, 28.34283830, 0, NULL, '
2021-12-16 11:30:40
', '2021-12-17 09:43:48
', 'manual', NULL),
(141, 'Drive2', 'Test', 'driver@example.com', '+2609555
', '700
', '$2y$10$nFWIL8qLTord/5Jrq8IuPuzAMwJ/rOaJ/ihmkNs1iMgG3ykTaNG9C', NULL, '
5.00', 'approved', 0, NULL, NULL, 0, NULL, '
2021-12-18 10:27:20
', '2021-12-18 10:28:53
', 'manual', NULL),
(142, 'Muhammad', 'Dawood', 'abc@gmail.com', '
100', '
0', '$2y$10$yAoNmHMA11At6yuqUPYFjOII3AIsyacoVUACIMNtvM/s56fVr09oq', 'provider/profile/5H88clkZ9mQFCXwvr544MzvppuOHW7pkUZDwslwM.png', '
5.00', 'onboarding', 0, NULL, NULL, 0, NULL, '
2021-12-18 13:04:49
', '2021-12-18 13:04:49
', 'manual', NULL),
(143, 'kasongo', 'lubasi', 'kasongolubasi92@gmail.com', '+260979939393
', '0
', '$2y$10$BEqPHXYRxGl/GihhtsuwZOjTbg9KuHKs0CBRKgTx.N/nIWYmxOwEu', NULL, '
5.00', 'onboarding', 0, NULL, NULL, 0, NULL, '
2021-12-18 19:53:10
', '2021-12-18 19:53:10
', 'manual', NULL),
(144, 'Alick ', 'Phiri', 'alicktreverphiri@gmail.com', '+260973806132
', '0
', '$2y$10$CHEU4JOFXqjL0thv9zyuKON4lLgrW/Jn27QE4Re3U/j/Urt0FiJF2', NULL, '
5.00', 'onboarding', 0, NULL, NULL, 0, NULL, '
2021-12-19 02:00:39
', '2021-12-19 02:00:39
', 'manual', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `provider_devices`
--

CREATE TABLE `provider_devices` (
  `id` int UNSIGNED NOT NULL,
  `provider_id` int NOT NULL,
  `udid` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `sns_arn` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` enum('android','ios') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `provider_devices`
--

INSERT INTO `provider_devices` (`id`, `provider_id`, `udid`, `token`, `sns_arn`, `type`, `created_at`, `updated_at`) VALUES
(122, 123, 'b85f0e01f9476281', 'f5BCDCO4T_mKzFmYfqk5TH:APA91bEpZdz9dtDjiYN7fn3En3zUVPkQBVkvR0qY76Q1vrmxjlg3MVi6Y2dR6jYdC-3PNaABEi6Lu3NBa0h0k3lCD9o6F5q_ZHgz_QerrgKQTxGJvPnJseFUq9n5z7jeNNEXg-BurJMc', NULL, 'android', '
2021-12-07 20:49:08
', '2021-12-18 12:47:53
'),
(123, 102, 'b85f0e01f9476281', 'c71Mk4oIS3S57dSrYmrki_:APA91bEyOjZ37QPRiNGCgEDDBgf9YoTizfPZCxs7flvnMNuGDqWWPVrGwZFWcYrdojZoToo3-9ShVg50o_UQWkPjoJt0C6IoxrUvIGdRDez1OkeHuz6Ynq4f-inYvHK-EM6CGO5tZdNS', NULL, 'android', '
2021-12-07 23:08:24
', '2021-12-12 16:31:34
'),
(124, 101, '057fba38381fcd8a', 'd3IzWFKcSMylMidiS00zFo:APA91bGcYwtfxNAXB86Wji-9POL32pfZOCqk9yAz1OZ8X0vcj5RkOBjl0NaNXIS4g_X_96kfnSij0XxyozFtgddha8goL6NvwT09XRnKP_TLZABNN7WgrLgblzsSsHwOb8ZhFORCn-e1', NULL, 'android', '
2021-12-08 10:40:50
', '2021-12-12 16:22:57
'),
(125, 124, 'dca62b3d31c626e8', 'c0aIGucaS76zYs5SluGcdK:APA91bEVHVKvHbfv91oRztHsv4tPij_OXfw61G8GgzTwyQckz5fR0lpOUpb3OrUn4dwdpGKvu_v9DaIVHK0i4S0F_mf-gb6XVTMDba3uvZ6B8dTfmW0zV3-uBwRHxCj8dAGvKf6bP1tc', NULL, 'android', '
2021-12-08 11:30:01
', '2021-12-16 12:05:31
'),
(126, 103, '46723fbbaaa757af', 'dOox8k01TCWVn52oIJnkK1:APA91bFE4Ocz0x8fcTOEAv9o127R9PYibkYJflYPmKa1lDny7otShwWpOy_Ebq98cbq18_VSoo1nPm8SScMM8khXHKH8-Xju_RdxCdCbx3mkk4iPQlmpDjiEfZ4y8A-1Kbpk3WDKz68-', NULL, 'android', '
2021-12-08 15:55:00
', '2021-12-17 10:12:41
'),
(127, 125, 'baeb9ad6c5c663e6', 'f-6NgHd7RRm_j5N-QhcnLP:APA91bHjGiIhquaPmR-4c_z6ajTXe5xGBi6MGKB7GiFP6qEaEIzJCA-tWfcKLGCQACCe1ehK0ZR5V3v1FgIOttTb5Fb_SvaD-8n3Xh7QO4835xNS8gqjSxoBOxbFPHi69yCixWMNdqPO', NULL, 'android', '
2021-12-08 16:21:26
', '2021-12-09 00:07:33
'),
(128, 109, '91dceff4b2ff0588', 'eX53Yq2nTsuTpPxU0Bi9Hh:APA91bHtX9QEOVOSqh6BuNhW9f2CGobIIlRgd9VHylVs5qVnm52dvaG-54E8GGXZtONc60sm8AJhhqhrQVdF59XrJ47kUBRTSGBbHbJg8bMzpKk94JE_kkF4krqtUsFZGAHju6C_FseW', NULL, 'android', '
2021-12-09 08:45:33
', '2021-12-16 08:58:09
'),
(129, 126, '76f73336aa5c4c8f', 'ff_8xEKBT0Ct_0b-NoMMts:APA91bEEpGzNj3bXngbkRPz4zP-vCKHVgBLOnOuiCMwMQ3PeJD_F9d6D9UWVWc5NLO35IaxW7KdH_Jy0V8NQ1_8lbXgCCxs2nOegP05e76C7swlvj1i_HEO-uG9_9Svv_nzEltmrS6R-', NULL, 'android', '
2021-12-10 20:14:58
', '2021-12-10 20:14:59
'),
(130, 127, '21ca6710bd939216', 'dOGvw3A1QcSst-0cJXcalL:APA91bFlY771KqyuM10Q_rKqfNojWzp3gsAPMX2zbzYYqSTjYt9ZrfF3NjBR-X5QIn2D_Gx8Rxc4St7YULH5JEAw3NnRAY5PDJetJRxP1JaRpZQqiF-0rJ9L92otadwdlhIrbTZJwQ_s', NULL, 'android', '
2021-12-11 12:17:59
', '2021-12-11 12:33:54
'),
(133, 130, '720f93e22ec76018', 'dpTGPhBdROKHj-oiQNSOpr:APA91bGEdb_pF1iNieCaVDegTVtikhbNtn_h86PlCMz2Y1HrYLr-skwoQYgEpw0jYjoYbS7xXSaBZIiCo8hGIfiHf1i5iDnGLqP0A9RW77jpYglk2x18317YkeV0ghG46ngBJDTpo2x4', NULL, 'android', '
2021-12-12 12:50:33
', '2021-12-17 20:22:29
'),
(135, 132, '22668867e3cbc73c', 'feP3SmR9RLa5MEPonoCMB0:APA91bHLzjpPCqwbe7bSAqYmhnC4NhwqZ3Z8qdDfERe6av4aNlHCZx5wMmMaoNKDHyTKy68_XhJm5E0WvualJ8Fsj1WhjMOeITvkFvkcBHzcotrBkec0VVHKOlEoETuHgkF29tuDcjHa', NULL, 'android', '
2021-12-12 13:39:23
', '2021-12-12 13:39:24
'),
(136, 133, '0d02c979fbab39a4', 'dYErG42nSNSWMTIhfMy5OA:APA91bGPJc6HHuQPalPaPqFT_L4mV6C2e0wUz6npwEWjARtxLVHgfjQCU1_FKuipFXKdsoXXVN5AO_OJL_pTWLrb1N3S1hA0nEPblf79aiUSfoAhDtuNRWww4Qs_tuZ6JZGEjM3yRprO', NULL, 'android', '
2021-12-12 15:33:51
', '2021-12-12 15:33:54
'),
(138, 135, '22668867e3cbc73c', 'cDP2dJzdRf-CJXqrj69Yfr:APA91bH2fq3AIlByTJuKHASABxXcPdMwWVeIxWrurzm3_kyY4D6HghN3sFytYZBY2uMQDSVhrsjbiHfiRX1qjlh7Bw4TQCsXsnf506LFhak6DP6fElAYY68XJvZXU038wkkEt8TtvhgQ', NULL, 'android', '
2021-12-12 18:25:34
', '2021-12-18 20:29:06
'),
(139, 134, '057fba38381fcd8a', 'dh_nXhCGSrmXa7nhANDZcD:APA91bFtSUfVg6ungz6iRU67F_g5v9lHAwZyeTBnvz0MDgOt3DOaMZEy4z2ry7a-GdZhAnCCq1Lg-BygARgdBLYC3TOOJcruQQFi_bxCaa1PTdh-9SS5zgCogKx2qdkg8lWd04yb382P', NULL, 'android', '
2021-12-13 01:57:23
', '2021-12-18 23:21:51
'),
(140, 136, '19793e2a121d68ad', 'cLOuBQWiQHepzQBDUN_Kz5:APA91bHVveoa-GEGO0FlQTOkxB2z1XffTj0Ek5U0jdNsMKVdzrIvYaq1NM38ZxH2-ONRxrjM21bYHqYXtmQ7M0N_YbI5F0qvAGjV79m12DVNLmwtNZfrx0Yz04X33-pdhUBsbAa0sc-M', NULL, 'android', '
2021-12-13 12:06:31
', '2021-12-13 12:06:32
'),
(141, 137, '16dbc50848d0a4e2', 'dl0Rz6yQSzyjFW4hmyjSvG:APA91bHAfqaAZeOjYytxfPEZqK0zVaCQkCTmVHXyYDBm8QLFE5iI2sdn21SjSzk3CmEqJxKoGOmm3MqIgcGDT4DgyJ8k0uGLF8JTW-Y3ccHwCDdtO6lJ8gKcSMRUx6PzQAl5OX9-zNW5', NULL, 'android', '
2021-12-13 16:34:02
', '2021-12-13 16:34:03
'),
(142, 138, '8536f388556a33b5', 'ekLqqt5TTHC9-_tzVAFxVH:APA91bFRA1Vb2BTJRUKoHfF_-q4R56w3E6meFg9dGERpeGlsy1n-e39mdwiWhJ1pDI8imaytOv_vaiTvyvPSM9zWDPjK8WDA6CJl6CYbVjmkYuEPYj7ZhKHUru79ad_6Acv5rWkMDESf', NULL, 'android', '
2021-12-14 10:46:35
', '2021-12-14 10:46:36
'),
(143, 112, 'b691f957f05f76aa', 'cnhc2up7SMy4o_DlAc_enf:APA91bHfN5G1KaOG7gBdqonuL-F5FVMTcQHdgd8xNr7DEDo3yZO6t78p3QoNq9wZL51FGGeoh5FzqgsYHJiwfrbrjy9YLELneFrv-hVSRqEiKQpIV_fZouuS72Z6zrV5rYWCj97C5ukd', NULL, 'android', '
2021-12-14 11:47:25
', '2021-12-14 11:47:25
'),
(144, 106, '2b9cba82fab06995', 'd-Mk_BDASCyOJdc-a_HrpJ:APA91bExGWl4XCr3QmXrvreWIJtXE6XCYI4w-rNHlHWmOLwyeH4L0csm5OQXqy8dXhK1Dlsh4u32sruAESUPJkVL39CUSm5YYqXjjC9m5hyT4RmF6Gj37Tvqr1FQT2vLTZrEtKSEshfz', NULL, 'android', '
2021-12-14 12:50:53
', '2021-12-18 17:13:14
'),
(145, 139, '22f26b645b39151d', 'clWuynBzQMWaDzJSEIl-xK:APA91bHpdL8qwLVXHVxZkHMIn25YZz_WMmlPmdrbQ4-NfiK3iIfUNEdgrPkTapZn1101KWJYCV94-i0VeeZ2bgi4aY0hfQlkFGHRzZn8b8gjshFOohCoPijJE66UD8AYQorn3ShxDg8P', NULL, 'android', '
2021-12-14 14:11:56
', '2021-12-15 11:55:44
'),
(146, 108, '17267be1b02e18da', 'f6nKyr0VRmSPfVYv4HUtS-:APA91bEyISG2MsRRXtv0MfV12T_qbOi0t4t1yrO8q2y7R1fApz4PWxjLzM6xZbr5oKd4dq1GYOvMvg8sZx4LDLkvms9uYhNLHqNMhQ8E_gptuSSHfM0FJSyoZ7azAT8nnNfFnGfC3nGp', NULL, 'android', '
2021-12-14 14:37:17
', '2021-12-14 14:37:17
'),
(147, 140, '9f5bf2149b2411a0', 'dqXPieEhRGmAXSF22uAswa:APA91bEgraascexjBCk16tlp1N_cdbb1SkyHQsfCC3XFlHeKRD8JWNfF6SfmMm19_aBUOldk7UzCkF6pgCsEG86cm0kNmQwKjLN5zLuWqaaYgcFrckXO0jRVW_dQcwlqq9uFKZ9V--Ib', NULL, 'android', '2021-12-16 11:30:40', '2021-12-16 11:30:40'),
(148, 107, '7ee44cd847f43d17', 'ch6IwQSyTM6dWjCdTNMcOW:APA91bGW151Rv3qdfqaXWlvTkbJDKp0oGhkXeSeVh53u3XPFShbqWJVXm8hn8GXpQnbKZVE_ayDfz7Ulzl9gMRh9dJEDGYbXHhjOrTkZWaXSHv8elmyoIp_4s4LS9UMJZcLjeaPHcCH6', NULL, 'android', '2021-12-18 09:20:31', '2021-12-18 09:20:31'),
(149, 143, '259cab2908fd9982', 'dpgamilFTJal82dwhh8pgd:APA91bEZ8F-uYD6biNxvsPOhONLNhT-IBTRADSUXKFCg3B9Vuk8gD0ONJcl_3DZKiGYr6iKRG7lb04VDtQ-Hc2Sk_v43SibzuNlLhRC_gUBF8_C2p2eXIQfUQMKvmexLW_Cv9lQNOVNG', NULL, 'android', '2021-12-18 19:53:10', '2021-12-18 19:53:11'),
(150, 144, '36f9097586d73bca', 'dQnTlNcDReS-vaD8McGrib:APA91bH040trTedx1Rg2GbELmQo3yjwwmiEJJBo7lLMmHG5T2YsQv1DvS1ahLMu1RFs9cWOfAsqDZlnnr1QnYwVD6peCZOs0mxJLfDtgMB2gWueQmlQAkfQEb3xKMcG9goeyc_4OqjZE', NULL, 'android', '2021-12-19 02:00:39', '2021-12-19 02:00:40');

-- --------------------------------------------------------

--
-- Table structure for table `provider_documents`
--

CREATE TABLE `provider_documents` (
  `id` int UNSIGNED NOT NULL,
  `provider_id` int NOT NULL,
  `document_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `unique_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('ASSESSING','ACTIVE') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `provider_documents`
--

INSERT INTO `provider_documents` (`id`, `provider_id`, `document_id`, `url`, `unique_id`, `status`, `expires_at`, `created_at`, `updated_at`) VALUES
(86, 41, '21', 'https://app.cheetahrides.com/uploads/1602929444999.png', NULL, 'ACTIVE', NULL, NULL, '2020-10-17 19:51:25'),
(87, 42, '21', 'https://app.cheetahrides.com/uploads/1602977105090.png', NULL, 'ACTIVE', NULL, NULL, '2020-10-18 08:55:52'),
(88, 43, '21', 'https://app.cheetahrides.com/uploads/1603037820955.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-10-19 01:47:43'),
(89, 44, '21', 'https://app.cheetahrides.com/uploads/1603237618939.png', NULL, 'ASSESSING', NULL, NULL, NULL),
(90, 45, '21', 'https://app.cheetahrides.com/uploads/1603237813762.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-10-21 09:30:11'),
(91, 45, '22', 'https://app.cheetahrides.com/uploads/1603237828982.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-10-21 09:30:28'),
(92, 45, '17', 'https://app.cheetahrides.com/uploads/1603237846480.JPG', NULL, 'ACTIVE', NULL, NULL, '2020-10-21 09:30:38'),
(93, 45, '16', 'https://app.cheetahrides.com/uploads/1603237868096.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-10-24 02:12:52'),
(96, 48, '21', 'https://app.cheetahrides.com/uploads/1603738179407.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-04 11:34:57'),
(95, 45, '14', 'https://app.cheetahrides.com/uploads/1603237898254.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-10-24 02:13:08'),
(97, 48, '12', 'https://app.cheetahrides.com/uploads/1603738245564.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-04 11:34:48'),
(98, 51, '21', 'https://app.cheetahrides.com/uploads/1605032586915.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-11 01:24:01'),
(99, 51, '22', 'https://app.cheetahrides.com/uploads/1605032603919.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-11 01:24:57'),
(117, 54, '12', 'https://app.cheetahrides.com/uploads/1605185143600.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-12 20:01:26'),
(101, 52, '21', 'https://app.cheetahrides.com/uploads/1605184226103.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-12 19:40:15'),
(116, 54, '21', 'https://app.cheetahrides.com/uploads/1605185124227.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-12 20:01:41'),
(103, 52, '12', 'https://app.cheetahrides.com/uploads/1605184313436.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-12 19:41:54'),
(104, 52, '22', 'https://app.cheetahrides.com/uploads/1605184340399.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-12 19:41:45'),
(105, 52, '16', 'https://app.cheetahrides.com/uploads/1605184434128.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-12 19:41:35'),
(106, 53, '12', 'https://app.cheetahrides.com/uploads/1605184512934.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-12 19:45:12'),
(107, 53, '13', 'https://app.cheetahrides.com/uploads/1605184522067.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-12 19:45:28'),
(108, 52, '17', 'https://app.cheetahrides.com/uploads/1605184525830.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-12 19:41:25'),
(109, 52, '15', 'https://app.cheetahrides.com/uploads/1605184545770.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-12 19:41:12'),
(110, 52, '14', 'https://app.cheetahrides.com/uploads/1605184578444.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-12 19:40:58'),
(118, 54, '13', 'https://app.cheetahrides.com/uploads/1605185165884.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-12 20:01:56'),
(112, 52, '13', 'https://app.cheetahrides.com/uploads/1605184602231.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-12 19:40:45'),
(119, 54, '14', 'https://app.cheetahrides.com/uploads/1605185206924.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-12 20:02:23'),
(114, 53, '16', 'https://app.cheetahrides.com/uploads/1605184674790.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-12 19:43:14'),
(115, 53, '17', 'https://app.cheetahrides.com/uploads/1605184725207.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-12 19:42:57'),
(120, 54, '15', 'https://app.cheetahrides.com/uploads/1605185272283.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-12 20:02:54'),
(125, 54, '16', 'https://app.cheetahrides.com/uploads/1605185696644.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-12 20:03:07'),
(122, 53, '14', 'https://app.cheetahrides.com/uploads/1605185477382.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-12 19:54:17'),
(123, 53, '15', 'https://app.cheetahrides.com/uploads/1605185490000.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-12 19:54:28'),
(124, 53, '22', 'https://app.cheetahrides.com/uploads/1605185501648.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-12 19:54:55'),
(126, 54, '17', 'https://app.cheetahrides.com/uploads/1605185739029.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-12 20:04:52'),
(127, 54, '22', 'https://app.cheetahrides.com/uploads/1605185755755.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-12 20:05:10'),
(129, 53, '21', 'https://app.cheetahrides.com/uploads/1605186147147.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-12 20:03:24'),
(130, 55, '21', 'https://app.cheetahrides.com/uploads/1605192016021.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-12 22:02:26'),
(131, 55, '14', 'https://app.cheetahrides.com/uploads/1605192033083.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-12 22:02:52'),
(132, 55, '15', 'https://app.cheetahrides.com/uploads/1605192045051.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-12 22:03:08'),
(133, 55, '16', 'https://app.cheetahrides.com/uploads/1605192079759.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-12 22:03:20'),
(134, 55, '17', 'https://app.cheetahrides.com/uploads/1605192143903.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-12 22:03:36'),
(135, 55, '22', 'https://app.cheetahrides.com/uploads/1605192251533.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-12 22:03:52'),
(136, 56, '12', 'https://app.cheetahrides.com/uploads/1605192659645.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-12 21:59:57'),
(137, 56, '13', 'https://app.cheetahrides.com/uploads/1605192675685.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-12 22:00:13'),
(138, 56, '14', 'https://app.cheetahrides.com/uploads/1605192691615.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-12 22:00:28'),
(139, 56, '15', 'https://app.cheetahrides.com/uploads/1605192706315.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-12 22:00:50'),
(140, 56, '22', 'https://app.cheetahrides.com/uploads/1605192720475.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-12 22:01:03'),
(141, 56, '21', 'https://app.cheetahrides.com/uploads/1605193078192.png', NULL, 'ACTIVE', NULL, NULL, '2020-11-12 22:01:16'),
(142, 56, '16', 'https://app.cheetahrides.com/uploads/1605193088472.png', NULL, 'ACTIVE', NULL, NULL, '2020-11-12 22:01:32'),
(143, 56, '17', 'https://app.cheetahrides.com/uploads/1605193099484.png', NULL, 'ACTIVE', NULL, NULL, '2020-11-12 22:01:42'),
(144, 57, '21', 'https://app.cheetahrides.com/uploads/1605281486361.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-13 22:36:39'),
(145, 57, '13', 'https://app.cheetahrides.com/uploads/1605281519797.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-13 22:37:04'),
(146, 57, '12', 'https://app.cheetahrides.com/uploads/1605281557139.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-13 22:37:16'),
(147, 57, '14', 'https://app.cheetahrides.com/uploads/1605281663431.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-13 22:37:28'),
(148, 57, '15', 'https://app.cheetahrides.com/uploads/1605281672011.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-13 22:37:46'),
(149, 57, '16', 'https://app.cheetahrides.com/uploads/1605281683686.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-13 22:37:58'),
(150, 57, '17', 'https://app.cheetahrides.com/uploads/1605281697236.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-13 22:38:08'),
(151, 57, '22', 'https://app.cheetahrides.com/uploads/1605281713979.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-13 22:38:17'),
(152, 58, '21', 'https://app.cheetahrides.com/uploads/1605283648252.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-13 23:12:49'),
(153, 58, '12', 'https://app.cheetahrides.com/uploads/1605283666503.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-13 23:12:59'),
(154, 58, '13', 'https://app.cheetahrides.com/uploads/1605283722240.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-13 23:13:11'),
(155, 58, '14', 'https://app.cheetahrides.com/uploads/1605283746284.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-13 23:13:21'),
(156, 58, '15', 'https://app.cheetahrides.com/uploads/1605283776426.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-13 23:14:02'),
(157, 58, '16', 'https://app.cheetahrides.com/uploads/1605283808251.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-13 23:13:52'),
(158, 58, '17', 'https://app.cheetahrides.com/uploads/1605283831089.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-13 23:13:42'),
(159, 58, '22', 'https://app.cheetahrides.com/uploads/1605283888281.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-13 23:13:31'),
(160, 59, '21', 'https://app.cheetahrides.com/uploads/1605285309251.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-13 23:40:41'),
(161, 59, '12', 'https://app.cheetahrides.com/uploads/1605285322102.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-13 23:41:48'),
(162, 59, '13', 'https://app.cheetahrides.com/uploads/1605285419127.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-13 23:41:38'),
(163, 59, '14', 'https://app.cheetahrides.com/uploads/1605285435643.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-13 23:41:28'),
(164, 59, '15', 'https://app.cheetahrides.com/uploads/1605285444760.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-13 23:41:18'),
(165, 59, '16', 'https://app.cheetahrides.com/uploads/1605285473837.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-13 23:41:08'),
(166, 59, '17', 'https://app.cheetahrides.com/uploads/1605285509745.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-13 23:40:59'),
(167, 59, '22', 'https://app.cheetahrides.com/uploads/1605285520134.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-13 23:40:51'),
(168, 61, '21', 'https://app.cheetahrides.com/uploads/1605383167607.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-15 02:46:27'),
(169, 62, '21', 'https://app.cheetahrides.com/uploads/1605418272250.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-15 12:31:34'),
(170, 64, '21', 'https://app.cheetahrides.com/uploads/1605426598343.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-15 14:50:34'),
(171, 65, '21', 'https://app.cheetahrides.com/uploads/1605439570800.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-15 18:28:32'),
(172, 66, '21', 'https://app.cheetahrides.com/uploads/1605449581248.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-15 21:13:27'),
(173, 68, '21', 'https://app.cheetahrides.com/uploads/1605576611032.JPG', NULL, 'ACTIVE', NULL, NULL, '2020-11-17 08:32:24'),
(174, 69, '21', 'https://app.cheetahrides.com/uploads/1605578698428.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-17 09:07:50'),
(175, 70, '21', 'https://app.cheetahrides.com/uploads/1606481896163.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-27 19:59:51'),
(176, 70, '12', 'https://app.cheetahrides.com/uploads/1606481918368.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-27 20:00:00'),
(177, 70, '14', 'https://app.cheetahrides.com/uploads/1606481931995.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-27 20:00:07'),
(178, 71, '21', 'https://app.cheetahrides.com/uploads/1606727648435.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-30 16:15:55'),
(179, 71, '12', 'https://app.cheetahrides.com/uploads/1606727662645.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-30 16:16:16'),
(180, 71, '13', 'https://app.cheetahrides.com/uploads/1606727676561.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-30 16:17:23'),
(181, 71, '22', 'https://app.cheetahrides.com/uploads/1606727692642.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-11-30 16:17:35'),
(182, 72, '21', 'https://app.cheetahrides.com/uploads/1607019524099.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-12-04 01:20:14'),
(183, 72, '15', 'https://app.cheetahrides.com/uploads/1607019538153.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-12-04 01:20:27'),
(184, 72, '14', 'https://app.cheetahrides.com/uploads/1607019548943.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-12-04 01:20:44'),
(185, 72, '22', 'https://app.cheetahrides.com/uploads/1607019563649.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-12-04 01:20:56'),
(186, 73, '21', 'https://app.cheetahrides.com/uploads/1607282069954.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-12-07 02:14:57'),
(187, 73, '12', 'https://app.cheetahrides.com/uploads/1607282080810.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-12-07 02:15:06'),
(188, 74, '21', 'https://app.cheetahrides.com/uploads/1607284013588.jpeg', NULL, 'ACTIVE', NULL, NULL, '2020-12-07 02:48:31'),
(189, 75, '21', 'https://app.cheetahrides.com/uploads/1607292515499.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-12-07 05:09:34'),
(190, 75, '22', 'https://app.cheetahrides.com/uploads/1607292526251.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-12-07 05:09:43'),
(191, 75, '14', 'https://app.cheetahrides.com/uploads/1607292536006.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-12-07 05:09:52'),
(192, 75, '15', 'https://app.cheetahrides.com/uploads/1607292546456.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-12-07 05:10:02'),
(193, 76, '21', 'https://app.cheetahrides.com/uploads/1607546052248.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-12-10 03:35:46'),
(194, 76, '14', 'https://app.cheetahrides.com/uploads/1607546067195.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-12-10 03:36:05'),
(195, 76, '15', 'https://app.cheetahrides.com/uploads/1607546077797.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-12-10 03:36:24'),
(196, 76, '17', 'https://app.cheetahrides.com/uploads/1607546093782.JPG', NULL, 'ACTIVE', NULL, NULL, '2020-12-10 03:36:37'),
(197, 76, '22', 'https://app.cheetahrides.com/uploads/1607546104180.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-12-10 03:36:58'),
(198, 77, '21', 'https://app.cheetahrides.com/uploads/1608041273238.JPG', NULL, 'ACTIVE', NULL, NULL, '2020-12-15 21:08:41'),
(199, 78, '21', 'https://app.cheetahrides.com/uploads/1608228414303.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-12-18 01:12:09'),
(200, 79, '22', 'https://app.cheetahrides.com/uploads/1608230565399.jpg', NULL, 'ACTIVE', NULL, NULL, '2020-12-18 01:43:32'),
(306, 80, '21', 'https://app.cheetahrides.com/uploads/1638393129142.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-02 04:14:25'),
(202, 80, '22', 'https://app.cheetahrides.com/uploads/1614491456376.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-02-28 12:54:18'),
(203, 80, '17', 'https://app.cheetahrides.com/uploads/1614491495217.JPG', NULL, 'ACTIVE', NULL, NULL, '2021-02-28 12:54:29'),
(204, 81, '21', 'https://app.cheetahrides.com/uploads/1614542533603.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-03-01 03:02:46'),
(205, 81, '12', 'https://app.cheetahrides.com/uploads/1614542551921.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-03-01 03:03:01'),
(206, 82, '21', 'https://app.cheetahrides.com/uploads/1614898734058.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-03-05 05:59:12'),
(207, 83, '21', 'https://app.cheetahrides.com/uploads/1615917556722.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-03-17 00:02:17'),
(208, 83, '12', 'https://app.cheetahrides.com/uploads/1615917567196.JPG', NULL, 'ACTIVE', NULL, NULL, '2021-03-17 00:02:27'),
(209, 85, '21', 'https://app.cheetahrides.com/uploads/1616481884028.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-03-23 12:45:10'),
(210, 87, '21', 'https://app.cheetahrides.com/uploads/1620144195669.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-05-04 22:04:03'),
(211, 87, '12', 'https://app.cheetahrides.com/uploads/1620144206901.JPG', NULL, 'ACTIVE', NULL, NULL, '2021-05-04 22:04:18'),
(212, 88, '22', 'https://app.cheetahrides.com/uploads/1620860167933.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-05-13 05:00:54'),
(213, 88, '21', 'https://app.cheetahrides.com/uploads/1620860190762.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-05-13 05:01:06'),
(214, 90, '22', 'https://app.cheetahrides.com/uploads/1621012837572.JPG', NULL, 'ACTIVE', NULL, NULL, '2021-05-14 23:21:13'),
(215, 91, '21', 'https://app.cheetahrides.com/uploads/1622063946752.JPG', NULL, 'ACTIVE', NULL, NULL, '2021-05-27 03:20:26'),
(216, 95, '21', 'https://app.cheetahrides.com/uploads/1629632842670.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-08-22 18:10:52'),
(217, 95, '14', 'https://app.cheetahrides.com/uploads/1629632968136.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-08-22 18:14:27'),
(218, 95, '15', 'https://app.cheetahrides.com/uploads/1629632983806.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-08-22 18:16:59'),
(219, 95, '16', 'https://app.cheetahrides.com/uploads/1629633001131.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-08-22 18:17:31'),
(220, 95, '17', 'https://app.cheetahrides.com/uploads/1629633014193.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-08-22 18:18:20'),
(221, 95, '22', 'https://app.cheetahrides.com/uploads/1629633027928.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-08-22 18:18:57'),
(222, 80, '12', 'https://app.cheetahrides.com/uploads/1635199074339.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-10-26 03:59:42'),
(223, 80, '13', 'https://app.cheetahrides.com/uploads/1635199085201.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-10-26 03:59:52'),
(224, 80, '14', 'https://app.cheetahrides.com/uploads/1635199132759.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-10-26 04:00:03'),
(225, 80, '15', 'https://app.cheetahrides.com/uploads/1635199145850.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-10-26 04:00:19'),
(307, 80, '16', 'https://app.cheetahrides.com/uploads/1638393151825.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-02 04:15:01'),
(228, 0, '', 'https://app.cheetahrides.com/uploads/1635836842919.jpg', NULL, 'ASSESSING', NULL, NULL, NULL),
(229, 96, '12', 'https://app.cheetahrides.com/uploads/1635836861045.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-11-02 13:44:24'),
(230, 96, '13', 'https://app.cheetahrides.com/uploads/1635836886717.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-11-02 13:45:08'),
(231, 96, '14', 'https://app.cheetahrides.com/uploads/1635836912679.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-11-02 13:45:24'),
(232, 96, '15', 'https://app.cheetahrides.com/uploads/1635836972997.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-11-02 13:45:40'),
(233, 96, '16', 'https://app.cheetahrides.com/uploads/1635836996317.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-11-02 13:45:52'),
(234, 96, '17', 'https://app.cheetahrides.com/uploads/1635837010504.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-11-02 13:46:02'),
(235, 96, '22', 'https://app.cheetahrides.com/uploads/1635837022230.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-11-02 13:46:20'),
(236, 96, '21', 'https://app.cheetahrides.com/uploads/1635837031691.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-11-02 13:46:31'),
(310, 113, '13', 'https://app.cheetahrides.com/uploads/1638537747357.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-04 12:52:43'),
(309, 113, '12', 'https://app.cheetahrides.com/uploads/1638537736577.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-04 12:53:08'),
(308, 113, '21', 'https://app.cheetahrides.com/uploads/1638537721170.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-04 12:54:17'),
(240, 101, '21', 'https://app.cheetahrides.com/uploads/1636013656469.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-11-04 14:49:38'),
(241, 101, '12', 'https://app.cheetahrides.com/uploads/1636013667413.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-11-04 14:50:13'),
(242, 101, '13', 'https://app.cheetahrides.com/uploads/1636013676280.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-11-04 14:50:22'),
(250, 101, '14', 'https://app.cheetahrides.com/uploads/1636016500809.jpeg', NULL, 'ACTIVE', NULL, NULL, '2021-11-04 15:01:59'),
(244, 101, '15', 'https://app.cheetahrides.com/uploads/1636013706682.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-11-04 14:52:27'),
(245, 101, '16', 'https://app.cheetahrides.com/uploads/1636013722154.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-11-04 14:54:01'),
(246, 101, '17', 'https://app.cheetahrides.com/uploads/1636013732179.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-11-04 14:55:57'),
(247, 101, '22', 'https://app.cheetahrides.com/uploads/1636013749921.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-11-04 14:57:00'),
(251, 97, '21', 'https://app.cheetahrides.com/uploads/1636535321821.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-11-10 17:36:32'),
(252, 97, '16', 'https://app.cheetahrides.com/uploads/1636535338586.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-11-10 17:36:43'),
(253, 97, '22', 'https://app.cheetahrides.com/uploads/1636535351638.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-11-10 17:37:04'),
(254, 97, '17', 'https://app.cheetahrides.com/uploads/1636535415023.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-11-10 17:37:17'),
(255, 97, '15', 'https://app.cheetahrides.com/uploads/1636535431935.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-11-10 17:37:28'),
(256, 97, '14', 'https://app.cheetahrides.com/uploads/1636535463538.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-11-10 17:37:42'),
(257, 97, '12', 'https://app.cheetahrides.com/uploads/1636535532587.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-11-10 17:37:56'),
(258, 97, '13', 'https://app.cheetahrides.com/uploads/1636535544533.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-11-10 17:38:07'),
(259, 105, '21', 'https://app.cheetahrides.com/uploads/1637733155734.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-11-24 16:09:54'),
(260, 105, '12', 'https://app.cheetahrides.com/uploads/1637733169987.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-11-24 16:12:42'),
(261, 105, '13', 'https://app.cheetahrides.com/uploads/1637733178504.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-11-24 16:12:51'),
(262, 105, '14', 'https://app.cheetahrides.com/uploads/1637733191012.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-11-24 16:13:06'),
(263, 105, '15', 'https://app.cheetahrides.com/uploads/1637733203581.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-11-24 16:13:23'),
(264, 105, '16', 'https://app.cheetahrides.com/uploads/1637733214013.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-11-24 16:13:34'),
(265, 105, '17', 'https://app.cheetahrides.com/uploads/1637733223247.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-11-24 16:13:43'),
(266, 105, '22', 'https://app.cheetahrides.com/uploads/1637733232433.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-11-24 16:10:55'),
(267, 106, '22', 'https://app.cheetahrides.com/uploads/1638196972666.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-11-30 03:36:07'),
(268, 106, '13', 'https://app.cheetahrides.com/uploads/1638197013582.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-11-30 03:36:21'),
(269, 106, '12', 'https://app.cheetahrides.com/uploads/1638197035148.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-11-30 03:36:43'),
(270, 106, '21', 'https://app.cheetahrides.com/uploads/1638197065401.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-11-30 03:39:38'),
(271, 106, '17', 'https://app.cheetahrides.com/uploads/1638197088201.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-11-30 03:39:52'),
(272, 106, '14', 'https://app.cheetahrides.com/uploads/1638197160924.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-11-30 03:40:15'),
(273, 106, '15', 'https://app.cheetahrides.com/uploads/1638197186632.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-11-30 03:40:34'),
(274, 106, '16', 'https://app.cheetahrides.com/uploads/1638197322110.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-11-30 03:41:01'),
(275, 108, '21', 'https://app.cheetahrides.com/uploads/1638275278610.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-01 03:56:08'),
(276, 108, '17', 'https://app.cheetahrides.com/uploads/1638275306398.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-01 03:56:21'),
(277, 108, '16', 'https://app.cheetahrides.com/uploads/1638275329988.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-01 03:56:39'),
(278, 108, '12', 'https://app.cheetahrides.com/uploads/1638275427257.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-01 03:56:58'),
(279, 108, '13', 'https://app.cheetahrides.com/uploads/1638275449294.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-01 03:57:16'),
(280, 108, '14', 'https://app.cheetahrides.com/uploads/1638275477895.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-01 03:57:49'),
(281, 108, '15', 'https://app.cheetahrides.com/uploads/1638275500123.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-01 03:58:06'),
(282, 108, '22', 'https://app.cheetahrides.com/uploads/1638275593964.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-01 03:58:47'),
(296, 109, '12', 'https://app.cheetahrides.com/uploads/1638342352267.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-01 14:06:45'),
(297, 109, '21', 'https://app.cheetahrides.com/uploads/1638342431734.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-01 14:10:22'),
(285, 109, '13', 'https://app.cheetahrides.com/uploads/1638301879705.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-01 04:01:08'),
(295, 109, '22', 'https://app.cheetahrides.com/uploads/1638340280607.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-01 14:09:49'),
(287, 109, '15', 'https://app.cheetahrides.com/uploads/1638301935892.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-01 04:13:51'),
(288, 109, '16', 'https://app.cheetahrides.com/uploads/1638301960111.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-01 04:11:14'),
(294, 109, '17', 'https://app.cheetahrides.com/uploads/1638340260479.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-01 14:09:10'),
(293, 109, '14', 'https://app.cheetahrides.com/uploads/1638340245851.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-01 14:07:00'),
(298, 112, '21', 'https://app.cheetahrides.com/uploads/1638359736418.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-01 21:22:57'),
(299, 112, '13', 'https://app.cheetahrides.com/uploads/1638359772787.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-01 21:23:12'),
(311, 113, '14', 'https://app.cheetahrides.com/uploads/1638537758040.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-04 12:53:42'),
(301, 112, '12', 'https://app.cheetahrides.com/uploads/1638359831611.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-01 21:23:39'),
(302, 112, '14', 'https://app.cheetahrides.com/uploads/1638359866870.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-01 21:23:50'),
(303, 112, '16', 'https://app.cheetahrides.com/uploads/1638359889727.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-01 21:24:12'),
(304, 112, '17', 'https://app.cheetahrides.com/uploads/1638359911734.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-01 21:24:25'),
(305, 112, '22', 'https://app.cheetahrides.com/uploads/1638359958232.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-01 21:22:38'),
(312, 113, '15', 'https://app.cheetahrides.com/uploads/1638537773510.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-04 12:54:54'),
(313, 113, '16', 'https://app.cheetahrides.com/uploads/1638537786338.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-04 12:55:27'),
(314, 113, '17', 'https://app.cheetahrides.com/uploads/1638537800219.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-04 12:55:58'),
(315, 113, '22', 'https://app.cheetahrides.com/uploads/1638537851194.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-04 12:56:26'),
(316, 116, '22', 'https://app.cheetahrides.com/uploads/1638739051317.jpg', NULL, 'ASSESSING', NULL, NULL, NULL),
(317, 116, '12', 'https://app.cheetahrides.com/uploads/1638739178797.jpg', NULL, 'ASSESSING', NULL, NULL, NULL),
(318, 116, '13', 'https://app.cheetahrides.com/uploads/1638739196773.jpg', NULL, 'ASSESSING', NULL, NULL, NULL),
(319, 0, '', 'https://app.cheetahrides.com/uploads/1638739524836.jpg', NULL, 'ASSESSING', NULL, NULL, NULL),
(320, 116, '15', 'https://app.cheetahrides.com/uploads/1638739545990.jpg', NULL, 'ASSESSING', NULL, NULL, NULL),
(321, 116, '14', 'https://app.cheetahrides.com/uploads/1638739561860.jpg', NULL, 'ASSESSING', NULL, NULL, NULL),
(322, 121, '21', 'https://app.cheetahrides.com/uploads/1638821737043.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-07 06:26:57'),
(323, 120, '21', 'https://app.cheetahrides.com/uploads/1638859473302.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-08 22:43:08'),
(327, 120, '17', 'https://app.cheetahrides.com/uploads/1638859516423.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-08 22:52:53'),
(328, 120, '22', 'https://app.cheetahrides.com/uploads/1638859523727.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-08 22:52:11'),
(329, 102, '21', 'https://app.cheetahrides.com/uploads/1638870805441.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-07 16:55:32'),
(330, 102, '12', 'https://app.cheetahrides.com/uploads/1638870819856.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-07 16:55:49'),
(331, 102, '14', 'https://app.cheetahrides.com/uploads/1638870839830.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-07 16:55:59'),
(332, 102, '15', 'https://app.cheetahrides.com/uploads/1638870853982.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-07 16:56:09'),
(333, 102, '22', 'https://app.cheetahrides.com/uploads/1638870882587.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-07 16:56:19'),
(334, 120, '13', 'https://app.cheetahrides.com/uploads/1638886564199.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-08 22:44:54'),
(335, 120, '12', 'https://app.cheetahrides.com/uploads/1638886570563.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-08 22:44:15'),
(336, 123, '21', 'https://app.cheetahrides.com/cabuser/includes/uploads/1638901071998.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-07 20:18:56'),
(337, 123, '21', 'https://app.cheetahrides.com/cabuser/includes/uploads/1638901093156.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-07 20:19:10'),
(338, 124, '21', 'https://app.cheetahrides.com/cabuser/includes/uploads/1638956344287.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-09 20:39:41'),
(339, 124, '12', 'https://app.cheetahrides.com/cabuser/includes/uploads/1638956676319.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-09 20:40:13'),
(340, 124, '13', 'https://app.cheetahrides.com/cabuser/includes/uploads/1638956688111.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-09 20:40:28'),
(341, 124, '14', 'https://app.cheetahrides.com/cabuser/includes/uploads/1638956704903.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-09 20:40:41'),
(342, 124, '15', 'https://app.cheetahrides.com/cabuser/includes/uploads/1638956719686.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-09 20:40:57'),
(343, 124, '16', 'https://app.cheetahrides.com/cabuser/includes/uploads/1638956733597.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-09 20:41:08'),
(344, 124, '17', 'https://app.cheetahrides.com/cabuser/includes/uploads/1638956750447.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-09 20:41:19'),
(345, 103, '13', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639035770535.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-10 08:35:56'),
(355, 127, '21', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639218114437.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-11 13:43:27'),
(347, 103, '12', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639035811264.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-10 08:37:25'),
(381, 140, '21', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639651510312.jpg', NULL, 'ASSESSING', NULL, NULL, NULL),
(349, 103, '16', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639077306722.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-10 08:38:03'),
(350, 103, '21', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639077320949.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-10 08:38:17'),
(351, 103, '17', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639077333185.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-10 08:38:27'),
(352, 103, '15', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639117199928.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-10 08:38:42'),
(353, 103, '14', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639117526607.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-10 08:38:53'),
(363, 128, '21', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639288737340.jpg', NULL, 'ASSESSING', NULL, NULL, NULL),
(357, 127, '22', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639218164241.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-11 13:46:03'),
(358, 127, '16', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639218184749.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-11 13:46:16'),
(359, 127, '12', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639218889548.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-11 13:46:30'),
(360, 127, '14', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639218900706.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-11 13:46:45'),
(361, 127, '15', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639218911200.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-11 13:46:59'),
(362, 127, '17', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639218924067.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-11 13:47:13'),
(364, 128, '12', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639288759481.JPG', NULL, 'ASSESSING', NULL, NULL, NULL),
(365, 129, '21', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639303638793.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-12 12:21:34'),
(366, 130, '21', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639306260227.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-12 12:54:34'),
(367, 131, '21', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639307562876.jpg', NULL, 'ASSESSING', NULL, NULL, NULL),
(368, 132, '21', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639309191859.jpg', NULL, 'ASSESSING', NULL, NULL, NULL),
(369, 134, '21', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639325204542.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-12 18:16:12'),
(370, 135, '21', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639326362036.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-12 18:26:38'),
(371, 139, '12', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639483969768.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-14 15:17:17'),
(372, 139, '13', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639483990226.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-14 15:17:29'),
(382, 140, '12', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639651542508.jpg', NULL, 'ASSESSING', NULL, NULL, NULL),
(374, 139, '22', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639484035855.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-14 15:18:16'),
(375, 139, '21', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639484159933.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-14 15:18:30'),
(376, 139, '15', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639484172536.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-14 15:18:47'),
(377, 139, '16', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639484181785.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-14 15:19:30'),
(378, 139, '17', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639484191865.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-14 15:19:44'),
(383, 139, '14', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639664800766.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-18 13:35:09'),
(385, 107, '21', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639812591425.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-18 10:08:27'),
(386, 107, '12', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639812610304.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-18 10:08:40'),
(387, 107, '13', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639812626931.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-18 10:08:48'),
(388, 107, '14', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639812644895.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-18 10:09:19'),
(389, 107, '15', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639812658475.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-18 10:09:35'),
(390, 107, '16', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639812672559.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-18 10:09:56'),
(391, 107, '17', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639812685985.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-18 10:10:30'),
(392, 107, '22', 'https://app.cheetahrides.com/cabuser/includes/uploads/1639812699055.jpg', NULL, 'ACTIVE', NULL, NULL, '2021-12-18 10:10:49');

-- --------------------------------------------------------

--
-- Table structure for table `provider_profiles`
--

CREATE TABLE `provider_profiles` (
  `id` int UNSIGNED NOT NULL,
  `provider_id` int NOT NULL,
  `language` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_secondary` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `postal_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `provider_profiles`
--

INSERT INTO `provider_profiles` (`id`, `provider_id`, `language`, `address`, `address_secondary`, `city`, `country`, `postal_code`, `created_at`, `updated_at`) VALUES
(1, 41, NULL, NULL, NULL, NULL, NULL, NULL, '2020-10-24 08:48:22', '2020-10-24 08:48:22'),
(2, 42, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-10 02:26:44', '2020-11-10 02:26:44'),
(3, 52, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-12 19:44:46', '2020-11-12 19:44:46'),
(4, 53, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-12 20:07:04', '2020-11-12 20:07:04'),
(5, 54, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-12 20:07:49', '2020-11-12 20:07:49'),
(6, 59, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-13 23:44:28', '2020-11-13 23:44:28'),
(7, 62, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-15 13:49:34', '2020-11-15 13:49:34'),
(8, 66, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-15 21:15:32', '2020-11-15 21:15:32'),
(9, 70, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-27 20:04:14', '2020-11-27 20:04:14'),
(10, 75, NULL, NULL, NULL, NULL, NULL, NULL, '2020-12-08 06:59:39', '2020-12-08 06:59:39'),
(11, 76, NULL, NULL, NULL, NULL, NULL, NULL, '2020-12-15 02:50:17', '2020-12-15 02:50:17'),
(12, 80, NULL, NULL, NULL, NULL, NULL, NULL, '2021-02-02 04:06:26', '2021-02-02 04:06:26'),
(13, 81, NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-01 03:08:22', '2021-03-01 03:08:22'),
(14, 79, NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-07 00:13:14', '2021-04-07 00:13:14'),
(15, 88, NULL, NULL, NULL, NULL, NULL, NULL, '2021-05-13 05:03:54', '2021-05-13 05:03:54'),
(16, 90, NULL, NULL, NULL, NULL, NULL, NULL, '2021-05-14 23:23:25', '2021-05-14 23:23:25'),
(17, 87, NULL, NULL, NULL, NULL, NULL, NULL, '2021-06-13 15:25:32', '2021-06-13 15:25:32'),
(18, 106, NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-30 10:20:27', '2021-11-30 10:20:27'),
(19, 123, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-11 15:40:46', '2021-12-11 15:40:46'),
(20, 130, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-17 20:23:33', '2021-12-17 20:23:33');

-- --------------------------------------------------------

--
-- Table structure for table `provider_services`
--

CREATE TABLE `provider_services` (
  `id` int UNSIGNED NOT NULL,
  `provider_id` int NOT NULL,
  `service_type_id` int NOT NULL,
  `status` enum('active','offline','riding') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `service_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `service_model` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `provider_services`
--

INSERT INTO `provider_services` (`id`, `provider_id`, `service_type_id`, `status`, `service_number`, `service_model`, `created_at`, `updated_at`) VALUES
(45, 41, 1, 'offline', 'abp 2020', 'Toyota ', '2020-10-17 19:40:25', '2020-11-15 21:05:02'),
(49, 45, 3, 'offline', 'baa 4545', 'Audi', '2020-10-21 09:19:26', '2020-10-28 00:58:15'),
(58, 52, 1, 'riding', 'Baa 3598', 'toyota corolla', '2020-11-12 19:29:38', '2021-03-25 23:43:51'),
(60, 54, 1, 'riding', 'ALJ 2989', 'sprinter corolla', '2020-11-12 19:41:48', '2021-11-28 22:41:34'),
(61, 53, 1, 'riding', 'AEB 1556', 'Spacio White', '2020-11-12 20:04:02', '2021-11-18 16:05:29'),
(62, 55, 1, 'offline', 'ADB2749', 'toyota sprinter', '2020-11-12 21:39:16', '2020-11-12 21:39:16'),
(63, 56, 1, 'active', 'AIC 6061', 'toyota vits', '2020-11-12 21:47:01', '2020-11-12 21:47:01'),
(64, 57, 1, 'active', 'ABM 3603', 'toyota calina', '2020-11-13 22:24:18', '2020-11-14 23:38:45'),
(65, 58, 1, 'active', 'ALH 6990', 'spacio blue', '2020-11-13 23:03:55', '2020-11-14 14:28:23'),
(66, 59, 1, 'riding', 'ALH5765', 'spacio sliver', '2020-11-13 23:34:39', '2021-03-26 00:06:19'),
(67, 60, 1, 'offline', 'BAJ 9462', 'Toyota Allion', '2020-11-15 01:54:34', '2020-11-15 01:54:34'),
(70, 63, 1, 'active', 'BAF 2002', 'Toyota white', '2020-11-15 14:44:24', '2020-11-15 14:44:24'),
(71, 64, 1, 'offline', 'Baf 202', 'Toyota white', '2020-11-15 14:49:04', '2020-11-15 18:11:31'),
(78, 69, 16, 'offline', 'BAF 9377', 'Toyota  RunX', '2020-11-17 09:06:36', '2020-11-17 15:02:27'),
(81, 71, 1, 'active', 'BAG 7320', 'Toyoya White', '2020-11-28 06:04:46', '2020-12-07 01:34:08'),
(94, 82, 20, 'offline', 'bap 12234', 'Nissan white', '2021-03-05 05:58:31', '2021-03-13 05:54:49'),
(104, 92, 1, 'offline', 'ABE 5019', 'Toyota sprinter box type', '2021-06-07 16:20:14', '2021-06-07 16:20:14'),
(105, 93, 1, 'active', '4558', 'Honda vits ', '2021-06-09 23:31:22', '2021-06-09 23:31:22'),
(108, 95, 1, 'active', 'Bae 2196', 'Silver Toyota Allex', '2021-08-22 17:43:02', '2021-09-29 13:15:32'),
(109, 96, 1, 'active', 'BLA 6694', 'HONDA CRV, SILVER ', '2021-11-02 13:01:56', '2021-11-02 13:01:56'),
(110, 97, 1, 'active', 'AIC 9384zm ', 'Toyota Axio', '2021-11-02 23:43:36', '2021-11-02 23:43:36'),
(111, 98, 1, 'active', 'BAJ7428', 'pearl', '2021-11-03 15:10:44', '2021-11-03 15:10:44'),
(112, 99, 1, 'active', 'AJE 1102', 'Toyota vitz blue', '2021-11-03 15:24:13', '2021-11-03 15:24:13'),
(113, 100, 1, 'active', 'BAD 7227', 'spacio sliver', '2021-11-03 15:31:21', '2021-11-03 15:31:21'),
(116, 101, 1, 'active', 'ALE 3375', 'TOYOTA COROLLA WHITE', '2021-11-04 15:03:05', '2021-12-12 16:23:45'),
(118, 103, 1, 'active', 'ALV 7913', 'runx  silver', '2021-11-11 19:25:38', '2021-11-11 19:25:38'),
(119, 104, 1, 'active', 'BAJ2604', 'Toyota Belta , White ', '2021-11-19 00:36:16', '2021-11-19 00:36:16'),
(121, 105, 1, 'offline', 'ALT 2515', 'Toyota Premio', '2021-11-23 11:56:28', '2021-12-09 01:04:42'),
(122, 106, 1, 'offline', 'BBA 6862', 'TOYOTA RUSH(2008), PEARL(WHITE)', '2021-11-29 21:40:38', '2021-12-18 19:52:02'),
(123, 107, 1, 'offline', 'BAL 8499', 'Mark x pearl', '2021-11-30 15:53:10', '2021-12-18 10:49:44'),
(124, 108, 1, 'active', 'BAK1449', 'Toyota Allion White', '2021-11-30 19:23:54', '2021-12-04 00:08:09'),
(126, 110, 1, 'active', 'ALJ 2091', 'mistubish colt', '2021-12-01 12:23:10', '2021-12-01 12:23:10'),
(127, 109, 1, 'active', 'BAJ 3303', 'Toyota Blue', '2021-12-01 14:14:17', '2021-12-01 14:46:46'),
(128, 111, 1, 'active', 'ALG 4823', 'Toyota RunX Gold', '2021-12-01 14:19:34', '2021-12-01 14:19:34'),
(129, 112, 1, 'active', 'BAB7016', 'Toyota Runx Silver ', '2021-12-01 18:49:54', '2021-12-01 18:49:54'),
(130, 113, 1, 'offline', 'ALM 902', 'Toyota Chaser', '2021-12-03 20:16:01', '2021-12-05 11:18:17'),
(131, 114, 1, 'active', 'Alt 641', 'Toyota Corolla', '2021-12-04 13:02:46', '2021-12-04 13:02:46'),
(132, 115, 1, 'active', 'ALJ8020', 'Honda CRV RD1', '2021-12-05 14:14:04', '2021-12-05 14:14:04'),
(133, 116, 1, 'active', 'bcc 7001', 'Nissan Gold', '2021-12-06 04:16:51', '2021-12-06 04:16:51'),
(135, 102, 1, 'active', 'ALR 8795', 'Toyota Silver', '2021-12-06 05:24:21', '2021-12-12 17:28:14'),
(136, 117, 1, 'active', 'AQB 648', 'allion', '2021-12-06 11:15:52', '2021-12-06 11:15:52'),
(137, 118, 1, 'active', 'ACX 4016', 'Toyota allion grey', '2021-12-06 15:47:08', '2021-12-06 15:47:08'),
(138, 119, 1, 'active', 'BAD 333', 'vits white', '2021-12-06 21:00:51', '2021-12-06 21:00:51'),
(139, 120, 1, 'active', 'ALP 5630', 'Toyota', '2021-12-07 02:36:16', '2021-12-07 02:36:16'),
(140, 121, 1, 'active', 'FGH 3443', 'Suzuki Red', '2021-12-07 03:14:24', '2021-12-07 03:14:24'),
(141, 122, 1, 'active', 'adf', 'ada', '2021-12-07 21:14:29', '2021-12-07 21:14:29'),
(143, 124, 1, 'active', 'BCB 9880', 'beige Toyota ist', '2021-12-08 11:30:01', '2021-12-08 11:30:01'),
(145, 126, 1, 'active', 'BAE6641', 'white ', '2021-12-10 20:14:58', '2021-12-10 20:14:58'),
(146, 127, 1, 'active', 'AIB9360ZM ', 'Honda Grey', '2021-12-11 12:17:59', '2021-12-11 12:17:59'),
(147, 128, 1, 'offline', 'bap 4545', 'Toyota white', '2021-12-12 07:58:00', '2021-12-12 10:07:37'),
(148, 129, 1, 'offline', 'BBC 123', 'Toyota blue', '2021-12-12 12:05:35', '2021-12-12 12:42:53'),
(149, 130, 1, 'active', 'bap 2020', 'Toyota yellow', '2021-12-12 12:50:33', '2021-12-18 12:38:13'),
(150, 131, 1, 'offline', 'bba 22', 'Toyota white', '2021-12-12 13:12:21', '2021-12-12 13:35:51'),
(151, 132, 1, 'active', 'ksks', 'today ', '2021-12-12 13:39:23', '2021-12-12 13:41:47'),
(152, 133, 17, 'active', 'BAV 1397', 'black', '2021-12-12 15:33:51', '2021-12-12 15:33:51'),
(153, 134, 1, 'offline', '3375', 'corolla vvti', '2021-12-12 18:05:58', '2021-12-18 23:26:07'),
(155, 136, 1, 'active', 'ABZ 2014', 'corolla VVTI', '2021-12-13 12:06:31', '2021-12-13 12:06:31'),
(156, 137, 1, 'active', 'abf 2542', 'corroll', '2021-12-13 16:34:02', '2021-12-13 16:34:02'),
(161, 123, 1, 'active', 'BAJ 3303', 'Toyota Blue', '2021-12-14 08:58:30', '2021-12-19 09:02:13'),
(162, 138, 1, 'active', 'ABA 1617', 'grey', '2021-12-14 10:46:35', '2021-12-14 10:46:35'),
(164, 140, 1, 'active', 'BAT 2928', 'toyota allex', '2021-12-16 11:30:40', '2021-12-16 11:30:40'),
(165, 141, 1, 'offline', 'BAJ 3303', 'Toyota Blue', '2021-12-18 10:27:43', '2021-12-18 10:27:43'),
(166, 135, 1, 'active', 'ALR 8795', 'Toyota Silver', '2021-12-18 13:39:06', '2021-12-19 11:29:27'),
(167, 139, 1, 'active', 'AGB 4719', 'IST Silver', '2021-12-18 13:40:04', '2021-12-18 13:40:04'),
(168, 143, 1, 'active', 'ACX5152', 'funcargo/silver', '2021-12-18 19:53:10', '2021-12-18 19:53:10'),
(169, 144, 1, 'active', 'ABL 4549', 'Toyota Duet White', '2021-12-19 02:00:39', '2021-12-19 02:00:39');

-- --------------------------------------------------------

--
-- Table structure for table `request_filters`
--

CREATE TABLE `request_filters` (
  `id` int UNSIGNED NOT NULL,
  `request_id` int NOT NULL,
  `provider_id` int NOT NULL,
  `status` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `request_filters`
--

INSERT INTO `request_filters` (`id`, `request_id`, `provider_id`, `status`, `created_at`, `updated_at`) VALUES
(1692, 128, 43, 0, '2020-10-24 16:08:17', '2020-10-24 16:08:17'),
(1691, 128, 41, 2, '2020-10-24 16:08:17', '2020-10-24 16:08:35'),
(1512, 13, 41, 0, '2020-10-18 01:28:39', '2020-10-18 01:28:39'),
(2965, 771, 80, 0, '2021-03-25 23:46:50', '2021-03-25 23:46:50'),
(2964, 771, 79, 2, '2021-03-25 23:46:50', '2021-03-25 23:47:10'),
(3243, 1031, 80, 0, '2021-10-23 02:17:40', '2021-10-23 02:17:40'),
(3425, 1199, 80, 2, '2021-11-20 17:55:12', '2021-11-20 17:55:31'),
(4760, 1657, 130, 2, '2021-12-18 12:44:11', '2021-12-18 12:44:16'),
(4612, 1614, 135, 2, '2021-12-17 16:55:34', '2021-12-17 16:55:48');

-- --------------------------------------------------------

--
-- Table structure for table `service_types`
--

CREATE TABLE `service_types` (
  `id` int UNSIGNED NOT NULL,
  `type` enum('daily','economy','luxury','extra_seat','outstation') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'economy',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `provider_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `map_icon` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `capacity` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `fixed` int NOT NULL,
  `price` float NOT NULL,
  `apply_after_1` double(10,2) NOT NULL DEFAULT '0.00',
  `apply_after_2` double(10,2) NOT NULL DEFAULT '0.00',
  `apply_after_3` double(10,2) NOT NULL DEFAULT '0.00',
  `after_1_price` double(10,2) NOT NULL DEFAULT '0.00',
  `after_2_price` double(10,2) NOT NULL DEFAULT '0.00',
  `after_3_price` double(10,2) NOT NULL DEFAULT '0.00',
  `after_1_minute` double(10,2) NOT NULL DEFAULT '0.00',
  `after_2_minute` double(10,2) NOT NULL DEFAULT '0.00',
  `after_3_minute` double(10,2) NOT NULL DEFAULT '0.00',
  `phourfrom` time DEFAULT NULL,
  `phourto` time DEFAULT NULL,
  `pextra` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `minute` float NOT NULL,
  `distance` float NOT NULL,
  `calculator` enum('MIN','HOUR','DISTANCE','DISTANCEMIN','DISTANCEHOUR') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `service_types`
--

INSERT INTO `service_types` (`id`, `type`, `name`, `provider_name`, `image`, `map_icon`, `capacity`, `fixed`, `price`, `apply_after_1`, `apply_after_2`, `apply_after_3`, `after_1_price`, `after_2_price`, `after_3_price`, `after_1_minute`, `after_2_minute`, `after_3_minute`, `phourfrom`, `phourto`, `pextra`, `minute`, `distance`, `calculator`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'economy', 'Taxi', 'Cheetah', 'https://app.cheetahrides.com/uploads/1c636342ad52f27333899f3de7847ffc0f5c3f08.png', 'https://app.cheetahrides.com/uploads/f507352f6323d3fccaae93366d6ac1af793b8be6.png', '3', 45, 10.2, 0.00, 15.50, 0.00, 10.20, 10.15, 0.00, 0.00, 0.00, 0.00, '00:00:00', '04:59:00', '5', 0.3, 4, 'DISTANCE', 'Size(LxBxH): 7ftx4.5ftx5.5ft\n\n Capacity: 800kg', 1, '2017-12-08 20:12:27', '2021-12-18 23:43:20'),
(3, 'economy', 'Luxury  Express', 'Cheetah', 'https://app.cheetahrides.com/uploads/b0a91dba618d21a9c9edb8d25d227d06c39a63ae.png', 'https://app.cheetahrides.com/uploads/4ba1e6042c7519f25372367762f808b33f596ea6.png', '2', 65, 11.9, 0.00, 15.00, 0.00, 11.90, 12.11, 0.00, 0.00, 0.00, 0.00, '00:00:00', '04:59:00', '5', 0.6, 4, 'DISTANCE', 'Size(LxBxH): 9ftx5.5ftx6.5ft\r\n\r\n Capacity: 800kg', 1, '2017-12-08 20:12:27', '2021-12-18 23:44:21'),
(13, 'extra_seat', 'Tow Truck', 'Cheetah', 'https://app.cheetahrides.com/uploads/dd0dd183236712d80a0b0120bbb8d2ceeadc39f7.png', 'https://app.cheetahrides.com/uploads/0c18bfb5ac8964dd666763e8fd430359d756f8c2.png', '2', 500, 67.4, 2.00, 15.50, 0.00, 0.00, 17.20, 0.00, 0.00, 0.00, 0.00, '19:00:00', '04:30:00', '0', 10, 3, 'DISTANCE', 'Tow Truck Fixed', 0, '2020-03-09 13:06:52', '2021-05-11 02:18:38'),
(16, 'luxury', 'Delivery Van', 'Cheetah', 'https://app.cheetahrides.com/uploads/9259fa2bd44490467ff9c0ebb97d6ed46432dc5e.png', 'https://app.cheetahrides.com/uploads/720544d0fe6ec5231b0181e6e26c4c57aca28a36.png', '2', 400, 70.5, 4.00, 5.00, 15.00, 0.00, 80.20, 40.00, 0.00, 0.00, 0.00, '21:29:00', '04:49:00', '0', 0, 2, 'DISTANCE', 'Size(LxBxH): 9ftx5.5ftx6.5ft\r\n\r\n\r\nCapacity: 1500kg', 0, '2020-04-07 14:43:11', '2021-05-12 23:50:39'),
(17, 'luxury', 'Delivery Bike', 'Cheetah', 'https://app.cheetahrides.com/uploads/55f11a1686a2dab295fab4bb2f10aabb0ad2d101.png', 'https://app.cheetahrides.com/uploads/e71ee634211f63b8602827a5c2cf83b7ddf86c1e.png', '0', 40, 9.8, 5.00, 10.00, 15.00, 9.80, 9.15, 7.80, 0.00, 0.00, 0.00, '19:00:00', '04:30:00', '2', 0.15, 5, 'DISTANCE', 'Delivery Bike 8Kg', 0, '2020-04-07 14:44:58', '2021-07-31 04:45:20'),
(20, 'outstation', 'Kids  Pickup', 'Cheetah', 'https://app.cheetahrides.com/uploads/bcd7aa27ece39e3a46c9cb449f19de2e3e6ed84a.png', 'https://app.cheetahrides.com/uploads/88ddb668772aebe34d8a322ef4137d5b934d562b.png', '3', 50, 10.4, 0.00, 15.00, 0.00, 0.00, 9.80, 0.00, 0.00, 0.00, 0.00, '23:50:00', '05:50:00', '1', 0.5, 4, 'DISTANCE', 'kids pickup saloon vehicle', 0, '2021-03-05 05:48:27', '2021-03-05 06:18:06');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int UNSIGNED NOT NULL,
  `key` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`) VALUES
(1, 'site_title', 'Cheetah'),
(2, 'site_logo', 'https://app.cheetahrides.com/uploads/f20b21d061a7403bf21d11ede84225c436f2d382.png'),
(3, 'site_email_logo', ''),
(4, 'site_icon', 'https://app.cheetahrides.com/uploads/fddbb8cf647f97ab71d61535938bb890598dcc56.png'),
(92, 'sos_number', '0975168880'),
(85, 'contact_number', '+260975168880'),
(8, 'base_price', '50'),
(9, 'price_per_minute', '50'),
(10, 'tax_percentage', '0'),
(11, 'stripe_secret_key', 'sk_test_exvCGYCBcEqNYEsUxV7PpeaJ00q8FoLMSO'),
(12, 'stripe_publishable_key', 'pk_test_8lVabGV5Gsvls06hxAdPNc3900PCsawopA'),
(13, 'CASH', '1'),
(14, 'CARD', '0'),
(15, 'manual_request', '0'),
(16, 'default_lang', 'en'),
(17, 'currency', 'ZK'),
(18, 'distance', 'Km'),
(19, 'scheduled_cancel_time_exceed', '10'),
(20, 'price_per_kilometer', '10'),
(21, 'commission_percentage', '10'),
(91, 'provider_search_radius', '3'),
(24, 'daily_target', '20'),
(25, 'surge_percentage', '5'),
(26, 'surge_trigger', '0'),
(27, 'demo_mode', '0'),
(28, 'booking_prefix', 'KWD'),
(89, 'store_link_ios', ''),
(90, 'provider_select_timeout', '70'),
(34, 'fb_app_version', ''),
(35, 'fb_app_id', ''),
(36, 'fb_app_secret', ''),
(37, 'f_email', 'admin@cheetahrides.com'),
(38, 'f_mobile', '+260761231220'),
(39, 'f_mainBanner', 'https://images.unsplash.com/photo-1490650404312-a2175773bbf5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&w=1000&q=80'),
(121, 'cat_web_ecomony', '1'),
(45, 'f_u_url', 'https://play.google.com/store/apps/details?id=com.kwendaapp.rideo'),
(46, 'f_pi_url', 'http://play.google.com/store/apps'),
(57, 'f_img2', ''),
(70, 'f_f_link', 'https://web.facebook.com/kwendaZM'),
(96, 'f_t_link', ''),
(72, 'f_l_link', ''),
(73, 'f_i_link', ''),
(75, 'contact_address', 'Lusaka, Zambia'),
(123, 'cat_web_ext', '1'),
(124, 'cat_web_out', '0'),
(126, 'longitude', '28.2839532'),
(77, 'contact_city', 'Lusaka'),
(94, 'map_key', 'AIzaSyDgxUkkfvb-L-bQyr5_WFbj18w2swdn1QY'),
(78, 'android_user_fcm_key', 'AAAAUVUR4b0:APA91bFrYaEw_BJcB64p3uacl4o21Sd-TRrvwlKWhZLwTQV8Al_-XQedQSytiFMi2uO9e2dS4QMVMnsJAcauFn4NaJL-_U_BjOvVeYDLhQrOX00QrWNsQXDbfC3fOQZMw0VA1WJyL27p'),
(79, 'android_user_driver_key', 'AAAAUVUR4b0:APA91bFrYaEw_BJcB64p3uacl4o21Sd-TRrvwlKWhZLwTQV8Al_-XQedQSytiFMi2uO9e2dS4QMVMnsJAcauFn4NaJL-_U_BjOvVeYDLhQrOX00QrWNsQXDbfC3fOQZMw0VA1WJyL27p'),
(86, 'contact_email', 'admin@cheetahrides.com'),
(93, 'social_login', '0'),
(122, 'cat_web_lux', '1'),
(115, 'verification', '0'),
(98, 'f_image1', 'https://taxitime.co.in/asset/img/photo-1490650404312-a2175773bbf5.jpg'),
(99, 'page_privacy', '<p><strong>Privacy Policy</strong></p>\r\n\r\n<p>Optimyze Technologies Limited built the Cheetah app as a Commercial app. This SERVICE is provided by Optimyze Technologies Limited and is intended for use as is.</p>\r\n\r\n<p>This page is used to inform visitors regarding our policies with the collection, use, and disclosure of Personal Information if anyone decided to use our Service.</p>\r\n\r\n<p>The terms used in this Privacy Policy have the same meanings as in our Terms and Conditions, which is accessible at Cheetah unless otherwise defined in this Privacy Policy. If you choose to use our Service, then you agree to the collection and use of information in relation to this policy. The Personal Information that we collect is used for providing and improving the Service. We will not use or share your information with anyone except as described in this Privacy Policy.</p>\r\n\r\n<p>Information Collection and Use</p>\r\n\r\n<p>For a better experience, while using our Service, we may require you to provide us with certain personally identifiable information. The information that we request will be retained by us and used as described in this privacy policy.</p>\r\n\r\n<p>The app does use third party services that may collect information used to identify you.</p>\r\n\r\n<p>Link to privacy policy of third party service providers used by the app</p>\r\n\r\n<p>Google Analytics for Firebase</p>\r\n\r\n<p>Firebase Crashlytics</p>\r\n\r\n<p>Log Data</p>\r\n\r\n<p>We want to inform you that whenever you use our Service, in a case of an error in the app we collect data and information (through third party products) on your phone called Log Data. This Log Data may include information such as your device Internet Protocol (&ldquo;IP&rdquo;) address, device name, operating system version, the configuration of the app when utilizing our Service, the time and date of your use of the Service, and other statistics.</p>\r\n\r\n<p>Cookies</p>\r\n\r\n<p>Cookies are files with a small amount of data that are commonly used as anonymous unique identifiers. These are sent to your browser from the websites that you visit and are stored on your devices internal memory.</p>\r\n\r\n<p>This Service does not use these &ldquo;cookies&rdquo; explicitly. However, the app may use third party code and libraries that use &ldquo;cookies&rdquo; to collect information and improve their services. You have the option to either accept or refuse these cookies and know when a cookie is being sent to your device. If you choose to refuse our cookies, you may not be able to use some portions of this Service.</p>\r\n\r\n<p>Service Providers</p>\r\n\r\n<p>We may employ third-party companies and individuals due to the following reasons:</p>\r\n\r\n<p>To facilitate our Service;</p>\r\n\r\n<p>To provide the Service on our behalf;</p>\r\n\r\n<p>To perform Service-related services; or</p>\r\n\r\n<p>To assist us in analyzing how our Service is used.</p>\r\n\r\n<p>We want to inform users of this Service that these third parties have access to your Personal Information. The reason is to perform the tasks assigned to them on our behalf. However, they are obligated not to disclose or use the information for any other purpose.</p>\r\n\r\n<p>Security</p>\r\n\r\n<p>We value your trust in providing us your Personal Information, thus we are striving to use commercially acceptable means of protecting it. But remember that no method of transmission over the internet, or method of electronic storage is 100% secure and reliable, and we cannot guarantee its absolute security.</p>\r\n\r\n<p>Links to Other Sites</p>\r\n\r\n<p>This Service may contain links to other sites. If you click on a third-party link, you will be directed to that site. Note that these external sites are not operated by us. Therefore, we strongly advise you to review the Privacy Policy of these websites. We have no control over and assume no responsibility for the content, privacy policies, or practices of any third-party sites or services.</p>\r\n\r\n<p>Children&rsquo;s Privacy</p>\r\n\r\n<p>These Services do not address anyone under the age of 13. We do not knowingly collect personally identifiable information from children under 13. In the case we discover that a child under 13 has provided us with personal information, we immediately delete this from our servers. If you are a parent or guardian and you are aware that your child has provided us with personal information, please contact us so that we will be able to do necessary actions.</p>\r\n\r\n<p>Changes to This Privacy Policy</p>\r\n\r\n<p>We may update our Privacy Policy from time to time. Thus, you are advised to review this page periodically for any changes. We will notify you of any changes by posting the new Privacy Policy on this page. These changes are effective immediately after they are posted on this page.</p>\r\n\r\n<p>Contact Us</p>\r\n\r\n<p>If you have any questions or suggestions about our Privacy Policy, do not hesitate to contact us at cheetahrides@optimyzetech.net</p>\r\n\r\n<p>This Privacy Policy explains how Cheetah collects, uses, shares and protects information about its partners. We also provide information regarding how you can access and update your information and how to use the personal information you encounter in your interaction with the Cheetah web and mobile services users.</p>\r\n\r\n<p>The Privacy Policy is incorporated by reference into the applicable Partners Contract.</p>\r\n\r\n<p>We reserve the right to change or modify this Policy or any of our tools or services at any time.</p>\r\n\r\n<p>- Personal data we process</p>\r\n\r\n<p>- Name, e-mail, phone number.</p>\r\n\r\n<p>- Geolocation of drivers and driving routes.</p>\r\n\r\n<p>- Information about vehicles (including registration number).</p>\r\n\r\n<p>- Drivers efficiency and ratings.</p>\r\n\r\n<p>- Drivers license, photo, profession and identification documents.</p>\r\n\r\n<p>Data about criminal convictions and offences. The financial data of providing transportation services is not considered as personal data, because drivers provide services in the course of economic and professional activities.</p>\r\n\r\n<p>- Purposes of the processing</p>\r\n\r\n<p>We collect and process personal data for the purpose of connecting customers and/or merchants with drivers to make deliveries through the Cheetah mobile and web platforms.</p>\r\n\r\n<p>Geolocation and driving routes are processed to analyse the geographical area and give suggestions to the drivers. ​If you do not want to disclose your geolocation for passengers, you must close the Cheetah application or indicate in the Cheetah application that you are offline and currently are not providing transportation services.</p>\r\n\r\n<p>Drivers license,&nbsp;identity documents and criminal convictions and offences are processed to determine the compliance with the legal requirements and your suitability as a driver on the Cheetah platform.</p>\r\n\r\n<p>The Cheetah platform displays drivers photo, name and vehicle details for the customers and/or Merchants to identify driver and vehicle.</p>\r\n\r\n<p>You will receive summaries from the Cheetah Platform, which will include your efficiency and ratings as a driver. Summary and ratings about driver are necessary to provide a reliable service for passengers.</p>\r\n\r\n<p>- Legal basis</p>\r\n\r\n<p>Personal data is processed for the performance of the contract concluded with the driver. The prerequisite for the use of the Cheetah services is the processing of drivers identification and geolocation data.</p>\r\n\r\n<p>Personal data may be processed on the ground of legitimate interest in investigating and detecting fraudulent payments.</p>\r\n\r\n<p>Data regarding the ​criminal convictions and offences is processed for compliance with a legal obligation.</p>\r\n\r\n<p>- Recipients</p>\r\n\r\n<p>Your personal data is only disclosed to customers and/or merchants, whose order has been accepted by you. Customers and/or merchants will see drivers name, vehicle, phone number, photo and geolocation data. Customers and/or merchants also see drivers personal data in the receipt.</p>\r\n\r\n<p>Processing of personal data by will occur under the same conditions as established in this privacy notice.</p>\r\n\r\n<p>- Security and access</p>\r\n\r\n<p>Any personal data collected in the course of providing services is transferred to, processed and stored in the United Kingdom. Only authorized partners and employees of Cheetah have access to the personal data and they may access the data only for the purpose of resolving issues associated with the use of the services (including disputes regarding delivery services). Your Personal Information may be subject to access requests from governments, courts, or law enforcement in the Republic of Zambia according to their laws. By using the Services or providing us with any information, you consent to this transfer, processing and storage of your information in the Republic of Zambia.</p>\r\n\r\n<p>- Processing passengers personal data</p>\r\n\r\n<p>You may not process the personal data of passengers without the permission of us. You may not contact any passenger or collect, record, store, grant access, use or cross-use the personal data provided by the passenger or accessible to you via the Cheetah platform for any reason other than for the purposes of fulfilling the delivery services.</p>\r\n\r\n<p>You must comply with the rules and conditions for processing of personal data of passengers as set forth in the Privacy Notice for Cheetah users(https://kwendazm.online/privacy). If you violate the requirements for the processing of personal data of passengers, we may terminate your drivers account and claim damages from you.</p>\r\n\r\n<p>- Access, correction, retention, deletion and data portability</p>\r\n\r\n<p>Personal data can be viewed and corrected in Cheetah Driver Platform.</p>\r\n\r\n<p>Your personal data will be stored as long as you have an active drivers account. If your account will be closed the personal data will be stored for additional 6 months&nbsp;period.</p>\r\n\r\n<p>Data necessary for accounting purposes shall be stored for 2&nbsp;years.</p>\r\n\r\n<p>In the event of suspicions of administrational or criminal offence, fraud or false information, the data shall be stored for 5&nbsp;years.</p>\r\n\r\n<p>In the event of disputes, the data shall be retained until the claim is satisfied or the expiry date of such claims.</p>\r\n\r\n<p>We respond to the request for deleting and transferring personal data submitted by an e-mail to admin@cheetahrides.com where you may specify the period of data deletion and transfer.</p>\r\n\r\n<p>- Location Information.&nbsp;</p>\r\n\r\n<p>Drivers: We collect your devices precise location when you open and use the Cheetah driver app, including while the app is running in the background from the time you request a ride until it ends.</p>\r\n\r\n<p>- Dispute resolution</p>\r\n\r\n<p>Disputes relating to the processing of personal data are resolved through customer support (admin@cheetahrides.com) ​</p>\r\n'),
(100, 'page_terms', '<p><strong>Terms &amp; Conditions</strong></p>\r\n\r\n<p>Welcome to Cheetah</p>\r\n\r\n<p>These terms and conditions outline the rules and regulations for the use of Cheetah app / Website, located at https://app.cheetahrides.com/</p>\r\n\r\n<p>By accessing this website or app, we assume you accept these terms and conditions. Do not continue to use Cheetah if you do not agree to take all of the terms and conditions stated on this page.</p>\r\n\r\n<p>The following terminology applies to these Terms and Conditions, Privacy Statement and Disclaimer Notice and all Agreements: &quot;Client&quot;, &quot;You&quot; and &quot;Your&quot; refers to you, the person log on this website and compliant to the Company terms and conditions. &quot;The Company&quot;, &quot;Ourselves&quot;, &quot;We&quot;, &quot;Our&quot; and &quot;Us&quot;, refers to our Company. &quot;Party&quot;, &quot;Parties&quot;, or &quot;Us&quot;, refers to both the Client and ourselves. All terms refer to the offer, acceptance and consideration of payment necessary to undertake the process of our assistance to the Client in the most appropriate manner for the express purpose of meeting the Client needs in respect of provision of the Company stated services, in accordance with and subject to, prevailing law of Netherlands. Any use of the above terminology or other words in the singular, plural, capitalization and/or he/she or they, are taken as interchangeable and therefore as referring to same.</p>\r\n\r\n<p><strong>Cookies</strong></p>\r\n\r\n<p>We employ the use of cookies. By accessing Cheetah, you agreed to use cookies in agreement with the Cheetah Privacy Policy.</p>\r\n\r\n<p>Most interactive websites use cookies to let us retrieve the user details for each visit. Cookies are used by our website to enable the functionality of certain areas to make it easier for people visiting our website. Some of our affiliate/advertising partners may also use cookies.</p>\r\n\r\n<p><strong>License</strong></p>\r\n\r\n<p>Unless otherwise stated, Cheetah and/or its licensors own the intellectual property rights for all material on Cheetah. All intellectual property rights are reserved. You may access this from Cheetah for your own personal use subjected to restrictions set in these terms and conditions.</p>\r\n\r\n<p>You must not:</p>\r\n\r\n<ul>\r\n	<li>Republish material from Cheetah</li>\r\n	<li>Sell, rent or sub-license material from Cheetah</li>\r\n	<li>Reproduce, duplicate or copy material from Cheetah</li>\r\n	<li>Redistribute content from Cheetah</li>\r\n</ul>\r\n\r\n<p>This Agreement shall begin on the date hereof.</p>\r\n\r\n<p>Parts of this website offer an opportunity for users to post and exchange opinions and information in certain areas of the website. Cheetah does not filter, edit, publish or review Comments prior to their presence on the website. Comments do not reflect the views and opinions of Cheetah,its agents and/or affiliates. Comments reflect the views and opinions of the person who post their views and opinions. To the extent permitted by applicable laws, Cheetah shall not be liable for the Comments or for any liability, damages or expenses caused and/or suffered as a result of any use of and/or posting of and/or appearance of the Comments on this website.</p>\r\n\r\n<p>Cheetah reserves the right to monitor all Comments and to remove any Comments which can be considered inappropriate, offensive or causes breach of these Terms and Conditions.</p>\r\n\r\n<p>You warrant and represent that:</p>\r\n\r\n<ul>\r\n	<li>You are entitled to post the Comments on our website and have all necessary licenses and consents to do so;</li>\r\n	<li>The Comments do not invade any intellectual property right, including without limitation copyright, patent or trademark of any third party;</li>\r\n	<li>The Comments do not contain any defamatory, libelous, offensive, indecent or otherwise unlawful material which is an invasion of privacy</li>\r\n	<li>The Comments will not be used to solicit or promote business or custom or present commercial activities or unlawful activity.</li>\r\n</ul>\r\n\r\n<p>You hereby grant Cheetah a non-exclusive license to use, reproduce, edit and authorize others to use, reproduce and edit any of your Comments in any and all forms, formats or media.</p>\r\n\r\n<p><strong>Hyperlinking to our Content</strong></p>\r\n\r\n<p>The following organizations may link to our Website without prior written approval:</p>\r\n\r\n<ul>\r\n	<li>Government agencies;</li>\r\n	<li>Search engines;</li>\r\n	<li>News organizations;</li>\r\n	<li>Online directory distributors may link to our Website in the same manner as they hyperlink to the Websites of other listed businesses; and</li>\r\n	<li>System wide Accredited Businesses except soliciting non-profit organizations, charity shopping malls, and charity fundraising groups which may not hyperlink to our Web site.</li>\r\n</ul>\r\n\r\n<p>These organizations may link to our home page, to publications or to other Website information so long as the link: (a) is not in any way deceptive; (b) does not falsely imply sponsorship, endorsement or approval of the linking party and its products and/or services; and (c) fits within the context of the linking party site.</p>\r\n\r\n<p>We may consider and approve other link requests from the following types of organizations:</p>\r\n\r\n<ul>\r\n	<li>commonly-known consumer and/or business information sources;</li>\r\n	<li>dot.com community sites;</li>\r\n	<li>associations or other groups representing charities;</li>\r\n	<li>online directory distributors;</li>\r\n	<li>internet portals;</li>\r\n	<li>accounting, law and consulting firms; and</li>\r\n	<li>educational institutions and trade associations.</li>\r\n</ul>\r\n\r\n<p>We will approve link requests from these organizations if we decide that: (a) the link would not make us look unfavorably to ourselves or to our accredited businesses; (b) the organization does not have any negative records with us; (c) the benefit to us from the visibility of the hyperlink compensates the absence of Cheetah; and (d) the link is in the context of general resource information.</p>\r\n\r\n<p>These organizations may link to our home page so long as the link: (a) is not in any way deceptive; (b) does not falsely imply sponsorship, endorsement or approval of the linking party and its products or services; and (c) fits within the context of the linking party site.</p>\r\n\r\n<p>If you are one of the organizations listed in paragraph 2 above and are interested in linking to our website, you must inform us by sending an e-mail to Cheetah. Please include your name, your organization name, contact information as well as the URL of your site, a list of any URLs from which you intend to link to our Website, and a list of the URLs on our site to which you would like to link. Wait 2-3 weeks for a response.</p>\r\n\r\n<p>Approved organizations may hyperlink to our Website as follows:</p>\r\n\r\n<ul>\r\n	<li>By use of our corporate name; or</li>\r\n	<li>By use of the uniform resource locator being linked to; or</li>\r\n	<li>By use of any other description of our Website being linked to that makes sense within the context and format of content on the linking party site.</li>\r\n</ul>\r\n\r\n<p>No use of Cheetah logo or other artwork will be allowed for linking absent a trademark license agreement.</p>\r\n\r\n<p><strong>iFrames</strong></p>\r\n\r\n<p>Without prior approval and written permission, you may not create frames around our Webpages that alter in any way the visual presentation or appearance of our Website.</p>\r\n\r\n<p><strong>Content Liability</strong></p>\r\n\r\n<p>We shall not be hold responsible for any content that appears on your Website. You agree to protect and defend us against all claims that is rising on your Website. No link(s) should appear on any Website that may be interpreted as libelous, obscene or criminal, or which infringes, otherwise violates, or advocates the infringement or other violation of, any third party rights.</p>\r\n\r\n<p><strong>Your Privacy</strong></p>\r\n\r\n<p>Please read Privacy Policy</p>\r\n\r\n<p><strong>Reservation of Rights</strong></p>\r\n\r\n<p>We reserve the right to request that you remove all links or any particular link to our Website. You approve to immediately remove all links to our Website upon request. We also reserve the right to amen these terms and conditions and it linking policy at any time. By continuously linking to our Website, you agree to be bound to and follow these linking terms and conditions.</p>\r\n\r\n<p><strong>Removal of links from our website</strong></p>\r\n\r\n<p>If you find any link on our Website that is offensive for any reason, you are free to contact and inform us any moment. We will consider requests to remove links but we are not obligated to or so or to respond to you directly.</p>\r\n\r\n<p>We do not ensure that the information on this website is correct, we do not warrant its completeness or accuracy; nor do we promise to ensure that the website remains available or that the material on the website is kept up to date.</p>\r\n\r\n<p><strong>Disclaimer</strong></p>\r\n\r\n<p>To the maximum extent permitted by applicable law, we exclude all representations, warranties and conditions relating to our website and the use of this website. Nothing in this disclaimer will:</p>\r\n\r\n<ul>\r\n	<li>limit or exclude our or your liability for death or personal injury;</li>\r\n	<li>limit or exclude our or your liability for fraud or fraudulent misrepresentation;</li>\r\n	<li>limit any of our or your liabilities in any way that is not permitted under applicable law; or</li>\r\n	<li>exclude any of our or your liabilities that may not be excluded under applicable law.</li>\r\n</ul>\r\n\r\n<p>The limitations and prohibitions of liability set in this Section and elsewhere in this disclaimer: (a) are subject to the preceding paragraph; and (b) govern all liabilities arising under the disclaimer, including liabilities arising in contract, in tort and for breach of statutory duty.</p>\r\n\r\n<p>As long as the website and the information and services on the website are provided free of charge, we will not be liable for any loss or damage of any nature.</p>\r\n\r\n<p>&nbsp;</p>\r\n'),
(135, 'extra_amount_percentage', '30'),
(133, 'provider_search_radius_delivery', '5'),
(101, 'tawk_live', '5fa900df8e1c140c2abc1fdc'),
(102, 'paypal', '0'),
(103, 'rave', '1'),
(104, 'UPI', '0'),
(105, 'razor', '0'),
(106, 'paypal_client_id', 'paypal_client_id'),
(107, 'rave_publicKey', 'FLWPUBK-bfc1b7264914562d5f8cc6603adad010-X'),
(108, 'rave_encryptionKey', 'e830526cfc11bac487d51204'),
(109, 'UPI_key', ''),
(110, 'razor_key', 'RazorPay_Key'),
(111, 'rave_country', 'NG'),
(112, 'rave_currency', 'NGN'),
(113, 'appmaintain', '0'),
(114, 'app_maintenance', 'We are currently undergoing maintenance. Sorry about the inconvenience. We will back soon'),
(22, 'dis_code', 'http://api.easycode.in/public/'),
(116, 'cat_app_ecomony', '1'),
(117, 'cat_app_lux', '1'),
(118, 'cat_app_ext', '1'),
(119, 'cat_app_out', '0'),
(120, 'weekly_target', '120'),
(125, 'latitude', '-15.3904063'),
(127, 'f_ui_url', 'http://play.google.com/store/apps'),
(128, 'f_p_url', 'https://play.google.com/store/apps/details?id=com.kwendaapp.driver');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int NOT NULL,
  `name` varchar(500) NOT NULL,
  `country_id` int DEFAULT NULL,
  `state_id` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `taximeter_user_requests`
--

CREATE TABLE `taximeter_user_requests` (
  `id` int NOT NULL,
  `provider_id` int NOT NULL,
  `distance` varchar(500) NOT NULL,
  `amount` double(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `taximeter_user_requests`
--

INSERT INTO `taximeter_user_requests` (`id`, `provider_id`, `distance`, `amount`, `created_at`) VALUES
(14, 41, '0.013', 45.12, '2020-10-17 18:00:30'),
(15, 41, '0.000', 45.00, '2020-11-01 14:19:45'),
(16, 66, '0.000', 65.00, '2020-11-16 07:01:51'),
(17, 80, '0.00', 65.00, '2020-12-19 17:04:42'),
(18, 80, '0.074', 65.92, '2021-10-16 12:17:58'),
(19, 94, '0.000', 65.00, '2021-10-16 12:19:32'),
(20, 94, '0.000', 65.00, '2021-10-16 12:19:57');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `first_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `payment_mode` enum('CASH','CARD','PAYPAL') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `device_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `device_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `device_type` enum('android','ios') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `login_by` enum('manual','facebook','google') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `social_unique_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `latitude` double(15,8) DEFAULT NULL,
  `longitude` double(15,8) DEFAULT NULL,
  `stripe_cust_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `wallet_balance` double(8,2) NOT NULL DEFAULT '0.00',
  `rating` decimal(4,2) NOT NULL DEFAULT '5.00',
  `otp` mediumint NOT NULL DEFAULT '0',
  `referal_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `added_by` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `payment_mode`, `email`, `mobile`, `password`, `picture`, `device_token`, `device_id`, `device_type`, `login_by`, `social_unique_id`, `latitude`, `longitude`, `stripe_cust_id`, `wallet_balance`, `rating`, `otp`, `referal_code`, `added_by`, `remember_token`, `created_at`, `updated_at`) VALUES
(81, 'Sydney ', 'Simwinga ', 'CASH', 'sydneysimwinga@gmail.com', '+260955416943', '$2y$10$nhsr5E1U2p.Cl1glFtVofeU4YVw5f6vzS1T5TNxIoMpQQ/IkMt/be', '', 'cqiAAAIsT1eEGWwQMw_V6O:APA91bGhIeWBxFhR_V6pdi1uAGYYLNyPnunsyB0u473q38bvJzpagd9o_G-pMdNCwGOX9rBFvVdNaSiPZI87tmb2SiiufHvgjOGx59rgaj_mrj9MfZJk-X2qwhKBNuZbh_NWA19hJXY6', 'bc3950386723ee3b', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2020-10-29 16:54:49', '2020-10-29 16:56:57'),
(88, 'Rachel ', 'Mukena ', 'CASH', 'rachelmukena82@gmail.com', '+260977566171', '$2y$10$YJn.BpgavcENa0QBqxulB.J.UcLLtq5FREx.WtjFfujhTD/cYimma', '', 'f2QYBZ8sS3-98SwbqtJkGG:APA91bERce0C4JGnDsMTFNSZRaAIUJ252W1cwaaSwRYMD2nfhuhLXCD81TgUTLivuTvEw4tE-xMcT8Ru5I1bP2Y0zt1F-QI1N1g4exRi6D7TSkeWiPfWAnnHTdOsZZZ3fOzbICZRdAoC', '5cb45a6cfb9a676b', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2020-11-12 16:20:24', '2020-11-12 16:20:24'),
(89, 'Joshua', 'Ngalande', 'CASH', 'joshuangalande17@gmail.com', '+260973360963', '$2y$10$/EQdNrxIubOmMkRQFpLPq.1XsSgw.34RsS92bfnwxIxTMcGOQSMQa', '', 'fMmoSdOxTpSLiMZGuLXvSJ:APA91bGEytD8EBY2jpgeaabCQ4FMZhGCb4HIcYe8NNnt7UMtKSTzX63qDn9_gxZhzMrxdSdzsxXFnaYlkPQ_Kcy5mGd6QgopNSUEoQuO0PqEZFa5E02lR7v3kI548ZemnX6bErYJc6_s', 'e92a0f754a848159', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2020-11-12 21:18:24', '2020-11-12 21:18:24'),
(91, 'Wina', 'Kozu', 'CASH', 'charlottekozu@gmail.com', '+260965530780', '$2y$10$7UbOt.V3f6TGDzHGFuxFBOqfUrJSNS0gmJ3R4zqdDNahohQZ96YaW', '', 'eOQCIxtlTsW-fy4DXK6wcW:APA91bHyqJDwZVcWXEO89XLvtMI16bK2J320XY7GJH9za_e7B3pbG9Oxm3HUX29dXl9PSxQzcbgmUBHwVXIeQsbBvK6KhfrzF3RB4VnObCFzbeqC68CdAoiwg736llUCA7Q6711H7qLO', '394299b57f369327', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2020-11-13 02:02:06', '2020-11-13 02:02:06'),
(93, 'michael', 'lungu', 'CASH', 'michaelsummerslungu305@gmail.com', '+260953017618', '$2y$10$DJViUy2kHlS0zRoy0KRiPui2MTvx.u8R7Ta1BYVUwoQgaIqbvIfOW', '', 'cjNHhga-RxGcrbcVFeF5Dj:APA91bGvVieK8Wkk13ebL5DfinRNgF1SBBWHwXpST5ECmOQC0FCYulFCObJaRwo1LMRYQ_ojW4G9J1sHAyhlWEaOH8ExOfKbV6CP-a10Z1Yl9zMfYQ4sDw7ynbc8BBAeyu5ZjZ-sXcPx', 'b285e19feab96101', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2020-11-14 02:52:18', '2021-01-01 19:04:24'),
(94, 'Chembe', 'Kavimba', 'CASH', 'kavimbac@gmail.com', '+260955000085', '$2y$10$u0fjA59Jf/aV4.Oj0sZF/eveRg.aqZuoYiBQC7d61fnEn2xs3RY7C', '', 'eExUovH0Sfy9XnCgsxhEKb:APA91bG1pOJYae4l2nFdfvdBdEVhFefHPIjNUHY06Zcr1oDEssvxpib8N0a6HnBEt4K1nbrHHuwWp6lrLg0UZ3R9HzVIkCDX-HFVvI4mja8BT8rx5yoBI-ocXCSxU5ANNQ4jb67er92Q', '18c67ced63f3984c', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2020-11-15 01:46:51', '2020-11-15 19:32:11'),
(100, 'Antoinette ', 'Chiti ', 'CASH', 'antonettechiti2@gmail.com', '+260978333363', '$2y$10$PMZv31yST.k5pFsLu1dEAetJbhitf0Cq97sAtjKs7.14tCY/7uwSC', '', 'c8dkQhmpTACEDjLL24y3nk:APA91bHB_dNgCs4n1dgTPENABXQHtUG_VfGn7YkCPyeY_SVSvVpH9voEgJSBr4EzqdPfeVmfu4jEFT-4CXw3l7-DCVNXT1T66FPt8Ivml4PFRdFwfH9qrsaTu7YAozPmgqXAAJ_SMmez', '51f6f1fa14941460', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2020-11-21 20:55:48', '2020-11-21 20:55:48'),
(133, 'changwe ', 'lungu ', 'CASH', 'changwelungu@gmail.com', '+260770553349', '$2y$10$A0xruq8Repi9099lWWX8BuB95edLkYzEdqUQVaqL2MCtglSlVvy2u', '', 'c8EnJdG8RRuu32kJXsYSgW:APA91bFvivWOooTKGcYQb2ANaTxra7BG-uuIdJRE_8YT1eGNR3I-3xCD0hyDsXJH8s_1Q2hkueFX7fqbmTTJM6O-3NBdj1mpKBkalDpsYdDaWIovqZMflnMWOmz3kgLldCk8-9NwgJUK', '5c62bf32728c3f2e', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2020-12-18 01:46:41', '2021-11-19 22:03:23'),
(147, 'mwangelwa', 'wasilota', 'CASH', 'mwagelwa.wasilota@yahoo.com', '+260976214427', '$2y$10$S1tKoHFIqfsIX3ba04M49OWgCyZ7z0i5pi6KJ6w3qPFlueMWe50e.', '', 'dsaGxSjxRgu_iGqKAcZU51:APA91bHmi8T_gZo15MFoFNkWPmpdCl4e53EG4dwCgfptTCbBOO2ulbGEQLHO7XKSBoW0nbHb-6yQekEfcUI3WJEunL9MPXDULub2UffuYH_LSqlO3YK-cUXp5d_eHHzOHxSMzzPi9LDX', '2bc0194413cf2f5c', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-03-13 15:58:22', '2021-03-13 15:58:22'),
(148, 'Emmanuel', 'Yuyi', 'CASH', 'emmanuelmufayayuyi@yahoo.com', '+260976683454', '$2y$10$xLot2ZWPg.mVku3vCWuZzORdfW3gyOSZY29hx4QEHItDUUtakc.DO', '', 'null', '32aecc19ab6cbaa7', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-03-16 17:48:40', '2021-03-16 17:48:40'),
(155, 'Madalitso', 'lungu', 'CASH', 'madalitsolungu95@gmail.com', '+260978328737', '$2y$10$iAiIg5ipDCI1i0OlaInRQOq4GTmD5hFlaG5IbyrNd9KfwD7Lxsofq', '', 'd2mH6amaQxGZtVlnhW9fWw:APA91bFltwP9BdVpkbQuPquwJw4rCoLl_0rbGEFbBxJs-kUiLHxN-PhJ2LvXaGIZU7cE4f4MCO2FWA3zprCnUHDnllMG07X86_gqKWKUUJmXEJrLETciooGFvc9KDHp4SsE3QdSfrFhN', '6e9399d356f1a7e2', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-04-16 13:42:19', '2021-04-16 13:42:19'),
(161, 'sandile', 'Lungu', 'CASH', 'sandile.lungu@gmail.com', '+260972144842', '$2y$10$oZYH1tl1TFsfUQTptd6/d.fZbINnqZqpK2y7nmpzRamt.yUzWAk/u', '', 'cALcFBgfQhSPobvX5qPXym:APA91bH234FYXVN3w9ccDq5ls0beREeAyxKJfyH53g8W59O_Dc80Ini4o2FcItbdL2ikYG0VuNovXGLLEBnRCW9PrDsgWmLWNAethRomLnG4gs0gniJeb85BMO6ZE208RddcbVSwtxH-', '5ae32a2e56efbaff', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-05-01 19:03:24', '2021-05-04 22:41:52'),
(169, 'Fred', 'Lungu', 'CASH', 'philip@optimyetech.net', '+260765024608', '$2y$10$/Pmsoen22SF99ifTWw2wcukurRpt5mtTOlw9wJDuaLEJY7yYJ/U22', 'app/public/user/profile/vQI19Z0YkWezOFRxTbBuDVzzzo1K2kT5DJxFoi4m.jpeg', 'f-uip4i9RbGqjKmb9_DtXv:APA91bHtLq_RxrL1VRDprL-GQNYh2ICEkXmgBzIR6a6PJJ5Orb4IxlxFoNfju0ZTSdButAHW3opEpUwtrlJ6jbZ_okPlgdwJSH3QYpFSksfy3VS45bGQK53i0FfvYA9cfBQVdvgElVRM', '421eda92047d1067', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-05-31 03:41:50', '2021-07-15 23:48:53'),
(170, 'Natasha ', 'Mwansa', 'CASH', 'chipashamwale@gmail.com', '+260975168881', '$2y$10$7ulKTquZDs1WdxZ6VfKktuL10ONHmtILPmTuolfkQ5W2aKkAVb83u', '', 'caEZJFfaRVCr2b4VJiHoeD:APA91bHYbUceZ9G-IpIip0-jvSWH52FNaZlHiDW31tXDgY7zZq71tZRhbSP6wHxxucerDiFU77g-TM8yjQlQcrFrmYOaHK-Pcu2qxFJh85ohOWcLr7z6h1NQ1_rRxxWhxbSETVubG0In', '1d2b52d5573c0059', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 928656, NULL, NULL, NULL, '2021-06-01 22:27:16', '2021-12-18 23:10:15'),
(173, 'Madalitso', 'Banda', 'CASH', 'jonesmadalitso@gmail.com', '+260974810167', '$2y$10$4XPE8PVnX5z..xLBkls2oeENbFoSyMBAc4aRigDLcApev1IinIfWe', '', 'fNAjrG-IR3G3xofs7VNJjW:APA91bFQ_wq72MTQxsOfTBk4P5ze47-V9x2xDjVXZ8LhMib0DgwMvrXVn9tbM___AICVdXU2Dyztq_UY15Af_23Nql48P3Klc6KUC2HswEy0hVEkXx4BHNups7CrvS_93AwqejhDU2bL', 'a5cdc29635962ad9', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-06-30 19:08:19', '2021-06-30 19:08:19'),
(174, 'Mwenya ', 'Mulenga', 'CASH', 'mwenya079@gmail.com', '+260762431471', '$2y$10$AidDL5ltjaZKmIaMUo3A9.5m45BN6V6so3uEEcqDYqAgzXyq8D/w.', '', 'chnumxNzRTatxaLzP5UNcF:APA91bFQsYGcKaVqgc9eOlmUw4U7cZc34sYX6GcB0WGF1Q3jgd0qqgGzhvlrZLVpxhbw2-Eg7OrG_oQ0OsNhHhSG6cvWuQPf5GClLrCAzeZ8J0t6pIsbW1AUJ1_PpXXC2HJ88B_x34dR', 'd1a0781607c9a8cd', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-06-30 22:02:09', '2021-06-30 22:02:09'),
(175, 'Chama', 'Bwalya', 'CASH', 'bwalyachama82@gmail.com', '+260763752242', '$2y$10$vdgmAPO.sf39rD5TFf/LfePxU/4EgZi33Lz.aoqwAvzeZP2b8kD/y', '', 'fiKf_2iOQTerjVkucsQbDr:APA91bFXPhQQ0RDT1eU_UUtPsWd_rWEP3QuPNGXAD73eYEien8Xw4NqjsR2iImXNRuEJ8FyBwgFMmRn9XUEJsWWabbv6I_5EVAVqKZDmikq8lTACIsCHTtZ5H3va8t1m6M_xGWiYd2ep', 'c3ab9613fbfb6d1c', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-07-04 20:07:57', '2021-07-04 20:07:57'),
(176, 'Mayuka', 'Misheck', 'CASH', 'mayukamisheck10@gmail.com', '+260969448651', '$2y$10$8sVKoK6WESnF8yW/0iJmheb.Q2zvx0eXm.YJG30qtzJk0EYPbbMzO', '', 'faCgMmlNRDyXH_G1jTlvSq:APA91bF_k71LDwg1MPsvbpF2zHyOJtsqtm_dlxL0ftJNSeM5zEXSro-5K8hpyFPz2jQG_7MnU77CNbjLsAGn2wGxx6huyDfnR5Tmq1TQviNIeRjGEder1kgoE24_EPpXmVrgD-kCB6F0', 'c19b7500b0f28e40', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-07-05 13:32:47', '2021-07-05 13:32:47'),
(177, 'Vanessa', 'Katongo', 'CASH', 'vanessakatongo36@gmail.com', '+260968339650', '$2y$10$6SlxLCRPk8wuCJ.MLsdXnO0Ye1Y.OZHvzEw43Zm1q0gIPwC4/JXkS', '', 'dXgZXCrXTG6iytkQ7F0jeV:APA91bFRA4rSxVxpUut_tQd33zPbmtHvb0MSoeZpaxwCtZuTHRjM49z8WIvweSAA-klEEmWd4FGxGUkFqzwd59grloUnH_16aeWgwAXE7fLWMW5wR38n86qwrVvWjLws35jEI6q3Wzu9', '12ed346e779ed4f5', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-07-05 15:32:14', '2021-07-05 20:03:21'),
(178, 'Mwenya ', 'Chilele', 'CASH', 'nachembe94@gmail.com', '+260975316521', '$2y$10$MW0nsvnkh2Oocumk.ukKf.z28f1Xam/a./MUaubEy2aNsJK4j8f7G', '', 'fqKEDM7hSvGGYC80O3doaq:APA91bEEgaYPRwJRy8xoWPGx72uQk5xtN05oHd9Pzmk8L611EUkBbIfbfvtNFuD77L-lg82MAAnfQXOzOMQLppo174d3mnzZ1tAbrbFfUr50gBNYabbMuy5uiy_Gq10rrrvqqX9IRVlv', 'd530bf96b59a263e', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-07-05 16:47:45', '2021-07-05 16:47:45'),
(179, 'esabel', 'sachelo', 'CASH', 'Skyesabel81@gmail.com', '+260977712885', '$2y$10$hpL16dTbCUBVo1BCeb./8e9TDnwUSsj1SjoorJwA4BmWA6gkIVb1C', '', 'd3ImtGdfQa-a_1RbBtYUe5:APA91bER4yuoC5zQwRXZ6LW30obqPG1awhJciRRCw4UOKceZDH6Il6iATkw01m_bQ2ZyvsuqlUvp21f8CmL_NkuyegV-QJlL7KjNYmOc4z_nje-jm0UDWlKurXWyH8lG2X5nFFrwZOW2', '914e159234c8ee84', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-07-05 20:53:17', '2021-07-05 20:53:17'),
(181, 'bobo', 'zambia', 'CASH', 'boboappzambia@gmail.com', '+260978955212', '$2y$10$6cMoxzILb9fdUflnQE145u15dLFvdEgLMqimgj/7xvdEmCX0YLnp.', '', 'fsesp7_hSlKoOEaQG_7VAb:APA91bE7cizd_nNwrgUvFWndbHrwxAW7OCR32_7TyTjupCudKbfHNfPl7ukFzMtC15u7CaKNp_Ac45YDlFy7hr2L8PO-ELr8fnsqndI3M2H-tPfi9RIbsbOTeYlgNSmN8yUDn_FOACUv', '59cbb80f3270eacf', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-07-16 14:10:34', '2021-07-16 14:10:34'),
(182, 'Joseph ', 'mulenga ', 'CASH', 'josephmulengamr@gmail.com', '+260972193975', '$2y$10$8PKcAhp39WZlgGzbPO27JuaEzWMBYpGaopjhs9HAj7HzMitUriEBO', '', 'fGH8EZ4cTZmL5WiYPYyL_B:APA91bGlxI9qpk-vvEyC9JYTWMBkESv8G30hccuaRMoHbALK-7catNqdOUcjODZ-Y3rAqfv5sA2NdrHCKZV5im7LftyXIf96qxAJ05dw4lPBsBJzq3kLsOBvRNET044GmThoslq3ODE2', 'e032710f590393d9', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-07-16 23:37:58', '2021-08-23 12:53:42'),
(186, 'Wilfred ', 'zulu', 'CASH', 'wilz80@gmail.com', '+15164446194', '$2y$10$6lsMMwk94U.GMQiRFtKEw.mbMBHEzQQGJK1VUjy7HOjzMZNbmeda2', '', 'esc4QI_WT4Cuz7pL927ceg:APA91bE4xiy-0gPMMSGz_aa7xSuqDfgpOaQzDW0ZVb2GVClkBRnperb2yOQuee5K07nqJJXoUMhdyP_qvyVqQGR7FqGVI6Okn1pu4i1WAuntEsdrTRVSJSDtQZqsDiUvDAEP3J0rhVqQ', '96d76cd5bdbfc8d5', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-08-02 04:47:18', '2021-08-02 04:47:18'),
(190, 'Chanda', 'Mutila', 'CASH', 'cmutila@gmail.com', '+260971232642', '$2y$10$Q1yPuZXy0K8RBfRdz9BctOLEPjB0dX.6S.NkeGCpaVwumQaT9ZOcG', '', 'cwqbkcoVQc-8zXB-C38P7L:APA91bEq1cOF5LOyszDPlBevmSJInq97eQ5SRI9pTbVxPoPXslI8Jmfq05ZTF9_t2hAFChdsUvJnOpTZrUYkx1k6THNqQtVQHrKSF1zRmJeccGqcFs5_-LPNHQ-kfz8ge-MIYxCcBuIE', 'fb9993e6990e75b9', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 872606, NULL, NULL, NULL, '2021-08-08 19:58:04', '2021-08-31 19:41:27'),
(193, 'Semmy', 'Lofalanga', 'CASH', 'lofalangas@gmail.com', '+260974746028', '$2y$10$d96lW9wq99CZLZa7XIrnK.xIQGYoqBqOKs15NnNTrXuHyNxdBTzXC', '', 'dPE8riJgQS65iAxIoQGEq4:APA91bGw4h9LRy-yAvpersV2xozcnXQTpQK1Whmz0cmhkg_MASogPWBV7ZgQI4Ggmz5-Pew_ThhsqHjvRcs-ImoyQaBiWux-Nx78l51TY7siixMuCIM_RquLUj3IXZf1MtcxIbRLBhjo', '71083ccdfd2d0938', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-08-22 16:18:49', '2021-08-22 16:18:49'),
(194, 'Sydney', 'bwale', 'CASH', 'bwalesydney1@gmail.com', '+260974266709', '$2y$10$.KXHDFcBaGslFwPdtMz7FOS2.VSmmLrtX58ENXUZFVowE1PJOrINu', '', 'ciaFPGIgTAmlwIiBOe7y4y:APA91bGKK5pg5alwKICyfmKgBk_W9cjOtWBODuxJ-zZlxThata3hW_m6tpmr2WlCxlskaCJrDKZwCUNC_gDc-XM1W3Jj6DngzVwA5BvPa3K4Bkfb3_pc6X-9TNuSz09FykGQt0spOF9a', '5f17d5a3139cf589', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-08-22 16:23:28', '2021-08-22 16:23:28'),
(195, 'Sydney', 'bwale', 'CASH', 'bwalesydney1@email.com', '+260974266709', '$2y$10$2hozP/UB9HYlm63P3LXQ3OAUGVYaxXww5CyRCMnKgvc9R0hPQmHmW', '', 'ciaFPGIgTAmlwIiBOe7y4y:APA91bGKK5pg5alwKICyfmKgBk_W9cjOtWBODuxJ-zZlxThata3hW_m6tpmr2WlCxlskaCJrDKZwCUNC_gDc-XM1W3Jj6DngzVwA5BvPa3K4Bkfb3_pc6X-9TNuSz09FykGQt0spOF9a', '5f17d5a3139cf589', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-08-22 16:24:08', '2021-08-22 16:24:08'),
(196, 'Mark', 'Simwanza ', 'CASH', 'marksimwanza85@gmail.com', '+260978357522', '$2y$10$eQX9fU7BZp6riyJZAGCy7.B/TxDzIO93vuy98DxTCR78kf932.rtC', '', 'cmDjLWUWRl2kb4GdMJRUoJ:APA91bEZD3ma9v99bXZwrJORQ24ErD2w1gO21-dSufm9VPk5JEkbIi6noNW4M3-VpehAVRYHiCzbZUGlp8wjnzbuwy052RL9I46IT0DP6eIAUqrDNbZdRB2jYh1owhm7kQhVSOZfbI1y', '241272e3e0b0ab87', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-08-22 18:54:04', '2021-08-22 18:54:04'),
(197, 'Gavin', 'Kanyika', 'CASH', 'gavinkanyika@gmail.com', '+260770747983', '$2y$10$g8n5e99pJZfy87XGsqXPNeEkLTwz2lfFYX2CF77cjVcW2N7GB6nhO', '', 'dKCcXVO8TLiEwcNIbKVySY:APA91bHgMORcaKA8tQ0cQZjdkJJc9vEXUMg2XZj0e7Ut7sGZgEIaMKTab2f4CpdWZxDZnxeMIAD2aOs7qbLRYfMANQhvcgFXXwQNMVMnhpWIv12q_LlLL0Uc_X7HWifybjUZEfQGlCVZ', '42be2dfbb8a0bde5', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-08-24 17:31:57', '2021-08-24 17:31:57'),
(202, 'Leonard', 'Luwaile', 'CASH', 'leonardluwaile@gmail.com', '+260978980746', '$2y$10$.IiiVe/84kCz.mTi/3J7NemOWVhqhzKZPRcfnuem1.Fu.FxX6BOK.', '', 'eH9G9T5MT52--oDzAwEZL-:APA91bGbY_bknpT_OMj0XCbbwmC5DnIf8mJEALAlF1BzZye8EV8eK9KjeifLMX_UQ7eEU7uaNM58wzy78xnGjeXXqFDInGRPdytVrgKBWHCuf7ptLWQuGaVGXKUZfbF8thzr3tI6A5pS', 'd2132c8aab067a47', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-09-28 19:05:51', '2021-09-28 19:05:51'),
(204, 'Chizzo', 'Cheese', 'CASH', 'chizzo84@gmail.com', '+260974820707', '$2y$10$SMhkaNsv/7hmH0A2zg5MCO5ezFE4MYcPJZbo.aw7OSYBGRslOLwsm', NULL, NULL, NULL, 'android', 'manual', NULL, 0.00000000, 0.00000000, NULL, 0.00, '5.00', 0, NULL, NULL, 'mrHPAZfmh3jfoyeVUag2OOk5q1eHtk06StUSu3LzRFeN4uCux5RM96t14kir', '2021-10-12 14:42:25', '2021-10-12 14:47:18'),
(214, 'Eunice', 'Mwenya', 'CASH', 'eunicemwenya99@gmail.com', '+260976230490', '$2y$10$2WhSP29WpgQ/gzyGG7IIbeUuI5Z1dJc8eeKTVuFY1QdqVxBe5ROxu', '', 'eaulkwE3TAul8YRu__oyZD:APA91bHDn7ehIREs9BK1Y5XN4p1GunnBi-C-qWtyfDI89y6GSd1BbfJRLMrt8sDRvDqktGzXkQN4yJ_irFdOV8rcVt0wtON9l5mH3GdiP8KWPOFAXucqIgqfJFMd_bzLQDCWv6bNfJ9z', '28a3fa6eb0e7b651', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 986687, NULL, NULL, NULL, '2021-11-03 13:00:03', '2021-11-20 17:51:18'),
(215, 'chipo', 'phiri', 'CASH', 'pchipo200@gmail.com', '+260966299479', '$2y$10$nJtK9tR6p/8qr9yPxUnH4.ryMMzdfjqnEG.oF1jBN67TfO96BrAFy', '', 'f8kO6xF5QR2CxxSSq7u_kE:APA91bEb02ayMDD8LhsFvsYTzzw8xkAEcFlkpNIuEHshIxRvNNXkvaeBKzjzYMEuPvKmz73PJ7ASavgfQIshXeZJ5VFsk7Zhh5-srd-_tl3dKy60KpeS-NbZWb3P_WHaxDSwD499zDnP', 'be1fd05da7f558b0', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-11-03 13:44:58', '2021-11-03 13:44:58'),
(217, 'Tabo ', 'Sumbwa ', 'CASH', 'tabosumbwa@facebook.com', '+260973387666', '$2y$10$uMo7o0i0ALs4FOlD2gY1Mu.2nu7NqKm3SMwYf.UT.spDi92TZxorS', '', 'f8I6EyO2TMW99Czi4gzyZv:APA91bEVnzl51nqH0BXoIMlfvRpEbk8Msejx3nNlkRsQBLuRjVLLww1tR4kcsdhzruV6YAhSqOaB1MafMAzCF9Fa-Hd47q_wFhBpnSFaAngCpS8U8AiZCNmncU_LMwmYgWHtdw1W_DGf', '378cf07963e60e1b', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-11-06 00:15:03', '2021-11-06 00:20:06'),
(218, 'Ottilia ', 'Moyo', 'CASH', 'tily2109@gmail.com', '+260976965906', '$2y$10$G9fbwjSAtIH/bl1h3mw5ZOw8Dq5DS7Qlh.msSUW0.YqqP0a9tCrnG', '', 'ecwsG1vMS-G3tCAX7zG6BR:APA91bGiu2KPSSq64pwjQK5oyOY9zGmCa1fhPFAjiVk0v-ucxvoA0wuvRVVKpdzC9VmayEZ7kzTcG0b_NFuUO_vwe-yWD87GH_ZcWQYqjD8ASJ_jXAticaRvCohs4bi8t0B8jNy0p6gS', '6a77ba79ab6683d7', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-11-06 13:18:26', '2021-11-06 16:04:17'),
(219, 'mus', 'Muma ', 'CASH', 'musmuma@gmail.com', '+260979492108', '$2y$10$CAZZ.vViPJTLVdj68n5zLuMsr1GlCXDzEFbKPB8ZT00Vx86lzy6VO', '', 'dZ7W-gguRvegIOu30682_k:APA91bHakCLKbJkR0MxvD60X0bfag6fIPAYxgjOlpZbZ0fo55SDoYPllgRDMFsBH-bcT8jj1282t1MwHEmezggbGWMzLSr6lACJQ2CGB5aJo9SeBq9eLVW4XuSoUlGXsX-AwkqcEbFoM', '49ee39dc9a989579', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-11-07 00:20:19', '2021-11-07 00:20:19'),
(220, 'hellen', 'kawandami', 'CASH', 'nanjihellen@gmail.com', '+260962923028', '$2y$10$JX2ZnCTmHdHKOR3lOmQWm.WunQB2EdgtoUi3k482iz4ApMJjdMmu6', '', 'f-ZZ1gZpTTWHCHWaCsoxGk:APA91bHZcjh_531gL5ScJDACB4XISGMqCfpftPFY-9pco2ZuS0UbosBOOvOpqyz37DYEYs1G7soOp-JJI-G4KuyRo-1kd_nHitdbgqirfIL79nWCpxnzURPTcqSjCJ2aCiKSn6akwdgl', '47a53ab7fed399a0', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-11-07 00:26:51', '2021-11-07 00:26:51'),
(233, 'Womba', 'Kamboyi', 'CASH', 'wombakamboyi@gmail.com', '+260972303610', '$2y$10$aWasURd53BFXE0HxX2fCpu0W.mYItQ4riqsUnSLrBkrtTtn20pyq6', '', 'caeDzrfGQpihXbyQgGtBjZ:APA91bFc_rDEqprsKGbflDl-1IM7MQebrSIdaVGWpzloMYfAxU2CGUOHfGkuEaM_pNHX0ReDuXNHSiZErM3F-uWUOq3T7zdmMqRm2zJd8iX8MoCGM3w64LlOrxf8YvwAShg0Hu2CZHLc', 'd77c31462b512a72', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-11-11 21:39:15', '2021-11-11 21:39:15'),
(242, 'Edz', 'Mano', 'CASH', 'edmwaza@gmail.com', '+260963509573', '$2y$10$NmKyIxoU97NGaHrGPr7AvuLm2CE1BqOl4nBXnN96tY.GHf8FxKJ7G', '', 'd8sLbcdfRCOI4hj0KPyVf5:APA91bFU7z6aJyXdcRYbP7xCsgsgaknVQJCj7MiyLdgqzx080HKCrWFn6EFyHZ25ssW_XlBa5jqP5z1-Z5Py7uqPDF679mDmsZYO9isheiTCP11d4AMX5gBI4hb3kMqv7Q-tRcqt0hG6', '2ae9a02fa6104594', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-11-19 16:49:27', '2021-11-19 16:50:42'),
(243, 'Lyris', 'Africa', 'CASH', 'lordlyris@gmail.com', '+260966291796', '$2y$10$IXOyiOQKYfYL/z3O1huDruRaxJOkNwq2jUFGv6IP6EqE1/qOQ4LzS', 'app/public/user/profile/GsBi21RshhhyjvhgXOkfrfgaHmzxxPiihcsmJeei.jpeg', 'dbsal9oGSzSABO8hAVsRtG:APA91bH903h6e9dcg8Y2Kqiha0oz5SP6bpuJM93m1akxlOsUE4stWnGpE8kWVJAjFtpqo9C2L1aonGm1SoX2J4R30XwDHTibxJ8wiFHeVg5TKPk8vjhZR1OSjKsApppgHf-VMAQ465th', '48d6e056ef6c3011', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 492171, NULL, NULL, NULL, '2021-11-19 22:08:33', '2021-12-13 11:11:01'),
(244, 'Bukata ', 'Musonda', 'CASH', 'bukatamusonda1@gmail.com', '+260972031682', '$2y$10$IpV8h916tcfBcqjjpwJ9bOSyMD551quN.9NOYJRH60KmB8wyTXB3K', '', 'dsYys5wOTtm1tsFnQgtNkV:APA91bGyZGCZIY6Nktx6l4fNTk_XI9YQBeWk8aKWZKo6ye1GModzfjsRZ-H6UtNhQbaFJXoMcDS0W7KrkoBJ27akpiKTqxLUJcle6Gz5ZbJV35QlNYX8HQOESY1aqu09OSQa6qU9swzY', '78c0107c9d392a4d', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-11-19 23:45:11', '2021-11-19 23:47:32'),
(245, 'Arkmed', 'Harawa', 'CASH', 'arkmed902@gmail.com', '+260972579467', '$2y$10$UGJeZNwqQrKhzNFP3Bt85eAsSYZ7R2hkRV3H/T.O6plJwnLmis0wO', '', 'dXDN8W-ERIKEG5FwgPxITo:APA91bFQWDgB8RwmzmRph--sUvknvXCx31ZrgFkohBH_EmrzCzJ_e2ohIdZYKdspQideoIgfmMh2IZrhP206VtW_25CX2p4yC8M2iPd6IL-Xkt_Su4YqRG_4oQQqwlSbBVZAFcLWm9Qn', '1467f80127198470', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-11-20 00:19:37', '2021-11-20 00:19:37'),
(246, 'Michael ', 'Kanga', 'CASH', 'michaelcholakanga@gmail.com', '+260977257038', '$2y$10$.SAeF7ki4g7e.QRftMAsUecYWTXL5smWlc5heA9x8mvbS8XEb2PVe', '', 'czX8KF0WTR2XkQm_nKnOt_:APA91bFZHd8ieJK8U7ZdChKRfAOUHopcoVUcYaXYm5JEEcp7ER7CXaGXzJoc9imX1PKvXmkK_I5wNnPbXiAO3A6-cScWVqE9Z-BQkYrpLIkVyBV4FwtCc0xUANoRKx-EI87C2pfJA2kK', 'b43d554bc2651959', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-11-20 00:26:22', '2021-11-20 00:26:22'),
(247, 'christine', 'ministry', 'CASH', 'christineministry8@gmail.com', '+260973744442', '$2y$10$5/wxLiXXVZZ4txANkatDbOLLT86RLLDgR5X.JiTOOr88Zt73YH0Ce', '', 'd74tLqwSQmeu1-aAbXvdP2:APA91bH_zK31jetKwIm8pCql6NvCztMUifyIBvKWy57CabfRERwilkxeuJZj-_KpvaSoj7xzXbFIMOeq6bFoE32wtly6EDJUqIGU8Mrmixgdo6sWko5Iyaw1plBNrhrSkTQSVB-lVZwf', 'b9590a3eae8eeb2c', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-11-20 00:34:55', '2021-11-20 00:34:55'),
(248, 'kafula', 'salamba', 'CASH', 'salamba2013@gmail.com', '+260960318018', '$2y$10$jNtOqHJ6Yvvf1n46w3AhWOEaQA1Xs6i4YUJfMzIWVAvZdV1VLrUpm', '', 'ep3Z7QG1ScudaekmWjsoUL:APA91bEWTC72OCewxQkc7fAuuLBJH2jRErYMvz4mKo7fbD-bCsb_JQm4SJFsTpxGhn02_Rbo-JIon7gNDBr8gt8ZIjaywXaI7vKmLaiXo8GIRc7JWq8MyUXsXZ8MDHmZoCI03q8f0VQv', '3d846fc86dc9e837', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-11-20 00:38:27', '2021-11-20 00:38:27'),
(249, 'mwape', 'bwalya', 'CASH', 'mwapehazelbwalya@gmail.com', '+260966159593', '$2y$10$kai0JH1V3RebvqYrh6l9Tu5J5n5cl.zu7D0SH.PoGrUfWeW.wie8a', '', 'dGf78-HvQS6aoD2ROtftIS:APA91bGVfmtmX3xJDBM4G3Dxj_2D2o1cuPFmgGubumeoapCsT_hRvheY0vuDWtgQH3nM90i7_izEmUL_R9d98xzoyCdwlOjzfcJmvBsh7NcSDQHgJ663pN4h61mc7mvigV95l4gjPCsb', '7fedcc121e0e7803', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-11-20 01:07:31', '2021-12-03 15:00:06'),
(250, 'kulyafya', 'mbofwana', 'CASH', 'kuli.mbofwana@gmail.com', '+260977862761', '$2y$10$8z.1S9PXI.9KIfWusjYVmeZ.nlWYh.yW0REPtI5.3zuPr18fvaOFW', '', 'ctCO25bvSt6f_w5N_e_nT1:APA91bH6CLasP1O6kDCDdlRg2he59k-kATGkD-B2B6Kix3ePXAPT0dZiVRM6JDtnsnDr3ZJ_4vbfKFM0SxqPu1FLreUM2gLwONRpZc_mYGq0h2m68ZNRfP1AzboIiUChg5kyDo7xx-eY', '8ef6173e3a25ba99', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-11-20 01:35:35', '2021-11-20 01:35:35'),
(251, 'BubeleC', 'Apollo', 'CASH', 'bubelekadan@gmail.com', '+260968726045', '$2y$10$glHb8QZUgVdEzAvMyPI1muIaZGYHie53tdH1f277mxEgFv4KcGeam', '', 'dnGsv7ruRra8rbrZ7OIR0Y:APA91bEDnq0yGKC0209wONWMNcoW-7eaFXzplE7MOMnc0KZj2zOIIreZAtp_82U6jeSrYB8uW7MeW4LygWj4UJ7WSlFVyWAZjfg5aSg9XwTReVoKgfs3_lmULDHt6xRHTQQA7zShIwbj', 'e9d4fa3a5aacc1c2', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-11-20 02:09:30', '2021-11-20 02:11:58'),
(252, 'Jacob', 'Kapembwa', 'CASH', 'jacobkaps@gmail.com', '+26077009380', '$2y$10$0oxH5c/P3K8hS8z2lCcZpOWmnB8gjU4UuWI4F4xsAm9Ewyt3gcsK2', '', 'db12fv5lQHiKkHJG6nqjcA:APA91bF5qkfmxoXrebFocdWKFro15jZNi8DuGfwwruOi-vzRBoiZpVdBINWWxXyRosfDMHExZWHQTAXmuepGXO4Awonj4DbWNQvXEahyyPEwaGUrWsC5ZlFeVZmWW42D9V5zy2C9zoIa', 'b2d8e36ea4bddedd', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-11-20 02:31:41', '2021-11-20 02:31:41'),
(254, 'Mweemba ', 'Hapompwe', 'CASH', 'mweemba91@gmail.com', '+260964780119', '$2y$10$K/aysynhdNigI6laYdm.we3h1Riec42mOMmPThJJaCBij74GEQTpi', '', '', '', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-11-23 11:53:28', '2021-12-09 00:32:33'),
(256, 'MACBORAN', 'MUBANGA', 'CASH', 'macboran94@gmail.com', '+260979548487', '$2y$10$haV66XfshcO59lJ26HfuqeUV7as4MetMDOscgO.i3w6CM6wrFRcka', '', 'fsG_TWhvQd6wl5UeNxjFad:APA91bG_i8hR25Jz0jgEUlx1aGaacNnbrzbK8wHW3J35Q3euSkIgsmeetlNUrnkrkMGKMGeEpL0YgmzA9cvKtxUTze048iKYqs1y2h9tkuf3ODprRajcsPQ8uhzaiCpe37UkW7bdwPvw', 'a6ab40d12440639c', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-11-29 21:59:52', '2021-11-29 21:59:52'),
(257, 'Leah', 'Mono', 'CASH', 'shebas@gmail.com', '+260966856968', '$2y$10$jdVe8crsT7IXfBD5q3GpB.msH3cWeRFMkutlvw6/2Udmbga.yEiwS', '', 'ff9NjgsnQnmtOc2AxzAaIU:APA91bH_bdkmGyvvU2ms47CAyPBZv87-2l5nNHKXbWHfyYNYXae_--iHHeQqZQBbGCgVsPhwmaBe7UlzHbINvn9vjv-bg2lVVJJYlkAgly-45WWKc2pTWS8ct3egj8S_QR3aOozJRRfA', 'd4a1181b71923086', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-11-30 00:27:19', '2021-11-30 00:27:19'),
(258, 'Phaika ', 'Jonathan ', 'CASH', 'phaikajonathan05@gmail.com', '+260978195960', '$2y$10$Tq9is5CgTK0SZJxxqsz2X.KGCOkvIowtqKu.2ASwCPaB0LDj7WNce', '', 'com.google.android.gms.tasks.zzw@e3edf0f', '5a11b049effd2333', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-11-30 18:58:28', '2021-11-30 18:58:28'),
(259, 'sweet ', 'lily', 'CASH', 'lillianvanrooyen7@gmail.com', '+260975701689', '$2y$10$XzrcAzGsKCmjFe3sHdVy3.phkv8NJnshtb7GbGrz5T0ur8.pxkfDG', '', 'c_ubpynPROub1VaH5OzlUq:APA91bFNMDyCMWaZ-nfFZIrg29JHus0j4BteqStoNtyCIYidZJ-RGXKy0azz9otYD9yR594b_COySU0O2VRuxQu7fRRV2D4Iztl_2vNon8hdtyvJ0QMnMY2qqqAfYk281VX1_sgOoPNT', '6472a55d72e3f9a2', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-11-30 20:48:58', '2021-11-30 20:48:58'),
(260, 'Margaret', 'Vunda', 'CASH', 'maggienkonde90@gmail.com', '+260977427142', '$2y$10$AQaI430QxUkZUPxcVJoESuu4sJpuMFGt.EKMaFN6YeC79PXRx/Siq', '', 'c6yaJAp9Te-Q36aIgCg5g8:APA91bE1xE8Nt5UEui-1Z1-lGK11HWuuY4Rj8k1PGeYi5-GYkwCfXS-tiOAR3uAbeIv3Ln8x8h2bAlgiZOwwl366jjMov_NrsxE_w0hpGQdvmGDyuUorK4XSEz2y7gDKHbUuTyEFokSs', '48d6fcc57ebf86f3', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-11-30 23:14:57', '2021-11-30 23:14:57'),
(261, 'gib', 'son', 'CASH', 'phirigbs@gmail.com', '+260978323007', '$2y$10$T.FqkqCIX1Nc2mWD1u1eke8MWUOf/q3p2ZF2nfTgQ7cqixr/YjNei', '', 'epBLc06kT1uenw-tF1lYcb:APA91bFXVyEqLIt_qm2suxFJGL6aZdpya7jNhDl8svP_80Cxm30ybrYlO4abNyP1COgWMTQfbVLjM9HkeYRfu7aec5hS8_4bsHDNIlgxz9YoOhPEiW8rFm6LLbDGls6PuuW-94R6qc_n', 'adc67ce3baf1862e', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-12-01 21:41:25', '2021-12-01 21:41:25'),
(262, 'j', 'mumba', 'CASH', 'jmmumba18@gmail.com', '+260955709867', '$2y$10$pRm6FL27XpZGvMCk715OjOoEoRmgqDDy4nm8aZsOKpnKigjNEx/YO', '', 'd-SlD84QQyeg0ImC1jzAB7:APA91bFenssD8E9f7p2qlwd55-zTKyF7DT9UPRP5fM_nG5EhSw3hIDfUvfCmxm-cSK87d_H_bvdrXmvAbbAEBcR33n7dYhGFSSakeyjSFgMj_w90M0SuwsPjsR0SGkELstxH8XQm8mYZ', 'cac8637554b9d681', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-12-03 05:16:12', '2021-12-17 08:38:30'),
(263, 'anthony', 'harrison', 'CASH', 'jonell.aka.harrison@gmail.com', '+260967742225', '$2y$10$KN3Vw9PL6EhpELXVEUux3uX5fZa9ENOhQ94AzXdDcIcIXM.DakdRq', '', 'fqySzMSPSaG77HrJTIms7r:APA91bGUQ0qQx7ylhkszIImWu4b3AKMC5xj2zA_0W1q_Q6z19kDho_caRvlcwK31_GjWy9K-pGbzda7kRa4VlTNiWruc4y1v1NaoAJTiAH1GW2kNbp-G8Re858-bBR6fsKwnUDVJJs7_', '6e44443c8cd7947a', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-12-04 16:21:40', '2021-12-04 16:21:40'),
(264, 'Mukopa ', 'Kasali ', 'CASH', 'mukopakasali@gmail.com', '+260761231117', '$2y$10$IM6hAUV0zV5zYGwVo6ZS0ukgRH9o8qSU8RF2p9cFRwmSt8tB3/xvq', '', 'cpUAYw_pRKmMfKnY6g0kw5:APA91bE36IQBAlLjxErQh2nOuL1KJOk2sE7wPk2hP90q8gcdlRFgPtzgx9ft6rBZdhTRAATF3Dj2FGEbwoV8QMA2EbtPh8K-CxPcVgtA85FIn0eRtZ3Nz2DSxXeXUd7sML1fnqymLAKl', '2ebf484ecf30eff4', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-12-05 16:55:07', '2021-12-05 16:55:07'),
(265, 'Bright ', 'Mbuzi ', 'CASH', 'brightmbuzi8@gmail.com', '+260956138363', '$2y$10$0ogwXZUtFDCYZCvXF2yc1ezflA.bfVB2A6XNKTfXujiYqqJwniIue', '', 'fB0D3JzLSM-YKW6MvjCQ5b:APA91bFz-IEblKlZv_R8ptGc6e4sU1KQsFmeTW62taT4z4_8ChFbKe3blr-uss3-1Uu6HAYQqVf3f-9i3I8v-ChtXwsJ87mghpXL-5pjVfVUUyC3fanXxD2BmryuTj3E9ASWgJ3412IM', '902a08ce3038b6fe', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-12-06 04:10:18', '2021-12-06 04:12:46'),
(267, 'Exploits', 'Mutale', 'CASH', 'exploitsm@gmail.com', '+260971717837', '$2y$10$3HIewLKtCBBIBv5aQaRLt.HR16sn/JqwTwNL4OrBl6Dqw/Sjrbr2.', '', 'e9UXifdtTGyh-qygBbfO3n:APA91bGiFUs4HjLL6D9GH2Jp03_LPyR7zNIlQF_w3dAfDC8OG_9Aub6Oo2vBLTbJIQlTZVFmhZRqOjwci55skUeLXRhsed9vMS5omg-jSRYKreqHf3zJYtdXnUAkythp0CNfLV0MSDW-', 'cc42519b13fae55d', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-12-06 13:56:56', '2021-12-06 13:56:56'),
(268, 'Elijah', 'Chibamba', 'CASH', 'elijahchibamba3038@gmail.com', '+260972163765', '$2y$10$2SF5wtrP9g1v0BbeEXRykef8AsVeJDermEdMhvdU.r/5iMp1reY6y', '', 'f8eWM_xNQ22i7lu3eJ6mL3:APA91bErFNMYjAa_qDT0DzT01UEluMwIjkt9uAIicZQTq4KCZIP-fE71ajUgxxxeA33VWh4l9D5FPscgHbBg8etYZPwd9XzyeNZjb728b-60sOioiwOy7c2F1_OHKgVoeeInTRzeefDR', '941cb76430c7a202', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-12-06 15:06:41', '2021-12-06 15:06:41'),
(269, 'Dennis', 'Chembo', 'CASH', 'dennischembo1@gmail.com', '+260977328120', '$2y$10$fUpp2O1nN8L1LXQV5Wsd7uwFTdp.6TstmgHuJc97r7AWVAshQHJbO', '', 'fwmGgApQQdSRUewcfaktdr:APA91bGpZ5H1Ha5YNxJ45tikmNhkPRXzS2z4_Oz-FaLh_hNxsBpT3rWHy4MU8vp3X7cMrJ7rghKNgLDlrQ580P_FcboJWxbmpsqA4LfmKeqCRySbfgRAkdj0It8xOkm7ismf57ENw_yI', 'def7deb90d7e21c0', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-12-06 22:49:00', '2021-12-07 05:45:44'),
(270, 'cassius', 'katongo', 'CASH', 'cassiuskatongo@gmail.com', '+260977896635', '$2y$10$xTAYYoFQp1gnd7prEkCCZ.v3UZW9rYvvQSAaLuFbjR/MFhol2kCSa', '', 'dPrt5vUGSpaF-QxyrjqwZC:APA91bF7zaMM7bjhsLGPCslqGvNIOiQI8XlNYOE1amnXQW1GxCpx9yUSzin3uj49jJtZF5lEGTyHDQ0E3SKH4fsjAfNDZVuIA-t_IXDT3w5TS0SfUXHTfg8nZ0TC_-K_vaRS4h4ppEXp', 'de397efaa5c10911', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-12-06 22:51:44', '2021-12-06 22:51:44'),
(271, 'jabulani', 'Soko', 'CASH', 'jabulaniesoko97@gmail.com', '+260975546995', '$2y$10$74WsdjixvctLtOMLSOOHNeu0o6XRGpYpD5XshM8xZZ4teslLViglC', '', 'cbkRFMXdRB2EQHSCuHtQOk:APA91bGp3dmtcR29fVJvugi7MQWUZUH1RL9HdAML3JDMj3zAhpeKtAkulmhMCukyn9h2EIEppRvjWKxw6U7T7NHiYklsCmKoa3ECJYp2zlcf0Re9uOX8Env3YitlidcMf1CYpk-yG-0F', '813bcac3b3e3e9f4', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-12-07 01:13:45', '2021-12-07 01:13:45'),
(272, 'Edward', 'Manda', 'CASH', 'edwardkingkrocker@gmail.com', '+260975255578', '$2y$10$DvkamFfKy3FSx1upYEH48e2j7WF3sJMBcVjnidl3W9GfEm2lwpHve', '', 'd4ePFLksQkiAgDZh4cw0tr:APA91bEq7P80XoKADgZ7K86Q9vhHf8RU2C3pcNnqn6aYH_v_64TNUFwmzX8y-d3XgFpwt-RMq2oTLgUTLT8IFiGc9MDl_BEr96WaJ5pzNW8RCnYs0eS10O2VtyF2KBLMZ62-RzsN58ZD', '86f1cec56e63be54', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-12-07 03:24:56', '2021-12-07 03:24:56'),
(274, 'Akram', 'khan', 'CASH', 'meewaysdesigner@gmail.com', '+2609991928291', '$2y$10$dAIJ8.1ENbE0lb9nvl64pOl9emn3L1EZciw9.0PPQdWl9o9SwEO06', '', 'ep2XEK0-RnWhza4KXLzTWX:APA91bFKN0wdmCL58hGHhLxMolj_uApgqFW1CTR0H4ta1QCuctimmlfkdTMnYgOA_4vLq74H7KjMva0_1dtGQKYYtEGCYBfEmbXtyYEJqllB9OsS4JKvjQm6tlHq0nlr_c9ISNU5INkA', '811015089f0ff1f9', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-12-08 08:43:27', '2021-12-08 08:43:27'),
(275, 'MUSONDA', 'chama', 'CASH', 'lathan79chama@gmail.com', '+260977409518', '$2y$10$486QTI18s6TYCHYcVUFi3eb7psOXEI.D67.FDiroaq8mdVM6morpC', '', 'e-Ramcf6TJmhE1fbw6OnJB:APA91bF75vLuVjTz5VxigTEdy-as1uBHnsWvgopQrKwDuEK7wzam3Vvr421zxUbRNxB5sB0iPVxPya66vckSU-gl5VKqviQYCh_Zo5xmuXeiOL_egh77XzyD0BF2CoN0TwOG0UfupFcA', '732b1e561599a37b', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-12-08 08:50:31', '2021-12-08 08:50:31'),
(276, 'Akram', 'khan', 'CASH', 'vrshahpuria@gmail.com', '+2609050623087', '$2y$10$xSx2jbG.Q1NxNzjdt/gsCeSfxEJXcX23UKfM9SQYji/Ui9YmHwcxe', '', 'fnpKdnnBSnaWMYhZ4ddcz0:APA91bGWYiG-PFeA7rWwZ3JL4MQ5IR-9DJ8T00yIEsNX-7RAFidEc3aOd8yGaTTG7wT1J_BvUoxRSPfZ1wI9DimLXVxa4L5hKZ0MtcNo1BN9ehKCQdnamC0Oj4iLKUugI5shI4TCPmn1', '811015089f0ff1f9', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-12-08 08:54:18', '2021-12-08 08:59:17'),
(277, 'adi', 'utest', 'CASH', 'test@gmail.com', '+26083865326472', '$2y$10$GN2i7grrvVBOGWXkLKtl0.kFDdUob5RX1b6ljZDCB666YWqKnARNK', '', 'fr8MTU5OQFi8F0WENeE6fA:APA91bGsDBkqz6G7werIX02tyS6jaYOOShDZQW5anAk_MnPhUzBls_Hq9w4aXKSdETDXY7pkmyp30rgzq6nPPpEwgqOr85cft-Q5VXOCaoStfZzVf1WH293rh-AVQHdrkU_zXiPgZcxu', 'baeb9ad6c5c663e6', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-12-08 16:28:26', '2021-12-08 21:04:26'),
(279, 'Jyo', 'kj', 'CASH', 'speak2pearl@gmail.com', '+2601234567896', '$2y$10$ITiF4.v1wy3a0pRSsedNvOUroxGjRHU6n9Jfk.P0G0F69I2Xy9bFW', '', 'eQfG6QcMR0mqzzDExEwzfA:APA91bECJguT9-BwvX0ufrxI_8Tf0qMHSdnKjQ5zeVWVZP5GD20Vzj2Ic31G2OYBZAqFDy6nrPL2YbixtuCIT912etoOd16O0Rq-AM34UD2Z2m_6D8Mm1GNznoFpjnDDXh3iMYkQdoCc', '94b64f62e297251a', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-12-09 01:40:19', '2021-12-09 01:40:19'),
(280, 'Lumbani', 'Kamanga', 'CASH', 'lumbanik96@gmail.com', '+260765193918', '$2y$10$KpTGa5BKJkHR6mioPeR/eeNqnxECNjb3peGnC56F/rVm142Ilv6zC', '', 'd8-04s8FS9Ky4B1u6wGUTJ:APA91bGuSlV_Ktm9nU-GeB1REDOuiNT6FWIchnROLE8rE7xhGm718nTsDdxq7CcTNKBS5RirmWKPS4apopuHZChD6SboUOWAPMk1cHIOwDBFUlKpBlSEPBgPwz0pmf1LC-YA8AaBxS_q', '91c29427e362145d', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-12-10 16:25:36', '2021-12-10 16:25:36'),
(281, 'Nate', 'Sakala ', 'CASH', 'nathansakala399@gmail.com', '+260979591897', '$2y$10$/ej5FPE8dcEQnCCzLmJ5M.TwnpSVjNMo/tsOzNtuj6Q62tvE.yEki', '', 'dorDobOrTjeOf3Vik8wTO1:APA91bHl12QJlwIHy2bF1APWZ56yivTg2sMl0tQbLVymxMB1_CdxhWXJuhJTAWcdi6v6xBsWSmRPwWnd4Nwb2EZ4AyEh4zMWtptCysuQ7aytAP7C6aYmWftunZ9ue1tSBtUwb8nZRTOG', '68e01b98e56ecead', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-12-11 10:46:08', '2021-12-11 10:46:08'),
(282, 'Joyce', 'kapembwa', 'CASH', 'joycekapembwa0@gmail.com', '+260970191999', '$2y$10$ZNS9zNeHRmlCxHfqax62nO3LK6pfPNVOJt4N8JxePyLhHgq67UN4O', '', 'eEvZtnf-SkG8uP-B5bmXQK:APA91bFpZGZ_6MxKkM-MWa0uyY7yghBmvY_uwCYtpF-T6kLTZvHYDX3p45U9UXnsK01UX2mdzbzcNevLTHhyRx3cCzxjr2ZkmdRbVq_3I21TINGFJetvp6NveNqMT_ObzO82Cs8E8kcz', 'b78db0700b9f772e', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-12-11 14:13:24', '2021-12-11 14:13:24'),
(283, 'Mofya', 'Vernon', 'CASH', 'Mofyamukuka08@gmail.com', '+260977218656', '$2y$10$6Wj8IoNwugEX6RVcKk.PEe/Ei9rjwAuLROTuxuM0rmU7s96SLjvLW', 'app/public/user/profile/wEj6xZT3jUf2VqM0q7fJnXlIM5zr6YwNMtodouCM.jpeg', 'deNZiuSzQHyeZMyUN07w1z:APA91bE49xBR-bA0qMbbfdJfod6AhzzaEpD2EB4Sflt20qvQoLVXB8rD8HY76U6mPtU9-bphdl_sOgNM_K72-RkeQxeXz3ZGsovkYaYZGE6zdvSmacfX-UHrmCya1Whju7wuy0gMgxVJ', '1a8b7dc7bbf80ef3', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-12-11 16:49:01', '2021-12-11 16:50:27'),
(286, 'Philip', 'Lungu', 'CASH', 'mebrsm@yagdk.com', '+260977500012', '$2y$10$3N7MkdlYmj2JYh2My8IOb.Vx5eMdE4lmtCMvmwaVifTWLtz.6a72C', '', 'f_3LsOJATjuqNtQ3BMSCtW:APA91bHQBCB9lXEo-iNKcwnAKMTap4k4gz-WnUHtfbUQ-ltPWy0w8BvnWPhwO38sBwmrqPnKT95i58vvKRH9vP7qjCi5lP1LXm6k-KxxStS6NNMWgxvbdOI2-rv873e64dt6kkmaZ8Ex', '8a00ada257db5c26', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-12-12 12:24:35', '2021-12-12 12:42:24'),
(287, 'test3', 'test', 'CASH', 'mebrsm@ydk.com', '+26099500022', '$2y$10$BAhj43nw3HRT3LVsz6YX2.0rODIreqAnopNAwnbiie2E0Y/FJkuB.', '', 'fiI4Uhr_RX2gn3GTjPI1wH:APA91bHq3ecZZF4o5_PC7q8mfL7sj19nVkM96d8hYMkHPZ14i-uhykWqiTHicZiud3GOtScqR7YPTtFFa6-swTnrAQqBKw-_OhhrykJR-5NO-LGWxysQlxUpMRu1hNeb4kMRIZQpHt8r', '8a00ada257db5c26', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-12-12 12:57:24', '2021-12-12 12:58:25'),
(289, 'Philip', 'Lungu', 'CASH', 'lunguphilip@gmail.com', '+260761231220', '$2y$10$u1HEeqGQw2ppKvkK3V0utek87WaPWzvvVaJ4.Mra//yFGIOIyXQYm', '', 'cs_pS1wcQJaeXsM7pK6cFv:APA91bFbV1kFsYZT9EmpMy22lZxctlqcav4y4Dt0WgYe4h_MSiz89rD24GzmSFphUYLrhOQLuseWVa1EW29T-27sz2BIvZ0RsoSykCJKCDV0gZFTyqVTjO67Fh3lNEYYJZHwhC0N0t3j', '22668867e3cbc73c', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-12-12 16:07:31', '2021-12-19 11:28:26'),
(290, 'Customer', 'App', 'CASH', 'test@account.com', '+26055667788', '$2y$10$VpvoqnWZwP.SnDpnxYYz4uhBEMYGFf9mQToFokWF7x.w2ti6dLMoC', 'app/public/user/profile/Eb6YKOtydLnTkzAuxeXiMm3T8Z1J4Nn7BeJ0TuuD.jpeg', 'f-2vb2HwSGacGAyiEqHF-W:APA91bFiPJs4MOxgEpSqH2oEMVrhgsHVM4wlIOwYNrPM8uxmUo6ZSUoc3-hnwLhM6pYz0pdmnwFqKjT749s4KX71zoG3KNnI1_Qcdx9UGMzwxU-qRnOpr8aARjK5TFz8PE99vlI2a9Tk', 'e70522ae5acf7b49', 'android', 'manual', NULL, NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-12-12 17:45:35', '2021-12-18 23:21:47'),
(291, 'fred', 'lungu', 'CASH', 'rhgg@sfg.vpm', '+260975168880', '$2y$10$geTbqRrqtcTQiAZbKepmYeIkPJRI5bBxQY7wiSfCeTZBpYasymJKu', '', 'dWT3qeF3Rk2C8VDizDnp3b:APA91bE0WyWy0R0RG7Z6MUwDUhhaDDz8vAR4gBlAcgJk9UPDXrToWx0MWX1zxaDgHXjuHdCSR6PINBkSBWuzz5Ypsiu90819KTZnXFrRIzo0NYH_dXshwxp7iKqhZ7hxyPvrAAgZ3p3o', 'e97b238621b62d34', 'android', 'manual', '', NULL, NULL, NULL, 5.00, '5.00', 0, NULL, NULL, NULL, '2021-12-12 18:30:05', '2021-12-18 15:20:02'),
(292, 'January', 'Kunda', 'CASH', 'januarykunda@gmail.com', '+260972032180', '$2y$10$uBckAM4V3r040faYUOZyOuQsnJtcKg7ioUHrmVL0v2x/mWzt4gqJG', '', 'dBZOseb0TOmSCRF04ryX-8:APA91bGZPWsm70zv_sdpaamMXWg9lEPpgA3D4dPE3Ec1OZD2GWOiIVr5A81v8XOULdjU5HB4pLrFNY3n0C1V2eta24xrWjmnvAk1WJbPRc-tnbGGxptDz9ye-j--jv3VnPjWKedzkb65', '4e13ebe942be517f', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-12-12 22:02:51', '2021-12-12 22:02:51'),
(293, 'Given', 'Mwansa', 'CASH', 'gmwansa55@gmail.com', '+260977459618', '$2y$10$qNf/oCJhqc7AkFR7y.mFmuZzd8HVYvPIx0irzGP9HKu3YygyFstwu', '', 'cUdBLci6RVKOVrmMAqqZCz:APA91bESgGl845R5gcbdH3zfAWSbzHSVuyc_0EZve933VTW_faMsU_fBQf0wIl6fMBGQDKyDSCGk5FDjUE434MrWXvqYDs6svna5tnNI4AMRsjSt7m9Seuji4dqDCMSTXCheRjG2UmLh', 'ed2d9c1f87731428', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-12-13 00:56:23', '2021-12-13 00:56:23'),
(294, 'Alfred', 'phiri', 'CASH', 'alfredlgophiri@gmail.com', '+260967293531', '$2y$10$Qv.OUdkQiuK8a6CSg9.4A.L2TPtKcSDqb1y6t2NLFH1PtqiinOwfW', '', 'eJtpCLl9S_i_sXleUUJfM6:APA91bF263KqOYHrbOKxDIUuK6xrdbwYEJjhgdN23aTouTWSURuuVae0H3DkiZkJ8ndA32kZgqXBZMTWKCGISLphBfIzCRzpMBORBwvzb-9SUSzm3PAUrvLxnJufTtksE3VQ-3CWNhKP', '99725ba040fbf448', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-12-13 12:35:15', '2021-12-13 12:35:15'),
(295, 'Rita', 'bwalya', 'CASH', 'bwalyarita4@gmail.com', '+260979053900', '$2y$10$hGbrlKhvsDw6MJrmukUZ8uJ4QZ1sxknPi1NTfsO3.lN/uSrtIlTZ2', 'app/public/user/profile/x4RzI1NJ69h6CGLKz05NH5riJ2ptlEkwkCCXDRZX.jpeg', 'f5sCf-nfRKCoyR-5x36mY2:APA91bFoF9a_SKGXimfOp7O34te_jjvHmXhsutjGAA--HKvCMkoIQnPGXdSDpHgSu1zlW_wQPl5eWV4EogYEA60jDD-vpWAFzXrVC0otLkXXC2ESOeunY_Wtb7lhRSWjZyPqkNVjc22S', 'cb12f3c14c9a4c70', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-12-16 13:05:56', '2021-12-17 07:09:03'),
(296, 'Ruth ', 'Mucheswe', 'CASH', 'ruthmucheswe@gmail.com', '+260978268972', '$2y$10$HyofnkwQwb5oyEct3xL8z.2LcJWlE.YiMIvDaqvGvkzWfM2CHZeF.', '', 'eeKDi9dpSnmLyp-y0hxZWh:APA91bG70cIod1mv3YPVojnkdIeNv0cevuBicEVsS9Zq1VuibEBi_MsCSCm5xpGx3CZvrrOd0_DEXVSHuflRaZLorhfYH4z0CeLuJ9n3Ut0JY7_HeIMv5iJFNtWYWQbWMbU_Z6KUSVbf', 'b5623aa3542116f7', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-12-16 13:12:14', '2021-12-16 13:13:01'),
(297, 'kapenda', 'lupambo', 'CASH', 'lupambokapenda@gmail.com', '+260972130948', '$2y$10$ZuKBOuO6eWDldbhHkvjis.I/S8bMHIJRkAHBJ9JHyMnuxU810.zFi', '', 'fmHhf63YTZyoZOW2mWMVpu:APA91bGf-weW7Bpi4waAKQ9hajrvACAujnoD7-407magPTucPqZwdB6xy65J1GUX2jkVL4_qjerVF1YWh4xhHc1uTC62nNoBHSHuLyLR318CZmmzwoUVK6TzjAEawwVYxEoBN_ReROTs', '2cd25550980b277e', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-12-16 21:21:05', '2021-12-16 21:21:05'),
(298, 'Deborah', 'Overcomer', 'CASH', 'deborahmwizabi@gmail.com', '+260972624618', '$2y$10$7axRMnPMbCp96kgxEc4xGeYEY0sgtnyPxtoeDlpWlSD9QeGi5vCjy', '', 'ckR_Y0WEQkS9iBryl_fciM:APA91bGspryZxYXyntUXHNSBfCZWwmzW9pq2Aih6LnOMjyyhss_0N_xwP-8_wTCAMxYT6lh5ujBCY1Y2EJpiRTPjJWTcu7hOdn6W-T8UIoDCm26jlmQ11QVqGm2miX-jeEIdY5FjcM0V', 'aaac5c9ca255ddb7', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-12-17 18:32:00', '2021-12-17 18:32:00'),
(299, 'Sample', 'Example', 'CASH', 'sam@examplle.com', '+2609777', '$2y$10$CDM6m./pkqlRs8fj5Nt.uurB2RnO3KrIQZvhOR4PL26Jlcxh4nKXq', NULL, NULL, NULL, 'android', 'manual', NULL, NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-12-18 10:25:09', '2021-12-18 10:25:09'),
(300, 'Natasha ', 'Kambaki ', 'CASH', 'nkambaki@yahoo.com', '+260971969910', '$2y$10$TQZnlygY.oyegsI4rNOMne/ucvMFIaMX1JiZuPfKrgaX5iSZiwKGS', '', 'fIh17MOuTsa0S900IAAUyh:APA91bFH1PbEVQSx7S6bVKrJ3t096hCNMw5TOFIC9yWKq2Osf_mHpZ3yrXtaQSyL2UReGHUmCk8fAYPwxmEqs9kDWyEa4VEsrn52HH39jx3qQSDK5plkqvHtPFuF5slgtsBAxdIGIluT', 'b7381bf39d76b8db', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-12-18 13:25:08', '2021-12-18 13:27:57'),
(301, 'Leya', 'Kalaluka', 'CASH', 'Leyakalaluka@gmail.com', '+260977214489', '$2y$10$JaQqjHQehmruoVkHa2HbhOCuMXTvB5tCCiz61sHt0Oar.OCZ/0FOW', '', 'dpy3knVLT9y_StAeOF17JC:APA91bG5O8ONnH6ERd-rcosxTT60QvW636pmZUDGRig3DudpJaX3fUG9EmX6I6ldNiauxPv36y7n9UDcJKrGc03dv74i6N1gdYUB_YvMIRyB4JlAP2dJyIWFM1gU0ac0JvwBdDZRdB0H', 'b833db06103abd34', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-12-18 14:51:03', '2021-12-18 14:51:03'),
(302, 'Francesca ', 'zulu', 'CASH', 'zulu.francesca@yahoo.co.uk', '+260975223062', '$2y$10$BiCH00EqC0jtYbVUY1IZjeeeqMP1j3./MCagmwz68vRw0uhKBBJVa', '', 'd0I52eiHSPSUlnkaDwBLem:APA91bHY_b7-poYDzKSNzsNifSexGwVFyaFUfXINyZ6xnvFFqDC3Lj1Fa3NilgTiQ_FizK5GSNjoN7aOyAqYlVwXo8PEf9hJupGGcGfKtd2DJopPZjmrTX_U2QLJhEtE92OAqzC2dvly', '7cd85272d5318a1a', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-12-18 19:44:26', '2021-12-18 19:44:26'),
(303, 'Rebecca', 'N Lombe', 'CASH', 'rablonde830@gmail.com', '+260979029152', '$2y$10$Hfxi8UAZnl3xI3XSFCznXOXmtGg6vT2HVHCnRBG8TCv7i93czZA0G', '', 'dHoD4pO1QJaCl0iEgdFC3C:APA91bF90rGkoIvPdaIcnAWzIbNe5xiiItJ_3fvDBO1HxoHVgCojaMuMMidyxJR5wwKSkY9f6e3Hu8Fa7xQGe87FsR_tWVG5BOgIgSIfXgPU0ir6vw3-113UbkZCrwOIM-4YxhKdSHWi', 'a5be75c5af75cd42', 'android', 'manual', '', NULL, NULL, NULL, 0.00, '5.00', 0, NULL, NULL, NULL, '2021-12-19 11:05:04', '2021-12-19 11:05:04');

-- --------------------------------------------------------

--
-- Table structure for table `user_requests`
--

CREATE TABLE `user_requests` (
  `id` int UNSIGNED NOT NULL,
  `booking_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `provider_id` int NOT NULL DEFAULT '0',
  `current_provider_id` int NOT NULL,
  `service_type_id` int NOT NULL,
  `otp` int DEFAULT NULL,
  `returntrip` int NOT NULL DEFAULT '0',
  `status` enum('SEARCHING','CANCELLED','ACCEPTED','STARTED','ARRIVED','PICKEDUP','DROPPED','COMPLETED','SCHEDULED') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cancelled_by` enum('NONE','USER','PROVIDER') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cancel_reason` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_mode` enum('CASH','CARD','PAYPAL','WALLET') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `paid` tinyint(1) NOT NULL DEFAULT '0',
  `distance` double(15,2) DEFAULT NULL,
  `amount` double(10,2) DEFAULT '0.00',
  `specialNote` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `s_address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `s_latitude` double(15,8) NOT NULL,
  `s_longitude` double(15,8) NOT NULL,
  `d_address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `d_latitude` double(15,8) NOT NULL,
  `d_longitude` double(15,8) NOT NULL,
  `assigned_at` timestamp NULL DEFAULT NULL,
  `schedule_at` timestamp NULL DEFAULT NULL,
  `started_at` timestamp NULL DEFAULT NULL,
  `finished_at` timestamp NULL DEFAULT NULL,
  `user_rated` tinyint(1) NOT NULL DEFAULT '0',
  `provider_rated` tinyint(1) NOT NULL DEFAULT '0',
  `use_wallet` tinyint(1) NOT NULL DEFAULT '0',
  `surge` tinyint(1) NOT NULL DEFAULT '0',
  `route_key` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_track` enum('YES','NO') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'NO',
  `travel_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `track_distance` double(15,8) NOT NULL DEFAULT '0.00000000',
  `track_latitude` double(15,8) NOT NULL DEFAULT '0.00000000',
  `track_longitude` double(15,8) NOT NULL DEFAULT '0.00000000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_requests`
--

INSERT INTO `user_requests` (`id`, `booking_id`, `user_id`, `provider_id`, `current_provider_id`, `service_type_id`, `otp`, `returntrip`, `status`, `cancelled_by`, `cancel_reason`, `payment_mode`, `paid`, `distance`, `amount`, `specialNote`, `s_address`, `s_latitude`, `s_longitude`, `d_address`, `d_latitude`, `d_longitude`, `assigned_at`, `schedule_at`, `started_at`, `finished_at`, `user_rated`, `provider_rated`, `use_wallet`, `surge`, `route_key`, `deleted_at`, `created_at`, `updated_at`, `is_track`, `travel_time`, `track_distance`, `track_latitude`, `track_longitude`) VALUES
(1329, 'KWD595015', 168, 0, 80, 3, 5188, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.46, 65.00, '', 'Unnamed Road, Lusaka, Zambia', -15.39815340, 28.38535860, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-07 20:11:31', NULL, NULL, NULL, 0, 0, 0, 0, '`m~|AkaglDiAPe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-07 20:11:31', '2021-12-07 20:11:51', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1330, 'KWD265034', 168, 123, 123, 1, 7018, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 11.85, 118.70, '', 'Unnamed Road, Lusaka, Zambia', -15.39815890, 28.38528700, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-07 20:21:58', NULL, '2021-12-07 20:22:36', '2021-12-07 20:22:53', 1, 1, 0, 0, 'nk~|Am~flDn@`DeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zE@P\\hELjAJf@x@lE\\lAh@zAnApCx@xAb@x@hBfCnGrH|B`CT\\|HnJjFfGhMrO~AnBOLsCkDYBSF]X[RG?KGQ_@CGUPCB?DDJxB`CvAdB', NULL, '2021-12-07 20:21:58', '2021-12-07 20:31:35', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1331, 'KWD498372', 168, 0, 123, 1, 6330, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.45, 54.05, '', 'Unnamed Road, Lusaka, Zambia', -15.39802780, 28.38536760, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-07 20:47:37', NULL, NULL, NULL, 0, 0, 0, 0, 'hk~|Ac_glD_CkLkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-07 20:47:37', '2021-12-07 20:47:45', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1332, 'KWD574302', 168, 0, 101, 1, 4485, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.48, 54.28, '', 'Unnamed Road, Lusaka, Zambia', -15.39820620, 28.38560420, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-07 20:50:07', NULL, NULL, NULL, 0, 0, 0, 0, 'tm~|AoaglD}ATe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-07 20:50:07', '2021-12-07 20:50:12', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1333, 'KWD442251', 168, 123, 123, 1, 1286, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 5.46, 54.15, '', 'Unnamed Road, Lusaka, Zambia', -15.39812260, 28.38543210, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-07 20:51:42', NULL, '2021-12-07 20:53:31', '2021-12-07 20:54:45', 1, 1, 0, 0, '~l~|AiaglDgANe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-07 20:51:42', '2021-12-07 21:05:22', 'NO', '1', 0.00000000, 0.00000000, 0.00000000),
(1334, 'KWD748799', 168, 123, 123, 1, 4269, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 12.95, 129.81, '', 'Unnamed Road, Lusaka, Zambia', -15.39820010, 28.38537330, 'Roma Park, Farm 609 Zambezi Drive Lusaka ZM, Lusaka 10101, Zambia', -15.36387520, 28.31771080, '2021-12-07 21:48:18', NULL, '2021-12-07 21:48:51', '2021-12-07 21:48:58', 1, 1, 0, 0, 'jm~|AmaglDsARe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@{CdPEJWR[B[?aA@I@KHGHE^w@`CmEzMkGhRwF|PyAjEK\\W\\_@RUPBHfB`KbBtI~@bE~@~CtGpRLXJJf@f@HJN^B`@DbA|@xCr@jC|@jE|DtT|B|M|B`LpCjOxFn\\d@hCNf@T~AZzADt@Fl@NZDBJJJPBXARAFEFBJHf@Jb@\\vAX|AbArFPbAXnCPpDCxDWzK[nPMvGAjBJrC~@vJz@bJb@~EVlDh@zFRdC@Bj@tER~AHp@t@jDb@`B^dATd@RXHBXJJNHR@ZCLINSNUB]Gs@LQ@IF_EtCoCtB}A~Ag@t@YSiAc@yAQk@?a@@s@Lw@RiEbBaATu@DeAGqEk@iNcB{NkBmOkB{AUcDw@{EoAuF}BcC{@iJiDsBe@}Dw@_@Ia@IGAA|Gy@DOFkLxE', NULL, '2021-12-07 21:48:18', '2021-12-07 21:52:01', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1335, 'KWD367309', 266, 123, 123, 1, 6592, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 11.51, 115.28, '', 'Unnamed Road, Lusaka, Zambia', -15.39804580, 28.38537400, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-07 22:16:13', NULL, '2021-12-07 22:17:12', '2021-12-07 22:23:45', 1, 1, 0, 0, 'll~|AeaglDu@Je@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@{CdPEJWR[B[?aA@I@KHGHE^w@`CmEzMkGhRwF|PyAjEK\\W\\_@RUPBHfB`KbBtI~@bE~@~CtGpRLXJJf@f@HJN^B`@DbA|@xCr@jC|@jE|DtT|B|M|B`LpCjOxFn\\d@hCNf@T~AZzADt@Fl@NZDBJJJPBXARAFEFBJHf@Jb@\\vAX|AbArFPbAXnCPpDCxDWzK[nPMvGAjBJrC~@vJz@bJb@~EVlDh@zFZrE^zDR|AP~@p@|Cb@pAh@tApAnCd@z@pArBbBvBrFnGtB|BRVpNzP~EbGzJtLOLsCkDg@Fq@h@IFI?OKSc@YV?F~BhCvAdB', NULL, '2021-12-07 22:16:13', '2021-12-07 23:00:44', 'NO', '6', 0.00000000, 0.00000000, 0.00000000),
(1336, 'KWD695101', 168, 123, 123, 1, 3655, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 5.45, 54.05, '', 'Unnamed Road, Lusaka, Zambia', -15.39803370, 28.38543770, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-07 23:13:51', NULL, '2021-12-07 23:14:26', '2021-12-07 23:17:33', 1, 1, 0, 0, 'll~|AeaglDu@Je@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-07 23:13:51', '2021-12-07 23:17:56', 'NO', '3', 0.00000000, 0.00000000, 0.00000000),
(1337, 'KWD402642', 168, 123, 123, 1, 5062, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 5.79, 57.48, '', 'Unnamed Road, Lusaka, Zambia', -15.39811910, 28.38528830, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-08 06:41:37', NULL, '2021-12-08 06:42:12', '2021-12-08 06:42:19', 1, 1, 0, 0, 'lk~|Ao~flDp@bDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-08 06:41:37', '2021-12-08 06:42:41', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1338, 'KWD212001', 168, 0, 102, 1, 4917, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.79, 57.47, '', 'Unnamed Road, Lusaka, Zambia', -15.39811590, 28.38527810, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-08 06:43:00', NULL, NULL, NULL, 0, 0, 0, 0, 'nk~|Am~flDn@`DeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-08 06:43:00', '2021-12-08 06:43:26', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1339, 'KWD345885', 168, 0, 102, 1, 4039, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 11.84, 118.66, '', 'Unnamed Road, Lusaka, Zambia', -15.39808559, 28.38522101, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-08 06:53:02', NULL, NULL, NULL, 0, 0, 0, 0, 'pk~|Ae~flDl@xCeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zE@P\\hELjAJf@x@lE\\lAh@zAnApCx@xAb@x@hBfCnGrH|B`CT\\|HnJjFfGhMrO~AnBOLsCkDYBSF]X[RG?KGQ_@CGUPCB?DDJxB`CvAdB', NULL, '2021-12-08 06:53:02', '2021-12-08 06:53:31', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1340, 'KWD664552', 168, 102, 102, 1, 9502, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 11.52, 115.41, '', 'Unnamed Road, Lusaka, Zambia', -15.39817780, 28.38532950, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-08 08:07:28', NULL, '2021-12-08 08:08:21', '2021-12-08 08:14:05', 1, 1, 0, 0, 'dm~|AkaglDmAPe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@{CdPEJWR[B[?aA@I@KHGHE^w@`CmEzMkGhRwF|PyAjEK\\W\\_@RUPBHfB`KbBtI~@bE~@~CtGpRLXJJf@f@HJN^B`@DbA|@xCr@jC|@jE|DtT|B|M|B`LpCjOxFn\\d@hCNf@T~AZzADt@Fl@NZDBJJJPBXARAFEFBJHf@Jb@\\vAX|AbArFPbAXnCPpDCxDWzK[nPMvGAjBJrC~@vJz@bJb@~EVlDh@zFZrE^zDR|AP~@p@|Cb@pAh@tApAnCd@z@pArBbBvBrFnGtB|BRVpNzP~EbGzJtLOLsCkDg@Fq@h@IFI?OKSc@YV?F~BhCvAdB', NULL, '2021-12-08 08:07:28', '2021-12-08 08:31:37', 'NO', '5', 0.00000000, 0.00000000, 0.00000000),
(1341, 'KWD274562', 276, 0, 109, 1, 3923, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.56, 55.10, '', 'Lusaka Zambia, J86F+X4V, Lusaka, Zambia', -15.38752380, 28.32280520, 'Maluba, Maluba, Lusaka, Zambia', -15.40974700, 28.29651210, '2021-12-08 08:59:17', NULL, NULL, NULL, 0, 0, 0, 0, 'lp||AmyzkDuCk[o@sGOyBM_BPCJjA^|DbAnKb@zE|@tK^zE@P\\hELjAJf@x@lE\\lAh@zAnApCx@xAb@x@hBfCnGrH|B`CT\\|HnJjFfGhMrOtBhCPRd@h@bE`Fj@v@zDtEtDfEzC|DzAfBfBtB`ArA`BhCd@`AbAlCf@~AV|@b@bC\\nCF|@r@nIlV{B', NULL, '2021-12-08 08:59:17', '2021-12-08 08:59:32', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1342, 'KWD712886', 168, 123, 123, 1, 6621, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 4.00, 45.00, '', 'H9G6+6FX, Lusaka, Zambia', -15.42461830, 28.36105540, 'Woodlands Mall, Chindo Rd, Lusaka, Zambia', -15.43605270, 28.34142110, '2021-12-08 09:48:38', NULL, '2021-12-08 09:49:11', '2021-12-08 09:49:21', 1, 1, 0, 0, 'zrc}AsgblDcE~EMZy@bGYrC]hCt@JnDd@hGz@dL`BD?AFaCzQG\\E`@ObAM`AY~Bw@jGeEv\\mAjJvEl@dMbB`Eh@|@N|@f@tAv@pBlAnBbAfC|@vBd@nBPbAFxBAlCQjASlBYl@IEWIo@@W', NULL, '2021-12-08 09:48:38', '2021-12-08 09:49:37', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1343, 'KWD782938', 168, 101, 101, 1, 3531, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 4.00, 45.00, '', 'H83W+HXQ, Lusaka, Zambia', -15.44551860, 28.34819250, 'Centro - Kabulonga Shopping Mall, centro mall, kabulonga lusaka ZM, Lusaka 10101, Zambia', -15.42029440, 28.34225660, '2021-12-08 11:11:36', NULL, '2021-12-08 11:20:29', '2021-12-08 11:27:27', 1, 1, 0, 0, '`tg}Aez_lDsH`DiFzBh@rA`E~JBLsAn@gGdCmEpBaFrBaDxAqElBoDzAHXE\\KPYNO@YGKIECUAg@Eq@J{Et@uAJqBFmA?wCOu@O{A]eA[sAi@gEcC{CeBwEq@uEm@kKwAeBSwASoAGkEGqACiCImAAuBVqC`@{@HLpAFTJBN?Lz@@PDH', NULL, '2021-12-08 11:05:36', '2021-12-08 11:27:45', 'NO', '6', 0.00000000, 0.00000000, 0.00000000),
(1344, 'KWD486265', 168, 101, 101, 1, 9170, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 4.00, 45.00, '', '13 Chindo Rd, Lusaka, Zambia', -15.43201730, 28.34235100, 'Masabo Trust School, G9X7+FWX, Lusaka, Zambia', -15.45126600, 28.36485670, '2021-12-08 12:11:28', NULL, '2021-12-08 12:31:16', '2021-12-08 12:40:36', 1, 1, 0, 0, 'rae}Asp~kDLDTTVn@GPATBJLFpAVt@wFPgBTqAZcAl@aAx@gAHGHIPQRSf@c@d@c@rAkAzCqClAiA`@_@rCgChHqGlGwFlA}@THfA^`KiJjF{Es@iBWe@pAeAvBmBjBcB~EqEhDuCbEcBzEuBh@WhDaBJEEUKw@Eq@?qAAaAa@iFqAeNOyCrHmFnAtB', NULL, '2021-12-08 12:11:28', '2021-12-08 12:42:34', 'NO', '9', 0.00000000, 0.00000000, 0.00000000),
(1345, 'KWD726576', 168, 101, 101, 1, 3445, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 10.05, 100.50, '', 'G9X7+FWX, Lusaka, Zambia', -15.45113380, 28.36483810, 'Kings Highway SDA School, H7PV+JQX, Lusaka, Zambia', -15.41338410, 28.29448340, '2021-12-08 13:04:06', NULL, '2021-12-08 13:04:58', '2021-12-08 13:28:57', 1, 1, 0, 0, 'xwh}Ae_clDI_AUw@yAdAoDfCNxCPvB}CPw@EcJkAcJqAkB_@mAKeEm@eEs@cCmA{AlD{ArDcDbI{IlTuFvM_D~HwC~GcFdLMX]v@]t@{@lBiN`[{EfKsD|GmIpOcCrEi@x@]`@oAjA}GhG_Az@eD|BDX?f@AXQ`B?ZfDjWV~C?~@?|@IrAc@bCi@jBuArEgFtPeEhNOb@]hA]fA{@lC]bAO`@oDjMc@pAW`@a@f@}@d@m@NcBJwANSH?@CFEBO@AAQB_@N_Av@m@n@g@dAUh@WfAm@hDiBrJaG~[g@pCIvA?l@LRD@JFJNHV?ZETELQPIFWFY?]@a@JOD[^mAvByD`Hg@~@KX@f@pBxFjBhFRj@NpDZnCj@vI', NULL, '2021-12-08 13:03:35', '2021-12-08 13:30:37', 'NO', '23', 0.00000000, 0.00000000, 0.00000000),
(1346, 'KWD222956', 168, 101, 101, 1, 5092, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 4.90, 48.39, '', 'H7PV+JQX, Lusaka, Zambia', -15.41349710, 28.29474220, 'EastPark Mall, Corner of Great East andThabo Mbeki Rds, Lusaka, Zambia', -15.39038920, 28.32219410, '2021-12-08 13:50:30', NULL, '2021-12-08 13:51:13', '2021-12-08 14:09:00', 1, 1, 0, 0, 'bja}AuhukDPbCaBLeHz@aO|A}Fl@uALIPAl@ELMBu@Dq@_Js@uIy@yJ_@uCi@kC_AuC}AkDaBgCy@iAwDqEsBiCoCcD{AoB_EoEm@w@uDuEsM}OeK_M_BoB}FwGgAuAUM_@_@kAqA}BmCsDaFkAaBYWMMQGOOMYCSD]TSVITBfAMhB}Ad@a@RQH[?S?UMYs@i@UQA@A?A?CAAAAE@A{@q@m@i@@CACACn@{@m@e@USYUdAsA', NULL, '2021-12-08 13:49:31', '2021-12-08 14:51:07', 'NO', '17', 0.00000000, 0.00000000, 0.00000000),
(1347, 'KWD727607', 168, 0, 109, 1, 1843, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 12.68, 127.12, '', 'J86F+994, Lusaka, Zambia', -15.38903970, 28.32332800, 'Grandaddy’s Shoka Nyama, Plot 206 Palm, Lusaka, Zambia', -15.39605830, 28.39428310, '2021-12-08 14:53:51', NULL, NULL, NULL, 0, 0, 0, 0, '~q||Ag{zkDMsB?g@t@eBAAACAG_ABu@@Fn@LpAZhDRdC@Bj@tER~AHp@t@jDb@`B^dATd@RXHBXJJNHR@ZCLINSNUB]GOOMYCS?MBGOk@}@qCYaAu@{DOaAO}AE{@KwBB[w@yIq@kH{@mJo@sGOyBM_BKoC@sDDgCHuCX_MJ}FJaGCmEI}A[qC]_B]qBGOy@mBs@}C?_@GSKKICOGMOIUA]J]Jo@Do@Cg@W{Ac@iCkAmGq@cEqAkHaDwQwAcIo@uCi@yBSk@Oe@k@wBo@wCu@eEaB}IeCgNMa@o@gCw@cCc@o@a@WOWESEcBkIsWcAgF_B{IgB{JuAoHa@cDu@}KWeEg@_HS}Ab@CH@NxAj@|HlAfRL~Af@fDl@vCTQ^SV]J]Pk@fA_DvF}PpOge@D_@FIJIHAZ?d@AZ?ZCVSDKzCePjHSrQm@vDUf@Bb@Jv@h@PHX@j@AAo@?}HAgChC?fHAdG?|F@|E@jAWAyB?mE@qE?gDBsBaA?', NULL, '2021-12-08 14:51:28', '2021-12-08 14:53:58', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1348, 'KWD286966', 168, 0, 101, 1, 2562, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 12.76, 127.96, '', 'J86F+994, Lusaka, Zambia', -15.38918829, 28.32255186, 'Grandaddy’s Shoka Nyama, Plot 206 Palm, Lusaka, Zambia', -15.39605830, 28.39428310, '2021-12-08 14:54:24', NULL, NULL, NULL, 0, 0, 0, 0, 'zr||AqvzkD[{COeCFa@n@sACAAG?CuBDHz@VtC^zEBDBNn@hFVnB|@bEl@rBZt@Zd@LBZRJPDRATCLKPOHKBU?QGSUK[AQBOm@sBi@cBi@yBe@mCMoAMuAAe@GgABm@cA{Ks@yH_B{PUgDMcBE}A@sDLeGHwBX_NJsGBkB?aCMiD[qCWgAc@iCa@{@m@gB]cBGS@ME[KUQCOIMSGU@_@L]L{@CcAgCsN}@oFgCiNwDqTyAoGc@oAk@yB}AaIoFaZaBaGSk@Wa@[[KEKIM[Ag@EeAK_@iGqR_AaDWkAcAwFiByJ}C{PUyBc@_GSaD}@aNS}ARAX?v@|JLfBpAxRf@fDl@vCp@c@Z_@Rs@tAaEjQmi@fDaKPi@D_@RSXA`AAZATGPSXyApBqKP_AdACzDMfBErIY`FQdCQb@Af@F\\Nt@f@RBx@?C}L?w@xA?zD?hGAdPBlA?jAWA_H?gD@qDB{DaA?', NULL, '2021-12-08 14:54:24', '2021-12-08 14:55:10', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1349, 'KWD410568', 168, 101, 101, 1, 5213, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 12.76, 127.94, '', 'T4, Lusaka, Zambia', -15.38918433, 28.32256549, 'Grandaddy’s Shoka Nyama, Plot 206 Palm, Lusaka, Zambia', -15.39605830, 28.39428310, '2021-12-08 14:56:15', NULL, '2021-12-08 14:57:10', '2021-12-08 15:21:23', 1, 1, 0, 0, 'zr||AsvzkD[yCOeCFa@n@sACAAG?CuBDHz@VtC^zEBDBNn@hFVnB|@bEl@rBZt@Zd@LBZRJPDRATCLKPOHKBU?QGSUK[AQBOm@sBi@cBi@yBe@mCMoAMuAAe@GgABm@cA{Ks@yH_B{PUgDMcBE}A@sDLeGHwBX_NJsGBkB?aCMiD[qCWgAc@iCa@{@m@gB]cBGS@ME[KUQCOIMSGU@_@L]L{@CcAgCsN}@oFgCiNwDqTyAoGc@oAk@yB}AaIoFaZaBaGSk@Wa@[[KEKIM[Ag@EeAK_@iGqR_AaDWkAcAwFiByJ}C{PUyBc@_GSaD}@aNS}ARAX?v@|JLfBpAxRf@fDl@vCp@c@Z_@Rs@tAaEjQmi@fDaKPi@D_@RSXA`AAZATGPSXyApBqKP_AdACzDMfBErIY`FQdCQb@Af@F\\Nt@f@RBx@?C}L?w@xA?zD?hGAdPBlA?jAWA_H?gD@qDB{DaA?', NULL, '2021-12-08 14:56:15', '2021-12-08 15:22:25', 'NO', '24', 0.00000000, 0.00000000, 0.00000000),
(1350, 'KWD891264', 168, 0, 123, 1, 3463, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.45, 54.07, '', 'Unnamed Road, Lusaka, Zambia', -15.39804750, 28.38540340, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-08 23:40:22', NULL, NULL, NULL, 0, 0, 0, 0, 'nl~|AgaglDw@Le@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-08 23:40:22', '2021-12-08 23:40:29', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1351, 'KWD525718', 168, 0, 123, 1, 2710, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 11.86, 118.79, '', 'Unnamed Road, Lusaka, Zambia', -15.39807600, 28.38535200, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-09 00:06:21', NULL, NULL, NULL, 0, 0, 0, 0, 'hk~|A}~flDt@pDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zE@P\\hELjAJf@x@lE\\lAh@zAnApCx@xAb@x@hBfCnGrH|B`CT\\|HnJjFfGhMrO~AnBOLsCkDYBSF]X[RG?KGQ_@CGUPCB?DDJxB`CvAdB', NULL, '2021-12-09 00:06:21', '2021-12-09 00:06:28', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1352, 'KWD837264', 168, 0, 123, 1, 7944, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.46, 54.11, '', 'Unnamed Road, Lusaka, Zambia', -15.39808190, 28.38542130, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-09 00:08:40', NULL, NULL, NULL, 0, 0, 0, 0, 'vl~|AgaglD_ALe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-09 00:08:40', '2021-12-09 00:08:45', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1353, 'KWD421558', 168, 0, 123, 1, 3271, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 9.24, 92.34, '', 'Unnamed Road, Lusaka, Zambia', -15.39804790, 28.38540420, 'Wayaya All Events, H8FV+HF7, Lusaka, Zambia', -15.42608620, 28.34367950, '2021-12-09 00:10:06', NULL, NULL, NULL, 0, 0, 0, 0, 'nl~|AgaglDnC]a@mCjCc@YgBa@iC_@}BaAaG_@cCn@WvCmA@wH?{BAyCd@Ap@COoAACdCYzIeAzDe@zAWzB|D|HzLzDnGlCxEzGnKbCtDd@v@d@v@hAfBx@nALRFTRl@b@rAjArDPj@Tj@J^Bd@Ab@MhAOfAUfAQfAa@|Bg@nCEb@A`@@THb@R^VZf@p@xAlAlB|AV\\T\\^`At@tBt@tBpAxDRx@X~@n@`Cp@~Bb@|BF^t@~F~Ks@pG[d@L|@RN@tASh@Bv@JlKtBdKpBxCTpCh@xKvBbEv@`HfArARALCXEXIt@WrBUjBc@hEmArJq@zF{@~G_@vCMjAGd@c@fEi@`EQxBi@rEeChRG`@M`A[fCw@bGu@jGM`A{ChVeAfIbBRjBV', NULL, '2021-12-09 00:10:06', '2021-12-09 00:10:13', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1354, 'KWD997954', 168, 0, 105, 1, 2943, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.79, 57.47, '', 'Unnamed Road, Lusaka, Zambia', -15.39818810, 28.38529460, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-09 00:51:24', NULL, NULL, NULL, 0, 0, 0, 0, 'nk~|Ak~flDn@~CeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-09 00:51:24', '2021-12-09 00:51:35', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1355, 'KWD920087', 168, 123, 123, 1, 4677, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 5.79, 57.52, '', 'Unnamed Road, Lusaka, Zambia', -15.39861920, 28.38518700, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-09 01:06:34', NULL, '2021-12-09 01:07:05', '2021-12-09 01:08:27', 1, 1, 0, 0, 'rp~|Ak}flDiBrBoBrCe@LUMOb@Gj@D_@ECoMwBsJgBoASs@a@_@IK?kBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@gET{Ql@{DLeABDW`BgJpAaH\\qBz@aFLaA?_@E?Y@gFeA_GoAeH_BqCa@aG_AoE}@w@Iy@AmBBy@Fu@NsBr@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EoB}L]iBUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-09 01:06:34', '2021-12-09 01:30:54', 'NO', '1', 0.00000000, 0.00000000, 0.00000000),
(1356, 'KWD820650', 278, 0, 123, 1, 5201, 0, 'CANCELLED', 'NONE', 'Cancelled by Admin', 'CASH', 0, 5.39, 53.39, NULL, 'Honeybed lodge, Lusaka, Zambia', -15.39749760, 28.38583280, 'Waterfalls Mall, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-09 01:14:57', '2021-12-09 01:14:00', NULL, NULL, 0, 0, 0, 0, 'dj~|AwbglDcAeFWqAyBd@eAH_CEgC?wA?kC@yD?aM?mCASCSKa@[]Og@Gc@@gETcIXwGR{DLeABDW`BgJpAaH\\qBz@aFLaA?_@E?Y@gFeA_GoAeH_BqCa@aG_AcDo@y@Ow@Iy@?oBBw@J[FKBsBr@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EoB}L]iBUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-09 01:14:57', '2021-12-09 01:15:07', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1357, 'KWD460447', 278, 0, 0, 1, 9268, 0, 'CANCELLED', 'NONE', 'Cancelled by Admin', 'CASH', 0, 5.39, 53.39, NULL, 'Honeybed lodge, Lusaka, Zambia', -15.39749760, 28.38583280, 'Waterfalls Mall, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-09 01:14:57', '2021-12-09 01:14:00', NULL, NULL, 0, 0, 0, 0, 'dj~|AwbglDcAeFWqAyBd@eAH_CEgC?wA?kC@yD?aM?mCASCSKa@[]Og@Gc@@gETcIXwGR{DLeABDW`BgJpAaH\\qBz@aFLaA?_@E?Y@gFeA_GoAeH_BqCa@aG_AcDo@y@Ow@Iy@?oBBw@J[FKBsBr@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EoB}L]iBUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-09 01:14:57', '2021-12-09 01:17:23', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1358, 'KWD357937', 269, 123, 123, 1, 1623, 0, 'CANCELLED', 'PROVIDER', 'Not found ', 'CASH', 0, 5.39, 53.39, NULL, 'Honeybed lodge, Lusaka, Zambia', -15.39749760, 28.38583280, 'Waterfalls Mall, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-09 01:16:58', '2021-12-09 01:15:00', NULL, NULL, 0, 0, 0, 0, 'dj~|AwbglDcAeFWqAyBd@eAH_CEgC?wA?kC@yD?aM?mCASCSKa@[]Og@Gc@@gETcIXwGR{DLeABDW`BgJpAaH\\qBz@aFLaA?_@E?Y@gFeA_GoAeH_BqCa@aG_AcDo@y@Ow@Iy@?oBBw@J[FKBsBr@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EoB}L]iBUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-09 01:16:58', '2021-12-11 15:42:30', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1359, 'KWD722657', 269, 0, 125, 3, 5291, 0, 'CANCELLED', 'NONE', 'Cancelled by Admin', 'CASH', 0, 4.95, 65.00, NULL, 'Salama Park, Lusaka, Lusaka, Zambia', -15.39815260, 28.39243800, 'Waterfalls Mall, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-09 01:19:05', '2021-12-09 01:18:00', NULL, NULL, 0, 0, 0, 0, 'lm~|AklhlDuD?mD??_BB{DBmBBq@uC@gD@qEC{BFqC?mKAkGBI?[?o@?w@@}@?[?mE@iGG]bBeAbH@NE?Y@gFeA_GoAeH_BqCa@aG_AoE}@w@Iy@AmBBy@Fu@NsBr@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EoB}L]iBUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-09 01:19:05', '2021-12-09 01:19:14', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1360, 'KWD453676', 269, 0, 125, 3, 5479, 0, 'CANCELLED', 'NONE', 'Cancelled by Admin', 'CASH', 0, 4.95, 65.00, NULL, 'Salama Park, Lusaka, Lusaka, Zambia', -15.39815260, 28.39243800, 'Waterfalls Mall, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-09 01:19:59', '2021-12-09 01:19:00', NULL, NULL, 0, 0, 0, 0, 'lm~|AklhlDuD?mD??_BB{DBmBBq@uC@gD@qEC{BFqC?mKAkGBI?[?o@?w@@}@?[?mE@iGG]bBeAbH@NE?Y@gFeA_GoAeH_BqCa@aG_AoE}@w@Iy@AmBBy@Fu@NsBr@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EoB}L]iBUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-09 01:19:59', '2021-12-09 01:20:02', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1361, 'KWD385186', 273, 123, 123, 1, 2342, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 12.35, 123.79, '', 'Unnamed Road, Lusaka, Zambia', -15.39805570, 28.38526070, 'Water Resources Management Authority[WARMA (HQ)], Plot Nos. LN-385-7 & LN-385, 8 Alick Nkhata Rd, Lusaka, Zambia', -15.41205700, 28.31833410, '2021-12-09 02:35:45', NULL, '2021-12-09 02:36:20', '2021-12-09 02:37:10', 1, 1, 0, 0, 'nk~|Am~flDn@`DeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHDDLFz@VZHf@Vb@Rb@JjAJPHB?h@BbBTvGnA~HvAnK`BxLfBjMnBbAZbAd@fAb@fB\\jFt@bDb@z@HSrDk@fFAZq@vFiAdHGLw@dHcB`NcAtHWdAMZ_CvBlI|PzBtEvAfCn@v@Xj@vBlE~CpGX~@n@jCF?ZEx@Ix@IrBUrBSrI{@rAUhCm@`GqAz@lA~@fAz@p@`Ax@fAl@zAv@', NULL, '2021-12-09 02:35:45', '2021-12-09 02:37:29', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1362, 'KWD221379', 273, 123, 123, 1, 8135, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 5.45, 54.00, '', 'Unnamed Road, Lusaka, Zambia', -15.39798610, 28.38545080, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-09 02:57:25', NULL, '2021-12-09 02:58:05', '2021-12-09 03:02:07', 1, 1, 0, 0, 'dl~|AcaglDm@He@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-09 02:57:25', '2021-12-09 03:02:49', 'NO', '4', 0.00000000, 0.00000000, 0.00000000),
(1363, 'KWD717297', 168, 102, 102, 1, 9081, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 5.46, 54.09, '', 'Unnamed Road, Lusaka, Zambia', -15.39807730, 28.38537550, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-09 03:03:34', NULL, '2021-12-09 03:04:12', '2021-12-09 03:04:25', 1, 1, 0, 0, 'rl~|AgaglD{@Le@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-09 03:03:34', '2021-12-09 13:20:48', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1364, 'KWD675288', 273, 123, 123, 1, 2423, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 11.74, 117.61, '', 'Unnamed Road, Lusaka, Zambia', -15.39817170, 28.38546580, 'Eataly Restaurant & Pizzeria Rhodespark, Twikatane Rd, Lusaka, Zambia', -15.40275710, 28.30770630, '2021-12-09 08:10:21', NULL, '2021-12-09 08:10:56', '2021-12-09 08:11:20', 1, 1, 0, 0, 'hm~|AkaglDqAPe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@{CdPEJWR[B[?aA@I@KHGHE^w@`CmEzMkGhRwF|PyAjEK\\W\\_@RUPBHfB`KbBtI~@bE~@~CtGpRLXJJf@f@HJN^B`@DbA|@xCr@jC|@jE|DtT|B|M|B`LpCjOxFn\\d@hCNf@T~AZzADt@Fl@NZDBJJJPBXARAFEFBJHf@Jb@\\vAX|AbArFPbAXnCPpDCxDWzK[nPMvGAjBJrC~@vJz@bJb@~EVlDh@zFZrE^zDR|AP~@p@|Cb@pAh@tApAnCd@z@pArBbBvBrFnGtB|BRVpNzP~EbGzJtLX\\d@h@PT|AlB`CvCdDsC`Aw@n@_@|@c@dAe@jAa@~@UDNLd@', NULL, '2021-12-09 08:10:21', '2021-12-09 08:11:48', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1365, 'KWD179225', 273, 0, 101, 1, 1171, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.79, 57.49, '', 'Unnamed Road, Lusaka, Zambia', -15.39808340, 28.38528160, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-09 09:05:02', NULL, NULL, NULL, 0, 0, 0, 0, 'lk~|Ao~flDp@bDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-09 09:05:02', '2021-12-09 09:05:07', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1366, 'KWD508310', 273, 123, 123, 1, 9626, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 5.80, 57.54, '', 'Unnamed Road, Lusaka, Zambia', -15.39811690, 28.38534510, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-09 09:09:48', NULL, '2021-12-09 09:10:20', '2021-12-09 09:10:31', 1, 1, 0, 0, 'jk~|Ay~flDr@lDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-09 09:09:48', '2021-12-09 11:48:48', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1367, 'KWD624461', 168, 0, 101, 1, 6841, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 20.46, 205.73, '', 'Unnamed Road, Lusaka, Zambia', -15.39817830, 28.38528730, 'Makeni Mall, Makeni, T2, Lusaka, Zambia', -15.45381920, 28.26621590, '2021-12-09 13:32:07', NULL, NULL, NULL, 0, 0, 0, 0, 'nk~|Ak~flDn@~CeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zE@P\\hELjAJf@x@lE\\lAh@zAnApCx@xAb@x@hBfCnGrH|B`CT\\|HnJjFfGhMrOtBhCd@h@tEtFj@v@zDtEtDfEzC|DzAfBfBtB`ArA`BhCd@`AbAlCf@~AV|@b@bC\\nCF|@r@nIbA~LZhEXvChAlNp@pH`ApLXlCZ~BXtBTfDPtBf@pGJr@HPLFDBBBXIdAUpEe@hPyA~RgBvRiBd^aDb@Gf@OJUZSVA\\PLV|Iy@dDE|@FpBZvBj@bBz@~@f@~@v@nAvAfApBj@jAbCxFhA~ArAtArA`ApB`A~CpA~Y|LxPdHbEnB`A^lD|AvQtH|Q~HtD~AhCnAh@RtFjCtCpAWb@?FG\\?|@GJKBy@JCLFnA', NULL, '2021-12-09 13:32:07', '2021-12-09 13:32:24', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1368, 'KWD767829', 168, 0, 97, 1, 6126, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 12.79, 128.19, '', 'Unnamed Road, Lusaka, Zambia', -15.39809230, 28.38528340, 'Golden Peacock Hotel, Kasangula Rd, Lusaka, Zambia', -15.37498100, 28.30215450, '2021-12-09 14:05:30', NULL, NULL, NULL, 0, 0, 0, 0, 'lk~|Ao~flDp@bDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zEBD^tCj@rE|@bEl@rBZt@Xd@F@RFNLJPD`@I\\QNQF]CICe@H_@DyIrGoBvBU\\CAUQg@Ua@Mi@I}@G_A@cB^iBp@gBr@k@Nk@Jy@AiAKsDe@aBtDiA~CcA`C}AfE{G~PkA`DOVULq@A_DMWPeFvMtB`CX`@BNAVKZwFvN[v@', NULL, '2021-12-09 13:40:58', '2021-12-09 14:05:39', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1369, 'KWD526314', 168, 0, 97, 1, 3409, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 5.47, 54.19, '', 'Unnamed Road, Lusaka, Zambia', -15.39816920, 28.38535240, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-09 15:40:23', NULL, NULL, NULL, 0, 0, 0, 0, 'dm~|AkaglDmAPe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-09 15:37:59', '2021-12-09 15:41:35', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1370, 'KWD919930', 168, 0, 97, 1, 8325, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 5.47, 54.18, '', 'Unnamed Road, Lusaka, Zambia', -15.39813330, 28.38550190, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-09 15:45:31', NULL, NULL, NULL, 0, 0, 0, 0, 'bm~|AkaglDkAPe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-09 15:43:09', '2021-12-09 15:45:31', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1371, 'KWD101050', 168, 0, 101, 1, 2138, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.80, 57.55, '', 'Unnamed Road, Lusaka, Zambia', -15.39808220, 28.38533830, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-09 15:46:46', NULL, NULL, NULL, 0, 0, 0, 0, 'jk~|Ay~flDr@lDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-09 15:46:03', '2021-12-09 15:46:56', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1372, 'KWD491732', 168, 102, 102, 1, 1790, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 5.26, 52.05, '', '37 OFF GREAT EAST RD GREAT EAST RD ZAMBIA, Lusaka, Zambia', -15.36622320, 28.40132910, 'Honeybed lodge, 24 Olive Road, Salama Park Lusaka ZM, Lusaka 10101, Zambia', -15.39749760, 28.38583280, '2021-12-09 17:00:42', NULL, '2021-12-09 17:01:48', '2021-12-09 17:30:21', 1, 1, 0, 0, 'pex|AqbjlDl@Vz@V`@\\PuBL}@hAsCdFdCvAb@hARjCx@L[PORGPAVDXNPZ@ZAHLJNd@rCzPt@|Ep@Ol@KLC\\OvCyBbBwAn@|@xApBvGdJXb@Tl@DXBv@B?LCZGZEv@GlBAx@Bv@J|Cn@fEn@nB\\jBVbFhAjPlDb@BPA?^M`A_ApF{DhTWxAnCI`IUpNg@rBOf@Bb@JZTZRPHdA?`MBdLCrE?~BDr@EjCi@fAnFRfA', NULL, '2021-12-09 17:00:42', '2021-12-09 17:34:35', 'NO', '28', 0.00000000, 0.00000000, 0.00000000),
(1373, 'KWD584888', 168, 0, 102, 1, 4941, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 11.52, 115.36, '', 'Unnamed Road, Lusaka, Zambia', -15.39811530, 28.38539600, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-09 20:23:05', NULL, NULL, NULL, 0, 0, 0, 0, 'zl~|AiaglDcANe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@{CdPEJWR[B[?aA@I@KHGHE^w@`CmEzMkGhRwF|PyAjEK\\W\\_@RUPBHfB`KbBtI~@bE~@~CtGpRLXJJf@f@HJN^B`@DbA|@xCr@jC|@jE|DtT|B|M|B`LpCjOxFn\\d@hCNf@T~AZzADt@Fl@NZDBJJJPBXARAFEFBJHf@Jb@\\vAX|AbArFPbAXnCPpDCxDWzK[nPMvGAjBJrC~@vJz@bJb@~EVlDh@zFZrE^zDR|AP~@p@|Cb@pAh@tApAnCd@z@pArBbBvBrFnGtB|BRVpNzP~EbGzJtLOLsCkDg@Fq@h@IFI?OKSc@YV?F~BhCvAdB', NULL, '2021-12-09 20:23:05', '2021-12-09 20:23:32', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1374, 'KWD714371', 168, 0, 102, 1, 7898, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 11.52, 115.27, '', 'Unnamed Road, Lusaka, Zambia', -15.39804560, 28.38536690, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-09 20:27:29', NULL, NULL, NULL, 0, 0, 0, 0, 'll~|AeaglDu@Je@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@{CdPEJWR[B[?aA@I@KHGHE^w@`CmEzMkGhRwF|PyAjEK\\W\\_@RUPBHfB`KbBtI~@bE~@~CtGpRLXJJf@f@HJN^B`@DbA|@xCr@jC|@jE|DtT|B|M|B`LpCjOxFn\\d@hCNf@T~AZzADt@Fl@NZDBJJJPBXARAFEFBJHf@Jb@\\vAX|AbArFPbAXnCPpDCxDWzK[nPMvGAjBJrC~@vJz@bJb@~EVlDh@zFZrE^zDR|AP~@p@|Cb@pAh@tApAnCd@z@pArBbBvBrFnGtB|BRVpNzP~EbGzJtLOLsCkDg@Fq@h@IFI?OKSc@YV?F~BhCvAdB', NULL, '2021-12-09 20:27:29', '2021-12-09 20:28:23', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1375, 'KWD517579', 168, 102, 102, 1, 2668, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 11.52, 115.27, '', 'Unnamed Road, Lusaka, Zambia', -15.39804560, 28.38536690, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-09 20:27:36', NULL, NULL, NULL, 0, 0, 0, 0, 'll~|AeaglDu@Je@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@{CdPEJWR[B[?aA@I@KHGHE^w@`CmEzMkGhRwF|PyAjEK\\W\\_@RUPBHfB`KbBtI~@bE~@~CtGpRLXJJf@f@HJN^B`@DbA|@xCr@jC|@jE|DtT|B|M|B`LpCjOxFn\\d@hCNf@T~AZzADt@Fl@NZDBJJJPBXARAFEFBJHf@Jb@\\vAX|AbArFPbAXnCPpDCxDWzK[nPMvGAjBJrC~@vJz@bJb@~EVlDh@zFZrE^zDR|AP~@p@|Cb@pAh@tApAnCd@z@pArBbBvBrFnGtB|BRVpNzP~EbGzJtLOLsCkDg@Fq@h@IFI?OKSc@YV?F~BhCvAdB', NULL, '2021-12-09 20:27:36', '2021-12-09 20:28:11', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1376, 'KWD790978', 168, 102, 102, 1, 4639, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 11.86, 118.82, '', 'Unnamed Road, Lusaka, Zambia', -15.39803929, 28.38536413, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-09 20:29:08', NULL, '2021-12-09 20:30:15', '2021-12-09 20:32:37', 1, 1, 0, 0, 'hk~|Aa_glDt@tDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zE@P\\hELjAJf@x@lE\\lAh@zAnApCx@xAb@x@hBfCnGrH|B`CT\\|HnJjFfGhMrO~AnBOLsCkDYBSF]X[RG?KGQ_@CGUPCB?DDJxB`CvAdB', NULL, '2021-12-09 20:29:08', '2021-12-09 20:33:58', 'NO', '2', 0.00000000, 0.00000000, 0.00000000),
(1377, 'KWD676728', 273, 101, 101, 1, 5321, 0, 'CANCELLED', 'PROVIDER', 'bad client', 'CASH', 0, 11.52, 115.39, '', 'Unnamed Road, Lusaka, Zambia', -15.39815560, 28.38533250, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-09 20:35:27', NULL, NULL, NULL, 0, 0, 0, 0, '`m~|AiaglDiANe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@{CdPEJWR[B[?aA@I@KHGHE^w@`CmEzMkGhRwF|PyAjEK\\W\\_@RUPBHfB`KbBtI~@bE~@~CtGpRLXJJf@f@HJN^B`@DbA|@xCr@jC|@jE|DtT|B|M|B`LpCjOxFn\\d@hCNf@T~AZzADt@Fl@NZDBJJJPBXARAFEFBJHf@Jb@\\vAX|AbArFPbAXnCPpDCxDWzK[nPMvGAjBJrC~@vJz@bJb@~EVlDh@zFZrE^zDR|AP~@p@|Cb@pAh@tApAnCd@z@pArBbBvBrFnGtB|BRVpNzP~EbGzJtLOLsCkDg@Fq@h@IFI?OKSc@YV?F~BhCvAdB', NULL, '2021-12-09 20:35:27', '2021-12-09 20:37:35', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1378, 'KWD199374', 273, 0, 102, 1, 8028, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 11.86, 118.78, '', 'Unnamed Road, Lusaka, Zambia', -15.39798810, 28.38531440, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-09 21:53:15', NULL, NULL, NULL, 0, 0, 0, 0, 'jk~|A{~flDr@nDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zE@P\\hELjAJf@x@lE\\lAh@zAnApCx@xAb@x@hBfCnGrH|B`CT\\|HnJjFfGhMrO~AnBOLsCkDYBSF]X[RG?KGQ_@CGUPCB?DDJxB`CvAdB', NULL, '2021-12-09 21:53:15', '2021-12-09 21:53:31', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1379, 'KWD436208', 168, 102, 102, 1, 5888, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 5.46, 54.14, '', 'Unnamed Road, Lusaka, Zambia', -15.39811920, 28.38538250, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-09 23:34:09', NULL, '2021-12-09 23:34:48', '2021-12-09 23:37:00', 1, 1, 0, 0, '|l~|AiaglDeANe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-09 23:34:09', '2021-12-09 23:37:48', 'NO', '2', 0.00000000, 0.00000000, 0.00000000),
(1380, 'KWD518944', 168, 0, 102, 1, 6656, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.46, 54.09, '', 'Unnamed Road, Lusaka, Zambia', -15.39806110, 28.38544500, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-09 23:46:43', NULL, NULL, NULL, 0, 0, 0, 0, 'rl~|AgaglD{@Le@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-09 23:46:43', '2021-12-09 23:46:52', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1381, 'KWD164342', 273, 102, 102, 1, 2309, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 10.86, 108.74, '', '175 Kudu Rd, Lusaka, Zambia', -15.41009130, 28.34920620, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-10 07:09:59', NULL, '2021-12-10 07:11:33', '2021-12-10 07:20:07', 1, 1, 0, 0, 'zu`}As``lDUAcALq@TOuA_@{BMiASAwBDCRXtJl@bQ@^A?}ANeC^_BRyB\\mJtAeCZ`@dCFdAIpDEvCKdDO~CkBIOp@_BnG_AOkAKcLaBaB_@sAq@q@Wk@Os@MyDk@mIoA_LaBwGeAiDm@eF_AiFaAcBUi@CE?SKyAMc@Oi@[UKUEMDWHYLKTUPWBQGOKKQGYD_@FMJo@Do@Cg@W{Ac@iCkAmGq@cEqAkHuAwHkA_HwAcIo@uCi@yBSk@Oe@k@wBo@wCu@eEaB}IeCgNMa@o@gCw@cCc@o@UOKGIKK_@EcB{D_MoCsI_@iBmBmKUkAgB{JuAoHa@cDaAuNKmBg@_HS}Ao@oEiAaFaCuIaBoIqAoHcB{KiAoHeAcHuAoIaAcHg@_Du@}EoB}L]iBUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-10 07:09:59', '2021-12-10 07:20:38', 'NO', '8', 0.00000000, 0.00000000, 0.00000000),
(1382, 'KWD471137', 168, 0, 123, 1, 7008, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 11.06, 110.68, '', '175 Kudu Rd, Lusaka, Zambia', -15.41027350, 28.34925090, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-10 13:04:44', NULL, NULL, NULL, 0, 0, 0, 0, 'j|`}Aq~_lDpAvJxA~LBT_@BoDd@}Fv@sC`@`ClMlAvGRhABh@Gf@YfAo@fCu@dDShAcH_AgFs@kBUu@Gs@?oABu@EqC]mAUcG}@kAKoG_AsCa@aB_@sAq@q@Wk@Os@MyDk@iRqC{KeBoKmBiFaAcBUi@CIAOIk@Em@Gc@O_Ag@UEMDWHYLAFSVYJSCOGMOIUA]J]Jo@Do@Cg@W{Ac@iCkAmGq@cEqAkHaDwQwAcIo@uCi@yBSk@Oe@k@wBo@wCu@eEaB}IeCgNMa@o@gCw@cCc@o@a@WOWESEcBkIsWcAgF_B{IgB{JuAoHa@cDu@}KWeEg@_HS}Ao@oEiAaFaCuIaBoIqAoHcB{KiAoHeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-10 13:04:44', '2021-12-10 13:04:56', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1383, 'KWD815790', 273, 0, 123, 1, 5535, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 6.20, 61.64, '', '175 Kudu Rd, Lusaka, Zambia', -15.41019020, 28.34927440, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-10 13:24:29', NULL, NULL, NULL, 0, 0, 0, 0, 'h|`}Ay~_lDrA~JxA~LBT_@BoDd@}Fv@sC`@`ClMlAvGRhABh@Gf@YfAo@fCu@dD[bBqAzIe@dEm@~Fo@jFCNG^E^O`AKz@_@dCM~@e@hE{@xGKhA?nCJ~BLlA`@rAFPRb@j@fApAfCpAhCTd@`FdK~AxCPXqDt@DTC^IvCKb@oBvE{IdSe@nAIXQr@Sr@e@hBmApEg@hBQr@IXM`@[rAE\\E|BKpGARg@CeBA_CJ_Db@_B`@kA^cAd@aAd@k@\\aAv@eDrC[VKLYV[TQFGFKJYVu@p@YXKJIHiAiA?ODOrAqATQBMCGwE{F', NULL, '2021-12-10 13:24:29', '2021-12-10 13:25:10', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1384, 'KWD196626', 168, 0, 123, 1, 8030, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 11.06, 110.71, '', '175 Kudu Rd, Lusaka, Zambia', -15.41021440, 28.34926610, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-10 16:49:34', NULL, NULL, NULL, 0, 0, 0, 0, 'h|`}Aw~_lDrA|JxA~LBT_@BoDd@}Fv@sC`@`ClMlAvGRhABh@Gf@YfAo@fCu@dDShAcH_AgFs@kBUu@Gs@?oABu@EqC]mAUcG}@kAKoG_AsCa@aB_@sAq@q@Wk@Os@MyDk@iRqC{KeBoKmBiFaAcBUi@CIAOIk@Em@Gc@O_Ag@UEMDWHYLAFSVYJSCOGMOIUA]J]Jo@Do@Cg@W{Ac@iCkAmGq@cEqAkHaDwQwAcIo@uCi@yBSk@Oe@k@wBo@wCu@eEaB}IeCgNMa@o@gCw@cCc@o@a@WOWESEcBkIsWcAgF_B{IgB{JuAoHa@cDu@}KWeEg@_HS}Ao@oEiAaFaCuIaBoIqAoHcB{KiAoHeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-10 16:49:34', '2021-12-10 16:50:07', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1385, 'KWD488408', 168, 102, 102, 1, 1400, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 11.05, 110.64, '', '175 Kudu Rd, Lusaka, Zambia', -15.41013020, 28.34916500, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-10 16:51:39', NULL, '2021-12-10 16:52:20', '2021-12-10 16:52:32', 1, 1, 0, 0, 'bz`}Acz_lDj@E^IRMHh@n@|En@lFh@pEBT_@BoDd@{BZ_Gv@UD^rBnDpRRhABh@Gf@YfAo@fCu@dDShAcH_AgFs@kBUu@Gs@?oABu@EqC]mAUcG}@kAKcLaBaB_@sAq@q@Wk@Os@MyDk@mIoA_LaBwGeAiDm@eF_AiFaAcBUi@CE?SKyAMc@Oi@[UKUEMDWHYLKTUPWBQGOKKQGYD_@FMJo@Do@Cg@W{Ac@iCkAmGq@cEqAkHuAwHkA_HwAcIo@uCi@yBSk@Oe@k@wBo@wCu@eEaB}IeCgNMa@o@gCw@cCc@o@UOKGIKK_@EcB{D_MoCsI_@iBmBmKUkAgB{JuAoHa@cDaAuNKmBg@_HS}Ao@oEiAaFaCuIaBoIqAoHcB{KiAoHeAcHuAoIaAcHg@_Du@}EoB}L]iBUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-10 16:51:39', '2021-12-10 16:58:02', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1386, 'KWD900166', 168, 0, 102, 1, 4060, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 11.05, 110.64, '', '175 Kudu Rd, Lusaka, Zambia', -15.41011660, 28.34918590, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-10 16:58:43', NULL, NULL, NULL, 0, 0, 0, 0, 'bz`}Acz_lDj@E^IRMHh@n@|En@lFh@pEBT_@BoDd@{BZ_Gv@UD^rBnDpRRhABh@Gf@YfAo@fCu@dDShAcH_AgFs@kBUu@Gs@?oABu@EqC]mAUcG}@kAKcLaBaB_@sAq@q@Wk@Os@MyDk@mIoA_LaBwGeAiDm@eF_AiFaAcBUi@CE?SKyAMc@Oi@[UKUEMDWHYLKTUPWBQGOKKQGYD_@FMJo@Do@Cg@W{Ac@iCkAmGq@cEqAkHuAwHkA_HwAcIo@uCi@yBSk@Oe@k@wBo@wCu@eEaB}IeCgNMa@o@gCw@cCc@o@UOKGIKK_@EcB{D_MoCsI_@iBmBmKUkAgB{JuAoHa@cDaAuNKmBg@_HS}Ao@oEiAaFaCuIaBoIqAoHcB{KiAoHeAcHuAoIaAcHg@_Du@}EoB}L]iBUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-10 16:58:43', '2021-12-10 16:58:50', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1387, 'KWD106918', 168, 0, 102, 1, 6897, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 11.05, 110.64, '', '175 Kudu Rd, Lusaka, Zambia', -15.41014010, 28.34916980, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-10 17:08:36', NULL, NULL, NULL, 0, 0, 0, 0, 'bz`}Acz_lDj@E^IRMHh@n@|En@lFh@pEBT_@BoDd@{BZ_Gv@UD^rBnDpRRhABh@Gf@YfAo@fCu@dDShAcH_AgFs@kBUu@Gs@?oABu@EqC]mAUcG}@kAKcLaBaB_@sAq@q@Wk@Os@MyDk@mIoA_LaBwGeAiDm@eF_AiFaAcBUi@CE?SKyAMc@Oi@[UKUEMDWHYLKTUPWBQGOKKQGYD_@FMJo@Do@Cg@W{Ac@iCkAmGq@cEqAkHuAwHkA_HwAcIo@uCi@yBSk@Oe@k@wBo@wCu@eEaB}IeCgNMa@o@gCw@cCc@o@UOKGIKK_@EcB{D_MoCsI_@iBmBmKUkAgB{JuAoHa@cDaAuNKmBg@_HS}Ao@oEiAaFaCuIaBoIqAoHcB{KiAoHeAcHuAoIaAcHg@_Du@}EoB}L]iBUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-10 17:08:36', '2021-12-10 17:08:54', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1388, 'KWD567174', 273, 0, 123, 1, 5461, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 16.77, 168.47, '', 'H77R+XJ5, Lusaka, Zambia', -15.43608530, 28.29197560, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-11 11:49:25', NULL, NULL, NULL, 0, 0, 0, 0, 'dze}AwwtkDw@{ISkCSaCs@gF?MAG?QAc@Aa@AQDOL_@Z_Ax@cCN_@DOAAcGeCiAq@w@]_FgCw@i@eDcC}DeDkFsEg@WiA_@g@YsAgAmA_A_E_DiDuBc@EiA{@i@e@_@Q]LGDMEeBeDq@v@]V]NyAXcATkH`@WEsA_AsAeA}AvB?BNVBXOb@kClDKPQL[DY@MEw@MWCkAJwQrAgF\\e@L?NETELQPIFWFY?WIQOMWEa@O[U[{CiBeF{CkHuD_MgGcBo@gBc@}@OuBUoAGeBA_CJ_Db@_B`@kA^cAd@aAd@k@\\aAv@eDrCQNKM}ByCyKyMoMuO_GeH}DoEmEsFmDeEkA_BgBqCe@gAg@mAqAoD[iAm@iDIi@q@kHeAiL_BiQo@sGOyBM_BKoC@sDDgCHuCX_MJ}FJaGCmEI}A[qC]_B]qBGOy@mB[sAWiA?_@GSKKQGOKKQGYD_@FMJo@Do@Cg@W{Ac@iCkAmGq@cEqAkHuAwHkA_HwAcIo@uCi@yBSk@Oe@k@wBo@wCu@eEaB}IeCgNMa@o@gCw@cCc@o@UOKGIKK_@EcB{D_MoCsI_@iBmBmKUkAgB{JuAoHa@cDaAuNKmBg@_HS}Ao@oEiAaFaCuIaBoIqAoHcB{KiAoHeAcHuAoIaAcHg@_Du@}EoB}L]iBUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-11 11:49:25', '2021-12-11 11:49:30', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1389, 'KWD608708', 273, 123, 123, 1, 6357, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 16.77, 168.49, '', 'H77R+XJ5, Lusaka, Zambia', -15.43606310, 28.29194890, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-11 11:51:41', NULL, NULL, NULL, 0, 0, 0, 0, 'dze}AswtkDw@_JSkCSaCs@gF?MAG?QAc@Aa@AQDOL_@Z_Ax@cCN_@DOAAcGeCiAq@w@]_FgCw@i@eDcC}DeDkFsEg@WiA_@g@YsAgAmA_A_E_DiDuBc@EiA{@i@e@_@Q]LGDMEeBeDq@v@]V]NyAXcATkH`@WEsA_AsAeA}AvB?BNVBXOb@kClDKPQL[DY@MEw@MWCkAJwQrAgF\\e@L?NETELQPIFWFY?WIQOMWEa@O[U[{CiBeF{CkHuD_MgGcBo@gBc@}@OuBUoAGeBA_CJ_Db@_B`@kA^cAd@aAd@k@\\aAv@eDrCQNKM}ByCyKyMoMuO_GeH}DoEmEsFmDeEkA_BgBqCe@gAg@mAqAoD[iAm@iDIi@q@kHeAiL_BiQo@sGOyBM_BKoC@sDDgCHuCX_MJ}FJaGCmEI}A[qC]_B]qBGOy@mB[sAWiA?_@GSKKQGOKKQGYD_@FMJo@Do@Cg@W{Ac@iCkAmGq@cEqAkHuAwHkA_HwAcIo@uCi@yBSk@Oe@k@wBo@wCu@eEaB}IeCgNMa@o@gCw@cCc@o@UOKGIKK_@EcB{D_MoCsI_@iBmBmKUkAgB{JuAoHa@cDaAuNKmBg@_HS}Ao@oEiAaFaCuIaBoIqAoHcB{KiAoHeAcHuAoIaAcHg@_Du@}EoB}L]iBUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-11 11:51:41', '2021-12-11 12:02:45', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1390, 'KWD131726', 170, 123, 123, 1, 4527, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 4.00, 45.00, '', 'H77W+H5W, Lusaka, Zambia', -15.43552120, 28.29567390, 'St Patricks School, H882+47P, Lusaka, Zambia', -15.43466520, 28.30071340, '2021-12-11 12:02:55', NULL, '2021-12-11 12:03:47', '2021-12-11 13:08:23', 1, 1, 0, 0, 'jve}AynukDYaCAQAc@Aa@AQBOL_@L_@Z_Az@cCDOBCeEaByAq@u@i@fAwAzA{C@C', NULL, '2021-12-11 12:02:55', '2021-12-11 13:08:51', 'NO', '4', 0.00000000, 0.00000000, 0.00000000),
(1391, 'KWD820483', 273, 0, 101, 1, 2065, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.46, 54.09, '', 'Unnamed Road, Lusaka, Zambia', -15.39807630, 28.38539290, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-11 13:52:14', NULL, NULL, NULL, 0, 0, 0, 0, 'tl~|AgaglD}@Le@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-11 13:52:14', '2021-12-11 13:52:24', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1392, 'KWD277113', 168, 0, 123, 1, 9851, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.47, 54.18, '', 'Unnamed Road, Lusaka, Zambia', -15.39816780, 28.38532420, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-11 14:49:15', NULL, NULL, NULL, 0, 0, 0, 0, 'bm~|AkaglDkAPe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-11 14:49:15', '2021-12-11 14:49:22', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000);
INSERT INTO `user_requests` (`id`, `booking_id`, `user_id`, `provider_id`, `current_provider_id`, `service_type_id`, `otp`, `returntrip`, `status`, `cancelled_by`, `cancel_reason`, `payment_mode`, `paid`, `distance`, `amount`, `specialNote`, `s_address`, `s_latitude`, `s_longitude`, `d_address`, `d_latitude`, `d_longitude`, `assigned_at`, `schedule_at`, `started_at`, `finished_at`, `user_rated`, `provider_rated`, `use_wallet`, `surge`, `route_key`, `deleted_at`, `created_at`, `updated_at`, `is_track`, `travel_time`, `track_distance`, `track_latitude`, `track_longitude`) VALUES
(1393, 'KWD893888', 168, 123, 123, 1, 5520, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 9.11, 91.00, '', '1001, Block F State Life Phase 1 State Life, Lahore, Punjab, Pakistan', 31.44290990, 74.39833780, 'DHA Phase 6, DHA Phase 6, Lahore, Punjab, Pakistan', 31.47150490, 74.45842450, '2021-12-11 15:38:58', NULL, '2021-12-11 15:39:20', '2021-12-11 15:39:27', 1, 1, 0, 0, 'oe|~Do|aeMJ\\jBg@Hj@gBp@k@LNv@cCn@m@?kBWmASqBWuDa@c@CQ@UFaAx@c@T]Fs@CmC[oBYgCYcEg@\\wDReDFuC@{CCyBOsCSaC]qCsAqIsEiUaAcFIo@aBcImAkFe@aC{@qCwA_FwAaDSYgA_CaDgFyCkEsCiE_FuH}GuJ_FqHuDkFcBeCq@eAk@cAw@gBqAqC]y@_AcBk@qAKg@Cc@@[D[Vy@Vs@R{@Bk@Ak@YeB?]B]L_@\\]XQJMF_@I]KAIAYLK?wAnAeAt@aBtAs@b@aAr@g@\\}@j@}AbAy@n@[j@O\\EP_@b@ULUDi@CQIIMCO?QEi@QaAQi@OSGGM_@Kq@Ce@BqC@}DA}BCi@M}@[}@a@w@_@c@u@}@[m@i@iAUe@wAuC{EqHeFsHiBkCqC_E}AiCy@gAcCqDmC{DqF_I_GyIoDwFKOTQhAkAlBsBvT}UnCsCvMuN`@a@NBZF', NULL, '2021-12-11 15:38:58', '2021-12-11 15:39:43', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1394, 'KWD467724', 168, 0, 101, 1, 2175, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.47, 54.18, '', 'Unnamed Road, Lusaka, Zambia', -15.39816570, 28.38532470, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-11 15:42:54', NULL, NULL, NULL, 0, 0, 0, 0, 'bm~|AkaglDkAPe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-11 15:42:54', '2021-12-11 15:42:58', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1395, 'KWD622760', 168, 0, 123, 1, 1466, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 9.11, 91.04, '', '1001, Block F State Life Phase 1 State Life, Lahore, Punjab, Pakistan', 31.44288330, 74.39838590, 'DHA Phase 6, DHA Phase 6, Lahore, Punjab, Pakistan', 31.47150490, 74.45842450, '2021-12-11 15:43:12', NULL, NULL, NULL, 0, 0, 0, 0, 'oe|~Dw|aeMJd@jBg@Hj@gBp@k@LNv@cCn@m@?kBWmASqBWuDa@c@CQ@UFaAx@c@T]Fs@CmC[oBYgCYcEg@\\wDReDFuC@{CCyBOsCSaC]qCsAqIsEiUaAcFIo@aBcImAkFe@aC{@qCwA_FwAaDSYgA_CaDgFyCkEsCiE_FuH}GuJ_FqHuDkFcBeCq@eAk@cAw@gBqAqC]y@_AcBk@qAKg@Cc@@[D[Vy@Vs@R{@Bk@Ak@YeB?]B]L_@\\]XQJMF_@I]KAIAYLK?wAnAeAt@aBtAs@b@aAr@g@\\}@j@}AbAy@n@[j@O\\EP_@b@ULUDi@CQIIMCO?QEi@QaAQi@OSGGM_@Kq@Ce@BqC@}DA}BCi@M}@[}@a@w@_@c@u@}@[m@i@iAUe@wAuC{EqHeFsHiBkCqC_E}AiCy@gAcCqDmC{DqF_I_GyIoDwFKOTQhAkAlBsBvT}UnCsCvMuN`@a@NBZF', NULL, '2021-12-11 15:43:12', '2021-12-11 15:44:25', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1396, 'KWD211161', 168, 0, 123, 1, 8920, 0, 'CANCELLED', 'USER', 'vv', 'CASH', 0, 9.11, 91.04, '', '1001, Block F State Life Phase 1 State Life, Lahore, Punjab, Pakistan', 31.44288540, 74.39838390, 'DHA Phase 6, DHA Phase 6, Lahore, Punjab, Pakistan', 31.47150490, 74.45842450, '2021-12-11 16:09:57', NULL, NULL, NULL, 0, 0, 0, 0, 'oe|~Dw|aeMJd@jBg@Hj@gBp@k@LNv@cCn@m@?kBWmASqBWuDa@c@CQ@UFaAx@c@T]Fs@CmC[oBYgCYcEg@\\wDReDFuC@{CCyBOsCSaC]qCsAqIsEiUaAcFIo@aBcImAkFe@aC{@qCwA_FwAaDSYgA_CaDgFyCkEsCiE_FuH}GuJ_FqHuDkFcBeCq@eAk@cAw@gBqAqC]y@_AcBk@qAKg@Cc@@[D[Vy@Vs@R{@Bk@Ak@YeB?]B]L_@\\]XQJMF_@I]KAIAYLK?wAnAeAt@aBtAs@b@aAr@g@\\}@j@}AbAy@n@[j@O\\EP_@b@ULUDi@CQIIMCO?QEi@QaAQi@OSGGM_@Kq@Ce@BqC@}DA}BCi@M}@[}@a@w@_@c@u@}@[m@i@iAUe@wAuC{EqHeFsHiBkCqC_E}AiCy@gAcCqDmC{DqF_I_GyIoDwFKOTQhAkAlBsBvT}UnCsCvMuN`@a@NBZF', NULL, '2021-12-11 16:09:57', '2021-12-11 16:10:05', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1397, 'KWD596676', 273, 123, 123, 1, 6958, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 5.80, 57.55, '', 'Unnamed Road, Lusaka, Zambia', -15.39807200, 28.38534230, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-11 16:35:06', NULL, '2021-12-11 16:37:11', '2021-12-11 16:37:30', 1, 1, 0, 0, 'jk~|A{~flDr@nDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-11 16:35:06', '2021-12-11 16:39:19', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1398, 'KWD232620', 168, 102, 102, 1, 9564, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 5.80, 57.56, '', 'Unnamed Road, Lusaka, Zambia', -15.39804860, 28.38533670, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-11 16:54:42', NULL, '2021-12-11 16:55:47', '2021-12-11 16:55:55', 1, 1, 0, 0, 'jk~|A{~flDr@nDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-11 16:54:42', '2021-12-11 16:56:14', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1399, 'KWD158888', 168, 101, 101, 1, 5720, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.79, 57.50, '', 'Unnamed Road, Lusaka, Zambia', -15.39811270, 28.38530180, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-11 17:33:06', NULL, NULL, NULL, 0, 0, 0, 0, 'lk~|Aq~flDp@dDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-11 17:31:54', '2021-12-11 17:33:53', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1400, 'KWD911384', 168, 0, 123, 1, 9091, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 10.03, 100.34, '', 'Unnamed Road, Lusaka, Zambia', -15.42948590, 28.36852270, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-11 18:23:38', NULL, NULL, NULL, 0, 0, 0, 0, 'bqd}AuuclDaG_AcEw@yKwBqCi@yCUeKqBmKuBqAOO?gAP]?cBa@qGZ_Lr@y@oGG_@SaAk@{BaBaGMi@u@wBi@cBu@uBw@uBO_@U]q@u@oB}Ak@e@c@e@m@w@S_@Ic@?w@LgAh@oC^}Bf@oCNgADe@@c@Ce@ESIWUi@e@yAiAmDe@yAIUMS]g@aA{AmAoBa@q@uGcKcCyDmCyE{DoGsB_DiE{G{B}D{AV{Dd@{IdAeCXUmAy@?}CAoED_BAqJDsFE_CFaB?cMAsCD_CA[?q@?w@@}@?[?oC?cA@eCCcCC[bBaA|FCt@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@kB_@[E]Cw@CoBBw@Fw@Lu@TcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-11 18:23:38', '2021-12-11 18:24:40', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1401, 'KWD925054', 168, 0, 102, 1, 5503, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 13.70, 137.42, '', '66 Twin Palms Rd, Lusaka, Zambia', -15.42781300, 28.35441290, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-11 18:58:34', NULL, NULL, NULL, 0, 0, 0, 0, '~fd}A{~`lDgBYgArICLG`@M`A[fCu@bGw@jG[jCqE~]yASaEKoFKsCGeEh@}BXyGdAaLbB}Ft@kGx@iFx@}@P?EaAmIq@cG[uB_@BoDd@{BZ_Gv@UD^rBnDpRRhABh@Gf@YfAo@fCu@dDShAcH_AgFs@kBUu@Gs@?oABu@EqC]mAUcG}@kAKcLaBaB_@sAq@q@Wk@Os@MyDk@mIoA_LaBwGeAiDm@eF_AiFaAcBUi@CE?SKyAMc@Oi@[UKUEMDWHYLKTUPWBQGOKKQGYD_@FMJo@Do@Cg@W{Ac@iCkAmGq@cEqAkHuAwHkA_HwAcIo@uCi@yBSk@Oe@k@wBo@wCu@eEaB}IeCgNMa@o@gCw@cCc@o@UOKGIKK_@EcB{D_MoCsI_@iBmBmKUkAgB{JuAoHa@cDaAuNKmBg@_HS}Ao@oEiAaFaCuIaBoIqAoHcB{KiAoHeAcHuAoIaAcHg@_Du@}EoB}L]iBUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-11 18:54:56', '2021-12-11 18:59:10', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1402, 'KWD685526', 168, 123, 123, 1, 3647, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 13.24, 132.79, '', 'H8CV+379, Lusaka, Zambia', -15.43056370, 28.34391780, 'Pick n Pay, JCH2+8XC, Lusaka, Zambia', -15.37169940, 28.40239560, '2021-12-11 19:15:30', NULL, '2021-12-11 19:16:18', '2021-12-11 19:16:27', 1, 1, 0, 0, 'pwd}Aw|~kDuDvHwEq@kJmA{IkAwASoAGkEG{EMmAAuBVqC`@yBXsHjAaJpAoMbBiIrAkByPc@sC_@BkC\\iC^k@HqFr@MBDPfBvJtBdLBh@Gf@i@rBy@dDo@dDcQ_C_AMuACwABu@EoC]WE{F}@_H}@kFu@gB]gAc@cAe@cA[uCc@eO{BsKaBeFw@_IwAwGoAcBUi@CC?C?YM_AGc@KkAk@[IWHg@ROZWLW?OGOMISE[H_@FML{@CcA_@wBgB{J}@oFeD{QyC_QyAoGc@oAk@yB}AaIgAgGgDyQe@gB{@yCSk@Wa@[[KESUEOAg@EeAK_@iGqR_AaDWkAuBmLwBqL}AmIUyBc@_GSaDSeDi@{HYaCw@{E{@qDkBuG}AkHkBsKmFy]Km@oAwHaAcH{AsJIm@{BcNUu@IYGAUMMSC_@@YLUPOd@IVDJFLFPZ?d@VZLr@d@Ed@Dg@mBGm@Bg@LOzBcAJE', NULL, '2021-12-11 19:15:30', '2021-12-11 19:16:39', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1403, 'KWD455799', 168, 102, 102, 1, 7031, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 6.45, 64.07, '', 'H998+C94, Lusaka 10102, Zambia', -15.42997450, 28.36786160, 'Honeybed lodge, 24 Olive Road, Salama Park Lusaka ZM, Lusaka 10101, Zambia', -15.39749760, 28.38583280, '2021-12-11 19:24:37', NULL, '2021-12-11 19:25:10', '2021-12-11 19:25:16', 1, 1, 0, 0, 'ftd}AcrclDHm@BY@MsASaHgAcEw@yKwBqCi@yCUeKqBmKuBqAOO?gAP]?cBa@qGZ_Lr@y@oGG_@SaAQ{@q@_Co@aCY_AMi@u@wBi@cBu@uBw@uBO_@U]q@u@oB}Ak@e@c@e@m@w@S_@Ic@?w@LgAh@oC^}Bf@oCNgADe@@c@Ce@ESIWUi@Sm@e@yAe@yAa@sASk@IUMS]g@[g@mAkBgAiBuGcKcCyDmCyE{DoGsB_DiE{G{B}D{AV{Dd@{IdAeCX@BNnAq@Be@@@xC?zBAvHwClAo@VgAViH~AdC`MdBzI', NULL, '2021-12-11 19:24:37', '2021-12-11 19:28:23', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1404, 'KWD890214', 168, 0, 101, 1, 5673, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 4.00, 45.00, '', 'Main St, Lusaka, Zambia', -15.41225240, 28.37798370, 'Honeybed lodge, 24 Olive Road, Salama Park Lusaka ZM, Lusaka 10101, Zambia', -15.39749760, 28.38583280, '2021-12-11 19:43:02', NULL, NULL, NULL, 0, 0, 0, 0, 'fda}AwoelDiByAk@e@c@e@m@w@S_@Ic@?w@LgAh@oC^}Bf@oCNgADe@@c@Ce@ESIWUi@e@yAiAmDe@yAIUMS]g@aA{AmAoBa@q@uGcKcCyDmCyE{DoGsB_DiE{G{B}D{AV{Dd@{IdAeCX@BNnAq@Be@@@xC?zBAvHwClAo@VgAViH~AdC`MdBzI', NULL, '2021-12-11 19:43:02', '2021-12-11 19:43:22', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1405, 'KWD473931', 273, 101, 101, 1, 9985, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 4.00, 45.00, '', 'J92V+9MV, Lusaka, Zambia', -15.39897590, 28.39424610, 'Honeybed lodge, 24 Olive Road, Salama Park Lusaka ZM, Lusaka 10101, Zambia', -15.39749760, 28.38583280, '2021-12-11 19:47:07', NULL, NULL, NULL, 0, 0, 0, 0, 'pr~|AsxhlDYAEAEG?i@_AAoEDeEAKrG?fDApE?lE@xBNCxAjHj@tCdBzI', NULL, '2021-12-11 19:47:07', '2021-12-11 19:47:41', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1406, 'KWD190762', 168, 0, 123, 1, 2684, 0, 'CANCELLED', 'USER', 'thanks', 'CASH', 0, 9.11, 91.01, '', '1001, Block F State Life Phase 1 State Life, Lahore, Punjab, Pakistan', 31.44291740, 74.39834170, 'DHA Phase 6, DHA Phase 6, Lahore, Punjab, Pakistan', 31.47150490, 74.45842450, '2021-12-11 20:17:38', NULL, NULL, NULL, 0, 0, 0, 0, 'oe|~Dq|aeMJ^jBg@Hj@gBp@k@LNv@cCn@m@?kBWmASqBWuDa@c@CQ@UFaAx@c@T]Fs@CmC[oBYgCYcEg@\\wDReDFuC@{CCyBOsCSaC]qCsAqIsEiUaAcFIo@aBcImAkFe@aC{@qCwA_FwAaDSYgA_CaDgFyCkEsCiE_FuH}GuJ_FqHuDkFcBeCq@eAk@cAw@gBqAqC]y@_AcBk@qAKg@Cc@@[D[Vy@Vs@R{@Bk@Ak@YeB?]B]L_@\\]XQJMF_@I]KAIAYLK?wAnAeAt@aBtAs@b@aAr@g@\\}@j@}AbAy@n@[j@O\\EP_@b@ULUDi@CQIIMCO?QEi@QaAQi@OSGGM_@Kq@Ce@BqC@}DA}BCi@M}@[}@a@w@_@c@u@}@[m@i@iAUe@wAuC{EqHeFsHiBkCqC_E}AiCy@gAcCqDmC{DqF_I_GyIoDwFKOTQhAkAlBsBvT}UnCsCvMuN`@a@NBZF', NULL, '2021-12-11 20:17:38', '2021-12-11 20:18:59', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1407, 'KWD394411', 168, 0, 102, 1, 2579, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 9.11, 91.06, '', '1001, Block F State Life Phase 1 State Life, Lahore, Punjab, Pakistan', 31.44289180, 74.39840930, 'DHA Phase 6, DHA Phase 6, Lahore, Punjab, Pakistan', 31.47150490, 74.45842450, '2021-12-11 20:25:44', NULL, NULL, NULL, 0, 0, 0, 0, 'qe|~D{|aeMLh@jBg@Hj@gBp@k@LNv@cCn@m@?kBWmASqBWuDa@c@CQ@UFaAx@c@T]Fs@CmC[oBYgCYcEg@\\wDReDFuC@{CCyBOsCSaC]qCsAqIsEiUaAcFIo@aBcImAkFe@aC{@qCwA_FwAaDSYgA_CaDgFyCkEsCiE_FuH}GuJ_FqHuDkFcBeCq@eAk@cAw@gBqAqC]y@_AcBk@qAKg@Cc@@[D[Vy@Vs@R{@Bk@Ak@YeB?]B]L_@\\]XQJMF_@I]KAIAYLK?wAnAeAt@aBtAs@b@aAr@g@\\}@j@}AbAy@n@[j@O\\EP_@b@ULUDi@CQIIMCO?QEi@QaAQi@OSGGM_@Kq@Ce@BqC@}DA}BCi@M}@[}@a@w@_@c@u@}@[m@i@iAUe@wAuC{EqHeFsHiBkCqC_E}AiCy@gAcCqDmC{DqF_I_GyIoDwFKOTQhAkAlBsBvT}UnCsCvMuN`@a@NBZF', NULL, '2021-12-11 20:25:44', '2021-12-11 20:26:00', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1408, 'KWD382009', 168, 0, 102, 1, 8581, 0, 'CANCELLED', 'USER', 'bb', 'CASH', 0, 9.11, 91.06, '', '1001, Block F State Life Phase 1 State Life, Lahore, Punjab, Pakistan', 31.44288918, 74.39841195, 'DHA Phase 6, DHA Phase 6, Lahore, Punjab, Pakistan', 31.47150490, 74.45842450, '2021-12-11 20:27:24', NULL, NULL, NULL, 0, 0, 0, 0, 'qe|~D}|aeMLj@jBg@Hj@gBp@k@LNv@cCn@m@?kBWmASqBWuDa@c@CQ@UFaAx@c@T]Fs@CmC[oBYgCYcEg@\\wDReDFuC@{CCyBOsCSaC]qCsAqIsEiUaAcFIo@aBcImAkFe@aC{@qCwA_FwAaDSYgA_CaDgFyCkEsCiE_FuH}GuJ_FqHuDkFcBeCq@eAk@cAw@gBqAqC]y@_AcBk@qAKg@Cc@@[D[Vy@Vs@R{@Bk@Ak@YeB?]B]L_@\\]XQJMF_@I]KAIAYLK?wAnAeAt@aBtAs@b@aAr@g@\\}@j@}AbAy@n@[j@O\\EP_@b@ULUDi@CQIIMCO?QEi@QaAQi@OSGGM_@Kq@Ce@BqC@}DA}BCi@M}@[}@a@w@_@c@u@}@[m@i@iAUe@wAuC{EqHeFsHiBkCqC_E}AiCy@gAcCqDmC{DqF_I_GyIoDwFKOTQhAkAlBsBvT}UnCsCvMuN`@a@NBZF', NULL, '2021-12-11 20:27:24', '2021-12-11 20:27:30', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1409, 'KWD686642', 168, 0, 102, 1, 4321, 0, 'CANCELLED', 'USER', 'y', 'CASH', 0, 9.11, 91.00, '', '1001, Block F State Life Phase 1 State Life, Lahore, Punjab, Pakistan', 31.44290580, 74.39833730, 'DHA Phase 6, DHA Phase 6, Lahore, Punjab, Pakistan', 31.47150490, 74.45842450, '2021-12-11 20:54:01', NULL, NULL, NULL, 0, 0, 1, 0, 'me|~Do|aeMH\\jBg@Hj@gBp@k@LNv@cCn@m@?kBWmASqBWuDa@c@CQ@UFaAx@c@T]Fs@CmC[oBYgCYcEg@\\wDReDFuC@{CCyBOsCSaC]qCsAqIsEiUaAcFIo@aBcImAkFe@aC{@qCwA_FwAaDSYgA_CaDgFyCkEsCiE_FuH}GuJ_FqHuDkFcBeCq@eAk@cAw@gBqAqC]y@_AcBk@qAKg@Cc@@[D[Vy@Vs@R{@Bk@Ak@YeB?]B]L_@\\]XQJMF_@I]KAIAYLK?wAnAeAt@aBtAs@b@aAr@g@\\}@j@}AbAy@n@[j@O\\EP_@b@ULUDi@CQIIMCO?QEi@QaAQi@OSGGM_@Kq@Ce@BqC@}DA}BCi@M}@[}@a@w@_@c@u@}@[m@i@iAUe@wAuC{EqHeFsHiBkCqC_E}AiCy@gAcCqDmC{DqF_I_GyIoDwFKOTQhAkAlBsBvT}UnCsCvMuN`@a@NBZF', NULL, '2021-12-11 20:54:01', '2021-12-11 20:54:10', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1410, 'KWD506915', 168, 0, 102, 1, 5935, 0, 'CANCELLED', 'USER', 'v', 'CASH', 0, 5.80, 57.53, '', 'Unnamed Road, Lusaka, Zambia', -15.39807340, 28.38532380, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-11 20:55:20', NULL, NULL, NULL, 0, 0, 0, 0, 'jk~|Aw~flDr@jDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-11 20:55:20', '2021-12-11 20:55:58', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1411, 'KWD214024', 168, 0, 102, 1, 6205, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 9.14, 91.31, '', '6 کماہاں - لدھڑ روڈ، Block A State Life Phase 1 State Life, لاہور, ضلع لاہور, پنجاب، پاکستان', 31.44305820, 74.39862790, 'DHA Phase 6, DHA Phase 6, Lahore, Punjab, Pakistan', 31.47150490, 74.45842450, '2021-12-12 07:18:26', NULL, NULL, NULL, 0, 0, 0, 0, '_f|~Do~aeMVzA@@LC~Ac@Hj@gBp@k@LNv@}@TeAXSBiAMiCa@mFk@sAOc@?WPa@^g@Z]Le@BUAeCY{JoAqAOH}@Da@VcDNaEBeBAyDKcCQiCQeBaBsKwE}UgA{Fw@_EwAyGs@cDq@oCsB_Hi@uA_AoBGEy@gBgAgBgBwCwB}C{A}Bs@eAwFuIwDmFgBkCyEkH_DmEoDkFa@q@o@qAo@yA_BmDaB_DQk@Ea@AWFq@H_@n@kBJu@@g@Gq@QcA?u@H_@Ra@p@e@FOBOIc@OCK?MHKBE?STuB|AuBfB{CrBa@V{BvA]V[XMR[j@EVY`@QLUH]@QASIIGEOAe@O_AS}@MWOOSw@Io@BqB@cE?iCAk@Iw@SaAc@aAcBuBiDeHyBkDwGuJoBwCmDeFcCyDw@gAsAqBaDwEgFsHyGyJ{DgGlBkB|T_VnAwAlBqBdPeQj@J', NULL, '2021-12-12 07:18:26', '2021-12-12 07:19:01', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1412, 'KWD921263', 168, 0, 102, 1, 8038, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 9.13, 91.20, '', '6 کماہاں - لدھڑ روڈ، Block A State Life Phase 1 State Life, لاہور, ضلع لاہور, پنجاب، پاکستان', 31.44296030, 74.39848760, 'DHA Phase 6, DHA Phase 6, Lahore, Punjab, Pakistan', 31.47150490, 74.45842450, '2021-12-12 07:19:33', NULL, NULL, NULL, 0, 0, 0, 0, 'oe|~Ds}aeMEBJt@@D@@LC~Ac@Hj@gBp@k@LNv@}@TeAXSBiAMiCa@mFk@sAOc@?WPa@^g@Z]Le@BUAeCY{JoAqAOH}@Da@VcDNaEBeBAyDKcCQiCQeBaBsKwE}UgA{Fw@_EwAyGs@cDq@oCsB_Hi@uA_AoBGEy@gBgAgBgBwCwB}C{A}Bs@eAwFuIwDmFgBkCyEkH_DmEoDkFa@q@o@qAo@yA_BmDaB_DQk@Ea@AWFq@H_@n@kBJu@@g@Gq@QcA?u@H_@Ra@p@e@FOBOIc@OCK?MHKBE?STuB|AuBfB{CrBa@V{BvA]V[XMR[j@EVY`@QLUH]@QASIIGEOAe@O_AS}@MWOOSw@Io@BqB@cE?iCAk@Iw@SaAc@aAcBuBiDeHyBkDwGuJoBwCmDeFcCyDw@gAsAqBaDwEgFsHyGyJ{DgGlBkB|T_VnAwAlBqBdPeQj@J', NULL, '2021-12-12 07:19:33', '2021-12-12 07:20:44', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1413, 'KWD961859', 168, 0, 102, 1, 4325, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 9.14, 91.30, '', 'C9VX+39X, Block F State Life Phase 1 State Life, Lahore, Punjab, Pakistan', 31.44284240, 74.39844260, 'DHA Phase 6, DHA Phase 6, Lahore, Punjab, Pakistan', 31.47150490, 74.45842450, '2021-12-12 07:29:22', NULL, NULL, NULL, 0, 0, 0, 0, '}d|~Dy}aeMWHJt@@D@@LC~Ac@Hj@gBp@k@LNv@}@TeAXSBiAMiCa@mFk@sAOc@?WPa@^g@Z]Le@BUAeCY{JoAqAOH}@Da@VcDNaEBeBAyDKcCQiCQeBaBsKwE}UgA{Fw@_EwAyGs@cDq@oCsB_Hi@uA_AoBGEy@gBgAgBgBwCwB}C{A}Bs@eAwFuIwDmFgBkCyEkH_DmEoDkFa@q@o@qAo@yA_BmDaB_DQk@Ea@AWFq@H_@n@kBJu@@g@Gq@QcA?u@H_@Ra@p@e@FOBOIc@OCK?MHKBE?STuB|AuBfB{CrBa@V{BvA]V[XMR[j@EVY`@QLUH]@QASIIGEOAe@O_AS}@MWOOSw@Io@BqB@cE?iCAk@Iw@SaAc@aAcBuBiDeHyBkDwGuJoBwCmDeFcCyDw@gAsAqBaDwEgFsHyGyJ{DgGlBkB|T_VnAwAlBqBdPeQj@J', NULL, '2021-12-12 07:29:22', '2021-12-12 07:30:35', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1414, 'KWD471885', 168, 0, 102, 1, 1703, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 9.12, 91.14, '', '1001, Block F State Life Phase 1 State Life, Lahore, Punjab, Pakistan', 31.44296200, 74.39846960, 'DHA Phase 6, DHA Phase 6, Lahore, Punjab, Pakistan', 31.47150490, 74.45842450, '2021-12-12 07:47:33', NULL, NULL, NULL, 0, 0, 0, 0, 'ue|~Dk}aeMPx@jBg@Hj@gBp@k@LNv@cCn@m@?kBWmASqBWuDa@c@CQ@UFaAx@c@T]Fs@CmC[oBYgCYcEg@\\wDReDFuC@{CCyBOsCSaC]qCsAqIsEiUaAcFIo@aBcImAkFe@aC{@qCwA_FwAaDSYgA_CaDgFyCkEsCiE_FuH}GuJ_FqHuDkFcBeCq@eAk@cAw@gBqAqC]y@_AcBk@qAKg@Cc@@[D[Vy@Vs@R{@Bk@Ak@YeB?]B]L_@\\]XQJMF_@I]KAIAYLK?wAnAeAt@aBtAs@b@aAr@g@\\}@j@}AbAy@n@[j@O\\EP_@b@ULUDi@CQIIMCO?QEi@QaAQi@OSGGM_@Kq@Ce@BqC@}DA}BCi@M}@[}@a@w@_@c@u@}@[m@i@iAUe@wAuC{EqHeFsHiBkCqC_E}AiCy@gAcCqDmC{DqF_I_GyIoDwFKOTQhAkAlBsBvT}UnCsCvMuN`@a@NBZF', NULL, '2021-12-12 07:47:33', '2021-12-12 07:48:46', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1415, 'KWD927076', 284, 0, 101, 1, 5856, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.79, 57.48, '', 'Unnamed Road, Lusaka, Zambia', -15.39808580, 28.38527840, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-12 07:53:36', NULL, NULL, NULL, 0, 0, 0, 0, 'lk~|Ao~flDp@bDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-12 07:53:36', '2021-12-12 07:53:47', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1416, 'KWD714960', 286, 0, 101, 1, 3331, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.47, 54.18, '', 'Unnamed Road, Lusaka, Zambia', -15.39816780, 28.38532420, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-12 12:25:25', NULL, NULL, NULL, 0, 0, 0, 0, 'bm~|AkaglDkAPe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-12 12:25:25', '2021-12-12 12:25:36', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1417, 'KWD911541', 286, 0, 123, 1, 7028, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.79, 57.50, '', 'Unnamed Road, Lusaka, Zambia', -15.39806450, 28.38528520, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-12 12:32:35', NULL, NULL, NULL, 0, 0, 0, 0, 'lk~|Aq~flDp@dDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-12 12:32:35', '2021-12-12 12:33:41', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1418, 'KWD992762', 286, 0, 123, 1, 8008, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.80, 57.56, '', 'Unnamed Road, Lusaka, Zambia', -15.39808090, 28.38534860, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-12 12:34:54', NULL, NULL, NULL, 0, 0, 0, 0, 'hk~|A{~flDt@nDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-12 12:34:54', '2021-12-12 12:35:49', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1419, 'KWD340057', 286, 0, 123, 1, 9562, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.45, 54.05, '', 'Unnamed Road, Lusaka, Zambia', -15.39804840, 28.38539040, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-12 12:38:50', NULL, NULL, NULL, 0, 0, 0, 0, 'nl~|AeaglDw@Je@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-12 12:38:50', '2021-12-12 12:39:07', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1420, 'KWD329694', 286, 0, 123, 1, 2337, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.45, 54.07, '', 'Unnamed Road, Lusaka, Zambia', -15.39804940, 28.38542650, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-12 12:42:24', NULL, NULL, NULL, 0, 0, 0, 0, 'pl~|AgaglDy@Le@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-12 12:42:24', '2021-12-12 12:42:32', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1421, 'KWD180471', 287, 130, 130, 1, 3913, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 5.47, 54.18, '', 'Unnamed Road, Lusaka, Zambia', -15.39816530, 28.38532440, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-12 12:58:25', NULL, '2021-12-12 12:59:30', '2021-12-12 12:59:54', 1, 1, 0, 0, 'bm~|AkaglDkAPe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-12 12:58:25', '2021-12-12 13:01:49', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1422, 'KWD327969', 288, 131, 131, 1, 5186, 0, 'CANCELLED', 'PROVIDER', '', 'CASH', 0, 5.47, 54.18, '', 'Unnamed Road, Lusaka, Zambia', -15.39816840, 28.38532230, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-12 13:27:15', NULL, NULL, NULL, 0, 0, 0, 0, 'bm~|AkaglDkAPe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-12 13:25:56', '2021-12-12 13:28:26', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1423, 'KWD225741', 288, 0, 132, 1, 3285, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.47, 54.18, '', 'Unnamed Road, Lusaka, Zambia', -15.39816840, 28.38532230, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-12 13:42:34', NULL, NULL, NULL, 0, 0, 0, 0, 'bm~|AkaglDkAPe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-12 13:42:34', '2021-12-12 13:42:58', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1424, 'KWD244011', 288, 0, 123, 1, 1088, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.80, 57.58, '', 'Unnamed Road, Lusaka, Zambia', -15.39786970, 28.38530250, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-12 14:02:36', NULL, NULL, NULL, 0, 0, 0, 0, 'hk~|A__glDt@rDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-12 14:02:36', '2021-12-12 14:03:22', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1425, 'KWD739839', 288, 0, 132, 1, 7312, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 11.85, 118.75, '', 'Unnamed Road, Lusaka, Zambia', -15.39805419, 28.38530157, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-12 14:03:47', NULL, NULL, NULL, 0, 0, 0, 0, 'lk~|Au~flDp@hDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zE@P\\hELjAJf@x@lE\\lAh@zAnApCx@xAb@x@hBfCnGrH|B`CT\\|HnJjFfGhMrO~AnBOLsCkDYBSF]X[RG?KGQ_@CGUPCB?DDJxB`CvAdB', NULL, '2021-12-12 14:03:47', '2021-12-12 14:04:05', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1426, 'KWD909773', 288, 0, 132, 1, 3642, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 11.85, 118.77, '', 'Unnamed Road, Lusaka, Zambia', -15.39807070, 28.38532720, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-12 14:05:37', NULL, NULL, NULL, 0, 0, 0, 0, 'jk~|Ay~flDr@lDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zE@P\\hELjAJf@x@lE\\lAh@zAnApCx@xAb@x@hBfCnGrH|B`CT\\|HnJjFfGhMrO~AnBOLsCkDYBSF]X[RG?KGQ_@CGUPCB?DDJxB`CvAdB', NULL, '2021-12-12 14:05:37', '2021-12-12 14:06:09', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1427, 'KWD653394', 288, 0, 123, 1, 8409, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.80, 57.59, '', 'Unnamed Road, Lusaka, Zambia', -15.39803520, 28.38536100, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-12 14:09:11', NULL, NULL, NULL, 0, 0, 0, 0, 'hk~|Aa_glDt@tDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-12 14:09:11', '2021-12-12 14:09:16', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1428, 'KWD260695', 288, 0, 123, 1, 9170, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 11.85, 118.71, '', 'Unnamed Road, Lusaka, Zambia', -15.39807946, 28.38527428, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-12 14:09:39', NULL, NULL, NULL, 0, 0, 0, 0, 'lk~|Ao~flDp@bDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zE@P\\hELjAJf@x@lE\\lAh@zAnApCx@xAb@x@hBfCnGrH|B`CT\\|HnJjFfGhMrO~AnBOLsCkDYBSF]X[RG?KGQ_@CGUPCB?DDJxB`CvAdB', NULL, '2021-12-12 14:09:39', '2021-12-12 14:09:45', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1429, 'KWD655253', 288, 0, 132, 1, 4350, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.80, 57.52, '', 'Unnamed Road, Lusaka, Zambia', -15.39806120, 28.38530310, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-12 14:11:36', NULL, NULL, NULL, 0, 0, 0, 0, 'lk~|Au~flDp@hDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-12 14:11:36', '2021-12-12 14:11:55', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1430, 'KWD821156', 288, 0, 123, 1, 1698, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 20.12, 202.30, '', 'Unnamed Road, Lusaka, Zambia', -15.39803150, 28.38538380, 'Makeni Mall, Makeni, T2, Lusaka, Zambia', -15.45381920, 28.26621590, '2021-12-12 14:13:26', NULL, NULL, NULL, 0, 0, 0, 0, 'jl~|AeaglDs@Je@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@{CdPEJWR[B[?aA@I@KHGHE^w@`CmEzMkGhRwF|PyAjEK\\W\\_@RUPBHfB`KbBtI~@bE~@~CtGpRLXJJf@f@HJN^B`@DbA|@xCr@jC|@jE|DtT|B|M|B`LpCjOxFn\\d@hCNf@T~AZzADt@Fl@NZDBJJJPBXARAFEFBJHf@Jb@\\vAX|AbArFPbAXnCPpDCxDWzK[nPMvGAjBJrC~@vJz@bJb@~EVlDh@zFZrE^zDR|AP~@p@|Cb@pAh@tApAnCd@z@pArBbBvBrFnGtB|BRVpNzP~EbGzJtLX\\d@h@PT|AlB`CvCtEpFnA|AvAzAv@fArBfCjBzBzAhBzBhDV`@vAdD|@rC^bBd@rCj@zGn@tH`AjMp@bIpBxUhAzMv@`GTvBPfCPzBh@hGHb@F@LFDDv@S`Dc@lGi@xJ_AfSgBlSmB`Q_BlK}@f@KTIBITWNGTAPHNLFJ@DJAhFe@fBQr@Cv@AhBBpAPlBb@v@TdAh@|Ax@~@v@|@`Ap@bA|@bBjBpEl@rA`@j@f@r@|@~@t@n@r@f@pB`A|YzLxJ`E|ErBbCbAbEnBrElBtMtFrLbFvNhGnCpAtCnA|E|B`Ab@Wb@CTEd@@\\CPIFs@DMDAFDp@@b@', NULL, '2021-12-12 14:13:26', '2021-12-12 14:13:40', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1431, 'KWD526406', 288, 0, 123, 1, 6798, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 10.06, 100.64, '', 'Unnamed Road, Lusaka, Zambia', -15.39804620, 28.38540980, 'St. Mary\'s Secondary High School, D152, Leopards Hill Rd, Lusaka, Zambia', -15.43236630, 28.34170150, '
2021-12-12 14:15:49
', NULL, NULL, NULL, 0, 0, 0, 0, 'nl~|AgaglDnC]a@mCjCc@YgBa@iC_@}BaAaG_@cCn@WvCmA@wH?{BAyCd@Ap@COoAACdCYzIeAzDe@zAWzB|D|HzLzDnGlCxEzGnKbCtDd@v@d@v@hAfBx@nALRFTRl@b@rAjArDPj@Tj@J^Bd@Ab@MhAOfAUfAQfAa@|Bg@nCEb@A`@@THb@R^VZf@p@xAlAlB|AV\\T\\^`At@tBt@tBpAxDRx@X~@n@`Cp@~Bb@|BF^t@~F~Ks@pG[d@L|@RN@tASh@Bv@JlKtBdKpBxCTpCh@xKvBbEv@`HfArARALCXEXIt@WrBUjBc@hEmArJq@zF{@~G_@vCMjAGd@c@fEi@`EQxBi@rEeChRG`@M`A[fCw@bGu@jGM`A{ChVeAfIbBRtFv@jJlAvEp@bAj@~G|DPFFe@Tk@X_@VQp@a@LDTTPb@', NULL, '
2021-12-12 14:15:49
', '2021-12-12 14:16:06
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1432, 'KWD650244', 288, 0, 132, 1, 6479, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 8.60, 85.88, '', 'Unnamed Road, Lusaka, Zambia', -15.39808320, 28.38537370, 'Munali Mall, 12th St, Lusaka, Zambia', -15.37214580, 28.34515770, '
2021-12-12 14:23:49
', NULL, NULL, NULL, 0, 0, 0, 0, 'tl~|AgaglD}@Le@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@{CdPEJWR[B[?aA@I@KHGHE^w@`CmEzMkGhRwF|PyAjEK\\W\\_@RUPBHfB`KbBtI~@bE~@~CtGpRLXJJf@f@HJN^B`@DbA|@xCr@jC|@jE|DtT|B|M|B`LpCjOxFn
\\d@hCNf@T~AZzADt@Fl@NZDBJJJPBXARKTUPWBQGGCCAgAXKHI@S@gAMkIkAoOwBgKoAqKuAw@KmBWaFq@_Fo@u@KaEk@YlCq@I', NULL, '
2021-12-12 14:23:49
', '2021-12-12 14:24:32
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1433, 'KWD874598', 288, 0, 132, 1, 1974, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.80, 57.56, '', 'Unnamed Road, Lusaka, Zambia', -15.39802940, 28.38533900, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '
2021-12-12 15:03:52
', NULL, NULL, NULL, 0, 0, 0, 0, 'hk~|A}~flDt@pDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-12 15:03:52', '2021-12-12 15:04:13', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1434, 'KWD161848', 288, 0, 123, 1, 5987, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.80, 57.58, '', 'Unnamed Road, Lusaka, Zambia', -15.39806830, 28.38536190, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-12 15:05:12', NULL, NULL, NULL, 0, 0, 0, 0, 'hk~|A__glDt@rDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F
\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '
2021-12-12 15:05:12
', '2021-12-12 15:05:24
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1435, 'KWD315269', 289, 0, 132, 1, 1294, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.47, 54.17, '', 'Unnamed Road, Lusaka, Zambia', -15.39816540, 28.38531880, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '
2021-12-12 16:08:10
', NULL, NULL, NULL, 0, 0, 0, 0, 'bm~|AkaglDkAPe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-12 16:08:10', '2021-12-12 16:08:18', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1436, 'KWD629993', 289, 123, 123, 1, 1882, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 5.47, 54.17, '', 'Unnamed Road, Lusaka, Zambia', -15.39816540, 28.38531880, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-12 16:09:02', NULL, '2021-12-12 16:09:40', '2021-12-12 16:09:44', 1, 1, 0, 0, 'bm~|AkaglDkAPe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '
2021-12-12 16:09:02
', '2021-12-12 16:11:42
', 'NO', '
0', 0.00000000, 0.00000000, 0.00000000),
(1437, 'KWD544292', 289, 123, 123, 1, 7287, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 22.16, 222.93, '', 'Unnamed Road, Lusaka, Zambia', -15.39812820, 28.38539310, 'Bonanza Golf Course, Ngwerere Rd, Lusaka, Zambia', -15.26075570, 28.44009430, '
2021-12-12 16:14:33
', NULL, '2021-12-12 16:15:22
', '2021-12-12 16:15:38
', 1, 1, 0, 0, '~l~|AiaglDgANe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@SqAc@sA]cB]s@YmG_D{J{EiFiCcD}A{JyE{J{EmUcL_[oO_OoH}GeDaGwCoBaAcCcAkCq@_CYqCOsCMqH]aPs@mDOwEQmP{@}b@iBkXkAm@CkC_@uBk@kBu@kAu@}AgAeBcBmAgBeBcE_@oAi@qEGaBBmAbBge@zC{w@@OQAUIaFkCuDqBuDqBqQsJiP_J_TqKaRcJkNsGaFgCqBeAqD{BkIaFc]kSc]mSSCMBeVjX}LdNu[h^aRtSgP`Re@h@s@dA_@r@q@vAaEnKkArDGl@E~BA`BApGQOyCq@cBY_Ca@uKoD{Ag@c@U{Ak@k@OSWKgAYg@]aAOo@?]J_A@oAKa@YMyAUsAYc@EeAMm@QGQs@y@g@y@iAeB', NULL, '2021-12-12 16:14:33', '2021-12-12 16:16:14', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1438, 'KWD741233', 289, 0, 101, 1, 9048, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 22.49, 226.26, '', 'Unnamed Road, Lusaka, Zambia', -15.39810580, 28.38527470, 'Bonanza Golf Course, Ngwerere Rd, Lusaka, Zambia', -15.26075570, 28.44009430, '2021-12-12 16:24:53', NULL, NULL, NULL, 0, 0, 0, 0, 'nk~|Am~flDn@`DeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@kCy@iASwAc@eFeCoKiFwE}BcD}A{JyE{J}EcI{D_LsF_FaC_GwC_LuFmX_NaGuCoBaAcCeAcA[eAWgAQw@IqCQsCMqH]gOo@mDScEOeOs@_c@mBeU_AyFWkC_@WG}Ac@gAc@c@Q{@i@QM{AeAu@u@o@m@Yc@s@cA{@iBs@qBUw@Mw@[yCG{A@oA`AqX`Dyy@^kJQAUI}F}CqDoBaNkHgX}N{QiJgPeIsVmLyEeCkHqE}_@eUe\\wRuCgBSCMBcS~TgOvPoNzOa^|`@_KbLiGbHu@hAw@|AYl@oAbDqBjFkArDKlBErLQOi@MkCi@mDm@gFaBcH}B{Aq@oA_@SWCc@Kg@Uc@Qg@[iA?]Fe@FmAA[Ka@YMy@KsBc@iBSm@QGQaAiAuA{BMS', NULL, '
2021-12-12 16:24:43
', '2021-12-12 16:25:04
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1439, 'KWD644157', 289, 0, 101, 1, 9832, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 22.16, 222.98, '', 'Unnamed Road, Lusaka, Zambia', -15.39816950, 28.38542570, 'Bonanza Golf Course, Ngwerere Rd, Lusaka, Zambia', -15.26075570, 28.44009430, '
2021-12-12 16:34:16
', NULL, NULL, NULL, 0, 0, 0, 0, 'fm~|AkaglDoAPe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@SqAc@sA]cB]s@YmG_D{J{EiFiCcD}A{JyE{J{EmUcL_[oO_OoH}GeDaGwCoBaAcCcAkCq@_CYqCOsCMqH]aPs@mDOwEQmP{@}b@iBkXkAm@CkC_@uBk@kBu@kAu@}AgAeBcBmAgBeBcE_@oAi@qEGaBBmAbBge@zC{w@@OQAUIaFkCuDqBuDqBqQsJiP_J_TqKaRcJkNsGaFgCqBeAqD{BkIaFc]kSc]mSSCMBeVjX}LdNu[h^aRtSgP`Re@h@s@dA_@r@q@vAaEnKkArDGl@E~BA`BApGQOyCq@cBY_Ca@uKoD{Ag@c@U{Ak@k@OSWKgAYg@]aAOo@?]J_A@oAKa@YMyAUsAYc@EeAMm@QGQs@y@g@y@iAeB', NULL, '2021-12-12 16:34:16', '2021-12-12 16:35:09', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1440, 'KWD161971', 289, 0, 102, 1, 8729, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.45, 54.05, '', 'Unnamed Road, Lusaka, Zambia', -15.39805220, 28.38537700, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-12 16:35:51', NULL, NULL, NULL, 0, 0, 0, 0, 'nl~|AeaglDw@Je@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '
2021-12-12 16:35:51
', '2021-12-12 16:36:03
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1441, 'KWD729588', 289, 0, 101, 1, 1917, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 12.79, 128.25, '', 'Unnamed Road, Lusaka, Zambia', -15.39803310, 28.38532880, 'Golden Peacock Hotel, Kasangula Rd, Lusaka, Zambia', -15.37498100, 28.30215450, '
2021-12-12 16:39:03
', NULL, NULL, NULL, 0, 0, 0, 0, 'jk~|A{~flDr@nDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP
\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zEBD^tCj@rE|@bEl@rBZt@Xd@F@RFNLJPD`@I
\\QNQF]CICe@H_@DyIrGoBvBU
\\CAUQg@Ua@Mi@I}@G_A@cB^iBp@gBr@k@Nk@Jy@AiAKsDe@aBtDiA~CcA`C}AfE{G~PkA`DOVULq@A_DMWPeFvMtB`CX`@BNAVKZwFvN[v@', NULL, '
2021-12-12 16:39:03
', '2021-12-12 16:39:29
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1442, 'KWD283824', 289, 0, 101, 1, 3057, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.46, 54.08, '', 'Unnamed Road, Lusaka, Zambia', -15.39806670, 28.38538900, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '
2021-12-12 16:42:55
', NULL, NULL, NULL, 0, 0, 0, 0, 'rl~|AgaglD{@Le@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-12 16:42:55', '2021-12-12 16:43:11', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1443, 'KWD826939', 288, 0, 101, 1, 9234, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.47, 54.18, '', 'Unnamed Road, Lusaka, Zambia', -15.39816720, 28.38532460, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-12 17:18:04', NULL, NULL, NULL, 0, 0, 0, 0, 'bm~|AkaglDkAPe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '
2021-12-12 17:17:56
', '2021-12-12 17:18:32
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1444, 'KWD231760', 289, 0, 101, 1, 2859, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.46, 54.17, '', 'Unnamed Road, Lusaka, Zambia', -15.39814340, 28.38540600, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '
2021-12-12 17:27:18
', NULL, NULL, NULL, 0, 0, 0, 0, '`m~|AkaglDiAPe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '
2021-12-12 17:27:18
', '2021-12-12 17:28:20
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1445, 'KWD665811', 289, 0, 97, 1, 2127, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.50, 54.51, '', 'Unnamed Road, Lusaka, Zambia', -15.39845260, 28.38544280, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '
2021-12-12 17:40:50
', NULL, NULL, NULL, 0, 0, 0, 0, '~n~|AwaglDgC
\\e@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-12 17:38:14', '2021-12-12 17:41:49', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1446, 'KWD758328', 289, 0, 101, 1, 7357, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 11.85, 118.69, '', 'Unnamed Road, Lusaka, Zambia', -15.39819830, 28.38528640, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-12 18:01:38', NULL, NULL, NULL, 0, 0, 0, 0, 'nk~|Ai~flDn@|CeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb
\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H
\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zE@P
\\hELjAJf@x@lE
\\lAh@zAnApCx@xAb@x@hBfCnGrH|B`CT\\|HnJjFfGhMrO~AnBOLsCkDYBSF]X[RG?KGQ_@CGUPCB?DDJxB`CvAdB', NULL, '
2021-12-12 18:01:29
', '2021-12-12 18:01:55
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1447, 'KWD358597', 289, 0, 101, 1, 2821, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.79, 57.46, '', 'Unnamed Road, Lusaka, Zambia', -15.39819830, 28.38528635, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '
2021-12-12 18:02:18
', NULL, NULL, NULL, 0, 0, 0, 0, 'nk~|Ai~flDn@|CeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-12 18:02:18', '2021-12-12 18:02:33', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1448, 'KWD100168', 289, 0, 134, 1, 1446, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.80, 57.56, '', 'Unnamed Road, Lusaka, Zambia', -15.39809970, 28.38535870, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-12 18:13:07', NULL, NULL, NULL, 0, 0, 0, 0, 'hk~|A}~flDt@pDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F
\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '
2021-12-12 18:13:07
', '2021-12-12 18:14:16
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1449, 'KWD874649', 170, 0, 97, 1, 4209, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 15.71, 157.75, '', 'Unnamed Road, Lusaka, Zambia', -15.39812190, 28.38537580, 'Luburma Market, Luburma Market, Lusaka, Zambia', -15.42528810, 28.28737760, '
2021-12-12 18:18:33
', NULL, NULL, NULL, 0, 0, 0, 0, '|l~|AiaglDeANe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@{CdPEJWR[B[?aA@I@KHGHE^w@`CmEzMkGhRwF|PyAjEK\\W\\_@RUPBHfB`KbBtI~@bE~@~CtGpRLXJJf@f@HJN^B`@DbA|@xCr@jC|@jE|DtT|B|M|B`LpCjOxFn
\\d@hCNf@T~AZzADt@Fl@NZDBJJJPBXARAFEFBJHf@Jb@
\\vAX|AbArFPbAXnCPpDCxDWzK[nPMvGAjBJrC~@vJz@bJb@~EVlDh@zFZrE^zDR|AP~@p@|Cb@pAh@tApAnCd@z@pArBbBvBrFnGtB|BRVpNzP~EbGzJtLX
\\d@h@PT|AlB`CvCdDsC`Aw@n@_@|@c@dAe@jAa@~@UzAYnBWbBIr@AtBBbBNdANjB^pBl@|Ar@`EpBdG|CpGhDnEjCrBlAh@VTBX@TI^CXFJFBB`CMjLy@hMgADG^e@VCVBTPP
\\@b@KPCTEx@hAjFnA~FpDvPvDdR
\\rAt@pDfG|Zx@pEN~@T|B`E[', NULL, '2021-12-12 18:17:21', '2021-12-12 18:19:45', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1450, 'KWD401716', 291, 135, 135, 1, 5460, 0, 'CANCELLED', 'PROVIDER', '', 'CASH', 0, 5.46, 54.11, '', 'Unnamed Road, Lusaka, Zambia', -15.39808940, 28.38540090, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-12 18:30:41', NULL, NULL, NULL, 0, 0, 0, 0, 'vl~|AgaglD_ALe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '
2021-12-12 18:30:41
', '2021-12-12 18:31:16
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1451, 'KWD212744', 289, 0, 134, 1, 9088, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 15.73, 157.93, '', 'Unnamed Road, Lusaka, Zambia', -15.39803470, 28.38531530, 'Town Centre Market, 117 Chiparamba Rd, Lusaka, Zambia', -15.41643250, 28.27933890, '
2021-12-12 18:38:12
', NULL, NULL, NULL, 0, 0, 0, 0, 'jk~|Ay~flDr@lDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP
\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zE@P\\hELjAJf@x@lE\\lAh@zAnApCx@xAb@x@hBfCnGrH|B`CT
\\|HnJjFfGhMrOtBhCd@h@tEtFj@v@zDtEtDfEzC|DzAfBfBtB`ArA`BhCd@`AbAlCf@~AV|@b@bC\\nCF|@r@nIbA~LZhEXvChAlNp@pH`ApLXlCZ~BXtBTfDPtBf@pGJr@HPLFNLF
\\ARAHCBHDl@n@hC|BpBhBtApAXZp@hAv@k@zAS~Hq@|RiB', NULL, '
2021-12-12 18:38:12
', '2021-12-12 18:38:26
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1452, 'KWD872100', 289, 0, 134, 1, 3697, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.80, 57.55, '', 'Unnamed Road, Lusaka, Zambia', -15.39806539, 28.38533672, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '
2021-12-12 18:39:35
', NULL, NULL, NULL, 0, 0, 0, 0, 'jk~|A{~flDr@nDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-12 18:39:26', '2021-12-12 18:40:19', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1453, 'KWD517185', 291, 0, 135, 1, 5803, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.45, 54.04, '', 'Unnamed Road, Lusaka, Zambia', -15.39803560, 28.38540370, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-12 18:41:22', NULL, NULL, NULL, 0, 0, 0, 0, 'll~|AeaglDu@Je@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '
2021-12-12 18:41:22
', '2021-12-12 18:41:28
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1454, 'KWD600410', 291, 0, 134, 1, 2437, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.45, 54.04, '', 'Unnamed Road, Lusaka, Zambia', -15.39803690, 28.38540130, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '
2021-12-12 18:45:11
', NULL, NULL, NULL, 0, 0, 0, 0, 'll~|AeaglDu@Je@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-12 18:45:11', '2021-12-12 18:45:24', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1455, 'KWD640117', 291, 0, 134, 1, 7133, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.46, 54.08, '', 'Unnamed Road, Lusaka, Zambia', -15.39805161, 28.38545128, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-12 18:46:04', NULL, NULL, NULL, 0, 0, 0, 0, 'pl~|AgaglDy@Le@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '
2021-12-12 18:45:54
', '2021-12-12 18:46:27
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1456, 'KWD390997', 291, 0, 134, 1, 3176, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.46, 54.08, '', 'Unnamed Road, Lusaka, Zambia', -15.39804996, 28.38545033, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '
2021-12-12 18:46:54
', NULL, NULL, NULL, 0, 0, 0, 0, 'pl~|AgaglDy@Le@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-12 18:46:54', '2021-12-12 18:47:11', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000);
INSERT INTO `user_requests` (`id`, `booking_id`, `user_id`, `provider_id`, `current_provider_id`, `service_type_id`, `otp`, `returntrip`, `status`, `cancelled_by`, `cancel_reason`, `payment_mode`, `paid`, `distance`, `amount`, `specialNote`, `s_address`, `s_latitude`, `s_longitude`, `d_address`, `d_latitude`, `d_longitude`, `assigned_at`, `schedule_at`, `started_at`, `finished_at`, `user_rated`, `provider_rated`, `use_wallet`, `surge`, `route_key`, `deleted_at`, `created_at`, `updated_at`, `is_track`, `travel_time`, `track_distance`, `track_latitude`, `track_longitude`) VALUES
(1457, 'KWD273512', 289, 0, 134, 1, 7761, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.80, 57.56, '', 'Unnamed Road, Lusaka, Zambia', -15.39805880, 28.38534430, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-12 18:47:40', NULL, NULL, NULL, 0, 0, 0, 0, 'hk~|A}~flDt@pDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F
\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '
2021-12-12 18:47:40
', '2021-12-12 18:48:43
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1458, 'KWD978948', 289, 0, 134, 1, 8151, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 9.44, 94.33, '', 'Unnamed Road, Lusaka, Zambia', -15.39804010, 28.38532240, 'Wayaya All Events, H8FV+HF7, Lusaka, Zambia', -15.42608620, 28.34367950, '
2021-12-12 18:55:08
', NULL, NULL, NULL, 0, 0, 0, 0, 'jk~|Ay~flDaCuLyBd@c@{CmAsIjAWrDy@lEaAfEeB@cL?}AAkA`@At@CQsA|SeCzAW?FzE|HpB|CnElHxBjDpDfGlFlInBzCd@x@f@v@fAdBx@nATh@Pl@b@rAjArDRj@Rj@BFFb@@d@Eb@MhAQfAg@nCa@|Be@nCCv@Fb@J`@l@x@b@j@`BnAv@n@r@r@VZP^^`At@rBt@xBz@bCXdAJ^V~@p@`Cl@zBd@`CDZt@zFtEYpLs@v@?b@Px@NL?vASv@FdUnEnB^xCTrFdAnNnCrDj@lEr@CXIt@Ir@WtBUhBc@jEkAhJs@zF{@~G]vCOjAa@vDKnAg@tD_@pD[pCeChRG`@M`A[fCu@bGw@jG[jCqE~]nEj@', NULL, '
2021-12-12 18:55:08
', '2021-12-12 18:55:57
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1459, 'KWD181819', 290, 0, 130, 1, 9720, 0, 'CANCELLED', 'USER', 'g', 'CASH', 0, 410.37, 4147.78, '', '
1001, Block F State Life Phase 1 State Life, Lahore, Punjab, Pakistan', 31.44289820, 74.39835610, 'Phase 7, Phase 7 Bahria Town, Rawalpindi, Islamabad, Islamabad Capital Territory, Pakistan', 33.52555030, 73.11283130, '
2021-12-12 19:17:46
', NULL, NULL, NULL, 0, 0, 0, 0, 'oe|~Ds|aeMaVlBeIv@gDlT`BlO{@Wah@uJq@cD|Ws@pE{s@u\\cyAix@koAa[{Vk`BnLue@h@{d@r^wXtNgyA`@o_BqBydAgNos@mZwe@yRsj@mAe}@s@a`Au@uj@hG_`Bls@wn@jl@~Fpz@zZd`@a]jRcx@vg@oc@ts@iZ~gBaDtn@gSrm@osBr|BitA~f@ivAdGmh@Ts`AlWwJ`iBzJvdDbg@baCxq@v|Drk@nuDfIhIb@eK}^xVuYnjAurAhrCm_B|aCyr@zfAm`@jlAep@baF_\\trBqXxeEqHfaB_Y`kDisAp`EcvBdiGuwAttGaxCf}Kch@~qCoy@f}Bku@`pCmjAfvB}rAhiHiuCnuJ_bApqE{b@j`B{VxnCPd|Hi]poQiGhsE_ExbCib@p|CsInkF{HbuBgc@~iLk^x}C}Y~}Agj@hhAiw@zpAy~Al}@yyAnQs`Bbo@esFptBsiG|i@c}Erv@k{AtKs`Bdv@}vDztAyzApPmrArBmgAhR_mB?_cEj@ynBrHkvAhSciCfgAahBbdAkoBvaBe}A`j@{mFdmDy`Af~AykAnsCchCdeFs|AlnBgpAdyAaiAty@itHfbCcnGhfCq|C~~@e{@v^{f@hj@_}@|pAm[b_AlKrKyPxKcH`[kUgNw_@_]u_@nJeSkSiYo^sYwNgT_A|BcHsDmGuOzF_ZiX_VpYih@r_@miBxRgtAtJ_gCnb@em@bWe]nE_NvQoJbeAkTtQqh@bKaoAno@gR~Y]ni@|JhqBuPxgAs]lf@mb@rQ_aAmPwdApDoeAdYupBtZwoCkA__BrFmr@xE}k@oNkdA}lAmxAarBy^OiiArk@gqAjf@qlArUuf@|Ven@js@si@x]ct@lTsuBt]szEve@c|Dzs@{mBnO}h@e
\\e`AjAiq@fUm_@nIwZsQgqAakCg[gTa_C_n@wuAcVuqAwx@{~@ikBeSep@sa@ob@wmAqcCajAkwBw~AqqBc_CwrA}zAeSacA{Ja|@am@kdC}gC_qAiZstBaXgmBuBkiAao@yl@}NssApKce@xFga@mSio@qh@eqCwFwg@_Hkw@qt@y}Bc_DkdCmrCkZuSyx@wHic@yOwa@xBgoA`vAubDl`C`FvEdAkNwSip@e
\\eReXol@efAq|Bob@gyAct@ejA}Yax@nCkNcTob@wh@{qAgDwBpN`DfkAw\\tRcH~Sci@`Ss[tUe|@poAu_GdPsw@jZgm@fc@ev@|l@o_Ab}Aqt@jc@}|@~^saAtaAel@bUmi@q@zU|x@uStStAzHZ`KiL', NULL, '2021-12-12 19:17:46', '2021-12-12 19:18:06', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1460, 'KWD162754', 290, 0, 130, 1, 9289, 0, 'CANCELLED', 'USER', 'g', 'CASH', 0, 410.37, 4147.78, '', '1001, Block F State Life Phase 1 State Life, Lahore, Punjab, Pakistan', 31.44289820, 74.39835610, 'Phase 7, Phase 7 Bahria Town, Rawalpindi, Islamabad, Islamabad Capital Territory, Pakistan', 33.52555030, 73.11283130, '2021-12-12 19:18:51', NULL, NULL, NULL, 0, 0, 0, 0, 'oe|~Ds|aeMaVlBeIv@gDlT`BlO{@Wah@uJq@cD|Ws@pE{s@u
\\cyAix@koAa[{Vk`BnLue@h@{d@r^wXtNgyA`@o_BqBydAgNos@mZwe@yRsj@mAe}@s@a`Au@uj@hG_`Bls@wn@jl@~Fpz@zZd`@a]jRcx@vg@oc@ts@iZ~gBaDtn@gSrm@osBr|BitA~f@ivAdGmh@Ts`AlWwJ`iBzJvdDbg@baCxq@v|Drk@nuDfIhIb@eK}^xVuYnjAurAhrCm_B|aCyr@zfAm`@jlAep@baF_
\\trBqXxeEqHfaB_Y`kDisAp`EcvBdiGuwAttGaxCf}Kch@~qCoy@f}Bku@`pCmjAfvB}rAhiHiuCnuJ_bApqE{b@j`B{VxnCPd|Hi]poQiGhsE_ExbCib@p|CsInkF{HbuBgc@~iLk^x}C}Y~}Agj@hhAiw@zpAy~Al}@yyAnQs`Bbo@esFptBsiG|i@c}Erv@k{AtKs`Bdv@}vDztAyzApPmrArBmgAhR_mB?_cEj@ynBrHkvAhSciCfgAahBbdAkoBvaBe}A`j@{mFdmDy`Af~AykAnsCchCdeFs|AlnBgpAdyAaiAty@itHfbCcnGhfCq|C~~@e{@v^{f@hj@_}@|pAm[b_AlKrKyPxKcH`[kUgNw_@_]u_@nJeSkSiYo^sYwNgT_A|BcHsDmGuOzF_ZiX_VpYih@r_@miBxRgtAtJ_gCnb@em@bWe]nE_NvQoJbeAkTtQqh@bKaoAno@gR~Y]ni@|JhqBuPxgAs]lf@mb@rQ_aAmPwdApDoeAdYupBtZwoCkA__BrFmr@xE}k@oNkdA}lAmxAarBy^OiiArk@gqAjf@qlArUuf@|Ven@js@si@x]ct@lTsuBt]szEve@c|Dzs@{mBnO}h@e\\e`AjAiq@fUm_@nIwZsQgqAakCg[gTa_C_n@wuAcVuqAwx@{~@ikBeSep@sa@ob@wmAqcCajAkwBw~AqqBc_CwrA}zAeSacA{Ja|@am@kdC}gC_qAiZstBaXgmBuBkiAao@yl@}NssApKce@xFga@mSio@qh@eqCwFwg@_Hkw@qt@y}Bc_DkdCmrCkZuSyx@wHic@yOwa@xBgoA`vAubDl`C`FvEdAkNwSip@e\\eReXol@efAq|Bob@gyAct@ejA}Yax@nCkNcTob@wh@{qAgDwBpN`DfkAw
\\tRcH~Sci@`Ss[tUe|@poAu_GdPsw@jZgm@fc@ev@|l@o_Ab}Aqt@jc@}|@~^saAtaAel@bUmi@q@zU|x@uStStAzHZ`KiL', NULL, '
2021-12-12 19:18:51
', '2021-12-12 19:19:13
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1461, 'KWD280015', 290, 0, 130, 1, 5762, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 410.37, 4147.78, '', '
1001, Block F State Life Phase 1 State Life, Lahore, Punjab, Pakistan', 31.44289820, 74.39835610, 'Phase 7, Phase 7 Bahria Town, Rawalpindi, Islamabad, Islamabad Capital Territory, Pakistan', 33.52555030, 73.11283130, '
2021-12-12 19:19:30
', NULL, NULL, NULL, 0, 0, 0, 0, 'oe|~Ds|aeMaVlBeIv@gDlT`BlO{@Wah@uJq@cD|Ws@pE{s@u\\cyAix@koAa[{Vk`BnLue@h@{d@r^wXtNgyA`@o_BqBydAgNos@mZwe@yRsj@mAe}@s@a`Au@uj@hG_`Bls@wn@jl@~Fpz@zZd`@a]jRcx@vg@oc@ts@iZ~gBaDtn@gSrm@osBr|BitA~f@ivAdGmh@Ts`AlWwJ`iBzJvdDbg@baCxq@v|Drk@nuDfIhIb@eK}^xVuYnjAurAhrCm_B|aCyr@zfAm`@jlAep@baF_\\trBqXxeEqHfaB_Y`kDisAp`EcvBdiGuwAttGaxCf}Kch@~qCoy@f}Bku@`pCmjAfvB}rAhiHiuCnuJ_bApqE{b@j`B{VxnCPd|Hi]poQiGhsE_ExbCib@p|CsInkF{HbuBgc@~iLk^x}C}Y~}Agj@hhAiw@zpAy~Al}@yyAnQs`Bbo@esFptBsiG|i@c}Erv@k{AtKs`Bdv@}vDztAyzApPmrArBmgAhR_mB?_cEj@ynBrHkvAhSciCfgAahBbdAkoBvaBe}A`j@{mFdmDy`Af~AykAnsCchCdeFs|AlnBgpAdyAaiAty@itHfbCcnGhfCq|C~~@e{@v^{f@hj@_}@|pAm[b_AlKrKyPxKcH`[kUgNw_@_]u_@nJeSkSiYo^sYwNgT_A|BcHsDmGuOzF_ZiX_VpYih@r_@miBxRgtAtJ_gCnb@em@bWe]nE_NvQoJbeAkTtQqh@bKaoAno@gR~Y]ni@|JhqBuPxgAs]lf@mb@rQ_aAmPwdApDoeAdYupBtZwoCkA__BrFmr@xE}k@oNkdA}lAmxAarBy^OiiArk@gqAjf@qlArUuf@|Ven@js@si@x]ct@lTsuBt]szEve@c|Dzs@{mBnO}h@e
\\e`AjAiq@fUm_@nIwZsQgqAakCg[gTa_C_n@wuAcVuqAwx@{~@ikBeSep@sa@ob@wmAqcCajAkwBw~AqqBc_CwrA}zAeSacA{Ja|@am@kdC}gC_qAiZstBaXgmBuBkiAao@yl@}NssApKce@xFga@mSio@qh@eqCwFwg@_Hkw@qt@y}Bc_DkdCmrCkZuSyx@wHic@yOwa@xBgoA`vAubDl`C`FvEdAkNwSip@e
\\eReXol@efAq|Bob@gyAct@ejA}Yax@nCkNcTob@wh@{qAgDwBpN`DfkAw\\tRcH~Sci@`Ss[tUe|@poAu_GdPsw@jZgm@fc@ev@|l@o_Ab}Aqt@jc@}|@~^saAtaAel@bUmi@q@zU|x@uStStAzHZ`KiL', NULL, '2021-12-12 19:19:30', '2021-12-12 19:20:43', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1462, 'KWD636875', 289, 0, 123, 1, 6588, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 11.54, 115.59, '', 'Unnamed Road, Lusaka, Zambia', -15.39862390, 28.38690570, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-12 19:28:27', NULL, NULL, NULL, 0, 0, 0, 0, '|p~|A{fglDkFz@o@}CWqAyBd@eAH_CEgC?wA?oG@qL?yCAy@?SCu@g@]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb
\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H
\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zE@P
\\hELjAJf@x@lE
\\lAh@zAnApCx@xAb@x@hBfCnGrH|B`CT\\|HnJjFfGhMrO~AnBOLsCkDYBSF]X[RG?KGQ_@CGUPCB?DDJxB`CvAdB', NULL, '
2021-12-12 19:28:27
', '2021-12-12 19:28:37
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1463, 'KWD110794', 290, 0, 130, 1, 3707, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 410.37, 4147.79, '', '
1001, Block F State Life Phase 1 State Life, Lahore, Punjab, Pakistan', 31.44291890, 74.39835590, 'Phase 7, Phase 7 Bahria Town, Rawalpindi, Islamabad, Islamabad Capital Territory, Pakistan', 33.52555030, 73.11283130, '
2021-12-12 19:34:02
', NULL, NULL, NULL, 0, 0, 0, 0, 'oe|~Ds|aeMaVlBeIv@gDlT`BlO{@Wah@uJq@cD|Ws@pE{s@u\\cyAix@koAa[{Vk`BnLue@h@{d@r^wXtNgyA`@o_BqBydAgNos@mZwe@yRsj@mAe}@s@a`Au@uj@hG_`Bls@wn@jl@~Fpz@zZd`@a]jRcx@vg@oc@ts@iZ~gBaDtn@gSrm@osBr|BitA~f@ivAdGmh@Ts`AlWwJ`iBzJvdDbg@baCxq@v|Drk@nuDfIhIb@eK}^xVuYnjAurAhrCm_B|aCyr@zfAm`@jlAep@baF_\\trBqXxeEqHfaB_Y`kDisAp`EcvBdiGuwAttGaxCf}Kch@~qCoy@f}Bku@`pCmjAfvB}rAhiHiuCnuJ_bApqE{b@j`B{VxnCPd|Hi]poQiGhsE_ExbCib@p|CsInkF{HbuBgc@~iLk^x}C}Y~}Agj@hhAiw@zpAy~Al}@yyAnQs`Bbo@esFptBsiG|i@c}Erv@k{AtKs`Bdv@}vDztAyzApPmrArBmgAhR_mB?_cEj@ynBrHkvAhSciCfgAahBbdAkoBvaBe}A`j@{mFdmDy`Af~AykAnsCchCdeFs|AlnBgpAdyAaiAty@itHfbCcnGhfCq|C~~@e{@v^{f@hj@_}@|pAm[b_AlKrKyPxKcH`[kUgNw_@_]u_@nJeSkSiYo^sYwNgT_A|BcHsDmGuOzF_ZiX_VpYih@r_@miBxRgtAtJ_gCnb@em@bWe]nE_NvQoJbeAkTtQqh@bKaoAno@gR~Y]ni@|JhqBuPxgAs]lf@mb@rQ_aAmPwdApDoeAdYupBtZwoCkA__BrFmr@xE}k@oNkdA}lAmxAarBy^OiiArk@gqAjf@qlArUuf@|Ven@js@si@x]ct@lTsuBt]szEve@c|Dzs@{mBnO}h@e
\\e`AjAiq@fUm_@nIwZsQgqAakCg[gTa_C_n@wuAcVuqAwx@{~@ikBeSep@sa@ob@wmAqcCajAkwBw~AqqBc_CwrA}zAeSacA{Ja|@am@kdC}gC_qAiZstBaXgmBuBkiAao@yl@}NssApKce@xFga@mSio@qh@eqCwFwg@_Hkw@qt@y}Bc_DkdCmrCkZuSyx@wHic@yOwa@xBgoA`vAubDl`C`FvEdAkNwSip@e
\\eReXol@efAq|Bob@gyAct@ejA}Yax@nCkNcTob@wh@{qAgDwBpN`DfkAw\\tRcH~Sci@`Ss[tUe|@poAu_GdPsw@jZgm@fc@ev@|l@o_Ab}Aqt@jc@}|@~^saAtaAel@bUmi@q@zU|x@uStStAzHZ`KiL', NULL, '2021-12-12 19:34:02', '2021-12-12 19:35:12', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1464, 'KWD469804', 290, 0, 130, 1, 9731, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 410.37, 4147.79, '', '1001, Block F State Life Phase 1 State Life, Lahore, Punjab, Pakistan', 31.44289560, 74.39836040, 'Phase 7, Phase 7 Bahria Town, Rawalpindi, Islamabad, Islamabad Capital Territory, Pakistan', 33.52555030, 73.11283130, '2021-12-12 19:35:43', NULL, NULL, NULL, 0, 0, 0, 0, 'oe|~Ds|aeMaVlBeIv@gDlT`BlO{@Wah@uJq@cD|Ws@pE{s@u
\\cyAix@koAa[{Vk`BnLue@h@{d@r^wXtNgyA`@o_BqBydAgNos@mZwe@yRsj@mAe}@s@a`Au@uj@hG_`Bls@wn@jl@~Fpz@zZd`@a]jRcx@vg@oc@ts@iZ~gBaDtn@gSrm@osBr|BitA~f@ivAdGmh@Ts`AlWwJ`iBzJvdDbg@baCxq@v|Drk@nuDfIhIb@eK}^xVuYnjAurAhrCm_B|aCyr@zfAm`@jlAep@baF_
\\trBqXxeEqHfaB_Y`kDisAp`EcvBdiGuwAttGaxCf}Kch@~qCoy@f}Bku@`pCmjAfvB}rAhiHiuCnuJ_bApqE{b@j`B{VxnCPd|Hi]poQiGhsE_ExbCib@p|CsInkF{HbuBgc@~iLk^x}C}Y~}Agj@hhAiw@zpAy~Al}@yyAnQs`Bbo@esFptBsiG|i@c}Erv@k{AtKs`Bdv@}vDztAyzApPmrArBmgAhR_mB?_cEj@ynBrHkvAhSciCfgAahBbdAkoBvaBe}A`j@{mFdmDy`Af~AykAnsCchCdeFs|AlnBgpAdyAaiAty@itHfbCcnGhfCq|C~~@e{@v^{f@hj@_}@|pAm[b_AlKrKyPxKcH`[kUgNw_@_]u_@nJeSkSiYo^sYwNgT_A|BcHsDmGuOzF_ZiX_VpYih@r_@miBxRgtAtJ_gCnb@em@bWe]nE_NvQoJbeAkTtQqh@bKaoAno@gR~Y]ni@|JhqBuPxgAs]lf@mb@rQ_aAmPwdApDoeAdYupBtZwoCkA__BrFmr@xE}k@oNkdA}lAmxAarBy^OiiArk@gqAjf@qlArUuf@|Ven@js@si@x]ct@lTsuBt]szEve@c|Dzs@{mBnO}h@e\\e`AjAiq@fUm_@nIwZsQgqAakCg[gTa_C_n@wuAcVuqAwx@{~@ikBeSep@sa@ob@wmAqcCajAkwBw~AqqBc_CwrA}zAeSacA{Ja|@am@kdC}gC_qAiZstBaXgmBuBkiAao@yl@}NssApKce@xFga@mSio@qh@eqCwFwg@_Hkw@qt@y}Bc_DkdCmrCkZuSyx@wHic@yOwa@xBgoA`vAubDl`C`FvEdAkNwSip@e\\eReXol@efAq|Bob@gyAct@ejA}Yax@nCkNcTob@wh@{qAgDwBpN`DfkAw
\\tRcH~Sci@`Ss[tUe|@poAu_GdPsw@jZgm@fc@ev@|l@o_Ab}Aqt@jc@}|@~^saAtaAel@bUmi@q@zU|x@uStStAzHZ`KiL', NULL, '
2021-12-12 19:35:43
', '2021-12-12 19:36:55
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1465, 'KWD116599', 290, 0, 130, 1, 4382, 0, 'CANCELLED', 'USER', 'ft', 'CASH', 0, 410.37, 4147.74, '', '
1001, Block F State Life Phase 1 State Life, Lahore, Punjab, Pakistan', 31.44290370, 74.39830280, 'Phase 7, Phase 7 Bahria Town, Rawalpindi, Islamabad, Islamabad Capital Territory, Pakistan', 33.52555030, 73.11283130, '
2021-12-12 19:39:09
', NULL, NULL, NULL, 0, 0, 0, 0, 'me|~Di|aeMcVbBeIv@gDlT`BlO{@Wah@uJq@cD|Ws@pE{s@u\\cyAix@koAa[{Vk`BnLue@h@{d@r^wXtNgyA`@o_BqBydAgNos@mZwe@yRsj@mAe}@s@a`Au@uj@hG_`Bls@wn@jl@~Fpz@zZd`@a]jRcx@vg@oc@ts@iZ~gBaDtn@gSrm@osBr|BitA~f@ivAdGmh@Ts`AlWwJ`iBzJvdDbg@baCxq@v|Drk@nuDfIhIb@eK}^xVuYnjAurAhrCm_B|aCyr@zfAm`@jlAep@baF_\\trBqXxeEqHfaB_Y`kDisAp`EcvBdiGuwAttGaxCf}Kch@~qCoy@f}Bku@`pCmjAfvB}rAhiHiuCnuJ_bApqE{b@j`B{VxnCPd|Hi]poQiGhsE_ExbCib@p|CsInkF{HbuBgc@~iLk^x}C}Y~}Agj@hhAiw@zpAy~Al}@yyAnQs`Bbo@esFptBsiG|i@c}Erv@k{AtKs`Bdv@}vDztAyzApPmrArBmgAhR_mB?_cEj@ynBrHkvAhSciCfgAahBbdAkoBvaBe}A`j@{mFdmDy`Af~AykAnsCchCdeFs|AlnBgpAdyAaiAty@itHfbCcnGhfCq|C~~@e{@v^{f@hj@_}@|pAm[b_AlKrKyPxKcH`[kUgNw_@_]u_@nJeSkSiYo^sYwNgT_A|BcHsDmGuOzF_ZiX_VpYih@r_@miBxRgtAtJ_gCnb@em@bWe]nE_NvQoJbeAkTtQqh@bKaoAno@gR~Y]ni@|JhqBuPxgAs]lf@mb@rQ_aAmPwdApDoeAdYupBtZwoCkA__BrFmr@xE}k@oNkdA}lAmxAarBy^OiiArk@gqAjf@qlArUuf@|Ven@js@si@x]ct@lTsuBt]szEve@c|Dzs@{mBnO}h@e
\\e`AjAiq@fUm_@nIwZsQgqAakCg[gTa_C_n@wuAcVuqAwx@{~@ikBeSep@sa@ob@wmAqcCajAkwBw~AqqBc_CwrA}zAeSacA{Ja|@am@kdC}gC_qAiZstBaXgmBuBkiAao@yl@}NssApKce@xFga@mSio@qh@eqCwFwg@_Hkw@qt@y}Bc_DkdCmrCkZuSyx@wHic@yOwa@xBgoA`vAubDl`C`FvEdAkNwSip@e
\\eReXol@efAq|Bob@gyAct@ejA}Yax@nCkNcTob@wh@{qAgDwBpN`DfkAw\\tRcH~Sci@`Ss[tUe|@poAu_GdPsw@jZgm@fc@ev@|l@o_Ab}Aqt@jc@}|@~^saAtaAel@bUmi@q@zU|x@uStStAzHZ`KiL', NULL, '2021-12-12 19:39:09', '2021-12-12 19:40:12', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1466, 'KWD747543', 290, 130, 130, 1, 6800, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 410.38, 4147.83, '', '1001, Block F State Life Phase 1 State Life, Lahore, Punjab, Pakistan', 31.44289536, 74.39840615, 'Phase 7, Phase 7 Bahria Town, Rawalpindi, Islamabad, Islamabad Capital Territory, Pakistan', 33.52555030, 73.11283130, '2021-12-12 19:42:50', NULL, '2021-12-12 19:43:21', '2021-12-12 19:43:31', 1, 1, 0, 0, 'qe|~D{|aeM_VtBeIv@gDlT`BlO{@Wah@uJq@cD|Ws@pE{s@u
\\cyAix@koAa[{Vk`BnLue@h@{d@r^wXtNgyA`@o_BqBydAgNos@mZwe@yRsj@mAe}@s@a`Au@uj@hG_`Bls@wn@jl@~Fpz@zZd`@a]jRcx@vg@oc@ts@iZ~gBaDtn@gSrm@osBr|BitA~f@ivAdGmh@Ts`AlWwJ`iBzJvdDbg@baCxq@v|Drk@nuDfIhIb@eK}^xVuYnjAurAhrCm_B|aCyr@zfAm`@jlAep@baF_
\\trBqXxeEqHfaB_Y`kDisAp`EcvBdiGuwAttGaxCf}Kch@~qCoy@f}Bku@`pCmjAfvB}rAhiHiuCnuJ_bApqE{b@j`B{VxnCPd|Hi]poQiGhsE_ExbCib@p|CsInkF{HbuBgc@~iLk^x}C}Y~}Agj@hhAiw@zpAy~Al}@yyAnQs`Bbo@esFptBsiG|i@c}Erv@k{AtKs`Bdv@}vDztAyzApPmrArBmgAhR_mB?_cEj@ynBrHkvAhSciCfgAahBbdAkoBvaBe}A`j@{mFdmDy`Af~AykAnsCchCdeFs|AlnBgpAdyAaiAty@itHfbCcnGhfCq|C~~@e{@v^{f@hj@_}@|pAm[b_AlKrKyPxKcH`[kUgNw_@_]u_@nJeSkSiYo^sYwNgT_A|BcHsDmGuOzF_ZiX_VpYih@r_@miBxRgtAtJ_gCnb@em@bWe]nE_NvQoJbeAkTtQqh@bKaoAno@gR~Y]ni@|JhqBuPxgAs]lf@mb@rQ_aAmPwdApDoeAdYupBtZwoCkA__BrFmr@xE}k@oNkdA}lAmxAarBy^OiiArk@gqAjf@qlArUuf@|Ven@js@si@x]ct@lTsuBt]szEve@c|Dzs@{mBnO}h@e\\e`AjAiq@fUm_@nIwZsQgqAakCg[gTa_C_n@wuAcVuqAwx@{~@ikBeSep@sa@ob@wmAqcCajAkwBw~AqqBc_CwrA}zAeSacA{Ja|@am@kdC}gC_qAiZstBaXgmBuBkiAao@yl@}NssApKce@xFga@mSio@qh@eqCwFwg@_Hkw@qt@y}Bc_DkdCmrCkZuSyx@wHic@yOwa@xBgoA`vAubDl`C`FvEdAkNwSip@e\\eReXol@efAq|Bob@gyAct@ejA}Yax@nCkNcTob@wh@{qAgDwBpN`DfkAw
\\tRcH~Sci@`Ss[tUe|@poAu_GdPsw@jZgm@fc@ev@|l@o_Ab}Aqt@jc@}|@~^saAtaAel@bUmi@q@zU|x@uStStAzHZ`KiL', NULL, '
2021-12-12 19:42:50
', '2021-12-12 19:46:43
', 'NO', '
0', 0.00000000, 0.00000000, 0.00000000),
(1467, 'KWD435186', 290, 130, 130, 1, 2092, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 410.38, 4147.84, '', '
1001, Block F State Life Phase 1 State Life, Lahore, Punjab, Pakistan', 31.44292770, 74.39840230, 'Phase 7, Phase 7 Bahria Town, Rawalpindi, Islamabad, Islamabad Capital Territory, Pakistan', 33.52555030, 73.11283130, '
2021-12-12 19:47:09
', NULL, '2021-12-12 19:47:42
', '2021-12-12 19:47:47
', 1, 1, 0, 0, 'qe|~D}|aeM_VvBeIv@gDlT`BlO{@Wah@uJq@cD|Ws@pE{s@u\\cyAix@koAa[{Vk`BnLue@h@{d@r^wXtNgyA`@o_BqBydAgNos@mZwe@yRsj@mAe}@s@a`Au@uj@hG_`Bls@wn@jl@~Fpz@zZd`@a]jRcx@vg@oc@ts@iZ~gBaDtn@gSrm@osBr|BitA~f@ivAdGmh@Ts`AlWwJ`iBzJvdDbg@baCxq@v|Drk@nuDfIhIb@eK}^xVuYnjAurAhrCm_B|aCyr@zfAm`@jlAep@baF_\\trBqXxeEqHfaB_Y`kDisAp`EcvBdiGuwAttGaxCf}Kch@~qCoy@f}Bku@`pCmjAfvB}rAhiHiuCnuJ_bApqE{b@j`B{VxnCPd|Hi]poQiGhsE_ExbCib@p|CsInkF{HbuBgc@~iLk^x}C}Y~}Agj@hhAiw@zpAy~Al}@yyAnQs`Bbo@esFptBsiG|i@c}Erv@k{AtKs`Bdv@}vDztAyzApPmrArBmgAhR_mB?_cEj@ynBrHkvAhSciCfgAahBbdAkoBvaBe}A`j@{mFdmDy`Af~AykAnsCchCdeFs|AlnBgpAdyAaiAty@itHfbCcnGhfCq|C~~@e{@v^{f@hj@_}@|pAm[b_AlKrKyPxKcH`[kUgNw_@_]u_@nJeSkSiYo^sYwNgT_A|BcHsDmGuOzF_ZiX_VpYih@r_@miBxRgtAtJ_gCnb@em@bWe]nE_NvQoJbeAkTtQqh@bKaoAno@gR~Y]ni@|JhqBuPxgAs]lf@mb@rQ_aAmPwdApDoeAdYupBtZwoCkA__BrFmr@xE}k@oNkdA}lAmxAarBy^OiiArk@gqAjf@qlArUuf@|Ven@js@si@x]ct@lTsuBt]szEve@c|Dzs@{mBnO}h@e
\\e`AjAiq@fUm_@nIwZsQgqAakCg[gTa_C_n@wuAcVuqAwx@{~@ikBeSep@sa@ob@wmAqcCajAkwBw~AqqBc_CwrA}zAeSacA{Ja|@am@kdC}gC_qAiZstBaXgmBuBkiAao@yl@}NssApKce@xFga@mSio@qh@eqCwFwg@_Hkw@qt@y}Bc_DkdCmrCkZuSyx@wHic@yOwa@xBgoA`vAubDl`C`FvEdAkNwSip@e
\\eReXol@efAq|Bob@gyAct@ejA}Yax@nCkNcTob@wh@{qAgDwBpN`DfkAw\\tRcH~Sci@`Ss[tUe|@poAu_GdPsw@jZgm@fc@ev@|l@o_Ab}Aqt@jc@}|@~^saAtaAel@bUmi@q@zU|x@uStStAzHZ`KiL', NULL, '2021-12-12 19:47:09', '2021-12-12 19:48:04', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1468, 'KWD770608', 290, 0, 130, 1, 7354, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 410.37, 4147.80, '', '1001, Block F State Life Phase 1 State Life, Lahore, Punjab, Pakistan', 31.44289820, 74.39836860, 'Phase 7, Phase 7 Bahria Town, Rawalpindi, Islamabad, Islamabad Capital Territory, Pakistan', 33.52555030, 73.11283130, '2021-12-12 19:48:49', NULL, NULL, NULL, 0, 0, 0, 0, 'oe|~Du|aeMaVnBeIv@gDlT`BlO{@Wah@uJq@cD|Ws@pE{s@u
\\cyAix@koAa[{Vk`BnLue@h@{d@r^wXtNgyA`@o_BqBydAgNos@mZwe@yRsj@mAe}@s@a`Au@uj@hG_`Bls@wn@jl@~Fpz@zZd`@a]jRcx@vg@oc@ts@iZ~gBaDtn@gSrm@osBr|BitA~f@ivAdGmh@Ts`AlWwJ`iBzJvdDbg@baCxq@v|Drk@nuDfIhIb@eK}^xVuYnjAurAhrCm_B|aCyr@zfAm`@jlAep@baF_
\\trBqXxeEqHfaB_Y`kDisAp`EcvBdiGuwAttGaxCf}Kch@~qCoy@f}Bku@`pCmjAfvB}rAhiHiuCnuJ_bApqE{b@j`B{VxnCPd|Hi]poQiGhsE_ExbCib@p|CsInkF{HbuBgc@~iLk^x}C}Y~}Agj@hhAiw@zpAy~Al}@yyAnQs`Bbo@esFptBsiG|i@c}Erv@k{AtKs`Bdv@}vDztAyzApPmrArBmgAhR_mB?_cEj@ynBrHkvAhSciCfgAahBbdAkoBvaBe}A`j@{mFdmDy`Af~AykAnsCchCdeFs|AlnBgpAdyAaiAty@itHfbCcnGhfCq|C~~@e{@v^{f@hj@_}@|pAm[b_AlKrKyPxKcH`[kUgNw_@_]u_@nJeSkSiYo^sYwNgT_A|BcHsDmGuOzF_ZiX_VpYih@r_@miBxRgtAtJ_gCnb@em@bWe]nE_NvQoJbeAkTtQqh@bKaoAno@gR~Y]ni@|JhqBuPxgAs]lf@mb@rQ_aAmPwdApDoeAdYupBtZwoCkA__BrFmr@xE}k@oNkdA}lAmxAarBy^OiiArk@gqAjf@qlArUuf@|Ven@js@si@x]ct@lTsuBt]szEve@c|Dzs@{mBnO}h@e\\e`AjAiq@fUm_@nIwZsQgqAakCg[gTa_C_n@wuAcVuqAwx@{~@ikBeSep@sa@ob@wmAqcCajAkwBw~AqqBc_CwrA}zAeSacA{Ja|@am@kdC}gC_qAiZstBaXgmBuBkiAao@yl@}NssApKce@xFga@mSio@qh@eqCwFwg@_Hkw@qt@y}Bc_DkdCmrCkZuSyx@wHic@yOwa@xBgoA`vAubDl`C`FvEdAkNwSip@e\\eReXol@efAq|Bob@gyAct@ejA}Yax@nCkNcTob@wh@{qAgDwBpN`DfkAw
\\tRcH~Sci@`Ss[tUe|@poAu_GdPsw@jZgm@fc@ev@|l@o_Ab}Aqt@jc@}|@~^saAtaAel@bUmi@q@zU|x@uStStAzHZ`KiL', NULL, '
2021-12-12 19:48:49
', '2021-12-12 19:49:04
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1469, 'KWD207919', 290, 0, 130, 1, 7772, 0, 'CANCELLED', 'USER', 'uu', 'CASH', 0, 410.38, 4147.82, '', '
1001, Block F State Life Phase 1 State Life, Lahore, Punjab, Pakistan', 31.44288820, 74.39839300, 'Phase 7, Phase 7 Bahria Town, Rawalpindi, Islamabad, Islamabad Capital Territory, Pakistan', 33.52555030, 73.11283130, '
2021-12-12 19:49:30
', NULL, NULL, NULL, 0, 0, 0, 0, 'qe|~Dy|aeM_VrBeIv@gDlT`BlO{@Wah@uJq@cD|Ws@pE{s@u\\cyAix@koAa[{Vk`BnLue@h@{d@r^wXtNgyA`@o_BqBydAgNos@mZwe@yRsj@mAe}@s@a`Au@uj@hG_`Bls@wn@jl@~Fpz@zZd`@a]jRcx@vg@oc@ts@iZ~gBaDtn@gSrm@osBr|BitA~f@ivAdGmh@Ts`AlWwJ`iBzJvdDbg@baCxq@v|Drk@nuDfIhIb@eK}^xVuYnjAurAhrCm_B|aCyr@zfAm`@jlAep@baF_\\trBqXxeEqHfaB_Y`kDisAp`EcvBdiGuwAttGaxCf}Kch@~qCoy@f}Bku@`pCmjAfvB}rAhiHiuCnuJ_bApqE{b@j`B{VxnCPd|Hi]poQiGhsE_ExbCib@p|CsInkF{HbuBgc@~iLk^x}C}Y~}Agj@hhAiw@zpAy~Al}@yyAnQs`Bbo@esFptBsiG|i@c}Erv@k{AtKs`Bdv@}vDztAyzApPmrArBmgAhR_mB?_cEj@ynBrHkvAhSciCfgAahBbdAkoBvaBe}A`j@{mFdmDy`Af~AykAnsCchCdeFs|AlnBgpAdyAaiAty@itHfbCcnGhfCq|C~~@e{@v^{f@hj@_}@|pAm[b_AlKrKyPxKcH`[kUgNw_@_]u_@nJeSkSiYo^sYwNgT_A|BcHsDmGuOzF_ZiX_VpYih@r_@miBxRgtAtJ_gCnb@em@bWe]nE_NvQoJbeAkTtQqh@bKaoAno@gR~Y]ni@|JhqBuPxgAs]lf@mb@rQ_aAmPwdApDoeAdYupBtZwoCkA__BrFmr@xE}k@oNkdA}lAmxAarBy^OiiArk@gqAjf@qlArUuf@|Ven@js@si@x]ct@lTsuBt]szEve@c|Dzs@{mBnO}h@e
\\e`AjAiq@fUm_@nIwZsQgqAakCg[gTa_C_n@wuAcVuqAwx@{~@ikBeSep@sa@ob@wmAqcCajAkwBw~AqqBc_CwrA}zAeSacA{Ja|@am@kdC}gC_qAiZstBaXgmBuBkiAao@yl@}NssApKce@xFga@mSio@qh@eqCwFwg@_Hkw@qt@y}Bc_DkdCmrCkZuSyx@wHic@yOwa@xBgoA`vAubDl`C`FvEdAkNwSip@e
\\eReXol@efAq|Bob@gyAct@ejA}Yax@nCkNcTob@wh@{qAgDwBpN`DfkAw\\tRcH~Sci@`Ss[tUe|@poAu_GdPsw@jZgm@fc@ev@|l@o_Ab}Aqt@jc@}|@~^saAtaAel@bUmi@q@zU|x@uStStAzHZ`KiL', NULL, '2021-12-12 19:49:30', '2021-12-12 19:49:57', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1470, 'KWD607753', 290, 0, 130, 1, 7614, 0, 'CANCELLED', 'USER', 'gg', 'CASH', 0, 410.38, 4147.87, '', '1001, Block F State Life Phase 1 State Life, Lahore, Punjab, Pakistan', 31.44291943, 74.39844358, 'Phase 7, Phase 7 Bahria Town, Rawalpindi, Islamabad, Islamabad Capital Territory, Pakistan', 33.52555030, 73.11283130, '2021-12-12 19:50:20', NULL, NULL, NULL, 0, 0, 0, 0, 'se|~Dc}aeM@lD_Vo@eIv@gDlT`BlO{@Wah@uJq@cD|Ws@pE{s@u
\\cyAix@koAa[{Vk`BnLue@h@{d@r^wXtNgyA`@o_BqBydAgNos@mZwe@yRsj@mAe}@s@a`Au@uj@hG_`Bls@wn@jl@~Fpz@zZd`@a]jRcx@vg@oc@ts@iZ~gBiXh}AosBr|BitA~f@ivAdGmh@Ts`AlWwJ`iBzJvdDbg@baCxq@v|Drk@nuDfIhIb@eK}^xVuYnjAurAhrCm_B|aCyr@zfAm`@jlAep@baF_
\\trBqXxeEqHfaB_Y`kDisAp`EcvBdiGuwAttGaxCf}Kch@~qCoy@f}Bku@`pCmjAfvB}rAhiHiuCnuJ_bApqE{b@j`B{VxnCPd|Hi]poQiGhsE_ExbCib@p|CsInkF{HbuBgc@~iLk^x}C}Y~}Agj@hhAiw@zpAy~Al}@yyAnQs`Bbo@esFptBsiG|i@c}Erv@k{AtKs`Bdv@}vDztAyzApPmrArBmgAhR_mB?_cEj@ynBrHkvAhSciCfgAahBbdAkoBvaBe}A`j@{mFdmDy`Af~AykAnsCchCdeFs|AlnBgpAdyAaiAty@itHfbCcnGhfCq|C~~@e{@v^{f@hj@_}@|pAm[b_AlKrKyPxKcH`[kUgNw_@_]u_@nJeSkSiYo^sYwNgT_A|BcHsDmGuOzF_ZiX_VpYih@r_@miBxRgtAtJ_gCnb@em@bWe]nE_NvQoJbeAkTtQqh@bKaoAno@gR~Y]ni@|JhqBuPxgAs]lf@mb@rQ_aAmPwdApDoeAdYupBtZwoCkA__BrFmr@xE}k@oNkdA}lAmxAarBy^OiiArk@gqAjf@qlArUuf@|Ven@js@si@x]ct@lTsuBt]szEve@c|Dzs@{mBnO}h@e\\e`AjAiq@fUm_@nIwZsQgqAakCg[gTa_C_n@wuAcVuqAwx@{~@ikBeSep@sa@ob@wmAqcCajAkwBw~AqqBc_CwrA}zAeSacA{Ja|@am@kdC}gC_qAiZstBaXgmBuBkiAao@yl@}NssApKce@xFga@mSio@qh@eqCwFwg@_Hkw@qt@y}Bc_DkdCmrCkZuSyx@wHic@yOwa@xBgoA`vAubDl`C`FvEdAkNwSip@e\\eReXol@efAq|Bob@gyAct@ejA}Yax@nCkNcTob@wh@{qAgDwBpN`DfkAw
\\tRcH~Sci@`Ss[tUe|@poAu_GdPsw@jZgm@fc@ev@|l@o_Ab}Aqt@jc@}|@~^saAtaAel@bUmi@q@zU|x@uStStAzHZ`KiL', NULL, '
2021-12-12 19:50:20
', '2021-12-12 19:50:51
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1471, 'KWD867141', 290, 0, 130, 1, 9249, 0, 'CANCELLED', 'USER', 'gb', 'CASH', 0, 410.39, 4147.99, '', '
1001, Block F State Life Phase 1 State Life, Lahore, Punjab, Pakistan', 31.44293027, 74.39847211, 'Phase 7, Phase 7 Bahria Town, Rawalpindi, Islamabad, Islamabad Capital Territory, Pakistan', 33.52555030, 73.11283130, '
2021-12-12 19:51:48
', NULL, NULL, NULL, 0, 0, 0, 0, 'ke|~Du}aeMwUfCaIbAoE`TxBpO}@Oef@yJ{BeD`Xi@fFcq@uXytAsvAymBk_B~Kog@P_c@|[}XbQuwAv@i{AeBwiA{L_v@i[c`@sQok@eCacA{@a_As@yi@jFw~A~q@wq@lm@zEry@t[xa@_\\jR{u@zd@if@bv@sZldBkVv~AksBz}B{uAxh@yvAfGsf@LwaAtVgH`u@iBds@vItaDz^neB|z@x{Enk@huDxHfJjAeK{^tU}XdgA{o@l_Bmb@~t@m_B~aCqq@pdA_b@jnAkp@taF_
\\trBwW`xDgIlmBqXljDcqAv|DowBjkG_yAnxG_uCtrKcj@`zCqx@ryB_v@dtCejArtBitArlH}sC~pJccAxtEgc@taB_WpjCNtyHk]~sQqFtqEkEraCya@x}CoJ~nF{HbuBec@`iLi^r~CqXr|Awk@xjAgt@dnAg}Aj~@q{A~R}~Atl@}tFtvBqkGnj@{{Exv@c}ApKu~Anu@ovDttA}{ArQuqAfBchArRslBFkbEd@uoBfHmuApR{pF~iC}pBpcBc|A|i@_kFziDucAh|AylAnuCoiCnhFk|AlnBepAfyAqiAxz@wkHf~BytGtiCqyCj}@k_Aj`@ch@xj@m}@voAu[f`AjKnKuObLuH`[eUqLe_@y]_VfBkIjGcbAmcAeZUt@eH_A}IePjIeXcYiXrXsg@``@yiB|RotA`K_gCdb@am@dWg]fEmN~PmJvdA}RrRgf@pJurAdp@eRjXkA`f@tJ~mBaNzmAkXj`@ug@tZu_AyPagAtDmbA`XarB~ZgpCs@y~AtFyq@`Fin@mN{aAqiAmyAstBu_@}@}}@nd@uzA`m@ilApU{e@dTyo@~t@qh@n]mt@lVetBv
\\{gElb@_sEjx@ilBfPki@e
\\wx@Liv@~Rgb@fMqZ_PoqAujCyUiTmdCso@_tAgV}pAku@w`AmiBwS}s@k_@c`@{oA{dCagAeuBkaBkuBk_CgsAuvAgSweAmJc{@ak@sfCwiCwoAg[kvBiXgjBsAgkA{n@yn@iP}rAbKod@hGs`@qPmp@ek@inC}Foh@sF}x@_t@i}Bq~Ci`CgnCc]yXiy@yI}c@sOeb@x@enAxtAoeDzaC|D`G~BgMmSup@e\\cRqVmf@ggAa`Cwb@gzAgo@ucA__@om@m@sRnC_N{Rga@yi@mqAoDkExIpBvkAiYfTaDlS{g@`V}a@pUuz@vnAo}F|i@afBze@qx@ri@q~@j_Byu@|c@k}@xYy~@tbAuk@`Zum@kA~Uty@{S|RnA`Il@zH{LzAF', NULL, '2021-12-12 19:51:48', '2021-12-12 19:52:15', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1472, 'KWD714513', 289, 0, 123, 1, 9737, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.48, 54.35, '', 'Unnamed Road, Lusaka, Zambia', -15.39862330, 28.38636390, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-12 20:39:08', NULL, NULL, NULL, 0, 0, 0, 0, 'bp~|AueglDE]kEr@o@}CWqAyBd@eAH_CEgC?wA?oG@qL?yCAy@?SCu@g@]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F
\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '
2021-12-12 20:39:08
', '2021-12-12 20:39:20
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1473, 'KWD476632', 289, 123, 123, 1, 7447, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 11.51, 115.26, '', 'Unnamed Road, Lusaka, Zambia', -15.39799160, 28.38537460, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '
2021-12-12 20:45:04
', NULL, '2021-12-12 20:45:31
', '2021-12-12 20:46:36
', 1, 1, 0, 0, 'fk~|Ae_glD}BiLkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@{CdPEJWR[B[?aA@I@KHGHE^w@`CmEzMkGhRwF|PyAjEK\\W\\_@RUPBHfB`KbBtI~@bE~@~CtGpRLXJJf@f@HJN^B`@DbA|@xCr@jC|@jE|DtT|B|M|B`LpCjOxFn
\\d@hCNf@T~AZzADt@Fl@NZDBJJJPBXARAFEFBJHf@Jb@
\\vAX|AbArFPbAXnCPpDCxDWzK[nPMvGAjBJrC~@vJz@bJb@~EVlDh@zFZrE^zDR|AP~@p@|Cb@pAh@tApAnCd@z@pArBbBvBrFnGtB|BRVpNzP~EbGzJtLOLsCkDg@Fq@h@IFI?OKSc@YV?F~BhCvAdB', NULL, '
2021-12-12 20:45:04
', '2021-12-12 20:47:03
', 'NO', '
1', 0.00000000, 0.00000000, 0.00000000),
(1474, 'KWD294911', 289, 0, 134, 1, 9358, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.78, 57.33, '', 'Unnamed Road, Lusaka, Zambia', -15.39822210, 28.38517540, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '
2021-12-12 21:53:25
', NULL, NULL, NULL, 0, 0, 0, 0, 'tk~|As}flDh@fCeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-12 21:53:25', '2021-12-12 21:54:05', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1475, 'KWD977770', 289, 0, 123, 1, 8597, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.79, 57.48, '', 'Unnamed Road, Lusaka, Zambia', -15.39803310, 28.38525870, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-12 22:03:28', NULL, NULL, NULL, 0, 0, 0, 0, 'nk~|Ao~flDn@bDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F
\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '
2021-12-12 22:03:28
', '2021-12-12 22:04:40
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1476, 'KWD377453', 289, 0, 123, 1, 8929, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.80, 57.53, '', 'Unnamed Road, Lusaka, Zambia', -15.39811390, 28.38533090, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '
2021-12-12 22:04:39
', NULL, NULL, NULL, 0, 0, 0, 0, 'jk~|Aw~flDr@jDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-12 22:04:39', '2021-12-12 22:05:27', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1477, 'KWD586644', 289, 0, 134, 1, 3928, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.80, 57.53, '', 'Unnamed Road, Lusaka, Zambia', -15.39811390, 28.38533090, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-12 22:07:05', NULL, NULL, NULL, 0, 0, 0, 0, 'jk~|Aw~flDr@jDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F
\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '
2021-12-12 22:07:05
', '2021-12-12 22:07:29
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1478, 'KWD350774', 289, 0, 134, 1, 7288, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.80, 57.53, '', 'Unnamed Road, Lusaka, Zambia', -15.39811390, 28.38533094, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '
2021-12-12 22:08:01
', NULL, NULL, NULL, 0, 0, 0, 0, 'jk~|Aw~flDr@jDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-12 22:08:01', '2021-12-12 22:08:14', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1479, 'KWD434183', 289, 0, 97, 1, 3575, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.80, 57.56, '', 'Unnamed Road, Lusaka, Zambia', -15.39809030, 28.38535030, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-12 22:12:41', NULL, NULL, NULL, 0, 0, 0, 0, 'jk~|A{~flDr@nDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F
\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '
2021-12-12 22:11:29
', '2021-12-12 22:13:40
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1480, 'KWD325396', 289, 0, 134, 1, 4087, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.80, 57.58, '', 'Unnamed Road, Lusaka, Zambia', -15.39805034, 28.38535773, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '
2021-12-12 22:13:57
', NULL, NULL, NULL, 0, 0, 0, 0, 'hk~|A__glDt@rDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-12 22:13:57', '2021-12-12 22:14:26', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1481, 'KWD896700', 289, 135, 135, 1, 3234, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 5.80, 57.58, '', 'Unnamed Road, Lusaka, Zambia', -15.39805034, 28.38535773, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-12 22:23:09', NULL, '2021-12-12 22:24:23', '2021-12-12 22:29:55', 1, 1, 0, 0, 'hk~|A__glDt@rDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F
\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '
2021-12-12 22:23:09
', '2021-12-12 22:30:34
', 'NO', '
5', 0.00000000, 0.00000000, 0.00000000),
(1482, 'KWD633078', 291, 0, 134, 1, 9821, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.47, 54.18, '', 'Unnamed Road, Lusaka, Zambia', -15.39816830, 28.38532310, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '
2021-12-12 22:31:21
', NULL, NULL, NULL, 0, 0, 0, 0, 'bm~|AkaglDkAPe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-12 22:31:12', '2021-12-12 22:31:57', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1483, 'KWD348405', 291, 0, 134, 1, 2565, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.79, 57.51, '', 'Unnamed Road, Lusaka, Zambia', -15.39813930, 28.38532210, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-12 22:35:25', NULL, NULL, NULL, 0, 0, 0, 0, 'lk~|As~flDp@fDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F
\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '
2021-12-12 22:35:14
', '2021-12-12 22:36:02
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1484, 'KWD879098', 291, 0, 123, 1, 5362, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.79, 57.51, '', 'Unnamed Road, Lusaka, Zambia', -15.39815780, 28.38532170, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '
2021-12-12 22:40:20
', NULL, NULL, NULL, 0, 0, 0, 0, 'lk~|As~flDp@fDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-12 22:40:20', '2021-12-12 22:41:30', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1485, 'KWD919246', 291, 0, 134, 1, 2666, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.79, 57.51, '', 'Unnamed Road, Lusaka, Zambia', -15.39815108, 28.38532187, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-12 22:41:19', NULL, NULL, NULL, 0, 0, 0, 0, 'lk~|As~flDp@fDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F
\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '
2021-12-12 22:41:19
', '2021-12-12 22:42:17
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1486, 'KWD501929', 291, 123, 123, 1, 3210, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 20.13, 202.41, '', 'Unnamed Road, Lusaka, Zambia', -15.39813710, 28.38534575, 'Makeni Mall, Makeni, T2, Lusaka, Zambia', -15.45381920, 28.26621590, '
2021-12-12 22:44:09
', NULL, '2021-12-12 22:44:45
', '2021-12-12 22:45:19
', 1, 1, 0, 0, '~l~|AiaglDgANe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@{CdPEJWR[B[?aA@I@KHGHE^w@`CmEzMkGhRwF|PyAjEK\\W\\_@RUPBHfB`KbBtI~@bE~@~CtGpRLXJJf@f@HJN^B`@DbA|@xCr@jC|@jE|DtT|B|M|B`LpCjOxFn
\\d@hCNf@T~AZzADt@Fl@NZDBJJJPBXARAFEFBJHf@Jb@
\\vAX|AbArFPbAXnCPpDCxDWzK[nPMvGAjBJrC~@vJz@bJb@~EVlDh@zFZrE^zDR|AP~@p@|Cb@pAh@tApAnCd@z@pArBbBvBrFnGtB|BRVpNzP~EbGzJtLX
\\d@h@PT|AlB`CvCtEpFnA|AvAzAv@fArBfCjBzBzAhBzBhDV`@vAdD|@rC^bBd@rCj@zGn@tH`AjMp@bIpBxUhAzMv@`GTvBPfCPzBh@hGHb@F@LFDDv@S`Dc@lGi@xJ_AfSgBlSmB`Q_BlK}@f@KTIBITWNGTAPHNLFJ@DJAhFe@fBQr@Cv@AhBBpAPlBb@v@TdAh@|Ax@~@v@|@`Ap@bA|@bBjBpEl@rA`@j@f@r@|@~@t@n@r@f@pB`A|YzLxJ`E|ErBbCbAbEnBrElBtMtFrLbFvNhGnCpAtCnA|E|B`Ab@Wb@CTEd@@\\CPIFs@DMDAFDp@@b@', NULL, '2021-12-12 22:44:09', '2021-12-12 22:45:37', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1487, 'KWD668178', 291, 134, 134, 1, 9010, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 5.46, 54.14, '', 'Unnamed Road, Lusaka, Zambia', -15.39812580, 28.38535190, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-12 22:46:33', NULL, '2021-12-12 22:47:09', '2021-12-12 22:47:52', 1, 1, 0, 0, '|l~|AiaglDeANe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '
2021-12-12 22:46:33
', '2021-12-12 22:48:57
', 'NO', '
0', 0.00000000, 0.00000000, 0.00000000),
(1488, 'KWD639736', 291, 134, 134, 1, 6676, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 5.46, 104.81, '', 'Unnamed Road, Lusaka, Zambia', -15.39812360, 28.38533700, 'Woodlands Mall, Chindo Rd, Lusaka, Zambia', -15.43605270, 28.34142110, '
2021-12-12 22:49:21
', NULL, '2021-12-12 22:50:16
', '2021-12-12 22:51:01
', 1, 1, 0, 0, 'zl~|AiaglDbC[a@mCjCc@YgBa@iC_@}BaAaG_@cCn@WvCmA@wH?{BAyCd@Ap@COoAACdCYzIeAzDe@zAWzB|D|HzLzDnGlCxEzGnKbCtDd@v@d@v@hAfBx@nALRFTRl@b@rAjArDPj@Tj@J^Bd@Ab@MhAOfAUfAQfAa@|Bg@nCEb@A`@@THb@R^VZf@p@xAlAlB|AV\\T\\^`At@tBt@tBpAxDRx@X~@n@`Cp@~Bb@|BF^t@~F~Ks@pG[d@L|@RN@tASh@Bv@JlKtBdKpBxCTpCh@xKvBbEv@`HfArARALCXEXIt@WrBUjBc@hEmArJq@zF{@~G_@vCMjAGd@c@fEi@`EQxBi@rEeChRG`@M`A[fCw@bGu@jGM`A{ChVeAfIbBRtFv@jJlAvEp@bAj@~G|DrAh@dAZzA
\\t@NvCNlA?pBGtAKxAW`C]Os@@k@', NULL, '2021-12-12 22:49:21', '2021-12-12 22:51:32', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1489, 'KWD471430', 291, 134, 134, 1, 4244, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 10.47, 104.81, '', 'Unnamed Road, Lusaka, Zambia', -15.39812910, 28.38533220, 'Woodlands Mall, Chindo Rd, Lusaka, Zambia', -15.43605270, 28.34142110, '2021-12-12 22:51:53', NULL, '2021-12-12 22:52:29', '2021-12-12 22:53:31', 1, 1, 0, 0, 'zl~|AiaglDbC[a@mCjCc@YgBa@iC_@}BaAaG_@cCn@WvCmA@wH?{BAyCd@Ap@COoAACdCYzIeAzDe@zAWzB|D|HzLzDnGlCxEzGnKbCtDd@v@d@v@hAfBx@nALRFTRl@b@rAjArDPj@Tj@J^Bd@Ab@MhAOfAUfAQfAa@|Bg@nCEb@A`@@THb@R^VZf@p@xAlAlB|AV
\\T
\\^`At@tBt@tBpAxDRx@X~@n@`Cp@~Bb@|BF^t@~F~Ks@pG[d@L|@RN@tASh@Bv@JlKtBdKpBxCTpCh@xKvBbEv@`HfArARALCXEXIt@WrBUjBc@hEmArJq@zF{@~G_@vCMjAGd@c@fEi@`EQxBi@rEeChRG`@M`A[fCw@bGu@jGM`A{ChVeAfIbBRtFv@jJlAvEp@bAj@~G|DrAh@dAZzA\\t@NvCNlA?pBGtAKxAW`C]Os@@k@', NULL, '
2021-12-12 22:51:53
', '2021-12-12 22:53:47
', 'NO', '
1', 0.00000000, 0.00000000, 0.00000000),
(1490, 'KWD566827', 291, 134, 134, 1, 4521, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 8.94, 89.32, '', 'Unnamed Road, Lusaka, Zambia', -15.39812960, 28.38533320, 'Munali Mall, 12th St, Lusaka, Zambia', -15.37214580, 28.34515770, '
2021-12-12 22:54:34
', NULL, '2021-12-12 22:54:54
', '2021-12-12 22:55:02
', 1, 1, 0, 0, 'jk~|Aw~flDr@jDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP
\\LHJNDXAVGPSRYFQCOImA
\\GDI@Q@a@CiC_@cEm@{LcByJoAsGw@_Gy@WE[Ew@Kw@KoBWqBW}Eo@w@M[EkDe@Eb@ShBq@I', NULL, '
2021-12-12 22:54:34
', '2021-12-12 22:55:19
', 'NO', '
0', 0.00000000, 0.00000000, 0.00000000),
(1491, 'KWD173655', 291, 134, 134, 1, 7522, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 6.93, 68.97, '', 'Unnamed Road, Lusaka, Zambia', -15.39813410, 28.38533100, 'Fig Tree Office Park, 2, Lusaka, Zambia', -15.41776880, 28.35322590, '
2021-12-12 22:56:19
', NULL, '2021-12-12 22:56:57
', '2021-12-12 23:00:47
', 1, 1, 0, 0, '|l~|AiaglD`C[a@mCjCc@YgBa@iC_@}BaAaG_@cCn@WvCmA@wH?{BAyCd@Ap@COoAACdCYzIeAzDe@zAWzB|D|HzLzDnGlCxEzGnKbCtDd@v@d@v@hAfBx@nALRFTRl@b@rAjArDPj@Tj@J^Bd@Ab@MhAOfAUfAQfAa@|Bg@nCEb@A`@@THb@R^VZf@p@xAlAlB|AV
\\T
\\^`At@tBt@tBpAxDRx@X~@n@`Cp@~Bb@|BjC`SVzAb@jCDVHPLNbIxGjBbBaBvBwCvDmBfCGLAVFb@rB`I~A`HMPGRGpBELIFKBQ?eBKUbJH?JB|@@VFHHDN?`@Q|D@d@TTNNZf@ZvBn@zFLv@L`A', NULL, '2021-12-12 22:56:07', '2021-12-12 23:01:22', 'NO', '3', 0.00000000, 0.00000000, 0.00000000),
(1492, 'KWD807499', 289, 0, 135, 1, 6825, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 9.81, 98.11, '', 'Unnamed Road, Lusaka, Zambia', -15.39809650, 28.38529780, 'EastPark Mall, Corner of Great East andThabo Mbeki Rds, Lusaka, Zambia', -15.39038920, 28.32219410, '2021-12-12 23:13:18', NULL, NULL, NULL, 0, 0, 0, 0, 'lk~|Aq~flDp@dDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb
\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H
\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zER`CPL
\\\\LR~@C?A?A?C@ADELELDDNCLMFOCACu@dB?f@HlAPfBZrC@?@AB@DB?HFDdAn@TTr@l@VRdAsA', NULL, '
2021-12-12 23:13:18
', '2021-12-12 23:14:01
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1493, 'KWD290450', 291, 135, 135, 1, 6610, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 9.80, 98.02, '', 'Unnamed Road, Lusaka, Zambia', -15.39816240, 28.38522730, 'EastPark Mall, Corner of Great East andThabo Mbeki Rds, Lusaka, Zambia', -15.39038920, 28.32219410, '
2021-12-12 23:14:51
', NULL, '2021-12-12 23:15:35
', '2021-12-12 23:16:04
', 1, 1, 0, 0, 'pk~|Aa~flDl@tCeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP
\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zER`CPL\\\\LR~@C?A?A?C@ADELELDDNCLMFOCACu@dB?f@HlAPfBZrC@?@AB@DB?HFDdAn@TTr@l@VRdAsA', NULL, '2021-12-12 23:14:51', '2021-12-12 23:16:56', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1494, 'KWD604667', 289, 135, 135, 1, 8023, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 14.66, 147.16, '', 'Unnamed Road, Lusaka, Zambia', -15.39808920, 28.38529370, 'Mandevu, Mandevu, Lusaka, Zambia', -15.35726830, 28.31112620, '2021-12-12 23:24:31', NULL, '2021-12-12 23:25:27', '2021-12-12 23:25:37', 1, 1, 0, 0, 'lk~|Aq~flDp@dDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb
\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H
\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zEBD^tCj@rE|@bEl@rBZt@Xd@F@RFNLJPD`@I\\QNQF]CICe@H_@DyIrGoBvBU\\CAUQg@Ua@Mi@I}@G_A@cB^iBp@gBr@k@Nk@Jy@AiAK_QuBoa@eFkASsAWcCk@qD_AiCeAsCgAaN_Fw@SuFiA]I_@IQCA|Gy@DcJrDuF~B_Af@YKoAOu@@WEa@Qg@g@CROv@eAdDGJOJKFeBj@oH`CGAz@`Dz@~Cp@~BEXa@tCEFoFjBS?i@S_Bo@_@lAHx@', NULL, '2021-12-12 23:24:31', '2021-12-12 23:26:00', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1495, 'KWD734418', 289, 123, 123, 1, 7102, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 9.93, 99.25, '', 'Unnamed Road, Lusaka, Zambia', -15.39810290, 28.38539570, 'SunShare Tower, Lusaka, Zambia', -15.38825950, 28.31652130, '2021-12-12 23:27:00', NULL, '2021-12-12 23:27:39', '2021-12-12 23:29:20', 1, 1, 0, 0, 'xl~|AiaglDaANe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@{CdPEJWR[B[?aA@I@KHGHE^w@`CmEzMkGhRwF|PyAjEK
\\W
\\_@RUPBHfB`KbBtI~@bE~@~CtGpRLXJJf@f@HJN^B`@DbA|@xCr@jC|@jE|DtT|B|M|B`LpCjOxFn\\d@hCNf@T~AZzADt@Fl@NZDBJJJPBXARAFEFBJHf@Jb@\\vAX|AbArFPbAXnCPpDCxDWzK[nPMvGAjBJrC~@vJz@bJb@~EVlDh@zFRdC@Bj@tER~AHp@t@jDb@`B^dATd@RXHBXJJNHR@ZCLINSNUB]Gs@LQ@IF_EtCp@dA', NULL, '
2021-12-12 23:27:00
', '2021-12-12 23:29:42
', 'NO', '
1', 0.00000000, 0.00000000, 0.00000000),
(1496, 'KWD106576', 291, 123, 123, 1, 2240, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 11.85, 118.75, '', 'Unnamed Road, Lusaka, Zambia', -15.39813710, 28.38532800, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '
2021-12-12 23:30:23
', NULL, '2021-12-12 23:30:59
', '2021-12-12 23:33:46
', 1, 1, 0, 0, 'lk~|Au~flDp@hDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP
\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zE@P\\hELjAJf@x@lE\\lAh@zAnApCx@xAb@x@hBfCnGrH|B`CT
\\|HnJjFfGhMrO~AnBOLsCkDYBSF]X[RG?KGQ_@CGUPCB?DDJxB`CvAdB', NULL, '2021-12-12 23:30:23', '2021-12-12 23:34:10', 'NO', '2', 0.00000000, 0.00000000, 0.00000000),
(1497, 'KWD942965', 289, 123, 123, 1, 4891, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 5.47, 54.24, '', 'Unnamed Road, Lusaka, Zambia', -15.39817810, 28.38553670, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-13 01:30:53', NULL, '2021-12-13 01:31:30', '2021-12-13 01:32:07', 1, 1, 0, 0, 'lm~|AmaglDuARe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '
2021-12-13 01:30:53
', '2021-12-13 01:32:49
', 'NO', '
0', 0.00000000, 0.00000000, 0.00000000),
(1498, 'KWD906760', 289, 0, 134, 1, 9114, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.79, 57.45, '', 'Unnamed Road, Lusaka, Zambia', -15.39814330, 28.38526360, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '
2021-12-13 01:49:10
', NULL, NULL, NULL, 0, 0, 0, 0, 'nk~|Ai~flDn@|CeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-13 01:49:10', '2021-12-13 01:49:42', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1499, 'KWD276658', 289, 0, 134, 1, 2640, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 14.36, 144.10, '', 'Unnamed Road, Lusaka, Zambia', -15.39812900, 28.38531100, 'Waterworks Plaza, Lusaka, Zambia', -15.45537210, 28.32083630, '2021-12-13 01:53:26', NULL, NULL, NULL, 0, 0, 0, 0, 'lk~|As~flDp@fDHKdBqBxDq@YiC_@}B_@{BaAgGaAaG_@cCn@WvCmA@wH?{BAyCd@Ap@COoAACdCYzIeAzDe@zAWzB|D|HzLzDnGlCxEzGnKtCpEd@v@nAnBx@nAZf@Pl@b@rAjArDf@vATt@Bd@Ab@MhAOfAUfA_@|Bg@nCSfAEb@A`@@THb@R^VZf@p@`@\\nB|At@n@V\\T\\^`A^bAl@bBnB|F`@xAn@~Bp@`Cf@|BN~@t@~F~Ks@pG[d@L|@RN@tASh@Bv@JlKtBdKpBxCTpCh@xKvBbEv@`HfArARALCXEXIt@Ir@WtBe@hEg@hEk@nEY|BY|By@zG_@vCMjAGf@CPc@fEi@`EQxBi@rE~RfCzC`@~Fn@xIpAr@PpClAx@ZxBfAbBx@xAj@bDxAbAz@^f@bGjHn@n@d@RfA^RHr@p@f@l@Zr@Zv@`A`ChG~OrAbDsGpCeGjCJ|@N|Cf@rJbCvh@lBv`@X~FDzAn@BnA@v@@tAElAIh@IfB]~@Ur@Wn@Uj@_@p@Yp@UjBY[jCo@~BEPD@JBVFjBj@`EpAjB|@fA~@hAxAXb@j@jAzCvC|AfBfBxBnC|C`ApA|AsE
\\R~@l@z@r@|BrA~@h@', NULL, '
2021-12-13 01:53:26
', '2021-12-13 01:54:16
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1500, 'KWD289908', 291, 0, 134, 1, 6390, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 8.61, 85.95, '', 'Unnamed Road, Lusaka, Zambia', -15.39816440, 28.38532330, 'Munali Mall, 12th St, Lusaka, Zambia', -15.37214580, 28.34515770, '
2021-12-13 01:58:55
', NULL, NULL, NULL, 0, 0, 0, 0, 'bm~|AkaglDkAPe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@{CdPEJWR[B[?aA@I@KHGHE^w@`CmEzMkGhRwF|PyAjEK\\W\\_@RUPBHfB`KbBtI~@bE~@~CtGpRLXJJf@f@HJN^B`@DbA|@xCr@jC|@jE|DtT|B|M|B`LpCjOxFn
\\d@hCNf@T~AZzADt@Fl@NZDBJJJPBXARKTUPWBQGGCCAgAXKHI@S@gAMkIkAoOwBgKoAqKuAw@KmBWaFq@_Fo@u@KaEk@YlCq@I', NULL, '
2021-12-13 01:58:55
', '2021-12-13 01:59:03
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1501, 'KWD961004', 291, 0, 134, 1, 3775, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 15.35, 200.32, '', 'Unnamed Road, Lusaka, Zambia', -15.39810638, 28.38527848, 'Kenneth Kaunda International Airport, Lusaka ZM ZM, Lusaka 10101, Zambia', -15.32539090, 28.44911240, '
2021-12-13 02:00:19
', NULL, NULL, NULL, 0, 0, 0, 0, 'nk~|Am~flDn@`DeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F
\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@kCy@iASwAc@eFeCoKiFwE}BcD}A{JyE{J}EcI{D_LsF_FaC_GwC_LuFmX_NaGuCoBaAcCeAcA[eAWgAQw@IqCQsCMqH]gOo@mDScEOeOs@_c@mBeU_AyFWkC_@WG}Ac@gAc@c@Q{@i@QM{AeAu@u@o@m@Yc@s@cA{@iBs@qBUw@Mw@[yCG{A@oA`AqXrGwbB^mJJuCFu@FaAEUGUAOPc@Ho@?O`@wJFeBPCdGZdHVbFVxBH', NULL, '
2021-12-13 02:00:19
', '2021-12-13 02:00:54
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1502, 'KWD785925', 291, 0, 134, 1, 3326, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.79, 57.47, '', 'Unnamed Road, Lusaka, Zambia', -15.39811659, 28.38527396, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '
2021-12-13 02:01:57
', NULL, NULL, NULL, 0, 0, 0, 0, 'nk~|Am~flDn@`DeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F
\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '
2021-12-13 02:01:57
', '2021-12-13 02:02:15
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1503, 'KWD105488', 291, 0, 134, 1, 7870, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.79, 57.46, '', 'Unnamed Road, Lusaka, Zambia', -15.39811951, 28.38527004, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '
2021-12-13 02:04:56
', NULL, NULL, NULL, 0, 0, 0, 0, 'nk~|Ak~flDn@~CeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-13 02:04:56', '2021-12-13 02:06:07', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1504, 'KWD649766', 289, 0, 134, 1, 8294, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 9.48, 94.78, '', 'Unnamed Road, Lusaka, Zambia', -15.39816440, 28.38532330, 'EastPark Mall, Corner of Great East andThabo Mbeki Rds, Lusaka, Zambia', -15.39038920, 28.32219410, '2021-12-13 02:13:25', NULL, NULL, NULL, 0, 0, 0, 0, 'bm~|AkaglDkAPe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@{CdPEJWR[B[?aA@I@KHGHE^w@`CmEzMkGhRwF|PyAjEK
\\W
\\_@RUPBHfB`KbBtI~@bE~@~CtGpRLXJJf@f@HJN^B`@DbA|@xCr@jC|@jE|DtT|B|M|B`LpCjOxFn\\d@hCNf@T~AZzADt@Fl@NZDBJJJPBXARAFEFBJHf@Jb@\\vAX|AbArFPbAXnCPpDCxDWzK[nPMvGAjBJrC~@vJz@bJb@~EFz@HDRT^b@~@C?C@GDENCJFDLELMFMEq@pAG`@HpA
\\nDP~A@A@?B@DB?HVNt@d@RRPLz@t@dAsA', NULL, '
2021-12-13 02:13:25
', '2021-12-13 02:13:36
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1505, 'KWD412459', 289, 0, 134, 1, 1233, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.78, 57.40, '', 'Unnamed Road, Lusaka, Zambia', -15.39813390, 28.38521270, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '
2021-12-13 02:37:14
', NULL, NULL, NULL, 0, 0, 0, 0, 'rk~|A_~flDj@rCeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-13 02:37:14', '2021-12-13 02:37:22', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000);
INSERT INTO `user_requests` (`id`, `booking_id`, `user_id`, `provider_id`, `current_provider_id`, `service_type_id`, `otp`, `returntrip`, `status`, `cancelled_by`, `cancel_reason`, `payment_mode`, `paid`, `distance`, `amount`, `specialNote`, `s_address`, `s_latitude`, `s_longitude`, `d_address`, `d_latitude`, `d_longitude`, `assigned_at`, `schedule_at`, `started_at`, `finished_at`, `user_rated`, `provider_rated`, `use_wallet`, `surge`, `route_key`, `deleted_at`, `created_at`, `updated_at`, `is_track`, `travel_time`, `track_distance`, `track_latitude`, `track_longitude`) VALUES
(1506, 'KWD540847', 291, 0, 134, 1, 9333, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 7.64, 76.15, '', 'Unnamed Road, Lusaka, Zambia', -15.39816440, 28.38532360, 'Liebherr Zambia Ltd, 175 Kudu Rd, Lusaka, Zambia', -15.41049910, 28.34952650, '2021-12-13 06:46:04', NULL, NULL, NULL, 0, 0, 0, 0, 'bm~|AkaglDzBYa@mCjCc@YgBa@iC_@}BaAaG_@cCn@WvCmA@wH?{BAyCd@Ap@COoAACdCYzIeAzDe@zAWzB|D|HzLzDnGlCxEzGnKbCtDd@v@d@v@hAfBx@nALRFTRl@b@rAjArDPj@Tj@J^Bd@Ab@MhAOfAUfAQfAa@|Bg@nCEb@A`@@THb@R^VZf@p@xAlAlB|AV
\\T
\\^`At@tBt@tBpAxDRx@X~@n@`Cp@~Bb@|BjC`SVzAb@jCDVHPLNbIxGjBbBaBvBwCvDmBfCGLAVFb@rB`I~A`HMPGRGpBELIFKBQ?eBKUbJH?JB|@@VFHHDN?`@Q|D@d@QPuFrEwFdEyHdG}CxBw@d@q@^_Bp@o@PNjAv@~F', NULL, '
2021-12-13 06:46:04
', '2021-12-13 06:46:10
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1507, 'KWD978475', 291, 0, 135, 1, 8831, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.79, 57.48, '', 'Unnamed Road, Lusaka, Zambia', -15.39811470, 28.38528560, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '
2021-12-13 06:46:57
', NULL, NULL, NULL, 0, 0, 0, 0, 'lk~|Ao~flDp@bDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-13 06:46:57', '2021-12-13 06:47:19', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1508, 'KWD506581', 289, 0, 134, 1, 6431, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 7.64, 76.19, '', 'Unnamed Road, Lusaka, Zambia', -15.39811360, 28.38539400, 'Liebherr Zambia Ltd, 175 Kudu Rd, Lusaka, Zambia', -15.41049910, 28.34952650, '2021-12-13 06:51:17', NULL, NULL, NULL, 0, 0, 0, 0, 'zl~|AiaglDbC[a@mCjCc@YgBa@iC_@}BaAaG_@cCn@WvCmA@wH?{BAyCd@Ap@COoAACdCYzIeAzDe@zAWzB|D|HzLzDnGlCxEzGnKbCtDd@v@d@v@hAfBx@nALRFTRl@b@rAjArDPj@Tj@J^Bd@Ab@MhAOfAUfAQfAa@|Bg@nCEb@A`@@THb@R^VZf@p@xAlAlB|AV
\\T
\\^`At@tBt@tBpAxDRx@X~@n@`Cp@~Bb@|BjC`SVzAb@jCDVHPLNbIxGjBbBaBvBwCvDmBfCGLAVFb@rB`I~A`HMPGRGpBELIFKBQ?eBKUbJH?JB|@@VFHHDN?`@Q|D@d@QPuFrEwFdEyHdG}CxBw@d@q@^_Bp@o@PNjAv@~F', NULL, '
2021-12-13 06:51:17
', '2021-12-13 06:51:45
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1509, 'KWD313017', 289, 0, 135, 1, 5541, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 11.52, 115.38, '', 'Unnamed Road, Lusaka, Zambia', -15.39814960, 28.38534470, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '
2021-12-13 06:55:17
', NULL, NULL, NULL, 0, 0, 0, 0, '`m~|AiaglDiANe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@{CdPEJWR[B[?aA@I@KHGHE^w@`CmEzMkGhRwF|PyAjEK
\\W
\\_@RUPBHfB`KbBtI~@bE~@~CtGpRLXJJf@f@HJN^B`@DbA|@xCr@jC|@jE|DtT|B|M|B`LpCjOxFn\\d@hCNf@T~AZzADt@Fl@NZDBJJJPBXARAFEFBJHf@Jb@\\vAX|AbArFPbAXnCPpDCxDWzK[nPMvGAjBJrC~@vJz@bJb@~EVlDh@zFZrE^zDR|AP~@p@|Cb@pAh@tApAnCd@z@pArBbBvBrFnGtB|BRVpNzP~EbGzJtLOLsCkDg@Fq@h@IFI?OKSc@YV?F~BhCvAdB', NULL, '2021-12-13 06:53:46', '2021-12-13 06:55:37', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1510, 'KWD274421', 289, 0, 134, 1, 8107, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.79, 57.44, '', 'Unnamed Road, Lusaka, Zambia', -15.39810880, 28.38524460, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-13 07:05:20', NULL, NULL, NULL, 0, 0, 0, 0, 'pk~|Ag~flDl@zCeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F
\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '
2021-12-13 07:05:20
', '2021-12-13 07:05:49
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1511, 'KWD693323', 243, 0, 96, 1, 8250, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 6.31, 62.73, '', 'G7XW+RPP, Lusaka, Zambia', -15.45152460, 28.29758270, 'Woodlands Mall, Chindo Rd, Lusaka, Zambia', -15.43605270, 28.34142110, '
2021-12-13 11:09:28
', NULL, NULL, NULL, 0, 0, 0, 0, 'fyh}AszukDCs@FWf@eANa@iBw@kC}@aBg@sAg@Cc@[_CCUAEAKEUCYEo@Cq@G}B?_@?OAy@Cc@e@wBUkCGgAWqB_@mCgABqDL_HTSCMGg@a@e@a@_BqBa@g@a@a@IGQOQO_@a@]e@}A_B_HoHy@}@u@cAMOQKa@Ya@We@Uc@SSGIECALYx@{BdBmEf@sA~B{HzC}JbEcN`Ko\\gBu@cBe@wGqBsAs@iC}@pAoEX_B@a@GyC]iHgEg|@yDPoA_@{@a@gD}AeGgDyAs@U[KUc@WG?UCWQe@CWCYDWDEWIo@@W', NULL, '2021-12-13 11:09:28', '2021-12-13 11:09:35', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1512, 'KWD748761', 289, 0, 135, 1, 5531, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 10.86, 108.74, '', '175 Kudu Rd, Lusaka, Zambia', -15.41008400, 28.34931800, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-13 13:00:57', NULL, NULL, NULL, 0, 0, 0, 0, 'zu`}As``lDUAcALq@TOuA_@{BMiASAwBDCRXtJl@bQ@^A?}ANeC^_BRyB
\\mJtAeCZ`@dCFdAIpDEvCKdDO~CkBIOp@_BnG_AOkAKcLaBaB_@sAq@q@Wk@Os@MyDk@mIoA_LaBwGeAiDm@eF_AiFaAcBUi@CE?SKyAMc@Oi@[UKUEMDWHYLKTUPWBQGOKKQGYD_@FMJo@Do@Cg@W{Ac@iCkAmGq@cEqAkHuAwHkA_HwAcIo@uCi@yBSk@Oe@k@wBo@wCu@eEaB}IeCgNMa@o@gCw@cCc@o@UOKGIKK_@EcB{D_MoCsI_@iBmBmKUkAgB{JuAoHa@cDaAuNKmBg@_HS}Ao@oEiAaFaCuIaBoIqAoHcB{KiAoHeAcHuAoIaAcHg@_Du@}EoB}L]iBUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-13 13:00:57', '2021-12-13 13:01:38', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1513, 'KWD798589', 289, 0, 135, 1, 4982, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 11.05, 110.66, '', '175 Kudu Rd, Lusaka, Zambia', -15.41027120, 28.34922870, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-13 14:46:43', NULL, NULL, NULL, 0, 0, 0, 0, 'j|`}Am~_lDpArJxA~LBT_@BoDd@}Fv@sC`@`ClMlAvGRhABh@Gf@YfAo@fCu@dDShAcH_AgFs@kBUu@Gs@?oABu@EqC]mAUcG}@kAKoG_AsCa@aB_@sAq@q@Wk@Os@MyDk@iRqC{KeBoKmBiFaAcBUi@CIAOIk@Em@Gc@O_Ag@UEMDWHYLAFSVYJSCOGMOIUA]J]Jo@Do@Cg@W{Ac@iCkAmGq@cEqAkHaDwQwAcIo@uCi@yBSk@Oe@k@wBo@wCu@eEaB}IeCgNMa@o@gCw@cCc@o@a@WOWESEcBkIsWcAgF_B{IgB{JuAoHa@cDu@}KWeEg@_HS}Ao@oEiAaFaCuIaBoIqAoHcB{KiAoHeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '
2021-12-13 14:46:43
', '2021-12-13 14:47:10
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1514, 'KWD645983', 289, 0, 97, 1, 6326, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.39, 53.40, '', 'Honeybed lodge, 24 Olive Road, Salama Park Lusaka ZM, Lusaka 10101, Zambia', -15.39749760, 28.38583280, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '
2021-12-13 14:49:05
', NULL, NULL, NULL, 0, 0, 0, 0, 'dj~|AwbglDcAeFWqAyBd@eAH_CEgC?wA?kC@yD?aM?mCASCSKa@[]Og@Gc@@gETcIXwGR{DLeABDW`BgJpAaH\\qBz@aFLaA?_@E?Y@gFeA_GoAeH_BqCa@aG_AcDo@y@Ow@Iy@?oBBw@J[FKBsBr@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EoB}L]iBUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-13 14:47:52', '2021-12-13 14:49:43', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1515, 'KWD760671', 289, 123, 123, 1, 3753, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 5.79, 57.50, '', 'Unnamed Road, Lusaka, Zambia', -15.39814700, 28.38531220, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-13 17:01:14', NULL, '2021-12-13 17:02:07', '2021-12-13 17:02:12', 1, 1, 0, 0, 'lk~|Aq~flDp@dDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F
\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '
2021-12-13 17:01:14
', '2021-12-13 17:02:31
', 'NO', '
0', 0.00000000, 0.00000000, 0.00000000),
(1516, 'KWD953173', 289, 0, 134, 1, 6044, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 14.15, 141.94, '', 'Unnamed Road, Lusaka, Zambia', -15.39810750, 28.38541730, 'Waterworks Plaza, Lusaka, Zambia', -15.45537210, 28.32083630, '
2021-12-13 17:12:36
', NULL, NULL, NULL, 0, 0, 0, 0, 'zl~|AiaglDbC[a@mCjCc@YgBa@iC_@}BaAaG_@cCn@WvCmA@wH?{BAyCd@Ap@COoAACdCYzIeAzDe@zAWzB|D|HzLzDnGlCxEzGnKbCtDd@v@d@v@hAfBx@nALRFTRl@b@rAjArDPj@Tj@J^Bd@Ab@MhAOfAUfAQfAa@|Bg@nCEb@A`@@THb@R^VZf@p@xAlAlB|AV\\T\\^`At@tBt@tBpAxDRx@X~@n@`Cp@~Bb@|BF^t@~F~Ks@pG[d@L|@RN@tASh@Bv@JlKtBdKpBxCTpCh@xKvBbEv@`HfArARALCXEXIt@WrBUjBc@hEmArJq@zF{@~G_@vCMjAGd@c@fEi@`EQxBi@rE~RfCzC`@~Fn@xIpAr@PpClAx@ZxBfAbBx@xAj@bDxAbAz@^f@bGjHn@n@d@RfA^RHr@p@f@l@Zr@Zv@`A`ChG~OrAbDsGpCeGjCJ|@N|Cf@rJbCvh@lBv`@X~FDzAn@BnA@v@@tAElAIh@IfB]~@Ur@Wn@Uj@_@p@Yp@UjBY[jCo@~BEPD@D@JBVFdBh@`EpAjB|@fA~@hAxAXb@j@jAzCvC|AfBfBxBnC|C`ApA|AsE\\R~@l@z@r@|BrA~@h@', NULL, '2021-12-13 17:12:36', '2021-12-13 17:12:50', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1517, 'KWD202045', 289, 123, 123, 1, 9038, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 6.79, 67.51, '', 'Unnamed Road, Lusaka, Zambia', -15.39808950, 28.38535550, 'Hilltop Hospital, Kabulonga Rd, Lusaka, Zambia', -15.42010520, 28.35733490, '2021-12-13 17:22:02', NULL, '2021-12-13 17:22:43', '2021-12-13 17:23:08', 1, 1, 0, 0, 'tl~|AgaglDhC]a@mCjCc@YgBa@iC_@}BaAaG_@cCn@WvCmA@wH?{BAyCd@Ap@COoAACdCYzIeAzDe@zAWzB|D|HzLzDnGlCxEzGnKbCtDd@v@d@v@hAfBx@nALRFTRl@b@rAjArDPj@Tj@J^Bd@Ab@MhAOfAUfAQfAa@|Bg@nCEb@A`@@THb@R^VZf@p@xAlAlB|AV
\\T
\\^`At@tBt@tBpAxDRx@X~@n@`Cp@~Bb@|BjC`SVzAb@jCDVHPLNbIxGjBbBaBvBwCvDmBfCGLAVFb@rB`I~A`HdDvMRl@TPRDx@QzCy@v@Md@@t@NtBX`@VLTDT@bAw@CoAY', NULL, '
2021-12-13 17:22:02
', '2021-12-13 20:12:39
', 'NO', '
0', 0.00000000, 0.00000000, 0.00000000),
(1518, 'KWD638352', 291, 0, 135, 1, 8913, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.47, 54.18, '', 'Unnamed Road, Lusaka, Zambia', -15.39816490, 28.38532380, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '
2021-12-13 20:16:42
', NULL, NULL, NULL, 0, 0, 0, 0, 'bm~|AkaglDkAPe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-13 20:16:42', '2021-12-13 20:16:51', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1519, 'KWD864253', 291, 0, 134, 1, 6494, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.80, 57.54, '', 'Unnamed Road, Lusaka, Zambia', -15.39809750, 28.38533600, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-13 20:17:46', NULL, NULL, NULL, 0, 0, 0, 0, 'jk~|Ay~flDr@lDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F
\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '
2021-12-13 20:17:46
', '2021-12-13 20:18:53
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1520, 'KWD722892', 291, 134, 134, 1, 9539, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 5.46, 54.15, '', 'Unnamed Road, Lusaka, Zambia', -15.39813790, 28.38534440, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '
2021-12-13 20:19:33
', NULL, '2021-12-13 20:21:34
', '2021-12-13 20:22:26
', 1, 1, 0, 0, '~l~|AiaglDgANe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-13 20:19:33', '2021-12-13 20:28:58', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1521, 'KWD755660', 289, 0, 134, 1, 2582, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 14.15, 141.96, '', 'Unnamed Road, Lusaka, Zambia', -15.39810970, 28.38533550, 'Waterworks Plaza, Lusaka, Zambia', -15.45537210, 28.32083630, '2021-12-13 20:30:13', NULL, NULL, NULL, 0, 0, 0, 0, 'xl~|AiaglDdC[a@mCjCc@YgBa@iC_@}BaAaG_@cCn@WvCmA@wH?{BAyCd@Ap@COoAACdCYzIeAzDe@zAWzB|D|HzLzDnGlCxEzGnKbCtDd@v@d@v@hAfBx@nALRFTRl@b@rAjArDPj@Tj@J^Bd@Ab@MhAOfAUfAQfAa@|Bg@nCEb@A`@@THb@R^VZf@p@xAlAlB|AV
\\T
\\^`At@tBt@tBpAxDRx@X~@n@`Cp@~Bb@|BF^t@~F~Ks@pG[d@L|@RN@tASh@Bv@JlKtBdKpBxCTpCh@xKvBbEv@`HfArARALCXEXIt@WrBUjBc@hEmArJq@zF{@~G_@vCMjAGd@c@fEi@`EQxBi@rE~RfCzC`@~Fn@xIpAr@PpClAx@ZxBfAbBx@xAj@bDxAbAz@^f@bGjHn@n@d@RfA^RHr@p@f@l@Zr@Zv@`A`ChG~OrAbDsGpCeGjCJ|@N|Cf@rJbCvh@lBv`@X~FDzAn@BnA@v@@tAElAIh@IfB]~@Ur@Wn@Uj@_@p@Yp@UjBY[jCo@~BEPD@D@JBVFdBh@`EpAjB|@fA~@hAxAXb@j@jAzCvC|AfBfBxBnC|C`ApA|AsE
\\R~@l@z@r@|BrA~@h@', NULL, '
2021-12-13 20:30:13
', '2021-12-13 20:30:32
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1522, 'KWD165427', 289, 0, 134, 1, 7914, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.80, 57.54, '', 'Unnamed Road, Lusaka, Zambia', -15.39803070, 28.38531060, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '
2021-12-13 20:34:11
', NULL, NULL, NULL, 0, 0, 0, 0, 'jk~|Aw~flDr@jDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-13 20:34:11', '2021-12-13 20:34:30', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1523, 'KWD434719', 289, 123, 123, 1, 9777, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 14.41, 144.57, '', 'Unnamed Road, Lusaka, Zambia', -15.39801850, 28.38537460, 'Water works, Lusaka, Zambia', -15.45340000, 28.31771000, '2021-12-13 20:35:28', NULL, '2021-12-13 20:40:13', '2021-12-13 20:41:42', 1, 1, 0, 0, 'fk~|Ae_glD}BiLyBd@c@{CmAsIjAWrDy@lEaAfEeB@cL?}AAkA`@At@CQsA|SeCzAW?FzE|HpB|CnElHxBjDpDfGlFlInBzCd@x@f@v@fAdBx@nATh@Pl@b@rAjArDRj@Rj@BFFb@@d@Eb@MhAQfAg@nCa@|Be@nCCv@Fb@J`@l@x@b@j@`BnAv@n@r@r@VZP^^`At@rBt@xBz@bCXdAJ^V~@p@`Cl@zBd@`CDZt@zFtEYpLs@v@?b@Px@NL?vASv@FdUnEnB^xCTrFdAnNnCrDj@lEr@CXIt@Ir@WtBUhBc@jEkAhJs@zF{@~G]vCOjAa@vDKnAg@tD_@pDYhCh@HhOlBnDd@jD`@jCXfGz@zBb@r@V`DtA|E`ChEfBr@
\\b@
\\^
\\V^x@~@pFrG^X`AZn@VzA~A^x@`DhInA~C`E~JBLsAn@gGdCkClAq@XJ|@j@vKl@xMfCzh@|Az[HrC|@BzA@jA?bACr@IjB[j@MlA]lAc@n@c@p@Wl@S~@Qj@G[jCu@nC@@D@D@JBVH|C`AbBf@|B`AbAv@TRhAxAt@tANX|A~ArAlAjAvArFpG`ApAOXeBxEd@Xj@r@lA`Bd@h@Hh@\\rA_@VYV', NULL, '2021-12-13 20:35:28', '2021-12-13 20:44:53', 'NO', '1', 0.00000000, 0.00000000, 0.00000000),
(1524, 'KWD997021', 289, 0, 135, 1, 4377, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.79, 57.50, '', 'Unnamed Road, Lusaka, Zambia', -15.39816550, 28.38531570, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-13 20:47:31', NULL, NULL, NULL, 0, 0, 0, 0, 'lk~|Aq~flDp@dDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F
\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '
2021-12-13 20:47:31
', '2021-12-13 20:48:19
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1525, 'KWD812445', 289, 0, 123, 1, 3798, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.79, 57.50, '', 'Unnamed Road, Lusaka, Zambia', -15.39816550, 28.38531570, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '
2021-12-13 20:51:56
', NULL, NULL, NULL, 0, 0, 0, 0, 'lk~|Aq~flDp@dDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-13 20:51:56', '2021-12-13 20:52:15', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1526, 'KWD774818', 289, 123, 123, 1, 2766, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.79, 57.48, '', 'Unnamed Road, Lusaka, Zambia', -15.39818170, 28.38530110, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-13 20:55:52', NULL, NULL, NULL, 0, 0, 0, 0, 'nk~|Am~flDn@`DeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-13 20:54:39', '2021-12-13 20:56:55', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1527, 'KWD733697', 289, 0, 134, 1, 3440, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.47, 54.24, '', 'Unnamed Road, Lusaka, Zambia', -15.39822310, 28.38531760, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-13 20:58:49', NULL, NULL, NULL, 0, 0, 0, 0, 'lm~|AmaglDuARe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '
2021-12-13 20:57:36
', '2021-12-13 20:59:40
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1528, 'KWD641061', 289, 0, 134, 1, 7621, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 409.24, 4136.38, '', 'Unnamed Road, Lusaka, Zambia', -15.39801610, 28.38522130, 'wsa innovations, pempuleni mufulira ZM, Mufulira 10101, Zambia', -12.54702940, 28.24742290, '
2021-12-13 21:00:45
', NULL, NULL, NULL, 0, 0, 0, 0, 'nk~|Ai~flDiCpIs[sFkEc@gJL}@mK{@yCkKd@wRl@uFbQaJlNqUbr@bTx}@hc@r_ClKr_CjHhY_SdNuSzAcCMcLpLuM`]_GNqAjSgPpb@gQ~e@}FxXu@lDgUbjAwdAgCmmBjBcwC|HsaB|Na~Bf_@aoEvs@}`Ftw@mx@v@gy@dMusD`w@ysAxDmxB`y@_nClv@w_CrlAe|BcDko@{QqYjCmb@jSkuBtS_gA`TeRbx@{V`_DoVfvA}p@deAk|A|aB}wA~lBkcBt}@{p@b^_sAh
\\i`ArYo|@|f@ejEbfBcyAn_@o|Aa@_~G`Cap@}BwtA}
\\m`Cql@ylEopAg}Aek@a\\i_@ecAylAwrAyvA}kB}lCq|@i~Ayg@se@oh@gP{p@agA_h@swAur@s~@s{A_uCk`AgV_UoKmj@elAe{AuiD_mFe}L{fD}yH_^_o@oq@s^ozAu`BkR{Lsw@{Hwm@{EsBOmd@uDkWc^mEgRuAcGcM{a@sGkmAy\\cg@{EiDaWeFajBxCqZirA}GuTya@_^{wBwdB{_B{_Ae|BahAekDuvCcy@tCyZGat@}QozA{VukCaY_kEyiB_mBmy@eoFcnB_gCir@qtAaQwQgA_kAcHwsAeIwSkJwxAimA_{Ait@g}B{|@egBq`BsjCouAs~A_s@m[}EipBj
\\qrDp_Beu@vA_`Ao@cuElD_RvVqBvTuCtc@wP`OijBMyrELgQ@et@@_mCjBkz@nGqjCxRaqEhd@}{BxYsw@jRqy@~MuuHhBscD|XqpBdUuwDstAiTcFggEey@azE}mAe}DyrAow@oYmdB{E_{BjA_~@f@cmDhBscBaNkcH{n@{pBiR{lBpRmP`Cm{@bM}lCr`@y_@Ik[qBsSuAeFbFmAtSy@vM}Cxi@_Obo@cvAj}BwlBxgEcaCbaBqgDhwBo|AjrAyxEh|E}~AxfBo`CtzAqnBpgAcY`PmRv[uGl
\\qGYoRtW{MdFkL~OadBf|AwaHnoFgwCdyBcWbUakGnbHqz@~u@ih@v`BcaAfhHqKvt@iQdYm|AzlBc`Ax}@gYx`@mTvNmjAeBqAAcDCuw@`IwT[KlPp@bCa@`Aap@h@}h@zF}gAnk@gpAbw@ysAdoCydGvnEm]rsAoI~]{QcJwt@{Z}TmVyeAqeAiz@eq@caDkxA}YmPaa@gGcx@oh@opBoxA_q@ct@qTgh@{g@g]aSiEyHsAi{@kTwSgHqOoEgn@m[qFsRgEcTqFmx@aEaqAqPtB}@^_YVuJcAwG}O{@AeLBkE@s@?mQIiBvG', NULL, '2021-12-13 21:00:45', '2021-12-13 21:01:10', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1529, 'KWD662099', 289, 0, 97, 1, 2712, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.77, 57.30, '', 'Unnamed Road, Lusaka, Zambia', -15.39816990, 28.38512410, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-13 21:04:10', NULL, NULL, NULL, 0, 0, 0, 0, 'vk~|Am}flDf@`CeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-13 21:02:16', '2021-12-13 21:04:23', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1530, 'KWD713516', 170, 0, 135, 1, 5970, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 17.89, 179.76, '', 'Unnamed Road, Lusaka, Zambia', -15.39813290, 28.38533480, 'Chalala ROCKFIELD Lusaka, G965+XHV, Lusaka, Zambia', -15.48750010, 28.35892680, '2021-12-13 21:06:41', NULL, NULL, NULL, 0, 0, 0, 0, '|l~|AiaglD`C[a@mCjCc@YgBa@iC_@}BaAaG_@cCn@WvCmA@wH?{BAyCd@Ap@COoAACdCYzIeAzDe@zAWzB|D|HzLzDnGlCxEzGnKbCtDd@v@d@v@hAfBx@nALRFTRl@b@rAjArDPj@Tj@J^Bd@Ab@MhAOfAUfAQfAa@|Bg@nCEb@A`@@THb@R^VZf@p@xAlAlB|AV\\T\\^`At@tBt@tBpAxDRx@X~@n@`Cp@~Bb@|BF^t@~F~Ks@pG[d@L|@RN@tASh@Bv@JlKtBdKpBxCTpCh@xKvBbEv@`HfArARALCXEXIt@WrBUjBc@hEmArJq@zF{@~G_@vCMjAGd@c@fEi@`EQxBi@rE~RfCzC`@~Fn@xIpAr@PpClAx@ZxBfAbBx@xAj@bDxAbAz@^f@bGjHn@n@d@RfA^RHr@p@f@l@Zr@Zv@`A`ChG~OnAtCl@YtB{@nF}BzCqAdAa@f@[fA_@dFyBxF}B|CyArD{AhBk@zDqA`G{BdHyC|FmCn@U`@In@AdAHnHRj@Ap@DhBDtDH`@JlC`AVF^@nC@T@?PI|BMrEk@jSe@~PGbFlEEpH?lKA`_@CjPD~A?|A@n@?`Q@p[?lG?HcGCiQC{SEe_@?gKBqJf@AzAANEHFr@DrEJ', NULL, '
2021-12-13 21:05:48
', '2021-12-13 21:07:08
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1531, 'KWD184802', 289, 0, 135, 1, 7424, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.78, 57.38, '', 'Unnamed Road, Lusaka, Zambia', -15.39823310, 28.38521900, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '
2021-12-13 21:11:12
', NULL, NULL, NULL, 0, 0, 0, 0, 'rk~|A{}flDj@nCeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-13 21:11:12', '2021-12-13 21:12:18', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1532, 'KWD718519', 291, 0, 135, 1, 4707, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 11.85, 118.75, '', 'Unnamed Road, Lusaka, Zambia', -15.39808860, 28.38531850, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-13 21:12:01', NULL, NULL, NULL, 0, 0, 0, 0, 'jk~|Au~flDr@hDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb
\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H
\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zE@P
\\hELjAJf@x@lE
\\lAh@zAnApCx@xAb@x@hBfCnGrH|B`CT\\|HnJjFfGhMrO~AnBOLsCkDYBSF]X[RG?KGQ_@CGUPCB?DDJxB`CvAdB', NULL, '
2021-12-13 21:12:01
', '2021-12-13 21:12:43
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1533, 'KWD760486', 289, 0, 135, 1, 4100, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 18.14, 182.34, '', 'Unnamed Road, Lusaka, Zambia', -15.39822600, 28.38513300, 'Matero Level 1 Hospital, J7G8+73W, Lusaka, Zambia', -15.37425800, 28.26519290, '
2021-12-13 21:45:54
', NULL, NULL, NULL, 0, 0, 0, 0, 'xk~|Ak}flDd@~BeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP
\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zEBD^tCj@rE|@bEl@rBZt@Xd@F@RFNLJPD`@I
\\QNQF]CICe@H_@DyIrGoBvBe@p@i@|@Ob@Iz@W`GcB~[g@|Kq@vNYtGs@pMe@|IArA?`AF~@Nv@Tb@XVpIbInBdBdGvFfBjBlApAzEjEdAbAj@x@d@`Ab@lA`ApCv@~CPpCFvAAbAC`BW`DI`@?DCHAHERGRMf@uAlFKb@UxA_AfE_ArDiApI?PwCCaPG_L\\uETyJz@gEd@qE`@mALmCZeARq@JqBd@s@PiBl@w@ZBN?VCJINWNMDYAYMKKyDjBoB`AcC|@uA`@aB
\\iBXqAJY@BzA?nFAnABnBLb@Vp@Jl@NdDPhB^`DBfAOnCK|AAf@DhAJp@d@hAd@`Ah@`Bf@jA\\l@Z\\fA`@^Dd@Dj@El@K_BvD', NULL, '
2021-12-13 21:45:54
', '2021-12-13 21:45:59
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1534, 'KWD348048', 289, 0, 123, 1, 8939, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.46, 54.13, '', 'Unnamed Road, Lusaka, Zambia', -15.39811040, 28.38537330, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '
2021-12-13 21:48:37
', NULL, NULL, NULL, 0, 0, 0, 0, 'xl~|AiaglDaANe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-13 21:48:37', '2021-12-13 21:48:53', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1535, 'KWD290890', 289, 0, 123, 3, 3055, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.79, 65.52, '', 'Unnamed Road, Lusaka, Zambia', -15.39806050, 28.38527850, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-13 21:52:59', NULL, NULL, NULL, 0, 0, 0, 0, 'lk~|Aq~flDp@dDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F
\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '
2021-12-13 21:52:59
', '2021-12-13 21:53:37
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1536, 'KWD326124', 289, 0, 135, 1, 3903, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 14.15, 141.92, '', 'Unnamed Road, Lusaka, Zambia', -15.39814880, 28.38533790, 'Waterworks Plaza, Lusaka, Zambia', -15.45537210, 28.32083630, '
2021-12-13 22:08:09
', NULL, NULL, NULL, 0, 0, 0, 0, '~l~|AiaglD~B[a@mCjCc@YgBa@iC_@}BaAaG_@cCn@WvCmA@wH?{BAyCd@Ap@COoAACdCYzIeAzDe@zAWzB|D|HzLzDnGlCxEzGnKbCtDd@v@d@v@hAfBx@nALRFTRl@b@rAjArDPj@Tj@J^Bd@Ab@MhAOfAUfAQfAa@|Bg@nCEb@A`@@THb@R^VZf@p@xAlAlB|AV\\T\\^`At@tBt@tBpAxDRx@X~@n@`Cp@~Bb@|BF^t@~F~Ks@pG[d@L|@RN@tASh@Bv@JlKtBdKpBxCTpCh@xKvBbEv@`HfArARALCXEXIt@WrBUjBc@hEmArJq@zF{@~G_@vCMjAGd@c@fEi@`EQxBi@rE~RfCzC`@~Fn@xIpAr@PpClAx@ZxBfAbBx@xAj@bDxAbAz@^f@bGjHn@n@d@RfA^RHr@p@f@l@Zr@Zv@`A`ChG~OrAbDsGpCeGjCJ|@N|Cf@rJbCvh@lBv`@X~FDzAn@BnA@v@@tAElAIh@IfB]~@Ur@Wn@Uj@_@p@Yp@UjBY[jCo@~BEPD@D@JBVFdBh@`EpAjB|@fA~@hAxAXb@j@jAzCvC|AfBfBxBnC|C`ApA|AsE\\R~@l@z@r@|BrA~@h@', NULL, '2021-12-13 22:08:09', '2021-12-13 22:08:18', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1537, 'KWD630939', 289, 0, 123, 3, 1765, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 11.84, 138.72, '', 'Unnamed Road, Lusaka, Zambia', -15.39802801, 28.38515673, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-13 22:09:31', NULL, NULL, NULL, 0, 0, 0, 0, 'rk~|A{}flDj@nCeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb
\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H
\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zE@P
\\hELjAJf@x@lE
\\lAh@zAnApCx@xAb@x@hBfCnGrH|B`CT\\|HnJjFfGhMrO~AnBOLsCkDYBSF]X[RG?KGQ_@CGUPCB?DDJxB`CvAdB', NULL, '
2021-12-13 22:09:31
', '2021-12-13 22:09:51
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1538, 'KWD588357', 289, 0, 123, 3, 8806, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 7.30, 83.73, '', 'Unnamed Road, Lusaka, Zambia', -15.39807950, 28.38523790, 'Waterfalls Hotel, Plot No.947 M/67/N off Great East Road, Lusaka Lusaka Lusaka Province ZM, Lusaka 10101, Zambia', -15.38675660, 28.34240190, '
2021-12-13 22:11:28
', NULL, NULL, NULL, 0, 0, 0, 0, 'nk~|Ag~flDn@zCeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP
\\LHJNDXAVGPN~@Rp@', NULL, '
2021-12-13 22:11:28
', '2021-12-13 22:11:33
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1539, 'KWD602515', 289, 0, 123, 3, 6180, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 5.46, 65.00, '', 'Unnamed Road, Lusaka, Zambia', -15.39808490, 28.38541990, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '
2021-12-13 22:28:32
', NULL, NULL, NULL, 0, 0, 0, 0, 'vl~|AgaglD_ALe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-13 22:28:32', '2021-12-13 22:29:03', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1540, 'KWD620176', 289, 0, 123, 3, 7295, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 5.80, 65.59, '', 'Unnamed Road, Lusaka, Zambia', -15.39805990, 28.38533740, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-13 22:31:32', NULL, NULL, NULL, 0, 0, 0, 0, 'jk~|A{~flDr@nDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F
\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '
2021-12-13 22:31:32
', '2021-12-13 22:31:58
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1541, 'KWD233869', 289, 0, 123, 3, 9427, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 14.36, 169.25, '', 'Unnamed Road, Lusaka, Zambia', -15.39805127, 28.38527557, 'Waterworks Plaza, Lusaka, Zambia', -15.45537210, 28.32083630, '
2021-12-13 22:32:20
', NULL, NULL, NULL, 0, 0, 0, 0, 'lk~|Aq~flDp@dDHKdBqBxDq@YiC_@}B_@{BaAgGaAaG_@cCn@WvCmA@wH?{BAyCd@Ap@COoAACdCYzIeAzDe@zAWzB|D|HzLzDnGlCxEzGnKtCpEd@v@nAnBx@nAZf@Pl@b@rAjArDf@vATt@Bd@Ab@MhAOfAUfA_@|Bg@nCSfAEb@A`@@THb@R^VZf@p@`@
\\nB|At@n@V
\\T
\\^`A^bAl@bBnB|F`@xAn@~Bp@`Cf@|BN~@t@~F~Ks@pG[d@L|@RN@tASh@Bv@JlKtBdKpBxCTpCh@xKvBbEv@`HfArARALCXEXIt@Ir@WtBe@hEg@hEk@nEY|BY|By@zG_@vCMjAGf@CPc@fEi@`EQxBi@rE~RfCzC`@~Fn@xIpAr@PpClAx@ZxBfAbBx@xAj@bDxAbAz@^f@bGjHn@n@d@RfA^RHr@p@f@l@Zr@Zv@`A`ChG~OrAbDsGpCeGjCJ|@N|Cf@rJbCvh@lBv`@X~FDzAn@BnA@v@@tAElAIh@IfB]~@Ur@Wn@Uj@_@p@Yp@UjBY[jCo@~BEPD@JBVFjBj@`EpAjB|@fA~@hAxAXb@j@jAzCvC|AfBfBxBnC|C`ApA|AsE\\R~@l@z@r@|BrA~@h@', NULL, '2021-12-13 22:32:20', '2021-12-13 22:33:02', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1542, 'KWD593604', 289, 0, 123, 3, 1257, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.76, 65.10, '', 'Unnamed Road, Lusaka, Zambia', -15.39814800, 28.38497450, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-13 22:34:20', NULL, NULL, NULL, 0, 0, 0, 0, '~k~|As|flD^fBeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F
\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '
2021-12-13 22:34:20
', '2021-12-13 22:35:19
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1543, 'KWD173892', 289, 0, 123, 3, 5048, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 5.79, 65.52, '', 'Unnamed Road, Lusaka, Zambia', -15.39798440, 28.38525470, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '
2021-12-13 22:39:43
', NULL, NULL, NULL, 0, 0, 0, 0, 'lk~|Aq~flDp@dDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-13 22:39:31', '2021-12-13 22:40:15', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1544, 'KWD809096', 289, 0, 123, 3, 6380, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 20.14, 239.18, '', 'Unnamed Road, Lusaka, Zambia', -15.39820650, 28.38530280, 'Makeni Mall, Makeni, T2, Lusaka, Zambia', -15.45381920, 28.26621590, '2021-12-13 22:41:23', NULL, NULL, NULL, 0, 0, 0, 0, 'hm~|AkaglDqAPe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@{CdPEJWR[B[?aA@I@KHGHE^w@`CmEzMkGhRwF|PyAjEK
\\W
\\_@RUPBHfB`KbBtI~@bE~@~CtGpRLXJJf@f@HJN^B`@DbA|@xCr@jC|@jE|DtT|B|M|B`LpCjOxFn\\d@hCNf@T~AZzADt@Fl@NZDBJJJPBXARAFEFBJHf@Jb@\\vAX|AbArFPbAXnCPpDCxDWzK[nPMvGAjBJrC~@vJz@bJb@~EVlDh@zFZrE^zDR|AP~@p@|Cb@pAh@tApAnCd@z@pArBbBvBrFnGtB|BRVpNzP~EbGzJtLX\\d@h@PT|AlB`CvCtEpFnA|AvAzAv@fArBfCjBzBzAhBzBhDV`@vAdD|@rC^bBd@rCj@zGn@tH`AjMp@bIpBxUhAzMv@`GTvBPfCPzBh@hGHb@F@LFDDv@S`Dc@lGi@xJ_AfSgBlSmB`Q_BlK}@f@KTIBITWNGTAPHNLFJ@DJAhFe@fBQr@Cv@AhBBpAPlBb@v@TdAh@|Ax@~@v@|@`Ap@bA|@bBjBpEl@rA`@j@f@r@|@~@t@n@r@f@pB`A|YzLxJ`E|ErBbCbAbEnBrElBtMtFrLbFvNhGnCpAtCnA|E|B`Ab@Wb@CTEd@@
\\CPIFs@DMDAFDp@@b@', NULL, '
2021-12-13 22:41:14
', '2021-12-13 22:41:30
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1545, 'KWD765702', 289, 0, 135, 3, 6738, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 5.80, 65.59, '', 'Unnamed Road, Lusaka, Zambia', -15.39808450, 28.38534100, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '
2021-12-13 22:43:07
', NULL, NULL, NULL, 0, 0, 0, 0, 'jk~|A{~flDr@nDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-13 22:42:24', '2021-12-13 22:43:11', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1546, 'KWD790286', 289, 0, 123, 3, 8577, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 9.23, 107.19, '', 'Unnamed Road, Lusaka, Zambia', -15.39811230, 28.38538050, 'Wayaya All Events, H8FV+HF7, Lusaka, Zambia', -15.42608620, 28.34367950, '2021-12-13 22:43:57', NULL, NULL, NULL, 0, 0, 0, 0, 'zl~|AiaglDbC[a@mCjCc@YgBa@iC_@}BaAaG_@cCn@WvCmA@wH?{BAyCd@Ap@COoAACdCYzIeAzDe@zAWzB|D|HzLzDnGlCxEzGnKbCtDd@v@d@v@hAfBx@nALRFTRl@b@rAjArDPj@Tj@J^Bd@Ab@MhAOfAUfAQfAa@|Bg@nCEb@A`@@THb@R^VZf@p@xAlAlB|AV
\\T
\\^`At@tBt@tBpAxDRx@X~@n@`Cp@~Bb@|BF^t@~F~Ks@pG[d@L|@RN@tASh@Bv@JlKtBdKpBxCTpCh@xKvBbEv@`HfArARALCXEXIt@WrBUjBc@hEmArJq@zF{@~G_@vCMjAGd@c@fEi@`EQxBi@rEeChRG`@M`A[fCw@bGu@jGM`A{ChVeAfIbBRjBV', NULL, '2021-12-13 22:43:48', '2021-12-13 22:44:33', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1547, 'KWD325867', 289, 0, 123, 3, 4111, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 517.36, 6260.62, '', 'Unnamed Road, Lusaka, Zambia', -15.39807530, 28.38547990, 'Wasa Lodge, Unnamed Road, Zambia', -12.55489300, 30.29611700, '2021-12-13 22:50:56', NULL, NULL, NULL, 0, 0, 0, 0, 'vl~|AgaglDmN}HsN@_TKqSIcVlRea@|aArVbaAxa@b|BjKh_ChHjYuSnM_TlBg^lj@c[zx@sXd~@u@lDeU`jAswDM{_DjIygL`dBu}Ezv@erB|NcuDfw@crApDsxBby@krChx@s|B`kAy{BcEajAgLaxClg@_iAtVcPny@{Vd_Dk]x_B_~C`yDcpAjwAe|Al|@glCvy@o}BlgAycEj~AytA~ZeeBLmtGxAqcCma@k_D_x@qnDqeA_~Awk@oYe^ufAgpAc~DucF}z@o|A{g@_e@ek@eReo@sgA}h@iwAkv@_fAewAimC}bAgUegAskBwfBe`E{|Ey~K{aDspHo`@yn@}q@i_@kzAqaBmuBgYsBOqe@_Es\\iq@uAcGmNql@kF_cAa_@sh@sCkBqbCuA_]{{Ags@is@qmBa|AcbBs`AmyB}fAamDqwCez@~EyoAiT}eFip@elEyjBc~IaiDuxEibAyQgAs_BqJmwAsU{zAgoAstEcnBajBobBqiCgtAmyBsw@qoBr
\\euDr`Bir@d@c_Am@s_@FgGc`@cb@wyB`GyhCGu^gAoTiCyi@cpAwkDaNcjC~G{dAkLa|BbNyqDss@efCk|A{bEyI{cAgSin@arCyjB_dEmoCysButC{zAetAaHqwAqnD{iJcb@iwBgW{_B}`AgxDmaCglFoqBwtCgbA{lB_c@gv@aG_kAoMsvDtAivAWiMQ}JkFg^uP{s@_Zw[gyA}kC{c@{pBg
\\s}BrBoyBkPm}CgEkqBox@slCsbB}`FcqAolCoJkaDjXyaEoCauAukE_}Fqo@{k@cq@kzDqc@_yA}Bko@pOih@pC{nA_gAeuDgkBkmFaqAcuBu^udBc_@ac@gs@cg@qz@gm@}y@gLiBUkBWmVwCiuA}r@_qHu{HgpDeqCanAi|@cb@g|@wmAymDudAiw@sYqs@uHu`CSoDUaJkJu~@qsBckCwsA{rCeQeoB_Xij@_FuJ{g@{l@ui@}j@cRiv@aI}z@vHu|B_]caGm[ubA|JqgAR}~A}Oi`BrOgcB`To}@rHez@qf@c~Bke@abBcXm]ys@_Rqf@gm@}yAk~Aku@sa@_}Akf@uzBqQmu@m`ActAifAo`@eIskAsAqiAiu@wu@gp@ec@gwAu|Fw{C}}HozFsHuQgJom@}Y@wzB`^siAbI_}Eq`@sn@|Ckh@z`@epD|~C}gBl}@cmEvbBgv@}@}pEg{@qnGgiAwyHr~A}uE~cAydN|R_rCbEa`B`CukBhJdd@buA\\taBqKzwCpR~_A_g@d~@hSp{B', NULL, '2021-12-13 22:50:45', '2021-12-13 22:51:24', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1548, 'KWD946379', 291, 0, 123, 3, 2126, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.46, 65.00, '', 'Unnamed Road, Lusaka, Zambia', -15.39805770, 28.38540530, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-14 00:42:19', NULL, NULL, NULL, 0, 0, 0, 0, 'pl~|AgaglDy@Le@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '
2021-12-14 00:42:19
', '2021-12-14 00:43:24
', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1549, 'KWD790134', 291, 0, 123, 3, 6530, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 23.25, 276.91, '', 'Unnamed Road, Lusaka, Zambia', -15.39803902, 28.38538400, 'Andrew
\'s Motel, G795+Q8P, Lusaka, Zambia', -15.48052710, 28.25832190, '2021-12-14 00:47:00', NULL, NULL, NULL, 0, 0, 0, 0, 'll~|AeaglDu@Je@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@{CdPEJWR[B[?aA@I@KHGHE^w@`CmEzMkGhRwF|PyAjEK\\W\\_@RUPBHfB`KbBtI~@bE~@~CtGpRLXJJf@f@HJN^B`@DbA|@xCr@jC|@jE|DtT|B|M|B`LpCjOxFn\\d@hCNf@T~AZzADt@Fl@NZDBJJJPBXARAFEFBJHf@Jb@\\vAX|AbArFPbAXnCPpDCxDWzK[nPMvGAjBJrC~@vJz@bJb@~EVlDh@zFZrE^zDR|AP~@p@|Cb@pAh@tApAnCd@z@pArBbBvBrFnGtB|BRVpNzP~EbGzJtLX\\d@h@PT|AlB`CvCtEpFnA|AvAzAv@fArBfCjBzBzAhBzBhDV`@vAdD|@rC^bBd@rCj@zGn@tH`AjMp@bIpBxUhAzMv@`GTvBPfCPzBh@hGHb@F@LFDDv@S`Dc@lGi@xJ_AfSgBlSmB`Q_BlK}@f@KTIBITWNGTAPHNLFJ@DJAhFe@fBQr@Cv@AhBBpAPlBb@v@TdAh@|Ax@~@v@|@`Ap@bA|@bBjBpEl@rA`@j@f@r@|@~@t@n@r@f@pB`A|YzLxJ`E|ErBbCbAbEnBrElBtMtFrLbFvNhGnCpAtCnAvP`IhAj@pEzBrD|A`I`D~CpA|BdAlC`AhEjBhC|@|Dp@~DPtDHpRl@l@ABCBEBCJEJ?VHHJ\\JjBDbDRtEp@tDx@nLvCjBr@~DhBhWrMhAmC', NULL, '2021-12-14 00:46:46', '2021-12-14 00:47:31', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1550, 'KWD177500', 291, 0, 135, 3, 8169, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 5.45, 65.00, '', 'Unnamed Road, Lusaka, Zambia', -15.39804519, 28.38542319, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-14 00:49:04', NULL, NULL, NULL, 0, 0, 0, 0, 'nl~|AgaglDw@Le@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-14 00:48:37', '2021-12-14 00:49:14', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1551, 'KWD282279', 291, 0, 135, 3, 1778, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 5.45, 65.00, '', 'Unnamed Road, Lusaka, Zambia', -15.39804519, 28.38542319, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-14 00:48:56', NULL, NULL, NULL, 0, 0, 0, 0, 'nl~|AgaglDw@Le@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-14 00:48:38', '2021-12-14 00:49:17', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1552, 'KWD564648', 291, 0, 135, 3, 9142, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 5.45, 65.00, '', 'Unnamed Road, Lusaka, Zambia', -15.39805310, 28.38539000, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-14 00:53:02', NULL, NULL, NULL, 0, 0, 0, 0, 'nl~|AgaglDw@Le@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-14 00:51:34', '2021-12-14 00:53:24', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1553, 'KWD316996', 289, 0, 123, 3, 4469, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 5.79, 65.43, '', 'Unnamed Road, Lusaka, Zambia', -15.39812210, 28.38522870, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-14 01:02:04', NULL, NULL, NULL, 0, 0, 0, 0, 'pk~|Ac~flDl@vCeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-14 01:01:52', '2021-12-14 01:02:35', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1554, 'KWD625235', 291, 0, 135, 3, 8540, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 5.46, 65.00, '', 'Unnamed Road, Lusaka, Zambia', -15.39805930, 28.38545250, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-14 01:06:29', NULL, NULL, NULL, 0, 0, 0, 0, 'rl~|AgaglD{@Le@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-14 01:04:25', '2021-12-14 01:06:47', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1555, 'KWD767481', 291, 0, 123, 3, 8946, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 16.05, 189.75, '', 'Unnamed Road, Lusaka, Zambia', -15.39795750, 28.38534170, 'Luburma Market, Luburma Market, Lusaka, Zambia', -15.42528810, 28.28737760, '2021-12-14 01:17:41', NULL, NULL, NULL, 0, 0, 0, 0, 'hk~|Aa_glDt@tDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zE@P\\hELjAJf@x@lE\\lAh@zAnApCx@xAb@x@hBfCnGrH|B`CT\\|HnJjFfGhMrOtBhCd@h@tEtF^h@pAgAtCcCp@_@`CiAjCw@tCg@fAKhBIfB?pAHvBT|@PlBf@vAf@xE~BlFlCnHvDbFxC|ChBXH`@BPI^E\\FTNbIk@pPsA~BSBERWNO`@AXHPTHb@?PINAJE^Cd@fAbF@Fb@pBnClMvArGpAnG`BpIVz@j@nCLl@xDvR~A~Hr@jET|Bp@GnCS', NULL, '2021-12-14 01:16:56', '2021-12-14 01:18:53', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1556, 'KWD810677', 291, 0, 97, 1, 2039, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 11.86, 118.80, '', 'Unnamed Road, Lusaka, Zambia', -15.39805730, 28.38535350, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-14 01:22:50', NULL, NULL, NULL, 0, 0, 0, 0, 'hk~|A__glDt@rDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zE@P\\hELjAJf@x@lE\\lAh@zAnApCx@xAb@x@hBfCnGrH|B`CT\\|HnJjFfGhMrO~AnBOLsCkDYBSF]X[RG?KGQ_@CGUPCB?DDJxB`CvAdB', NULL, '2021-12-14 01:22:50', '2021-12-14 01:22:53', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1557, 'KWD281583', 291, 0, 123, 3, 8249, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 11.85, 138.87, '', 'Unnamed Road, Lusaka, Zambia', -15.39809520, 28.38529460, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-14 01:23:52', NULL, NULL, NULL, 0, 0, 0, 0, 'lk~|Aq~flDp@dDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zE@P\\hELjAJf@x@lE\\lAh@zAnApCx@xAb@x@hBfCnGrH|B`CT\\|HnJjFfGhMrO~AnBOLsCkDYBSF]X[RG?KGQ_@CGUPCB?DDJxB`CvAdB', NULL, '2021-12-14 01:23:52', '2021-12-14 01:24:07', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1558, 'KWD193255', 289, 0, 123, 3, 8029, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 5.80, 65.59, '', 'Unnamed Road, Lusaka, Zambia', -15.39807630, 28.38534110, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-14 01:28:23', NULL, NULL, NULL, 0, 0, 0, 0, 'jk~|A{~flDr@nDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-14 01:28:23', '2021-12-14 01:30:18', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1559, 'KWD779803', 289, 0, 123, 3, 8903, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 5.46, 65.00, '', 'Unnamed Road, Lusaka, Zambia', -15.39810180, 28.38539530, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-14 01:40:39', NULL, NULL, NULL, 0, 0, 0, 0, 'xl~|AiaglDaANe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-14 01:40:39', '2021-12-14 01:41:51', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1560, 'KWD877633', 289, 0, 123, 3, 6344, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 14.36, 169.30, '', 'Unnamed Road, Lusaka, Zambia', -15.39807040, 28.38531500, 'Waterworks Plaza, Lusaka, Zambia', -15.45537210, 28.32083630, '2021-12-14 01:46:02', NULL, NULL, NULL, 0, 0, 0, 0, 'jk~|Aw~flDr@jDHKdBqBxDq@YiC_@}B_@{BaAgGaAaG_@cCn@WvCmA@wH?{BAyCd@Ap@COoAACdCYzIeAzDe@zAWzB|D|HzLzDnGlCxEzGnKtCpEd@v@nAnBx@nAZf@Pl@b@rAjArDf@vATt@Bd@Ab@MhAOfAUfA_@|Bg@nCSfAEb@A`@@THb@R^VZf@p@`@\\nB|At@n@V\\T\\^`A^bAl@bBnB|F`@xAn@~Bp@`Cf@|BN~@t@~F~Ks@pG[d@L|@RN@tASh@Bv@JlKtBdKpBxCTpCh@xKvBbEv@`HfArARALCXEXIt@Ir@WtBe@hEg@hEk@nEY|BY|By@zG_@vCMjAGf@CPc@fEi@`EQxBi@rE~RfCzC`@~Fn@xIpAr@PpClAx@ZxBfAbBx@xAj@bDxAbAz@^f@bGjHn@n@d@RfA^RHr@p@f@l@Zr@Zv@`A`ChG~OrAbDsGpCeGjCJ|@N|Cf@rJbCvh@lBv`@X~FDzAn@BnA@v@@tAElAIh@IfB]~@Ur@Wn@Uj@_@p@Yp@UjBY[jCo@~BEPD@JBVFjBj@`EpAjB|@fA~@hAxAXb@j@jAzCvC|AfBfBxBnC|C`ApA|AsE\\R~@l@z@r@|BrA~@h@', NULL, '2021-12-14 01:46:02', '2021-12-14 01:48:29', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1561, 'KWD689782', 289, 0, 123, 3, 5865, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 5.46, 65.00, '', 'Unnamed Road, Lusaka, Zambia', -15.39812290, 28.38535110, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-14 01:58:11', NULL, NULL, NULL, 0, 0, 0, 0, 'zl~|AiaglDcANe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-14 01:58:11', '2021-12-14 01:59:01', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1562, 'KWD364999', 289, 0, 123, 3, 5873, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 5.46, 65.00, '', 'Unnamed Road, Lusaka, Zambia', -15.39812090, 28.38535100, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-14 01:59:29', NULL, NULL, NULL, 0, 0, 0, 0, 'zl~|AiaglDcANe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-14 01:59:29', '2021-12-14 02:00:40', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1563, 'KWD765568', 289, 0, 123, 3, 4073, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 11.05, 129.18, '', '175 Kudu Rd, Lusaka, Zambia', -15.41014290, 28.34919810, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-14 07:54:59', NULL, NULL, NULL, 0, 0, 0, 0, 'bz`}Acz_lDj@E^IRMHh@n@|En@lFh@pEBT_@BoDd@{BZ_Gv@UD^rBnDpRRhABh@Gf@YfAo@fCu@dDShAcH_AgFs@kBUu@Gs@?oABu@EqC]mAUcG}@kAKcLaBaB_@sAq@q@Wk@Os@MyDk@mIoA_LaBwGeAiDm@eF_AiFaAcBUi@CE?SKyAMc@Oi@[UKUEMDWHYLKTUPWBQGOKKQGYD_@FMJo@Do@Cg@W{Ac@iCkAmGq@cEqAkHuAwHkA_HwAcIo@uCi@yBSk@Oe@k@wBo@wCu@eEaB}IeCgNMa@o@gCw@cCc@o@UOKGIKK_@EcB{D_MoCsI_@iBmBmKUkAgB{JuAoHa@cDaAuNKmBg@_HS}Ao@oEiAaFaCuIaBoIqAoHcB{KiAoHeAcHuAoIaAcHg@_Du@}EoB}L]iBUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-14 07:54:59', '2021-12-14 07:55:39', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1564, 'KWD678944', 289, 0, 123, 3, 1642, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 10.86, 126.90, '', '175 Kudu Rd, Lusaka, Zambia', -15.41011610, 28.34929430, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-14 08:03:54', NULL, NULL, NULL, 0, 0, 0, 0, 'zu`}As``lDUAcALq@TOuA_@{BMiASAwBDCRXtJl@bQ@^A?}ANeC^_BRyB\\mJtAeCZ`@dCFdAIpDEvCKdDO~CkBIOp@_BnG_AOkAKcLaBaB_@sAq@q@Wk@Os@MyDk@mIoA_LaBwGeAiDm@eF_AiFaAcBUi@CE?SKyAMc@Oi@[UKUEMDWHYLKTUPWBQGOKKQGYD_@FMJo@Do@Cg@W{Ac@iCkAmGq@cEqAkHuAwHkA_HwAcIo@uCi@yBSk@Oe@k@wBo@wCu@eEaB}IeCgNMa@o@gCw@cCc@o@UOKGIKK_@EcB{D_MoCsI_@iBmBmKUkAgB{JuAoHa@cDaAuNKmBg@_HS}Ao@oEiAaFaCuIaBoIqAoHcB{KiAoHeAcHuAoIaAcHg@_Du@}EoB}L]iBUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-14 08:03:54', '2021-12-14 08:05:07', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1565, 'KWD658263', 289, 0, 123, 3, 3959, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 10.86, 126.90, '', '175 Kudu Rd, Lusaka, Zambia', -15.41011610, 28.34929430, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-14 08:03:55', NULL, NULL, NULL, 0, 0, 0, 0, 'zu`}As``lDUAcALq@TOuA_@{BMiASAwBDCRXtJl@bQ@^A?}ANeC^_BRyB\\mJtAeCZ`@dCFdAIpDEvCKdDO~CkBIOp@_BnG_AOkAKcLaBaB_@sAq@q@Wk@Os@MyDk@mIoA_LaBwGeAiDm@eF_AiFaAcBUi@CE?SKyAMc@Oi@[UKUEMDWHYLKTUPWBQGOKKQGYD_@FMJo@Do@Cg@W{Ac@iCkAmGq@cEqAkHuAwHkA_HwAcIo@uCi@yBSk@Oe@k@wBo@wCu@eEaB}IeCgNMa@o@gCw@cCc@o@UOKGIKK_@EcB{D_MoCsI_@iBmBmKUkAgB{JuAoHa@cDaAuNKmBg@_HS}Ao@oEiAaFaCuIaBoIqAoHcB{KiAoHeAcHuAoIaAcHg@_Du@}EoB}L]iBUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-14 08:03:55', '2021-12-14 08:05:07', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1566, 'KWD555403', 289, 135, 135, 3, 5601, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 11.05, 129.18, '', '175 Kudu Rd, Lusaka, Zambia', -15.41011990, 28.34919330, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-14 08:34:43', NULL, '2021-12-14 08:35:14', '2021-12-14 08:35:21', 1, 1, 0, 0, 'bz`}Acz_lDj@E^IRMHh@n@|En@lFh@pEBT_@BoDd@{BZ_Gv@UD^rBnDpRRhABh@Gf@YfAo@fCu@dDShAcH_AgFs@kBUu@Gs@?oABu@EqC]mAUcG}@kAKcLaBaB_@sAq@q@Wk@Os@MyDk@mIoA_LaBwGeAiDm@eF_AiFaAcBUi@CE?SKyAMc@Oi@[UKUEMDWHYLKTUPWBQGOKKQGYD_@FMJo@Do@Cg@W{Ac@iCkAmGq@cEqAkHuAwHkA_HwAcIo@uCi@yBSk@Oe@k@wBo@wCu@eEaB}IeCgNMa@o@gCw@cCc@o@UOKGIKK_@EcB{D_MoCsI_@iBmBmKUkAgB{JuAoHa@cDaAuNKmBg@_HS}Ao@oEiAaFaCuIaBoIqAoHcB{KiAoHeAcHuAoIaAcHg@_Du@}EoB}L]iBUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-14 08:34:43', '2021-12-14 08:35:45', 'NO', '0', 0.00000000, 0.00000000, 0.00000000);
INSERT INTO `user_requests` (`id`, `booking_id`, `user_id`, `provider_id`, `current_provider_id`, `service_type_id`, `otp`, `returntrip`, `status`, `cancelled_by`, `cancel_reason`, `payment_mode`, `paid`, `distance`, `amount`, `specialNote`, `s_address`, `s_latitude`, `s_longitude`, `d_address`, `d_latitude`, `d_longitude`, `assigned_at`, `schedule_at`, `started_at`, `finished_at`, `user_rated`, `provider_rated`, `use_wallet`, `surge`, `route_key`, `deleted_at`, `created_at`, `updated_at`, `is_track`, `travel_time`, `track_distance`, `track_latitude`, `track_longitude`) VALUES
(1567, 'KWD220686', 289, 0, 135, 3, 5625, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 11.05, 129.18, '', '175 Kudu Rd, Lusaka, Zambia', -15.41011550, 28.34920730, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-14 08:36:44', NULL, NULL, NULL, 0, 0, 0, 0, 'bz`}Acz_lDj@E^IRMHh@n@|En@lFh@pEBT_@BoDd@{BZ_Gv@UD^rBnDpRRhABh@Gf@YfAo@fCu@dDShAcH_AgFs@kBUu@Gs@?oABu@EqC]mAUcG}@kAKcLaBaB_@sAq@q@Wk@Os@MyDk@mIoA_LaBwGeAiDm@eF_AiFaAcBUi@CE?SKyAMc@Oi@[UKUEMDWHYLKTUPWBQGOKKQGYD_@FMJo@Do@Cg@W{Ac@iCkAmGq@cEqAkHuAwHkA_HwAcIo@uCi@yBSk@Oe@k@wBo@wCu@eEaB}IeCgNMa@o@gCw@cCc@o@UOKGIKK_@EcB{D_MoCsI_@iBmBmKUkAgB{JuAoHa@cDaAuNKmBg@_HS}Ao@oEiAaFaCuIaBoIqAoHcB{KiAoHeAcHuAoIaAcHg@_Du@}EoB}L]iBUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-14 08:36:44', '2021-12-14 08:37:04', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1568, 'KWD681313', 289, 0, 123, 3, 2487, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 11.05, 129.18, '', '175 Kudu Rd, Lusaka, Zambia', -15.41011990, 28.34919330, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-14 08:37:35', NULL, NULL, NULL, 0, 0, 0, 0, 'bz`}Acz_lDj@E^IRMHh@n@|En@lFh@pEBT_@BoDd@{BZ_Gv@UD^rBnDpRRhABh@Gf@YfAo@fCu@dDShAcH_AgFs@kBUu@Gs@?oABu@EqC]mAUcG}@kAKcLaBaB_@sAq@q@Wk@Os@MyDk@mIoA_LaBwGeAiDm@eF_AiFaAcBUi@CE?SKyAMc@Oi@[UKUEMDWHYLKTUPWBQGOKKQGYD_@FMJo@Do@Cg@W{Ac@iCkAmGq@cEqAkHuAwHkA_HwAcIo@uCi@yBSk@Oe@k@wBo@wCu@eEaB}IeCgNMa@o@gCw@cCc@o@UOKGIKK_@EcB{D_MoCsI_@iBmBmKUkAgB{JuAoHa@cDaAuNKmBg@_HS}Ao@oEiAaFaCuIaBoIqAoHcB{KiAoHeAcHuAoIaAcHg@_Du@}EoB}L]iBUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-14 08:37:35', '2021-12-14 08:37:47', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1569, 'KWD125864', 291, 0, 123, 3, 2557, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 11.05, 129.18, '', '175 Kudu Rd, Lusaka, Zambia', -15.41012020, 28.34914840, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-14 08:39:16', NULL, NULL, NULL, 0, 0, 0, 0, 'bz`}Acz_lDj@E^IRMHh@n@|En@lFh@pEBT_@BoDd@{BZ_Gv@UD^rBnDpRRhABh@Gf@YfAo@fCu@dDShAcH_AgFs@kBUu@Gs@?oABu@EqC]mAUcG}@kAKcLaBaB_@sAq@q@Wk@Os@MyDk@mIoA_LaBwGeAiDm@eF_AiFaAcBUi@CE?SKyAMc@Oi@[UKUEMDWHYLKTUPWBQGOKKQGYD_@FMJo@Do@Cg@W{Ac@iCkAmGq@cEqAkHuAwHkA_HwAcIo@uCi@yBSk@Oe@k@wBo@wCu@eEaB}IeCgNMa@o@gCw@cCc@o@UOKGIKK_@EcB{D_MoCsI_@iBmBmKUkAgB{JuAoHa@cDaAuNKmBg@_HS}Ao@oEiAaFaCuIaBoIqAoHcB{KiAoHeAcHuAoIaAcHg@_Du@}EoB}L]iBUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-14 08:39:16', '2021-12-14 08:39:25', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1570, 'KWD638426', 291, 123, 123, 3, 5526, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 11.05, 129.18, '', '175 Kudu Rd, Lusaka, Zambia', -15.41012263, 28.34916006, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-14 08:42:33', NULL, '2021-12-14 08:44:33', '2021-12-14 08:52:50', 1, 1, 0, 0, 'bz`}Acz_lDj@E^IRMHh@n@|En@lFh@pEBT_@BoDd@{BZ_Gv@UD^rBnDpRRhABh@Gf@YfAo@fCu@dDShAcH_AgFs@kBUu@Gs@?oABu@EqC]mAUcG}@kAKcLaBaB_@sAq@q@Wk@Os@MyDk@mIoA_LaBwGeAiDm@eF_AiFaAcBUi@CE?SKyAMc@Oi@[UKUEMDWHYLKTUPWBQGOKKQGYD_@FMJo@Do@Cg@W{Ac@iCkAmGq@cEqAkHuAwHkA_HwAcIo@uCi@yBSk@Oe@k@wBo@wCu@eEaB}IeCgNMa@o@gCw@cCc@o@UOKGIKK_@EcB{D_MoCsI_@iBmBmKUkAgB{JuAoHa@cDaAuNKmBg@_HS}Ao@oEiAaFaCuIaBoIqAoHcB{KiAoHeAcHuAoIaAcHg@_Du@}EoB}L]iBUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-14 08:42:33', '2021-12-14 08:59:11', 'NO', '8', 0.00000000, 0.00000000, 0.00000000),
(1571, 'KWD346486', 289, 0, 123, 3, 4065, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 10.86, 126.90, '', '175 Kudu Rd, Lusaka, Zambia', -15.40979390, 28.34930730, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-14 08:54:35', NULL, NULL, NULL, 0, 0, 0, 0, 'zu`}As``lDUAcALq@TOuA_@{BMiASAwBDCRXtJl@bQ@^A?}ANeC^_BRyB\\mJtAeCZ`@dCFdAIpDEvCKdDO~CkBIOp@_BnG_AOkAKcLaBaB_@sAq@q@Wk@Os@MyDk@mIoA_LaBwGeAiDm@eF_AiFaAcBUi@CE?SKyAMc@Oi@[UKUEMDWHYLKTUPWBQGOKKQGYD_@FMJo@Do@Cg@W{Ac@iCkAmGq@cEqAkHuAwHkA_HwAcIo@uCi@yBSk@Oe@k@wBo@wCu@eEaB}IeCgNMa@o@gCw@cCc@o@UOKGIKK_@EcB{D_MoCsI_@iBmBmKUkAgB{JuAoHa@cDaAuNKmBg@_HS}Ao@oEiAaFaCuIaBoIqAoHcB{KiAoHeAcHuAoIaAcHg@_Du@}EoB}L]iBUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-14 08:54:35', '2021-12-14 08:54:53', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1572, 'KWD677594', 291, 123, 123, 1, 6320, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 12.43, 124.57, '', '175 Kudu Rd, Lusaka, Zambia', -15.41012520, 28.34918090, 'Makeni Mall, Makeni, T2, Lusaka, Zambia', -15.45381920, 28.26621590, '2021-12-14 08:59:58', NULL, '2021-12-14 09:06:26', '2021-12-14 09:06:33', 1, 1, 0, 0, 'bz`}Acz_lDj@E^IRMHh@n@|En@lFh@pE^jCrBpQRjAbAhIfAxId@fDP^HF`@L`Cb@zEn@pFr@dIlA`H|@`Df@v@R|C~@~@\\|@T`AFB??QBYV]VMRC`@HXTHRDX?f@AXQ`B?Zx@`GlBhOV~C?~@?|@IrAc@bCi@jBuArEsBxGoDnLmC~I]fA}@rC{@fCaChIgA|Dc@pAW`@a@f@}@d@m@NcBJwANSH?@AV@JJ`AtAjGnGfZ`ClLNn@BA`@@VLJJHZCV]l@aAtAaApAAJE^Cd@fAbF@Fb@pBnClMvArGpAnG`BpIVz@j@nCLl@xDvR~A~Hr@jEvAtQz@rITfBPHNLFJ@DJAhFe@fBQr@Cv@AhBBpAPlBb@v@TdAh@|Ax@~@v@|@`Ap@bA|@bBjBpEl@rA`@j@f@r@|@~@t@n@r@f@pB`A|YzLxJ`E|ErBbCbAbEnBrElBtMtFrLbFvNhGnCpAtCnA|E|B`Ab@Wb@CTEd@@\\CPIFs@DMDAFDp@@b@', NULL, '2021-12-14 08:59:40', '2021-12-14 12:31:36', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1573, 'KWD565671', 289, 0, 56, 1, 5745, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 6.20, 61.55, '', '175 Kudu Rd, Lusaka, Zambia', -15.41014740, 28.34915430, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-14 09:41:19', NULL, NULL, NULL, 0, 0, 0, 0, 'bz`}Acz_lDj@E^IRMHh@n@|En@lFh@pEBT_@BoDd@{BZ_Gv@UD^rBnDpRRhABh@Gf@YfAo@fCu@dD[bBqAzIsAdMq@rFG^G^M`AKz@_@dCM~@AHe@fEa@tCe@lE?nCB|@TnCd@|ARb@h@dApAhCpAhCTb@HN|E~J~AxCPXqDt@DTC^IvCKb@oBvE{IdS_@bAIXSr@Sr@e@fBkAnEwAhF[rAE\\E|BKpGARg@CeBAy@BeAF_Db@_B`@kA^cAd@aAd@k@\\aAv@eDrCSPMJYXYXG@QFMLYVs@p@w@t@iAiA?ODOrAqAXUCQwE{F', NULL, '2021-12-14 09:40:43', '2021-12-14 09:41:27', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1574, 'KWD236751', 289, 134, 134, 1, 4050, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 5.39, 53.40, '', 'Honeybed lodge, 24 Olive Road, Salama Park Lusaka ZM, Lusaka 10101, Zambia', -15.39749760, 28.38583280, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-14 10:28:21', NULL, '2021-12-14 10:29:31', '2021-12-14 10:32:05', 1, 1, 0, 0, 'dj~|AwbglDcAeFWqAyBd@eAH_CEgC?wA?kC@yD?aM?mCASCSKa@[]Og@Gc@@gETcIXwGR{DLeABDW`BgJpAaH\\qBz@aFLaA?_@E?Y@gFeA_GoAeH_BqCa@aG_AcDo@y@Ow@Iy@?oBBw@J[FKBsBr@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EoB}L]iBUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-14 10:28:21', '2021-12-14 10:32:20', 'NO', '2', 0.00000000, 0.00000000, 0.00000000),
(1575, 'KWD518602', 289, 123, 123, 1, 7325, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 6.32, 62.85, '', '175 Kudu Rd, Lusaka, Zambia', -15.41011790, 28.34913880, 'Madison General Insurance Company Zambia Limited, 318 Independence Avenue Lusaka ZM, Lusaka 10101, Zambia', -15.42654410, 28.31443400, '2021-12-14 11:01:09', NULL, '2021-12-14 11:02:43', '2021-12-14 11:02:54', 1, 1, 0, 0, 'bz`}Acz_lDj@E^IRMHh@n@|En@lFh@pE^jCrBpQRjAbAhIfAxId@fDP^HF`@L`Cb@zEn@pFr@dIlA`H|@`Df@v@R|C~@~@\\|@T`AFB??QBYV]VMRC`@HXTHRDX?f@AXQ`B?Zx@`GlBhOV~C?~@?|@IrAc@bCi@jBuArEsBxGoDnLpA`@\\s@JULMvFiBbJuCVKp@SbBi@|Ae@dBg@p@SlJ_DxDoAl@?cBtFwC~JaDbKyBhHuFjQqB~G', NULL, '2021-12-14 11:01:00', '2021-12-14 11:03:21', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1576, 'KWD586084', 289, 134, 134, 1, 6363, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 11.45, 114.62, '', 'Honeybed lodge, 24 Olive Road, Salama Park Lusaka ZM, Lusaka 10101, Zambia', -15.39749760, 28.38583280, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-14 11:03:50', NULL, '2021-12-14 11:10:57', '2021-12-14 11:11:01', 1, 1, 0, 0, 'dj~|AwbglDcAeFWqAyBd@eAH_CEgC?wA?kC@yD?aM?mCASCSKa@[]Og@Gc@@gETcIXwGR{DLeABQ~@qBpKYxAQRUFaABu@@SRE^Qh@gD`KiC~HuEnNkHpTi@`B[^q@b@vBtL~BfL`@fBrCnIdEzLl@n@TTJ^?`@F|@H\\jA|Dh@lBfCfNdCtNjBnKx@rD~AjIhAzGl@|CfGx]VhAp@xDDVFlAP\\FDJHHT@ZAJGNH`@D\\\\nAx@rEv@fEPrAXdDFbDI|ESlK[jOMpHBfBRtCjA~Lj@lGt@zIVtC^zEVbDTbC^rBd@`C\\lAh@zAj@nA|@jBbAhBhBfCpDhEzEjFrDtEjK~LhMrO~AnBOLsCkDYBSFq@j@O@KGMUCICGUPCB?DDJxB`CvAdB', NULL, '2021-12-14 11:03:50', '2021-12-14 11:12:51', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1577, 'KWD648782', 289, 134, 134, 1, 2334, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 11.45, 114.62, '', 'Honeybed lodge, 24 Olive Road, Salama Park Lusaka ZM, Lusaka 10101, Zambia', -15.39749760, 28.38583280, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-14 11:13:38', NULL, NULL, NULL, 0, 0, 0, 0, 'dj~|AwbglDcAeFWqAyBd@eAH_CEgC?wA?kC@yD?aM?mCASCSKa@[]Og@Gc@@gETcIXwGR{DLeABQ~@qBpKYxAQRUFaABu@@SRE^Qh@gD`KiC~HuEnNkHpTi@`B[^q@b@vBtL~BfL`@fBrCnIdEzLl@n@TTJ^?`@F|@H\\jA|Dh@lBfCfNdCtNjBnKx@rD~AjIhAzGl@|CfGx]VhAp@xDDVFlAP\\FDJHHT@ZAJGNH`@D\\\\nAx@rEv@fEPrAXdDFbDI|ESlK[jOMpHBfBRtCjA~Lj@lGt@zIVtC^zEVbDTbC^rBd@`C\\lAh@zAj@nA|@jBbAhBhBfCpDhEzEjFrDtEjK~LhMrO~AnBOLsCkDYBSFq@j@O@KGMUCICGUPCB?DDJxB`CvAdB', NULL, '2021-12-14 11:13:38', '2021-12-14 11:14:50', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1578, 'KWD721452', 170, 0, 97, 1, 7525, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 13.75, 137.90, '', 'Unnamed Road, Lusaka, Zambia', -15.39811820, 28.38535610, 'Chalala Mall, Off Ring Road, Lusaka, Zambia', -15.46602650, 28.34278230, '2021-12-14 11:19:28', NULL, NULL, NULL, 0, 0, 0, 0, 'zl~|AiaglDbC[a@mCjCc@YgBa@iC_@}BaAaG_@cCn@WvCmA@wH?{BAyCd@Ap@COoAACdCYzIeAzDe@zAWzB|D|HzLzDnGlCxEzGnKbCtDd@v@d@v@hAfBx@nALRFTRl@b@rAjArDPj@Tj@J^Bd@Ab@MhAOfAUfAQfAa@|Bg@nCEb@A`@@THb@R^VZf@p@xAlAlB|AV\\T\\^`At@tBt@tBpAxDRx@X~@n@`Cp@~Bb@|BF^t@~F~Ks@pG[d@L|@RN@tASh@Bv@JlKtBdKpBxCTpCh@xKvBbEv@`HfArARALCXEXIt@WrBUjBc@hEmArJq@zF{@~G_@vCMjAGd@c@fEi@`EQxBi@rE~RfCzC`@~Fn@xIpAr@PpClAx@ZxBfAbBx@xAj@bDxAbAz@^f@bGjHn@n@d@RfA^RHr@p@f@l@Zr@Zv@`A`ChG~OnAtCl@YtB{@nF}BzCqAdAa@f@[fA_@dFyBxF}B|CyArD{AhBk@zDqA`G{BdHyC|FmCn@U`@In@AdAHnHRj@Ap@DhBDtDH`@JlC`AVF^@nC@T@?PI|BMrEk@jSe@~PGbFlEEpH?P?BaC', NULL, '2021-12-14 11:19:07', '2021-12-14 11:22:28', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1579, 'KWD135210', 170, 123, 123, 1, 5558, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 7.64, 76.13, '', 'Cozy Lodge Zambia, Plot 225 Kudu Rd, Lusaka, Zambia', -15.41068230, 28.34959730, 'Chalala SDA Church, Chalala,, Lusaka, Zambia', -15.45301910, 28.37199820, '2021-12-14 11:23:40', NULL, '2021-12-14 11:24:39', '2021-12-14 11:25:56', 1, 1, 0, 0, '`|`}Aa``lDzAfLxA~L^jCp@bG`AlI?D|@QhFy@jGy@|Fu@`LcBxGeA|BYdEi@rCFnFJ`EJxARjMbBrKvA|@Nv@yAzEgKtLcXDKN[L[\\u@z@mBz@kBbFeLvC_H~C_ItFwM~Nq^vDgJrDsIl@oAl@cAhC}DDGLS^k@|@sA|@yANUnBuC`CeDvBsBnEmDjFeE`MyJPOB@t@f@dAxAxAvBJJr@fAVVNPl@x@^f@FTVZh@`@h@\\kAt@', NULL, '2021-12-14 11:23:40', '2021-12-14 12:03:28', 'NO', '1', 0.00000000, 0.00000000, 0.00000000),
(1580, 'KWD750042', 170, 135, 135, 1, 2412, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 6.57, 65.34, '', 'Cozy Lodge Zambia, Plot 225 Kudu Rd, Lusaka, Zambia', -15.41068230, 28.34959730, 'Rhodes Park School, Sibweni Rd, Lusaka, Zambia', -15.40165580, 28.29980040, '2021-12-14 12:04:07', NULL, '2021-12-14 12:04:50', '2021-12-14 12:06:36', 1, 1, 0, 0, '`|`}Aa``lDzAfLxA~LBT_@BoDd@}Fv@sC`@`ClMlAvGRhABh@Gf@YfAo@fCu@dD[bBqAzIe@dEm@~Fo@jFCNG^E^O`AKz@_@dCM~@e@hE{@xGKhA?nCJ~BLlA`@rAFPRb@j@fApAfCpAhCTd@`FdK~AxCPXqDt@DTC^IvCKb@oBvE{IdSe@nAIXQr@Sr@e@hBmApEg@hBQr@IXM`@[rAE\\E|BKpGARg@CeBA_CJ_Db@_B`@kA^cAd@aAd@k@\\aAv@eDrC[VKLYV[TQFGFKJYVu@p@w@t@u@r@YVEFfAjArRrUr@z@', NULL, '2021-12-14 12:04:07', '2021-12-14 12:09:52', 'NO', '1', 0.00000000, 0.00000000, 0.00000000),
(1581, 'KWD165733', 289, 135, 135, 1, 2764, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 6.20, 61.55, '', '175 Kudu Rd, Lusaka, Zambia', -15.41011380, 28.34921530, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-14 12:55:21', NULL, '2021-12-14 12:55:56', '2021-12-14 13:01:32', 1, 1, 0, 0, 'bz`}Acz_lDj@E^IRMHh@n@|En@lFh@pEBT_@BoDd@{BZ_Gv@UD^rBnDpRRhABh@Gf@YfAo@fCu@dD[bBqAzIsAdMq@rFG^G^M`AKz@_@dCM~@AHe@fEa@tCe@lE?nCB|@TnCd@|ARb@h@dApAhCpAhCTb@HN|E~J~AxCPXqDt@DTC^IvCKb@oBvE{IdS_@bAIXSr@Sr@e@fBkAnEwAhF[rAE\\E|BKpGARg@CeBAy@BeAF_Db@_B`@kA^cAd@aAd@k@\\aAv@eDrCSPMJYXYXG@QFMLYVs@p@w@t@iAiA?ODOrAqAXUCQwE{F', NULL, '2021-12-14 12:55:21', '2021-12-14 13:01:50', 'NO', '5', 0.00000000, 0.00000000, 0.00000000),
(1582, 'KWD537519', 170, 0, 57, 1, 3872, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 9.67, 96.65, '', 'Cozy Lodge Zambia, Plot 225 Kudu Rd, Lusaka, Zambia', -15.41068230, 28.34959730, 'Town Center Market, Chiparamba Rd, Lusaka, Zambia', -15.41803190, 28.27977420, '2021-12-14 13:02:35', NULL, NULL, NULL, 0, 0, 0, 0, '`|`}Aa``lDzAfLxA~L^jCp@bG`AlIRjAjCbTd@fDP^HF`@L`Cb@hJnA`TtCjEp@rCx@`Cv@|@T`AFB??QBYV]VMRC`@HXTHRDX?f@AXQ`B?ZfDjWV~C?~@?|@IrAc@bCi@jBuArEgFtPsCpJy@hC]hA}@pC{@hCeE|Nc@pAW`@a@f@}@d@m@NcBJwANSHADCDOBEAQB_@N_Av@m@n@g@dAUh@WfAm@hDiBrJaG~[g@pCIvA?l@LRD@JFJNHV?ZALL\\NRh@\\dIzEdMhHPPeB`DsKvR{@dBIXEVIxAI`Eu@x`@FPLpB|AlOr@hJN~Bb@nETjBB`@M@}Fd@b@jHj@GbJw@tD[', NULL, '2021-12-14 12:58:58', '2021-12-14 13:03:47', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1583, 'KWD592355', 289, 134, 134, 1, 6966, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 12.41, 124.32, '', 'Honeybed lodge, 24 Olive Road, Salama Park Lusaka ZM, Lusaka 10101, Zambia', -15.39749760, 28.38583280, 'Garden Park, Lusaka, Zambia', -15.38777050, 28.29514190, '2021-12-14 13:03:39', NULL, '2021-12-14 13:04:33', '2021-12-14 13:06:01', 1, 1, 0, 0, 'dj~|AwbglDcAeFWqAyBd@eAH_CEgC?wA?kC@yD?aM?mCASCSKa@[]Og@Gc@@gETcIXwGR{DLeABQ~@qBpKYxAQRUFaABu@@SRE^Qh@gD`KiC~HuEnNkHpTi@`B[^q@b@vBtL~BfL`@fBrCnIdEzLl@n@TTJ^?`@F|@H\\jA|Dh@lBfCfNdCtNjBnKx@rD~AjIhAzGl@|CfGx]VhAp@xDDVFlAP\\FDJHHT@ZAJGNH`@D\\\\nAx@rEv@fEPrAXdDFbDI|ESlK[jOMpHBfBRtCjA~Lj@lGt@zIVtC^zEBDBNn@hFVnB|@bEl@rBZt@Zd@LBZRJPDRATCLKPOHKBU?GCICe@H_@Dg@^qHrFoBvBe@p@i@|@Ob@Iz@KpBg@xJ}Ax[[vHy@rPaBj[ArA?`AF~@Nv@Tb@xCpCpEhEnBdB`@\\', NULL, '2021-12-14 13:03:39', '2021-12-14 15:51:04', 'NO', '1', 0.00000000, 0.00000000, 0.00000000),
(1584, 'KWD811955', 289, 135, 135, 1, 9389, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 5.80, 57.52, '', 'Unnamed Road, Lusaka, Zambia', -15.39811920, 28.38532520, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-14 18:09:22', NULL, '2021-12-14 18:10:05', '2021-12-14 18:10:09', 1, 1, 0, 0, 'jk~|Au~flDr@hDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-14 18:09:22', '2021-12-14 18:14:56', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1585, 'KWD902140', 289, 123, 123, 1, 9052, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 14.68, 147.33, '', 'Unnamed Road, Lusaka, Zambia', -15.39812330, 28.38530910, 'DHL main Office, 3039 Makishi Rd, Lusaka, Zambia', -15.41385330, 28.28932830, '2021-12-14 18:15:16', NULL, '2021-12-14 18:16:17', '2021-12-14 18:16:31', 1, 1, 0, 0, 'lk~|As~flDp@fDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zE@P\\hELjAJf@x@lE\\lAh@zAnApCx@xAb@x@hBfCnGrH|B`CT\\|HnJjFfGhMrOtBhCd@h@tEtFj@v@zDtEtDfEzC|DzAfBfBtB`ArA`BhCd@`AbAlCf@~AV|@b@bC\\nCF|@r@nIbA~LZhEXvChAlNp@pHtBYtC_@fCSnM_AfIm@lBOAEMqB', NULL, '2021-12-14 18:15:16', '2021-12-14 18:17:03', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1586, 'KWD693128', 289, 0, 97, 1, 3609, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 14.35, 144.00, '', 'Unnamed Road, Lusaka, Zambia', -15.39807540, 28.38533200, 'Waterworks Plaza, Lusaka, Zambia', -15.45537210, 28.32083630, '2021-12-14 18:19:51', NULL, NULL, NULL, 0, 0, 0, 0, 'jk~|Ay~flDaCuLyBd@c@{CmAsIjAWrDy@lEaAfEeB@cL?}AAkA`@At@CQsA|SeCzAW?FzE|HpB|CnElHxBjDpDfGlFlInBzCd@x@f@v@fAdBx@nATh@Pl@b@rAjArDRj@Rj@BFFb@@d@Eb@MhAQfAg@nCa@|Be@nCCv@Fb@J`@l@x@b@j@`BnAv@n@r@r@VZP^^`At@rBt@xBz@bCXdAJ^V~@p@`Cl@zBd@`CDZt@zFtEYpLs@v@?b@Px@NL?vASv@FdUnEnB^xCTrFdAnNnCrDj@lEr@CXIt@Ir@WtBUhBc@jEkAhJs@zF{@~G]vCOjAa@vDKnAg@tD_@pDYhCh@HhOlBnDd@jD`@jCXfGz@zBb@r@V`DtA|E`ChEfBr@\\b@\\^\\V^x@~@pFrG^X`AZn@VzA~A^x@`DhInA~C`E~JBLsAn@gGdCkClAq@XJ|@j@vKl@xMfCzh@|Az[HrC|@BzA@jA?bACr@IjB[j@MlA]lAc@n@c@p@Wl@S~@Qj@G[jCu@nC@@D@D@JBVH|C`AbBf@|B`AbAv@TRhAxAt@tANX|A~ArAlAjAvArFpG`ApA|AsE|A`AjA~@lDpB', NULL, '2021-12-14 18:17:26', '2021-12-14 18:20:13', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1587, 'KWD746370', 289, 135, 135, 1, 5991, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 14.68, 147.35, '', 'Unnamed Road, Lusaka, Zambia', -15.39803590, 28.38529590, 'DHL main Office, 3039 Makishi Rd, Lusaka, Zambia', -15.41385330, 28.28932830, '2021-12-14 18:37:15', NULL, '2021-12-14 18:38:14', '2021-12-14 21:57:40', 1, 1, 0, 0, 'lk~|Au~flDp@hDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zE@P\\hELjAJf@x@lE\\lAh@zAnApCx@xAb@x@hBfCnGrH|B`CT\\|HnJjFfGhMrOtBhCd@h@tEtFj@v@zDtEtDfEzC|DzAfBfBtB`ArA`BhCd@`AbAlCf@~AV|@b@bC\\nCF|@r@nIbA~LZhEXvChAlNp@pHtBYtC_@fCSnM_AfIm@lBOAEMqB', NULL, '2021-12-14 18:37:15', '2021-12-14 21:58:21', 'NO', '19', 0.00000000, 0.00000000, 0.00000000),
(1588, 'KWD735431', 290, 0, 130, 1, 8079, 0, 'CANCELLED', 'USER', 'gvb', 'CASH', 0, 410.40, 4148.07, '', 'C9VX+39X, Block F State Life Phase 1 State Life, Lahore, Punjab, Pakistan', 31.44283898, 74.39840945, 'Phase 7, Phase 7 Bahria Town, Rawalpindi, Islamabad, Islamabad Capital Territory, Pakistan', 33.52555030, 73.11283130, '2021-12-14 18:51:11', NULL, NULL, NULL, 0, 0, 0, 0, '_e|~Dy}aeMcVjCaIbAoE`TxBpO}@Oef@yJ{BeD`Xi@fFcq@uXytAsvAymBk_B~Kog@P_c@|[}XbQuwAv@i{AeBwiA{L_v@i[c`@sQok@eCacA{@a_As@yi@jFw~A~q@wq@lm@zEry@t[xa@_\\jR{u@zd@if@bv@sZldBkVv~AksBz}B{uAxh@yvAfGsf@LwaAtVgH`u@iBds@vItaDz^neB|z@x{Enk@huDxHfJjAeK{^tU}XdgA{o@l_Bmb@~t@m_B~aCqq@pdA_b@jnAkp@taF_\\trBwW`xDgIlmBqXljDcqAv|DowBjkG_yAnxG_uCtrKcj@`zCqx@ryB_v@dtCejArtBitArlH}sC~pJccAxtEgc@taB_WpjCNtyHk]~sQqFtqEkEraCya@x}CoJ~nF{HbuBec@`iLi^r~CqXr|Awk@xjAgt@dnAg}Aj~@q{A~R}~Atl@}tFtvBqkGnj@{{Exv@c}ApKu~Anu@ovDttA}{ArQuqAfBchArRslBFkbEd@uoBfHmuApR{pF~iC}pBpcBc|A|i@_kFziDucAh|AylAnuCoiCnhFk|AlnBepAfyAqiAxz@wkHf~BytGtiCqyCj}@k_Aj`@ch@xj@m}@voAu[f`AjKnKuObLuH`[eUqLe_@y]_VfBkIjGcbAmcAeZUt@eH_A}IePjIeXcYiXrXsg@``@yiB|RotA`K_gCdb@am@dWg]fEmN~PmJvdA}RrRgf@pJurAdp@eRjXkA`f@tJ~mBaNzmAkXj`@ug@tZu_AyPagAtDmbA`XarB~ZgpCs@y~AtFyq@`Fin@mN{aAqiAmyAstBu_@}@}}@nd@uzA`m@ilApU{e@dTyo@~t@qh@n]mt@lVetBv\\{gElb@_sEjx@ilBfPki@e\\wx@Liv@~Rgb@fMqZ_PoqAujCyUiTmdCso@_tAgV}pAku@w`AmiBwS}s@k_@c`@{oA{dCagAeuBkaBkuBk_CgsAuvAgSweAmJc{@ak@sfCwiCwoAg[kvBiXgjBsAgkA{n@yn@iP}rAbKod@hGs`@qPmp@ek@inC}Foh@sF}x@_t@i}Bq~Ci`CgnCc]yXiy@yI}c@sOeb@x@enAxtAoeDzaC|D`G~BgMmSup@e\\cRqVmf@ggAa`Cwb@gzAgo@ucA__@om@m@sRnC_N{Rga@yi@mqAoDkExIpBvkAiYfTaDlS{g@`V}a@pUuz@vnAo}F|i@afBze@qx@ri@q~@j_Byu@|c@k}@xYy~@tbAuk@`Zum@kA~Uty@{S|RnA`Il@zH{LzAF', NULL, '2021-12-14 18:51:11', '2021-12-14 18:51:20', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1589, 'KWD741507', 290, 0, 130, 1, 8256, 0, 'CANCELLED', 'USER', 'gg', 'CASH', 0, 410.40, 4148.06, '', 'C9VX+39X, Block F State Life Phase 1 State Life, Lahore, Punjab, Pakistan', 31.44285517, 74.39842805, 'Phase 7, Phase 7 Bahria Town, Rawalpindi, Islamabad, Islamabad Capital Territory, Pakistan', 33.52555030, 73.11283130, '2021-12-14 18:51:39', NULL, NULL, NULL, 0, 0, 0, 0, 'ae|~Dy}aeMaVjCaIbAoE`TxBpO}@Oef@yJ{BeD`Xi@fFcq@uXytAsvAymBk_B~Kog@P_c@|[}XbQuwAv@i{AeBwiA{L_v@i[c`@sQok@eCacA{@a_As@yi@jFw~A~q@wq@lm@zEry@t[xa@_\\jR{u@zd@if@bv@sZldBkVv~AksBz}B{uAxh@yvAfGsf@LwaAtVgH`u@iBds@vItaDz^neB|z@x{Enk@huDxHfJjAeK{^tU}XdgA{o@l_Bmb@~t@m_B~aCqq@pdA_b@jnAkp@taF_\\trBwW`xDgIlmBqXljDcqAv|DowBjkG_yAnxG_uCtrKcj@`zCqx@ryB_v@dtCejArtBitArlH}sC~pJccAxtEgc@taB_WpjCNtyHk]~sQqFtqEkEraCya@x}CoJ~nF{HbuBec@`iLi^r~CqXr|Awk@xjAgt@dnAg}Aj~@q{A~R}~Atl@}tFtvBqkGnj@{{Exv@c}ApKu~Anu@ovDttA}{ArQuqAfBchArRslBFkbEd@uoBfHmuApR{pF~iC}pBpcBc|A|i@_kFziDucAh|AylAnuCoiCnhFk|AlnBepAfyAqiAxz@wkHf~BytGtiCqyCj}@k_Aj`@ch@xj@m}@voAu[f`AjKnKuObLuH`[eUqLe_@y]_VfBkIjGcbAmcAeZUt@eH_A}IePjIeXcYiXrXsg@``@yiB|RotA`K_gCdb@am@dWg]fEmN~PmJvdA}RrRgf@pJurAdp@eRjXkA`f@tJ~mBaNzmAkXj`@ug@tZu_AyPagAtDmbA`XarB~ZgpCs@y~AtFyq@`Fin@mN{aAqiAmyAstBu_@}@}}@nd@uzA`m@ilApU{e@dTyo@~t@qh@n]mt@lVetBv\\{gElb@_sEjx@ilBfPki@e\\wx@Liv@~Rgb@fMqZ_PoqAujCyUiTmdCso@_tAgV}pAku@w`AmiBwS}s@k_@c`@{oA{dCagAeuBkaBkuBk_CgsAuvAgSweAmJc{@ak@sfCwiCwoAg[kvBiXgjBsAgkA{n@yn@iP}rAbKod@hGs`@qPmp@ek@inC}Foh@sF}x@_t@i}Bq~Ci`CgnCc]yXiy@yI}c@sOeb@x@enAxtAoeDzaC|D`G~BgMmSup@e\\cRqVmf@ggAa`Cwb@gzAgo@ucA__@om@m@sRnC_N{Rga@yi@mqAoDkExIpBvkAiYfTaDlS{g@`V}a@pUuz@vnAo}F|i@afBze@qx@ri@q~@j_Byu@|c@k}@xYy~@tbAuk@`Zum@kA~Uty@{S|RnA`Il@zH{LzAF', NULL, '2021-12-14 18:51:39', '2021-12-14 18:51:52', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1590, 'KWD755463', 290, 0, 130, 1, 4513, 0, 'CANCELLED', 'USER', 'yy', 'CASH', 0, 410.40, 4148.06, '', 'C9VX+39X, Block F State Life Phase 1 State Life, Lahore, Punjab, Pakistan', 31.44285512, 74.39842994, 'Phase 7, Phase 7 Bahria Town, Rawalpindi, Islamabad, Islamabad Capital Territory, Pakistan', 33.52555030, 73.11283130, '2021-12-14 18:52:07', NULL, NULL, NULL, 0, 0, 0, 0, 'ae|~Dy}aeMaVjCaIbAoE`TxBpO}@Oef@yJ{BeD`Xi@fFcq@uXytAsvAymBk_B~Kog@P_c@|[}XbQuwAv@i{AeBwiA{L_v@i[c`@sQok@eCacA{@a_As@yi@jFw~A~q@wq@lm@zEry@t[xa@_\\jR{u@zd@if@bv@sZldBkVv~AksBz}B{uAxh@yvAfGsf@LwaAtVgH`u@iBds@vItaDz^neB|z@x{Enk@huDxHfJjAeK{^tU}XdgA{o@l_Bmb@~t@m_B~aCqq@pdA_b@jnAkp@taF_\\trBwW`xDgIlmBqXljDcqAv|DowBjkG_yAnxG_uCtrKcj@`zCqx@ryB_v@dtCejArtBitArlH}sC~pJccAxtEgc@taB_WpjCNtyHk]~sQqFtqEkEraCya@x}CoJ~nF{HbuBec@`iLi^r~CqXr|Awk@xjAgt@dnAg}Aj~@q{A~R}~Atl@}tFtvBqkGnj@{{Exv@c}ApKu~Anu@ovDttA}{ArQuqAfBchArRslBFkbEd@uoBfHmuApR{pF~iC}pBpcBc|A|i@_kFziDucAh|AylAnuCoiCnhFk|AlnBepAfyAqiAxz@wkHf~BytGtiCqyCj}@k_Aj`@ch@xj@m}@voAu[f`AjKnKuObLuH`[eUqLe_@y]_VfBkIjGcbAmcAeZUt@eH_A}IePjIeXcYiXrXsg@``@yiB|RotA`K_gCdb@am@dWg]fEmN~PmJvdA}RrRgf@pJurAdp@eRjXkA`f@tJ~mBaNzmAkXj`@ug@tZu_AyPagAtDmbA`XarB~ZgpCs@y~AtFyq@`Fin@mN{aAqiAmyAstBu_@}@}}@nd@uzA`m@ilApU{e@dTyo@~t@qh@n]mt@lVetBv\\{gElb@_sEjx@ilBfPki@e\\wx@Liv@~Rgb@fMqZ_PoqAujCyUiTmdCso@_tAgV}pAku@w`AmiBwS}s@k_@c`@{oA{dCagAeuBkaBkuBk_CgsAuvAgSweAmJc{@ak@sfCwiCwoAg[kvBiXgjBsAgkA{n@yn@iP}rAbKod@hGs`@qPmp@ek@inC}Foh@sF}x@_t@i}Bq~Ci`CgnCc]yXiy@yI}c@sOeb@x@enAxtAoeDzaC|D`G~BgMmSup@e\\cRqVmf@ggAa`Cwb@gzAgo@ucA__@om@m@sRnC_N{Rga@yi@mqAoDkExIpBvkAiYfTaDlS{g@`V}a@pUuz@vnAo}F|i@afBze@qx@ri@q~@j_Byu@|c@k}@xYy~@tbAuk@`Zum@kA~Uty@{S|RnA`Il@zH{LzAF', NULL, '2021-12-14 18:52:07', '2021-12-14 18:52:32', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1591, 'KWD702646', 290, 0, 130, 1, 3974, 0, 'CANCELLED', 'USER', 'tgy', 'CASH', 0, 410.40, 4148.06, '', 'C9VX+39X, Block F State Life Phase 1 State Life, Lahore, Punjab, Pakistan', 31.44285550, 74.39843171, 'Phase 7, Phase 7 Bahria Town, Rawalpindi, Islamabad, Islamabad Capital Territory, Pakistan', 33.52555030, 73.11283130, '2021-12-14 18:52:47', NULL, NULL, NULL, 0, 0, 0, 0, 'ae|~Dy}aeMaVjCaIbAoE`TxBpO}@Oef@yJ{BeD`Xi@fFcq@uXytAsvAymBk_B~Kog@P_c@|[}XbQuwAv@i{AeBwiA{L_v@i[c`@sQok@eCacA{@a_As@yi@jFw~A~q@wq@lm@zEry@t[xa@_\\jR{u@zd@if@bv@sZldBkVv~AksBz}B{uAxh@yvAfGsf@LwaAtVgH`u@iBds@vItaDz^neB|z@x{Enk@huDxHfJjAeK{^tU}XdgA{o@l_Bmb@~t@m_B~aCqq@pdA_b@jnAkp@taF_\\trBwW`xDgIlmBqXljDcqAv|DowBjkG_yAnxG_uCtrKcj@`zCqx@ryB_v@dtCejArtBitArlH}sC~pJccAxtEgc@taB_WpjCNtyHk]~sQqFtqEkEraCya@x}CoJ~nF{HbuBec@`iLi^r~CqXr|Awk@xjAgt@dnAg}Aj~@q{A~R}~Atl@}tFtvBqkGnj@{{Exv@c}ApKu~Anu@ovDttA}{ArQuqAfBchArRslBFkbEd@uoBfHmuApR{pF~iC}pBpcBc|A|i@_kFziDucAh|AylAnuCoiCnhFk|AlnBepAfyAqiAxz@wkHf~BytGtiCqyCj}@k_Aj`@ch@xj@m}@voAu[f`AjKnKuObLuH`[eUqLe_@y]_VfBkIjGcbAmcAeZUt@eH_A}IePjIeXcYiXrXsg@``@yiB|RotA`K_gCdb@am@dWg]fEmN~PmJvdA}RrRgf@pJurAdp@eRjXkA`f@tJ~mBaNzmAkXj`@ug@tZu_AyPagAtDmbA`XarB~ZgpCs@y~AtFyq@`Fin@mN{aAqiAmyAstBu_@}@}}@nd@uzA`m@ilApU{e@dTyo@~t@qh@n]mt@lVetBv\\{gElb@_sEjx@ilBfPki@e\\wx@Liv@~Rgb@fMqZ_PoqAujCyUiTmdCso@_tAgV}pAku@w`AmiBwS}s@k_@c`@{oA{dCagAeuBkaBkuBk_CgsAuvAgSweAmJc{@ak@sfCwiCwoAg[kvBiXgjBsAgkA{n@yn@iP}rAbKod@hGs`@qPmp@ek@inC}Foh@sF}x@_t@i}Bq~Ci`CgnCc]yXiy@yI}c@sOeb@x@enAxtAoeDzaC|D`G~BgMmSup@e\\cRqVmf@ggAa`Cwb@gzAgo@ucA__@om@m@sRnC_N{Rga@yi@mqAoDkExIpBvkAiYfTaDlS{g@`V}a@pUuz@vnAo}F|i@afBze@qx@ri@q~@j_Byu@|c@k}@xYy~@tbAuk@`Zum@kA~Uty@{S|RnA`Il@zH{LzAF', NULL, '2021-12-14 18:52:47', '2021-12-14 18:53:09', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1592, 'KWD854621', 291, 123, 123, 1, 5461, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 9.97, 99.77, '', 'Unnamed Road, Lusaka, Zambia', -15.39816820, 28.38532380, 'Novare Pinnacle Shopping Mall, H89R+5MJ, Lusaka, Zambia', -15.43204690, 28.34163410, '2021-12-14 19:24:31', NULL, '2021-12-14 19:25:25', '2021-12-14 19:27:53', 1, 1, 0, 0, 'bm~|AkaglDzBYa@mCjCc@YgBa@iC_@}BaAaG_@cCn@WvCmA@wH?{BAyCd@Ap@COoAACdCYzIeAzDe@zAWzB|D|HzLzDnGlCxEzGnKbCtDd@v@d@v@hAfBx@nALRFTRl@b@rAjArDPj@Tj@J^Bd@Ab@MhAOfAUfAQfAa@|Bg@nCEb@A`@@THb@R^VZf@p@xAlAlB|AV\\T\\^`At@tBt@tBpAxDRx@X~@n@`Cp@~Bb@|BF^t@~F~Ks@pG[d@L|@RN@tASh@Bv@JlKtBdKpBxCTpCh@xKvBbEv@`HfArARALCXEXIt@WrBUjBc@hEmArJq@zF{@~G_@vCMjAGd@c@fEi@`EQxBi@rEeChRG`@M`A[fCw@bGu@jGM`A{ChVeAfIbBRtFv@jJlAvEp@bAj@~G|DPFFe@Tk@X_@VQDE', NULL, '2021-12-14 19:24:31', '2021-12-14 19:28:46', 'NO', '2', 0.00000000, 0.00000000, 0.00000000),
(1593, 'KWD278298', 170, 0, 134, 1, 2050, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 9.67, 45.00, '', 'Unnamed Road, Lusaka, Zambia', -15.39818040, 28.38535920, 'Ibex Hill Baptist Church, Main Street, Lusaka, Zambia', -15.40207990, 28.40089470, '2021-12-14 19:52:30', NULL, NULL, NULL, 0, 0, 0, 0, 'fm~|AkaglDvBYa@mCjCc@YgBa@iC_@}BaAaG_@cCn@WvCmA@wH?{BAyCd@Ap@COoAACdCYzIeAzDe@zAWe@eDSaBYkB}@yFIm@ScBU}AaA}G', NULL, '2021-12-14 19:51:17', '2021-12-14 19:53:23', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1594, 'KWD472805', 170, 123, 123, 1, 8569, 0, 'CANCELLED', 'PROVIDER', '', 'CASH', 0, 9.67, 45.00, '', 'Unnamed Road, Lusaka, Zambia', -15.39818040, 28.38535920, 'Ibex Hill Baptist Church, Main Street, Lusaka, Zambia', -15.40207990, 28.40089470, '2021-12-14 19:51:20', NULL, NULL, NULL, 0, 0, 0, 0, 'fm~|AkaglDvBYa@mCjCc@YgBa@iC_@}BaAaG_@cCn@WvCmA@wH?{BAyCd@Ap@COoAACdCYzIeAzDe@zAWe@eDSaBYkB}@yFIm@ScBU}AaA}G', NULL, '2021-12-14 19:51:20', '2021-12-14 19:53:04', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1595, 'KWD337861', 289, 135, 135, 1, 5453, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 15.34, 200.24, '', 'Unnamed Road, Lusaka, Zambia', -15.39812390, 28.38523120, 'Kenneth Kaunda International Airport, Lusaka ZM ZM, Lusaka 10101, Zambia', -15.32539090, 28.44911240, '2021-12-14 23:04:40', NULL, '2021-12-14 23:05:15', '2021-12-14 23:05:20', 1, 1, 0, 0, 'pk~|Ac~flDl@vCeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@kCy@iASwAc@eFeCoKiFwE}BcD}A{JyE{J}EcI{D_LsF_FaC_GwC_LuFmX_NaGuCoBaAcCeAcA[eAWgAQw@IqCQsCMqH]gOo@mDScEOeOs@_c@mBeU_AyFWkC_@WG}Ac@gAc@c@Q{@i@QM{AeAu@u@o@m@Yc@s@cA{@iBs@qBUw@Mw@[yCG{A@oA`AqXrGwbB^mJJuCFu@FaAEUGUAOPc@Ho@?O`@wJFeBPCdGZdHVbFVxBH', NULL, '2021-12-14 23:04:40', '2021-12-14 23:05:45', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1596, 'KWD229789', 289, 135, 135, 1, 5964, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 11.85, 118.71, '', 'Unnamed Road, Lusaka, Zambia', -15.39807250, 28.38526917, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-14 23:10:52', NULL, '2021-12-14 23:11:51', '2021-12-14 23:12:14', 1, 1, 0, 0, 'nk~|Am~flDn@`DeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zE@P\\hELjAJf@x@lE\\lAh@zAnApCx@xAb@x@hBfCnGrH|B`CT\\|HnJjFfGhMrO~AnBOLsCkDYBSF]X[RG?KGQ_@CGUPCB?DDJxB`CvAdB', NULL, '2021-12-14 23:10:52', '2021-12-14 23:13:48', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1597, 'KWD999602', 291, 123, 123, 1, 2322, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 7.85, 78.34, '', 'Unnamed Road, Lusaka, Zambia', -15.39811223, 28.38529221, 'Liebherr Zambia Ltd, 175 Kudu Rd, Lusaka, Zambia', -15.41049910, 28.34952650, '2021-12-15 06:29:43', NULL, '2021-12-15 06:30:20', '2021-12-15 06:30:40', 1, 1, 0, 0, 'lk~|Ao~flDp@bDHKdBqBxDq@YiC_@}B_@{BaAgGaAaG_@cCn@WvCmA@wH?{BAyCd@Ap@COoAACdCYzIeAzDe@zAWzB|D|HzLzDnGlCxEzGnKtCpEd@v@nAnBx@nAZf@Pl@b@rAjArDf@vATt@Bd@Ab@MhAOfAUfA_@|Bg@nCSfAEb@A`@@THb@R^VZf@p@`@\\nB|At@n@V\\T\\^`A^bAl@bBnB|F`@xAn@~Bp@`Cf@|BN~@bC`RJl@n@xDDVHPLNbIxGjBbBaBvBwCvDmBfCGLAVFb@rB`I~A`HMPGRGpBELIFKBQ?eBKUbJH?JB|@@VFHHDN?`@Q|D@d@QPuFrEwFdEyHdG}CxBw@d@q@^_Bp@o@PNjAv@~F', NULL, '2021-12-15 06:28:31', '2021-12-15 06:32:16', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1598, 'KWD876095', 289, 135, 135, 1, 1038, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 6.40, 63.64, '', '175 Kudu Rd, Lusaka, Zambia', -15.41005040, 28.34951320, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-15 07:19:10', NULL, '2021-12-15 07:21:20', '2021-12-15 07:21:29', 1, 1, 0, 0, 'zu`}As``lDUAcALq@TOuA_@{BMiASAwBDCRXtJl@bQJdDLfAt@`EnDpRRhABh@Gf@YfAo@fCu@dD[bBqAzIsAdMq@rFG^M~@M`A]~BM`AG^AHe@fEa@tCe@lE?nCB|@TnCd@|ARb@Rb@j@dAh@dAlAdCj@fAHN|E~J~AxCPXqDt@DTC^IvCKb@oBvE{IdS_@bAIXSr@g@fBkAnEmArE[hA[rAE\\E|BKpGARg@CeBAy@BeAF_Db@_B`@kA^cAd@aAd@k@\\aAv@eDrCSPMJYXYXG@QFMLYVYXu@p@[ZiAiA?ODOrAqAXUCQwE{F', NULL, '2021-12-15 07:19:10', '2021-12-15 07:21:57', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1599, 'KWD316173', 289, 0, 97, 1, 3398, 0, 'CANCELLED', 'USER', 'No driver found ', 'CASH', 0, 10.61, 106.16, '', 'Honeybed lodge, 24 Olive Road, Salama Park Lusaka ZM, Lusaka 10101, Zambia', -15.39749760, 28.38583280, 'Woodlands Mall, Chindo Rd, Lusaka, Zambia', -15.43605270, 28.34142110, '2021-12-15 08:52:54', NULL, NULL, NULL, 0, 0, 0, 0, 'dj~|AwbglDcAeFWqAyBd@qBoNzA[hH_BfAWn@WvCmA@wH?{BAyCd@Ap@COoAACdCYzIeAzDe@zAWzB|DhEzGrB~CzDnGlCxEbCxDtGbKLTd@v@f@v@fAbBx@nAd@xAb@rAjArDh@vADRBd@Ab@Ed@OfASfAe@nCa@|BUfAMfA?v@Hb@R^l@v@b@d@bBrAv@n@p@t@T\\N^^bAl@bBhAfDt@vBLh@J^X~@n@`Cl@vBd@dCx@nG~Ks@pG[bB`@\\?fAQN?pANrWfFxCTpCh@xKvBbEv@`HfArARALCXIr@It@WtBU~Ae@tEiA~Iq@zF{@~G_@xCMjAi@bFi@`EQxBeBbNuAjKM`A[fCu@bGu@jGwB|Po@|EeAfIbBRtFv@tC^tEl@vEp@zCdBfEbCrAh@dAZzA\\t@NvCNlA?pBGtAKzEu@Os@@k@', NULL, '2021-12-15 08:50:27', '2021-12-15 08:53:20', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1600, 'KWD769136', 289, 135, 135, 1, 5845, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 11.35, 113.67, '', '175 Kudu Rd, Lusaka, Zambia', -15.41011340, 28.34921230, 'Joma School, Palm, Lusaka, Zambia', -15.36643340, 28.39998810, '2021-12-15 11:06:14', NULL, '2021-12-15 11:06:48', '2021-12-15 11:06:58', 1, 1, 0, 0, 'bz`}Acz_lDj@E^IRMHh@n@|En@lFh@pEBT_@BoDd@{BZ_Gv@UD^rBnDpRRhABh@Gf@YfAo@fCu@dDShAcH_AgFs@kBUu@Gs@?oABu@EqC]mAUcG}@kAKcLaBaB_@sAq@q@Wk@Os@MyDk@mIoA_LaBwGeAiDm@eF_AiFaAcBUi@CE?SKyAMc@Oi@[UKUEMDWHYLKTUPWBQGOKKQGYD_@FMJo@Do@Cg@W{Ac@iCkAmGq@cEqAkHuAwHkA_HwAcIo@uCi@yBSk@Oe@k@wBo@wCu@eEaB}IeCgNMa@o@gCw@cCc@o@UOKGIKK_@EcB{D_MoCsI_@iBmBmKUkAgB{JuAoHa@cDaAuNKmBg@_HS}Ao@oEiAaFaCuIaBoIqAoHcB{KiAoHeAcHuAoIaAcHg@_Du@}EoB}L]iBUo@SGQSGS?g@kCy@iASwAc@{BgAiB}@iArCM|@]xEKlA', NULL, '2021-12-15 11:06:14', '2021-12-15 11:07:49', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1601, 'KWD612633', 289, 135, 135, 1, 9428, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 4.00, 45.00, '', '37 OFF GREAT EAST RD GREAT EAST RD ZAMBIA, Lusaka, Zambia', -15.36632550, 28.40138070, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-15 18:55:12', NULL, '2021-12-15 18:55:45', '2021-12-15 18:56:08', 1, 1, 0, 0, '|ex|AkbjlD|Ah@`@\\PuBL}@hAsCdFdCvAb@hARjCx@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-15 18:55:12', '2021-12-15 18:56:50', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1602, 'KWD985453', 170, 0, 123, 1, 5137, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 9.89, 98.89, '', 'Unnamed Road, Lusaka, Zambia', -15.39816670, 28.38531610, 'Nyumba Yanga Market, Alex Chola Road, Lusaka, Zambia', -15.44316290, 28.35608810, '2021-12-15 21:50:37', NULL, NULL, NULL, 0, 0, 0, 0, 'bm~|AkaglDzBYa@mCjCc@YgBa@iC_@}BaAaG_@cCn@WvCmA@wH?{BAyCd@Ap@COoAACdCYzIeAzDe@zAWzB|D|HzLzDnGlCxEzGnKbCtDd@v@d@v@hAfBx@nALRFTRl@b@rAjArDPj@Tj@J^Bd@Ab@MhAOfAUfAQfAa@|Bg@nCEb@A`@@THb@R^VZf@p@xAlAlB|AV\\T\\^`At@tBt@tBpAxDRx@X~@n@`Cp@~Bb@|BF^t@~F~Ks@pG[d@L|@RN@tASh@Bv@JlKtBdKpBxCTpCh@xKvBbEv@`HfArARALCXEXIt@WrBUjBc@hEmArJq@zF{@~G_@vCMjAGd@c@fEi@`EQxBi@rE~RfCzC`@~Fn@xIpAr@PpClAx@ZPa@nB_Fn@_BnAyCD@`FlB|CjA~@ZlBd@n@HxBV`GJd@Hz@Zz@d@r@_Bn@cEFi@w@I', NULL, '2021-12-15 21:50:24', '2021-12-15 21:51:36', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1603, 'KWD908649', 170, 0, 97, 1, 5916, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 14.09, 141.33, '', 'Unnamed Road, Lusaka, Zambia', -15.39813920, 28.38525670, 'YMCA, Chilimbulu Rd, Lusaka, Zambia', -15.44157720, 28.31432280, '2021-12-15 22:00:19', NULL, NULL, NULL, 0, 0, 0, 0, 'nk~|Ag~flDn@zCHKdBqBxDq@YiC_@}B_@{BaAgGaAaG_@cCn@WvCmA@wH?{BAyCd@Ap@COoAACdCYzIeAzDe@zAWzB|D|HzLzDnGlCxEzGnKtCpEd@v@nAnBx@nAZf@Pl@b@rAjArDf@vATt@Bd@Ab@MhAOfAUfA_@|Bg@nCSfAEb@A`@@THb@R^VZf@p@`@\\nB|At@n@V\\T\\^`A^bAl@bBnB|F`@xAn@~Bp@`Cf@|BN~@t@~F~Ks@pG[d@L|@RN@tASh@Bv@JlKtBdKpBxCTpCh@xKvBbEv@`HfArARALCXEXIt@Ir@WtBe@hEg@hEk@nEY|BY|By@zG_@vCMjAGf@CPc@fEi@`EQxBi@rE~RfCzC`@~Fn@xIpAr@PpClAx@ZxBfAbBx@xAj@bDxAbAz@^f@bGjHn@n@d@RfA^RHr@p@f@l@Zr@Zv@`A`ChG~OrAbDsGpCeGjCJ|@N|Cf@rJbCvh@lBv`@X~FDzACj@W~AuAnEzBt@rAr@zA`@~GtBfBt@aBrF}C~JwFdRkDzK}@zCk@M', NULL, '2021-12-15 21:52:12', '2021-12-15 22:00:29', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1604, 'KWD303208', 291, 0, 134, 1, 6124, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 11.52, 115.40, '', 'Unnamed Road, Lusaka, Zambia', -15.39816610, 28.38532480, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-16 00:23:26', NULL, NULL, NULL, 0, 0, 0, 0, 'bm~|AkaglDkAPe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@{CdPEJWR[B[?aA@I@KHGHE^w@`CmEzMkGhRwF|PyAjEK\\W\\_@RUPBHfB`KbBtI~@bE~@~CtGpRLXJJf@f@HJN^B`@DbA|@xCr@jC|@jE|DtT|B|M|B`LpCjOxFn\\d@hCNf@T~AZzADt@Fl@NZDBJJJPBXARAFEFBJHf@Jb@\\vAX|AbArFPbAXnCPpDCxDWzK[nPMvGAjBJrC~@vJz@bJb@~EVlDh@zFZrE^zDR|AP~@p@|Cb@pAh@tApAnCd@z@pArBbBvBrFnGtB|BRVpNzP~EbGzJtLOLsCkDg@Fq@h@IFI?OKSc@YV?F~BhCvAdB', NULL, '2021-12-16 00:23:26', '2021-12-16 00:23:42', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1605, 'KWD741726', 291, 123, 123, 1, 6430, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 328.22, 3317.19, '', 'Unnamed Road, Lusaka, Zambia', -15.39801150, 28.38539480, 'Water Works, 2MG4+GGH, Ndola, Zambia', -12.97368010, 28.65636400, '2021-12-16 00:24:39', NULL, '2021-12-16 00:25:19', '2021-12-16 00:25:53', 1, 1, 0, 0, 'fl~|AeaglD}CiJ_Ih@sN@_TKqSIiPf@yDdQcLxSaTbm@hRnv@hCrIv\\hiB`DxQ|DhUe@vh@rFf_AhHjYuSnM_TlBwGs@qFzM}Md]cGb@iC|G@tFbAfBqGxPiH`RkF|OqI~SuFfXu@lD_In`@iHbh@{AL}dAoCwq@M}~@nCakBdGys@dAal@xC_t@lLosBp\\gqEft@u}Ezv@m{@p@wu@jMcuDfw@crApDsxBby@cl@pMgeBvi@ehAfj@ms@x_@_d@RyvAwEoo@oQqYfDkc@hSusBbSgx@lJwOfKuIxQmEtf@{Vd_DaLxy@iP~d@il@rz@co@jo@q`A`mAid@vo@uVlYcSdLyz@bb@k`@hYez@b]aqAr[cy@vVik@h[aWjS{cBdp@}~Adm@}v@fX{\\vAeeBLmtGxAex@aGkjAkYk_D_x@arBoi@o{@a[_~Awk@oYe^eYya@ol@mm@ooAqsAsmBcoCga@qk@uX}o@cP_TwV_Pek@eReo@sgAu[oaAgLyTo_@u^{Uif@ewAimCwSmKen@yHmSuMwr@}|AwfBe`E{|Ey~K{aDspHkU{e@cJ}G}q@i_@kzAqaB{OgIufA{J{\\cCsBOqe@_EgK_FyJuYqDsOuAcG{B{FiAqBgHca@kF_cAa_@sh@sCkBuY}EmaANcZlDiJu@_]{{AsGgNsj@ad@qmBa|Aie@e_@y{@m`@iuAgk@cc@uZamDqwCqPkBsh@jIeXm@sv@{RccB{WyaCmWk}Ais@ymBov@mfAe`@ob@{VesF_pBarCgt@seAaMyQgAs_BqJsbA_HySsL{zAgoAgi@aYibAc`@agB}r@ajBobBqiCgtAa|Aiq@k\\iEqoBr\\_eAda@eoBl~@}[jAkUe@c_Am@evBf@_jA\\gW`EwM`TgBdYeDn_@sQfO{pB]_tEJuH@qt@@oz@BerAlBay@hGyjCzR{rErd@{|@bJy\\pDu^~Ha\\dKsEv@iTlDqy@~MkLjBmqAb@ewEg@o}BlQmc@jFcvAlRmYrAgwDstAyUkFmkEsz@gwAqY}`Css@}gDciAyO}Fm|@{[kTqDasAl@u{BjAot@b@cpDdB}`BaNsbHwn@qqBmR}YRyX~Dow@bLoP`CciAjPidCn^scBmIykDuSse@qCya@kG_t@wRm|@wUkfBwd@qg@sLeSGqoAp@glA\\cRL_kAj@_dA}@onByGm_BmB_nB|Eyv@bE{_@fWub@~[cUjWqy@rsAqn@ncAmUj_@sy@dn@aHhEqBgB{[}NgeAsp@cMwGwMX{HxGoLzVmLeD', NULL, '2021-12-16 00:24:39', '2021-12-16 07:43:00', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1606, 'KWD671478', 291, 135, 135, 1, 8118, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 12.43, 124.57, '', '175 Kudu Rd, Lusaka, Zambia', -15.41015050, 28.34918120, 'Makeni Mall, Makeni, T2, Lusaka, Zambia', -15.45381920, 28.26621590, '2021-12-16 07:43:41', NULL, '2021-12-16 07:44:21', '2021-12-16 07:44:36', 1, 1, 0, 0, 'bz`}Acz_lDj@E^IRMHh@n@|En@lFh@pE^jCrBpQRjAbAhIfAxId@fDP^HF`@L`Cb@zEn@pFr@dIlA`H|@`Df@v@R|C~@~@\\|@T`AFB??QBYV]VMRC`@HXTHRDX?f@AXQ`B?Zx@`GlBhOV~C?~@?|@IrAc@bCi@jBuArEsBxGoDnLmC~I]fA}@rC{@fCaChIgA|Dc@pAW`@a@f@}@d@m@NcBJwANSH?@AV@JJ`AtAjGnGfZ`ClLNn@BA`@@VLJJHZCV]l@aAtAaApAAJE^Cd@fAbF@Fb@pBnClMvArGpAnG`BpIVz@j@nCLl@xDvR~A~Hr@jEvAtQz@rITfBPHNLFJ@DJAhFe@fBQr@Cv@AhBBpAPlBb@v@TdAh@|Ax@~@v@|@`Ap@bA|@bBjBpEl@rA`@j@f@r@|@~@t@n@r@f@pB`A|YzLxJ`E|ErBbCbAbEnBrElBtMtFrLbFvNhGnCpAtCnA|E|B`Ab@Wb@CTEd@@\\CPIFs@DMDAFDp@@b@', NULL, '2021-12-16 07:43:30', '2021-12-16 07:49:50', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1607, 'KWD898169', 289, 134, 134, 1, 4400, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 5.39, 53.40, '', 'Honeybed lodge, 24 Olive Road, Salama Park Lusaka ZM, Lusaka 10101, Zambia', -15.39749760, 28.38583280, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-16 09:54:16', NULL, '2021-12-16 10:01:39', '2021-12-16 10:01:42', 1, 1, 0, 0, 'dj~|AwbglDcAeFWqAyBd@eAH_CEgC?wA?kC@yD?aM?mCASCSKa@[]Og@Gc@@gETcIXwGR{DLeABDW`BgJpAaH\\qBz@aFLaA?_@E?Y@gFeA_GoAeH_BqCa@aG_AcDo@y@Ow@Iy@?oBBw@J[FKBsBr@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EoB}L]iBUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-16 09:54:16', '2021-12-16 11:28:40', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1608, 'KWD924320', 296, 0, 127, 1, 5876, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 4.00, 45.00, '', 'H7WX+H8V, Lusaka, Zambia', -15.40389560, 28.29765020, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-16 13:13:01', NULL, NULL, NULL, 0, 0, 0, 0, 'vr_}Aq{ukDe@iDIa@gA?UQg@q@k@T{@qBi@w@kSoVeBuBgAkA@CLKXYZYLMDEBAgAcACKBQPWxAqADIAIcBuBuBiC', NULL, '2021-12-16 13:13:01', '2021-12-16 13:13:10', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1609, 'KWD388695', 262, 0, 96, 1, 4831, 0, 'CANCELLED', 'USER', 'testing app', 'CASH', 0, 5.43, 53.86, '', 'H854+FH3, Lusaka, Zambia', -15.44198970, 28.30522460, 'Enock Kavu Road, Enock Kavu Rd, Lusaka, Zambia', -15.40935770, 28.30881340, '2021-12-17 08:38:30', NULL, NULL, NULL, 0, 0, 0, 0, 'l_g}A_iwkDMDo@xAsAi@^iAwD_B_Bm@wAs@gBk@g@UcBo@pBgFnDaJN_@N]^_A^aAmGuCsBy@sDkAcBm@k@Mo@?cEBC?I?G?S@c@?c@?iA@g@@qPNqILyNH}FDiFJ{FfIEFOR_@h@_@h@GHCBy@fA@@DDBF@NK\\QXi@r@q@v@OJC@WCGEqCxDwBtCcArAe@r@JJHZCV]l@cCfDIHSHm@Bw@QWC[?iE\\ePjA_CNWDYH?F?NGTIJUPKDWBUAYMSYCICYKWISOQe@[eAm@mBiAo@_@{D{BsGeD{C{Ag@UFObE}I', NULL, '2021-12-17 08:38:30', '2021-12-17 08:39:00', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1610, 'KWD289621', 289, 123, 123, 1, 9272, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 11.06, 110.75, '', '175 Kudu Rd, Lusaka, Zambia', -15.41018410, 28.34929820, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-17 12:18:52', NULL, '2021-12-17 12:20:32', '2021-12-17 12:20:47', 1, 1, 0, 0, 'h|`}A__`lDrAdKxA~LBT_@BoDd@}Fv@sC`@`ClMlAvGRhABh@Gf@YfAo@fCu@dDShAcH_AgFs@kBUu@Gs@?oABu@EqC]mAUcG}@kAKoG_AsCa@aB_@sAq@q@Wk@Os@MyDk@iRqC{KeBoKmBiFaAcBUi@CIAOIk@Em@Gc@O_Ag@UEMDWHYLAFSVYJSCOGMOIUA]J]Jo@Do@Cg@W{Ac@iCkAmGq@cEqAkHaDwQwAcIo@uCi@yBSk@Oe@k@wBo@wCu@eEaB}IeCgNMa@o@gCw@cCc@o@a@WOWESEcBkIsWcAgF_B{IgB{JuAoHa@cDu@}KWeEg@_HS}Ao@oEiAaFaCuIaBoIqAoHcB{KiAoHeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-17 12:18:52', '2021-12-17 12:22:15', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1611, 'KWD155206', 289, 123, 123, 1, 9594, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 6.40, 63.64, '', '175 Kudu Rd, Lusaka, Zambia', -15.41011630, 28.34931070, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-17 14:22:29', NULL, '2021-12-17 14:23:14', '2021-12-17 14:26:21', 1, 1, 0, 0, 'zu`}As``lDUAcALq@TOuA_@{BMiASAwBDCRXtJl@bQJdDLfAt@`EnDpRRhABh@Gf@YfAo@fCu@dD[bBqAzIsAdMq@rFG^M~@M`A]~BM`AG^AHe@fEa@tCe@lE?nCB|@TnCd@|ARb@Rb@j@dAh@dAlAdCj@fAHN|E~J~AxCPXqDt@DTC^IvCKb@oBvE{IdS_@bAIXSr@g@fBkAnEmArE[hA[rAE\\E|BKpGARg@CeBAy@BeAF_Db@_B`@kA^cAd@aAd@k@\\aAv@eDrCSPMJYXYXG@QFMLYVYXu@p@[ZiAiA?ODOrAqAXUCQwE{F', NULL, '2021-12-17 14:22:21', '2021-12-17 14:26:52', 'NO', '3', 0.00000000, 0.00000000, 0.00000000),
(1612, 'KWD142296', 290, 0, 135, 1, 7842, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 410.37, 4147.78, '', '1001, Block F State Life Phase 1 State Life, Lahore, Punjab, Pakistan', 31.44288490, 74.39835980, 'Phase 7, Phase 7 Bahria Town, Rawalpindi, Islamabad, Islamabad Capital Territory, Pakistan', 33.52555030, 73.11283130, '2021-12-17 16:39:07', NULL, NULL, NULL, 0, 0, 0, 0, 'oe|~Ds|aeMaVlBeIv@gDlT`BlO{@Wah@uJq@cD|Ws@pE{s@u\\cyAix@koAa[{Vk`BnLue@h@{d@r^wXtNgyA`@o_BqBydAgNos@mZwe@yRsj@mAe}@s@a`Au@uj@hG_`Bls@wn@jl@~Fpz@zZd`@a]jRcx@vg@oc@ts@iZ~gBaDtn@gSrm@osBr|BitA~f@ivAdGmh@Ts`AlWwJ`iBzJvdDbg@baCxq@v|Drk@nuDfIhIb@eK}^xVuYnjAurAhrCm_B|aCyr@zfAm`@jlAep@baF_\\trBqXxeEqHfaB_Y`kDisAp`EcvBdiGuwAttGaxCf}Kch@~qCoy@f}Bku@`pCmjAfvB}rAhiHiuCnuJ_bApqE{b@j`B{VxnCPd|Hi]poQiGhsE_ExbCib@p|CsInkF{HbuBgc@~iLk^x}C}Y~}Agj@hhAiw@zpAy~Al}@yyAnQs`Bbo@esFptBsiG|i@c}Erv@k{AtKs`Bdv@}vDztAyzApPmrArBmgAhR_mB?_cEj@ynBrHkvAhSciCfgAahBbdAkoBvaBe}A`j@{mFdmDy`Af~AykAnsCchCdeFs|AlnBgpAdyAaiAty@itHfbCcnGhfCq|C~~@e{@v^{f@hj@_}@|pAm[b_AlKrKyPxKcH`[kUgNw_@_]u_@nJeSkSiYo^sYwNgT_A|BcHsDmGuOzF_ZiX_VpYih@r_@miBxRgtAtJ_gCnb@em@bWe]nE_NvQoJbeAkTtQqh@bKaoAno@gR~Y]ni@|JhqBuPxgAs]lf@mb@rQ_aAmPwdApDoeAdYupBtZwoCkA__BrFmr@xE}k@oNkdA}lAmxAarBy^OiiArk@gqAjf@qlArUuf@|Ven@js@si@x]ct@lTsuBt]szEve@c|Dzs@{mBnO}h@e\\e`AjAiq@fUm_@nIwZsQgqAakCg[gTa_C_n@wuAcVuqAwx@{~@ikBeSep@sa@ob@wmAqcCajAkwBw~AqqBc_CwrA}zAeSacA{Ja|@am@kdC}gC_qAiZstBaXgmBuBkiAao@yl@}NssApKce@xFga@mSio@qh@eqCwFwg@_Hkw@qt@y}Bc_DkdCmrCkZuSyx@wHic@yOwa@xBgoA`vAubDl`C`FvEdAkNwSip@e\\eReXol@efAq|Bob@gyAct@ejA}Yax@nCkNcTob@wh@{qAgDwBpN`DfkAw\\tRcH~Sci@`Ss[tUe|@poAu_GdPsw@jZgm@fc@ev@|l@o_Ab}Aqt@jc@}|@~^saAtaAel@bUmi@q@zU|x@uStStAzHZ`KiL', NULL, '2021-12-17 16:39:07', '2021-12-17 16:39:16', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1613, 'KWD948842', 290, 135, 135, 1, 5492, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 410.37, 4147.81, '', '1001, Block F State Life Phase 1 State Life, Lahore, Punjab, Pakistan', 31.44288450, 74.39838660, 'Phase 7, Phase 7 Bahria Town, Rawalpindi, Islamabad, Islamabad Capital Territory, Pakistan', 33.52555030, 73.11283130, '2021-12-17 16:39:41', NULL, '2021-12-17 16:40:15', '2021-12-17 16:40:48', 1, 1, 0, 0, 'oe|~Dw|aeMaVpBeIv@gDlT`BlO{@Wah@uJq@cD|Ws@pE{s@u\\cyAix@koAa[{Vk`BnLue@h@{d@r^wXtNgyA`@o_BqBydAgNos@mZwe@yRsj@mAe}@s@a`Au@uj@hG_`Bls@wn@jl@~Fpz@zZd`@a]jRcx@vg@oc@ts@iZ~gBaDtn@gSrm@osBr|BitA~f@ivAdGmh@Ts`AlWwJ`iBzJvdDbg@baCxq@v|Drk@nuDfIhIb@eK}^xVuYnjAurAhrCm_B|aCyr@zfAm`@jlAep@baF_\\trBqXxeEqHfaB_Y`kDisAp`EcvBdiGuwAttGaxCf}Kch@~qCoy@f}Bku@`pCmjAfvB}rAhiHiuCnuJ_bApqE{b@j`B{VxnCPd|Hi]poQiGhsE_ExbCib@p|CsInkF{HbuBgc@~iLk^x}C}Y~}Agj@hhAiw@zpAy~Al}@yyAnQs`Bbo@esFptBsiG|i@c}Erv@k{AtKs`Bdv@}vDztAyzApPmrArBmgAhR_mB?_cEj@ynBrHkvAhSciCfgAahBbdAkoBvaBe}A`j@{mFdmDy`Af~AykAnsCchCdeFs|AlnBgpAdyAaiAty@itHfbCcnGhfCq|C~~@e{@v^{f@hj@_}@|pAm[b_AlKrKyPxKcH`[kUgNw_@_]u_@nJeSkSiYo^sYwNgT_A|BcHsDmGuOzF_ZiX_VpYih@r_@miBxRgtAtJ_gCnb@em@bWe]nE_NvQoJbeAkTtQqh@bKaoAno@gR~Y]ni@|JhqBuPxgAs]lf@mb@rQ_aAmPwdApDoeAdYupBtZwoCkA__BrFmr@xE}k@oNkdA}lAmxAarBy^OiiArk@gqAjf@qlArUuf@|Ven@js@si@x]ct@lTsuBt]szEve@c|Dzs@{mBnO}h@e\\e`AjAiq@fUm_@nIwZsQgqAakCg[gTa_C_n@wuAcVuqAwx@{~@ikBeSep@sa@ob@wmAqcCajAkwBw~AqqBc_CwrA}zAeSacA{Ja|@am@kdC}gC_qAiZstBaXgmBuBkiAao@yl@}NssApKce@xFga@mSio@qh@eqCwFwg@_Hkw@qt@y}Bc_DkdCmrCkZuSyx@wHic@yOwa@xBgoA`vAubDl`C`FvEdAkNwSip@e\\eReXol@efAq|Bob@gyAct@ejA}Yax@nCkNcTob@wh@{qAgDwBpN`DfkAw\\tRcH~Sci@`Ss[tUe|@poAu_GdPsw@jZgm@fc@ev@|l@o_Ab}Aqt@jc@}|@~^saAtaAel@bUmi@q@zU|x@uStStAzHZ`KiL', NULL, '2021-12-17 16:39:41', '2021-12-17 16:54:01', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1614, 'KWD754884', 290, 135, 135, 1, 6201, 0, 'SCHEDULED', 'NONE', NULL, 'CASH', 0, 6.41, 63.73, '', '1001, Block F State Life Phase 1 State Life, Lahore, Punjab, Pakistan', 31.44290900, 74.39841460, 'Phase 5 D.H.A, Phase 5 D.H.A, Lahore, Punjab, Pakistan', 31.46253890, 74.40859290, '2021-12-17 16:55:34', '2021-12-20 19:55:00', NULL, NULL, 0, 0, 0, 0, 'qe|~D}|aeMLj@jBg@Hj@gBp@k@LNv@cCn@m@?kBWmASqBWuDa@c@CQ@UFaAx@c@T]Fs@CmC[oBYgCYcEg@\\wDReDFuC@{CCyBOsCSaC]qCsAqIsEiUaAcFIo@aBcImAkFe@aC{@qCwA_FwAaDSYgA_CaDgFyCkEsCiE_FuH}GuJU]HCLEV[n@oAj@uBPi@Zs@Xe@Z]h@a@b@S`@Gb@CZDTDCNCPe@Em@B]HYT_Ax@a@j@O`@[`B[dAs@nAcAbA[Vy@b@q@TwDlAIJEB}@|H_BvO}@lImBrRyAvNa@zDNFxBd@|B`@|BRu@dH', NULL, '2021-12-17 16:55:34', '2021-12-17 16:55:48', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1615, 'KWD870043', 289, 0, 56, 1, 2660, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 4.00, 45.00, '', '175 Kudu Rd, Lusaka, Zambia', -15.41016770, 28.34916030, 'Woodlands Mall, Chindo Rd, Lusaka, Zambia', -15.43605270, 28.34142110, '2021-12-17 17:07:29', NULL, NULL, NULL, 0, 0, 0, 0, 'bz`}Acz_lDj@E^IRMHh@n@|En@lFh@pE^jCrBpQ?D|@QhFy@nIgApNoBbKaBbIcAxGNjHNpH`AdMbB`Eh@|@N|@f@tAv@pBlAnBbAfC|@vBd@nBPbAFxBAlCQjASlBYl@IEWIo@@W', NULL, '2021-12-17 17:06:16', '2021-12-17 17:07:34', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1616, 'KWD666503', 291, 0, 57, 1, 2144, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 4.00, 45.00, '', '175 Kudu Rd, Lusaka, Zambia', -15.41016700, 28.34919700, 'Woodlands Mall, Chindo Rd, Lusaka, Zambia', -15.43605270, 28.34142110, '2021-12-17 17:59:52', NULL, NULL, NULL, 0, 0, 0, 0, 'bz`}Acz_lDj@E^IRMHh@n@|En@lFh@pE^jCrBpQ?D|@QhFy@nIgApNoBbKaBbIcAxGNjHNpH`AdMbB`Eh@|@N|@f@tAv@pBlAnBbAfC|@vBd@nBPbAFxBAlCQjASlBYl@IEWIo@@W', NULL, '2021-12-17 17:08:34', '2021-12-17 19:01:54', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1617, 'KWD154457', 289, 0, 134, 1, 1147, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 22.04, 221.78, '', 'Unnamed Road, Lusaka, Zambia', -15.39818610, 28.38552220, 'Makeni Road, Makeni Rd, Lusaka, Zambia', -15.46090560, 28.25025010, '2021-12-17 20:01:39', NULL, NULL, NULL, 0, 0, 0, 0, 'nm~|AmaglDwARe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@{CdPEJWR[B[?aA@I@KHGHE^w@`CmEzMkGhRwF|PyAjEK\\W\\_@RUPBHfB`KbBtI~@bE~@~CtGpRLXJJf@f@HJN^B`@DbA|@xCr@jC|@jE|DtT|B|M|B`LpCjOxFn\\d@hCNf@T~AZzADt@Fl@NZDBJJJPBXARAFEFBJHf@Jb@\\vAX|AbArFPbAXnCPpDCxDWzK[nPMvGAjBJrC~@vJz@bJb@~EVlDh@zFZrE^zDR|AP~@p@|Cb@pAh@tApAnCd@z@pArBbBvBrFnGtB|BRVpNzP~EbGzJtLX\\d@h@PT|AlB`CvCtEpFnA|AvAzAv@fArBfCjBzBzAhBzBhDV`@vAdD|@rC^bBd@rCj@zGn@tH`AjMp@bIpBxUhAzMv@`GTvBPfCPzBh@hGHb@F@LFDDv@S`Dc@lGi@xJ_AfSgBlSmB`Q_BlK}@f@KTIBITWNGTAPHNLFJ@DJAhFe@fBQr@Cv@AhBBpAPlBb@v@TdAh@|Ax@~@v@|@`Ap@bA|@bBjBpEl@rA`@j@f@r@|@~@t@n@r@f@pB`A|YzLxJ`E|ErBbCbAbEnBrElBtMtFrLbFvNhGnCpAtCnAvP`IhAj@e@hAC`AFd@dBzG\\`B|@dDnC~JbBnGf@lBHXNl@Pl@`@xA`@xA`AnDdExOpAtFpApFvAbG', NULL, '2021-12-17 20:01:39', '2021-12-17 20:02:42', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1618, 'KWD100326', 291, 0, 134, 1, 4770, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 11.85, 118.76, '', 'J92M+CF2, Lusaka, Zambia', -15.39811030, 28.38532960, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-17 20:02:09', NULL, NULL, NULL, 0, 0, 0, 0, 'jk~|Aw~flDr@jDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zE@P\\hELjAJf@x@lE\\lAh@zAnApCx@xAb@x@hBfCnGrH|B`CT\\|HnJjFfGhMrO~AnBOLsCkDYBSF]X[RG?KGQ_@CGUPCB?DDJxB`CvAdB', NULL, '2021-12-17 20:02:09', '2021-12-17 20:02:41', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1619, 'KWD210188', 291, 0, 97, 1, 9238, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 11.51, 115.32, '', 'Unnamed Road, Lusaka, Zambia', -15.39808300, 28.38539470, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-17 20:17:36', NULL, NULL, NULL, 0, 0, 0, 0, 'tl~|AgaglD}@Le@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@{CdPEJWR[B[?aA@I@KHGHE^w@`CmEzMkGhRwF|PyAjEK\\W\\_@RUPBHfB`KbBtI~@bE~@~CtGpRLXJJf@f@HJN^B`@DbA|@xCr@jC|@jE|DtT|B|M|B`LpCjOxFn\\d@hCNf@T~AZzADt@Fl@NZDBJJJPBXARAFEFBJHf@Jb@\\vAX|AbArFPbAXnCPpDCxDWzK[nPMvGAjBJrC~@vJz@bJb@~EVlDh@zFZrE^zDR|AP~@p@|Cb@pAh@tApAnCd@z@pArBbBvBrFnGtB|BRVpNzP~EbGzJtLOLsCkDg@Fq@h@IFI?OKSc@YV?F~BhCvAdB', NULL, '2021-12-17 20:15:43', '2021-12-17 20:19:11', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000);
INSERT INTO `user_requests` (`id`, `booking_id`, `user_id`, `provider_id`, `current_provider_id`, `service_type_id`, `otp`, `returntrip`, `status`, `cancelled_by`, `cancel_reason`, `payment_mode`, `paid`, `distance`, `amount`, `specialNote`, `s_address`, `s_latitude`, `s_longitude`, `d_address`, `d_latitude`, `d_longitude`, `assigned_at`, `schedule_at`, `started_at`, `finished_at`, `user_rated`, `provider_rated`, `use_wallet`, `surge`, `route_key`, `deleted_at`, `created_at`, `updated_at`, `is_track`, `travel_time`, `track_distance`, `track_latitude`, `track_longitude`) VALUES
(1620, 'KWD661819', 290, 0, 123, 1, 3835, 0, 'CANCELLED', 'USER', 'hh', 'CASH', 0, 6.40, 63.64, '', '1001, Block F State Life Phase 1 State Life, Lahore, Punjab, Pakistan', 31.44292872, 74.39830454, 'Phase 5 D.H.A, Phase 5 D.H.A, Lahore, Punjab, Pakistan', 31.46253890, 74.40859290, '2021-12-17 20:20:23', NULL, NULL, NULL, 0, 0, 0, 0, 'me|~Dk|aeMHXjBg@Hj@gBp@k@LNv@cCn@m@?kBWmASqBWuDa@c@CQ@UFaAx@c@T]Fs@CmC[oBYgCYcEg@\\wDReDFuC@{CCyBOsCSaC]qCsAqIsEiUaAcFIo@aBcImAkFe@aC{@qCwA_FwAaDSYgA_CaDgFyCkEsCiE_FuH}GuJU]HCLEV[n@oAj@uBPi@Zs@Xe@Z]h@a@b@S`@Gb@CZDTDCNCPe@Em@B]HYT_Ax@a@j@O`@[`B[dAs@nAcAbA[Vy@b@q@TwDlAIJEB}@|H_BvO}@lImBrRyAvNa@zDNFxBd@|B`@|BRu@dH', NULL, '2021-12-17 20:20:23', '2021-12-17 20:20:41', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1621, 'KWD240164', 290, 0, 130, 1, 9413, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 410.37, 4147.75, '', '1001, Block F State Life Phase 1 State Life, Lahore, Punjab, Pakistan', 31.44292690, 74.39830640, 'Phase 7, Phase 7 Bahria Town, Rawalpindi, Islamabad, Islamabad Capital Territory, Pakistan', 33.52555030, 73.11283130, '2021-12-17 20:27:54', NULL, NULL, NULL, 0, 0, 0, 0, 'me|~Dk|aeMcVdBeIv@gDlT`BlO{@Wah@uJq@cD|Ws@pE{s@u\\cyAix@koAa[{Vk`BnLue@h@{d@r^wXtNgyA`@o_BqBydAgNos@mZwe@yRsj@mAe}@s@a`Au@uj@hG_`Bls@wn@jl@~Fpz@zZd`@a]jRcx@vg@oc@ts@iZ~gBaDtn@gSrm@osBr|BitA~f@ivAdGmh@Ts`AlWwJ`iBzJvdDbg@baCxq@v|Drk@nuDfIhIb@eK}^xVuYnjAurAhrCm_B|aCyr@zfAm`@jlAep@baF_\\trBqXxeEqHfaB_Y`kDisAp`EcvBdiGuwAttGaxCf}Kch@~qCoy@f}Bku@`pCmjAfvB}rAhiHiuCnuJ_bApqE{b@j`B{VxnCPd|Hi]poQiGhsE_ExbCib@p|CsInkF{HbuBgc@~iLk^x}C}Y~}Agj@hhAiw@zpAy~Al}@yyAnQs`Bbo@esFptBsiG|i@c}Erv@k{AtKs`Bdv@}vDztAyzApPmrArBmgAhR_mB?_cEj@ynBrHkvAhSciCfgAahBbdAkoBvaBe}A`j@{mFdmDy`Af~AykAnsCchCdeFs|AlnBgpAdyAaiAty@itHfbCcnGhfCq|C~~@e{@v^{f@hj@_}@|pAm[b_AlKrKyPxKcH`[kUgNw_@_]u_@nJeSkSiYo^sYwNgT_A|BcHsDmGuOzF_ZiX_VpYih@r_@miBxRgtAtJ_gCnb@em@bWe]nE_NvQoJbeAkTtQqh@bKaoAno@gR~Y]ni@|JhqBuPxgAs]lf@mb@rQ_aAmPwdApDoeAdYupBtZwoCkA__BrFmr@xE}k@oNkdA}lAmxAarBy^OiiArk@gqAjf@qlArUuf@|Ven@js@si@x]ct@lTsuBt]szEve@c|Dzs@{mBnO}h@e\\e`AjAiq@fUm_@nIwZsQgqAakCg[gTa_C_n@wuAcVuqAwx@{~@ikBeSep@sa@ob@wmAqcCajAkwBw~AqqBc_CwrA}zAeSacA{Ja|@am@kdC}gC_qAiZstBaXgmBuBkiAao@yl@}NssApKce@xFga@mSio@qh@eqCwFwg@_Hkw@qt@y}Bc_DkdCmrCkZuSyx@wHic@yOwa@xBgoA`vAubDl`C`FvEdAkNwSip@e\\eReXol@efAq|Bob@gyAct@ejA}Yax@nCkNcTob@wh@{qAgDwBpN`DfkAw\\tRcH~Sci@`Ss[tUe|@poAu_GdPsw@jZgm@fc@ev@|l@o_Ab}Aqt@jc@}|@~^saAtaAel@bUmi@q@zU|x@uStStAzHZ`KiL', NULL, '2021-12-17 20:27:54', '2021-12-17 20:28:26', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1622, 'KWD395167', 290, 130, 130, 1, 9008, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 6.40, 63.64, '', '1001, Block F State Life Phase 1 State Life, Lahore, Punjab, Pakistan', 31.44286560, 74.39832830, 'Phase 5 D.H.A, Phase 5 D.H.A, Lahore, Punjab, Pakistan', 31.46253890, 74.40859290, '2021-12-17 20:30:09', NULL, '2021-12-17 20:30:38', '2021-12-17 20:30:52', 1, 1, 0, 0, 'me|~Dk|aeMHXjBg@Hj@gBp@k@LNv@cCn@m@?kBWmASqBWuDa@c@CQ@UFaAx@c@T]Fs@CmC[oBYgCYcEg@\\wDReDFuC@{CCyBOsCSaC]qCsAqIsEiUaAcFIo@aBcImAkFe@aC{@qCwA_FwAaDSYgA_CaDgFyCkEsCiE_FuH}GuJU]HCLEV[n@oAj@uBPi@Zs@Xe@Z]h@a@b@S`@Gb@CZDTDCNCPe@Em@B]HYT_Ax@a@j@O`@[`B[dAs@nAcAbA[Vy@b@q@TwDlAIJEB}@|H_BvO}@lImBrRyAvNa@zDNFxBd@|B`@|BRu@dH', NULL, '2021-12-17 20:30:09', '2021-12-17 20:31:23', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1623, 'KWD109203', 289, 0, 134, 1, 5339, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 11.51, 115.25, '', 'Unnamed Road, Lusaka, Zambia', -15.39801890, 28.38537980, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-17 20:54:45', NULL, NULL, NULL, 0, 0, 0, 0, 'hl~|AeaglDq@Je@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@{CdPEJWR[B[?aA@I@KHGHE^w@`CmEzMkGhRwF|PyAjEK\\W\\_@RUPBHfB`KbBtI~@bE~@~CtGpRLXJJf@f@HJN^B`@DbA|@xCr@jC|@jE|DtT|B|M|B`LpCjOxFn\\d@hCNf@T~AZzADt@Fl@NZDBJJJPBXARAFEFBJHf@Jb@\\vAX|AbArFPbAXnCPpDCxDWzK[nPMvGAjBJrC~@vJz@bJb@~EVlDh@zFZrE^zDR|AP~@p@|Cb@pAh@tApAnCd@z@pArBbBvBrFnGtB|BRVpNzP~EbGzJtLOLsCkDg@Fq@h@IFI?OKSc@YV?F~BhCvAdB', NULL, '2021-12-17 20:54:45', '2021-12-17 20:55:07', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1624, 'KWD758476', 289, 0, 134, 1, 5207, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 10.67, 106.81, '', 'Unnamed Road, Lusaka, Zambia', -15.39801790, 28.38537750, 'Woodlands Mall, Chindo Rd, Lusaka, Zambia', -15.43605270, 28.34142110, '2021-12-17 20:57:31', NULL, NULL, NULL, 0, 0, 0, 0, 'fk~|Ae_glD}BiLyBd@c@{CmAsIjAWrDy@lEaAfEeB@cL?}AAkA`@At@CQsA|SeCzAW?FzE|HpB|CnElHxBjDpDfGlFlInBzCd@x@f@v@fAdBx@nATh@Pl@b@rAjArDRj@Rj@BFFb@@d@Eb@MhAQfAg@nCa@|Be@nCCv@Fb@J`@l@x@b@j@`BnAv@n@r@r@VZP^^`At@rBt@xBz@bCXdAJ^V~@p@`Cl@zBd@`CDZt@zFtEYpLs@v@?b@Px@NL?vASv@FdUnEnB^xCTrFdAnNnCrDj@lEr@CXIt@Ir@WtBUhBc@jEkAhJs@zF{@~G]vCOjAa@vDKnAg@tD_@pD[pCeChRG`@M`A[fCu@bGw@jG[jCqE~]jMbBrKvA|@N|@f@tAv@pBlAnBbAfC|@vBd@nBPbAFxBAlCQxDm@l@IEWIo@@W', NULL, '2021-12-17 20:56:18', '2021-12-17 20:57:42', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1625, 'KWD440611', 289, 0, 134, 1, 7421, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 10.48, 104.90, '', 'Unnamed Road, Lusaka, Zambia', -15.39803300, 28.38538440, 'Woodlands Mall, Chindo Rd, Lusaka, Zambia', -15.43605270, 28.34142110, '2021-12-17 20:59:59', NULL, NULL, NULL, 0, 0, 0, 0, 'jl~|AeaglDrC_@a@mCjCc@YgBa@iC_@}BaAaG_@cCn@WvCmA@wH?{BAyCd@Ap@COoAACdCYzIeAzDe@zAWzB|D|HzLzDnGlCxEzGnKbCtDd@v@d@v@hAfBx@nALRFTRl@b@rAjArDPj@Tj@J^Bd@Ab@MhAOfAUfAQfAa@|Bg@nCEb@A`@@THb@R^VZf@p@xAlAlB|AV\\T\\^`At@tBt@tBpAxDRx@X~@n@`Cp@~Bb@|BF^t@~F~Ks@pG[d@L|@RN@tASh@Bv@JlKtBdKpBxCTpCh@xKvBbEv@`HfArARALCXEXIt@WrBUjBc@hEmArJq@zF{@~G_@vCMjAGd@c@fEi@`EQxBi@rEeChRG`@M`A[fCw@bGu@jGM`A{ChVeAfIbBRtFv@jJlAvEp@bAj@~G|DrAh@dAZzA\\t@NvCNlA?pBGtAKxAW`C]Os@@k@', NULL, '2021-12-17 20:58:46', '2021-12-17 21:00:16', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1626, 'KWD550243', 289, 0, 134, 1, 6806, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 20.31, 204.24, '', 'Unnamed Road, Lusaka, Zambia', -15.39808190, 28.38541950, 'Texila American University, Texila American University Campus, F-405-a/6, Lilayi, Lusaka, Zambia', -15.50955460, 28.31154530, '2021-12-17 21:08:56', NULL, NULL, NULL, 0, 0, 0, 0, 'vl~|AgaglDfC]a@mCjCc@YgBa@iC_@}BaAaG_@cCn@WvCmA@wH?{BAyCd@Ap@COoAACdCYzIeAzDe@zAWzB|D|HzLzDnGlCxEzGnKbCtDd@v@d@v@hAfBx@nALRFTRl@b@rAjArDPj@Tj@J^Bd@Ab@MhAOfAUfAQfAa@|Bg@nCEb@A`@@THb@R^VZf@p@xAlAlB|AV\\T\\^`At@tBt@tBpAxDRx@X~@n@`Cp@~Bb@|BF^t@~F~Ks@pG[d@L|@RN@tASh@Bv@JlKtBdKpBxCTpCh@xKvBbEv@`HfArARALCXEXIt@WrBUjBc@hEmArJq@zF{@~G_@vCMjAGd@c@fEi@`EQxBi@rE~RfCzC`@~Fn@xIpAr@PpClAx@ZxBfAbBx@xAj@bDxAbAz@^f@bGjHn@n@d@RfA^RHr@p@f@l@Zr@Zv@`A`ChG~OrAbDsGpCeGjCJ|@N|Cf@rJbCvh@lBv`@X~FDzAn@BnA@v@@tAElAIh@IfB]~@Ur@Wn@Uj@_@p@Yp@UjBY[jCo@~BEPD@D@JBVFdBh@`EpAjB|@fA~@hAxAXb@j@jAzCvC|AfBfBxBnC|C`ApA|AsE\\R~@l@z@r@|BrAtBlAtEvCjBjAnAv@PFHBJ@VDj@Fl@FzAL~ALvDVjL`AnBLnE^`Lx@nALlAJ`DXzCX`AD`AH|BRrE\\b@DxE\\fF`@nBPL@L@XBnBJz@F\\B`K`AjFb@zFf@xBNxBRlIt@xBNdF`@z@H\\BN@JMf@G~BNlELvBFf@FnCZvBn@z@`@p@N~C`@nGv@vEn@hFv@dBT`C\\xAPxBNtGT~BHhAFpCLhABzFTlLj@xFRjH\\fFPlEPdBLfBDlDP', NULL, '2021-12-17 21:08:56', '2021-12-17 21:09:50', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1627, 'KWD107862', 291, 0, 97, 1, 6575, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 11.51, 115.29, '', 'Unnamed Road, Lusaka, Zambia', -15.39805770, 28.38537840, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-17 21:14:33', NULL, NULL, NULL, 0, 0, 0, 0, 'pl~|AgaglDy@Le@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@{CdPEJWR[B[?aA@I@KHGHE^w@`CmEzMkGhRwF|PyAjEK\\W\\_@RUPBHfB`KbBtI~@bE~@~CtGpRLXJJf@f@HJN^B`@DbA|@xCr@jC|@jE|DtT|B|M|B`LpCjOxFn\\d@hCNf@T~AZzADt@Fl@NZDBJJJPBXARAFEFBJHf@Jb@\\vAX|AbArFPbAXnCPpDCxDWzK[nPMvGAjBJrC~@vJz@bJb@~EVlDh@zFZrE^zDR|AP~@p@|Cb@pAh@tApAnCd@z@pArBbBvBrFnGtB|BRVpNzP~EbGzJtLOLsCkDg@Fq@h@IFI?OKSc@YV?F~BhCvAdB', NULL, '2021-12-17 21:10:44', '2021-12-17 21:15:59', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1628, 'KWD922236', 289, 134, 134, 1, 9388, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 11.51, 115.31, '', 'Unnamed Road, Lusaka, Zambia', -15.39806950, 28.38540250, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-17 21:23:33', NULL, '2021-12-17 21:24:36', '2021-12-17 21:29:16', 1, 1, 0, 0, 'rl~|AgaglD{@Le@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@{CdPEJWR[B[?aA@I@KHGHE^w@`CmEzMkGhRwF|PyAjEK\\W\\_@RUPBHfB`KbBtI~@bE~@~CtGpRLXJJf@f@HJN^B`@DbA|@xCr@jC|@jE|DtT|B|M|B`LpCjOxFn\\d@hCNf@T~AZzADt@Fl@NZDBJJJPBXARAFEFBJHf@Jb@\\vAX|AbArFPbAXnCPpDCxDWzK[nPMvGAjBJrC~@vJz@bJb@~EVlDh@zFZrE^zDR|AP~@p@|Cb@pAh@tApAnCd@z@pArBbBvBrFnGtB|BRVpNzP~EbGzJtLOLsCkDg@Fq@h@IFI?OKSc@YV?F~BhCvAdB', NULL, '2021-12-17 21:22:20', '2021-12-17 21:35:32', 'NO', '4', 0.00000000, 0.00000000, 0.00000000),
(1629, 'KWD943171', 290, 130, 130, 1, 7879, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 6.20, 61.56, '', '', 31.46253890, 74.40859290, 'DHA Phase 6, DHA Phase 6, Lahore, Punjab, Pakistan', 31.47150490, 74.45842450, '2021-12-17 21:28:11', NULL, '2021-12-17 21:31:57', '2021-12-17 21:33:22', 1, 1, 0, 0, 'y~__Em|ceMt@eHzB`@fAmKh@qEn@{IbA{J\\aEr@}Ez@aH\\uC?iAKe@GOqAqBuBsCwAsB{A`@c@NMCEDMBKCKKCO[w@c@w@gDsEoDeF_FuHoBkC_EeGiCqDg@k@_@Y]SY?YGQSCa@Ei@QaAQi@OSGGM_@Kq@Ce@@s@BuE?yCEsAM}@[}@a@w@_@c@u@}@[m@i@iAqAmCy@yA}DeGeFsHkEkGmCiEsBwCiD_FkFwHs@eA_GyIoDwFKOTQhAkAlBsBnSsTjAkAbQgR`@a@NBZF', NULL, '2021-12-17 21:28:11', '2021-12-17 21:34:42', 'NO', '1', 0.00000000, 0.00000000, 0.00000000),
(1630, 'KWD760961', 290, 0, 130, 1, 2356, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 6.38, 63.39, '', '', 31.44284000, 74.39830670, 'Phase 5 D.H.A, Phase 5 D.H.A, Lahore, Punjab, Pakistan', 31.46253890, 74.40859290, '2021-12-17 21:35:28', '2021-12-18 06:35:00', NULL, NULL, 0, 0, 0, 0, 'qd|~Dw{aeMxAa@Hj@gBp@k@LNv@}@TeAXSBiAMiCa@mFk@sAOc@?WPa@^g@Z]Le@BUAeCYuDe@eEi@qAOH}@Da@VcDNaEBeBAyDKcCQiCQeBaBsKwE}UgA{Fw@_EwAyGs@cDq@oCsB_Hi@uA_AoBGEy@gBgAgBgBwCwB}C{A}Bs@eAwFuIwDmFgBkCa@m@PETSn@kAVq@Pw@Nk@Zy@n@eA`@_@p@a@VIf@G^@b@HG`@{@Gu@Nu@l@eAlAO`@YzA]hAUb@q@`A}@~@]RqAh@aEnAADKH]lCuArMsDb^}A~OaAfJ`@JdDr@~@N|BRu@dH', NULL, '2021-12-17 21:35:28', '2021-12-17 21:35:31', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1631, 'KWD174154', 289, 0, 135, 1, 5085, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 22.15, 222.85, '', 'Unnamed Road, Lusaka, Zambia', -15.39805260, 28.38538030, 'Bonanza Golf Course, Ngwerere Rd, Lusaka, Zambia', -15.26075570, 28.44009430, '2021-12-18 00:00:17', NULL, NULL, NULL, 0, 0, 0, 0, 'nl~|AgaglDw@Le@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@SqAc@sA]cB]s@YmG_D{J{EiFiCcD}A{JyE{J{EmUcL_[oO_OoH}GeDaGwCoBaAcCcAkCq@_CYqCOsCMqH]aPs@mDOwEQmP{@}b@iBkXkAm@CkC_@uBk@kBu@kAu@}AgAeBcBmAgBeBcE_@oAi@qEGaBBmAbBge@zC{w@@OQAUIaFkCuDqBuDqBqQsJiP_J_TqKaRcJkNsGaFgCqBeAqD{BkIaFc]kSc]mSSCMBeVjX}LdNu[h^aRtSgP`Re@h@s@dA_@r@q@vAaEnKkArDGl@E~BA`BApGQOyCq@cBY_Ca@uKoD{Ag@c@U{Ak@k@OSWKgAYg@]aAOo@?]J_A@oAKa@YMyAUsAYc@EeAMm@QGQs@y@g@y@iAeB', NULL, '2021-12-18 00:00:17', '2021-12-18 00:00:26', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1632, 'KWD961082', 289, 0, 134, 1, 8209, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 4.36, 45.00, '', 'Unnamed Road, Lusaka, Zambia', -15.39805260, 28.38538030, 'Dream Valley, H9PF+7CG, Lusaka, Zambia', -15.41431170, 28.37357240, '2021-12-18 00:02:05', NULL, NULL, NULL, 0, 0, 0, 0, 'nl~|AgaglDnC]a@mCjCc@YgBa@iC_@}BaAaG_@cCn@WvCmA@wH?{BAyCd@Ap@COoAACdCYzIeAzDe@zAWzB|D|HzLzDnGlCxEzGnKbCtDd@v@d@v@hAfBx@nALRFTRl@b@rAjArDPj@Tj@J^Bd@Ab@MhAOfAUfAQfAa@|Bg@nCEb@A`@@THb@R^VZf@p@xAlAlB|AV\\T\\^`At@tBt@tBpAxDRx@X~@n@`CHT', NULL, '2021-12-18 00:02:05', '2021-12-18 00:02:13', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1633, 'KWD929116', 289, 0, 134, 1, 5607, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 11.85, 118.71, '', 'J92M+CF2, Lusaka, Zambia', -15.39812870, 28.38528630, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-18 07:18:42', NULL, NULL, NULL, 0, 0, 0, 0, 'nk~|Am~flDn@`DeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zE@P\\hELjAJf@x@lE\\lAh@zAnApCx@xAb@x@hBfCnGrH|B`CT\\|HnJjFfGhMrO~AnBOLsCkDYBSF]X[RG?KGQ_@CGUPCB?DDJxB`CvAdB', NULL, '2021-12-18 07:18:42', '2021-12-18 07:18:49', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1634, 'KWD754844', 289, 135, 135, 1, 6422, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 11.85, 118.71, '', 'J92M+CF2, Lusaka, Zambia', -15.39815890, 28.38529330, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-18 07:20:29', NULL, '2021-12-18 07:21:11', '2021-12-18 07:21:34', 1, 1, 0, 0, 'nk~|Am~flDn@`DeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zE@P\\hELjAJf@x@lE\\lAh@zAnApCx@xAb@x@hBfCnGrH|B`CT\\|HnJjFfGhMrO~AnBOLsCkDYBSF]X[RG?KGQ_@CGUPCB?DDJxB`CvAdB', NULL, '2021-12-18 07:20:29', '2021-12-18 07:22:00', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1635, 'KWD855500', 291, 135, 135, 1, 8938, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 11.85, 118.76, '', 'J92M+CF2, Lusaka, Zambia', -15.39810850, 28.38533230, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-18 07:40:35', NULL, '2021-12-18 07:41:58', '2021-12-18 07:45:59', 1, 1, 0, 0, 'jk~|Aw~flDr@jDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zE@P\\hELjAJf@x@lE\\lAh@zAnApCx@xAb@x@hBfCnGrH|B`CT\\|HnJjFfGhMrO~AnBOLsCkDYBSF]X[RG?KGQ_@CGUPCB?DDJxB`CvAdB', NULL, '2021-12-18 07:39:22', '2021-12-18 07:46:45', 'NO', '4', 0.00000000, 0.00000000, 0.00000000),
(1636, 'KWD283513', 289, 0, 97, 1, 9154, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 16.37, 164.42, '', 'J92M+CF2, Lusaka, Zambia', -15.39809520, 28.38522410, 'Lusaka City Market, Lusaka City Market, Los Angeles Rd, Lusaka, Zambia', -15.42025780, 28.27568480, '2021-12-18 07:53:37', NULL, NULL, NULL, 0, 0, 0, 0, 'pk~|Ae~flDl@xCeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zE@P\\hELjAJf@x@lE\\lAh@zAnApCx@xAb@x@hBfCnGrH|B`CT\\|HnJjFfGhMrOtBhCd@h@tEtFj@v@zDtEtDfEzC|DzAfBfBtB`ArA`BhCd@`AbAlCf@~AV|@b@bC\\nCF|@r@nIbA~LZhEXvChAlNp@pH`ApLXlCZ~BXtBTfDPtBf@pGJr@HPLFNLF\\ARAHCBHDl@n@hC|BpBhBtApAXZp@hAn@bBdBvCJPlBcAXO|@W^KlAMnEc@tE_@PCHtAvJ{@xI{@\\BLVx@`J', NULL, '2021-12-18 07:50:00', '2021-12-18 07:54:49', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1637, 'KWD251107', 291, 123, 123, 1, 9841, 0, 'CANCELLED', 'PROVIDER', '', 'CASH', 0, 8.94, 89.32, '', 'J92M+CF2, Lusaka, Zambia', -15.39810930, 28.38533280, 'Munali Mall, 12th St, Lusaka, Zambia', -15.37214580, 28.34515770, '2021-12-18 08:24:58', NULL, NULL, NULL, 0, 0, 0, 0, 'jk~|Aw~flDr@jDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPSRYFQCOImA\\GDI@Q@a@CiC_@cEm@{LcByJoAsGw@_Gy@WE[Ew@Kw@KoBWqBW}Eo@w@M[EkDe@Eb@ShBq@I', NULL, '2021-12-18 08:24:58', '2021-12-18 08:25:54', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1638, 'KWD351609', 289, 135, 135, 1, 2841, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 14.15, 141.95, '', 'Unnamed Road, Lusaka, Zambia', -15.39809710, 28.38541610, 'Waterworks Plaza, Lusaka, Zambia', -15.45537210, 28.32083630, '2021-12-18 08:58:21', NULL, NULL, NULL, 0, 0, 0, 0, 'xl~|AiaglDdC[a@mCjCc@YgBa@iC_@}BaAaG_@cCn@WvCmA@wH?{BAyCd@Ap@COoAACdCYzIeAzDe@zAWzB|D|HzLzDnGlCxEzGnKbCtDd@v@d@v@hAfBx@nALRFTRl@b@rAjArDPj@Tj@J^Bd@Ab@MhAOfAUfAQfAa@|Bg@nCEb@A`@@THb@R^VZf@p@xAlAlB|AV\\T\\^`At@tBt@tBpAxDRx@X~@n@`Cp@~Bb@|BF^t@~F~Ks@pG[d@L|@RN@tASh@Bv@JlKtBdKpBxCTpCh@xKvBbEv@`HfArARALCXEXIt@WrBUjBc@hEmArJq@zF{@~G_@vCMjAGd@c@fEi@`EQxBi@rE~RfCzC`@~Fn@xIpAr@PpClAx@ZxBfAbBx@xAj@bDxAbAz@^f@bGjHn@n@d@RfA^RHr@p@f@l@Zr@Zv@`A`ChG~OrAbDsGpCeGjCJ|@N|Cf@rJbCvh@lBv`@X~FDzAn@BnA@v@@tAElAIh@IfB]~@Ur@Wn@Uj@_@p@Yp@UjBY[jCo@~BEPD@D@JBVFdBh@`EpAjB|@fA~@hAxAXb@j@jAzCvC|AfBfBxBnC|C`ApA|AsE\\R~@l@z@r@|BrA~@h@', NULL, '2021-12-18 08:55:55', '2021-12-18 08:59:32', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1639, 'KWD410865', 290, 0, 130, 1, 8946, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 6.41, 63.65, '', '1001, Block F State Life Phase 1 State Life, Lahore, Punjab, Pakistan', 31.44290300, 74.39833110, 'Phase 5 D.H.A, Phase 5 D.H.A, Lahore, Punjab, Pakistan', 31.46253890, 74.40859290, '2021-12-18 09:35:49', NULL, NULL, NULL, 0, 0, 0, 0, 'me|~Dm|aeMHZjBg@Hj@gBp@k@LNv@cCn@m@?kBWmASqBWuDa@c@CQ@UFaAx@c@T]Fs@CmC[oBYgCYcEg@\\wDReDFuC@{CCyBOsCSaC]qCsAqIsEiUaAcFIo@aBcImAkFe@aC{@qCwA_FwAaDSYgA_CaDgFyCkEsCiE_FuH}GuJU]HCLEV[n@oAj@uBPi@Zs@Xe@Z]h@a@b@S`@Gb@CZDTDCNCPe@Em@B]HYT_Ax@a@j@O`@[`B[dAs@nAcAbA[Vy@b@q@TwDlAIJEB}@|H_BvO}@lImBrRyAvNa@zDNFxBd@|B`@|BRu@dH', NULL, '2021-12-18 09:35:49', '2021-12-18 09:37:01', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1640, 'KWD691045', 290, 0, 130, 1, 8091, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 6.36, 63.17, '', '1001, Block F State Life Phase 1 State Life, Lahore, Punjab, Pakistan', 31.44262110, 74.39825690, 'Phase 5 D.H.A, Phase 5 D.H.A, Lahore, Punjab, Pakistan', 31.46253890, 74.40859290, '2021-12-18 09:48:06', NULL, NULL, NULL, 0, 0, 0, 0, 'kc|~De|aeMr@SHj@gBp@k@LNv@}@TeAXSBiAMiCa@mFk@sAOc@?WPa@^g@Z]Le@BUAeCYuDe@eEi@qAOH}@Da@VcDNaEBeBAyDKcCQiCQeBaBsKwE}UgA{Fw@_EwAyGs@cDq@oCsB_Hi@uA_AoBGEy@gBgAgBgBwCwB}C{A}Bs@eAwFuIwDmFgBkCa@m@PETSn@kAVq@Pw@Nk@Zy@n@eA`@_@p@a@VIf@G^@b@HG`@{@Gu@Nu@l@eAlAO`@YzA]hAUb@q@`A}@~@]RqAh@aEnAADKH]lCuArMsDb^}A~OaAfJ`@JdDr@~@N|BRu@dH', NULL, '2021-12-18 09:48:06', '2021-12-18 09:49:18', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1641, 'KWD145578', 289, 0, 123, 1, 5985, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 20.46, 205.80, '', 'J92M+CF2, Lusaka, Zambia', -15.39810890, 28.38533270, 'Makeni Mall, Makeni, T2, Lusaka, Zambia', -15.45381920, 28.26621590, '2021-12-18 09:55:05', NULL, NULL, NULL, 0, 0, 0, 0, 'jk~|Aw~flDr@jDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zE@P\\hELjAJf@x@lE\\lAh@zAnApCx@xAb@x@hBfCnGrH|B`CT\\|HnJjFfGhMrOtBhCd@h@tEtFj@v@zDtEtDfEzC|DzAfBfBtB`ArA`BhCd@`AbAlCf@~AV|@b@bC\\nCF|@r@nIbA~LZhEXvChAlNp@pH`ApLXlCZ~BXtBTfDPtBf@pGJr@HPLFDBBBXIdAUpEe@hPyA~RgBvRiBd^aDb@Gf@OJUZSVA\\PLV|Iy@dDE|@FpBZvBj@bBz@~@f@~@v@nAvAfApBj@jAbCxFhA~ArAtArA`ApB`A~CpA~Y|LxPdHbEnB`A^lD|AvQtH|Q~HtD~AhCnAh@RtFjCtCpAWb@?FG\\?|@GJKBy@JCLFnA', NULL, '2021-12-18 09:55:05', '2021-12-18 09:55:16', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1642, 'KWD655700', 289, 0, 95, 1, 6274, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 20.46, 205.80, '', 'J92M+CF2, Lusaka, Zambia', -15.39810890, 28.38533270, 'Makeni Mall, Makeni, T2, Lusaka, Zambia', -15.45381920, 28.26621590, '2021-12-18 09:58:40', NULL, NULL, NULL, 0, 0, 0, 0, 'jk~|Aw~flDr@jDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zE@P\\hELjAJf@x@lE\\lAh@zAnApCx@xAb@x@hBfCnGrH|B`CT\\|HnJjFfGhMrOtBhCd@h@tEtFj@v@zDtEtDfEzC|DzAfBfBtB`ArA`BhCd@`AbAlCf@~AV|@b@bC\\nCF|@r@nIbA~LZhEXvChAlNp@pH`ApLXlCZ~BXtBTfDPtBf@pGJr@HPLFDBBBXIdAUpEe@hPyA~RgBvRiBd^aDb@Gf@OJUZSVA\\PLV|Iy@dDE|@FpBZvBj@bBz@~@f@~@v@nAvAfApBj@jAbCxFhA~ArAtArA`ApB`A~CpA~Y|LxPdHbEnB`A^lD|AvQtH|Q~HtD~AhCnAh@RtFjCtCpAWb@?FG\\?|@GJKBy@JCLFnA', NULL, '2021-12-18 09:56:16', '2021-12-18 09:58:50', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1643, 'KWD896164', 289, 0, 134, 1, 9975, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 11.85, 118.76, '', 'J92M+CF2, Lusaka, Zambia', -15.39810890, 28.38533270, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-18 09:59:06', NULL, NULL, NULL, 0, 0, 0, 0, 'jk~|Aw~flDr@jDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zE@P\\hELjAJf@x@lE\\lAh@zAnApCx@xAb@x@hBfCnGrH|B`CT\\|HnJjFfGhMrO~AnBOLsCkDYBSF]X[RG?KGQ_@CGUPCB?DDJxB`CvAdB', NULL, '2021-12-18 09:59:06', '2021-12-18 09:59:42', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1644, 'KWD469963', 289, 135, 135, 1, 6528, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 11.85, 118.68, '', 'J92M+CF2, Lusaka, Zambia', -15.39803830, 28.38523300, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-18 10:01:31', NULL, '2021-12-18 10:07:51', '2021-12-18 10:19:37', 1, 1, 0, 0, 'nk~|Ai~flDn@|CeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zE@P\\hELjAJf@x@lE\\lAh@zAnApCx@xAb@x@hBfCnGrH|B`CT\\|HnJjFfGhMrO~AnBOLsCkDYBSF]X[RG?KGQ_@CGUPCB?DDJxB`CvAdB', NULL, '2021-12-18 10:01:31', '2021-12-18 10:19:57', 'NO', '11', 0.00000000, 0.00000000, 0.00000000),
(1645, 'KWD730459', 289, 0, 134, 1, 6059, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 16.06, 161.24, '', 'J92M+CF2, Lusaka, Zambia', -15.39823640, 28.38536800, 'Lusaka City Market, Lusaka City Market, Los Angeles Rd, Lusaka, Zambia', -15.42025780, 28.27568480, '2021-12-18 10:21:17', NULL, NULL, NULL, 0, 0, 0, 0, 'pm~|AmaglDyARe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@{CdPEJWR[B[?aA@I@KHGHE^w@`CmEzMkGhRwF|PyAjEK\\W\\_@RUPBHfB`KbBtI~@bE~@~CtGpRLXJJf@f@HJN^B`@DbA|@xCr@jC|@jE|DtT|B|M|B`LpCjOxFn\\d@hCNf@T~AZzADt@Fl@NZDBJJJPBXARAFEFBJHf@Jb@\\vAX|AbArFPbAXnCPpDCxDWzK[nPMvGAjBJrC~@vJz@bJb@~EVlDh@zFZrE^zDR|AP~@p@|Cb@pAh@tApAnCd@z@pArBbBvBrFnGtB|BRVpNzP~EbGzJtLX\\d@h@PT|AlB`CvCtEpFnA|AvAzAv@fArBfCjBzBzAhBzBhDV`@vAdD|@rC^bBd@rCj@zGn@tH`AjMp@bIpBxUhAzMv@`GTvBPfCPzBh@hGHb@F@LFNRDXCREHTP|@|@dErDhCfCp@hAN`@^`AvAdCXb@fCsA|Ac@jBSxKaAHtALAhNoAxEe@\\BLVj@fGLxA', NULL, '2021-12-18 10:21:17', '2021-12-18 10:21:37', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1646, 'KWD396850', 289, 135, 135, 1, 3919, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 11.85, 118.70, '', 'J92M+CF2, Lusaka, Zambia', -15.39808790, 28.38526880, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-18 10:34:06', NULL, '2021-12-18 10:37:04', '2021-12-18 10:37:11', 1, 1, 0, 0, 'nk~|Am~flDn@`DeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zE@P\\hELjAJf@x@lE\\lAh@zAnApCx@xAb@x@hBfCnGrH|B`CT\\|HnJjFfGhMrO~AnBOLsCkDYBSF]X[RG?KGQ_@CGUPCB?DDJxB`CvAdB', NULL, '2021-12-18 10:34:06', '2021-12-18 10:37:34', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1647, 'KWD972488', 289, 135, 135, 1, 9130, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 6.78, 67.42, '', 'Unnamed Road, Lusaka, Zambia', -15.39815540, 28.38543330, 'Hilltop Hospital, Kabulonga Rd, Lusaka, Zambia', -15.42010520, 28.35733490, '2021-12-18 10:39:04', NULL, '2021-12-18 10:39:38', '2021-12-18 10:39:45', 1, 1, 0, 0, 'dm~|AkaglDxBYa@mCjCc@YgBa@iC_@}BaAaG_@cCn@WvCmA@wH?{BAyCd@Ap@COoAACdCYzIeAzDe@zAWzB|D|HzLzDnGlCxEzGnKbCtDd@v@d@v@hAfBx@nALRFTRl@b@rAjArDPj@Tj@J^Bd@Ab@MhAOfAUfAQfAa@|Bg@nCEb@A`@@THb@R^VZf@p@xAlAlB|AV\\T\\^`At@tBt@tBpAxDRx@X~@n@`Cp@~Bb@|BjC`SVzAb@jCDVHPLNbIxGjBbBaBvBwCvDmBfCGLAVFb@rB`I~A`HdDvMRl@TPRDx@QzCy@v@Md@@t@NtBX`@VLTDT@bAw@CoAY', NULL, '2021-12-18 10:39:04', '2021-12-18 10:40:06', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1648, 'KWD378682', 289, 123, 123, 1, 4802, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 4.00, 45.00, '', 'Unnamed Road, Lusaka, Zambia', -15.39800810, 28.38528910, 'Grandaddy’s Shoka Nyama, Plot 206 Palm, Lusaka, Zambia', -15.39605830, 28.39428310, '2021-12-18 10:41:56', NULL, '2021-12-18 10:42:45', '2021-12-18 10:42:54', 1, 1, 0, 0, 'jk~|Au~flDaCyLyBd@c@{CmAsIjAWA_H?gDDmJaA?', NULL, '2021-12-18 10:41:56', '2021-12-18 10:43:18', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1649, 'KWD937884', 289, 0, 123, 1, 6690, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 16.12, 161.88, '', 'J92M+CF2, Lusaka, Zambia', -15.39810280, 28.38533880, 'Yellow Shop, Kamwala, South, Zambia', -15.45680720, 28.30610350, '2021-12-18 11:21:45', NULL, NULL, NULL, 0, 0, 0, 0, 'vl~|AgaglDfC]a@mCjCc@YgBa@iC_@}BaAaG_@cCn@WvCmA@wH?{BAyCd@Ap@COoAACdCYzIeAzDe@zAWzB|D|HzLzDnGlCxEzGnKbCtDd@v@d@v@hAfBx@nALRFTRl@b@rAjArDPj@Tj@J^Bd@Ab@MhAOfAUfAQfAa@|Bg@nCEb@A`@@THb@R^VZf@p@xAlAlB|AV\\T\\^`At@tBt@tBpAxDRx@X~@n@`Cp@~Bb@|BF^t@~F~Ks@pG[d@L|@RN@tASh@Bv@JlKtBdKpBxCTpCh@xKvBbEv@`HfArARALCXEXIt@WrBUjBc@hEmArJq@zF{@~G_@vCMjAGd@c@fEi@`EQxBi@rE~RfCzC`@~Fn@xIpAr@PpClAx@ZxBfAbBx@xAj@bDxAbAz@^f@bGjHn@n@d@RfA^RHr@p@f@l@Zr@Zv@`A`ChG~OrAbDsGpCeGjCJ|@N|Cf@rJbCvh@lBv`@X~FDzAn@BnA@v@@tAElAIh@IfB]~@Ur@Wn@Uj@_@p@Yp@UjBY[jCo@~BEPD@D@JBVFdBh@`EpAjB|@fA~@hAxAXb@j@jAzCvC|AfBfBxBnC|C`ApAkA|C}AdE{F`P{@tBt@b@SVc@`@CJF\\d@t@Xb@Zd@t@fAr@hAr@tAr@hAlAlBb@r@vAlCvArCt@hAv@fA\\b@fA`AdCpBpDlCjBdBp@f@j@^h@l@hAv@hAz@fAfAz@b@}AJiCDcCCs@?Eq@', NULL, '2021-12-18 11:21:45', '2021-12-18 11:22:08', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1650, 'KWD942619', 289, 0, 97, 1, 9261, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 16.12, 118.76, '', 'J92M+CF2, Lusaka, Zambia', -15.39811250, 28.38533040, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-18 12:25:08', NULL, NULL, NULL, 0, 0, 0, 0, 'jk~|Aw~flDr@jDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zE@P\\hELjAJf@x@lE\\lAh@zAnApCx@xAb@x@hBfCnGrH|B`CT\\|HnJjFfGhMrO~AnBOLsCkDYBSF]X[RG?KGQ_@CGUPCB?DDJxB`CvAdB', NULL, '2021-12-18 12:22:43', '2021-12-18 12:26:20', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1651, 'KWD748158', 289, 0, 97, 1, 7797, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 17.29, 173.71, '', 'Unnamed Road, Lusaka, Zambia', -15.39807360, 28.38542400, 'Sugarbush Cafe, GC9M+C6M, Lusaka, Zambia', -15.48140040, 28.43303870, '2021-12-18 12:30:13', NULL, NULL, NULL, 0, 0, 0, 0, 'tl~|AgaglDhC]a@mCjCc@YgBa@iC_@}BaAaG_@cCn@WvCmA@wH?{BAyCd@Ap@COoAACdCYzIeAzDe@zAWzB|D|HzLzDnGlCxEzGnKbCtDd@v@d@v@hAfBx@nALRFTRl@b@rAjArDPj@Tj@DJnCeAjOyEzCeAz@_@|@]xB}@`CcAdGuBhAc@bBm@dDcALGz@i@@Gy@mCzCaA`FcBdEsAdDgABLJZJZVt@n@lBn@lBtAnErAlEf@`BVt@JZTRz@lCl@nBhBrFnFvPxMdb@TbAXO`@_@dJqNjA_BvF_HnEaGvAsBNYDUAQGU?SLa@f@u@j@^jFvDpAbA@Jx@|@tA`AnBtAzDbCb@ZfAz@hAt@nAt@jAr@~@z@f@VPJzBbBfCfB`FlDhJvG`@Zz@q@pB}A|IgH~NmL|K_JlA_AtEeDbJeGdDqCnEeErG_GrH{GrRkQd]a[bJgItH_H`B}Al@o@j@w@|@yA`@kAdAcEl@uBlAqEnD}M|CaLf@wBl@wBlAoEzCaLdDaMfB_Hz@mDFeA@eA_@eEM}A[iEUmBsB_VsEij@sCcY', NULL, '2021-12-18 12:27:48', '2021-12-18 12:31:26', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1652, 'KWD407570', 290, 130, 130, 1, 4771, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 6.38, 63.39, '', '', 31.44284000, 74.39830667, 'Phase 5 D.H.A, Phase 5 D.H.A, Lahore, Punjab, Pakistan', 31.46253890, 74.40859290, '2021-12-18 12:32:19', NULL, '2021-12-18 12:35:12', '2021-12-18 12:37:22', 1, 1, 0, 0, 'qd|~Dw{aeMxAa@Hj@gBp@k@LNv@}@TeAXSBiAMiCa@mFk@sAOc@?WPa@^g@Z]Le@BUAeCYuDe@eEi@qAOH}@Da@VcDNaEBeBAyDKcCQiCQeBaBsKwE}UgA{Fw@_EwAyGs@cDq@oCsB_Hi@uA_AoBGEy@gBgAgBgBwCwB}C{A}Bs@eAwFuIwDmFgBkCa@m@PETSn@kAVq@Pw@Nk@Zy@n@eA`@_@p@a@VIf@G^@b@HG`@{@Gu@Nu@l@eAlAO`@YzA]hAUb@q@`A}@~@]RqAh@aEnAADKH]lCuArMsDb^}A~OaAfJ`@JdDr@~@N|BRu@dH', NULL, '2021-12-18 12:32:19', '2021-12-18 12:38:19', 'NO', '2', 0.00000000, 0.00000000, 0.00000000),
(1653, 'KWD804922', 289, 0, 95, 1, 3405, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.79, 57.45, '', 'J92M+CF2, Lusaka, Zambia', -15.39810970, 28.38525470, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-18 12:33:48', NULL, NULL, NULL, 0, 0, 0, 0, 'nk~|Ai~flDn@|CeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-18 12:32:35', '2021-12-18 12:34:08', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1654, 'KWD807543', 289, 0, 123, 1, 5552, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 9.46, 94.58, '', 'Unnamed Road, Lusaka, Zambia', -15.39787880, 28.38540570, 'EastPark Mall, Corner of Great East andThabo Mbeki Rds, Lusaka, Zambia', -15.39038920, 28.32219410, '2021-12-18 12:35:34', NULL, NULL, NULL, 0, 0, 0, 0, 'bk~|As_glDyB{KkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@{CdPEJWR[B[?aA@I@KHGHE^w@`CmEzMkGhRwF|PyAjEK\\W\\_@RUPBHfB`KbBtI~@bE~@~CtGpRLXJJf@f@HJN^B`@DbA|@xCr@jC|@jE|DtT|B|M|B`LpCjOxFn\\d@hCNf@T~AZzADt@Fl@NZDBJJJPBXARAFEFBJHf@Jb@\\vAX|AbArFPbAXnCPpDCxDWzK[nPMvGAjBJrC~@vJz@bJb@~EFz@HDRT^b@~@C?C@GDENCJFDLELMFMEq@pAG`@HpA\\nDP~A@A@?B@DB?HVNt@d@RRPLz@t@dAsA', NULL, '2021-12-18 12:35:34', '2021-12-18 12:35:40', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1655, 'KWD311770', 289, 0, 123, 1, 3845, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 8.53, 85.16, '', 'Unnamed Road, Lusaka, Zambia', -15.39801520, 28.38537410, 'Eden Haus, 37d Middleway, Lusaka, Zambia', -15.43086430, 28.35406110, '2021-12-18 12:36:36', NULL, NULL, NULL, 0, 0, 0, 0, 'fk~|Ae_glD}BiLyBd@c@{CmAsIjAWrDy@lEaAfEeB@cL?}AAkA`@At@CQsA|SeCzAW?FzE|HpB|CnElHxBjDpDfGlFlInBzCd@x@f@v@fAdBx@nATh@Pl@b@rAjArDRj@Rj@BFFb@@d@Eb@MhAQfAg@nCa@|Be@nCCv@Fb@J`@l@x@b@j@`BnAv@n@r@r@VZP^^`At@rBt@xBz@bCXdAJ^V~@p@`Cl@zBd@`CDZt@zFtEYpLs@v@?b@Px@NL?vASv@FdUnEnB^xCTrFdAnNnCrDj@lEr@CXIt@Ir@WtBUhBc@jEkAhJs@zF{@~G]vCOjAa@vDKnAg@tD_@pDYhCh@HhOlBnDd@o@tFGd@MA[E', NULL, '2021-12-18 12:36:36', '2021-12-18 12:36:43', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1656, 'KWD478498', 289, 0, 97, 1, 8321, 0, 'CANCELLED', 'NONE', NULL, 'CASH', 0, 9.47, 94.68, '', 'Unnamed Road, Lusaka, Zambia', -15.39805615, 28.38539508, 'EastPark Mall, Corner of Great East andThabo Mbeki Rds, Lusaka, Zambia', -15.39038920, 28.32219410, '2021-12-18 12:39:35', NULL, NULL, NULL, 0, 0, 0, 0, 'pl~|AgaglDy@Le@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@{CdPEJWR[B[?aA@I@KHGHE^w@`CmEzMkGhRwF|PyAjEK\\W\\_@RUPBHfB`KbBtI~@bE~@~CtGpRLXJJf@f@HJN^B`@DbA|@xCr@jC|@jE|DtT|B|M|B`LpCjOxFn\\d@hCNf@T~AZzADt@Fl@NZDBJJJPBXARAFEFBJHf@Jb@\\vAX|AbArFPbAXnCPpDCxDWzK[nPMvGAjBJrC~@vJz@bJb@~EFz@HDRT^b@~@C?C@GDENCJFDLELMFMEq@pAG`@HpA\\nDP~A@A@?B@DB?HVNt@d@RRPLz@t@dAsA', NULL, '2021-12-18 12:37:11', '2021-12-18 12:40:47', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1657, 'KWD781323', 290, 130, 130, 1, 8131, 0, 'SCHEDULED', 'NONE', NULL, 'CASH', 0, 6.38, 63.39, '', '', 31.44284000, 74.39830670, 'Phase 5 D.H.A, Phase 5 D.H.A, Lahore, Punjab, Pakistan', 31.46253890, 74.40859290, '2021-12-18 12:44:10', '2021-12-18 20:44:00', NULL, NULL, 0, 0, 0, 0, 'qd|~Dw{aeMxAa@Hj@gBp@k@LNv@}@TeAXSBiAMiCa@mFk@sAOc@?WPa@^g@Z]Le@BUAeCYuDe@eEi@qAOH}@Da@VcDNaEBeBAyDKcCQiCQeBaBsKwE}UgA{Fw@_EwAyGs@cDq@oCsB_Hi@uA_AoBGEy@gBgAgBgBwCwB}C{A}Bs@eAwFuIwDmFgBkCa@m@PETSn@kAVq@Pw@Nk@Zy@n@eA`@_@p@a@VIf@G^@b@HG`@{@Gu@Nu@l@eAlAO`@YzA]hAUb@q@`A}@~@]RqAh@aEnAADKH]lCuArMsDb^}A~OaAfJ`@JdDr@~@N|BRu@dH', NULL, '2021-12-18 12:44:10', '2021-12-18 12:44:16', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1658, 'KWD606016', 291, 0, 135, 1, 3646, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 10.29, 102.98, '', 'Unnamed Road, Lusaka, Zambia', -15.39807420, 28.38539580, 'Kalingalinga Clinic, H8VJ+64J, Lusaka, Zambia', -15.40690700, 28.33027050, '2021-12-18 12:50:35', NULL, NULL, NULL, 0, 0, 0, 0, 'rl~|AgaglD{@Le@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@{CdPEJWR[B[?aA@I@KHGHE^w@`CmEzMkGhRwF|PyAjEK\\W\\_@RUPBHfB`KbBtI~@bE~@~CtGpRLXJJf@f@HJN^B`@DbA|@xCr@jC|@jE|DtT|B|M|B`LpCjOxFn\\d@hCNf@T~AZzADt@Fl@NZDBJJDDXFbAX~@f@b@Nl@Fj@DNHH@h@BbBThF`AdF~@hDl@zKdBhRpCxDj@r@Lj@Np@VrAp@`B^rC`@nG~@jAJbG|@lATpC\\t@DnACr@?t@FrIhAbH~@GXqAzIsAdMu@bGG^M`A[~B]`CCNAFA?yAS', NULL, '2021-12-18 12:50:35', '2021-12-18 12:50:47', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1659, 'KWD748391', 291, 135, 135, 1, 8669, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 8.94, 89.33, '', 'J92M+CF2, Lusaka, Zambia', -15.39810370, 28.38533510, 'Munali Mall, 12th St, Lusaka, Zambia', -15.37214580, 28.34515770, '2021-12-18 12:56:08', NULL, '2021-12-18 12:57:12', '2021-12-18 13:02:07', 1, 1, 0, 0, 'jk~|Ay~flDr@lDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPSRYFQCOImA\\GDI@Q@a@CiC_@cEm@{LcByJoAsGw@_Gy@WE[Ew@Kw@KoBWqBW}Eo@w@M[EkDe@Eb@ShBq@I', NULL, '2021-12-18 12:56:08', '2021-12-18 13:02:41', 'NO', '4', 0.00000000, 0.00000000, 0.00000000),
(1660, 'KWD189544', 300, 0, 57, 1, 5550, 0, 'CANCELLED', 'USER', 'No ride assigned to me', 'CASH', 0, 10.27, 102.76, '', 'G9V6+HRG, Lusaka, Zambia', -15.45734980, 28.36211210, 'Forest Park Specialised Hospital, 8238, Nangwenya Rd, Lusaka 10101, Zambia', -15.40403700, 28.31767900, '2021-12-18 13:25:58', NULL, NULL, NULL, 0, 0, 0, 0, 'l_j}AmoblDyH?mGFWBKFIJ?b@@nH?zC@xTDvLu@DkACuCFM??jDAlE@jA@lJBjAgExAy@RcAb@cBt@yCtAeFtBqF|B}D`B}CnAYRsBv@cBt@mBz@u@XsGpCeGjCcDrAmF`CiAd@iHzCOH@BDL?\\KTUPUBUCWQe@CWCYDeANmBXkARmCPyB@cAGoBQwBe@gC}@oBcAgEeC}@g@{BbEqDvG_HlMi@x@]`@oAjA}GhG_Az@eD|BDX?f@AXQ`B?Zx@`GlBhOV~C?~@?|@IrAc@bCi@jBuArEsBxGoDnLgClIMb@Mb@]fA}@nC{@hCkBtGgA|Dc@pAW`@a@f@}@d@m@NcBJwANSH?@ADMFKAKK?OBi@aCwKqCL}@Dc@G{@[eIeEsE}BkAq@aBy@}BkBuAeBe@o@qDt@yEhAyAVoFh@[B]Dy@Hy@HsBRsBTy@HM@Jf@ZpBBnAAl@E?U?I@CD', NULL, '2021-12-18 13:25:58', '2021-12-18 13:26:33', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1661, 'KWD855012', 300, 0, 57, 1, 1467, 0, 'CANCELLED', 'USER', 'No ride', 'CASH', 0, 10.27, 102.76, '', 'G9V6+HRG, Lusaka, Zambia', -15.45734980, 28.36211210, 'Forest Park Specialised Hospital, 8238, Nangwenya Rd, Lusaka 10101, Zambia', -15.40403700, 28.31767900, '2021-12-18 13:27:57', NULL, NULL, NULL, 0, 0, 0, 0, 'l_j}AmoblDyH?mGFWBKFIJ?b@@nH?zC@xTDvLu@DkACuCFM??jDAlE@jA@lJBjAgExAy@RcAb@cBt@yCtAeFtBqF|B}D`B}CnAYRsBv@cBt@mBz@u@XsGpCeGjCcDrAmF`CiAd@iHzCOH@BDL?\\KTUPUBUCWQe@CWCYDeANmBXkARmCPyB@cAGoBQwBe@gC}@oBcAgEeC}@g@{BbEqDvG_HlMi@x@]`@oAjA}GhG_Az@eD|BDX?f@AXQ`B?Zx@`GlBhOV~C?~@?|@IrAc@bCi@jBuArEsBxGoDnLgClIMb@Mb@]fA}@nC{@hCkBtGgA|Dc@pAW`@a@f@}@d@m@NcBJwANSH?@ADMFKAKK?OBi@aCwKqCL}@Dc@G{@[eIeEsE}BkAq@aBy@}BkBuAeBe@o@qDt@yEhAyAVoFh@[B]Dy@Hy@HsBRsBTy@HM@Jf@ZpBBnAAl@E?U?I@CD', NULL, '2021-12-18 13:27:57', '2021-12-18 13:29:08', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1662, 'KWD960013', 291, 0, 134, 1, 2883, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.37, 53.16, '', 'Mass Media Area, between Thabo Mbeki Rd &, Alick Nkhata Rd, Lusaka, Zambia', -15.40327880, 28.32774810, 'Kabwata Market, H885+34C, Lusaka, Zambia', -15.43480130, 28.30777470, '2021-12-18 15:20:02', NULL, NULL, NULL, 0, 0, 0, 0, 'nm_}Aow{kDw@Oj@zAvBlErB`EnCrFzAw@|HiE@BBHHPRb@Tb@h@dAh@dAnAdCrCxFxBtEhBdDz@lA~@fAz@p@`Ax@fAl@dB|@dOxHjAd@f@FlESXjAdBvHXn@@@B@B@BF?L?d@J`Ap@~Cb@jB`HZvGf@bDPbId@xGb@jABjNOxNIbRWhHEd@Ad@?hAAfGEn@?j@LLDs@~BiA`CyA|B_ItK', NULL, '2021-12-18 15:20:02', '2021-12-18 15:20:19', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1663, 'KWD995636', 289, 135, 135, 1, 7363, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 4.00, 45.00, '', 'H8WH+3HV, Lusaka, Zambia', -15.40461800, 28.32878490, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-18 15:23:13', NULL, '2021-12-18 15:24:00', '2021-12-18 15:24:05', 1, 1, 0, 0, 'hv_}Ak`|kDcH{@q@tFGp@HXl@`BvBlErB`EnCrFyDrBqDnByDrBbBjDrDrHv@rC\\~AZpBBnAC|AAx@c@hU_@vRMhJ?bAqBTcBZgCt@aChAo@^uCbCiB|AYVYXMJM@KHKJMLYVYXu@p@EDEDgAcACKBQPWxAqADIAIcBuBuBiC', NULL, '2021-12-18 15:23:13', '2021-12-18 15:24:59', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1664, 'KWD532872', 289, 135, 135, 1, 5325, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 5.46, 54.11, '', 'Unnamed Road, Lusaka, Zambia', -15.39806560, 28.38553480, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-18 18:27:28', NULL, '2021-12-18 18:28:01', '2021-12-18 18:28:13', 1, 1, 0, 0, 'vl~|AgaglD_ALe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-18 18:27:28', '2021-12-18 18:28:43', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1665, 'KWD695494', 289, 0, 135, 1, 4851, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.37, 118.76, '', 'J92M+CF2, Lusaka, Zambia', -15.39811230, 28.38533250, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-18 20:27:26', NULL, NULL, NULL, 0, 0, 0, 0, 'jk~|Aw~flDr@jDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zE@P\\hELjAJf@x@lE\\lAh@zAnApCx@xAb@x@hBfCnGrH|B`CT\\|HnJjFfGhMrO~AnBOLsCkDYBSF]X[RG?KGQ_@CGUPCB?DDJxB`CvAdB', NULL, '2021-12-18 20:27:26', '2021-12-18 20:28:20', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1666, 'KWD181675', 170, 135, 135, 1, 1380, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 14.76, 148.11, '', 'J92M+CF2, Lusaka, Zambia', -15.39811230, 28.38533250, 'Pick n Pay Levy Park, Kabelenga Rd, Lusaka, Zambia', -15.41318090, 28.28595270, '2021-12-18 23:10:15', NULL, '2021-12-18 23:11:20', '2021-12-18 23:13:38', 0, 1, 0, 0, 'jk~|Aw~flDr@jDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zE@P\\hELjAJf@x@lE\\lAh@zAnApCx@xAb@x@hBfCnGrH|B`CT\\|HnJjFfGhMrOtBhCd@h@tEtFj@v@zDtEtDfEzC|DzAfBfBtB`ArA`BhCd@`AbAlCf@~AV|@b@bC\\nCF|@r@nIbA~LZhEXvChAlNp@pHtBYtC_@VxCr@jI^C|NsAb@MrBkArAq@', NULL, '2021-12-18 23:10:15', '2021-12-18 23:20:04', 'NO', '2', 0.00000000, 0.00000000, 0.00000000),
(1667, 'KWD347495', 289, 134, 134, 1, 8267, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 11.85, 118.74, '', 'Unnamed Road, Lusaka, Zambia', -15.39807250, 28.38530260, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-18 23:23:23', NULL, '2021-12-18 23:24:09', '2021-12-18 23:25:49', 1, 1, 0, 0, 'lk~|As~flDp@fDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zE@P\\hELjAJf@x@lE\\lAh@zAnApCx@xAb@x@hBfCnGrH|B`CT\\|HnJjFfGhMrO~AnBOLsCkDYBSF]X[RG?KGQ_@CGUPCB?DDJxB`CvAdB', NULL, '2021-12-18 23:23:23', '2021-12-18 23:26:33', 'NO', '1', 0.00000000, 0.00000000, 0.00000000),
(1668, 'KWD272290', 289, 135, 135, 1, 6313, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 9.97, 102.02, '', 'Unnamed Road, Lusaka, Zambia', -15.39801260, 28.38534850, 'The Gathering Zambia, Twin Palms Rd, Lusaka, Zambia', -15.42423490, 28.33730390, '2021-12-19 02:10:06', NULL, '2021-12-19 02:10:47', '2021-12-19 02:11:01', 1, 1, 0, 0, 'hk~|A__glD_CoLyBd@c@{CmAsIjAWrDy@lEaAfEeB@cL?}AAkA`@At@CQsA|SeCzAW?FzE|HpB|CnElHxBjDpDfGlFlInBzCd@x@f@v@fAdBx@nATh@Pl@b@rAjArDRj@Rj@BFFb@@d@Eb@MhAQfAg@nCa@|Be@nCCv@Fb@J`@l@x@b@j@`BnAv@n@r@r@VZP^^`At@rBt@xBz@bCXdAJ^V~@p@`Cl@zBd@`CDZt@zFtEYpLs@v@?b@Px@NL?vASv@FdUnEnB^xCTrFdAnNnCrDj@lEr@CXIt@Ir@WtBUhBc@jEkAhJs@zF{@~G]vCOjAa@vDKnAg@tD_@pD[pCeChRG`@M`A[fCu@bGw@jG[jCqE~]cAfJg@zDoBrOWvB', NULL, '2021-12-19 02:10:06', '2021-12-19 02:11:43', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1669, 'KWD175710', 289, 135, 135, 1, 5401, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 4.00, 45.00, '', 'Unnamed Road, Lusaka, Zambia', -15.39809770, 28.38550610, 'Honeybed lodge, 24 Olive Road, Salama Park Lusaka ZM, Lusaka 10101, Zambia', -15.39749760, 28.38583280, '2021-12-19 02:14:20', NULL, '2021-12-19 02:14:58', '2021-12-19 02:15:09', 1, 1, 0, 0, '|l~|AiaglDeANQ}@', NULL, '2021-12-19 02:14:20', '2021-12-19 02:16:33', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1670, 'KWD449789', 289, 123, 123, 1, 5474, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 11.52, 117.67, '', 'J92M+CF2, Lusaka, Zambia', -15.39811530, 28.38536000, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-19 02:17:00', NULL, '2021-12-19 02:17:32', '2021-12-19 02:17:47', 1, 1, 0, 0, 'zl~|AiaglDcANe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@{CdPEJWR[B[?aA@I@KHGHE^w@`CmEzMkGhRwF|PyAjEK\\W\\_@RUPBHfB`KbBtI~@bE~@~CtGpRLXJJf@f@HJN^B`@DbA|@xCr@jC|@jE|DtT|B|M|B`LpCjOxFn\\d@hCNf@T~AZzADt@Fl@NZDBJJJPBXARAFEFBJHf@Jb@\\vAX|AbArFPbAXnCPpDCxDWzK[nPMvGAjBJrC~@vJz@bJb@~EVlDh@zFZrE^zDR|AP~@p@|Cb@pAh@tApAnCd@z@pArBbBvBrFnGtB|BRVpNzP~EbGzJtLOLsCkDg@Fq@h@IFI?OKSc@YV?F~BhCvAdB', NULL, '2021-12-19 02:17:00', '2021-12-19 02:18:34', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1671, 'KWD661799', 289, 123, 123, 1, 6685, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 5.46, 56.19, '', 'Unnamed Road, Lusaka, Zambia', -15.39809360, 28.38544400, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-19 02:18:58', NULL, '2021-12-19 02:19:30', '2021-12-19 02:19:50', 1, 1, 0, 0, 'xl~|AiaglDaANe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-19 02:18:58', '2021-12-19 02:20:11', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1672, 'KWD283545', 289, 123, 123, 1, 9770, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 12.36, 126.20, '', 'J92M+CF2, Lusaka, Zambia', -15.39811250, 28.38533110, 'Water Resources Management Authority[WARMA (HQ)], Plot Nos. LN-385-7 & LN-385, 8 Alick Nkhata Rd, Lusaka, Zambia', -15.41205700, 28.31833410, '2021-12-19 02:20:42', NULL, '2021-12-19 02:21:32', '2021-12-19 02:23:59', 1, 1, 0, 0, 'jk~|Aw~flDr@jDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHDDLFz@VZHf@Vb@Rb@JjAJPHB?h@BbBTvGnA~HvAnK`BxLfBjMnBbAZbAd@fAb@fB\\jFt@bDb@z@HSrDk@fFAZq@vFiAdHGLw@dHcB`NcAtHWdAMZ_CvBlI|PzBtEvAfCn@v@Xj@vBlE~CpGX~@n@jCF?ZEx@Ix@IrBUrBSrI{@rAUhCm@`GqAz@lA~@fAz@p@`Ax@fAl@zAv@', NULL, '2021-12-19 02:20:42', '2021-12-19 02:24:42', 'NO', '2', 0.00000000, 0.00000000, 0.00000000),
(1673, 'KWD136451', 289, 123, 123, 1, 7752, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 7.65, 78.42, '', 'Unnamed Road, Lusaka, Zambia', -15.39801330, 28.38559590, 'Liebherr Zambia Ltd, 175 Kudu Rd, Lusaka, Zambia', -15.41049910, 28.34952650, '2021-12-19 02:28:24', NULL, '2021-12-19 02:35:13', '2021-12-19 02:35:20', 1, 1, 0, 0, 'pl~|AgaglDlC]a@mCjCc@YgBa@iC_@}BaAaG_@cCn@WvCmA@wH?{BAyCd@Ap@COoAACdCYzIeAzDe@zAWzB|D|HzLzDnGlCxEzGnKbCtDd@v@d@v@hAfBx@nALRFTRl@b@rAjArDPj@Tj@J^Bd@Ab@MhAOfAUfAQfAa@|Bg@nCEb@A`@@THb@R^VZf@p@xAlAlB|AV\\T\\^`At@tBt@tBpAxDRx@X~@n@`Cp@~Bb@|BjC`SVzAb@jCDVHPLNbIxGjBbBaBvBwCvDmBfCGLAVFb@rB`I~A`HMPGRGpBELIFKBQ?eBKUbJH?JB|@@VFHHDN?`@Q|D@d@QPuFrEwFdEyHdG}CxBw@d@q@^_Bp@o@PNjAv@~F', NULL, '2021-12-19 02:28:12', '2021-12-19 02:35:35', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1674, 'KWD868400', 289, 123, 123, 1, 5853, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 11.52, 117.65, '', 'Unnamed Road, Lusaka, Zambia', -15.39808820, 28.38540600, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-19 02:36:08', NULL, '2021-12-19 02:36:40', '2021-12-19 02:36:45', 1, 1, 0, 0, 'vl~|AgaglD_ALe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@{CdPEJWR[B[?aA@I@KHGHE^w@`CmEzMkGhRwF|PyAjEK\\W\\_@RUPBHfB`KbBtI~@bE~@~CtGpRLXJJf@f@HJN^B`@DbA|@xCr@jC|@jE|DtT|B|M|B`LpCjOxFn\\d@hCNf@T~AZzADt@Fl@NZDBJJJPBXARAFEFBJHf@Jb@\\vAX|AbArFPbAXnCPpDCxDWzK[nPMvGAjBJrC~@vJz@bJb@~EVlDh@zFZrE^zDR|AP~@p@|Cb@pAh@tApAnCd@z@pArBbBvBrFnGtB|BRVpNzP~EbGzJtLOLsCkDg@Fq@h@IFI?OKSc@YV?F~BhCvAdB', NULL, '2021-12-19 02:36:08', '2021-12-19 02:37:03', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1675, 'KWD967587', 289, 0, 134, 1, 9945, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 5.46, 56.18, '', 'Unnamed Road, Lusaka, Zambia', -15.39808820, 28.38540600, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-19 02:37:36', NULL, NULL, NULL, 0, 0, 0, 0, 'vl~|AgaglD_ALe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-19 02:37:26', '2021-12-19 02:37:47', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1676, 'KWD142792', 289, 123, 123, 1, 5266, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 11.52, 117.65, '', 'Unnamed Road, Lusaka, Zambia', -15.39808820, 28.38540600, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-19 02:44:05', NULL, '2021-12-19 02:45:01', '2021-12-19 02:45:07', 1, 1, 0, 0, 'vl~|AgaglD_ALe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@{CdPEJWR[B[?aA@I@KHGHE^w@`CmEzMkGhRwF|PyAjEK\\W\\_@RUPBHfB`KbBtI~@bE~@~CtGpRLXJJf@f@HJN^B`@DbA|@xCr@jC|@jE|DtT|B|M|B`LpCjOxFn\\d@hCNf@T~AZzADt@Fl@NZDBJJJPBXARAFEFBJHf@Jb@\\vAX|AbArFPbAXnCPpDCxDWzK[nPMvGAjBJrC~@vJz@bJb@~EVlDh@zFZrE^zDR|AP~@p@|Cb@pAh@tApAnCd@z@pArBbBvBrFnGtB|BRVpNzP~EbGzJtLOLsCkDg@Fq@h@IFI?OKSc@YV?F~BhCvAdB', NULL, '2021-12-19 02:43:49', '2021-12-19 02:47:21', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1677, 'KWD205488', 289, 0, 134, 1, 6449, 0, 'CANCELLED', 'USER', '', 'CASH', 0, 10.22, 104.48, '', '410/12 Salama Park, Lusaka, Zambia', -15.39818990, 28.38491410, 'SunShare Tower, Lusaka, Zambia', -15.38825950, 28.31652130, '2021-12-19 02:52:08', NULL, NULL, NULL, 0, 0, 0, 0, 'zn~|Aq{flD{@dAeBfCe@LUMOb@Gj@D_@ECyEw@{HqAwI_Bg@Iq@a@YIG?y@@uKb@MOYkDUiBMwBt@_B[S[Uc@Kg@CsBNkDLgSn@oCHg@nCsBtKEJWR[BaA@[?I@KHGHE^w@`CoGrRuJ~YsCnIQj@K\\W\\_@RUPBHfB`KVjAjAhG~@bE~@~CtGpRLXJJf@f@RXF`@@PDbA|@xCr@jC|@jEtBnLdCpN~@pFb@vBxAhHv@dEfAnGf@fCtAhIrD|SNf@T~AZzADt@Fl@NZDBDDJJHX?XCLEFBJHf@h@zBdAfGh@lCXnCPpDCxDKbEWfMEzCMtFIdEAjBJrC\\vDdA~KdAjLZvDZhDRdCNjAp@lFHp@t@jDb@`B^dATd@RXB@LBPHJNHR@RANEJMRQFO@K?QGs@LQ@IF_EtCp@dA', NULL, '2021-12-19 02:52:08', '2021-12-19 02:52:40', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1678, 'KWD762973', 289, 123, 123, 1, 2447, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 5.45, 56.10, '', 'Unnamed Road, Lusaka, Zambia', -15.39800380, 28.38545420, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-19 02:55:03', NULL, '2021-12-19 02:56:57', '2021-12-19 02:57:12', 1, 1, 0, 0, 'hl~|AeaglDq@Je@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@rGu^LaA?_@Q@c@CmFiAmK_CsCm@kBW}Ew@qCg@yBc@y@Gw@AoBBw@H[FcAXcCbAw@n@qF~DUHgALo@Lf@dDT`Bs@PiBV_AmGKm@oAwHaAcH{AsJ_BaKe@oCUu@IYGAUMMSC_@@YLUPOd@IVDHMFg@IwAc@sCq@LCF@b@Lv@', NULL, '2021-12-19 02:54:52', '2021-12-19 02:57:29', 'NO', '0', 0.00000000, 0.00000000, 0.00000000);
INSERT INTO `user_requests` (`id`, `booking_id`, `user_id`, `provider_id`, `current_provider_id`, `service_type_id`, `otp`, `returntrip`, `status`, `cancelled_by`, `cancel_reason`, `payment_mode`, `paid`, `distance`, `amount`, `specialNote`, `s_address`, `s_latitude`, `s_longitude`, `d_address`, `d_latitude`, `d_longitude`, `assigned_at`, `schedule_at`, `started_at`, `finished_at`, `user_rated`, `provider_rated`, `use_wallet`, `surge`, `route_key`, `deleted_at`, `created_at`, `updated_at`, `is_track`, `travel_time`, `track_distance`, `track_latitude`, `track_longitude`) VALUES
(1679, 'KWD305656', 289, 135, 135, 1, 4884, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 5.79, 59.59, '', 'Unnamed Road, Lusaka, Zambia', -15.39803960, 28.38528150, 'Waterfalls Mall, Cnr Great East & Airport Rd, Lusaka, Zambia', -15.36983480, 28.40223770, '2021-12-19 03:08:53', NULL, '2021-12-19 03:09:27', '2021-12-19 03:09:35', 1, 1, 0, 0, 'lk~|Aq~flDp@dDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABDW`BgJnBsKz@aFLaA?_@E?Y@gFeAsJuBqDy@g@IiBWeEq@gBYkDq@w@Iy@AmBBw@Hw@NkBp@cAb@s@j@uAbA{C|BYJyAR]F\\|B^hCs@PiBVeAcHuAoIaAcHg@_Du@}EQgA{B_NUo@SGQSGS?g@L[PORGPAVDN_@?w@Gu@c@sCq@LCF@b@Lp@?D', NULL, '2021-12-19 03:08:43', '2021-12-19 03:10:04', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1680, 'KWD110186', 289, 123, 123, 1, 6346, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 4.00, 45.00, '', 'J92M+CF2, Lusaka, Zambia', -15.39827530, 28.38522850, 'Honeybed lodge, 24 Olive Road, Salama Park Lusaka ZM, Lusaka 10101, Zambia', -15.39749760, 28.38583280, '2021-12-19 03:11:17', NULL, '2021-12-19 03:12:00', '2021-12-19 03:12:06', 1, 1, 0, 0, '`p~|A{|flDaBnByAkH', NULL, '2021-12-19 03:11:09', '2021-12-19 03:12:41', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1681, 'KWD205489', 289, 135, 135, 1, 9360, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 17.82, 181.59, '', 'Unnamed Road, Lusaka, Zambia', -15.39787540, 28.38558370, 'China Mall, H77G+WFQ, Lusaka, Zambia', -15.43515260, 28.27622200, '2021-12-19 03:38:16', NULL, '2021-12-19 03:39:29', '2021-12-19 03:39:48', 1, 1, 0, 0, 'tk~|AaaglD]Fe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@{CdPEJWR[B[?aA@I@KHGHE^w@`CmEzMkGhRwF|PyAjEK\\W\\_@RUPBHfB`KbBtI~@bE~@~CtGpRLXJJf@f@HJN^B`@DbA|@xCr@jC|@jE|DtT|B|M|B`LpCjOxFn\\d@hCNf@T~AZzADt@Fl@NZDBJJJPBXARAFEFBJHf@Jb@\\vAX|AbArFPbAXnCPpDCxDWzK[nPMvGAjBJrC~@vJz@bJb@~EVlDh@zFZrE^zDR|AP~@p@|Cb@pAh@tApAnCd@z@pArBbBvBrFnGtB|BRVpNzP~EbGzJtLX\\d@h@PT|AlB`CvCtEpFnA|AvAzAv@fArBfCjBzBzAhBzBhDV`@vAdD|@rC^bBd@rCj@zGn@tH`AjMp@bIpBxUhAzMv@`GTvBPfCPzBh@hGHb@F@LFDDv@S`Dc@lGi@xJ_AfSgBlSmB`Q_BlK}@f@KTIBITWNGTAPHNLFJ@DJAhFe@fBQr@Cv@AhBBpAPlBb@v@TdAh@|Ax@~@v@|@`Ap@bA|@bBjBpEl@rA`@j@f@r@|@~@t@n@r@f@pB`A~CpAMXWx@nGjCm@dB', NULL, '2021-12-19 03:37:03', '2021-12-19 03:40:13', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1682, 'KWD943106', 289, 123, 123, 1, 5730, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 20.11, 204.84, '', 'Unnamed Road, Lusaka, Zambia', -15.39787540, 28.38558370, 'Makeni Mall, Makeni, T2, Lusaka, Zambia', -15.45381920, 28.26621590, '2021-12-19 03:40:37', NULL, '2021-12-19 03:41:26', '2021-12-19 03:41:41', 1, 1, 0, 0, 'tk~|AaaglD]Fe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@{CdPEJWR[B[?aA@I@KHGHE^w@`CmEzMkGhRwF|PyAjEK\\W\\_@RUPBHfB`KbBtI~@bE~@~CtGpRLXJJf@f@HJN^B`@DbA|@xCr@jC|@jE|DtT|B|M|B`LpCjOxFn\\d@hCNf@T~AZzADt@Fl@NZDBJJJPBXARAFEFBJHf@Jb@\\vAX|AbArFPbAXnCPpDCxDWzK[nPMvGAjBJrC~@vJz@bJb@~EVlDh@zFZrE^zDR|AP~@p@|Cb@pAh@tApAnCd@z@pArBbBvBrFnGtB|BRVpNzP~EbGzJtLX\\d@h@PT|AlB`CvCtEpFnA|AvAzAv@fArBfCjBzBzAhBzBhDV`@vAdD|@rC^bBd@rCj@zGn@tH`AjMp@bIpBxUhAzMv@`GTvBPfCPzBh@hGHb@F@LFDDv@S`Dc@lGi@xJ_AfSgBlSmB`Q_BlK}@f@KTIBITWNGTAPHNLFJ@DJAhFe@fBQr@Cv@AhBBpAPlBb@v@TdAh@|Ax@~@v@|@`Ap@bA|@bBjBpEl@rA`@j@f@r@|@~@t@n@r@f@pB`A|YzLxJ`E|ErBbCbAbEnBrElBtMtFrLbFvNhGnCpAtCnA|E|B`Ab@Wb@CTEd@@\\CPIFs@DMDAFDp@@b@', NULL, '2021-12-19 03:40:30', '2021-12-19 03:46:16', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1683, 'KWD176407', 289, 135, 135, 1, 5871, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 23.23, 236.56, '', 'Unnamed Road, Lusaka, Zambia', -15.39810010, 28.38545180, 'TS Tyre Services, G795+J4P, Lusaka, Zambia', -15.48091940, 28.25781480, '2021-12-19 03:46:34', NULL, '2021-12-19 03:47:03', '2021-12-19 03:47:37', 1, 1, 0, 0, 'zl~|AiaglDcANe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@{CdPEJWR[B[?aA@I@KHGHE^w@`CmEzMkGhRwF|PyAjEK\\W\\_@RUPBHfB`KbBtI~@bE~@~CtGpRLXJJf@f@HJN^B`@DbA|@xCr@jC|@jE|DtT|B|M|B`LpCjOxFn\\d@hCNf@T~AZzADt@Fl@NZDBJJJPBXARAFEFBJHf@Jb@\\vAX|AbArFPbAXnCPpDCxDWzK[nPMvGAjBJrC~@vJz@bJb@~EVlDh@zFZrE^zDR|AP~@p@|Cb@pAh@tApAnCd@z@pArBbBvBrFnGtB|BRVpNzP~EbGzJtLX\\d@h@PT|AlB`CvCtEpFnA|AvAzAv@fArBfCjBzBzAhBzBhDV`@vAdD|@rC^bBd@rCj@zGn@tH`AjMp@bIpBxUhAzMv@`GTvBPfCPzBh@hGHb@F@LFDDv@S`Dc@lGi@xJ_AfSgBlSmB`Q_BlK}@f@KTIBITWNGTAPHNLFJ@DJAhFe@fBQr@Cv@AhBBpAPlBb@v@TdAh@|Ax@~@v@|@`Ap@bA|@bBjBpEl@rA`@j@f@r@|@~@t@n@r@f@pB`A|YzLxJ`E|ErBbCbAbEnBrElBtMtFrLbFvNhGnCpAtCnAvP`IhAj@pEzBrD|A`I`D~CpA|BdAlC`AhEjBhC|@|Dp@~DPtDHpRl@l@ABCBEBCJEJ?VHHJ\\JjBDbDRtEp@tDx@nLvCjBr@~DhBhWrMn@}A', NULL, '2021-12-19 03:46:34', '2021-12-19 03:48:11', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1684, 'KWD281966', 289, 123, 123, 1, 9166, 0, 'CANCELLED', 'PROVIDER', '', 'CASH', 0, 11.85, 121.09, '', 'J92M+CF2, Lusaka, Zambia', -15.39810920, 28.38533270, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-19 07:15:39', NULL, NULL, NULL, 0, 0, 0, 0, 'jk~|Aw~flDr@jDeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zE@P\\hELjAJf@x@lE\\lAh@zAnApCx@xAb@x@hBfCnGrH|B`CT\\|HnJjFfGhMrO~AnBOLsCkDYBSF]X[RG?KGQ_@CGUPCB?DDJxB`CvAdB', NULL, '2021-12-19 07:15:39', '2021-12-19 07:16:00', 'NO', NULL, 0.00000000, 0.00000000, 0.00000000),
(1685, 'KWD323032', 289, 135, 135, 1, 1971, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 18.15, 185.02, '', 'J92M+CF2, Lusaka, Zambia', -15.39819090, 28.38515820, 'China Mall, H77G+WFQ, Lusaka, Zambia', -15.43515260, 28.27622200, '2021-12-19 07:59:00', NULL, '2021-12-19 07:59:26', '2021-12-19 07:59:30', 1, 1, 0, 0, 'vk~|As}flDf@fCeBfCe@LUMOb@Gj@D_@ECoMwBiCe@yHuAs@a@_@IwBFuERcCHMO[oDSeBMwBt@_BIEa@[]Og@Gc@@eCPaFPwRl@eABQ~@qBpKYxAQRUF[@aA@Y@SRE^Qh@gD`KwDhLsKb\\uA`ESr@[^q@b@~@nFlBxJhArF`@fBxIjWx@x@NZFb@ALF|@H\\jA|Dh@lBdF`Y~B~MRjAx@rD~AjId@lCz@xEpCfPjCbOVhAp@xDDVFlAP\\LHJNDXAVGPN~@n@lClA|GP~@PrAXdDFbDUdMUrJEjDQjHCvCBfBRtC^|DbAnKb@zEZbE`@pE^zE@P\\hELjAJf@x@lE\\lAh@zAnApCx@xAb@x@hBfCnGrH|B`CT\\|HnJjFfGhMrOtBhCd@h@tEtFj@v@zDtEtDfEzC|DzAfBfBtB`ArA`BhCd@`AbAlCf@~AV|@b@bC\\nCF|@r@nIbA~LZhEXvChAlNp@pH`ApLXlCZ~BXtBTfDPtBf@pGJr@HPLFDBBBXIdAUpEe@hPyA~RgBvRiBd^aDb@Gf@OJUZSVA\\PLV|Iy@dDE|@FpBZvBj@bBz@~@f@~@v@nAvAfApBj@jAbCxFhA~ArAtArA`ApB`A~CpAe@rAnGjCm@dB', NULL, '2021-12-19 07:59:00', '2021-12-19 07:59:51', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1686, 'KWD849818', 289, 123, 123, 1, 6392, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 9.39, 96.04, '', 'H932+HFP, Lusaka, Zambia', -15.44704330, 28.35140490, 'Manda Hill Shopping Mall, 19255 Manda Hill Rd, Lusaka, Zambia', -15.39754650, 28.30702210, '2021-12-19 08:59:49', NULL, '2021-12-19 09:00:26', '2021-12-19 09:00:35', 1, 1, 0, 0, 'p~g}Ael`lD}BbArAdEh@`CmEnBuLdFiFzBh@rA`E~JBLsAn@gGdCmEpBaFrBaDxAqElBoDzAHXE\\KPYNO@mChJ}C`K{HfW_D|JkH`ViB~FeDtKwC~JaDbKyBhHyD|LqDxLqAlEqBhFKJg@lAgA~AsDhFGHGHOR_@h@_@f@}@hADDFL@NENOZSXi@p@WZONOJYCGEsG|I}AvB?BNVBXOb@}@nAyAnBQL[DY@MEoAQgHh@sOhAoAHe@LA\\IT[XWFY?WIQOMWEO?QO[U[wA}@qCaBwCeB{Ay@qJ{EwE_CeAg@cBo@gBc@}@OuBUoAGeBAy@BeAF_Db@_B`@kA^cAd@aAd@k@\\aAv@eDrCSPMJMLYVKLG@QFMLKJ[XYVs@p@ONiAiA?ODOrAqAXUCQwE{F', NULL, '2021-12-19 08:59:49', '2021-12-19 09:02:23', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1687, 'KWD766503', 289, 135, 135, 1, 6394, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 10.13, 103.59, '', 'Unnamed Road, Lusaka, Zambia', -15.40448920, 28.38143870, 'Italian School Of Lusaka, Lubu Rd, Lusaka, Zambia', -15.40769100, 28.31021280, '2021-12-19 09:52:58', NULL, '2021-12-19 09:53:39', '2021-12-19 09:53:49', 1, 1, 0, 0, 'lu_}AmgflDvAjA`BTrAT|Bf@lAVdF`Af@R`@\\fMpC@THb@R^l@v@b@d@bBrAv@n@p@t@T\\N^^bAl@bBhAfDt@vBLh@J^X~@V~@n@`CTv@RdAP~@lCfSTtAd@rCPZtC`CrD|CjBbB}EjGiCjDIZ@Z~@jDxB`J^fBbBzG`AzDRl@TPRDx@QzCy@v@Md@@t@NtBX`@VLTDT@bAB|ABjCAjBIbAq@pFu@dFGr@_@tCYvEMtCFvBNhCZlDbCnQ`AbIp@tE`Ef\\jApJTdB@A^?`@PRVBPDd@Ed@@DQrA?\\hBzNjAlJH~B?jAIrAOfAe@lBgArDiGfSgElN]fA}@rC{@hC]bAsBjH}@bDc@pAk@x@_@\\eAb@w@HeCNe@N?@CDMFE?c@Fo@`@w@t@WX[l@]z@Od@e@hCsBxKI`@KCkGkAwJcBoEu@yASsA?{A`@w@`@QTmA`BsAvC', NULL, '2021-12-19 09:52:58', '2021-12-19 09:54:12', 'NO', '0', 0.00000000, 0.00000000, 0.00000000),
(1688, 'KWD327444', 289, 135, 135, 1, 6129, 0, 'COMPLETED', 'NONE', NULL, 'CASH', 1, 11.53, 117.85, '', 'Unnamed Road, Lusaka, Zambia', -15.39810350, 28.38558400, 'International School of Lusaka, 6945 Nangwenya Rd, Lusaka, Zambia', -15.40491290, 28.31458280, '2021-12-19 11:28:26', NULL, '2021-12-19 11:28:57', '2021-12-19 11:29:08', 1, 1, 0, 0, '`m~|AiaglDiANe@eCgAoFkCh@s@D_CEsE?aA@}E?gM?kD?YAQIw@i@c@Kg@CwDTuIXiPf@{CdPEJWR[B[?aA@I@KHGHE^w@`CmEzMkGhRwF|PyAjEK\\W\\_@RUPBHfB`KbBtI~@bE~@~CtGpRLXJJf@f@HJN^B`@DbA|@xCr@jC|@jE|DtT|B|M|B`LpCjOxFn\\d@hCNf@T~AZzADt@Fl@NZDBJJDDXFbAX~@f@b@Nl@Fj@DNHH@h@BbBThF`AdF~@hDl@zKdBhRpCxDj@r@Lj@Np@VrAp@`B^rC`@nG~@jAJSrD[zCQpAEp@k@zEaApGO`@w@hHyB`Qm@pEI\\[bA_CvBbBlDlIxP~@nBn@bAn@v@|BvErDrHv@rC\\~AZpBBnAC|AAx@Q~HxAFb@FjAn@', NULL, '2021-12-19 11:28:26', '2021-12-19 11:29:35', 'NO', '0', 0.00000000, 0.00000000, 0.00000000);

-- --------------------------------------------------------

--
-- Table structure for table `user_request_payments`
--

CREATE TABLE `user_request_payments` (
  `id` int UNSIGNED NOT NULL,
  `request_id` int NOT NULL,
  `promocode_id` int DEFAULT NULL,
  `payment_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_mode` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `fixed` double(10,2) NOT NULL DEFAULT '0.00',
  `distance` double(10,2) NOT NULL DEFAULT '0.00',
  `t_price` double(10,2) DEFAULT '0.00',
  `commision` double(10,2) NOT NULL DEFAULT '0.00',
  `discount` double(10,2) NOT NULL DEFAULT '0.00',
  `tax` double(10,2) NOT NULL DEFAULT '0.00',
  `wallet` double(10,2) NOT NULL DEFAULT '0.00',
  `surge` double(10,2) NOT NULL DEFAULT '0.00',
  `total` double(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `payable` double(8,2) NOT NULL DEFAULT '0.00',
  `provider_commission` double(8,2) NOT NULL DEFAULT '0.00',
  `provider_commission_paid` enum('1','0') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `provider_pay` double(8,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_request_payments`
--

INSERT INTO `user_request_payments` (`id`, `request_id`, `promocode_id`, `payment_id`, `payment_mode`, `fixed`, `distance`, `t_price`, `commision`, `discount`, `tax`, `wallet`, `surge`, `total`, `created_at`, `updated_at`, `payable`, `provider_commission`, `provider_commission_paid`, `provider_pay`) VALUES
(543, 1330, NULL, NULL, NULL, 45.00, 118.72, 0.00, 11.87, 0.00, 0.00, 0.00, 0.00, 118.72, '2021-12-07 20:22:53', '2021-12-07 20:22:53', 118.72, 11.87, '0', 106.85),
(544, 1333, NULL, NULL, NULL, 45.00, 54.12, 0.00, 5.41, 0.00, 0.00, 0.00, 0.00, 54.12, '2021-12-07 20:54:45', '2021-12-07 20:54:45', 54.12, 5.41, '0', 48.70),
(545, 1334, NULL, NULL, NULL, 45.00, 129.84, 0.00, 12.98, 0.00, 0.00, 0.00, 0.00, 129.84, '2021-12-07 21:48:58', '2021-12-07 21:48:58', 129.84, 12.98, '0', 116.86),
(546, 1335, NULL, NULL, NULL, 45.00, 115.28, 0.00, 11.53, 0.00, 0.00, 0.00, 0.00, 115.28, '2021-12-07 22:23:45', '2021-12-07 22:23:45', 115.28, 11.53, '0', 103.75),
(547, 1336, NULL, NULL, NULL, 45.00, 54.01, 0.00, 5.40, 0.00, 0.00, 0.00, 0.00, 54.01, '2021-12-07 23:17:33', '2021-12-07 23:17:33', 54.01, 5.40, '0', 48.61),
(548, 1337, NULL, NULL, NULL, 45.00, 57.45, 0.00, 5.75, 0.00, 0.00, 0.00, 0.00, 57.45, '2021-12-08 06:42:19', '2021-12-08 06:42:19', 57.45, 5.75, '0', 51.71),
(549, 1340, NULL, NULL, NULL, 45.00, 115.38, 0.00, 11.54, 0.00, 0.00, 0.00, 0.00, 115.38, '2021-12-08 08:14:05', '2021-12-08 08:14:05', 115.38, 11.54, '0', 103.84),
(550, 1342, NULL, NULL, NULL, 45.00, 45.00, 0.00, 4.50, 0.00, 0.00, 0.00, 0.00, 45.00, '2021-12-08 09:49:21', '2021-12-08 09:49:21', 45.00, 4.50, '0', 40.50),
(551, 1343, NULL, NULL, NULL, 45.00, 45.00, 0.00, 4.50, 0.00, 0.00, 0.00, 0.00, 45.00, '2021-12-08 11:27:27', '2021-12-08 11:27:27', 45.00, 4.50, '0', 40.50),
(552, 1344, NULL, NULL, NULL, 45.00, 45.00, 0.00, 4.50, 0.00, 0.00, 0.00, 0.00, 45.00, '2021-12-08 12:40:36', '2021-12-08 12:40:36', 45.00, 4.50, '0', 40.50),
(553, 1345, NULL, NULL, NULL, 45.00, 100.52, 0.00, 10.05, 0.00, 0.00, 0.00, 0.00, 100.52, '2021-12-08 13:28:57', '2021-12-08 13:28:57', 100.52, 10.05, '0', 90.47),
(554, 1346, NULL, NULL, NULL, 45.00, 48.45, 0.00, 4.85, 0.00, 0.00, 0.00, 0.00, 48.45, '2021-12-08 14:09:00', '2021-12-08 14:09:00', 48.45, 4.85, '0', 43.61),
(555, 1349, NULL, NULL, NULL, 45.00, 127.92, 0.00, 12.79, 0.00, 0.00, 0.00, 0.00, 127.92, '2021-12-08 15:21:23', '2021-12-08 15:21:23', 127.92, 12.79, '0', 115.13),
(556, 1355, NULL, NULL, NULL, 47.25, 60.32, 0.00, 6.03, 0.00, 0.00, 0.00, 0.00, 60.32, '2021-12-09 01:08:27', '2021-12-09 01:08:27', 60.32, 6.03, '0', 54.29),
(557, 1361, NULL, NULL, NULL, 47.25, 129.96, 0.00, 13.00, 0.00, 0.00, 0.00, 0.00, 129.96, '2021-12-09 02:37:10', '2021-12-09 02:37:10', 129.96, 13.00, '0', 116.97),
(558, 1362, NULL, NULL, NULL, 47.25, 56.72, 0.00, 5.67, 0.00, 0.00, 0.00, 0.00, 56.72, '2021-12-09 03:02:07', '2021-12-09 03:02:07', 56.72, 5.67, '0', 51.04),
(559, 1363, NULL, NULL, NULL, 47.25, 56.82, 0.00, 5.68, 0.00, 0.00, 0.00, 0.00, 56.82, '2021-12-09 03:04:25', '2021-12-09 03:04:25', 56.82, 5.68, '0', 51.14),
(560, 1364, NULL, NULL, NULL, 45.00, 117.61, 0.00, 11.76, 0.00, 0.00, 0.00, 0.00, 117.61, '2021-12-09 08:11:20', '2021-12-09 08:11:20', 117.61, 11.76, '0', 105.85),
(561, 1366, NULL, NULL, NULL, 45.00, 57.55, 0.00, 5.76, 0.00, 0.00, 0.00, 0.00, 57.55, '2021-12-09 09:10:31', '2021-12-09 09:10:31', 57.55, 5.76, '0', 51.80),
(562, 1372, NULL, NULL, NULL, 45.00, 52.09, 0.00, 5.21, 0.00, 0.00, 0.00, 0.00, 52.09, '2021-12-09 17:30:21', '2021-12-09 17:30:21', 52.09, 5.21, '0', 46.88),
(563, 1376, NULL, NULL, NULL, 45.00, 118.82, 0.00, 11.88, 0.00, 0.00, 0.00, 0.00, 118.82, '2021-12-09 20:32:37', '2021-12-09 20:32:37', 118.82, 11.88, '0', 106.94),
(564, 1379, NULL, NULL, NULL, 45.00, 54.12, 0.00, 5.41, 0.00, 0.00, 0.00, 0.00, 54.12, '2021-12-09 23:37:00', '2021-12-09 23:37:00', 54.12, 5.41, '0', 48.70),
(565, 1381, NULL, NULL, NULL, 45.00, 108.71, 0.00, 10.87, 0.00, 0.00, 0.00, 0.00, 108.71, '2021-12-10 07:20:07', '2021-12-10 07:20:07', 108.71, 10.87, '0', 97.84),
(566, 1385, NULL, NULL, NULL, 45.00, 110.63, 0.00, 11.06, 0.00, 0.00, 0.00, 0.00, 110.63, '2021-12-10 16:52:32', '2021-12-10 16:52:32', 110.63, 11.06, '0', 99.57),
(567, 1390, NULL, NULL, NULL, 45.00, 45.00, 0.00, 4.50, 0.00, 0.00, 0.00, 0.00, 45.00, '2021-12-11 13:08:23', '2021-12-11 13:08:23', 45.00, 4.50, '0', 40.50),
(568, 1393, NULL, NULL, NULL, 45.00, 91.02, 0.00, 9.10, 0.00, 0.00, 0.00, 0.00, 91.02, '2021-12-11 15:39:27', '2021-12-11 15:39:27', 91.02, 9.10, '0', 81.92),
(569, 1397, NULL, NULL, NULL, 45.00, 57.55, 0.00, 5.76, 0.00, 0.00, 0.00, 0.00, 57.55, '2021-12-11 16:37:30', '2021-12-11 16:37:30', 57.55, 5.76, '0', 51.80),
(570, 1398, NULL, NULL, NULL, 45.00, 57.55, 0.00, 5.76, 0.00, 0.00, 0.00, 0.00, 57.55, '2021-12-11 16:55:55', '2021-12-11 16:55:55', 57.55, 5.76, '0', 51.80),
(571, 1402, NULL, NULL, NULL, 45.00, 132.77, 0.00, 13.28, 0.00, 0.00, 0.00, 0.00, 132.77, '2021-12-11 19:16:27', '2021-12-11 19:16:27', 132.77, 13.28, '0', 119.49),
(572, 1403, NULL, NULL, NULL, 45.00, 64.12, 0.00, 6.41, 0.00, 0.00, 0.00, 0.00, 64.12, '2021-12-11 19:25:16', '2021-12-11 19:25:16', 64.12, 6.41, '0', 57.71),
(573, 1421, NULL, NULL, NULL, 45.00, 54.22, 0.00, 5.42, 0.00, 0.00, 0.00, 0.00, 54.22, '2021-12-12 12:59:54', '2021-12-12 12:59:54', 54.22, 5.42, '0', 48.80),
(574, 1436, NULL, NULL, NULL, 45.00, 54.22, 0.00, 5.42, 0.00, 0.00, 0.00, 0.00, 54.22, '2021-12-12 16:09:44', '2021-12-12 16:09:44', 54.22, 5.42, '0', 48.80),
(575, 1437, NULL, NULL, NULL, 45.00, 222.95, 0.00, 22.30, 0.00, 0.00, 0.00, 0.00, 222.95, '2021-12-12 16:15:34', '2021-12-12 16:15:34', 222.95, 22.30, '0', 200.66),
(576, 1437, NULL, NULL, NULL, 45.00, 222.95, 0.00, 22.30, 0.00, 0.00, 0.00, 0.00, 222.95, '2021-12-12 16:15:38', '2021-12-12 16:15:38', 222.95, 22.30, '0', 200.66),
(577, 1466, NULL, NULL, NULL, 45.00, 4147.86, 0.00, 414.79, 0.00, 0.00, 0.00, 0.00, 4147.86, '2021-12-12 19:43:31', '2021-12-12 19:43:31', 4147.86, 414.79, '0', 3733.07),
(578, 1467, NULL, NULL, NULL, 45.00, 4147.86, 0.00, 414.79, 0.00, 0.00, 0.00, 0.00, 4147.86, '2021-12-12 19:47:47', '2021-12-12 19:47:47', 4147.86, 414.79, '0', 3733.07),
(579, 1473, NULL, NULL, NULL, 45.00, 115.28, 0.00, 11.53, 0.00, 0.00, 0.00, 0.00, 115.28, '2021-12-12 20:46:36', '2021-12-12 20:46:36', 115.28, 11.53, '0', 103.75),
(580, 1481, NULL, NULL, NULL, 45.00, 57.55, 0.00, 5.76, 0.00, 0.00, 0.00, 0.00, 57.55, '2021-12-12 22:29:55', '2021-12-12 22:29:55', 57.55, 5.76, '0', 51.80),
(581, 1486, NULL, NULL, NULL, 45.00, 202.43, 0.00, 20.24, 0.00, 0.00, 0.00, 0.00, 202.43, '2021-12-12 22:45:05', '2021-12-12 22:45:05', 202.43, 20.24, '0', 182.19),
(582, 1486, NULL, NULL, NULL, 45.00, 202.43, 0.00, 20.24, 0.00, 0.00, 0.00, 0.00, 202.43, '2021-12-12 22:45:19', '2021-12-12 22:45:19', 202.43, 20.24, '0', 182.19),
(583, 1487, NULL, NULL, NULL, 45.00, 54.12, 0.00, 5.41, 0.00, 0.00, 0.00, 0.00, 54.12, '2021-12-12 22:47:52', '2021-12-12 22:47:52', 54.12, 5.41, '0', 48.70),
(584, 1488, NULL, NULL, NULL, 45.00, 54.12, 0.00, 5.41, 0.00, 0.00, 0.00, 0.00, 54.12, '2021-12-12 22:51:01', '2021-12-12 22:51:01', 54.12, 5.41, '0', 48.70),
(585, 1489, NULL, NULL, NULL, 45.00, 104.77, 0.00, 10.48, 0.00, 0.00, 0.00, 0.00, 104.77, '2021-12-12 22:53:31', '2021-12-12 22:53:31', 104.77, 10.48, '0', 94.29),
(586, 1490, NULL, NULL, NULL, 45.00, 89.30, 0.00, 8.93, 0.00, 0.00, 0.00, 0.00, 89.30, '2021-12-12 22:55:02', '2021-12-12 22:55:02', 89.30, 8.93, '0', 80.37),
(587, 1491, NULL, NULL, NULL, 45.00, 68.98, 0.00, 6.90, 0.00, 0.00, 0.00, 0.00, 68.98, '2021-12-12 23:00:47', '2021-12-12 23:00:47', 68.98, 6.90, '0', 62.08),
(588, 1493, NULL, NULL, NULL, 45.00, 97.99, 0.00, 9.80, 0.00, 0.00, 0.00, 0.00, 97.99, '2021-12-12 23:16:02', '2021-12-12 23:16:02', 97.99, 9.80, '0', 88.19),
(589, 1493, NULL, NULL, NULL, 45.00, 97.99, 0.00, 9.80, 0.00, 0.00, 0.00, 0.00, 97.99, '2021-12-12 23:16:04', '2021-12-12 23:16:04', 97.99, 9.80, '0', 88.19),
(590, 1494, NULL, NULL, NULL, 45.00, 147.13, 0.00, 14.71, 0.00, 0.00, 0.00, 0.00, 147.13, '2021-12-12 23:25:37', '2021-12-12 23:25:37', 147.13, 14.71, '0', 132.41),
(591, 1495, NULL, NULL, NULL, 45.00, 99.31, 0.00, 9.93, 0.00, 0.00, 0.00, 0.00, 99.31, '2021-12-12 23:29:20', '2021-12-12 23:29:20', 99.31, 9.93, '0', 89.38),
(592, 1496, NULL, NULL, NULL, 45.00, 118.72, 0.00, 11.87, 0.00, 0.00, 0.00, 0.00, 118.72, '2021-12-12 23:33:47', '2021-12-12 23:33:47', 118.72, 11.87, '0', 106.85),
(593, 1497, NULL, NULL, NULL, 47.25, 56.93, 0.00, 5.69, 0.00, 0.00, 0.00, 0.00, 56.93, '2021-12-13 01:32:07', '2021-12-13 01:32:07', 56.93, 5.69, '0', 51.23),
(594, 1515, NULL, NULL, NULL, 45.00, 57.45, 0.00, 5.75, 0.00, 0.00, 0.00, 0.00, 57.45, '2021-12-13 17:02:12', '2021-12-13 17:02:12', 57.45, 5.75, '0', 51.71),
(595, 1517, NULL, NULL, NULL, 45.00, 67.56, 0.00, 6.76, 0.00, 0.00, 0.00, 0.00, 67.56, '2021-12-13 17:23:08', '2021-12-13 17:23:08', 67.56, 6.76, '0', 60.81),
(596, 1520, NULL, NULL, NULL, 45.00, 54.12, 0.00, 5.41, 0.00, 0.00, 0.00, 0.00, 54.12, '2021-12-13 20:22:26', '2021-12-13 20:22:26', 54.12, 5.41, '0', 48.70),
(597, 1523, NULL, NULL, NULL, 45.00, 144.60, 0.00, 14.46, 0.00, 0.00, 0.00, 0.00, 144.60, '2021-12-13 20:41:42', '2021-12-13 20:41:42', 144.60, 14.46, '0', 130.14),
(598, 1566, NULL, NULL, NULL, 65.00, 129.17, 0.00, 12.92, 0.00, 0.00, 0.00, 0.00, 129.17, '2021-12-14 08:35:21', '2021-12-14 08:35:21', 129.17, 12.92, '0', 116.25),
(599, 1570, NULL, NULL, NULL, 65.00, 129.17, 0.00, 12.92, 0.00, 0.00, 0.00, 0.00, 129.17, '2021-12-14 08:52:50', '2021-12-14 08:52:50', 129.17, 12.92, '0', 116.25),
(600, 1572, NULL, NULL, NULL, 45.00, 124.58, 0.00, 12.46, 0.00, 0.00, 0.00, 0.00, 124.58, '2021-12-14 09:06:33', '2021-12-14 09:06:33', 124.58, 12.46, '0', 112.12),
(601, 1574, NULL, NULL, NULL, 45.00, 53.41, 0.00, 5.34, 0.00, 0.00, 0.00, 0.00, 53.41, '2021-12-14 10:32:05', '2021-12-14 10:32:05', 53.41, 5.34, '0', 48.07),
(602, 1575, NULL, NULL, NULL, 45.00, 62.81, 0.00, 6.28, 0.00, 0.00, 0.00, 0.00, 62.81, '2021-12-14 11:02:54', '2021-12-14 11:02:54', 62.81, 6.28, '0', 56.53),
(603, 1576, NULL, NULL, NULL, 45.00, 114.67, 0.00, 11.47, 0.00, 0.00, 0.00, 0.00, 114.67, '2021-12-14 11:11:01', '2021-12-14 11:11:01', 114.67, 11.47, '0', 103.21),
(604, 1579, NULL, NULL, NULL, 45.00, 76.16, 0.00, 7.62, 0.00, 0.00, 0.00, 0.00, 76.16, '2021-12-14 11:25:56', '2021-12-14 11:25:56', 76.16, 7.62, '0', 68.54),
(605, 1580, NULL, NULL, NULL, 45.00, 65.34, 0.00, 6.53, 0.00, 0.00, 0.00, 0.00, 65.34, '2021-12-14 12:06:36', '2021-12-14 12:06:36', 65.34, 6.53, '0', 58.80),
(606, 1581, NULL, NULL, NULL, 45.00, 61.60, 0.00, 6.16, 0.00, 0.00, 0.00, 0.00, 61.60, '2021-12-14 13:01:32', '2021-12-14 13:01:32', 61.60, 6.16, '0', 55.44),
(607, 1583, NULL, NULL, NULL, 45.00, 124.38, 0.00, 12.44, 0.00, 0.00, 0.00, 0.00, 124.38, '2021-12-14 13:06:01', '2021-12-14 13:06:01', 124.38, 12.44, '0', 111.94),
(608, 1584, NULL, NULL, NULL, 45.00, 57.55, 0.00, 5.76, 0.00, 0.00, 0.00, 0.00, 57.55, '2021-12-14 18:10:09', '2021-12-14 18:10:09', 57.55, 5.76, '0', 51.80),
(609, 1585, NULL, NULL, NULL, 45.00, 147.33, 0.00, 14.73, 0.00, 0.00, 0.00, 0.00, 147.33, '2021-12-14 18:16:31', '2021-12-14 18:16:31', 147.33, 14.73, '0', 132.60),
(610, 1592, NULL, NULL, NULL, 45.00, 99.71, 0.00, 9.97, 0.00, 0.00, 0.00, 0.00, 99.71, '2021-12-14 19:27:53', '2021-12-14 19:27:53', 99.71, 9.97, '0', 89.74),
(611, 1587, NULL, NULL, NULL, 45.00, 147.33, 0.00, 14.73, 0.00, 0.00, 0.00, 0.00, 147.33, '2021-12-14 21:57:40', '2021-12-14 21:57:40', 147.33, 14.73, '0', 132.60),
(612, 1595, NULL, NULL, NULL, 45.00, 200.20, 0.00, 20.02, 0.00, 0.00, 0.00, 0.00, 200.20, '2021-12-14 23:05:20', '2021-12-14 23:05:20', 200.20, 20.02, '0', 180.18),
(613, 1596, NULL, NULL, NULL, 45.00, 118.72, 0.00, 11.87, 0.00, 0.00, 0.00, 0.00, 118.72, '2021-12-14 23:12:14', '2021-12-14 23:12:14', 118.72, 11.87, '0', 106.85),
(614, 1597, NULL, NULL, NULL, 45.00, 78.28, 0.00, 7.83, 0.00, 0.00, 0.00, 0.00, 78.28, '2021-12-15 06:30:40', '2021-12-15 06:30:40', 78.28, 7.83, '0', 70.45),
(615, 1598, NULL, NULL, NULL, 45.00, 63.62, 0.00, 6.36, 0.00, 0.00, 0.00, 0.00, 63.62, '2021-12-15 07:21:29', '2021-12-15 07:21:29', 63.62, 6.36, '0', 57.26),
(616, 1600, NULL, NULL, NULL, 45.00, 113.66, 0.00, 11.37, 0.00, 0.00, 0.00, 0.00, 113.66, '2021-12-15 11:06:58', '2021-12-15 11:06:58', 113.66, 11.37, '0', 102.30),
(617, 1601, NULL, NULL, NULL, 45.00, 45.00, 0.00, 4.50, 0.00, 0.00, 0.00, 0.00, 45.00, '2021-12-15 18:56:08', '2021-12-15 18:56:08', 45.00, 4.50, '0', 40.50),
(618, 1605, NULL, NULL, NULL, 47.25, 3483.08, 0.00, 348.31, 0.00, 0.00, 0.00, 0.00, 3483.08, '2021-12-16 00:25:53', '2021-12-16 00:25:53', 3483.08, 348.31, '0', 3134.77),
(619, 1606, NULL, NULL, NULL, 45.00, 124.58, 0.00, 12.46, 0.00, 0.00, 0.00, 0.00, 124.58, '2021-12-16 07:44:36', '2021-12-16 07:44:36', 124.58, 12.46, '0', 112.12),
(620, 1607, NULL, NULL, NULL, 45.00, 53.41, 0.00, 5.34, 0.00, 0.00, 0.00, 0.00, 53.41, '2021-12-16 10:01:42', '2021-12-16 10:01:42', 53.41, 5.34, '0', 48.07),
(621, 1610, NULL, NULL, NULL, 45.00, 110.73, 0.00, 11.07, 0.00, 0.00, 0.00, 0.00, 110.73, '2021-12-17 12:20:47', '2021-12-17 12:20:47', 110.73, 11.07, '0', 99.66),
(622, 1611, NULL, NULL, NULL, 45.00, 63.62, 0.00, 6.36, 0.00, 0.00, 0.00, 0.00, 63.62, '2021-12-17 14:26:21', '2021-12-17 14:26:21', 63.62, 6.36, '0', 57.26),
(623, 1613, NULL, NULL, NULL, 45.00, 4147.76, 0.00, 414.78, 0.00, 0.00, 0.00, 0.00, 4147.76, '2021-12-17 16:40:48', '2021-12-17 16:40:48', 4147.76, 414.78, '0', 3732.98),
(624, 1622, NULL, NULL, NULL, 45.00, 63.62, 0.00, 6.36, 0.00, 0.00, 0.00, 0.00, 63.62, '2021-12-17 20:30:52', '2021-12-17 20:30:52', 63.62, 6.36, '0', 57.26),
(625, 1628, NULL, NULL, NULL, 45.00, 115.28, 0.00, 11.53, 0.00, 0.00, 0.00, 0.00, 115.28, '2021-12-17 21:29:16', '2021-12-17 21:29:16', 115.28, 11.53, '0', 103.75),
(626, 1629, NULL, NULL, NULL, 45.00, 61.60, 0.00, 6.16, 0.00, 0.00, 0.00, 0.00, 61.60, '2021-12-17 21:33:22', '2021-12-17 21:33:22', 61.60, 6.16, '0', 55.44),
(627, 1634, NULL, NULL, NULL, 45.00, 118.72, 0.00, 11.87, 0.00, 0.00, 0.00, 0.00, 118.72, '2021-12-18 07:21:34', '2021-12-18 07:21:34', 118.72, 11.87, '0', 106.85),
(628, 1635, NULL, NULL, NULL, 45.00, 118.72, 0.00, 11.87, 0.00, 0.00, 0.00, 0.00, 118.72, '2021-12-18 07:45:59', '2021-12-18 07:45:59', 118.72, 11.87, '0', 106.85),
(629, 1644, NULL, NULL, NULL, 45.00, 118.72, 0.00, 11.87, 0.00, 0.00, 0.00, 0.00, 118.72, '2021-12-18 10:19:37', '2021-12-18 10:19:37', 118.72, 11.87, '0', 106.85),
(630, 1646, NULL, NULL, NULL, 45.00, 118.72, 0.00, 11.87, 0.00, 0.00, 0.00, 0.00, 118.72, '2021-12-18 10:37:11', '2021-12-18 10:37:11', 118.72, 11.87, '0', 106.85),
(631, 1647, NULL, NULL, NULL, 45.00, 67.46, 0.00, 6.75, 0.00, 0.00, 0.00, 0.00, 67.46, '2021-12-18 10:39:45', '2021-12-18 10:39:45', 67.46, 6.75, '0', 60.71),
(632, 1648, NULL, NULL, NULL, 45.00, 45.00, 0.00, 4.50, 0.00, 0.00, 0.00, 0.00, 45.00, '2021-12-18 10:42:54', '2021-12-18 10:42:54', 45.00, 4.50, '0', 40.50),
(633, 1652, NULL, NULL, NULL, 45.00, 63.42, 0.00, 6.34, 0.00, 0.00, 0.00, 0.00, 63.42, '2021-12-18 12:37:22', '2021-12-18 12:37:22', 63.42, 6.34, '0', 57.08),
(634, 1659, NULL, NULL, NULL, 45.00, 89.30, 0.00, 8.93, 0.00, 0.00, 0.00, 0.00, 89.30, '2021-12-18 13:02:07', '2021-12-18 13:02:07', 89.30, 8.93, '0', 80.37),
(635, 1663, NULL, NULL, NULL, 45.00, 45.00, 0.00, 4.50, 0.00, 0.00, 0.00, 0.00, 45.00, '2021-12-18 15:24:05', '2021-12-18 15:24:05', 45.00, 4.50, '0', 40.50),
(636, 1664, NULL, NULL, NULL, 45.00, 54.12, 0.00, 5.41, 0.00, 0.00, 0.00, 0.00, 54.12, '2021-12-18 18:28:13', '2021-12-18 18:28:13', 54.12, 5.41, '0', 48.70),
(637, 1666, NULL, NULL, NULL, 45.00, 148.14, 0.00, 14.81, 0.00, 0.00, 0.00, 0.00, 148.14, '2021-12-18 23:13:38', '2021-12-18 23:13:38', 148.14, 14.81, '0', 133.32),
(638, 1667, NULL, NULL, NULL, 45.00, 118.72, 0.00, 11.87, 0.00, 0.00, 0.00, 0.00, 118.72, '2021-12-18 23:25:49', '2021-12-18 23:25:49', 118.72, 11.87, '0', 106.85),
(639, 1668, NULL, NULL, NULL, 47.25, 107.07, 0.00, 10.71, 0.00, 0.00, 0.00, 0.00, 107.07, '2021-12-19 02:11:01', '2021-12-19 02:11:01', 107.07, 10.71, '0', 96.36),
(640, 1669, NULL, NULL, NULL, 47.25, 47.25, 0.00, 4.72, 0.00, 0.00, 0.00, 0.00, 47.25, '2021-12-19 02:15:09', '2021-12-19 02:15:09', 47.25, 4.72, '0', 42.52),
(641, 1670, NULL, NULL, NULL, 47.25, 123.59, 0.00, 12.36, 0.00, 0.00, 0.00, 0.00, 123.59, '2021-12-19 02:17:47', '2021-12-19 02:17:47', 123.59, 12.36, '0', 111.23),
(642, 1671, NULL, NULL, NULL, 47.25, 59.00, 0.00, 5.90, 0.00, 0.00, 0.00, 0.00, 59.00, '2021-12-19 02:19:50', '2021-12-19 02:19:50', 59.00, 5.90, '0', 53.10),
(643, 1672, NULL, NULL, NULL, 47.25, 132.54, 0.00, 13.25, 0.00, 0.00, 0.00, 0.00, 132.54, '2021-12-19 02:23:59', '2021-12-19 02:23:59', 132.54, 13.25, '0', 119.29),
(644, 1673, NULL, NULL, NULL, 47.25, 82.34, 0.00, 8.23, 0.00, 0.00, 0.00, 0.00, 82.34, '2021-12-19 02:35:20', '2021-12-19 02:35:20', 82.34, 8.23, '0', 74.11),
(645, 1674, NULL, NULL, NULL, 47.25, 123.59, 0.00, 12.36, 0.00, 0.00, 0.00, 0.00, 123.59, '2021-12-19 02:36:45', '2021-12-19 02:36:45', 123.59, 12.36, '0', 111.23),
(646, 1676, NULL, NULL, NULL, 47.25, 123.59, 0.00, 12.36, 0.00, 0.00, 0.00, 0.00, 123.59, '2021-12-19 02:45:07', '2021-12-19 02:45:07', 123.59, 12.36, '0', 111.23),
(647, 1678, NULL, NULL, NULL, 47.25, 58.90, 0.00, 5.89, 0.00, 0.00, 0.00, 0.00, 58.90, '2021-12-19 02:57:12', '2021-12-19 02:57:12', 58.90, 5.89, '0', 53.01),
(648, 1679, NULL, NULL, NULL, 47.25, 62.52, 0.00, 6.25, 0.00, 0.00, 0.00, 0.00, 62.52, '2021-12-19 03:09:35', '2021-12-19 03:09:35', 62.52, 6.25, '0', 56.27),
(649, 1680, NULL, NULL, NULL, 47.25, 47.25, 0.00, 4.72, 0.00, 0.00, 0.00, 0.00, 47.25, '2021-12-19 03:12:06', '2021-12-19 03:12:06', 47.25, 4.72, '0', 42.52),
(650, 1681, NULL, NULL, NULL, 47.25, 190.73, 0.00, 19.07, 0.00, 0.00, 0.00, 0.00, 190.73, '2021-12-19 03:39:48', '2021-12-19 03:39:48', 190.73, 19.07, '0', 171.66),
(651, 1682, NULL, NULL, NULL, 47.25, 215.14, 0.00, 21.51, 0.00, 0.00, 0.00, 0.00, 215.14, '2021-12-19 03:41:41', '2021-12-19 03:41:41', 215.14, 21.51, '0', 193.62),
(652, 1683, NULL, NULL, NULL, 47.25, 248.39, 0.00, 24.84, 0.00, 0.00, 0.00, 0.00, 248.39, '2021-12-19 03:47:37', '2021-12-19 03:47:37', 248.39, 24.84, '0', 223.55),
(653, 1685, NULL, NULL, NULL, 45.00, 185.00, 0.00, 18.50, 0.00, 0.00, 0.00, 0.00, 185.00, '2021-12-19 07:59:30', '2021-12-19 07:59:30', 185.00, 18.50, '0', 166.50),
(654, 1686, NULL, NULL, NULL, 45.00, 96.08, 0.00, 9.61, 0.00, 0.00, 0.00, 0.00, 96.08, '2021-12-19 09:00:35', '2021-12-19 09:00:35', 96.08, 9.61, '0', 86.48),
(655, 1687, NULL, NULL, NULL, 45.00, 103.59, 0.00, 10.36, 0.00, 0.00, 0.00, 0.00, 103.59, '2021-12-19 09:53:49', '2021-12-19 09:53:49', 103.59, 10.36, '0', 93.24),
(656, 1688, NULL, NULL, NULL, 45.00, 117.80, 0.00, 11.78, 0.00, 0.00, 0.00, 0.00, 117.80, '2021-12-19 11:29:08', '2021-12-19 11:29:08', 117.80, 11.78, '0', 106.02);

-- --------------------------------------------------------

--
-- Table structure for table `user_request_ratings`
--

CREATE TABLE `user_request_ratings` (
  `id` int UNSIGNED NOT NULL,
  `request_id` int NOT NULL,
  `user_id` int NOT NULL,
  `provider_id` int NOT NULL,
  `user_rating` int NOT NULL DEFAULT '0',
  `provider_rating` int NOT NULL DEFAULT '0',
  `user_comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `provider_comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_request_ratings`
--

INSERT INTO `user_request_ratings` (`id`, `request_id`, `user_id`, `provider_id`, `user_rating`, `provider_rating`, `user_comment`, `provider_comment`, `created_at`, `updated_at`) VALUES
(526, 1330, 168, 123, 5, 5, '', '', '2021-12-07 20:31:26', '2021-12-07 20:31:35'),
(527, 1333, 168, 123, 5, 5, '', 'Good ', '2021-12-07 20:56:11', '2021-12-07 21:05:22'),
(528, 1334, 168, 123, 5, 5, '', '', '2021-12-07 21:51:49', '2021-12-07 21:52:01'),
(529, 1335, 266, 123, 5, 5, '', 'Hi is good ', '2021-12-07 22:24:30', '2021-12-07 23:00:44'),
(530, 1336, 168, 123, 5, 5, '', '', '2021-12-07 23:17:48', '2021-12-07 23:17:56'),
(531, 1337, 168, 123, 5, 5, '', '', '2021-12-08 06:42:27', '2021-12-08 06:42:41'),
(532, 1340, 168, 102, 5, 5, '', '', '2021-12-08 08:15:35', '2021-12-08 08:31:37'),
(533, 1342, 168, 123, 5, 5, '', '', '2021-12-08 09:49:31', '2021-12-08 09:49:37'),
(534, 1343, 168, 101, 5, 5, 'Thank you ', 'good', '2021-12-08 11:27:42', '2021-12-08 11:27:45'),
(535, 1344, 168, 101, 5, 5, '', 'Good ', '2021-12-08 12:41:03', '2021-12-08 12:42:34'),
(536, 1345, 168, 101, 5, 4, 'Good driver ', 'Good ', '2021-12-08 13:30:25', '2021-12-08 13:30:37'),
(537, 1346, 168, 101, 5, 5, '', '', '2021-12-08 14:10:52', '2021-12-08 14:51:07'),
(538, 1349, 168, 101, 5, 5, '', 'good client', '2021-12-08 15:22:15', '2021-12-08 15:22:25'),
(539, 1355, 168, 123, 5, 5, '', '', '2021-12-09 01:14:02', '2021-12-09 01:30:54'),
(540, 1361, 273, 123, 5, 5, '', '', '2021-12-09 02:37:25', '2021-12-09 02:37:29'),
(541, 1362, 273, 123, 5, 5, '', '', '2021-12-09 03:02:41', '2021-12-09 03:02:49'),
(542, 1363, 168, 102, 5, 5, '', '', '2021-12-09 03:04:32', '2021-12-09 13:20:48'),
(543, 1364, 273, 123, 5, 5, '', '', '2021-12-09 08:11:41', '2021-12-09 08:11:48'),
(544, 1366, 273, 123, 5, 5, '', '', '2021-12-09 09:12:37', '2021-12-09 11:48:48'),
(545, 1372, 168, 102, 5, 5, '', '', '2021-12-09 17:33:58', '2021-12-09 17:34:35'),
(546, 1376, 168, 102, 5, 5, '', '', '2021-12-09 20:33:48', '2021-12-09 20:33:58'),
(547, 1379, 168, 102, 5, 5, '', 'good client', '2021-12-09 23:37:35', '2021-12-09 23:37:48'),
(548, 1381, 273, 102, 5, 5, '', '', '2021-12-10 07:20:33', '2021-12-10 07:20:38'),
(549, 1385, 168, 102, 5, 5, '', '', '2021-12-10 16:57:45', '2021-12-10 16:58:02'),
(550, 1390, 170, 123, 5, 5, 'good driver', '', '2021-12-11 13:08:41', '2021-12-11 13:08:51'),
(551, 1393, 168, 123, 5, 5, 'good', 'Nice', '2021-12-11 15:39:40', '2021-12-11 15:39:43'),
(552, 1397, 273, 123, 5, 5, '', '', '2021-12-11 16:39:06', '2021-12-11 16:39:19'),
(553, 1398, 168, 102, 5, 5, '', '', '2021-12-11 16:56:08', '2021-12-11 16:56:14'),
(554, 1402, 168, 123, 5, 5, '', '', '2021-12-11 19:16:36', '2021-12-11 19:16:39'),
(555, 1403, 168, 102, 5, 5, '', '', '2021-12-11 19:27:56', '2021-12-11 19:28:23'),
(556, 1421, 287, 130, 5, 5, '', '', '2021-12-12 13:01:45', '2021-12-12 13:01:49'),
(557, 1436, 289, 123, 5, 5, '', '', '2021-12-12 16:11:01', '2021-12-12 16:11:42'),
(558, 1437, 289, 123, 5, 5, '', '', '2021-12-12 16:16:01', '2021-12-12 16:16:14'),
(559, 1466, 290, 130, 5, 5, 'ok', 'Goo', '2021-12-12 19:46:26', '2021-12-12 19:46:43'),
(560, 1467, 290, 130, 5, 5, 'vvb', ' C', '2021-12-12 19:48:02', '2021-12-12 19:48:04'),
(561, 1473, 289, 123, 5, 5, '', '', '2021-12-12 20:46:54', '2021-12-12 20:47:03'),
(562, 1481, 289, 135, 5, 5, '', '', '2021-12-12 22:30:22', '2021-12-12 22:30:34'),
(563, 1486, 291, 123, 5, 5, '', '', '2021-12-12 22:45:37', '2021-12-12 22:45:37'),
(564, 1487, 291, 134, 5, 5, '', '', '2021-12-12 22:48:47', '2021-12-12 22:48:57'),
(565, 1488, 291, 134, 5, 5, '', '', '2021-12-12 22:51:25', '2021-12-12 22:51:32'),
(566, 1489, 291, 134, 5, 5, '', '', '2021-12-12 22:53:46', '2021-12-12 22:53:47'),
(567, 1490, 291, 134, 5, 5, '', '', '2021-12-12 22:55:17', '2021-12-12 22:55:19'),
(568, 1491, 291, 134, 5, 5, '', '', '2021-12-12 23:01:21', '2021-12-12 23:01:22'),
(569, 1493, 291, 135, 5, 5, '', '', '2021-12-12 23:16:33', '2021-12-12 23:16:56'),
(570, 1494, 289, 135, 5, 5, '', '', '2021-12-12 23:25:57', '2021-12-12 23:26:00'),
(571, 1495, 289, 123, 5, 5, '', '', '2021-12-12 23:29:31', '2021-12-12 23:29:42'),
(572, 1496, 291, 123, 5, 5, '', '', '2021-12-12 23:34:04', '2021-12-12 23:34:10'),
(573, 1497, 289, 123, 5, 5, '', '', '2021-12-13 01:32:39', '2021-12-13 01:32:49'),
(574, 1515, 289, 123, 5, 5, '', '', '2021-12-13 17:02:25', '2021-12-13 17:02:31'),
(575, 1517, 289, 123, 5, 5, '', '', '2021-12-13 20:12:31', '2021-12-13 20:12:39'),
(576, 1520, 291, 134, 5, 5, '', '', '2021-12-13 20:23:07', '2021-12-13 20:28:58'),
(577, 1523, 289, 123, 5, 5, '', '', '2021-12-13 20:44:28', '2021-12-13 20:44:53'),
(578, 1566, 289, 135, 5, 5, '', '', '2021-12-14 08:35:41', '2021-12-14 08:35:45'),
(579, 1570, 291, 123, 5, 5, '', '', '2021-12-14 08:54:00', '2021-12-14 08:59:11'),
(580, 1572, 291, 123, 5, 5, '', '', '2021-12-14 09:13:41', '2021-12-14 12:31:36'),
(581, 1574, 289, 134, 5, 5, '', '', '2021-12-14 10:32:20', '2021-12-14 10:32:20'),
(582, 1575, 289, 123, 5, 5, '', '', '2021-12-14 11:03:19', '2021-12-14 11:03:21'),
(583, 1576, 289, 134, 5, 5, '', '', '2021-12-14 11:11:21', '2021-12-14 11:12:51'),
(584, 1579, 170, 123, 5, 5, '', 'great client', '2021-12-14 11:27:35', '2021-12-14 12:03:28'),
(585, 1580, 170, 135, 5, 5, '', 'Great ride', '2021-12-14 12:09:15', '2021-12-14 12:09:52'),
(586, 1581, 289, 135, 5, 5, '', '', '2021-12-14 13:01:46', '2021-12-14 13:01:50'),
(587, 1583, 289, 134, 5, 5, '', '', '2021-12-14 15:43:15', '2021-12-14 15:51:04'),
(588, 1584, 289, 135, 5, 5, '', '', '2021-12-14 18:14:32', '2021-12-14 18:14:56'),
(589, 1585, 289, 123, 5, 5, '', '', '2021-12-14 18:17:01', '2021-12-14 18:17:03'),
(590, 1592, 291, 123, 5, 5, '', '', '2021-12-14 19:28:33', '2021-12-14 19:28:46'),
(591, 1587, 289, 135, 5, 5, '', '', '2021-12-14 21:58:05', '2021-12-14 21:58:21'),
(592, 1595, 289, 135, 5, 5, '', '', '2021-12-14 23:05:37', '2021-12-14 23:05:45'),
(593, 1596, 289, 135, 5, 5, '', '', '2021-12-14 23:13:38', '2021-12-14 23:13:48'),
(594, 1597, 291, 123, 5, 5, 'great ride ', 'good client', '2021-12-15 06:31:51', '2021-12-15 06:32:16'),
(595, 1598, 289, 135, 5, 5, '', '', '2021-12-15 07:21:52', '2021-12-15 07:21:57'),
(596, 1600, 289, 135, 5, 5, 'Greats ', 'Great ', '2021-12-15 11:07:38', '2021-12-15 11:07:49'),
(597, 1601, 289, 135, 5, 5, '', '', '2021-12-15 18:56:44', '2021-12-15 18:56:50'),
(598, 1605, 291, 123, 5, 5, '', '', '2021-12-16 07:42:53', '2021-12-16 07:43:00'),
(599, 1606, 291, 135, 5, 5, '', '', '2021-12-16 07:45:11', '2021-12-16 07:49:50'),
(600, 1607, 289, 134, 5, 5, '', '', '2021-12-16 10:05:44', '2021-12-16 11:28:40'),
(601, 1610, 289, 123, 5, 5, '', '', '2021-12-17 12:22:10', '2021-12-17 12:22:15'),
(602, 1611, 289, 123, 5, 5, '', '', '2021-12-17 14:26:50', '2021-12-17 14:26:52'),
(603, 1613, 290, 135, 5, 5, 'awesome Ride', 'Good', '2021-12-17 16:53:31', '2021-12-17 16:54:01'),
(604, 1622, 290, 130, 5, 5, 'good', 'Gkkd', '2021-12-17 20:31:17', '2021-12-17 20:31:23'),
(605, 1629, 290, 130, 5, 5, 'Good Driver', 'Good customer', '2021-12-17 21:34:36', '2021-12-17 21:34:42'),
(606, 1628, 289, 134, 5, 5, '', '', '2021-12-17 21:34:54', '2021-12-17 21:35:32'),
(607, 1634, 289, 135, 5, 5, '', '', '2021-12-18 07:21:53', '2021-12-18 07:22:00'),
(608, 1635, 291, 135, 5, 5, '', '', '2021-12-18 07:46:32', '2021-12-18 07:46:45'),
(609, 1644, 289, 135, 5, 5, '', '', '2021-12-18 10:19:51', '2021-12-18 10:19:57'),
(610, 1646, 289, 135, 5, 5, '', '', '2021-12-18 10:37:28', '2021-12-18 10:37:34'),
(611, 1647, 289, 135, 5, 5, '', '', '2021-12-18 10:40:00', '2021-12-18 10:40:06'),
(612, 1648, 289, 123, 5, 5, '', '', '2021-12-18 10:43:13', '2021-12-18 10:43:18'),
(613, 1652, 290, 130, 5, 5, 'Good Driver', 'Good Customer', '2021-12-18 12:38:13', '2021-12-18 12:38:19'),
(614, 1659, 291, 135, 5, 5, '', '', '2021-12-18 13:02:40', '2021-12-18 13:02:41'),
(615, 1663, 289, 135, 5, 5, '', '', '2021-12-18 15:24:48', '2021-12-18 15:24:59'),
(616, 1664, 289, 135, 5, 5, '', '', '2021-12-18 18:28:35', '2021-12-18 18:28:43'),
(617, 1666, 170, 135, 0, 5, NULL, '', '2021-12-18 23:20:04', '2021-12-18 23:20:04'),
(618, 1667, 289, 134, 5, 5, '', '', '2021-12-18 23:26:07', '2021-12-18 23:26:33'),
(619, 1668, 289, 135, 5, 5, '', '', '2021-12-19 02:11:35', '2021-12-19 02:11:43'),
(620, 1669, 289, 135, 5, 5, '', '', '2021-12-19 02:15:47', '2021-12-19 02:16:33'),
(621, 1670, 289, 123, 5, 5, 'Thank you for the feedback ', 'thanks good dtiver', '2021-12-19 02:18:23', '2021-12-19 02:18:33'),
(622, 1671, 289, 123, 5, 5, '', '', '2021-12-19 02:20:09', '2021-12-19 02:20:11'),
(623, 1672, 289, 123, 5, 5, '', '', '2021-12-19 02:24:39', '2021-12-19 02:24:42'),
(624, 1673, 289, 123, 5, 5, '', '', '2021-12-19 02:35:31', '2021-12-19 02:35:35'),
(625, 1674, 289, 123, 5, 5, '', '', '2021-12-19 02:36:58', '2021-12-19 02:37:03'),
(626, 1676, 289, 123, 5, 5, '', '', '2021-12-19 02:47:04', '2021-12-19 02:47:21'),
(627, 1678, 289, 123, 5, 5, '', '', '2021-12-19 02:57:27', '2021-12-19 02:57:29'),
(628, 1679, 289, 135, 5, 5, '', '', '2021-12-19 03:09:57', '2021-12-19 03:10:04'),
(629, 1680, 289, 123, 5, 5, '', '', '2021-12-19 03:12:37', '2021-12-19 03:12:41'),
(630, 1681, 289, 135, 5, 5, '', '', '2021-12-19 03:40:04', '2021-12-19 03:40:13'),
(631, 1682, 289, 123, 5, 5, '', '', '2021-12-19 03:43:08', '2021-12-19 03:46:16'),
(632, 1683, 289, 135, 5, 5, '', '', '2021-12-19 03:48:04', '2021-12-19 03:48:11'),
(633, 1685, 289, 135, 5, 5, '', '', '2021-12-19 07:59:44', '2021-12-19 07:59:51'),
(634, 1686, 289, 123, 5, 5, '', '', '2021-12-19 09:02:13', '2021-12-19 09:02:23'),
(635, 1687, 289, 135, 5, 5, '', '', '2021-12-19 09:54:01', '2021-12-19 09:54:12'),
(636, 1688, 289, 135, 5, 5, '', '', '2021-12-19 11:29:27', '2021-12-19 11:29:35');

-- --------------------------------------------------------

--
-- Table structure for table `wallet_passbooks`
--

CREATE TABLE `wallet_passbooks` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `amount` int NOT NULL,
  `status` enum('CREDITED','DEBITED') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `via` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `wallet_passbooks`
--

INSERT INTO `wallet_passbooks` (`id`, `user_id`, `amount`, `status`, `via`, `created_at`, `updated_at`) VALUES
(1, 101, 10, 'CREDITED', 'CARD', '2020-11-27 04:22:38', '2020-11-27 04:22:38'),
(2, 131, 200, 'CREDITED', 'CARD', '2020-12-14 07:53:10', '2020-12-14 07:53:10'),
(3, 131, 74, 'DEBITED', 'TRIP', '2020-12-14 08:06:34', '2020-12-14 08:06:34'),
(4, 131, 65, 'DEBITED', 'TRIP', '2021-02-15 03:41:19', '2021-02-15 03:41:19'),
(5, 131, 61, 'DEBITED', 'TRIP', '2021-03-06 03:55:32', '2021-03-06 03:55:32'),
(6, 131, 5, 'CREDITED', 'CARD', '2021-04-16 19:11:47', '2021-04-16 19:11:47'),
(7, 131, 10, 'CREDITED', 'CARD', '2021-04-17 20:29:31', '2021-04-17 20:29:31'),
(8, 131, 10, 'CREDITED', 'CARD', '2021-04-21 23:35:48', '2021-04-21 23:35:48'),
(9, 162, 5, 'CREDITED', 'CARD', '2021-05-03 02:55:49', '2021-05-03 02:55:49'),
(10, 131, 5, 'CREDITED', 'CARD', '2021-05-24 03:09:24', '2021-05-24 03:09:24'),
(11, 168, 5, 'CREDITED', 'CARD', '2021-10-17 22:50:55', '2021-10-17 22:50:55'),
(12, 207, 10, 'CREDITED', 'CARD', '2021-10-18 01:48:33', '2021-10-18 01:48:33'),
(13, 168, 2, 'CREDITED', 'CARD', '2021-10-20 16:40:43', '2021-10-20 16:40:43'),
(14, 168, 10, 'CREDITED', 'CARD', '2021-10-31 17:59:57', '2021-10-31 17:59:57'),
(15, 168, 20, 'CREDITED', 'CARD', '2021-11-10 00:56:53', '2021-11-10 00:56:53'),
(16, 234, 5, 'CREDITED', 'CARD', '2021-11-16 01:01:43', '2021-11-16 01:01:43'),
(17, 234, 5, 'CREDITED', 'CARD', '2021-11-17 05:28:10', '2021-11-17 05:28:10'),
(18, 234, 5, 'CREDITED', 'CARD', '2021-11-17 05:31:22', '2021-11-17 05:31:22'),
(19, 168, 5, 'CREDITED', 'CARD', '2021-12-02 04:23:00', '2021-12-02 04:23:00'),
(20, 168, 10, 'CREDITED', 'CARD', '2021-12-03 06:33:37', '2021-12-03 06:33:37'),
(21, 168, 47, 'DEBITED', 'TRIP', '2021-12-03 06:36:23', '2021-12-03 06:36:23'),
(22, 168, 10, 'CREDITED', 'CARD', '2021-12-06 05:43:02', '2021-12-06 05:43:02'),
(23, 273, 10, 'CREDITED', 'CARD', '2021-12-11 13:54:19', '2021-12-11 13:54:19'),
(24, 168, 10, 'CREDITED', 'CARD', '2021-12-11 15:11:54', '2021-12-11 15:11:54'),
(25, 291, 5, 'CREDITED', 'CARD', '2021-12-16 18:20:03', '2021-12-16 18:20:03');

-- --------------------------------------------------------

--
-- Table structure for table `withdrawal_moneys`
--

CREATE TABLE `withdrawal_moneys` (
  `id` int NOT NULL,
  `bank_account_id` int DEFAULT NULL,
  `provider_id` int DEFAULT NULL,
  `amount` varchar(50) DEFAULT NULL,
  `status` enum('WAITING','APPROVED','DISAPPROVED') DEFAULT 'WAITING',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `zones`
--

CREATE TABLE `zones` (
  `id` int NOT NULL,
  `name` varchar(500) DEFAULT NULL,
  `coordinate` varchar(500) DEFAULT NULL,
  `background` varchar(500) DEFAULT NULL,
  `draw_lines` varchar(500) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `accounts_email_unique` (`email`);

--
-- Indexes for table `account_password_resets`
--
ALTER TABLE `account_password_resets`
  ADD KEY `account_password_resets_email_index` (`email`),
  ADD KEY `account_password_resets_token_index` (`token`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `provider_id` (`provider_id`);

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_pushes`
--
ALTER TABLE `custom_pushes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dispatchers`
--
ALTER TABLE `dispatchers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dispatchers_email_unique` (`email`);

--
-- Indexes for table `dispatcher_password_resets`
--
ALTER TABLE `dispatcher_password_resets`
  ADD KEY `dispatcher_password_resets_email_index` (`email`),
  ADD KEY `dispatcher_password_resets_token_index` (`token`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favourite_locations`
--
ALTER TABLE `favourite_locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fleets`
--
ALTER TABLE `fleets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fleets_email_unique` (`email`);

--
-- Indexes for table `fleet_password_resets`
--
ALTER TABLE `fleet_password_resets`
  ADD KEY `fleet_password_resets_email_index` (`email`),
  ADD KEY `fleet_password_resets_token_index` (`token`);

--
-- Indexes for table `frontend`
--
ALTER TABLE `frontend`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `keycode` (`keycode`);

--
-- Indexes for table `ltm_translations`
--
ALTER TABLE `ltm_translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`),
  ADD KEY `oauth_access_tokens_client_id_index` (`client_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_personal_access_clients_client_id_index` (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package_services`
--
ALTER TABLE `package_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `payment_histories`
--
ALTER TABLE `payment_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_histories_payment_service_id_foreign` (`payment_service_id`),
  ADD KEY `payment_histories_provider_id_foreign` (`provider_id`),
  ADD KEY `payment_histories_user_id_foreign` (`user_id`);

--
-- Indexes for table `payment_services`
--
ALTER TABLE `payment_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promocodes`
--
ALTER TABLE `promocodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promocode_passbooks`
--
ALTER TABLE `promocode_passbooks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promocode_usages`
--
ALTER TABLE `promocode_usages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `providers`
--
ALTER TABLE `providers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `providers_email_unique` (`email`);

--
-- Indexes for table `provider_devices`
--
ALTER TABLE `provider_devices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `provider_documents`
--
ALTER TABLE `provider_documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `provider_profiles`
--
ALTER TABLE `provider_profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `provider_services`
--
ALTER TABLE `provider_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request_filters`
--
ALTER TABLE `request_filters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_types`
--
ALTER TABLE `service_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `settings_key_index` (`key`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `taximeter_user_requests`
--
ALTER TABLE `taximeter_user_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_requests`
--
ALTER TABLE `user_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_request_payments`
--
ALTER TABLE `user_request_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_request_ratings`
--
ALTER TABLE `user_request_ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wallet_passbooks`
--
ALTER TABLE `wallet_passbooks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawal_moneys`
--
ALTER TABLE `withdrawal_moneys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zones`
--
ALTER TABLE `zones`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=427;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `custom_pushes`
--
ALTER TABLE `custom_pushes`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dispatchers`
--
ALTER TABLE `dispatchers`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `favourite_locations`
--
ALTER TABLE `favourite_locations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;

--
-- AUTO_INCREMENT for table `fleets`
--
ALTER TABLE `fleets`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `frontend`
--
ALTER TABLE `frontend`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ltm_translations`
--
ALTER TABLE `ltm_translations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1548;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `package_services`
--
ALTER TABLE `package_services`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_histories`
--
ALTER TABLE `payment_histories`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payment_services`
--
ALTER TABLE `payment_services`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `promocodes`
--
ALTER TABLE `promocodes`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `promocode_passbooks`
--
ALTER TABLE `promocode_passbooks`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `promocode_usages`
--
ALTER TABLE `promocode_usages`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `providers`
--
ALTER TABLE `providers`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT for table `provider_devices`
--
ALTER TABLE `provider_devices`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `provider_documents`
--
ALTER TABLE `provider_documents`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=393;

--
-- AUTO_INCREMENT for table `provider_profiles`
--
ALTER TABLE `provider_profiles`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `provider_services`
--
ALTER TABLE `provider_services`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;

--
-- AUTO_INCREMENT for table `request_filters`
--
ALTER TABLE `request_filters`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4866;

--
-- AUTO_INCREMENT for table `service_types`
--
ALTER TABLE `service_types`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `taximeter_user_requests`
--
ALTER TABLE `taximeter_user_requests`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=304;

--
-- AUTO_INCREMENT for table `user_requests`
--
ALTER TABLE `user_requests`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1689;

--
-- AUTO_INCREMENT for table `user_request_payments`
--
ALTER TABLE `user_request_payments`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=657;

--
-- AUTO_INCREMENT for table `user_request_ratings`
--
ALTER TABLE `user_request_ratings`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=637;

--
-- AUTO_INCREMENT for table `wallet_passbooks`
--
ALTER TABLE `wallet_passbooks`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `withdrawal_moneys`
--
ALTER TABLE `withdrawal_moneys`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `zones`
--
ALTER TABLE `zones`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
