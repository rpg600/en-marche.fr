<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ProcurationRequest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/espace-response-procuration")
 * @Security("is_granted('ROLE_PROCURATION_MANAGER')")
 */
class ProcurationManagerController extends Controller
{
    /**
     * @Route("", name="app_procuration_manager_index")
     * @Method("GET")
     */
    public function indexAction(): Response
    {
        $requestsRepository = $this->getDoctrine()->getRepository(ProcurationRequest::class);

        return $this->render('procuration_manager/index.html.twig', [
            'requests' => $requestsRepository->findManagedBy($this->getUser()),
        ]);
    }
}
