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
              {assign var='active' value=$tokenDefault.active}
              {assign var='token' value=$tokenDefault.token}
              {assign var='default' value=$tokenDefault.default}

              <tr class="tokendefaults-row">
                <td>
                  {$form.$active.html}
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
      var newTokendefaultsField = $('.tokendefaults-row:last-child').html();
      var form = $('form.{/literal}{$form.formClass}{literal}');

      $('input.crm-token-selector', form)
        .addClass('crm-action-menu fa-code')
        .crmSelect2({
          data: form.data('tokens'),
          placeholder: '{/literal}{ts escape='js'}Tokens{/ts}{literal}'
        });


      $('.add-tokendefaults').click(function(e){
        e.preventDefault();
        var tokenRowCount = $('input[name="token_row_count"]').val();
        var tokenRowCountVal = parseInt(tokenRowCount);

        $('.tokendefaults-body').append('<tr class="tokendefaults-row">' + newTokendefaultsField +'</tr>');
        var $addedElements = $('.tokendefaults-row:last-child');

        $addedElements.find('td:first-child input').removeAttr('name').removeAttr('id').attr('id','active_' + tokenRowCountVal).attr('name','active_' + tokenRowCountVal).prop( "checked", true );
        $addedElements.find('td:nth-child(2) input').removeAttr('name').removeAttr('id').attr('id','token_' + tokenRowCountVal).attr('name','token_' + tokenRowCountVal);
        $addedElements.find('td:nth-child(3) input').removeAttr('name').removeAttr('id').attr('id','default_' + tokenRowCountVal).attr('name','default_' + tokenRowCountVal);
        $addedElements.find('.crm-token-selector').crmSelect2({
          data: form.data('tokens'),
          placeholder: '{/literal}{ts escape='js'}Tokens{/ts}{literal}'
        });

        $('input[name="token_row_count"]').val(tokenRowCountVal + 1);
      });

      $('.tokendefaults-table').on('click','.delete-tokendefaults', function(e){
        e.preventDefault();
        $(this).parents('.tokendefaults-row').remove();
      });
    });
  {/literal}
</script>
