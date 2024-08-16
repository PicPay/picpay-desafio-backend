CREATE TABLE IF NOT EXISTS user_tb (
                                       user_id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
                                       user_name VARCHAR(255) NOT NULL,
                                       user_code VARCHAR(50) NOT NULL UNIQUE,
                                       user_email VARCHAR(255) NOT NULL UNIQUE,
                                       user_password VARCHAR(255) NOT NULL,
                                       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                       updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                       is_deleted BOOLEAN NOT NULL
);

CREATE INDEX IF NOT EXISTS idx_user_code ON user_tb(user_code);

CREATE OR REPLACE FUNCTION update_user_tb_updated_at()
    RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- UPDATED AT TRIGGER

CREATE TRIGGER trg_update_user_tb
    BEFORE UPDATE ON user_tb
    FOR EACH ROW
EXECUTE FUNCTION update_user_tb_updated_at();

-- CREATED AT TRIGGER

CREATE OR REPLACE FUNCTION update_user_tb_created_at()
    RETURNS TRIGGER AS $$
BEGIN
    NEW.created_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trg_create_user_tb
    BEFORE INSERT ON user_tb
    FOR EACH ROW
EXECUTE FUNCTION update_user_tb_created_at();

-- DELETED TRIGGER

CREATE OR REPLACE FUNCTION update_user_tb_is_deleted()
    RETURNS TRIGGER AS $$
BEGIN
    NEW.is_deleted = FALSE;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trg_create_deleted_prop_user_tb
    BEFORE INSERT ON user_tb
    FOR EACH ROW
EXECUTE FUNCTION update_user_tb_is_deleted();
