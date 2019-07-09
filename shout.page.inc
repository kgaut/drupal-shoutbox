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
  $shout = $variables['elements']['#shout'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
