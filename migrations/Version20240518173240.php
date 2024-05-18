<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240518173240 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client_livre (id INT AUTO_INCREMENT NOT NULL, quntite INT NOT NULL, client_id INT NOT NULL, livres_id INT DEFAULT NULL, INDEX IDX_F0ED32E19EB6921 (client_id), INDEX IDX_F0ED32EEBF07F38 (livres_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, customer_name VARCHAR(255) NOT NULL, customer_email VARCHAR(255) NOT NULL, customer_address LONGTEXT NOT NULL, total DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE order_item (id INT AUTO_INCREMENT NOT NULL, book_title VARCHAR(255) NOT NULL, book_price DOUBLE PRECISION NOT NULL, quantity INT NOT NULL, total DOUBLE PRECISION NOT NULL, order_id INT NOT NULL, INDEX IDX_52EA1F098D9F6D38 (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE client_livre ADD CONSTRAINT FK_F0ED32E19EB6921 FOREIGN KEY (client_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE client_livre ADD CONSTRAINT FK_F0ED32EEBF07F38 FOREIGN KEY (livres_id) REFERENCES livres (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F098D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE commande ADD etat TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client_livre DROP FOREIGN KEY FK_F0ED32E19EB6921');
        $this->addSql('ALTER TABLE client_livre DROP FOREIGN KEY FK_F0ED32EEBF07F38');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F098D9F6D38');
        $this->addSql('DROP TABLE client_livre');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_item');
        $this->addSql('ALTER TABLE commande DROP etat');
    }
}
