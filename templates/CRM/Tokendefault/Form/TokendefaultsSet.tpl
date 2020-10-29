{* HEADER *}

<div class="crm-submit-buttons">
{include file="CRM/common/formButtons.tpl" location="top"}
</div>

<div class="crm-block crm-form-block">
    <table class="form-layout">
      <tr>
          <td class="label">{$form.title.label}</td>
          <td class="html-adjust">{$form.title.html}</td>
      </tr>
      <tr>
          <td class="label">{$form.is_default.label}</td>
          <td class="html-adjust">{$form.is_default.html}</td>
      </tr>
    </table>
</div>

{* FOOTER *}
<div class="crm-submit-buttons">
{include file="CRM/common/formButtons.tpl" location="bottom"}
</div>
