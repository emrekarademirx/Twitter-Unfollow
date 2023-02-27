<?php

require_once('config.php');
require_once('OAuth.php');
require_once('TwitterOAuth.php');

// Create TwitterOAuth instance
$twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

// Get the list of friends
$friends = $twitter->get('friends/ids', ['count' => 200]);

// Get the list of followers
$followers = $twitter->get('followers/ids', ['count' => 200]);

// Get the list of friends that are not following back
$not_following_back = array_diff($friends->ids, $followers->ids);

// Unfollow the accounts that are not following back
$unfollowed = 0;
foreach ($not_following_back as $id) {
    $result = $twitter->post('friendships/destroy', ['user_id' => $id]);
    if ($result) {
        $unfollowed++;
    }
}

// Print the number of unfollowed accounts
echo "Unfollowed " . $unfollowed . " accounts that were not following back.";

?>
