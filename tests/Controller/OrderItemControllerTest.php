<?php

namespace App\Test\Controller;

use App\Entity\OrderItem;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OrderItemControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/order/item/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(OrderItem::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('OrderItem index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'order_item[bookTitle]' => 'Testing',
            'order_item[bookPrice]' => 'Testing',
            'order_item[quantity]' => 'Testing',
            'order_item[total]' => 'Testing',
            'order_item[order]' => 'Testing',
        ]);

        self::assertResponseRedirects('/sweet/food/');

        self::assertSame(1, $this->getRepository()->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new OrderItem();
        $fixture->setBookTitle('My Title');
        $fixture->setBookPrice('My Title');
        $fixture->setQuantity('My Title');
        $fixture->setTotal('My Title');
        $fixture->setOrder('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('OrderItem');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new OrderItem();
        $fixture->setBookTitle('Value');
        $fixture->setBookPrice('Value');
        $fixture->setQuantity('Value');
        $fixture->setTotal('Value');
        $fixture->setOrder('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'order_item[bookTitle]' => 'Something New',
            'order_item[bookPrice]' => 'Something New',
            'order_item[quantity]' => 'Something New',
            'order_item[total]' => 'Something New',
            'order_item[order]' => 'Something New',
        ]);

        self::assertResponseRedirects('/order/item/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getBookTitle());
        self::assertSame('Something New', $fixture[0]->getBookPrice());
        self::assertSame('Something New', $fixture[0]->getQuantity());
        self::assertSame('Something New', $fixture[0]->getTotal());
        self::assertSame('Something New', $fixture[0]->getOrder());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new OrderItem();
        $fixture->setBookTitle('Value');
        $fixture->setBookPrice('Value');
        $fixture->setQuantity('Value');
        $fixture->setTotal('Value');
        $fixture->setOrder('Value');

        $this->manager->remove($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/order/item/');
        self::assertSame(0, $this->repository->count([]));
    }
}
