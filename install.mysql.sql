CREATE TABLE IF NOT EXISTS `#__cookieaccept2` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`lang` varchar(25) NOT NULL UNIQUE,
	`message` text NOT NULL,
	`accept_btn_label` text NOT NULL,
	`more_btn_label` text,
	`more_btn_article` int(10),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=4 ;
 
INSERT INTO `#__cookieaccept2` (`id`,`lang`,`message`,`accept_btn_label`,`more_btn_label`,`more_btn_article`) VALUES
(1,'en-GB','NOTE! This site uses cookies and similar technologies. If you not change browser settings, you agree to it.','I understand','Learn more',6),
(2,'fr-FR','REMARQUE ! Ce site utilise des cookies et autres technologies similaires. Si vous ne changez pas les paramètres de votre navigateur, vous êtes d\'accord.','J\'ai compris','En savoir plus',6),
(3,'pl-PL','UWAGA! Ten serwis używa cookies i podobnych technologii. Brak zmiany ustawień przeglądarki oznacza zgodę na to.','Zrozumiałem','Czytaj więcej',6);
	