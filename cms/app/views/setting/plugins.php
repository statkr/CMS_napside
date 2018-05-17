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
<h2><?php echo __('Plugins'); ?></h2>
               
                                    </div>

<div id="pluginsMap" class="card">
	
	<div id="pluginsMapActions" class="box-actions">
		<!--<button rel="<?php echo get_url('plugins/add'); ?>" id="pluginsMapAddButton" class="button-image"><img src="images/add.png" /> <?php echo __('Add plugin'); ?></button>-->
	</div>
 
	
	<ul id="pluginsMapItems" class="map-items" style="padding-left: 0px;">
	
		<?php foreach ($plugins as $plugin): ?>
		<?php $disabled = (isset($plugin->require_version) && $plugin->require_version > CMS_VERSION); ?>
		<li>
			<div class="item <?php if($disabled) echo('item-disabled'); elseif(Plugin::isEnabled($plugin->id)) echo('item-enabled'); ?>">
				<span class="title">
                                    <em><i class="zmdi zmdi-plugins <?php echo $plugin->icon; ?>"></i></em>
					<em><?php echo $plugin->title; ?></em>
					<i> 
                                           
                                            <?php if( $disabled ) echo('<span class="disabled">'.__('This plugin cannot be enabled! It requires CMS version :v.', array(':v' => $plugin->require_version)).'</span>'); ?>
                                        </i>
				</span>
				 <!--<span class="author"><?php echo(isset($plugin->author) ? $plugin->author : __('n/a')); ?></span>
				<span class="website"><a href="<?php echo $plugin->website; ?>" target="_blank"><?php echo __('Website') ?></a></span>
				<span class="latest"><?php echo (($latest = Plugin::checkLatest($plugin)) == 'unknown' ? __('unknown') : $latest); ?></span>-->
				<div style="
    float: right;
">
                                    <span class="version v2k hidden-sm hidden-xs"><?php echo $plugin->version; ?></span>
                                <span class="action">
                                    
                                    <button class="botton-fmp" data-trigger="hover" data-toggle="popover" data-placement="left" data-content="<?php echo $plugin->description; ?>" title="" >
                           <i class="zmdi zmdi-fm-edit zmdi-pin-help"></i>
                            </button>
                                    
					<?php if( isset($loaded_plugins[$plugin->id]) && Plugin::hasSettingsPage($plugin->id) ): ?>
						<button class="item-settings-button botton-fmp" rel="<?php echo get_url('plugin/'.$plugin->id.'/settings'); ?>" title="<?php echo __('Plugin settings'); ?>"><i class="zmdi zmdi-fm-edit zmdi-settings"></i></button>
					<?php endif; ?>
					
					<?php if (isset($loaded_plugins[$plugin->id]) && Plugin::hasDocumentationPage($plugin->id) ): ?>
						<button class="item-docs-button botton-fmp" rel="<?php echo get_url('plugin/'.$plugin->id.'/documentation'); ?>" title="<?php echo __('Documentation'); ?>"><i class="zmdi zmdi-fm-edit zmdi-library"></i></button>
					<?php endif; ?>
					
					<?php if ( $disabled ): ?>
                                                <button disabled><i class="zmdi zmdi-fm-edit zmdi-lock-open"></i></button>
					<?php elseif ( Plugin::isEnabled($plugin->id) ): ?>
						<button class="item-deactivate-button botton-fmp" rel="<?php echo get_url('plugins/deactivate_plugin/'.$plugin->id); ?>" title="<?php echo __('Deactivate plugin'); ?>"><i class="zmdi zmdi-fm-edit zmdi-pause"></i></button>
					<?php else: ?>
						<button class="item-activate-button botton-fmp" rel="<?php echo get_url('plugins/activate_plugin/'.$plugin->id); ?>" title="<?php echo __('Activate plugin'); ?>"><i class="zmdi zmdi-fm-edit zmdi-play"></i></button>
					<?php endif; ?>
				</span>
                                    
                                    </div>
                                <div class="clearfix"></div>
			</div>
		</li>
		<?php endforeach; ?>
	</ul>
	
</div><!--/#pluginsMap-->