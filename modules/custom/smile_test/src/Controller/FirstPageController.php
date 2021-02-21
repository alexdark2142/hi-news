<?php
/**
 * @return
 * Contains \Drupal\smile_test\Controller\FirstPageController.
 */

namespace Drupal\smile_test\Controller;

/**
 * Provides route responses for the SmileTest module.
 */
class FirstPageController {

  /**
   * Returns a simple page.
   *
   * @return array
   *   A simple renderable array.
   */
  public function content() {
    return $element = [
      '#markup' => 'Hello World!',
    ];
  }

}
