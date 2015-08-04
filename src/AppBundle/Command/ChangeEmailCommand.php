<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use AppBundle\Exception\InvalidDataException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Description of ChangeEmailCommand
 *
 * @author Jarek
 */
class ChangeEmailCommand extends ContainerAwareCommand
{
    /**
     *
     * @var EmailChanger
     */
    protected $changer;
    
    protected function configure()
    {
        $this
            ->setName('email:change')
            ->setDescription("Changes user's email")
            ->addArgument('username', InputArgument::REQUIRED, 'Username')
            ->addArgument('email', InputArgument::REQUIRED, "New email")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->changer = $this->getContainer()->get('email_changer');
        
        try
        {
            $this->changer->change($input->getArgument('username'), $input->getArgument('email'));
            $output->writeln("Email changed successfully");
        } 
        catch (NotFoundHttpException $e) 
        {
            $output->writeln("User not found");
        }
        catch (InvalidDataException $e) 
        {
            $this->printErrors($output);
        }
    }
    
    protected function printErrors(OutputInterface $output)
    {
        $errors = $this->changer->getErrors();

        foreach ($errors as $error)
        {
            $output->writeln("- " . $error->getMessage());
        }        
    }
}