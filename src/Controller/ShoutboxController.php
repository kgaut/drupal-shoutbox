<?php

namespace Drupal\shoutbox\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Render\Renderer;
use Drupal\shoutbox\Entity\Shoutbox;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\shoutbox\ShoutboxService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ShoutboxController.
 */
class ShoutboxController extends ControllerBase {

  /**
   * Drupal\shoutbox\ShoutboxService definition.
   *
   * @var \Drupal\shoutbox\ShoutboxService
   */
  protected $shoutboxService;

  /**
   * Drupal\Core\Entity\EntityTypeManager definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;

  /**
   * Drupal\Core\Render\Renderer definition.
   *
   * @var \Drupal\Core\Render\Renderer
   */
  protected $renderer;


  /**
   * Constructs a new ShoutboxController object.
   */
  public function __construct(ShoutboxService $shoutbox_service, EntityTypeManager $entityTypeManager, Renderer $rendered) {
    $this->shoutboxService = $shoutbox_service;
    $this->entityTypeManager = $entityTypeManager;
    $this->renderer = $rendered;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('shoutbox.service'),
      $container->get('entity_type.manager'),
      $container->get('renderer')
    );
  }

  public function loadShouts(Shoutbox $shoutbox, $range = 20, $offset = 0) {
    $shouts = $this->shoutboxService->getShoutboxShouts($shoutbox, $range, $offset);
    $data = [
      'shouts' => [],
      'has_mode_shouts' => $this->shoutboxService->getShoutboxNumberOfShouts($shoutbox) > $offset + $range,
    ];
    $viewBuilder = $this->entityTypeManager->getViewBuilder('shout');
    foreach ($shouts as $shout) {
      $shoutArray =  $viewBuilder->view($shout);
      $data['shouts'][] = $this->renderer->render($shoutArray);
    }
    return new JsonResponse($data);
  }

}
