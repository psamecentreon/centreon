<?php

namespace Centreon\Domain\Service;

use Centreon\Domain\Entity\AccessGroup;
use Centreon\Domain\Entity\Contact;
use Centreon\Domain\Entity\Pagination;
use Centreon\Domain\Repository\Interfaces\AccessGroupRepositoryInterface;
use Centreon\Domain\Repository\Interfaces\RealTimeServiceRepositoryInterface;
use Centreon\Domain\Service\Interfaces\MonitoringServiceInterface;

class MonitoringService implements MonitoringServiceInterface
{
    /**
     * @var RealTimeServiceRepositoryInterface
     */
    private $realTimeServiceRepository;
    /**
     * @var AccessGroupRepositoryInterface
     */
    private $accessGroupRepository;
    /**
     * @var Pagination
     */
    private $pagination;

    /**
     * MonitoringService constructor.
     * @param RealTimeServiceRepositoryInterface $realTimeServiceRepository
     * @param AccessGroupRepositoryInterface $accessGroupRepository
     * @param Pagination $pagination Automatically injected by DI
     */
    public function __construct(
        RealTimeServiceRepositoryInterface $realTimeServiceRepository,
        AccessGroupRepositoryInterface $accessGroupRepository,
        Pagination $pagination
    ) {
        $this->realTimeServiceRepository = $realTimeServiceRepository;
        $this->accessGroupRepository = $accessGroupRepository;
        $this->pagination = $pagination;
    }

    /**
     * @param Contact $contact
     * @return AccessGroup[]|null
     */
    public function findServicesFromContact(Contact $contact): array
    {
        if ($contact->isAdmin()) {
            return $this
                ->realTimeServiceRepository
                ->getServices(null);
        } elseif (count($accessGroups = $this->accessGroupRepository->findFromContact($contact)) > 0) {
            return $this
                ->realTimeServiceRepository
                ->getServices($accessGroups);
        }
        return [];
    }
}
