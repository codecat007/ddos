/*
* Removed ill redo this later old 1n looked like my grandmothers fat ass
*/

<br /><br />
<br /><br />
		<div id="article">			

            <u>Latest News:</u>
			<br><br>

          <table width="400" border="1" align="center" cellpadding="5" cellspacing="0">
			
            <?php														
			$link = mysql_connect("localhost", "root", "poiupoiu");
			mysql_select_db("login", $link);
            $news_qry = mysql_query("SELECT * FROM news ORDER BY id DESC LIMIT 4;");

            if (mysql_num_rows($news_qry) > 0) {
                while ($news = mysql_fetch_assoc($news_qry)) {
                    echo '
					<tr>
						<td>
                        <div class="sectionBody">
						  <div class="upcomming">
						  <div class="recentupdates">
                            <div class="recentNews">
								  <div class="author">
                                <div class="newsTitle">
									
                                    <u><center>' . $news['title'] . '</u> - ' . $news['author_id'] . ' <br>
                                    <span><b>' . $news['date'] . '</b></span>
                                </div>
                                <p>
								<font size="2">
								<center>
								' . $news['description'] . '</p>
								</font>
								</div>
                                <p>
								<b>
								<u><font color="#ff0000">Recent Updates:</font>
								<br>
								</u>
								</b>
								<font size="2">
								' . $news['updates'] . '
								</font>
								</p>
								</div>
								
								
								<p>
								<b>
								<u><font color="lime">Upcomming Updates:</font>
								<br>
								</u>
								</b>
								<font size="2">
								' . $news['upcomming'] . '
								</font>
								</p>
								</div>
								
								
                        </div>
						</td>
						</tr>';
                }
            }
            ?>
   </table>
</div>
