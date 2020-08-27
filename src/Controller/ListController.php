<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

class ListController extends AbstractFOSRestController
{
    /**
     * @Rest\Get ("/lists", name="lists.get")
     */
    public function getLists ()
    {
    }

    /**
     * @Rest\Get ("/lists/{$id}", name="lists.get.id")
     * @param int $id
     * @return string
     */
    public function getListsById (int $id)
    {
        return $this->json([
            "message" => `Querying list with id=`
        ]);
    }
}
