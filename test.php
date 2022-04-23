<html><body><table border="0" cellpadding="3">
<tr><td bgcolor="#CCCCCC" align="center"><b>Distance</b></td>
<td bgcolor="#CCCCCC" align="center"><b>Cost</b></td></tr>
<?php
for ($distance=50; $distance<=250; $distance+=50) {
echo "<tr>\n";
echo "<td align='right'>$distance</td>\n";
echo "<td align='right'>" . $distance/10 . "</td>\n";
echo "</tr>\n";
}
?>
</table></body></html>