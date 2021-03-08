<?php

defined('CASU_PATH') or die('Hacking attempt!');

function casu_try_log_user($success, $cas_user) {
    if ($success === true) {
        return true;
    }

//we want user['id'] with casu_id
    if (!($userid = casu_get_userid($cas_user['id']))) {

        $userid = casu_register_user($cas_user);
    }

    casu_register_groups($userid, casu_get_casu_groups($cas_user['attributes']));
    log_user($userid, false);
    return true;
}

function casu_get_userid($cas_user) {
    $query = 'SELECT user_id FROM '
            . USER_INFOS_TABLE .
            ' WHERE casu_id LIKE "'
            . $cas_user . '"';
    $result = pwg_query($query);

    if (pwg_db_num_rows($result) == 0) {
        
    } else {
        list($user_id) = pwg_db_fetch_row($result);
        return $user_id;
    }
}

function casu_register_user($cas_user) {
    global $conf;
    $insert = array(
        $conf['user_fields']['username'] => pwg_db_real_escape_string($cas_user['user']),
        $conf['user_fields']['password'] => '*',
        $conf['user_fields']['email'] => $cas_user['attributes']['mail']
    );

    single_insert(USERS_TABLE, $insert);
    $user_id = pwg_db_insert_id();

    $query = '
SELECT id
  FROM ' . GROUPS_TABLE . '
  WHERE is_default = \'' . boolean_to_string(true) . '\'
  ORDER BY id ASC
;';
    $result = pwg_query($query);
    $inserts = array();
    while ($row = pwg_db_fetch_assoc($result)) {
        $inserts[] = array(
            'user_id' => $user_id,
            'group_id' => $row['id']
        );
    }
    if (count($inserts) != 0) {
        mass_inserts(USER_GROUP_TABLE, array('user_id', 'group_id'), $inserts);
    }

    $override = array();
    if ($conf['browser_language'] and $language = get_browser_language()) {
        $override['language'] = $language;
        $override['casu_id'] = $cas_user['id'];
    }

    create_user_infos($user_id, $override);

    trigger_notify(
            'register_user',
            array(
                'id' => $user_id,
                'username' => $cas_user['user'],
                'email' => $cas_user['attributes']['mail'],
            )
    );

    return $user_id;
}

function casu_get_casu_groups($attributes) {
    $casu_groups = array();
    $confcasu = conf_get_param('casu', array());
    foreach ($confcasu['casu_groups'] as $group_attr => $regexp) {
        if (is_array($attributes[$group_attr])) {
            foreach ($attributes[$group_attr] as $group) {
                if (empty($regexp)) {
                    $casu_groups[] = $group;
                } elseif (preg_match($regexp, $group, $groupm)) {
                    $casu_groups[] = $groupm[1];
                }
            }
        } else {
            if (empty($regexp)) {
                $casu_groups[] = $attributes[$group_attr];
            } elseif (preg_match($regexp, $attributes[$group_attr], $groupm)) {
                $casu_groups[] = $groupm[1];
            }
        }
    }
    return($casu_groups);
}

function casu_register_groups($user_id, $casu_groups) {

    //we want the list of all *casu_* groups the user is member of
    $query = 'SELECT DISTINCT  gr.id '
            . 'FROM ' . USER_GROUP_TABLE . ' AS ug '
            . 'INNER JOIN ' . GROUPS_TABLE . ' AS gr '
            . 'ON ug.group_id = gr.id '
            . 'WHERE gr.name LIKE \'casu_%\' AND ug.user_id=\'' . $user_id . '\';';

    $result = pwg_query($query);

    $groups_old = array();
    if (pwg_db_num_rows($result) > 0) {
        while (list($id) = pwg_db_fetch_row($result)) {
            $groups_old[] = $id;
        }
    }

    //now we begin
    $groups_add = array();
    foreach ($casu_groups as $group) {
        $query = 'SELECT id,name FROM ' . GROUPS_TABLE
                . ' WHERE name LIKE \'casu_' . pwg_db_real_escape_string($group) . '\';';
        $result = pwg_query($query);
        if (pwg_db_num_rows($result) == 1) {
            list($id) = pwg_db_fetch_row($result);
            $groups_add[] = $id;
        } elseif (pwg_db_num_rows($result) == 0) {
            $query = 'INSERT INTO ' . GROUPS_TABLE .
                    ' (name) VALUES (\'casu_'
                    . pwg_db_real_escape_string($group) . '\');';
            pwg_query($query);

            $query = 'SELECT id FROM ' . GROUPS_TABLE .
                    ' WHERE name LIKE \'casu_' . pwg_db_real_escape_string($group) . '\';';
            $result = pwg_query($query);

            list($id) = pwg_db_fetch_row($result);
            $groups_add[] = $id;
        }
    }
    $groups_remove = array_diff($groups_old, $groups_add);
    $groups_reg = array_diff($groups_add, $groups_old);

    $inserts = array();
    foreach ($groups_reg as $group) {
        $inserts[] = array(
            'user_id' => $user_id,
            'group_id' => $group
        );
    }
    if (count($inserts) != 0) {
        mass_inserts(USER_GROUP_TABLE, array('user_id', 'group_id'), $inserts);
    }
    foreach ($groups_remove as $group) {
        $query = 'DELETE FROM ' . USER_GROUP_TABLE .
                ' WHERE user_id = \'' . $user_id . '\'' .
                ' AND group_id = \'' . $group . '\''
        ;
        pwg_query($query);
    }
}
