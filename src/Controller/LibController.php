<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * This class is the base of all controller with variable and function for help us
 */
class LibController
{

    private ?Request $request = null;

    protected const OK = 200;
    protected const CREATED = 201;
    protected const NOT_FOUND = 404;
    protected const ACCESS_DENIED = 403;

    private array $message = [
        self::OK => "Success",
        self::CREATED => "Resources created with success",
        self::NOT_FOUND => "Resources not found",
        self::ACCESS_DENIED => "You don't have access to the resources"
    ];

    public function __construct(RequestStack $requestStack)
    {
        if ($this->request === null)
        {
            $this->request = $requestStack->getCurrentRequest();
        }
    }

    /**
     * This function get all information in the body for POST, PUT etc...
     *
     * @return array
     */
    protected function getBody() : array
    {
        return json_decode($this->request->getContent(), true);
    }

    /**
     * This function set the JsonResponse
     *
     * @param integer $code it's the code initialize in this class
     * @param array|null $message if the message is null a template message is write
     * @param array $message The header what you want for the response
     * @return JsonResponse
     */
    protected function setReturn(int $code, ?array $message = null, array $headers = []) : JsonResponse
    {
        if($message === null)
        {
            return new JsonResponse(['status' => $this->message[$code]], $code, $headers);
        }
        
        return new JsonResponse($message, $code);
    }
}
