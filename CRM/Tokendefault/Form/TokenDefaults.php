<?php

use CRM_Tokendefault_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Tokendefault_Form_TokenDefaults extends CRM_Core_Form {

  public function buildQuickForm() {
    $tokens = $this->getTokens();
    $tokenDefaultsCount = $this->getTokenDefaults()->rowCount;
    $tokenDefaultsNextCount = $tokenDefaultsCount + 1;
    $tokenDefNewArr = [];

    if ($tokenDefaultsCount > 0) {
      foreach ($this->getTokenDefaults() as $tokenDefault) {
        if ($tokenDefault['is_active']) {
          $this->addElement('checkbox', "is_active_{$tokenDefault['id']}");
          $this->add('text', "token_{$tokenDefault['id']}", NULL, [
            'class' => 'crm-token-selector big',
          ]);
          $this->add('text', "default_{$tokenDefault['id']}", NULL);

          $tokenDefNewArr[$tokenDefault['id']]['is_active'] = "is_active_{$tokenDefault['id']}";
          $tokenDefNewArr[$tokenDefault['id']]['token'] = "token_{$tokenDefault['id']}";
          $tokenDefNewArr[$tokenDefault['id']]['default'] = "default_{$tokenDefault['id']}";
        }
      }
    }

    $this->addElement('checkbox', "is_active_{$tokenDefaultsNextCount}");
    $this->add('text', "token_{$tokenDefaultsNextCount}", NULL, [
      'class' => 'crm-token-selector big',
    ]);
    $this->add('text', "default_{$tokenDefaultsNextCount}", NULL);
    $tokenDefNewArr[$tokenDefaultsNextCount]['is_active'] = "is_active_{$tokenDefaultsNextCount}";
    $tokenDefNewArr[$tokenDefaultsNextCount]['token'] = "token_{$tokenDefaultsNextCount}";
    $tokenDefNewArr[$tokenDefaultsNextCount]['default'] = "default_{$tokenDefaultsNextCount}";

    $this->assign('tokens', CRM_Utils_Token::formatTokensForDisplay($tokens));
    $this->assign('tokenDefaults', $tokenDefNewArr);

    $this->addButtons(array(
      array(
        'type' => 'submit',
        'name' => E::ts('Submit'),
        'isDefault' => TRUE,
      ),
      array(
        'type' => 'cancel',
        'name' => ts('Cancel'),
      ),
    ));

    parent::buildQuickForm();
  }

  /**
   * Set default values.
   *
   * @return array
   */
  public function setDefaultValues() {
    $defaults = parent::setDefaultValues();

    if ($this->getTokenDefaults()->rowCount > 0) {
      foreach ($this->getTokenDefaults() as $tokenDefault) {
        $defaults["is_active_{$tokenDefault['id']}"] = $tokenDefault['is_active'];
        $defaults["token_{$tokenDefault['id']}"] = $tokenDefault['token'];
        $defaults["default_{$tokenDefault['id']}"] = $tokenDefault['default'];
      }
    }

    return $defaults;
  }

  public function postProcess() {
    $values = $this->exportValues();
    $options = $this->getColorOptions();
    CRM_Core_Session::setStatus(E::ts('You picked color "%1"', array(
      1 => $options[$values['favorite_color']],
    )));
    parent::postProcess();
  }

  public function getTokens() {
    $tokens = CRM_Core_SelectValues::contactTokens();
    return $tokens;
  }

  public function getTokenDefaults() {
    $tokenDefaults = \Civi\Api4\Tokendefaults::get()->setLimit()->execute();
    return $tokenDefaults;
  }

}
