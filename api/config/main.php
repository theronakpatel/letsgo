<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php')
   // require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'name' => 'HOI Application',
    'basePath' => dirname(__DIR__),    
    'bootstrap' => ['log'],
    'modules' => [ 
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module'
        ]
    ],
    'components' => [        
        'user' => [
            'identityClass' => 'api\modules\v2\models\User',
            'enableAutoLogin' => false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
	    'rules' => [
			['class' => 'yii\rest\UrlRule',
			  'controller' => ['v1/user','v1/login','v1/country','v1/category','v1/post','v1/promotion'],
			  'pluralize' => false,
			  'extraPatterns' => [
                    'POST testimage' => 'testimage', // 'makelogin' refers to 'actionMakelogin'
                    'POST makelogin' => 'makelogin', // 'makelogin' refers to 'actionMakelogin'
                    'POST forgotpassword' => 'forgotpassword', // 'forgotpassword' refers to 'actionForgotpassword'
                    'POST register' => 'register', // 'register' refers to 'actionRegister'
                    'POST statelist' => 'statelist', // 'register' refers to 'actionRegister'
                    'POST per-category' => 'per-category', // 'register' refers to 'actionRegister'
                    'POST per-post' => 'per-post', // 'register' refers to 'actionRegister'
                    'POST details' => 'details', // 'register' refers to 'actionRegister'
                    'GET list' => 'list' // 'logout' refers to 'actionLogout'
                ],
			],
		    ],
		]
    ],
   
   
    'params' => $params,
];



