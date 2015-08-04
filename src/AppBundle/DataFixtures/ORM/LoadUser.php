<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

use AppBundle\Entity\User;

class LoadUser extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{    
    /**
     * @var EncoderFactoryInterface 
     */
    private $encoderFactory;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->encoderFactory = $container->get('security.encoder_factory');
    }    
    
    public function load(ObjectManager $manager)
    {
        $password = "SecretPassword";
        
        $user = new User();
        $user->setUsername('rafael');
        $user->setPassword($this->getEncoder($user)->encodePassword($password, $user->getSalt()));
        $user->setName('Rafael');
        $user->setEmail('rafael@example.com');
        $manager->persist($user);
        
        $user2 = new User();
        $user2->setUsername('donatello');
        $user2->setPassword($this->getEncoder($user2)->encodePassword($password, $user2->getSalt()));
        $user2->setName('Donatello');
        $user2->setEmail('donatello@example.com');
        $manager->persist($user2);
        
        $user3 = new User();
        $user3->setUsername('michelangelo');
        $user3->setPassword($this->getEncoder($user3)->encodePassword($password, $user3->getSalt()));
        $user3->setName('Michelangelo');
        $user3->setEmail('michelangelo@example.com');
        $manager->persist($user3);
        
        $user4 = new User();
        $user4->setUsername('leonardo');
        $user4->setPassword($this->getEncoder($user4)->encodePassword($password, $user4->getSalt()));
        $user4->setName('Leonardo');
        $user4->setEmail('leonardo@example.com');
        $manager->persist($user4);
        
        $manager->flush();
    }
    
    private function getEncoder(User $user)
    {
        return $this->encoderFactory->getEncoder($user);
    }

    public function getOrder()
    {
        return 1;
    }
}
