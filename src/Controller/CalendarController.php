<?php

namespace Drupal\comuni_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;

class CalendarController extends ControllerBase {

  /**
   * Return as array of events starting in the next 7 days.
   * 
   * @return array
   */
  public static function getCalendarEvents() {
    $days = 7;
    $database = Database::getConnection();
    $host = \Drupal::request()->getSchemeAndHttpHost();
    $currentDate = (new \DateTime())->setTime(0, 0);
    $result = [];
    for ($i = 0; $i < $days; $i++) {
      if ($i > 1) {
        $date = $currentDate->modify("+1 days");
      } else {
        $date = $currentDate;
        $minDate = $date;
      }
      $minDate = clone $date;
      $maxDate = clone $date;
      $minDate = $minDate->modify("-1 days");
      $maxDate = $maxDate->modify("+1 days");
      $formattedDate = $date->format('Y-m-d');
      $formattedMinDate = $minDate->format('Y-m-d');
      $formattedMaxDate = $maxDate->format('Y-m-d');
      //$date->format('');
      // AND NFDT.field_data_e_orario_di_inizio_value = :date
      //AND DATE_FORMAT(NFDT.field_data_e_orario_di_inizio_value, '%Y-%m-%d') > :minDate
      //AND DATE_FORMAT(NFDT.field_data_e_orario_di_inizio_value, '%Y-%m-%d') < :maxDate
      $query = $database->query(
        "
        SELECT NFD.nid,
        NFD.title
        FROM {node_field_data} AS NFD
        JOIN node__field_data_e_orario_di_inizio AS NFDT ON NFD.nid = NFDT.entity_id
        WHERE NFD.type = 'evento'
        AND NFD.status = 1
        AND DATE_FORMAT(NFDT.field_data_e_orario_di_inizio_value, '%Y-%m-%d') > :minDate
        AND DATE_FORMAT(NFDT.field_data_e_orario_di_inizio_value, '%Y-%m-%d') < :maxDate
        LIMIT 4;",
        [
          ':minDate' => $formattedMinDate,
          ':maxDate' => $formattedMaxDate,
        ]
      );
      $contents = (array) $query->fetchAll();
      foreach ($contents as $key => $content) {
        $result[$formattedDate][$key] = $content;
        $result[$formattedDate][$key]->alias = $host . \Drupal::service('path_alias.manager')->getAliasByPath('/node/' . $content->nid);
      }
    }
    return $result;
  }
}
