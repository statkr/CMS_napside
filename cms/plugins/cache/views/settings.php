<?php if(!defined('CMS_ROOT')) die; ?>
<div class="content__header">
<h2>
	<a href="<?php echo get_url('plugins'); ?>"><?php echo __('Plugins'); ?></a> &rarr;
	<?php echo __('Cache settings'); ?>
</h2>
              
                                    </div>

<div id="CS" class="card">
	<form id="CSForm" class="form" action="<?php echo get_url('plugin/cache/settings'); ?>" method="post">
		  <div class="row" style="margin:  0;     padding: 15px 0px 2px 10px;">
		<section>
                  
                        <div class="col-lg-6 col-md-6 colpaddding15">
                       <div class="col-lg-6 col-md-5">
			<label><?php echo __('Cache'); ?></label>
                        </div>
                         <div class="col-lg-6 col-md-7">
			<span id="CSType">
                            <label class="checkbox-inline">
                            <input id="CSTypeRadio-static" type="checkbox" value="yes" name="setting[cache_static]" <?php if (isset($setting['cache_static']) && $setting['cache_static'] == 'yes') echo('checked'); ?> >
                            <i class="input-helper"></i>
                          <?php echo __('Switch On'); ?>
                            
                        </label>
                         </span>
                        </div>
                        </div> 
		</section>
		
		<section>
                    <div class="col-lg-6 col-md-6 colpaddding15">
                       <div class="col-lg-6 col-md-5">
			<label for="CSRemove"><?php echo __('Removing cache'); ?></label>
			</div>
                         <div class="col-lg-6 col-md-7">
                        <span>
				<button class="btn-cache" id="CSRemoveButton" rel="<?php echo get_url('plugin/cache/remove_cache'); ?>"><?php echo __('Remove cached data'); ?></button>
			</span>
                              </div>
                        </div> 
		</section>
		  
		<section>
                    <div class="col-lg-6 col-md-6 colpaddding15">
                       <div class="col-lg-6 col-md-5">
			<label for="CSRemoveStatic"><?php echo __('Removing static cache automaticly'); ?> 
                            <p><?php echo __('When update or save page – all static cache will be removed automaticly.'); ?></p></label>
			</div>
                         <div class="col-lg-6 col-md-7">
                        <span>
                            
                            <label class="checkbox-inline">
                            
                                <input id="CSRemoveStaticCheckbox" type="checkbox" value="yes" name="setting[cache_remove_static]" <?php if (isset($setting['cache_remove_static']) && $setting['cache_remove_static'] == 'yes') echo('checked'); ?> /> 
                            
                                <i class="input-helper"></i>
                       <?php echo __('Remove static cache automaticly'); ?>
                            
                        </label>
                            
				</span>
                               </div>
                        </div> 
		</section>
		
		<section>
                    <div class="col-lg-6 col-md-6 colpaddding15">
                       <div class="col-lg-6 col-md-5">
			<label for="CSLifetime"><?php echo __('Cache life time'); ?> 
                            <p><?php echo __('Time when cache will be updated. Default: 24*60*60 = 86400 seconds.'); ?></p></label>
			
                        </div>
                         <div class="col-lg-6 col-md-7">
                        <span>
				<input class="input-cache" id="CSLifetime" type="text" name="setting[cache_lifetime]" value="<?php echo(isset($setting['cache_lifetime']) ? (int)$setting['cache_lifetime']: 86400); ?>" />
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
</div>