<?php
$nr_indeksu='169271';
$nrGrupy='2';

echo 'Bartosz Kowalski '.$nr_indeksu.' grupa '.$nrGrupy.'<br /><br />';
                
echo 'a) Zastosowanie metody include()<br />';
include('vars.php');
echo 'A '.$color.' '.$fruit.'<br/> <br/> ';
                
echo 'b) Warunki if, else, elseif, switch<br />';
$a = 5;
$b = 10;
if ($a > $b)
{
    echo $a.'>'.$b;
}
elseif ($a < $b)
{
    echo $a.'<'.$b;
}
else
{
    echo $a.'='.$b;
}
echo '<br/>';
switch($a)
{
    case 1:
        echo 'a=1';
        break;
    case 5:
        echo 'a=5';
        break;
    case 10:
        echo 'a=10';
        break;
}

echo '<br/><br/>c) Pętle while() i for()<br />';
for ($i = 1; $i <= 10; $i++) {
    echo $i.' ';
}
echo '<br/>';
$i = 10;
while ($i >= 1)
{
    echo $i.' ';
    $i--;
}

echo '<br/><br/>d) Typy zmiennych $_GET, $_POST, $_SESSION<br />';
if (isset($_GET["name"])) {
    echo 'Hello ' . htmlspecialchars($_GET["name"]) . '!';
} else 
{
    echo 'Nie podałeś swojego imienia w URL-u.';
}

echo '<br />';
if (isset($_POST["name"])) {
    echo 'Hello ' . htmlspecialchars($_POST["name"]) . '!';
} else 
{
    echo 'Nie podałeś swojego imienia w URL-u.';
}

echo '<br />';
session_start();
$_SESSION['username']='Bartosz';
echo $_SESSION["username"];
?>