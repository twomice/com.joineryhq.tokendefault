<?php
use CRM_Tokendefault_ExtensionUtil as E;

class CRM_Tokendefault_Page_MosaicoJs extends CRM_Core_Page {

  public function run() {
    // Retrieve and assign custom field ID value for "in office".
    $tokendefaultsSets['sets'] = \Civi\Api4\TokendefaultsSet::get()->execute();
    $this->assign('tokendefault', $tokendefaultsSets);

    // Ensure content is sent as JavaScript.
    CRM_Core_Page_AJAX::setJsHeaders();

    // Parse the template and echo it directly, then exit (if we let civicrm
    // process the template normally, it will be wrapped with site chrome and
    // sent as HTML).
    $smarty = CRM_Core_Smarty::singleton();
    echo $smarty->fetch(self::getTemplateFileName());
    CRM_Utils_System::civiExit();
  }

}
