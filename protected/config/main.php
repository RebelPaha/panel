<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');

return array(
    'basePath'   => dirname( __FILE__ ) . DIRECTORY_SEPARATOR . '..',
    'name'       => 'ProAdmin',
    'theme'      => 'bootstrap',
    'preload'    => array( 'log', 'settings', 'Notification' ),
    // autoloading model and component classes
    'import'     => array(
        'application.models.*',
        'application.components.*',
        'ext.yii-mail.YiiMailMessage',
        'application.extensions.EAdvancedArBehavior',
    ),
    'modules'    => array(
        // uncomment the following to enable the Gii tool
        'gii' => array(
            'class'     => 'system.gii.GiiModule',
            'generatorPaths'=>array(
                'bootstrap.gii',
            ),
            'password'  => 'pass',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array( '127.0.0.1', '::1' ),
            //'ipFilters' => array( '192.168.0.100', '::1' ),
        ),

        'auth' => array(
            'strictMode'     => true, // when enabled authorization items cannot be assigned children of the same type.
            'userClass'      => 'User', // the name of the user model class.
            'userIdColumn'   => 'id', // the name of the user id column.
            'userNameColumn' => 'username', // the name of the user name column.
            'appLayout'      => 'webroot.themes.bootstrap.views.layouts.main', // the layout used by the module.
            'viewDir'        => null, // the path to view files to use with this module.
        ),
    ),
    // application components
    'components' => array(
        'settings' => array(
            'class'        => 'Settings',
            'cache'        => 3600,
            'startupGroup' => 'general'
        ),
        'user'         => array(
            // enable cookie-based authentication
            'class'          => 'auth.components.AuthWebUser',
            'allowAutoLogin' => true,
            'loginUrl'       => array( '/user/login' ),
        ),
        // uncomment the following to enable URLs in path-format
        'urlManager'   => array(
            'urlFormat' => 'path',
            'rules'     => array(
                '<action:registration>/<hash:.+>'           => 'user/registration/<hash>',
                '<controller:\w+>/<id:\d+>'                 => '<controller>/view',
                '<controller:settings>/templates'           => 'setting/templates',
                '<controller:settings>/templates/<id:\w+>' => 'setting/templates/id/<id>',
                '<controller:settings>/<group:\w+>'         => 'setting/index/group/<group>',
                '<controller:\w+>/<action:\w+>/<id:\d+>'    => '<controller>/<action>',
                '<controller:user>/<action:\w+>/<role:\w+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>'             => '<controller>/<action>',
                '<action:(login|logout|recovery)>'          => 'user/<action>',
            ),
            'showScriptName' => false
        ),
        // uncomment the following to use a MySQL database
        'db'           => array(
//            'connectionString' => 'mysql:host=localhost;dbname=cawoon',
//            'username'         => 'root',
//            'password'         => '',
            'connectionString' => 'mysql:host=localhost;dbname=panel',
            'username'         => 'root',
            'password'         => 'mysql',
           // 'connectionString' => 'mysql:host=localhost;dbname=cawoon_panel',
           // 'username'         => 'cawoon_admin',
           // 'password'         => 'admin',
            'emulatePrepare'   => true,
            'charset'          => 'utf8',
            // включаем профайлер
//            'enableProfiling'=>true,
            // показываем значения параметров
            'enableParamLogging' => true,
        ),
 		'mail' => array(
 			'class' => 'ext.yii-mail.YiiMail',
			'transportType' => 'php',
			'viewPath' => 'application.views.mail',
			'logging' => true,
 			'dryRun' => false
 		),
        'cache' => array(
            'class' => 'system.caching.CFileCache'
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'notification' => array( 'class' => 'Notification' ),
        'VarDumper',
        'log'          => array(
            'class'  => 'CLogRouter',
            'routes' => array(
                array(
                    'class'  => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
                // uncomment the following to show log messages on web pages
                array(
                    // направляем результаты профайлинга в ProfileLogRoute (отображается
                    // внизу страницы)
                    'class'=>'CProfileLogRoute',
                    'levels'=>'profile',
                    'enabled'=>true,
                ),
                array(
                    'class'=>'CWebLogRoute',
                    'categories' => 'application',
                    'levels'=>'error, warning, trace, profile, info',
                ),
            ),
        ),
        'bootstrap'=>array(
            'class'=>'bootstrap.components.Bootstrap',
        ),
        'authManager' => array(
            'class'        => 'CDbAuthManager',
            'connectionID' => 'db',
            'defaultRoles' => array( 'user' ),
            'behaviors'    => array(
                'auth' => array(
                    'class'  => 'auth.components.AuthBehavior',
                    'admins' => array( 'boss' ), // users with full access
                ),
            ),
        ),

    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params'     => array(
        // this is used in contact page
        'adminEmail' => 'rebelpaha@gmail.com',
    ),
);