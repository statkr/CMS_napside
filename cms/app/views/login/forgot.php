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

<div id="dialog" class="box" style="
    height: 240px;
">
	<!--<h1 class="box-title"><?php echo __('Forgot password') .' &ndash; '. Setting::get('admin_title'); ?></h1>
-->
 
	<form id="forgotForm" action="<?php echo get_url('login/forgot'); ?>" method="post">
             <p style="
     padding: 10px 29px 0px 16px;
    text-align: center;
    color: #578592;
">Введите адрес электронной почты от своего аккаунта. На введенный вами e'mail прийдет сообщение с новым паролем.</p>
		<p id="forgotLine">
                   
			<!--<label for="forgotEmailField"><?php echo __('E-mail address'); ?>:</label>-->
			<!--style="
                                background-image: url('images/check.png');
                                background-repeat: no-repeat;  
                                background-position: 10px 19px;
                               
                               "-->
                    
                    <input  class="input-text" id="forgotEmailField" placeholder="<?php echo __('E-mail address'); ?>" type="text" name="forgot[email]" value="<?php echo $email; ?>" tabindex="1" />
		</p>
		
<?php Observer::notify('admin_login_forgot_form'); ?>
		
		
			<button type="submit" tabindex="10">  <?php echo __('Send password'); ?></button>
			<!--<span><a href="<?php echo get_url('login'); ?>" tabindex="11"><?php echo __('Login'); ?></a></span>
		-->
	</form>
</div>

<p id="website"><small><a href="<?php echo get_url('/'); ?>" tabindex="12"><?php echo __('Login'); ?></a></small></p>