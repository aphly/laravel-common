<?php
return [
    'perPage'=>'10',
    'id_type'=>'email',  //email || mobile
    'email_verify'=>true,
    'verify_code'=>false,
    'oauth'=>[
        'type'=>'id', //id || email
        'providers'=>[
            'facebook',
            'google',
        ]
    ]
];
