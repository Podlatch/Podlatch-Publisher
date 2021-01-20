1. Unter app/config/parameters.yml das Secret kopieren und lokal speichern



2. Folgende Ordner löschen:
* app
* bin
* docs
* src
* tests
* var
* vendor

3. Das aktuelle Zip File herunterladen und im Ordner entpacken

4. den Ordner uploads von web nach public verschieben

5. den Ordner web löschen

6. Installer erneut aufrufen und durchlaufen lassen


SQL Statements zum manuellen ausführen
```
CREATE TABLE orbitale_cms_pages (id INT AUTO_INCREMENT NOT NULL, podcast_show_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary_ordered_time)', category_id INT DEFAULT NULL, parent_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, page_content LONGTEXT DEFAULT NULL, meta_description VARCHAR(255) DEFAULT NULL, meta_title VARCHAR(255) DEFAULT NULL, meta_keywords VARCHAR(255) DEFAULT NULL, css LONGTEXT DEFAULT NULL, js LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, enabled TINYINT(1) NOT NULL, homepage TINYINT(1) NOT NULL, host VARCHAR(255) DEFAULT NULL, locale VARCHAR(6) DEFAULT NULL, UNIQUE INDEX UNIQ_C0E694ED989D9B62 (slug), INDEX IDX_C0E694ED7A80CB6E (podcast_show_id), INDEX IDX_C0E694ED12469DE2 (category_id), INDEX IDX_C0E694ED727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
CREATE TABLE orbitale_cms_categories (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, enabled TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_A8EF7232989D9B62 (slug), INDEX IDX_A8EF7232727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
ALTER TABLE orbitale_cms_pages ADD CONSTRAINT FK_C0E694ED7A80CB6E FOREIGN KEY (podcast_show_id) REFERENCES podcast_show (id);
ALTER TABLE orbitale_cms_pages ADD CONSTRAINT FK_C0E694ED12469DE2 FOREIGN KEY (category_id) REFERENCES orbitale_cms_categories (id);
ALTER TABLE orbitale_cms_pages ADD CONSTRAINT FK_C0E694ED727ACA70 FOREIGN KEY (parent_id) REFERENCES orbitale_cms_pages (id);
ALTER TABLE orbitale_cms_categories ADD CONSTRAINT FK_A8EF7232727ACA70 FOREIGN KEY (parent_id) REFERENCES orbitale_cms_categories (id);
```

