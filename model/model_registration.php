<?php
class Model_Registration extends Model
{	   
    //Проверям, существует ли пользователь
    function checkUserExistance(string $User_login)
	{
        // проверяем, не существует ли пользователя с таким именем
        $sql = "select id from users where login = '$User_login'";
        $stmt = $this->db->query($sql);
        $result = $stmt->FetchAll(PDO::FETCH_NUM);

        if(count($result) > 0)
        {
            return false;
        } 
        else 
        {
            return true;
        }              
    }
   
    //Создаём пользователя
    function createUser(string $User_login, string $UserPassword, int $RoleID=1)
    {
        // Убираем лишние пробелы и делаем двойное хэширование (используем старый метод md5)
        $password = md5(md5(trim($UserPassword)));         
        $sql = "insert into users(login, password) 
        values ('".$User_login."', '".$password."');";   
        $result =  $this->db->exec($sql); 
        if($result)
        {
            $sql = "select id from users  where login = '$User_login'LIMIT 1";
            $stmt = $this->db->query($sql);
            $result = $stmt->FETCH(PDO::FETCH_ASSOC);
            $user_id = $result['id'];
            //добавляем роль пользователю по умолчанию
            $sql = "insert into roles_map(role_id, user_id) 
            values ('".$RoleID."', '".$user_id."');";                          
            $result =  $this->db->exec($sql);
            return true;
        }  
        return false; 
    }
}?>