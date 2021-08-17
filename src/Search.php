<?php

namespace eCFR;

use GuzzleHttp\Psr7\Uri;
use eCFR\Requestor\SearchRequestor;
use LogicException;

final class Search {
  
  use EndpointTrait;

  private const ENDPOINT = 'api/search/v1';
  
  /**
   * Constructs an instance
   * 
   * @param Api $objApi
   */
  public function __construct(Api $objApi) {
    $this->objApi = $objApi;
  }
  
  /**
   * The standard set of $objRequestors used for all search queries
   */
  public function standardSet(SearchRequestor $objRequestor, Uri &$objUri) : void {
    if (!empty($objRequestor->getQuery()) {
      $objUri = $objUri->withQueryValue($objUri, 'query', $objRequestor->getQuery());
    }

    if (!empty($objRequestor->getDate()) {
      $objUri = $objUri->withQueryValue($objUri, 'date', $objRequestor->getDate());
    }

    if (!empty($objRequestor->getLastModifiedAfter()) {
      $objUri = $objUri->withQueryValue($objUri, 'last_modified_date', $objRequestor->getLastModifiedAfter());
    }

    if (!empty($objRequestor->getLastModifiedOnOrAfter()) {
      $objUri = $objUri->withQueryValue($objUri, 'last_modified_on_or_after', $objRequestor->getLastModifiedOnOrAfter());
    }

    if (!empty($objRequestor->getLastModifiedBefore()) {
      $objUri = $objUri->withQueryValue($objUri, 'last_modified_before', $objRequestor->getLastModifiedBefore());
    }

    if (!empty($objRequestor->getLastModifiedOnOrBefore()) {
      $objUri = $objUri->withQueryValue($objUri, 'last_modified_on_or_before', $objRequestor->getLastModifiedOnOrBefore());
    }
  }

  /**
   * Returns search results available
   * 
   * @return array
   */
  public function results(SearchRequestor $objRequestor) : array {
    $objUri = new Uri();
    $strPath = self::ENDPOINT . '/results';

    // Search specific query values
    $objUri = $objUri->withQueryValue($objUri, 'per_page', $objRequestor->getPerPage());
    $objUri = $objUri->withQueryValue($objUri, 'page', $objRequestor->getPage());
    $objUri = $objUri->withQueryValue($objUri, 'order', $objRequestor->getOrder());
    return $this->execute($objRequestor, $objUri);
  }

  /**
   * Returns search result count
   */
  public function count(SearchRequestor $objRequestor) : array {
    $objUri = new Uri();
    $strPath = self::ENDPOINT . '/count';
    return $this->execute($objRequestor, $objUri);
  }

  /**
   * Returns search summary details
   */
  public function summary(SearchRequestor $objRequestor) : array {
    $objUri = new Uri();
    $strPath = self::ENDPOINT . '/summary';
    return $this->execute($objRequestor, $objUri);
  }

  /**
   * Returns search result counts by date
   */
  public function countsDaily(SearchRequestor $objRequestor) : array {
    $objUri = new Uri();
    $strPath = self::ENDPOINT . '/counts/daily';
    return $this->execute($objRequestor, $objUri);
  }

  /**
   * Returns search result counts by title
   */
  public function countsTitle(SearchRequestor $objRequestor) : array {
    $objUri = new Uri();
    $strPath = self::ENDPOINT . '/counts/titles';
    return $this->execute($objRequestor, $objUri);
  }

  /**
   * Returns search result counts by hierarchy
   */
  public function countsDaily(SearchRequestor $objRequestor) : array {
    $objUri = new Uri();
    $strPath = self::ENDPOINT . '/counts/hierarchy';
    return $this->execute($objRequestor, $objUri);
  }

  /**
   * Returns search suggestions
   */
  public function suggestions(SearchRequestor $objRequestor) : array {
    $objUri = new Uri();
    $strPath = self::ENDPOINT . '/counts/suggestions';
    return $this->execute($objRequestor, $objUri);
  }

  /**
   * Execute our query as it is passed by the parent function.
   */
  private function execute(SearchRequestor $objRequestor, Uri $objUri) : array {
    $this->standardSet($objRequestor, $objUri);
    return $this->objApi->getArray($objUri->withPath($strPath));
  }
}