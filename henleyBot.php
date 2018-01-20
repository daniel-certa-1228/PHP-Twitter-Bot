<?php

require "vendor/abraham/twitteroauth/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;

$consumerKey = getenv('TWITTER_CONSUMER_KEY_HB'); // Consumer Key
$consumerSecret = getenv('TWITTER_CONSUMER_SECRET_HB'); // Consumer Secret
$accessToken = getenv('TWITTER_ACCESS_TOKEN_HB'); // Access Token
$accessTokenSecret = getenv('TWITTER_ACCESS_TOKEN_SECRET_HB'); // Access Token Secret

$connection = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

$status = $connection->post("statuses/update", array("status" => "I'm posting a tweet!"));
$status_dump = var_dump($status);
print("Status is: ($status_dump)");

?>