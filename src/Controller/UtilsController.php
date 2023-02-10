<?php

namespace Drupal\comuni_module\Controller;

use Drupal\Core\Controller\ControllerBase;


class UtilsController extends ControllerBase {

  /**
   * Called in comuni_module_install to copy themes from module to project.
   * Copies a file, or recursively copy a folder and its contents
   * 
   * @param   string   $source    Source path
   * @param   string   $dest      Destination path
   * @param   int      $permissions New folder creation permissions
   * @return  bool     Returns true on success, false on failure
   */
  public static function xcopy($source, $dest, $permissions = 0755) {
    $sourceHash = self::hashDirectory($source);
    // Check for symlinks
    if (is_link($source)) {
      return symlink(readlink($source), $dest);
    }

    // Simple copy for a file
    if (is_file($source)) {
      return copy($source, $dest);
    }

    // Make destination directory
    if (!is_dir($dest)) {
      mkdir($dest, $permissions);
    }

    // Loop through the folder
    $dir = dir($source);
    while (false !== $entry = $dir->read()) {
      // Skip pointers
      if ($entry == '.' || $entry == '..') {
        continue;
      }

      // Deep copy directories
      if ($sourceHash != self::hashDirectory($source . "/" . $entry)) {
        self::xcopy("$source/$entry", "$dest/$entry", $permissions);
      }
    }

    // Clean up
    $dir->close();
    return true;
  }

  /**
   * Called in function xcopy
   * In case of coping a directory inside itself, there is a need to hash check the directory otherwise and infinite loop of coping is generated
   * 
   * @param   string   $directory
   */
  public static function hashDirectory($directory) {
    if (!is_dir($directory)) {
      return false;
    }

    $files = array();
    $dir = dir($directory);

    while (false !== ($file = $dir->read())) {
      if ($file != '.' and $file != '..') {
        if (is_dir($directory . '/' . $file)) {
          $files[] = self::hashDirectory($directory . '/' . $file);
        } else {
          $files[] = md5_file($directory . '/' . $file);
        }
      }
    }

    $dir->close();

    return md5(implode('', $files));
  }
}
