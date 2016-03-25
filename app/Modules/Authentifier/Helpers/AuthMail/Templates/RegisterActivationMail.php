<?php

namespace Modules\Authentifier\Helpers\AuthMail\Templates;

class RegisterActivationMail implements MailTemplate
{
    static public function getTemplate($data){
        return
            "<h1>Activate you account</h1>".PHP_EOL.
            "<p>Welcome to $data[title_site] $data[user_name] ! for visit the website, You need to visit this url for validate your account $data[url]</p>".PHP_EOL
        ;
    }
}