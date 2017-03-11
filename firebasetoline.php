<?php

include ('vendor/autoload.php');
   
$secret = 'aeogVO99vj4QgwyUcR6QXl4OaPEnPB9izi9d9PCa';
$databaseUri = 'https://helloworld-48dff.firebaseio.com';

$firebase = Firebase::fromDatabaseUriAndSecret($databaseUri, $secret);

$database = $firebase->getDatabase();

$newPost = $database
    ->getReference('blog/posts')
    ->push([
        'title' => 'Post title',
        'body' => 'This should probably be longer.'
    ]);

$newPost->getKey(); // => -KVr5eu8gcTv7_AHb-3-
echo $newPost->getKey(); 
$newPost->getUri(); // => https://my-project.firebaseio.com/blog/posts/-KVr5eu8gcTv7_AHb-3-

$newPost->getChild('title')->set('Changed post title');
$newPost->getValue(); // Fetches the data from the realtime database
$newPost->remove();
