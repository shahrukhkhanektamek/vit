<?php


namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class ImageModel extends Model
{
    protected $table = 'your_table_name'; // Adjust the table name as required
    protected $primaryKey = 'id';
    protected $allowedFields = ['image_name', 'image_path', 'image_alt_text']; // Adjust your allowed fields

    // Upload and update image function
    public function upload_multiple_image(array $all_image_column_names, string $table_name = '', string $p_id = '', $getPost=[], $uploadSource='')
    {
        $return_array = [];
        if(empty($uploadSource)) $uploadPath = 'upload/';
        else $uploadPath = $uploadSource;

        if(!file_exists(FCPATH.$uploadPath))
            mkdir(FCPATH.$uploadPath);
        

        foreach ($all_image_column_names as $key => $value) {

            // Check and create column if it doesn't exist
            if (!empty($table_name)) {
                check_column_and_ceate($value, $table_name);
            }

            // Retrieve old image data from database
            $old_img_data = $this->db->table($table_name)->select($value)->where(['id' => $p_id])->get()->getResultObject();

            if (!empty($old_img_data)) {
                $old_img_data = $old_img_data[0];
                $images = $old_img_data->$value;

                // If images are present, delete the old ones
                if (!empty($images) && json_decode($images)) {
                    foreach (json_decode($images) as $key5 => $value_img) {
                        $file_path = FCPATH . $uploadPath . $value_img->image_path;
                        if (file_exists($file_path)) {
                            unlink($file_path); // Delete old image
                        }
                    }
                }
            }

            // Process new images
            $images_data = [];
            $image_names = $getPost->getPost("image_name" . $value);
            // print_r($image_names);
            if (!empty($image_names)) {
                $image_alt_text = $getPost->getPost("image_alt_text" . $value);
                $image_strings = $getPost->getPost("image_string" . $value);

                foreach ($image_names as $key2 => $image_name) {
                    // Decode base64 image string
                    $image_content = base64_decode(explode(",", $image_strings[$key2])[1]);
                    $image_time = Time::now()->getTimestamp() . $key . $key2 . $value . '.' . pathinfo($image_name, PATHINFO_EXTENSION);

                    // Save image to the server
                    $file_path = FCPATH . $uploadPath . $image_time;
                    if (file_put_contents($file_path, $image_content)) {

                        $webp_path = FCPATH . $uploadPath . pathinfo($image_time, PATHINFO_FILENAME) . '.webp';
                        $converted = $this->convertToWebP($file_path, $webp_path);
                        if ($converted) {
                            unlink($file_path); // Delete original
                            $final_image_path = basename($webp_path); // Just the filename for DB
                        } else {
                            $final_image_path = $image_time; // Fallback to original if failed
                        }

                        // If the image is successfully uploaded, add to the data array
                        $images_data[] = [
                            'image_name' => $image_name,
                            'image_path' => $final_image_path,
                            'image_alt_text' => $image_alt_text[$key2]
                        ];
                    }
                }
                // Encode image data as JSON and return it
                if (!empty($images_data)) {
                    $return_array[$value] = json_encode($images_data);
                }
            }
        }

        return $return_array; // Return the array of image data
    }


    public function upload_image($name, $getPost, $accepts=[], $uploadSource='')
    {
        if(empty($uploadSource)) $uploadPath = 'upload/';
        else $uploadPath = $uploadSource;

        // Check if a file has been uploaded
        if ($getPost->getFile($name)) {
            // Get the uploaded file
            $image = $getPost->getFile($name);
            
            $ext = strtolower($image->getClientExtension());
            if(!in_array($ext, $accepts) && !empty($accepts))
                return false;
            
            // Check if the file is valid and not empty
            if ($image->isValid() && ! $image->hasMoved()) {
                // Generate a new name for the image
                $newName = $image->getRandomName();
                
                // Move the image to the 'public/uploads' directory
                $image->move(FCPATH . 'upload', $newName);
                
                // Get the file path
                $filePath = FCPATH . $uploadPath . $newName;
                $imageNameWebp = FCPATH . $uploadPath . explode(".", $newName)[0].".webp" ;

                if($newName!='default.jpg' && $newName!='user.png')
                {                    
                    $rvalue = $this->convertToWebP($filePath, $imageNameWebp);
                    if($rvalue)
                    {
                        unlink($filePath);
                        $newName = explode(".", $newName)[0].".webp";
                    }
                }
                return $newName;
            } else {
                
            }
        } else {
            
        }
    }

    public function convertToWebP($source, $destination = null, $quality = 80) {
        if (!file_exists($source)) {
            return false;
        }

        $info = getimagesize($source);
        if (!$info) return false;

        $mime = $info['mime'];
        $image = null;

        switch ($mime) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($source);
                break;
            case 'image/png':
                $image = imagecreatefrompng($source);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($source);
                break;
            case 'image/bmp':
            case 'image/x-ms-bmp':
                $image = imagecreatefrombmp($source);
                break;
            default:
                return false; // unsupported type
        }

        if (!$image) return false;

        // Handle transparency for PNG/GIF
        imagepalettetotruecolor($image);
        imagealphablending($image, false);
        imagesavealpha($image, true);

        // Destination fallback
        if ($destination === null) {
            $destination = preg_replace('/\.\w+$/', '.webp', $source);
        }

        // Convert to WebP
        $result = imagewebp($image, $destination, $quality);

        imagedestroy($image);
        return $result ? $destination : false;
    }

    
}