<?php

namespace Onest\EshopParamsBundle\Tests;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\ORM\EntityManager;

class CategoryTest extends KernelTestCase
{
    /**
     * @var EntityManager
     */
    private $em;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->em = $kernel->getContainer()->get('doctrine')->getManager();
    }

    public function testCategoryWithoutParameters()
    {
        $repo = $this->em->getRepository(Category::class);
        $c1 = $repo->findOneBy(['seo_slug' => 'c1']);
        $this->assertEquals(null, $c1->getCategoryGroupWithParents());
    }

    public function testCategoryWithOwnParameters()
    {
        $repo = $this->em->getRepository(Category::class);
        $c2 = $repo->findOneBy(['seo_slug' => 'c2']);
        $this->assertNotEquals(null, $c2->getCategoryGroupWithParents());
        $this->assertEquals(1, count($c2->getCategoryGroupWithParents()->getparameters()->toArray()));
    }

    public function testCategoryWithParentParameters()
    {
        $repo = $this->em->getRepository(Category::class);
        $c3 = $repo->findOneBy(['seo_slug' => 'c3']);
        $this->assertNotEquals(null, $c3->getCategoryGroupWithParents());
        $this->assertEquals(1, count($c3->getCategoryGroupWithParents()->getparameters()->toArray()));
    }

    public function testProductWith2CategoriesParentFirst()
    {
        $repo = $this->em->getRepository(Product::class);
        $p1 = $repo->findOneBy(['slug' => 'p1']);
        $params = $p1->getParametersClasses();
        $this->assertTrue(count(array_filter($params, function($a) { return $a->getName() === 'parameter2'; })) > 0);
    }

    public function testProductWith2CategoriesChildFirst()
    {
        $repo = $this->em->getRepository(Product::class);
        $p2 = $repo->findOneBy(['slug' => 'p2']);
        $params = $p2->getParametersClasses();
        $this->assertTrue(count(array_filter($params, function($a) { return $a->getName() === 'parameter2'; })) > 0);
    }

    public function testProductWith1CategoryWithOwnParameters()
    {
        $repo = $this->em->getRepository(Product::class);
        $p3 = $repo->findOneBy(['slug' => 'p3']);
        $params = $p3->getParametersClasses();

        $this->assertTrue(count(array_filter($params, function($a) { return $a->getName() === 'parameter2'; })) > 0);
    }

    public function testProductWith1CategoryWithParentParameters()
    {
        $repo = $this->em->getRepository(Product::class);
        $p4 = $repo->findOneBy(['slug' => 'p4']);
        $params = $p4->getParametersClasses();
        $this->assertTrue(count(array_filter($params, function($a) { return $a->getName() === 'parameter1'; })) > 0);
    }

    public function testProductWith2CategoriesWithParentParameters()
    {
        $repo = $this->em->getRepository(Product::class);
        $p5 = $repo->findOneBy(['slug' => 'p5']);
        $params = $p5->getParametersClasses();
        $this->assertTrue(count(array_filter($params, function($a) { return $a->getName() === 'parameter1'; })) > 0);
    }

    public function testProductWith1CategoryTopLevel()
    {
        $repo = $this->em->getRepository(Product::class);
        $p6 = $repo->findOneBy(['slug' => 'p6']);
        $params = $p6->getParametersClasses();
        $this->assertTrue(count(array_filter($params, function($a) { return $a->getName() === 'parameter1'; })) > 0);
    }
}
