<?php

namespace App\Core\Presentation\Controller\Admin;

use App\Core\Persistence\Entity\Movie;
use App\Core\Persistence\Entity\MovieStaff;
use App\Core\Presentation\Provider\Admin\CountryProvider;
use App\Core\Presentation\Provider\Admin\GenreProvider;
use App\Core\Presentation\Provider\Admin\MovieStaffProvider;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class MovieCrudController extends AbstractCrudController
{
    public function __construct(
        private readonly CountryProvider $countryProvider,
        private readonly GenreProvider $genreProvider,
        private readonly MovieStaffProvider $movieStaffProvider
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return Movie::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setEntityLabelInPlural('Фильмы')
            ->setEntityLabelInSingular(
                static fn (?Movie $movie, ?string $pageName): string => $movie ? $movie->__toString() : 'Фильм'
            )

            ->setSearchFields(['title', 'originalTitle'])
            ->setDefaultSort(['title' => 'ASC']);
    }

    public function createIndexQueryBuilder(
        SearchDto $searchDto,
        EntityDto $entityDto,
        FieldCollection $fields,
        FilterCollection $filters
    ): QueryBuilder {
        $queryBuilder = parent::createIndexQueryBuilder(
            $searchDto,
            $entityDto,
            $fields,
            $filters
        );

        $queryBuilder->andWhere('entity.deletedAt is null');

        return $queryBuilder;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
            ->hideOnForm();

        yield TextField::new('title', 'Заголовок')
            ->setRequired(true);
        yield TextField::new('originalTitle', 'Заголовок (ориг.)')
            ->setSortable(true);
        yield DateField::new('premieredAt', 'Премьера')
            ->setRequired(true)
            ->setSortable(true);
        yield IntegerField::new('durationInMinutes', 'Продолжительность (мин.)')
            ->setRequired(true);

        yield TextField::new('poster', 'Постер')
            ->setFormType(VichImageType::class)
            ->onlyOnForms();
        yield ImageField::new('posterName', 'Постер')
            ->onlyOnIndex()
            ->setBasePath('/images/posters');

        yield FormField::addPanel('Дополнительная информация');
        yield ChoiceField::new('countries', 'Страны')
            ->allowMultipleChoices()
            ->autocomplete()
            ->setChoices($this->getCountries())
            ->setSortable(false);
        yield ChoiceField::new('genres', 'Жанры')
            ->allowMultipleChoices()
            ->autocomplete()
            ->setChoices($this->getGenres())
            ->setSortable(false);

        yield CollectionField::new('staffItems', 'Съемочная группа')
            ->useEntryCrudForm(MovieStaffItemCrudController::class)
            ->setRequired(true)
            ->hideOnIndex();

        yield DateTimeField::new('createdAt', 'Дата создания')
            ->hideOnForm()
            ->setSortable(true);
        yield DateTimeField::new('updatedAt', 'Дата обновления')
            ->hideOnForm()
            ->setSortable(true);
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $createdAt = new DateTime();

        $entityInstance->setCreatedAt($createdAt);
        $entityInstance->setUpdatedAt($createdAt);

        if (!$entityInstance->getStaffItems()->isEmpty()) {
            /** @var MovieStaff $staffItem */
            foreach ($entityInstance->getStaffItems() as $staffItem) {
                $staffItem->setMovie($entityInstance);

                $staffItem->setCreatedAt($createdAt);
                $staffItem->setUpdatedAt($createdAt);
            }
        }

        parent::persistEntity($entityManager, $entityInstance);
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param Movie $entityInstance
     * @return void
     */
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $updatedAt = new DateTime();

        $entityInstance->setUpdatedAt($updatedAt);

        $existsMovieStaffIds = $this->movieStaffProvider->get(
            $entityInstance->getId()
        );

        if (!$entityInstance->getStaffItems()->isEmpty()) {
            /** @var MovieStaff $staffItem */
            foreach ($entityInstance->getStaffItems() as $staffItem) {
                $staffItem->setMovie($entityInstance);

                if (!$staffItem->getCreatedAt()) {
                    $staffItem->setCreatedAt($updatedAt);
                }

                $staffItem->setUpdatedAt($updatedAt);
            }
        }

        $movieStaffIdsForDelete = $this->getMovieStaffIdsForDelete(
            $existsMovieStaffIds,
            array_map(
                static fn (MovieStaff $movieStaff): ?int => $movieStaff->getId(),
                $entityInstance->getStaffItems()->toArray()
            )
        );

        if (!empty($movieStaffIdsForDelete)) {
            $movieStaffRepository = $entityManager->getRepository(MovieStaff::class);

            $movieStaffItemsToDelete = $movieStaffRepository->findBy(['id' => $movieStaffIdsForDelete]);

            foreach ($movieStaffItemsToDelete as $movieStaffItem) {
                $movieStaffRepository->remove($movieStaffItem);
            }
        }

        parent::updateEntity($entityManager, $entityInstance);
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param Movie $entityInstance
     * @return void
     */
    public function deleteEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setDeletedAt(new DateTime());

        $entityManager->flush();
    }

    /**
     * @return array<string, string>
     */
    private function getCountries(): array
    {
        $countries = $this->countryProvider->getAllSortedByTitle();

        $result = [];
        foreach ($countries as $country) {
            $result[$country->getTitle()] = $country->getCode();
        }

        return $result;
    }

    /**
     * @return array<string, string>
     */
    private function getGenres(): array
    {
        $genres = $this->genreProvider->getAllSortedByTitle();

        $result = [];
        foreach ($genres as $genre) {
            $result[$genre->getTitle()] = $genre->getCode();
        }

        return $result;
    }

    /**
     * @param int[] $oldIds
     * @param int[] $actualIds
     * @return int[]
     */
    private function getMovieStaffIdsForDelete(array $oldIds, array $actualIds): array
    {
        return array_filter(
            $oldIds,
            static fn (int $id): bool => !in_array($id, $actualIds)
        );
    }
}
