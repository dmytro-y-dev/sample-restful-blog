<?php

namespace BlogBundle\Service;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class RESTfulResponseGeneratorService
{
    /* @var Serializer */
    private $serializer;

    public function __construct()
    {
        $this->serializer = new Serializer(array(new ObjectNormalizer()), array(new JsonEncoder()));
    }

    /**
     * Generate response for REST controller methods.
     *
     * @param $status string Request's result status (possible values are 'ok', 'fail').
     * @param $description string Detailed description of result.
     * @param $data mixed Object to be serialized.
     *
     * @return JsonResponse
     */
    public function generateResponse($status, $description = '', $data = '')
    {
        // $serializer doesn't know how to perform correctly on arrays. Let's help him.

        if (is_array($data)) {
            foreach ($data as &$item) {
                $item = $this->serializer->normalize($item, 'json');
            }
        }

        // Prepare response data

        $responseData = array(
            'status' => array(
                'result' => $status,
                'description' => $description
            ),
            'data' => $data
        );

        $serializedData = $this->serializer->serialize($responseData, 'json');

        // Finally, generate response

        return new Response($serializedData);
    }
}