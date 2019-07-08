<?php

namespace Drupal\shoutbox\Entity\ListBuilder;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Shoutbox entities.
 *
 * @ingroup shoutbox
 */
class ShoutboxListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Shoutbox ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var \Drupal\shoutbox\Entity\Shoutbox $entity */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.shoutbox.edit_form',
      ['shoutbox' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
