<?php

namespace SOA\CatalogBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class FixturesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('soa:catalog:load-fixtures');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $baseUrl = $this->getContainer()->getParameter('base_url');

        $faker = \Faker\Factory::create('fr_FR');
        $client = new \Guzzle\Http\Client($baseUrl);

        $headers = array(
            'Accept'        => 'application/json',
            'Content-type'  => 'application/json'
        );

        // Load Properties
        $properties = array();
        for ($i = 0; $i < 10; $i++) {
            $properties[$i] = $faker->uuid;
            $property = array(
                'property' => array(
                    'key'       => $properties[$i],
                    'name'      => $faker->sentence(3),
                    'locale'    => $faker->locale
                )
            );

            $request = $client->post('/api/fr_FR/properties/create.json',
                $headers,
                $property
            );

            $request->send();
        }

        // Load Products
        $products = array();
        for ($i = 0; $i < 10; $i++) {
            $products[$i] = $faker->uuid;
            $product = array(
                'product' => array(
                    'reference'     => $products[$i],
                    'name'          => $faker->sentence(3),
                    'description'   => $faker->paragraph(3),
                    'locale'        => $faker->locale
                )
            );

            $request = $client->post('/api/fr_FR/products/create.json',
                $headers,
                $product
            );

            $request->send();
        }
    }
}
