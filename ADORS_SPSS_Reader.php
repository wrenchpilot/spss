<?php
require 'SPSSReader.php';
$SPSS = new SPSSReader('2012_Beginning_College_Survey_of_Student_Engagement-08302016.sps.sav');
?>
<!DOCTYPE html>

<h2>LABEL VALUES</h2>
<table border="1" width="100%">
	<tr>
		<th>QUESTION</th> <!-- Question -->
		<th>VALUE</th> <!-- Label -->
		<th>LABEL</th> <!-- Value -->
        <th>SURVEYID</th>
        <th>PROGRAM_ID</th>
	</tr>
	<?php $i=0; foreach($SPSS->variables as $var): ?>
	<?php
		if ($var->isExtended) continue; // skip extended vars
		$i++; 
	?>


			<?php
				foreach($var->valueLabels as $key => $val) {
					echo "<tr>";
					echo "<td>". $var->name ."</td>";
					echo "<td>". $val . "</td>";
					echo "<td>". $key . "</td>";
					echo "<td>". SURVEYID ."</td>";
					echo "<td>". PROGRAM_ID ."</td>";
					echo "</tr>";
				}
			?>

	<?php endforeach; ?>
</table>


<h2>QUESTIONS</h2>
<table border="1" width="100%">
	<tr>
		<th>QUESTION</th> 
        <th>POSITION</th>
        <th>LABEL</th> 
		<th>SURVEYID</th> 
        <th>PROGRAM_ID</th>
        <th>MISSING</th>
        <th>DISPLAY_MEAN</th>
        <th>DISPLAY_FREQ</th>
	</tr>
    <?php $dm = 0; $df = 0; ?>
	<?php $i=0; foreach($SPSS->variables as $var): ?>
	<?php
		if ($var->isExtended) continue; // skip extended vars
		$i++; 
		switch ( $var->getMeasureLabel() ){
			case "Nominal": $dm = 0; $df = 1; break;
			case "Ordinal": $dm = 0; $df = 0; break;
			case "Scale"  : $dm = 1; $df = 1; break;
		}
	?>
    <tr>
			<?php
					echo "<td>". $var->name ."</td>";
					echo "<td>". $i ."</td>";
					echo "<td>". $var->getLabel() ."</td>";
					echo "<td>SURVEYID</td>";
					echo "<td>PROGRAM_ID</td>";
					echo "<td>". $var->getMissingLabel() ."</td>";
					echo "<td>". $dm ."</td>";
					echo "<td>". $df ."</td>";
			?>
            </tr>
 <?php endforeach; ?>
</table>

<?php

$SPSS->loadData();
?>
<h2>Data view</h2>
<table border="1" width="100%">
<tr>
	<th></th>
	<?php foreach($SPSS->variables as $var): ?>
	<?php
		if ($var->isExtended) continue; // skip extended vars
	?>
	<th><?=$var->name?></th>
	<?php endforeach; ?>
</tr>
<?php
for($case=0;$case<$SPSS->header->numberOfCases;$case++) {
	echo '<tr>';
		echo '<td>'.($case+1).'</td>';
	foreach($SPSS->variables as $var) {
		if ($var->isExtended) continue; // skip extended vars
		echo '<td align="'.$var->getAlignmentLabel().'">'.($var->data[$case]==='NaN'?'.':$var->data[$case]).'</td>';
	}
	echo '</tr>';
}
?>
</table>