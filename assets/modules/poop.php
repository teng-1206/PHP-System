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
        public function read_all_by_user_id ( $conn, Poop $object, $select_date = "Today" )
        {
            $where = "";
            switch ( $select_date ) 
            {
                case "This Week":
                    $where = "AND YEARWEEK( date, 1 ) = YEARWEEK( NOW(), 1 )";
                    break;
                case "This Month":
                    $where = "AND MONTH( date ) = MONTH( CURRENT_TIMESTAMP ) AND YEAR( date ) = YEAR( CURRENT_TIMESTAMP )";
                    break;
                case "This Year":
                    $where = "AND YEAR( date ) = YEAR( CURRENT_TIMESTAMP )";
                    break;
                case "Last 30 Days":
                    $where = "AND date >= DATE_SUB( CURDATE(), INTERVAL 1 MONTH ) AND date <= CURDATE()";
                    break;
                case "Last 90 Days":
                    $where = "AND date >= DATE_SUB( CURDATE(), INTERVAL 3 MONTH ) AND date <= CURDATE()";
                    break;
                case "All":
                    $where = "";
                    break;
                default:
                    $where = "AND date >= DATE_FORMAT( NOW(), '%Y-%m-%d 00:00:00' ) AND date < DATE_FORMAT( DATE_ADD( NOW(), INTERVAL 1 DAY ), '%Y-%m-%d 00:00:00' )";
                    break;
            }
            $sql = "SELECT * FROM poop
                    WHERE fk_user_id = ? AND soft_delete = 0 "  . $where . "
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

         /**
         * Converts an array of poop data into a Poop object.
         *
         * @param array $object The poop data array.
         *
         * @return Poop Returns a Poop object.
         */
        public function convert ( array $object )
        {
            $new_object = new Poop();
            $new_object->set( 'id', $object[ 'id' ] );
            $new_object->set( 'date', $object[ 'date' ] );
            $new_object->set( 'fk_user_id', $object[ 'fk_user_id' ] );
            $new_object->set( 'soft_delete', $object[ 'soft_delete' ] );
            $new_object->set( 'create_at', $object[ 'create_at' ] );
            $new_object->set( 'update_at', $object[ 'update_at' ] );
            return $new_object;
        }

        /**
         * Converts an array of objects using the convert method for each object
         *
         * @param array $array The array of objects to convert
         * @return array The array of converted objects
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