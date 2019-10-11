<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use App\Entity\Access;

class AccessController extends AbstractController
{
    /**
     * @Route("/access/", name="access")
     */
    public function index()
    {
       $repo = $this->getDoctrine()->getRepository(Access::class);
       $access = $repo->findAll();
       return $this->render('access/index.html.twig', [
            'controller_name' => 'AccessController',
            'access' => $access
        ]);
    }
}
