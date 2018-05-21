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
 




<div id="userMap">
                    <div class="content__header">
                        
                            <div class="actions" style="    
         position: absolute;
    left: -1px;
    top: -7px;">
                        
                        <div class="dropdown">
                            <a href="" class="drop-paste" data-toggle="dropdown"><i class="zmdi zmdi-more-vert"></i></a>
                            <ul class="dropdown-menu pull-right">
                                <div class="box-actions">
		
		<button rel="<?php echo get_url('user/add'); ?>" id="userMapAddButton" class="button-image bottom-home"><i class="zmdi zmdi-home zmdi-account-add"></i> Добавить</button>
 
	
                               </div>
                            </ul>
                        </div>
                    </div>
                        
                        <h2><?php echo __('Users'); ?></h2>

                         
                    </div>

 
    
                    <div class="action-header action-header--dark">
                        <ul class="action-header__menu action-header__menu--padding">
                            <li><input id="all_func" class="but_contact" type="button" value="Все пользователи" /></li>
                            <li> <input id="admin_func" class="but_contact" type="button" value="Администраторы" /></li>
                            <li><input id="dev_func" class="but_contact" type="button" value="Разработчики" /></li>
                            <li><input id="editor_func" class="but_contact" type="button" value="Редакторы" /></li>
                        </ul>

                         
<script>
  admin_func.onclick = function() {
    document.getElementById('contact_all').style.display ='none';
    document.getElementById('admin_contact').style.display ='block';
    document.getElementById('editor_contact').style.display ='none';
    document.getElementById('dev_contact').style.display ='none';
  

  };
  
    dev_func.onclick = function() {

    document.getElementById('editor_contact').style.display ='none';
    document.getElementById('admin_contact').style.display ='none';
    document.getElementById('dev_contact').style.display ='block';
    document.getElementById('contact_all').style.display ='none';

  };
  
     editor_func.onclick = function() {

    document.getElementById('editor_contact').style.display ='block';
    document.getElementById('admin_contact').style.display ='none';
    document.getElementById('dev_contact').style.display ='none';
    document.getElementById('contact_all').style.display ='none';

  };
  
    admin_func.onclick = function() {
    document.getElementById('contact_all').style.display ='none';
    document.getElementById('admin_contact').style.display ='block';
    document.getElementById('editor_contact').style.display ='none';
    document.getElementById('dev_contact').style.display ='none';
  

  };
  
    all_func.onclick = function() {
    document.getElementById('contact_all').style.display ='block';
    document.getElementById('admin_contact').style.display ='none';
    document.getElementById('editor_contact').style.display ='none';
    document.getElementById('dev_contact').style.display ='none';
  

  };
</script>
                       
                    </div>

    <div id="contact_all" class="contacts row" style="display: block">
	
		<?php foreach ($users as $user): ?>
        <?php $sd = implode(', ', $user->getPermissions()); ?>
		<div class="col-md-2 col-sm-4">
                            <div class="contacts__item">
                                <a href="<?php echo get_url('user/edit/'.$user->id); ?>" class="contacts__img">
                                   <img height="100%" src="http://voice4thought.org/wp-content/uploads/2016/08/default1.jpg"  style="opacity: 0.3;" title="<?php echo __('Avatar from www.gravatar.com'); ?>" alt="" />
					
                                </a>
                                
                                 <div class="user__info" >
                                    <strong>Имя: <?php echo $user->name; ?></strong>
                                    <small>Логин: <?php echo $user->username; ?></small>
                                    <small>Почта: <?php echo $user->email; ?></small>
                                   
                                  
                                    <small>Роль: <?php echo implode(', ', $user->getPermissions()); ?></small>
                                </div>
                                
                                
                                
                               <!-- <span class="action">
					<?php if ($user->id > 1): ?>
					<button class="item-remove-button" rel="<?php echo get_url('user/delete/'.$user->id); ?>" title="<?php echo __('Remove'); ?>"><img src="images/remove.png" /></button>
					<?php else: ?>
					<button disabled><img src="images/remove.png" /></button>
					<?php endif; ?>
				</span>-->
                                <form action="<?php echo get_url('user/edit/'.$user->id); ?>">
                                   <button class="contacts__btn btn btn--icon-text btn--light"><i class="zmdi zmdi-account"></i> Редактировать</button>
                                  
                                </form>
                                 
                                 
				 
				
		  </div>
                        </div>
		<?php endforeach; ?>
	  </div>
    
    
    
    
    <div id="admin_contact" class="contacts row" style="display: none">
	
		<?php foreach ($users as $user): ?>
        <?php $sd = implode(', ', $user->getPermissions()); ?>
		<div class="col-md-2 col-sm-4" style="<?php  if ($sd !== "administrator"): ?> display:none; <?php else: ?> alala<?php endif; ?>">
                            <div class="contacts__item">
                                <a href="<?php echo get_url('user/edit/'.$user->id); ?>" class="contacts__img">
                                   <img height="100%" src="http://voice4thought.org/wp-content/uploads/2016/08/default1.jpg"  style="opacity: 0.3;" title="<?php echo __('Avatar from www.gravatar.com'); ?>" alt="" />
					
                                </a>
                                
                                 <div class="user__info" >
                                    <strong>Имя: <?php echo $user->name; ?></strong>
                                    <small>Логин: <?php echo $user->username; ?></small>
                                    <small>Почта: <?php echo $user->email; ?></small>
                                   
                                  
                                    <small>Роль: <?php echo implode(', ', $user->getPermissions()); ?></small>
                                </div>
                                
                                
                                
                               <!-- <span class="action">
					<?php if ($user->id > 1): ?>
					<button class="item-remove-button" rel="<?php echo get_url('user/delete/'.$user->id); ?>" title="<?php echo __('Remove'); ?>"><img src="images/remove.png" /></button>
					<?php else: ?>
					<button disabled><img src="images/remove.png" /></button>
					<?php endif; ?>
				</span>-->
                                <form action="<?php echo get_url('user/edit/'.$user->id); ?>">
                                   <button class="contacts__btn btn btn--icon-text btn--light"><i class="zmdi zmdi-account"></i> Редактировать</button>
                                  
                                </form>
                                 
                                 
				 
				
		  </div>
                        </div>
		<?php endforeach; ?>
	  </div>
    
    
    <div id="dev_contact" class="contacts row" style="display: none">
	
		<?php foreach ($users as $user): ?>
        <?php $sd = implode(', ', $user->getPermissions()); ?>
		<div class="col-md-2 col-sm-4" style="<?php  if ($sd !== "developer"): ?> display:none; <?php else: ?> alala<?php endif; ?>">
                            <div class="contacts__item">
                                <a href="<?php echo get_url('user/edit/'.$user->id); ?>" class="contacts__img">
                                   <img height="100%" src="http://voice4thought.org/wp-content/uploads/2016/08/default1.jpg"  style="opacity: 0.3;" title="<?php echo __('Avatar from www.gravatar.com'); ?>" alt="" />
					
                                </a>
                                
                                 <div class="user__info" >
                                    <strong>Имя: <?php echo $user->name; ?></strong>
                                    <small>Логин: <?php echo $user->username; ?></small>
                                    <small>Почта: <?php echo $user->email; ?></small>
                                   
                                  
                                    <small>Роль: <?php echo implode(', ', $user->getPermissions()); ?></small>
                                </div>
                                
                                
                                
                               <!-- <span class="action">
					<?php if ($user->id > 1): ?>
					<button class="item-remove-button" rel="<?php echo get_url('user/delete/'.$user->id); ?>" title="<?php echo __('Remove'); ?>"><img src="images/remove.png" /></button>
					<?php else: ?>
					<button disabled><img src="images/remove.png" /></button>
					<?php endif; ?>
				</span>-->
                                <form action="<?php echo get_url('user/edit/'.$user->id); ?>">
                                   <button class="contacts__btn btn btn--icon-text btn--light"><i class="zmdi zmdi-account"></i> Редактировать</button>
                                  
                                </form>
                                 
                                 
				 
				
		  </div>
                        </div>
		<?php endforeach; ?>
	  </div>
    
    
    
    <div id="editor_contact" class="contacts row" style="display: none">
	
		<?php foreach ($users as $user): ?>
        <?php $sd = implode(', ', $user->getPermissions()); ?>
		<div class="col-md-2 col-sm-4" style="<?php  if ($sd !== "editor"): ?> display:none; <?php else: ?> alala<?php endif; ?>">
                            <div class="contacts__item">
                                <a href="<?php echo get_url('user/edit/'.$user->id); ?>" class="contacts__img">
                                   <img height="100%" src="http://voice4thought.org/wp-content/uploads/2016/08/default1.jpg"  style="opacity: 0.3;" title="<?php echo __('Avatar from www.gravatar.com'); ?>" alt="" />
					
                                </a>
                                
                                 <div class="user__info" >
                                    <strong>Имя: <?php echo $user->name; ?></strong>
                                    <small>Логин: <?php echo $user->username; ?></small>
                                    <small>Почта: <?php echo $user->email; ?></small>
                                   
                                  
                                    <small>Роль: <?php echo implode(', ', $user->getPermissions()); ?></small>
                                </div>
                                
                                
                                
                               <!-- <span class="action">
					<?php if ($user->id > 1): ?>
					<button class="item-remove-button" rel="<?php echo get_url('user/delete/'.$user->id); ?>" title="<?php echo __('Remove'); ?>"><img src="images/remove.png" /></button>
					<?php else: ?>
					<button disabled><img src="images/remove.png" /></button>
					<?php endif; ?>
				</span>-->
                                <form action="<?php echo get_url('user/edit/'.$user->id); ?>">
                                   <button class="contacts__btn btn btn--icon-text btn--light"><i class="zmdi zmdi-account"></i> Редактировать</button>
                                  
                                </form>
                                 
                                 
				 
				
		  </div>
                        </div>
		<?php endforeach; ?>
	  </div>
    <div id="userMapActions" class="box-actions">
	 
	</div>
                   
                        
 
                         
                                

                               

                               
                          

                   

                    
                </div>

















 