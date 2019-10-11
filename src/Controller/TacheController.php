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
use App\Entity\Tache;

class TacheController extends AbstractController
{
    /**
     * @Route("/test/", name="test")
     */
    public function test()
    {
        return $this->render('tache/test.html.twig', [
            'controller_name' => 'TacheController',
        ]);
    }
    /**
     * @Route("/tache", name="tache")
     */
    public function index()
    {
        return $this->render('tache/index.html.twig', [
            'controller_name' => 'TacheController',
        ]);
    }
    /**
     * @Route("/", name="tache_home")
     */
    public function home()
    {
       $repo = $this->getDoctrine()->getRepository(Tache::class);
       $taches = $repo->findBy(array('done' => '0' ), array('createdAt' => 'DESC' ));
       
      return $this->render('tache/home.html.twig', [
            'controller_name' => 'TacheController',
            'taches' => $taches
        ]);
    }
    /**
     * @Route("/todo/", name="tache_todos")
     */
    public function todo()
    {
       $repo = $this->getDoctrine()->getRepository(Tache::class);
       $taches = $repo->findBy(array('done' => '0' ), array('createdAt' => 'DESC' ));
       
      return $this->render('tache/todo.html.twig', [
            'controller_name' => 'TacheController',
            'taches' => $taches
        ]);
    }
     /**
     * @Route("/all/", name="tache_all")
     */
    public function all()
    {
       $repo = $this->getDoctrine()->getRepository(Tache::class);
       $taches = $repo->findBy(array('done' => array('0', '1') ), array('createdAt' => 'DESC' ));
       
      return $this->render('tache/all.html.twig', [
            'controller_name' => 'TacheController',
            'taches' => $taches
        ]);
    }
    /**
     * @Route("/done/", name="tache_done")
     */
    public function done()
    {
       $repo = $this->getDoctrine()->getRepository(Tache::class);
       $taches = $repo->findBy(array('done' => '1' ), array('createdAt' => 'DESC' ));
       
      return $this->render('tache/done.html.twig', [
            'controller_name' => 'TacheController',
            'taches' => $taches
        ]);
    }
    /**
     * @Route("/add/", name="tache_add")
     */
    public function add(Tache $tache = NULL, Request $request, ObjectManager $manager)
    {
      
        if(!$tache)
        {
            $tache = new Tache();
        }
        $now = new \DateTime('now');
        $form = $this->createFormBuilder($tache)
        ->add('client')
        ->add('title')
        ->add('content')
        ->add('createdAt', null, ['data' => $now])
        ->add('done', null, ['data' => '0'])
        ->add('save', SubmitType::class, ['label' => 'Envoyer'])
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($tache);
            $manager->flush();
            return $this->redirectToRoute('tache_todos');
        }   
        return $this->render('tache/add.html.twig', [
            'formTache' => $form->createView()
        ]);
    }
     /**
     * @Route("/edit/{id}/", name="tache_edit")
     */
    public function edit(Tache $tache = NULL, Request $request, ObjectManager $manager)
    {
        if(!$tache)
        {
            $tache = new Tache();
        }
        $now = new \DateTime('now');
        $form = $this->createFormBuilder($tache)
        ->add('client')
        ->add('title')
        ->add('content')
        ->add('createdAt')
        ->add('done')
        ->add('doneAt', null, ['data' => $now])
        ->add('duree')
        ->add('save', SubmitType::class, [
            'label' => 'Envoyer'
            
        ])
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($tache);
            $manager->flush();
            return $this->redirectToRoute('tache_todos');
        }   
        return $this->render('tache/add.html.twig', [
            'formTache' => $form->createView()
        ]);
    }
     /**
     * @Route("/setdone/", name="tache_setdone")
     */
    public function setdone(Request $request)
    {
        $id = $request->request->get('id');
        $done = $request->request->get('done');
        $manager = $this->getDoctrine()->getManager();
        $tache = $manager->getRepository(Tache::class)->find($id);
        $tache->setDone($done);
        $manager->flush();

        return $this->render('tache/operation.html.twig', [
            'controller_name' => 'TacheController',
            'id' => $id,
            'done' => $done
        ]);
    }

     /**
     * @Route("/delete/", name="tache_delete")
     */
    public function delete(Request $request)
    {
        $id = $request->request->get('id');
        $manager = $this->getDoctrine()->getManager();
        $tache = $manager->getRepository(Tache::class)->find($id);
        $manager->remove($tache);
        $manager->flush();
        
        return $this->render('tache/operation.html.twig', [
            'controller_name' => 'TacheController',
            'id' => $id
        ]);
    }
}
