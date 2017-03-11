<?php

include ('line-bot.php');


<script src="https://www.gstatic.com/firebasejs/3.7.1/firebase.js"></script>
<script>
  // Initialize Firebase
  var config = {
    apiKey: "AIzaSyAuz1ICCDhvX70gjOJPoPo0fMZfiav2fqc",
    authDomain: "helloworld-48dff.firebaseapp.com",
    databaseURL: "https://helloworld-48dff.firebaseio.com",
    storageBucket: "helloworld-48dff.appspot.com",
    messagingSenderId: "391050066910"
  };
  firebase.initializeApp(config);
</script>

const DEFAULT_URL = 'https://helloworld-48dff.firebaseio.com';
const DEFAULT_TOKEN = 'AIzaSyAuz1ICCDhvX70gjOJPoPo0fMZfiav2fqc';
const DEFAULT_PATH = '/firebase/line';

$firebase = new \Firebase\FirebaseLib(DEFAULT_URL, DEFAULT_TOKEN);

// --- storing an array ---
$test = array(
    "foo" => "bar",
    "i_love" => "lamp",
    "id" => 42
);
$dateTime = new DateTime();
$firebase->set(DEFAULT_PATH . '/' . $dateTime->format('c'), $test);

// --- storing a string ---
$firebase->set(DEFAULT_PATH . '/name/contact001', "John Doe");

// --- reading the stored string ---
$name = $firebase->get(DEFAULT_PATH . '/name/contact001');

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
