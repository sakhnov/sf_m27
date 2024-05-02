<?php
class Model_Login extends Model
{	      
    //Проверям, существует ли пользователь
    function getUser(string $User_login, string $Password, string $Hash, string $Ip, string $Insip='', string $VKpass=null)
	{
        // проверяем, не существует ли пользователя с таким именем
        $sql = "select id, password from users where login = '$User_login' LIMIT 1";
        $stmt = $this->db->query($sql);
        $result = $stmt->FETCH(PDO::FETCH_ASSOC);
        if (is_null($VKpass) & ($result['password']===md5(md5($_POST['password']))))
        {
            // Записываем в БД новый хеш авторизации и IP
            $sql = "update users set token='".$Hash.$Insip."' where id='".$result['id']."';";          
            $createResult=$this->db->prepare($sql); 
            $createResult->execute();
            if($createResult->rowCount()>0)
            {
                return $result['id'];
            }  
            return null;
        } 
        elseif(!is_null($VKpass))
        {
            // Записываем в БД новый хеш авторизации и IP
            $sql = "update users set token='".$Hash.$Insip."' where id='".$result['id']."';";          
            $createResult=$this->db->prepare($sql); 
            $createResult->execute();
            if($createResult->rowCount()>0)
            {
                return $result['id'];
            }  
            return null;            
        }
        else 
        {
            return null;
        }              
    }
    //Интеграция в VK
    //Создаём пользователя
    function createUser(string $User_login, string $UserPassword, int $RoleID=2)
    {
        // Убираем лишние пробелы и делаем двойное хэширование (используем старый метод md5)
        $password = md5(md5(trim($UserPassword)));         
        $sql = "insert into users(login, password) 
        values ('".$User_login."', '".$password."');";   
        $result =  $this->db->exec($sql); 
        if($result)
        {
            $sql = "select id from users where login = '$User_login' LIMIT 1";
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