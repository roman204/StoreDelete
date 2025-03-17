<?php

namespace CopeX\StoreDelete\Console\Command;

use Magento\Framework\App\State;
use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\WebsiteRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\Registry;

class DeleteWebsite extends Command
{
    private WebsiteRepository $websiteRepository;
    private State $state;
    private Registry $registry;

    public function __construct(WebsiteRepository $websiteRepository, State $state, Registry $registry)
    {
        parent::__construct();
        $this->websiteRepository = $websiteRepository;
        $this->state = $state;
        $this->registry = $registry;
    }

    protected function configure()
    {
        $this->setName('store:website:delete')->setDescription('Delete a website by ID')->addArgument('website_id', InputArgument::REQUIRED, 'Website ID');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->registry->register('isSecureArea', true);
        $this->state->setAreaCode('adminhtml');
        $websiteId = (int)$input->getArgument('website_id');
        $website = $this->websiteRepository->getById($websiteId);
        if ($website->getIsDefault()) {
            throw new LocalizedException(__('Cannot delete the default website.'));
        }
        if (!$website->isCanDelete()) {
            throw new LocalizedException(__('This website cannot be deleted.'));
        }
        try {
            $website->delete();
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            throw new LocalizedException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new LocalizedException(__('Unable to delete the website. Please try again later.'));
        }
        $output->writeln("Website ID $websiteId deleted.");
        return 0;
    }
}