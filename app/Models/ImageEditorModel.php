<?php


namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;
use Config\Database;


class ImageEditorModel extends Model
{
    protected $table = 'your_table_name'; // Adjust the table name as required
    protected $primaryKey = 'id';
    protected $allowedFields = ['image_name', 'image_path', 'image_alt_text']; // Adjust your allowed fields

    

    public static function createCertificate($row)
    {
        $db = \Config\Database::connect();
        $user = $db->table("users")->where(["id" => $row->user_id])->get()->getFirstRow();
    

        // Now you can proceed to embed the generated QR code image into your certificate
        $return_name = str_replace(" ","-" ,$row->name).'-'.str_replace(' ','-',env('APP_SORT').$row->user_idd).'.jpg';
        $outputPath = FCPATH.'imageeditor/'.$return_name;
        
        $imgPath = FCPATH.'imageeditor/'.'certificate.png';
        $fontRelativePath = FCPATH.'imageeditor/fonts/'.'Arial_Italic.ttf';
        
        $angle = 0;
        $image = imagecreatefrompng($imgPath);
        $textColor = imagecolorallocate($image, 4, 47, 224);
        
        if (!$image) {
            die('Failed to load image.');
        }
        
        $fontPath = realpath($fontRelativePath);
        if (!$fontPath) {
            die('Invalid font path: ' . $fontRelativePath);
        }
        
        if (!file_exists($fontPath)) {
            die('Font file does not exist: ' . $fontPath);
        }
        
        $imageWidth = imagesx($image);
        $imageHeight = imagesy($image);
        

        // Add Text for Reg. Id.
        $text = strtoupper($row->reg_no);
        $fontRelativePathTemp = FCPATH . 'imageeditor/fonts/' . 'Verdana_Bold.ttf';            
        $fontSize = 13;
        $angle = 0;
        $textColorTemp = imagecolorallocate($image, 0, 0, 0);
        $x = 935;
        $y = 145;
        $letterSpacing = 1;
        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];
            imagettftext($image, $fontSize, $angle, $x, $y, $textColorTemp, $fontRelativePathTemp, $char);
            $bbox = imagettfbbox($fontSize, $angle, $fontRelativePathTemp, $char);
            $charWidth = abs($bbox[4] - $bbox[0]);
            $x += $charWidth + $letterSpacing;
        }


        // Add Text for Name
        $text = strtoupper($row->name);
        $fontSize = 35;
        $textBox = imagettfbbox($fontSize, $angle, $fontPath, $text);
        $textWidth = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $x = ($imageWidth - $textWidth) / 2+50;
        $y = 480;
        imagettftext($image, $fontSize, $angle, $x, $y, $textColor, $fontPath, $text);


        // Add Text for (During after one year of study)
        $fontRelativePathD = FCPATH . 'imageeditor/fonts/' . 'DancingScript-Bold.ttf';
        $textColor3 = imagecolorallocate($image, 2, 29, 90);
        $text = strtoupper('During after one year of study');
        $fontSize = 25;
        $textBox = imagettfbbox($fontSize, $angle, $fontRelativePathD, $text);
        $textWidth = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $x = ($imageWidth - $textWidth) / 2+50;
        $y = 570;
        imagettftext($image, $fontSize, $angle, $x, $y, $textColor3, $fontRelativePathD, $text);
        
        // imagettftext($image, $fontSize, $angle, $x, $y, $textColor3, $fontRelativePathD, $text);


        // Add Text for Performance
        $text = strtoupper($row->performance);
        $fontSize = 35;
        $textBox = imagettfbbox($fontSize, $angle, $fontPath, $text);
        $textWidth = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $x = ($imageWidth - $textWidth) / 2+50;
        $y = 790;
        imagettftext($image, $fontSize, $angle, $x, $y, $textColor, $fontPath, $text);



        // Add Text for Issue Day
        $day = date("j", strtotime($row->issue_date)); // e.g., 10
        $suffix = 'th';
        if ($day % 10 == 1 && $day != 11) $suffix = 'st';
        elseif ($day % 10 == 2 && $day != 12) $suffix = 'nd';
        elseif ($day % 10 == 3 && $day != 13) $suffix = 'rd';
        $text = strtoupper($day);
        $fontSize = 25;
        $angle = 0;
        $x = 520;
        $y = 1350;
        imagettftext($image, $fontSize, $angle, $x, $y, $textColor, $fontPath, $text);
        $textBox = imagettfbbox($fontSize, $angle, $fontPath, $text);
        $textWidth = abs($textBox[4] - $textBox[0]);
        $suffixFontSize = 15;
        $suffixX = $x + $textWidth + 5;
        $suffixY = $y - 8;
        imagettftext($image, $suffixFontSize, $angle, $suffixX, $suffixY, $textColor, $fontPath, $suffix);




        // Add Text for Month year
        $text = strtoupper(date("M. Y", strtotime($row->issue_date)));
        $fontSize = 25;
        $textBox = imagettfbbox($fontSize, $angle, $fontPath, $text);
        $textWidth = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $x = 750;
        $y = 1350;
        imagettftext($image, $fontSize, $angle, $x, $y, $textColor, $fontPath, $text);


        // Add Text for Grade Text
        $fontRelativePath = FCPATH . 'imageeditor/fonts/' . 'Verdana_Bold.ttf';  
        $textColor2 = imagecolorallocate($image, 32, 57, 91);
        $text = ($user->gender==1?'He':'She').' has obtained a grade-';
        $fontSize = 21;
        $angle = 0;
        $x = 218;
        $y = 1500;
        $letterSpacing = 0;
        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];
            imagettftext($image, $fontSize, $angle, $x, $y, $textColor2, $fontRelativePath, $char);
            $bbox = imagettfbbox($fontSize, $angle, $fontRelativePath, $char);
            $charWidth = abs($bbox[4] - $bbox[0]);
            $x += $charWidth + $letterSpacing;
        }

        // Add Text for Grade
        $fontRelativePathTemp = FCPATH . 'imageeditor/fonts/' . 'Verdana_Bold.ttf';  
        $text = '(' . strtoupper($row->grade) . ')';
        $fontSize = 30;
        $angle = 0;
        $x = 610;
        $y = 1500;
        $letterSpacing = 0;
        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];
            imagettftext($image, $fontSize, $angle, $x, $y, $textColor, $fontRelativePathTemp, $char);
            $bbox = imagettfbbox($fontSize, $angle, $fontRelativePathTemp, $char);
            $charWidth = abs($bbox[4] - $bbox[0]);
            $x += $charWidth + $letterSpacing;
        }

        
        
      
        // ✅ Add user image
        $userImagePath = FCPATH . 'upload/' . $row->image;

        if (file_exists($userImagePath)) {
            $userImageInfo = getimagesize($userImagePath);
            $userImage = null;

            switch ($userImageInfo['mime']) {
                case 'image/jpeg':
                    $userImage = imagecreatefromjpeg($userImagePath);
                    break;

                case 'image/png':
                    $userImage = imagecreatefrompng($userImagePath);
                    break;

                case 'image/gif':
                    $userImage = imagecreatefromgif($userImagePath);
                    break;

                case 'image/webp':
                    // 🟢 WebP support check
                    if (function_exists('imagecreatefromwebp')) {
                        $userImage = imagecreatefromwebp($userImagePath);
                    } else {
                        // 🔄 Convert WebP → PNG if GD doesn’t support it
                        $tempPng = FCPATH . 'upload/temp_' . uniqid() . '.png';
                        @exec("dwebp " . escapeshellarg($userImagePath) . " -o " . escapeshellarg($tempPng));

                        if (file_exists($tempPng)) {
                            $userImage = imagecreatefrompng($tempPng);
                            @unlink($tempPng); // cleanup
                        } else {
                            die('WebP image could not be converted. Please enable GD WebP support or install WebP tools.');
                        }
                    }
                    break;

                default:
                    die('Unsupported image type: ' . $userImageInfo['mime']);
            }

            if (!$userImage) {
                die('Failed to load user image.');
            }

            // 🧩 Image placement and size
            $usrX = 1010;
            $usrY = 155;
            $userWidth = 125;
            $userHeight = 155;

            // 🖼️ Resize and overlay
            $resizedUserImage = imagescale($userImage, $userWidth, $userHeight);
            imagecopy($image, $resizedUserImage, $usrX, $usrY, 0, 0, imagesx($resizedUserImage), imagesy($resizedUserImage));

            // 🧹 Free up memory
            imagedestroy($userImage);
            imagedestroy($resizedUserImage);

        } else {
            die('User image not found: ' . $userImagePath);
        }


        // imagejpeg($image, $outputPath);
        // imagedestroy($image);

        ob_start();
        imagejpeg($image);
        $imageData = ob_get_contents();
        ob_end_clean();
        imagedestroy($image);
        $base64 = 'data:image/jpeg;base64,' . base64_encode($imageData);
        return $base64;
    }

    public static function createResult($row)
    {
        // Now you can proceed to embed the generated QR code image into your certificate
        $return_name = str_replace(" ","-" ,$row->name).'-'.str_replace(' ','-',env('APP_SORT').$row->user_idd).'result.jpg';
        $outputPath = FCPATH.'imageeditor/'.$return_name;
        
        $imgPath = FCPATH.'imageeditor/'.'result.jpg';
        $fontRelativePath = FCPATH.'imageeditor/fonts/'.'Arial_Italic.ttf';
        $fontRelativePathBold = FCPATH . 'imageeditor/fonts/' . 'Verdana_Bold.ttf';            
        
        $angle = 0;
        $image = imagecreatefromjpeg($imgPath);
        $textColor = imagecolorallocate($image, 4, 47, 224);
        
        if (!$image) {
            die('Failed to load image.');
        }
        
        $fontPath = realpath($fontRelativePath);
        if (!$fontPath) {
            die('Invalid font path: ' . $fontRelativePath);
        }
        
        if (!file_exists($fontPath)) {
            die('Font file does not exist: ' . $fontPath);
        }
        
        $imageWidth = imagesx($image);
        $imageHeight = imagesy($image);
        

        // Add Text for Reg. Id.
        $text = strtoupper($row->reg_no);
        $fontSize = 13;
        $angle = 0;
        $textColorTemp = imagecolorallocate($image, 0, 33, 97);
        $x = 935;
        $y = 145;
        $letterSpacing = 1;
        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];
            imagettftext($image, $fontSize, $angle, $x, $y, $textColorTemp, $fontRelativePathBold, $char);
            $bbox = imagettfbbox($fontSize, $angle, $fontRelativePathBold, $char);
            $charWidth = abs($bbox[4] - $bbox[0]);
            $x += $charWidth + $letterSpacing;
        }


        // Add Text for semester
        $text = strtoupper($row->semester);
        $fontSize = 18;
        $textBox = imagettfbbox($fontSize, $angle, $fontRelativePathBold, $text);
        $textWidth = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $x = 250;
        $y = 550;
        imagettftext($image, $fontSize, $angle, $x, $y, $textColor, $fontRelativePathBold, $text);


        // Add Text for Duration
        $text = strtoupper($row->duration);
        $fontSize = 18;
        $textBox = imagettfbbox($fontSize, $angle, $fontRelativePathBold, $text);
        $textWidth = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $x = 965;
        $y = 550;
        imagettftext($image, $fontSize, $angle, $x, $y, $textColor, $fontRelativePathBold, $text);

        // Add Text for Name
        $text = strtoupper($row->name);
        $fontSize = 30;
        $textBox = imagettfbbox($fontSize, $angle, $fontPath, $text);
        $textWidth = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $x = 240;
        $y = 615;
        imagettftext($image, $fontSize, $angle, $x, $y, $textColor, $fontPath, $text);



        // Add Text for Student Id. No.
        $text = strtoupper(env('APP_SORT').$row->user_idd);
        $fontSize = 18;
        $textBox = imagettfbbox($fontSize, $angle, $fontRelativePathBold, $text);
        $textWidth = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $x = 985;
        $y = 615;
        imagettftext($image, $fontSize, $angle, $x, $y, $textColor, $fontRelativePathBold, $text);


        // Add Text for Batch Code
        $text = strtoupper($row->batch_code);
        $fontSize = 18;
        $textBox = imagettfbbox($fontSize, $angle, $fontRelativePathBold, $text);
        $textWidth = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $x = 290;
        $y = 680;
        imagettftext($image, $fontSize, $angle, $x, $y, $textColor, $fontRelativePathBold, $text);


        // Add Text for Course
        $text = strtoupper($row->course);
        $fontSize = 18;
        $textBox = imagettfbbox($fontSize, $angle, $fontRelativePathBold, $text);
        $textWidth = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $x = 990;
        $y = 682;
        imagettftext($image, $fontSize, $angle, $x, $y, $textColor, $fontRelativePathBold, $text);






        // ✅ DUMMY DATA — replace later with DB values if needed
        $modules = json_decode($row->module);
        if(empty($modules)) $modules = [];
        

        $projects = json_decode($row->project);
        if(empty($projects)) $projects = [];

        // ===============================
        // 📊 MODULE TEST SECTION
        // ===============================


        // Add Text for Course
        $text = strtoupper("Module Test:");
        $fontSize = 18;
        $textBox = imagettfbbox($fontSize, $angle, $fontRelativePathBold, $text);
        $textWidth = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $x = 160;
        $y = 790;
        imagettftext($image, $fontSize, $angle, $x, $y, $textColor, $fontRelativePathBold, $text);


        $fontSize = 15;
        $textColorModules = imagecolorallocate($image, 18, 54, 196); // black text

        $lineHeight = 30;
        $xLabel = 190;
        $xValue = 950;
        $startY = 830;
        $totalMaks = 0;
        foreach ($modules as $index => $module) {

            $y = $startY + ($index * $lineHeight);
            $text = "•    " . "$module->title";
            $marks = (int) "$module->value";

            $totalMaks+=$marks;

            // Left side (subject)
            imagettftext($image, $fontSize, 0, $xLabel, $y, $textColorModules, $fontRelativePath, $text);

            imagettftext($image, $fontSize, 0, 900, $y, $textColorModules, $fontRelativePathBold, ":");

            // Right side (marks)
            imagettftext($image, $fontSize, 0, $xValue, $y, $textColorModules, $fontRelativePath, $marks);
        }


        $projectStartY = $startY + (count($modules) * $lineHeight) + 10; // small gap after modules
        $projectFontSize = 18;
        imagettftext($image, $projectFontSize, 0, $x, $projectStartY, $textColorModules, $fontRelativePathBold, "Projects:");
        $projectStartY += 10;
        foreach ($projects as $i => $proj) {
            // $y = $projectStartY + (($i + 1) * $lineHeight);
            // imagettftext($image, $projectFontSize, 0, $xLabel + 30, $y, $textColorModules, $fontRelativePath, $proj);


            $y = $projectStartY = $projectStartY+$lineHeight;
            // $y = $projectStartY;
            $text = "•    " . "$proj->title";
            $marks = "$proj->value";

            // Left side (subject)
            imagettftext($image, $fontSize, 0, $xLabel, $y, $textColorModules, $fontRelativePath, $text);

            imagettftext($image, $fontSize, 0, 900, $y, $textColorModules, $fontRelativePathBold, ":");

            // Right side (marks)
            imagettftext($image, $fontSize, 0, $xValue, $y, $textColorModules, $fontRelativePath, $marks);
        }




        // Add Text for performance
        $text = strtoupper($row->performance);
        $text = $totalMaks;
        $fontSize = 20;
        $textBox = imagettfbbox($fontSize, $angle, $fontPath, $text);
        $textWidth = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $x = 950;
        $y = 1273;
        imagettftext($image, $fontSize, $angle, $x, $y, $textColor, $fontPath, $text);


        // Add Text for Grade
        $text = '('.strtoupper($row->grade).')';
        $fontSize = 15;
        $textBox = imagettfbbox($fontSize, $angle, $fontPath, $text);
        $textWidth = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $x = 950;
        $y = 1325;
        imagettftext($image, $fontSize, $angle, $x, $y, $textColor, $fontPath, $text);


        // Add Text for Place
        $text = strtoupper($row->place);
        $fontSize = 15;
        $textBox = imagettfbbox($fontSize, $angle, $fontPath, $text);
        $textWidth = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $x = 190;
        $y = 1384;
        imagettftext($image, $fontSize, $angle, $x, $y, $textColor, $fontPath, $text);




        // Add Text for Issue Day
        $day = date("j", strtotime($row->issue_date)); // e.g., 10
        $suffix = 'th';
        if ($day % 10 == 1 && $day != 11) $suffix = 'st';
        elseif ($day % 10 == 2 && $day != 12) $suffix = 'nd';
        elseif ($day % 10 == 3 && $day != 13) $suffix = 'rd';
        $text = strtoupper($day);
        $fontSize = 15;
        $angle = 0;
        $x = 190;
        $y = 1450;
        imagettftext($image, $fontSize, $angle, $x, $y, $textColor, $fontPath, $text);
        $textBox = imagettfbbox($fontSize, $angle, $fontPath, $text);
        $textWidth = abs($textBox[4] - $textBox[0]);
        $suffixFontSize = 15;
        $suffixX = $x + $textWidth + 5;
        $suffixY = $y - 8;
        imagettftext($image, $suffixFontSize, $angle, $suffixX, $suffixY, $textColor, $fontPath, $suffix);


        // Add Text for Month year
        $text = strtoupper(date("M. Y", strtotime($row->issue_date)));
        $fontSize = 15;
        $textBox = imagettfbbox($fontSize, $angle, $fontPath, $text);
        $textWidth = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $x = 230;
        $y = 1450;
        imagettftext($image, $fontSize, $angle, $x, $y, $textColor, $fontPath, $text);


        
        
      
        // ✅ Add user image
        $userImagePath = FCPATH . 'upload/' . $row->image;

        if (file_exists($userImagePath)) {
            $userImageInfo = getimagesize($userImagePath);
            $userImage = null;

            switch ($userImageInfo['mime']) {
                case 'image/jpeg':
                    $userImage = imagecreatefromjpeg($userImagePath);
                    break;

                case 'image/png':
                    $userImage = imagecreatefrompng($userImagePath);
                    break;

                case 'image/gif':
                    $userImage = imagecreatefromgif($userImagePath);
                    break;

                case 'image/webp':
                    // 🟢 WebP support check
                    if (function_exists('imagecreatefromwebp')) {
                        $userImage = imagecreatefromwebp($userImagePath);
                    } else {
                        // 🔄 Convert WebP → PNG if GD doesn’t support it
                        $tempPng = FCPATH . 'upload/temp_' . uniqid() . '.png';
                        @exec("dwebp " . escapeshellarg($userImagePath) . " -o " . escapeshellarg($tempPng));

                        if (file_exists($tempPng)) {
                            $userImage = imagecreatefrompng($tempPng);
                            @unlink($tempPng); // cleanup
                        } else {
                            die('WebP image could not be converted. Please enable GD WebP support or install WebP tools.');
                        }
                    }
                    break;

                default:
                    die('Unsupported image type: ' . $userImageInfo['mime']);
            }

            if (!$userImage) {
                die('Failed to load user image.');
            }

            // 🧩 Image placement and size
            $usrX = 1010;
            $usrY = 155;
            $userWidth = 125;
            $userHeight = 155;

            // 🖼️ Resize and overlay
            $resizedUserImage = imagescale($userImage, $userWidth, $userHeight);
            imagecopy($image, $resizedUserImage, $usrX, $usrY, 0, 0, imagesx($resizedUserImage), imagesy($resizedUserImage));

            // 🧹 Free up memory
            imagedestroy($userImage);
            imagedestroy($resizedUserImage);

        } else {
            die('User image not found: ' . $userImagePath);
        }

        
        // imagejpeg($image, $outputPath);
        // imagedestroy($image);



        ob_start();
        imagejpeg($image);
        $imageData = ob_get_contents();
        ob_end_clean();
        imagedestroy($image);
        $base64 = 'data:image/jpeg;base64,' . base64_encode($imageData);
        return $base64;

    }



    
}
