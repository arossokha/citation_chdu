<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..',
    'name' => 'Admin panel',
    'defaultController' => 'admin',
    'controllerPath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '../controllers',
    'viewPath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '../views',
    'sourceLanguage' => 'ru',

    // preloading 'log' component
    'preload' => array('log'),

    // autoloading model and component classes
    'import' => array(
        'application.admin.models.*',
        'application.admin.components.*',
        'application.components.ActiveDataProvider',
        'application.components.ActiveRecord',
        'application.admin.components.widgets.*',
        'application.admin.controllers.*',
    ),

    // application components
    'components' => array(
        'user' => array(
            'class' => 'AdminWebUser',
            'allowAutoLogin' => true,
            'loginUrl' => '/admin/login',
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => require('rules.php'),
        ),

        'db' => require('db.php'),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => '/admin/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
                // uncomment the following to show log messages on web pages
                /*
                array(
                    'class'=>'CWebLogRoute',
                ),
                */
            ),
        ),
        'session' => array(
            'class' => 'CDbHttpSession',
            'sessionTableName' => 'AdminUserSession',
            'timeout' => 24 * 60 * 60,
            'connectionID' => 'db'
        ),

        //      'cache' => array('class' => 'CApcCache')
    ),

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'arossokha@takeforce.com',
        'provides' => "© " . date('Y') . " Powered by Group 501m. All right reserved",
        'layout' => array(
            'panelSettings' => array(
                array(
                    'name' => 'Настройки',
                    'path' => 'settings',
                    'returnUrl' => '/admin/settings',
                    'class' => 'ModelWidget',
                    'importPath' => 'application.admin.models.*',
                    'model' => array('class' => 'Settings')
                ),
                array(
                    'name' => 'Администраторы',
                    'path' => 'user',
                    'class' => 'ModelManagerWidget',
                    'importPath' => 'application.admin.models.*',
                    'model' => 'AdminUser',
                ),
                array(
                    'name' => 'Баннеры',
                    'path' => 'banner',
                    'class' => 'BannerWidget',
                    'importPath' => 'application.models.*',
                    'model' => 'Banner',
                ),
                array(
                    'name' => 'FAQ',
                    'path' => 'faq',
                    'class' => 'ModelManagerWidget',
                    'importPath' => 'application.models.*',
                    'model' => 'Faq',
                ),
                array(
                    'name' => 'Города',
                    'path' => 'city',
                    'class' => 'ModelManagerLimiterWidget',
                    'importPath' => 'application.models.*',
                    'model' => 'City',
                ),
                array(
                    'name' => 'Регионы',
                    'path' => 'region',
                    'class' => 'ModelManagerWidget',
                    'importPath' => 'application.models.*',
                    'model' => 'Region',
                ),
                array(
                    'name' => 'Страны',
                    'path' => 'country',
                    'class' => 'ModelManagerWidget',
                    'importPath' => 'application.models.*',
                    'model' => 'Country',
                ),
                array(
                    'name' => 'Сферы деятельности',
                    'path' => 'scopeofactivity',
                    'class' => 'ModelManagerWidget',
                    'importPath' => 'application.models.*',
                    'model' => 'ScopeOfActivity',
                ),
                array(
                    'name' => 'Форма собственности',
                    'path' => 'patternsofownership',
                    'class' => 'SortableModelWidget',
                    'importPath' => 'application.models.*',
                    'model' => 'PatternsOfOwnership',
                ),
                array(
                    'name' => 'Тип тары',
                    'path' => 'taretype',
                    'class' => 'ModelManagerWidget',
                    'importPath' => 'application.models.*',
                    'model' => 'TareType',
                ),
                array(
                    'name' => 'Марка ТС',
                    'path' => 'cartype',
                    'class' => 'ModelManagerWidget',
                    'importPath' => 'application.models.*',
                    'model' => 'CarType',
                ),
                array(
                    'name' => 'Тип работы',
                    'path' => 'worktype',
                    'class' => 'ModelManagerWidget',
                    'importPath' => 'application.models.*',
                    'model' => 'WorkType',
                ),
                array(
                    'name' => 'Тип загрузки',
                    'path' => 'loadtype',
                    'class' => 'ModelManagerWidget',
                    'importPath' => 'application.models.*',
                    'model' => 'LoadType',
                ),
                array(
                    'name' => 'Тип кузова',
                    'path' => 'bodytype',
                    'class' => 'ModelManagerWidget',
                    'importPath' => 'application.models.*',
                    'model' => 'BodyType',
                ),
                array(
                    'name' => 'Тип транспорта',
                    'path' => 'transportType',
                    'class' => 'ModelManagerWidget',
                    'importPath' => 'application.models.*',
                    'model' => 'TransportType',
                ),
                array(
                    'name' => 'Валюта',
                    'path' => 'currency',
                    'class' => 'ModelManagerWidget',
                    'importPath' => 'application.models.*',
                    'model' => 'Currency',
                ),

                array(
                    'name' => 'Статьи',
                    'class' => 'ModelManagerWidget',
                    'path' => 'pages',
                    'importPath' => 'application.models.*',
                    'model' => 'Page'
                ),
                array(
                    'name' => 'Новости',
                    'class' => 'ModelManagerWidget',
                    'path' => 'news',
                    'importPath' => 'application.models.*',
                    'model' => 'News'
                ),
                array(
                    'name' => 'Полезное',
                    'class' => 'ModelManagerWidget',
                    'path' => 'important',
                    'importPath' => 'application.models.*',
                    'model' => 'Important'
                ),
                array(
                    'name' => 'Отзывы',
                    'path' => 'feedback',
                    'class' => 'ModelManagerWidget',
                    'importPath' => 'application.models.*',
                    'model' => 'Feedback',
                ),
            ),
        )
    ),
);