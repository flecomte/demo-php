create table commits
(
    sha        text,
    created_at timestamptz,
    message    text       not null,
    primary key (created_at, sha)
) partition by RANGE (created_at);

-- partition of commits table
create table commits_2010 partition of commits for values from (MINVALUE) to (('2010-01-01'::timestamptz));

do language plpgsql $$
begin
    for year in 2011..2024
    loop
        execute 'create table commits_' || year || ' partition of commits for values from ((''' || year || '-01-01''::timestamptz)) to ((''' || year+1 || '-01-01''::timestamptz))';
    end loop;
end;
$$;

create table commits_2025 partition of commits for values from (('2025-01-01'::timestamptz)) to (MAXVALUE);

-- convert text to array of word
CREATE OR REPLACE FUNCTION text_to_array_of_words (in input text, out result text[])
    LANGUAGE plpgsql
    PARALLEL SAFE
    IMMUTABLE
AS $$
BEGIN
    select regexp_split_to_array(input, E'\\s+') into result;
END
$$;

-- Index for tags
create index commits_keyword ON commits
    USING gin
    (text_to_array_of_words(message));