<?php

namespace Drupal\smile_field\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin field type.
 *
 * @FieldType(
 *   id = "SetUrlYouTube",
 *   module = "smile_field",
 *   label = @Translation("YouTube video box."),
 *   description = @Translation("Watch YouTube videos by URL"),
 *   default_widget = "GetUrlYoutube",
 *   default_formatter = "UrlYouTube_formatter"
 * )
 */
class UrlItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return [
      'columns' => [
        'url' => [
          'type' => 'text',
          'size' => 'tiny',
          'not null' => FALSE,
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $value = $this->get('url')->getValue();
    return $value === NULL || $value === '';
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['url'] = DataDefinition::create('string');
    return $properties;
  }

}
