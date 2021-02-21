<?php

namespace Drupal\smile_entity\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Display Block
 * @package Drupal\smile_entity\Plugin\Block
 *
 * @Block(
 *  id = "smile_block_entity",
 *  admin_label = @Translation("Smile Block Entity"),
 * )
 */

class SmileBlockEntity extends BlockBase{

  public function build() {
    $build['#cache']['max-age'] = 0;

    $build['content'] = [
      '#theme' => 'my_block_entity',
      '#cache' => [
        'contexts' => ['user.roles'],
      ],
    ];
    return $build;
  }

}
