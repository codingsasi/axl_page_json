<?php

namespace Drupal\axl_page_json\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\system\Form\SiteInformationForm;

/**
 * Custom site information form to override existing form.
 */
class CustomSiteInformationForm extends SiteInformationForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);
    $form['site_information']['siteapikey'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Site API Key'),
      '#default_value' => $this->config('system.site')->get('siteapikey') ?? $this->t('No API Key yet'),
      '#description' => $this->t("Enter Site API Key here."),
    ];
    $form['actions']['submit']['#value'] = $this->t('Update Configuration');
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
    if (!preg_match('/^[a-zA-Z0-9]*$/', $form_state->getValue('siteapikey'))
      && !empty($form_state->getValue('siteapikey'))) {
      $form_state->setErrorByName('siteapikey', 'The Site API key should be alphanumeric.');
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('system.site')
      ->set('siteapikey', $form_state->getValue('siteapikey'))
      ->save();
    $message = $form_state->getValue('siteapikey') ?
      'Site API key has been saved with the value: @siteapikey' : 'Site API Key has been cleared.';
    $this->messenger()->addMessage(
      $this->t($message,
        ['@siteapikey' => $this->config('system.site')->get('siteapikey')]
      )
    );
    parent::submitForm($form, $form_state);
  }

}
