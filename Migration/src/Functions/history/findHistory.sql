CREATE OR REPLACE FUNCTION find_history (_created_at timestamptz, keyword text, out result json)
  LANGUAGE plpgsql
  PARALLEL SAFE
AS $$
BEGIN
  SELECT json_agg(t) INTO result
    FROM
    (
      SELECT
        id,
        created_at,
        jsonb_path_query_array(data, '$.payload.commits[*].message') as messages
      FROM history
      WHERE data->>'type' = 'PushEvent' and
            (keyword is null or history_tags(data) @> ARRAY[keyword]) and
            created_at BETWEEN date_trunc('day', _created_at) and (date_trunc('day', _created_at) + INTERVAL '1 day')
    ) t;
END
$$;
