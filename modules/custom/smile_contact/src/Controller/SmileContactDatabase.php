<?php

namespace Drupal\smile_contact\Controller;

/**
 * Class SmileContactDatabase. Connection for database.
 * @package Drupal\smile_contact\Controller
 */
class SmileContactDatabase {
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
    $query = $this->connection->insert('smile_contact');
    $result = $query->fields($entry);
    return $result->execute();
  }

  /**
   * This is function for displaying user data.
   */
  public function view() {
    $query = $this->connection->select('smile_contact', 'contact');
    $query->fields( 'contact',['user_id']);
    return $query->execute()->fetchAll();
  }

  /**
   * This is function for displaying user data by id.
   * @param $id
   * @return mixed
   */
  public function viewList($id) {
    return $this->connection->select('smile_contact', 'contact')
      ->condition('user_id', $id)
      ->fields( 'contact',['id','email', 'phone', 'message', 'category', 'user_id'])
      ->execute()->fetchAll();
  }

  /**
   * This is function for displaying user data by id.
   * @param $id
   * @return mixed
   */
  public function sendMail($id) {
    return $this->connection->select('smile_contact', 'contact')
      ->condition('id', $id)
      ->fields( 'contact',['id','email', 'phone', 'message', 'category', 'user_id'])
      ->execute()->fetchAssoc();
  }

  /**
   * This is function for updates user data.
   * @param array $entry
   * @return \Drupal\Core\Database\StatementInterface|int|string|null
   */
  public function update(array $entry) {

    // Connection->update()...->execute() updates user data.
    return $this->connection->update('smile_contact')
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
    $query = $this->connection->delete('smile_contact');
    $query->condition('id', $id);
    return $query->execute();
  }
}
