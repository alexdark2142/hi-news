<?php

namespace Drupal\unpublish_node_queue\Plugin\QueueWorker;

use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Queue\QueueWorkerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Process a queue.
 *
 * @QueueWorker(
 *   id = "unpublish_node",
 *   title = @Translation("My queue worker"),
 *   cron = {"time" = 30}
 * )
 */
class UnpublishNode extends QueueWorkerBase implements ContainerFactoryPluginInterface {

  protected $nodeStorage;

  /**
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $node_storage
   */

  public function __construct(EntityTypeManagerInterface $node_storage)
  {
    $this->nodeStorage = $node_storage->getStorage('node');
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
  {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function processItem($data) {
    // Do something with $data.
    $node = $this->nodeStorage->load($data['id']);
    $title = $node->title->value;
    return $node->set('title', $title . ' ' . $data['label'])
      ->setUnpublished()
      ->save();
  }

}
