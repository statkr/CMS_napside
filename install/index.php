<?php
/**
 * @package install
 *
 * @author Popkov Pavel <pavel@fn.de>
 * @version 0.0.3
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 * @copyright Popkov Pavel, 2018
 */

//Defines
define('CMS_ROOT',  realpath(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'));
define('I18N_PATH', CMS_ROOT.DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'i18n');
define('CONFIG_FILE_PATH', CMS_ROOT.DIRECTORY_SEPARATOR.'config.php');
define('CONFIGTPL_FILE_PATH', CMS_ROOT.DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'config.tpl');
define('SQLDUMP_FILE_PATH', CMS_ROOT.DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'dump.sql');

function get_timezones($timezone_identifiers)
{
        if (empty($timezone_identifiers)) return false;
        $timezones = array(); 
        foreach( $timezone_identifiers as $value )
        {
            if ( preg_match( '/^(America|Antartica|Arctic|Asia|Atlantic|Europe|Indian|Pacific)\//', $value ) )
            {
                $ex=explode('/',$value);//obtain continent,city
                $city = isset($ex[2])? $ex[1].' - '.$ex[2]:$ex[1];//in case a timezone has more than one
                $timezones[$ex[0]][$value] = $city;
            }
        }
        return $timezones;
}

function get_select_timezones($select_name='TIMEZONE',$selected=NULL, $timezones=NULL)
{
    $sel ='';
    if (!is_array($timezones)) $timezones = get_timezones();
    $sel.='<select id="'.$select_name.'" style="width:100%;height: 34px;margin-top: -4px; name="'.$select_name.'">';
    foreach( $timezones as $continent=>$timezone )
    {
        $sel.= '<optgroup label="'.$continent.'">';
        foreach( $timezone as $city=>$cityname )
        {            
            if ($selected==$city)
            {
                $sel.= '<option selected=selected value="'.$city.'">'.$cityname.'</option>';
            }
            else $sel.= '<option value="'.$city.'">'.$cityname.'</option>';
        }
        $sel.= '</optgroup>';
    }
    $sel.='</select>';
 
    return $sel;
}

// Check config.tpl file
if (!file_exists(CONFIGTPL_FILE_PATH))
	die('File config.tpl not exists! This file is required!');

	
// Check config.php
if (file_exists(CONFIG_FILE_PATH))
	die('System already installed! Please, remove this directory!');


// Requires
require_once(CMS_ROOT.DIRECTORY_SEPARATOR.'cms'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'I18n.php');


// i18n settings
$default_lang = strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
$i18n_lang = isset($_GET['lang']) ? htmlentities(strtolower($_GET['lang'])): $default_lang;
I18n::setLocale($i18n_lang);


// Data
$data = array();


// Success/Error
$success = false;
$error   = false;


// Get $langs
$langs = scandir(I18N_PATH);


// Requirements
$req_pdo     = class_exists('PDO');

$pdo_drv = ($req_pdo ? PDO::getAvailableDrivers(): array());

$req_mysql   = in_array('mysql', $pdo_drv);
$req_sqlite  = in_array('sqlite', $pdo_drv);
$req_php     = (PHP_VERSION < 5 ? false: true);
$req_json    = (function_exists('json_encode') || class_exists('JSON'));
$req_rewrite = (isset($_GET['mod_rewrite']) && $_GET['mod_rewrite'] == '1' ? true: false);

// Timezone
$tzlist_ids = false;
if (method_exists('DateTimeZone','listIdentifiers')) $tzlist_ids = DateTimeZone::listIdentifiers();  
$tzlist = get_timezones($tzlist_ids);

// POST
if (!empty($_POST['install']))
{
	$data = $_POST['install'];
	
	if (!$req_php)
	{
		$error = __('Require support of PHP 5+!');
	}
	else if (!$req_pdo)
	{
		$error = __('Require support of PDO extension!');
	}
	else if (!$req_mysql && !$req_pgsql && !$req_sqlite)
	{
		$error = __('Require support of PDO driver MySQL or PostgreSQL or SQLite!');
	}
	else if (($data['db_driver'] == 'mysql' || $data['db_driver'] == 'pgsql') && (empty($data['db_server']) || empty($data['db_user']) || empty($data['db_name'])))
	{
		$error = __('Fields <b>Database driver</b>, <b>Database server</b>, <b>Database user</b>, <b>Database name</b> are required!');
	}
	else if ($data['db_driver'] == 'sqlite' && empty($data['db_name']))
	{
		$error = __('Field <b>Database name</b> is required!');
	}
	else if (empty($data['username']))
	{
		$error = __('Field <b>Administrator username</b> is required!');
	}
	else if (!preg_match("/^[a-zA-Z0-9_]{4,64}$/", $data['username'])){
    $error = __('Wrong <b>Administrator username</b> format!');
	}
	else if (empty($data['mail']))
	{
		$error = __('Field <b>Administrator mail</b> is required!');
	}
	else if (!preg_match("/^[a-zA-Z0-9\._-]+@[a-zA-Z0-9\._-]+\.[a-zA-Z]{2,4}$/",$data['mail']))
	{
		$error = __('Wrong <b>Administrator mail</b> format!');
	}
	else
	{
    // Timezone ...again
    $tzone = $data['default_timezone'];
    if ((!is_array($tzlist_ids)) || (@in_array($tzone, $tzlist_ids, true)==false)) $tzone = date_default_timezone_get();
    ini_set('date.timezone', $tzone);
    if(function_exists('date_default_timezone_set'))
        date_default_timezone_set($tzone);
    else
        putenv('TZ='.$tzone);    
        
		// SQLite needs more than 30 seconds
		@set_time_limit(180);
		// Prepare connection
		if ($data['db_driver'] != 'sqlite' )
			$db_dsn = $data['db_driver'] . ':dbname='. $data['db_name'] . (';host=' . $data['db_server'] . (!empty($data['db_port']) ? ';port=' . $data['db_port']: ''));
		else
			$db_dsn = $data['db_driver'] . ':'. $data['db_name'];
		
		$db_exception = null;
		
		$connection = false;
		
		try
		{
			$connection = new PDO( $db_dsn, ($data['db_driver'] != 'sqlite' ? $data['db_user']: null), ($data['db_driver'] != 'sqlite' ? $data['db_password']: null) );
			$connection->exec('SET NAMES "utf8"');
			$connection->exec('SET time_zone = "'. date('P') .'"');
		}
		catch (Exception $e) { $db_exception = $e->getMessage(); }
		
		if (!$connection)
		{
			$error = __('Can\'t connect to Database! :message', array(':message' => $db_exception));
		}
		else
		{
			$schema_file = CMS_ROOT.DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'schema_'.$data['db_driver'].'.sql';
			$dump_file = CMS_ROOT.DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'dump.sql';
			
			if (!file_exists($schema_file))
			{
				$error = __('Database schema file not found!');
			}
			else
			{
				// Create tables
				
				$schema_content = file_get_contents($schema_file);
				$schema_content = str_replace('TABLE_PREFIX_', $data['table_prefix'], $schema_content);
				$schema_content = preg_split('/;(\s*)$/m', $schema_content);
				
				$schema_error = false;
				
				foreach ($schema_content as $create_table_sql)
				{
					$create_table_sql = trim($create_table_sql);
					
					if (!empty($create_table_sql))
					{
						if ($connection->exec($create_table_sql) === false)
						{
							$schema_error = true;
							break;
						}
					}
				}
				
				if ($schema_error)
				{
					$e_info = $connection->errorInfo();
					$error = __('Problems with creating Database schema! :message',  array(':message' => $e_info[2]));
				}
				else if (!file_exists($dump_file))
				{
					$error = __('Database dump file not found!');
				}
				else
				{
					// Insert SQL dump
					
					//$password = time().dechex(rand(100000000, 4294967295));
					$rndkey = array('h','a','d','e','q','f','g','j','p','r','s','t','b','w','y','c','z','k','m');
          $password = $rndkey[rand(1,count($rndkey)-1)].dechex(date('SM')).$rndkey[rand(1,count($rndkey)-1)].dechex(rand(100000000, 4294967295)+time()).$rndkey[rand(1,count($rndkey)-1)];
					
					function date_incremenator()
					{
						return date('Y-m-d H:i:s', time());
					}
					
					$dump_content = file_get_contents($dump_file);
					$dump_content = str_replace('__ADMIN_MAIL__', $data['mail'], $dump_content);
					$dump_content = str_replace('__ADMIN_LOGIN__', $data['username'], $dump_content);
					$dump_content = str_replace('TABLE_PREFIX_', $data['table_prefix'], $dump_content);
					$dump_content = str_replace('__ADMIN_PASSWORD__', sha1($password), $dump_content);
					$dump_content = preg_replace_callback('/__DATE__/m', 'date_incremenator', $dump_content);
					$dump_content = str_replace('__LANG__', $i18n_lang, $dump_content);
					$dump_content = preg_split('/;(\s*)$/m', $dump_content);
					
					$dump_error = false;
				
					foreach ($dump_content as $insert_sql)
					{
						$insert_sql = trim($insert_sql);
						
						if (!empty($insert_sql))
						{
							if ($connection->exec($insert_sql) === false)
							{
								$dump_error = true;
								break;
							}
						}
					}
					
					if ($dump_error)
					{
						$e_info = $connection->errorInfo();
						$error = __('Problems with importing Database dump! :message', array(':message' => $e_info[2]));
					}
					else
					{
						// Insert settings to config.php
						
						$tpl_content = file_get_contents(CONFIGTPL_FILE_PATH);
						
						$repl = array(
							'__DB_DSN__'          => $db_dsn,
							'__DB_USER__'         => $data['db_user'],
							'__DB_PASS__'         => $data['db_password'],
							'__TABLE_PREFIX__'    => $data['table_prefix'],
							'__DEFAULT_TIMEZONE__'=> $tzone,
							'__USE_MOD_REWRITE__' => ($req_rewrite ? 'true': 'false'),
							'__URL_SUFFIX__'      => $data['url_suffix'],
							'__LANG__'            => $i18n_lang
						);
						
						$tpl_content = str_replace(
							array_keys($repl),
							array_values($repl),
							$tpl_content
						);
						
						if (file_put_contents(CONFIG_FILE_PATH, $tpl_content) !== false)
						{
							$success = true;
						}
						else
						{
							$error = __('Can\'t write config.php file!');
						}
					}
				}
			}
		}
	}
} // POST

?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		
		<title><?php echo __('Installation'); ?> &ndash; napside CMS</title>
		
		<link href="install.css" rel="stylesheet" type="text/css" charset="utf-8" />
		<link href="../admin/stylesheets/bootstrap.min.css" rel="stylesheet" type="text/css"/>
                <link href="../admin/stylesheets/font-awesome.min.css" rel="stylesheet" type="text/css"/>
                <link href="../admin/stylesheets/responsive.css" rel="stylesheet" type="text/css"/>
                <link href="../admin/stylesheets/animate.css" rel="stylesheet" type="text/css"/>
		<script src="../admin/javascripts/jquery-1.6.4.js"></script>
                <script>
window.onload = function () {
	var list = document.getElementById('list');
	var cur = document.getElementById('div').children[0];
	
	function sh(cur, next) {
		cur.style.display = 'none';
		next.style.display = 'block';
	}
	
	document.body.onclick = function (e) {
		e = e || event;
		var target = e.target || e.srcElement;
		var elem;
		if (target.className == 'previous') {
			if (target.parentNode.previousSibling.previousSibling) {//previousElementSibling
				elem = target.parentNode.previousSibling.previousSibling;
				sh(cur, elem);
				cur = elem;
			}
		} else 
		if (target.className == 'next') {
			if (cur.nextSibling.nextSibling) {//nextElementSibling
				elem = cur.nextSibling.nextSibling;
				sh(cur, elem);
				cur = elem;
			}
		} else 
		if (target.parentNode.parentNode.id == 'list') {
			elem = document.getElementById(target.getAttribute('href').replace('#', ''));
			sh(cur, elem);
			cur = elem;
		}
	}
	

}
</script> 
                
		<script>
			$(function()
			{
				// Messages
				$('.message').animate({top: 0}, 1000);
				
				
				// Langs
				$('#installLangField').bind('change', function()
				{
					location.href = '?lang=' + $(this).val();
				});
				
				
				// First field focus
				$('form:first input[type="text"]:first').focus();
				
				
				// DB variants				
				$('#installDriverField').bind('change', function()
				{
					var val = $(this).val();
					
					switch (val)
					{
						case 'sqlite':
							$('#installDBServer, #installDBPort, #installDBUser, #installDBPassword, #installDBPrefix').slideUp('fast');
							$('#installDBNameDescr').hide();
							$('#installDBNameSQLiteDescr').css('display', 'block').show();
							break;
						default:
							$('#installDBServer, #installDBPort, #installDBUser, #installDBPassword, #installDBPrefix').slideDown('fast');
							$('#installDBNameDescr').show();
							$('#installDBNameSQLiteDescr').hide();
							break;
					}
				});
			});
			
			// IE HTML5 hack (If you like to work with IE - you have a big problems ^___^ )
			if (document.all)
			{
				var e = ['header', 'nav', 'aside', 'article', 'section', 'footer', 'figure', 'hgroup', 'mark', 'output', 'time'];
				for (i in e) document.createElement(e[i]);
			}
		</script>
	</head>
	<body>
            
    
            
            
            <section id="logo_style">
        <div class="container">
            <div class="row">
                
                <div class="col-xs-12 text-center padding wow fadeIn animated" data-wow-duration="1000ms" data-wow-delay="300ms" style="visibility: visible; animation-duration: 1000ms; animation-delay: 300ms;">
                    <?php if ($error): ?><div id="errorMessage" class="message"><?php echo $error; ?></div><?php endif; ?>  
                   
<div class="tabs">

<div id="div" >
    
    <div id="first">
        
          <section id="home-slider">
        <div class="container">
            <div class="row">
                
                
                
                <div class="main-slider animate-in">
          
                    
                    
                    <div class="col-lg-6 hidden-md hidden-sm hidden-xs">
                    <img src="../admin/images/circle_left_right.png" class="slider-sun" alt="slider image">
                    <img src="../admin/images/center_line.png" class="slider-birds1" alt="slider image">
                    <img src="../admin/images/circle_center_layback.png" class="slider-house" alt="slider image">
                    <img src="../admin/images/N_in_center.png" class="slider-hill" alt="slider image">
                    <img src="../admin/images/circle_up.png" class="slider-birds2" alt="slider image">
                    <img src="../admin/images/circle_up.png" class="slider-birds3" alt="slider image">
                     
                    <img src="../admin/images/n.png" class="word-n" alt="slider image">
                    <img src="../admin/images/a.png" class="word-a" alt="slider image">
                    <img src="../admin/images/p.png" class="word-p" alt="slider image">
                    <img src="../admin/images/s.png" class="word-s" alt="slider image">
                    <img src="../admin/images/i.png" class="word-i" alt="slider image">
                    <img src="../admin/images/d.png" class="word-d" alt="slider image">
                    <img src="../admin/images/e.png" class="word-e" alt="slider image">
                            
                    <img src="../admin/images/CMS-1.png" class="word-cms1" alt="slider image">
                    <img src="../admin/images/CMS-2.png" class="word-cms2" alt="slider image">
                    <img src="../admin/images/CMS-3.png" class="word-cms3" alt="slider image">
                    </div> 
                    
                    
                    <?php if (!$success): ?> 
                    
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                     <div class="slide-text">
                        <h1><?php echo __('Welcome'); ?></h1>
                        <br>
                        <div class="col-md-7"> <p style="text-align: left;"><?php echo __('Select language'); ?>: </p>
		</div>
		<div class="col-md-5">
                      
                     
			
			<div id="installLang">
				<select id="installLangField" name="lang">
					<option  value="en" >English</option>
					<?php foreach ($langs as $lang): if (substr($lang, -4) != '.php') continue; $lang = substr($lang, 0, 2); ?>
					<option value="<?php echo $lang; ?>" <?php if($i18n_lang == $lang) echo('selected'); ?> ><?php echo (isset(I18n::$locale_names[$lang]) ? I18n::$locale_names[$lang]: 'unknown'); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
                        
                     
		</div>   
                        
                     <div class="col-md-12">  
                         <br>
               
                     <p style="text-align: left;">Перед началом установки napside CMS, убедитесь в работоспособности и поддержке всех необходимых компонентов: </p>
                     
                     <form id="installForm" action="?lang=<?php echo $i18n_lang; ?>" class="form form-<?php echo (isset($data['db_driver']) ? $data['db_driver']: 'mysql'); ?>" method="post">
				
				<ul id="requirements">
                                    
                                    <div class="alert fade in <?php echo($req_php ? 'alert-success': 'alert-danger'); ?>" style="  margin-bottom: 10px;">
                                        
                                        <li class="okstyle <?php echo($req_pdo ? 'ok': 'bad'); ?>">PHP 5+ <?php echo __(!$req_php ? 'not supported': 'supported'); ?></li>
                                       
                                    </div> 
                                    
                                    <div class="alert  fade in  <?php echo($req_php ? 'alert-success': 'alert-danger'); ?>" style="  margin-bottom: 10px;">
                                       
                                        <li class="okstyle <?php echo($req_pdo ? 'ok': 'bad'); ?>">PDO <?php echo __(!$req_pdo ? 'not supported': 'supported'); ?></li>
                                        
                                    </div> 
                                    
				    <div class="alert  fade in  <?php echo($req_php ? 'alert-success': 'alert-danger'); ?>" style="  margin-bottom: 10px;">
                                      
                                        <li class="okstyle <?php echo($req_mysql ? 'ok': 'bad'); ?>">PDO MySQL <?php echo __(!$req_mysql ? 'not supported': 'supported'); ?></li>
					
                                       
                                    </div> 	
					
                                    <div class="alert  fade in <?php echo($req_php ? 'alert-info': 'alert-danger'); ?>" style="  margin-bottom: 10px;">
                                        
                                       <li class="okstyle <?php echo($req_sqlite ? 'ok': 'bad'); ?>">PDO SQLite <?php echo __(!$req_sqlite ? 'not supported': 'supported'); ?> (<?php echo __('optional'); ?>)</li>
                                   
                                    </div> 
                                    
                                    <div class="alert fade in <?php echo($req_php ? 'alert-info': 'alert-danger'); ?>" style="  margin-bottom: 10px;">
                                        
                                         <li class="okstyle <?php echo($req_json ? 'ok': 'bad'); ?>">JSON  <?php echo __(!$req_json ? 'not supported': 'supported'); ?> (<?php echo __('optional'); ?>)</li>
					
                                       
                                    </div> 
                                    
                                    <div class="alert  fade in <?php echo($req_php ? 'alert-info': 'alert-danger'); ?>" style="  margin-bottom: 10px;">
                                      
                                        <li class="okstyle <?php echo($req_rewrite ? 'ok': 'bad'); ?>">mod_rewrite <?php echo __(!$req_rewrite ? 'not supported': 'supported'); ?> (<?php echo __('optional'); ?>)</li>
				
                                        
                                    </div> 
                                    <!--
                                    <div class="alert  fade in <?php echo($req_php ? 'alert-info': 'alert-danger'); ?>" style="  margin-bottom: 10px;">
                                    <li class="<?php echo($req_pgsql ? 'ok': 'bad'); ?>">PDO PostgreSQL <?php echo __(!$req_pgsql ? 'not supported': 'supported'); ?> (<?php echo __('optional'); ?>)</li>  
                                    </div> 
                                    -->
					 
					</ul>
				
				<?php if(!$req_php || !$req_pdo || !$req_rewrite): ?>
				<p><a href="#"><?php echo __('If some requirements not aviable&hellip;'); ?></a></p>
				<?php endif; ?>
                     
                     
                     
                     </div> 
                     
                       <div class="col-md-12">    
                           <input id="super-next" type="button" value="Продолжить" class="next"  />
                           
                       </div> 
                    </div>
                    </div>
                </div>
            </div>
        </div>
        
    </section>
           

       
      
    </div>
    <div id="second" style="display: none;   ">
        
        
        <div class="col-md-4 shag" style="border-radius: 0px;"><h4> <?php echo __('Step'); ?> 1</h4><p>Проверка модулей и компонентов</p>  </div>
        <div class="col-md-4" style="border-radius: 0px;"> <h4><?php echo __('Step'); ?> 2</h4><p><?php echo __('Database information'); ?></p> </div>
        <div class="col-md-4 shag" style="border-radius: 0px;"> <h4><?php echo __('Step'); ?> 3 </h4><p>Создание пользователя</p> </div>
        
       
    
        <div class="col-lg-6 hidden-md hidden-sm hidden-xs" style="border-radius: 0px;">
            <section id="home-slider">
            <div class="main-slider2 animate-in">
                <img src="../admin/images/step2back.png" class="step2-1" alt="slider image">
                <img src="../admin/images/step2front.png" class="step2-2" alt="slider image">
                <img src="../admin/images/step2lock.png" class="step2-3" alt="slider image">

             </div>
                </section>  
        </div>
        
        
        <div class="col-md-12 col-lg-6 slide-text granica animate-in padd-1200" style="border-radius: 0px; "> 
       <h1 style="margin-bottom:6px">Подключение БД</h1>
       <p class="styleshir">Заполните поля в форме представленной ниже, для подключения к выбранной базе данных. Поля обязательные для заполнения отмечены символом *  </p>
       <br>
   <div class="col-md-4 col-lg-5" style="text-align: left;">
    <p><?php echo __('Database driver'); ?> </p>
  </div>
   <div class="col-md-8 col-lg-7" >  
				
<section id="installDriver" >
                                                <span>
						<select style='width:100%;height: 34px;margin-top: -4px;' id="installDriverField" style="height: 34px;margin-left: 40px;margin-top: -4px;" name="install[db_driver]">
							<option value="mysql" <?php if (isset($data['db_driver']) && $data['db_driver'] == 'mysql') echo('selected'); ?> >MySQL</option>
							<?php if($req_sqlite): ?>
							<option value="sqlite" <?php if (isset($data['db_driver']) && $data['db_driver'] == 'sqlite') echo('selected'); ?> >SQLite</option>
							<?php endif; ?>
						</select>
					</span>
				</section>
                                </div>				
           
        <div id="installDBServer" class="col-md-12">  <br></div> 
    <section id="installDBServer" >    
   <div class="col-md-4 col-lg-5" style="text-align: left;">
    <p><?php echo __('Database server'); ?>:</p>
  </div>

           <div class="col-md-8 col-lg-7">  
				
					<span><input id="installDBServerField" class="input-text" type="text" name="install[db_server]" maxlength="255" size="50" value="<?php echo(isset($data['db_server']) ? $data['db_server']: 'localhost'); ?>" /></span>
				
				</div>
     </section>
     
       <div id="installDBServer" class="col-md-12">  <br></div>
				<section id="installDBPort">
                                    
                                    <div class="col-md-4 col-lg-5" style="text-align: left;">
					<p for="installDBPortField"><?php echo __('Database port'); ?>:</p>
					</div>
                                    <div class="col-md-8 col-lg-7"> 
                                        <span><input id="installDBPortField" class="input-text" type="text" name="install[db_port]" maxlength="255" size="50" value="<?php echo(isset($data['db_port']) ? $data['db_port']: '3306'); ?>" /></span>
				</div>
                                </section>
				   <div id="installDBServer" class="col-md-12">  <br></div>
				
                                  <section id="installDBUser">
                                      <div class="col-md-4 col-lg-5" style="text-align: left;">
					<p for="installDBUserField"><?php echo __('Database user'); ?>: </p>
					</div>
                                      <div class="col-md-8 col-lg-7"> 
                                        <span><input id="installDBUserField" class="input-text" type="text" name="install[db_user]" maxlength="255" size="50" value="<?php echo(isset($data['db_user']) ? $data['db_user']: 'root'); ?>" /></span>
                                        </div>
                                  </section>
				     <div id="installDBServer" class="col-md-12">  <br></div>
				<section id="installDBPassword">
                                    <div class="col-md-4 col-lg-5" style="text-align: left;">
					<p for="installDBPasswordField"><?php echo __('Database password'); ?>:</p>
					</div>
                                      <div class="col-md-8 col-lg-7"> 
                                        <span><input id="installDBPasswordField" class="input-text" type="text" name="install[db_password]" maxlength="255" size="50" value="<?php echo(isset($data['db_password']) ? $data['db_password']: ''); ?>" /></span>
				</div>
                                </section>
				   <div class="col-md-12">  <br></div>
				<section id="installDBName">
                                    <div class="col-md-4 col-lg-5" style="text-align: left;">
					<p for="installDBNameField"><?php echo __('Database name'); ?> </p>
					</div>
                                      <div class="col-md-8 col-lg-7"> 
                                        <span><input id="installDBNameField" class="input-text" type="text" name="install[db_name]" maxlength="255" size="50" value="<?php echo(isset($data['db_name']) ? $data['db_name']: ''); ?>" /></span>
				</div>
                                </section>
				   <div class="col-md-12">  <br></div>
				<section id="installDBPrefix">
                                    <div class="col-md-4 col-lg-5" style="text-align: left;">
					<p for="installDBPrefixField"><?php echo __('Prefix'); ?></p>
					</div>
                                      <div class="col-md-8 col-lg-7"> 
                                        <span><input id="installDBPrefixField" class="input-text" type="text" name="install[table_prefix]" maxlength="255" size="50" value="<?php echo(isset($data['table_prefix']) ? $data['table_prefix']: ''); ?>" /></span>
				</div>
                                </section>
				
		
                                   
                               
                                      
                                   
                                   
                                   
                                                 
        <br></div>
        
        
        
      
                                     
                                        <input  id="super-next" type="button" value="Продолжить" class="next" style="
    margin-right: 44px;
    margin-top: 20px;
" />
           
					 <input id="super-prev" type="button" value="Назад" class="previous" style="
  
    margin-top: 20px;
" />
                                         
                                     		 
         
    </div>
    
    
    <div id="third"  style="display: none; ">
        <div class="col-md-4 shag-old" style="border-radius: 0px;"><h4> <?php echo __('Step'); ?> 1</h4><p>Проверка модулей и компонентов</p>  </div>
        <div class="col-md-4 shag" style="border-radius: 0px;"> <h4><?php echo __('Step'); ?> 2</h4><p><?php echo __('Database information'); ?></p> </div>
        <div class="col-md-4 " style="border-radius: 0px;"> <h4><?php echo __('Step'); ?> 3 </h4><p>Дополнительная информация</p> </div>
        
        
        
        <div class="col-lg-6 hidden-md hidden-sm hidden-xs" style="border-radius: 0px;">
          <section id="home-slider">
            <div class="main-slider2 animate-in">
                 

                <img src="../admin/images/step3back.png" class="step3-1" alt="slider image">
                <img src="../admin/images/step3monitor.png" class="step3-2" alt="slider image">
                <img src="../admin/images/step3lines.png" class="step3-3" alt="slider image">
                
                <img src="../admin/images/step3man.png" class="step3-4" alt="slider image">
                <img src="../admin/images/step3man.png" class="step3-5" alt="slider image">
                <img src="../admin/images/step3man.png" class="step3-6" alt="slider image">
             </div>
                </section>
        </div> 
         <div class="col-lg-6 col-md-12 col-sm-12" style="border-radius: 0px;     padding-right: 30px;"> 
         
             
              <h1 style="margin-bottom:6px"><?php echo __('Other information'); ?></h1>
       <p style="text-align: justify;padding: 0 18px 0 18px;     margin-top: 20px;
    margin-bottom: 25px;">
           
           Скоро начнется установка. Убедитесь в корректности заполнения необходимых полей и нажмите кнопку "Установить". Если у вас возникнут проблемы, ознакомтесь с официальной <a>документацией</a>.

       </p>
       <br> 
             
    
				
				<section id="installUsername">
                                     <div class="col-md-5" style="text-align: left;">
					<p for="installUsernameField"><?php echo __('Administrator username'); ?> </p>
					</div>
                                      <div class="col-md-7"> 
                                        <span><input id="installUsernameField" class="input-text" type="text" name="install[username]" maxlength="255" size="50" value="<?php echo(isset($data['username']) ? $data['username']: 'admin'); ?>" /></span>
				</div>
                                </section>
				<div class="col-md-12">  <br></div>
				<section id="installMail">
                                     <div class="col-md-5" style="text-align: left;">
					<p for="installMailField"><?php echo __('Administrator mail'); ?> </p>
					</div>
                                      <div class="col-md-7"> 
                                        <span><input id="installMailField" class="input-text" type="text" name="install[mail]" maxlength="255" size="50" value="<?php echo(isset($data['mail']) ? $data['mail']: 'admin@example.com'); ?>" /></span>
				</section>
				<div class="col-md-12">  <br></div>
				<section id="installURLSuffix">
					 <div class="col-md-5" style="text-align: left;">
                                    <p for="installURLSuffixField"><?php echo __('URL suffix'); ?>: </p>
					</div>
                                      <div class="col-md-7"> 
                                    <span><input id="installURLSuffixField" class="input-text" type="text" name="install[url_suffix]" maxlength="255" size="50" value="<?php echo(isset($data['url_suffix']) ? $data['url_suffix']: '.html'); ?>" /></span>
				</div>
                                </section>
				<div class="col-md-12">  <br></div>
				<?php if(is_array($tzlist)){ ?>
       <section id="installtimezone" >
            <div class="col-md-5" style="text-align: left;">
					<p for="installtimezone"><?php echo __('Default timezone'); ?>: </p>
					</div>
                                      <div class="col-md-7"> 
                                        <span><?=get_select_timezones('install[default_timezone]', date_default_timezone_get(), $tzlist)?></span>
                                        </div>
				</section><?php } ?>
				<div class="col-md-12">  
				
					<button id="super-next" style="
    margin-top: 30px;
" > <?php echo __('Install now!'); ?></button>
				
				<br></div>
			</form>
			
                     
                     
                     
         
         </div>
        
             <input id="super-prew"type="button" value="Назад" class="previous" />
            
           
            
              
             
            
            
            
            
            
            
            
            
    </div>
        
         
			<?php else: ?>
                        <div class="col-md-12 shag" style="    background: none;"> <h4 style="
    padding: 13px 13px 12px 13px;
    font-size: 22px;
    color: #31708f;
    
"><?php echo __('Congratulations! Napside CMS is installed!'); ?></h4></div>
				 <div class="col-lg-6 hidden-md hidden-sm hidden-xs" style="border-radius: 0px;"></div>
				<div class="col-lg-6 col-md-12" style="border-radius: 0px;padding-right: 84px;">
				<h1 style="
    margin-top: 20px;
"><?php echo __('You should now:'); ?></h1>
				<p style="
     padding: 10px 0px 22px 0px;
    margin-left: 24px;">Napside CMS установлена и готова к использованию. Для обеспечения повышенной безопасности мы предлагаем выполнить следующие рекомендации:   </p>
                                
                                
                                <div id="installInfo" style="
    width: 100%;
    color: #31708f;
        margin-left: 20px;
    background-color: #d9edf7;
    border-color: #bce8f1;
    /* background: #dbf4ff; */
    border: 1px solid #b4eaff;
      margin-top: -10px;
    margin-bottom: 50px;
">
					
                                    
                                    
					<ul>
						<li style="
    padding-top: 8px;
"><b><?php echo __('Username:'); ?></b> <?php echo (isset($data['username']) ? $data['username']: 'n/a'); ?></li>
						<li><b><?php echo __('Password:'); ?></b> <?php echo (isset($password) ? $password: 'n/a'); ?></li>
					</ul>
                                   <a href="../admin/" class="next" style="/* margin-left:14px; */padding: 13px;/* width:  100%; */margin-bottom: 12px;/* font-size: 14px; *//* margin-top: 10px; */border-radius:  3px;/* border: 1px solid #b4eaff; */background: #00aad2;color: white;line-height: 49px;" ">
                                    <?php echo __('Administration panel'); ?>
                                    </a>
					</div>
                                
                                
				<ul style="
    width: 100%;
    margin-left: 19px;
">
                                    
                                    <div class="alert fade in alert-danger" style="  margin-bottom: 10px;     padding: 13px;">
                                        
                                        <li ><?php echo __('delete the <em>install/</em> folder!'); ?></li>
                                        
                                    </div>
                                     <div class="alert fade in alert-danger" style="  margin-bottom: 10px;     padding: 13px;">
					
					<li><?php echo __('remove all write permissions from the <em>config.php</em> file!'); ?></li>
                                        
                                     </div>
                                    <div class="alert fade in alert-danger" style="  margin-bottom: 10px;     padding: 13px;">
					<li><?php echo __('delete directory <em>readme/</em> to enhance security.'); ?></li>
                                        
                                        </div>
                                    
                                     <div class="alert fade in alert-danger" style="  margin-bottom: 10px;     padding: 13px;">
					<li><?php echo __('Create new password'); ?></li>
                                        
                                        </div>
				</ul>
				
				
                                 </div> 
          
			<?php endif; ?>
        </div>
                                 
        
</div>
</div>


                    
                    
                    
                    
                </div>
                
            </div>
        </div>
    </section>
            
             
            
     <!--       
     <p style="
    padding-top: 15px;
    text-align: center;
"> napsideСMS. Copyright © 2016-2017 Pavel Popkov. Подробная <br> 
информация представлена на официальном сайте napside.ru<br>
Napside | Donate | Documentation | License | Partners | Support  
   
     </p>
      -->      
            
	
		
	    <script type="text/javascript" src="../admin/javascripts/jquery.js"></script>
    <script type="text/javascript" src="../admin/javascripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="../admin/javascripts/lightbox.min.js"></script>
    <script type="text/javascript" src="../admin/javascripts/wow.min.js"></script>
    <script type="text/javascript" src="../admin/javascripts/main.js"></script>   	
	</body>
</html>