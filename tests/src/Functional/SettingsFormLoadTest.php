<?php

namespace Drupal\Tests\avs_integration\Functional;

use Drupal\Core\Url;
use Drupal\Tests\BrowserTestBase;

/**
 * Simple test to ensure that Alexa config page loads for administrators with module enabled.
 *
 * @group avs_integration
 */
class SettingsFormLoadTest extends BrowserTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['avs_integration'];

  /**
   * A user with permission to administer site configuration.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $user;
  
  protected $settings_form_route = 'avs_integration.alexa_form';
  protected $test_path = 'any-path';
  protected $config_name = 'avs_integration.alexa';
  protected $config_item = 'path';

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    $this->user = $this->drupalCreateUser(['administer site configuration']);
    $this->drupalLogin($this->user);
  }
  
  /**
   * Tests that the Alexa settings page loads with a 200 response.
   */
  public function testAlexaFormRouterURLIsAccessibleToAdmin() {
    $this->drupalGet(Url::fromRoute($this->settings_form_route));
    $this->assertSession()->statusCodeEquals(200);
  }

  /**
   * Tests that the form has a field with the ID of "edit-path" to use.
   */
  public function testAlexaFormPathFieldExists() {
    $this->testAlexaFormRouterURLIsAccessibleToAdmin();
    $this->assertFieldById('edit-path', NULL);
  }
  
  /**
   * Tests that the form has a submit button to use.
   */
  public function testAlexaFormSubmitButtonExists() {
    $this->testAlexaFormRouterURLIsAccessibleToAdmin();
    $this->assertFieldById('edit-submit', NULL);
  }
  
  /**
   * Test the submission of the form.
   * @throws \Expection
   */
  public function testAlexaFormSubmitValid() {
    $this->drupalPostForm(
      Url::fromRoute($this->settings_form_route),
      array(
        'edit-path' => $this->test_path,
      ),
      t('Save configuration')
    );
    
    $this->assertUrl(Url::fromRoute($this->settings_form_route));
  }
  
  /**
   * Tests the form saved value to config.
   */
  public function testConfigSaved() {
    $this->testAlexaFormSubmitValid();
    $config_factory = \Drupal::config($this->config_name);
    $item = $config_factory->get($this->config_item);
    
    $this->assertTrue($this->test_path == $item);
  }
}
