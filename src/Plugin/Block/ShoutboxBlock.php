<?php

namespace Drupal\shoutbox\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\shoutbox\Entity\Shoutbox;

/**
 * Provides a 'ShoutboxBlock' block.
 *
 * @Block(
 *  id = "shoutbox_block",
 *  admin_label = @Translation("Shoutbox"),
 * )
 */
class ShoutboxBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
          ] + parent::defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['shoutbox'] = [
      '#type' => 'select',
      '#title' => $this->t('Shoutbox to use'),
      '#default_value' => $this->configuration['shoutbox'],
      '#options' => \Drupal::service('shoutbox.service')->getShoutboxAsArray(),
      '#weight' => '0',
      'required' => TRUE,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['shoutbox'] = $form_state->getValue('shoutbox');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $viewBuilder = \Drupal::entityTypeManager()->getViewBuilder('shoutbox');
    $shoutbox = Shoutbox::load($this->configuration['shoutbox']);
    return $viewBuilder->view($shoutbox);
  }

}
