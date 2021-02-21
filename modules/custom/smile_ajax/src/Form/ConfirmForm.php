<?php


namespace Drupal\smile_ajax\Form;


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\smile_contact\Controller\SmileContactDatabase;

/**
 * Class ConfirmForm for
 * display a modal window to confirm deletion
 * @package Drupal\smile_ajax\Form
 */
class ConfirmForm extends FormBase
{

  public function getFormId()
  {
    return 'smile_confirm_form';
  }

  /**
   * Render modal
   * @param array $form
   * @param FormStateInterface $form_state
   * @return array
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $form['title'] = [
      '#type' => 'item',
      '#markup' => 'Do you really want to delete this message?',
    ];
    $form['action']['btn_yes'] = [
      '#type' => 'submit',
      '#value' => $this->t('Yes'),
      '#name' => 'yes',
    ];
    $form['action']['btn_no'] = [
      '#type' => 'submit',
      '#value' => $this->t('No'),
    ];
    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    //Here I am getting the id from the host url
    $id = \Drupal::routeMatch()->getRawParameter('nojs');
    //Here I am getting the name of the button to test the action.
    $input = $form_state->getTriggeringElement();
    $button = $input['#name'];
    //If the button press is yes, the action will be performed.
    if ($button == 'yes') {
      $this->messenger()->addMessage($this->t('Message with id ' . $id . ' has been deleted.'));
      $connect = new SmileContactDatabase();
      $connect->delete($id);
    }
    $form_state->setRedirect('smile_contact.admin');
  }
}
