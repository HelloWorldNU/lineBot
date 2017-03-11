<?php

include ('line-bot.php');

$channelSecret = 'U7e89954991a92e09af34d7239b50386c';
$access_token  = 'dC08L00nDwAwasGu2gNqqyAJ6RvWUVoZFx8msUwBiIxQrvbg7VKypVZAO5WHaMGFfg85FL9YVl7UsVzbdndaZpJGDSRycm3wvQibZcp9UuPwAFGFh5icr0cVdbY5/44VS6vVdv2A4uDolwgN3+Z9bgdB04t89/1O/w1cDnyilFU=';

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
