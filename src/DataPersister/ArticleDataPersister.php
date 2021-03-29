<?php


namespace App\DataPersister;


use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\String\Slugger\SluggerInterface;

class ArticleDataPersister implements ContextAwareDataPersisterInterface
{

	public function __construct(
		private EntityManagerInterface $entityManager,
		private SluggerInterface $slugger,
		private RequestStack $request,
	)
	{
		$this->request = $this->request->getCurrentRequest();
	}

	public function supports($data, array $context = []): bool
	{
		return $data instanceof Article;
	}

	public function persist($data, array $context = [])
	{
		// Update the slug only if the article isn't published
		if (!$data->getIsPublished()) {
			$data->setSlug(
				$this
					->slugger
					->slug(strtolower($data->getTitle())) . '-' . uniqid()
			);
		}

		// Set the updatedAt value if it's not a POST request
		if ($this->request->getMethod() !== 'POST') {
			$data->setUpdatedAt(new \DateTime());
		}

		$this->entityManager->persist($data);
		$this->entityManager->flush();
	}

	public function remove($data, array $context = [])
	{
		$this->entityManager->remove($data);
		$this->entityManager->flush();
	}
}
