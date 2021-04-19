<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210419203120 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (username VARCHAR(180) NOT NULL, roles JSON NOT NULL, lastname VARCHAR(180) NOT NULL, firstname VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, registration_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, idUser INT NOT NULL, PRIMARY KEY(idUser))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_880E0D76F85E0677 ON admin (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_880E0D763124B5B6 ON admin (lastname)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_880E0D7683A00E68 ON admin (firstname)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE admin');
    }
}
