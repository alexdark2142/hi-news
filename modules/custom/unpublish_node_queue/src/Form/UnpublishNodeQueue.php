<?php
/**
 * @file
 * Contains \Drupal\smile_form_unpublish\Form\QueueNode.
 */

namespace Drupal\unpublish_node_queue\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Render\FormattableMarkup;

/**
 * A form to create a queue to cancel the publication of the node.
 */
class UnpublishNodeQueue extends FormBase {

  /**
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'queue_node_form';
  }

  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    //We get our queue to block access to the button, if it is still is active.
    $queue = \Drupal::queue('unpublish_node');
    if ($number_of_items = $queue->numberOfItems()) {
      $form['info_text'] = [
        '#type' => 'markup',
        '#markup' => new FormattableMarkup('<div>This queue has already started, there is still: @number</div>', [
          '@number' => $number_of_items,
        ]),
      ];

      $form['delete'] = [
        '#type' => 'submit',
        '#value' => $this->t('Cancel current queue'),
        '#disable' => TRUE,
      ];

    }
    else {
      $form['actions'] = [
        '#type' => 'actions',
      ];
      $form['actions']['unpublish'] = [
        '#type' => 'submit',
        '#value' => $this->t('Unpublish node'),
        '#disable' => TRUE,
      ];
      $form['actions']['conf'] = [
        '#type' => 'submit',
        '#value' => $this->t(' Configure queue'),
        '#disable' => TRUE,
        '#name' => 'conf',
      ];
    }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    //Here I am getting the name of the button to test the action.
    $input = $form_state->getTriggeringElement();
    $button = $input['#name'];

    if ($button == 'conf') {
      $form_state->setRedirect('unpublish_node_queue.settings_queue');
    }
    else {
      // Get the queue object.
      $queue = \Drupal::queue('unpublish_node');

      // Convert period to timestamp.
      $conf = \Drupal::config('unpublish_node_queue.settings');
      $period = $conf->get('period') * 86400;
      $items = $conf->get('items_to_create');
      $run = $conf->get('disabled');
      $label = $conf->get('unpublsihed_label');

      // This is current time.
      $current_time = \Drupal::time()->getCurrentTime();

      // The date was a period of days ago.
      $time = $current_time - $period;

      // If the delete button is checked we delete our queue.
      if ($form_state->getTriggeringElement()['#id'] == 'edit-delete') {
        $queue->deleteQueue();
      }
      elseif ($run) {
        // We get a list of all nodes published on the site.
        $nids = \Drupal::entityQuery('node')
          ->condition('type', 'article')
          ->condition('status', 1)
          ->condition('changed', $time, '<=')
          ->sort('changed', 'DESC')
          ->range(0, $items)
          ->execute();

        # Create our queue.
        $queue->createQueue();

        // Adding data to the queue.
        foreach ($nids as $nid) {
          $queue->createItem([
            'id' => $nid,
            'label' => $label,
          ]);
        }
      }
    }

  }

}
