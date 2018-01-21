<?php

namespace Drupal\avs_integration\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class AlexaForm.
 */
class AlexaForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'avs_integration.alexa',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'alexa_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('avs_integration.alexa');

    $path = $config->get('path');
    $form['path'] = array(
      '#type' => 'textfield',
      '#size' => 60,
      '#default_value' => $path,
      '#title' => t('Callback Path'),
      '#description' => t('Enter the callback path for Alexa Voice Services'),
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->configFactory->getEditable('avs_integration.alexa');
    $config->set('path', $form_state->getValue('path'));
    $config->save();
    parent::submitForm($form, $form_state);
  }

}
