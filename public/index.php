<?php

use Phalcon\Loader;
use Phalcon\Logger;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Mvc\Application;
use Phalcon\DI\FactoryDefault;
use Phalcon\Config;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Logger\Adapter\File as FileLogger;
use Phalcon\Db\Profiler as DbProfiler;

try {

    // Register an autoloader
    $loader = new Loader();
    $loader->registerDirs(array(
        '../app/controllers/',
        '../app/models/'
    ))->register();
    $loader -> registerNamespaces(
        [
            'Develop\Alipay' => '../app/alipay',
            'Develop\Controllers' => '../app/controllers',
            'Develop\Models' => '../app/models',
            'Develop\Views' => '../app/views'
        ]
    ) -> register();
    // Create a DI
    $di = new FactoryDefault();

    //Setup config
    $di -> set('config',function (){
        $configData = require '../config/config.php';
        return new Config($configData);
    });

    $di->set('profiler', function(){
        return new DbProfiler();
    }, true);

    // Setup the view component
    $di->set('view', function () {
        $view = new View();
        $view->setViewsDir('../app/views/');
        return $view;
    });

    // Setup a base URI so that all generated URIs include the "tutorial" folder
    $di->set('url', function () {
        $url = new UrlProvider();
        $url->setBaseUri('/develop/');
        return $url;
    });

//    $database = $di['config'] -> database;
    $config = $di['config'];
    $di -> set('db',function () use ($config){
        $connection = new DbAdapter([
            'host'      => $config -> database -> host,
            'username'  => $config -> database -> username,
            'password'  => $config -> database -> password,
            'dbname'    => $config -> database -> dbname,
            'charset'   => $config -> database -> charset,
        ]);

        if($config -> database -> debug){
            $eventManager = new EventsManager();
            $logger = new FileLogger($config -> logger -> dir . 'db-' . date('Ymd') . '.log');

            $eventManager -> attach('db', function ($event, $connection) use ($logger) {
                if ($event -> getType() == 'beforeQuery') {
                    $sqlVariables = $connection->getSQLVariables();
                    if (count($sqlVariables)) {
                        $logger -> log($connection -> getSQLStatement() . ' PARAMS:' . join(', ', $sqlVariables), Logger::INFO);
                    } else {
                        $logger -> log($connection -> getSQLStatement(), Logger::INFO);
                    }
                }
            });

            $connection -> setEventsManager($eventManager);
        }
        return $connection;
    });

    // Handle the request
    $application = new Application($di);

    echo $application->handle()->getContent();

} catch (\Exception $e) {
    echo "PhalconException: ", $e->getMessage();
}
