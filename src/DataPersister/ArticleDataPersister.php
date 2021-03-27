<?php


namespace App\DataPersister;


use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class ArticleDataPersister implements ContextAwareDataPersisterInterface
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private SluggerInterface $slugger
    )
    {
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Article;
    }

    public function persist($data, array $context = [])
    {
        $data->setSlug(
            $this->slugger->slug(strtolower($data->getTitle())) . '-' . uniqid()
        );

        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    public function remove($data, array $context = [])
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}
