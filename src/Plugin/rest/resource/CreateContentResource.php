<?php

namespace Drupal\comuni_module\Plugin\rest\resource;

use Drupal\node\Entity\Node;
use Drupal\rest\ModifiedResourceResponse;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use mysql_xdevapi\Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Provides a resource to get view modes by entity and bundle.
 *
 * @RestResource(
 *   id = "create_content_resource",
 *   label = @Translation("Create content resource"),
 *   uri_paths = {
 *     "create" = "/api/v1/create/{type}"
 *   }
 * )
 */
class CreateContentResource extends ResourceBase {

  /**
   * A current user instance.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    $instance = parent::create($container, $configuration, $plugin_id, $plugin_definition);
    $instance->logger = $container->get('logger.factory')->get('comuni_module');
    $instance->currentUser = $container->get('current_user');


    return $instance;
  }

  /**
   * Responds to POST requests.
   *
   * @param string $payload
   *
   * @return \Drupal\rest\ModifiedResourceResponse
   *   The HTTP response object.
   *
   * @throws \Symfony\Component\HttpKernel\Exception\HttpException
   *   Throws exception expected.
   */
  public function post(Request $request) {
    try {
      $url = explode("/", $request->getUri());
      $type = (end($url));

      // You must to implement the logic of your REST Resource here.
      // Use current user after pass authentication to validate access.

      $response = $this->save($type,$request->getContent());
      return new ModifiedResourceResponse($response->getResponseData(), $response->getStatusCode());

    } catch(Exception $e) {
      return new ModifiedResourceResponse($e->getMessage(), $e->getStatusCode());
    };
  }

  public function validate($value) {
    if (is_string($value)) {
      return empty(trim($string));
    } else if (is_object($value)) {
      foreach ($value as $field) {
        $check = $this->validate($field);
        if ($check == true) return true;
      }
      return $false;
    } else {
      return $false;
    }
  }

  public function save($type, $payloadJson)
  {
    try {
      $payload = json_decode($payloadJson,true);
      $arrayInsertNode = [];
      $arrayInsertNode['type'] = $type;

      if ($this->validate($payload)) {
        return new ModifiedResourceResponse('Campi vuoti non ammessi', 542);
      }

      switch ($type) {
        case  'valutazione' :
          $arrayInsertNode['title'] = $payload['title'];

          $arrayInsertNode['field_stelle'] = $payload['star'];
          $arrayInsertNode['field_sottotitolo'] = $payload['radioResponse'];
          $arrayInsertNode['body'] = $payload['freeText'];
          $arrayInsertNode['field_nome'] = $payload['page'];

          break;
        case 'ticket' :
          $arrayInsertNode['title'] = $payload['title'];

          $arrayInsertNode['field_nome'] = $payload['nome'];
          $arrayInsertNode['field_cognome'] = $payload['cognome'];
          $arrayInsertNode['field_email'] = $payload['email'];
          $arrayInsertNode['field_categoria_servizio_txt'] = $payload['categoria'];
          $arrayInsertNode['field_nome_servizio_txt'] = $payload['servizio'];
          $arrayInsertNode['field_descrizione_breve'] = $payload['descrizione'];

          break;
        case 'appuntamento' :
          $arrayInsertNode['title'] = $payload['name']. ' '.$payload['surname'];
          $timeEndDate = strtotime($payload['appointment']['endDate']);
          $newformatEndDate = date('Y-m-d\TH:i:s',$timeEndDate);
          $timestartDate = strtotime($payload['appointment']['startDate']);
          $newformatstartDate = date('Y-m-d\TH:i:s',$timestartDate);

          $arrayInsertNode['field_email_richiedente'] = $payload['email'];
          $arrayInsertNode['field_data_e_ora_fine_appuntam'] = $newformatEndDate;
          $arrayInsertNode['field_data_e_ora_inizio_appuntam'] = $newformatstartDate;
          $arrayInsertNode['field_data_e_ora_prenotazione'] = date("Y-m-d\TH:i:s");
          $arrayInsertNode['field_dettaglio_richiesta'] = $payload['moreDetails'];
          $arrayInsertNode['field_nome'] = $payload['service'];
          $arrayInsertNode['field_sottotitolo'] = $payload['office'];
          break;
      }

      $node = Node::create($arrayInsertNode);
      $node->setUnpublished();
      $node->save();
      return new ModifiedResourceResponse('Contenuto creato con successo: ' . $node->id(), 200);
    } catch (Exception $e) {
      return new ModifiedResourceResponse($e->getMessage(), $e->getStatusCode());
    }
  }
}
