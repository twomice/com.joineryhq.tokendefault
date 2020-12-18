CRM.$(function($){
  tokendefault = {
    insertHtmlTokenDefaultSet: function insertHtmlTokenDefaultSet(ckeTextareaSelector, filterSetSelector) {
      // Get the ckeditor instance name based on known "crm-ui-id" value in "~/crmMailing/BodyHtml.html"
      var ckeInstanceName = CRM.$(ckeTextareaSelector).attr('id');
      // Shorthand variable for the cke instance.
      var ckeInstance = CKEDITOR.instances[ckeInstanceName];
      // Shorthand variable for the ckeditor content.
      var data = ckeInstance.getData();
      // Strip any existing "filter_cid" token.
      data = data.replace(/(<p>)?{TokenDefault.set___[0-9]*}(<\/p>)?/, '');
      // Get the cid of the selected Public Official contact, if any.
      var filterSet = CRM.$(filterSetSelector).val();
      // If a public official cid is found, insert the filter_cid token at the end
      // of the ckeditor HTML content.
      if (filterSet) {
        data += '{TokenDefault.set___' +  filterSet + '}';
      }
      // Apply the altered content to the on-page ckeditor instance.
      ckeInstance.setData(data, {
        callback: function() {
          // Set range; without this, something about ckeditor makes it fail to recognize
          // the effects of setData() (at least WRT the value submitted with the form)
          // until the user mouse-clicks in the editor.
          var range = this.createRange();
          range.moveToElementEditEnd( range.root );
          this.getSelection().selectRanges( [ range ] );
        }
      });
    }
  };

});
