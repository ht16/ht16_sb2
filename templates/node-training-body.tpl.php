<?php print check_plain($node->title) ?>
<table style="cellspacing: 0 5 0 0;"><thead></thead>
<tr>
<td style="min-width:90px;"><?php print $node->field_weekday[0]['view'] ?></td>
<td style="min-width:75px;">von <?php print $node->field_beginn[0]['view'] ?></td>
<td style="min-width:75px;">bis <?php print $node->field_ende[0]['view'] ?></td>
<td style="min-width:250px;"><?php print $node->field_halle[0]['view'] ?></td>
</tr>
</table>
<?php print $node->body ?>