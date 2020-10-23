do
$$
    declare
        found_commit json;
    begin
        -- insert good history
        perform insert_commit('{"sha": "123", "created_at": "2015-01-01T12:00:08Z", "message":"plop"}');
        -- insert wrong message
        perform insert_commit('{"sha": "1234", "created_at": "2015-01-01T12:00:08Z", "message":"plip"}');

        select find_commit('2015-01-01 01:00:00+00'::timestamptz, 'plop') into found_commit;
        assert (found_commit#>>'{0, sha}') = '123', 'The commit with sha "123" must be found';
        assert (json_array_length(found_commit)) = 1, 'Only one commit must be found';

        rollback;
        raise notice 'commits test pass';
    end
$$;