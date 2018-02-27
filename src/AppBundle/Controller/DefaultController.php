<?php

namespace AppBundle\Controller;

use AppBundle\Service\CloseIOService;
use AppBundle\Type\CloseIOType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request): Response
    {

        $form = $this->createForm(CloseIOType::class);

        $form->handleRequest($request);

        $found = '';

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var CloseIOService $closeIOService */
            $closeIOService  = $this->container->get('close.io_service');

            $emailAddress = $form->getData()['email'];
            $companyName = $form->getData()['company'];

            if(!filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
               $found = 'Not a valid email address';
            }else {

                $closeIOData = $closeIOService->findContact('orga_ewP1OMNH1nVGxAjRM1S5j6ATb8hikpIyCmYBJmIFcHM', $emailAddress);

                if (empty($closeIOData['data'])) {
                    $closeIOService->createContact($companyName, $emailAddress);
                    $found .= 'Create Contact';
                }

                $found .= 'Found a email address';
            }
        }

        return $this->render('default/index.html.twig', [
            'form' => $form->createView(),
            'found' => $found
        ]);
    }
}
