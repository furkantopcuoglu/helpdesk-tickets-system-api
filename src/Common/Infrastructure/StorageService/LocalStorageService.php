<?php

namespace Common\Infrastructure\StorageService;

use Symfony\Component\Filesystem\Filesystem;
use App\Domain\Exceptions\BadRequestException;
use Common\Application\Traits\RandomUniqTrait;
use Symfony\Component\HttpFoundation\File\File;

class LocalStorageService
{
    use RandomUniqTrait;

    public function uploadWithBase64(StorageOptions $options): StorageResponse
    {
        [$mime, $base64data] = explode(';', $options->file);
        [, $mime] = explode(':', $mime);
        [, $base64data] = explode(',', $base64data);

        $decodedData = base64_decode($base64data, true);

        $extension = $this->getFileExtensionFromMime($mime);

        if ('none' === $extension) {
            throw new BadRequestException('FILE_EXTENSION');
        }

        $fileName = 'ticket_file_'.$this->generateRandomUniq(10).'_'.$options->user->getId()->toString().'_'.time().$extension;

        $tempFile = tempnam(sys_get_temp_dir(), 'ticket_upload_file');
        file_put_contents($tempFile, $decodedData);

        $path = $this->checkPath($options->path);
        $file = new File($tempFile);
        $target = $file->move($path, $fileName);

        $path = $this->getPath($target->getPathname());

        return new StorageResponse([
            'fileName' => $fileName,
            'path' => $path,
            'url' => $path,
        ]);
    }

    private function checkPath(?string $path): string
    {
        if (null === $path || '' === trim($path)) {
            throw new \Exception('Path cannot be null');
        }

        $folders = collect(explode('/', $path))
            ->filter(fn ($pathName) => '' !== trim($pathName))
            ->toArray();

        $path = implode('/', $folders);
        $fileSystem = new Filesystem();
        $fileSystem->mkdir($path);

        if (!is_dir($path)) {
            throw new \Exception(sprintf('%s directory not found', $path));
        }

        return $path;
    }

    private function getPath(string $pathName): string
    {
        return str_replace('public/', '', $pathName);
    }

    private function getFileExtensionFromMime(string $mime): string
    {
        $extensions = [
            'image/jpeg' => '.jpg',
            'image/png' => '.png',
        ];

        return $extensions[$mime] ?? 'none';
    }
}
