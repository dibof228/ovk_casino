-- phpMyAdmin SQL Dump
-- version 5.2.1-1.el8
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Июл 20 2025 г., 22:26
-- Версия сервера: 8.0.39-cll-lve
-- Версия PHP: 7.2.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `ovkc`
--

-- --------------------------------------------------------

--
-- Структура таблицы `mout`
--

CREATE TABLE `mout` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `time` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `signature`
--

CREATE TABLE `signature` (
  `id` int NOT NULL,
  `signature` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `spins`
--

CREATE TABLE `spins` (
  `id` int NOT NULL,
  `ovk_id` int NOT NULL,
  `time` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `ovk_id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `img` text COLLATE utf8mb4_general_ci,
  `monet` int NOT NULL DEFAULT '15',
  `wins` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `mout`
--
ALTER TABLE `mout`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `signature`
--
ALTER TABLE `signature`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `spins`
--
ALTER TABLE `spins`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `mout`
--
ALTER TABLE `mout`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `signature`
--
ALTER TABLE `signature`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `spins`
--
ALTER TABLE `spins`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
