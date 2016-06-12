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
			$db_con = new Sqlite3('../db/test_db.sqlite');
			$sql = "select * from users where username = '".$credentials['username']."' ";
			$user = $db_con->query($sql)->fetchArray();
			if ($user) {
				if (hash_equals(hash('sha256', $credentials['password']), $user['password'])) {
					return array('error'=>false, 'user'=>$user, 'message'=>'Login Successful!'); ;
				}else{
					return array('error'=>1, 'user'=>$credentials, 'message'=>'Username and password do not match.'); 
				}
			}else{
				return array('error'=>2, 'user'=>$credentials, 'message'=>'Username not found.'); 
			}

			// return json_encode(array('message'=>'success', 'error'=>false));

		}

		/**
	     * Simple static used to register user
		 * @param (array) $reginfo of user to be created
		 * @return (array) info on the success or failure of creation
		 */	

		public static function registerUser($regInfo)
		{
			$regInfo['password'] = hash('sha256',$regInfo['password']);
			$db_con = new Sqlite3('../db/test_db.sqlite');
			$id = (int)$db_con->querySingle('select * from users order by id DESC') + 1;
			$sql = <<<SQL
			insert into users values(
									$id, 
									'$regInfo[username]',
									'$regInfo[password]',
									'$regInfo[email]',
									'$regInfo[name]')
SQL;
			$newUser = $db_con->query($sql);
			return array('error'=>false, 'user'=>$regInfo, 'message'=>'Registration Complete.'); 
		}
	}
?>