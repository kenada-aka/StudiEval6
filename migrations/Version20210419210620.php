<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210419210620 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE admin');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE admin (iduser INT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, lastname VARCHAR(180) NOT NULL, firstname VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, registration_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(iduser))');
        $this->addSql('CREATE UNIQUE INDEX uniq_880e0d7683a00e68 ON admin (firstname)');
        $this->addSql('CREATE UNIQUE INDEX uniq_880e0d763124b5b6 ON admin (lastname)');
        $this->addSql('CREATE UNIQUE INDEX uniq_880e0d76f85e0677 ON admin (username)');
    }
}
