<?php


namespace ObservationBundle\Controller;


use ObservationBundle\Entity\User;
use ObservationBundle\Form\Type\User\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LandingPageController extends Controller
{
    public function page1Action(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user, ['action' => $this->generateUrl('user_connect')]);
        $form->handleRequest($request);

        return $this->render('@Observation/LandingPage/Desktop/view.html.twig', array('form' => $form->createView()));
    }

    public function page2Action()
    {
        return $this->render('@Observation/LandingPage/Desktop/view.html.twig');
    }
}