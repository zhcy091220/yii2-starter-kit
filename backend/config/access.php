<?php
/** 权限验证笔记
 * yii\filters\AccessRule::roles: 
 *      ? 匹配未验证用户，来宾
 *      @ 匹配身份验证用户
 * yii\filters\AccessRule::ips 匹配'192.168.*'
 * yii\filters\AccessRule::verbs: 指定请求方法。例如GET、POST
 *
 * Yii::$app->authManager
 **/
return [
        'class'=>'\common\behaviors\GlobalAccessBehavior',
        'rules'=>[
           [
                'controllers'=>['sign-in'],
                'allow' => true,
                'roles' => ['?'],
                'actions'=>['login']
            ],
            [
                'controllers'=>['sign-in'],
                'allow' => true,
                'roles' => ['@'],
                'actions'=>['logout']
            ],
            [
                'controllers'=>['site'],
                'allow' => true,
                'roles' => ['?', '@'],
                'actions'=>['error']
            ],
            [
                'controllers'=>['debug/default'],
                'allow' => true,
                'roles' => ['?'],
            ],
            [
                'controllers'=>['user'],
                'allow' => true,
                'roles' => ['administrator'],
            ],
            [
                'controllers'=>['user'],
                'allow' => false,
            ],

            [
                'allow' => true,
                'roles' => ['manager','P_leader','P_director','P_teacher'],
            ],
        ]
    ];