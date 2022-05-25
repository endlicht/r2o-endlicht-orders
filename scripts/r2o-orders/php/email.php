<?php
declare(strict_types=1);

/*
*    r2o-orders: The simple way to show orders from r2o API.
*    Copyright (c) 2022 Josef Müller
*
*    Please see LICENSE file for your rights under this license. */

use PHPMailer\PHPMailer\PHPMailer;

/**
 * Create email signature.
 *
 * @return string
 */
function email_signature(): string
{
    return '
<br><br>
Beste Grüße<br><br>
Dein Endlicht-Info Bot<br>
------------------------------------------<br>
<strong>Endlicht-Info Bot von Josef Müller</strong>
';
}


/**
 * Sends an email to a given address.
 *
 * @param string $email_address_to
 * @param string $subject
 * @param string $body
 *
 * @return bool
 */
function send_mail(string $email_address_to, string $subject, string $body): bool
{
    $email_address = get_env('MAIL_ADDRESS');

    $mail = new PHPMailer(TRUE);
    /* $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output. */
    $mail->isSMTP();

    /* https://stackoverflow.com/questions/2491475/phpmailer-character-encoding-issues */
    $mail->Encoding = 'base64';
    $mail->CharSet = 'UTF-8';

    $mail->SMTPAuth = TRUE;
    $mail->SMTPKeepAlive = TRUE;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer' => FALSE,
            'verify_peer_name' => FALSE,
            'allow_self_signed' => TRUE
        ]
    ];
    $mail->Host = get_env('MAIL_HOST');
    $mail->Port = get_env('MAIL_PORT');
    $mail->Username = get_env('MAIL_USERNAME');
    $mail->Password = get_env('MAIL_PASSWORD');

    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->isHTML(TRUE);

    try {
        $mail->setFrom($email_address, 'Endlicht-Info Bot');
        $mail->addAddress($email_address_to === '' ? $email_address : $email_address_to);
        $mail->send();
    } catch (\PHPMailer\PHPMailer\Exception $e) {
        return FALSE;
    }
    return TRUE;
}