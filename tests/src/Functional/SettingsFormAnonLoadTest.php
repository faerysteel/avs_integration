<?php

namespace Drupal\Tests\avs_integration\Functional;

use Drupal\Core\Url;
use Drupal\Tests\BrowserTestBase;

/**
 * Simple test to ensure that Alexa config page loads for administrators with module enabled.
 *
 * @group avs_integration
 */
class SettingsFormAnonLoadTest extends BrowserTestBase {

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
  }
  
  /**
   * Tests that the Alexa settings page loads with a 403 response.
   */
  public function testAlexaFormRouterURLIsNotAccessibleToAnon() {
    $this->drupalGet(Url::fromRoute($this->settings_form_route));
    $this->assertSession()->statusCodeEquals(403);
  }
}
