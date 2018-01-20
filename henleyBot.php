<?php

require "vendor/abraham/twitteroauth/autoload.php";
require 'lyrics.php';

use Abraham\TwitterOAuth\TwitterOAuth;

$consumerKey = getenv('TWITTER_CONSUMER_KEY_HB'); // Consumer Key
$consumerSecret = getenv('TWITTER_CONSUMER_SECRET_HB'); // Consumer Secret
$accessToken = getenv('TWITTER_ACCESS_TOKEN_HB'); // Access Token
$accessTokenSecret = getenv('TWITTER_ACCESS_TOKEN_SECRET_HB'); // Access Token Secret

$connection = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

// $status = $connection->post("statuses/update", array("status" => "I'm posting a test tweet!"));
// var_dump($status);
$eoi_lyrics = Lyrics::$lyricsArray;
var_dump($eoi_lyrics[0]);

?>