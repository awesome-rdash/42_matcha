SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

DROP TABLE IF EXISTS `errors`;
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
(27, 'member', 'invalid', 'lastname', 'Votre nom ne doit pas dépasser 20 caractères.'),
(28, 'member', 'incorrectsize', 'phone', 'Le numéro de téléphone doit être composé de 10 chiffres. Exemple : 0123456789'),
(29, 'member', 'invalid', 'phone', 'Le numéro de téléphone doit être composé de 10 chiffres. Exemple : 0123456789'),
(30, 'member', 'invalid', 'sexe', 'Votre sexe ne peut être que masculin ou féminin.'),
(31, 'member', 'invalid', 'mail_confirmed', 'Confirmation du mail incorrecte.'),
(32, 'users', 'notfound', 'get', 'Aucun utilisateur avec cet ID n\'a été trouvé.'),
(33, 'users', 'badselector', 'get', 'Mauvais sélecteur. Sélecteurs disponibles : id nickname email');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nickname` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(128) NOT NULL,
  `register_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `birthdate` date DEFAULT NULL,
  `firstname` varchar(20) DEFAULT NULL,
  `lastname` varchar(20) DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `sexe` bit(2) DEFAULT NULL,
  `bio` text,
  `mail_confirmed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `nickname`, `email`, `password`, `register_time`, `birthdate`, `firstname`, `lastname`, `phone`, `sexe`, `bio`, `mail_confirmed`) VALUES
(1, 'test', 'test@test.fr', '989bac194dc428df07bd8f455326765ad001c7b3909c86b63400641fddc9bc4a205ca18458e112e978e6c9576a6a397fa2203cf458ca0412886b57c23b386f76', '2016-06-20 17:18:01', '2016-06-01', 'test', 'test', NULL, NULL, NULL, 0);


ALTER TABLE `errors`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `errors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
