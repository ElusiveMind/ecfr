<?php

namespace eCFR;

use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Client;
use LogicException;
use Psr\Http\Message\ResponseInterface;

final class Api {
  private const URL = 'ecfr.federalregister.gov.';
  private $objHttp;
  private $objUri;

  /**
   * Construct an instance
   * 
   * @param Client $objHttp
   */
  public function __construct(Client $objHttp) {
    $this->objHttp = $objHttp;
  }

  /**
   * HTTP GET
   * 
   * @param Uri $objUri
   * @return Response
   */
  public function get(Uri $objUri) : ResponseInterface {
    if (empty($objUri->getPath())) {
      throw new LogicException('Uri must contain a valid path');
    }
    $objUri = $objUri->withHost(self::URL)->withScheme('https');
    $this->objUri =$objUri;

    $objResponse = $this->objHttp->get($this->objUri);
    return $objResponse;
  }

  public function getData(Uri $objUri) : string {
    $objResponse = $this->get($objUri);
    $contentLength = $objResponse->getHeader('Content-Length');
    $body = $objResponse->getBody();
    $body->seek(0);
    return $body->read($contentLength[0]);
  }

  /**
   * Performs HTTP GET and returns as an object
   * 
   * @param Uri $objUri
   * @return array
   */
  public function getArray(Uri $objUri) : array {
    $objResponse = $this->get($objUri);
    return json_decode($objResponse->getBody()->getContents(), true);
  }

  public function getObjHttp() : Client {
    return $this->objHttp;
  }

  public function setStrApiKey(string $key) : self {
    $this->strApiKey = $key;
    return $this;
  }

  public function getStrApiKey() : string {
    return $this->strApiKey;
  }

  public function getObjUri() : Uri {
    return $this->objUri;
  }
}