create table history
(
    id         text,
    created_at timestamptz,
    data       json        not null,
    primary key (created_at, id)
) partition by RANGE (created_at);

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
