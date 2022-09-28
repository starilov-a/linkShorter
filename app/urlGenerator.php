<?php

function generate_string($strength = 5) {
    $input = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $input_length = strlen($input);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }

    return $random_string;
}

function urlGenerate($db, $url) {
    $urls = $db->getLinks(['long_link' => $url]);
    if(!empty($urls)) {
        return $urls[0]['short_link'];
    } else {
        $shortUrl = 'http://'.$_SERVER['HTTP_HOST']. '/' . generate_string();
        $db->addLinks($url, $shortUrl);
        return $shortUrl;
    }
}