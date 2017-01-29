<?php
declare(strict_types=1);
namespace App;

class Mail
{
	/**
	 * send
	 * Este metodo se encarga de realizar el envio de mails.
	 *
	 * @param string cuenta de correo del usuario
	 * @param array datos necesarios para el mensaje
	 * @param string contenido del mensaje
	 * @param string mensaje alternativo
	 * @return boolean retorna true si el envio del correo es exitoso de lo contrario
	 *         retorna false.
	 */
	public static function send($to = '', array $data, $subject = '', $content = '', $alt_message = '')
	{
		// Create a new PHPMailer instance
	    $mail = new \PHPMailer();

	   	$mail->CharSet = "utf-8";

	    // Set PHPMailer to use the sendmail transport
	    $mail->isSendmail();

	    // Set who the message is to be sent from
	    $mail->setFrom('thermoteam2016@gmail.com', 'ThermoBackend');

	    // Set an alternative reply-to address
	    $mail->addReplyTo('thermoteam2016@gmail.com', 'ThermoBackend');

	    // Set who the message is to be sent to
	    $mail->addAddress(trim($to), trim($data['username']));

	    // Set the subject line
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
	    $mail->AltBody = trim($alt_message);

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
							<title>Bienvenido ThermoBackend</title>
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
}
