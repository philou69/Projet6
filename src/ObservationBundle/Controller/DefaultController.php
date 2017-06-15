<?php

namespace ObservationBundle\Controller;

use ObservationBundle\Entity\Message;
use ObservationBundle\Entity\Picture;
use ObservationBundle\Form\Message\MessageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $pictures = new Picture();

        $gallery = $em->getRepository('ObservationBundle:Picture')->getPictureGallery();

        $device = $this->get('mobile_detect.mobile_detector');
        if ($device->isMobile() || $device->isTablet()) {

            return $this->render('@Observation/Home/Mobile/home.html.twig', array('gallery' => $gallery));
        }else{
            return $this->render('@Observation/Home/Desktop/home.html.twig', array('gallery' => $gallery));
        }
    }

    public function contactAction(Request $request)
    {
        $message = new Message();
        $message->setPostedAt(new \DateTime());
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();
            $this->get('observation.contact.mailer')->sendMessage($message);
            $this->addFlash('success', 'Votre message à bien été envoyer!');
            return $this->redirectToRoute('contact');
        }

        $device = $this->get('mobile_detect.mobile_detector');
        if($device->isMobile() || $device->isTablet()){
            return $this->render('@Observation/Association/Mobile/contact.html.twig', array('form' => $form->createView()));
        }else{
            return $this->render('@Observation/Association/Desktop/contact.html.twig', array('form' => $form->createView()));
        }
    }

    public function faqAction()
    {
        $device = $this->get('mobile_detect.mobile_detector');
        if($device->isMobile() || $device->isTablet()){
            return $this->render('@Observation/Association/Mobile/faq.html.twig');
        }else{
            return $this->render('@Observation/Association/Desktop/faq.html.twig');
        }
    }
}
