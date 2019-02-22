<div id="nav">
		
	<div class="container">
		
		<a href="javascript:;" class="btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        	<i class="icon-reorder"></i>
      	</a>
		
		<div class="nav-collapse">
			
			<ul class="nav">
		
				<li class="nav-icon">
					<a href="<?php echo $url;?>index.php">
						<i class="icon-home"></i>
						<span>Home</span>
					</a>	    				
				</li>
				
				<li class="dropdown">					
					<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
					<i class="icon-th"></i>
						Boot Tools
						<b class="caret"></b>
					</a>	
				
					<ul class="dropdown-menu">
						<li><a href="<?php echo $url;?>boot.php">HUB</a></li>
						<li><a href="logger.php">IP Logger</a></li>
					</ul>    				
				</li>
				
				<li class="dropdown">					
					<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
						User Settings
						<b class="caret"></b>
					</a>	
				
					<ul class="dropdown-menu">
						<li><a href="<?php echo $url;?>settings.php">User CP</a></li>
						<li><a href="<?php echo $url;?>unset.php">Logout</a></li>
					</ul>    				
				</li>
				<?php
				if ($user -> isAdmin())
				{
					echo '<li class="dropdown">					
					<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
						Admin
						<b class="caret"></b>
					</a>	
				
					<ul class="dropdown-menu">
						<li><a href="'.$url.'admin/logs.php">Logs</a></li>
						<li><a href="'.$url.'admin/users.php">Users</a></li>
						<li><a href="'.$url.'admin/api.php">API</a></li>
					</ul>    				
				</li>';
				}
				?>
			</ul>
			
			
		</div> <!-- /.nav-collapse -->
		
	</div> <!-- /.container -->
	
</div> <!-- /#nav -->