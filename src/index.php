<html>
 <head>
  <title>Test PHP</title>
 </head>
 <body>
 <?php echo '<p>Bonjour le monde</p>'; ?>
<?php
$output = shell_exec('ps -aux | grep transcode | grep python3 | grep -v grep');
echo "<pre>$output</pre>";
?>

<?php
$output = shell_exec('ls -al /mnt/video');
echo "<pre>$output</pre>";
?>


 </body>
</html>
