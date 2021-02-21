<?php

namespace Drupal\smile_field\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin formatter.
 *
 * @FieldFormatter(
 *   id = "UrlYouTube_formatter",
 *   module = "smile_field",
 *   label = @Translation("Url YouTube"),
 *   field_types = {
 *     "SetUrlYouTube"
 *   }
 * )
 */
class LinkYouTubeFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    $url = 'https://www.youtube.com/embed/';

    foreach ($items as $delta => $item) {
      //This is by link https://www.youtube.com/watch?v=
      $link1 = str_split($item->url, 32);
      //This is by link https://youtu.be/
      $link2 = str_split($item->url, 17);

      //Checking which link a user entered
      if ($link1[0] === 'https://www.youtube.com/watch?v=') {
        $id = $link1[1];
      }
      else {
        $id = $link2[1];
      }

      $elements[$delta] = [
        '#type' => 'html_tag',
        '#tag' => 'iframe',
        '#attributes' => [
          'src' => $url . $id,
          'width' => '560',
          'height' => '315',
          'frameborder' => '0',
          'allow' => "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture",
          'allowfullscreen' => '1',
        ],
      ];
    }

    return $elements;
  }

}
