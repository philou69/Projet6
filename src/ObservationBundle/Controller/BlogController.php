<?php


namespace ObservationBundle\Controller;


use ObservationBundle\Entity\Content;
use ObservationBundle\Form\Content\ContentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends Controller
{

    public function viewAction(Content $content)
    {
        $device = $this->get('mobile_detect.mobile_detector');
        if($device->isMobile() || $device->isTablet()){
            return $this->render('ObservationBundle:Blog/Mobile:view.html.twig', array('content' => $content));
        }else{
            return $this->render('@Observation/Blog/Desktop/view.html.twig', array('content' => $content));
        }
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @param Content $content
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Content $content, Request $request)
    {
        $form = $this->createForm(ContentType::class, $content);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('blog_view', array('page' => 'blog'));
        }

        $device = $this->get('mobile_detect.mobile_detector');
        if($device->isMobile() || $device->isTablet()){
            return $this->render('@Observation/Blog/Mobile/edit.html.twig', array('form' => $form->createView()));
        }else{
            return $this->render('@Observation/Blog/Desktop/edit.html.twig', array('form' => $form->createView()));
        }
    }
}