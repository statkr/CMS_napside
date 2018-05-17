<?php if(!defined('CMS_ROOT')) die; ?>
<script>
	var FILE_MANAGER_NOW_PATH = '<?php echo $now_path; ?>';
</script>

<script language="JavaScript">
var select, value, text;


var createCookie = function(name, value, days) {
    var expires;
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    }
    else {
        expires = "";
    }
    document.cookie = name + "=" + value + expires + "; path=/";
}

function getCookie(c_name) {
    if (document.cookie.length > 0) {
        c_start = document.cookie.indexOf(c_name + "=");
        if (c_start != -1) {
            c_start = c_start + c_name.length + 1;
            c_end = document.cookie.indexOf(";", c_start);
            if (c_end == -1) {
                c_end = document.cookie.length;
            }
            return unescape(document.cookie.substring(c_start, c_end));
        }
    }
    return "";
}

  


function change(a) {
    select = document.getElementById("selectId"); 
    valuenew = a; 
    console.log(valuenew); 
   
     createCookie("file-manager-variant", valuenew, 1400); 
        document.location.reload( );
};


 
var fmselect = getCookie("file-manager-variant");

function onload() {
console.log('All assets are loaded')
    
if (fmselect == "1")
{
    document.getElementById("divas1").style.display = "block";
    document.getElementById("divas2").style.display = "none";
    document.getElementById("divas3").style.display = "none"; 
    console.log("block1"); 
}

else
{
  
  
  if (fmselect == "2")
{
    document.getElementById("divas1").style.display = "none";
    document.getElementById("divas2").style.display = "block";
    document.getElementById("divas3").style.display = "none"; 
    console.log("good"); 
}

else
{
   document.getElementById("divas1").style.display = "none";
    document.getElementById("divas2").style.display = "none";
    document.getElementById("divas3").style.display = "block";  
  console.log("no-good"); 
}



  
  
}
}
   





</script>


<div class="content__header">
    
    <div class="actions" style="    
         position: absolute;
    left: -1px;
    top: -7px;
        z-index: 4;
    width: 30px;">
                        
                        <div class="dropdown">
                            <a href="" class="drop-paste" data-toggle="dropdown"><i class="zmdi zmdi-more-vert"></i></a>
                            <ul class="dropdown-menu pull-right">
                                <div id="FMMapActions" class="box-actions">
		
	 
		<button rel="<?php echo get_url('plugin/file_manager/upload'); ?>" id="FMMapUploadButton" class="page-map-reorder-button button-image bottom-home"><i class="zmdi zmdi-home zmdi-cloud-upload"></i> Загрузить</button>
		<button rel="<?php echo get_url('plugin/file_manager/upload'); ?>" id="FMMapCFolderButton" class="page-map-copy-button button-image bottom-home"><i class="zmdi zmdi-home zmdi-folder"></i>Создать папку</button>
	
                               </div>
                            </ul>
                        </div>
                    </div>   
                    <h2>
	<?php echo __('File manager'); ?> &rarr;
	<?php if(!empty($now_path)): ?><a href="<?php echo get_url('plugin/file_manager/'.PUBLIC_DIR_NAME.'/'); ?>"><?php echo PUBLIC_DIR_NAME; ?></a><?php else: echo(PUBLIC_DIR_NAME); endif; ?>
	<?php $full_path = ''; $dirs = explode('/', $now_path); $dirs_count = count($dirs); ?>
	<?php for($i=0; $i<$dirs_count; ++$i): ?>
	<?php if(empty($dirs[$i])) continue; ?>
	/
	<?php if($i+1 != $dirs_count): ?>
	<a href="<?php echo get_url('plugin/file_manager/'.PUBLIC_DIR_NAME.'/'.$full_path.$dirs[$i]); ?>"><?php echo urldecode($dirs[$i]); ?></a>
	<?php else: ?>
	<?php echo urldecode($dirs[$i]); ?>
	<?php endif; ?>
	<?php $full_path .= $dirs[$i].'/'; endfor; ?>
</h2>
                <?php require CORE_ROOT . '/app/layouts/actions.php'; ?>
                                    </div>










<div id="FMMap" class="card">
	
	
	<!--<div class="map-header">
		<span class="name"><?php echo __('File name'); ?></span>
		<span class="size"><?php echo __('Size'); ?></span>
		<span class="perm"><?php echo __('Permissions'); ?></span>
		<span class="action"><?php echo __('Actions'); ?></span>
	</div>-->
	<div id="divas1">
	<div id="FMMapItems" class="map-items">
            <div class="row" style="padding: 0 43px 18px 40px;">
		<?php if (!empty($now_path)): ?>
		<div class="col-md-12 col-sm-12">
			<div class="item">
				<span class="name"><img src="<?php echo PLUGINS_URL.'file_manager/images/folder-up.png'; ?>" /> <a href="<?php echo get_url('plugin/file_manager/'.PUBLIC_DIR_NAME.'/' .(!empty($now_path) ? substr($now_path, 0, strrpos($now_path, '/')): '')); ?>"><?php echo __('Level up'); ?></a></span>
			</div>
		</div>
		<?php endif; ?>
		<?php foreach ($files as $file): ?>
		<?php if(!$file->isDir() || $file->isDot()) continue; ?>
		<div class="col-md-2 col-sm-4">
			<div class="contacts__item">
                                     <p class="zmdi-center"><a href="<?php echo get_url('plugin/file_manager/'.PUBLIC_DIR_NAME.'/' .(!empty($now_path) ? $now_path.'/': ''). $file->getFilenameUTF8()); ?>"><i class="zmdi zmdi-center zmdi-folder"></i></a></p>
                                 

                                <div class="contacts__info">
                                   
                                     
                                    <strong>
                                        <a class="contacts__img color-grey-a" href="<?php echo get_url('plugin/file_manager/'.PUBLIC_DIR_NAME.'/' .(!empty($now_path) ? $now_path.'/': ''). $file->getFilenameUTF8()); ?>"><?php echo $file->getFilenameUTF8(); ?></a> 
  
                                    
                                    <strong>
                                        <div class="ovals">
                                       
				<span style="    position: initial;" class="action "> 
					<button class="item-rename-button st-block1" rel='<?php echo json_encode(array('name' => $file->getFilenameUTF8(), 'chmod' => $file->getChmodPerms(), 'now_path' => $now_path, 'dir' => true)); ?>' title="<?php echo __('Rename'); ?>"><i               style="padding-left: 6px;"          class="zmdi zmdi-edit"></i></button>
					<button class="item-remove-button st-block2" rel="<?php echo get_url('plugin/file_manager/remove/' . (!empty($now_path) ? $now_path.'/': '') .$file->getFilenameUTF8()); ?>" title="<?php echo __('Remove'); ?>"><i               style="padding-left: 6px;"          class="zmdi zmdi-close"></i></button>
				</span>
                                        </div>
                                        
                                        
                                          </strong>
                                    
                                </div>

                                
                            
                            
                            
				 
				
                                  </div>
			 
		</div>
		<?php endforeach; ?>
		<?php foreach ($files as $file): ?>
		<?php if($file->isDir() || $file->isDot()) continue; ?>
		<div class="col-md-2 col-sm-4">
			<div class="contacts__item">
                            <p class="zmdi-center"><img style="margin-top:-29px;"src="<?php echo PLUGINS_URL.'file_manager/images/files/file'. (file_exists(PLUGINS_ROOT.DIRECTORY_SEPARATOR.'file_manager'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.'file-'.$file->getExt().'.png') ? '-'.$file->getExt(): '').'.png'; ?>" />
                                    </p>
                           
				   <div class="contacts__info">
                                    <strong>
                                       <a class="color-grey-a" href="<?php echo PUBLIC_URL. (!empty($now_path) ? $now_path.'/': '') .$file->getFilenameUTF8(); ?>" target="_blank"><?php echo $file->getFilenameUTF8(); ?></a>
                                   </strong>
                                       
                                       <strong>
                                            <div class="ovals">
                                           
                                           
                                 <span style="    position: initial; "class="action">
					<button class="item-rename-button st-block1" rel='<?php echo json_encode(array('name' => $file->getFilenameUTF8(), 'chmod' => $file->getChmodPerms(), 'now_path' => $now_path, 'dir' => false)); ?>' title="<?php echo __('Rename'); ?>"><i  style="padding-left: 6px;" class="zmdi zmdi-edit"></i></button>
					<button class="item-remove-button st-block2" rel="<?php echo get_url('plugin/file_manager/remove/' . (!empty($now_path) ? $now_path.'/': '') .$file->getFilenameUTF8()); ?>" title="<?php echo __('Remove'); ?>"><i  style="padding-left: 6px;" class="zmdi zmdi-close"></i></button>
				</span>
                                           
                                         </div>   
                                       </strong>
                                </div>
                                    
				
			</div>
		</div>
		<?php endforeach; ?>
	</div>
    </div>
        </div>
        
        
        
        
        
     <div id="divas2">
  
  
  <ul id="FMMapItems" class="map-items">
		<?php if (!empty($now_path)): ?>
		<li>
			<div class="item" style="height: 54px;">
				<span class="name"><i class="zmdi zmdi-undo undoro"></i><a href="<?php echo get_url('plugin/file_manager/'.PUBLIC_DIR_NAME.'/' .(!empty($now_path) ? substr($now_path, 0, strrpos($now_path, '/')): '')); ?>"><?php echo __('Level up'); ?></a></span>
			</div>
		</li>
		<?php endif; ?>
		<?php foreach ($files as $file): ?>
		<?php if(!$file->isDir() || $file->isDot()) continue; ?>
		<li>
			<div class="item">
				<span class="name"><i class="zmdi zmdi-center zmdi-folder" style="font-size: 31px !important;position:  relative;top: 7px;left: 3px;margin-right: 6px;"></i> 
                                    <a  href="<?php echo get_url('plugin/file_manager/'.PUBLIC_DIR_NAME.'/' .(!empty($now_path) ? $now_path.'/': ''). $file->getFilenameUTF8()); ?>"><?php echo $file->getFilenameUTF8(); ?></a></span>
				<span class="size hidden-sm hidden-xs"><?php echo (!$file->isDir() ? convert_size($file->getSize()): ''); ?></span>
				<span class="perm hidden-sm hidden-xs"><?php echo $file->getChmodPerms(); ?></span>
				<span class="action">
                                    
                                    
                                    
					<button class="item-rename-button botton-fm" rel='<?php echo json_encode(array('name' => $file->getFilenameUTF8(), 'chmod' => $file->getChmodPerms(), 'now_path' => $now_path, 'dir' => true)); ?>' title="<?php echo __('Rename'); ?>"><i class="zmdi zmdi-fm-edit zmdi-edit"></i></button>
					<button class="item-remove-button botton-fm" rel="<?php echo get_url('plugin/file_manager/remove/' . (!empty($now_path) ? $now_path.'/': '') .$file->getFilenameUTF8()); ?>" title="<?php echo __('Remove'); ?>"><i class="zmdi zmdi-fm-edit zmdi-close"></i></button>
				</span>
			</div>
		</li>
		<?php endforeach; ?>
		<?php foreach ($files as $file): ?>
		<?php if($file->isDir() || $file->isDot()) continue; ?>
		<li>
			<div class="item" style="height: 50px;">
				<span class="name"><img style="width: 32px;     margin-top: -44px;"src="<?php echo PLUGINS_URL.'file_manager/images/files/file'. (file_exists(PLUGINS_ROOT.DIRECTORY_SEPARATOR.'file_manager'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.'file-'.$file->getExt().'.png') ? '-'.$file->getExt(): '').'.png'; ?>" /> <a class="url-minim " href="<?php echo PUBLIC_URL. (!empty($now_path) ? $now_path.'/': '') .$file->getFilenameUTF8(); ?>" target="_blank"><?php echo $file->getFilenameUTF8(); ?></a></span>
				<span class="size hidden-sm hidden-xs"><?php echo (!$file->isDir() ? convert_size($file->getSize()): ''); ?></span>
				<span class="perm hidden-sm hidden-xs"><?php echo $file->getChmodPerms(); ?></span>
				<span class="action">
					<button class="item-rename-button botton-fm" rel='<?php echo json_encode(array('name' => $file->getFilenameUTF8(), 'chmod' => $file->getChmodPerms(), 'now_path' => $now_path, 'dir' => false)); ?>' title="<?php echo __('Rename'); ?>"><i class="zmdi zmdi-fm-edit zmdi-edit"></i></button>
					<button class="item-remove-button botton-fm" rel="<?php echo get_url('plugin/file_manager/remove/' . (!empty($now_path) ? $now_path.'/': '') .$file->getFilenameUTF8()); ?>" title="<?php echo __('Remove'); ?>"><i class="zmdi zmdi-fm-edit zmdi-close"></i></button>
				</span>
			</div>
		</li>
		<?php endforeach; ?>
	</ul>
  
  
  
  </div>   
       
        
        <div id="divas3">
 
  <div id="FMMapItems" class="map-items">
            <div class="row" style="    padding: 0 15px 0px 15px;">
                
                
          
                
                <div id="social-links">
		<?php if (!empty($now_path)): ?>
		<div class="col-md-12 col-sm-12">
			<div class="item">
				<span class="name"><img src="<?php echo PLUGINS_URL.'file_manager/images/folder-up.png'; ?>" /> <a href="<?php echo get_url('plugin/file_manager/'.PUBLIC_DIR_NAME.'/' .(!empty($now_path) ? substr($now_path, 0, strrpos($now_path, '/')): '')); ?>"><?php echo __('Level up'); ?></a></span>
			</div>
		</div>
		<?php endif; ?>
		<?php foreach ($files as $file): ?>
		<?php if(!$file->isDir() || $file->isDot()) continue; ?>
		<div class="social-logo col-sm-4 col-xs-12">
                      
			<div class="contacts__item  " style="     min-height: 65px;   margin-bottom: 2px; background:none;     padding:0 0 0 0;">
                           
                                     <span ><a href="<?php echo get_url('plugin/file_manager/'.PUBLIC_DIR_NAME.'/' .(!empty($now_path) ? $now_path.'/': ''). $file->getFilenameUTF8()); ?>"><i class="zmdi zmdi-center zmdi-lol zmdi-folder"></i></a></span>
                                 

                                <span class="contacts__info">
                                   
                                     
                                     
                                        <a style="     text-align: left;    text-overflow: ellipsis;     font-size: 13px;  display: inline-block;" class="url-minim contacts__img color-grey-a" href="<?php echo get_url('plugin/file_manager/'.PUBLIC_DIR_NAME.'/' .(!empty($now_path) ? $now_path.'/': ''). $file->getFilenameUTF8()); ?>"><?php echo $file->getFilenameUTF8(); ?></a> 
                           
                                    
                                </span>
 
                                 
                            
                            
                            
				 
				
                                
                                
				<span class="action" style="    right: 0px;">
                                    
                                    
                                    <li class="dropdown botton-fm2">
                    <a data-toggle="dropdown" href="" aria-expanded="true"><i class="zmdi more-zmdi zmdi-more-vert"></i></a>
                    <ul class="dropdown-menu dropdown-menu--icon pull-right" style="padding: 4px;height: 41px;left: -122px;top: -4px;">
                        <span class="size"><?php echo (!$file->isDir() ? convert_size($file->getSize()): ''); ?></span>
				<span class="perm fm-tree " ><?php echo $file->getChmodPerms(); ?></span>
                                
                        
                        <button style="margin-top: -9px;padding: 12px 0 0 0;" class="item-remove-button botton-fm2" rel="<?php echo get_url('plugin/file_manager/remove/' . (!empty($now_path) ? $now_path.'/': '') .$file->getFilenameUTF8()); ?>" title="<?php echo __('Remove'); ?>"><i class="zmdi zmdi-fm-edit zmdi-close"></i></button>
				<button style="margin-top: -9px;padding: 12px 0 0 0;"  class="item-rename-button botton-fm2" rel='<?php echo json_encode(array('name' => $file->getFilenameUTF8(), 'chmod' => $file->getChmodPerms(), 'now_path' => $now_path, 'dir' => true)); ?>' title="<?php echo __('Rename'); ?>"><i class="zmdi zmdi-fm-edit zmdi-edit"></i></button>
				
                        
                         
                        
                    </ul>
                </li>
                                    
                                    
                                     	
                                </span>
                                
 </div>  
    			 
		</div>
		<?php endforeach; ?>
		<?php foreach ($files as $file): ?>
		<?php if($file->isDir() || $file->isDot()) continue; ?>
		<div class="col-sm-4 col-xs-12 social-logo">
			<div class="contacts__item" style="    min-height: 65px;    margin-bottom: 2px; background:none;        padding: 11px 0 0 0;">
                            <span ><img style="    width: 40px;"src="<?php echo PLUGINS_URL.'file_manager/images/files/file'. (file_exists(PLUGINS_ROOT.DIRECTORY_SEPARATOR.'file_manager'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.'file-'.$file->getExt().'.png') ? '-'.$file->getExt(): '').'.png'; ?>" />
                                    </span>
                           
				   <span class="contacts__info" style="top: 4px;position:  relative;">
                                   
                                       <a  style="        text-align: left; font-size: 13px;   display: inline-block;" class="url-minim color-grey-a" href="<?php echo PUBLIC_URL. (!empty($now_path) ? $now_path.'/': '') .$file->getFilenameUTF8(); ?>" target="_blank"><?php echo $file->getFilenameUTF8(); ?></a>
                            
                                    
                                </span>
                            
                            
                            
                            <li class="dropdown botton-fm2" style="
    margin-top: -2px;
">
                    <a data-toggle="dropdown" href="" aria-expanded="true"><i class="zmdi more-zmdi zmdi-more-vert"></i></a>
                    <ul class="dropdown-menu dropdown-menu--icon pull-right" style="padding: 4px;height: 41px;left: -169px;top: -4px;     width: 208px;">
                        
                        
                        <span class="size fm-tree20 "><?php echo (!$file->isDir() ? convert_size($file->getSize()): ''); ?></span>
				<span class="perm fm-tree21 " ><?php echo $file->getChmodPerms(); ?></span>
                                 
                                
                                
                                
                        
                   
                        <button style="margin-top: -9px;padding: 12px 0 0 0;" class="item-remove-button botton-fm2" rel="<?php echo get_url('plugin/file_manager/remove/' . (!empty($now_path) ? $now_path.'/': '') .$file->getFilenameUTF8()); ?>" title="<?php echo __('Remove'); ?>"><i  class="zmdi zmdi-fm-edit zmdi-close"></i></button>
                                 <button style="margin-top: -9px;padding: 12px 0 0 0;" class="item-rename-button botton-fm2" rel='<?php echo json_encode(array('name' => $file->getFilenameUTF8(), 'chmod' => $file->getChmodPerms(), 'now_path' => $now_path, 'dir' => false)); ?>' title="<?php echo __('Rename'); ?>"><i class="zmdi zmdi-fm-edit zmdi-edit"></i></button>
					
                         
                        
                    </ul>
                </li>
                            
                            
                            
                                    
				
				 
			</div>
		</div>
		<?php endforeach; ?>
	</div>
      </div>
    </div>
</div>
        
</div><!--/#FMMap-->




			
  
  

 

  
  


 <script>
      onload();
   </script>