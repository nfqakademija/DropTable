<?php

namespace LibraryBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isbn')
            ->add('title')
            ->add('author')
            ->add(
                'category',
                'entity',
                [
                    'class' => 'LibraryBundle:Category',
                    'property' => 'name'
                ]
            )
            ->add('publisher')
            ->add('description', 'textarea')
            ->add('pages')
            ->add('created_at', 'date')
            ->add('Save', 'submit');
    }

    public function getName()
    {
        return 'library_book';
    }
}