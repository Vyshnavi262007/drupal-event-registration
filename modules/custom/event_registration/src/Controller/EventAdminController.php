<?php

namespace Drupal\event_registration\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;

class EventAdminController extends ControllerBase {

  public function registrations() {

    $header = [
      'id' => 'ID',
      'full_name' => 'Name',
      'email' => 'Email',
      'college' => 'College',
      'department' => 'Department',
      'created' => 'Date',
    ];

    $rows = [];

    $result = Database::getConnection()
      ->select('event_registration', 'e')
      ->fields('e')
      ->execute();

    foreach ($result as $row) {
      $rows[] = [
        $row->id,
        $row->full_name,
        $row->email,
        $row->college,
        $row->department,
        date('Y-m-d H:i', $row->created),
      ];
    }

    return [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#empty' => 'No registrations yet',
    ];
  }
}
