<?php
if (!defined('CMS_ROOT'))
    die;

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
        <a href="<?php echo get_url('user'); ?>"><?php echo __('Users'); ?></a> &rarr;
        <?php echo __(ucfirst($action) . ' user'); ?>
    </h2>

</div>

<div id="userEdit" class="card">

    <form id="userEditForm" class="form" action="<?php echo $action == 'edit' ? get_url('user/edit/' . $user->id) : get_url('user/add');; ?>" method="post" style="padding-top: 5px;">
      <h2 class="box-title"> </h2>
        <div class="row" style="margin:  0;">
            <section>
                <div class="col-lg-6 col-md-6">
                    <div class="col-lg-5  col-md-6">
                        <label for="userEditNameField"><?php echo __('Name'); ?></label>
                    </div>
                    <div class="col-lg-7  col-md-6">
                        <span><input id="userEditNameField" class="input-text" type="text" name="user[name]" maxlength="255" size="50" value="<?php echo $user->name; ?>" /></span>
                    </div>
                </div>
            </section>

            <section>
                <div class="col-lg-6 col-md-6">
                    <div class="col-lg-5  col-md-6">
                        <label for="userEditEmailField"><?php echo __('E-mail'); ?> <p><?php echo __('Optional. Please use a valid e-mail address.'); ?></p></label>
                    </div>
                    <div class="col-lg-7  col-md-6">
                        <span><input id="userEditEmailField" class="input-text" type="text" name="user[email]" maxlength="255" size="50" value="<?php echo $user->email; ?>" /></span>
                    </div>
                </div>
            </section>
        </div> <div class="row" style="margin:  0;">
            <section>
                <div class="col-lg-6 col-md-6">
                    <div class="col-lg-5  col-md-6">
                <label for="userEditUsernameField"><?php echo __('Username'); ?> <p><?php echo __('At least 3 characters. Must be unique.'); ?></p></label>
                </div>
                    <div class="col-lg-7  col-md-6">
                <span><input id="userEditUsernameField" class="input-text" type="text" name="user[username]" maxlength="255" size="50" value="<?php echo $user->username; ?>" /></span>
              </div>
                </div>
                </section>

            <section>
                <div class="col-lg-6 col-md-6">
                    <div class="col-lg-5  col-md-6">
                <label for="userEditPasswordField"><?php echo __('Password'); ?> <p><?php echo __('At least 3 characters. Must be unique.'); ?> <?php if ($action == 'edit') echo __('Leave password blank for it to remain unchanged.'); ?></p></label>
                  </div>
                    <div class="col-lg-7  col-md-6">
                <span><input id="userEditPasswordField" class="input-text" type="password" name="user[password]" maxlength="255" size="50" autocomplete="off" /></span>
              </div>
                </div>
            </section>
        </div> <div class="row" style="margin:  0;">
            <section>
                  <div class="col-lg-6 col-md-6">
                    <div class="col-lg-5  col-md-6">
                <label for="userEditConfirmField"><?php echo __('Confirm Password'); ?></label>
                 </div>
                    <div class="col-lg-7  col-md-6">
                <span><input id="userEditPasswordField" class="input-text" type="password" name="user[confirm]" maxlength="255" size="50" autocomplete="off" /></span>
              </div>
                </div>
                </section>

<?php if (AuthUser::hasPermission('administrator')): ?>
                <section>
                    <div class="col-lg-6 col-md-6">
                    <div class="col-lg-5  col-md-6">
                    <label><?php echo __('Roles'); ?> <p><?php echo __('Roles restrict user privileges and turn parts of the administrative interface on or off.'); ?></p></label>
                    </div>
                    <div class="col-lg-7  col-md-6">
                    <span>
                        <?php $user_permissions = ($user instanceof User) ? $user->getPermissions() : array('editor'); ?>
                        <?php foreach ($permissions as $perm): ?>
                        
                        
                        
                        
                        <div class="radio">
                            <label>
                                <input id="userEditPerms<?php echo ucwords($perm->name); ?>" type="checkbox" name="user_permission[<?php echo $perm->name; ?>]" value="<?php echo $perm->id; ?>" <?php if (in_array($perm->name, $user_permissions)) echo('checked="checked"'); ?> />
                                <i class="input-helper"></i>
                                <?php echo __(ucwords($perm->name)); ?>
                            </label>
                        </div>
                        
                        
                        
                        
                                <?php endforeach; ?>
                    </span>
                        </div>
                </div>
                </section>
<?php endif; ?>
        </div><div class="row" style="margin:  0;">
   
        
        
        
        <section>
             <div class="col-lg-6 col-md-6">
                    <div class="col-lg-5  col-md-6">
            <label for="userEditLanguage"><?php echo __('Interface language'); ?> <p><?php echo __('Individual language for administration interface. Create your own <a href=":url">translation</a>.', array(':url' => get_url('translate'))); ?></p></label>
            </div>
                    <div class="col-lg-7  col-md-6">
            
            <span>
                <select id="userEditLanguage" name="user[language]">
                    <?php foreach (I18n::getLanguages() as $code => $label): ?>
                        <option value="<?php echo $code; ?>" <?php if ($code == $user->language) echo('selected="selected"'); ?> ><?php echo __($label); ?></option>
<?php endforeach; ?>
                </select>
            </span>
                          </div>
                </div>
        </section>
            </div>

<?php Observer::notify('view_user_edit_plugins', array($user)); ?>

        <div class="box-buttons">
            <button  class="button-submit-style" type="submit"><i class="zmdi zmdi-check"></i><?php echo __($action == 'edit' ? 'Save changes' : 'Add user'); ?></button>
            
               
                               <a class="button-submit-style-a" href="<?php echo get_url('user'); ?>"><i class="zmdi zmdi-undo"></i> <?php echo __('Cancel'); ?></a> 
            
              
        </div>

    </form>

</div><!--/#userEdit-->