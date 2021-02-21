<?php

namespace Drupal\unpublish_node_queue\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure unpublish node by queue settings for this site.
 */
class ConfigureQueue extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'unpublish_node_queue';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['unpublish_node_queue.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['description'] = [
      '#type' => 'item',
      '#markup' => $this->t('Configure unpublish node queue via cron.'),
    ];

    $form['period'] = [
      '#type' => 'number',
      '#title' => $this->t('Period'),
      '#min' => 180,
      '#default_value' => $this->config('unpublish_node_queue.settings')->get('period'),
    ];

    $form['items_to_create'] = [
      '#type' => 'number',
      '#title' => $this->t('Number of items to create'),
      '#min' => 5,
      '#max' => 25,
      '#default_value' => $this->config('unpublish_node_queue.settings')->get('items_to_create'),
    ];

    $form['disabled'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable queue'),
      '#default_value' => $this->config('unpublish_node_queue.settings')->get('disabled'),
    ];

    $form['unpublsihed_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Unpublsihed label'),
      '#default_value' => $this->config('unpublish_node_queue.settings')->get('unpublsihed_label'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
    /**
     * Valid period.
     */
    $period = $form_state->getValue('period');
    if ($period < 180) {
      $form_state->setErrorByName('period', 'The term must be at least 180 days!');
    }
    /**
     * Valid items_to_create.
     */
    $age = $form_state->getValue('items_to_create');
    if ($age < 5 || $age > 25) {
      $form_state->setErrorByName('items_to_create', 'Crafting items must be at least 5 and no more than 25!');
    }
    /**
     * Valid unpublsihed_label.
     */
    $unpublsihed_label = $form_state->getValue('unpublsihed_label');
    if (strlen($unpublsihed_label) >= 50) {
      $form_state->setErrorByName('unpublsihed_label', 'Entered text is incorrect!');
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('unpublish_node_queue.settings')
      ->set('period', $form_state->getValue('period'))
      ->set('items_to_create', $form_state->getValue('items_to_create'))
      ->set('disabled', $form_state->getValue('disabled'))
      ->set('unpublsihed_label', $form_state->getValue('unpublsihed_label'))
      ->save();
    parent::submitForm($form, $form_state);
    $form_state->setRedirect('unpublish_node_queue.unpublish_node');
  }

}
