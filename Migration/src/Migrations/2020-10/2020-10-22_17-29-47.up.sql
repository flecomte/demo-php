create table history
(
    id         text,
    created_at timestamptz,
    data       jsonb       not null,
    primary key (created_at, id)
) partition by RANGE (created_at);

-- partition of history table
create table history_2010 partition of history for values from (MINVALUE) to (('2010-01-01'::timestamptz));

do language plpgsql $$
begin
    for year in 2011..2024
    loop
        execute 'create table history_' || year || ' partition of history for values from ((''' || year || '-01-01''::timestamptz)) to ((''' || year+1 || '-01-01''::timestamptz))';
    end loop;
end;
$$;

create table history_2025 partition of history for values from (('2025-01-01'::timestamptz)) to (MAXVALUE);

-- convert jsonb array of text to array of word as text
CREATE OR REPLACE FUNCTION jsonb_array_to_words (in input jsonb, out result text[])
    LANGUAGE plpgsql
    PARALLEL SAFE
    IMMUTABLE
AS $$
BEGIN
    select array_agg(c) into result
    from jsonb_array_elements(input) as r,
    lateral regexp_split_to_array(r->>0, E'\\s+') as b,
    lateral unnest(b) c;
END
$$;

-- extract tags from commit messages
CREATE OR REPLACE FUNCTION history_tags (in data jsonb, out result text[])
    LANGUAGE plpgsql
    PARALLEL SAFE
    IMMUTABLE
AS $$
BEGIN
    select jsonb_array_to_words(jsonb_path_query_array(data, '$.payload.commits[*].message')) into result;
END
$$;

create index history_type on history using btree ((data->>'type'));
-- Index for tags
create index history_tag ON history
    USING gin
    (history_tags(data))
    WHERE data->>'type' = 'PushEvent';