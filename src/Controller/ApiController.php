<?php

namespace App\Controller;

use App\Entity\Boutique;
use App\Entity\Article;
use App\Entity\ArticleBoutique;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;

class ApiController extends AbstractController
{
    /**
     * @Route("/articles", methods={"GET"})
     */
    public function getArticles(): JsonResponse
    {
        // Get all articles
        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();

        $data = array_map(function (Article $article) {
            return [
                'id' => $article->getId(),
                'nom' => $article->getNom(),
                'prix' => $article->getPrix(),
            ];
        }, $articles);

        return new JsonResponse($data);
    }

    /**
     * @Route("/boutique/{id}/infos", methods={"GET"})
     */
    public function getBoutiqueInfos(int $id, Security $security): JsonResponse
    {
        // Check user roles and permissions
        $user = $security->getUser();
        if (!$user || !in_array('ROLE_ADMIN', $user->getRoles())) {
            return new JsonResponse(['code' => 403, 'error' => 'Accès interdit'], 403);
        }

        $boutique = $this->getDoctrine()->getRepository(Boutique::class)->find($id);
        if (!$boutique) {
            return new JsonResponse(['code' => 404, 'error' => 'Boutique introuvable'], 404);
        }

        // Fetch stock and personnel
        $stock = $this->getDoctrine()->getRepository(ArticleBoutique::class)->findBy(['boutique' => $boutique]);
        $personnel = []; // Fetch personnel based on delegation

        $stockData = array_map(function (ArticleBoutique $ab) {
            return [
                'article' => [
                    'id' => $ab->getArticle()->getId(),
                    'nom' => $ab->getArticle()->getNom(),
                    'prix' => $ab->getArticle()->getPrix(),
                ],
                'tarifLocationJour' => $ab->getTarifLocationJour(),
                'stock' => $ab->getStock(),
            ];
        }, $stock);

        $response = [
            'id' => $boutique->getId(),
            'stock' => $stockData,
            'personnel' => $personnel,
        ];

        return new JsonResponse($response);
    }

    /**
     * @Route("/boutique/{id}/articles", methods={"POST"})
     */
    public function postArticles(int $id, Request $request, Security $security): JsonResponse
    {
        // Check user roles and permissions
        $user = $security->getUser();
        if (!$user || !in_array('ROLE_ADMIN', $user->getRoles())) {
            return new JsonResponse(['code' => 403, 'error' => 'Accès interdit'], 403);
        }

        // Handle request data
        $data = json_decode($request->getContent(), true);

        foreach ($data as $item) {
            $article = $this->getDoctrine()->getRepository(Article::class)->find($item['article']);
            if ($article) {
                // Create or update ArticleBoutique
                $articleBoutique = new ArticleBoutique();
                $articleBoutique->setArticle($article);
                $articleBoutique->setBoutique($this->getDoctrine()->getRepository(Boutique::class)->find($id));
                $articleBoutique->setTarifLocationJour($item['tarifLocationJour']);
                $articleBoutique->setStock($item['stock']);
                $em = $this->getDoctrine()->getManager();
                $em->persist($articleBoutique);
                $em->flush();
            }
        }

        // Return updated stock
        $stock = $this->getDoctrine()->getRepository(ArticleBoutique::class)->findBy(['boutique' => $this->getDoctrine()->getRepository(Boutique::class)->find($id)]);
        $stockData = array_map(function (ArticleBoutique $ab) {
            return [
                'article' => [
                    'id' => $ab->getArticle()->getId(),
                    'nom' => $ab->getArticle()->getNom(),
                    'prix' => $ab->getArticle()->getPrix(),
                ],
                'tarifLocationJour' => $ab->getTarifLocationJour(),
                'stock' => $ab->getStock(),
            ];
        }, $stock);

        return new JsonResponse($stockData);
    }
}
