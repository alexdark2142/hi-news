<?php

namespace Drupal\page\Controller;

class Page {

  function build() {
    $page_content = ['#markup' => 'Hello World!'];
    $build['content'] = $page_content;

    return $build;
  }
}
