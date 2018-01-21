<?php

namespace Drupal\avs_integration\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class AlexaController.
 */
class AlexaController extends ControllerBase {

  public function content() {
    $return = array();
    // Do something
    return new \Symfony\Component\HttpFoundation\JsonResponse($return);
  }
}
