<?php
defined('BASEPATH') OR exit("No direct script access allowed");
$config['mail'] = array(
    'protocol' => 'smtp',
    'smtp_host' => getenv('MAIL_SERVER'),    // My host name
    'smtp_port' => getenv('MAIL_SERVER_PORT'),
    'smtp_user' => getenv('NO_REPLY_MAIL'),   // My username
    'smtp_pass' => getenv('NO_REPLY_PWD'),   // My password
    'charset' => 'utf-8',
    'wordwrap' => TRUE,
    'smtp_timeout' => 30,
    'newline' => "\r\n",
    'crlf' => "\r\n",
    'mailtype' => "text"
);
