<?php
/**
 * SMSLive247 SMS Gateway
 * @author Solomon Gbeta
 */

define("SMSLIVE247_GATEWAY", [
	"username" => "your_username", // Your smslive247 username
	"password" => "your_password", // Your smslive247 password
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
	curl_setopt($ch, CURLOPT_URL, "https://api.smslive247.com/api/v4/sms");
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, [
		"username" => SMSLIVE247_GATEWAY["username"],
		"password" => SMSLIVE247_GATEWAY["password"],
		"to" => $phone,
		"message" => $message,
		"from" => SMSLIVE247_GATEWAY["sender"]
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

function gatewayGetAccount()
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api.smslive247.com/api/v4/account");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($ch);
	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);

	if ($httpCode == 200) {
		// Account details received successfully
		return json_decode($response, true);
	} else {
		// Error getting account details
		return false;
	}
}

function gatewayGetSubaccounts()
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api.smslive247.com/api/v4/subaccounts");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($ch);
	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);

	if ($httpCode == 200) {
		// Subaccount details received successfully
		return json_decode($response, true);
	} else {
		// Error getting subaccount details
		return false;
	}
}
