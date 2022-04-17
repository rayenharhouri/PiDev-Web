<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220417212640 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY id_pubFK');
        $this->addSql('DROP INDEX id_pubFK ON commentaire');
        $this->addSql('ALTER TABLE commentaire ADD publication_id INT NOT NULL, CHANGE id_pub id_pub_id INT NOT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCA5CA559A FOREIGN KEY (id_pub_id) REFERENCES publication (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC38B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id)');
        $this->addSql('CREATE INDEX IDX_67F068BCA5CA559A ON commentaire (id_pub_id)');
        $this->addSql('CREATE INDEX IDX_67F068BC38B217A7 ON commentaire (publication_id)');
        $this->addSql('ALTER TABLE publication CHANGE reactions reactions INT DEFAULT NULL, CHANGE nbre_commentaires nbre_commentaires INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCA5CA559A');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC38B217A7');
        $this->addSql('DROP INDEX IDX_67F068BCA5CA559A ON commentaire');
        $this->addSql('DROP INDEX IDX_67F068BC38B217A7 ON commentaire');
        $this->addSql('ALTER TABLE commentaire ADD id_pub INT NOT NULL, DROP id_pub_id, DROP publication_id');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT id_pubFK FOREIGN KEY (id_pub) REFERENCES publication (id_pub)');
        $this->addSql('CREATE INDEX id_pubFK ON commentaire (id_pub)');
        $this->addSql('ALTER TABLE publication CHANGE reactions reactions INT DEFAULT 0, CHANGE nbre_commentaires nbre_commentaires INT DEFAULT 0');
    }
}
