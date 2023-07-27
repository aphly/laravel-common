<?php
return [
    'perPage'=>'10',
    //注册类型
    'id_type'=>'email',  //email || mobile
    //邮件激活
    'email_verify'=>false,
    //快捷注册
    'oauth'=>[
        'type'=>'id', //id || email
        'providers'=>[
            'facebook',
            'google',
        ]
    ],
    //'template'=>'rihoas'
    'template'=>'blog'
];
