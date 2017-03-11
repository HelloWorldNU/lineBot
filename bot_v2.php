<?php

include ('line-bot.php');

$channelSecret = '5a02ad4858081691fd64b0ddaad9cee8';
$access_token  = 'KDibenaEkXLtV0XXGj0le1FNu2PdiFiUHAsUzsGa/5GsxfTbJGbnlJ6f7TkwS1NhNnscm3GWCYnEMcKXUSp2/MqrK05xHqAjW5dylGPH1PMUU8Tl5WlFuV1DYCvVZLPrO95mv/2XprHvrtI3o8FD7QdB04t89/1O/w1cDnyilFU=';

$bot = new BOT_API($channelSecret, $access_token);
	
if (!empty($bot->isEvents)) {
		
	if ($bot->message->text == 'เราคือใคร')
	{
		if ($bot->source->userId == 'U7e89954991a92e09af34d7239b50386c')
		{
			$recvmsg = 'เอ็นไงจะใครละ';
		}
		else
		{
			$recvmsg = 'ไม่รู้ครับ';
		}
			
		$bot->replyMessageNew($bot->replyToken, $recvmsg);
	}
	$bot->replyMessageNew($bot->replyToken, json_encode($bot->message));
	//$bot->replyMessageNew($bot->replyToken, json_encode($bot->source));

	if ($bot->isSuccess()) {
		echo 'Succeeded!';
		exit();
	}

	// Failed
	echo $bot->response->getHTTPStatus . ' ' . $bot->response->getRawBody(); 
	exit();

}
