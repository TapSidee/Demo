-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 23 2024 г., 15:16
-- Версия сервера: 8.0.30
-- Версия PHP: 8.0.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `techno`
--

-- --------------------------------------------------------

--
-- Структура таблицы `request`
--

CREATE TABLE `request` (
  `id_request` int NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_finish` timestamp NULL DEFAULT NULL,
  `car_type` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `problem_description` text NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `status` enum('новая заявка','в процессе ремонта','готова к выдаче','ожидание автозапчастей','завершена') NOT NULL DEFAULT 'новая заявка',
  `mechanic` varchar(255) DEFAULT NULL,
  `mechanic_comment` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `request`
--

INSERT INTO `request` (`id_request`, `date_added`, `date_finish`, `car_type`, `model`, `problem_description`, `client_name`, `phone_number`, `status`, `mechanic`, `mechanic_comment`) VALUES
(1, '2024-05-23 12:11:42', NULL, '44', '2341', '123', '321321', '1233123', 'новая заявка', NULL, NULL),
(2, '2024-05-23 12:11:48', NULL, '22', '1234', '3222', 'werwer', 'ewrwer', 'новая заявка', NULL, NULL),
(3, '2024-05-23 12:11:53', NULL, 'wer', 'werwerrrr', 'werww', 'rwer', 'wwwwer', 'новая заявка', NULL, NULL),
(4, '2024-05-23 12:12:04', '2024-05-23 12:14:50', 'werxsdsdf', 'dasssd', 'asdqqw``112', '213121fgddf', 'sdfsdwewwer', 'завершена', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id_user`, `login`, `password`, `role`) VALUES
(1, 'user', 'ee11cbb19052e40b07aac0ca060c23ee', 'user'),
(2, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`id_request`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `request`
--
ALTER TABLE `request`
  MODIFY `id_request` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
