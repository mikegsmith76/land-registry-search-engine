<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200920084224 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, reference VARCHAR(255) NOT NULL, price INT NOT NULL, date DATETIME NOT NULL, postcode VARCHAR(255) NOT NULL, property_type VARCHAR(1) NOT NULL, new TINYINT(1) NOT NULL, tenure VARCHAR(1) NOT NULL, house_number_name VARCHAR(255) NOT NULL, unit_name VARCHAR(255) NOT NULL, street VARCHAR(255) NOT NULL, locality VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, district VARCHAR(255) NOT NULL, county VARCHAR(255) NOT NULL, type VARCHAR(1) NOT NULL, UNIQUE INDEX UNIQ_723705D1AEA34913 (reference), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE transaction');
    }
}
