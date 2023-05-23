<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230523121359 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__incident AS SELECT id, date FROM incident');
        $this->addSql('DROP TABLE incident');
        $this->addSql('CREATE TABLE incident (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, ride_id INTEGER DEFAULT NULL, date DATETIME NOT NULL, CONSTRAINT FK_3D03A11A302A8A70 FOREIGN KEY (ride_id) REFERENCES ride (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO incident (id, date) SELECT id, date FROM __temp__incident');
        $this->addSql('DROP TABLE __temp__incident');
        $this->addSql('CREATE INDEX IDX_3D03A11A302A8A70 ON incident (ride_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__incident AS SELECT id, date FROM incident');
        $this->addSql('DROP TABLE incident');
        $this->addSql('CREATE TABLE incident (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, date DATETIME NOT NULL)');
        $this->addSql('INSERT INTO incident (id, date) SELECT id, date FROM __temp__incident');
        $this->addSql('DROP TABLE __temp__incident');
    }
}
