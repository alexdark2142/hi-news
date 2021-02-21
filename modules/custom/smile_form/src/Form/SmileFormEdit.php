<?php

namespace Drupal\smile_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\pets_owners_form\Controller\SmileDatabase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * UI to update a record.
 *
 * @ingroup
 */
class SmileFormEdit extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'smile_update';
  }

  /**
   * Sample UI to update a record.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Wrap the form in a div.
    $form = [
      '#prefix' => '<div id="updateform">',
      '#suffix' => '</div>',
    ];
    // Add some explanatory text to the form.
    $form['message'] = [
      '#markup' => $this->t('Edit pet owners details.'),
    ];
    // Query for items to display.
    $connection = new SmileDatabase();
    $entries = $connection->view();
    // Tell the user if there is nothing to display.
    if (empty($entries)) {
      $form['no_values'] = [
        '#value' => $this->t('No entries exist in the table pets table.'),
      ];
      return $form;
    }

    $keyed_entries = [];
    $options = [];
    foreach ($entries as $entry) {
      $options[$entry->id] = $this->t('ID-@id, Name: @name', [
        '@id' => $entry->id,
        '@name' => $entry->name,
      ]);
      $keyed_entries[$entry->id] = $entry;
    }

    // Grab the id.
    $id = $form_state->getValue('id');
    // Use the id to set the default entry for updating.
    $default_entry = !empty($id) ? $keyed_entries[$id] : $entries[0];

    // Save the entries into the $form_state. We do this so the AJAX callback
    // doesn't need to repeat the query.
    $form_state->setValue('entries', $keyed_entries);

    $form['id'] = [
      '#type' => 'select',
      '#options' => $options,
      '#title' => $this->t('Choose entry to update'),
      '#default_value' => $default_entry->id,
      '#ajax' => [
        'wrapper' => 'updateform',
        'callback' => '::updateCallback',
      ],
    ];

    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Updated first name'),
      '#size' => 15,
      '#default_value' => $default_entry->name,
      '#required' => TRUE,
    ];

    $form['gender'] = [
      '#type' => 'select',
      '#title' => $this->t('Update gender:'),
      '#options' => [
        'Male' => $this->t('Male'),
        'Female' => $this->t('Female'),
        'Unknown' => $this->t('Unknown'),
      ],
      '#default_value' => $default_entry->gender,
    ];
    $form['prefix'] = [
      '#type' => 'select',
      '#title' => $this->t('Update prefix:'),
      '#options' => [
        'mr' => $this->t('mr'),
        'mrs' => $this->t('mrs'),
        'ms' => $this->t('ms'),
      ],
      '#size' => 1,
      '#default_value' => $default_entry->prefix,
    ];
    $form['age'] = [
      '#type' => 'number',
      '#title' => $this->t('Update age:'),
      '#min' => 1,
      '#max' =>120,
      '#default_value' => $default_entry->age,
      '#description' => $this->t('Values less than 0 and greater than 120 will cause an exception.'),
    ];
    $form['father_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Updated father name'),
      '#size' => 15,
      '#default_value' => $default_entry->father_name,
    ];
    $form['mother_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Updated mother name'),
      '#size' => 15,
      '#default_value' => $default_entry->mother_name,
    ];
    $form['pet_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Updated pet name'),
      '#size' => 15,
      '#default_value' => $default_entry->pet_name,
    ];
    $form['email'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Updated email'),
      '#size' => 15,
      '#default_value' => $default_entry->email,
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Update'),
    ];
    return $form;
  }

  /**
   * AJAX callback handler for the id select.
   *
   * When the id changes, populates the defaults from the database in the form.
   */
  public function updateCallback(array $form, FormStateInterface $form_state) {
    // Gather the DB results from $form_state.
    $entries = $form_state->getValue('entries');
    // Use the specific entry for this $form_state.
    $entry = $entries[$form_state->getValue('id')];
    // Setting the #value of items is the only way I was able to figure out
    // to get replaced defaults on these items. #default_value will not do it
    foreach (['name', 'gender', 'prefix', 'age', 'father_name', 'mother_name', 'pet_name', 'email',] as $item) {
      $form[$item]['#value'] = $entry->$item;
    }
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $age = $form_state->getValue('age');
//    // Confirm that age is numeric.
    if ($age <= 0 || $age >= 120) {
      $form_state->setErrorByName('age', $this->t('Your age is not correct. Please enter a number between 0 and 120!'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Save the submitted entry.
    $entry = [
      'id' => $form_state->getValue('id'),
      'name' => $form_state->getValue('name'),
      'gender' => $form_state->getValue('gender'),
      'prefix' => $form_state->getValue('prefix'),
      'age' => $form_state->getValue('age'),
      'father_name' => $form_state->getValue('father_name'),
      'mother_name' => $form_state->getValue('mother_name'),
      'pet_name' => $form_state->getValue('pet_name'),
      'email' => $form_state->getValue('email'),
    ];
    $db = new SmileContactDatabase();
    $count = $db->update($entry);
    $this->messenger()->addMessage($this->t('Updated user: (ID @id, name @name)! (@count row updated)', [
      '@count' => $count,
      '@id' => $entry['id'],
      '@name' => $entry['name'],
    ]));
    $form_state->setRedirect('pets_owners_form.admin');
  }

}
