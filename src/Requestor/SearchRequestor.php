<?php

namespace eCFR\Requestor;

final class SearchRequestor{
  private $query = NULL;
  private $date = NULL;
  private $lastModifiedAfter = NULL;
  private $lastModifiedBefore = NULL;
  private $lastModifiedOnOrAfter = NULL;
  private $lastModifiedOnOrBefore = NULL;
  private $perPage = 20;
  private $page = 1;
  private $order = 'relevance';

  public function setQuery(string $query) : self {
    if (!empty($query)) {
      $this->query = $query;
    }
    return $this;
  }
  
  public function getQuery() : string {
    return $this->query;
  }

  public function setDate(string $date) : self {
    if ($this->validateDate($date) === TRUE) {
      throw new LogicException('Search query date must be a valid yyyy-mm-dd value.');
    }
    $this->date = $date;
    return $this;
  }

  public function getDate() : string {
    return $this->date;
  }

  public function setPerPage(int $perPage) : self {
    if ($perPage < 0 || $perPage > 1000) {
      throw new LogicException('Results per page must be between 0 and 1000');
    }
    $this->perPage = $perPage;
    return $this;
  }

  public function getPerPage() : int {
    return $this->perPage;
  }

  public function setPage(int $page) : self {
    if ($page < 0 || $page > 10000) {
      throw new LogicException('The page being requested must be between 0 and 10000');
    }
    $this->page = $page;
    return $this;
  }

  public function getPage() : int {
    return $this->page;
  }

  public function setOrder(string $order) : self {
    $available = ['relevance', 'hierarchy', 'newest_first', 'oldest_first'];
    if (!in_array($order, $available)) {
      throw new LogicException('Order must be one of - relevance, hierarchy, newest_first or oldest_first');
    }
    $this->order = $order;
    return $this;
  }

  public function getOrder() : string {
    return $this->order;
  }

  public function setLastModifiedAfter(string $lastModifiedAfter) : self {
    if ($this->validateDate($lastModifiedAfter) === TRUE) {
      throw new LogicException('Last modified after date must be a valid yyyy-mm-dd value.');
    }
    $this->lastModifiedAfter = $lastModifiedAfter;
    return $this;
  }

  public function getLastModifiedAfter() : string  {
    return $this->lastModifiedAfter;
  }

  public function setLastModifiedBefore(string $lastModifiedBefore) : self {
    if ($this->validateDate($lastModifiedBefore) === TRUE) {
      throw new LogicException('Last modified before date must be a valid yyyy-mm-dd value.');
    }
    $this->lastModifiedBefore = $lastModifiedBefore;
    return $this;
  }

  public function getLastModifiedBefore() {
    return $this->lastModifiedBefore;
  }

  public function setlastModifiedOnOrAfter(string $lastModifiedOnOrAfter) : self {
    if ($this->validateDate($lastModifiedOnOrAfter) === TRUE) {
      throw new LogicException('Last modified on or after date must be a valid yyyy-mm-dd value.');
    }
    $this->lastModifiedOnOrAfter = $lastModifiedOnOrAfter;
    return $this;
  }

  public function getlastModifiedOnOrAfter() {
    return $this->lastModifiedOnOrAfter;
  }

  public function setlastModifiedOnOrBefore(string $lastModifiedOnOrBefore) : self {
    if ($this->validateDate($lastModifiedOnOrBefore) === TRUE) {
      throw new LogicException('Last modified on or before date must be a valid yyyy-mm-dd value.');
    }
    $this->lastModifiedOnOrBefore = $lastModifiedOnOrBefore;
    return $this;
  }

  public function getlastModifiedOnOrBefore() {
    return $this->lastModifiedOnOrBefore;
  }

  /**
   * Check the date to make sure things passed to the API are valid.
   * https://stackoverflow.com/questions/19271381/correctly-determine-if-date-string-is-a-valid-date-in-that-format/19271434
   */
  private function validateDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number 
    // of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
  }
}