CREATE TABLE `phpvms_rules` (
  `id` int(11) NOT NULL auto_increment,
  `rule` varchar(800) NOT NULL,
  `category` int(10) NOT NULL,
  `status` int(20) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1

CREATE TABLE `phpvms_rules_categories` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(100) NOT NULL,
  `status` int(20) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
