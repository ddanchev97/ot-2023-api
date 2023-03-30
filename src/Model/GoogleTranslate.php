<?php

namespace App\Model;

use Google\Cloud\Core\Exception\GoogleException;
use Google\Cloud\Core\Exception\ServiceException;
use Google\Cloud\Translate\V2\TranslateClient;

class GoogleTranslate
{
    private string $keyFilePath;
    private string $projectId;

    /**
     * GoogleTranslate constructor.
     * @param string $keyFilePath
     * @param string $projectId
     */
    public function __construct(string $keyFilePath, string $projectId)
    {
        $this->keyFilePath = $keyFilePath;
        $this->projectId = $projectId;
    }

    /**
     * @param string $text
     * @param string $targetLanguage
     * @param string|null $sourceLanguage
     * @return string[]
     * @throws GoogleException
     */
    public function translate(string $text, string $targetLanguage, string $sourceLanguage = null): array
    {
        $translate = new TranslateClient([
            'keyFilePath' => $this->keyFilePath,
            'projectId' => $this->projectId,
            'requestTimeout' => 10
        ]);

        return $translate->translate($text, [
            'source' => $sourceLanguage,
            'target' => $targetLanguage,
            'format' => 'text'
        ]);
    }

    /**
     * @param string $text
     * @return string[]
     * @throws ServiceException|GoogleException
     */
    public function detectLanguage(string $text): array
    {
        $translate = new TranslateClient([
        'keyFilePath' => $this->keyFilePath,
        'projectId' => $this->projectId,
        'requestTimeout' => 10
    ]);

        return $translate->detectLanguage($text);
    }
}
