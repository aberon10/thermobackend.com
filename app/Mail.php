<?php
declare(strict_types=1);
namespace App;

const HEAD = "
<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>ThermoBackend</title>
	<style>
		html {box-sizing: border-box;font-family: Verdana, sans-serif;font-size: 16px;}
		*, *::before, *::after { box-sizing: inherit;font-size: 1rem;margin: 0;padding: 0;color: #444;}
		body {background-color: #fff;	}
		h1 {font-size: 1.6rem; font-weight: 400; color: #1287A8; font-family: Verdana, sans-serif;}
		p {margin-bottom: 1rem;}
		.link {text-decoration: underline;color: #1287A8;display: block;}
		.link:hover {color: #00f0ff;}
		.header {height: 4rem; width: 100%;}
		.logo {height: 100%;width: 100%;display: flex;align-items: center;justify-content: center;text-align: center;}
		.main-container {width: 80%;margin: 1rem auto;padding: 1rem;}
		.footer {text-align: center;display: flex;justify-content: center;align-items: center;padding: 1rem;}
		.footer p {margin-bottom: 0;font-size: .8rem;}
		.signature {margin-top: 2rem;}
	</style>
</head>";

class Mail
{
	/**
	 * send
	 * @return boolean
	 */
	public static function send($to = '', array $data, $subject = '', $content = '', $alt_message = '') {
		try {
			$mail = new \PHPMailer;

			// Set mailer to use SMTP
			$mail->isSMTP();

			// Enable SMTP debugging
			// 0 = off (for production use)
			// 1 = client messages
			// 2 = client and server messages
			$mail->SMTPDebug = 0;

			//Ask for HTML-friendly debug output
			//$mail->Debugoutput = 'html';

			// Set the hostname of the mail server
			$mail->Host = getenv('SMTP_HOST');

			// TCP port to connect to
			$mail->Port = getenv('SMTP_PORT');

			// Set the encryption system to use
			$mail->SMTPSecure = 'tls';

			// Whether to use SMTP authentication
			$mail->SMTPAuth = true;

			// Username to use for SMTP authentication
			$mail->Username = getenv('SMTP_USER');

			// Password to use for SMTP authentication
			$mail->Password = getenv('SMTP_PASS');

			// Set who the message is to be sent from
			$mail->setFrom(getenv('APP_CONTACT_EMAIL'), getenv('APP_NAME'));

			// Set an alternative reply-to address
			$mail->addReplyTo(getenv('APP_CONTACT_EMAIL'), getenv('APP_NAME'));

			// Set who the message is to be sent to
			$mail->addAddress(trim($to), trim($data['username']));

			//Set the subject line
			$mail->Subject = $subject;

			// Read an HTML message body from an external file, convert referenced images to embedded,
			// convert HTML into a basic plain-text alternative body
			if (isset($content)) {
				switch ($content) {
					case 1:
						$content = self::templateWelcome($data);
						break;
					case 2:
						$content = self::templateUpdateAccount($data);
						break;
					default:
						$content = self::templateWelcome($data);
						break;
				}
				$mail->msgHTML($content);
			}

			// Replace the plain text body with one created manually
			$mail->AltBody = $alt_message;

			// send the message, check for errors
			if (!$mail->send()) {
			    return 'Mailer Error: '.$mail->ErrorInfo;
			} else {
			    return true;
			}
		} catch (\phpmailerException $e) {
			die($e->errorMessage());
		}
	}


	/**
	 * templateWelcome
	 * @param  string $data
	 * @return string $template
	 */
	public static function templateWelcome($data)
	{
		extract($data);
	    $template = "<!DOCTYPE html>
					<html lang='es'>
						<head>
							<meta charset='UTF-8'>
							<title>Bienvenido ThermoBackend</title>
							<style>
							body {color: #555; margin: 0; padding: 0;}
							.logo span {color: #1287A8;}
							.section {width: 768px; font-family: Helvetica, Arial, sans-serif; font-size: 14px; padding: 1em;}
							.header {width: 100%; background: #ececec;}
							.button {
								transition: all 0.3s ease;
								font-size: 1.1em;
								text-decoration: none;
								text-align: center;
								margin: 0;
								color: #FFF;
								background:  #1287A8;
								padding: .5em 1em;
							}
							.button:hover {
								background: #006F8E;
								color: #FFF;
							}
							h2 {margin: 0; padding: .5em; color: #555;}
							</style>
						</head>
						<body>
							<header class='header'>
								<h2 class='logo'>Thermo<span>Backend</span></h2>
							</header>
							<section class='section'>
								<p>Hola, $name!</p>
								<p>El equipo de ThermoBackend te da la Bienvenida, estamos contentos de que formes parte de nuestro equipo.</p>
								<p>Tus datos de la cuenta son: <b>Usuario</b>: $username <b>Contraseña:</b> $password <p>
								<p>Accede al siguiente link para confirmar tu cuenta
									<a href='".$url."' class='button' target='_blanck'>Confirmar cuenta</a>
								</p>
								<br>
								<p>Gracias, </p>
								<p>El equipo de ThermoBackend.</p>
								</section>
							</body>
						</html>";

	    return $template;
	}

	/**
	 * templateUpdateAccount
	 * @param  string $data
	 * @return string $template
	 */
	public static function templateUpdateAccount($data)
	{
		extract($data);
		$template = "<!DOCTYPE html>
					<html lang='es'>
						<head>
							<meta charset='UTF-8'>
							<title>Cuenta Actualizada - ThermoBackend</title>
							<style>
							body {color: #555; margin: 0; padding: 0;}
							.logo span {color: #1287A8;}
							.section {width: 768px; font-family: Helvetica, Arial, sans-serif; font-size: 14px; padding: 1em;}
							.header {width: 100%; background: #ececec;}
							h2 {margin: 0; padding: .5em; color: #555;}
							</style>
						</head>
						<body>
							<header class='header'>
								<h2 class='logo'>Thermo<span>Backend</span></h2>
							</header>
							<section class='section'>
								<p>Hola, $name!</p>
								<p>$message</p>
								<br>
								<p>Saludos, </p>
								<p>El equipo de ThermoBackend.</p>
								</section>
							</body>
						</html>";
		return $template;
	}

	/**
	 * Esta funcion se encarga de realizar el envio de mails.
	 *
	 * @param string cuenta de correo del usuario
	 * @param string nombre del usuario
	 * @param string contenido del mensaje
	 * @param string mensaje alternativo
	 * @return boolean retorna true si el envio del correo es exitoso de lo contrario
	 *      retorna false.
	 */
	public static function sendMail($to = '', $username = '', $subject = '', $content = '', $alt_message = '') {
		$mail = new \PHPMailer;

		// Set mailer to use SMTP
		$mail->isSMTP();

		// Enable SMTP debugging
		// 0 = off (for production use)
		// 1 = client messages
		// 2 = client and server messages
		$mail->SMTPDebug = 0;

		//Ask for HTML-friendly debug output
		//$mail->Debugoutput = 'html';

		// Set the hostname of the mail server
		$mail->Host = getenv('SMTP_HOST');

		// TCP port to connect to
		$mail->Port = getenv('SMTP_PORT');

		// Set the encryption system to use
		$mail->SMTPSecure = 'tls';

		// Whether to use SMTP authentication
		$mail->SMTPAuth = true;

		// Username to use for SMTP authentication
		$mail->Username = getenv('SMTP_USER');

		// Password to use for SMTP authentication
		$mail->Password = getenv('SMTP_PASS');

		// Set who the message is to be sent from
		$mail->setFrom(getenv('APP_CONTACT_EMAIL'), getenv('APP_NAME'));

		// Set an alternative reply-to address
		$mail->addReplyTo(getenv('APP_CONTACT_EMAIL'), getenv('APP_NAME'));

		// Set who the message is to be sent to
		$mail->addAddress(trim($to), trim($username));

		//Set the subject line
		$mail->Subject = $subject;

		// Read an HTML message body from an external file, convert referenced images to embedded,
		// convert HTML into a basic plain-text alternative body
		$content = HEAD . $content;

		$mail->msgHTML($content);

		// Replace the plain text body with one created manually
		$mail->AltBody = trim($alt_message);

		// $mail­->CharSet = "UTF­8";

		// $mail­->Encoding = "quoted­printable";

		// Attach an image file
		//$mail->addAttachment('images/phpmailer_mini.png');

		// Send the message, check for errors
		if (!$mail->send()) {
			// echo "Mailer Error: " . $mail->ErrorInfo;
			return false;
		} else {
			return true;
		}
	}

}
