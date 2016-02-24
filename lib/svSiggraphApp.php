<?php
date_default_timezone_set("America/Los_Angeles");
session_start();
define('ROOT_DIR', __DIR__ . '/../');
require_once __DIR__ . '/ClassLoader.php';

$classloader = new ClassLoader();

use Component\Server\Core;
use Component\Persist\EntityManager;
use Component\Template\SmartyView;
use Component\Utility\StringTable;
use Component\Config\Parameters;
use Component\Utility\Logger;
use Component\Server\Request;

class svSiggraphApp
{
	private $parameters;
	private $pdo;
	private $entityManager;
	private $logger;
	private $view;
	private $stable;
	
	public $kernel;
	
	private static $instance = null;
	
	private function __construct($configFile)
	{
		/**
		 * Get application parameters
		 */
		$this->parameters = new Parameters(ROOT_DIR . 'conf/' . $configFile);
		
		/**
		 * Setting up database connection
		 */
		
		$this->pdo = new PDO("mysql:host=" . $this->parameters->getParameter('database.host') . ";" .
						"dbname=" . $this->parameters->getParameter('database.name') . ";" .
						$this->parameters->getParameter('database.socket'),
						$this->parameters->getParameter('database.user'),
						$this->parameters->getParameter('database.pass'));
		
		$this->entityManager = new EntityManager($this->pdo);
		
		/**
		 * Setting up smarty view engine
		 */
		
		require_once ROOT_DIR . 'vendor/smarty/libs/Smarty.class.php';
		
		$this->engine = new Smarty();
		$this->engine->template_dir 	= ROOT_DIR . $this->parameters->getParameter('template.smarty_dir');
		$this->engine->compile_dir 	= ROOT_DIR . $this->parameters->getParameter('template.compile_dir');
		$this->engine->config_dir 	= ROOT_DIR . $this->parameters->getParameter('template.config_dir');
		$this->engine->cached_dir 	= ROOT_DIR . $this->parameters->getParameter('template.cache_dir');
		
		$this->engine->configLoad(ROOT_DIR . $this->parameters->getParameter('template.smarty_config'));
		$this->engine->addPluginsDir(ROOT_DIR . 'lib/Component/Template/plugins');
		
		if ($this->parameters->getParameter('kernel.debug'))
		{
			$this->engine->caching = 0;
		}
				
		$this->view = new SmartyView($this->engine);
		
		/**
		 * Set up StringTable for translations
		 */
		$this->stable = new StringTable(ROOT_DIR . $this->parameters->getParameter('messages.file'));
		
		/**
		 * Setup logging
		 */
		
		$this->logger = new Logger(ROOT_DIR . $this->parameters->getParameter('logger.file'), 
			$this->parameters->getParameters('kernel.debug'));
		
		/** Initialize framework
		 */
		$this->kernel = new Core($this->entityManager, $this->view);
		$this->kernel->register('logger', $this->logger);
		$this->kernel->register('message', $this->stable);
		$this->kernel->loadParameters($this->parameters);
	}
	public static function loadApplicationSettings($configFile)
	{
		if (self::$instance)
			return self::$instance;
		
		self::$instance = new svSiggraphApp($configFile);
		return self::$instance;
	}
	public static function getInstance()
	{
		return self::$instance;
	}
	public function execute($defaultController = null, $defaultAction = null)
	{
		if (!$this->kernel)
			exit();
		
		try 
		{
			if (isset($defaultController) && isset($defaultAction))
				$_REQUEST['action'] = $defaultController . '/' . $defaultAction;
				
			$request = new Request($_REQUEST, $_SESSION, $_SERVER);
			$response = $this->kernel->dispatch($request);
			$response->send();
		}
		catch (Exception $e)
		{
			$this->logger->log('Application', 'FATAL', 'Application terminated unexpectedly: ' . $e);
			if ($this->kernel->debug)
				print $e;
		}
	}
	public static function printError($errno, $errstr, $errfile, $errline) 
	{
		print 'error encountered at ' . $errfile . ' line ' . $errline . ': ' . $errstr;
		flush();
	}
}

?>
