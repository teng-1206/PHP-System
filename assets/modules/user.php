<?php
class User {
    private $id;
    private $username;
    private $password;
    private $email;
    private $verify;
    private $code;
    private $verify_timestamp;
    private $twofa;
    private $soft_delete;
    private $create_at;
    private $update_at;

    /**
     * Get Method
     */
    public function get(string $attribute) {
        return property_exists($this, $attribute) ? $this->$attribute : null;
    }

    /**
     * Set Method
     */
    public function set(string $attribute, $value) {
        if (property_exists($this, $attribute)) {
            $this->$attribute = $value;
        }
    }
}

class User_Controller {
    public function login($conn, User $object) {
        $sql = "SELECT * FROM user
                WHERE username = ? AND password = ? AND verify = 1 AND soft_delete = 0";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([$object->get('username'), $object->get('password')]);
        $num_row = $stmt->rowCount();
        if($result && $num_row == 1) {
            $result = $stmt->fetch();
            return $result['id'];
        }
        return 0;
    }

    public function check_username($conn, User $object) {
        $sql = "SELECT * FROM user
                WHERE username = ? AND soft_delete = 0";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([$object->get('username')]);
        $num_row = $stmt->rowCount();
        if($result && $num_row == 1) {
            $result = $stmt->fetch();
            return $result['id'];
        }
        return 0;
    }

    public function verify_code($conn, User $object) {
        $sql = "UPDATE user
                SET verify = 1
                WHERE email = ? AND code = ?  AND verify_timestamp > NOW() AND soft_delete = 0";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([
            $object->get('email'),
            $object->get('code'),
        ]);
        if ($result && $stmt->rowCount() > 0) {
            return $stmt->rowCount();
        }
        return 0;
    }

    public function resend_code($conn, User $object) {
        $sql = "SELECT * FROM user
                WHERE email = ? AND code = ? AND soft_delete = 0";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([
            $object->get('email'),
            $object->get('code'),
        ]);
        $num_row = $stmt->rowCount();
                error_log($num_row);

        if($result && $num_row == 1) {
            $result = $stmt->fetch();
            return $stmt->rowCount();
        }
        return 0;
    }
    
    public function read_all($conn) {
        $sql = "SELECT * FROM user WHERE soft_delete = 0
                ORDER BY id DESC";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute();
        $num_row = $stmt->rowCount();
        if($result) {
            $result = $stmt->fetchAll();
            return $result;
        }
        return null;
    }
    
    public function read($conn, User $object) {
        $sql = "SELECT * FROM user
                WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([$object->get('id')]);
        $num_row = $stmt->rowCount();
        if($result && $num_row == 1) {
            $result = $stmt->fetch();
            $new_object = $this->convert($result);
            return $new_object;
        }
        return null;
    }

    public function read_by_email($conn, User $object) {
        $sql = "SELECT * FROM user
                WHERE email = ? AND soft_delete = 0";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([$object->get('email')]);
        $num_row = $stmt->rowCount();
        if($result && $num_row == 1) {
            $result = $stmt->fetch();
            $new_object = $this->convert($result);
            return $new_object;
        }
        return null;
    }
    
    public function create($conn, User $object) {
        $sql = "INSERT INTO user(username, password, email, code, verify_timestamp)
                VALUES(?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([
            $object->get('username'),
            $object->get('password'),
            $object->get('email'),
            $object->get('code'),
            $object->get('verify_timestamp'),
        ]);
        $last_id = $result ? $conn->lastInsertId() : null;
        return $last_id;
    }
    
    public function update($conn, User $object)
    {
        $sql = "UPDATE user
                SET username = ?, password = ?, email = ?, update_at = CURRENT_TIMESTAMP, verify = ?, code = ?, verify_timestamp = ?, twofa = ?
                WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([
            $object->get('username'),
            $object->get('password'),
            $object->get('email'),
            $object->get('verify'),
            $object->get('code'),
            $object->get('verify_timestamp'),
            $object->get('twofa'),
            $object->get('id')]);
        return $result ? true : false;
    }

    public function delete($conn, User $object)
    {
        $sql = "UPDATE user
                SET soft_delete = ?, update_at = CURRENT_TIMESTAMP
                WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([1, $object->get('id')]);
        return $result ? true : false;
    }

    public function convert(array $object)
    {
        $new_object = new User();
        $new_object->set('id', $object['id']);
        $new_object->set('username', $object['username']);
        $new_object->set('password', $object['password']);
        $new_object->set('email', $object['email']);
        $new_object->set('verify', $object['verify']);
        $new_object->set('code', $object['code']);
        $new_object->set('verify_timestamp', $object['verify_timestamp']);
        $new_object->set('twofa', $object['twofa']);
        $new_object->set('soft_delete', $object['soft_delete']);
        $new_object->set('create_at', $object['create_at']);
        $new_object->set('update_at', $object['update_at']);
        return $new_object;
    }

    public function convert_all(array $array)
    {
        $new_array = array();
        foreach ($array as $object) {
            $new_object = $this->convert($object);
            array_push($new_array, $new_object);
        }
        return $new_array;
    }

}