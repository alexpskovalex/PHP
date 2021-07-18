<?php
//константы
$expected_chars = array("(",")","-"," ");//символы исполующиеся для формата записи номер, которые нужно удалить
$expected_chars = array("(",")","-"," ");//символы исполующиеся для формата записи номер, которые нужно удалить
$digits='0123456789';

require_once('connection.php');// подключаюсь к своей Бд\

$sql = 'SELECT ID,contacts FROM phonenum.phones';
$result = $pdo->query($sql);


while ($client = $result->fetch(PDO::FETCH_ASSOC)){
    $allnumbers = array(); //инициализация массива содержащего все номера из ячейки
    $client['contacts']=str_replace($expected_chars,'',$client['contacts']); // удаляет символы использующиеся для форматированной записи номера(все цифры идут строго дург за другом)
    for ($i=0; $i <strlen($client['contacts']) ; $i++) { 
        if ($client['contacts'][$i]=='7' or $client['contacts'][$i]=='8') {  //если находит 7 или 8 в строке то начинает проверку являеться ли это номером
            $number=substr($client['contacts'],$i,11); //заносит 11 символов предполагаемого номера в переменную
            for ($j=1; $j<11 ; $j++) {                        
                if (strpos($digits,$number[$j]) == false) {//если символа нет в $digits 
                    $i+= $j;//перебор перемещаеться неправильный символ(далее continue перемещает на следующий) 
                    continue(2);//прекращает проверку текущего номера 
                }
            }   
            $i+= $j;     //если цикл не прервался то перебор перемещается на последнюю цифру номера              
            $allnumbers[]= substr($number,0,1).'('.substr($number,1,3).')'.substr($number,4,7);//добавляет номер в массив всех номеров     
            //echo $number.'<br>';              
        }
    }
   //занесение в БД
    $phone=$allnumbers[0];//если номер один то он заносится в основную таблицу
    if (count($allnumbers)==1) {
        $sql="INSERT INTO phonenum.app_cliants (id, phone) VALUES (:id, :phone)";//запрос с плейсхолдерами
        $insert=$pdo->prepare($sql);
        $insert->execute(array(':id'=>$client['ID'],':phone'=>$phone));
    }elseif (count($allnumbers)==0) {//если номеров нет то он заносится во вторую таблицу  
        $sql="INSERT INTO phonenum.app_problem (id, phone) VALUES (:id, :phone)";
        $insert->execute(array(':id'=>$client['ID'],':phone'=>'номер отсутствует'));
    }else{//если номеров больше одного то они заносятся во вторую таблицу
        for ($i=1; $i < count($allnumbers) ; $i++) { //составляет список из всех номеров телефонов в одну строку
            $phone=$phone.'; '.$allnumbers[$i];
        }
        $sql="INSERT INTO phonenum.app_problem (id, phone) VALUES (:id, :phone)";
        $insert=$pdo->prepare($sql);
        $insert->execute(array(':id'=>$client['ID'],':phone'=>$phone));
    }
    

}
//ID, contacts
?>
