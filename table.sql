--
-- Structure de la table `user`
--

CREATE TABLE `user` (
    id int(11) NOT NULL AUTO_INCREMENT,
    login varchar(100) NOT NULL,
    mdp varchar(255) NOT NULL,
    email varchar(255), 
    remember varchar(255),
    avatar varchar(255),
    
    PRIMARY KEY (id),
    UNIQUE KEY login (login)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Structure de la table `ecrit`
--

CREATE TABLE `ecrit` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `titre` varchar(255) NOT NULL,
    `contenu` text,
    `dateEcrit` datetime NOT NULL,
    `image` varchar(255) DEFAULT NULL,
    `idAuteur` int(11) NOT NULL,
    `idAmi` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Structure de la table `lien`
--

CREATE TABLE `lien` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `idUtilisateur1` int(11) NOT NULL,
    `idUtilisateur2` int(11) NOT NULL,
    `etat` varchar(10) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- une donnée dans la table ecrit

INSERT INTO `ecrit` (`id`, `titre`, `contenu`, `dateEcrit`, `image`, `idAuteur`, `idAmi`) VALUES
(1, 'test', 'alors comment ca va', '2017-10-10 16:57:14', '', 1, 1);