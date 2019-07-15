<?php

namespace Drupal\shoutbox\Entity\AccessControlHandler;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Shoutbox entity.
 *
 * @see \Drupal\shoutbox\Entity\Shoutbox.
 */
class ShoutboxAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\shoutbox\Entity\Shoutbox $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'administer shoutbox');
        }
        return AccessResult::allowedIfHasPermission($account, 'view shoutbox');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'administer shoutbox');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'administer shoutbox');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'administer shoutbox');
  }

}
