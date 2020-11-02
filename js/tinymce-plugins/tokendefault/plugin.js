/**
 * campaignadv - TinyMCE plugin which allows users to easily insert a "filter  cid"
 * token for public officials.
/*global tinymce:true */

tinymce.PluginManager.add('tokendefault', function(editor, pluginUrl) {
  if (!editor.settings.tokendefault) {
    throw "Failed to initialize tokendefault. TinyMCE settings should define \"tokendefault\".";
  }

  function settings() {
    return editor.settings.tokendefault;
  }

  editor.addCommand('tokendefault', function(ui, v) {

    CRM.$('body').append('\n\
      <div id="tokendefaultSelector" title="Token Default Set" style="display:none">\n\
        <select name="tokendefault-set" style="margin: 2em; min-width: 20em;" /></select>\n\
      </div>\n\
    ');

    CRM.api4('TokendefaultsSet', 'get', {
    }).then(function(tokendefaultsSets) {
      var setOption;
      for (i = 0; i < tokendefaultsSets.length; i++) {
        var defaultSet = tokendefaultsSets[i].is_default ? 'selected' : '';
        setOption += "<option value=" + tokendefaultsSets[i].id + " " + defaultSet + ">" + tokendefaultsSets[i].title + "</option>";
      }
      CRM.$('#tokendefaultSelector select').html(setOption).select2();
    });

    // var setOption;
    // for (i in CRM.vars.tokendefault.sets) {
    //   var defaultSet = CRM.vars.tokendefault.sets[i].is_default ? 'selected' : '';
    //   setOption += "<option value=" + CRM.vars.tokendefault.sets[i].id + " " + defaultSet + ">" + CRM.vars.tokendefault.sets[i].title + "</option>";
    // }

    CRM.$('#tokendefaultSelector').dialog({
      width: 'auto',
      padding: '10px',
      modal: true,
      autoOpen: true,
      buttons: [
        {
          text: 'Cancel',
          icon: 'fa-times',
          click: function() {
            $(this).dialog('close');
          }
        },
        {
          text: 'Select',
          icon: 'fa-check',
          click: function() {
            var data = tinymce.activeEditor.getContent();
            // Strip any existing "filter_cid" token.
            data = data.replace(/(<p>)?{TokenDefault.filter_cid___[0-9]*}(<\/p>)?/, '');
            // Get the cid of the selected Public Official contact, if any.
            var filterCid = CRM.$('select[name=tokendefault-set]').val();
            // If a public official cid is found, insert the filter_cid token at the end
            // of the ckeditor HTML content.
            if (filterCid) {
              data += '{TokenDefault.filter_cid___' +  filterCid + '}';
            }
            // Apply the altered content to the activetinymce instance.
            tinymce.activeEditor.execCommand('mceSetContent', false, data);
            $(this).dialog('close');
          }
        }
      ]
    });
  });

  editor.addShortcut('ctrl+shift+p', 'Select Token Default Set', 'tokendefault');
  editor.addButton('tokendefault', {
    text: 'Select Token Default Set',
    tooltip: 'Token Default Set (Ctrl-Shift-P)',
    onclick: function(_) {
      editor.execCommand('tokendefault');
    }
  });

  // Append our button to toolbar1 in this editor, if it's not already there.
  // (Apparently the above editor.addButton() method only adds it to the first
  // editor in the page.
  if (!editor.settings.toolbar1.includes('tokendefault')) {
    editor.settings.toolbar1 += ' | tokendefault';
  }

});
