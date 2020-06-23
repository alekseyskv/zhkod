<?php


namespace App\Controller;


use App\User\DatabaseUserProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\Authentication\Provider\DaoAuthenticationProvider;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserChecker;

class IndexController extends Controller
{
    public function indexAction() {
        // dump(db());

        return $this->render('index', ['title' => 'Заголовок']);
    }

    public function pageAction($page) {
        $data = [
            'title' => 'sdfsdfdf',
            'alias' => $page,
        ];
        return $this->render('page', $data);
    }

    public function loginAction(Request $request) {
        $userProvider = new DatabaseUserProvider(db());
        // we'll use default UserChecker, it's used to check additional checks like account lock/expired etc.
        // you can implement your own by implementing UserCheckerInterface interface
        $userChecker = new UserChecker();

        $encoderFactory = new EncoderFactory([
            User::class => new MessageDigestPasswordEncoder('sha512', true, 5000),
        ]);

        $daoProvider = new DaoAuthenticationProvider(
            $userProvider,
            $userChecker,
            'frontend',
            $encoderFactory
        );

        // init authentication provider manager
        //$authenticationManager = new AuthenticationProviderManager([$daoProvider]);

        try {
            // get unauthenticated token
            $unauthenticatedToken = new UsernamePasswordToken('admin', 'foo', 'frontend');
            $authenticatedToken = $daoProvider->authenticate($unauthenticatedToken);
            // authenticate user & get authenticated token
            //$authenticatedToken = $authenticationManager->authenticate($unauthenticatedToken);

            // we have got the authenticated token (user is logged in now), it can be stored in a session for later use
            echo $authenticatedToken;
            echo "\n";
        } catch (AuthenticationException $e) {
            echo $e->getMessage();
            echo "\n";
        }
        return new Response('login');
    }
}