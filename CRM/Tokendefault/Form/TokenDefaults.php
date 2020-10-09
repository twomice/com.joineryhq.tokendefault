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
      for ($i = 0; $i < $tokenDefaultsNextCount; $i++) {
        $this->addElement('checkbox', "active_{$i}");
        $this->add('text', "token_{$i}", NULL, [
          'class' => 'crm-token-selector big',
        ]);
        $this->add('text', "default_{$i}", NULL);

        $tokenDefNewArr[$i]['active'] = "active_{$i}";
        $tokenDefNewArr[$i]['token'] = "token_{$i}";
        $tokenDefNewArr[$i]['default'] = "default_{$i}";
      }
    }

    $this->add('hidden', "token_row_count", NULL);
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
        'name' => E::ts('Cancel'),
      ),
    ));

    CRM_Core_Resources::singleton()->addStyleFile('com.joineryhq.tokendefault', 'css/tokendefaults.css');
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
    $tokenDefaults = $this->getTokenDefaults();
    $tokenDefaultsCount = $tokenDefaults->rowCount;

    if ($tokenDefaultsCount > 0) {
      for ($i = 0; $i < $tokenDefaultsCount; $i++) {
        $defaults["active_{$i}"] = $tokenDefaults[$i]['is_active'];
        $defaults["token_{$i}"] = $tokenDefaults[$i]['token'];
        $defaults["default_{$i}"] = $tokenDefaults[$i]['default'];
      }

      $defaults["token_row_count"] = $tokenDefaultsCount + 1;
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
    $tokens = [];
    $tokenRowCount = $values['token_row_count'];

    for ($i = 0; $i < $tokenRowCount; $i++) {
      if (!empty($values["token_{$i}"]) && empty($values["default_{$i}"])) {
        $errorField = "default_{$i}";
        $errors[$errorField] = E::ts('Please enter a default value for this token');
      }

      if (empty($values["token_{$i}"]) && !empty($values["default_{$i}"])) {
        $errorField = "token_{$i}";
        $errors[$errorField] = E::ts('Please enter a token before adding a default value');
      }

      if (!empty($values["token_{$i}"])) {
        $tokens[$i] = $values["token_{$i}"];
      }
    }

    $tokenValuesCount = count(array_unique($tokens));

    if ($tokenRowCount != $tokenValuesCount) {
      $duplicateValues = array_diff_assoc($tokens, array_unique($tokens));
      foreach ($duplicateValues as $value) {
        $duplicateField = array_search($value, $values);
        $errors[$duplicateField] = E::ts('There is a duplicate on this token.');
      }
    }

    return $errors;
  }

  /**
   * Process the form submission.
   */
  public function postProcess() {
    $values = $this->getSubmitValues();
    $tokenRowCount = $values['token_row_count'];
    $results = \Civi\Api4\Tokendefaults::delete()
                ->addWhere('id', 'IS NOT NULL')
                ->execute();

    for ($i = 0; $i < $tokenRowCount; $i++) {
      if (!empty($values["token_{$i}"])) {
        $isActive = !empty($values["active_{$i}"]) ? 1 : 0;
        $results = \Civi\Api4\Tokendefaults::create()
                  ->addValue('token', $values["token_{$i}"])
                  ->addValue('default', $values["default_{$i}"])
                  ->addValue('is_active', $isActive)
                  ->execute();
      }
    }

    CRM_Core_Session::setStatus(E::ts('Defaults saved'), E::ts('Token Defaults'), 'success');

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
