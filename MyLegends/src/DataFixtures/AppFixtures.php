<?php

namespace App\DataFixtures;

use App\Entity\CarteJoueur;
use App\Entity\Member;
use App\Entity\User;
use App\Entity\MaCollection;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class AppFixtures extends Fixture implements DependentFixtureInterface
{
    private const LOUIS_COLLECTION_1 = 'louis-inventory-1';
    private const LEO_COLLECTION_1 = 'leo-inventory-1';
    private const THOMAS_COLLECTION_1 = 'thomas-inventory-1';
    
    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }

    private function memberGenerator(): array
    {
        return [
            ["louis", "Néant", "Cote d'ivoire", "louis@localhost"],
            ["leo", "Néant", "Sénégal", "leo@localhost"],
            ["thomas", "Néant", "Togo", "thomas@localhost"]
        ];
    }

    private function maCollectionDataGenerator(): array
    {
        return [
            ["Légendes de la CAN", "Légendes africaines ayant remporté la CAN une fois", self::LOUIS_COLLECTION_1, "louis"],
            ["Légendes africaines en UCL", "Légende africaine ayant brillé en UCL", self::LEO_COLLECTION_1, "leo"],
            ["Légendes de la WC", "Légende africaine ayant brillé en WC", self::THOMAS_COLLECTION_1, "thomas"]
        ];
    }

    private function carteJoueurGenerator(): array
    {
        return [
            [self::LOUIS_COLLECTION_1, "Samuel Eto'o", "Cameroun", "Attaquant"],
            [self::LOUIS_COLLECTION_1, "Yaya Touré", "Cote d'ivoire", "Milieu"],
            [self::LEO_COLLECTION_1, "Didier Drogba", "Cote d'ivoire", "Attaquant"]
        ];
    }

    public function load(ObjectManager $manager): void
    {
        // Member Generation
        foreach ($this->memberGenerator() as [$nomMembre, $descriptMembre, $paysMembre, $useremail]) {
            $member = new Member();
            if ($useremail) {
                $user = $manager->getRepository(User::class)->findOneByEmail($useremail);
                if ($user instanceof User){
                    $member->setUser($user);
                }
            }
            $member->setNomMembre($nomMembre);
            $member->setDescriptMembre($descriptMembre);
            $member->setPaysMembre($paysMembre);
            $manager->persist($member);
            $this->addReference($nomMembre, $member);
        }
        

        // MaCollection Generation
        foreach ($this->maCollectionDataGenerator() as [$nomCollect, $descriptCollect, $maCollectionReference, $member]) {
            $membre = $this->getReference($member);
            $macollection = new MaCollection();
            $macollection->setNomCollect($nomCollect);
            $macollection->setDescriptCollect($descriptCollect);
            $membre->addCollection($macollection);
            $manager->persist($macollection);
            $this->addReference($maCollectionReference, $macollection);
        }

        // CarteJoueur Generation
        foreach ($this->carteJoueurGenerator() as [$maCollectionReference, $nomJoueur, $pays, $poste]) {
            $macollection = $this->getReference($maCollectionReference);
            $carte = new CarteJoueur();
            $carte->setNomJoueur($nomJoueur);
            $carte->setPays($pays);
            $carte->setPoste($poste);
            $carte->setMaCollection($macollection);
            $macollection->addRelation($carte);
            $manager->persist($carte);
        }

        $manager->flush();
    }
}
