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

    if ($tokenDefaultsCount > 0) {
      foreach ($this->getTokenDefaults() as $tokenDefault) {
        // unset($tokens['{' . $tokenDefault['token'] . '}']);

        $this->addElement('checkbox', 'is_active[' . $tokenDefault['id'] . ']');
        $this->add('text', 'token[' . $tokenDefault['id'] . ']', NULL, [
          'class' => 'crm-token-selector big',
        ]);
        $this->add('text', 'default[' . $tokenDefault['id'] . ']', NULL);
      }
    }

    $this->addElement('checkbox', 'is_active[' . ($tokenDefaultsCount + 1) . ']');
    $this->add('text', 'token[' . ($tokenDefaultsCount + 1) . ']', NULL, [
      'class' => 'crm-token-selector big',
    ]);
    $this->add('text', 'default[' . ($tokenDefaultsCount + 1) . ']', NULL);

    $this->assign('tokens', CRM_Utils_Token::formatTokensForDisplay($tokens));
    $this->assign('tokenDefaults', $this->getTokenDefaults());
    $this->assign('tokenDefaultsCount', $tokenDefaultsCount + 1);

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
        $defaults['is_active[' . $tokenDefault['id'] . ']'] = TRUE;
        $defaults['token[' . $tokenDefault['id'] . ']'] = $tokenDefault['token'];
        $defaults['default[' . $tokenDefault['id'] . ']'] = $tokenDefault['default'];
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
