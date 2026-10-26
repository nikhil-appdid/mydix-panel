<?php
namespace App\Helpers;

use Exception;
use Intervention\Image\Facades\Image;

class FileUploader
{
    public static function uploadFile($file, string $path = "images", string $initials = "img"): string
    {
        try {
            $destinationPath = $path;
            $req_file        = $initials . '-' . rand(1, 1000) . sha1(time()) . "." . $file->getClientOriginalExtension();
            $file            = $file->move($destinationPath, $req_file);
            return str_replace('\\', '/', $file);
        } catch (Exception $e) {
            \Log::info('Exception in image upload : ' . $e->getMessage());
            throw new Exception("Failed to upload image. error : " . $e->getMessage());
        }
    }

    //This function is for image size reduction it converts 5 mb image to almost 800 kb. and it does not has much impact in quality.
    public static function optimizeUploadFile($file, string $path = "images", string $initials = "img"): string
    {
        // Uncomment the below code if you want to use S3 for optimized image upload

        // try {
        //     $filename = $initials . '-' . rand(1, 1000) . '-' . sha1(time()) . '.' . $file->getClientOriginalExtension();
        //     $image = Image::make($file)->encode($file->getClientOriginalExtension(), 60); // 60% quality
        //     $s3Path = "village-wheels/$path/$filename";
        //     Storage::disk('s3')->put($s3Path, (string) $image, 'public');
        //     return Storage::disk('s3')->url($s3Path);
        // } catch (Exception $e) {
        //     \Log::info('Exception in optimized image upload: ' . $e->getMessage());
        //     throw new Exception("Failed to upload optimized image. Error: " . $e->getMessage());
        // }

        try {
            $originalPath = $path . '/' . $initials . '-' . rand(1, 1000) . sha1(time()) . "." . $file->getClientOriginalExtension();
            if (! file_exists($path)) {
                mkdir($path, 0777, true);
            }
            Image::make($file)->save($originalPath, 60);
            return $originalPath;
        } catch (Exception $e) {
            \Log::info('Exception in image upload : ' . $e->getMessage());
            throw new Exception("Failed to upload image. error : " . $e->getMessage());
        }
    }
}
