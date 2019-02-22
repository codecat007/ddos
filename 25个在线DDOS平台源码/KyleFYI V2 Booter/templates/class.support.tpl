			<div class="section">
				<div class="box">
					<div class="title">
						Support Tickets
						<span class="hide"></span>
					</div>
					<div class="content">
						<table cellspacing="0" cellpadding="0" border="0" class="sortsearch"> 
							<thead> 
								<tr>
									<th>ID</th>
									<th>Subject</th>
									<th>Priority</th>
									<th>Owner</th>
								</tr>
							</thead>
							<tbody>
							{section name=list loop=$tickets} 
								<tr class="gradeX">
								<td><a href="view.php?id={$tickets[list].id}">{$tickets[list].id}</a></td>
								<td>{$tickets[list].subject}</td>
								{if $tickets[list].Priority == "1"}
								<td><font color="green">Low</font></td>
								{elseif $tickets[list].Priority == "2"}
								<td><font color="yellow">Normal</font></td>
								{else}
								<td><font color="red">High</font></a></td>
								{/if}
								<td>{$tickets[list].owner}</td>
								</tr>
							{/section}
												</tbody>
						</table>
					</div>
				</div>
			</div>