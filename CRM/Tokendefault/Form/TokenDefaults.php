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
        $this->addElement('checkbox', "active_{$tokenDefault['id']}");
        $this->add('text', "token_{$tokenDefault['id']}", NULL, [
          'class' => 'crm-token-selector big',
        ]);
        $this->add('text', "default_{$tokenDefault['id']}", NULL);

        $tokenDefNewArr[$tokenDefault['id']]['active'] = "active_{$tokenDefault['id']}";
        $tokenDefNewArr[$tokenDefault['id']]['token'] = "token_{$tokenDefault['id']}";
        $tokenDefNewArr[$tokenDefault['id']]['default'] = "default_{$tokenDefault['id']}";
      }
    }

    $this->addElement('checkbox', "active_{$tokenDefaultsNextCount}");
    $this->add('text', "token_{$tokenDefaultsNextCount}", NULL, [
      'class' => 'crm-token-selector big',
    ]);
    $this->add('text', "default_{$tokenDefaultsNextCount}", NULL);
    $this->add('hidden', "token_row_count", NULL);
    $tokenDefNewArr[$tokenDefaultsNextCount]['active'] = "active_{$tokenDefaultsNextCount}";
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
    $this->addFormRule(['CRM_Tokendefault_Form_TokenDefaults', 'formRule'], $this);
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
        $defaults["active_{$tokenDefault['id']}"] = $tokenDefault['is_active'];
        $defaults["token_{$tokenDefault['id']}"] = $tokenDefault['token'];
        $defaults["default_{$tokenDefault['id']}"] = $tokenDefault['default'];
      }

      $defaults["token_row_count"] = $this->getTokenDefaults()->rowCount + 1;
    }

    return $defaults;
  }

  /**
   * Global validation rules for the form.
   *
   * @param array $values
   *   Posted values of the form.
   *
   * @return array
   *   list of errors to be posted back to the form
   */
  public function formRule($values) {
    $errors = [];
    $tokensDefaults = [];

    foreach ($values as $key => $value) {
      $keyExplode = explode('_', $key);
      $fieldID = end($keyExplode);
      $fieldLabel = $keyExplode[0];

      if (intval($fieldID)) {
        $tokensDefaults[$fieldID][$fieldLabel] = $value;
      }
    }

    foreach($tokensDefaults as $tokenID => $tokenDefault) {
      if (!empty($tokenDefault['token']) && empty($tokenDefault['default'])) {
        $errorField = "default_{$tokenID}";
        $errors[$errorField] = ts('Please enter a default value for this token');
      }

      if (empty($tokenDefault['token']) && !empty($tokenDefault['default'])) {
        $errorField = "token_{$tokenID}";
        $errors[$errorField] = ts('Please enter a token before adding a default value');
      }
    }

    return $errors;
  }

  /**
   * Process the form submission.
   */
  public function postProcess() {
    $values = $this->exportValues();
    $tokensDefaults = [];
    $results = \Civi\Api4\Tokendefaults::delete()
                ->addWhere('id', 'IS NOT NULL')
                ->execute();

    foreach ($values as $key => $value) {
      $keyExplode = explode('_', $key);
      $fieldID = end($keyExplode);
      $fieldLabel = $keyExplode[0];

      if (intval($fieldID) && !empty($value)) {
        $tokensDefaults[$fieldID][$fieldLabel] = $value;
      }
    }

    foreach ($tokensDefaults as $tokenID => $tokenDefault) {
      $isActive = isset($tokenDefault['active']) ? $tokenDefault['active'] : 0;
      $results = \Civi\Api4\Tokendefaults::create()
                ->addValue('token', $tokenDefault['token'])
                ->addValue('default', $tokenDefault['default'])
                ->addValue('is_active', $isActive)
                ->execute();
    }

    CRM_Core_Session::setStatus(E::ts('You picked color "%1"', array(
      1 => json_encode($values),
    )));

    CRM_Utils_System::redirect(CRM_Utils_System::url('civicrm/admin/tokendefaults/defaults',
      "reset=1"
    ));

    parent::postProcess();
  }

  public function getTokens() {
    $tokens = CRM_Core_SelectValues::contactTokens();
    return $tokens;
  }

  public function getTokenDefaults() {
    $tokenDefaults = \Civi\Api4\Tokendefaults::get()->execute();
    return $tokenDefaults;
  }

}
