<?php

namespace App\Controller;

use App\Entity\Member;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MemberRepository;
use Doctrine\Persistence\ManagerRegistry;

class MemberController extends AbstractController
{
    #[Route('/member', name: 'app_member')]
    public function index(MemberRepository $membreRepository): Response
    {
        $membres = $membreRepository->findAll();
        return $this->render('member/index.html.twig', [
            'membres' => $membres,
        ]);
    }
    

    
    #[Route('/member/{id}', name: 'member_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(ManagerRegistry $doctrine, $id)
    {
        $membreRepo = $doctrine->getRepository(Member::class);
        $membre = $membreRepo->find($id);
        
        if (!$membre) {
            throw $this->createNotFoundException('The Member does not exist');
        }
        
        return $this->render('member/show.html.twig', [
            'membre' => $membre,
        ]);
    }
    

}
