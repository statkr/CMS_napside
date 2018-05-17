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
    
     <div class="actions" style="    
         position: absolute;
    left: -1px;
    top: -7px;">
    <div class="dropdown">
                            <a href="" class="drop-paste" data-toggle="dropdown"><i class="zmdi zmdi-more-vert"></i></a>
                            <ul class="dropdown-menu pull-right">
                                <div class="box-actions">
		
		 
		<button  id="layoutMapAddButton"  class="page-map-reorder-button button-image bottom-home" rel="<?php echo get_url('layout/add'); ?>"><i class="zmdi zmdi-home zmdi-widgets"></i> Добавить</button>
		 
		
                               </div>
                            </ul>
                        </div>
      </div>
    
    
<h2><?php echo __('Layouts'); ?></h2>
                 
                                    </div>
 

<div id="layoutMap" class="card row" style="
    margin: 0px;
">
	
	<div id="layoutMapActions" class="box-actions ">
		<?php /* <button id="layoutMapDownloadButton" class="button-image"><img src="images/down.png" /> Download Themes</button> */ ?>
	</div>
	
	 
	
	<div id="layoutMapItems" class="map-items ">
	
		<?php foreach ($layouts as $layout): ?>
		<div >
			<div class="item col-lg-12  " style="padding-bottom: 7px;">
				<span class="name"><i class="zmdi zmdi-lol zmdi-view-web"></i> <a href="<?php echo get_url('layout/edit/'.$layout->name); ?>"><?php echo $layout->name; ?></a></span>
				<span class="direction styled-dir hidden-xs"><?php echo '/'. LAYOUTS_DIR_NAME .'/'. $layout->name .'.'. LAYOUTS_EXT; ?></span>
				<span class="action">
					<button class="item-remove-button botton-fm2" rel="<?php echo get_url('layout/delete/'. $layout->name); ?>" title="<?php echo __('Remove'); ?>"><i class="zmdi zmdi-fm-edit zmdi-close"></i></button>
                                        
                              </span>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
	
</div><!--/#layoutMap-->