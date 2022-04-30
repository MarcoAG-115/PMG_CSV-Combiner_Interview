<?php
if (($open = fopen("household_cleaners.csv", "r")) !== FALSE)
{
    while (($data = fgetcsv($open, 1000, ",")) !== FALSE)
    {
        $array[] = $data;
    }
    fclose($open); 
}
echo "<prev>";
var_dump($array);
echo "</prev>";
?>