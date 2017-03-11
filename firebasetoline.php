<?php

include ('verdor/firebase-php/src/Firebase.php');

$firebase = Firebase::fromServiceAccount('helloworld-48dff-firebase-adminsdk-zpze8-0bbee8d5ef.json');
$tokenHandler = $firebase->getTokenHandler();

$uid = 'a-uid';
$claims = ['foo' => 'bar']; // optional

// Returns a Lcobucci\JWT\Token instance
$customToken = $tokenHandler->createCustomToken($uid, $claims);
echo $token; // "eyJ0eXAiOiJKV1..."

$idTokenString = $token;
// Returns a Lcobucci\JWT\Token instance
$idToken = $tokenHandler->verifyIdToken($idTokenString);

$uid = $idToken->getClaim('sub');

echo $uid; // 'a-uid'
