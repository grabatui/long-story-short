<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230216080949 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movie_staffs ADD movie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE movie_staffs ADD CONSTRAINT FK_FC8ACEE58F93B6FC FOREIGN KEY (movie_id) REFERENCES "movie_staffs" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_FC8ACEE58F93B6FC ON movie_staffs (movie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "movie_staffs" DROP CONSTRAINT FK_FC8ACEE58F93B6FC');
        $this->addSql('DROP INDEX IDX_FC8ACEE58F93B6FC');
        $this->addSql('ALTER TABLE "movie_staffs" DROP movie_id');
    }
}
