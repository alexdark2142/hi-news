<?php

namespace Drupal\pets_owners_form\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\pets_owners_form\Controller\SmileContactDatabase;

/**
 * Class SmileList
 * Displaying a list of pet owner users
 * @package Drupal\pets_owners_form\Controller
 */
class SmileList extends ControllerBase{


  public function entryList() {

    $connect = new SmileContactDatabase();
    // Writing to an array of users from the database
    $entries = $connect->view();
    $content = [];

    $content['message'] = [
      '#markup' => $this->t('List users pets owners'),
    ];

    //Array with headers
    $headers = [
      $this->t('Id'),
      $this->t('Name'),
      $this->t('Gender'),
      $this->t('Prefix'),
      $this->t('Age'),
      $this->t('Father name'),
      $this->t('Mother name'),
      $this->t('Pet name'),
      $this->t('Email'),
    ];

    $rows = [];
    foreach ($entries as $entry) {
      // Sanitize each entry.
      $rows[] = array_map('Drupal\Component\Utility\Html::escape',  (array) $entry);
    }

    //Create table
    $content['table'] = [
      '#type' => 'table',
      '#header' => $headers,
      '#rows' => $rows,
      '#empty' => $this->t('No entries available.'),
    ];


    // Don't cache this page.
    $content['#cache']['max-age'] = 0;

    return $content;
  }


}
