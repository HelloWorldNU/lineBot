<?php

include ('vendor/autoload.php');
   
$secret = 'aeogVO99vj4QgwyUcR6QXl4OaPEnPB9izi9d9PCa';
$databaseUri = 'https://helloworld-48dff.firebaseio.com';

$firebase = Firebase::fromDatabaseUriAndSecret($databaseUri, $secret);

//$database = $firebase->getDatabase();

//$newPost = $database
//    ->getReference('blog/posts')
//    ->push([
//        'title' => 'Post title',
//        'body' => 'This should probably be longer.'
//    ]);

//$newPost->getKey(); // => -KVr5eu8gcTv7_AHb-3-
//$newPost->getUri(); // => https://my-project.firebaseio.com/blog/posts/-KVr5eu8gcTv7_AHb-3-

//$newPost->getChild('title')->set('Changed post title');
//$newPost->getValue(); // Fetches the data from the realtime database
//$newPost->remove();

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
