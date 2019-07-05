<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190705091955 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('INSERT INTO `user` (`email`, `roles`, `password`, `lastname`, `firstname`, `phone`) VALUES (\'lavoliere45@gmail.com\', \'[\"ROLE_ADMIN\"]\', \'$argon2id$v=19$m=65536,t=6,p=1$CDNWrzyws4ORgzh+FRgu5A$oFkEEG1eGhGra1uSeIsnGQfw8HVYtKCDyX5Z2rscTrs\', \'Lecomte-Fousset\', \'Vincent\', \'0660391318\')');
        $this->addSql('INSERT INTO `category` (`name`) VALUES (\'Légumes\')');
        $this->addSql('INSERT INTO `category` (`name`) VALUES (\'Fruits\')');
        $this->addSql('INSERT INTO `category` (`name`) VALUES (\'Produits de la région\')');
        $this->addSql('INSERT INTO `category` (`name`) VALUES (\'Panier de la semaine\')');
        $this->addSql('INSERT INTO `month_calendar` (`month`) VALUES (\'Janvier\')');
        $this->addSql('INSERT INTO `month_calendar` (`month`) VALUES (\'Février\')');
        $this->addSql('INSERT INTO `month_calendar` (`month`) VALUES(\'Mars\')');
        $this->addSql('INSERT INTO `month_calendar` (`month`) VALUES (\'Avril\')');
        $this->addSql('INSERT INTO `month_calendar` (`month`) VALUES (\'Mai\')');
        $this->addSql('INSERT INTO `month_calendar` (`month`) VALUES (\'Juin\')');
        $this->addSql('INSERT INTO `month_calendar` (`month`) VALUES (\'Juillet\')');
        $this->addSql('INSERT INTO `month_calendar` (`month`) VALUES (\'Aout\')');
        $this->addSql('INSERT INTO `month_calendar` (`month`) VALUES (\'Septembre\')');
        $this->addSql('INSERT INTO `month_calendar` (`month`) VALUES (\'Octobre\')');
        $this->addSql('INSERT INTO `month_calendar` (`month`) VALUES (\'Novembre\')');
        $this->addSql('INSERT INTO `month_calendar` (`month`) VALUES (\'Décembre\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');


        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE month_calendar');
        $this->addSql('DROP TABLE category');
    }
}
