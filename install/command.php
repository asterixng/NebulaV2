<?php

require_once './configure.php';

if(isset($_POST['cmd'])){
	
	echo 'Execution command: ' . $_POST['cmd'];
	
	if($_POST['cmd']=='dbuser'){
		dbuser();
	}
	
} else {
	
	echo 'error command';
	
}


function dbuser(){
	
	$query_user = "CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `username` varchar(45) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `status` tinyint(45) DEFAULT NULL,
  `created_data` datetime DEFAULT NULL,
  `idRole` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";	
	Connector::Execute($query_user);
	
	Connector::Execute("
INSERT INTO `user` (`id`, `username`, `email`, `password`, `status`, `created_data`, `idRole`) VALUES
(1, 'admin', NULL, '21232f297a57a5a743894a0e4a801fc3', 1, '2013-07-10 17:14:35', 1)
	");
	print('User Table Create');
	
	$query_role = "
CREATE TABLE IF NOT EXISTS `role` (
  `idRole` int(11) NOT NULL AUTO_INCREMENT,
  `rolename` varchar(100) NOT NULL,
  `role_context` text NOT NULL,
  `isActive` int(11) NOT NULL,
  PRIMARY KEY (`idRole`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;";


	Connector::Execute($query_role);
	Connector::Execute(	"
INSERT INTO `role` (`idRole`, `rolename`, `role_context`, `isActive`) VALUES
(NULL, 'Administrator', '*', 1);");
	print('Role Table Create');
	
	$query_view = "CREATE VIEW `user_role` AS select `u`.`id` AS `id`,`u`.`username` AS `username`,`u`.`email` AS `email`,`u`.`password` AS `password`,`u`.`status` AS `status`,`u`.`created_data` AS `created_data`,`u`.`idRole` AS `idRole`,`r`.`rolename` AS `rolename`,`r`.`role_context` AS `role_context`,`r`.`isActive` AS `isActive` from (`user` `u` join `role` `r` on((`r`.`idRole` = `u`.`idRole`)));";
	Connector::Execute($query_view);
	print('View User Role Create');
	
}