<?php

namespace Drupal\shoutbox\Entity\Interfaces;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Shoutbox entities.
 *
 * @ingroup shoutbox
 */
interface ShoutboxInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Shoutbox name.
   *
   * @return string
   *   Name of the Shoutbox.
   */
  public function getName();

  /**
   * Sets the Shoutbox name.
   *
   * @param string $name
   *   The Shoutbox name.
   *
   * @return \Drupal\shoutbox\Entity\ShoutboxInterface
   *   The called Shoutbox entity.
   */
  public function setName($name);

  /**
   * Gets the Shoutbox creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Shoutbox.
   */
  public function getCreatedTime();

  /**
   * Sets the Shoutbox creation timestamp.
   *
   * @param int $timestamp
   *   The Shoutbox creation timestamp.
   *
   * @return \Drupal\shoutbox\Entity\ShoutboxInterface
   *   The called Shoutbox entity.
   */
  public function setCreatedTime($timestamp);


}
