<?php
use Doctrine\Common\ClassLoader,
Doctrine\ORM\Configuration,
Doctrine\ORM\EntityManager,
Doctrine\Common\Cache\ArrayCache,
Doctrine\DBAL\Logging\EchoSQLLogger,
Doctrine\Common\Annotations\AnnotationReader,
Doctrine\ORM\Mapping\Driver\AnnotationDriver,
Doctrine\Common\Annotations\AnnotationRegistry;


class Doctrine {

  public $em = null;
  public $tool = null;

  public function __construct()
  {
    // load database configuration from CodeIgniter
    if ( ! defined('ENVIRONMENT') OR ! file_exists($file_path = APPPATH.'config/'.ENVIRONMENT.'/database.php'))
    {
        $file_path = APPPATH.'config/database.php';
    }
    require_once $file_path;

    // Set up class loading. You could use different autoloaders, provided by your favorite framework,
    // if you want to.
    // require_once APPPATH.'libraries/Doctrine/Common/ClassLoader.php';

    // $doctrineClassLoader = new ClassLoader('Doctrine',  APPPATH.'libraries');
    // $doctrineClassLoader->register();

    //model loader 
    //method 1
    // $entitiesClassLoader = new ClassLoader('models', rtrim(APPPATH, "/" ));
    // $entitiesClassLoader->register();

    //method 2
    // $loader = new ClassLoader('Doctrine', APPPATH
    //     .'third_party/doctrine-orm');
    // $loader->register();    

    // Set up models loading
    $loader = new ClassLoader('models', APPPATH);
    $loader->register();
    foreach (glob(APPPATH.'modules/*', GLOB_ONLYDIR) as $m) {
        $module = str_replace(APPPATH.'modules/', '', $m);
        $loader = new ClassLoader($module, APPPATH.'modules');
        $loader->register();
    }



    $proxiesClassLoader = new ClassLoader('Proxies', APPPATH.'models/proxies');
    $proxiesClassLoader->register();

    // Set up caches
    //method 1
    // $config = new Configuration;
    // $cache = new ArrayCache;
    // $config->setMetadataCacheImpl($cache);
    // $driverImpl = $config->newDefaultAnnotationDriver(array(APPPATH.'models/Entities'),false);
    // $config->setMetadataDriverImpl($driverImpl);
    // $config->setQueryCacheImpl($cache);

    // $config->setQueryCacheImpl($cache);

    // // Proxy configuration
    // $config->setProxyDir(APPPATH.'/models/proxies');
    // $config->setProxyNamespace('Proxies');

    // // Set up logger
    // $logger = new EchoSQLLogger;
    // $config->setSQLLogger($logger);

    // $config->setAutoGenerateProxyClasses( TRUE );
    //method 1 ends

    // method2
    // Set up caches
    $config = new Configuration;
    $cache = new ArrayCache;
    $config->setMetadataCacheImpl($cache);
    $config->setQueryCacheImpl($cache);

    // Set up driver
    $reader = new AnnotationReader($cache);
    // $reader
    // ->setDefaultAnnotationNamespace('Doctrine\ORM\Mapping\\');
    
        // Set up models
    $models = array(APPPATH.'models');
    foreach (glob(APPPATH.'modules/*/models', GLOB_ONLYDIR) as $m)
        array_push($models, $m);
    // $diver=new Doctrine\Common\Persistence\Mapping\Driver\MappingDriver($reader, $models);
    $driver = new AnnotationDriver($reader, $models);

    $config->setMetadataDriverImpl($driver);

    // Proxy configuration
    $config->setProxyDir(APPPATH.'/Proxies');
    $config->setProxyNamespace('Proxies');

    // Set up logger
    //$logger = new EchoSqlLogger;
    //$config->setSqlLogger($logger);

    $config->setAutoGenerateProxyClasses( TRUE );
    // mehthod2

    // Database connection information
    //method 2
    // $CI =& get_instance();
    // $CI->load->database();
    //     // echo $CI->db->database; 
    // $connectionOptions = array(
    //     'driver'   => 'pdo_mysql',
    //     'user'     => $CI->db->username,
    //     'password' => $CI->db->password,
    //     'host'     => $CI->db->hostname,
    //     'dbname'   => $CI->db->database
    //     );
    $connectionOptions = array(
        'driver'   => 'pdo_mysql',
        'user'     => 'root',
        'password' => '',
        'host'     => 'localhost',
        'dbname'   => 'cd_crowd_test'
        );


    // Create EntityManager
    $this->em = EntityManager::create($connectionOptions, $config);

}
}