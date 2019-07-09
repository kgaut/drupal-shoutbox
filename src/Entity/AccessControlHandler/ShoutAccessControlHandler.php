<?php

namespace Drupal\shoutbox\Entity\AccessControlHandler;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Shout entity.
 *
 * @see \Drupal\shoutbox\Entity\Shout.
 */
class ShoutAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\shoutbox\Entity\ShoutInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished shout entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published shout entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit shout entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete shout entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add shout entities');
  }

}
