CREATE OR REPLACE FUNCTION insert_history (data json) RETURNS void
  LANGUAGE plpgsql
  PARALLEL SAFE
AS $$
BEGIN
    INSERT INTO history (created_at, data)
    SELECT (data->>'created_at')::timestamptz, data;
END;
$$;