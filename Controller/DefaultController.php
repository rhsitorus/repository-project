<?php

namespace Rofil\Repo\ContentBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\DiExtraBundle\Annotation as DI;

class DefaultController extends Controller
{
	/**
	 * @DI\Inject("rofil_repo_content.project")
	 * @var [type]
	 */
	protected $projectRepo;

	/**
	 * Entity Manager
	 */
	protected $em;

    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return ['name' => '$name', 'entities' => $this->projectRepo->all()] ;
    }

    /**
     * @Route("/repo/project/{id}/{slug}", name="front.project.show")
     * @Template()
     */
    public function showAction($id)
    {
    	$entity = $this->projectRepo->find($id);
    	return [ 'entity' => $entity ];
    }

    /**
     * @Template("RofilRepoContentBundle:Default:_random.html.twig")
     * [randomProjectAction description]
     * @param  integer $n [description]
     * @return [type]     [description]
     */
    public function randomProjectAction(Request $request, $n=4)
    {
       
        return [
            'entities' => $this->projectRepo->get(['limit'=>5])
        ];
    }

    /**
     * @Route("/rofilde/admin")
     *
     */
    public function roleAction()
    {
        return new Response("Rofilde");
    }
}
