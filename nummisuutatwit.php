<?php
  // this from https://github.com/abraham/twitteroauth/
  require_once('twitteroauth/twitteroauth.php');
  // these from https://dev.twitter.com/
  // create new app and from OAuth settings
  // Consumer key
  // Consumer secret
  define('CONSUMER_KEY', 'KEY');
  define('CONSUMER_SECRET', 'SECRET');
  // same place below that
  // Your access token
  // Access token
  // Access token secret
  $oauth_token = "OKTNE";
  $oauth_token_secret = "SCRETE";

  $something_sent = false;

  // utf-8 format file to tweet
  $fname = "file_from_gutenberg.txt";

  $c = file_get_contents($fname);
// find something to tweet
  $tweet = substr($c, 0, 140);
  if(strlen($tweet) == 140){
    $pos1 = strrpos($tweet, ",");
    $pos2 = strrpos($tweet, ".");
    $pos3 = strrpos($tweet, "!");
    $pos4 = strrpos($tweet, "?");
    $pos5 = strrpos($tweet, ";");
    $cut = max($pos1, $pos2, $pos3, $pos4, $pos5);
    if($cut < 50){
      $cut = strrpos($tweet, " ");
    }

    $tweet = trim(substr($tweet,0,$cut+1));
    $c = trim(substr($c, strlen($tweet)+1));
  } else {
    $c = "";
  }
  // put the rest back for next round
  file_put_contents($fname, $c);

  // do the magic
  if(!empty($tweet)){
    // clean up the tweet
    $rowbreak = chr(13)."\n";
    $tweet = str_replace($rowbreak.$rowbreak, "DOUBLENEWLINE", $tweet);
    $tweet = str_replace($rowbreak, " ", $tweet);
    $tweet = str_replace("DOUBLENEWLINE", "\n\n", $tweet);
    // make a connection and tweet
    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);
    $params = array('status' => $tweet);
    $response = $connection->post('statuses/update', $params);
  }
  
