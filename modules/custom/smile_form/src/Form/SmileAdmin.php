<?php


namespace Drupal\smile_form\Form;


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\pets_owners_form\Controller\SmileDatabase;


class SmileAdmin extends FormBase {

  public function getFormId()
  {
    return 'smile_admin';
  }



  public function buildForm(array $form, FormStateInterface $form_state) {
    //Database connection
    $connect = new SmileDatabase();
    $entries = $connect->view();
    $x =1;
    if (!empty($entries)) {
      $form['users'] = [
        '#type' => 'table',
        '#caption' => $this
          ->t('<h1>Users Table</h1>'),
        '#header' => [
          $this->t('Id'),
          $this->t('Name'),
          $this->t('Gender'),
          $this->t('Prefix'),
          $this->t('Age'),
          $this->t('Father name'),
          $this->t('Mother name'),
          $this->t('Pet name'),
          $this->t('Email'),
          $this->t('Delete'),
        ],
      ];
      foreach ($entries as $entry) {
        // Sanitize each entry.
        $form['users'][$entry->id]['id'] = [
          '#type' => 'item',
          '#markup' => $this->t($entry->id),
        ];
        $form['users'][$entry->id]['name'] = [
          '#type' => 'item',
          '#markup' => $this->t($entry->name),
        ];
        $form['users'][$entry->id]['gender'] = [
          '#type' => 'item',
          '#markup' => $this->t($entry->gender),
        ];
        $form['users'][$entry->id]['prefix'] = [
          '#type' => 'item',
          '#markup' => $this->t($entry->prefix),
        ];
        $form['users'][$entry->id]['age'] = [
          '#type' => 'item',
          '#markup' => $this->t($entry->age),
        ];
        $form['users'][$entry->id]['father_name'] = [
          '#type' => 'item',
          '#markup' => $this->t($entry->father_name),
        ];
        $form['users'][$entry->id]['mother_name'] = [
          '#type' => 'item',
          '#markup' => $this->t($entry->mother_name),
        ];
        $form['users'][$entry->id]['pet_name'] = [
          '#type' => 'item',
          '#markup' => $this->t($entry->pet_name),
        ];
        $form['users'][$entry->id]['email'] = [
          '#type' => 'item',
          '#markup' => $this->t($entry->email),
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

      $form['edit'] = [
        '#title' => $this
          ->t('Edit'),
        '#type' => 'link',
        '#url' => Url::fromRoute('pets_owners_form.edit'),
      ];
    }
    else {
      $form['no_users'] = [
        '#type' => 'item',
        '#markup' => $this->t('Users database is empty.'),
      ];
    }
    return $form;
  }


  public function submitForm(array &$form, FormStateInterface $form_state)
  {
  }
}
