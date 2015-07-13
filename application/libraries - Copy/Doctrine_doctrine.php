<?php

use \Doctrine\ORM\Tools\Setup;
use \Doctrine\ORM\EntityManager;

class Doctrine{

	public $em = null;

	function __constructor(){
		// $paths = array("/path/to/entity-files");
		// $paths = array("/modules/*/models");


		$loader = new \Doctrine\Common\ClassLoader('models', APPPATH);
		$loader->register();
		foreach (glob(APPPATH.'modules/*', GLOB_ONLYDIR) as $m) {
			$module = str_replace(APPPATH.'modules/', '', $m);
			$loader = new \Doctrine\Common\ClassLoader($module, APPPATH.'modules');
			$loader->register();
		}
		$driverImpl = $config->newDefaultAnnotationDriver(APPPATH . 'modules/*/models');
		$config->setMetadataDriverImpl($driverImpl);


		$isDevMode = false;

		// the connection configuration
		$dbParams = array(
			'driver'   => 'pdo_mysql',
			'user'     => 'root',
			'password' => '',
			'dbname'   => 'foo',
			);

		$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
		$em = EntityManager::create($dbParams, $config);
	}	
}
