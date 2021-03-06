App.modules.linkToObjectForm = {
  
  /**
   * Switch link object fileforms based on selected option (link existing or
   * link new file)
   */
  toggleLinkForms: function toggleLinkForms() {
    if(Ext.getDom('linkFormExistingObject').checked) {
      Ext.getDom('linkFormExistingObjectControls').style.display = 'block';
      Ext.getDom('linkFormNewObjectControls').style.display = 'none';
      // Ext.getDom('documentFormFile').value = '';
    } else {
      Ext.getDom('linkFormExistingObjectControls').style.display = 'none';
      Ext.getDom('linkFormNewObjectControls').style.display = 'block';
    } // if
  } // toggleLinkForms
  
};