<?php

namespace App\Service;

use App\Exception\FileUploadException;
use PHPUnit\Util\Exception;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use function PHPUnit\Framework\throwException;

class FileUploader
{
    private $targetDirectory;
    private $slugger;

    public function __construct(string $targetDirectory, SluggerInterface $slugger)
    {
        $this->targetDirectory = $targetDirectory;
        $this->slugger = $slugger;
    }

    /**
     * @throws FileUploadException
     */
    public function upload(?UploadedFile $file): ?string
    {
        if(!$file) {
            throw new FileUploadException();
        }
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.time().'.'.$file->guessClientExtension();
        try {
            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {
            return null;
        }
        return $fileName;
    }

    public function uploadFile(?UploadedFile $file): ?string
    {
        if(!$file) {
            throw new FileUploadException();
        }
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.time().'.'.$file->guessClientExtension();
        $file->move($this->getTargetDirectory(), $fileName);
        return $this->targetDirectory . '/' .$fileName;

    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}