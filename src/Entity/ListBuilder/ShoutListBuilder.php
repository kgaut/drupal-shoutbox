<?php

namespace Drupal\shoutbox\Entity\ListBuilder;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Shout entities.
 *
 * @ingroup shoutbox
 */
class ShoutListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Shout ID');
    $header['shoutbox'] = $this->t('Shoutbox');
    $header['author'] = $this->t('Author');
    $header['message'] = $this->t('Message');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var \Drupal\shoutbox\Entity\Shout $entity */
    $shoutbox = $entity->getShoutbox();
    $author = $entity->getOwner();
    $row['id'] = $entity->id();
    $row['shoutbox'] = Link::createFromRoute(
      $shoutbox->label(),
      'entity.shoutbox.canonical',
      ['shoutbox' => $shoutbox->id()]
    );
    $row['author'] = Link::createFromRoute(
      $author->getDisplayName(),
      'entity.user.canonical',
      ['user' => $author->id()]
    );
    $row['message'] = Link::createFromRoute(
      $entity->label(),
      'entity.shout.edit_form',
      ['shout' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
