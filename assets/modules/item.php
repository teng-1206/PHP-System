<?php

class Item
{
    private $id;
    private $name;
    private $description;
    private $status;
    private $price;
    private $purchase_date;
    private $fk_user_id;
    private $soft_delete;
    private $create_at;
    private $update_at;

    /**
     * Get Method
     * 
     * Returns the value of the specified attribute
     * 
     * @param string $attribute The name of the attribute to retrieve
     * @return mixed The value of the specified attribute
     */
    public function get( string $attribute )
    {
        switch ($attribute) {
            case 'id':
                return $this->id;
                break;
            case 'name':
                return $this->name;
                break;
            case 'description':
                return $this->description;
                break;
            case 'status':
                return $this->status;
                break;
            case 'price':
                return $this->price;
                break;
            case 'purchase_date':
                return $this->purchase_date;
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
     * 
     * Sets the value of the specified attribute
     * 
     * @param string $attribute The name of the attribute to set
     * @param mixed $value The value to set the attribute to
     */
    public function set(string $attribute, $value)
    {
        switch ($attribute) {
            case 'id':
                $this->id = $value;
                break;
            case 'name':
                $this->name = $value;
                break;
            case 'description':
                $this->description = $value;
                break;
            case 'status':
                $this->status = $value;
                break;
            case 'price':
                $this->price = $value;
                break;
            case 'purchase_date':
                $this->purchase_date = $value;
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

class Item_Controller 
{
    /**
     * Retrieve all non-deleted items from the "item" table in the database,
     * ordered by descending ID. Returns an array of all items retrieved, or
     * null if no items were found.
     *
     * @param PDO $conn An active PDO database connection object
     *
     * @return array|null An array of all retrieved items or null if no items were found
     */
    public function read_all( $conn ) {
        $sql = "SELECT * FROM item 
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

    public function read_all_by_user_id ( $conn, Item $object )
    {
        $sql = "SELECT * FROM item
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

    public function read( $conn, Item $object ) {
        $sql = "SELECT * FROM item
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

    public function create( $conn, Item $object ) {
        $sql = "INSERT INTO item( name, description, status, price, purchase_date, fk_user_id )
                VALUES( ?, ?, ?, ?, ?, ? )";
        $stmt = $conn->prepare( $sql );
        $result = $stmt->execute( [
            $object->get( 'name' ),
            $object->get( 'description' ),
            $object->get( 'status' ),
            $object->get( 'price' ),
            $object->get( 'purchase_date' ),
            $object->get( 'fk_user_id' ),
        ] );
        $last_id = $result ? $conn->lastInsertId() : null;
        return $last_id;
    }

    public function update( $conn, Item $object)  {
        $sql = "UPDATE item
                SET name = ?, description = ?, status = ?, price = ?, purchase_date = ?, update_at = CURRENT_TIMESTAMP
                WHERE id = ?";
        $stmt = $conn->prepare( $sql );
        $result = $stmt->execute( [
            $object->get( 'name' ),
            $object->get( 'description' ),
            $object->get( 'status' ),
            $object->get( 'price' ),
            $object->get( 'purchase_date' ),
            $object->get( 'id' ),
        ] );
        return $result ? true : false;
    }

    public function delete( $conn, Item $object ) {
        $sql = "UPDATE item SET soft_delete = 1
                WHERE id = ?";
        $stmt = $conn->prepare( $sql );
        $result = $stmt->execute( [
            $object->get( 'id' ),
        ] );
        return $result;
    }

     /**
         * Converts an array of item data into a Item object.
         *
         * @param array $object The item data array.
         *
         * @return Item Returns a Item object.
         */
        public function convert ( array $object )
        {
            $new_object = new Item();
            $new_object->set( 'id', $object[ 'id' ] );
            $new_object->set( 'name', $object[ 'name' ] );
            $new_object->set( 'description', $object[ 'description' ] );
            $new_object->set( 'status', $object[ 'status' ] );
            $new_object->set( 'price', $object[ 'price' ] );
            $new_object->set( 'purchase_date', $object[ 'purchase_date' ] );
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