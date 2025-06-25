<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250624091626 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE country (id SERIAL NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE guide (id SERIAL NOT NULL, app_user_id INT DEFAULT NULL, country_id INT NOT NULL, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, photo VARCHAR(255) NOT NULL, status VARCHAR(20) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_CA9EC7354A3353D8 ON guide (app_user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_CA9EC735F92F3E70 ON guide (country_id)
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN guide.created_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN guide.updated_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE location (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE tourist (id SERIAL NOT NULL, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN tourist.created_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN tourist.updated_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE "user" (id SERIAL NOT NULL, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN "user".created_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN "user".updated_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE visit (id SERIAL NOT NULL, country_id INT NOT NULL, location_id INT NOT NULL, guide_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, start_time TIME(0) WITHOUT TIME ZONE NOT NULL, duration INT NOT NULL, end_time TIME(0) WITHOUT TIME ZONE NOT NULL, comments TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, ended BOOLEAN NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_437EE939F92F3E70 ON visit (country_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_437EE93964D218E ON visit (location_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_437EE939D7ED1D4B ON visit (guide_id)
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN visit.date IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN visit.start_time IS '(DC2Type:time_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN visit.end_time IS '(DC2Type:time_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN visit.created_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN visit.updated_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE visit_tourist (id SERIAL NOT NULL, visit_id INT NOT NULL, tourist_id INT NOT NULL, present BOOLEAN NOT NULL, comment TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_CE18FA1975FA0FF2 ON visit_tourist (visit_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_CE18FA19EC61B273 ON visit_tourist (tourist_id)
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN visit_tourist.created_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN visit_tourist.updated_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE guide ADD CONSTRAINT FK_CA9EC7354A3353D8 FOREIGN KEY (app_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE guide ADD CONSTRAINT FK_CA9EC735F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE visit ADD CONSTRAINT FK_437EE939F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE visit ADD CONSTRAINT FK_437EE93964D218E FOREIGN KEY (location_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE visit ADD CONSTRAINT FK_437EE939D7ED1D4B FOREIGN KEY (guide_id) REFERENCES guide (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE visit_tourist ADD CONSTRAINT FK_CE18FA1975FA0FF2 FOREIGN KEY (visit_id) REFERENCES visit (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE visit_tourist ADD CONSTRAINT FK_CE18FA19EC61B273 FOREIGN KEY (tourist_id) REFERENCES tourist (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE guide DROP CONSTRAINT FK_CA9EC7354A3353D8
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE guide DROP CONSTRAINT FK_CA9EC735F92F3E70
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE visit DROP CONSTRAINT FK_437EE939F92F3E70
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE visit DROP CONSTRAINT FK_437EE93964D218E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE visit DROP CONSTRAINT FK_437EE939D7ED1D4B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE visit_tourist DROP CONSTRAINT FK_CE18FA1975FA0FF2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE visit_tourist DROP CONSTRAINT FK_CE18FA19EC61B273
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE country
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE guide
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE location
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE tourist
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE "user"
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE visit
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE visit_tourist
        SQL);
    }
}
