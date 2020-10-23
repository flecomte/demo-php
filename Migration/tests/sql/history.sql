do
$$
    declare
        found_history json;
    begin
        -- insert good history
        perform insert_history('{"id": "123", "type":"PushEvent", "created_at": "2015-01-01T12:00:08Z", "payload": {"commits": [{"message":"plop"}]}}');
        -- insert wrong type
        perform insert_history('{"id": "123", "type":"other", "created_at": "2015-01-01T12:00:08Z", "payload": {"commits": [{"message":"plop"}]}}');
        -- insert wrong message
        perform insert_history('{"id": "1234", "type":"PushEvent", "created_at": "2015-01-01T12:00:08Z", "payload": {"commits": [{"message":"plip"}]}}');

        select find_history('2015-01-01 01:00:00+00'::timestamptz, 'plop') into found_history;
        assert (found_history#>>'{0, id}') = '123', 'The history with id "123" must be found';
        assert (json_array_length(found_history)) = 1, 'Only one history must be found';

        rollback;
        raise notice 'history test pass';
    end
$$;