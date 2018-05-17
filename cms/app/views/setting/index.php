<?php if(!defined('CMS_ROOT')) die;

/**
 * Flexo CMS - Content Management System. <http://flexo.up.dn.ua>
 * Copyright (C) 2008 Maslakov Alexander <jmas.ukraine@gmail.com>
 * Copyright (C) 2008 Philippe Archambault <philippe.archambault@gmail.com>
 * Copyright (C) 2008 Martijn van der Kleijn <martijn.niji@gmail.com>
 *
 * This file is part of Flexo CMS.
 *
 * Flexo CMS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Flexo CMS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Flexo CMS.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Flexo CMS has made an exception to the GNU General Public License for plugins.
 * See exception.txt for details and the full text.
 */

/**
 * @package Flexo
 * @subpackage views
 *
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 * @author Maslakov Alexandr <jmas.ukraine@gmail.com>
 * @version 0.1
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 * @copyright Maslakov Alexander, 2011
 */
 
?>
<div class="content__header">
<h2><!--<?php echo __('General setting'); ?>-->   <?php echo __('Site options'); ?></h2>
 
                                    </div>
					
<div id="setting" class="card">
	
	<form id="settingForm" class="form" action="<?php echo get_url('setting'); ?>" method="post" style="padding-top: 5px;">
	 
		<h2 class="box-title"> </h2>
		
                <div class="row" style="margin:  0;">
		<section>
                    <div class="col-lg-6 col-md-6">
                        <div class="col-lg-5  col-md-6">
			<label for="settingTitle"><?php echo __('Site title'); ?> 
                            <p><?php echo __('This text will be bresent at backend and can be used in themes.'); ?></p>
                        </label>
                        </div>
                        <div class="col-lg-7  col-md-6">
			<span>
                            <input id="settingTitle" class="input-text" type="text" name="setting[admin_title]" maxlength="255" size="50" value="<?php echo htmlentities(Setting::get('admin_title'), ENT_COMPAT, 'UTF-8'); ?>" />
                           
                        </span>
                        </div>
                        
                       </div> 
		</section>
                    
                    
                  <section>
                    <div class="col-lg-6 col-md-6">
                        <div class="col-lg-5  col-md-6">
			<label for="settingSubTitle"><?php echo __('Site subtitle'); ?>
                            <p><?php echo __('This text will be bresent at backend and can be used in themes.'); ?></p>
                          </label>
                        </div>
                        <div class="col-lg-7  col-md-6">
			<span>
                              <input id="settingSubTittle" class="input-text" type="text" name="setting[admin_subtitle]" maxlength="255" size="50" value="<?php echo htmlentities(Setting::get('admin_subtitle'), ENT_COMPAT, 'UTF-8'); ?>" />
                     
                        </span>
                        </div>
                        
                       </div> 
		</section>  
                    
                    
                    
		
		
		</div> <div class="row" style="margin:  0;">
		<section>
                      
                    <div class="col-lg-6 col-md-6">
                            <div class="col-lg-5  col-md-6">
			<label for="settingSection"><?php echo __('Default backend section'); ?> 
                            <p><?php echo __('This allows you to specify which section you will see by default after login.'); ?></p></label>
			 </div>
                           <div class="col-lg-7  col-md-6">
                        <span>
				<select id="settingSection" name="setting[default_tab]">
				<?php $current_default_nav = Setting::get('default_tab');?>
					<?php foreach( Plugin::$nav as $name => $group ): ?>
						<optgroup label="<?php echo __($name); ?>">
						<?php foreach( $group->items as $item ): ?>
							<option value="<?php echo $item->uri; ?>" <?php if ($item->uri == $current_default_nav) echo 'selected="selected"'; ?> ><?php echo $item->name; ?></option>
						<?php endforeach; ?>
						</optgroup>
					<?php endforeach; ?>
				</select>
			</span>
                               </div> 
                        
                         </div> 
                          
		</section>
                    
                    <section>
                     <div class="col-lg-6 col-md-6" >
                     <div class="col-lg-5  col-md-6">
			<label for="settingTheme"><?php echo __('Backend theme'); ?> 
                            <p><?php echo __('This will change your backend interface theme.'); ?></p>
                        </label>
			 </div>
                     <div class="col-lg-7  col-md-6">
                        <span>
				<select id="settingTheme" name="setting[theme]">
				<?php $current_theme = Setting::get('theme'); ?>
				<?php foreach( Setting::getThemes() as $code => $label ): ?>
					<option value="<?php echo $code; ?>" <?php if ($code == $current_theme) echo 'selected="selected"'; ?>><?php echo __($label); ?></option>
				<?php endforeach; ?>
				</select>
			</span>
                         </div>
                         </div> 
		</section>
                    
                    
       </div><!--/#setting-->             
                    
              
 	  
<div class="row" style="margin:  0;">
		 
		<div class="col-lg-6 col-md-6">
                    <section>
                    <div class="col-lg-5  col-md-6">
			<label for="settingPageFilter"><?php echo __('Default filter'); ?> <p><?php echo __('Only for filter in pages, <i>not</i> in snippets.'); ?></p></label>
			   </div>
                     <div class="col-lg-7  col-md-6">
                        <span>
				<select id="settingPageFilter" name="setting[default_filter_id]">
					<?php $current_default_filter_id = Setting::get('default_filter_id'); ?>
					<option value="" <?php if( $current_default_filter_id == '' ) echo ('selected="selected"'); ?> >&ndash; <?php echo __('none'); ?> &ndash;</option>
					<?php foreach( $filters as $filter_id ): ?>
					<?php if( isset($loaded_filters[$filter_id]) ): ?>
					<option value="<?php echo $filter_id; ?>" <?php if( $filter_id == $current_default_filter_id ) echo ('selected="selected"'); ?> ><?php echo Inflector::humanize($filter_id); ?></option>
					<?php endif; ?>
					<?php endforeach; ?>
				</select>
			</span>
                           </div>
		</section>
		
		</div><div class="col-lg-6 col-md-6">
		<section>
                    <div class="col-lg-5  col-md-6">
			<label><?php echo __('Default page status'); ?> 
                            <p><?php echo __('This status will be autoselected when page creating.'); ?></p></label>
                        
                        </div>
                     <div class="col-lg-7  col-md-6">
			<span>
                             <div class="radio col-md-12 col-lg-6 col-sm-6 col-xs-6">
                            <label>
                                <input id="settingPageStatusDraft" type="radio" name="setting[default_status_id]"  value="<?php echo Page::STATUS_DRAFT; ?>" <?php if (Setting::get('default_status_id') == FrontPage::STATUS_DRAFT) echo 'checked="checked"'; ?> >
                                <i class="input-helper"></i>
                               <?php echo __('Draft'); ?>
                            </label>
                        </div>

                         

                        <div class="radio col-md-12 col-lg-6 col-sm-6 col-xs-6">
                            <label>
                                <input  id="settingPageStatusPublished"  type="radio" name="setting[default_status_id]" value="<?php echo Page::STATUS_PUBLISHED; ?>" <?php if (Setting::get('default_status_id') == FrontPage::STATUS_PUBLISHED) echo 'checked="checked"'; ?> >
                                <i class="input-helper"></i>
                               <?php echo __('Published'); ?>
                            </label>
                        </div>
                            
                            <!--
				<i class="radio"><input id="settingPageStatusDraft" type="radio" name="setting[default_status_id]" value="<?php echo Page::STATUS_DRAFT; ?>" <?php if (Setting::get('default_status_id') == FrontPage::STATUS_DRAFT) echo 'checked="checked"'; ?> /> <label for="settingPageStatusDraft"><?php echo __('Draft'); ?></label></i>
				<i class="radio"><input id="settingPageStatusPublished" type="radio" name="setting[default_status_id]" value="<?php echo Page::STATUS_PUBLISHED; ?>" <?php if (Setting::get('default_status_id') == FrontPage::STATUS_PUBLISHED) echo 'checked="checked"'; ?> /> <label for="settingPageStatusPublished"><?php echo __('Published'); ?></label></i>
			-->
                            </span>
                            </div>
		</section>
		 </div>
                </div>
		<?php Observer::notify('view_setting_plugins'); ?>
		
		<div class="box-buttons" style=" ">
			<button  class="button-submit-style" type="submit"><i class="zmdi zmdi-check"></i> <?php echo __('Save setting'); ?></button>
		</div>
		
	</form> 
	
 </div><!--/#setting-->