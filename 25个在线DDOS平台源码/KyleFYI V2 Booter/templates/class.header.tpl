			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
	<title>{$bootername}</title>
	
	<meta name="apple-mobile-web-app-capable" content="no" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<meta name="viewport" content="width=device-width,initial-scale=0.69,user-scalable=yes,maximum-scale=1.00" />



		<link rel="stylesheet" type="text/css" href="{$template}/css/style.css" /> 
		<link rel="stylesheet" type="text/css" href="{$template}/css/forms.css" /> 
		<link rel="stylesheet" type="text/css" href="{$template}/css/forms-btn.css" /> 
		<link rel="stylesheet" type="text/css" href="{$template}/css/menu.css" /> 
		<link rel="stylesheet" type="text/css" href="{$template}/css/style_text.css" /> 
		<link rel="stylesheet" type="text/css" href="{$template}/css/datatables.css" /> 
		<link rel="stylesheet" type="text/css" href="{$template}/css/fullcalendar.css" /> 
		<link rel="stylesheet" type="text/css" href="{$template}/css/pirebox.css" /> 
		<link rel="stylesheet" type="text/css" href="{$template}/css/modalwindow.css" /> 
		<link rel="stylesheet" type="text/css" href="{$template}/css/statics.css" /> 
		<link rel="stylesheet" type="text/css" href="{$template}/css/tabs-toggle.css" /> 
		<link rel="stylesheet" type="text/css" href="{$template}/css/system-message.css" /> 
		<link rel="stylesheet" type="text/css" href="{$template}/css/tooltip.css" /> 
		<link rel="stylesheet" type="text/css" href="{$template}/css/wizard.css" /> 
		<link rel="stylesheet" type="text/css" href="{$template}/css/wysiwyg.css" /> 
		<link rel="stylesheet" type="text/css" href="{$template}/css/wysiwyg.modal.css" /> 
		<link rel="stylesheet" type="text/css" href="{$template}/css/wysiwyg-editor.css" /> 
		<link rel="stylesheet" type="text/css" href="{$template}/css/handheld.css" /> 
	
	
	
	<!--[if lte IE 8]>
		<script type="text/javascript" src="http://www.dreamwire.nl/themes/Mustache/v1.2/Fixed/{$template}/js/excanvas.min.js"></script>
	<![endif]-->
	
	<script type="text/javascript" src="{$template}/js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="{$template}/js/jquery.backgroundPosition.js"></script>
	<script type="text/javascript" src="{$template}/js/jquery.placeholder.min.js"></script>
	<script type="text/javascript" src="{$template}/js/jquery.ui.1.8.17.js"></script>
	<script type="text/javascript" src="{$template}/js/jquery.ui.select.js"></script>
	<script type="text/javascript" src="{$template}/js/jquery.ui.spinner.js"></script>
	<script type="text/javascript" src="{$template}/js/superfish.js"></script>
	<script type="text/javascript" src="{$template}/js/supersubs.js"></script>
	<script type="text/javascript" src="{$template}/js/jquery.datatables.js"></script>
	<script type="text/javascript" src="{$template}/js/fullcalendar.min.js"></script>
	<script type="text/javascript" src="{$template}/js/jquery.smartwizard-2.0.min.js"></script>
	<script type="text/javascript" src="{$template}/js/pirobox.extended.min.js"></script>
	<script type="text/javascript" src="{$template}/js/jquery.tipsy.js"></script>
	<script type="text/javascript" src="{$template}/js/jquery.elastic.source.js"></script>
	<script type="text/javascript" src="{$template}/js/jquery.jBreadCrumb.1.1.js"></script>
	<script type="text/javascript" src="{$template}/js/jquery.customInput.js"></script>
	<script type="text/javascript" src="{$template}/js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="{$template}/js/jquery.metadata.js"></script>
	<script type="text/javascript" src="{$template}/js/jquery.filestyle.mini.js"></script>
	<script type="text/javascript" src="{$template}/js/jquery.filter.input.js"></script>
	<script type="text/javascript" src="{$template}/js/jquery.flot.js"></script>
	<script type="text/javascript" src="{$template}/js/jquery.flot.pie.min.js"></script>
	<script type="text/javascript" src="{$template}/js/jquery.flot.resize.min.js"></script>
	<script type="text/javascript" src="{$template}/js/jquery.graphtable-0.2.js"></script>
	<script type="text/javascript" src="{$template}/js/jquery.wysiwyg.js"></script>
	<script type="text/javascript" src="{$template}/js/controls/wysiwyg.image.js"></script>
	<script type="text/javascript" src="{$template}/js/controls/wysiwyg.link.js"></script>
	<script type="text/javascript" src="{$template}/js/controls/wysiwyg.table.js"></script>
	<script type="text/javascript" src="{$template}/js/plugins/wysiwyg.rmFormat.js"></script>
	<script type="text/javascript" src="{$template}/js/costum.js"></script>
	
</head>

<body>

<div id="wrapper">
	<div id="container">
	
		<div class="hide-btn top tip-s" original-title="Close sidebar"></div>
		<div class="hide-btn center tip-s" original-title="Close sidebar"></div>
		<div class="hide-btn bottom tip-s" original-title="Close sidebar"></div>
		
		<div id="top">
			<h1 id="logo"><a href="./"></a></h1>
			<div id="labels">
				<ul>
					<li><a href="index.php" class="user"><span class="bar">Welcome {$username}</span></a></li>
					<li><a href="profile.php" class="settings"></a></li>
					<li><a href="logout.php" class="logout"></a></li>
				</ul>
			</div>
			<div id="menu">
				<ul> 
					<li><a href="index.php">Dashboard</a></li> 
					<li><a href="hub.php">Boot</a> </li> 
					<li><a href="cfr.php">CloudFlare Resolver</a></li>
					<li><a href="don.php">Down or not?</a></li>
						<li><a href="ip_logger.php">IP Logger</a></li>
						<li>
						<a href="#">Friends/Enemys</a>
						<ul> 
							<li><a href="friends.php">Friends</a></li>
							<li><a href="enemys.php">Enemys</a></li>
						</ul>
					</li>
					<li><a href="attacks.php">My Attacks</a></li>
					{if $type == 'reseller'}
						<li><a href="reseller.php">Reseller</a></li>
					{/if}
				</ul>
			</div>
		</div>
		
		<div id="left">
		{if $type == 'admin'}
			<div class="box submenu">
				<div class="content">
					<ul>
						<li><a href="admin/users.php">List Users</a></li>
						<li><a href="admin/add.php">Add Users</a></li>
						<li><a href="admin/logs.php">View Logs</a></li>
						<li><a href="admin/news.php">News Manger</a></li>
						<li><a href="admin/blacklist.php">BlackList</a></li>
						<li><a href="admin/shells.php">Add Shells</a></li>
					</ul>
				</div>
			</div>
			{/if}
			<div class="box statics">
				<div class="content">
					<ul>
						<li><h2>Statistics</h2></li>
						<li>Max Boot Time <div class="info red"><span>{$maxboot}</span></div></li>
						<li>Total Users <div class="info green"><span>{$total_users}</span></div></li>
						<li>Expiry Data <div class="info red"><span>{$timeleft}</span></div></li>
						<li>Shells <div class="info blue"><span>{$shells}</span></div></li>
					</ul>
				</div>
			</div>
		</div>
		
				<div id="right">
		