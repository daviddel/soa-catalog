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
                    'locale'    => 'fr_FR'
                )
            );

            $request = $client->post('/api/fr_FR/properties/create.json',
                $headers,
                $property
            );

            $response = $request->send();
            $output->writeln($response->getEffectiveUrl());
            $output->writeln($response->getLocation());
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
                    'locale'        => 'fr_FR'
                )
            );

            $request = $client->post('/api/fr_FR/products/create.json',
                $headers,
                $product
            );

            $response = $request->send();
            $output->writeln($response->getEffectiveUrl());
            $output->writeln($response->getLocation());
        }

        foreach ($products as $product) {
            $variant = array(
                'variant' => array(
                )
            );

            $request = $client->post('/api/fr_FR/products/'.$product.'/variants/add.json',
                $headers,
                $variant
            );

            $response = $request->send();
            $output->writeln($response->getEffectiveUrl());
            $output->writeln($response->getLocation());

            $subscribedPropertiesKeys = array_rand($properties, rand(1, count($properties)));
            if (!is_array($subscribedPropertiesKeys))
                $subscribedPropertiesKeys = array($subscribedPropertiesKeys);
            foreach ($subscribedPropertiesKeys as $subscribedPropertyKey) {
                $subscribedProperty = array(
                    'subscribed_property' => array(
                        'property'  => array('key' => $properties[$subscribedPropertyKey]),
                        'value'     => $faker->sentence(3),
                        'locale'    => 'fr_FR'
                    )
                );

                $request = $client->post('/api/fr_FR/products/'.$product.'/properties/add.json',
                    $headers,
                    $subscribedProperty
                );

                $response = $request->send();
                $output->writeln($response->getEffectiveUrl());
                $output->writeln($response->getLocation());
            }
        }
    }
}
