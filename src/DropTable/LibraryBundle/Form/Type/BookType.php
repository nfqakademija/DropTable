<?php

namespace DropTable\LibraryBundle\Form\Type;

use DropTable\LibraryBundle\Service\CatalogService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class BookType.
 *
 * @package DropTable\LibraryBundle\Form\Type
 */
class BookType extends AbstractType
{
    /**
     * @var CatalogService
     */
    private $catalog;

    /**
     * @param CatalogService $catalog
     */
    public function __construct(CatalogService $catalog)
    {
        $this->catalog = $catalog;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isbn')
            ->add('title')
            ->add(
                'categories',
                'entity',
                [
                    'class' => 'DropTableLibraryBundle:Category',
                    'property' => 'name',
                    'multiple' => true,
                    'required' => false,
                ]
            )
            ->add(
                'authors',
                'collection',
                [
                    'type' => new AuthorType(),
                    'allow_add' => true,
                ]
            )
            ->add(
                'publisher',
                'entity',
                [
                    'class' => 'DropTableLibraryBundle:Publisher',
                    'property' => 'name',
                ]
            )
            ->add('thumbnail_small', new ImageType(), ['image_path' => 'thumbnail_small'])
            ->add('description', 'textarea')
            ->add('pages')
            ->add('created_at', 'date')
            ->add('Save', 'submit')
            ->addEventListener(
                FormEvents::PRE_SUBMIT,
                [$this, 'addMissingCategories']
            );
    }

    /**
     * @param FormEvent $event
     */
    public function addMissingCategories(FormEvent $event)
    {
        $form = $event->getForm();

        $form->remove('categories')
            ->add(
                'categories',
                'choice',
                [
                    'choices' => ['asd', 'asd', 'mmm'],
                    'required' => false,
                    'multiple' => true,
                ]
            );

//        $form = $event->getForm();
//        $form->remove('categories')
//            ->add(
//                'categories',
//                'entity',
//                [
//                    'class' => 'DropTableLibraryBundle:Category',
//                    'property' => 'name',
//                    'multiple' => true,
//                ]
//            );
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'DropTable\LibraryBundle\Entity\Book',
                'attr' => ['id' => 'add-edit-book'],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'library_book';
    }
}
