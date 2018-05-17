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


<?php if ( empty($page_part->is_protected) || $page_part->is_protected == PagePart::PART_NOT_PROTECTED || ($page_part->is_protected == PagePart::PART_PROTECTED && AuthUser::hasPermission(array('administrator','developer'))) ): ?>
<div id="pageEditPart-<?php echo $index; ?>" rel="<?php echo $page_part->name; ?>" class="item">
	<input id="pageEditPartName-<?php echo ($index-1); ?>" name="part[<?php echo ($index-1); ?>][name]" type="hidden" value="<?php echo $page_part->name; ?>" />

	<?php if (isset($page_part->id)): ?>
	<input id="pageEditPartId-<?php echo ($index-1); ?>" name="part[<?php echo ($index-1); ?>][id]" type="hidden" value="<?php echo $page_part->id; ?>" />
	<?php endif; ?>
	
	<div class="item-title">
		<?php echo $page_part->name; ?>
		<a class="item-options-button" href="#" title="<?php echo __('Page part options'); ?>"><i style="
    font-size: 20px;
    color: #8a9ba1;
" class="zmdi Settingszmdi-collection-item"></i></a>
	</div>
	
	<div class="item-options">
            <span class="inlinespan" style="    display: inline-block;">
			<label><?php echo __('Filter'); ?></label>
			<span>
				<select class="item-filter" name="part[<?php echo ($index-1); ?>][filter_id]" rel="<?php echo ($index-1); ?>">
					<option value="">&ndash; <?php echo __('none'); ?> &ndash;</option>
					<?php foreach (Filter::findAll() as $filter): ?> 
					<option value="<?php echo $filter; ?>" <?php echo( $page_part->filter_id == $filter ? ' selected="selected"': ''); ?> ><?php echo Inflector::humanize($filter); ?></option>
					<?php endforeach; ?> 
				</select>
			</span>
		</span>
		
		<?php if( AuthUser::hasPermission('administrator,developer') ): ?>
		<span class="checkbox inlinespan" style="    display: inline-block;">
			<label style="top: -4px;" class="checkbox-inline">
                            <input id="pageEditPartProtected-<?php echo ($index-1); ?>" type="checkbox" class="select-box" name="part[<?php echo ($index-1); ?>][is_protected]" value="<?php echo PagePart::PART_PROTECTED; ?>" <?php echo(isset($page_part->is_protected) && $page_part->is_protected == PagePart::PART_PROTECTED ? ' checked': ''); ?>  >
                            <i class="input-helper"></i>
                            <label style="top: 2px;left: 2px;" class="centertext" for="pageEditPartProtected-<?php echo ($index-1); ?>"><?php echo __('Is protected'); ?></label>
                        </label>
                    
			
		</span>
		<?php endif; ?>
		
		<?php if ($page_part->name != 'body'): ?>
		<span class="inlinespan" style="    display: inline-block;"><button class="item-remove removebottom"><img src="images/remove.png" /> <?php echo __('Remove part :part_name', array(':part_name' => $page_part->name)); ?></button></span>
		<?php endif; ?>
	</div>
	
	<div class="item-content">
		<textarea id="pageEditPartContent-<?php echo ($index-1); ?>" name="part[<?php echo ($index-1); ?>][content]" tabindex="<?php echo (6 + $index); ?>" spellcheck="false" wrap="off"><?php echo htmlentities($page_part->content, ENT_COMPAT, 'UTF-8'); ?></textarea>
		
		<?php if ($page_part->filter_id != ''): ?>
		<script>
			jQuery(function(){
				cms.filters.switchOn( 'pageEditPartContent-<?php echo ($index-1); ?>', '<?php echo $page_part->filter_id; ?>' );
			});
		</script>
		<?php endif; ?>
	</div>
</div><!--/#pageEditPart-->
<?php else: ?>
<div class="item item-part-protected">
	<p><?php echo __('Content of page part <b>:part_name</b> is protected from changes.', array(':part_name' => $page_part->name)); ?></p>
</div>
<?php endif; ?>

