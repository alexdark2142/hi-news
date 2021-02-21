<?php

namespace Drupal\pets_owners_form\Controller;

/**
 * Class SmileDatabase. Connection for database.
 * @package Drupal\pets_owners_form\Controller
 */
class SmileDatabase {
  public $connection;


  public function __construct() {
    $this->connection = \Drupal::database();

  }

  /**
   * @param array $entry
   * @return \Drupal\Core\Database\StatementInterface|int|string|null
   * @throws \Exception
   * Insert user data in database.
   */

  public function insert(array $entry)
  {
    $query = $this->connection->insert('pets_owners_form');
    $result = $query->fields($entry);
    return $result->execute();
  }

  /**
   * This is function for displaying user data.
   */
  public function view() {
    $query = $this->connection->select('pets_owners_form', 'pets');
    $query->fields( 'pets',['id','name', 'gender', 'prefix', 'age', 'father_name', 'mother_name', 'pet_name', 'email']);
    return $query->execute()->fetchAll();
  }

  /**
   * This is function for updates user data.
   * @param array $entry
   * @return \Drupal\Core\Database\StatementInterface|int|string|null
   */
  public function update(array $entry) {

    // Connection->update()...->execute() updates user data.
    return $this->connection->update('pets_owners_form')
      ->fields($entry)
      ->condition('id', $entry['id'])
      ->execute();
  }

  /**
   * Deleting a user from  the database.
   * @param $id
   * this user id
   * @return int
   */
  public function delete($id) {
    $query = $this->connection->delete('pets_owners_form');
    $query->condition('id', $id);
    return $query->execute();
  }
}
