<?php
namespace Baquaras\AppliBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Baquaras\AppliBundle\Entity\Agent;

class ConfigureTablespacesCommand extends ContainerAwareCommand
{
    /**
     * paramétrage de la tâche
     * (non-PHPdoc)
     * @see Symfony\Component\Console\Command.Command::configure()
     */
    protected function configure()
    {
        $this
            ->setName('baquaras:configure-tablespaces')
            ->setDescription('Déplace les indexes dans le bon tablespace')
            ->addOption('tablespace', null, InputOption::VALUE_REQUIRED, 'Nom du tablespace', 'idx_1')
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
        $text = 'baquaras: déplacement des indexes sur le bon tablespace.';
        $output->writeln($text);
        $this->moveIndexes($conn, $input->getOption('tablespace'), $output);
    }

    /**
     * déplacement des indexes
     * @param doctrine obj $conn
     * @param strig $tablespace
     * @param OutputInterface $output
     */
    private function moveIndexes($conn, $tablespace, OutputInterface $output)
    {

        $req = <<<SQL

SELECT
    n.nspname || '.' || c.relname AS index_name,
    (select spcname from pg_catalog.pg_tablespace where pg_tablespace.oid=c.reltablespace) AS name_tablespace
FROM
    pg_catalog.pg_class c
    JOIN pg_catalog.pg_namespace n ON n.oid = c.relnamespace
WHERE
    c.relkind = 'i'
AND pg_catalog.pg_table_is_visible(c.oid)
   AND n.nspname=current_schema()

SQL;
        $req.=" AND n.nspname=current_schema()";
        $statement = $conn->query($req);

        foreach ($statement->fetchAll() as $row)
        {
            $index = $row['index_name'];
            $cmdSql=sprintf('ALTER INDEX %s SET TABLESPACE %s', $index, $tablespace);
            $output->writeln('- deplacement de '.$index. ' vers '. $tablespace);
            $conn->query($cmdSql);
        }

    }

}