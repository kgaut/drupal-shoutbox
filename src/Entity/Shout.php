<?php

namespace Drupal\shoutbox\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\shoutbox\Entity\Interfaces\ShoutInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Shout entity.
 *
 * @ingroup shoutbox
 *
 * @ContentEntityType(
 *   id = "shout",
 *   label = @Translation("Shout"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\shoutbox\Entity\ListBuilder\ShoutListBuilder",
 *     "views_data" = "Drupal\shoutbox\Entity\ViewsData\ShoutViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\shoutbox\Entity\Form\ShoutForm",
 *       "add" = "Drupal\shoutbox\Entity\Form\ShoutForm",
 *       "edit" = "Drupal\shoutbox\Entity\Form\ShoutForm",
 *       "delete" = "Drupal\shoutbox\Entity\Form\ShoutDeleteForm",
 *     },
 *     "access" = "Drupal\shoutbox\Entity\AccessControlHandler\ShoutAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\shoutbox\Entity\HtmlRouteProvider\ShoutHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "shout",
 *   translatable = FALSE,
 *   admin_permission = "administer shout entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "uid" = "author",
 *     "published" = "status",
 *   },
 *   links = {
 *     "add-form" = "/admin/content/shoutbox/shout/add",
 *     "edit-form" = "/admin/content/shoutbox/shout/{shout}/edit",
 *     "delete-form" = "/admin/content/shoutbox/shout/{shout}/delete",
 *     "collection" = "/admin/content/shoutbox/shout",
 *   },
 *   field_ui_base_route = "shout.settings"
 * )
 */
class Shout extends ContentEntityBase {

  use EntityChangedTrait;

  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += [
      'author' => \Drupal::currentUser()->id(),
    ];
  }

  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  public function isPublished() {
    return (bool) $this->get('status')->value;
  }

  public function setPublished($published = NULL) {
    if ($published !== NULL) {
      @trigger_error('The $published parameter is deprecated since version 8.3.x and will be removed in 9.0.0.', E_USER_DEPRECATED);
      $value = (bool) $published;
    }
    else {
      $value = TRUE;
    }
    $this->set('status', $value);
    return $this;
  }

  public function getShoutboxId() {
    return $this->get('shoutbox')->target_id;
  }

  /**
   * @return \Drupal\shoutbox\Entity\Shoutbox
   */
  public function getShoutbox() {
    return $this->get('shoutbox')->entity;
  }

  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['author'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['shoutbox'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Shoutbox'))
      ->setSetting('target_type', 'shoutbox')
      ->setSetting('handler', 'default')
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['shout'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Shout'))
      ->setSetting('text_processing', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayConfigurable('form', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
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
