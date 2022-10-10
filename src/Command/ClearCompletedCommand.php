<?php

namespace App\Command;


use App\Repository\ApplicationsRepository;
use App\Repository\ApplicationFileRepository;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


#[AsCommand(
    name: 'app:clear-completed',
    description: 'Add a short description for your command',
)]
class ClearCompletedCommand extends Command
{
    private $appRep;
    private $appFileRep;
    private $fileSys;    
    private $publicDirectory;

    public function __construct(ApplicationsRepository $appRep, ApplicationFileRepository $appFileRep, Filesystem $fileSys, string $publicDirectory) 
    {
        $this->appRep = $appRep;
        $this->appFileRep = $appFileRep;
        $this->fileSys = $fileSys;        
        $this->publicDirectory = $publicDirectory;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('day', null, InputOption::VALUE_OPTIONAL, 'Option description')
        ;        
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $arrId = $this->appRep->getIdCompletedApplication();
                        
        if (count($arrId) > 0) {
            foreach ($arrId as $value) {                
                $appArrFile = $this->appFileRep->findBy(array('name_file' => $value['id']));
                foreach ($appArrFile as $file) {
                    if ($this->fileSys->exists($this->publicDirectory . $file->getName())) {
                        $this->fileSys->remove($this->publicDirectory . $file->getName());
                    }
                                        
                }
                $this->appFileRep->removeArray($appArrFile, true);
            }            
        }
        
        $this->appRep->removeCompletedApplication();

        $msg = '';     
        if (count($arrId) == 0) {
            $msg = "Нет заявок для удаления. Передать --help для просмотра опций.";
        } elseif (count($arrId) == 1) {
            $msg = "Заявка удалена id: '{$arrId[0]['id']}'. Передать --help для просмотра опций.";
        } elseif (count($arrId) > 0) {
            $appIdString = '';
            foreach ($arrId as $value) {
               $appIdString .= $value['id'] . ' '; 
            }
            $appIdString = trim($appIdString);
            $msg = "Заявки удалены id: '{$appIdString}'. Передать --help для просмотра опций.";
        }
        
        $io->success($msg);

        return Command::SUCCESS;
    }
}
