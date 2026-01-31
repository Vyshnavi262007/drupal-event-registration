<?php

namespace Drupal\event_registration\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class EventConfigForm extends ConfigFormBase {

  protected function getEditableConfigNames() {
    return ['event_registration.settings'];
  }

  public function getFormId() {
    return 'event_config_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    $config = $this->config('event_registration.settings');

    $form['start_date'] = [
      '#type' => 'date',
      '#title' => $this->t('Registration Start Date'),
      '#default_value' => $config->get('start_date'),
      '#required' => TRUE,
    ];

    $form['end_date'] = [
      '#type' => 'date',
      '#title' => $this->t('Registration End Date'),
      '#default_value' => $config->get('end_date'),
      '#required' => TRUE,
    ];

    $form['event_date'] = [
      '#type' => 'date',
      '#title' => $this->t('Event Date'),
      '#required' => TRUE,
    ];

    $form['event_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Event Name'),
      '#required' => TRUE,
    ];

    $form['category'] = [
      '#type' => 'select',
      '#title' => $this->t('Category'),
      '#options' => [
        'Online Workshop' => 'Online Workshop',
        'Hackathon' => 'Hackathon',
        'Conference' => 'Conference',
        'One-day Workshop' => 'One-day Workshop',
      ],
      '#required' => TRUE,
    ];

    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {

    // Save dates in config (for registration open/close)
    $this->config('event_registration.settings')
      ->set('start_date', $form_state->getValue('start_date'))
      ->set('end_date', $form_state->getValue('end_date'))
      ->save();

    // Save full event data in database table
    \Drupal::database()->insert('event_config')
      ->fields([
        'start_date' => $form_state->getValue('start_date'),
        'end_date' => $form_state->getValue('end_date'),
        'event_date' => $form_state->getValue('event_date'),
        'event_name' => $form_state->getValue('event_name'),
        'category' => $form_state->getValue('category'),
      ])
      ->execute();

    parent::submitForm($form, $form_state);
  }

}
