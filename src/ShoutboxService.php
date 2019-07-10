<?php

namespace Drupal\shoutbox;
use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\shoutbox\Entity\Shout;
use Drupal\shoutbox\Entity\Shoutbox;

/**
 * Class ShoutboxService.
 */
class ShoutboxService {

  /**
   * Drupal\Core\Entity\EntityManagerInterface definition.
   *
   * @var \Drupal\Core\Entity\EntityManagerInterface
   */
  protected $entityManager;

  /**
   * Constructs a new ShoutboxService object.
   */
  public function __construct(EntityManagerInterface $entity_manager) {
    $this->entityManager = $entity_manager;
  }

  /**
   * @param \Drupal\shoutbox\Entity\Shoutbox $shoutbox
   * @param int $range
   * @param int $offset
   *
   * @return \Drupal\shoutbox\Entity\Shout[]
   */
  public function getShoutboxShouts(Shoutbox $shoutbox, $range = 20, $offset = 0) {
    $query = \Drupal::entityQuery('shout');
    $query->condition('status', 1);
    $query->condition('shoutbox', $shoutbox->id());
    $query->range($offset, $range);
    $query->sort('created', 'DESC');
    $shouts_ids = $query->execute();
    return Shout::loadMultiple($shouts_ids);
  }

}
