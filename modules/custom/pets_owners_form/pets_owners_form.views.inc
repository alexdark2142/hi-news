<?php

/**
 * @file
 * Provide views data for pets_owners_form.module.
 */

/**
 * Implements hook_views_data().
 */
function pets_owners_form_views_data() {
  $data = [];

  $data['pets_owners_form']['table']['group'] = t('Users pets owners');
  $data['pets_owners_form']['table']['base'] = [
    'field' => '',
    'title' => t('Pets owners'),
    'help' => t('List of users of pet owners.'),
  ];

  $data['pets_owners_form']['id'] = [
    'title' => t('id'),
    'help' => t('User id.'),
    'field' => [
      'id' => 'standard',
    ],
  ];

  $data['pets_owners_form']['name'] = [
    'title' => t('Name'),
    'help' => t('User name.'),
    'field' => [
      'id' => 'standard',
    ],
  ];

  $data['pets_owners_form']['gender'] = [
    'title' => t('Gender'),
    'help' => t('User gender.'),
    'field' => [
      'id' => 'standard',
    ],
    'filter' => [
      'id' => 'string',
    ],
    'argument' => [
      'id' => 'string',
    ],
  ];

  $data['pets_owners_form']['prefix'] = [
    'title' => t('Prefix'),
    'help' => t('User gender prefix..'),
    'field' => [
      'id' => 'standard',
    ],
    'filter' => [
      'id' => 'pets_owners_sex',
    ],
    'argument' => [
      'id' => 'string',
    ],
  ];

  $data['pets_owners_form']['age'] = [
    'title' => t('Age'),
    'help' => t('User age.'),
    'field' => [
      'id' => 'numeric',
    ],
    'sort' => [
      'id' => 'standard',
    ],
    'filter' => [
      'id' => 'numeric',
    ],
    'argument' => [
      'id' => 'numeric',
    ]
  ];

  $data['pets_owners_form']['father_name'] = [
    'title' => t('Father name'),
    'help' => t('User`s father name.'),
    'field' => [
      'id' => 'standard',
    ],
  ];

  $data['pets_owners_form']['mother_name'] = [
    'title' => t('Mother name'),
    'help' => t('User`s mother name.'),
    'field' => [
      'id' => 'standard',
    ],
  ];

  $data['pets_owners_form']['pet_name'] = [
    'title' => t('Pet name'),
    'help' => t('User`s pet name.'),
    'field' => [
      'id' => 'standard',
    ],
  ];

  $data['pets_owners_form']['email'] = [
    'title' => t('Email'),
    'help' => t('User email.'),
    'field' => [
      'id' => 'standard',
    ],
  ];

  return $data;
}
