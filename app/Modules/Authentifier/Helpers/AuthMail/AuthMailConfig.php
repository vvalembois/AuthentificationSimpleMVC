<?php

namespace Modules\Authentifier\Helpers\AuthMail;

class AuthMailConfig{
    public function __construct(){
        // Mail server
        define('MAIL_METHOD', 'smtp'); // Which method to use to send mail. Options: "mail", "sendmail", or "smtp".
        // SMTP (comment these lines if you use another method)
        define('MAIL_SMTP_SERVER', 'smtp.gmail.com');
        define('MAIL_SMTP_PORT', 465);
        define('MAIL_SMTP_SECURE','ssl');
        define('MAIL_SMTP_AUTH', true);
        define('MAIL_ACCOUNT', 'authentifiersmvc@gmail.com');
        define('MAIL_ACCOUNT_PASSWORD', 'tlscxkpenmrxdebq'); // If you use Gmail, you need to create an application password https://support.google.com/accounts/answer/185833
        // Others
        define('MAIL_SENDER',SITETITLE);
    }
}
