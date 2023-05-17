<?php
/**
 * Africas Talking SMS Gateway
 * @author Solonon Gbeta
 */

define("AFRICAS_TALKING_GATEWAY", [
	"username" => "your_username", // Your Africas Talking username
	"api_key" => "your_api_key", // Your Africas Talking api key
	"sender" => "My Zender" // Sender Name
]);

function gatewaySend($phone, $message, &$system)
{
	/**
	 * Implement sending here
	 * @return bool:true
	 * @return bool:false
	 */

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api.africastalking.com/sendsms");
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, [
		"username" => AFRICAS_TALKING_GATEWAY["username"],
		"api_key" => AFRICAS_TALKING_GATEWAY["api_key"],
		"to" => $phone,
		"message" => $message,
		"from" => AFRICAS_TALKING_GATEWAY["sender"]
	]);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($ch);
	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);

	if ($httpCode == 200) {
		// Message sent successfully
		return true;
	} else {
		// Error sending message
		$system = $response;
		return false;
	}
}

function gatewayCallback($request, &$system)
{
	/**
	 * Implement status callback here if gateway supports it
	 * @return array:MessageID
	 * @return array:Empty
	 */
}
