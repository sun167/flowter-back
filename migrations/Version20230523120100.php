<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230523120100 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE allowance (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, date DATETIME DEFAULT NULL, amount DOUBLE PRECISION NOT NULL, CONSTRAINT FK_66C84883A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_66C84883A76ED395 ON allowance (user_id)');
        $this->addSql('CREATE TABLE brand (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, label VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE car (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, model_id INTEGER DEFAULT NULL, company_id INTEGER DEFAULT NULL, mot_date DATETIME DEFAULT NULL, insurance_date DATETIME DEFAULT NULL, license_plate VARCHAR(20) DEFAULT NULL, mileage DOUBLE PRECISION DEFAULT NULL, CONSTRAINT FK_773DE69D7975B7E7 FOREIGN KEY (model_id) REFERENCES model (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_773DE69D979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_773DE69D7975B7E7 ON car (model_id)');
        $this->addSql('CREATE INDEX IDX_773DE69D979B1AD6 ON car (company_id)');
        $this->addSql('CREATE TABLE car_type (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, label VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE company (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE incident (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, date DATETIME NOT NULL)');
        $this->addSql('CREATE TABLE location (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, car_id INTEGER DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_5E9E89CBC3C6F69F FOREIGN KEY (car_id) REFERENCES car (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5E9E89CBC3C6F69F ON location (car_id)');
        $this->addSql('CREATE TABLE maintenance (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, incident_id INTEGER DEFAULT NULL, car_id INTEGER DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, date DATETIME DEFAULT NULL, commentary VARCHAR(255) DEFAULT NULL, document BLOB DEFAULT NULL, CONSTRAINT FK_2F84F8E9A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_2F84F8E959E53FB9 FOREIGN KEY (incident_id) REFERENCES incident (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_2F84F8E9C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_2F84F8E9A76ED395 ON maintenance (user_id)');
        $this->addSql('CREATE INDEX IDX_2F84F8E959E53FB9 ON maintenance (incident_id)');
        $this->addSql('CREATE INDEX IDX_2F84F8E9C3C6F69F ON maintenance (car_id)');
        $this->addSql('CREATE TABLE model (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, brand_id INTEGER DEFAULT NULL, car_type_id INTEGER DEFAULT NULL, label VARCHAR(255) NOT NULL, nb_seats INTEGER NOT NULL, horse_power INTEGER DEFAULT NULL, CONSTRAINT FK_D79572D944F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D79572D996E7774F FOREIGN KEY (car_type_id) REFERENCES car_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_D79572D944F5D008 ON model (brand_id)');
        $this->addSql('CREATE INDEX IDX_D79572D996E7774F ON model (car_type_id)');
        $this->addSql('CREATE TABLE ride (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, location_id INTEGER DEFAULT NULL, car_id INTEGER DEFAULT NULL, date_of_loan DATETIME NOT NULL, date_of_return DATETIME NOT NULL, real_date_of_loan DATETIME DEFAULT NULL, real_date_of_return DATETIME DEFAULT NULL, nb_of_seats INTEGER DEFAULT NULL, CONSTRAINT FK_9B3D7CD064D218E FOREIGN KEY (location_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9B3D7CD0C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_9B3D7CD064D218E ON ride (location_id)');
        $this->addSql('CREATE INDEX IDX_9B3D7CD0C3C6F69F ON ride (car_id)');
        $this->addSql('CREATE TABLE ride_user (ride_id INTEGER NOT NULL, user_id INTEGER NOT NULL, PRIMARY KEY(ride_id, user_id), CONSTRAINT FK_C6ACE33D302A8A70 FOREIGN KEY (ride_id) REFERENCES ride (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_C6ACE33DA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_C6ACE33D302A8A70 ON ride_user (ride_id)');
        $this->addSql('CREATE INDEX IDX_C6ACE33DA76ED395 ON ride_user (user_id)');
        $this->addSql('CREATE TABLE "user" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, company_id INTEGER DEFAULT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, first_name VARCHAR(50) DEFAULT NULL, last_name VARCHAR(50) DEFAULT NULL, phone VARCHAR(20) DEFAULT NULL, driver_licence_check BOOLEAN DEFAULT NULL, identity_check BOOLEAN NOT NULL, is_driver BOOLEAN DEFAULT NULL, CONSTRAINT FK_8D93D649979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_8D93D649979B1AD6 ON "user" (company_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE allowance');
        $this->addSql('DROP TABLE brand');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE car_type');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE incident');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE maintenance');
        $this->addSql('DROP TABLE model');
        $this->addSql('DROP TABLE ride');
        $this->addSql('DROP TABLE ride_user');
        $this->addSql('DROP TABLE "user"');
    }
}
