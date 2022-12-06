<?php 

echo '<br>';

include 'connecSQL.php';

$request = $mysqli->query('select * from utilisateurs');

$result = $request->fetch_array(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="index.css" rel = "stylesheet">
    <title>Page Admin</title>
</head>
<body>
<div class="background">
<?php 
    include 'header.php';
?>
<table border="3">
        <thead>
            <?php
                foreach($result = $request->fetch_array(MYSQLI_ASSOC) as $key => $value){
                    echo '<th>' . $key . '</th>';
                }
            ?>
        </thead>
        <tbody>
            <?php
            while($result !=null){
                echo '<tr>';
                foreach($result as $value){
                    echo '<td>' . $value . '</td>';
                }
                $result = $request->fetch_array(MYSQLI_ASSOC);
                echo '</tr>';
            }
            ?>
<div class="background">
</body>
</html>