<?php

namespace BlogBundle\Service;

class RESTfulResponseGeneratorService
{
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
        return new JsonResponse(array(
            'status' => array(
                'result' => $status,
                'description' => $description
            ),
            'data' => $data
        ));
    }
}