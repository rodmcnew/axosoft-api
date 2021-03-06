<?php

namespace Reliv\AxosoftApi\Model;

/**
 * Class AbstractApiResponse
 *
 * AbstractApiResponse
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   Reliv\AxosoftApi\Model
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2015 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */

abstract class AbstractApiResponse implements ApiResponse
{
    /**
     * @var array
     */
    protected $responseData = [];

    /**
     * setResponseData
     *
     * @param $responseData
     *
     * @return void
     */
    public function setResponseData($responseData)
    {
        $this->responseData = $responseData;
    }

    /**
     * getResponseData
     *
     * @return array
     */
    public function getResponseData()
    {
        return $this->responseData;
    }

    /**
     * getRequestDataProperty
     *
     * @param string $name
     * @param null   $default
     *
     * @return null
     */
    public function getResponseProperty($name, $default = null)
    {
        if (isset($this->responseData[$name])) {
            return $this->responseData[$name];
        }

        return $default;
    }
}
