<?php

/**
 * Implements template_preprocess_HOOK().
 */
function template_preprocess_my_block_entity(&$variables) {
  $variables['my_block_entity'] = [];
  $conf = \Drupal::config('smile_entity.settings');
  $entities= $conf->get('show_entities');
  $nids = \Drupal::entityQuery('smile_entity')
    ->sort('created', 'DESC')
    ->range(0, $entities)
    ->execute();
  $nodes = \Drupal::entityTypeManager()
    ->getStorage('smile_entity')
    ->loadMultiple($nids);
  $result = \Drupal::entityTypeManager()
    ->getViewBuilder('smile_entity')
    ->viewMultiple($nodes);


  $variables['items'] = $result;
}
