<?php
// ✅ Your Access Token
$access_token = 'EAAUeqZBKdMeUBPKhMYtiZCreTRrFvghLtQy8ZCpZCrnc4h2Gy7otojZA84MAO31B4ZBsJwTXiDvBzB7PZABX1bBWaLgpfeyq8Dxp5LroZCvKgnafajkQwa7LAys0R0YTlYTWeaZCk09qTsBVrcRPo82wzXAJXUqRpEaHN8jIljhY4KG8fGQtwDbIQFZBllWlpOBgDD0ncvtJqB1GaeNvH1LTHQ24Sb3dxFV2I2IvYkkgBp3yDTmP9vOoRH7oCRCuuH4pQZD';

// ✅ Your WhatsApp Phone Number ID (from Meta App Setup)
$phone_number_id = '737583066094746';

// ✅ Recipient WhatsApp number (must start with country code)
$to = '919673839167'; // +91 96738 39167

// ✅ API endpoint
$url = "https://graph.facebook.com/v18.0/$phone_number_id/messages";

// ✅ Message data
$data = [
    'messaging_product' => 'whatsapp',
    'to' => $to,
    'type' => 'text',
    'text' => [
        'body' => 'Thank you! Please visit again.'
    ]
];

// ✅ Headers
$headers = [
    "Authorization: Bearer $access_token",
    "Content-Type: application/json"
];

// ✅ cURL request
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// ✅ Execute and get response
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// ✅ Output result
echo "WhatsApp API Response (HTTP Code: $http_code):<br>";
echo "<pre>";
print_r(json_decode($response, true));
echo "</pre>";
?>
