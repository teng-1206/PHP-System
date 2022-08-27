<?php

    class Finance_Category
    {
        private $id;
        private $category;
        private $color_code;
        private $background_color_code;
        private $icon_code;
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
                case 'category':
                    return $this->category;
                    break;
                case 'color_code':
                    return $this->color_code;
                    break;
                case 'background_color_code':
                    return $this->background_color_code;
                    break;
                case 'icon_code':
                    return $this->icon_code;
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
                case 'category':
                    $this->category = $value;
                    break;
                case 'color_code':
                    $this->color_code = $value;
                    break;
                case 'background_color_code':
                    $this->background_color_code = $value;
                    break;
                case 'icon_code':
                    $this->icon_code = $value;
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

    class Finance_Category_Data_Connector
    {
        public function read_all ( $conn )
        {
            $sql = "SELECT * FROM finance_category
                    WHERE soft_delete = 0
                    ORDER BY id DESC";
            $stmt = $conn->prepare( $sql );
            $result = $stmt->execute();
            $num_row = $stmt->rowCount();
            if ( $result && $num_row > 0 ) 
            {
                $result = $stmt->fetchAll();
                return $result;
            }
            return null;
        }

        public function read_all_by_user_id ( $conn, Finance_Category $object )
        {
            $sql = "SELECT * FROM finance_category
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

        public function read ( $conn, Finance_Category $object )
        {
            $sql = "SELECT * FROM finance_category
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

        public function create ( $conn, Finance_Category $object )
        {
            $sql = "INSERT INTO finance_category( category, color_code, background_color_code, icon_code, fk_user_id )
                    VALUES( ?, ?, ?, ?, ? )";
            $stmt = $conn->prepare( $sql );
            $result = $stmt->execute( [
                $object->get( 'category' ),
                $object->get( 'color_code' ),
                $object->get( 'background_color_code' ),
                $object->get( 'icon_code' ),
                $object->get( 'fk_user_id' ),
            ] );
            $last_id = $result ? $conn->lastInsertId() : null;
            return $last_id;
        }

        public function update ( $conn, Finance_Category $object )
        {
            $sql = "UPDATE finance_category
                    SET category = ?, color_code = ?, background_color_code = ?, icon_code = ?, update_at = CURRENT_TIMESTAMP
                    WHERE id = ?";
            $stmt = $conn->prepare( $sql );
            $result = $stmt->execute( [
                $object->get( 'category' ),
                $object->get( 'color_code' ),
                $object->get( 'background_color_code' ),
                $object->get( 'icon_code' ),
                $object->get( 'id' ),
            ] );
            return $result ? true : false;
        }

        public function delete ( $conn, Finance_Category $object )
        {
            $sql = "UPDATE finance_category
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
            $new_object = new Finance_Category();
            $new_object->set( 'id', $object[ 'id' ] );
            $new_object->set( 'category', $object[ 'category' ] );
            $new_object->set( 'color_code', $object[ 'color_code' ] );
            $new_object->set( 'background_color_code', $object[ 'background_color_code' ] );
            $new_object->set( 'icon_code', $object[ 'icon_code' ] );
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