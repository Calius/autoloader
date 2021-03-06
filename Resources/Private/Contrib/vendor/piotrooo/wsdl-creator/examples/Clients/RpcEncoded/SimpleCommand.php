<?php
namespace Clients\RpcEncoded;

use Clients\InitCommand;
use SoapClient;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SimpleCommand extends InitCommand
{
    protected function configure()
    {
        $this->setName('rpc_encoded:simple');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $this->soapClient = new SoapClient('http://localhost/wsdl-creator/examples/rpc_encoded/SimpleExampleSoapServer.php?wsdl', array(
            'trace' => true, 'cache_wsdl' => WSDL_CACHE_NONE
        ));

        $this->serviceInfo('Client Simple - rpc/encoded');

        $this->renderMethodsTable();

        $response = $this->soapClient->getNameWithAge('john', 5);
        $this->method('getNameWithAge', array('john', 5), $response);

        $response = $this->soapClient->getNameForUsers(array('john', 'billy', 'peter'));
        $this->method('getNameForUser', array(array('john', 'billy', 'peter')), $response);

        $response = $this->soapClient->countTo(5);
        $this->method('countTo', array(5), $response);
    }
}