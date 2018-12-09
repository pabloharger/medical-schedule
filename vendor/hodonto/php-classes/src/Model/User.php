<?php

namespace HOdonto\Model;

use \HOdonto\DB\Sql;
use \HOdonto\Model;
use \HOdonto\Mailer;

class User extends Model {

	const SESSION = "User";
	const ERROR   = "UserError";
	const SECRET  = "HCodePhp7_Secret";
	const SECIV   = "HCodePhp7_SecIV_";
	const ENCRYPTMETHOD = "AES-256-CBC";

	public function get($idUser)
	{

		$sql = new Sql();

		$results = $sql->select("
			SELECT * 
			FROM tb_users usr 
			WHERE id_user = :id_user
		", array(
			":id_user"=>$idUser
		));

		$data = $results[0];

		$data['name'] = utf8_encode($data['name']);

		$this->setValues($data);

	}

	public function save()
	{
		$sql = new Sql();

		$params = Array();

		if ($this->checkLoginExist($this->getemail()) === true) {
			$this->setError('This email is already registered!');
			header('Location: /register');
			exit;
		}

		$sql->query('
			INSERT INTO tb_users (email, password, name)
			VALUES (:email, :password, :name)
		', Array(
			':email' => $this->getemail(),
			':password' => User::getPasswordHash($this->getpassword()),
			':name' => $this->getname()
		));

		if ((int)$this->getid() === 0) {
			$result = $sql->select('
				SELECT *
				FROM tb_users
				WHERE id_user = LAST_INSERT_ID()
			');

			if (count($result) > 0)
				$this->setValues($result[0]);
		}
	}

	public function update()
	{

		$sql = new Sql();

		$params = Array();

		if ((int)$this->getid_user() > 0){
			$sql->query('
				UPDATE tb_users 
				SET email = :email, password = :password, name = :name
				WHERE id_user = :id_user
			', Array(
				':id_user' => $this->getid_user(),
				':email' => $this->getemail(),
				':password' => User::getPasswordHash($this->getpassword()),
				':name' => $this->getname()
			));
		}
	}

	public static function login($email, $password)
	{
		$sql = new Sql();

		$results = $sql->select("
			SELECT *
			FROM tb_users usr
			WHERE email = :email
		", array(
			":email"=>$email
		));

		if (count($results) === 0) {
			User::setError('Email is not registered!');
			header('Location: /login');
			exit;
		}

		$data = $results[0];

		if (USer::validatePassword($password, $data["password"]) === true) {

			$user = new User();

			$data['name'] = utf8_encode($data['name']);

			$user->setValues($data);

			$_SESSION[User::SESSION] = $user->getValues();

			return $user;

		} else {

			User::setError('Email or password is invalid.');
			header('Location: /login');
			exit;
		}

	}

	public static function checkLoginExist($login)
	{

		$sql = new Sql();

		$result = $sql->select("
			SELECT *
			FROM tb_users usr
			WHERE UPPER(TRIM(email)) = UPPER(TRIM(:email))
		", array(
			":email"=>$login
		));

		return (count($result) > 0);

	}

	public static function getPasswordHash($password)
	{
		//return password_hash($password, PASSWORD_DEFAULT, ['cost'=>12]);
		$cost = '08';
		$salt = User::randomPassword();//'Cf1f11ePArKlBJomM0F6aJ';

		return crypt($password, '$2a$' . $cost . '$' . $salt . '$');
	}

	private static function randomPassword(){
		$password = "";
		$charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

		for($i = 0; $i < 22; $i++) {
			$random_int = mt_rand();
			$password .= $charset[$random_int % strlen($charset)];
		}

		return $password;
	}

	private static function validatePassword($password, $hash)
	{
		return (crypt($password, $hash) === $hash);
	}

	public static function verifyLogin()
	{
		if (!User::checkLogin()) {

			header("Location: /login");
			exit;

		}
	}

	public static function checkLogin()
	{

		if (
			!isset($_SESSION[User::SESSION])
			||
			!$_SESSION[User::SESSION]
			||
			!isset($_SESSION[User::SESSION]["id_user"])
			||
			!(int)$_SESSION[User::SESSION]["id_user"] > 0
		) return false;
		
		return true;
	}

	public static function logout()
	{
		$_SESSION[User::SESSION] = NULL;
	}

	public static function setError($msg)
	{

		$_SESSION[User::ERROR] = $msg;

	}

	public static function getError()
	{

		$msg = (isset($_SESSION[User::ERROR]) && $_SESSION[User::ERROR]) ? $_SESSION[User::ERROR] : '';

		User::clearError();

		return $msg;

	}

	public static function clearError()
	{

		$_SESSION[User::ERROR] = NULL;

	}

	public static function forgotSent($email)
	{
		$sql = new Sql();

		$results = $sql->select("
			SELECT *
         	FROM tb_users
         	WHERE email = :email
         ", array(
			":email"=>$email
		));

		if (count($results) === 0) {
			
			User::setError('Email is not registered.');
			return false;

		} else {

			$data = $results[0];

			$result = $sql->select('
				INSERT INTO tb_userspasswordsrecoveries (iduser, ip)
		    	VALUES(:iduser, :ip)

			', Array(
				':iduser'=>$data['id_user'],
				':ip'=>$_SERVER["REMOTE_ADDR"]
			));

			$result = $sql->select('select LAST_INSERT_ID() idrecovery');

		    
		    $result = $result[0];

		    // hash
		    $key = hash('sha256', User::SECRET);

		    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		    $iv = substr(hash('sha256', User::SECIV), 0, 16);
		    
            $code = openssl_encrypt($result['idrecovery'], User::ENCRYPTMETHOD, $key, 0, $iv);
       	    $code = base64_encode($code);

	    	$link = "hodonto.com/forgot/reset/$code";

			$mailer = new Mailer(
				$data["email"], 
				$data["name"], 
				"Redefine password to hOdonto",
				"forgot", 
			array(
				"name"=>$data["name"],
				"link"=>$link
			));

			$mailer->send();

			return true;
		}
	}

	public static function validForgotDecrypt($code)
	{
		// hash
		$key = hash('sha256', User::SECRET);

		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$iv = substr(hash('sha256', User::SECIV), 0, 16);
		$idrecovery = openssl_decrypt(base64_decode($code), User::ENCRYPTMETHOD, $key, 0, $iv);

		$sql = new Sql();

		$results = $sql->select("
			SELECT *
			FROM tb_userspasswordsrecoveries r
			INNER JOIN tb_users u
			ON u.id_user = r.iduser
			WHERE r.id_recovery = :idrecovery
			AND dtrecovery IS NULL
			AND DATE_ADD(r.dtregister, INTERVAL 12 HOUR) >= NOW()
		", array(
			":idrecovery"=>$idrecovery
		));

		if (count($results) === 0) {
			throw new \Exception('An error occurred while trying to recover your password, this link may be expired, try requesting another password recovery request');
		}

		return $results[0];

	}

	public function setForgotUsed($idRecovery)
	{

		$sql = new Sql();

		$sql->query("
			UPDATE tb_userspasswordsrecoveries 
			SET dtrecovery = NOW() 
			WHERE id_recovery = :id_recovery
		", array(
			":id_recovery"=>$idRecovery
		));

	}

}

?>