<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class FileManager extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'file_type', 'storage_type', 'original_name', 'file_name', 'user_id', 'path', 'extension', 'size', 'external_link',
    ];

    public function upload($to, $file, $name = NULL, $id = NULL, $is_watermark = false, $is_main_file = false)
    {
        try {
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $size = $file->getSize();

            $file_name = $name ? $name . '-' . time() . rand(100000, 9999999) . '.' . $extension
                : rand(000, 999) . time() . '.' . $extension;
            $file_name = str_replace(' ', '_', $file_name);

            if (($is_watermark && getOption('water_mark_img')) && !$is_main_file) {
                $img = Image::make($file);
                $watermark = Image::make(getSettingImage('water_mark_img'));

                // Resize watermark dynamically based on image size
                $wmWidth = $img->width() * 0.05;  // 15% of the main image width
                $wmHeight = $wmWidth * ($watermark->height() / $watermark->width()); // Maintain aspect ratio
                $watermark->resize($wmWidth, $wmHeight);

                // Rotate the watermark slightly to match the diagonal pattern

                // Create a watermark pattern across the image
                for ($x = 0; $x < (int)$img->width(); $x += (int)$wmWidth + 80) { // 50px spacing
                    for ($y = 0; $y < (int)$img->height(); $y += (int)$wmHeight + 80) {
                        $img->insert($watermark, 'top-left', $x, $y);
                    }
                }

                $tempPath = storage_path('app/temp/' . $file_name);

                // Ensure temp directory exists
                if (!file_exists(storage_path('app/temp'))) {
                    mkdir(storage_path('app/temp'), 0777, true);
                }

                $img->save($tempPath);

                // Store the watermarked file in the configured storage
                Storage::disk(config('app.STORAGE_DRIVER'))->put('uploads/' . $to . '/' . $file_name, file_get_contents($tempPath));

                // Delete temporary file
                unlink($tempPath);
            } else {
                Storage::disk(config('app.STORAGE_DRIVER'))->put('uploads/' . $to . '/' . $file_name, file_get_contents($file->getRealPath()));
            }

            $fileManager = is_null($id) ? new self() : self::find($id) ?? new self();
            $fileManager->file_type = $file->getMimeType();
            $fileManager->storage_type = config('filesystems.default');
            $fileManager->original_name = $originalName;
            $fileManager->file_name = $file_name;
            $fileManager->user_id = auth()->id();
            $fileManager->path = 'uploads/' . $to . '/' . $file_name;
            $fileManager->extension = $extension;
            $fileManager->size = $size;
            $fileManager->save();

            return ['status' => true, 'file' => $fileManager, 'message' => "File Saved Successfully"];
        } catch (\Exception $exception) {
            return ['status' => false, 'file' => [], 'message' => $exception->getMessage()];
        }
    }

    private function getWatermarkImage()
    {
        if ($watermarkFileId = getOption('water_mark_img')) {
            $fileManager = self::find($watermarkFileId);
            if ($fileManager) {
                $path = "files/Setting/{$fileManager->file_name}";
                if (Storage::disk(config('app.STORAGE_DRIVER'))->exists($path)) {
                    return Storage::disk(config('app.STORAGE_DRIVER'))->path($path);
                }
            }
        }
        return public_path('frontend/assets/img/mask.png');
    }

    public function removeFile()
    {
        if (Storage::disk(config('app.STORAGE_DRIVER'))->exists($this->path)) {
            Storage::disk(config('app.STORAGE_DRIVER'))->delete($this->path);
            return 100;
        }
        return 200;
    }
}
