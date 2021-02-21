<?php

namespace Drupal\my_event\EventSubscriber;

use Drupal\my_event\Event\MyEvent;
use Drupal\Core\Logger\LoggerChannelInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ConfigEventSubscriber
 * @package Drupal\my_event\EventSubscriber
 */
class ConfigEventSubscriber implements EventSubscriberInterface {

  /**
   * @var Drupal\Core\Logger\LoggerChannelInterface
   */
  protected $logger;

  /**
   * @var Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;


  /**
   * ConfigEventSubscriber constructor.
   * @param LoggerChannelInterface $logger
   * @param AccountProxyInterface $current_user
   */

  public function __construct(LoggerChannelInterface $logger, AccountProxyInterface $current_user) {
    $this->logger = $logger;
    $this->currentUser = $current_user;
  }

  public static function getSubscribedEvents() {
    return [
      MyEvent::HOOK_NODE_UPDATE => ['nodeUpdate'],
    ];
  }



  public function nodeUpdate(MyEvent $event) {
    /** @var \Drupal\node\NodeInterface $node */
    $node = $event->node;

    $this->logger->notice('User @username changed an @node_type called @node_title!', [
      '@username' => $this->currentUser->getDisplayName(),
      '@node_title' => $node->getTitle(),
      '@node_type' =>  $node->getType(),
    ]);

  }
}
