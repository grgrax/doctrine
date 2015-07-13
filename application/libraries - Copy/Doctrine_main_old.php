<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
use Doctrine\ORM\EntityManager,
Doctrine\ORM\Configuration,
Doctrine\ORM,
Doctrine\Common\Cache\ArrayCache,
Doctrine\OXM;

define('DEBUGGING', false);
/**
 * Doctrine
 *
 * @category Libraries
 * @package  CodeIgniter
 * @author   Tariqul Islam <tareq@webkutir.net>
 * @license  http://directory.fsf.org/wiki/License:ReciprocalPLv1.3 Reciprocal Public License v1.3
 * @link     http://webkutir.net
 */
class Doctrine
{
    public $em = null;
    /**
     * Class Constructor
     */
    public function __construct()
    {
        // load database configuration and custom config from CodeIgniter
        //method 1
        // include APPPATH . 'config/database.php';
        //mehtod 2
        if ( ! defined('ENVIRONMENT') OR ! file_exists($file_path = APPPATH.'config/'.ENVIRONMENT.'/database.php'))
        {
            $file_path = APPPATH.'config/database.php';
        }
    // load database configuration from CodeIgniter
        require_once $file_path;



        // Set up class loading.
        // include_once APPPATH . 'third_party/Doctrine/Common/ClassLoader.php';
        // $doctrineClassLoader = new \Doctrine\Common\ClassLoader('Doctrine', APPPATH . 'third_party');
        // $doctrineClassLoader->register();
        

        // Set up models loading
        //method 1        
        // $entitiesClassLoader = new \Doctrine\Common\ClassLoader('entities', APPPATH . 'models/doctrine');
        // $entitiesClassLoader->register();

        //method 2
        $loader = new \Doctrine\Common\ClassLoader('models', APPPATH);
        $loader->register();
        foreach (glob(APPPATH.'modules/*', GLOB_ONLYDIR) as $m) {
            $module = str_replace(APPPATH.'modules/', '', $m);
            $loader = new \Doctrine\Common\ClassLoader($module, APPPATH.'modules');
            $loader->register();
        }
        

        
        $proxiesClassLoader = new \Doctrine\Common\ClassLoader('proxies', APPPATH . 'cache/doctrine');
        $proxiesClassLoader->register();
        // $symfonyClassLoader = new \Doctrine\Common\ClassLoader('Symfony', APPPATH . 'third_party/Doctrine');
        // $symfonyClassLoader->register();
        // Choose caching method based on application mode (ENVIRONMENT is defined in /index.php)
        if (ENVIRONMENT == 'development' || ENVIRONMENT == 'testing') {
            $cache = new \Doctrine\Common\Cache\ArrayCache;
        } else {
            $cache = new \Doctrine\Common\Cache\ApcCache;
        }
        // Set some configuration options
        $config = new Configuration;
        // Metadata driver
        
        
        //method 1        
        // $driverImpl = $config->newDefaultAnnotationDriver(APPPATH . 'models/doctrine/entities');
        // $config->setMetadataDriverImpl($driverImpl);
        //method 2        
        $driverImpl = $config->newDefaultAnnotationDriver(APPPATH . 'modules/*/model');
        $config->setMetadataDriverImpl($driverImpl);
        
        
        // Caching
        $config->setMetadataCacheImpl($cache);
        $config->setQueryCacheImpl($cache);
        // Proxies
        $config->setProxyDir(APPPATH . 'cache/doctrine/proxies');
        $config->setProxyNamespace('Proxies');
        if (ENVIRONMENT == 'development') {
            $config->setAutoGenerateProxyClasses(true);
        } else {
            $config->setAutoGenerateProxyClasses(false);
        }
        // SQL query logger
        if (DEBUGGING) {
            $logger = new \Doctrine\DBAL\Logging\EchoSQLLogger;
            $config->setSQLLogger($logger);
        }
        // Database connection information
        if (ENVIRONMENT == 'testing') {
            $active_group = 'default_test';
        }
 
        
        //method 1
        // $connectionOptions = array(
        //     'driver'   => 'pdo_mysql',
        //     'user'     => $db[$active_group]['username'],
        //     'password' => $db[$active_group]['password'],
        //     'host'     => $db[$active_group]['hostname'],
        //     'dbname'   => $db[$active_group]['database']
        //     );
        //method 2
        $CI =& get_instance();
        $CI->load->database();
        // echo $CI->db->database; 
        $connectionOptions = array(
            'driver'   => 'pdo_mysql',
            'user'     => $CI->db->username,
            'password' => $CI->db->password,
            'host'     => $CI->db->hostname,
            'dbname'   => $CI->db->database
            );
        // Create EntityManager
        $this->em = EntityManager::create($connectionOptions, $config);
    }
}