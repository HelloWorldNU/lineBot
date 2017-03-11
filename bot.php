<?php

$weatherNew = simplexml_load_file('http://data.tmd.go.th/api/WeatherWarningNews/v1/?uid=demo&ukey=demokey');
$urlWeather = 'http://api.wunderground.com/api/27b9265c9a2320fa/forecast/lang:TH/q/Thailand/'.str_replace(' ', '%20', 'พิษณุโลก').'.json';

$access_token = 'KDibenaEkXLtV0XXGj0le1FNu2PdiFiUHAsUzsGa/5GsxfTbJGbnlJ6f7TkwS1NhNnscm3GWCYnEMcKXUSp2/MqrK05xHqAjW5dylGPH1PMUU8Tl5WlFuV1DYCvVZLPrO95mv/2XprHvrtI3o8FD7QdB04t89/1O/w1cDnyilFU=';
// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			
			$text_ex = explode(':', $text);
			
			if($text_ex[0] == 'อุณหภูมิ')
			{
				$urlWeather = 'http://api.wunderground.com/api/27b9265c9a2320fa/forecast/lang:TH/q/Thailand/'.str_replace(' ', '%20', $text_ex[1]).'.json';
				$weatherGet = file_get_contents($urlWeather);
				$weatherJson = json_decode($weatherGet, true);
				$text = $weatherJson['current_observation']['temp_c'].' องศาเซลเซียส';
			}
			else if($text == 'ข่าวเตือนภัย')
			{
				$text = $weatherNew->WarningNews->TitleThai.'เพิ่มเติม '.$weatherNew->WarningNews->DocumentFile;
			}
			
			// Get replyToken
			$replyToken = $event['replyToken'];
			// Build message to reply back
			$messages = [
				'type' => 'text',
				'text' => $text
			];
			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);
			echo $result . "\r\n";
		}
	}
}
echo "OK";
echo $urlWeather;
echo $weatherNew->WarningNews->DescriptionThai;
echo $weatherNew->WarningNews->TitleThai.'\n เพิ่มเติม '.$weatherNew->WarningNews->DocumentFile;
