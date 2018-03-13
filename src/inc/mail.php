<?php
add_action('phpmailer_init', 'setup_php_mailer');

function setup_php_mailer($phpmailer) {
    $phpmailer->isSMTP();
    $phpmailer->SMTPDebug = 0;
    $phpmailer->Host = 'smtp.gmail.com';
    $phpmailer->SMTPSecure = 'tls';
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = 587;
    $phpmailer->Username = '';
    $phpmailer->Password = '';
}