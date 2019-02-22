<div class="section">
				<div class="box">
					<div class="title">
						Add User
						<span class="hide"></span>
					</div>
					<div class="content">
						<form action="" method="POST" class="valid">
						{$check}
							<div class="row">
								<label>Max Boot Time</label>
								<div class="right"><input type="text" value="" name="max" class="" /></div>
							</div>
							<div class="row">
								<label>Expiry</label>
								<div class="right"><input type="text" value="" name="expiry" class="" /></div>
							</div>
														<div class="row">
								<label></label>
								<div class="right">
									<button type="submit"><span>Add Key</span></button>
								</div>
							</div>
			</form>
							
</div>
</div>
</div>	

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