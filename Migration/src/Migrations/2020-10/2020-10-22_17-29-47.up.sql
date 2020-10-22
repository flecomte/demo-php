create table history
(
    id         uuid primary key default uuid_generate_v4(),
    created_at timestamptz not null,
    data       json        not null
);