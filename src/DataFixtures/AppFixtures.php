<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\ProductCategory;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ){}

    public function load(ObjectManager $manager): void
    {
        //Creating 1 admin
        $admin = new User();
        $admin->setName('Admin');
        $admin->setEmail('admin@gmail.com');
        $admin->setPassword(
            $this->passwordHasher->hashPassword($admin, ('admin'))
        );
        $admin->setRoles([
            'ROLE_ADMIN'
        ]);
        $manager->persist($admin);
        $manager->flush();

        //50 Users
        $names = array("Emma", "Olivia", "Ava", "Isabella", "Sophia", "Mia", "Charlotte", "Amelia", "Harper", "Evelyn", "Abigail", "Emily", "Elizabeth", "Avery", "Ella", "Madison", "Scarlett", "Victoria", "Aubrey", "Grace", "Chloe", "Camila", "Penelope", "Riley", "Layla", "Lillian", "Natalie", "Aaliyah", "Hazel", "Lucy", "Audrey", "Mila", "Nova", "Willow", "Luna", "Savannah", "Aurora", "Sofia", "Eleanor", "Genesis", "Makayla", "Ariel", "Aurora", "Adalynn", "Arianna", "Allison", "Violet", "Kaylee", "Jackson", "Aiden", "Liam", "Oliver", "Elijah", "Mason", "Noah", "Ethan", "Logan", "James", "Benjamin", "Lucas", "Michael", "Alexander", "William", "Daniel", "Matthew", "Samuel");

        for($i = 0; $i < 50; $i++){
            $it = rand(0, 50);
            $name = $names[$it];
            $user = new User();
            $user->setName($name);
            $user->setEmail($name . $i . '@gmail.com');
            $user->setPassword(
                $this->passwordHasher->hashPassword($user, ($name . 'password'))
            );
            $user->setRoles([
                'ROLE_USER'
            ]);
            $manager->persist($user);
        }
        $manager->flush();

        //10 Categories
        for($i = 0; $i < 10; $i++){
            $productCategory = new ProductCategory();
            $productCategory->setName('Category' . $i);

            $manager->persist($productCategory);
        }
        $manager->flush();

        //20 products per categories
        $categories = $manager->getRepository(ProductCategory::class)->findAll();
        foreach ($categories as $category){
            for($i = 0; $i < 20; $i++){
                $product = new Product();
                $product->setName('Product' . $i);
                $product->setPrice((rand(599,29999))/100);
                $product->setStock(rand(1, 999));
                $product->setDescription('Abundans et sustentantur et abundans herbae penitus vidimus siquae abundans per et ignorantes herbae vini et alites copia penitus et usum plerosque qua usum plerosque per frumenti herbae abundans caro abundans qua est possint et possint frumenti aucupium lactisque plerosque vidimus per possint sustentantur multiplices vini plerosque possint est copia.');
                $product->setCategory($category);

                $manager->persist($product);
            }
        }
        $manager->flush();
    }
}
