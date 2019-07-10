<?php

/**
 * @file
 * Contains shout.page.inc.
 *
 * Page callback for Shout entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Shout templates.
 *
 * Default template: shout.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_shout(array &$variables) {
  // Fetch Shout Entity Object.
  /** @var \Drupal\shoutbox\Entity\Shout $shout */
  $shout = $variables['elements']['#shout'];
  $shoutbox = $shout->getShoutbox();
  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
  /** @var \Drupal\user\Entity\User $author */
  $author = $shout->getOwner();
  $variables['author'] = [
    'id' => $author->id(),
    'name' => $author->getDisplayName(),
    'url' => $author->toUrl()->toString()
  ];

  $variables['attributes']['class'][] = 'author-' . $author->id();
  if ((int) $shoutbox->getOwnerId() === (int) $author->id()) {
    $variables['attributes']['class'][] = 'author-shoutbox-admin';
  }
  $variables['date'] = \Drupal::service('date.formatter')->format($shout->getCreatedTime(), 'medium');
}
