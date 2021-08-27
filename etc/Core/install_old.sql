

CREATE TABLE internal_boxlists (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    owner VARCHAR(100) NOT NULL, 
    package VARCHAR(100) NOT NULL, 
    alias VARCHAR(100) NOT NULL, 
    order_num SMALLINT NOT NULL DEFAULT 0,
    position VARCHAR(100) NOT NULL DEFAULT 'bottom',  
    href VARCHAR(100) NOT NULL, 
    title VARCHAR(100) NOT NULL, 
    description TEXT NOT NULL, 
    FOREIGN KEY (package) REFERENCES internal_packages (alias) ON DELETE CASCADE, 
    FOREIGN KEY (owner) REFERENCES internal_packages (alias) ON DELETE CASCADE
) engine=InnoDB;

CREATE TABLE internal_tasks (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,  
    failed SMALLINT NOT NULL DEFAULT 0,
    execute_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, 
    adapter VARCHAR(100) NOT NULL, 
    alias VARCHAR(100) NOT NULL, 
    data LONGTEXT 
) engine=InnoDB;

CREATE TABLE cms_placeholders (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    package VARCHAR(100) NOT NULL, 
    uri VARCHAR(150) NOT NULL, 
    alias VARCHAR(150) NOT NULL, 
    contents TEXT NOT NULL, 
    FOREIGN KEY (package) REFERENCES internal_packages (alias) ON DELETE CASCADE
) engine=InnoDB;



/**
 * Notifications
 */

CREATE TABLE notifications (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    is_active TINYINT(1) NOT NULL DEFAULT 1, 
    adapter VARCHAR(100) NOT NULL, 
    sender VARCHAR(30) NOT NULL, 
    recipient VARCHAR(30) NOT NULL, 
    reply_to VARCHAR(100) NOT NULL DEFAULT '',  
    cc VARCHAR(100) NOT NULL DEFAULT '', 
    bcc VARCHAR(100) NOT NULL DEFAULT '',  
    content_type VARCHAR(30) NOT NULL DEFAULT 'text/plain', 
    subject VARCHAR(255) NOT NULL,
    contents LONGTEXT NOT NULL, 
    condition_vars TEXT NOT NULL
) Engine=InnoDB;

CREATE TABLE notifications_attachments ( 
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    notification_id INT NOT NULL, 
    mime_type VARCHAR(100) NOT NULL, 
    filename VARCHAR(255) NOT NULL, 
    contents LONGTEXT NOT NULL, 
    FOREIGN KEY (notification_id) REFERENCES notifications (id) ON DELETE CASCADE
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


/**
 * Dashboards
 */

CREATE TABLE dashboard_items (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    package VARCHAR(100) NOT NULL, 
    area VARCHAR(30) NOT NULL DEFAULT 'admin', 
    type ENUM('top','right','tab') NOT NULL, 
    divid VARCHAR(100) NOT NULL DEFAULT '', 
    panel_class VARCHAR(100) NOT NULL DEFAULT '', 
    alias VARCHAR(255) NOT NULL, 
    title VARCHAR(255) NOT NULL, 
    description TEXT NOT NULL, 
    FOREIGN KEY (package) REFERENCES internal_packages (alias) ON DELETE CASCADE
) engine=InnoDB;

CREATE TABLE dashboard_profiles (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    is_default TINYINT(1) NOT NULL DEFAULT 0, 
    area VARCHAR(30) NOT NULL, 
    userid INT NOT NULL
) engine=InnoDB;

INSERT INTO dashboard_profiles VALUES (1, 1, 'admin', 0);
INSERT INTO dashboard_profiles VALUES (2, 1, 'members', 0);

CREATE TABLE dashboard_profiles_items (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    profile_id INT NOT NULL, 
    type VARCHAR(10) NOT NULL, 
    package VARCHAR(100) NOT NULL, 
    alias VARCHAR(255) NOT NULL, 
    FOREIGN KEY (profile_id) REFERENCES dashboard_profiles (id) ON DELETE CASCADE, 
    FOREIGN KEY (package) REFERENCES internal_packages (alias) ON DELETE CASCADE 
) engine=InnoDB;



