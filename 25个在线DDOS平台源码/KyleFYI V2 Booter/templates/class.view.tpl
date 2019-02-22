{section name=list loop=$thread} 
<div class="section">
				<div class="box">
					<div class="title">
						{$thread[list].subject} Posted by: {$thread[list].owner}
						
					</div>
					<div class="content">
{$thread[list].message}
							
</div>
</div>
</div>
{/section}

{section name=list loop=$replys}
<div class="section">
				<div class="box">
					<div class="title">
						{$replys[list].subject} Posted by: {$replys[list].username}
						
					</div>
					<div class="content">
{$replys[list].message}
							
</div>
</div>
</div>
{/section}
