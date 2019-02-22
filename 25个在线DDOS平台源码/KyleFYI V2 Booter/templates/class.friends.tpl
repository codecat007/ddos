<div class="section">
				<div class="box">
					<div class="title">
						Add Friend
						<span class="hide"></span>
					</div>
					<div class="content">
						<form action="" method="POST" class="valid">
						{$check}
							<div class="row">
								<label>IP Address</label>
								<div class="right"><input type="text" value="" name="ip" class="" /></div>
							</div>
														<div class="row">
								<label>Reason</label>
								<div class="right"><input type="text" value="" name="reason" class="" /></div>
							</div>
														<div class="row">
								<label></label>
								<div class="right">
									<button type="submit"><span>Add Friend</span></button>
								</div>
							</div>
			</form>
							
</div>
</div>
</div>	
	<div class="section">
				<div class="box">
					<div class="title">
						Friends list
						<span class="hide"></span>
					</div>
					<div class="content">
						<table cellspacing="0" cellpadding="0" border="0" class="sortsearch"> 
							<thead> 
								<tr>
									<th>IP Address</th>
									<th>Reason</th>
								</tr>
							</thead>
							<tbody>
							{section name=list loop=$iplogged} 
								<tr class="gradeX">
								<td>{$iplogged[list].ip}</td>
								<td>{$iplogged[list].reason}</td>
								</tr>
							{/section}
												</tbody>
						</table>
					</div>
				</div>
			</div>