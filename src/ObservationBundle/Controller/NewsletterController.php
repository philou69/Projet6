<?php


namespace ObservationBundle\Controller;


use ObservationBundle\Entity\User;
use ObservationBundle\Form\Newsletter\UnscubscribeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NewsletterController extends Controller
{

    public function subscribeAction(Request $request)
    {
        $email = $request->request->get('email');

        if($this->getUser() && $this->getUser()->getEmail() !== $email){
            $this->addFlash('warning', 'Vous ne pouvez utiliser une autre adresse mail que celle de votre compte');

        }elseif ($this->getUser() && $this->getUser()->getNewsletter() === true){

        }
        else{
            $mailler = $this->get('observation.newsletter_listing');
            $mailler->addLisntingNewwsLetter( $this->getUser() == true ? $this->getUser(): null, $this->getUser() == true ? null : $email);

            if($this->getUser() && $mailler->isSuccess()){
                $em = $this->getDoctrine()->getManager();
                $this->getUser()->setNewsletter(true);
                $em->persist($this->getUser());
                $em->flush();
            }
            $this->addFlash(
                $mailler->isSuccess() == true ? 'success' : 'warning',
                $mailler->isSuccess() == true ? 'Votre email a bien été ajouté' : 'Votre email n\'a pas pu être ajouté!'
            );
        }
        return $this->redirectToRoute('homepage');
    }

    public function unsubscribeAction($email, Request $request)
    {
        $form = $this->createForm(UnscubscribeType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            // On evoyer le mail à MailChimp pour le retirer
            $mailer = $this->get('observation.user.mailer');
            $mailer->removeForListing($email);
            // Si le succes est au rendez vous, on regard s'il s'agit d'un visiteur
            if($mailer->isSuccess()){
                $em = $this->getDoctrine()->getManager();
                $user = $em->getRepository('ObservationBundle:User')->findOneBy(array('email' => $email));
                if($user){
                    $user->setNewsletter(false);
                    $em->flush();
                }
                $this->addFlash('success', 'Votre email a bien été retirer');
            }else{
                $this->addFlash('warning', "Votre email n'a pas pu être retirer de nos listes.");
            }
            return $this->render('@Observation/Newsletter/status.html.twig', array('email' => $email, 'status' => $mailer->isSuccess()));
        }

        $device = $this->get('mobile_detect.mobile_detector');
        if($device->isMobile() || $device->isTablet()){
            return $this->render('@Observation/Newsletter/Mobile/unsubscribe.html.twig', array('form' => $form->createView(), 'email' => $email));
        }else{
            return $this->render('@Observation/Newsletter/Desktop/unsubscribe.html.twig', array('form' => $form->createView(), 'email' => $email));
        }
    }

}