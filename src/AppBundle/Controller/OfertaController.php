<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Oferta;
use AppBundle\Entity\Dokumenta;
use AppBundle\Entity\Tender;
use AppBundle\Form\OfertaType;
use AppBundle\Forms\TenderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OfertaController extends  Controller
{


    /**
     * @Route("/ofertim/{id}", name="oferto")
     */
    public function shikoDetajet(Request $request,Tender $tender,EntityManagerInterface  $entityManager)
    {

        if( ($this->get('session')->get('loginUserId') != null )
//            && ($this->get('session')->get('roleId') != 4)
             ){
           $logopath=$this->get('session')->get('logoPath');
            $logopath="/uploads/logo/".$logopath;
            $user = $this->get('session')->get('loginUserId');

            $Query="SELECT emer_biznesi 
                    From biznes
                    Where biznes.id=:biznesID ";
            $statement = $entityManager->getConnection()->prepare($Query);
            $statement->execute(array('biznesID'=>  $this->get('session')->get('loginUserId')));
            $profili = $statement->fetchAll();
            $biznesName= $profili[0]["emer_biznesi"];

            $oferta = new Oferta();
            $dokument = new Dokumenta();
            $form = $this->createForm(OfertaType::class);
            $form->handleRequest($request);
            if($form->isValid() && $form->isSubmitted()){

                $entityManager = $this->getDoctrine()->getManager();
                $oferta->setAdresaDorezimit($form->get('adresaDorezimit')->getData());
                $oferta->setPershkrimi($form->get('pershkrimi')->getData());
                $oferta->setVlefta($form->get('vlefta')->getData());
                $oferta->setCreatedBy($user);
                $oferta->setTenderId($tender->getId());
                $oferta->setIsDeleted(0);
                $oferta->setVendimi('shqyrtim');
                
                $entityManager->persist($oferta);
                $entityManager->flush();
                //file upload
                $uploads_directory=$this->getParameter('uploads_directory');
                $files = $request->files->get('oferta')['document'];
                foreach ($files as $file){
                    $dokument = new Dokumenta();
                    $filename=md5(uniqid()).'.'.$file->guessExtension();
                    $file->move($uploads_directory,$filename);
                    $dokument->setTitullDokumenti($filename);
                    $dokument->setOfertaId($oferta->getId());
                    $dokument->setPath($file);
                    $dokument->setIsDeleted(0);
                    $dokument->setCreatedBy($user);
                    $entityManager->persist($dokument);
                    $entityManager->flush();
                }
                return $this->redirectToRoute('buletini');

            }

        }
        else{
            return $this->redirectToRoute('landingpage');
        }        
 return $this->render('oferta/aplikim.html.twig',[
                'form' => $form->createView(),
                'tender'=>$tender,
                'logoUrl'=>$logopath,
//     ,
                'biznesName'=>$biznesName
 ]);
    }

    /**
     * @Route("/ofertat_e_mia", name="ofertat_e_mia")
     */
    public function shikoOfertateMia(Request $request,EntityManagerInterface  $entityManager)
    {
        if(($this->get('session')->get('loginUserId') != null) && ($this->get('session')->get('roleId') !=4)){
           $logopath=$this->get('session')->get('logoPath');
            $logopath="/uploads/logo/".$logopath;

            $biznesId = $this->get('session')->get('loginUserId');
            $repository = $entityManager->getRepository(Oferta::class);

            $Query="SELECT emer_biznesi 
            From biznes
                    Where biznes.id=:biznesID ";
            $statement = $entityManager->getConnection()->prepare($Query);
            $statement->execute(array('biznesID'=>$this->get('session')->get('loginUserId')));
            $profili = $statement->fetchAll();
//            $biznesName= $profili->getEmerBiznesi();

            $ofertaQuery="SELECT oferta.id as ofertaId, 
                oferta.vlefta as VleraOferte, 
                tender.emer_statusi as statusTender, 
                tender.data_perfundimit as dataMbylljeTender, 
                oferta.vendimi as vendimi, 
                tender.titull_thirrje as titullTender, 
                biznes.id From oferta 
                inner join tender on oferta.tender_id=tender.id 
                inner join biznes on oferta.created_by=biznes.id 
                where oferta.created_by=:biznesId
                and  oferta.is_deleted=0;" ;
            $statement = $entityManager->getConnection()->prepare($ofertaQuery);

            $statement->execute(array('biznesId' => $biznesId));
            $ofertat = $statement->fetchAll();
            $Query="SELECT emer_biznesi 
                    From biznes
                    Where biznes.id=:biznesID ";
            $statement = $entityManager->getConnection()->prepare($Query);
            $statement->execute(array('biznesID'=>$biznesId));
            $profili = $statement->fetchAll();
            $biznesName= $profili[0]["emer_biznesi"];

        }
        else{
            return $this->redirectToRoute('landingpage');
        }
        return $this->render('oferta/ofertatemia.html.twig',[
            'oferta' =>$ofertat,
            'logoUrl'=>$logopath,
//            ,
            'biznesName'=>$biznesName
        ]);
    }

    /**
     * @Route("/shiko_oferten/{id}", name="detaje_oferte")
     */
    public function shikoOferten(Request $request,EntityManagerInterface  $entityManager, Oferta $oferta)
    {
        if(($this->get('session')->get('loginUserId') != null) && ($this->get('session')->get('roleId') !=4)){
           $logopath=$this->get('session')->get('logoPath');
            $logopath="/uploads/logo/".$logopath;

            $biznesId = $this->get('session')->get('loginUserId');
            $repository = $entityManager->getRepository(Oferta::class);
            $repositoryDokumenta = $entityManager->getRepository(Dokumenta::class);
            $businesId = $this->get('session')->get('loginUserId');

            $Query="SELECT emer_biznesi 
            From biznes
                    Where biznes.id=:biznesID ";
            $statement = $entityManager->getConnection()->prepare($Query);
            $statement->execute(array('biznesID'=>$this->get('session')->get('loginUserId')));

            $profili = $statement->fetchAll();
            $biznesName= $profili[0]["emer_biznesi"];

            $dokumenta = $repositoryDokumenta->createQueryBuilder('dok')
                ->andWhere('dok.ofertaId=:idOferte')
                ->setParameter('idOferte', $oferta->getId())
                ->andWhere('dok.isDeleted=0')
                ->getQuery()
                ->getResult();

            $ofertaQuery="SELECT oferta.id as ofertaId,
                            oferta.vlefta as VleraOferte, 
                            oferta.pershkrimi as Pershkrim,
                            oferta.adresa_dorezimit as Adresa 
                          From oferta    
                          where oferta.id=:ofertaId
                          and  oferta.is_deleted=0;" ;
            $statement = $entityManager->getConnection()->prepare($ofertaQuery);

            $statement->execute(array('ofertaId'=>$oferta->getId()));
            $oferta = $statement->fetchAll();

        }
        else{
            return $this->redirectToRoute('landingpage');
        }
        return $this->render('oferta/ofertadetajuar.html.twig',[
            'oferta' =>$oferta,
            'dokumenta'=>$dokumenta,
            'logoUrl'=>$logopath
            ,
            'biznesName'=>$biznesName
        ]);
    }

    /**
     * @Route("/modifikoOferten/{id}", name="Modifiko_Oferten")
     */
    public function modifikoOferten(Request $request, Oferta $oferte,EntityManagerInterface $entityManager)
    {

        if(($this->get('session')->get('loginUserId') != null) && ($this->get('session')->get('roleId') !=4))
        {
           $logopath=$this->get('session')->get('logoPath');
            $logopath="/uploads/logo/".$logopath;
            $Query="SELECT emer_biznesi 
                    From biznes
                    Where biznes.id=:biznesID ";
            $statement = $entityManager->getConnection()->prepare($Query);
            $statement->execute(array('biznesID'=>$this->get('session')->get('loginUserId')));

            $profili = $statement->fetchAll();
            $biznesName= $profili[0]["emer_biznesi"];

            $form = $this->createForm(OfertaType::class, $oferte);
            $form->handleRequest($request);

            $repositoryDokumenta = $entityManager->getRepository(Dokumenta::class);

            $dokumenta = $repositoryDokumenta->createQueryBuilder('dok')
                ->andWhere('dok.ofertaId=:idOferte')
                ->setParameter('idOferte', $oferte->getId())
                ->andWhere('dok.isDeleted=0')
                ->getQuery()
                ->getResult();


        if($form->isSubmitted() && $form->isValid()){

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($oferte);
            $entityManager->flush();

            $uploads_directory = $this->getParameter('uploads_directory');
            $files = $request->files->get('oferta')['document'];
            $oferteid = $oferte->getId();

            foreach ($files as $file)
            {
                $dokument = new Dokumenta();
                $filename=$file->getClientOriginalName().$file->guessExtension();
                $file->move(
                    $uploads_directory,
                    $filename);
                $dokument->setTitullDokumenti($filename);
                $dokument->setOfertaId($oferte->getId());
                $dokument->setPath($file);
                $dokument->setIsDeleted(0);

                $dokument->setCreatedBy($this->get('session')->get('loginUserId'));
//                dump($dokument);die();
                $entityManager->persist($dokument);
                $entityManager->flush();
            }


            return $this->redirectToRoute('ofertat_e_mia');
            //return $this->render('Oferta/showoferta.html.twig');
        }
        return $this->render('oferta/showoferta.html.twig', [
            'form' => $form->createView(),
            'dokumenta'=>$dokumenta,
            'logoUrl'=>$logopath
            ,
            'biznesName'=>$biznesName
        ]);
        }

        else{
            return $this->redirectToRoute('landingpage');
        }

    }
    /**
     * @Route("/fshiOferten/{id}/fshi", name="fshiOferten")
     */
    public function fshiOferten (Request $request,Oferta $oferta,EntityManagerInterface  $entityManager)
    {
        if (($this->get('session')->get('loginUserId') != null) && ($this->get('session')->get('roleId') != 4)) {
            $entityManager->getRepository(Oferta::class);
            $oferta->setIsDeleted(1);
            $entityManager->persist($oferta);
//            dump($oferta);die();
            $entityManager->flush();
            return $this->redirectToRoute('ofertat_e_mia');
        } else {
            return $this->redirectToRoute('landingpage');
        }
    }


}