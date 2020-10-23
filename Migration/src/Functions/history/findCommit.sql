CREATE OR REPLACE FUNCTION find_commit (_created_at timestamptz, keyword text, out result json)
  LANGUAGE plpgsql
  PARALLEL SAFE
AS $$
BEGIN
  SELECT json_agg(t) INTO result
    FROM
    (
      SELECT
        sha,
        created_at,
        message
      FROM commits
      WHERE (keyword is null or text_to_array_of_words(message) @> ARRAY[keyword]) and
            created_at BETWEEN date_trunc('day', _created_at) and (date_trunc('day', _created_at) + INTERVAL '1 day')
    ) t;
END
$$;
