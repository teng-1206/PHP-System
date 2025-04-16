<?php

    class Task_Project
    {
        private $id;
        private $title;
        private $fk_user_id;
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

    class Task_Project_Controller
    {
        public function read_all_by_user_id ( $conn, Task_Project $object )
        {
            $sql = "SELECT * FROM task_project
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
        
        public function read ( $conn, Task_Project $object )
        {
            $sql = "SELECT * FROM task_project
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

        public function create ( $conn, Task_Project $object )
        {
            $sql = "INSERT INTO task_project( title, fk_user_id )
                    VALUES( ?, ? )";
            $stmt = $conn->prepare( $sql );
            $result = $stmt->execute( [
                $object->get( 'title' ),
                $object->get( 'fk_user_id' ),
            ] );
            $last_id = $result ? $conn->lastInsertId() : null;
            return $last_id;
        }

        public function update ( $conn, Task_Project $object )
        {
            $sql = "UPDATE task_project
                    SET title = ?, update_at = CURRENT_TIMESTAMP
                    WHERE id = ?";
            $stmt = $conn->prepare( $sql );
            $result = $stmt->execute( [
                $object->get( 'title' ),
                $object->get( 'id' ),
            ] );
            return $result ? true : false;
        }

        public function delete ( $conn, Task_Project $object )
        {
            $sql = "UPDATE task_project
                    SET soft_delete = ?, update_at = CURRENT_TIMESTAMP
                    WHERE id = ?";
            $stmt = $conn->prepare( $sql );
            $result = $stmt->execute( [
                1,
                $object->get( 'id' ),
            ] );
            return $result ? true : false;
        }

        /**
         * Convert Method
         */
        public function convert ( array $object )
        {
            $new_object = new Task_Project();
            $new_object->set( 'id', $object[ 'id' ] );
            $new_object->set( 'title', $object[ 'title' ] );
            $new_object->set( 'fk_user_id', $object[ 'fk_user_id' ] );
            $new_object->set( 'soft_delete', $object[ 'soft_delete' ] );
            $new_object->set( 'create_at', $object[ 'create_at' ] );
            $new_object->set( 'update_at', $object[ 'update_at' ] );
            return $new_object;
        }

        /**
         * Convert All Method
         */
        public function convert_all ( array $array )
        {
            $new_array = array();
            foreach ( $array as $object )
            {
                $new_object = $this->convert( $object );
                array_push( $new_array, $new_object );
            }
            return $new_array;
        }
    }

?>