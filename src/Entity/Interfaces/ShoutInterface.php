<?php

namespace Drupal\shoutbox\Entity\Interfaces;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Shout entities.
 *
 * @ingroup shoutbox
 */
interface ShoutInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface {

  /**
   * Gets the Shout creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Shout.
   */
  public function getCreatedTime();

  /**
   * Sets the Shout creation timestamp.
   *
   * @param int $timestamp
   *   The Shout creation timestamp.
   *
   * @return \Drupal\shoutbox\Entity\ShoutInterface
   *   The called Shout entity.
   */
  public function setCreatedTime($timestamp);


}
