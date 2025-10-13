<?php

namespace App\Helper;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;

class ImageManager
{
    public static function upload(string $dir, string $format, $image = null)
    {
        if ($image != null) {
            $imageName = Carbon::now()->toDateString() . "-" . uniqid() . "." . $format;
            if (!Storage::disk('public')->exists($dir)) {
                Storage::disk('public')->makeDirectory($dir);
            }
            Storage::disk('public')->put($dir . $imageName, file_get_contents($image));
        } else {
            $imageName = 'default.jpg';
        }

        return $imageName;
    }

    public static function update(string $dir, $old_image, string $format, $image = null)
    {
        if($old_image!='default.jpg' && $old_image!='user.png')
        {
            if (Storage::disk('public')->exists($dir . $old_image)) {
                Storage::disk('public')->delete($dir . $old_image);
            }
        }
        $imageName = ImageManager::upload($dir, $format, $image);
        return $imageName;
    }

    public static function delete($full_path)
    {
        if (Storage::disk('public')->exists($full_path)) {
            Storage::disk('public')->delete($full_path);
        }

        return [
            'success' => 1,
            'message' => 'Removed successfully !'
        ];

    }




    public static function upload_multiple(string $dir, string $format, $images = null)
    {
        $imageNames = [];

        if ($images != null) {
            // Ensure $images is an array
            if (!is_array($images)) {
                $images = [$images];
            }

            foreach ($images as $image) {
                $imageName = Carbon::now()->toDateString() . "-" . uniqid() . "." . $format;

                // Create the directory if it doesn't exist
                if (!Storage::disk('public')->exists($dir)) {
                    Storage::disk('public')->makeDirectory($dir);
                }

                // Save each file
                Storage::disk('public')->put($dir . $imageName, file_get_contents($image));
                $imageNames[] = $imageName;
            }
        } else {
            $imageNames[] = '';
        }

        return $imageNames; // Return an array of file names
    }

    public static function update_multiple(string $dir, array $old_images, string $format, $images = null)
    {
        // Delete old images if they are not defaults
        foreach ($old_images as $old_image) {
            if ($old_image != 'default.jpg' && $old_image != 'user.png') {
                if (Storage::disk('public')->exists($dir . $old_image)) {
                    Storage::disk('public')->delete_multiple($dir . $old_image);
                }
            }
        }

        // Upload new images
        $imageNames = ImageManager::upload_multiple($dir, $format, $images);
        return $imageNames; // Return an array of new image names
    }

    public static function delete_multiple($full_path)
    {
        if (Storage::disk('public')->exists($full_path)) {
            Storage::disk('public')->delete_multiple($full_path);
        }

        return [
            'success' => 1,
            'message' => 'Removed successfully !'
        ];
    }






    public static function video_upload(string $dir, string $format, $image = null)
    {


        // $video = $image;
        // // Define the path where the video will be stored
        // $destinationPath = base_path('videos');

        // // Ensure the destination directory exists
        // if (!file_exists($destinationPath)) {
        //     mkdir($destinationPath, 0755, true);
        // }

        // // Generate a unique name for the video
        // $videoName = time() . '_' . $video->getClientOriginalName();

        // // Move the video to the destination path
        // $video->move($destinationPath, $videoName);
        // return $videoName;


        if ($image != null) {
            $video = $image;
            $videoName = Carbon::now()->toDateString() . "-" . uniqid() . "." . $format;
            $destinationPath = base_path($dir);
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $video->move($destinationPath, $videoName);
            // return $videoName;
        } else {
            $videoName = 'default.jpg';
        }
        return $videoName;
    }

    public static function video_update(string $dir, $old_image, string $format, $image = null)
    {
        $extension = $image->extension();
        $format = $extension;
        if($old_image!='default.jpg')
        {
            if (Storage::disk('public')->exists($dir . $old_image)) {
                Storage::disk('public')->delete($dir . $old_image);
            }
        }
        $imageName = ImageManager::video_upload($dir, $format, $image);
        return $imageName;
    }

    public static function video_delete($full_path)
    {
        if (Storage::disk('public')->exists($full_path)) {
            Storage::disk('public')->delete($full_path);
        }

        return [
            'success' => 1,
            'message' => 'Removed successfully !'
        ];

    }








    public static function upload_image($all_image_column_names,$table_name='',$p_id='')
    {
        $return_array = array();
        foreach ($all_image_column_names as $key => $value)
        {
            

            // $old_img_data = $this->db->select($value)->get_where($table_name,array("id"=>$p_id,))->result_object();

            $old_img_data = DB::table($table_name)->where(["id"=>$p_id,])->first();

            if(!empty($old_img_data))
            {
                // $old_img_data = $old_img_data[0];
                $images = $old_img_data->$value;
                if(!empty($images))
                {
                    if(json_decode($images))
                    {
                        foreach (json_decode($images) as $key5 => $value_img)
                        {
                            if(file_exists(storage_path().'/app/public/upload/'.$value_img->image_path))
                                unlink(storage_path().'/app/public/upload/'.$value_img->image_path);
                        }
                    }
                }
            }


            $images_data = array();
            if(isset($_POST["image_name".$value]))
            {
                $image_name = $_POST["image_name".$value];
                $image_alt_text = $_POST["image_alt_text".$value];
                $image_string = $_POST["image_string".$value];
                foreach ($image_name as $key2 => $value2)
                {
                    $image_content = base64_decode(explode(",", $image_string[$key2])[1]);
                    $image_time = time().$key.$key2.$value.'.'.explode(".", $image_name[$key2])[1];
                    $ok=false;
                    if(file_put_contents(storage_path().'/app/public/upload/'.$image_time,$image_content))
                    {
                        $ok = true;
                    }
                    else
                    {
                        $ok = true;
                    }
                    if($ok==true)
                    {
                        $images_data[] = array(
                            "image_name"=>$image_name[$key2],
                            "image_path"=>$image_time,
                            "image_alt_text"=>$image_alt_text[$key2],
                        );
                    }
                }
                $images_data = json_encode($images_data);
                $return_array[$value] = $images_data;
            }
            
        }
        return $return_array;
        // print_r($all_image_column_names);
    }









}
