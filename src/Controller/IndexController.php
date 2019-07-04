<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Event;
use App\Entity\PickingCalendar;
use App\Entity\Product;
use App\Entity\Contact;
use App\Entity\Recipe;
use App\Form\ContactType;
use App\Repository\PickingCalendarRepository;
use App\Service\OrderService;
use App\Service\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    const BASKET_CATEGORY = 'Panier de la semaine';

    /**
     * @Route("/", name="app_index")
     * @param Request $request
     * @param MailerService $mailer
     * @return Response
     * @throws \Exception
     */
    public function index(Request $request, MailerService $mailer, PickingCalendarRepository $pickingCalendarRepository)
    {
        $productsShowcased = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findBy(
                [
                    'isShowcased' => true,
                    'isAvailable' => true,
                ]
            );

        $weekBasketName = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name' => self::BASKET_CATEGORY]);

        $recipe = $this->getDoctrine()
            ->getRepository(Recipe::class)
            ->findOneBy(['isPresent' => true]);

        $weekBasket = [];
        if (isset($weekBasketName)) {
            $weekBasket = $this->getDoctrine()
                ->getRepository(Product::class)
                ->findOneBy(['category' => $weekBasketName->getId()]);
        }

        $now = new \DateTime();

        $allActualEvents = $this->getDoctrine()
            ->getRepository(Event::class)
            ->findByActualEvents($now);

        $pickingCalendar = $pickingCalendarRepository->findAllSortByName();

        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $sender = $this->getParameter('mailer_from');
            $destination = $this->getParameter('mailer_to');

            $bodyMail = $this->renderView('emails/contact.html.twig', ['contact' => $contact]);

            $mailer->sendMail(
                $sender,
                $destination,
                'Contact depuis le site de la Volière',
                'text/html',
                $bodyMail
            );

            $this->addFlash(
                'success',
                'Votre message a bien été envoyé, merci !'
            );

            return $this->redirectToRoute('app_index');
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash(
                'warning',
                'Veuillez corriger votre formulaire avant l\'envoi.'
            );
        }
        return $this->render('index/index.html.twig', [
            '_fragment' => 'contact-form',
            'productsShowcased' => $productsShowcased,
            'weekBasket' => $weekBasket,
            'recipe' => $recipe,
            'allActualEvents' => $allActualEvents,
            'form' => $form->createView(),
            'calendars' => $pickingCalendar,
        ]);
    }

    /**
     * @param Product $product
     * @param OrderService $orderService
     * @param Request $request
     * @Route("/ajout-panier-index/{id}", name="add_cart_index", methods={"POST", "GET"})
     */
    public function add(?Request $request, OrderService $orderService, Product $product)
    {
        if ($request->request->get('quantity')) {
            $quantity = $request->request->get('quantity');
        } else {
            $quantity = 1 ;
        }
        $weekBasketName = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name' => self::BASKET_CATEGORY]);

        $anchor = 'product-cards-index';

        if ($product->getCategory() == $weekBasketName) {
            $anchor = 'week-basket';
        }

        $orderService->addToCart($product, $quantity);
        return $this->redirectToRoute('app_index', ['_fragment' => $anchor]);
    }
}
