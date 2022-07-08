<?php

namespace Drupal\comuni_module\TwigExtension;

use Drupal\cactus_backend\Controller\Cactus;
use Drupal\cactus_backend\Controller\Injections;
use Drupal\file\Entity\File;
use Drupal\media\Entity\Media;
use Drupal\taxonomy\Entity\Term;
use \Twig\Extension\AbstractExtension;
use \Twig\TwigFunction;
use \Twig\TwigFilter;

/**
 * Class CactusTwig.
 */
class ComuniTwig extends AbstractExtension
{

  /**
   * {@inheritdoc}
   */
  public function getName()
  {
    return 'cactus_backend.twig.extension';
  }

  /**
   * {@inheritdoc}
   * Return your custom twig function to Drupal
   */
  public function getFunctions()
  {
    return [
      new TwigFunction('registerController', [
        $this,
        'registerController',
        [
          "is_safe" => TRUE,
        ],
      ]),
      new TwigFunction('getRegisteredControllers', [
        $this,
        'getRegisteredControllers',
        [
          "is_safe" => TRUE,
        ],
      ]),
      new TwigFunction('getInjections', [
        $this,
        'getInjections',
        [
          "is_safe" => TRUE,
        ],
      ]),
      new TwigFunction('getTranslatedUrl', [
        $this,
        'getTranslatedUrl',
        [
          "is_safe" => TRUE,
        ],
      ]),
      new TwigFunction('loadTaxonomy', [
        $this,
        'loadTaxonomy',
        [
          "is_safe" => TRUE,
        ],
      ]),
      new TwigFunction('getTitle', [
        $this,
        'getTitle',
        [
          "is_safe" => TRUE,
        ],
      ]),
      new TwigFunction('getUrlFromMedia', [
        $this,
        'getUrlFromMedia',
        [
          "is_safe" => TRUE,
        ],
      ]),
      new TwigFunction('dayEn2It', [
        $this,
        'dayEn2It',
        [
          "is_safe" => TRUE,
        ],
      ]),
      new TwigFunction('monthEn2It', [
        $this,
        'monthEn2It',
        [
          "is_safe" => TRUE,
        ],
      ]),
      new TwigFunction('strpad', [
        $this,
        'strpad',
        [
          "is_safe" => TRUE,
        ],
      ]),
    ];
  }

  /**
   * {@inheritdoc}
   * Return your custom twig filter to Drupal
   */
  public function getFilters()
  {
    return [
      new TwigFilter('tokens', [$this, 'tokens']),
      new TwigFilter('colorize', [$this, 'colorize']),
      new TwigFilter('string_value', [$this, 'string_value']),
      new TwigFilter('getUrlFromMedia', [$this, 'getUrlFromMedia']),
      new TwigFilter('dayEn2It', [$this, 'dayEn2It']),
      new TwigFilter('monthEn2It', [$this, 'monthEn2It']),
      new TwigFilter('strpad', [$this, 'strpad'])
    ];
  }

  /**
   * Replaces available values to entered tokens
   * Also accept HTML text
   *
   * @param string $text
   *   replaceable tokens with/without entered HTML text
   *
   * @return string
   *   replaced token values with/without entered HTML text
   */
  public function tokens($text)
  {
    return \Drupal::token()->replace($text);
  }

  public function hex2rgba($hex, $opacity = 1){
    list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
    return sprintf('rgba(%s, %s, %s, %s)', $r, $g, $b, $opacity);
  }


  /**
   * Filters color hex input and opacity render to obtain a valid style markup
   *
   * @param $colorString
   * @param string $mode
   *
   * @return string
   */
  public function colorize($colorString)
  {
    $ret = "";
    $raw = explode(" ", trim($this -> string_value($colorString)));

    $hex = $raw[0] ?? false;
    if($hex) {

      $opacity = $raw[1] ?? '1';
      $color = $this -> hex2rgba($hex, $opacity);
      if($color) {
        $ret = "background-color: " . $color . "; ";
      }
    }
    return $ret;
  }

  public function registerController($id = '', $mode = 'async')
  {
    $cactus = new Cactus();
    if ($id) {
      $cactus->registerController($id, $mode);
    }
  }

  public function getRegisteredControllers()
  {
    $cactus = new Cactus();
    return $cactus->getRegisteredControllers();
  }

  public function getInjections($position = 'body')
  {
    $injections = new Injections();
    return $injections->build($position);
  }

  public function string_value($element)
  {
    return preg_replace('/\s+/', ' ', trim(preg_replace("/[^\w -_]+/i", "", strip_tags(\Drupal::service('twig.extension')->renderVar($element)))));
  }

  public function getTranslatedUrl($node, $lang)
  {
    $ret = "";
    if (isset($node) && $node->hasTranslation($lang)) {
      $node = $node->getTranslation($lang);
      if ($node) {
        $ret = $node->toUrl();
      }
    }
    return $ret;
  }

  public function loadTaxonomy($vid, $view_mode = 'full')
  {
    $vocabulary =  \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($vid);
    $language = \Drupal::languageManager()->getCurrentLanguage()->getId();
    $results = [];

    foreach ($vocabulary as $term) {

      $results[] = \Drupal::service('twig_tweak.entity_view_builder')
        ->build(\Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($term->tid), $view_mode, $language, FALSE);
    }

    return $results;

  }

  public function getTitle($vid){
    $term = \Drupal::entityTypeManager()->getStorage('taxonomy_vocabulary')->load($vid);

    $title = $term->get('name');

    return $title;
  }

  public function getUrlFromMedia($mid) {
    if ($mid) {
      $media = Media::load($mid);
      if (is_null($media)) {
        return null;
      } else {
        $fid = $media->getSource()->getSourceFieldValue($media);
        $file = File::load($fid);
        return $url = $file->createFileUrl();
      }
    }
  }

  public function dayEn2It($englishName, $short=true) {
    if ($short) {
      $days = array(
        'Mon' =>  'lun',
        'Tue' =>  'mar',
        'Wed' =>  'mer',
        'Thu' =>  'gio',
        'Fri' =>  'ven',
        'Sat' =>  'sab',
        'Sun' =>  'dom',
      );
    } else {
      $days = array(
        'Monday' =>  'Lunedì',
        'Tuesday' =>  'Martedì',
        'Wednesday' =>  'Mercoledì',
        'Thursday' =>  'Giovedì',
        'Friday' =>  'Venerdì',
        'Saturday' =>  'Sabato',
        'Sunday' =>  'Domenica',
      );
    }
    return $days[$englishName];
  }

  public function monthEn2It($englishName, $short=true) {
    if ($short) {
      $months = array(
        'Jan' =>  'Gen',
        'Feb' =>  'Feb',
        'Mar' =>  'Mar',
        'Apr' =>  'Apr',
        'May' =>  'Mag',
        'Jun' =>  'Giu',
        'Jul' =>  'Lug',
        'Aug' =>  'Ago',
        'Sep' =>  'Set',
        'Oct' =>  'Ott',
        'Nov' =>  'Nov',
        'Dec' =>  'Dic',
      );
    } else {
      $months = array(
        'January' =>  'Gennaio',
        'February' =>  'Febbraio',
        'March' =>  'Marzo',
        'April' =>  'Aprile',
        'May' =>  'Maggio',
        'Jun' =>  'Giugno',
        'July' =>  'Luglio',
        'August' =>  'Agosto',
        'September' =>  'Settembre',
        'October' =>  'Ottobre',
        'November' =>  'Novembre',
        'December' =>  'Dicembre',
      );
    }
    return $months[$englishName];
  }

  public function strpad($string, $length, $pad_string) {
    if (is_null($string)) {
      return null;
    } elseif (is_null($length)) {
      return $string;
    } else {
      return str_pad($string, $length, $pad_string, STR_PAD_LEFT);
    }
  }
}
