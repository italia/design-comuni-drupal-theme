<?php

namespace Drupal\comuni_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\comuni_module\Controller\FileController;
use Drupal\taxonomy\Entity\Term;

class ThemeController extends ControllerBase {

  /**
   * @return array
   */
  /*public static function getInfoComune() {
    $data = [];
    $configPages = \Drupal::service('config_pages.loader');
    $configInfoComune = $configPages->load("info_comune");
    //dump($configInfoComune->field_test);
    $logoMid = $configInfoComune->field_logo->target_id;
    $data["logo"] = FileController::getDataFromMedia($logoMid);
    $data["nome_comune"] = $configInfoComune->field_nome_del_comune->value;
    $data["nome_regione"] = $configInfoComune->field_regione_di_appartenenza->value;
    $data["slogan"] = $configInfoComune->field_slogan->value;
    $data["amministrazione_trasparente"] = $configInfoComune->field_amministrazione_trasparent->value;
    $data["contatti"] = $configInfoComune->field_contatti_footer->value;
    $socials = $configInfoComune->field_social->referencedEntities();
    foreach ($socials as $social) {
      $iconMid = $social->field_icon->target_id;
      $data["social"][] = [
        "name" => $social->field_titolo->value ?? NULL,
        "icon" => FileController::getDataFromMedia($iconMid),
        "link" => $social->field_link->uri,
        "alt" => $social->field_link->title,
      ];
    }
    $icone = $configInfoComune->field_icone->referencedEntities();
    foreach ($icone as $icona) {
      $iconMid = $icona->field_icona->target_id;
      $data["icone"][] = [
        "content_type" => $icona->field_content_type->target_id,
        "icon" => FileController::getDataFromMedia($iconMid),
      ];
    }
    return $data;
  }*/

  /**
   * @return array
   */
  /*public static function getHomepage() {
    $data = [];
    $host = \Drupal::request()->getSchemeAndHttpHost();
    $configPages = \Drupal::service('config_pages.loader');
    $configInfoComune = $configPages->load("info_comune");
    $argomentiInEvidenza = $configInfoComune->field_argomenti_in_evidenza->referencedEntities();
    $altriArgomenti = $configInfoComune->field_argomenti->referencedEntities();
    foreach ($altriArgomenti as $altroArgomento) {
      $tid = $altroArgomento->id();
      $data["altri_argomenti"][$tid] =
      [
        "nome" => $altroArgomento->name->value,
        "alias" => $host . \Drupal::service('path_alias.manager')->getAliasByPath('/taxonomy/term/' . $tid),
      ];
    }
    foreach ($argomentiInEvidenza as $cardArgomento) {
      $tid = $cardArgomento->field_argomento->target_id;
      $argomento = Term::load($tid);
      $contenutiCard = $cardArgomento->field_contenuti_card->referencedEntities();
      foreach ($contenutiCard as $contenutoCard) {
        $nid = $contenutoCard->id();
        $bundle = $contenutoCard->bundle();
        $cards[$nid] = [
          "title" => $contenutoCard->title->value,
          "content_type" => $bundle,
          "alias" => $host . \Drupal::service('path_alias.manager')->getAliasByPath('/node/' . $nid),
        ];
        if ($bundle == "sito_tematico") {
          $cards[$nid]["color"] = [];
          $cards[$nid]["image"] = [];
          $cards[$nid]["color"] = [];
        }
      }
      $data["argomenti_in_evidenza"][$tid] =
      [
        "nome" => $argomento->name->value,
        "alias" => $host . \Drupal::service('path_alias.manager')->getAliasByPath('/taxonomy/term/' . $tid),
        "elementi" => $cards,
      ];
    }
    return $data;
  }*/
}
