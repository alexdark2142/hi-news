<?php
namespace Drupal\news_block_top\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Display Block
 * @package Drupal\news_block_top\Plugin\Block
 *
 * @Block(
 *  id = "news_block_top",
 *  admin_label = @Translation("News block top"),
 *)
 */

class TopNews extends BlockBase {

  public function build()
  {
    $build['content'] = [
      '#theme' => 'block_news',
    ];

    return $build;
  }
}
