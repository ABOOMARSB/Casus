<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211108100716 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, sort INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(75) NOT NULL, street LONGTEXT NOT NULL, zip VARCHAR(6) NOT NULL, latitude NUMERIC(20, 16) NOT NULL, longitude NUMERIC(20, 16) NOT NULL, website LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE deal (id INT AUTO_INCREMENT NOT NULL, city_id_id INT NOT NULL, company_id_id INT NOT NULL, category_id_id INT NOT NULL, deal_unique LONGTEXT NOT NULL, title VARCHAR(255) NOT NULL, slug LONGTEXT NOT NULL, img VARCHAR(255) NOT NULL, sold INT NOT NULL, new_price NUMERIC(7, 2) NOT NULL, from_price NUMERIC(7, 2) NOT NULL, is_for_sale TINYINT(1) NOT NULL, is_new_today TINYINT(1) NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_E3FEC1163CCE3900 (city_id_id), INDEX IDX_E3FEC11638B53C32 (company_id_id), INDEX IDX_E3FEC1169777D11E (category_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE deal ADD CONSTRAINT FK_E3FEC1163CCE3900 FOREIGN KEY (city_id_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE deal ADD CONSTRAINT FK_E3FEC11638B53C32 FOREIGN KEY (company_id_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE deal ADD CONSTRAINT FK_E3FEC1169777D11E FOREIGN KEY (category_id_id) REFERENCES category (id)');
        $this->addSql('DROP TABLE deal_data');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE deal DROP FOREIGN KEY FK_E3FEC1169777D11E');
        $this->addSql('ALTER TABLE deal DROP FOREIGN KEY FK_E3FEC1163CCE3900');
        $this->addSql('ALTER TABLE deal DROP FOREIGN KEY FK_E3FEC11638B53C32');
        $this->addSql('CREATE TABLE deal_data (id VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, title VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, company_name VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, city_name VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, sold_amount VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, max_amount INT NOT NULL, from_price DOUBLE PRECISION NOT NULL, original_price DOUBLE PRECISION NOT NULL, img VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, new_today TINYINT(1) NOT NULL, saved INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE deal');
    }
}
