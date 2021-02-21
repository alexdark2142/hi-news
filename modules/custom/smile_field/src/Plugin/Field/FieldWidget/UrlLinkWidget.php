<?php

namespace Drupal\smile_field\Plugin\Field\FieldWidget;

use Drupal\smile_field\Controller\CheckingUrlYouTube;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin widget.
 *
 * @FieldWidget(
 *   id = "GetUrlYoutube",
 *   module = "smile_field",
 *   label = @Translation("Url YouTube"),
 *   field_types = {
 *     "SetUrlYouTube"
 *   }
 * )
 */
class UrlLinkWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $value = isset($items[$delta]->url) ? $items[$delta]->url : '';

    $element += [
      '#type' => 'textfield',
      '#default_value' => $value,
      '#size' => 43,
      '#description' => $this->t('Enter the YouTube video ID'),
      '#maxlength' => 43,
      '#element_validate' => [
        [$this, 'validate'],
      ],
    ];
    return ['url' => $element];
  }


  public function validate($element, FormStateInterface $form_state) {
    $value = $element['#value'];
    $link1 = str_split($value, 32);
    if (strlen($value) === 0) {
      $form_state->setValueForElement($element, '');
      return;
    }
    $url = new CheckingUrlYouTube;
    $valid = $url->video_exists($value);
    //Checking if a video exist
    if (!$valid) {
      $form_state->setError($element, $this->t('This YouTube Url does not exist!'));
    }
    if ($link1[0] !== 'https://www.youtube.com/watch?v=') {
      $link2 = str_split($value, 17);
      if ($link2[0] !== 'https://youtu.be/') {
        $form_state->setError($element, $this->t('The link must be a YouTube URL.'));
      }
    }
  }
}
