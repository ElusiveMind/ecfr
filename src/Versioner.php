<?php

namespace eCFR;

use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\Response;
use eCFR\Requestor\VersionerRequestor;
use LogicException;

final class Package {

  use EndpointTrait;

  private const ENDPOINT = 'api/versioner/v1';

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
    if (!empty($objRequestor->getSubtitle()) {
      $objUri = $objUri->withQueryValue($objUri, 'subtitle', $objRequestor->getSubtitle());
    }

    if (!empty($objRequestor->getChapter()) {
      $objUri = $objUri->withQueryValue($objUri, 'chapter', $objRequestor->getChapter());
    }

    if (!empty($objRequestor->getSubchapter()) {
      $objUri = $objUri->withQueryValue($objUri, 'subchapter', $objRequestor->getSubchapter());
    }

    if (!empty($objRequestor->getPart()) {
      $objUri = $objUri->withQueryValue($objUri, 'part', $objRequestor->getPart());
    }

    if (!empty($objRequestor->getSubpart()) {
      $objUri = $objUri->withQueryValue($objUri, 'subpart', $objRequestor->getSubpart());
    }

    if (!empty($objRequestor->getSection()) {
      $objUri = $objUri->withQueryValue($objUri, 'section', $objRequestor->getSection());
    }

    if (!empty($objRequestor->getAppendix()) {
      $objUri = $objUri->withQueryValue($objUri, 'appendix', $objRequestor->getAppendix());
    }
  }

  /**
   * Ancestors route returns all ancestors (including self)
   * from a given level through the top title node
   *
   * @param VersionerRequestor $objRequestor
   * @return array
   */
  public function ancestry(VersionerRequestor $objRequestor) : array {
    $this->requireTitle($objRequestor);
    $this->requireDate($objRequestor);

    $objUri = new Uri();
    $objUri = $objUri->withQueryValue($objUri, 'title', $objRequestor->getTitle());
    $objUri = $objUri->withQueryValue($objUri, 'date', $objRequestor->getDate());
    $this->standardSet($objRequestor, $objUri);

    $strPath = self::ENDPOINT . '/ancestry/' . $objRequestor->getDate() . '/title-' . $objRequestor->getTitle() . '.json';
    return $this->objApi->getArray($objUri->withPath($strPath));
  }

  public function full(VersionerRequestor $objRequestor) : array {
    $this->requireTitle($objRequestor);
    $this->requireDate($objRequestor);

    $objUri = new Uri();
    $objUri = $objUri->withQueryValue($objUri, 'title', $objRequestor->getTitle());
    $objUri = $objUri->withQueryValue($objUri, 'date', $objRequestor->getDate());
    $this->standardSet($objRequestor, $objUri);

    $strPath = self::ENDPOINT . '/full/' . $objRequestor->getDate() . '/title-' . $objRequestor->getTitle() . '.xml';
    return $this->objApi->parseXML($objUri->withPath($strPath));
  }

  public function structure(VersionerRequestor $objRequestor) : array {
    $this->requireTitle($objRequestor);
    $this->requireDate($objRequestor);

    $strPath = self::ENDPOINT . '/structure/' . $objRequestor->getDate() . '/title-' . $objRequestor->getTitle() . '.json';
    return $this->objApi->getArray($objUri->withPath($strPath));
  }

  public function versions() : array {
    $strPath = self::ENDPOINT . '/versions.json';
    return $this->objApi->getArray($objUri->withPath($strPath));
  }

  public function versionsTitle(VersionerRequestor $objRequestor) : array {
    $this->requireTitle($objRequestor);
    $strPath = self::ENDPOINT . '/versions/' . '/title-' . $objRequestor->getTitle() . '.json';
    return $this->objApi->getArray($objUri->withPath($strPath));
  }

  public function corrections() : array {
    $strPath = self::ENDPOINT . '/corrections.json';
    return $this->objApi->getArray($objUri->withPath($strPath));
  }

  private function requireDate(VersionerRequestor $objRequestor) : void {
    if (empty($objRequestor->getDate())) {
      throw new \LogicException('Date is required.');
    }
  }

  private function requireTitle(VersionerRequestor $objRequestor) : void {
    if (empty($objRequestor->getTitle())) {
      throw new \LogicException('Title is required.');
    }
  }
}