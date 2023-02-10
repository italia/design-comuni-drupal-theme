<?php

namespace Drupal\comuni_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\file\Entity\File;
use Drupal\media\Entity\Media;
use Drupal\node\Entity\Node;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\comuni_module\Controller\FileController;
class NodeController extends ControllerBase {

  /**
   * Called in comuni_module_node_presave to update field_formato_documento.
   * 
   * @param Node $node
   */
  public static function updateFileExtension($node) {
    $paragraph = Paragraph::load($node->field_paragraph_documento->target_id);
    $paragraphType = $paragraph->bundle();
    if ($paragraphType == 'link') {
      $fileUri = $paragraph->field_link->uri;
      $extension = pathinfo($fileUri)["extension"];
    } else {
      $mid = $paragraph->field_documento->target_id;
      $media = Media::load($mid);
      $fid = $media->field_media_document->target_id;
      $file = File::load($fid);
      if ($file && !empty($file)) {
        $fileUri = $file->createFileUrl(FALSE);
      }
    }
    if ($fileUri && !empty($fileUri)) {
      $extension = pathinfo($fileUri)["extension"];
      $node->field_formato_documento->setValue($extension);
    }
  }

  /**
   * @return array
   */
  public static function getLastNews() {
    $result = [];
    $database = Database::getConnection();
    $query = $database->query(
      "SELECT NFD.nid,
      NFD.title,
      NFD.created,
      NFI.field_immagine_target_id AS mid,
      NFDB.field_descrizione_breve_value AS short_desc,
      NFDDN.field_data_della_notizia_value AS custom_created
      FROM {node_field_data} AS NFD
      JOIN node__field_immagine AS NFI ON NFD.nid = NFI.entity_id
      JOIN node__field_descrizione_breve AS NFDB ON NFD.nid = NFDB.entity_id
      JOIN node__field_data_della_notizia AS NFDDN ON NFD.nid = NFDDN.entity_id
      WHERE NFD.type = 'notizia'
      AND NFD.status = 1
      ORDER BY NFDDN.field_data_della_notizia_value desc
      LIMIT 1"
    );
    $contents = (array) $query->fetchAll();
    foreach($contents as $content) {
      $nid = (int) $content->nid;
      $mid = $content->mid ?? NULL;
      $result[$nid] = $content;
      $result[$nid]->image = !empty($mid) ? FileController::getDataFromMedia($mid) : [];
      $result[$nid]->argomenti = self::getRelatedArgomenti($nid);
    }
    return $result;
  }

  /**
   * @param int $nid
   * 
   * @return array
   */
  public static function getRelatedArgomenti($nid) {
    $host = \Drupal::request()->getSchemeAndHttpHost();
    $database = Database::getConnection();
    $query = $database->query(
      "SELECT NFA.field_argomenti_target_id AS id,
      TTFD.name
      FROM {node__field_argomenti} AS NFA
      JOIN {node_field_data} AS NFD ON NFD.nid = NFA.entity_id
      JOIN {taxonomy_term_field_data} AS TTFD ON TTFD.tid = NFA.entity_id
      WHERE NFD.nid = :nid",
      [
        ':nid' => $nid,
      ]
    );
    $argomenti = (array) $query->fetchAll();
    foreach($argomenti as $key => $argomento) {
      $argomenti[$key]->alias = $host . \Drupal::service('path_alias.manager')->getAliasByPath('/taxonomy/term/' . $argomento->id);
    }
    return $argomenti;
  }
}
