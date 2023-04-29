<?php
class User {
    private $id;
    private $username;
    private $password;
    private $email;
    private $soft_delete;
    private $create_at;
    private $update_at;
    
    public function get(string $attribute) {
        switch($attribute) {
            case 'id':
                return $this->id;
                break;
            case 'username':
                return $this->username;
                break;
            case 'password':
                return $this->password;
                break;
            case 'email':
                return $this->email;
                break;
            case 'soft_delete':
                return $this->soft_delete;
                break;
            case 'create_at':
                return $this->create_at;
                break;
            case 'update_at':
                return $this->update_at;
                break;
        }
    }
    
    public function set(string $attribute, $value) {
        switch($attribute) {
            case 'id':
                $this->id = $value;
                break;
            case 'username':
                $this->username = $value;
                break;
            case 'password':
                $this->password = $value;
                break;
            case 'email':
                $this->email = $value;
                break;
            case 'soft_delete':
                $this->soft_delete = $value;
                break;
            case 'create_at':
                $this->create_at = $value;
                break;
            case 'update_at':
                $this->update_at = $value;
                break;
        }
    }
}

class User_Controller {
    public function login($conn, User $object) {
        $sql = "SELECT * FROM user
                WHERE username = ? AND password = ? AND soft_delete = 0";
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
    
    public function create($conn, User $object) {
        $sql = "INSERT INTO user(username, password, email)
                VALUES(?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([$object->get('username'), $object->get('password'), $object->get('email')]);
        $last_id = $result ? $conn->lastInsertId() : null;
        return $last_id;
    }
    
    public function update($conn, User $object)
    {
        $sql = "UPDATE user
                SET username = ?, password = ?, email = ?, update_at = CURRENT_TIMESTAMP
                WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([$object->get('username'), $object->get('password'), $object->get('email'), $object->get('id')]);
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