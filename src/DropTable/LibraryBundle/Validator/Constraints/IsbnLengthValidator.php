<?php
namespace DropTable\LibraryBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class IsbnLengthValidator.
 *
 * @package DropTable\LibraryBundle\Validator\Constraints
 */
class IsbnLengthValidator extends ConstraintValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        $length = strlen($value);
        if ($length != 10) {
            if ($length != 13) {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('%string%', $value)
                    ->addViolation();
            }
        }
    }
}
