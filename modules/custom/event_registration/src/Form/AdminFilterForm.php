<?php

namespace Drupal\event_registration\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

class AdminFilterForm extends FormBase {

  public function getFormId() {
    return 'admin_filter_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['event_date'] = [
      '#type' => 'select',
      '#title' => 'Event Date',
      '#options' => $this->getDates(),
      '#empty_option' => '- All -',
      '#ajax' => [
        'callback' => '::reloadTable',
        'wrapper' => 'table-wrapper',
      ],
    ];

    $form['event_name'] = [
      '#type' => 'select',
      '#title' => 'Event Name',
      '#options' => $this->getNames($form_state),
      '#empty_option' => '- All -',
      '#ajax' => [
        'callback' => '::reloadTable',
        'wrapper' => 'table-wrapper',
      ],
    ];
$form['export'] = [
  '#type' => 'submit',
  '#value' => 'Export CSV',
  '#submit' => ['::exportCsv'],
];

    $form['table_wrapper'] = [
      '#type' => 'container',
      '#attributes' => ['id' => 'table-wrapper'],
    ];

    $form['table_wrapper']['count'] = [
  '#markup' => '<h3>Total Participants: ' . $this->getCount($form_state) . '</h3>',
];

$form['table_wrapper']['table'] = $this->buildTable($form_state);


    return $form;
  }

  public function reloadTable(array &$form, FormStateInterface $form_state) {
    return $form['table_wrapper'];
  }

  private function getDates() {
    $result = Database::getConnection()
      ->select('event_registration', 'e')
      ->fields('e', ['event_date'])
      ->distinct()
      ->execute();

    $options = [];
    foreach ($result as $row) {
      $options[$row->event_date] = $row->event_date;
    }
    return $options;
  }

  private function getNames(FormStateInterface $form_state) {
    $date = $form_state->getValue('event_date');

    $query = Database::getConnection()
      ->select('event_registration', 'e')
      ->fields('e', ['event_name'])
      ->distinct();

    if ($date) {
      $query->condition('event_date', $date);
    }

    $result = $query->execute();

    $options = [];
    foreach ($result as $row) {
      $options[$row->event_name] = $row->event_name;
    }
    return $options;
  }

  private function buildTable(FormStateInterface $form_state) {

    $header = ['Name','Email','Date','Event','Category','College','Department'];

    $query = Database::getConnection()
      ->select('event_registration', 'e')
      ->fields('e');

    if ($form_state->getValue('event_date')) {
      $query->condition('event_date', $form_state->getValue('event_date'));
    }

    if ($form_state->getValue('event_name')) {
      $query->condition('event_name', $form_state->getValue('event_name'));
    }

    $result = $query->execute();

    $rows = [];
    foreach ($result as $row) {
      $rows[] = [
        $row->full_name,
        $row->email,
        $row->event_date,
        $row->event_name,
        $row->category,
        $row->college,
        $row->department,
      ];
    }

    return [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#empty' => 'No data',
    ];
  }
  private function getCount(FormStateInterface $form_state) {

  $query = \Drupal::database()->select('event_registration', 'e')
    ->countQuery();

  if ($form_state->getValue('event_date')) {
    $query->condition('event_date', $form_state->getValue('event_date'));
  }

  if ($form_state->getValue('event_name')) {
    $query->condition('event_name', $form_state->getValue('event_name'));
  }

  return $query->execute()->fetchField();
}

public function submitForm(array &$form, FormStateInterface $form_state) {
  // No submit needed (Ajax filters only)
}
public function exportCsv(array &$form, FormStateInterface $form_state) {

  $query = \Drupal::database()->select('event_registration', 'e')
    ->fields('e');

  if ($form_state->getValue('event_date')) {
    $query->condition('event_date', $form_state->getValue('event_date'));
  }

  if ($form_state->getValue('event_name')) {
    $query->condition('event_name', $form_state->getValue('event_name'));
  }

  $result = $query->execute();

  $filename = 'event_registrations.csv';

  header('Content-Type: text/csv');
  header('Content-Disposition: attachment; filename="'.$filename.'"');

  $handle = fopen('php://output', 'w');

  fputcsv($handle, [
    'Name','Email','Event Date','Event Name','Category','College','Department'
  ]);

  foreach ($result as $row) {
    fputcsv($handle, [
      $row->full_name,
      $row->email,
      $row->event_date,
      $row->event_name,
      $row->category,
      $row->college,
      $row->department,
    ]);
  }

  fclose($handle);
  exit();
}

}
