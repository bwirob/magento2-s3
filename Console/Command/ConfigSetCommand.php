<?php
namespace Thai\S3\Console\Command;

use Magento\Config\Model\Config\Factory;
use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @inheritdoc
 */
class ConfigSetCommand extends Command
{
    /**
     * @var Factory
     */
    private $configFactory;

    /**
     * @var State
     */
    private $state;

    /**
     * @param State $state
     * @param Factory $configFactory
     */
    public function __construct(
        State $state,
        Factory $configFactory
    ) {
        $this->state = $state;
        $this->configFactory = $configFactory;

        parent::__construct();
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('s3:config:set');
        $this->setDescription('Allows you to set your S3 configuration via the CLI.');
        $this->setDefinition($this->getOptionsList());
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        return $this->state->emulateAreaCode(Area::AREA_ADMINHTML, function () use ($input, $output) {
            if (!$input->getOption('region') && !$input->getOption('bucket')) {
                $output->writeln($this->getSynopsis());

                return 1;
            }

            $config = $this->configFactory->create();

            foreach ($this->getOptions() as $option => $pathValue) {
                if (!empty($input->getOption($option))) {
                    $config->setDataByPath('thai_s3/general/' . $pathValue, $input->getOption($option));
                    $config->save();
                }
            }

            $output->writeln('<info>You have successfully updated your S3 credentials.</info>');

            return 0;
        });
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return [
            'bucket' => 'bucket',
            'region' => 'region',
        ];
    }

    /**
     * @return array
     */
    public function getOptionsList()
    {
        return [
            new InputOption('bucket', null, InputOption::VALUE_OPTIONAL, 'an S3 bucket name'),
            new InputOption('region', null, InputOption::VALUE_OPTIONAL, 'an S3 region, e.g. us-east-1'),
        ];
    }
}
