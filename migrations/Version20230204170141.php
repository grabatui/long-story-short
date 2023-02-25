<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230204170141 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE "movies_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "movies" (id INT NOT NULL, title VARCHAR(255) NOT NULL, original_title VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, premiered_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, countries JSON NOT NULL, genres JSON NOT NULL, staff JSON NOT NULL, duration_in_minutes INT NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C61EED30989D9B62 ON "movies" (slug)');
        $this->addSql('COMMENT ON COLUMN "movies".premiered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "movies".deleted_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE "movies_id_seq" CASCADE');
        $this->addSql('DROP TABLE "movies"');
    }
}
