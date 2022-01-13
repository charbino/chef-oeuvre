<?php

namespace App\Controller\OverKill;

use App\Entity\Upload;
use App\Form\UploadType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/overkill', name: 'overkill')]
class OverkillController extends AbstractController
{

    private EntityManagerInterface $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/', name: '_index')]
    public function index(Request $request): Response
    {
        $upload = new Upload();
        $form = $this->createForm(UploadType::class, $upload);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->em->persist($upload);
            $this->em->flush();

            return $this->redirectToRoute('overkill_index');
        }

        return $this->render('overkill/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
