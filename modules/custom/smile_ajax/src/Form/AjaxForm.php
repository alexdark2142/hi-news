<?php

namespace Drupal\smile_ajax\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Class AjaxForm
 * This is a form using ajax callbacks to add two fields or google link
 * @package Drupal\smile_ajax\Form
 *  @see \Drupal\Core\Form\FormBase
 */
class AjaxForm extends FormBase {


  public function getFormId()
  {
    return 'smile_ajax_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['description'] = [
      '#type' => 'item',
      '#markup' => $this->t('This form AJAX callback.'),
    ];

    $form['based_filed'] = [
      '#type' => 'textfield',
      '#title' => 'Main field',
    ];

    $form['check'] = [
      '#title' => $this->t('Check the box to display fields or link'),
      '#type' => 'radios',
      '#options' => [
        'field' => $this->t('Fields'),
        'link' => $this->t('Link'),
      ],
      '#ajax' => [
        'callback' => '::CheckBoxes',
        'wrapper' => 'ajax-wrapper',
      ],
    ];

    // Add a wrapper that can be replaced with new HTML by the ajax callback.
    // This is given the ID that was passed to the ajax callback in the '#ajax'
    // element above.
    $form['ajax_wrapper'] = [
      '#type' => 'container',
      '#attributes' => ['id' => 'ajax-wrapper'],
    ];


    $temperature = $form_state->getValue('check');
    if ($temperature == 'field') {
      $form['ajax_wrapper']['Field1'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Text field number 1'),
      ];
      $form['ajax_wrapper']['Field2'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Text field number 1'),
      ];
    }
    if ($temperature == 'link') {
      $form['ajax_wrapper']['link'] = [
        '#title' => $this
          ->t('google.com'),
        '#type' => 'link',
        '#url' => Url::fromUri('https://google.com'),
      ];
    }


    $form['actions'] = [
      '#type' => 'actions',
      'submit' => [
        '#type' => 'submit',
        '#value' => $this->t('Submit'),
      ],
    ];

    return $form;
  }

  /**
   * Ajax callback for the checkboxes
   */
  public function CheckBoxes(array $form, FormStateInterface $form_state) {
    return $form['ajax_wrapper'];
  }


  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $check = $form_state->getValue('check');
    $this->messenger()->addMessage($check);
    // TODO: Implement submitForm() method.
  }
}
