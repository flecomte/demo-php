CREATE OR REPLACE FUNCTION find_history (_created_at timestamptz, keyword text, out result json)
  LANGUAGE plpgsql
  PARALLEL SAFE
AS $$
BEGIN
  SELECT to_json(t) INTO result
    FROM
    (
      SELECT
        *
      FROM history
      WHERE created_at BETWEEN date_trunc('day', _created_at) and (date_trunc('day', _created_at) + INTERVAL '1 day')
    ) t;
END;
$$;