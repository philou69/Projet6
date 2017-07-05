<?php

namespace ObservationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PictureController extends Controller
{

    public function gallerieAction()
    {
        $em = $this->getDoctrine()->getManager();
        $gallery = $em->getRepository('ObservationBundle:Picture')->findAll();
        return $this->render('ObservationBundle:Picture/Desktop:gallery.html.twig', array('gallery' => $gallery));
    }
}