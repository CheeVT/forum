<?php

namespace App\Inspections;

use Exception;

class InvalidKeywords {

  protected $keywords = [
    'fuck you nigga',
    'vucicu pederu'
  ];

  public function detect($body) {
    foreach($this->keywords as $keyword) {
      if(stripos($body, $keyword) !== false) {
        throw new Exception('Your reply contains spam.');
      }
    }
  }
}