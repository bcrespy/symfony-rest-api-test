<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractFOSRestController
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        UserRepository $userRepository,
        UserPasswordEncoderInterface $passwordEncoder,
        EntityManagerInterface $entityManager
    ){
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
    }

    /**
     * @Rest\Post("/api/register", name="registration")
     * @Rest\RequestParam(
     *     name="username",
     *     description="Username, must be at least 6 characters",
     *     nullable=false
     * )
     * @Rest\RequestParam(
     *     name="email",
     *     description="Email, must be a valid email format",
     *     nullable=false
     * )
     * @Rest\RequestParam(
     *     name="password",
     *     description="Plain text password, must be at least 8 characters long, include at least one lower case letter, one upper case letter and one digit",
     *     nullable=false
     * )
     * @param ParamFetcher $paramFetcher
     * @return View
     */
    public function index(ParamFetcher $paramFetcher)
    {

        $username = $paramFetcher->get("username");
        $email = $paramFetcher->get("email");
        $password = $paramFetcher->get("password");

        $errors = [];

        // username validation
        if (strlen($username) < 6) {
            $errors["username"] = "Username should be at least 6 characters long";
        }

        // email validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = "Email is invalid";
        }

        // password strength validation
        if (!preg_match('@[A-Z]@', $password) || !preg_match('@[a-z]@', $password)
            || !preg_match('@[0-9]@', $password) || strlen($password) < 8) {
            $errors["password"] = "Password strength is too low. Passwords must be at least 8 characters long, include at least one lower case letter, one upper case letter and one digit";
        }

        // returns error and failed expectations if criteria are met
        if (count($errors) > 0) {
            $error_fields = implode(array_keys($errors), ", ");
            return $this->view([
                "message" => 'The following fields are invalid: '.$error_fields,
                "errors" => $errors
            ], Response::HTTP_EXPECTATION_FAILED);
        }

        // if user already exists, end request with 409 Conflict
        if (!is_null($this->userRepository->findOneBy([ "email" => $email]))) {
            return $this->view([
                "message" => `User with email ${$email} already exists`
            ],Response::HTTP_CONFLICT);
        }

        $user = new User();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword(
            $this->passwordEncoder->encodePassword($user, $password)
        );

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->view($user, Response::HTTP_CREATED)
            ->setContext((new Context())->setGroups(["public"]));
    }
}
