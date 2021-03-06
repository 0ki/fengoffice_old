<!--
<?php if(isset($folders) && is_array($folders) && count($folders)) { ?>
<div class="sidebarBlock">
  <h2><?php echo lang('folders') ?></h2>
  <div class="blockContent" id="sidebarFolderList">
    <ul>
<?php // if($current_folder instanceof ProjectFolder) { ?>
      <li><a class="internalLink" href="<?php // echo ProjectFiles::getIndexUrl($order, $page) ?>"><?php //echo lang('all files') ?></a></li>
<?php //} else { ?>
      <li><a href="<?php echo ProjectFiles::getIndexUrl($order, $page) ?>" class="selected internalLink"><?php echo lang('all files') ?></a></li>
<?php //} // if ?>
    
    </ul>
    <p><a class="internalLink" href="<?php echo get_url('files', 'add_folder') ?>"><?php echo lang('add folder') ?></a></p>
  </div>
</div>
<?php } // if ?>

<?php if(isset($important_files) && is_array($important_files) && count($important_files)) { ?>
<div class="sidebarBlock">
  <h2><?php echo lang('important files') ?></h2>
  <div class="blockContent">
    <ul>
<?php foreach($important_files as $important_file) { ?>
      <li>
        <a class="internalLink" href="<?php echo $important_file->getDetailsUrl() ?>"><?php echo clean($important_file->getFilename()) ?></a><br />
        <span class="desc"><?php echo lang('revisions on file', $important_file->countRevisions()) ?></span>
      </li>
<?php } // foreach ?>
    </ul>
  </div>
</div>
<?php } // if ?>
-->