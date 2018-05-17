<?php if (!defined('CMS_ROOT')) die; ?>
<div class="content__header">
<h2>
	<a href="<?php echo get_url('plugins'); ?>"><?php echo __('Plugins'); ?></a> &rarr;
	<?php echo __('TinyMCE settings'); ?>: <?php echo __('Select editor buttons'); ?>
</h2>
                
                                    </div>



<div id="TMCES" class="card">
	<form id="TMCESForm" class="form" action="<?php echo get_url('plugin/tinymce/settings'); ?>" method="post">
		
		<h2 class="box-title"></h2>
		
		<div id="TMCESButtonsSets">
			<?php foreach ($buttons_sets as $i => $button_set): ?>
			<?php if(!empty($button_set)): ?>
			<p><?php echo __('Panel') .' '. ($i+1); ?></p>
			
			<ul>
				<?php foreach ($button_set as $button): ?>
				<?php if ($button != '|'): ?>
				<li id="<?php echo $button; ?>" title="<?php echo $button; ?>">
                                    
                                    <label for="TMCESButtonField-<?php echo $button; ?>" class="checkbox-inline" style="margin: 2px 0px 0 3px;">
                                        <input id="TMCESButtonField-<?php echo $button; ?>" type="checkbox" name="buttons[]" value="<?php echo $button; ?>" <?php if (in_array($button, $selected_buttons)) echo('checked'); ?> > 
                                    
                                        <i class="input-helper"></i>
                             <i class="zmdi zmdistyle21 zmdimce_<?php echo $button; ?>"> </i>
                                       </label>
                                    
                                    
                                </li>
				<?php else: ?>
				<li class="separator"></li>
				<?php endif; ?>
				<?php endforeach; ?>
			</ul>
			<?php endif; ?>
			<?php endforeach; ?>
		</div>
		
		<!--<h2 class="box-header"><?php echo __('Other settings'); ?></h2>
		
		<section>
			<label for="TMCESStylesheet"><?php echo __('Content stylesheet file'); ?> <em><?php echo __('Select absolute path to stylesheet file in public directory.'); ?></em></label>
			<span><input id="TMCESStylesheetField" class="input-text" type="text" name="setting[stylesheet]" maxlength="255" size="50" value="<?php echo isset($setting['stylesheet']) ? htmlentities($setting['stylesheet'], ENT_COMPAT, 'UTF-8'): ''; ?>" /> <button id="TMCESStylesheetSelectButton"><?php echo __('Select'); ?></button></span>
		</section>
		-->
		<div class="box-buttons">
                    <button class="button-submit-style" type="submit" name="commit"><i class="zmdi zmdi-check"></i> <?php echo __('Save setting'); ?></button>
			  
			 <a class="button-submit-style-a" href="<?php echo get_url('plugins'); ?>"><i class="zmdi zmdi-undo"></i> <?php echo __('Cancel'); ?></a>
		</div>
	</form>
</div>

<script>
    
   
  
   
    var main= document.getElementById("styleselect");
    var str = '<span class="style-settingsTiny"> Styles </span>';
    main.innerHTML = main.innerHTML+str;
    
    var main2= document.getElementById("formatselect");
    var str = '<span class="style-settingsTiny"> Font Family </span>';
    main2.innerHTML = main2.innerHTML+str;
    
    var main3= document.getElementById("fontselect");
    var str = '<span class="style-settingsTiny"> Format </span>';
    main3.innerHTML = main3.innerHTML+str;
    
    var main4= document.getElementById("fontsizeselect");
    var str = '<span class="style-settingsTiny"> Font Size </span>';
    main4.innerHTML = main4.innerHTML+str;
    
    var main5= document.getElementById("forecolor");
    var str = '<span class="style-settingsTiny"><i class="zmdi  zmdimce_forecolorolo"></i></span>';
    main5.innerHTML = main5.innerHTML+str;
    
    var main6= document.getElementById("backcolor");
    var str = '<span class="style-settingsTiny"><i class="zmdi zmdimce_backcolorolo"></i> </span>';
    main6.innerHTML = main6.innerHTML+str;
       
    </script>