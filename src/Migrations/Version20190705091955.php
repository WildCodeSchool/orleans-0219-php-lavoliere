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

        $this->addSql('CREATE TABLE recipe (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, url VARCHAR(255) NOT NULL, is_present TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, postal_code VARCHAR(6) NOT NULL, city VARCHAR(255) NOT NULL, delivery_date VARCHAR(255) NOT NULL, is_private TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, reset_password_token VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partner (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE month_calendar (id INT AUTO_INCREMENT NOT NULL, month VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picking_calendar (id INT AUTO_INCREMENT NOT NULL, season_start_at_id INT NOT NULL, season_end_at_id INT NOT NULL, picking_start_at_id INT NOT NULL, picking_end_at_id INT NOT NULL, product VARCHAR(255) NOT NULL, out_of_stock TINYINT(1) NOT NULL, INDEX IDX_3C1561E922FA907E (season_start_at_id), INDEX IDX_3C1561E9E5808BE3 (season_end_at_id), INDEX IDX_3C1561E9B171AA1E (picking_start_at_id), INDEX IDX_3C1561E92889C7B5 (picking_end_at_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, picture VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, start_at DATETIME NOT NULL, end_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE purchase_product (id INT AUTO_INCREMENT NOT NULL, purchase_id INT NOT NULL, quantity INT NOT NULL, price DOUBLE PRECISION NOT NULL, name VARCHAR(255) NOT NULL, bundle VARCHAR(255) NOT NULL, INDEX IDX_C890CED4558FBEB9 (purchase_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE purchase (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, delivery_date DATE NOT NULL, order_date DATETIME NOT NULL, location VARCHAR(255) NOT NULL, comment VARCHAR(255) DEFAULT NULL, INDEX IDX_6117D13BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(255) NOT NULL, bundle VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, description LONGTEXT NOT NULL, origin VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, is_showcased TINYINT(1) NOT NULL, is_available TINYINT(1) NOT NULL, INDEX IDX_D34A04AD12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE picking_calendar ADD CONSTRAINT FK_3C1561E922FA907E FOREIGN KEY (season_start_at_id) REFERENCES month_calendar (id)');
        $this->addSql('ALTER TABLE picking_calendar ADD CONSTRAINT FK_3C1561E9E5808BE3 FOREIGN KEY (season_end_at_id) REFERENCES month_calendar (id)');
        $this->addSql('ALTER TABLE picking_calendar ADD CONSTRAINT FK_3C1561E9B171AA1E FOREIGN KEY (picking_start_at_id) REFERENCES month_calendar (id)');
        $this->addSql('ALTER TABLE picking_calendar ADD CONSTRAINT FK_3C1561E92889C7B5 FOREIGN KEY (picking_end_at_id) REFERENCES month_calendar (id)');
        $this->addSql('ALTER TABLE purchase_product ADD CONSTRAINT FK_C890CED4558FBEB9 FOREIGN KEY (purchase_id) REFERENCES purchase (id)');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
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

        $this->addSql('ALTER TABLE purchase DROP FOREIGN KEY FK_6117D13BA76ED395');
        $this->addSql('ALTER TABLE picking_calendar DROP FOREIGN KEY FK_3C1561E922FA907E');
        $this->addSql('ALTER TABLE picking_calendar DROP FOREIGN KEY FK_3C1561E9E5808BE3');
        $this->addSql('ALTER TABLE picking_calendar DROP FOREIGN KEY FK_3C1561E9B171AA1E');
        $this->addSql('ALTER TABLE picking_calendar DROP FOREIGN KEY FK_3C1561E92889C7B5');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE purchase_product DROP FOREIGN KEY FK_C890CED4558FBEB9');
        $this->addSql('DROP TABLE recipe');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE partner');
        $this->addSql('DROP TABLE month_calendar');
        $this->addSql('DROP TABLE picking_calendar');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE purchase_product');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE purchase');
        $this->addSql('DROP TABLE product');
    }
}
