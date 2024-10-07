<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class FileUtilHelper 
{
    protected string $disk;

    public function __construct(?string $disk = null)
    {
        $this->disk = $disk ?? config('filesystems.default');
    }

    public function getFileUrl(string $path): string
    {
        # for private bucket, temp url with signature is generated
        return Storage::disk($this->disk)->temporaryUrl($path, now()->addMinutes(30));
    }

    public function getFileContent(string $path): ?string
    {
        return Storage::disk($this->disk)->get($path);
    }

    public function putFile(string $path, $content): string|bool
    {
        return Storage::disk($this->disk)->put($path, $content);
    }
}