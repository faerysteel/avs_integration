<?php

/**
 * @file
 * Contains \Drupal\avs_integration\Routing\RouteSubscriber
 */

namespace Drupal\avs_integration\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Defines dynamic routes.
 */
class RouteSubscriber extends RouteSubscriberBase {

  private $path;

  public function __construct(\Drupal\Core\Config\ConfigFactory $config_factory) {
    $config = $config_factory->get('avs_integration.alexa');
    $this->path = $config->get('path');
  }
   
  /**
   * {@inheritdoc}
   */
  public function alterRoutes(RouteCollection $collection) {
    $path = $this->path;

    if (substr($path, 0, 1) !== '/') {
      $path = '/' . $path;
    }
    \Drupal::logger('test')->notice($path);

    $route = new Route(
      $path,
      array(
        '_controller' => '\Drupal\avs_integration\Controller\AlexaController::content',
        '_title' => 'Alexa Callback',
      ),
      array(
        '_permission' => 'access content',
      )
    );

    $collection->add('avs_integration.alexa', $route);
  }
}
