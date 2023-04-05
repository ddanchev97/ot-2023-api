<?php

namespace App\Controller\API;
use App\Model\GoogleTranslate;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class TranslationController extends AbstractController
{
    /**
     * @param Request $request
     * @param GoogleTranslate $translate
     * @param LoggerInterface $logger
     * @return JsonResponse
     */
    public function translate(Request $request, GoogleTranslate $translate, LoggerInterface $logger): JsonResponse
    {
        // Get the JSON data from the request body
        $jsonData = $request->getContent();

        // Convert the JSON data into a PHP object
        $data = json_decode($jsonData);

        // Extract the language and text from the data object
        $targetLanguage = $data->targetLanguage;
        $text = $data->text;

        if (!is_null($text) && !is_null($targetLanguage)) {
            try {
                $translated = $translate->translate($text, $targetLanguage);
            } catch (Exception $exception) {
                $logger->error($exception->getMessage());
                return $this->json(['status' => 'error', 'error' => $exception->getMessage()]);
            }

            if (isset($translated['text'])) {
                $translatedText = $translated['text'];
                return $this->json([
                    'status' => 'success',
                    'text' => $translatedText
                ]);
            }
        }

        return $this->json([
            'status' => 'error',
            'message' => 'Translation failed',
            'data' => [$text, $targetLanguage]
        ]);
    }
}