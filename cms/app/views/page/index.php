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
<div class="content__header" >

    
                                    

<div id="pageMap" >
    
    <div class="actions" style="    
         position: absolute;
    left: -1px;
    top: -7px;">
                        
                        <div class="dropdown">
                            <a href="" class="drop-paste" data-toggle="dropdown"><i class="zmdi zmdi-more-vert"></i></a>
                            <ul class="dropdown-menu pull-right">
                                <div class="box-actions">
		
		 
		<button id="pageMapReorderButton" class="page-map-reorder-button button-image bottom-home"><i class="zmdi zmdi-home zmdi-swap-alt"></i> <?php echo __('Reorder'); ?></button>
		<button id="pageMapCopyButton" class="page-map-copy-button button-image bottom-home"><i class="zmdi zmdi-home zmdi-copy"></i> <?php echo __('Copy'); ?></button>
	
                               </div>
                            </ul>
                        </div>
                    </div>   
    
		<h2 style="
    font-size: inherit;
"><span class="title text-page-header"><?php echo __('Page'); ?></span></h2>
		<h2><span class="status text-page-header hidden-sm hidden-xs"><?php echo __('Status'); ?></span></h2>
		<h2><span class="date text-page-header hidden-sm hidden-xs"><?php echo __('Date'); ?></span></h2>
		<h2><span class="action text-page-header" style="display: block;"><?php echo __('Actions'); ?></span></h2>
	</div>

</div>
					
<div id="pageMap" class="card" >
    
	
    
	
	
	
	<ul id="pageMapItems" class="map-items" style="
    padding-left: 0px;
">
		<li rel="<?php echo $root->id; ?>" class="map-items map-level-0">
			<div class="item">
				<span class="title">
					<?php if( ! AuthUser::hasPermission($root->getPermissions()) ): ?>
					<img src="images/page-text-locked.png" title="<?php echo('You do not have permission to access the requested page!'); ?>" />
					<em title="/"><?php echo $root->title; ?></em>
					<?php else: ?>
					<img src="images/page-text.png" />
					<a href="<?php echo get_url('page/edit/1'); ?>" title="/"><?php echo $root->title; ?></a>
					<?php endif; ?>
					</span>
                            
                            
                            
                            
                            
                            
                                  
                            
                            
                            
                          
                
                
                       
                            
                            
                            
                            
				<span class="date hidden-sm hidden-xs"><?php echo date('Y-m-d', strtotime($root->published_on)); ?></span>
				<span class="status hidden-sm hidden xs"><em class="item-status-published"><?php echo __('Published'); ?></em></span>
				
                                <div class="action action-btn-home">
                      
                           <a class="padding-icon-page" style="    margin-top: 4px;" href="<?php echo(CMS_URL); ?>" target="_blank"  ><i class="zmdi zmdi-getsite zmdi-redo"></i> </a>
				                                 
                                    
                        <a class="padding-icon-page" style="    margin-top: 4px;" href="<?php echo get_url('page/add/'.$root->id); ?>" title="/"><i class="zmdi zmdi-getsite zmdi-plus"></i></a>
                        <a class="padding-icon-page" style="    margin-top: 4px;" href="<?php echo get_url('page/edit/1'); ?>" title="/"><i class="zmdi  zmdi-getsite zmdi-edit"></i></a>
                          
                             
                        
                        
                        
                    </div>    
                                        
                                          
                                    
				
                           
			</div>
			
			<?php echo $content_children; ?>
		</li>
	</ul><!--/#pageMapItems-->
	
	<ul id="pageMapSearchItems" class="map-items" style="padding:0"><!--x--></ul>
	
</div>