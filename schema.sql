SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `memes` (
  `id` int(11) NOT NULL,
  `url` varchar(2083) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `memes` (`id`, `url`, `created_at`) VALUES
(3, 'https://i.pinimg.com/originals/d9/a5/35/d9a53505ba41c37885c2234dda0844e0.jpg', '2020-12-09 17:55:31'),
(4, 'https://i.pinimg.com/736x/a8/ae/fe/a8aefeac2b170da0552f68124862ac9d.jpg', '2020-12-09 18:33:46'),
(5, 'https://www.dailydot.com/wp-content/uploads/eba/e3/5b1a6900482cfa27.jpg', '2020-12-09 18:34:34'),
(6, 'https://miro.medium.com/max/1280/0*Mif09Iu6iFryla-7.jpg', '2020-12-09 18:41:59'),
(7, 'https://img.devrant.com/devrant/rant/r_1991329_A1RXn.jpg', '2020-12-09 18:44:09'),
(8, 'https://miro.medium.com/max/2160/1*iLelrbqiic_JByLdEm1SUA.jpeg', '2020-12-09 18:45:19'),
(9, 'https://www.siliconrepublic.com/wp-content/uploads/2014/12/img/astronaut-meme-3.jpg', '2020-12-09 18:46:30'),
(10, 'https://memezila.com/wp-content/Wait-its-all-cake-Always-has-been-meme-5066.png', '2020-12-09 18:49:45'),
(11, 'https://i.pinimg.com/originals/23/b1/e7/23b1e763c040474632562c81152c1675.png', '2020-12-09 18:52:48'),
(12, 'https://wyncode.co/uploads/2014/08/81.jpg', '2020-12-09 18:54:29'),
(13, 'https://www.hackadda.com/media/blog/abhi/2020/02/07/debugging-meme.jpg', '2020-12-09 18:54:54'),
(14, 'https://pbs.twimg.com/media/EeZbQ93XgAAFHum.jpg', '2020-12-09 18:55:45'),
(15, 'https://img-9gag-fun.9cache.com/photo/aBgOBQz_460s.jpg', '2020-12-09 18:57:54');

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'lonnieCeo', '$2y$10$t8XIBlaAZT9pkAP8OnBEDuEoNSX8wBQNwOtUrPO5YojZEjXP1Wjh6'),
(2, 'lonnieCeo1', '$2y$10$IzodiGl.xmIPeYHhpSR7jOV5faUccFaTie191IaQNlLQpn0hZmTj6');

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `memes`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

ALTER TABLE `memes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;