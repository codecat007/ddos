<div class="section">
				<div class="box">
					<div class="title">
						Host 2 IP
						<span class="hide"></span>
					</div>
					<div class="content">
						<form action="" method="POST" class="valid">
							<div class="row">
								<label>Domain</label>
								<div class="right"><input type="text" value="" name="domain" class="" /></div>
							</div>
														<div class="row">
								<label></label>
								<div class="right">
									<button type="submit"><span>Grab IP</span></button>
								</div>
							</div>
			</form>
							
</div>
</div>
</div>


<div class="section">
				<div class="box">
					<div class="title">
						Boot
						<span class="hide"></span>
					</div>
					<div class="content">
					<marquee behavior="scroll" direction="left" scrollamount="15">{$attack}</marquee>
						<form action="" method="POST" class="valid">
							<div class="row">
								<label>Type</label>
								<div class="right">
									<select name="type" class="">
										<option value="UDP">UDP</option>
									</select>
								</div>
							</div>
							<div class="row">
								<label>Host</label>
								<div class="right"><input type="text" value="{$domain}" name="host" class="" /></div>
							</div>
					<div class="row">
								<label>Port</label>
								<div class="right"><input type="text" value="" name="port" class="" /></div>
							</div>
							<div class="row">
									<label>Time</label>
									<div class="right">
										<div class="slider single-slide">
										
											Time: <input type="text" style="width: 100px;" class="amount" readonly="readonly" name="time" value="" />
											<div class="slide" value="30" max="{$maxboot}" min="10"></div>
										</div>
									</div>
								</div>
													<div class="row">
									<label>Power</label>
									<div class="right">
										<div class="slider single-slide">
											Power: <input type="text" class="amount" readonly="readonly" name="power" value="" />%
											<div class="slide" value="50" max="100" min="10"></div>
										</div>
									</div>
								</div>
							<div class="row">
								<label></label>
								<div class="right">
									<button type="submit"><span>Start Attack</span></button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>