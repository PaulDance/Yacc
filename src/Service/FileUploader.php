<?php

// src/Service/FileUploader.php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Describes a service meant to receive and store uploaded files.
 * @author Paul Mabileau <paulmabileau@hotmail.fr>
 */
class FileUploader {
	/**
	 * @var string
	 */
	private $targetDirectory;
	/**
	 * @var ContainerInterface
	 */
	private $container;
	
	public function __construct(ContainerInterface $container) {
		$this->container = $container;
	}
	
	public function setTargetDirectoryFromConfig(string $configDirectory, string $suffix = '') {
		$this->setTargetDirectory($this->container->getParameter($configDirectory) . $suffix);
	}
	
	/**
	 * Sets the directory in which the following files should be moved to.
	 * @param string $targetDirectory The path leading to the directory
	 * 			from the project's root ("absolute path").
	 */
	public function setTargetDirectory(string $targetDirectory) {
		$this->targetDirectory = $targetDirectory;
	}
	
	/**
	 * Gets the directory in which the following files will be moved to.
	 * @return string The path leading to the directory from the project's
	 * 			root ("absolute path").
	 */
	public function getTargetDirectory(): string {
		return $this->targetDirectory;
	}
	
	/**
	 * Receives an uploaded file and stores it in the target directory
	 * with a file name stripped of any non-alphanumeric characters,
	 * with a random nonce and with a guessed extensio.
	 * 
	 * @param UploadedFile $file The uploaded file.
	 * @return string The new file name that was generated and used.
	 */
	public function upload(UploadedFile $file): string {
		$originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
		$safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
		$fileName = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();
		
		$file->move($this->getTargetDirectory(), $fileName);
		return $fileName;
	}
	
	/**
	 * Fetches a file from the Web through an URL and uses the upload
	 * method on it.
	 * 
	 * @param string $URL An URL which should point to an available file.
	 * @return string The new file name that was generated and used.
	 */
	public function uploadFromURL(string $URL): string {
		$baseName = basename($URL);
		$tmpFilePath = $this->container->getParameter('tmp_dir') . '/' . $baseName;
		
		copy($URL, $tmpFilePath);
		return $this->upload(new UploadedFile($tmpFilePath, $baseName, null, null, true));
	}
}
