<?php
add_action('admin_post_submit_contact_form', 'submit_contact_form');
add_action('admin_post_nopriv_submit_contact_form', 'submit_contact_form');

function submit_contact_form() {
    if ($_POST['blah']) {
        header('Location: /contact-us');
        return;
    }

    $to = 'info@hipurefiltration.com';
    $subject = 'Contact Form Submission';
    $body = 'The following was submitted via HiPure Filtration Contact form' . "\r\n";
    $body .= 'Name: ' . $_POST['name'] . "\r\n";
    $body .= 'Email: ' . $_POST['email'] . "\r\n";
    $body .= 'Phone: ' . $_POST['phone'] . "\r\n";
    $body .= 'Message: ' . "\r\n" . $_POST['comment'];

    $headers = 'From: ' . $_POST['email'] . "\r\n";

    $result = wp_mail($to, $subject, $body, $headers);
    header('Location: /contact-us?sent=' . ($result ? 'true' : 'false'));
}