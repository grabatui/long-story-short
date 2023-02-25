<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230219135601 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movie_staffs DROP CONSTRAINT FK_FC8ACEE58F93B6FC');
        $this->addSql('ALTER TABLE movie_staffs ADD CONSTRAINT FK_FC8ACEE58F93B6FC FOREIGN KEY (movie_id) REFERENCES "movies" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE movies ALTER premiered_at TYPE DATE');
        $this->addSql('ALTER TABLE movies ALTER deleted_at TYPE DATE');
        $this->addSql('COMMENT ON COLUMN movies.premiered_at IS NULL');
        $this->addSql('COMMENT ON COLUMN movies.deleted_at IS NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "movies" ALTER premiered_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE "movies" ALTER deleted_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('COMMENT ON COLUMN "movies".premiered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "movies".deleted_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE "movie_staffs" DROP CONSTRAINT fk_fc8acee58f93b6fc');
        $this->addSql('ALTER TABLE "movie_staffs" ADD CONSTRAINT fk_fc8acee58f93b6fc FOREIGN KEY (movie_id) REFERENCES movie_staffs (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
