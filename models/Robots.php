<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Mvc\Model\Message;
use Phalcon\Validation\Validator\Uniqueness as UniquenessValidator;
use Phalcon\Validation\Validator\InclusionIn as InclusionInValidator;

class Robots extends Model
{
    public function validation()
    {
        $validator = new Validation();

        // Robot name must be unique
        $validator->add(
            'name',
            new UniquenessValidator([
                'model' => $this,
                'message' => 'The robot name must be unique',
            ])
        );

        // Type must be: droid, mechanical or virtual
        $validator->add(
            "type",
            new InclusionInValidator([
              "message" => "The robot type must be droid, mechanical or virtual",
              "domain" => [
                  "droid",
                  "mechanical",
                  "virtual",
              ]
            ])
        );

        // Year cannot be less than zero
        if ($this->year < 0) {
            $this->appendMessage(
                new Message("The year cannot be less than zero")
            );
        }

        // Check if any messages have been produced
        if ($this->validationHasFailed() === true) {
            return false;
        }

        return $this->validate($validator);
    }
}