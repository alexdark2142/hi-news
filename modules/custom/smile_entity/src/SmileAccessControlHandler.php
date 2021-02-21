<?php

namespace Drupal\smile_entity;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Url;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Access controller for the smile entity.
 */
class SmileAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   *
   * Link the activities to the permissions. checkAccess() is called with the
   * $operation as defined in the routing.yml file.
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {

    // Check the admin_permission as defined in your @ContentEntityType
    // annotation.
    $admin_permission = $this->entityType->getAdminPermission();
    //Current url.
    $current_route =  $entity->toUrl()->getRouteName();
    $current_role =  $account->getRoles();
    $entity_role = $entity->get('role')->target_id;
    if ($current_route == 'entity.smile_entity.canonical') {
      $previousUrl = \Drupal::request()->server->get('HTTP_REFERER');
      if (strpos($previousUrl, 'http://drupal.loc') === FALSE) {
        return AccessResult::forbidden();
      }
      elseif (in_array($entity_role, $current_role)) {
        return AccessResult::allowed();
      }
    }
    elseif ($account->hasPermission($admin_permission)) {
      return AccessResult::allowed();
    }

    switch ($operation) {
      case 'view':
        return AccessResult::allowedIfHasPermission($account, 'view smile entity');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit smile entity');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete smile entity');
    }


    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   *
   * Separate from the checkAccess because the entity does not yet exist. It
   * will be created during the 'add' process.
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    // Check the admin_permission as defined in your @ContentEntityType
    // annotation.
    $admin_permission = $this->entityType->getAdminPermission();
    if ($account->hasPermission($admin_permission)) {
      return AccessResult::allowed();
    }
    return AccessResult::allowedIfHasPermission($account, 'add smile entity');
  }

}
