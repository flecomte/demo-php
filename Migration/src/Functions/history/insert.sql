CREATE OR REPLACE FUNCTION insert_history (data json) RETURNS void
  LANGUAGE plpgsql
  PARALLEL SAFE
AS $$
BEGIN
    INSERT INTO history (id, created_at, data)
    SELECT data->>'id', (data->>'created_at')::timestamptz, data
    on conflict DO NOTHING;
END;
$$;