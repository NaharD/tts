<?php

/**
 * Class Voice
 *
 * @property int $text Текстове повімлення, котре треба озвучити.
 * @property int $voice Голосовий профіль, котрий буде використано при озвучуванні повідомлення.
 * @property int $name Назва звукового файлу, котрий буде на виході. Корисно, коли потрібно завантажити озвучку зі зрозумілим ім'ям.
 * @property int $path Абсолютний шлях до теки аудіо файлів
 */
class Voice
{
	public const EXT_WAV='.wav';
	public const EXT_MP3='.mp3';
	
	public $text;
	public $voice;
	public $name;
	public $scale;
	private $path;
	
	public function __construct($text, $voice=null, $name=null, $scale=null)
	{
		$this->delOldFiles();
		
		$this->text = urldecode($text);
		$this->voice = $voice ?: 'anatol';
		$this->name = $name ?: uniqid('audio_', true);
		$this->scale = is_numeric($scale) ? $scale : 1;
		$this->path = getcwd();
	}
	
	/**
	 * Озвучує отриманий текст.
	 * Результат записує в .wav файл.
	 * Конвертує наш .wav в mp3, для заощадження вільного простору.
	 * Видаляє .wav
	 */
	public function createVoice():self
	{
		$inFile = $this->getInFile();
		$outFile = $this->getOutFile();
		
		exec("echo {$this->text} | RHVoice-test -p {$this->voice} -o {$inFile}; lame --scale {$this->scale} {$inFile} {$outFile}; rm {$inFile}");
		
		return $this;
	}
	
	/**
	 * Стрімить озвучку
	 */
	public function streamVoice():self
	{
		header('Content-type: audio/mpeg, audio/wav');
		header("Content-Disposition: filename={$this->getOutFileName()}");
		readfile($this->getOutFile());
		
		return $this;
	}
	
	/**
	 * Видаляє всі файли котрі є старіші за вказаний час.
	 * Без задання час в одну хвилину.
	 *
	 * Якщо треба чистити теку від файлів котрим є 30сек - вказуй значення 0.5
	 *
	 * @param float $old
	 */
	public function delOldFiles($old=1.0):void
	{
		exec("find {$this->path} -mmin +{$old} -type f ! -name '*.php' -exec rm -fv {} \;");
	}
	
	public function getInFile():string
	{
		return $this->createFullFilePath($this->getInFileName());
	}
	
	public function getOutFile():string
	{
		return $this->createFullFilePath($this->getOutFileName());
	}
	
	public function getInFileName():string
	{
		return $this->createFileName(self::EXT_WAV);
	}
	
	public function getOutFileName():string
	{
		return $this->createFileName(self::EXT_MP3);
	}
	
	public function createFileName($ext):string
	{
		return $this->name . $ext;
	}
	
	public function createFullFilePath($fileName):string
	{
		return $this->path . DIRECTORY_SEPARATOR . $fileName;
	}
}