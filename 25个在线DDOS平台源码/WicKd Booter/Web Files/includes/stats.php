<div class="span3">
				<div class="widget">
					
					<div class="widget-header">
						
						<h3>
							<i class="icon-tasks"></i> 
							User Stats								
						</h3>
						
							
					</div> <!-- /.widget-header -->
					
					<div class="widget-content">		
						
						<div class="stat">
							
							<div class="stat-header">
								
								<div class="stat-label">
									Username
								</div> <!-- /.stat-label -->
								
								<div class="stat-value">
									<?php echo $_SESSION['username']; ?>
								</div> <!-- /.stat-value -->
								
							</div> <!-- /stat-header -->
							
							
						</div> <!-- /.stat -->
						<hr />
						<div class="stat">
							<div class="stat-header">
								<div class="stat-label">
									Max Boot
								</div> <!-- /.stat-label -->
								<div class="stat-value">
									<?php echo $status -> maxBoot(); ?>
								</div> <!-- /.stat-value -->
							</div> <!-- /stat-header -->
						</div> 
						
						<hr />
						<div class="stat">
							<div class="stat-header">
								<div class="stat-label">
									Expire
								</div> <!-- /.stat-label -->
								<div class="stat-value">
									<?php echo $status -> expire();?>
								</div> <!-- /.stat-value -->
							</div> <!-- /stat-header -->
						</div> 
						
						
					</div> <!-- /.widget-content -->
					
				</div> <!-- /.widget -->
				<div class="widget">
					
					<div class="widget-header">
						
						<h3>
							<i class="icon-tasks"></i> 
							Booter Stats								
						</h3>
						
							
					</div> <!-- /.widget-header -->
					
					<div class="widget-content">		
						
						<div class="stat">
							
							<div class="stat-header">
								
								<div class="stat-label">
									Registered Users
								</div> <!-- /.stat-label -->
								
								<div class="stat-value">
									<?php echo $status -> registered();?>
								</div> <!-- /.stat-value -->
								
							</div> <!-- /stat-header -->
							
							
						</div> <!-- /.stat -->
						<hr>
						<div class="stat">
							<div class="stat-header">
								<div class="stat-label">
									Total Boots
								</div> <!-- /.stat-label -->
								
								<div class="stat-value">
									<?php echo $status -> totalBoots(); ?>
								</div> <!-- /.stat-value -->
							</div> <!-- /stat-header -->
						</div> 
						<hr />
						<div class="stat">
							<div class="stat-header">
								<div class="stat-label">
									User Boots
								</div> <!-- /.stat-label -->
								
								<div class="stat-value">
									<?php echo $status -> userBoots(); ?>
								</div> <!-- /.stat-value -->
							</div> <!-- /stat-header -->
						</div> 
						
						<hr />
						
						<div class="stat">
							<div class="stat-header">
								<div class="stat-label">
									Boots Running
								</div> <!-- /.stat-label -->
								
								<div class="stat-value">
									<?php echo $status -> running(); ?>
								</div> <!-- /.stat-value -->
							</div> <!-- /stat-header -->
						</div> 
						
						
					</div> <!-- /.widget-content -->
					
				</div> <!-- /.widget -->
				
				
				
				
			</div> <!-- /.span3 -->