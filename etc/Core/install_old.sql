

CREATE TABLE cms_placeholders (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    package VARCHAR(100) NOT NULL, 
    uri VARCHAR(150) NOT NULL, 
    alias VARCHAR(150) NOT NULL, 
    contents TEXT NOT NULL, 
    FOREIGN KEY (package) REFERENCES internal_packages (alias) ON DELETE CASCADE
) engine=InnoDB;





/**
 * Images
 */

CREATE TABLE images (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    type VARCHAR(50) NOT NULL, 
    record_id VARCHAR(50) NOT NULL DEFAULT '', 
    is_default TINYINT(1) NOT NULL DEFAULT 0, 
    size VARCHAR(15) NOT NULL DEFAULT 'full', 
    width INT NOT NULL DEFAULT 0, 
    height INT NOT NULL DEFAULT 0, 
    mime_type VARCHAR(50) NOT NULL DEFAULT 'image/jpg', 
    filename VARCHAR(100) NOT NULL
) engine = InnoDB;

CREATE TABLE images_contents (
    id INT NOT NULL PRIMARY KEY, 
    contents LONGBLOB NOT NULL, 
    FOREIGN KEY (id) REFERENCES images (id) ON DELETE CASCADE
) engine=InnoDB;





