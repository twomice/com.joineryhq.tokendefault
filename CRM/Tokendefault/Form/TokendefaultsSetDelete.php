<?php

use CRM_Tokendefault_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Tokendefault_Form_TokendefaultsSetDelete extends CRM_Core_Form {

  public function preProcess() {
    $id = CRM_Utils_Request::retrieve('id', 'Positive',
      $this, FALSE, 0
    );

    $tokendefaultsSets = \Civi\Api4\TokendefaultsSet::get()
      ->addWhere('id', '=', $id)
      ->execute();
    foreach ($tokendefaultsSets as $tokendefaultsSet) {
      $this->assign('title', $tokendefaultsSet['title']);
    }
  }

  public function buildQuickForm() {

    $this->addButtons([
      [
        'type' => 'next',
        'name' => E::ts('Delete Token Default Set'),
        'isDefault' => TRUE,
      ],
      [
        'type' => 'cancel',
        'name' => E::ts('Cancel'),
      ],
    ]);

    parent::buildQuickForm();
  }

  public function postProcess() {
    $id = CRM_Utils_Request::retrieve('id', 'Positive',
      $this, FALSE, 0
    );

    $results = \Civi\Api4\TokendefaultsSet::delete()
      ->addWhere('id', '=', $id)
      ->execute();

    CRM_Core_Session::setStatus(E::ts('Token Default Set has been deleted!'), E::ts('Token Defaults'), 'success');

    CRM_Utils_System::redirect(CRM_Utils_System::url('civicrm/admin/tokendefault',
      "reset=1"
    ));

    parent::postProcess();
  }

}
