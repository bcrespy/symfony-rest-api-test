<?php

namespace App\Controller;

use App\Entity\Model3D;
use App\Repository\Model3DRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

class Model3DController extends AbstractFOSRestController
{
    /**
     * @var Model3DRepository
     */
    private $model3DRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(Model3DRepository $model3DRepository, EntityManagerInterface $entityManager)
    {
        $this->model3DRepository = $model3DRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Rest\Get("/models", name="models.get")
     */
    public function getModels()
    {
        $data = $this->model3DRepository->findAll();
        return $this->view(
            $data,
            Response::HTTP_OK
        );
    }

    /**
     * @Rest\Get("/models/{id}", name="models.get.by_id")
     * @param int $id
     * @return View
     */
    public function getModel(int $id)
    {
        $data = $this->model3DRepository->findOneBy([
            "id" => $id
        ]);
        return $this->view(
            $data,
            Response::HTTP_OK
        );
    }

    /**
     * @Rest\Post("/models", name="models.post")
     * @Rest\RequestParam(
     *     name="name",
     *     description="The name of the model, will be displayed in the library",
     *     nullable=false
     * )
     * @Rest\FileParam(
     *     name="model_file",
     *     description="A ZIP file containing the 3D model informations",
     *     nullable=false
     * )
     * @param ParamFetcher $paramFetcher
     * @return View
     */
    public function postModel(ParamFetcher $paramFetcher)
    {
        var_dump($paramFetcher->get("model_file"));

        $name = $paramFetcher->get("name");

        if (!empty($name))
        {
            $model = new Model3D();
            $model->setName($name);
            $this->entityManager->persist($model);
            $this->entityManager->flush();

            return $this->view(
                $model,
                Response::HTTP_CREATED
            );
        }

        return $this->view(
            [
                "message" => "Bad request"
            ],
            Response::HTTP_BAD_REQUEST
        );
    }
}
