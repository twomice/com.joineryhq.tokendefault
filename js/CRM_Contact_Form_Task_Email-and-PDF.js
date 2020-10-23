CRM.$(function($) {
  $('div.crm-html_email-accordion div.crm-token-selector').before('\n\
    <div id="tokendefaultSelector" title="Select Token Default Set" style="display:none">\n\
      <select name="tokendefault-set" style="margin: 2em;" /></select>\n\
    </div>\n\
    <a id="tokendefaultSelectorOpen" style="float:left; margin-bottom: 10px;" class="button"><span>' + ts("Select Token Default Set") + '</span></a>\n\
  ');

  var setOption;
  for (i in CRM.vars.tokendefault) {
    setOption += "<option value=" + CRM.vars.tokendefault[i].id + ">" + CRM.vars.tokendefault[i].title + "</option>";
  }

  $('#tokendefaultSelector select').html(setOption);

  $('#tokendefaultSelector').dialog(
    {
      width: 'auto',
      padding: '10px',
      modal: true,
      autoOpen: false,
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
          tokendefault.insertHtmlTokenDefaultSet('textarea#html_message', 'select[name=tokendefault-set]');
          $(this).dialog('close');
        }
      }
    ]
  });
  $('#tokendefaultSelectorOpen').click(function() {
    $('#tokendefaultSelector').dialog('open');
  });
});