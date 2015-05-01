<?php

namespace DropTable\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

    /**
     * Class ProfileFormType
     * @package DropTable\UserBundle\Form\Type
     */
class ProfileFormType extends AbstractType
{
    /**
     * Builds the embedded form representing the user.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('username')
            ->add('firstName', null, ['label' => 'form.first_name', 'translation_domain' => 'FOSUserBundle'])
            ->add('lastName', null, ['label' => 'form.last_name', 'translation_domain' => 'FOSUserBundle']);
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'fos_user_profile';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dt_user_profile';
    }
}
