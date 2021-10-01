
CREATE TABLE internal_config (
    package VARCHAR(100) NOT NULL, 
    alias VARCHAR(100) NOT NULL, 
    value TEXT NOT NULL 
);

CREATE TABLE internal_tasks (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,  
    failed SMALLINT NOT NULL DEFAULT 0,
    execute_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    last_execute_time TIMESTAMP,
    class_name VARCHAR(255) NOT NULL,
    data LONGTEXT
);


