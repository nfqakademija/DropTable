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
        // Get book.
        $book = $event->getData();

        // Get submitted categories.
        $subCatNames = $book['categories'];

        // Get all existing categories.
        $existCat = $this->catalog->listCategories();

        // Put existing categories' names into array.
        $existCatNames = [];
        foreach ($existCat as $category) {
            $existCatNames[] = $category->getName();
        }

        // Put existing categories' ids into array.
        $existCatIds = [];
        foreach ($existCat as $category) {
            $existCatIds[] = $category->getId();
        }

        // Iterate over submitted categories and check if they exist in db already.
        foreach ($subCatNames as $category) {
            if (!in_array($category, $existCatNames) && !in_array($category, $existCatIds)) {
                $this->catalog->createCategory($category);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'DropTable\LibraryBundle\Entity\Book',
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
