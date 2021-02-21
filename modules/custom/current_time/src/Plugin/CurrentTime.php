<?php

namespace Drupal\current_time\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Display Block
 * @package Drupal\current_time\Plugin\Block
 *
 * @Block(
 *  id = "time_block",
 *  admin_label = @Translation("Current time Block"),
 *)
 */

class CurrentTime extends BlockBase{

  public function build() {

    $current_time = \Drupal::time()->getCurrentTime();
    $time = 'Cьогодні ' . date('l, j F', $current_time);

    $build['time'] = [
      '#markup' => $time,
    ];
    return $build;
  }

}
