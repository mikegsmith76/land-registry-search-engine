<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200922111855 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction DROP CONSTRAINT FK_723705D1549213EC;');
        $this->addSql('ALTER TABLE property CHANGE id id VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX UNIQ_723705D1AEA34913 ON transaction');
        $this->addSql('ALTER TABLE transaction DROP reference, CHANGE id id VARCHAR(255) NOT NULL, CHANGE property_id property_id VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE property CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE transaction ADD reference VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE property_id property_id INT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_723705D1AEA34913 ON transaction (reference)');
    }
}
