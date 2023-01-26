<?php

namespace Drupal\comuni_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\file\Entity\File;
use Drupal\media\Entity\Media;

class FileController extends ControllerBase {

  /**
   * Returns data from media. Supported media type types: document, image, image_svg.
   * 
   * @param   string|int   $mid
   * @param   string       $type
   * 
   * @return array
   */
  public static function getDataFromMedia($mid, $type = "image") {
    $infos = [];
    $media = Media::load($mid);
    if(!empty($media)) {
      if ($type == "image") {
        $infos = $media->field_media_image->getValue()[0];
      } elseif ($type == "document") {
        $infos = $media->field_media_document->getValue()[0];
      }
      if(!empty($infos["target_id"])) {
        $file = File::load($infos["target_id"]);
        if (isset($file)) {
          $infos["uri"] = $file->createFileUrl(FALSE);
        }
      }
    }
    return $infos;
  }
}
