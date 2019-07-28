<?php

// Class
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

// Validate
if ( isset( $_POST[ 'email' ] ) || array_key_exists( 'email', $_POST ) ) :

	// Message Settings
	$message = array(
		'name'			=> $_POST[ 'name' ],
		'email'			=> $_POST[ 'email' ],
		'phone'			=> $_POST[ 'phone' ],
		'subject'		=> $_POST[ 'subject' ],
		'message'		=> $_POST[ 'message' ],
		'body'			=> '',
		"alerts"		=> array(
			"error"			=> 'El mensaje no pudo ser enviado.',
			"success"		=> 'Gracias. El mensaje ha sido enviado.',
		),
	);
	
	$message[ 'body' ] .= '<b>Nombre:</b> ' . $message[ 'name' ];
	$message[ 'body' ] .= '<br><b>Email:</b> ' . $message[ 'email' ];
	$message[ 'body' ] .= '<br><b>Tlf:</b> ' . $message[ 'phone' ];
	$message[ 'body' ] .= '<br><br><b>Mensaje:</b><br>' . $message[ 'message' ];
	
	// Include
	require 'phpmailer/Exception.php';
	require 'phpmailer/PHPMailer.php';

	$mail = new PHPMailer( true );

	try {
		// Recipients
		$mail->AddReplyTo( $message[ 'email' ], $message[ 'name' ] );
		$mail->setFrom( 'admin@'. $_SERVER['SERVER_NAME'], $message[ 'name' ] );
		$mail->addAddress( $settings[ 'email' ], $settings[ 'name' ] );
		
		// Content
		$mail->isHTML( true );
		$mail->Subject = $message[ 'subject' ];
		$mail->Body    = $message[ 'body' ];
		
		// Send
		$mail->send();
		
		// Success
		echo '["success", "'. $message[ 'alerts' ][ 'success' ] .'"]';
	} catch ( Exception $e ) {
		// Error
		echo '["error", "'. $message[ 'alerts' ][ 'error' ] .'"]';
	}

endif;
