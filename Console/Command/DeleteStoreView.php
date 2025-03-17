<?php
namespace CopeX\StoreDelete\Console\Command;

use Magento\Framework\App\State;
use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\StoreRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\Registry;


class DeleteStoreView extends Command
{
    private StoreRepository $storeRepository;
    private StoreManagerInterface $storeManager;
    private State $state;

    private Registry $registry;


    public function __construct(
        StoreRepository $storeRepository,
        StoreManagerInterface $storeManager,
        State $state,
        Registry $registry
    ) {
        parent::__construct();
        $this->storeRepository = $storeRepository;
        $this->storeManager = $storeManager;
        $this->state = $state;
        $this->registry = $registry;
    }

    protected function configure()
    {
        $this->setName('store:view:delete')
            ->setDescription('Delete a store view by ID')
            ->addArgument('store_view_id', InputArgument::REQUIRED, 'Store View ID');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->registry->register('isSecureArea', true);
        $this->state->setAreaCode('adminhtml');

        $storeViewId = (int)$input->getArgument('store_view_id');
        $store = $this->storeRepository->getById($storeViewId);

        if ($store->isDefault()) {
            throw new LocalizedException(__('Cannot delete the default store view.'));
        }

        $store->delete();
        $output->writeln("Store View ID $storeViewId deleted.");
        return 0;
    }
}