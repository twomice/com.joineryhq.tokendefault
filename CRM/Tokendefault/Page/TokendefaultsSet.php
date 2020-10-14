<?php
use CRM_Tokendefault_ExtensionUtil as E;

class CRM_Tokendefault_Page_TokendefaultsSet extends CRM_Core_Page {

  /**
   * The action links that we need to display for the browse screen
   *
   * @var array
   */
  private static $_actionLinks;

  /**
   * Get the action links for this page.
   *
   *
   * @return array
   *   array of action links that we need to display for the browse screen
   */
  public static function &actionLinks() {
    // check if variable _actionsLinks is populated
    if (!isset(self::$_actionLinks)) {
      self::$_actionLinks = [
        CRM_Core_Action::BROWSE => [
          'name' => ts('View and Edit Token Default'),
          'url' => 'civicrm/admin/tokendefault/default',
          'qs' => 'reset=1&sid=%%id%%',
          'title' => ts('View and Edit Token Default'),
        ],
        CRM_Core_Action::UPDATE => [
          'name' => ts('Settings'),
          'url' => 'civicrm/admin/tokendefault',
          'qs' => 'action=update&reset=1&id=%%id%%',
          'title' => ts('Edit Token Default Set'),
        ],
        CRM_Core_Action::DELETE => [
          'name' => ts('Delete'),
          'url' => 'civicrm/admin/tokendefault',
          'qs' => 'action=delete&reset=1&id=%%id%%',
          'title' => ts('Delete Token Default Set'),
        ],
      ];
    }
    return self::$_actionLinks;
  }

  public function run() {
    // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
    CRM_Utils_System::setTitle(E::ts('Token Default Set'));

    // Example: Assign a variable for use in a template
    $this->assign('currentTime', date('Y-m-d H:i:s'));

    parent::run();
  }

}
