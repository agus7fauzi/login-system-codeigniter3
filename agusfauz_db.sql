-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.2
-- Waktu pembuatan: 09 Nov 2020 pada 16.22
-- Versi server: 5.7.30-33-log
-- Versi PHP: 7.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `agusfauz_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `login_system_codeigniter3__users`
--

CREATE TABLE `login_system_codeigniter3__users` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `image` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `login_system_codeigniter3__users`
--

INSERT INTO `login_system_codeigniter3__users` (`id`, `name`, `email`, `image`, `password`, `role_id`, `is_active`, `date_created`) VALUES
(6, 'Iksan Bahtiar', 'iksan7bahtiar@gmail.com', 'default.png', '$2y$10$xyoNgyXf47VAQ2liAMpUteB88zbpTW7w5Mk.A5/1AzXpqGw9orDMO', 2, 1, 1604639182),
(15, 'Agus Imam Fauzi', 'agus7fauzi@gmail.com', 'default.png', '$2y$10$/qGwib.nWeDN5fiMxNJH6.qAjmF4u4eXHxXb4A7AXr6tCvK8qaQTi', 1, 1, 1604794847);

-- --------------------------------------------------------

--
-- Struktur dari tabel `login_system_codeigniter3__users_token`
--

CREATE TABLE `login_system_codeigniter3__users_token` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `token` varchar(128) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `login_system_codeigniter3__user_access_menu`
--

CREATE TABLE `login_system_codeigniter3__user_access_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `login_system_codeigniter3__user_access_menu`
--

INSERT INTO `login_system_codeigniter3__user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(1, 1, 1),
(3, 2, 2),
(21, 1, 3),
(22, 1, 2),
(23, 3, 2),
(24, 3, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `login_system_codeigniter3__user_menus`
--

CREATE TABLE `login_system_codeigniter3__user_menus` (
  `id` int(11) NOT NULL,
  `menu` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `login_system_codeigniter3__user_menus`
--

INSERT INTO `login_system_codeigniter3__user_menus` (`id`, `menu`) VALUES
(1, 'Admin'),
(2, 'User'),
(3, 'Menu');

-- --------------------------------------------------------

--
-- Struktur dari tabel `login_system_codeigniter3__user_roles`
--

CREATE TABLE `login_system_codeigniter3__user_roles` (
  `id` int(11) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `login_system_codeigniter3__user_roles`
--

INSERT INTO `login_system_codeigniter3__user_roles` (`id`, `role`) VALUES
(1, 'Administrator'),
(2, 'Member');

-- --------------------------------------------------------

--
-- Struktur dari tabel `login_system_codeigniter3__user_sub_menus`
--

CREATE TABLE `login_system_codeigniter3__user_sub_menus` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `login_system_codeigniter3__user_sub_menus`
--

INSERT INTO `login_system_codeigniter3__user_sub_menus` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`) VALUES
(1, 1, 'Dasboard', 'admin', 'fas fa-fw fa-tachometer-alt', 1),
(2, 2, 'My Profile', 'user', 'fas fa-fw fa-user', 1),
(3, 2, 'Edit Profile', 'user/edit', 'fas fa-fw fa-user-edit', 1),
(4, 3, 'Menu Management', 'menu', 'fas fa-fw fa-puzzle-piece', 1),
(5, 3, 'Sub Menu Management', 'menu/submenu', 'fas fa-fw fa-bars', 1),
(7, 1, 'Roles', 'admin/roles', 'fas fa-fw fa-users-cog', 1),
(8, 2, 'Change Password', 'user/changepassword', 'fas fa-fw fa-key', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `login_system_codeigniter3__users`
--
ALTER TABLE `login_system_codeigniter3__users`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `login_system_codeigniter3__users_token`
--
ALTER TABLE `login_system_codeigniter3__users_token`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `login_system_codeigniter3__user_access_menu`
--
ALTER TABLE `login_system_codeigniter3__user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `login_system_codeigniter3__user_menus`
--
ALTER TABLE `login_system_codeigniter3__user_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `login_system_codeigniter3__user_roles`
--
ALTER TABLE `login_system_codeigniter3__user_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `login_system_codeigniter3__user_sub_menus`
--
ALTER TABLE `login_system_codeigniter3__user_sub_menus`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `login_system_codeigniter3__users`
--
ALTER TABLE `login_system_codeigniter3__users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `login_system_codeigniter3__users_token`
--
ALTER TABLE `login_system_codeigniter3__users_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `login_system_codeigniter3__user_access_menu`
--
ALTER TABLE `login_system_codeigniter3__user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `login_system_codeigniter3__user_menus`
--
ALTER TABLE `login_system_codeigniter3__user_menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `login_system_codeigniter3__user_roles`
--
ALTER TABLE `login_system_codeigniter3__user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `login_system_codeigniter3__user_sub_menus`
--
ALTER TABLE `login_system_codeigniter3__user_sub_menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
