<?php

require_once 'tokendefault.civix.php';
// phpcs:disable
use CRM_Tokendefault_ExtensionUtil as E;
// phpcs:enable

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function tokendefault_civicrm_config(&$config) {
  _tokendefault_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function tokendefault_civicrm_xmlMenu(&$files) {
  _tokendefault_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function tokendefault_civicrm_install() {
  _tokendefault_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function tokendefault_civicrm_postInstall() {
  _tokendefault_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function tokendefault_civicrm_uninstall() {
  _tokendefault_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function tokendefault_civicrm_enable() {
  _tokendefault_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function tokendefault_civicrm_disable() {
  _tokendefault_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function tokendefault_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _tokendefault_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function tokendefault_civicrm_managed(&$entities) {
  _tokendefault_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function tokendefault_civicrm_caseTypes(&$caseTypes) {
  _tokendefault_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function tokendefault_civicrm_angularModules(&$angularModules) {
  _tokendefault_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function tokendefault_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _tokendefault_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function tokendefault_civicrm_entityTypes(&$entityTypes) {
  _tokendefault_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_thems().
 */
function tokendefault_civicrm_themes(&$themes) {
  _tokendefault_civix_civicrm_themes($themes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 */
//function tokendefault_civicrm_preProcess($formName, &$form) {
//
//}

/**
 * Implements hook_civicrm_alterAngular().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterAngular/
 *
 */
function tokendefault_civicrm_alterAngular(\Civi\Angular\Manager $angular) {
  // Alter angular content for Mailing page, by adding some buttons and a div
  // that can function as a jQuery-ui dialog.
  $changeSet = \Civi\Angular\ChangeSet::create('inject_tokendefault_tools')
    ->alterHtml('~/crmMailing/BodyHtml.html',
      function (phpQueryObject $doc) {
        $tokendefaultsSets = \Civi\Api4\TokendefaultsSet::get()->execute();
        $setOptions = '';

        foreach ($tokendefaultsSets as $tokendefaultsSet) {
          $isDefault = $tokendefaultsSet['is_default'] ? 'selected' : '';
          $setOptions .= "<option value='{$tokendefaultsSet['id']}' {$isDefault}>{$tokendefaultsSet['title']}</option>";
        }

        $doc->find('input[crm-mailing-token]')->before('
          <div id="tokendefaultSelector" title="Token Default Set" style="display:none">
            <select name="tokendefault-set" style="margin: 2em; min-width: 20em;">' . $setOptions . '</select>
          </div>
        ' .
        // Quick-and-dirty: we're not really using AngularJS to handle this custom
        // feature, instead just using good old-fashioned jQuery. This means our
        // call to $.dialog() won't be fired on page load, so we fire it on-click
        // of the "Select Public Official" button; thus we have here all the
        // params for $.dialog(), such as dialog properties, buttons, etc.
        '
          <a id="tokendefaultSelectorOpen" onclick="CRM.$( \'#tokendefaultSelector\' ).dialog({width: \'auto\', modal: true,   buttons: [
            {
              text: \'Cancel\',
              icon: \'fa-times\',
              click: function() {
                CRM.$( this ).dialog( \'close\' );
              }
            },
            {
              text: \'Select\',
              icon: \'fa-check\',
              click: function() {
                tokendefault.insertHtmlTokenDefaultSet(\'textarea[name=body_html]\', \'select[name=tokendefault-set]\');
                CRM.$( this ).dialog( \'close\' );
              }
            }
          ]});" style="float:left; margin-bottom: 10px;" class="button"><span>{{ts("Select Token Default Set")}}<span></a>
        ');
      });
  $angular->add($changeSet);
  CRM_Core_Resources::singleton()->addScriptFile('com.joineryhq.tokendefault', 'js/tokendefault-utils.js');
}

function tokendefault_civicrm_mosaicoConfig(&$config) {
  if (_tokendefault_civicrm_checkMosaicoHooks()) {
    $config['tinymceConfig']['external_plugins']['tokendefault'] = CRM_Core_Resources::singleton()->getUrl('com.joineryhq.tokendefault', 'js/tinymce-plugins/tokendefault/plugin.js', 1);
    $config['tinymceConfig']['plugins'][0] .= ' tokendefault';
    $config['tinymceConfig']['toolbar1'] .= ' tokendefault';
    $config['tinymceConfig']['tokendefault'] = TRUE;
  }
}

function tokendefault_civicrm_mosaicoScriptUrlsAlter(&$scriptUrls) {
  $res = CRM_Core_Resources::singleton();

  $coreResourceList = $res->coreResourceList('html-header');
  $coreResourceList = array_filter($coreResourceList, 'is_string');
  foreach ($coreResourceList as $item) {
    if (
      FALSE !== strpos($item, 'js')
      && !strpos($item, 'crm.menubar.js')
      && !strpos($item, 'crm.wysiwyg.js')
      && !strpos($item, 'l10n-js')
    ) {
      if ($res->isFullyFormedUrl($item)) {
        $itemUrl = $item;
      }
      else {
        $item = CRM_Core_Resources::filterMinify('civicrm', $item);
        $itemUrl = $res->getUrl('civicrm', $item, TRUE);
      }
      $scriptUrls[] = $itemUrl;
    }
  }

  // Include our own JS.
  $url = $res->addCacheCode(CRM_Utils_System::url('civicrm/tokendefault/mosaico-js', '', TRUE, NULL, NULL, NULL, NULL));
  $scriptUrls[] = $url;
}

function tokendefault_civicrm_mosaicoStyleUrlsAlter(&$styleUrls) {
  $res = CRM_Core_Resources::singleton();

  // Load custom or core css
  $config = CRM_Core_Config::singleton();
  if (!Civi::settings()->get('disable_core_css')) {
    $styleUrls[] = $res->getUrl('civicrm', 'css/civicrm.css', TRUE);
  }
  if (!empty($config->customCSSURL)) {
    $customCSSURL = $res->addCacheCode($config->customCSSURL);
    $styleUrls[] = $customCSSURL;
  }
  // crm-i.css added ahead of other styles so it can be overridden by FA.
  array_unshift($styleUrls, $res->getUrl('civicrm', 'css/crm-i.css', TRUE));

  $coreResourceList = $res->coreResourceList('html-header');
  $coreResourceList = array_filter($coreResourceList, 'is_string');
  foreach ($coreResourceList as $item) {
    if (
      FALSE !== strpos($item, 'css')
      // Exclude jquery ui theme styles, which conflict with Mosaico styles.
      && FALSE === strpos($item, '/jquery-ui/themes/')
    ) {
      if ($res->isFullyFormedUrl($item)) {
        $itemUrl = $item;
      }
      else {
        $item = CRM_Core_Resources::filterMinify('civicrm', $item);
        $itemUrl = $res->getUrl('civicrm', $item, TRUE);
      }
      $styleUrls[] = $itemUrl;
    }
  }

  // Include our own abridged styles from jquery-ui 'smoothness' theme, as
  // required for our jquery-ui dialog, but which don't conflict with Mosaico.
  $styleUrls[] = $res->getUrl('com.joineryhq.tokendefault', 'css/jquery-ui-smoothness-partial.css', TRUE);
}

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 */
function tokendefault_civicrm_navigationMenu(&$menu) {
  _tokendefault_civix_insert_navigation_menu($menu, 'Administer/Customize Data and Screens', array(
    'label' => E::ts('Token Defaults'),
    'name' => 'Token Defaults',
    'url' => 'civicrm/admin/tokendefault?reset=1',
    'permission' => 'access CiviCRM',
  ));
  _tokendefault_civix_navigationMenu($menu);
}

/**
 * Implements hook_civicrm_tokens().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_tokens
 *
 */
function tokendefault_civicrm_tokens(&$tokens) {
  $tokens['TokenDefault'] = [];
}

/**
 * Implements hook_civicrm__tokenValues().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_tokenValues
 */
function tokendefault_civicrm_tokenValues(&$values, $cids, $job = NULL, $tokenGroups = [], $context = NULL) {
  // Normalize tokens for CiviMail vs non-civiMail.
  $tokenGroups = _tokendefault_normalize_token_values($tokenGroups);

  $setId = NULL;
  if (isset($tokenGroups['TokenDefault'])) {
    foreach ($tokenGroups['TokenDefault'] as $tokenGroupTokens) {
      if (preg_match('/set___([0-9]+)/', $tokenGroupTokens, $matches)) {
        $setId = $matches[1];

        break;
      }
    }
  }

  if (empty($setId)) {
    $tokendefaultsSets = \Civi\Api4\TokendefaultsSet::get()
      ->addWhere('is_default', '=', 1)
      ->setLimit(1)
      ->execute();
    foreach ($tokendefaultsSets as $tokendefaultsSet) {
      $setId = $tokendefaultsSet['id'];
    }
  }

  $tokenDefaultsRows = \Civi\Api4\Tokendefaults::get()
    ->addWhere('set_id', '=', $setId)
    ->addWhere('is_active', '=', 1)
    ->execute();
  $tokenDefaults = [];

  if (empty($tokenDefaultsRows)) {
    return;
  }

  foreach ($tokenDefaultsRows as $tokenDefaultRow) {
    $tokenToken = str_replace(array('{', '}'), '', $tokenDefaultRow['token']);
    $tokenDefaults[$tokenToken] = $tokenDefaultRow['default'];
  }

  foreach ($cids as $cid) {
    foreach ($tokenGroups as $tokenGroupName => $tokenGroupTokens) {
      foreach ($tokenGroupTokens as $tokenName) {
        $token = $tokenGroupName . '.' . $tokenName;
        if (empty($values[$cid][$tokenName])) {
          $values[$cid][$tokenName] = $tokenDefaults[$token];
        }
      }
    }
  }
}

/**
 * Implements hook_civicrm_buildForm().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_buildForm
 *
 */
function tokendefault_civicrm_buildForm($formName, &$form) {
  switch ($formName) {
    case 'CRM_Contact_Form_Task_Email':
    case 'CRM_Contact_Form_Task_PDF':
      CRM_Core_Resources::singleton()->addScriptFile('com.joineryhq.tokendefault', 'js/tokendefault-utils.js');
      CRM_Core_Resources::singleton()->addScriptFile('com.joineryhq.tokendefault', 'js/CRM_Contact_Form_Task_Email-and-PDF.js');

      $tokendefaultsSets['sets'] = \Civi\Api4\TokendefaultsSet::get()->execute();
      CRM_Core_Resources::singleton()->addVars('tokendefault', $tokendefaultsSets);
      break;
  }
}

/**
 * Normalize token array structure. CiviCRM presents tokens to hook_civicrm_tokenValues
 * in varying array structures, depending on whether the context is CiviMail (in
 * which case the tokens are named in array keys) or one-off mailings / merge
 * documents (in which case tokens are named in array values). This function
 * ensures all are named in array keys.
 *
 * @param type $tokens
 * @return type
 */
function _tokendefault_normalize_token_values($tokens) {
  foreach ($tokens as $key => $values) {
    if (!array_key_exists(0, $values)) {
      $tokens[$key] = array_keys($values);
    }
  }
  return $tokens;
}

/**
 * Implements hook_civicrm_pageRun().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_pageRun/
 *
 */
function tokendefault_civicrm_pageRun(&$page) {
  if ($page->getVar('_name') == 'CRM_Admin_Page_Extensions') {
    if (!_tokendefault_civicrm_checkMosaicoHooks()) {
      CRM_Core_Session::setStatus(
        E::ts('Extensions Tokendefault and Mosaico would work better together if you install the Mosaico Hooks extension.'),
        E::ts('Tokendefault Extension'),
        'info'
      );
    }
  }
}

function _tokendefault_civicrm_checkMosaicoHooks() {
  $extensionIsInstalled = TRUE;
  $manager = CRM_Extension_System::singleton()->getManager();
  $dependencies = array(
    'com.joineryhq.mosaicohooks',
  );

  foreach ($dependencies as $ext) {
    if ($manager->getStatus($ext) != CRM_Extension_Manager::STATUS_INSTALLED) {
      $extensionIsInstalled = FALSE;
    }
  }

  return $extensionIsInstalled;
}
