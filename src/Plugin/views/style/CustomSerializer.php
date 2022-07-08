<?php

namespace Drupal\comuni_module\Plugin\views\style;

use Drupal\rest\Plugin\views\style\Serializer;
use Drupal\Component\Serialization\Json;

/**
 * The style plugin for serialized output formats.
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "custom_serializer",
 *   title = @Translation("Nested Json Serializer"),
 *   help = @Translation("Serializes views row data and pager using the
 *   Serializer component."), display_types = {"data"}
 * )
 */
class CustomSerializer extends Serializer {

  /**
   * {@inheritdoc}
   */
  public function render() {
    $rows = [];

    // If the Data Entity row plugin is used, this will be an array of entities
    // which will pass through Serializer to one of the registered Normalizers,
    // which will transform it to arrays/scalars. If the Data field row plugin
    // is used, $rows will not contain objects and will pass directly to the
    // Encoder.
    foreach ($this->view->result as $row_index => $row) {
      $this->view->row_index = $row_index;
      $rows[] = $this->view->rowPlugin->render($row);
    }
    unset($this->view->row_index);

    // Get the content type configured in the display or fallback to the
    // default.
    if ((empty($this->view->live_preview))) {
      $content_type = $this->displayHandler->getContentType();
    }
    else {
      $content_type = !empty($this->options['formats']) ? reset($this->options['formats']) : 'json';
    }

    for ($i = 0; $i < count($rows); $i++) {
      foreach ($rows[$i] as $key => $value) {
        if (Json::decode($rows[$i][$key])) {
          $rows[$i][$key] = Json::decode($rows[$i][$key]);
        }
        if ($value == "[]") {
          $rows[$i][$key] = [];
        }
      }
    }
    
    if ($this->view->storage->get('id') === 'rest_survey') {
      foreach ($rows as $key => $row) {

        if (array_key_exists('questions', $row)) {

          $rows[$key]['questions'] = $rows[$key]['questions']['data'];

        }

      }
    }

    $pager = $this->view->pager;
    if($pager->getPluginId() == 'full') {

      $class = get_class($pager);
      $current_page = $pager->getCurrentPage();
      $items_per_page = $pager->getItemsPerPage();
      $total_items = $pager->getTotalItems();
      $total_pages = 0;
      if (!in_array($class, [
        'Drupal\views\Plugin\views\pager\None',
        'Drupal\views\Plugin\views\pager\Some'
      ])) {
        $total_pages = $pager->getPagerTotal();
      }

      $responseObj = [
        'data' => $rows,
        'pager' => [
          'current_page' => $current_page,
          'total_items' => $total_items,
          'total_pages' => $total_pages,
          'items_per_page' => $items_per_page,
        ],
        'count_data_obj' => $total_items
      ];
    } else {
      $responseObj = [
        'data' => $rows
      ];
    }


    return $this->serializer->serialize($responseObj, $content_type, ['views_style_plugin' => $this]);
  }

}
