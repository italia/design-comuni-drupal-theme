<?php

namespace Drupal\comuni_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Drupal\menu_link_content\Entity\MenuLinkContent;
use Drush\Commands\DrushCommands;

class MenuController extends ControllerBase {

  public static function importMenu() {
    $menus = [
      'topleft' => [
        'name' => 'Top left',
        'link' => (Url::fromUri('route:<nolink>'))->toUriString(),
        'values' => [
          'Amministrazione' => [
            'link' => 'internal:/amministrazione',
          ],
          'Servizi' =>  [
            'link' => 'internal:/servizi',
          ],
          'Novità' =>  [
            'link' => 'internal:/novita',
          ],
          'Vivere il comune' =>  [
            'link' => 'internal:/vivere-il-comune'
          ],
        ]
      ],
      'topright' => [
        'name' => 'Top right',
        'link' => (Url::fromUri('route:<nolink>'))->toUriString(),
        'values' => [
          'Acqua' =>  [
            'link' => 'internal:/tutti-gli-argomenti/acqua'
          ],
          'Agricoltura' =>  [
            'link' => 'internal:/tutti-gli-argomenti/agricoltura'
          ],
          'Animale domestico' =>  [
            'link' => 'internal:/tutti-gli-argomenti/animale-domestico'
          ],
          'Tutti gli argomenti' =>  [
            'link' => 'internal:/tutti-gli-argomenti'
          ],
        ],
      ],
      'customfooter' => [
        'name' => 'Footer - Navigazione',
        'link' => (Url::fromUri('route:<nolink>'))->toUriString(),
        'values' => [
          'Amministrazione' => [
            'link' => (Url::fromUri('route:<nolink>'))->toUriString(),
            'values' => [
              'Organi di governo' => [
                'link' => 'internal:/#',
              ],
              'Aree amministrative' => [
                'link' => 'internal:/#',
              ],
              'Uffici' => [
                'link' => 'internal:/#',
              ],
              'Enti e fondazioni' => [
                'link' => 'internal:/#',
              ],
              'Politici' => [
                'link' => 'internal:/#',
              ],
              'Personale amministrativo' => [
                'link' => 'internal:/#',
              ],
              'Documenti e dati' => [
                'link' => 'internal:/documenti-e-dati',
              ],
            ],
          ],
          'Categorie di servizio' => [
            'link' => (Url::fromUri('route:<nolink>'))->toUriString(),
            'values' => [
              'Anagrafe e stato civile' => [
                'link' => 'internal:/categorie-dei-servizi/anagrafe-e-stato-civile'
              ],
              'Cultura e tempo libero' => [
                'link' => 'internal:/categorie-dei-servizi/cultura-e-tempo-libero',
              ],
              'Vita lavorativa' => [
                'link' => 'internal:/categorie-dei-servizi/vita-lavorativa',
              ],
              'Imprese e commercio' => [
                'link' => 'internal:/categorie-dei-servizi/imprese-e-commercio',
              ],
              'Appalti pubblici' => [
                'link' => 'internal:/categorie-dei-servizi/appalti-pubblici',
              ],
              'Catasto e urbanistica' => [
                'link' => 'internal:/categorie-dei-servizi/catasto-e-urbanistica',
              ],
              'Turismo' => [
                'link' => 'internal:/categorie-dei-servizi/turismo',
              ],
              'Mobilità e trasporti' => [
                'link' => 'internal:/categorie-dei-servizi/mobilita-e-trasporti',
              ],
              'Educazione e formazione' => [
                'link' => 'internal:/categorie-dei-servizi/educazione-e-formazione',
              ],
              'Giustizia e sicurezza pubblica' => [
                'link' => 'internal:/categorie-dei-servizi/giustizia-e-sicurezza-pubblica',
              ],
              'Tributi, finanze e contravvenzioni' => [
                'link' => 'internal:/categorie-dei-servizi/tributi-finanze-e-contravvenzioni'
              ],
              'Ambiente' => [
                'link' => 'internal:/categorie-dei-servizi/ambiente',
              ],
              'Salute, benessere e assistenza' => [
                'link' => 'internal:/categorie-dei-servizi/salute-benessere-e-assistenza',
              ],              
              'Autorizzazioni' => [
                'link' => 'internal:/categorie-dei-servizi/autorizzazioni'
              ],
              'Agricoltura e pesca' => [
                'link' => 'internal:/categorie-dei-servizi/agricoltura-e-pesca',
              ],
            ],
          ],
          'Novità' => [
            'link' => (Url::fromUri('route:<nolink>'))->toUriString(),
            'values' => [
              'Notizie' => [
                'link' => 'internal:/#'
              ],
              'Comunicati' => [
                'link' => 'internal:/#',
              ],
              'Avvisi' => [
                'link' => 'internal:/#'
              ],
            ],
          ],
          'Vivere il comune' => [
            'link' => (Url::fromUri('route:<nolink>'))->toUriString(),
            'values' => [
              'Luoghi' => [
                'link' => 'internal:/#'
              ],
              'Eventi' =>  [
                'link' => 'internal:/#',
              ],
            ],
          ],
        ],
      ],
      'footer---contatti' => [
        'name' => 'Footer - Contatti',
        'link' => (Url::fromUri('route:<nolink>'))->toUriString(),
        'values' => [
          'Leggi le FAQ' =>  [
            'link' => 'internal:/domande-frequenti',
          ],
          'Prenotazione appuntamento' =>  [
            'link' => 'internal:/#',
          ],
          'Segnalazione disservizio' =>  [
            'link' => 'internal:/#',
          ],
          "Richiesta di assistenza" =>  [
            'link' => 'internal:/richiedi-assistenza',
          ],
          'Amministrazione trasparente' =>  [
            'link' => 'internal:/#',
          ],
          'Informativa privacy' =>  [
            'link' => 'internal:/#',
          ],
          'Note legali' =>  [
            'link' => 'internal:/#',
          ],
          'Dichiarazione di accessibilità' =>  [
            'link' => 'internal:/#',
          ],
        ],
      ],
      'footer' => [
        'name' => 'Footer',
        'link' => (Url::fromUri('route:<nolink>'))->toUriString(),
        'values' => [
          'Mappa del sito' => [
            'link' => 'internal:/#',
          ],
          'Media policy' =>  [
            'link' => 'internal:/#',
          ],
        ],
      ],
    ];

    foreach ($menus as $menuId => $menu) {
      //Create menu if does not exist.
      // $nolink = (Url::fromUri('route:<nolink>'))->toUriString();
      $currentMenu = \Drupal::entityTypeManager()->getStorage('menu')->load($menuId);
      if ($currentMenu == NULL) {
        //\Drupal::entityTypeManager()->getStorage('menu')->load($menuId)->delete();
        \Drupal::entityTypeManager()
          ->getStorage('menu')
          ->create([
            'id' => $menuId,
            'label' => $menu["name"],
            'description' => '',
          ])->save();
      }


      //Create menu links.
      if (!empty($menu["values"])) {
        foreach ($menu["values"] as $menuLinkTitle => $menuLinkInfo) {
          $menuLink = MenuLinkContent::create([
            'title' => $menuLinkTitle,
            'link' => Url::fromUri($menuLinkInfo["link"])->toUriString(),
            'menu_name' => $menuId,
            'expanded' => TRUE,
          ]);
          $menuLink->save();
          if (isset($menuLinkInfo["values"])) {
            $parentPluginId = $menuLink->getPluginId();
            //Create nested links.
            foreach ($menuLinkInfo["values"] as $nestedMenuLinkTitle => $nestedMenuLinkInfo) {
              $nested_menu_link = MenuLinkContent::create([
                'title' => $nestedMenuLinkTitle,
                'link' => Url::fromUri($nestedMenuLinkInfo["link"])->toUriString(),
                'menu_name' => $menuId,
                'expanded' => TRUE,
                'parent' => $parentPluginId
              ]);
              $nested_menu_link->save();
            }
          }
        }
      }
    }
  }
}
