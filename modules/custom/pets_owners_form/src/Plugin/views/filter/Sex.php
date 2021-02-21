<?php

/**
 * @file
 * Definition of Drupal\pets_owners_form\Plugin\views\filter\Sex.
 */

namespace Drupal\pets_owners_form\Plugin\views\filter;

use Drupal\views\Plugin\views\display\DisplayPluginBase;
use Drupal\views\Plugin\views\filter\InOperator;
use Drupal\views\ViewExecutable;

/**
 * Filters by given list of sex options.
 *
 * @ingroup views_filter_handlers
 *
 * @ViewsFilter("pets_owners_sex")
 */
class Sex extends InOperator {

  /**
   * {@inheritdoc}
   */
  public function init(ViewExecutable $view, DisplayPluginBase $display, array &$options = NULL) {
    parent::init($view, $display, $options);
    $this->valueTitle = t('Sex');
    $this->definition['options callback'] = array($this, 'generateOptions');
  }

  /**
   * Override the query so that no filtering takes place if the user doesn't
   * select any options.
   */
  public function query() {
    if (!empty($this->value)) {
      if ($this->value[0] === 'ms') {
        $this->value[] = 'mrs';
      }
      if ($this->value['ms'] === 'ms') {
        $this->value[] = 'mrs';
      }
      parent::query();
    }
  }

  /**
   * Skip validation if no options have been chosen so we can use it as a
   * non-filter.
   */
  public function validate() {
    if (!empty($this->value)) {
      parent::validate();
    }
  }

  /**
   * Helper function that generates the options.
   * @return array
   */
  public function generateOptions() {
    // Array keys are used to compare with the table field values.
    return [
      'mr' => $this->t('Man'),
      'ms' => $this->t('Woman'),
    ];
  }

}