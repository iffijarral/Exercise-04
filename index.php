<?php

	/*
	* Author: Iftikhar Ahmed
	* 
	* Date: 23/05/2018
	*
	* @desc: This file is the entry point of a simple command-line tool. In this file objects of Application and a user defined CreateUserCommand classes have been...
	*		 instantiated. Then command has been added to application object. 	
	*
	* @required-namespaces: UserCommand\CreateUserCommand, Symfony\Component\Console\Application
	*
	* @required-classes: autoload.php, CreateUserCommand.php, 
	*
	
	*/

require_once('vendor/autoload.php');

require_once('CreateUserCommand.php');

use UserCommand\CreateUserCommand;

use Symfony\Component\Console\Application;

$application = new Application();

// ... register commands
$command = new CreateUserCommand();
$application->add($command);
$application->setDefaultCommand($command->getName());

$application->run();

