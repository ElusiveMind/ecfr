<?php

namespace eCFR\Requestor;

use \DateTime;
use \LogicException;

final class VersionerRequestor {

  private $date = '';
  private $title = '';
  private $subtitle = '';
  private $chapter = '';
  private $subchapter = '';
  private $part = '';
  private $subpart = '';
  private $section = '';
  private $appendix = '';

  public function setDate(string $date) : self {
    if ($this->validateDate($date) === TRUE) {
      throw new LogicException('Date must be a valid yyyy-mm-dd value.');
    }
    $this->date = $date;
    return $this;
  }

  public function setTitle(string $title) : self {
    $this->title = $title;
    return $this;
  }

  public function setSubtitle(string $subtitle) : self {
    $this->subtitle = $subtitle;
    return $this;
  }

  public function setChapter(string $chapter) : self {
    $this->chapter = $chapter;
    return $this;
  }

  public function setSubchapter(string $subchapter) : self {
    $this->subchapter = $subchapter;
    return $this;
  }

  public function setPart(string $part) : self {
    $this->part = $part;
    return $this;
  }

  public function setSubpart(string $subPart) : self {
    $this->subPart = $subPart;
    return $this;
  }

  public function setSection(string $section) : self {
    $this->section = $section;
    return $this;
  }

  public function setAppendix(string $appendix) : self {
    $this->appendix = $appendix;
    return $this;
  }
  
  public function getDate() : string {
    return $this->date;
  }

  public function getTitle() : string {
    return $this->title;
  }

  public function getSubtitle() :string {
    return $this->subtitle;
  }

  public function getChapter() : string {
    return $this->chapter;
  }

  public function getSubChapter() : string {
    return $this->subchapter;
  }

  public function getPart() : string {
    return $this->part;
  }

  public function getSubpart() : string {
    return $this->subpart;
  }

  public function getSection() : string {
    return $this->section;
  }

  public function getAppendix() : string {
    return $this->appendix;
  }

  /**
   * Check the date to make sure things passed to the API are valid.
   * https://stackoverflow.com/questions/19271381/correctly-determine-if-date-string-is-a-valid-date-in-that-format/19271434
   */
  private function validateDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number 
    // of digits so changing the comparison from == to === fixes the issue.
    return ($d && $d->format($format)) === $date;
  }
}