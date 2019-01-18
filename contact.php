<?php
/**
 * EDIT THE VALUES BELOW THIS LINE TO ADJUST THE CONFIGURATION
 * EACH OPTION HAS A COMMENT ABOVE IT WITH A DESCRIPTION
 */
/**
 * Specify the email address to which all mail messages are sent.
 * The script will try to use PHP's mail() function,
 * so if it is not properly configured it will fail silently (no error).
 */
$mailTo     = 'info@ipisdosaj.edu.do';
// $mailTo     = 'email@example.com';

/**
 * Set the message that will be shown on success
 */
$successMsg = '¡Gracias, tu mensaje ha sido enviado!';

/**
 * Set the message that will be shown if not all fields are filled
 */
$fillMsg    = '¡Por favor llena todos los espacios!';

/**
 * Set the message that will be shown on error
 */
$errorMsg   = '¡Tu mensaje no pudo ser entregado, inténtalo de nuevo!';

/**
 * DO NOT EDIT ANYTHING BELOW THIS LINE, UNLESS YOU'RE SURE WHAT YOU'RE DOING
 */

?>
<?php
if(
    !isset($_POST['contact-name']) ||	
	!isset($_POST['contact-email']) ||
	!isset($_POST['contact-message']) ||
    empty($_POST['contact-name']) ||
    empty($_POST['contact-email']) ||
	empty($_POST['contact-message'])
	
) {
	
	if( empty($_POST['contact-name']) && empty($_POST['contact-email']) && empty($_POST['contact-message']) ) {
		$json_arr = array( "type" => "error", "msg" => $fillMsg );
		echo json_encode( $json_arr );		
	} else {

		$fields = "";
		if( !isset( $_POST['contact-name'] ) || empty( $_POST['contact-name'] ) ) {
			$fields .= "Name";
		}		
		
		if( !isset( $_POST['contact-email'] ) || empty( $_POST['contact-email'] ) ) {
			if( $fields == "" ) {
				$fields .= "Email";
			} else {
				$fields .= ", Email";
			}
		}	
		
		if( !isset( $_POST['contact-message'] ) || empty( $_POST['contact-message'] ) ) {
			if( $fields == "" ) {
				$fields .= "Message";
			} else {
				$fields .= ", Message";
			}		
		}	
		$json_arr = array( "type" => "error", "msg" => "Please fill ".$fields." fields!" );
		echo json_encode( $json_arr );
		
	}
	

} else {

	// Validate e-mail
	if (!filter_var($_POST['contact-email'], FILTER_VALIDATE_EMAIL) === false) {
		
		$msg = "Name: ".$_POST['contact-name']."\r\n";			
		$msg .= "Email: ".$_POST['contact-email']."\r\n";	
		$msg .= "Message: ".$_POST['contact-message']."\r\n";
		
		$success = @mail($mailTo, $_POST['contact-email'], $msg, 'From: ' . $_POST['contact-name'] . '<' . $_POST['contact-email'] . '>');
		
		if ($success) {
			$json_arr = array( "type" => "success", "msg" => $successMsg );
			echo json_encode( $json_arr );
		} else {
			$json_arr = array( "type" => "error", "msg" => $errorMsg );
			echo json_encode( $json_arr );
		}
		
	} else {
 		$json_arr = array( "type" => "error", "msg" => "Por favor introduzca una dirección válida!" );
		echo json_encode( $json_arr );	
	}

}