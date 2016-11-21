<?php namespace WebEd\Base\Elfinder\Support;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Class Connector
 * Extended elFinder connector
 * @package WebEd\Base\Elfinder\Support
 * @author Dmitry (dio) Levashov
 * @thanks to Barrydvh. See https://github.com/barryvdh/laravel-elfinder
 *
 * @edited by Tedozi Manson <duyphan.developer@gmail.com>
 */
class Connector extends \elFinderConnector
{

    const ERROR_CODE = 500;
    const NOT_FOUND_CODE = 404;
    const SUCCESS_CODE = 201;
    const SUCCESS_NO_CONTENT_CODE = 200;

    /** @var Response */
    protected $response;

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Output json
     * @param  array $data to output
     * @return void
     * @author Dmitry (dio) Levashov
     **/
    protected function output(array $data)
    {

        $header = isset($data['header']) ? $data['header'] : $this->header;
        unset($data['header']);

        $headers = array();
        if ($header) {
            foreach ((array)$header as $headerString) {
                if (strpos($headerString, ':') !== false) {
                    list($key, $value) = explode(':', $headerString, 2);
                    $headers[$key] = $value;
                }
            }
        }

        if (isset($data['pointer'])) {
            $this->response = new StreamedResponse(function () use ($data) {
                rewind($data['pointer']);
                fpassthru($data['pointer']);
                if (!empty($data['volume'])) {
                    $data['volume']->close($data['pointer'], $data['info']['hash']);
                }
            }, $this::SUCCESS_CODE, $headers);
        } else {
            if (!empty($data['raw']) && !empty($data['error'])) {
                $this->response = new JsonResponse($data['error'], $this::ERROR_CODE);
            } else {
                $this->response = new JsonResponse($data, $this::SUCCESS_CODE, $headers);
            }
        }
    }
}
