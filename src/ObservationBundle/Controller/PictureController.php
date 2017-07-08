<?php

namespace ObservationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PictureController extends Controller
{

    public function gallerieAction()
    {
        $em = $this->getDoctrine()->getManager();
        $gallery = $em->getRepository('ObservationBundle:Picture')->findAll();
        return $this->render('ObservationBundle:Picture/Desktop:gallery.html.twig', array('gallery' => $gallery));
    }

    public function paginationAction($page, Request $request)
    {
        // On vérifie s'il s'agit d'une reuqete ajax
        if ($request->isXmlHttpRequest()) {
            // On verifie le numero de la page
            // Superieur à 0, on recuper la liste
            if ($page > 0) {
                // On définit la quantité d'oiseaux
                $number = 12;
                $em = $this->getDoctrine()->getManager();


                // On effectue la requete doctrine getPage()
                $pictures = $em->getRepository('ObservationBundle:Picture')->getPage(
                    $page,
                    $number
                );


//                $user = $em->getRepository('ObservationBundle:Picture')->getUserPicture();

                // On calcul le nombre de page max
                $nbPage = ceil(count($pictures) / $number);

                if ($nbPage < 1 && $nbPage < $page) {
                    // Si le nombre de page est inferieur à 1 ou superieur à la page, on mets tout à null
                    $pictures = null;
                    $nbPage = null;
                }
            } else {
                // Sinon on passe tout à null
                $pictures = null;
                $nbPage = null;
            }



            $device = $this->get('mobile_detect.mobile_detector');
            if ($device->isMobile() || $device->isTablet()) {
                return $this->render(
                    '@Observation/Picture/Mobile/page.gallerie.html.twig', compact('pictures', 'nbPage', 'page', 'number','user')

                );
            } else {
                return $this->render(
                    '@Observation/Picture/Desktop/page.gallerie.html.twig',
                    compact('pictures', 'nbPage', 'page', 'number', 'user')
                );
            }
        } else {
            throw $this->createAccessDeniedException('Vous n\'avez pas le droit d\'être içi !');
        }
    }
}