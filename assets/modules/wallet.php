<?php

    class Wallet
    {
        /**
         * @var int $id The wallet's id.
         * @var string $name The person's name.
         * @var string $status Default | Optional.
         * @var string $category Cash | Saving Account | Credit Card | Debit Card | eWallet.
         */
        private $id;
        private $name;
        private $status;
        private $category;
        private $amount;
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

    class Wallet_Controller
    {
        // public function read_all ( $conn )
        // {
        //     $sql = "SELECT * FROM wallet
        //             WHERE soft_delete = 0
        //             ORDER BY id DESC";
        //     $stmt = $conn->prepare( $sql );
        //     $result = $stmt->execute();
        //     $num_row = $stmt->rowCount();
        //     if ( $result ) 
        //     {
        //         $result = $stmt->fetchAll();
        //         return $result;
        //     }
        //     return null;
        // }

        public function read_all_by_user_id ( $conn, Wallet $object )
        {
            $sql = "SELECT * FROM wallet
                    WHERE fk_user_id = ? AND soft_delete = 0
                    ORDER BY name ASC";
            $stmt = $conn->prepare( $sql );
            $result = $stmt->execute( [
                $object->get( 'fk_user_id' ),
            ] );
            $num_row = $stmt->rowCount();
            if ( $result ) 
            {
                $result = $stmt->fetchAll();
                // $result = $this->convert_all( $result );
                return $result;
            }
            return null;
        }

        public function read_default_wallet ( $conn, $user_id = 0 )
        {
            $sql = "SELECT * FROM wallet
                    WHERE fk_user_id = ? AND status = 'Default' AND soft_delete = 0
                    ORDER BY id DESC";
            $stmt = $conn->prepare( $sql );
            $result = $stmt->execute( [
                $user_id,
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

        public function read ( $conn, Wallet $object )
        {
            $sql = "SELECT * FROM wallet
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

        public function create ( $conn, Wallet $object )
        {
            $sql = "INSERT INTO wallet( name, status, category, amount, fk_user_id )
                    VALUES( ?, ?, ?, ?, ? )";
            $stmt = $conn->prepare( $sql );
            $result = $stmt->execute( [
                $object->get( 'name' ),
                $object->get( 'status' ),
                $object->get( 'category' ),
                $object->get( 'amount' ),
                $object->get( 'fk_user_id' ),
            ] );
            $last_id = $result ? $conn->lastInsertId() : null;
            return $last_id;
        }

        public function update ( $conn, Wallet $object )
        {
            $sql = "UPDATE wallet
                    SET name = ?, status = ?, category = ?, amount = ?, update_at = CURRENT_TIMESTAMP
                    WHERE id = ?";
            $stmt = $conn->prepare( $sql );
            $result = $stmt->execute( [
                $object->get( 'name' ),
                $object->get( 'status' ),
                $object->get( 'category' ),
                $object->get( 'amount' ),
                $object->get( 'id' ),
            ] );
            return $result ? true : false;
        }

        public function delete ( $conn, Wallet $object )
        {
            $sql = "UPDATE wallet
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
            $new_object = new Wallet();
            $new_object->set( 'id', $object[ 'id' ] );
            $new_object->set( 'name', $object[ 'name' ] );
            $new_object->set( 'status', $object[ 'status' ] );
            $new_object->set( 'category', $object[ 'category' ] );
            $new_object->set( 'amount', $object[ 'amount' ] );
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