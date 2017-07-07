<?php


namespace ObservationBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    /**
     * @Security("has_role('ROLE_NATURALISTE')")
     * @param Request $request
     * @return BinaryFileResponse
     */
    public function exportAction(Request $request)
    {
        $generator = $this->get('observation.generator');
        $generator->GetCSV();

        $Zip = realpath(__DIR__ . '/../../../web/uploads/CSV/ZIP') . '/export-nao.zip';
        $response = new BinaryFileResponse($Zip);
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);
        return $response;
    }
}