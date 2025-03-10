-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: MySQL-5.7
-- Время создания: Мар 08 2025 г., 21:47
-- Версия сервера: 5.7.44
-- Версия PHP: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: task-force
--
CREATE DATABASE IF NOT EXISTS task-force DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE task-force;

-- --------------------------------------------------------

--
-- Структура таблицы address
--

DROP TABLE IF EXISTS address;
CREATE TABLE address (
  id_address int(11) NOT NULL,
  id_city int(11) NOT NULL,
  lat_address float DEFAULT NULL,
  long_address float DEFAULT NULL,
  address varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы category
--

DROP TABLE IF EXISTS category;
CREATE TABLE category (
  id_category int(11) NOT NULL,
  name_category varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  icon_category varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы city
--

DROP TABLE IF EXISTS city;
CREATE TABLE city (
  id_city int(11) NOT NULL,
  name_city varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  lat_city float NOT NULL,
  long_city float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы file
--

DROP TABLE IF EXISTS file;
CREATE TABLE `file` (
  id_file int(11) NOT NULL,
  path varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  name varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  id_task int(11) NOT NULL,
  date_add datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы job_title
--

DROP TABLE IF EXISTS job_title;
CREATE TABLE job_title (
  id_specialization int(11) NOT NULL,
  specialization varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы respons
--

DROP TABLE IF EXISTS respons;
CREATE TABLE respons (
  id_response int(11) NOT NULL,
  id_executor int(11) NOT NULL,
  id_task int(11) NOT NULL,
  price int(11) NOT NULL,
  date_add datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы review
--

DROP TABLE IF EXISTS review;
CREATE TABLE review (
  id_review int(11) NOT NULL,
  id_user int(11) NOT NULL,
  id_commentator int(11) NOT NULL,
  grade int(11) NOT NULL,
  date_add datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  id_task int(11) DEFAULT NULL,
  comment text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы role
--

DROP TABLE IF EXISTS role;
CREATE TABLE role (
  id_role int(11) NOT NULL,
  role varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы status
--

DROP TABLE IF EXISTS status;
CREATE TABLE `status` (
  id_status int(11) NOT NULL,
  status varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы task
--

DROP TABLE IF EXISTS task;
CREATE TABLE task (
  id_task int(11) NOT NULL,
  task varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  discription text COLLATE utf8mb4_unicode_ci,
  price int(11) DEFAULT NULL,
  date_public datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  date_execut datetime NOT NULL,
  id_status int(11) NOT NULL,
  id_address int(11) DEFAULT NULL,
  id_client int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы task_category
--

DROP TABLE IF EXISTS task_category;
CREATE TABLE task_category (
  id int(11) NOT NULL,
  id_task int(11) NOT NULL,
  id_category int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы user
--

DROP TABLE IF EXISTS user;
CREATE TABLE `user` (
  id_user int(11) NOT NULL,
  name varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  email varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  id_city int(11) NOT NULL,
  password varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  birth datetime DEFAULT NULL,
  registration datetime NOT NULL,
  telegram varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  id_specialization int(11) DEFAULT NULL,
  avatar varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  information text COLLATE utf8mb4_unicode_ci,
  id_role int(11) NOT NULL,
  phone varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы user_job_title
--

DROP TABLE IF EXISTS user_job_title;
CREATE TABLE user_job_title (
  id int(11) NOT NULL,
  id_user int(11) NOT NULL,
  id_specialization int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы address
--
ALTER TABLE address
  ADD PRIMARY KEY (id_address);

--
-- Индексы таблицы category
--
ALTER TABLE category
  ADD PRIMARY KEY (id_category);

--
-- Индексы таблицы city
--
ALTER TABLE city
  ADD PRIMARY KEY (id_city);

--
-- Индексы таблицы file
--
ALTER TABLE file
  ADD PRIMARY KEY (id_file),
  ADD KEY id_task (id_task);

--
-- Индексы таблицы job_title
--
ALTER TABLE job_title
  ADD PRIMARY KEY (id_specialization);

--
-- Индексы таблицы respons
--
ALTER TABLE respons
  ADD PRIMARY KEY (id_response),
  ADD KEY id_task (id_task),
  ADD KEY responses_ibfk_1 (id_executor);

--
-- Индексы таблицы review
--
ALTER TABLE review
  ADD PRIMARY KEY (id_review),
  ADD KEY id_commentator (id_commentator),
  ADD KEY id_user (id_user),
  ADD KEY reviews_ibfk_3 (id_task);

--
-- Индексы таблицы role
--
ALTER TABLE role
  ADD PRIMARY KEY (id_role);

--
-- Индексы таблицы status
--
ALTER TABLE status
  ADD PRIMARY KEY (id_status);

--
-- Индексы таблицы task
--
ALTER TABLE task
  ADD PRIMARY KEY (id_task),
  ADD KEY id_location (id_address),
  ADD KEY tasks_ibfk_3 (id_status),
  ADD KEY tasks_ibfk_1 (id_client);

--
-- Индексы таблицы task_category
--
ALTER TABLE task_category
  ADD PRIMARY KEY (id),
  ADD KEY id_category (id_category),
  ADD KEY tasks-categories_ibfk_2 (id_task);

--
-- Индексы таблицы user
--
ALTER TABLE user
  ADD PRIMARY KEY (id_user),
  ADD KEY id_city (id_city),
  ADD KEY id_specialization (id_specialization),
  ADD KEY id_role (id_role);

--
-- Индексы таблицы user_job_title
--
ALTER TABLE user_job_title
  ADD PRIMARY KEY (id),
  ADD KEY id_specialization (id_specialization),
  ADD KEY users-specializations_ibfk_2 (id_user);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы address
--
ALTER TABLE address
  MODIFY id_address int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы category
--
ALTER TABLE category
  MODIFY id_category int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы city
--
ALTER TABLE city
  MODIFY id_city int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы file
--
ALTER TABLE file
  MODIFY id_file int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы job_title
--
ALTER TABLE job_title
  MODIFY id_specialization int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы respons
--
ALTER TABLE respons
  MODIFY id_response int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы review
--
ALTER TABLE review
  MODIFY id_review int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы role
--
ALTER TABLE role
  MODIFY id_role int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы status
--
ALTER TABLE status
  MODIFY id_status int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы task
--
ALTER TABLE task
  MODIFY id_task int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы task_category
--
ALTER TABLE task_category
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы user
--
ALTER TABLE user
  MODIFY id_user int(11) NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы file
--
ALTER TABLE file
  ADD CONSTRAINT file_ibfk_1 FOREIGN KEY (id_task) REFERENCES task (id_task);

--
-- Ограничения внешнего ключа таблицы respons
--
ALTER TABLE respons
  ADD CONSTRAINT respons_ibfk_1 FOREIGN KEY (id_executor) REFERENCES `user` (id_user),
  ADD CONSTRAINT respons_ibfk_2 FOREIGN KEY (id_task) REFERENCES task (id_task);

--
-- Ограничения внешнего ключа таблицы review
--
ALTER TABLE review
  ADD CONSTRAINT review_ibfk_1 FOREIGN KEY (id_commentator) REFERENCES `user` (id_user),
  ADD CONSTRAINT review_ibfk_2 FOREIGN KEY (id_user) REFERENCES `user` (id_user),
  ADD CONSTRAINT review_ibfk_3 FOREIGN KEY (id_task) REFERENCES task (id_task);

--
-- Ограничения внешнего ключа таблицы task
--
ALTER TABLE task
  ADD CONSTRAINT task_ibfk_1 FOREIGN KEY (id_client) REFERENCES `user` (id_user),
  ADD CONSTRAINT task_ibfk_2 FOREIGN KEY (id_address) REFERENCES address (id_address),
  ADD CONSTRAINT task_ibfk_3 FOREIGN KEY (id_status) REFERENCES status (id_status);

--
-- Ограничения внешнего ключа таблицы task_category
--
ALTER TABLE task_category
  ADD CONSTRAINT task_category_ibfk_1 FOREIGN KEY (id_category) REFERENCES category (id_category),
  ADD CONSTRAINT task_category_ibfk_2 FOREIGN KEY (id_task) REFERENCES task (id_task);

--
-- Ограничения внешнего ключа таблицы user
--
ALTER TABLE user
  ADD CONSTRAINT user_ibfk_1 FOREIGN KEY (id_city) REFERENCES city (id_city),
  ADD CONSTRAINT user_ibfk_3 FOREIGN KEY (id_role) REFERENCES role (id_role);

--
-- Ограничения внешнего ключа таблицы user_job_title
--
ALTER TABLE user_job_title
  ADD CONSTRAINT user_job_title_ibfk_1 FOREIGN KEY (id_specialization) REFERENCES job_title (id_specialization),
  ADD CONSTRAINT user_job_title_ibfk_2 FOREIGN KEY (id_user) REFERENCES `user` (id_user);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
