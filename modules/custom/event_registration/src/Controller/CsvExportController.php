<?php

namespace Drupal\event_registration\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\Response;

class CsvExportController extends ControllerBase {

  public function export() {

    $result = Database::getConnection()
      ->select('event_registration', 'e')
      ->fields('e')
      ->execute();

    $csv = "Name,Email,Event Date,Event Name,Category,College,Department,Submitted\n";

    foreach ($result as $row) {
      $csv .= "{$row->full_name},{$row->email},{$row->event_date},{$row->event_name},{$row->category},{$row->college},{$row->department}," . date('Y-m-d', $row->created) . "\n";
    }

    return new Response(
      $csv,
      200,
      [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="registrations.csv"',
      ]
    );
  }

}
