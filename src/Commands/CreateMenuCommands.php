<?php
namespace Drupal\comuni_module\Commands;

use Drupal\comuni_module\Controller\MenuController;
use Drush\Commands\DrushCommands;


/**
 * Drush command file.
 */
class CreateMenuCommands extends DrushCommands {

  /**
   * A custom Drush command to displays the given text.
   *
   * @command drush-create-menus:generate
   */
  public function generate()
  {
      MenuController::importMenu();
  }
}
