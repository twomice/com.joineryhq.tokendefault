<div class="crm-form crm-form-block crm-string_override-form-block">
  <div class="crm-submit-buttons">
    {include file="CRM/common/formButtons.tpl" location="top"}
  </div>
  <table class="form-layout-compressed">
    <tr>
      <td>
        <table class="tokendefaults-table row-highlight">
          <thead>
            <tr class="columnheader">
              <th>{ts}Enabled{/ts}</th>
              <th>{ts}Token{/ts}</th>
              <th colspan="2">{ts}Default{/ts}</th>
            </tr>
          </thead>
          <tbody class="tokendefaults-body">
            {foreach from=$tokenDefaults item=tokenDefault}
              {assign var='is_active' value=$tokenDefault.is_active}
              {assign var='token' value=$tokenDefault.token}
              {assign var='default' value=$tokenDefault.default}

              <tr class="tokendefaults-row">
                <td>
                  {$form.$is_active.html}
                </td>
                <td>
                 <div class="helpIcon" id="helphtml">
                  {$form.$token.html}
                 </div>
                </td>
                <td>{$form.$default.html}</td>
                <td><a class="delete-tokendefaults" href="#">delete</a></td>
              </tr>
            {/foreach}
          </tbody>
        </table>
        &nbsp;&nbsp;&nbsp;<a class="action-item crm-hover-button add-tokendefaults" href="#"><i class="crm-i fa-plus-circle" aria-hidden="true"></i> {ts}Add row{/ts}</a>
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

      var newTokendefaultsField = $('.tokendefaults-row:last-child').html();
      $('.add-tokendefaults').click(function(e){
        e.preventDefault();
        $('.tokendefaults-body').append('<tr class="tokendefaults-row">' + newTokendefaultsField +'</tr>');
        $('.tokendefaults-row:last-child').find('.crm-token-selector').crmSelect2({
          data: form.data('tokens'),
          placeholder: '{/literal}{ts escape='js'}Tokens{/ts}{literal}'
        });

        var tokenRowCount = $('input[name="token_row_count"]').val();
        $('input[name="token_row_count"]').val(parseInt(tokenRowCount) + 1);
      });

      $('.tokendefaults-table').on('click','.delete-tokendefaults', function(e){
        e.preventDefault();
        $(this).parents('.tokendefaults-row').remove();
        var tokenRowCount = $('input[name="token_row_count"]').val();
        $('input[name="token_row_count"]').val(parseInt(tokenRowCount) - 1);
      })
    });
  {/literal}
</script>
