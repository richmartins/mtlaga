<?php
defined('BASEPATH') OR exit("No direct script access allowed");
$config['mail'] = array(
    'protocol' => 'smtp',
    'smtp_host' => 'mail.infomaniak.com',    // My host name
    'smtp_port' => 587,
    'smtp_user' => 'no-reply@mtlaga.ch',   // My username
    'smtp_pass' => getenv('NO-REPLY_PWD'),   // My password
    'charset' => 'utf-8',
    'wordwrap' => TRUE,
    'smtp_timeout' => 30,
    'newline' => "\r\n",
    'crlf' => "\r\n",
    'mailtype' => "text"
);
