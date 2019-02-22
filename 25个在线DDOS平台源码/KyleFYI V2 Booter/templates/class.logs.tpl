<div class="section">
				<div class="box">
					<div class="title">
						Your Logs
						<span class="hide"></span>
					</div>
					<div class="content">
						<table cellspacing="0" cellpadding="0" border="0" class="sortsearch"> 
							<thead> 
								<tr>
									<th>Action</th>
									<th>Date</th>
								</tr>
							</thead>
							<tbody>
							{section name=list loop=$iplogged} 
								<tr class="gradeX">
								<td>{$iplogged[list].action}</td>
								<td>{$iplogged[list].date}</td>
								</tr>
							{/section}
												</tbody>
						</table>
					</div>
				</div>
			</div>