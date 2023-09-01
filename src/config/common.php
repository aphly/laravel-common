<?php
return [
    'perPage'=>'10',
    //注册类型
    'id_type'=>'email',  //email || mobile
    //邮件激活
    'email_verify'=>false,
    //发送邮件类型 0同步 1队列
    'email_type'=>1,
    //发送邮件队列通道 1vip 0普通
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
        'about_us'=>'/information/1',
        'terms_of_service'=>'/information/2',
        'privacy_policy'=>'/information/3',
        'contact_us'=>'/information/4',
        'refund_policy'=>'/information/5',
        'shipping'=>'/information/6',
    ],
    'statistics_appid'=>'2023080134801599',
    'email_appid'=>'2023080188980024',
    'email_secret'=>'nw30ZFKpOGjm3KwIoWcTSgbiRs6RXR3k',
];
