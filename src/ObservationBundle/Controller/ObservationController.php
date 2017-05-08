<?php


namespace ObservationBundle\Controller;


use ObservationBundle\Entity\Location;
use ObservationBundle\Entity\Observation;
use ObservationBundle\Form\Location\LocationType;
use ObservationBundle\Form\Observation\AddObservationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ObservationController extends Controller
{
    public function listAction()
    {
        $location = new Location();
        $form = $this->createForm(LocationType::class, $location);
        return $this->render(
            'ObservationBundle:Observation:Desktop/list.html.twig', array(
            'form' => $form->createView()
        ));

    }

    public function viewAction(Observation $observation)
    {
        return $this->render(
            'ObservationBundle:Observation:Desktop/view.html.twig');
    }

    public function addAction(Request $request)
    {
        $observation = new Observation();

        $form = $this->createForm(AddObservationType::class, $observation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            echo 'test Reussi';
            return $this->redirectToRoute('observation_list');
        }

        return $this->render(
            'ObservationBundle:Observation:Desktop/add.html.twig', array(
            'form' => $form->createView()
        ));

    }

    /**
     * @Security(has_role('ROLE_NATURALISTE')
     */
    public function validateAction(Observation $observation)
    {
        return $this->render(
            'ObservationBundle:Observation:Desktop/validate.html.twig');

    }

    /**
     * @Security(has_role('ROLE_NATURALISTE)
     */
    public function unvalideAction(Observation $observation)
    {
        return $this->render(
            'ObservationBundle:Observation:Desktop/unvalidate.html.twig');

    }
}