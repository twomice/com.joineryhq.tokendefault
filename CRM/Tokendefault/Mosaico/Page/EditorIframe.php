<?php

/**
 * Overrides certain methods in CRM_Mosaico_Page_EditorIframe.
 *
 * Really couldn't find a way to do the needful using hooks, so we override methods.
 */
class CRM_Tokendefault_Mosaico_Page_EditorIframe extends CRM_Mosaico_Page_EditorIframe {

  /**
   * Modify return value of parent:: method.
   */
  protected function createMosaicoConfig() {
    $config = parent::createMosaicoConfig();
    $config['tinymceConfig']['external_plugins']['tokendefault'] = CRM_Core_Resources::singleton()->getUrl('com.joineryhq.tokendefault', 'js/tinymce-plugins/tokendefault/plugin.js', 1);
    $config['tinymceConfig']['plugins'][0] .= ' tokendefault';
    $config['tinymceConfig']['toolbar1'] .= ' tokendefault';
    $config['tinymceConfig']['tokendefault'] = true;
    return $config;
  }

  /**
   * Modify return value of parent:: method.
   */
  protected function getScriptUrls() {
    $scriptUrls = parent::getScriptUrls();
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

    return $scriptUrls;
  }

  /**
   * Modify return value of parent:: method.
   */
  protected function getStyleUrls() {
    $res = CRM_Core_Resources::singleton();
    $styleUrls = parent::getStyleUrls();

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
    return $styleUrls;
  }
}
