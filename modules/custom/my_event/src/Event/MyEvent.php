<?php

namespace Drupal\my_event\Event;

use Drupal\Core\Entity\EntityInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Event hook_node_update.
 */
class MyEvent extends Event {

  /**
   * Called during hook_node_update().
   */
  const HOOK_NODE_UPDATE = 'my_event.hook_node_update';

  public $node;

  /**
   * MyEvent constructor.
   * @param EntityInterface $node
   */

  public function __construct(EntityInterface $node) {
    $this->node = $node;
  }

  /**
   * Returns variables array from preprocess.
   */
  public function getVariables() {
    return $this->node;
  }

}
