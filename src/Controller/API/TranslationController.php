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
        $text = $request->get('text');
        $sourceLanguage = $request->get('sourceLanguage');
        $targetLanguage = $request->get('targetLanguage');

        if (!is_null($text) && !is_null($sourceLanguage) && !is_null($targetLanguage)) {
            try {
                $translated = $translate->translate($text, $targetLanguage, $sourceLanguage);
            } catch (Exception $exception) {
                $logger->error($exception->getMessage());
                return $this->json(['status' => 'error']);
            }

            if (isset($translated['translated'])) {
                $translatedText = $translated['translated'];
                return $this->json([
                    'status' => 'success',
                    'data' => $translatedText
                ]);
            }
        }

        return $this->json([
            'status' => 'error',
            'message' => 'Translation failed'
        ]);
    }
}