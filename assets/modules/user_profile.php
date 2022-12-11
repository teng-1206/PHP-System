<?php

    class User_Profile    
    {
        private $id;
        private $email;
        private $name;
        private $gender;
        private $profile_image;
        private $fk_user_id;

        /**
         * Get Method
         */
        public function get( string $attribute )
        {
            switch ( $attribute ) 
            {
                case 'id':
                    return $this->id;
                    break;
                case 'email':
                    return $this->email;
                    break;
                case 'name':
                    return $this->name;
                    break;
                case 'gender':
                    return $this->gender;
                    break;
                case 'profile_image':
                    return $this->profile_image;
                    break;
                case 'fk_user_id':
                    return $this->fk_user_id;
                    break;
            }
        }

        /**
         * Set Method
         */
        public function set( string $attribute, $value )
        {
            switch ( $attribute ) 
            {
                case 'id':
                    $this->id = $value;
                    break;
                case 'email':
                    $this->email = $value;
                    break;
                case 'name':
                    $this->name = $value;
                    break;
                case 'gender':
                    $this->gender = $value;
                    break;
                case 'profile_image':
                    $this->profile_image = $value;
                    break;
                case 'fk_user_id':
                    $this->fk_user_id = $value;
                    break;
            }
        }
    }

    class User_Profile_Controller
    {
        public function read( $conn, User_Profile $object )
        {
            $sql = "SELECT * FROM user_profile
                    WHERE id = ?";
            $stmt = $conn->prepare( $sql );
            $result = $stmt->execute( [
                $object->get( 'id' ),
            ] );
            $num_row = $stmt->rowCount();
            if( $result && $num_row == 1 )
            {
                $result = $stmt->fetch();
                $new_object = $this->convert( $result );
                return $new_object;
            }
            else
            {
                return null;
            }
        }

        public function read_by_fk_user_id( $conn, User_Profile $object )
        {
            $sql = "SELECT * FROM user_profile
                    WHERE fk_user_id = ?";
            $stmt = $conn->prepare( $sql );
            $result = $stmt->execute( [
                $object->get( 'fk_user_id' ),
            ] );
            $num_row = $stmt->rowCount();
            if( $result && $num_row == 1 )
            {
                $result = $stmt->fetch();
                $new_object = $this->convert( $result );
                return $new_object;
            }
            else
            {
                return null;
            }
        }

        public function create( $conn, User_Profile $object )
        {
            $sql = "INSERT INTO user_profile( email, name, gender, profile_image, fk_user_id )
                    VALUES( ?, ?, ?, ?, ? )";
            $stmt = $conn->prepare( $sql );
            $result = $stmt->execute( [
                $object->get( 'email' ),
                $object->get( 'name' ),
                $object->get( 'gender' ),
                $object->get( 'profile_image' ),
                $object->get( 'fk_user_id' ),
            ] );
            $last_id = $result ? $conn->lastInsertId() : null;
            return $last_id;
        }

        public function update( $conn, User_Profile $object )
        {
            $sql = "UPDATE user_profile
                    SET email = ?, name = ?, gender = ?, profile_image = ?
                    WHERE id = ?";
            $stmt = $conn->prepare( $sql );
            $result = $stmt->execute( [
                $object->get( 'email' ),
                $object->get( 'name' ),
                $object->get( 'gender' ),
                $object->get( 'profile_image' ),
                $object->get( 'id' ),
            ] );
            return $result ? true : false;
        }

        /**
         * Convert Method
         */
        public function convert( array $object )
        {
            $new_object = new User_Profile();
            $new_object->set( 'id', $object[ 'id' ] );
            $new_object->set( 'email', $object[ 'email' ] );
            $new_object->set( 'name', $object[ 'name' ] );
            $new_object->set( 'gender', $object[ 'gender' ] );
            $new_object->set( 'profile_image', $object[ 'profile_image' ] );
            $new_object->set( 'fk_user_id', $object[ 'fk_user_id' ] );
            return $new_object;
        }
    }

?>