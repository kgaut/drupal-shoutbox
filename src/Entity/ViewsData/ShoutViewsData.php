<?php

namespace Drupal\shoutbox\Entity\ViewsData;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Shout entities.
 */
class ShoutViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.
    return $data;
  }

}
