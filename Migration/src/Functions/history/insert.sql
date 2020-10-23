CREATE OR REPLACE FUNCTION insert_commit (data json) RETURNS void
  LANGUAGE plpgsql
  PARALLEL SAFE
AS $$
BEGIN
    INSERT INTO commits (sha, created_at, message)
    SELECT sha, created_at, message
    from json_populate_record(null::commits, data)
    on conflict DO NOTHING;
END;
$$;