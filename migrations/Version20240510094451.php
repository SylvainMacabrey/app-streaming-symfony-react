<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240510094451 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_movie (category_id INT NOT NULL, movie_id INT NOT NULL, INDEX IDX_F56DBD2612469DE2 (category_id), INDEX IDX_F56DBD268F93B6FC (movie_id), PRIMARY KEY(category_id, movie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE csa (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, value INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movie (id INT AUTO_INCREMENT NOT NULL, csa_id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, thumbnail VARCHAR(255) NOT NULL, trailer VARCHAR(255) NOT NULL, director VARCHAR(255) NOT NULL, actors LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_1D5EF26F9B4ACA0C (csa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movie_movie (movie_source INT NOT NULL, movie_target INT NOT NULL, INDEX IDX_631CE8F3A64DE206 (movie_source), INDEX IDX_631CE8F3BFA8B289 (movie_target), PRIMARY KEY(movie_source, movie_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category_movie ADD CONSTRAINT FK_F56DBD2612469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_movie ADD CONSTRAINT FK_F56DBD268F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movie ADD CONSTRAINT FK_1D5EF26F9B4ACA0C FOREIGN KEY (csa_id) REFERENCES csa (id)');
        $this->addSql('ALTER TABLE movie_movie ADD CONSTRAINT FK_631CE8F3A64DE206 FOREIGN KEY (movie_source) REFERENCES movie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movie_movie ADD CONSTRAINT FK_631CE8F3BFA8B289 FOREIGN KEY (movie_target) REFERENCES movie (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category_movie DROP FOREIGN KEY FK_F56DBD2612469DE2');
        $this->addSql('ALTER TABLE category_movie DROP FOREIGN KEY FK_F56DBD268F93B6FC');
        $this->addSql('ALTER TABLE movie DROP FOREIGN KEY FK_1D5EF26F9B4ACA0C');
        $this->addSql('ALTER TABLE movie_movie DROP FOREIGN KEY FK_631CE8F3A64DE206');
        $this->addSql('ALTER TABLE movie_movie DROP FOREIGN KEY FK_631CE8F3BFA8B289');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_movie');
        $this->addSql('DROP TABLE csa');
        $this->addSql('DROP TABLE movie');
        $this->addSql('DROP TABLE movie_movie');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
