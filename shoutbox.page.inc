<?php

use Drupal\shoutbox\Entity\Shout;
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
  $nb_shouts_to_display = 2;
  $nb_shouts_to_reload = 20;
  $variables['range'] = $nb_shouts_to_reload;
  $variables['offset'] = $nb_shouts_to_display;
  $variables['#attached']['library'][] = 'shoutbox/shoutbox';
  // Fetch Shoutbox Entity Object.
  $shoutbox = $variables['elements']['#shoutbox'];
  $variables['shoutbox_id'] = $shoutbox->id();
  $variables['attributes']['class'][] = 'shoutbox-' . $shoutbox->id();
  $variables['attributes']['class'][] = 'js-shoutbox-' . $shoutbox->id();

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
  $variables['content']['shouts'] = [];
  $shouts = \Drupal::service('shoutbox.service')->getShoutboxShouts($shoutbox, $nb_shouts_to_display);
  $variables['nb_shouts'] =  \Drupal::service('shoutbox.service')->getShoutboxNumberOfShouts($shoutbox);
  $variables['has_mode_shouts'] = $variables['nb_shouts'] > $nb_shouts_to_display;
  $viewBuilder = \Drupal::entityTypeManager()->getViewBuilder('shout');
  foreach ($shouts as $shout) {
    $variables['content']['shouts'][] = $viewBuilder->view($shout);
  }
  $variables['form'] = [
    'cache' => [
      'contexts' => ['user.roles'],
    ]
  ];
  if (\Drupal::currentUser()->hasPermission('shoutbox shout')) {
    $shoutNew = Shout::create(['shoutbox' => $shoutbox->id()]);
    $variables['form']['data'] = \Drupal::service('entity.form_builder')->getForm($shoutNew, 'default');
  }
}
