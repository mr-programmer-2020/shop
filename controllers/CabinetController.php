<?php

include_once ROOT . '/models/User.php';

class CabinetController{

	public function actionIndex(){

		$userid=User::checkLogged();

		$user=User::getUserById($userid);

		require_once(ROOT.'/views/cabinet/index.php');

		return true;
	}



    public function actionEdit()
    {
        // Получаем идентификатор пользователя из сессии
        $userId = User::checkLogged();
        
        // Получаем информацию о пользователе из БД
        $user = User::getUserById($userId);
        
        //$name = $user['name'];
        //$password = $user['password'];
        
        $name = (isset($_POST['name']) && $_POST['name'] != "") ? ($_POST['name']) : null;
        $password = (isset($_POST['password']) && $_POST['password'] != "") ? ($_POST['password']) : null;
                
        $result = false;     

        if (isset($_POST['submit']) && $name && $password) {

            //$name = $_POST['name'];
            //$password = $_POST['password'];
            
            $errors = false;
            
            if (!User::checkName($name)) {
                $errors[] = 'Имя не должно быть короче 2-х символов';
            }
            
            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }
            
            if ($errors == false) {
                $result = User::edit($userId, $name, $password);
            }

        }

        require_once(ROOT . '/views/cabinet/edit.php');

        return true;
    }
}