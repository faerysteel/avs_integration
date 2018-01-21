<?php

namespace Drupal\Tests\avs_integration\Functional;

use Drupal\Core\Url;
use Drupal\Tests\BrowserTestBase;

/**
 * Simple test to ensure that Alexa config page loads for administrators with module enabled.
 *
 * @group avs_integration
 */
class AlexaPathAnonLoadTest extends BrowserTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['node', 'avs_integration'];

  /**
   * A user with permission to administer site configuration.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $user;
  
  protected $settings_form_route = 'avs_integration.alexa_form';


  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    $this->user = $this->drupalCreateUser(['access content']);
    $this->drupalLogin($this->user);
    $config_factory = \Drupal::service('config.factory')->getEditable('avs_integration.alexa');
    $config_factory->set('path', 'any-path');
  }
  
  /**
   * Tests that the dynamic callback URL loads with a 200 response.
   */
  public function testAlexaCallbackURLIsAccessibleToAnon() {
    $this->drupalGet(Url::fromRoute('avs_integration.alexa_callback_url'));
    $this->assertSession()->statusCodeEquals(200);
  }
}
