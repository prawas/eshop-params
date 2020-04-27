<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\Category;
use Onest\EshopParamsBundle\Entity\CategoryGroup;
use Onest\EshopParamsBundle\Entity\ParameterClass;
use App\Entity\Product;

class CategoryFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $category1 = (new Category())
            ->setTitle('Категория без параметров')
            ->setSeoSlug('c1')
        ;
        $manager->persist($category1);

        $group1 = (new CategoryGroup())
            ->addParameter(
                (new ParameterClass())
                ->setType('int')
                ->setName('parameter1')
            )
        ;
        $manager->persist($group1);

        $category2 = (new Category())
            ->setTitle('Категория с параметрами')
            ->setCategoryGroup($group1)
            ->setSeoSlug('c2')
        ;
        $manager->persist($category2);

        $category3 = (new Category())
            ->setTitle('Категория с параметрами через родителя')
            ->setParent($category2)
            ->setSeoSlug('c3')
        ;
        $manager->persist($category3);

        $group2 = (new CategoryGroup())
            ->addParameter(
                (new ParameterClass())
                ->setType('int')
                ->setName('parameter2')
            )
        ;
        $manager->persist($group2);

        $category4 = (new Category())
            ->setTitle('Категория 2го уровня с параметрами')
            ->setParent($category2)
            ->setCategoryGroup($group2)
            ->setSeoSlug('c4')
        ;
        $manager->persist($category4);

        $product1 = (new Product())
            ->setTitle('Продукт с двумя категориями, сначала родительская')
            ->addCategory($category2)
            ->addCategory($category4)
            ->setSlug('p1')
        ;
        $manager->persist($product1);

        $product2 = (new Product())
            ->setTitle('Продукт с двумя категориями, сначала дочерняя')
            ->addCategory($category4)
            ->addCategory($category2)
            ->setSlug('p2')
        ;
        $manager->persist($product2);

        $product3 = (new Product())
            ->setTitle('Продукт с категорией с собственными параметрами')
            ->addCategory($category4)
            ->setSlug('p3')
        ;
        $manager->persist($product3);

        $product4 = (new Product())
            ->setTitle('Продукт с категорией с параметрами через родителя')
            ->addCategory($category3)
            ->setSlug('p4')
        ;
        $manager->persist($product4);

        $product5 = (new Product())
            ->setTitle('Продукт с двумя категориеями с параметрами через родителя')
            ->addCategory($category3)
            ->addCategory($category1)
            ->setSlug('p5')
        ;
        $manager->persist($product5);

        $product6 = (new Product())
            ->setTitle('Продукт с категорией верхнего уровня с параметрами')
            ->addCategory($category2)
            ->setSlug('p6')
        ;
        $manager->persist($product6);

        $manager->flush();
    }
}
