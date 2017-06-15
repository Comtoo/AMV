<?php
/**
 * Created by PhpStorm.
 * User: comtoo
 * Date: 28/03/2017
 * Time: 11:04
 */
/**
 * @QueryParam(
 *   name="",
 *   key=null,
 *   requirements="",
 *   incompatibles={},
 *   default=null,
 *   description="",
 *   strict=false,
 *   array=false,
 *   nullable=false
 * )
 */
namespace DataBundle\Controller;
use DataBundle\DataBundle;
use DataBundle\Entity\Article;
use DataBundle\Entity\Ville;
use FOS\UserBundle\Form\Type\RegistrationFormType;
use FOS\UserBundle\Form\Type\UsernameFormType;
use JMS\Serializer\SerializationContext;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest ;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use UserBundle\Form\UserType;
use UserBundle\UserBundle;



class DataController extends Controller
{
    /**
     * @param Article $article_id
     * @return array
     * @Rest\View()
     * @ParamConverter("article_id", class="DataBundle:Article")
     */
    public function getArticleAction(Article $article_id){

        return array('article' => $article_id);
    }


    /**
     * @Rest\Get("/articles/{id_ville}/{cat}")
     * @param $id_ville
     * @param $cat
     * @return array
     * @Rest\View()
     */
    public function getArticlesAction($id_ville,$cat){

        $list_category = explode(",", $cat);
        $em = $this->getDoctrine()->getManager();
        $entity = $em
            ->getRepository('DataBundle:Article')
            ->createQueryBuilder('e')
            ->join('e.service_cat', 'r')
            ->where('r.id = e.service_cat')
            ->where('e.ville IN('.$id_ville.')')
            -> andWhere('r.name IN (:cat)')
            ->setParameter('cat', $list_category)
            ->orderBy('e.id','DESC')
            ->getQuery()
            ->getResult();

        if (!$entity) {
            $error = 1;
        }else{
            $error = null;
        }

        return array('article' => $entity, 'error' => $error);

    }


    /**
     * @Rest\Get("/services/visitor")
     * @return array
     * @Rest\View()
     */
    public function getServicesVisitorAction(){
        $em = $this->getDoctrine()->getManager();
        $entity = $em
            ->getRepository('DataBundle:Article')
            ->createQueryBuilder('e')
            ->join('e.service_cat', 'r')
            ->where('r.id = e.service_cat')
            ->orderBy('e.id','DESC')
            ->getQuery()
            ->getResult();

        if (!$entity) {
            $error = 1;
        }else{
            $error = null;
        }

        return array('article' => $entity, 'error' => $error);
    }


    /**
     * @Rest\Get("/domaine_articles/{id_ville}/{cat}/{service_id}")
     * @param $id_ville
     * @param $cat
     * @param $service_id
     * @return array
     * @Rest\View()
     */
    public function getServiceArticlesAction($id_ville,$cat,$service_id){

        $list_category = explode(",", $cat);
        $em = $this->getDoctrine()->getManager();
        $entity = $em
            ->getRepository('DataBundle:Article')
            ->createQueryBuilder('e')
            ->join('e.service_cat', 'r')
            ->where('r.id = e.service_cat')
            ->where('e.ville IN('.$id_ville.')')
            -> andWhere('r.name IN (:cat)')
            ->setParameter('cat', $list_category)
            -> andWhere('r.service IN (:service)')
            ->setParameter('service',$service_id)
            ->orderBy('e.id','DESC')
            ->getQuery()
            ->getResult();

        return array('article' => $entity);
    }

    /**
     * @Rest\Get("/domaine_articles_visitor/{service_id}")
     * @param $service_id
     * @return array
     * @Rest\View()
     */
    public function getServiceArticlesVisitorAction($service_id){

        $em = $this->getDoctrine()->getManager();
        $entity = $em
            ->getRepository('DataBundle:Article')
            ->createQueryBuilder('e')
            ->join('e.service_cat', 'r')
            ->where('r.id = e.service_cat')
            -> andWhere('r.service IN (:service)')
            ->setParameter('service',$service_id)
            ->orderBy('e.id','DESC')
            ->getQuery()
            ->getResult();

        return array('article' => $entity);
    }
    /**
     * @Rest\Get("/services_cat")
     * @return array
     * @Rest\View()
     */
    public function getServicesCatAction(){
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery(
            "SELECT p
             FROM DataBundle:Service_cat p
            ORDER BY p.service"
        );

        $service = $query->getResult();

        if (!$service) {
            $error = 1;
        }else{
            $error = null;
        }

        return array('services' => $service, 'error' => $error);
    }

    /**
     * @Rest\Get("/town")
     * @return array
     * @Rest\View()
     */
    public function getTownAction(){
        $em = $this->getDoctrine()->getManager();

        $town = $em->getRepository('DataBundle:Ville')->findBy(array(), array('name' => 'asc'));
        if (!$town) {
            $error = 1;
        }else{
            $error = null;
        }

        return array('town' => $town, 'error' => $error);
    }

    /**
     * @Rest\Get("/town/{town_name}")
     * @return json
     * @param $town_name
     * @Rest\View()
     */
    public function getTownIdAction($town_name){
        $em = $this->getDoctrine()->getManager();

        $townResult = $em->getRepository('DataBundle:Ville')->findOneBy(array('name'=>$town_name));

        return $townResult;
    }


    /**
     * @Rest\Get("/demarches/{user_id}")
     * @Rest\View()
     * @param $user_id
     * @return array
     */
    public function getDemarchesAction($user_id)
    {
        $userId = $user_id;
        $em = $this->getDoctrine()->getManager();
        $um= $this->get('fos_user.user_manager');
        $user = $um->findUserBy((array('id' => $userId)));

        $demarche = $em->getRepository('DataBundle:Demarche')->findBy(array('user' =>  $user),array('dateDebut' => 'asc'));

        if (!$demarche) {
            $validation = false;
        }else{
            $validation = true;
        }
        return array('demarche' => $demarche, 'validation' => $validation);
    }

    /**
     * @Rest\Get("/demarches/number/{user_id}")
     * @Rest\View()
     * @param $user_id
     * @return int
     */
    public function getNumbreDemarchesAction($user_id)
    {
        $userId = $user_id;
        $em = $this->getDoctrine()->getManager();
        $um= $this->get('fos_user.user_manager');
        $user = $um->findUserBy((array('id' => $userId)));

        $demarche = $em->getRepository('DataBundle:Demarche')->findBy(array('user' =>  $user));
        $number = count($demarche);

        return $number;
    }

    /**
     * @Rest\Delete("/demarches/delete/{id}")
     * @Rest\View()
     * @param $id
     * @return array
     */
    public function deleteDemarchesAction($id){
        $em = $this->getDoctrine()->getManager();
        $demarche = $em->getRepository('DataBundle:Demarche')->find($id);

        if ($demarche) {
            $em->remove($demarche);
            $em->flush();
            $message = "Démarche supprimée ";
        }else{
            $message =  "Pas de démarche pour l'id : ".$id;
        }


        return array('Message' => $message);
    }

    /**
     * @Rest\Put("/user/update/address")
     * @Rest\View()
     * @param Request $request
     * @return array
     */
    public function editUserAddressAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $um = $this->get('fos_user.user_manager');
        $id = $request ->get('id');
        $town = $request ->get('town');
        $address = $request->get('address');
        $cp = $request->get('cp');

        $user = $this->getDoctrine()->getRepository('UserBundle:User')->findOneBy(['id' => $id]);

        $user->setAddress($address);
        $user->setCp($cp);
        $user->setTown($town);

        $message = "Changement d'adresse effectué";

        $em->persist($user);
        $em->flush($user);

        return array('Message' => $message);
    }

    /**
     * @Rest\Put("/user/update/email")
     * @Rest\View()
     * @param Request $request
     * @return array
     */
    public function editUserMailAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $um = $this->get('fos_user.user_manager');
        $id = $request ->get('id');
        $email = $request ->get('email');

        $user = $this->getDoctrine()->getRepository('UserBundle:User')->findOneBy(['id' => $id]);

        $user->setEmail($email);

        $message = "Changement d'email effectué";

        $em->persist($user);
        $em->flush($user);

        return array('Message' => $message);
    }

    /**
     * @Rest\Put("/user/update/geolocation")
     * @Rest\View()
     * @param Request $request
     * @return array
     */
    public function editUserGeolocationAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $um = $this->get('fos_user.user_manager');
        $id = $request ->get('id');
        $geolocation = $request ->get('geolocation');

        $user = $this->getDoctrine()->getRepository('UserBundle:User')->findOneBy(['id' => $id]);

        $user->setGeolocation($geolocation);

        if($geolocation == 0){
            $message = "La géolocalisation est désactivée";
        }else{
            $message = "La géolocalisation est activée";
        }

        $em->persist($user);
        $em->flush($user);

        return array('Message' => $message);
    }


    /**
     * @Rest\Post("/registration")
     * @Rest\View()
     * @param Request $request
     * @return array
     */
    public function postRegistrationAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $emf = $this->get('fos_user.user_manager');

        $user = new User();

        $email_exist = $emf->findUserByEmail($request->get("email"));
        $username_exist = $emf->findUserByUsername($request->get("username"));

        if ($email_exist){
            $message= "Email déja utilisé";
            $validation = false;
        }elseif ($username_exist){
            $message = "Username déja utilisé";
            $validation = false;
        }else {

            $user->setUsername($request->get('username'));
            $user->setEmail($request->get('email'));
            $user->setEmailCanonical($request->get('email'));
            $user->setPlainPassword($request->get('password'));
            $user->setEnabled(false);
            $user->setFirstname($request->get('firstname'));
            $user->setLastname($request->get('lastname'));
            $user->setTown($request->get('town'));
            $user->setAddress($request->get('address'));
            $user->setCp($request->get('cp'));
            $user->setGeolocation($request->get('geolocation'));

            $list_followedtown = explode(",", $request->get('followedtown'));
            foreach ($list_followedtown as $item){
                $town = $this->getDoctrine()->getRepository('DataBundle:Ville')->findOneBy(['name' => $item]);
                $user->addFollowedtown($town);
            }

            $list_followedcategory = explode(",", $request->get('followedcategory'));
            foreach ($list_followedcategory as $item){
                $service_cat = $this->getDoctrine()->getRepository('DataBundle:Service_cat')->findOneBy(['name' => $item]);
                $user->addFollowedservicecategory($service_cat);
            }

            $user->setRoles(array('ROLE_USER'));
            $tokenGenerator = $this->get('fos_user.util.token_generator');
            $token = $tokenGenerator->generateToken();

            $user->setConfirmationToken($token);
            $this->get('fos_user.mailer')->sendConfirmationEmailMessage($user);
            $em->persist($user);
            $em->flush($user);
            $message= "Utilisateur crée";
            $validation = true;

        }
        return array("Validation" => $validation , 'Message' => $message);
    }

    /**
     * @Rest\Post("/login_check")
     * @Rest\View()
     * @param Request $request
     * @return Response
     */
    public function postLoginAction(Request $request)
    {
        $um = $this->get('fos_user.user_manager');
        $username = $request->get('username');
        $password = $request->get('password');
        // $user = $um->findUserByUsername($username);
        $user = $this->getDoctrine()->getRepository('UserBundle:User')->findOneBy(['username' => $username]);

        if (!$user) {

            $response = new Response($this->serialize(['token' => '','message' =>'Utilisateur non trouvé']));

        }else{
            $isValid = $this->get('security.password_encoder')
                ->isPasswordValid($user, $password);
            if(!$isValid){
                $response = new Response($this->serialize(['token' => '','message' =>'Mot de passe incorrect']));
            }else{


                // $token = $this->getToken($user);

                $token = $this->get('lexik_jwt_authentication.encoder')
                    ->encode(['username'=>$user->getUsername()]);
                $response = new Response($this->serialize(['token' => $token,'message' =>'Connexion réussie','userData'=> $user]), Response::HTTP_OK);

            }

        }


        return $response;
    }

    /**
     * Returns token for user.
     *
     * @param User $user
     *
     * @return array
     */
    public function getToken(User $user)
    {
        return $this->container->get('lexik_jwt_authentication.encoder')
            ->encode([
                'username' => $user->getUsername(),
                'exp' => $this->getTokenExpiryDateTime(),
            ]);
    }

    /**
     * Returns token expiration datetime.
     *
     * @return string Unixtmestamp
     */
    private function getTokenExpiryDateTime()
    {
        $tokenTtl = $this->container->getParameter('lexik_jwt_authentication.token_ttl');
        $now = new \DateTime();
        $now->add(new \DateInterval('PT'.$tokenTtl.'S'));
        return $now->format('U');
    }
    /**
     * Set base HTTP headers.
     *
     * @param Response $response
     *
     * @return Response
     */
    private function setBaseHeaders(Response $response)
    {
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }

    /**
     * Data serializing via JMS serializer.
     *
     * @param mixed $data
     *
     * @return string JSON string
     */
    public function serialize($data)
    {
        $context = new SerializationContext();
        $context->setSerializeNull(true);

        return $this->get('jms_serializer')
            ->serialize($data, 'json', $context);
    }
}