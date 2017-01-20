SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


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
  `sexual_orientation` enum('male','female','both') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `nickname`, `email`, `password`, `register_time`, `birthdate`, `firstname`, `lastname`, `phone`, `sexe`, `bio`, `mail_confirmed`, `sexual_orientation`) VALUES
(1, 'admin', 'admin@camagru.fr', '838858b5bb0592b88fef9c3a67a97546949687b8d45e505a50c203d064c0306be286d20d5f41b2d1cecd613e8c410c49031db7b878629761b64691d11ced1a58', 1470013136, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'male');


ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
