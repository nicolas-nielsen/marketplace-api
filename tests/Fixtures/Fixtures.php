<?php

declare(strict_types=1);

namespace App\Tests\Fixtures;

use App\Domain\Category\Category;
use App\Domain\Product\Product;
use App\Domain\User\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Fixtures extends Fixture
{
    /** @var Category[] */
    private array $categories = [];

    /** @var Product[] */
    private array $products = [];

    /** @var User[] */
    private array $users = [];

    public function load(ObjectManager $manager): void
    {
        $this->loadCategories($manager);
        $this->loadProducts($manager);
        $this->loadUsers($manager);
    }

    private function loadCategories(ObjectManager $manager): void
    {
        $this->categories[FixtureIds::CATEGORY_ROOT] = Category::createFixture([
            'id' => FixtureIds::CATEGORY_ROOT,
            'title' => 'Root Category',
            'description' => 'Root category',
            'slug' => 'root',
            'level' => 0,
        ]);
        $manager->persist($this->categories[FixtureIds::CATEGORY_ROOT]);

        $this->categories[FixtureIds::CATEGORY_APPAREL] = Category::createFixture([
            'id' => FixtureIds::CATEGORY_APPAREL,
            'title' => 'Category Apparel',
            'description' => 'Clothes and accessories',
            'slug' => 'apparel',
            'level' => 1,
            'parent' => $this->categories[FixtureIds::CATEGORY_ROOT],
        ]);
        $manager->persist($this->categories[FixtureIds::CATEGORY_APPAREL]);

        $manager->flush();
    }

    private function loadProducts(ObjectManager $manager): void
    {
        $this->products[FixtureIds::PRODUCT_1] = Product::createFixture([
            'id' => FixtureIds::PRODUCT_1,
            'title' => 'Atmosphere Hoodie',
            'description' => 'Rhymesayers atmosphere hoodie blue',
            'slug' => 'atmosphere-hoodie',
            'status' => 'new',
            'category' => $this->categories[FixtureIds::CATEGORY_APPAREL],
            'createdAt' => new \DateTime('2024-01-01 10:00:00'),
            'updatedAt' => new \DateTime('2024-01-01 10:00:00'),
        ]);

        $this->products[FixtureIds::PRODUCT_2] = Product::createFixture([
            'id' => FixtureIds::PRODUCT_2,
            'title' => 'The Clash T-shirt',
            'description' => 'The Clash t-shirt short sleeves',
            'slug' => 'the-clash-t-short-sleeves',
            'status' => 'new',
            'category' => $this->categories[FixtureIds::CATEGORY_APPAREL],
            'createdAt' => new \DateTime('2024-01-01 10:00:00'),
            'updatedAt' => new \DateTime('2024-01-01 10:00:00'),
        ]);

        $manager->persist($this->products[FixtureIds::PRODUCT_1]);
        $manager->persist($this->products[FixtureIds::PRODUCT_2]);

        $manager->flush();
    }

    private function loadUsers(ObjectManager $manager): void
    {
        $this->users[FixtureIds::USER_1] = User::createFixture([
            'id' => FixtureIds::USER_1,
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'john.doe@test.com',
            'password' => 'tictactoe',
            'createdAt' => new \DateTime('2024-01-01 10:00:00'),
            'updatedAt' => new \DateTime('2024-01-01 10:00:00'),
        ]);

        foreach ($this->users as $user) {
            $manager->persist($user);
        }

        $manager->flush();
    }
}
