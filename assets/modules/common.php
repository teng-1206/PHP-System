<?php

    class Common
    {

        public static function convert_two_decimal( $value )
        {
            return sprintf( '%0.2f', round( $value, 2 ) );
        }

        public static function format_two_decimal( $value )
        {
            return number_format( $value, 2, '.', ',' );
        }

        /**
         * Creates a thumbnail image from a source image and saves it to the destination path.
         * 
         * Supports JPEG, PNG, and GIF image formats. The thumbnail maintains the original
         * aspect ratio while resizing to the specified width.
         *
         * @param string $src_path     The path to the source image file
         * @param string $dest_path    The path where the thumbnail should be saved
         * @param int $thumb_width     The desired width of the thumbnail in pixels (default: 300)
         * 
         * @return bool                Returns true if the thumbnail was successfully created 
         *                             and saved, false on failure or unsupported image type
         */
        public static function create_thumbnail( $src_path, $dest_path, $thumb_width = 300 ) {
            $info = getimagesize($src_path);
            $mime = $info['mime'];

            switch ($mime) {
                case 'image/jpeg':
                    $image = imagecreatefromjpeg($src_path);
                    break;
                case 'image/png':
                    $image = imagecreatefrompng($src_path);
                    break;
                case 'image/gif':
                    $image = imagecreatefromgif($src_path);
                    break;
                default:
                    return false;
            }

            $width  = imagesx($image);
            $height = imagesy($image);
            $thumbHeight = floor($height * ($thumb_width / $width));

            $thumb = imagecreatetruecolor($thumb_width, $thumbHeight);
            imagecopyresampled($thumb, $image, 0, 0, 0, 0, $thumb_width, $thumbHeight, $width, $height);

            switch ($mime) {
                case 'image/jpeg':
                    imagejpeg($thumb, $dest_path);
                    break;
                case 'image/png':
                    imagepng($thumb, $dest_path);
                    break;
                case 'image/gif':
                    imagegif($thumb, $dest_path);
                    break;
            }

            return file_exists($dest_path);
        }

    }

?>