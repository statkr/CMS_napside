<?php if(!defined('CMS_ROOT')) die; ?>
<div class="content__header">
<h2>
	<a href="<?php echo get_url('plugins'); ?>"><?php echo __('Plugins'); ?></a> &rarr;
	<?php echo __('Image resizing settings'); ?>
</h2>
 
                                    </div>
<div id="IRSettings" class="card">
	
	<form id="IRSettingsForm" class="form" action="<?php echo get_url('plugin/image_resizing/settings'); ?>" method="post">
		<div class="row" style="margin:  0;     padding: 15px 0px 2px 10px;">
		<section>
                    
                      <div class="col-lg-6 col-md-6 colpaddding15">
                       <div class="col-lg-6 col-md-5">
			<label><?php echo __('Cache images sizes'); ?> <p><?php echo __('Images with this sizes will be cached in same directory.'); ?></p></label>
			</div>
                         <div class="col-lg-6 col-md-7">
                        <span id="IRSettingsCache">
                            
                            
                            <?php if(!empty($setting['cache_sizes'])): ?>
				<?php foreach(unserialize($setting['cache_sizes']) as $size): ?>
                            
                            
                                 <label class="checkbox-inline">
                           
                            
                                <input id="IRSettingsCacheCkeckbox-<?php echo $size; ?>" type="checkbox" value="<?php echo $size; ?>" name="setting[cache_sizes][]" checked /> 
                            
                                <i class="input-helper"></i>
                       <p><?php echo $size; ?></p>
                            
                      
                            
                            
                            
                                </label>
                            
				 
				<?php endforeach; ?>
				<?php endif; ?>
                            
                            
				<button class="botton-fm" id="IRSettingsCacheAddButton"><i style="    padding-top: 12px;" class="zmdi zmdi-fm-edit zmdi-plus"></i></button>
                               
			</span>
                              </div>
                        </div> 
		</section>
		
		<section>
                     <div class="col-lg-6 col-md-6 colpaddding15">
                       <div class="col-lg-6 col-md-5">
			
                           <label for="IRSettingsQualityField"><?php echo __('Resized images quality'); ?> <em><?php echo __('More is better, but a larger file.'); ?></em></label>
			</div>
                         <div class="col-lg-6 col-md-7">
                           <span>
				<select id="IRSettingsQualityField" name="setting[quality]">
					<?php for($i=100; $i>=10; $i-=10): ?>
					<option value="<?php echo $i; ?>" <?php if($setting['quality'] == $i) echo('selected'); ?> ><?php echo $i; ?></option>
					<?php endfor; ?>
				</select>
			</span>
                               </div>
                        </div> 
		</section>
		</div>
		<div class="box-buttons">
			<button class="button-submit-style" type="submit" name="commit"><i class="zmdi zmdi-check"></i> <?php echo __('Save setting'); ?></button>
						 <a class="button-submit-style-a" href="<?php echo get_url('plugins'); ?>"><i class="zmdi zmdi-undo"></i> <?php echo __('Cancel'); ?></a>
		</div>
		
	</form>
	
</div><!--/#-->