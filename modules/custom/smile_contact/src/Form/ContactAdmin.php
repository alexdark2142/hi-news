<?php


namespace Drupal\smile_contact\Form;


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\smile_contact\Controller\SmileContactDatabase;


class ContactAdmin extends FormBase {

  public function getFormId()
  {
    return 'smile_contact_admin';
  }


  public function buildForm(array $form, FormStateInterface $form_state) {
    //Database connection
    /** @var Drupal\smile_contact\Controller\SmileContactDatabase $connect */
    $connect = new SmileContactDatabase();
    $entries = $connect->view();

    // Wrap the form in a div.
    $form = [
      '#prefix' => '<div id="list_form">',
      '#suffix' => '</div>',
    ];

    // Tell the user if there is nothing to display.
    if (empty($entries)) {
      $form['no_values'] = [
        '#type' => 'item',
        '#markup' => $this->t('There are no entries in the "User`s message" table.'),
      ];
      return $form;
    }

    foreach ($entries as $entry) {
      $options[$entry->user_id] = $this->t('User ID-@id', [
        '@id' => $entry->user_id,
      ]);
    }

    // Grab the id.
    $id = $form_state->getValue('id');

    $default_id = array_key_first($options);
    // User ID to set the default list to show.
    $default_list = !empty($id) ? $connect->viewList($id) : $connect->viewList($default_id);

    // Save the entries into the $form_state. We do this so the AJAX callback
    // doesn't need to repeat the query.
    $form_state->setValue('entries', $entries);

    //Select user by ID.
    $form['id'] = [
      '#type' => 'select',
      '#options' => $options,
      '#title' => $this->t('Choose user id.'),
      '#default_value' => $default_list,
      '#ajax' => [
        'wrapper' => 'list_form',
        'callback' => '::listCallback',
      ],
    ];


    // Table headers.
    $form['users'] = [
      '#type' => 'table',
      '#caption' => $this
        ->t('<h1>Users Table</h1>'),
      '#header' => [
        $this->t('Id'),
        $this->t('Email'),
        $this->t('Phone'),
        $this->t('Category'),
        $this->t('User ID'),
        $this->t('Delete'),
      ],
    ];

    //User message list.
    foreach ($default_list as $entry) {
      // Sanitize each entry.
      $form['users'][$entry->id]['id'] = [
        '#type' => 'item',
        '#markup' => $entry->id,
      ];
      $form['users'][$entry->id]['email'] = [
        '#type' => 'item',
        '#markup' => $this->t($entry->email),
      ];
      $form['users'][$entry->id]['phone'] = [
        '#type' => 'item',
        '#markup' => $entry->phone,
      ];
      $form['users'][$entry->id]['category'] = [
        '#type' => 'item',
        '#markup' => $this->t($entry->category),
      ];
      $form['users'][$entry->id]['user_id'] = [
        '#type' => 'item',
        '#markup' => $entry->user_id,
      ];
      $form['users'][$entry->id]['delete'] = [
        '#type' => 'link',
        '#title' => $this->t('Delete.'),
        '#url' => Url::fromRoute('smile_ajax.confirm_page',['nojs' => $entry->id]),
        '#attributes' => [
          'class' => ['use-ajax'],
          'data-dialog-type' => 'modal',
        ],
      ];
    }

    return $form;
  }

  /**
   * AJAX callback handler for the id select.
   *
   * When the id changes, populates the defaults from the database in the form.
   */
  public function listCallback(array $form, FormStateInterface $form_state) {
    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state)
  {
  }
}
