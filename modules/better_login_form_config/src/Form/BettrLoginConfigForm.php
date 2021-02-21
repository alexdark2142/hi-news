<?php

namespace Drupal\better_login_form_config\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for BettrLogin forms.
 */
class BettrLoginConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'better_login_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);
    $login_form_config = $this->config('better_login_form_config.settings');
    $form['login_form_setting'] = [
      '#type' => 'details',
      '#title' => $this->t('Login Form'),
      '#open' => TRUE,
    ];
    $form['login_form_setting']['form_title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Login Form Title'),
      '#maxlength' => 120,
      '#attributes' => ['class' => ['form-title']],
      '#required' => TRUE,
      '#default_value' => $login_form_config->get('form_title'),
    ];
    $form['login_form_setting']['form_tab'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Login Form Tab'),
      '#maxlength' => 120,
      '#attributes' => ['class' => ['form-tab']],
      '#required' => TRUE,
      '#default_value' => $login_form_config->get('form_tab'),
    ];
    $form['login_form_setting']['username_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Username Label'),
      '#maxlength' => 120,
      '#attributes' => ['class' => ['username-label']],
      '#required' => TRUE,
      '#default_value' => $login_form_config->get('username_label'),
    ];
    $form['login_form_setting']['username_description'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Username Description'),
      '#maxlength' => 180,
      '#attributes' => ['class' => ['username-description']],
      '#default_value' => $login_form_config->get('username_description') ,
    ];
    $form['login_form_setting']['password_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Password Label'),
      '#maxlength' => 120,
      '#attributes' => ['class' => ['password-label']],
      '#required' => TRUE,
      '#default_value' => $login_form_config->get('password_label'),
    ];
    $form['login_form_setting']['password_description'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Password Description'),
      '#maxlength' => 180,
      '#attributes' => ['class' => ['password-description']],
      '#default_value' => $login_form_config->get('password_description') ,
    ];
    $form['login_form_setting']['login_button'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Login button text'),
      '#maxlength' => 60,
      '#required' => TRUE,
      '#attributes' => ['class' => ['login-button']],
      '#default_value' => $login_form_config->get('login_button') ,
    ];
    $form['login_form_setting']['include_login'] = [
      '#type' => 'checkbox',
      '#default_value' => $login_form_config->get('include_login'),
      '#title' => $this->t('Exclude login Form Template'),
    ];
    $form['forgot_form_setting'] = [
      '#type' => 'details',
      '#title' => $this->t('Forgot Password Form'),
      '#open' => FALSE,
    ];
    $form['forgot_form_setting']['forgot_form_title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Forgot Form Title'),
      '#maxlength' => 120,
      '#attributes' => ['class' => ['forgot_form_title']],
      '#required' => TRUE,
      '#default_value' => $login_form_config->get('forgot_form_title'),
    ];
    $form['forgot_form_setting']['forgot_form_tab'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Forgot Form Tab'),
      '#maxlength' => 120,
      '#attributes' => ['class' => ['forgot_form_tab']],
      '#required' => TRUE,
      '#default_value' => $login_form_config->get('forgot_form_tab') ,
    ];
    $form['forgot_form_setting']['forgot_form_username'] = [
      '#type' => 'textfield',
      '#title' => $this->t('User Name or Email Label'),
      '#maxlength' => 120,
      '#attributes' => ['class' => ['forgot_form_username']],
      '#required' => TRUE,
      '#default_value' => $login_form_config->get('forgot_form_username'),
    ];
    $form['forgot_form_setting']['forgot_form_username_desc'] = [
      '#type' => 'textfield',
      '#title' => $this->t('User Name or Email Description'),
      '#maxlength' => 180,
      '#attributes' => ['class' => ['forgot_form_username_desc']],
      '#default_value' => $login_form_config->get('forgot_form_username_desc'),
    ];
    $form['forgot_form_setting']['forgot_form_button'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Forgot Form Button'),
      '#maxlength' => 60,
      '#required' => TRUE,
      '#attributes' => ['class' => ['forgot_form_button']],
      '#default_value' => $login_form_config->get('forgot_form_button') ,
    ];
    $form['forgot_form_setting']['include_forgot_template'] = [
      '#type' => 'checkbox',
      '#default_value' => $login_form_config->get('include_forgot_template') ,
      '#title' => $this->t('Exclude Forgot Password Form Template'),
    ];
    $form['register_form_setting'] = [
      '#type' => 'details',
      '#title' => $this->t('Register Form'),
      '#open' => FALSE,
    ];
    $form['register_form_setting']['register_form_title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Register Form Title'),
      '#maxlength' => 180,
      '#required' => TRUE,
      '#attributes' => ['class' => ['register_form_title']],
      '#default_value' => $login_form_config->get('register_form_title') ,
    ];
    $form['register_form_setting']['register_form_tab'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Register Form Tab'),
      '#maxlength' => 120,
      '#required' => TRUE,
      '#attributes' => ['class' => ['register_form_tab']],
      '#default_value' => $login_form_config->get('register_form_tab') ,
    ];
    $form['register_form_setting']['register_form_mail'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Register Mail Label'),
      '#maxlength' => 120,
      '#required' => TRUE,
      '#attributes' => ['class' => ['register_form_mail']],
      '#default_value' => $login_form_config->get('register_form_mail') ,
    ];
    $form['register_form_setting']['register_mail_desc'] = [
      '#type' => 'textfield',
      '#title' => $this->t('EMail Description'),
      '#maxlength' => 180,
      '#attributes' => ['class' => ['register_mail_desc']],
      '#default_value' => $login_form_config->get('register_mail_desc'),
    ];
    $form['register_form_setting']['register_form_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Register Name Label'),
      '#required' => TRUE,
      '#attributes' => ['class' => ['register_form_name']],
      '#default_value' => $login_form_config->get('register_form_title') ,
    ];
    $form['register_form_setting']['register_form_name_desc'] = [
      '#type' => 'textfield',
      '#title' => $this->t('User Name Description'),
      '#maxlength' => 180,
      '#attributes' => ['class' => ['register_form_name_desc']],
      '#default_value' => $login_form_config->get('register_form_name_desc') ,
    ];
    $form['register_form_setting']['register_form_button'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Register button Text'),
      '#maxlength' => 60,
      '#required' => TRUE,
      '#attributes' => ['class' => ['register_form_button']],
      '#default_value' => $login_form_config->get('register_form_button') ,
    ];
    $form['register_form_setting']['include_regi_template'] = [
      '#type' => 'checkbox',
      '#default_value' => $login_form_config->get('include_regi_template'),
      '#title' => $this->t('Exclude Register Form Template'),
    ];
    $form['create_account'] = [
      '#type' => 'checkbox',
      '#default_value' => $login_form_config->get('create_account') ,
      '#title' => $this->t('Create New Account'),
    ];
    $form['forgot_password'] = [
      '#type' => 'checkbox',
      '#default_value' => $login_form_config->get('forgot_password') ,
      '#title' => $this->t('Forgot your password?'),
    ];
    $form['back_to_home'] = [
      '#type' => 'checkbox',
      '#default_value' => $login_form_config->get('forgot_password'),
      '#title' => $this->t('Back to Home Page'),
    ];
    $form['login_page_link'] = [
      '#type' => 'checkbox',
      '#default_value' => $login_form_config->get('login_page_link') ,
      '#title' => $this->t('Login page link'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('better_login_form_config.settings');
    $config->set('form_title', $form_state->getValue('form_title'));
    $config->set('form_tab', $form_state->getValue('form_tab'));
    $config->set('username_label', $form_state->getValue('username_label'));
    $config->set('username_description', $form_state->getValue('username_description'));
    $config->set('password_label', $form_state->getValue('password_label'));
    $config->set('password_description', $form_state->getValue('password_description'));
    $config->set('login_button', $form_state->getValue('login_button'));
    $config->set('login_page_link', $form_state->getValue('login_page_link'));
    $config->set('create_account', $form_state->getValue('create_account'));
    $config->set('forgot_password', $form_state->getValue('forgot_password'));
    $config->set('back_to_home', $form_state->getValue('back_to_home'));
    $config->set('forgot_form_title', $form_state->getValue('forgot_form_title'));
    $config->set('forgot_form_tab', $form_state->getValue('forgot_form_tab'));
    $config->set('register_form_title', $form_state->getValue('register_form_title'));
    $config->set('register_form_tab', $form_state->getValue('register_form_tab'));
    $config->set('register_form_mail', $form_state->getValue('register_form_mail'));
    $config->set('register_mail_desc', $form_state->getValue('register_mail_desc'));
    $config->set('register_form_name', $form_state->getValue('register_form_name'));
    $config->set('register_form_name_desc', $form_state->getValue('register_form_name_desc'));
    $config->set('register_form_button', $form_state->getValue('register_form_button'));
    $config->set('forgot_form_username_desc', $form_state->getValue('forgot_form_username_desc'));
    $config->set('forgot_form_username', $form_state->getValue('forgot_form_username'));
    $config->set('forgot_form_button', $form_state->getValue('forgot_form_button'));
    $config->set('include_login', $form_state->getValue('include_login'));
    $config->set('include_regi_template', $form_state->getValue('include_regi_template'));
    $config->set('include_forgot_template', $form_state->getValue('include_forgot_template'));
    $config->save();
    return parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['better_login_form_config.settings'];
  }

}
