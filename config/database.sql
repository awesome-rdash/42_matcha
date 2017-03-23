SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

DROP DATABASE `camagru`;
CREATE DATABASE IF NOT EXISTS `camagru` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `camagru`;

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_picture` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `time_posted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `errors` (
  `id` int(11) NOT NULL,
  `module` varchar(20) NOT NULL,
  `type` varchar(20) NOT NULL,
  `element` varchar(20) NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `filters` (
  `id` int(11) NOT NULL,
  `upload_time` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `filters` (`id`, `upload_time`, `owner_id`) VALUES
(1, 1, 1),
(2, 1, 1),
(3, 1, 1),
(4, 1490274541, 1);

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_picture` int(11) NOT NULL,
  `time_liked` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `content` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `tags` (`id`, `content`) VALUES
(1, 'test'),
(2, 'php');

CREATE TABLE `tags_users` (
  `id_tag` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `tags_users` (`id_tag`, `id_user`) VALUES
(1, 1),
(2, 1);

CREATE TABLE `tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(40) NOT NULL,
  `time_created` int(11) NOT NULL,
  `usefor` varchar(20) NOT NULL,
  `isused` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `userpictures` (
  `id` int(11) NOT NULL,
  `upload_source` varchar(20) NOT NULL,
  `upload_time` int(11) NOT NULL,
  `filter_used` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(12, 'stock', 1490289391, 4, 1);

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

INSERT INTO `users` (`id`, `nickname`, `email`, `password`, `register_time`, `birthdate`, `firstname`, `lastname`, `phone`, `sexe`, `bio`, `mail_confirmed`, `sexual_orientation`, `profilePicture`, `featuredPictures`) VALUES
(1, 'admin', 'admin@camagru.fr', '838858b5bb0592b88fef9c3a67a97546949687b8d45e505a50c203d064c0306be286d20d5f41b2d1cecd613e8c410c49031db7b878629761b64691d11ced1a58', 1470013136, NULL, 'Eddy', 'Albert', NULL, b'00', 'ceci est ma bio', 1, 'male', 4, '5,6,7,8');


ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `errors`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `filters`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `userpictures`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `errors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
ALTER TABLE `filters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
ALTER TABLE `tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `userpictures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
