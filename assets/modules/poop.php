<?php

    class Poop
    {
        private $id;
        private $date;
        private $fk_user_id;
        private $soft_delete;
        private $create_at;
        private $update_at;

        public function get(string $attribute)
        {
            switch ($attribute) {
                case 'id':
                    return $this->id;
                    break;
                case 'date':
                    return $this->date;
                    break;
                case 'fk_user_id':
                    return $this->fk_user_id;
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

        public function set(string $attribute, $value)
        {
            switch ($attribute) {
                case 'id':
                    $this->id = $value;
                    break;
                case 'date':
                    $this->date = $value;
                    break;
                case 'fk_user_id':
                    $this->fk_user_id = $value;
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

    class Poop_Controller 
    {
        public function read_all_by_user_id ( $conn, Poop $object )
        {
            $sql = "SELECT * FROM poop
                    WHERE fk_user_id = ? AND soft_delete = 0
                    ORDER BY id DESC";
            $stmt = $conn->prepare( $sql );
            $result = $stmt->execute( [
                $object->get( 'fk_user_id' ),
            ] );
            $num_row = $stmt->rowCount();
            if ( $result && $num_row > 0 ) 
            {
                $result = $stmt->fetchAll();
                return $result;
            }
            return null;
        }

        public function read( $conn, Poop $object ) {
            $sql = "SELECT * FROM poop
                    WHERE id = ?";
            $stmt = $conn->prepare( $sql );
            $result = $stmt->execute( [
                $object->get( 'id' ),
            ] );
            $num_row = $stmt->rowCount();
            if ( $result && $num_row == 1 )
            {
                $result = $stmt->fetch();
                // $result = $this->convert( $result );
                return $result;
            }
            return null;
        }

        public function create( $conn, Poop $object ) {
            $sql = "INSERT INTO poop( date, fk_user_id )
                    VALUES( ?, ? )";
            $stmt = $conn->prepare( $sql );
            $result = $stmt->execute( [
                $object->get( 'date' ),
                $object->get( 'fk_user_id' ),
            ] );
            $last_id = $result ? $conn->lastInsertId() : null;
            return $last_id;
        }

        public function update( $conn, Poop $object) {
            $sql = "UPDATE poop
                    SET date = ?,  update_at = CURRENT_TIMESTAMP
                    WHERE id = ?";
            $stmt = $conn->prepare( $sql );
            $result = $stmt->execute( [
                $object->get( 'date' ),
                $object->get( 'id' ),
            ] );
            return $result ? true : false;
        }

        public function delete( $conn, Poop $object ) {
            $sql = "UPDATE poop SET soft_delete = 1
                    WHERE id = ?";
            $stmt = $conn->prepare( $sql );
            $result = $stmt->execute( [
                $object->get( 'id' ),
            ] );
            return $result;
        }

    }


?>