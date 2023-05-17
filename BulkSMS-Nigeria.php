<?php
/**
 * BulkSMS Nigeria SMS Gateway
 * @author Solomon Gbeta
 */

define("BULKSMS_NIGERIA_GATEWAY", [
	"username" => "your_username", // Your bulkSMS Nigeria username
	"password" => "your_password", // Your bulkSMS Nigeria password
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
	curl_setopt($ch, CURLOPT_URL, "https://api.bulksmsnigeria.com/api/v1/sendsms");
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, [
		"username" => BULKSMS_NIGERIA_GATEWAY["username"],
		"password" => BULKSMS_NIGERIA_GATEWAY["password"],
		"to" => $phone,
		"message" => $message,
		"from" => BULKSMS_NIGERIA_GATEWAY["sender"]
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
