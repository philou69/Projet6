<?php


namespace ObservationBundle\Controller;


use ObservationBundle\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
    public function resendAction(Message $message, Request $request)
    {
        // On verife être en requete AJAX
        if ($request->isXmlHttpRequest()) {
            // On vérifie si le message n'a pas été recu
            if ($message->getReceived() === false) {
                // on le renvoye et on fais un message flash
                $this->get('observation.contact.mailer')->sendMessage($message);
            }
            return new JsonResponse(array('status' => 'Le mail a bien été envoyer'));
        }
    }

    public function receivedAction(Message $message, Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $message->setReceived(true);
            $em->persist($message);
            $em->flush();
            return new JsonResponse(array('status' => 'OK', 'message' => 'L\'été de l\'email a bien été modifier'));
        }
    }

    public function answeredAction(Message $message, Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $message->setAnswered(true)
                ->setReceived(true);
            $em->persist($message);
            $em->flush();
            return new JsonResponse(array('status' => 'OK', 'message' => 'L\'été de l\'email a bien été modifier'));
        }
    }

    public function refreshAction()
    {
        $em = $this->getDoctrine()->getManager();
        $messages = $em->getRepository('ObservationBundle:Message')->findAllOrdering();

        return $this->render('@Observation/Association/Desktop/messages.html.twig', array('messages' => $messages));
    }
}
