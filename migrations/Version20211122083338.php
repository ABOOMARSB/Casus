<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211122083338 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company ADD company_slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE deal ADD company_id INT NOT NULL');
        $this->addSql('ALTER TABLE deal ADD CONSTRAINT FK_E3FEC11638B53C32 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('CREATE INDEX IDX_E3FEC11638B53C32 ON deal (company_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company DROP company_slug');
        $this->addSql('ALTER TABLE deal DROP FOREIGN KEY FK_E3FEC11638B53C32');
        $this->addSql('DROP INDEX IDX_E3FEC11638B53C32 ON deal');
        $this->addSql('ALTER TABLE deal DROP company_id');
    }
}
