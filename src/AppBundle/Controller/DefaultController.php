<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Exception\InvalidDataException;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;

class DefaultController extends FOSRestController
{
    /**
     * @Rest\View()
     */
    public function changeEmailAction(Request $request, $username)
    {
        $user = $this->getDoctrine()->getRepository("AppBundle:User")->findOneBy(array ('username' => $username));

        if (!$user)
        {
            throw new NotFoundHttpException();
        }
        
        if (!$this->getEncoder($user)->isPasswordValid($user->getPassword(), $request->get('password'), $user->getSalt()))
        {
            throw new InvalidDataException("Invalid password");
        }
        
        $form = $this->createForm(new UserType(), $user, array ("method" => "PUT"));
        
        $form->handleRequest($request);
        
        if ($form->isValid())
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($form->getData());
            $manager->flush();
            
            return View::create(null, 204);
        }
        return View::create($form, 400);
    }
    
    protected function getEncoder(User $user)
    {
        return $this->get('security.encoder_factory')->getEncoder($user);
    }
}
