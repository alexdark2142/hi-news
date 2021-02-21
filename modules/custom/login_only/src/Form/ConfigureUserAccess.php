<?php

namespace Drupal\login_only\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure unpublish node by queue settings for this site.
 */
class ConfigureUserAccess extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'login_only';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['login_only.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['description'] = [
      '#type' => 'item',
      '#markup' => $this->t('Configure mode "Login only".'),
    ];

    $form['disabled'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable mode'),
      '#default_value' => $this->config('login_only.settings')->get('disabled'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('login_only.settings')
      ->set('disabled', $form_state->getValue('disabled'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
