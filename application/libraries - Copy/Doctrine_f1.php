<?php 


use Doctrine\Common\ClassLoader,
    Doctrine\ORM\Configuration,
    Doctrine\ORM\EntityManager,
    Doctrine\Common\Cache\ArrayCache,
    Doctrine\Common\Annotations\AnnotationReader,
    Doctrine\ORM\Mapping\Driver\AnnotationDriver,
    Doctrine\DBAL\Logging\EchoSqlLogger,
    Doctrine\DBAL\Event\Listeners\MysqlSessionInit,
    Doctrine\ORM\Tools\SchemaTool,
    Doctrine\Common\EventManager,
    Gedmo\Timestampable\TimestampableListener,
    Gedmo\Sluggable\SluggableListener,
    Gedmo\Tree\TreeListener,
    Gedmo\SoftDeleteable\SoftDeleteableListener,
    Gedmo\Loggable\LoggableListener;
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Doctrine {

 /**
 * 
 * @var Doctrine\ORM\EntityManager
 */ 
  public $em = null;
  
  /**
   * 
   * @var Doctrine\ORM\Tools\SchemaTool
   */
  public $tool = null;
  
  
  /**
   * 
   * @var AuditManager
   */
  public $am = NULL;
  
  /**
   * 
   * @var AuditReader
   */
  public $ar = NULL;

  public function __construct()
  {
    // load database configuration from CodeIgniter
    if (defined('ENVIRONMENT') AND file_exists(APPPATH.'config/'.ENVIRONMENT.'/database'.EXT))
    {
        require(APPPATH.'config/'.ENVIRONMENT.'/database'.EXT);
    }
    else
    {
        require(APPPATH.'config/database'.EXT);
    }
    
    if (defined('ENVIRONMENT') AND file_exists(APPPATH.'config/'.ENVIRONMENT.'/doctrine'.EXT))
    {
        require(APPPATH.'config/'.ENVIRONMENT.'/doctrine'.EXT);
    }
    else
    {
        require(APPPATH.'config/doctrine'.EXT);
    }
    
    if ( ! isset($active_group) OR ! isset($db[$active_group]))
    {
        show_error('You have specified an invalid database connection group.');
    }

    // audit configuration

    // $auditconfig = new AuditConfiguration();
    // $auditconfig->setAuditedEntityClasses(array(

    // ));

    // $evm = new EventManager();
    // $auditManager = new AuditManager($auditconfig);
    // $auditManager->registerEvents($evm);


    
    
    
    // Set up models loading
    $entitiesClassLoader = new ClassLoader('models', APPPATH);
    $entitiesClassLoader->register();

    $entitiesClassLoader = new ClassLoader('models/ca', APPPATH);
    $entitiesClassLoader->register();
    

    //cache models directory and models namespaces
    $entityNamespaces = array('models');
    $entityPaths = array(APPPATH.'models/');
    
    foreach (glob(APPPATH.'modules/*', GLOB_ONLYDIR) as $m) {
        $module = str_replace(APPPATH.'modules/', '', $m);
        $entitiesClassLoader = new ClassLoader($module, APPPATH.'modules');
        $entitiesClassLoader->register();
        
        if(is_dir(APPPATH.'modules/'.$module.'/models')){
            $entityNamespaces[] = $module."\models";
            $entityPaths[] = APPPATH.'modules/'.$module.'/models/';
        }
            
    }

    $proxiesClassLoader = new ClassLoader('Proxies', APPPATH.'models/proxies');
    $proxiesClassLoader->register();

    // ensure standard doctrine annotations are registered
    Doctrine\Common\Annotations\AnnotationRegistry::registerFile(
        './vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php'
    );
    

    
    // Set up caches
    $cache = new Doctrine\Common\Cache\ArrayCache;
    
    $annotationReader = new Doctrine\Common\Annotations\AnnotationReader;
    $cachedAnnotationReader = new Doctrine\Common\Annotations\CachedReader(
            $annotationReader, // use reader
            $cache // and a cache driver
    );
    
    // create a driver chain for metadata reading
    $driverChain = new Doctrine\ORM\Mapping\Driver\DriverChain();
    
    // load superclass metadata mapping only, into driver chain
    // also registers Gedmo annotations.NOTE: you can personalize it
    Gedmo\DoctrineExtensions::registerAbstractMappingIntoDriverChainORM(
            $driverChain, // our metadata driver chain, to hook into
            $cachedAnnotationReader // our cached annotation reader
    );
    
    // now we want to register our application entities,
   // for that we need another metadata driver used for Entity namespace
    $annotationDriver = new Doctrine\ORM\Mapping\Driver\AnnotationDriver(
        $cachedAnnotationReader, // our cached annotation reader
        $entityPaths // paths to look in
    );
    
    // NOTE: driver for application Entity can be different, Yaml, Xml or whatever
    // register annotation driver for our application Entity namespace
    foreach ( $entityNamespaces as $entityNamespace ){
        $driverChain->addDriver($annotationDriver, $entityNamespace);
    }
        
    
    
//  $logger = new TBSQLLogger();
    
    // general ORM configuration
    $config = new Doctrine\ORM\Configuration;
    $config->setProxyDir(APPPATH.'models/proxies');
    $config->setProxyNamespace('Proxies');
    $config->setAutoGenerateProxyClasses($doctrine['regenerate_proxies']); // this can be based on production config.
    // register metadata driver
    $config->setMetadataDriverImpl($driverChain);
    // use our allready initialized cache driver
    $config->setMetadataCacheImpl($cache);
    $config->setQueryCacheImpl($cache);
    
    if(ENVIRONMENT == 'development'){        
/*        $logger = new \Doctrine\DBAL\Logging\Profiler();
        
        $config->setSQLLogger($logger);
*/    }

//  $config->setSQLLogger($logger);
    
    // Third, create event manager and hook prefered extension listeners
    $evm = new Doctrine\Common\EventManager();


    //audit configuration
    
    $auditconfig = new AuditConfiguration();
    $auditconfig->setAuditedEntityClasses(array(
        'models\ca\General',
    ));

    $auditManager = new AuditManager($auditconfig);
    $auditManager->registerEvents($evm);
    // end of audotconfig


    // gedmo extension listeners

    // sluggable
    $sluggableListener = new Gedmo\Sluggable\SluggableListener;
    // you should set the used annotation reader to listener, to avoid creating new one for mapping drivers
    $sluggableListener->setAnnotationReader($cachedAnnotationReader);
    $evm->addEventSubscriber($sluggableListener);
    
    //loggable
    $loggableListener = new Gedmo\Loggable\LoggableListener;
    //$loggableListener = new F1softLoggableListener();
    $loggableListener->setAnnotationReader($cachedAnnotationReader);
    $evm->addEventSubscriber($loggableListener);
    
    
    // timestampable
    $timestampableListener = new Gedmo\Timestampable\TimestampableListener;
    $timestampableListener->setAnnotationReader($cachedAnnotationReader);
    $evm->addEventSubscriber($timestampableListener);
    
    //setup soft delete filter
    $config->addFilter('soft-deleteable', 'Gedmo\SoftDeleteable\Filter\SoftDeleteableFilter');
    
    $config->addFilter('f1soft-pagent', 'Transborder\DoctrineExtensions\Filters\PAgentFilter');
    
     
    // Database connection information
    $connectionOptions = array(
        'driver'    => $doctrine['db_driver'],
        'user'      => $db[$active_group]['username'],
        'password'  => $db[$active_group]['password'],
        'host'      => $db[$active_group]['hostname'],
        'dbname'    => $db[$active_group]['database']
    );

    // Create EntityManager
    $this->em = EntityManager::create($connectionOptions, $config,$evm);
    
//     $this->em->getFilters()->enable('soft-deleteable');
//     $this->em->getFilters()->enable('f1soft-pagent');

    // Schema Tool
    $this->tool = new SchemaTool($this->em);
  }
}