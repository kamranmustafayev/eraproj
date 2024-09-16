<!DOCTYPE html>
<html>
<body>

<?php

$tarix = date('Y-m-d');
echo $tarix.'<br>';
$datecheck = strtotime($tarix);
echo $datecheck.'<br>';
$realdr = date('1111-11-11');
$drcheck = strtotime($realdr);
echo $drcheck.'<br>';
echo 'Разница: '.($datecheck-$drcheck);



?>

</body>
</html>
