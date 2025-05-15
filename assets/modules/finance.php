<?php

    /**
     * The Finance class represents a financial transaction, including its
     * ID, title, date, status, amount, category ID, user ID, and create/update timestamps.
     */
    class Finance
    {
        /**
         * The ID of the financial transaction.
         *
         * @var int
         */
        private $id;

        /**
         * The title of the financial transaction.
         *
         * @var string
         */
        private $title;

         /**
         * The description of the financial transaction.
         *
         * @var string
         */
        private $description;

        /**
         * The date of the financial transaction.
         *
         * @var string
         */
        private $date;

        /**
         * The status of the financial transaction.
         *
         * @var string
         */
        private $status;

        /**
         * The amount of the financial transaction.
         *
         * @var float
         */
        private $amount;

        /**
         * The ID of the category that the financial transaction belongs to.
         *
         * @var int
         */
        private $fk_category_id;

        /**
         * The ID of the user that the financial transaction belongs to.
         *
         * @var int
         */
        private $fk_wallet_id;

        /**
         * The ID of the user that the financial transaction belongs to.
         *
         * @var int
         */
        private $fk_user_id;

        /**
         * A flag indicating whether the financial transaction has been soft-deleted.
         *
         * @var bool
         */
        private $soft_delete;

        /**
         * The timestamp of when the financial transaction was created.
         *
         * @var string
         */
        private $create_at;

        /**
         * The timestamp of when the financial transaction was last updated.
         *
         * @var string
         */
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

    /**
     * Controller for the Finance model.
     */
    class Finance_Controller
    {
        /**
         * Reads all finance data from the database.
         *
         * @param object $conn The database connection object.
         *
         * @return array|null Returns an array containing all finance data or null if there is an error.
         */
        // public function read_all ( $conn )
        // {
        //     $sql = "SELECT finance.*, finance_category.category, finance_category.color_code, finance_category.background_color_code, finance_category.icon_code FROM finance
        //             INNER JOIN finance_category
        //             ON finance.fk_category_id = finance_category.id
        //             WHERE finance.soft_delete = 0
        //             ORDER BY finance.id DESC";
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

        public function get_available_years( $conn, $user_id = null )
        {
            $sql = "SELECT DISTINCT YEAR(date) AS year 
                    FROM finance 
                    WHERE soft_delete = 0 AND fk_user_id = ? ORDER BY year DESC";

            $stmt = $conn->prepare($sql);
            $result = $stmt->execute( [
                $user_id,
            ] );

            $num_row = $stmt->rowCount();
            if ( $result )
            {
                $result = $stmt->fetchAll( PDO::FETCH_COLUMN );
                // $result = $this->convert( $result );
                return $result;
            }
            return null;
        }

        public function read_all_by_user_id_and_year($conn, Finance $object, $year = null)
        {
            $where = "";

            if ( $year ) {
                $where = "AND YEAR(finance.date) = $year";
            }

            $sql = "SELECT finance.*, finance_category.category, finance_category.color_code, finance_category.background_color_code, finance_category.icon_code 
                    FROM finance
                    INNER JOIN finance_category ON finance.fk_category_id = finance_category.id
                    WHERE finance.fk_wallet_id = ? 
                    AND finance.fk_user_id = ? 
                    AND finance.soft_delete = 0 
                    $where
                    ORDER BY finance.id DESC";

            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                $object->get('fk_wallet_id'),
                $object->get('fk_user_id'),
            ]);

            $num_row = $stmt->rowCount();
            if ( $result ) 
            {
                $result = $stmt->fetchAll();
                return $result;
            }

            return null;
        }



        /**
         * Reads all finance data from the database for a specific user and date range.
         *
         * @param object   $conn        The database connection object.
         * @param Finance  $object      The Finance object representing the user and date range.
         * @param string   $select_date The selected date range.
         *
         * @return array|null Returns an array containing all finance data for the specified user and date range or null if there is an error.
         */
        public function read_all_by_user_id ( $conn, Finance $object, $select_date = "This Month" )
        {
            $where = "";
            switch ( $select_date ) 
            {
                // case "This Week":
                //     $where = "AND YEARWEEK( finance.date, 1 ) = YEARWEEK( NOW(), 1 )";
                //     break;
                case "This Month":
                    $where = "AND MONTH( finance.date ) = MONTH( CURRENT_TIMESTAMP ) AND YEAR( finance.date ) = YEAR( CURRENT_TIMESTAMP )";
                    break;
                case "This Year":
                    $where = "AND YEAR( finance.date ) = YEAR( CURRENT_TIMESTAMP )";
                    break;
                case "Last Month":
                    if ( date( 'm' ) == 1 ) {
                        $where = "AND MONTH( finance.date ) = 12 AND YEAR( finance.date ) = YEAR( CURRENT_TIMESTAMP ) - 1";
                    } else {
                        $where = "AND MONTH( finance.date ) = MONTH( CURRENT_TIMESTAMP ) - 1 AND YEAR( finance.date ) = YEAR( CURRENT_TIMESTAMP )";
                    }
                    break;
                case "Last 3 Months":
                    if ( date( 'm' ) == 1 ) {
                        $where = "AND (MONTH( finance.date ) = 10 OR MONTH( finance.date ) = 11 OR MONTH( finance.date ) = 12) AND YEAR( finance.date ) = YEAR( CURRENT_TIMESTAMP ) - 1";
                    } else if ( date( 'm' ) == 2 ) {
                        $where = "AND ( ( MONTH( finance.date ) = 11 AND YEAR( finance.date ) = YEAR( CURRENT_TIMESTAMP ) - 1) OR (MONTH( finance.date ) = 12 AND YEAR( finance.date ) = YEAR( CURRENT_TIMESTAMP ) - 1) OR (MONTH( finance.date ) = 1 AND YEAR( finance.date ) = YEAR( CURRENT_TIMESTAMP ) ) )";
                    } else if ( date( 'm' ) == 3 ) {
                        $where = "AND ( ( MONTH( finance.date ) = 12 AND YEAR( finance.date ) = YEAR( CURRENT_TIMESTAMP ) - 1) OR (MONTH( finance.date ) = 1 AND YEAR( finance.date ) = YEAR( CURRENT_TIMESTAMP ) )  OR (MONTH( finance.date ) = 2 AND YEAR( finance.date ) = YEAR( CURRENT_TIMESTAMP ) ) )";
                    } else {
                        $where = "AND MONTH( finance.date ) = MONTH( CURRENT_TIMESTAMP ) - 3 AND YEAR( finance.date ) = YEAR( CURRENT_TIMESTAMP )";
                    }
                    break;
                case "Last Year":
                    $where = "AND YEAR( finance.date ) = YEAR( CURRENT_TIMESTAMP ) - 1";
                    break;
                case "All":
                    $where = "";
                    break;
                default:
                    $where = "AND MONTH( finance.date ) = MONTH( CURRENT_TIMESTAMP ) AND YEAR( finance.date ) = YEAR( CURRENT_TIMESTAMP )";
                    // $where = "AND finance.date >= DATE_FORMAT( NOW(), '%Y-%m-%d 00:00:00' ) AND finance.date < DATE_FORMAT( DATE_ADD( NOW(), INTERVAL 1 DAY ), '%Y-%m-%d 00:00:00' )";
                    break;
            }
            $sql = "SELECT finance.*, finance_category.category, finance_category.color_code, finance_category.background_color_code, finance_category.icon_code FROM finance
                    INNER JOIN finance_category
                    ON finance.fk_category_id = finance_category.id
                    WHERE finance.fk_wallet_id = ? AND finance.fk_user_id = ? AND finance.soft_delete = 0 " . $where . "
                    ORDER BY finance.id DESC";
            $stmt = $conn->prepare( $sql );
            $result = $stmt->execute( [
                $object->get( 'fk_wallet_id' ),
                $object->get( 'fk_user_id' ),
            ] );
            $num_row = $stmt->rowCount();
            if ( $result ) 
            {
                $result = $stmt->fetchAll();
                return $result;
            }
            return null;
        }

        /**
         * Reads a single finance record from the database.
         *
         * @param object  $conn   The database connection object.
         * @param Finance $object The Finance object representing the record to read.
         *
         * @return array|null Returns an array containing the finance data or null if there is an error.
         */
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
                // $result = $this->convert( $result );
                return $result;
            }
            return null;
        }

        /**
         * Inserts a new finance record into the database.
         *
         * @param object  $conn   The database connection object.
         * @param Finance $object The Finance object representing the record to create.
         *
         * @return int|null Returns the ID of the newly inserted record or null if there is an error.
         */
        public function create ( $conn, Finance $object )
        {
            $sql = "INSERT INTO finance( title, description, date, status, amount, fk_category_id, fk_wallet_id, fk_user_id )
                    VALUES( ?, ?, ?, ?, ?, ?, ?, ? )";
            $stmt = $conn->prepare( $sql );
            $result = $stmt->execute( [
                $object->get( 'title' ),
                $object->get( 'description' ),
                $object->get( 'date' ),
                $object->get( 'status' ),
                $object->get( 'amount' ),
                $object->get( 'fk_category_id' ),
                $object->get( 'fk_wallet_id' ),
                $object->get( 'fk_user_id' ),
            ] );
            $last_id = $result ? $conn->lastInsertId() : null;
            return $last_id;
        }

        /**
         * Updates an existing finance record in the database.
         *
         * @param object  $conn   The database connection object.
         * @param Finance $object The Finance object representing the record to update.
         *
         * @return bool Returns true if the update was successful, false otherwise.
         */
        public function update ( $conn, Finance $object )
        {
            $sql = "UPDATE finance
                    SET title = ?, description = ?,  date = ?, status = ?, amount = ?, fk_category_id = ?, fk_wallet_id = ?, update_at = CURRENT_TIMESTAMP
                    WHERE id = ?";
            $stmt = $conn->prepare( $sql );
            $result = $stmt->execute( [
                $object->get( 'title' ),
                $object->get( 'description' ),
                $object->get( 'date' ),
                $object->get( 'status' ),
                $object->get( 'amount' ),
                $object->get( 'fk_category_id' ),
                $object->get( 'fk_wallet_id' ),
                $object->get( 'id' ),
            ] );
            return $result ? true : false;
        }

        /**
         * Deletes an existing finance record from the database.
         *
         * @param object  $conn   The database connection object.
         * @param Finance $object The Finance object representing the record to delete.
         *
         * @return bool Returns true if the delete was successful, false otherwise.
         */
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
         * Converts an array of finance data into a Finance object.
         *
         * @param array $object The finance data array.
         *
         * @return Finance Returns a Finance object.
         */
        public function convert ( array $object )
        {
            $new_object = new Finance();
            $new_object->set( 'id', $object[ 'id' ] );
            $new_object->set( 'title', $object[ 'title' ] );
            $new_object->set( 'description', $object[ 'description' ] );
            $new_object->set( 'date', $object[ 'date' ] );
            $new_object->set( 'status', $object[ 'status' ] );
            $new_object->set( 'amount', $object[ 'amount' ] );
            $new_object->set( 'fk_category_id', $object[ 'fk_category_id' ] );
            $new_object->set( 'fk_wallet_id', $object[ 'fk_wallet_id' ] );
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