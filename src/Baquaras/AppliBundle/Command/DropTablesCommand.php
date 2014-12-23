<?php

namespace Baquaras\AppliBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Baquaras\AppliBundle\Entity\Agent;

class DropTablesCommand extends ContainerAwareCommand
{
    /**
     * paramétrage de la tâche
     * (non-PHPdoc)
     * @see Symfony\Component\Console\Command.Command::configure()
     */
    protected function configure()
        {
            $this
                ->setName('baquaras:drop-tables')
                ->setDescription('Efface les tables de la base de données')
                ->addOption('confirm', null, InputOption::VALUE_NONE, 'permet de ne pas demander de confirmation avant de vider les tables')
                ->addOption('notConfirm', null, InputOption::VALUE_NONE, 'sert pour les test unitaires, ne vide pas la base')
                ;
        }

    /**
     * execution de la tâche
     * (non-PHPdoc)
     * @see Symfony\Component\Console\Command.Command::execute()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
        {
            // initialize the database connection
            $this->em = $this->getContainer()->get('doctrine.orm.entity_manager');
            $conn = $this->em->getConnection();
            $dialog = $this->getHelperSet()->get('dialog');
            if ($ret = !$input->getOption('notConfirm') === true && $ret = $input->getOption('confirm') === false)
            {
                $ret = $dialog->askConfirmation($output, '<question>Êtes vous sûr de vouloir vider la base ? Y/N</question>', false);
            }
            if ($input->getOption('notConfirm') || $ret = false)
            {
                $output->writeln('baquaras: conservation des tables de la base de données');
            }
            else
            {
                $output->writeln('baquaras:suppression des tables de la base de données');
                $this->dropTables($conn, $output);
            }
        }

    /**
     * effacement des tables
     * @param unknown_type $conn
     * @param OutputInterface $output
     */
    private function dropTables($conn, OutputInterface $output)
    {
        $req = "SELECT relname FROM pg_stat_user_tables where schemaname=current_schema() ORDER BY relname";

        $statement = $conn->query($req);

        foreach ($statement->fetchAll() as $row)
        {
            $table = $row['relname'];
            $conn->query(sprintf('DROP TABLE %s CASCADE', $table));
            $output->writeln('baquaras:  - '.$table);
        }
    }
}