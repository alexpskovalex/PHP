e<html>
<head>
</head>

<?php
//подключаю дб

//параметры для входа
$driver = 'mysql';
$host = 'localhost';
$db_name = 'pdo_trying';
$db_user = 'root';
$db_pass = 'root';
$charset = 'utf8';
$options = [    PDO::ATTR_ERRMODE =>PDO::ERRMODE_EXCEPTION]; // =>? ::?
try {
$pdo=new PDO("mysql:host=$host;dbname-$db_name;charset=$charset",$db_user,$db_pass,$options); 
} catch (PDOException $e) {
    die('ошибка подключения к БД');
}
//$result=$pdo->query('SELECT * FROM pdo_trying.users');

$id = '4';
$sql = 'SELECT * FROM pdo_trying.users WHERE id > :id';
$result = $pdo->prepare($sql); //
$result->execute(array('id' => $id));


while($row = $result->fetch(PDO::FETCH_ASSOC)){
echo 'username= ' . $row['username'] . ' password= ' . $row['password'].'<br>' ;
}
echo '<hr>';

/*
foreach ($result->fetch(PDO::FETCH_ASSOC) as $row ) {
    echo 'username= ' . $row['username'] . ' password= ' . $row['password'].'<br>' ;
}
$pdo = null;
$result = null;
*/

?>

<form method="POST">
    <fieldset>
    <label for="login"  >Имя</label>
        <input  id="login" type="text" placeholder="login" maxlength="16" name="login" required >
        <br>
    <label for="username"  >Имя</label>
        <input  id="username" type="text" placeholder="user123" maxlength="16" name="username" required >
        <br>
    <label for="password"  >Имя</label>
        <input  id="password" type="text" placeholder="password" maxlength="16" name="password" required >
        <br>
        <input type="submit">
    </fieldset> 
</form>
<?php
$username = $_POST['username'];
$password = $_POST['password'];
$login=$_POST['login'];
$sql="INSERT INTO pdo_trying.users (login, password, username ) VALUES (:login, :password, :username) ";
$insert=$pdo->prepare($sql);
$insert->execute(array(':login'=>$_POST['login'],':password'=>$_POST['password'],':username'=>$_POST['username']));
echo '<hr>';
$sql='SELECT username,password FROM pdo_trying.users';
$result = $pdo->query($sql)->fetchAll(PDO::FETCH_KEY_PAIR);
print_r ($result);
?>
</html>