<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240904135821 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prix NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_boutique (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, boutique_id INT NOT NULL, tarif_location_jour NUMERIC(10, 2) NOT NULL, stock INT NOT NULL, INDEX IDX_F4CAC83F7294869C (article_id), INDEX IDX_F4CAC83FAB677BE6 (boutique_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE boutique (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, display_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article_boutique ADD CONSTRAINT FK_F4CAC83F7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE article_boutique ADD CONSTRAINT FK_F4CAC83FAB677BE6 FOREIGN KEY (boutique_id) REFERENCES boutique (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_boutique DROP FOREIGN KEY FK_F4CAC83F7294869C');
        $this->addSql('ALTER TABLE article_boutique DROP FOREIGN KEY FK_F4CAC83FAB677BE6');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE article_boutique');
        $this->addSql('DROP TABLE boutique');
        $this->addSql('DROP TABLE utilisateur');
    }
}
