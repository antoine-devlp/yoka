<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220112203312 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE saisons (id INT AUTO_INCREMENT NOT NULL, id_serie_id INT NOT NULL, num_saison INT NOT NULL, INDEX IDX_1F1539CB89986428 (id_serie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE series (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, nbr_saison VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE series_users (series_id INT NOT NULL, users_id INT NOT NULL, INDEX IDX_610C41F45278319C (series_id), INDEX IDX_610C41F467B3B43D (users_id), PRIMARY KEY(series_id, users_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE saisons ADD CONSTRAINT FK_1F1539CB89986428 FOREIGN KEY (id_serie_id) REFERENCES series (id)');
        $this->addSql('ALTER TABLE series_users ADD CONSTRAINT FK_610C41F45278319C FOREIGN KEY (series_id) REFERENCES series (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE series_users ADD CONSTRAINT FK_610C41F467B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE saisons DROP FOREIGN KEY FK_1F1539CB89986428');
        $this->addSql('ALTER TABLE series_users DROP FOREIGN KEY FK_610C41F45278319C');
        $this->addSql('DROP TABLE saisons');
        $this->addSql('DROP TABLE series');
        $this->addSql('DROP TABLE series_users');
    }
}
