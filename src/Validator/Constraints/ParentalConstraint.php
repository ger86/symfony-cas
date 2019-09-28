<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ParentalConstraint extends Constraint {

    public $message = '"{{ string }}" es peligroso para tus hijos';

    public function validatedBy() {
        return \get_class($this).'Validator';
    }
}