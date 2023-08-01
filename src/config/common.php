<?php
return [
    'perPage'=>'10',
    //注册类型
    'id_type'=>'email',  //email || mobile
    //邮件激活
    'email_verify'=>false,
    //发送邮件类型
    'email_type'=>1,
    //发送邮件队列通道
    'email_queue_priority'=>0,
    //快捷注册
    'oauth'=>[
        'type'=>'id', //id || email
        'providers'=>[
            'facebook',
            'google',
        ]
    ],
    'template'=>'rihoas',
    //'template'=>'blog',
    'menu'=>[
        'about_us'=>'',
        'terms_of_service'=>'',
        'privacy_policy'=>'',
        'contact_us'=>'',
        'refund_policy'=>'',
        'shipping'=>'',
    ],
    'statistics_appid'=>''
];
