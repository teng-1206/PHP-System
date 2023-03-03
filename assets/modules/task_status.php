<?php

    class Task_Status
    {
        private $id;
        private $title;
        private $fk_task_project_id;
        private $fk_order_id;
        private $soft_delete;
        private $create_at;
        private $update_at;
        
        /**
         * Get Method
         */
        public function get ( string $attribute )
        {
            switch ( $attribute ) 
            {
                case 'id':
                    return $this->id;
                    break;
                case 'title':
                    return $this->title;
                    break;
                case 'fk_task_project_id':
                    return $this->fk_task_project_id;
                    break;
                case 'fk_order_id':
                    return $this->fk_order_id;
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

        /**
         * Set Method
         */
        public function set ( string $attribute, $value )
        {
            switch ( $attribute ) 
            {
                case 'id':
                    $this->id = $value;
                    break;
                case 'title':
                    $this->title = $value;
                    break;
                case 'fk_task_project_id':
                    $this->fk_task_project_id = $value;
                    break;
                case 'fk_order_id':
                    $this->fk_order_id = $value;
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

    class Task_Status_Controller
    {
        /**
         * Read all the task status for one project by user
         */
        public function read_all_by_task_project_id ( $conn, Task_Status $object )
        {
            $sql = "SELECT * FROM task_status
                    WHERE fk_task_project_id = ? AND soft_delete = 0
                    ORDER BY id DESC";
            $stmt = $conn->prepare( $sql );
            $result = $stmt->execute( [
                $object->get( 'fk_task_project_id' ),
            ] );
            $num_row = $stmt->rowCount();
            if ( $result && $num_row > 0 ) 
            {
                $result = $stmt->fetchAll();
                return $result;
            }
            return null;
        }

        public function read ( $conn, Task_Status $object )
        {
            $sql = "SELECT * FROM task_status
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

        public function create ( $conn, Task_Status $object )
        {
            $sql = "INSERT INTO task_status( title, fk_task_project_id, fk_order_id )
                    VALUES( ?, ?, ? )";
            $stmt = $conn->prepare( $sql );
            $result = $stmt->execute( [
                $object->get( 'title' ),
                $object->get( 'fk_task_project_id' ),
                $object->get( 'fk_order_id' ),
            ] );
            $last_id = $result ? $conn->lastInsertId() : null;
            return $last_id;
        }

        public function update ( $conn, Task_Status $object )
        {
            $sql = "UPDATE task_status
                    SET title = ?, fk_task_project_id = ?, fk_order_id = ?, update_at = CURRENT_TIMESTAMP
                    WHERE id = ?";
            $stmt = $conn->prepare( $sql );
            $result = $stmt->execute( [
                $object->get( 'title' ),
                $object->get( 'fk_task_project_id' ),
                $object->get( 'fk_order_id' ),
                $object->get( 'id' ),
            ] );
            return $result ? true : false;
        }

        public function delete ( $conn, Task_Status $object )
        {
            $sql = "UPDATE task_status
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
            $new_object = new Task_Status();
            $new_object->set( 'id', $object[ 'id' ] );
            $new_object->set( 'title', $object[ 'title' ] );
            $new_object->set( 'fk_task_project_id', $object[ 'fk_task_project_id' ] );
            $new_object->set( 'fk_order_id', $object[ 'fk_order_id' ] );
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