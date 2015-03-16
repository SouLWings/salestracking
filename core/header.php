<html>
  <head>
	<?php foreach($js as $j){?>
	<script type='text/javascript' src='js/<?php echo $j ?>.js'></script>
	<?php } ?>
	<?php foreach($css as $c){?>
	<link rel="stylesheet" type="text/css" href="css/<?php echo $c ?>.css" />
	<?php } ?>
  </head>
  <body>
  <div class='container'>