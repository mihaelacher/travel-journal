<?php

namespace App\Services\Utils;

use App\Exceptions\General\FileStorageException;
use App\Exceptions\General\UnSupportedMimeTypeExtension;
use App\Models\File as FileModel;
use App\Models\FileType;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileServiceUtil
{
    /**
     * Stores files in storage
     *
     * @param array $files
     * @param int $userId
     * @param int $locationId
     * @return array
     * @throws UnSupportedMimeTypeExtension
     * @throws FileStorageException
     */
    public static function storeFiles(array $files, int $userId, int $locationId): array
    {
        $fileReferences = [];

        /** @var UploadedFile $file */
        foreach ($files as $file) {
            if ($file->isExecutable()) {
                throw new UnSupportedMimeTypeExtension();
            }

            $extension = $file->getClientOriginalExtension();
            $originalName = $file->getClientOriginalName();
            $systemName = md5($originalName . microtime());

            // for the scale of the application and current functionalities,
            // creating an additional table to hold references to uploaded files is unnecessary
            // pros for single json column: Simplicity, Performance, Query Efficiency
            // $uploadedFile = self::saveFileToDb($filePath, $originalName, $systemName, $mimeType);
            try {
                $filePath = self::generateUniqueFilePath(
                    systemName: $systemName,
                    extension: $extension,
                    userId: $userId,
                    locationId: $locationId
                );
                Storage::disk(Config::get('filesystems.default'))->put($filePath, File::get($file));
            } catch (\Throwable $t) {
                LogUtil::logError(message: $t->getMessage());
                throw new FileStorageException();
            }


            $fileReferences[] = $systemName . '.' . $extension;
        }

        return $fileReferences;
    }

    /**
     * Deletes files from storage
     *
     * @param int $locationId
     * @param int $userId
     * @param array $photoReferences
     * @return void
     * @throws FileStorageException
     */
    public static function deleteUserLocationFile(int $locationId, int $userId, array $photoReferences): void
    {
        try {
            $filePaths = [];
            foreach ($photoReferences as $photoReference) {
                $filePaths[] = 'user/' . $userId . '/' . $locationId . '/' . $photoReference;
            }

            Storage::disk(Config::get('filesystems.default'))->delete($filePaths);
        } catch (\Throwable $t) {
            LogUtil::logError(message: $t->getMessage());
            throw new FileStorageException();
        }
    }

    /**
     * Generates unique file path for stored images
     *
     * @param string $systemName
     * @param string $extension
     * @param int $userId
     * @param int $locationId
     * @return string
     */
    private static function generateUniqueFilePath(string $systemName, string $extension, int $userId, int $locationId): string
    {
        $path = 'user/' . $userId . '/' . $locationId . '/';
        $fullPath = $path . $systemName . '.' . $extension;
        $counter = 0;

        while (Storage::disk(Config::get('filesystems.default'))->exists($fullPath)) {
            $counter++;
            $fileName = $systemName . ' (' . $counter . ')';
            $fullPath = $path . $fileName . '.' . $extension;
        }

        return $fullPath;
    }

    /**
     * @param string $path
     * @param string $originalName
     * @param string $systemName
     * @param string $mimeType
     * @return FileModel
     */
    private static function saveFileToDb(string $path, string $originalName, string $systemName, string $mimeType): FileModel
    {
        $file = new FileModel();
        $file->path = $path;
        $file->original_name = self::sanitizeFileOriginalName(originalName: $originalName);
        $file->system_name = $systemName;
        $file->file_type_id = self::getFileTypeId(mimeType: $mimeType);
        $file->save();

        return $file;
    }

    /**
     * @param string $originalName
     * @return array|string
     */
    private static function sanitizeFileOriginalName(string $originalName): array|string
    {
        $originalName = StrUtil::trimSpaces(text: $originalName);
        $originalName = str_replace(' ', '_', $originalName);
        $originalName = str_replace('%20', '_', $originalName);
        $originalName = str_replace('%', '_', $originalName);

        return $originalName;
    }

    /**
     * @param string $mimeType
     * @return int|null
     */
    private static function getFileTypeId(string $mimeType): ?int
    {
        return match ($mimeType) {
            'image/png', 'image/jpeg', 'image/gif', 'image/bmp', 'image/webp', 'image/svg+xml' => FileType::slugId(FileType::IMAGE),
            'video/mp4', 'video/mpeg', 'video/quicktime', 'video/webm', 'video/x-msvideo', 'video/x-ms-wmv' => FileType::slugId(FileType::VIDEO),
            default => null,
        };
    }
}
