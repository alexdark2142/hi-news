<?php
/**
 * @file
 * Contains \Drupal\smile_test\Controller\Display.
 */

namespace Drupal\smile_test\Controller;

use Drupal\node\NodeInterface;

/**
 * Provides route responses for the SmileTest module.
 */
class Display {

  /**
   * Returns a simple page.
   *
   * @return array
   *   A simple renderable array.
   */
  public function content(NodeInterface $node) {
    $element = array(
      '#markup' => $node->body->value,
    );
    return $element;
  }


  /**
   * Returns a page title.
   */
  public function getTitle(NodeInterface $node) {
    return $node->getTitle();
  }

}
