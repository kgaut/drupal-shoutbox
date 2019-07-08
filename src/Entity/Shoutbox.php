<?php

namespace Drupal\shoutbox\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\user\UserInterface;

/**
 * Defines the Shoutbox entity.
 *
 * @ingroup shoutbox
 *
 * @ContentEntityType(
 *   id = "shoutbox",
 *   label = @Translation("Shoutbox"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\ViewBuilder\EntityViewBuilder",
 *     "list_builder" = "Drupal\shoutbox\Entity\ListBuilder\ShoutboxListBuilder",
 *     "views_data" = "Drupal\shoutbox\Entity\ViewsData\ShoutboxViewsData",
 *     "form" = {
 *       "default" = "Drupal\shoutbox\Entity\Form\ShoutboxForm",
 *       "add" = "Drupal\shoutbox\Entity\Form\ShoutboxForm",
 *       "edit" = "Drupal\shoutbox\Entity\Form\ShoutboxForm",
 *       "delete" = "Drupal\shoutbox\Entity\Form\ShoutboxDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\shoutbox\Entity\HtmlRouteProvider\ShoutboxHtmlRouteProvider",
 *     },
 *     "access" = "Drupal\shoutbox\Entity\AccessControlHandler\ShoutboxAccessControlHandler",
 *   },
 *   base_table = "shoutbox",
 *   translatable = FALSE,
 *   admin_permission = "administer shoutbox",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uid" = "user_id",
 *     "published" = "status",
 *   },
 *   links = {
 *     "canonical" = "/shoutbox/{shoutbox}",
 *     "add-form" = "/admin/content/shoutbox/add",
 *     "edit-form" = "/admin/content/shoutbox/{shoutbox}/edit",
 *     "delete-form" = "/admin/content/shoutbox/{shoutbox}/delete",
 *     "collection" = "/admin/content/shoutbox",
 *   },
 *   field_ui_base_route = "shoutbox.settings"
 * )
 */
class Shoutbox extends ContentEntityBase implements ShoutboxInterface {
  use EntityChangedTrait;
  use EntityPublishedTrait;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += [
      'creator' => \Drupal::currentUser()->id(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields += static::publishedBaseFieldDefinitions($entity_type);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Created by'))
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Shoutbox'))
      ->setSetting('max_length', 255)
      ->setSetting('text_processing', 0)
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Published'))
      ->setDefaultValue(TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
