<?php

namespace Aphly\LaravelCommon\Models;

use Aphly\Laravel\Mail\MailSend;

class RemoteEmail
{
    function send($input){
        $MailSend = new MailSend();
        $MailSend->appid = config('common.email_appid');
        $MailSend->secret = config('common.email_secret');
        return $MailSend->remote($input);
    }
}
