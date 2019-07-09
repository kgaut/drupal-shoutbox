<?php

namespace Drupal\shoutbox\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\shoutbox\Entity\Interfaces\ShoutboxInterface;
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
 *     "uid" = "creator",
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
class Shoutbox extends ContentEntityBase {

  use EntityChangedTrait;
  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += [
      'creator' => \Drupal::currentUser()->id(),
    ];
  }

  public function getName() {
    return $this->get('name')->value;
  }

  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  public function getOwner() {
    return $this->get('creator')->entity;
  }

  public function getOwnerId() {
    return $this->get('creator')->target_id;
  }

  public function setOwnerId($uid) {
    $this->set('creator', $uid);
    return $this;
  }

  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  public function isPublished() {
    return (bool) $this->getEntityKey('published');
  }

  public function setPublished($published = NULL) {
    if ($published !== NULL) {
      @trigger_error('The $published parameter is deprecated since version 8.3.x and will be removed in 9.0.0.', E_USER_DEPRECATED);
      $value = (bool) $published;
    }
    else {
      $value = TRUE;
    }
    $key = $this->getEntityType()->getKey('published');
    $this->set($key, $value);

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['creator'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Creator'))
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

    $field['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Published'))
      ->setDefaultValue(TRUE)
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
