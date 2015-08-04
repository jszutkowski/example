<?php
namespace AppBundle\Service;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\ORM\EntityManager;
use AppBundle\Exception\InvalidDataException;
use AppBundle\Entity\User;

/**
 * Description of EmailChanger
 *
 * @author Jarek
 */
class EmailChanger 
{
    /**
     *
     * @var EntityManager 
     */
    protected $manager;
    
    /**
     *
     * @var ValidatorInterface 
     */
    protected $validator;
    
    /**
     *
     * @var string[]
     */
    protected $errors;
    
    public function __construct(EntityManager $manager, ValidatorInterface $validator)
    {
        $this->manager = $manager;
        $this->validator = $validator;
    }
    
    /**
     * @param string $username
     * @param string $email
     * @throws NotFoundHttpException|InvalidDataException
     */
    public function change($username, $email)
    {        
        $user = $this->manager->getRepository('AppBundle:User')->findOneBy(array ('username' => $username));
        
        if (!$user)
        {
            throw new NotFoundHttpException();
        }        

        $user->setEmail($email);
        
        if (!$this->isUserValid($user))
        {
            throw new InvalidDataException();
        }
        
        $this->manager->persist($user);
        $this->manager->flush();
    }
    
    /**
     * 
     * @param User $user
     * @return boolean
     */
    protected function isUserValid(User $user)
    {
        $this->errors = $this->validator->validate($user);        

        return count ($this->errors) == 0;
    }
    
    function getErrors()
    {
        return $this->errors;
    }
}
