<?php

namespace App\Controller;

use App\Service\DecodingService;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\Stream;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class DecodingController extends LibController
{
    /**
     * @Route("/youtube/mime", methods={"POST"})
     *
     * @return JsonResponse
     */
    public function getAllMime(DecodingService $decodingService) : JsonResponse
    {
        $data = $this->getBody();

        $mime = $decodingService->getAllYoutubeMime($data);

        return $this->setReturn(self::OK, $mime);
    }

    /**
     * @Route("/youtube/download", methods={"POST"})
     *
     * @param DecodingService $decodingService
     * @return JsonResponse
     */
    public function downloadYoutube(DecodingService $decodingService) : BinaryFileResponse
    {
        $data = $this->getBody();
        
        $media = $decodingService->downloadYoutube($data);
        
        
        return new BinaryFileResponse($media['mediaFile']);

    }
}