<?php
namespace App\Controller;

use App\Entity\Dossier;
use App\Repository\DossierRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Attribute\Route;

class DossierController extends AbstractController
{
    public function __construct(private DossierRepository $dossierRepository)
    {
    }

    #[Route('/', name: 'dossierList')]
    public function dossierList(Request $request, PaginatorInterface $paginator): Response
    {
        $query = $this->dossierRepository->findVisibleQuery();
        $dossierList = $paginator->paginate($query, $request->query->getInt('page', 1), 6);

        return $this->render('dossierList.html.twig', [
            'dossierList' => $dossierList,
        ]);
    }

    #[Route('/dossier/ajax/details/{dossier}', name: 'dossierAjaxPageDetails', requirements: ['dossier' => '\d+'])]
    public function dossierListAjaxDetails(Dossier $dossier): Response
    {
        return $this->render('dossierDetails.ajax.html.twig', [
            'dossier' => $dossier,
        ]);
    }
}
