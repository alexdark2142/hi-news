<?php

namespace Drupal\smile_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\pets_owners_form\Controller\SmileContactDatabase;


/**
 * My custom test form
 * @package Drupal\smile_form\Form
 */

class SmileForm extends FormBase {


  public function getFormId() {
    return 'my_custom_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['description'] = [
      '#type' => 'item',
      '#markup' => $this->t('This is pets owners form.'),
    ];

    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name:'),
      '#required' => TRUE,
    ];

    $form['gender'] = [
      '#type' => 'radios',
      '#title' => $this->t('Gender:'),
      '#default_value' => 'Unknown',
      '#options' => [
        'Male' => $this->t('Male'),
        'Female' => $this->t('Female'),
        'Unknown' => $this->t('Unknown'),
      ],
      '#required' => TRUE,
    ];

    $form['prefix'] = [
      '#type' => 'select',
      '#title' => $this->t('Prefix:'),
      '#options' => [
        'mr' => $this->t('mr'),
        'mrs' => $this->t('mrs'),
        'ms' => $this->t('ms'),
      ],
      '#required' => TRUE,
    ];

    $form['age'] = [
      '#type' => 'number',
      '#title' => $this->t('Age:'),
      '#min' => 1,
      '#max' =>120,
      '#required' => TRUE,
    ];

    $form['age_18'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Me less 18 age'),
    ];

    $form['parents'] = [
      '#type' => 'item',
      '#title' => $this->t('YOUR PARENTS'),
      '#states' => [
        'visible' =>[
          ':input[name="age_18"]' => [
            'checked' => TRUE
          ],
        ],
      ],
    ];

    $form['parents']['father_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Father`s name:'),
    ];

    $form['parents']['mother_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Mother`s name:'),
    ];


    $form['pets'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Have you some pets?'),
      '#options' => [
        'Yes' => $this->t('Yes'),
      ],
      '#attributes' => [
        //define static name and id so we can easier select it
        // 'id' => 'pets',
        'name' => 'pet',
      ],
    ];

    $form['pet_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name(s) of your pet(s):'),

      '#states' => [
        'visible' =>[
          ':input[name="pet"]' => [
            'checked' => TRUE
          ],
        ],
      ],
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email:'),
      '#required' => TRUE,
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

    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    /**
     * Valid name user and name pets.
     */
    $name = $form_state->getValue('name');
    if (strlen($name) >=20) {
      $form_state->setErrorByName('name', 'Entered name is incorrect!');
    }
    /**
     * Valid age user.
     */
    $age = $form_state->getValue('age');
    if ($age <= 0 || $age >=120) {
      $form_state->setErrorByName('age', 'Entered age is incorrect!');
    }
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {

    $entry = [
      'name' => $form_state->getValue('name'),
      'gender' => $form_state->getValue('gender'),
      'prefix' => $form_state->getValue('prefix'),
      'age' => $form_state->getValue('age'),
      'father_name' => $form_state->getValue('father_name'),
      'mother_name' => $form_state->getValue('mother_name'),
      'pet_name' => $form_state->getValue('pet_name'),
      'email' => $form_state->getValue('email'),
    ];

    //Connection for database.
    $connection = new SmileContactDatabase();
    $return = $connection->insert($entry);
    if ($return) {
      $this->messenger()->addMessage($this->t('Thank you @name!', ['@name' => $entry['name']]));
    }
  }
}
