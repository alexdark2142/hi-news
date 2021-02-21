<?php

namespace Drupal\smile_block_nodes\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Display Block
 * @package Drupal\smile_block_nodes\Plugin\Block
 *
 * @Block(
 *  id = "smile_block_nodes",
 *  admin_label = @Translation("Smile Block Nodes"),
 *)
 */

class SmileBlockNodes extends BlockBase{

  public function build() {


    $nids = \Drupal::entityQuery('node')
      ->condition('type', 'article')
      ->sort('created', 'DESC')
      ->range(0,5)
      ->execute();
    $nodes = \Drupal::entityTypeManager()
      ->getStorage('node')
      ->loadMultiple($nids);
    $result = \Drupal::entityTypeManager()
      ->getViewBuilder('node')
      ->viewMultiple($nodes, 'teaser');

    $build['#cache']['max-age'] = 0;

    foreach ($nids as $nid) {
      $build['#cache']['tags'] = ['node:'. $nid];
    }



    $build['content'] = [
      '#theme' => 'my_block_node',
      '#items' => $result,
      '#cache' => [
        'contexts' => ['user.roles'],
      ],
    ];
    return $build;
  }

}
