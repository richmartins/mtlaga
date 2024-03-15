--
START TRANSACTION;

-- select database
USE `mtlaga`;

--
-- Structure de la table `favorites`
--
CREATE TABLE `favorites` (
  `id_favorites` int(11) NOT NULL,
  `departure` varchar(255) NOT NULL,
  `arrival` varchar(255) NOT NULL
);

--
-- Structure de la table `users`
--
CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `hash_password` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `confirmed` tinyint(1) NOT NULL,
  `confirmed_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) NOT NULL,
  `remember` tinyint(1) NOT NULL,
  `reset_password_token` varchar(255) DEFAULT NULL,
  `reset_password_sent_at` datetime DEFAULT NULL
);

--
-- Structure de la table `rss`
--
CREATE TABLE `rss` (
  `id_rss` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL
);

--
-- Structure de la table `users_has_favorites`
--
CREATE TABLE `users_has_favorites` (
  `users_id_user` int(11) NOT NULL,
  `favorites_id_favorites` int(11) NOT NULL
);

--
-- Index pour la table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id_favorites`);

--
-- Index pour la table `rss`
--
ALTER TABLE `rss`
  ADD PRIMARY KEY (`id_rss`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- Index pour la table `users_has_favorites`
--
ALTER TABLE `users_has_favorites`
  ADD PRIMARY KEY (`users_id_user`,`favorites_id_favorites`),
  ADD KEY `fk_users_has_favorites_favorites1_idx` (`favorites_id_favorites`),
  ADD KEY `fk_users_has_favorites_users_idx` (`users_id_user`);

--
-- AUTO_INCREMENT pour la table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id_favorites` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT pour la table `rss`
--
ALTER TABLE `rss`
  MODIFY `id_rss` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- Contraintes pour la table `users_has_favorites`
--
ALTER TABLE `users_has_favorites`
  ADD CONSTRAINT `fk_users_has_favorites_favorites1` FOREIGN KEY (`favorites_id_favorites`) REFERENCES `favorites` (`id_favorites`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_has_favorites_users` FOREIGN KEY (`users_id_user`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;

COMMIT;