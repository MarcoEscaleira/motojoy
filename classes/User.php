<?php
/**
 * Class de users
 */
class User
{
    private $_db,
            $_data,
            $_sessionsName,
            $_cookiesName,
            $_isLoggedIn;

    public function __construct($user = null) {
        $this->_db = Db::getInstance();

        $this->_sessionsName = Config::get('session/session_name');
        $this->_cookiesName = Config::get('remember/cookie_name');

        if (!$user) {
           if (Session::exists($this->_sessionsName)) {
              $user = Session::get($this->_sessionsName);

              if ($this->find($user)) {
                 $this->_isLoggedIn = true;
              } else {
                 //process logout
              }
           }
        } else {
           $this->find($user);
        }
    }

    public function create($fields = array()) {
        if (!$this->_db->insert('users', $fields)) {
            throw new Exception("Houve um problema na criação da conta.");
        }
    }

    public function find($user = null) {
        if ($user) {
            $field = (is_numeric($user)) ? 'user_id' : 'user_email';
            $data = $this->_db->get('users', array($field, '=', $user));

            if ($data->count()) {
                $this->_data = $data->first();
                return true;
            }
        }
    }

    public function login($email = null, $password = null, $remember = false) {

        if (!$email && !$password && $this->exists()) {
            Session::put($this->_sessionsName, $this->data()->user_id);
        } else {
            $user = $this->find($email);

            if ($user) {
                if (($this->data()->user_password == Hash::make($password, $this->data()->user_salt)) && $this->data()->user_confirmed == 1) { //Passwords coicidem
                    Session::put($this->_sessionsName, $this->data()->user_id);

                    if ($remember) {
                        $hash = Hash::unique();
                        $hashCheck = $this->_db->get('sessions', array('user_id', '=', $this->data()->user_id));

                        if (!$hashCheck->count()) {
                            $this->_db->insert('sessions', array(
                                'user_id' => $this->data()->user_id,
                                'hash' => $hash
                            ));
                        } else {
                            $hash = $hashCheck->first()->hash;
                        }

                        Cookie::put($this->_cookiesName, $hash, Config::get('remember/cookie_expiry'));
                    }

                    return true;
                }
            }
        }

        return false;
    }

    public function update($fields = array(), $id = null) {

        if (!$id && $this->isLoggedIn()) {
            $id = $this->data()->user_id;
        }

        if (!$this->_db->update('users', $id, 'user_id',$fields)) {
            throw new Exception("Houve problemas na atualização dos dados");
        }

    }

    public function hasPermission($key) {
        $group = $this->_db->get('groups', array('group_id', '=', $this->data()->group_id));

        if ($group->count()) {
            $permissions = json_decode($group->first()->group_permissions, true);

            if (!empty($permissions[$key])) {
                return true;
            }
        }
        return false;
    }

    public function exists() {
        return (!empty($this->_data)) ? true : false;
    }

    public function logout() {

        $this->_db->delete('sessions', array('user_id', '=', $this->data()->user_id));

         Session::delete($this->_sessionsName);
         Cookie::delete($this->_cookiesName);
    }

    public function data() {
        return $this->_data;
    }

    public function isLoggedIn() {
      return $this->_isLoggedIn;
   }
}

?>
