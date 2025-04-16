<?php

    class Task
    {
        private $id;
        private $title;
        private $description;
        private $due_date;
        private $fk_task_status_id;
        private $fk_order_id;
        private $fk_priority_id;
        private $fk_repeat_period_id;
        private $fk_reminder_id;
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

    class Task_Controller
    {
        public function read_all_by_task_status_id ( $conn, Task $object )
        {
            $sql = "SELECT * FROM task
                    WHERE fk_task_status_id = ? AND soft_delete = 0
                    ORDER BY id DESC";
            $stmt = $conn->prepare( $sql );
            $result = $stmt->execute( [
                $object->get( 'fk_task_status_id' ),
            ] );
            $num_row = $stmt->rowCount();
            if ( $result && $num_row > 0 ) 
            {
                $result = $stmt->fetchAll();
                return $result;
            }
            return null;
        }

        public function read ( $conn, Task $object )
        {
            $sql = "SELECT * FROM task
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

        public function create ( $conn, Task $object )
        {
            $sql = "INSERT INTO task( title, description, due_date, fk_task_status_id, fk_order_id, fk_priority_id, fk_repeat_period_id, fk_reminder_id )
                    VALUES( ?, ?, ?, ?, ?, ?, ?, ? )";
            $stmt = $conn->prepare( $sql );
            $result = $stmt->execute( [
                $object->get( 'title' ),
                $object->get( 'description' ),
                $object->get( 'due_date' ),
                $object->get( 'fk_task_status_id' ),
                $object->get( 'fk_order_id' ),
                $object->get( 'fk_priority_id' ),
                $object->get( 'fk_repeat_period_id' ),
                $object->get( 'fk_reminder_id' ),
            ] );
            $last_id = $result ? $conn->lastInsertId() : null;
            return $last_id;
        }

        public function update ( $conn, Task $object )
        {
            $sql = "UPDATE task
                    SET title = ?, description = ?, due_date = ?, fk_task_status_id = ?, fk_order_id = ?, fk_priority_id = ?, fk_repeat_period_id = ?, fk_reminder_id = ?, update_at = CURRENT_TIMESTAMP
                    WHERE id = ?";
            $stmt = $conn->prepare( $sql );
            $result = $stmt->execute( [
                $object->get( 'title' ),
                $object->get( 'description' ),
                $object->get( 'due_date' ),
                $object->get( 'fk_task_status_id' ),
                $object->get( 'fk_order_id' ),
                $object->get( 'fk_priority_id' ),
                $object->get( 'fk_repeat_period_id' ),
                $object->get( 'fk_reminder_id' ),
                $object->get( 'id' ),
            ] );
            return $result ? true : false;
        }

        public function delete ( $conn, Task $object )
        {
            $sql = "UPDATE task
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
            $new_object = new Task();
            $new_object->set( 'id', $object[ 'id' ] );
            $new_object->set( 'title', $object[ 'title' ] );
            $new_object->set( 'description', $object[ 'description' ] );
            $new_object->set( 'due_date', $object[ 'due_date' ] );
            $new_object->set( 'fk_task_status_id', $object[ 'fk_task_status_id' ] );
            $new_object->set( 'fk_order_id', $object[ 'fk_order_id' ] );
            $new_object->set( 'fk_priority_id', $object[ 'fk_priority_id' ] );
            $new_object->set( 'fk_repeat_period_id', $object[ 'fk_repeat_period_id' ] );
            $new_object->set( 'fk_reminder_id', $object[ 'fk_reminder_id' ] );
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