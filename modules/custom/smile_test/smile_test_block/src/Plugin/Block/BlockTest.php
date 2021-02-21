<?php

namespace Drupal\smile_test_block\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountInterface;

/**
 * Display Block
 * @package Drupal\smile_test_block\Plugin\Block
 *
 * @Block(
 *  id = "simple_block_test",
 *  admin_label = @Translation("Simple Block Test"),
 *)
 */

class BlockTest extends BlockBase{

  /**
   * @return string[]
   */
  public function build() {
    return [
      '#type' => 'markup',
      '#markup' => 'This is custom block!',
    ];
  }

}
