<?php

namespace Drupal\smile_field\Controller;
/**
 * Class CheckUrl
 * Checks for video availability on the YouTube host
 * @package Drupal\smile_field\Controller
 */
class CheckingUrlYouTube {

  function video_exists($videoURL) {
    $theURL = "http://www.youtube.com/oembed?url=$videoURL&format=json";
    $headers = get_headers($theURL);

    return (substr($headers[0], 9, 3) !== "404");
  }

}
