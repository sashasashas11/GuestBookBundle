<?php
/**
 * Created by JetBrains PhpStorm.
 * User: sasha
 * Date: 20.10.13
 * Time: 15:44
 * To change this template use File | Settings | File Templates.
 */

namespace Acme\GuestBookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\GuestBookBundle\Entity\GuestBook as Book;
use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\HttpFoundation\Request;

class GuestBookController extends Controller{

	public function addAction()
	{
		$book = new Book();
//		$form = $this->createFormBuilder()
//			->add('name', 'text')
//			->add('email', 'text')
//			->add('message', 'textarea')
//			->getForm();

		$form = $this->get('form.factory')
			->createBuilder('form', $book)
			->add('name', 'text')
			->add('email', 'text')
			->add('message', 'textarea')
			->getForm();

//		$request= $this->getRequest();
		$request= $this->get('request');

		if ($request->getMethod() == 'POST') {
			$form->bindRequest($request);

			if ($form->isValid()) {
				$em = $this->getDoctrine()->getEntityManager();
				$em->persist($book);
				$em->flush();
				return   $this->redirect($this->generateUrl('list'));
			}
		}

		return $this->render('AcmeGuestBookBundle:Default:add.html.twig', array(
			'form' => $form->createView(),
		));
	}

	public function listAction()
	{
		$books = $this->getDoctrine()->getRepository('AcmeGuestBookBundle:GuestBook')->findAll();
		return $this->render('AcmeGuestBookBundle:Default:list.html.twig', array('books'=>$books));
	}

	public function bookAction()
	{
		$book = new Book();
		$book->setName('sasha');
		$book->setEmail('sasha@i.ua');
		$book->setMessage('aaaaa');
		$book->setDate(new \DateTime());
		$em = $this->getDoctrine()->getEntityManager();
		$em->persist($book);
		$em->flush();
		return $this->render('AcmeGuestBookBundle:Default:list.html.twig');
	}

//	public function addBookAction(Request $request)
//	{
//		$book = new Book();
//		$book->setName('sasha');
//		$book->setEmail('sasha@i.ua');
//		$book->setMessage('aaaaa');
//		$book->setDate(new \DateTime());
//		$em = $this->getDoctrine()->getEntityManager();
//		$em->persist($book);
//		$em->flush();
//		if ($request->getMethod() == 'POST') {
////			$form->bindRequest($request);
//			var_dump('aaaaaa');
//			exit;
//		}
//
////		return $this->render('AcmeGuestBookBundle:Default:list.html.twig');
//	}

}