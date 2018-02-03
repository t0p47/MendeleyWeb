-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 30 2017 г., 14:50
-- Версия сервера: 5.5.53-MariaDB
-- Версия PHP: 5.6.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `multi`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip_restrict` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `admin_users`
--

INSERT INTO `admin_users` (`id`, `name`, `email`, `password`, `ip_restrict`, `ip`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Jane Doe', 'janedoe@test.com', '$1$IR0.xP..$ButPxXOE6OxH4izjFoIAb0', 'no', '127.0.0.1', 'AgdyIqHYBD5tfg3fwKJiNhKK3xF9sLOf7tgVZ92rJrchjWBoEuAW183JbCo2', '2017-01-17 03:15:13', '2017-01-20 21:18:02'),
(2, 'Alexey', 'alexey@yandex.ru', '$2y$10$JhJA/tq.VRCuzz43x7D1p.X5N3VvlD8CeRPJ.Lw7GLOzGfVffJVkO', 'no', '0', 'XwZIT1HHH80E0i3cOjvBZg9SiuPEMCKr8ZNOKpw6DNLceOJQ2dpeGUurfP5c', NULL, '2017-04-11 01:06:17');

-- --------------------------------------------------------

--
-- Структура таблицы `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) UNSIGNED NOT NULL,
  `amount` float NOT NULL,
  `details` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `expenses`
--

INSERT INTO `expenses` (`id`, `amount`, `details`, `created_at`, `updated_at`) VALUES
(2, 25, 'На бусы', '2017-01-18 12:35:17', '2017-01-18 12:39:58');

-- --------------------------------------------------------

--
-- Структура таблицы `folders`
--

CREATE TABLE `folders` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `subfolder` text COMMENT 'Массив дочерних папок',
  `rootfolder` int(11) NOT NULL COMMENT 'Ссылка на папку-родитель',
  `level` int(11) NOT NULL DEFAULT '0',
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `folders`
--

INSERT INTO `folders` (`id`, `title`, `subfolder`, `rootfolder`, `level`, `uid`) VALUES
(1, 'LevelOne1', '', 0, 0, 6),
(2, 'LevelOne2', '4,5', 0, 0, 6),
(3, 'LevelOne3', '', 0, 0, 6),
(4, 'LevelTwo1', '', 2, 1, 6),
(5, 'LevelTwo2', '6,7', 2, 1, 6),
(6, 'LevelThree1', '', 5, 2, 6),
(7, 'LevelThree2', '', 5, 2, 6);

-- --------------------------------------------------------

--
-- Структура таблицы `journal_articles`
--

CREATE TABLE `journal_articles` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'Primary identifier for a record',
  `title` text NOT NULL,
  `authors` varchar(255) NOT NULL,
  `abstract` text,
  `journal` text,
  `volume` int(11) DEFAULT NULL,
  `issue` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `pages` int(11) DEFAULT NULL,
  `ArXivID` varchar(255) DEFAULT NULL,
  `DOI` varchar(255) DEFAULT NULL,
  `PMID` varchar(255) DEFAULT NULL,
  `folder` int(11) NOT NULL DEFAULT '0',
  `filepath` text,
  `uid` int(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `delete_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Custom table My database module' ROW_FORMAT=COMPACT;

--
-- Дамп данных таблицы `journal_articles`
--

INSERT INTO `journal_articles` (`id`, `title`, `authors`, `abstract`, `journal`, `volume`, `issue`, `year`, `pages`, `ArXivID`, `DOI`, `PMID`, `folder`, `filepath`, `uid`, `created_at`, `updated_at`, `delete_date`) VALUES
(1, 'dsadas', 'dasasfa', 'dadsads', 'fasfa', 578578577, 75757, 678, 7857, 'asdawd', 'awdasd', 'awdadaas', 0, NULL, 1, '2016-10-12 17:00:00', '2016-10-13 08:53:42', '0000-00-00 00:00:00'),
(2, 'fasfasf', 'asfasfas', 'gdrgr', 'fasfa', 857757, 857578, 5878757, 5785785, 'uhkuk', 'ukyukyuy', 'uky', 0, '../userdata/articles/1/guice.pdf', 1, '2016-10-12 17:00:00', '2016-10-13 09:04:21', '0000-00-00 00:00:00'),
(3, 'dfsdfs', 'dfsdfef', 'dedaskjj', 'sfdsf', 13123, 1265, 456, 10456, 'sodfbboi', 'ninpfog', 'onpindg', 0, 'userdata/articles/1/guice.pdf', 1, '2016-10-12 17:00:00', '2016-10-13 09:23:32', '0000-00-00 00:00:00'),
(11, 'Journal article title', '01', 'Abstract', 'Journal title', 22, 22, 2017, 22, 'Arxiv', 'DOI', 'PMID', 0, NULL, 6, '2017-04-11 01:24:32', '2017-04-12 19:07:04', '0000-00-00 00:00:00'),
(24, '99', '99', '99', '99', 99, 99, 99, 99, '99', '99', '99', 0, '/storage/6/pdf-at-iframe.pdf', 6, '2017-04-12 04:21:32', '2017-04-12 04:21:32', '0000-00-00 00:00:00'),
(25, '01', '02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 9, '2017-04-18 18:07:04', '2017-04-18 18:07:04', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `libraries`
--

CREATE TABLE `libraries` (
  `id` int(10) UNSIGNED NOT NULL,
  `uid` int(11) NOT NULL,
  `type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `mid` int(11) NOT NULL,
  `takescount` int(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Дамп данных таблицы `libraries`
--

INSERT INTO `libraries` (`id`, `uid`, `type`, `mid`, `takescount`) VALUES
(1, 1, 'journalarticles', 1, 0),
(2, 1, 'journalarticles', 2, 0),
(3, 1, 'journalarticles', 3, 0),
(4, 6, 'journalarticles', 10, 0),
(5, 6, 'journalarticles', 11, 0),
(6, 6, 'journalarticles', 14, 0),
(7, 6, 'journalarticles', 15, 0),
(8, 6, 'journalarticles', 16, 0),
(9, 6, 'journalarticles', 17, 0),
(10, 6, 'journalarticles', 18, 0),
(11, 6, 'journalarticles', 19, 0),
(12, 6, 'journalarticles', 20, 0),
(13, 6, 'journalarticles', 21, 0),
(14, 6, 'journalarticles', 22, 0),
(15, 6, 'journalarticles', 23, 0),
(16, 6, 'journalarticles', 24, 0),
(17, 6, 'journalarticles', 25, 0),
(18, 9, 'journalarticles', 25, 0),
(19, 6, 'journalarticles', 26, 0),
(20, 6, 'journalarticles', 27, 0),
(21, 6, 'journalarticles', 28, 0),
(22, 6, 'journalarticles', 29, 0),
(23, 6, 'journalarticles', 30, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2017_01_17_095658_create_admin_users_table', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('janedoe@test.com', '609c913a334661ad1798fd69a9e5d5f10b59b94a7f33a7bcb415ae0208eba568', '2017-04-05 12:23:41'),
('andrei@yandex.ru', 'f3bb6d69d419f88bf04163975ead8c4d1f00c8cdb452ab12738231b7c514fbc2', '2017-04-18 17:45:49');

-- --------------------------------------------------------

--
-- Структура таблицы `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `type` enum('Revenue','Expense') NOT NULL,
  `amount` float NOT NULL,
  `details` text,
  `ip` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Дамп данных таблицы `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `type`, `amount`, `details`, `ip`, `created_at`, `updated_at`) VALUES
(2, 4, 'Revenue', 25, NULL, '', '2017-01-20 09:36:29', '2017-01-20 02:36:29'),
(3, 1, 'Revenue', 78, NULL, '', '2017-01-19 07:40:04', '2017-01-19 00:40:04'),
(4, 1, 'Revenue', 81, NULL, '', '2017-01-20 07:45:40', '2017-01-20 00:45:40'),
(5, 1, 'Revenue', 21, NULL, '', '2017-01-20 07:45:56', '2017-01-20 00:45:56'),
(6, 4, 'Revenue', 51, NULL, '', '2017-01-18 09:35:34', '2017-01-18 09:35:34'),
(7, 4, 'Revenue', 6, NULL, '127.0.0.1', '2017-01-18 22:36:21', '2017-01-18 22:36:21'),
(8, 1, 'Revenue', 40, NULL, '127.0.0.1', '2017-01-19 11:55:40', '2017-01-19 11:55:40'),
(9, 1, 'Revenue', 31, NULL, '127.0.0.1', '2017-01-20 19:48:05', '2017-01-20 19:48:05'),
(10, 1, 'Revenue', 6, NULL, '127.0.0.1', '2017-01-20 19:48:28', '2017-01-20 19:48:28'),
(11, 1, 'Revenue', 110, NULL, '127.0.0.1', '2017-01-20 19:48:43', '2017-01-20 19:48:43'),
(12, 1, 'Revenue', 110, NULL, '127.0.0.1', '2017-01-20 19:48:49', '2017-01-20 19:48:49');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip_restrict` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `ip` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `postcount` int(20) NOT NULL DEFAULT '0' COMMENT 'Количество выложенных материалов ',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `ip_restrict`, `ip`, `postcount`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'John Doe', 'johndoe@test.com', '$2y$10$0ot9VlZ8JI2cby0feLbGxu63wNSvKXfW5YdeuMw8GDuBfcNGg11p2', 'no', '45.76.154.7', 0, 'vzQpg8mMEsaDcWTdu9Q7aOo6bNv84kqxv46Ln8BiAtlB6AEJxTT60ww2TrxM', '2017-01-17 06:58:17', '2017-01-20 20:58:08'),
(4, 'Alexye', 't0p47@yandex.ru', '55005500', 'no', '45.76.154.7', 0, 'GESTmdoCIK6bpEPYTJiFIp0pbbacFFMoAv1JnPYg4wOHwJvkeB1tX2h5KddY', '2017-01-18 09:35:02', '2017-01-20 21:17:30'),
(5, 'Dmitriy', 'admin@yandex.ru', '$2y$10$iyH7VP4.bwn3X0l2l7iER.IUd1Shf9KfMBQaqEgu3mRWGKTiBzjyK', 'yes', '0', 0, 'PesgsPSdx0E5vwgzkHAbNHwvNu5QuzKQgNGy1HSKkxBdu7Iu6T9KukaGwSLW', '2017-04-05 12:47:44', '2017-04-05 12:48:36'),
(6, 'junk50', 'junk50@yandex.ru', '$2y$10$tbxicBhqlV7VjGT1SVUs1OMAN4V7Srh9RQzOFFELpvoQZ3L4J804G', 'no', '0', 2, 'YjsaGz3QRe6nfHFJSaEkiIEfiMHkkM5mA0N4hTklTQLqOVUW8yBM0awBK0dk', '2017-04-05 12:50:57', '2017-04-18 21:30:31'),
(9, 'Andrei', 'andrei@yandex.ru', '$2y$10$P4SHS/vXmJYymuIffx7FMe.y8Zo8cWn8Y.8KbRn91wm87RkkKx2PS', 'no', '0', 1, 'FFAtbMy60XMHmyAyZg4urYQdqTTIFkOUKkg7MS1o4Z4o9QzmA9dCnaSydsvd', '2017-04-18 17:49:48', '2017-04-18 19:11:32');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_users_email_unique` (`email`);

--
-- Индексы таблицы `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `folders`
--
ALTER TABLE `folders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `journal_articles`
--
ALTER TABLE `journal_articles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `libraries`
--
ALTER TABLE `libraries`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Индексы таблицы `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `folders`
--
ALTER TABLE `folders`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT для таблицы `journal_articles`
--
ALTER TABLE `journal_articles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Primary identifier for a record', AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT для таблицы `libraries`
--
ALTER TABLE `libraries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
