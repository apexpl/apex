
ALTER TABLE internal_tasks ADD COLUMN is_onetime BOOLEAN NOT NULL DEFAULT false AFTER id;
ALTER TABLE internal_tasks ADD COLUMN in_progress BOOLEAN NOT NULL DEFAULT false AFTER is_onetime;

