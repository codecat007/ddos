<div class="section">
				<div class="box">
					<div class="title">
						Users
						<span class="hide"></span>
					</div>
					<div class="content">
						<table cellspacing="0" cellpadding="0" border="0" class="sortsearch"> 
							<thead> 
								<tr>
									<th>Users</th>
									<th>Max Boot</th>
									<th>Attacks</th>
									<th>Type</th>
									<th>Key</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							{section name=list loop=$iplogged} 
								<tr class="gradeX">
								<td>{$iplogged[list].login}</td>
								<td>{$iplogged[list].max}</td>
								<td>{$iplogged[list].attacks}</td>
								<td>{$iplogged[list].type}</td>
								<td>{$iplogged[list].key}</td>
								<td><a href="?remove={$iplogged[list].login}">Remove</a> - <a href="?ban={$iplogged[list].login}">Ban</a>
								</tr>
							{/section}
												</tbody>
						</table>
					</div>
				</div>
			</div>