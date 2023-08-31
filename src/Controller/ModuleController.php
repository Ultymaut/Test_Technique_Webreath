<?php

namespace App\Controller;

use App\Entity\Module;
use App\Form\ModuleType;
use App\Form\RestartModuleType;
use App\Repository\ModuleRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ModuleController extends AbstractController
{

    /**
     * @param Request $request
     * @param ModuleRepository $moduleRepository
     * @param PaginatorInterface $paginator
     * @param ManagerRegistry $doctrine
     * @return Response
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    #[Route('/', name: 'app_dashboard', methods:['GET'])]
    public function index(Request $request, ModuleRepository $moduleRepository, PaginatorInterface $paginator,ManagerRegistry $doctrine): Response
    {
        //Rechercher tout les modules puis les mettre dans une pagination
        $module = $paginator->paginate(
            $moduleRepository->findAll(),
            $request->query->getInt('page', 1),
            10,
        );

        //Faire un requete simple afin d'avoir le total des modules existants
        $query= $doctrine->getRepository(Module::class);
        $total = $query->createQueryBuilder('e')
            ->select('count(e)')
            ->getQuery()
            ->getSingleScalarResult();

        return $this->render('pages/dashboard.html.twig', [
            'module' => $module,
            'total' => $total
        ]);
    }

    /**
     * @param Module $module
     * @return Response
     */
    #[Route ('/etat/{id}', name: 'app_etat', methods:['GET','POST'])]
    public function etat(Module $module):Response
    {
        // Récupérer les données du module
        $temperature = $module->getTemperature();
        $humidity = $module->getHumidity();
        $wind = $module->getWind();

        // Passer les données du module au template Twig
        return $this->render('pages/etat.html.twig', [
            'module' => $module,
            'temperature' => $temperature,
            'humidity' => $humidity,
            'wind' => $wind,
        ]);
    }

    /**
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return Response
     */
    #[Route ('/new', name: 'app_new', methods:['GET', 'POST'])]
    public function new(EntityManagerInterface $manager,Request $request):Response
    {
        $module = new Module();
        $form = $this->createForm(ModuleType::class,$module);
        $form->handleRequest($request);

        //Vérifie si le formulaire est valide et peut être envoyé
        if ($form->isSubmitted() && $form->isValid()){

            //Jeu random de valeur lors de la crétion d'un module
            $temperature = rand(-20, 55);
            $wind = rand(0, 200);
            $humidity = rand(0, 100);
            $module->setIsWorking(true);
            $module->setUptime(null);
            $module->setTemperature($temperature);
            $module->setHumidity($humidity);
            $module->setWind($wind);

            //Rentre toutes les valeurs crée au sein de la BDD
            $manager->persist($module);
            $manager->flush();

            //Message flash qui s'affiche si tout c'est bien passé
            $this->addFlash(
                'success',
                'le module à été ajouté avec succès !'
            );
            return $this->redirectToRoute('app_dashboard');
        }
        return $this->render('pages/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Module $module
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */
    #[Route ('/restart/{id}', name: 'app_restart', methods:['GET','POST'])]
    public function restart(Module $module, EntityManagerInterface $entityManager,Request $request):Response
    {
        // Créer le formulaire pour redémarrer le module
        $form = $this->createForm(RestartModuleType::class,$module);

        // Gérer la soumission du formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // Enregistrer les modifications dans la base de données
            $module->setUptime(null);
            $entityManager->persist($module);
            $entityManager->flush();

            // Rediriger vers la page dashboard après la validation du formulaire
            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('pages/restart.html.twig', [
            'module' => $module,
            'form' => $form->createView()
        ]);
    }

}
