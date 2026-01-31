<?php

namespace Drupal\event_registration\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

class EventRegisterForm extends FormBase {

  public function getFormId() {
    return 'event_register_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['category'] = [
      '#type' => 'select',
      '#title' => $this->t('Category'),
      '#options' => $this->getCategories(),
      '#empty_option' => '- Select -',
      '#ajax' => [
        'callback' => '::loadDates',
        'wrapper' => 'date-wrapper',
      ],
      '#required' => TRUE,
    ];

    $form['date_wrapper'] = [
      '#type' => 'container',
      '#attributes' => ['id' => 'date-wrapper'],
    ];

    $form['date_wrapper']['event_date'] = [
      '#type' => 'select',
      '#title' => $this->t('Event Date'),
      '#options' => $this->getDates($form_state),
      '#empty_option' => '- Select -',
      '#ajax' => [
        'callback' => '::loadNames',
        'wrapper' => 'name-wrapper',
      ],
      '#required' => TRUE,
    ];

    $form['name_wrapper'] = [
      '#type' => 'container',
      '#attributes' => ['id' => 'name-wrapper'],
    ];

    $form['name_wrapper']['event_name'] = [
      '#type' => 'select',
      '#title' => $this->t('Event Name'),
      '#options' => $this->getNames($form_state),
      '#empty_option' => '- Select -',
      '#required' => TRUE,
    ];

    $form['full_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Full Name'),
      '#required' => TRUE,
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#required' => TRUE,
    ];

    $form['college'] = [
      '#type' => 'textfield',
      '#title' => $this->t('College'),
      '#required' => TRUE,
    ];

    $form['department'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Department'),
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Register'),
    ];

    return $form;
  }

  /* ================= AJAX ================= */

  public function loadDates(array &$form, FormStateInterface $form_state) {
    return $form['date_wrapper'];
  }

  public function loadNames(array &$form, FormStateInterface $form_state) {
    return $form['name_wrapper'];
  }

  /* ================= DATABASE ================= */

  private function getCategories() {
    $result = Database::getConnection()
      ->select('event_config', 'e')
      ->fields('e', ['category'])
      ->distinct()
      ->execute();

    $options = [];
    foreach ($result as $row) {
      $options[$row->category] = $row->category;
    }

    return $options;
  }

  private function getDates(FormStateInterface $form_state) {
    $category = $form_state->getValue('category');
    if (!$category) return [];

    $result = Database::getConnection()
      ->select('event_config', 'e')
      ->fields('e', ['event_date'])
      ->condition('category', $category)
      ->distinct()
      ->execute();

    $options = [];
    foreach ($result as $row) {
      $options[$row->event_date] = $row->event_date;
    }

    return $options;
  }

  private function getNames(FormStateInterface $form_state) {
    $category = $form_state->getValue('category');
    $date = $form_state->getValue('event_date');

    if (!$category || !$date) return [];

    $result = Database::getConnection()
      ->select('event_config', 'e')
      ->fields('e', ['event_name'])
      ->condition('category', $category)
      ->condition('event_date', $date)
      ->execute();

    $options = [];
    foreach ($result as $row) {
      $options[$row->event_name] = $row->event_name;
    }

    return $options;
  }

  /* ================= VALIDATION ================= */

  public function validateForm(array &$form, FormStateInterface $form_state) {

    $pattern = '/^[a-zA-Z\s]+$/';

    if (!preg_match($pattern, $form_state->getValue('full_name'))) {
      $form_state->setErrorByName('full_name', 'Only letters allowed.');
    }

    if (!preg_match($pattern, $form_state->getValue('college'))) {
      $form_state->setErrorByName('college', 'Only letters allowed.');
    }

    if (!preg_match($pattern, $form_state->getValue('department'))) {
      $form_state->setErrorByName('department', 'Only letters allowed.');
    }

    // Duplicate check
    $exists = Database::getConnection()
      ->select('event_registration', 'e')
      ->fields('e', ['id'])
      ->condition('email', $form_state->getValue('email'))
      ->condition('event_date', $form_state->getValue('event_date'))
      ->execute()
      ->fetchField();

    if ($exists) {
      $form_state->setErrorByName('email', 'You already registered for this event.');
    }
  }

  /* ================= SUBMIT ================= */

  public function submitForm(array &$form, FormStateInterface $form_state) {

    Database::getConnection()->insert('event_registration')
      ->fields([
        'full_name' => $form_state->getValue('full_name'),
        'email' => $form_state->getValue('email'),
        'college' => $form_state->getValue('college'),
        'department' => $form_state->getValue('department'),
        'event_date' => $form_state->getValue('event_date'),
        'event_name' => $form_state->getValue('event_name'),
        'category' => $form_state->getValue('category'),
        'created' => time(),
      ])
      ->execute();
    $mailManager = \Drupal::service('plugin.manager.mail');

$params = [
  'name' => $form_state->getValue('full_name'),
  'event_name' => $form_state->getValue('event_name'),
  'event_date' => $form_state->getValue('event_date'),
  'category' => $form_state->getValue('category'),
];

$mailManager->mail(
  'event_registration',
  'registration_confirm',
  $form_state->getValue('email'),
  \Drupal::currentUser()->getPreferredLangcode(),
  $params
);

    $this->messenger()->addStatus('Registration successful!');
  }

}
