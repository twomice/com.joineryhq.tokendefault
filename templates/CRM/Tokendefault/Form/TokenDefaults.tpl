<div class="crm-form crm-form-block crm-string_override-form-block">
  <div class="crm-submit-buttons">
    {include file="CRM/common/formButtons.tpl" location="top"}
  </div>
  <table class="form-layout-compressed">
    <tr>
      <td>
        <table class="string-override-table row-highlight">
          <thead>
            <tr class="columnheader">
              <th>{ts}Enabled{/ts}</th>
              <th>{ts}Token{/ts}</th>
              <th colspan="2">{ts}Default{/ts}</th>
            </tr>
          </thead>
          <tbody>
            {foreach from=$tokenDefaults item=tokenDefault}
              {assign var='is_active' value=$tokenDefault.is_active}
              {assign var='token' value=$tokenDefault.token}
              {assign var='default' value=$tokenDefault.default}

              <tr class="string-override-row">
                <td>
                  {$form.$is_active.html}
                </td>
                <td>
                 <div class="helpIcon" id="helphtml">
                  {$form.$token.html}
                 </div>
                </td>
                <td>{$form.$default.html}</td>
                <td><a href="#">delete</a></td>
              </tr>
            {/foreach}
          </tbody>
        </table>
        &nbsp;&nbsp;&nbsp;<a class="action-item crm-hover-button buildStringOverrideRow" href="#"><i class="crm-i fa-plus-circle" aria-hidden="true"></i> {ts}Add row{/ts}</a>
      </td>
    </tr>
  </table>
  <div class="crm-submit-buttons">
  {include file="CRM/common/formButtons.tpl" location="bottom"}
  </div>
</div>

<script type="text/javascript">
  cj('form.{$form.formClass}').data('tokens', {$tokens|@json_encode});

  {literal}
    CRM.$(function($) {
      var form = $('form.{/literal}{$form.formClass}{literal}');
      $('input.crm-token-selector', form)
        .addClass('crm-action-menu fa-code')
        .crmSelect2({
          data: form.data('tokens'),
          placeholder: '{/literal}{ts escape='js'}Tokens{/ts}{literal}'
        });

      $('input.crm-token-selector', form).each(function(){
        if ($(this).val()) {
          var thisVal = $(this).val().split(".");
          var select2Val = thisVal[1].toLowerCase().replace('_',' ').replace(/\b[a-z]/g, function(letter) {
            return letter.toUpperCase();
          });
          $(this).prev().find('.select2-chosen').text(select2Val);
        }
      });
    });
  {/literal}
</script>
