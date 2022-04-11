<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220410172731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire ADD id INT AUTO_INCREMENT NOT NULL, DROP id_commentaire, CHANGE comment comment VARCHAR(255) NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE publication MODIFY id_pub INT NOT NULL');
        $this->addSql('DROP INDEX id_u_fr ON publication');
        $this->addSql('ALTER TABLE publication DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE publication ADD nbre_commentaire INT DEFAULT NULL, DROP nbre_commentaires, CHANGE date_pub date_pub DATE DEFAULT NULL, CHANGE reactions reactions INT DEFAULT NULL, CHANGE topic topic VARCHAR(255) NOT NULL, CHANGE id_pub id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE publication ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE commentaire DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE commentaire ADD id_commentaire INT NOT NULL, DROP id, CHANGE comment comment VARCHAR(60) NOT NULL');
        $this->addSql('ALTER TABLE publication MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE publication DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE publication ADD nbre_commentaires INT NOT NULL, DROP nbre_commentaire, CHANGE date_pub date_pub DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE reactions reactions INT NOT NULL, CHANGE topic topic VARCHAR(120) NOT NULL, CHANGE id id_pub INT AUTO_INCREMENT NOT NULL');
        $this->addSql('CREATE INDEX id_u_fr ON publication (id_u)');
        $this->addSql('ALTER TABLE publication ADD PRIMARY KEY (id_pub)');
    }
}
