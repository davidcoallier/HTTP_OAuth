<?php
/**
 * HTTP_OAuth
 *
 * Implementation of the OAuth specification
 *
 * PHP version 5.2.0+
 *
 * LICENSE: This source file is subject to the New BSD license that is
 * available through the world-wide-web at the following URI:
 * http://www.opensource.org/licenses/bsd-license.php. If you did not receive
 * a copy of the New BSD License and are unable to obtain it through the web,
 * please send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category  HTTP
 * @package   HTTP_OAuth
 * @author    Jeff Hodsdon <jeffhodsdon@gmail.com>
 * @copyright 2009 Jeff Hodsdon <jeffhodsdon@gmail.com>
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @link      http://pear.php.net/package/HTTP_OAuth
 * @link      http://github.com/jeffhodsdon/HTTP_OAuth
 */

require_once 'HTTP/OAuth/Message.php';
require_once 'HTTP/OAuth/Exception.php';
require_once 'HTTP/Request2/Response.php';

/**
 * HTTP_OAuth_Consumer_Response
 *
 * Class to handle OAuth responses from a provider.  Accepts and decorates a
 * HttpMessage instance
 *
 * @category  HTTP
 * @package   HTTP_OAuth
 * @author    Jeff Hodsdon <jeffhodsdon@gmail.com>
 * @copyright 2009 Jeff Hodsdon <jeffhodsdon@gmail.com>
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @link      http://pear.php.net/package/HTTP_OAuth
 * @link      http://github.com/jeffhodsdon/HTTP_OAuth
 */
class HTTP_OAuth_Consumer_Response extends HTTP_OAuth_Message
{

    /**
     * Instance of HTTP_Request2_Response
     *
     * @var HTTP_Request2_Response $response Response from the HTTP_Request2
     */
    protected $response = null;

    /**
     * Construct
     *
     * @param HTTP_Request2_Response $response Response from HTTP_Request2
     *
     * @return void
     */
    public function __construct(HTTP_Request2_Response $response)
    {
        $this->response = $response;
    }

    /**
     * Gets data from body
     *
     * If body is and OAuth specific query string, parse and return
     *
     * @return array Query string data
     */
    public function getDataFromBody()
    {
        $result = array();
        parse_str($this->getBody(), $result);
        return $result;
    }

    /**
     * Gets HttpMessage
     *
     * @return HttpMessage Instance of the current HttpMessage
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Call
     *
     * If method exists on HttpMessage pass to that, otherwise
     * throw BadMethodCallException
     *
     * @param string $method Name of the method
     * @param array  $args   Arguments for the method
     *
     * @return mixed Result from method
     * @throws BadMethodCallException When method does not exist on HttpMessage
     */
    public function __call($method, $args)
    {
        if (method_exists($this->response, $method)) {
            return call_user_func_array(array($this->response, $method), $args);
        }

        throw new BadMethodCallException($method);
    }

}

?>
