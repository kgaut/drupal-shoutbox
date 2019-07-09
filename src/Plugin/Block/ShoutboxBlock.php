<?php

namespace Drupal\shoutbox\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

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
      '#type' => 'number',
      '#title' => $this->t('Shoutbox to use'),
      '#default_value' => $this->configuration['shoutbox'],
      '#weight' => '0',
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
    $build = [];
    $build['shoutbox_block_shoutbox']['#markup'] = '<p>' . $this->configuration['shoutbox']. '</p>';

    return $build;
  }

}
