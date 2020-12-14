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
          'name' => E::ts('View and Edit Token Default'),
          'url' => 'civicrm/admin/tokendefault/default',
          'qs' => 'reset=1&sid=%%id%%',
          'title' => E::ts('View and Edit Token Default'),
        ],
        CRM_Core_Action::UPDATE => [
          'name' => E::ts('Settings'),
          'url' => 'civicrm/admin/tokendefault',
          'qs' => 'action=update&reset=1&id=%%id%%',
          'title' => E::ts('Edit Token Default Set'),
        ],
        CRM_Core_Action::DELETE => [
          'name' => E::ts('Delete'),
          'url' => 'civicrm/admin/tokendefault',
          'qs' => 'action=delete&reset=1&id=%%id%%',
          'title' => E::ts('Delete Token Default Set'),
        ],
      ];
    }
    return self::$_actionLinks;
  }

  public function run() {
    // get the requested action
    $action = CRM_Utils_Request::retrieve('action', 'String',
      // default to 'browse'
      $this, FALSE, 'browse'
    );

    if ($action & CRM_Core_Action::DELETE) {
      $session = CRM_Core_Session::singleton();
      $session->pushUserContext(CRM_Utils_System::url('civicrm/admin/tokendefault/', 'action=browse'));
      $controller = new CRM_Core_Controller_Simple('CRM_Tokendefault_Form_TokendefaultsSetDelete', "Delete Token Default Set", NULL);
      $id = CRM_Utils_Request::retrieve('id', 'Positive',
        $this, FALSE, 0
      );
      $controller->set('id', $id);
      $controller->setEmbedded(TRUE);
      $controller->process();
      $controller->run();
    }

    // assign vars to templates
    $this->assign('action', $action);
    $id = CRM_Utils_Request::retrieve('id', 'Positive',
      $this, FALSE, 0
    );

    // what action to take ?
    if ($action & (CRM_Core_Action::UPDATE | CRM_Core_Action::ADD)) {
      $this->edit($id, $action);
    }
    else {
      // finally browse the custom groups
      $this->browse();
    }

    CRM_Utils_System::setTitle(E::ts('Token Default Set'));

    parent::run();
  }

  /**
   * Edit custom group.
   *
   * @param int $id
   *   Custom group id.
   * @param string $action
   *   The action to be invoked.
   *
   * @return void
   */
  public function edit($id, $action) {
    // create a simple controller for editing custom data
    $controller = new CRM_Core_Controller_Simple('CRM_Tokendefault_Form_TokendefaultsSet', E::ts('Custom Set'), $action);

    // set the userContext stack
    $session = CRM_Core_Session::singleton();
    $session->pushUserContext(CRM_Utils_System::url('civicrm/admin/tokendefault/', 'action=browse'));
    $controller->set('id', $id);
    $controller->setEmbedded(TRUE);
    $controller->process();
    $controller->run();
  }

  /**
   * Browse all custom data groups.
   *
   * @param string $action
   *   The action to be invoked.
   *
   * @return void
   */
  public function browse($action = NULL) {
    $tokenDefaultSetsRow = [];
    $tokendefaultsSets = \Civi\Api4\TokendefaultsSet::get()->execute();
    foreach ($tokendefaultsSets as $tokendefaultsSet) {
      $id = $tokendefaultsSet['id'];
      $tokenDefaultSetsRow[$id]['id'] = $id;
      $tokenDefaultSetsRow[$id]['title'] = $tokendefaultsSet['title'];
      $tokenDefaultSetsRow[$id]['is_default'] = $tokendefaultsSet['is_default'];
      $tokenDefaultSetsRow[$id]['action'] = CRM_Core_Action::formLink(self::actionLinks(), $action,
        ['id' => $id],
        E::ts('more'),
        FALSE,
        'tokenDefaultSet.row.actions',
        'tokenDefaultSet',
        $id
      );
    }

    $this->assign('rows', $tokenDefaultSetsRow);
  }

}
