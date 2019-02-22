<div class="section">
				<div class="box">
					<div class="title">
						Logs
						<span class="hide"></span>
					</div>
					<div class="content">
						<table cellspacing="0" cellpadding="0" border="0" class="sortsearch"> 
							<thead> 
								<tr>
									<th>Username</h>
									<th>Action</th>
									<th>Date</th>
									<th>IP Address</th>
								</tr>
							</thead>
							<tbody>
							{section name=list loop=$iplogged} 
								<tr class="gradeX">
								<td>{$iplogged[list].username}</td>
								<td>{$iplogged[list].action}</td>
								<td>{$iplogged[list].date}</td>
								<td>{$iplogged[list].ip}</td>
								</tr>
							{/section}
												</tbody>
						</table>
					</div>
				</div>
			</div>