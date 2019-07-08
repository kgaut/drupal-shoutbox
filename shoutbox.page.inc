<?php

/**
 * @file
 * Contains shoutbox.page.inc.
 *
 * Page callback for Shoutbox entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Shoutbox templates.
 *
 * Default template: shoutbox.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_shoutbox(array &$variables) {
  // Fetch Shoutbox Entity Object.
  $shoutbox = $variables['elements']['#shoutbox'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
