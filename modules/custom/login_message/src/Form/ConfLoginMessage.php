<?php
namespace Drupal\login_message\Form;



use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure login message settings for this site.
 */
class ConfLoginMessage extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'login_message';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['login_message.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['description'] = [
      '#type' => 'item',
      '#markup' => $this->t('Configure login message.'),
    ];

    $form['message_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Unpublsihed label'),
      '#default_value' => $this->config('login_message.settings')->get('message_label'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);

    /**
     * Valid message_label.
     */
    $unpublsihed_label = $form_state->getValue('message_label');
    if (strlen($unpublsihed_label) >= 50) {
      $form_state->setErrorByName('message_label', 'Entered text is incorrect!');
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('login_message.settings')
      ->set('message_label', $form_state->getValue('message_label'))
      ->save();
    parent::submitForm($form, $form_state);
//    $form_state->setRedirect('unpublish_node_queue.unpublish_node');
  }

}
