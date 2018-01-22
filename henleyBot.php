<?php

    require "vendor/abraham/twitteroauth/autoload.php";
    require 'lyrics.php';
    use Abraham\TwitterOAuth\TwitterOAuth;

    $eoi_lyrics = Lyrics::$lyricsArray;//get the lyrics from the Lyrics class
    //the counter that keeps track of which line the program is on is stored in a database
    //get the database login info from env
    $dbopts = parse_url(getenv('DATABASE_URL'));
    $dbname = ltrim($dbopts["path"],'/');
    //connect to dabase
    $c = pg_connect("host=$dbopts[host] port=$dbopts[port] dbname=$dbname user=$dbopts[user] password=$dbopts[pass]")
        or die("Could not connect: " . pg_last_error());
    $query = "SELECT counter FROM counter";
    $result = pg_query($query)
        or die("Query failed: " . pg_last_error());
    $count = pg_fetch_result($result,0,0);//get the current count from the database
    // print("$count\n"); //inspect the count if necessary
    
    $consumerKey = getenv('TWITTER_CONSUMER_KEY_HB'); // Consumer Key
    $consumerSecret = getenv('TWITTER_CONSUMER_SECRET_HB'); // Consumer Secret
    $accessToken = getenv('TWITTER_ACCESS_TOKEN_HB'); // Access Token
    $accessTokenSecret = getenv('TWITTER_ACCESS_TOKEN_SECRET_HB'); // Access Token Secret
    //connect to Twitter using credentials from env
    $connection = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);
    // tweet the appropriate line
    $status = $connection->post("statuses/update", array("status" => "$eoi_lyrics[$count]"));

    var_dump($status);//print the status from twitter to the console

    $count += 1;//increment the counter
    // print("$count\n"); //inspect the incremented count if necessary
    //save the incremented count to the db or reset to zero if appropriate
    if ($count == count($eoi_lyrics)) {
        $set = pg_query("UPDATE counter SET counter = 0");
    }  else  {
        $set = pg_query("UPDATE counter SET counter = '$count'");
    };

    pg_close($c); //close the database connection

?>