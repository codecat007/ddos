<div class="section">
				<div class="box">
					<div class="title">
						IP Logger Link
						<span class="hide"></span>
					</div>
					<div class="content">
						<form action="" method="POST" class="valid">
							<div class="row">
								<label>Link</label>
								<div class="right"><input type="text" value="{$booterURL}funny.php?id={$member_ID}" name="domain" class="" /></div>
							</div>
			</form>
							
</div>
</div>
</div>

			<div class="section">
				<div class="box">
					<div class="title">
						IP's Logged
						<span class="hide"></span>
					</div>
					<div class="content">
						<table cellspacing="0" cellpadding="0" border="0" class="sortsearch"> 
							<thead> 
								<tr>
									<th>IP</th>
									<th>Date</th>
								</tr>
							</thead>
							<tbody>
							{section name=list loop=$iplogged} 
								<tr class="gradeX">
								<td>{$iplogged[list].ip}</td>
								<td>{$iplogged[list].date}</td>
								</tr>
							{/section}
												</tbody>
						</table>
					</div>
				</div>
			</div>