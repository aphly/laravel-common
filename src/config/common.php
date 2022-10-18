<?php
return [
    'perPage'=>'10',
    'id_type'=>'email',  //email || mobile
    'email_verify'=>false,
    'oauth'=>[
        'type'=>'id', //id || email
        'providers'=>[
            'facebook',
            'google',
        ]
    ]
];
