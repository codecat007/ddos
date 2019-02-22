<?php

require_once "core.php";

echo "<div style='width: 360px; margin-left: auto; margin-right: auto; text-align: justify;'>\n";
echo "<h3>Terms Of Service</h3>\n";

echo html_entity_decode($settings['terms']);

echo "</div>\n";

?>