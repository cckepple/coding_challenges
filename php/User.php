<?php
	class User
	{

		/**
	     * Simple static used to attempt login
		 * @param (array) $credentails of user to authenticate
		 * @return (array) info on the success or failure of auth
		 */		

		public static function attemptLogin($credentials)
		{
			if (self::validateInput($credentials)) {
				$db_con = new Sqlite3('../db/test_db.sqlite');
				$safeInput = $db_con->escapeString($credentials['username']);
				$sql = "select * from users where username = '$safeInput';";
				$user = $db_con->query($sql)->fetchArray();

				if ($user) {
					if (hash_equals(hash('sha256', $credentials['password']), $user['password'])) {
						date_default_timezone_set('UTC');
						$now = date('Y-m-d H:i:s');
						$recordId = $user['ID'];
						$sql = "update users set last_login = '$now' where id = $recordId;";
						$db_con->query($sql);
						$db_con->close();
						return array('error'=>false, 'user'=>$user, 'message'=>'Login Successful!','stmt'=>$sql);
					}else{
						$db_con->close();
						return array('error'=>1, 'user'=>$credentials, 'message'=>'Username and password do not match.'); 
					}
				}else{
					$db_con->close();
					return array('error'=>2, 'user'=>$credentials, 'message'=>'Username not found.'); 
				}
			}else{
				return array('error'=>1, 'user'=>$credentials, 'message'=>'User input contains errors.'); 
			}
		}

		/**
	     * Simple static used to register user
		 * @param (array) $reginfo of user to be created
		 * @return (array) info on the success or failure of creation
		 */	

		public static function registerUser($regInfo)
		{

			if(self::validateInput($regInfo)){
				if (!self::usernameTaken($regInfo['username'])) {
					$regInfo['password'] = hash('sha256',$regInfo['password']);

					$db_con = new Sqlite3('../db/test_db.sqlite');
					$id = (int)$db_con->querySingle('select * from users order by id DESC') + 1;
					
					$safeId = $db_con->escapeString($id);
					$safeUn = $db_con->escapeString($regInfo['username']);
					$safePw = $db_con->escapeString($regInfo['password']);
					$safeEm = $db_con->escapeString($regInfo['email']);
					$safeNm = $db_con->escapeString($regInfo['name']);

					date_default_timezone_set('UTC');
					$now = date('Y-m-d H:i:s');

					$sql = "insert into users values($safeId, '$safeUn', '$safePw', '$safeEm', '$safeNm', '$now', '$now');";
					$newUser = $db_con->query($sql);

					$safeInput = $db_con->escapeString($regInfo['username']);
					$sql = "select * from users where username = '$safeInput';";
					$user = $db_con->query($sql)->fetchArray();
					$db_con->close();

					return array('error'=>false, 'user'=>$user, 'message'=>'Registration Complete.','created_at'=>'derp'); 
				}else{
					return array('error'=>true, 'user'=>$regInfo, 'message'=>'Usename already taken.','created_at'=>'derp'); 
				}

			}else{
				return array('error'=>true, 'user'=>$regInfo, 'message'=>'User input contains errors.','created_at'=>'derp'); 
			}
		}

		private static function validateInput($input)
		{
			if (isset($input['username'])) {
				$username = $input['username'];
				if ($username == '' || $username == null) {
					return false;
				}else{
					if (strlen($username) > 24) {
						return false;
					}

					if (!preg_match('/^[a-zA-Z0-9]+$/', $username)) {
						return false;
					}
				}
			}else{
				return false;
			}

			if (isset($input['password'])) {
				$password = $input['password'];
				if ($password == '' || $password == null) {
					return false;
				}else{
					if (strlen($password) > 255) {
						return false;
					}

					if (preg_match('/\s/', $password)) {
						return false;
					}
				}
			}else{
				return false;
			}


			if (isset($input['email'])) {
				$email = $input['email'];
				if ($email == '' || $email == null) {
					return 'no email';
					return false;
				}else{
					if (strlen($email) >= 255) {
						return 'long email';
						return false;
					}

					if (preg_match('/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $email)) {
						return 'bad email';
						return false;
					}
				}
			}

			if (isset($input['name'])) {
				$name = $input['name'];
				if ($name == '' || $name == null) {
					return 'no name';
					return false;
				}else{
					if (strlen($name) >= 255) {
						return 'long name';
						return false;
					}
					if (preg_match('/^[a-zA-Z0-9 .,-]+$/', $name)) {
						return 'bad name';
						return false;
					}
				}
			}

			return true;
		}

		private static function usernameTaken($username)
		{
			$db_con = $db_con = new Sqlite3('../db/test_db.sqlite');
			$safeInput = $db_con->escapeString($username);
			$sql = "select * from users where username = '$safeInput';";
			$user = $db_con->query($sql)->fetchArray();
			$db_con->close();

			return $user;
		}	
	}
?>