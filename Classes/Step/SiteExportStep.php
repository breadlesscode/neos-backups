<?php

declare(strict_types=1);

namespace Breadlesscode\Backups\Step;

use Neos\Neos\Domain\Model\Site;
use Neos\Neos\Domain\Repository\SiteRepository;
use Neos\Neos\Domain\Service\SiteExportService;
use Neos\Neos\Domain\Service\SiteImportService;
use Neos\Neos\Domain\Service\SiteService;
use Neos\Flow\Annotations as Flow;

class SiteExportStep extends StepAbstract
{
    /**
     * Folder name in backup file
     *
     * @var string
     */
    protected $name = 'SiteExport';

    /**
     * @Flow\Inject()
     * @var SiteExportService
     */
    protected $siteExportService;

    /**
     * @Flow\Inject()
     * @var SiteImportService
     */
    protected $siteImportService;

    /**
     * @Flow\Inject()
     * @var SiteRepository
     */
    protected $siteRepository;

    /**
     * @Flow\Inject()
     * @var SiteService
     */
    protected $siteService;

    /**
     * filename for xml export file
     */
    const SITES_XML_FILENAME = 'Sites.xml';

    /**
     * warning is displayed on restore backup
     */
    protected $restoreWarning = 'All of your current sites will be removed and newly imported!';

    public function backup(): bool
    {
        $backupPath = $this->getBackupStepPath().'/'.self::SITES_XML_FILENAME;
        $sites = $this->siteRepository->findAll()->toArray();
        $this->siteExportService->exportToFile($sites, false, $backupPath);

        return true;
    }

    public function restore(): bool
    {
        $backupPath = $this->getBackupStepPath().'/'.self::SITES_XML_FILENAME;
        $this->siteService->pruneAll();
        $this->siteImportService->importFromFile($backupPath);

        return true;
    }
}
