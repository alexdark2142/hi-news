<?php
namespace Drupal\user_menu\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Display Block
 * @package Drupal\news_block_top\Plugin\Block
 *
 * @Block(
 *  id = "user_menu",
 *  admin_label = @Translation("News user menu"),
 *)
 */

class UserMenu extends BlockBase {

  public function build()
  {
    $build['content'] = [
      '#theme' => 'user_menu',
    ];

    return $build;
  }
}
