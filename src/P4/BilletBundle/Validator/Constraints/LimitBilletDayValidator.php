<?php 

namespace P4\BilletBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\EntityManager;
use P4\BilletBundle\Entity\Billets;

class LimitBilletDayValidator extends ConstraintValidator 
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function validate($formulaire, Constraint $constraint)
    {
        $nbBillets = $this->em->getRepository(Billets::class)->countNbBilletPerDate($formulaire->getDate());
        if ($nbBillets + count($formulaire->getBillets()) > 0)
        {
            $this->context->buildViolation("Limite atteinte")->addViolation();
        }
    }
}