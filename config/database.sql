-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jun 03, 2017 at 03:46 PM
-- Server version: 5.6.35
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `camagru`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_picture` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `time_posted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `errors`
--

CREATE TABLE `errors` (
  `id` int(11) NOT NULL,
  `module` varchar(20) NOT NULL,
  `type` varchar(20) NOT NULL,
  `element` varchar(20) NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `errors`
--

INSERT INTO `errors` (`id`, `module`, `type`, `element`, `message`) VALUES
(9, 'register', 'missingfield', 'nickname', 'Vous devez entrer un nom d\'utilisateur.'),
(10, 'register', 'missingfield', 'email', 'Vous devez entrer votre email.'),
(11, 'register', 'missingfield', 'password', 'Vous devez entrer un mot de passe.'),
(12, 'register', 'missingfield', 'password2', 'Vous devez entrer la confirmation du mot de passe.'),
(13, 'member', 'notthesame', 'password', 'Les mots de passe ne correspondent pas.'),
(14, 'register', 'missingfield', 'birthdate', 'Vous devez entrer votre date de naissance.'),
(15, 'member', 'alreadyexist', 'nickname', 'Le nom d\'utilisateur que vous avez choisi est déjà utilisé.'),
(16, 'member', 'alreadyexist', 'email', 'L\'email que vous avez entrée est déjà associée à un autre compte.'),
(17, 'member', 'toolong', 'nickname', 'La longueur du nom d\'utilisateur ne peut excéder 15 caractères.'),
(18, 'member', 'specialchar', 'nickname', 'Le nom d\'utilisateur doit être composé uniquement de caractères alphanumériques.'),
(19, 'member', 'toolong', 'email', 'Veuillez utiliser une adresse email contenant moins de 255 caractères.'),
(20, 'member', 'notvalid', 'email', 'L\'adresse email que vous avez entrée n\'est pas valide.'),
(21, 'member', 'tooshort', 'password', 'Le mot de passe doit faire au moins 6 caractères.'),
(22, 'member', 'toolong', 'password', 'Le mot de passe ne peut excéder 200 caractères.'),
(23, 'member', 'invalid', 'registertime', 'L\'heure d\'enregistrement n\'est pas valide.'),
(24, 'member', 'toolong', 'firstname', 'Votre prénom ne doit pas dépasser 20 caractères.'),
(25, 'member', 'invalid', 'firstname', 'Votre prénom ne peut contenir que des caractères alphanumériques.'),
(26, 'member', 'invalid', 'lastname', 'Votre nom ne peut contenir que des caractères alphanumériques.'),
(27, 'member', 'toolong', 'lastname', 'Votre nom ne doit pas dépasser 20 caractères.'),
(28, 'member', 'incorrectsize', 'phone', 'Le numéro de téléphone doit être composé de 10 chiffres. Exemple : 0123456789'),
(29, 'member', 'invalid', 'phone', 'Le numéro de téléphone doit être composé de 10 chiffres. Exemple : 0123456789'),
(30, 'member', 'invalid', 'sexe', 'Votre sexe ne peut être que masculin ou féminin.'),
(31, 'member', 'invalid', 'mail_confirmed', 'Confirmation du mail incorrecte.'),
(32, 'users', 'notfound', 'get', 'Aucun utilisateur avec cet ID n\'a été trouvé.'),
(33, 'users', 'badselector', 'get', 'Mauvais sélecteur. Sélecteurs disponibles : id nickname email'),
(34, 'login', 'notfound', 'nickname', 'Aucun compte n\'existe avec ce nom d\'utilisateur.'),
(35, 'login', 'invalid', 'password', 'Le mot de passe ne correspond pas au compte.'),
(36, 'token', 'missing', 'usetoken', 'Impossible de valider l\'action sans jeton.'),
(37, 'token', 'invalid', 'usetoken', 'Le jeton est invalide. Etes-vous sur d\'avoir cliqué sur le bon lien ?'),
(38, 'token', 'alreadyused', 'usetoken', 'Ce jeton a déjà été utilisé. Etes-vous sur d\'avoir cliqué sur le bon lien ?'),
(39, 'token', 'outdated', 'usetoken', 'Le jeton a expiré.'),
(40, 'resetpassword', 'missingfield', 'email', 'Vous devez indiquer votre email.'),
(41, 'resetpassword', 'missingfield', 'birthdate', 'Vous devez indiquer votre date de naissance.'),
(42, 'resetpassword', 'notfound', 'email', 'Aucun compte n\'est associé à cette adresse.'),
(43, 'resetpassword', 'invalide', 'birthdate', 'La date de naissance ne correspond pas.'),
(44, 'login', 'notconfirmed', 'mail', 'Vous devez cliquer sur le lien envoyé par email pour confirmer votre inscription.'),
(45, 'member', 'tooshort', 'nickname', 'Le nom d\'utilisateur doit être compose d\'au moins 3 caractères.'),
(46, 'tag', 'specialchar', 'content', 'Le TAG ne peut être composé que de caractères alphanumériques.'),
(48, 'taglink', 'alreadyexist', 'addlink', 'Le TAG est déjà associé.');

-- --------------------------------------------------------

--
-- Table structure for table `fakeaccounts_reports`
--

CREATE TABLE `fakeaccounts_reports` (
  `id` int(11) NOT NULL,
  `fromUser` int(11) NOT NULL,
  `toUserReported` int(11) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `filters`
--

CREATE TABLE `filters` (
  `id` int(11) NOT NULL,
  `upload_time` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `filters`
--

INSERT INTO `filters` (`id`, `upload_time`, `owner_id`) VALUES
(1, 1, 1),
(2, 1, 1),
(3, 1, 1),
(4, 1490274541, 1);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_picture` int(11) NOT NULL,
  `time_liked` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `type` enum('like','visit','mutualLike','message','unLike') NOT NULL,
  `new` tinyint(1) NOT NULL DEFAULT '0',
  `toUser` int(11) NOT NULL,
  `fromUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `timestamp`, `type`, `new`, `toUser`, `fromUser`) VALUES
(3, 1492027297, 'like', 0, 1, 4),
(4, 1492027270, 'visit', 0, 1, 3),
(5, 1492034134, 'like', 0, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `content` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `content`) VALUES
(1, 'test'),
(2, 'php'),
(3, 'camagru');

-- --------------------------------------------------------

--
-- Table structure for table `tags_users`
--

CREATE TABLE `tags_users` (
  `id_tag` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tags_users`
--

INSERT INTO `tags_users` (`id_tag`, `id_user`) VALUES
(1, 1),
(2, 1),
(3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(40) NOT NULL,
  `time_created` int(11) NOT NULL,
  `usefor` varchar(20) NOT NULL,
  `isused` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`id`, `user_id`, `token`, `time_created`, `usefor`, `isused`) VALUES
(1, 0, '496174e72a1de9371bf71e3bf81d8f06bc64721b', 1491927266, 'mailconfirmation', b'0'),
(2, 0, '4b9584149393c431c5c8a349b4787b1b9689c165', 1491927353, 'mailconfirmation', b'0'),
(3, 3, '1bddccaa5f4a41c1583967eae5b9f225df30a913', 1491927428, 'mailconfirmation', b'0'),
(4, 4, '9e29f3cac1cfe57e9037348d2316756e33d2dc58', 1491927491, 'mailconfirmation', b'0'),
(5, 5, '72ccea702b2da462c9d27e0c2a1ace7f9de248c1', 1492032388, 'mailconfirmation', b'0'),
(6, 6, 'bfa8518902baba2c3b1c133bb4abbad588489d54', 1494840771, 'mailconfirmation', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `userpictures`
--

CREATE TABLE `userpictures` (
  `id` int(11) NOT NULL,
  `upload_source` varchar(20) NOT NULL,
  `upload_time` int(11) NOT NULL,
  `filter_used` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `userpictures`
--

INSERT INTO `userpictures` (`id`, `upload_source`, `upload_time`, `filter_used`, `owner_id`) VALUES
(3, 'stock', 1490274544, 1, 1),
(4, 'stock', 1490274548, 1, 1),
(5, 'stock', 1490289389, 4, 1),
(6, 'stock', 1490289389, 4, 1),
(7, 'stock', 1490289390, 4, 1),
(8, 'stock', 1490289390, 4, 1),
(9, 'stock', 1490289390, 4, 1),
(10, 'stock', 1490289391, 4, 1),
(11, 'stock', 1490289391, 4, 1),
(12, 'stock', 1490289391, 4, 1),
(13, 'stock', 1491925954, 1, 1),
(14, 'stock', 1491935176, 2, 1),
(15, 'stock', 1492009462, 2, 1),
(16, 'stock', 1494840917, 2, 6);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nickname` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(128) NOT NULL,
  `register_time` int(11) NOT NULL,
  `birthdate` int(11) DEFAULT NULL,
  `firstname` varchar(20) DEFAULT NULL,
  `lastname` varchar(20) DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `sexe` bit(2) DEFAULT NULL,
  `bio` text,
  `mail_confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `sexual_orientation` enum('male','female','both') DEFAULT NULL,
  `profilePicture` int(11) DEFAULT NULL,
  `featuredPictures` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nickname`, `email`, `password`, `register_time`, `birthdate`, `firstname`, `lastname`, `phone`, `sexe`, `bio`, `mail_confirmed`, `sexual_orientation`, `profilePicture`, `featuredPictures`) VALUES
(1, 'admin', 'admin@camagru.fr', '838858b5bb0592b88fef9c3a67a97546949687b8d45e505a50c203d064c0306be286d20d5f41b2d1cecd613e8c410c49031db7b878629761b64691d11ced1a58', 1470013136, NULL, 'Prenom', 'Nom', NULL, b'00', 'ts', 1, 'female', 9, '13,13,6,7'),
(2, 'test', 'test@test.fr', 'test', 3, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 7, NULL),
(3, 'tameretest2', 'jrouzier@outlook.com', '8d9e2cc2d89dd1b980e302dc530aa2519ae31e6326ef82b25d25d9bf97054b253470a026b8f67ee3c20dc49a8fef73ceca3590f2fac6ff1e8f16d4af175130a9', 1491927428, NULL, 'Rouzier', 'Justin', NULL, NULL, NULL, 0, NULL, NULL, NULL),
(4, 'tameretest', 'sebhug@free.fr', '02ec27b3db4131a31bc3446c7b6dfe8ea17a365de5ab0795107540eccb8ac6d5a78c6eaf590e3290bc9d14d533002436247c1826f560df6d069aef3efba67f3e', 1491927491, NULL, 'testhuguenot', 'test', NULL, b'01', '', 1, 'both', NULL, NULL),
(5, 'root', 'root@outlook.com', '2ae79f9bb91a6c53b1d17ecc533926203630d734006775004ae8086d7558d02b50d1afca5f270336d21a60bc11ffd1f5a14bbfbcf9d2d78d9fadb29fe87d00e2', 1492032388, NULL, 'root', 'root', NULL, NULL, NULL, 1, NULL, 16, '16,16,16,16'),
(6, 'jrouzier', 'jrouzier@esport42.fr', '839f24ff0037376f636613cbf49f6e60320073bf29bfe0f0c842eedfa25b3ce37aa9edca128bbc0ca28d2930270234abc1c0776434055c95a297afa69713582f', 1494840771, NULL, 'Rouzier', 'Justin', NULL, NULL, NULL, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_likes`
--

CREATE TABLE `user_likes` (
  `id` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idProfileLiked` int(11) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_likes`
--

INSERT INTO `user_likes` (`id`, `idUser`, `idProfileLiked`, `time`) VALUES
(5, 1, 1, 1492031914),
(11, 1, 5, 1492034125);

-- --------------------------------------------------------

--
-- Table structure for table `user_visits`
--

CREATE TABLE `user_visits` (
  `id` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idProfileVisited` int(11) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_visits`
--

INSERT INTO `user_visits` (`id`, `idUser`, `idProfileVisited`, `time`) VALUES
(22, 1, 6, 1494955689),
(23, 1, 2, 1494928941);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `errors`
--
ALTER TABLE `errors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fakeaccounts_reports`
--
ALTER TABLE `fakeaccounts_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `filters`
--
ALTER TABLE `filters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userpictures`
--
ALTER TABLE `userpictures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_likes`
--
ALTER TABLE `user_likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_visits`
--
ALTER TABLE `user_visits`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `errors`
--
ALTER TABLE `errors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `fakeaccounts_reports`
--
ALTER TABLE `fakeaccounts_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `filters`
--
ALTER TABLE `filters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `userpictures`
--
ALTER TABLE `userpictures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `user_likes`
--
ALTER TABLE `user_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `user_visits`
--
ALTER TABLE `user_visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;