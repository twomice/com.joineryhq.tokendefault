{if $action eq 1 or $action eq 2 or $action eq 4}
    {include file="CRM/Tokendefault/Form/TokendefaultsSet.tpl"}
{elseif $action eq 8}
    {include file="CRM/Tokendefault/Form/TokendefaultsSetDelete.tpl"}
{else}
    {if $rows}
    <div class="crm-content-block crm-block">
    <div id="custom_group">
     {strip}
   {* handle enable/disable actions*}
   {include file="CRM/common/enableDisableApi.tpl"}
      <table id="options" class="row-highlight">
        <thead>
          <tr>
            <th>{ts}ID{/ts}</th>
            <th>{ts}Title{/ts}</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
        {foreach from=$rows item=row}
        <tr id="TokenDefaultSet-{$row.id}" data-action="setvalue" class="crm-entity {cycle values="odd-row,even-row"}">
          <td>{$row.id}</td>
          <td class="crmf-title crm-editable">{$row.title}</td>
          <td>{$row.action|replace:'xx':$row.id}</td>
        </tr>
        {/foreach}
        </tbody>
      </table>

        {if NOT ($action eq 1 or $action eq 2) }
        <div class="action-link">
        {crmButton p='civicrm/admin/tokendefault' q="action=add&reset=1" id="newCustomDataGroup"  icon="plus-circle"}{ts}Add Set of Token Default{/ts}{/crmButton}
        </div>
        {/if}

        {/strip}
    </div>
    </div>
    {else}
       {if $action ne 1} {* When we are adding an item, we should not display this message *}
       <div class="messages status no-popup">
       <img src="{$config->resourceBase}i/Inform.gif" alt="{ts}status{/ts}"/> &nbsp;
         {capture assign=crmURL}{crmURL p='civicrm/admin/tokendefault' q='action=add&reset=1'}{/capture}
         {ts 1=$crmURL}No token default set have been created yet. You can <a id="newCustomDataGroup" href='%1'>add one</a>.{/ts}
       </div>
       {/if}
    {/if}
{/if}
