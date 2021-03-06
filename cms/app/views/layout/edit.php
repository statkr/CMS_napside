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
<h2>
	<a href="<?php echo get_url('layout'); ?>"><?php echo __('Layouts'); ?></a> &rarr;
	<?php echo __(ucfirst($action).' layout'); ?>
</h2>

                                    </div>

<form id="layoutEditForm" action="<?php echo $action=='edit' ? get_url('layout/edit/'. $layout->name): get_url('layout/add/'); ?>" method="post">
	
	<div id="layoutEdit" class="card">
            
            
            <p id="layoutEditName">
				<label><?php echo __('Layout name'); ?></label>
				<span><input id="layoutEditNameField" class="input-text" type="text" name="layout[name]" value="<?php echo htmlspecialchars($layout->name, ENT_QUOTES); ?>" size="255" maxlength="255" tabindex="1" size="255" maxlength="255" tabindex="1"></span>
				 
			</p>
            
		 
		
		<p id="layoutEditContent">
			<textarea id="layoutEditContentField" name="layout[content]" style="    resize: vertical; width:100%; height: 450px; min-height: 100px;" tabindex="7" spellcheck="false" wrap="off"><?php echo htmlentities($layout->content, ENT_COMPAT, 'UTF-8'); ?></textarea>
		</p>
		
                
                
                <div class="box-buttons">
			<button class="button-submit-style" type="submit" name="commit"><i class="zmdi zmdi-check"></i> <?php echo __('Save and Close'); ?></button>
			<button class="button-submit-style2 " style="margin-left:7px;" type="submit" name="continue"><i class="zmdi zmdi-check-all"></i> <?php echo __('Save and Continue editing'); ?></button>
			 
                        
                               <a class="button-submit-style-a" href="<?php echo get_url('layout'); ?>"><i class="zmdi zmdi-undo"></i> <?php echo __('Cancel'); ?></a> 
		</div>
                
                
		 
	</div><!--/#layoutEdit-->
	
</form><!--/#layoutEditForm-->