<?php
if (!defined('CMS_ROOT'))
    die;


$controller = Dispatcher::getController(Setting::get('default_tab'));
$action = Dispatcher::getAction();
$params = Dispatcher::getParams();

Plugin::addNav('Content', __('Pages'), 'page', array('administrator', 'developer', 'editor'), 100);



Plugin::addNav('Design', __('Шаблоны*'), 'layout', array('administrator', 'developer'), 100);
Plugin::addNav('Design', __('Snippets'), 'snippet', array('administrator', 'developer'), 100);

Plugin::addNav('Settings', __('General'), 'setting', array('administrator'), 100);
Plugin::addNav('Settings', __('Plugins'), 'plugins', array('administrator'), 100);
Plugin::addNav('Settings', __('Users'), 'user', array('administrator'), 100);
?>
<!DOCTYPE html>
<html lang="en">
    <!--[if IE 9 ]><html class="ie9"><![endif]-->
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php echo __(ucfirst($controller)); ?> &ndash; <?php echo Setting::get('admin_title'); ?></title>


        <base href="<?php echo BASE_URL . ADMIN_DIR_NAME . '/'; ?>" />
        <link href="<?php echo BASE_URL . ADMIN_DIR_NAME; ?>/favicon.ico" rel="favourites icon" />

        <script>
            var BASE_URL = '<?php echo BASE_URL; ?>';
            var CMS_URL = '<?php echo CMS_URL; ?>';
            var ADMIN_DIR_NAME = '<?php echo ADMIN_DIR_NAME; ?>';
            var PUBLIC_URL = '<?php echo PUBLIC_URL; ?>';
            var PLUGINS_URL = '<?php echo PLUGINS_URL; ?>';
            var LOCALE = '<?php echo I18n::getLocale(); ?>';
        </script>

 
        <script>
          
window.onload = function(){

var x = document.getElementsByClassName("mceToolbar");
 for(var i=0; i< x.length;i++){
    x[i].style.width = document.getElementById("pageEditMeta").offsetWidth+"px";
   console.log(x[i]);
 }
 
 
};

 
        </script>
   
      <script src="//code.jquery.com/jquery-1.9.1.js"></script>
                <script src="//code.jquery.com/jquery-migrate-1.2.1.js"></script>
                 <script src="javascripts/jquery-ui/jquery-ui-1.8.12.js" ></script>
		<link href="javascripts/jquery-ui/jquery-ui-1.8.12.css" media="screen" rel="stylesheet" type="text/css" charset="utf-8" />
                
        <script src="javascripts/jquery.tubby-0.12.js"></script>
        <script src="javascripts/backend.js"></script>

        <?php if (file_exists(CMS_ROOT . DIRECTORY_SEPARATOR . ADMIN_DIR_NAME . DIRECTORY_SEPARATOR . 'javascripts' . DIRECTORY_SEPARATOR . 'i18n' . DIRECTORY_SEPARATOR . I18n::getLocale() . '-message.js')): ?>
            <script src="<?php echo BASE_URL . ADMIN_DIR_NAME; ?>/javascripts/i18n/<?php echo I18n::getLocale(); ?>-message.js"></script>
<?php endif; ?>

        <!-- Plugins automatic requires -->
        <?php foreach (Plugin::$plugins as $plugin_id => $plugin): ?>
            <?php if (file_exists(PLUGINS_ROOT . DIRECTORY_SEPARATOR . $plugin_id . DIRECTORY_SEPARATOR . $plugin_id . '.css')): ?><link href="<?php echo PLUGINS_URL . $plugin_id . '/' . $plugin_id . '.css'; ?>" media="screen" rel="stylesheet" type="text/css" charset="utf-8" /><?php endif; ?>
            <?php if (file_exists(PLUGINS_ROOT . DIRECTORY_SEPARATOR . $plugin_id . DIRECTORY_SEPARATOR . 'i18n' . DIRECTORY_SEPARATOR . I18n::getLocale() . '-message.js')): ?><script src="<?php echo PLUGINS_URL . $plugin_id; ?>/i18n/<?php echo I18n::getLocale(); ?>-message.js"></script><?php endif; ?>
            <?php if (file_exists(PLUGINS_ROOT . DIRECTORY_SEPARATOR . $plugin_id . DIRECTORY_SEPARATOR . $plugin_id . '.js')): ?><script src="<?php echo PLUGINS_URL . $plugin_id . '/' . $plugin_id . '.js'; ?>" type="text/javascript" charset="utf-8"></script><?php endif; ?>
        <?php endforeach; ?>

        <?php foreach (Plugin::$javascripts as $javascript): ?><script src="<?php echo $javascript; ?>"></script><?php endforeach; ?>
        <?php foreach (Plugin::$stylesheets as $stylesheet): ?><link href="<?php echo $stylesheet; ?>" media="screen" rel="stylesheet" type="text/css" charset="utf-8" /><?php endforeach; ?>

<?php Observer::notify('layout_backend_head'); ?>


        <link href="../admin/themes/<?php echo Setting::get('theme'); ?>/css/forms.css" rel="stylesheet" type="text/css"/>
        <link href="../admin/themes/<?php echo Setting::get('theme'); ?>/animate.css/animate.min.css" rel="stylesheet">
        <link href="../admin/themes/<?php echo Setting::get('theme'); ?>/material-design-iconic-font/dist/css/material-design-iconic-font.min.css" rel="stylesheet">

        <link href="../admin/themes/<?php echo Setting::get('theme'); ?>/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet">
        <link href="../admin/themes/<?php echo Setting::get('theme'); ?>/css/app.css" rel="stylesheet">
        <link href="../admin/themes/<?php echo Setting::get('theme'); ?>/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
     
        <script src="../admin/themes/<?php echo Setting::get('theme'); ?>/js/page-loader.min.js"></script>





    </head>

    <body id="body_<?php echo $controller . '_' . $action . ($controller == 'plugin' ? '_' . (empty($params) ? 'index' : $params[0]) : ''); ?>">
        <!-- Page Loader -->
        <div id="page-loader">
            <div class="preloader preloader--xl preloader--blue">
                <svg viewBox="25 25 50 50">
                <circle cx="50" cy="50" r="20" />
                </svg>
            </div>
        </div>

        <!-- Header -->
        <header id="header">
            <div class="logo">
                <i class="logo__trigger zmdi zmdi-menu" data-mae-action="block-open" data-mae-target="#navigation"></i>
                <a href="<?php $default_tab = Setting::get('default_tab');
echo(get_url(empty($default_tab) ? 'page/index' : $default_tab)); ?>"><?php echo Setting::get('admin_title'); ?>

                </a>
<p>  <?php echo Setting::get('admin_subtitle'); ?><!--&copy; Napside CMS v<?php echo CMS_VERSION; ?>--> </p>
                
            </div>

            <ul class="top-menu">
                <li class="top-menu__trigger hidden-lg hidden-md">
                    <a href=""><i class="zmdi zmdi-search"></i></a>
                </li>

                <li class="top-menu__apps dropdown hidden-xs hidden-sm">
                    <a data-toggle="dropdown" href="">
                        <i class="zmdi zmdi-apps"></i>
                    </a>
                    <ul class="dropdown-menu pull-right">
                        <li>
                            <a href="">
                                <i class="zmdi zmdi-calendar"></i>
                                <small>Calendar</small>
                            </a>
                        </li>

                        <li>
                            <a href="">
                                <i class="zmdi zmdi-file-text"></i>
                                <small>Files</small>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <i class="zmdi zmdi-email"></i>
                                <small>Mail</small>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <i class="zmdi zmdi-trending-up"></i>
                                <small>Analytics</small>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <i class="zmdi zmdi-view-headline"></i>
                                <small>News</small>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <i class="zmdi zmdi-image"></i>
                                <small>Gallery</small>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown hidden-xs">
                    <a data-toggle="dropdown" href=""><i class="zmdi zmdi-more-vert"></i></a>
                    <ul class="dropdown-menu dropdown-menu--icon pull-right">
                        <li class="hidden-xs">
                            <a data-mae-action="fullscreen" href=""><i class="zmdi zmdi-fullscreen"></i> Toggle Fullscreen</a>
                        </li>
                        <li>
                            <a data-mae-action="clear-localstorage" href=""><i class="zmdi zmdi-delete"></i> Clear Local Storage</a>
                        </li>
                        <li>
                            <a href=""><i class="zmdi zmdi-face"></i> Privacy Settings</a>
                        </li>
                        <li>
                           <a href="<?php echo get_url('login/logout'); ?>"><?php echo __('Logout'); ?></a>
				
                             
                        </li>
                    </ul>
                </li>
                <li class="top-menu__alerts" data-mae-action="block-open" data-mae-target="#notifications" data-toggle="tab" data-target="#notifications__messages">
                    <a href=""><i class="zmdi zmdi-notifications"></i></a>
                </li>
                <li class="top-menu__profile dropdown">
                    <a data-toggle="dropdown" href="">
                        <img src="https://cdn.fishki.net/upload/post/2017/03/19/2245758/tn/07-cute-cat-wallpaper-hdcat-wallpaper.jpg" alt="">
                    </a>

                    <ul class="dropdown-menu pull-right dropdown-menu--icon">
                        <li>
                            <a href="profile-about.html"><i class="zmdi zmdi-account"></i> View Profile</a>
                        </li>
                        <li>
                            <a href=""><i class="zmdi zmdi-input-antenna"></i> Privacy Settings</a>
                        </li>
                        <li>
                            <a href=""><i class="zmdi zmdi-settings"></i> Settings</a>
                        </li>
                        <li>
                            <a href=""><i class="zmdi zmdi-time-restore"></i> Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>

            <form class="top-search">
                <input class="top-search__input" id="pageMapSearchField" type="search" name="query" placeholder="<?php echo __('Find page'); ?>" />

                <i class="zmdi zmdi-search top-search__reset"></i>
            </form>
        </header>

        <section id="main">
            <aside id="notifications">
                <ul class="tab-nav tab-nav--justified tab-nav--icon">
                    <li><a class="user-alert__messages" href="#notifications__messages" data-toggle="tab"><i class="zmdi zmdi-email"></i></a></li>
                    <li><a class="user-alert__notifications" href="#notifications__updates" data-toggle="tab"><i class="zmdi zmdi-notifications"></i></a></li>
                    <li><a class="user-alert__tasks" href="#notifications__tasks" data-toggle="tab"><i class="zmdi zmdi-playlist-plus"></i></a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane" id="notifications__messages">
                        <div class="list-group">
                            <a href="" class="list-group-item media">
                                <div class="pull-left">
                                    <img class="avatar-img" src="demo/img/profile-pics/1.jpg" alt="">
                                </div>

                                <div class="media-body">
                                    <div class="list-group__heading">David Villa Jacobs</div>
                                    <small class="list-group__text">Sorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam mattis lobortis sapien non posuere</small>
                                </div>
                            </a>

                            <a href="" class="list-group-item media">
                                <div class="pull-left">
                                    <img class="avatar-img" src="demo/img/profile-pics/5.jpg" alt="">
                                </div>
                                <div class="media-body">
                                    <div class="list-group__heading">Candice Barnes</div>
                                    <small class="list-group__text">Quisque non tortor ultricies, posuere elit id, lacinia purus curabitur.</small>
                                </div>
                            </a>

                            <a href="" class="list-group-item media">
                                <div class="pull-left">
                                    <img class="avatar-img" src="demo/img/profile-pics/3.jpg" alt="">
                                </div>
                                <div class="media-body">
                                    <div class="list-group__heading">Jeannette Lawson</div>
                                    <small class="list-group__text">Donec congue tempus ligula, varius hendrerit mi hendrerit sit amet. Duis ac quam sit amet leo feugiat iaculis</small>
                                </div>
                            </a>

                            <a href="" class="list-group-item media">
                                <div class="pull-left">
                                    <img class="avatar-img" src="demo/img/profile-pics/4.jpg" alt="">
                                </div>
                                <div class="media-body">
                                    <div class="list-group__heading">Darla Mckinney</div>
                                    <small class="list-group__text">Duis tincidunt augue nec sem dignissim scelerisque. Vestibulum rhoncus sapien sed nulla aliquam lacinia</small>
                                </div>
                            </a>

                            <a href="" class="list-group-item media">
                                <div class="pull-left">
                                    <img class="avatar-img" src="demo/img/profile-pics/2.jpg" alt="">
                                </div>
                                <div class="media-body">
                                    <div class="list-group__heading">Rudolph Perez</div>
                                    <small class="list-group__text">Phasellus a ullamcorper lectus, sit amet viverra quam. In luctus tortor vel nulla pharetra bibendum</small>
                                </div>
                            </a>
                        </div>

                        <a href="" class="btn btn--float">
                            <i class="zmdi zmdi-plus"></i>
                        </a>
                    </div>

                    <div class="tab-pane" id="notifications__updates">
                        <div class="list-group">
                            <a href="" class="list-group-item media">
                                <div class="pull-right">
                                    <img class="avatar-img" src="demo/img/profile-pics/1.jpg" alt="">
                                </div>

                                <div class="media-body">
                                    <div class="list-group__heading">David Villa Jacobs</div>
                                    <small class="list-group__text">Sorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam mattis lobortis sapien non posuere</small>
                                </div>
                            </a>

                            <a href="" class="list-group-item">
                                <div class="list-group__heading">Candice Barnes</div>
                                <small class="list-group__text">Quisque non tortor ultricies, posuere elit id, lacinia purus curabitur.</small>
                            </a>

                            <a href="" class="list-group-item">
                                <div class="list-group__heading">Jeannette Lawson</div>
                                <small class="list-group__text">Donec congue tempus ligula, varius hendrerit mi hendrerit sit amet. Duis ac quam sit amet leo feugiat iaculis</small>
                            </a>

                            <a href="" class="list-group-item media">
                                <div class="pull-right">
                                    <img class="avatar-img" src="demo/img/profile-pics/4.jpg" alt="">
                                </div>
                                <div class="media-body">
                                    <div class="list-group__heading">Darla Mckinney</div>
                                    <small class="list-group__text">Duis tincidunt augue nec sem dignissim scelerisque. Vestibulum rhoncus sapien sed nulla aliquam lacinia</small>
                                </div>
                            </a>

                            <a href="" class="list-group-item media">
                                <div class="pull-right">
                                    <img class="avatar-img" src="demo/img/profile-pics/2.jpg" alt="">
                                </div>
                                <div class="media-body">
                                    <div class="list-group__heading">Rudolph Perez</div>
                                    <small class="list-group__text">Phasellus a ullamcorper lectus, sit amet viverra quam. In luctus tortor vel nulla pharetra bibendum</small>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="tab-pane" id="notifications__tasks">
                        <div class="list-group">
                            <div class="list-group-item">
                                <div class="list-group__heading m-b-5">HTML5 Validation Report</div>

                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100" style="width: 95%">
                                        <span class="sr-only">95% Complete (success)</span>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="list-group__heading m-b-5">Google Chrome Extension</div>

                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                        <span class="sr-only">80% Complete (success)</span>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="list-group__heading m-b-5">Social Intranet Projects</div>

                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                        <span class="sr-only">20% Complete</span>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="list-group__heading m-b-5">Bootstrap Admin Template</div>

                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                        <span class="sr-only">60% Complete (warning)</span>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="list-group__heading m-b-5">Youtube Client App</div>

                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                        <span class="sr-only">80% Complete (danger)</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="" class="btn btn--float">
                            <i class="zmdi zmdi-plus"></i>
                        </a>
                    </div>
                </div>
            </aside>

            <aside id="navigation">
                <div class="navigation__header">
                    <i class="zmdi zmdi-long-arrow-left" data-mae-action="block-close"></i>
                </div>

                <div class="navigation__toggles">
                    <a href="" class="active" data-mae-action="block-open" data-mae-target="#notifications" data-toggle="tab" data-target="#notifications__messages">
                        <i class="zmdi zmdi-email"></i>
                    </a>
                    <a href="" data-mae-action="block-open" data-mae-target="#notifications" data-toggle="tab" data-target="#notifications__updates">
                        <i class="zmdi zmdi-notifications"></i>
                    </a>
                    <a href=""  data-mae-action="block-open" data-mae-target="#notifications" data-toggle="tab" data-target="#notifications__tasks">
                        <i class="zmdi zmdi-playlist-plus"></i>
                    </a>
                </div>

                <div class="navigation__menu c-overflow">
                    <ul>


                        <li><a href="<?php $default_tab = Setting::get('default_tab');
echo(get_url(empty($default_tab) ? 'page/index' : $default_tab)); ?>"><i class="zmdi zmdi-home"></i> Главная</a></li>
                        <li><a href="calendar.html"><i class="zmdi zmdi-cloud-download"></i>Обновления</a></li>

<?php foreach (Plugin::getNav() as $nav_name => $nav): ?>
    <?php if ($nav->is_current)  ?> 


                            <li class="navigation__sub <?php if ($nav->is_current) echo('navigation__sub--active navigation__sub--toggled'); ?> "   >
                                <a href="" data-mae-action="submenu-toggle"><i class="zmdi <?php echo ($nav_name); ?>zmdi-collection-item"></i> <?php echo __($nav_name); ?></a>

                                <ul>
    <?php foreach ($nav->items as $item): ?>
                                        <li  <?php if ($item->is_current) echo('class="navigation__active"'); ?>><a href="<?php echo get_url($item->uri); ?>"><?php echo $item->name; ?></a></li>
                            <?php endforeach; ?>
                                </ul>

                            </li>
<?php endforeach; ?>

                        <li><a href="calendar.html"><i class="zmdi zmdi-file-text"></i>Документация</a></li>	





                    </ul>
                </div>
            </aside>
            <section id="content">




<?php if (($info = Flash::get('notice')) !== null): ?><div id="noticeMessage" class="btn-xs btn-default"><?php echo $notice; ?></div><?php endif; ?>
<?php if (($error = Flash::get('error')) !== null): ?><div id="errorMessage" class="btn-xs btn-default"><?php echo $error; ?></div><?php endif; ?>
                    <?php if (($success = Flash::get('success')) !== null): ?>
                    <div class="alert alert-success alert-dismissible  animated fadeOutDown"  data-wow-delay="4000ms" style="animation-delay: 4000ms; display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out; z-index: 1031; top: 30px; right: 30px; animation-iteration-count: 1;">

                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span></button>
                    <?php echo $success; ?>

                    </div>
<?php endif; ?>





<?php echo $content_for_layout; ?>















            </section>

            <footer id="footer">
              &copy;  Napside CMS v <?php echo CMS_VERSION; ?> | <a href="http://altmedia.su/" target="_blank"><?php echo __('Information'); ?></a>

                <ul class="footer__menu">
                    <li><a href="">Home</a></li>
                    <li><a href="">Dashboard</a></li>
                    <li><a href="">Reports</a></li>
                    <li><a href="">Support</a></li>
                    <li><a href="">Contact</a></li>
                </ul>
            </footer>

        </section>



        <!-- jQuery -->



        <!-- Bootstrap -->
        <script src="../admin/themes/<?php echo Setting::get('theme'); ?>/bootstrap/dist/js/bootstrap.min.js"></script>

        <!-- Malihu ScrollBar -->
        <script src="../admin/themes/<?php echo Setting::get('theme'); ?>/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>

        <!-- Bootstrap Notify -->
        <script src="../admin/themes/<?php echo Setting::get('theme'); ?>/remarkable-bootstrap-notify/dist/bootstrap-notify.min.js"></script>

        <!-- Placeholder for IE9 -->
        <!--[if IE 9 ]>
            <script src="vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
        <![endif]-->

        <!-- Demo Only -->
        <script src="../admin/themes/<?php echo Setting::get('theme'); ?>/demo/js/misc.js"></script>

        <!-- Site Functions & Actions -->
        <script src="../admin/themes/<?php echo Setting::get('theme'); ?>/js/app.min.js"></script>


  <script>
       
       
       document.onreadystatechange = function(a){
   if(document.readyState === 'complete'){
         var screen = window.innerWidth;
     var x = document.getElementsByClassName("mceToolbar");
 for(var i=0; i< x.length;i++){
    x[i].style.width = document.getElementById("pageEditMeta").offsetWidth-5+"px";
   console.log(screen);
   
 
   
   
 }
 
   }
}
 


        </script>
        
        
          <script>
         window.onresize = function () {
  var x = document.getElementsByClassName("mceToolbar");
 for(var i=0; i< x.length;i++){
    x[i].style.width = document.getElementById("pageEditMeta").offsetWidth-5+"px";
  
 
   
   
 }
};
   </script>
    </body>
</html>