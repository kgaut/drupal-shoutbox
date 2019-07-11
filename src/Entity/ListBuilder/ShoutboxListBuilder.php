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
    $header['id'] = $this->t('ID');
    $header['name'] = $this->t('Name');
    $header['shouts'] = $this->t('Messages');
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
      'entity.shoutbox.canonical',
      ['shoutbox' => $entity->id()]
    );
    $row['shouts'] = \Drupal::service('shoutbox.service')->getShoutboxNumberOfShouts($entity);
    return $row + parent::buildRow($entity);
  }

}
