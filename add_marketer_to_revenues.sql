-- SQL Script to add marketer_id column to revenues table
-- This can be run directly in your database if needed

-- Add the marketer_id column
ALTER TABLE revenues
ADD COLUMN marketer_id BIGINT UNSIGNED NULL AFTER counselor_id;

-- Add foreign key constraint
ALTER TABLE revenues
ADD CONSTRAINT revenues_marketer_id_foreign
FOREIGN KEY (marketer_id) REFERENCES marketers(id)
ON DELETE SET NULL;

-- Add index for better query performance
CREATE INDEX idx_marketer_id ON revenues(marketer_id);
