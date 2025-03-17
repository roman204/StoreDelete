<?php
namespace CopeX\StoreDelete\Console\Command;

use Magento\Framework\App\State;
use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\GroupRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\Registry;


class DeleteStoreGroup extends Command
{
    private GroupRepository $groupRepository;
    private State $state;
    private Registry $registry;


    public function __construct(GroupRepository $groupRepository, State $state, Registry $registry)
    {
        parent::__construct();
        $this->groupRepository = $groupRepository;
        $this->state = $state;
        $this->registry = $registry;
    }

    protected function configure()
    {
        $this->setName('store:group:delete')
            ->setDescription('Delete a store group by ID')
            ->addArgument('store_group_id', InputArgument::REQUIRED, 'StoreGroup ID');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->registry->register('isSecureArea', true);
        $this->state->setAreaCode('adminhtml');

        $storeGroupId = (int)$input->getArgument('store_group_id');
        $storeGroup = $this->groupRepository->get($storeGroupId);

        if ($storeGroup->getDefaultStoreId() == $storeGroupId) {
            throw new LocalizedException(__('Cannot delete a StoreGroup that contains the default store view.'));
        }

        try {
            $storeGroup->delete();
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            throw new LocalizedException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new LocalizedException(__('Unable to delete the StoreGroup. Please try again later.'));
        }
        $output->writeln("StoreGroup ID $storeGroupId deleted.");
        return 0;
    }
}