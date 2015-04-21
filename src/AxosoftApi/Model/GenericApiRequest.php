<?php


namespace AxosoftApi\Model;


/**
 * Class GenericApiRequest
 *
 * GenericApiRequest
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   AxosoftApi\Model
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2015 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */

class GenericApiRequest extends AbstractApiRequest
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $requestMethod = 'GET';

    /**
     * @var array
     */
    protected $requestData = [];

    /**
     * @var array
     */
    protected $requestParameters = [];

    /**
     * @var object|null
     */
    protected $validator = null;

    /**
     * @param $url
     * @param $properties
     * @param $parameters
     */
    public function __construct($url, $properties = [], $parameters = [])
    {
        $this->url = $url;
        $this->properties = $properties;
        $this->parameters = $parameters;
    }

    /**
     * setRequestDataProperty
     *
     * @param $name
     * @param $value
     *
     * @return void
     */
    public function setRequestDataProperty($name, $value)
    {
        $this->requestData[$name] = $value;
    }

    /**
     * setParameter
     *
     * @param $name
     * @param $value
     *
     * @return void
     */
    public function setParameter($name, $value)
    {
        $this->requestParameters[$name] = $value;
    }

    /**
     * getResponse
     *
     * @param $responseData
     *
     * @return \AxosoftApi\Model\AbstractApiResponse
     */
    public function getResponse($responseData)
    {
        if(isset($responseData['error'])){

            return new GenericApiError($responseData);
        }

        return new GenericApiResponse($responseData);
    }

    /**
     * setValidator
     *
     * @param $validator
     *
     * @return void
     * @throws \Exception
     */
    public function setValidator($validator)
    {
        // this implies an interface like ZF2s input filter
        // Is here to prevent a ZF2 dependency, but still support ZF2's inputFilter
        if (!method_exists($validator, 'isValid')
            || !method_exists(
                $validator,
                'getMessages'
            )
        ) {
            throw new \Exception(
                'Validator must contain "setData", "isValid" and "getMessages" methods'
            );
        }

        $this->validator = $validator;
    }

    /**
     * getValidator
     *
     * @return null|object
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * Validation of request data
     *
     * @return bool
     */
    public function isValid()
    {
        if (!empty($this->validator)) {
            $this->validator->setData($this->parameters);
            return $this->validator->isValid();
        }

        return true;
    }

    /**
     * jsonSerialize
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->getRequestData();
    }
}