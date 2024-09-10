<?php

namespace App\Controller\OverKill;

use App\Entity\Upload;
use App\Form\UploadType;
use App\Message\UploadMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/user/overkill', name: 'overkill')]
class OverkillController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    #[Route('/', name: '_index')]
    public function index(Request $request, MessageBusInterface $messageBus, HubInterface $hub): Response
    {
        $upload = new Upload();
        $form = $this->createForm(UploadType::class, $upload);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && $this->getUser() !== null) {
            $upload->setUploadBy($this->getUser());
            $this->em->persist($upload);
            $this->em->flush();

            if ($upload->getImageFile() !== null) {
                $messageBus->dispatch(new UploadMessage($upload->getImageFile(), $this->getUser()->getUserIdentifier()));
                $this->sendMercure($hub, $this->getUser());
            }

            return $this->redirectToRoute('overkill_index');
        }

        return $this->render('overkill/index.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @throws \JsonException
     */
    private function sendMercure(HubInterface $hub, UserInterface $user): void
    {
        //        $encoders = [new JsonEncoder()];
        //        $normalizers = [new ObjectNormalizer()];
        //
        //        $serializer = new Serializer($normalizers, $encoders);

        $update = new Update(
            'overkill_send',
            json_encode(['id' => $user->getUserIdentifier()], JSON_THROW_ON_ERROR)
        );
//        $hub->publish($update);
    }
}
