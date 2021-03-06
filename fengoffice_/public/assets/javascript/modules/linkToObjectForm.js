App.modules.linkToObjectForm = {
  
  /**
   * Switch link object fileforms based on selected option (link existing or
   * link new file)
   */
  toggleLinkForms: function toggleLinkForms() {
    if($('linkFormExistingObject').checked) {
      $('linkFormExistingObjectControls').style.display = 'block';
      $('linkFormNewObjectControls').style.display = 'none';
      // $('documentFormFile').value = '';
    } else {
      $('linkFormExistingObjectControls').style.display = 'none';
      $('linkFormNewObjectControls').style.display = 'block';
    } // if
  } // toggleLinkForms
  
};