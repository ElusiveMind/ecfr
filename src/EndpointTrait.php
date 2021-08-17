<?php

namespace eCFR;

trait EndpointTrait {
  public function getObjApi() : Api {
    return $this->objApi;
  }
}