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
//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\HttpFoundation\Request;

class GuestBookController extends Controller{

	public function addAction()
	{

		$book = new Book();
		$form = $this->createFormBuilder()
			->add('name', 'text')
			->add('email', 'text')
			->add('message', 'textarea')
			->getForm();


		$request= $this->get('request');
//		$form->handleRequest($request);

		if ($request->getMethod() == 'POST') {
			$form->handleRequest($request);

			if ($form->isValid()) {
				$date = $form->getData();
				$book->setName($date['name']);
				$book->setEmail($date['email']);
				$book->setMessage($date['message']);
				$book->setDate(new \DateTime());
				$em = $this->getDoctrine()->getManager();
				$em->persist($book);
				$em->flush();
				return   $this->redirect($this->generateUrl('acme_guest_book_list'));
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



}