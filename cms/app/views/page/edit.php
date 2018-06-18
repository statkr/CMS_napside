<?php if(!defined('CMS_ROOT')) die;

/**
 * Frog CMS - Content Management Simplified. <http://www.madebyfrog.com>
 * Copyright (C) 2008 Philippe Archambault <philippe.archambault@gmail.com>
 * Copyright (C) 2008 Martijn van der Kleijn <martijn.niji@gmail.com>
 * Copyright (C) 2008 Maslakov Alexander <jmas.ukraine@gmail.com>
 *
 * This file is part of Frog CMS.
 *
 * Frog CMS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Frog CMS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Frog CMS.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Frog CMS has made an exception to the GNU General Public License for plugins.
 * See exception.txt for details and the full text.
 */

/**
 * @package frog
 * @subpackage views
 *
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 * @author Maslakov Alexandr <jmas.ukraine@gmail.com>
 * @version 0.1
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 * @copyright Philippe Archambault, 2008
 */

// TODO: clean up code/solution
$pagetmp = Flash::get('page');
$parttmp = Flash::get('page_parts');
$tagstmp = Flash::get('page_tag');

if ($pagetmp != null && !empty($pagetmp) && $parttmp != null && !empty($parttmp) && $tagstmp != null && !empty($tagstmp))
{
    $page = $pagetmp;
    $page_parts = $parttmp;
    $tags = $tagstmp;
}

?>

<form id="pageEditForm" action="<?php echo ($action == 'add' ? get_url('page/add/'.$parent_id) : get_url('page/edit/'.$page->id)); ?>" method="post">
	
	<?php if (!empty($parent_id)): ?>
	<input type="hidden" name="page[parent_id]" value="<?php echo $parent_id; ?>" />
	<?php endif; ?>
	
	
	
	<div class="content__header col-lg-9 col-md-8 col-sm-12 ">
<h2>
		<a href="<?php echo get_url('page'); ?>"><?php echo __('Pages'); ?></a> &rarr;
		<?php echo __(ucfirst($action).' page'); ?>
		<?php if( $action == 'edit' ): ?>
		<a id="pageEditView" href="<?php echo(CMS_URL . ($uri = $page->getUri()) . (strstr($uri, '.') === false && $uri != '' ? URL_SUFFIX : '')); ?>" target="_blank" title="<?php echo __('View page'); ?>"><i class="zmdi zmdi-forward"></i></a>
		<?php endif; ?></h2>
</div>
             <div  class="col-md-4 col-lg-3 hidden-sm hidden-xs">
                        <h2 class="h2-all-pages">Опции</h2>
                         <div class="piker-blet"><?php Observer::notify('view_page_edit_options', array($page)); ?></div>
                    </div>
                                     
<div class=" row">
    
    <div id="pageEdit" class="col-lg-9 col-md-8 col-sm-12">
                            <div class="contacts__item">
                                <div id="pageEditMeta">
			<p id="pageEditMetaTitle">
				<label><?php echo __('Page title'); ?></label>
				<span><input id="pageEditMetaTitleField" class="input-text" type="text" name="page[title]" value="<?php echo htmlspecialchars($page->title, ENT_QUOTES); ?>" size="255" maxlength="255" tabindex="1" /></span>
				<a id="pageEditMetaMoreButton" href="#" title="<?php echo __('Page meta information'); ?>"><i style="
      font-size: 20px;
    background: #2b3942;
    padding-right: 12px;
    padding-left: 5px;
    margin-right: -12px;
    color: #8a9ba1;
" class="zmdi Settingszmdi-collection-item"></i></a>
			</p>
			<div id="pageEditMetaMore" >
				<?php if($action == 'add' || ($action == 'edit' && isset($page->id) && $page->id != 1)): ?>
				<p class="bottom-mergin-in-edit">
					<label style="margin-top: 5px;"><?php echo __('Slug'); ?></label>
					<span><input id="pageEditMetaSlugField" class="input-text" type="text" name="page[slug]" value="<?php echo $page->slug; ?>" size="100" maxlength="100" tabindex="2" style="line-height: 35px;" /></span>
				</p>
				<?php endif; ?>
				
				<p class="bottom-mergin-in-edit">
					<label style="margin-top: 5px;"><?php echo __('Breadcrumb'); ?></label>
					<span><input id="pageEditMetaBreadcrumbField" class="input-text" type="text" name="page[breadcrumb]" value="<?php echo htmlspecialchars($page->breadcrumb, ENT_QUOTES); ?>" size="160" maxlength="160" tabindex="3" style="line-height: 35px;"  /></span>
				</p>
				
				<p class="bottom-mergin-in-edit">
					<label><?php echo __('Keywords'); ?></label>
					<span><textarea id="pageEditMetaKeywordsField" class="textarea" name="page[keywords]" maxlength="255" tabindex="4"><?php echo htmlspecialchars($page->keywords, ENT_QUOTES); ?></textarea></span>
				</p>
				
				<p class="bottom-mergin-in-edit">
					<label><?php echo __('Description'); ?></label>
					<span><textarea id="pageEditMetaDescriptionField" class="textarea" name="page[description]" maxlength="255" tabindex="4"><?php echo htmlspecialchars($page->description, ENT_QUOTES); ?></textarea></span>
				</p>
				
				<p class="bottom-mergin-in-edit">
					<label><?php echo __('Tags'); ?></label>
					<span><textarea id="pageEditMetaTagsField" class="textarea" name="page_tag[tags]" maxlength="255" tabindex="6"><?php echo join(', ', $tags); ?></textarea></span>
				</p>
				
				<?php Observer::notify('view_page_edit_meta', array($page)); ?>
				
				<?php if (isset($page->updated_on)): ?>
				<p id="pageEditLastUpdated"><small><?php echo __('Last updated by <a href=":link">:name</a> on :date', array(':link' => get_url('user/edit/' . $page->updated_by_id), ':name' => $page->updated_by_name, ':date' => date('D, j M Y', strtotime($page->updated_on)))); ?></small></p>
				<?php endif; ?>
			</div>
		</div><!--/#pageEditMeta-->

                
                
                
                
                
		<div id="pageEditParts">
			
			<?php
				$index = 1;
				
				foreach ($page_parts as $page_part)
				{
					echo new View(
						'page/part_edit',
						array(
							'index'       => $index,
							'page_part'   => $page_part,
							'permissions' => $permissions
						)
					);
					$index++; 
				}
			?>
		
		</div><!--/#pageEditParts-->
                
                
                
		
		<?php if (AuthUser::hasPermission(array('administrator','developer'))): ?>
		<p id="pageEditPartAdd"><button id="pageEditPartAddButton" class="button-image button-add-style"><i class="zmdi zmdi-plus"></i> <?php echo __('Add page part'); ?></button></p>
		<?php endif; ?>
		
		<?php Observer::notify('view_page_edit_plugins', array($page)); ?>
		
		<div class="box-buttons hidden-xs hidden-sm">
			<button class="button-submit-style" type="submit" name="commit"><i class="zmdi zmdi-check"></i> <?php echo __('Save'); ?></button>
			<button class="button-submit-style2 " type="submit" name="continue"><i class="zmdi zmdi-check-all"></i> <?php echo __('Save and Continue editing'); ?></button>
			 
                         <a class="button-submit-style-a" href="<?php echo get_url('page'); ?>"><i class="zmdi zmdi-undo"></i> <?php echo __('Cancel'); ?></a>
		  
                         	</div>
                            
                            </div>
                        </div>
    
    <div  class="hidden-lg hidden-md col-sm-12 col-xs-12" style="margin-bottom: 10px;">
                       <h2 class="h2-all-pages">Опции</h2>
                           <div class="piker-blet-sm"><?php Observer::notify('view_page_edit_options', array($page)); ?></div>
                    </div>
    
    <div  class="col-lg-3 col-md-4 col-sm-12">
                            <div class="contacts__item">
                             <div id="pageEditOptions" class="box">
			
                                 
                                 
                             
                                 
			
			  <div class="row padding15">
                          <div class="col-sm-12  col-xs-12  col-md-4">
				<label><?php echo __('Layout'); ?></label>
				</div>
                                 <div class="col-sm-12  col-xs-12  col-md-8">
                                <span>
					

                                    <div class="new-select-style-wpandyou" style="padding: 5px;">
                                    <select name="page[layout_file]" >
						<option value="">&ndash; <?php echo __('inherit'); ?> &ndash;</option>
						<?php foreach ($layouts as $layout): ?>
						<option value="<?php echo($layout->name); ?>" <?php echo($layout->name == $page->layout_file ? ' selected="selected"': ''); ?> ><?php echo $layout->name; ?></option>
						<?php endforeach; ?>
					</select>
                                    </div>
				</span>
                                    </div>
			 
			 
			 <div class="col-sm-12  col-xs-12  col-md-4">
				<label><?php echo __('Type'); ?></label></div>
                                 <div class="col-sm-12  col-xs-12  col-md-8">
				<span> <div class="new-select-style-wpandyou" style="padding: 5px;">
					<select name="page[behavior_id]">
						<option value=""<?php if ($page->behavior_id == '') echo ' selected="selected"'; ?>>&ndash; <?php echo __('none'); ?> &ndash;</option>
						<?php foreach ($behaviors as $behavior): ?>
						<option value="<?php echo $behavior; ?>"<?php if ($page->behavior_id == $behavior) echo ' selected="selected"'; ?>><?php echo Inflector::humanize($behavior); ?></option>
						<?php endforeach; ?>
					</select></div>
				</span> </div>
			 
			
			<?php if(AuthUser::hasPermission(array('administrator','developer')) && ($action == 'add' || ($action == 'edit' && isset($page->id) && $page->id != 1))): ?>
			 
                          <div class="col-sm-12  col-xs-12  col-md-4">
				<label><?php echo __('Status'); ?></label></div>
                                 <div class="col-sm-12  col-xs-12  col-md-8">
				<span><div class="new-select-style-wpandyou" style="padding: 5px;">
					<select name="page[status_id]">
						<option value="<?php echo Page::STATUS_DRAFT; ?>"<?php echo $page->status_id == Page::STATUS_DRAFT ? ' selected="selected"': ''; ?>><?php echo __('Draft'); ?></option>
						<option value="<?php echo Page::STATUS_REVIEWED; ?>"<?php echo $page->status_id == Page::STATUS_REVIEWED ? ' selected="selected"': ''; ?>><?php echo __('Reviewed'); ?></option>
						<option value="<?php echo Page::STATUS_PUBLISHED; ?>"<?php echo $page->status_id == Page::STATUS_PUBLISHED ? ' selected="selected"': ''; ?>><?php echo __('Published'); ?></option>
						<option value="<?php echo Page::STATUS_HIDDEN; ?>"<?php echo $page->status_id == Page::STATUS_HIDDEN ? ' selected="selected"': ''; ?>><?php echo __('Hidden'); ?></option>
					</select></div>
				</span></div>
			</p>
			<?php endif; ?>
			
			<?php if($action == 'add' || ($action == 'edit' && isset($page->id) && $page->id != 1)): ?>
			 <div><div class="col-sm-12  col-xs-12 col-md-4">
				<label><?php echo __('Published'); ?></label></div>
				<div class="col-sm-12 col-xs-12 col-md-8">
                                    <div style="padding:5px;"><span>
					<input class="text-calendar-options" type="text" name="page[published_on]" value="<?php echo $page->published_on; ?>" maxlength="20" />
				</span></div></div>
			 </div>
			<?php endif; ?>
			<?php if (AuthUser::hasPermission(array('administrator','developer'))): ?>
			<div>
				
                                <div class="col-sm-12  col-xs-12 col-md-4"><label><?php echo __('Users roles that can edit page'); ?></label>	</div>
				<div class="col-sm-12  col-xs-12 col-md-8"><span><div style="padding:5px;">
					<select class="new-select-style-noresp" name="page_permissions[]" multiple size="3" title="<?php echo __('Use Ctrl + mouse left click for multiselect'); ?>">
						<?php foreach ($permissions as $permission): ?>
						<option style="padding: 5px;" value="<?php echo $permission->name; ?>" <?php echo(in_array($permission->name, $page_permissions) ? 'selected': ''); ?> ><?php echo ucfirst($permission->name); ?></option>
						<?php endforeach; ?>
					</select>
				</div></span></div>
			</div>
			<?php endif; ?>

			<?php if (AuthUser::hasPermission(array('administrator','developer'))): ?>
			<div><div class="col-sm-12  col-xs-12  col-md-4">
				<label><?php echo __('Needs login'); ?></label></div>
			
                            <div class="col-sm-12  col-xs-12  col-md-8">
				<span><div class="new-select-style-wpandyou" style="padding: 5px;">
					<select name="page[needs_login]">
						<option value="<?php echo Page::LOGIN_INHERIT; ?>"<?php echo $page->needs_login == Page::LOGIN_INHERIT ? ' selected="selected"': ''; ?>>&ndash; <?php echo __('inherit'); ?> &ndash;</option>
						<option value="<?php echo Page::LOGIN_NOT_REQUIRED; ?>"<?php echo $page->needs_login == Page::LOGIN_NOT_REQUIRED ? ' selected="selected"': ''; ?>><?php echo __('Not required'); ?></option>
						<option value="<?php echo Page::LOGIN_REQUIRED; ?>"<?php echo $page->needs_login == Page::LOGIN_REQUIRED ? ' selected="selected"': ''; ?>><?php echo __('Required'); ?></option>
					</select>
				</div></span></div></div>
			 
			<?php endif; ?>
			
			 
                        
                           <div class="box-buttons hidden-md hidden-lg" style="padding: 21px;position:  relative;top: 15px;">
			<button class="button-submit-style" type="submit" name="commit"><i class="zmdi zmdi-check"></i> <?php echo __('Save'); ?></button>
			<button class="button-submit-style2 " type="submit" name="continue"><i class="zmdi zmdi-check-all"></i> <?php echo __('Save and Continue editing'); ?></button>
			 
                         <a class="button-submit-style-a" href="<?php echo get_url('page'); ?>"><i class="zmdi zmdi-undo"></i> <?php echo __('Cancel'); ?></a>
		  
                         	</div>
			 
		</div><!--/#pageEditOptions-->
                	<?php Observer::notify('view_page_edit_sidebar', array($page)); ?>
                            </div>
                        </div>
    
    

    
      
        
  </div>     
        
</form>






