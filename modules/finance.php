<?php

    class Finance
    {
        private $id;
        private $title;
        private $date;
        private $amount;
        private $fk_category_id;
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
                case 'date':
                    return $this->date;
                    break;
                case 'amount':
                    return $this->amount;
                    break;
                case 'fk_category_id':
                    return $this->fk_category_id;
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
                case 'date':
                    $this->date = $value;
                    break;
                case 'amount':
                    $this->amount = $value;
                    break;
                case 'fk_category_id':
                    $this->fk_category_id = $value;
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

    class Finance_Data_Connector
    {
        public function read_all ( $conn )
        {
            $sql = "SELECT * FROM finance
                    ORDER BY id DESC";
            $stmt = $conn->prepare( $sql );
            $result = $stmt->execute();
            $num_row = $stmt->rowCount();
            if ( $result && $num_row > 0 ) 
            {
                $result = $stmt->fetchAll();
                $result = $this->convert_all( $result );
                return $result;
            }
            return null;
        }

        public function read ( $conn, Finance $object )
        {
            $sql = "SELECT * FROM finance
                    WHERE id = ?";
            $stmt = $conn->prepare( $sql );
            $result = $stmt->execute( [
                $object->get( 'id' ),
            ] );
            $num_row = $stmt->rowCount();
            if ( $result && $num_row == 1 )
            {
                $result = $stmt->fetch();
                $new_object = $this->convert( $result );
                return $new_object;
            }
            return null;
        }

        public function create ( $conn, Finance $object )
        {
            $sql = "INSERT INTO finance( title, date, amount, fk_category_id )
                    VALUES( ?, ?, ?, ? )";
            $stmt = $conn->prepare( $sql );
            $result = $stmt->execute( [
                $object->get( 'title' ),
                $object->get( 'date' ),
                $object->get( 'amount' ),
                $object->get( 'fk_category_id' ),
            ] );
            $last_id = $result ? $conn->lastInsertId() : null;
            return $last_id;
        }

        public function update ( $conn, Finance $object )
        {
            $sql = "UPDATE finance
                    SET title = ?, date = ?, amount = ?, fk_category_id = ?, update_at = CURRENT_TIMESTAMP
                    WHERE id = ?";
            $stmt = $conn->prepare( $sql );
            $result = $stmt->execute( [
                $object->get( 'title' ),
                $object->get( 'date' ),
                $object->get( 'amount' ),
                $object->get( 'fk_category_id' ),
                $object->get( 'id' ),
            ] );
            return $result ? true : false;
        }

        public function delete ( $conn, Finance $object )
        {
            $sql = "UPDATE finance
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
            $new_object = new Finance();
            $new_object->set( 'id', $object[ 'id' ] );
            $new_object->set( 'title', $object[ 'title' ] );
            $new_object->set( 'date', $object[ 'date' ] );
            $new_object->set( 'amount', $object[ 'amount' ] );
            $new_object->set( 'fk_category_id', $object[ 'fk_category_id' ] );
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