<?php

namespace Drupal\smile_contact\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Mail\MailManager;
use Drupal\Core\Mail\Plugin\Mail\PhpMail;
use Drupal\smile_contact\Controller\SmileContactDatabase;


/**
 * My custom test form
 * @package Drupal\smile_contact\Form
 */

class ContactForm extends FormBase {


  public function getFormId() {
    return 'smile_contact_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    $current_user = \Drupal::currentUser();
//    $anon = $current_user->isAnonymous();
//    $email = $current_user->getEmail();
    $user_id = $current_user->id();

    $form['description'] = [
      '#type' => 'item',
      '#markup' => $this->t('This is contact form.'),
    ];

//    if ($anon){
      $form['email'] = [
        '#type' => 'email',
        '#title' => $this->t('Email'),
        '#required' => TRUE,
      ];
//    }
//    else{
//      $form['email'] = [
//        '#type' => 'hidden',
//        '#value' => $email,
//      ];
//    }

    $form['phone'] = [
      '#type' => 'tel',
      '#title' => $this->t('Number phone'),
      '#required' => TRUE,
    ];

    $form['message'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Message'),
      '#required' => TRUE,
    ];

    /** @var \Drupal\Core\Entity\EntityTypeManagerInterface $terms */
    $terms =\Drupal::entityTypeManager()
      ->getStorage('taxonomy_term')
      ->loadTree('submission');

    foreach ($terms as $term) {
      $term_data [$term->name] = $term->name;
    }

    $form['category'] = [
      '#type' => 'select',
      '#title' => $this->t('Submission category'),
      '#options' => $term_data,
    ];

    $form['user_id'] = [
      '#type' => 'hidden',
      '#default_value' => $user_id,
    ];


    // Group submit handlers in an actions element with a key of "actions" so
    // that it gets styled correctly, and so that other modules may add actions
    // to the form. This is not required, but is convention.
    $form['actions'] = [
      '#type' => 'actions',
    ];

    // Add a submit button that handles the submission of the form.
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];


    $form['#cache']['max-age'] = 0;
    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {

    /**
     * Checking user's phone number.
     */
    $phone = $form_state->getValue('phone');
    if (strlen($phone) > 0 && !preg_match('/^[+][0-9]{1,3}[(][0-9]{2}[)][0-9]{3}-[0-9]{2}-[0-9]{2}$/', $phone)) {
      $form_state->setErrorByName('phone', $this->t('Phone number must be in format +380(YY)XXX-XX-XX.'));
    }
    /**
     * Checking message text for invalid characters.
     */
    $message= $form_state->getValue('message');
    if (strlen($message) > 0 && !strip_tags($message)) {
      $form_state->setErrorByName('message', $this->t('Invalid characters in the message'));
    }

  }

  public function submitForm(array &$form, FormStateInterface $form_state) {

    $entry = [
      'user_id' => $form_state->getValue('user_id'),
      'message' => $form_state->getValue('message'),
      'category' => $form_state->getValue('category'),
      'phone' => $form_state->getValue('phone'),
      'email' => $form_state->getValue('email'),
    ];


    /** @var \Drupal\Core\Mail\MailManagerInterface $send_mail */
    $send_mail = \Drupal :: service ('plugin.manager.mail');
    $to = 'alex@gmail.com';
    $lang = 'en';
    $subject = 'Test send email from swiftmailer';
    $body = '<p style="background-color: green">' . $entry['message'] . '</p>';

    $params = array(
      'subject' => $subject,
      'message' => $body,
      'from' => $entry['email'],
    );
    //Connection for database.
    $connection = new SmileContactDatabase();
    $return = $connection->insert($entry);
    if ($return) {
      $mail = $send_mail->mail('smile_email', 'smile', $to, $lang, $params, NULL,TRUE);
      if ($mail){
        $this->messenger()->addMessage($this->t('Message sent! From user @email!', ['@email' => $entry['email']]));
      }
    }
  }
}
