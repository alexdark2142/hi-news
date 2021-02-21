<?php

namespace Drupal\smile_block\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\Annotation\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountInterface;

/**
 * Display Block
 * @package Drupal\smile_block\Plugin\Block
 *
 * @Block(
 *  id = "smile_block",
 *  admin_label = @Translation("Smile Block"),
 *)
 */

class SmileBlock extends BlockBase{

  public function build() {

    $current_time = \Drupal::time()->getCurrentTime();
    $time = 'Cьогодні ' . date('l, j F', $current_time);

    $build['time'] = [
      '#markup' => $time,
    ];
    return $build;
  }

}
