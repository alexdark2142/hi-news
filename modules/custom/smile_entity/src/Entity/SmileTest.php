<?php

namespace Drupal\smile_entity\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\smile_entity\SmileInterface;
use Drupal\user\UserInterface;
use Drupal\Core\Entity\EntityChangedTrait;

/**
 * Defines the SmileEntity entity.
 *
 * @ingroup smile_entity
 *
 * @ContentEntityType(
 *   id = "smile_entity",
 *   label = @Translation("Smile entity"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\smile_entity\Entity\Controller\SmileListBuilder",
 *     "form" = {
 *       "default" = "Drupal\smile_entity\Form\SmileForm",
 *       "delete" = "Drupal\smile_entity\Form\SmileDeleteForm",
 *     },
 *     "access" = "Drupal\smile_entity\SmileAccessControlHandler",
 *   },
 *   list_cache_contexts = { "user" },
 *   base_table = "smile",
 *   admin_permission = "administer smile entity",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "title",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/smile_entity/{smile_entity}",
 *     "edit-form" = "/smile_entity/{smile_entity}/edit",
 *     "delete-form" = "/smile_entity/{smile_entity}/delete",
 *     "collection" = "/smile_entity"
 *   },
 *   field_ui_base_route = "smile_entity.smile_settings",
 * )
 *
 */
class SmileTest extends ContentEntityBase implements SmileInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   *
   * When a new entity instance is added, set the user_id entity reference to
   * the current user as the creator of the instance.
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += [
      'user_id' => \Drupal::currentUser()->id(),
    ];
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
   *
   * Define the field properties here.
   *
   * Field name, type and size determine the table structure.
   *
   * In addition, we can define how the field and its content can be manipulated
   * in the GUI. The behaviour of the widgets used can be determined here.
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    // Standard field, used as unique if primary index.
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Smile entity.'))
      ->setReadOnly(TRUE);

    // Standard field, unique outside of the scope of the current project.
    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the Smile entity.'))
      ->setReadOnly(TRUE);

    // Name field for the smile.
    // We set display options for the view as well as the form.
    // Users with correct privileges can change the view and edit configuration.
    $fields['title'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Title'))
      ->setSettings([
        'max_length' => 60,
        'text_processing' => 0,
      ])
      // Set no default value.
      ->setDefaultValue(NULL)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -2,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -2,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['body'] = BaseFieldDefinition::create('text_with_summary')
      ->setLabel(t('Body'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      // Set no default value.
      ->setDefaultValue(NULL)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'format' => 'default',
        'weight' => -1,
      ])
      ->setDisplayOptions('form', [
        'type' => 'text_with_summary',
        'weight' => -1,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    // Role field for the contact.
    // The values shown in options are 'administrator' and 'user'.
    $fields['role'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Role'))
      ->setDescription(t('The role of the Smile entity.'))
      ->setSetting('target_type', 'user_role')
      // Set the default value of this field to 'user'.
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'options_select',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['langcode'] = BaseFieldDefinition::create('language')
      ->setLabel(t('Language code'))
      ->setDescription(t('The language code of SmileEntity entity.'));
    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
