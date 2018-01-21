<?php

    require "vendor/abraham/twitteroauth/autoload.php";
    require 'lyrics.php';

    use Abraham\TwitterOAuth\TwitterOAuth;

    $eoi_lyrics = Lyrics::$lyricsArray;//get the lyrics from the Lyrics class

    //connect to dabase
    $c = pg_connect("dbname=eoi_counter")
        or die("Could not connect: " . pg_last_error());
    $query = "SELECT counter FROM counter";
    $result = pg_query($query)
        or die("Query failed: " . pg_last_error());
    $count = pg_fetch_result($result,0,0);//get the current count from the database

    // print("$count\n");

    $consumerKey = getenv('TWITTER_CONSUMER_KEY_HB'); // Consumer Key
    $consumerSecret = getenv('TWITTER_CONSUMER_SECRET_HB'); // Consumer Secret
    $accessToken = getenv('TWITTER_ACCESS_TOKEN_HB'); // Access Token
    $accessTokenSecret = getenv('TWITTER_ACCESS_TOKEN_SECRET_HB'); // Access Token Secret

    $connection = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

    $status = $connection->post("statuses/update", array("status" => "$eoi_lyrics[$count]"));

    var_dump($status);//print the status from twitter to the console

    $count += 1;//increment the counter

    // print("$count\n");

    if ($count == count($eoi_lyrics)) {
        $set = pg_query("UPDATE counter SET counter = 0");
    }  else  {
        $set = pg_query("UPDATE counter SET counter = '$count'");
    };

    pg_close($c); //close the database connection

?>