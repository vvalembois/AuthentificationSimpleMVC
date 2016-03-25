<?php

namespace Modules\Authentifier\Helpers\AuthMail\Templates;

interface MailTemplate
{
    static public function getTemplate($data);
}