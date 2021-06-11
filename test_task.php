<?php

$arr_json = '{
 "roles": [
   {
     "id": 1,
     "roleName": "Admin"
   },
   {
     "id": 2,
     "roleName": "User"
   }
 ],
 "permissions": [
   {
     "id": 1,
     "value": "Read Only"
   },
   {
     "id": 2,
     "value": "Create Only"
   },
   {
     "id": 3,
     "value": "Full Access"
   }
 ],
 "users": [
   {
     "id": 1,
     "name": "User1",
     "role": 1,
     "permissions": 3
   },
   {
     "id": 2,
     "name": "User2",
     "role": 1,
     "permissions": 3
   },
   {
     "id": 3,
     "name": "User3",
     "role": 2,
     "permissions": 1
   },
   {
     "id": 4,
     "name": "User4",
     "role": 2,
     "permissions": 2
   },
   {
     "id": 5,
     "name": "User5",
     "role": 2,
     "permissions": 1
   }
 ],
 "contacts": [
   {
     "user": 1,
     "firstName": "John",
     "lastName": "Dou"
   },
   {
     "user": 1,
     "firstName": "John",
     "lastName": "Smith"
   },
   {
     "user": 3,
     "firstName": "Mark",
     "lastName": "Twen"
   },
   {
     "user": 4,
     "firstName": "Niko",
     "lastName": "Belec"
   },
   {
     "user": 4,
     "firstName": "Jim",
     "lastName": "Smith"
   },
   {
     "user": 4,
     "firstName": "Jack",
     "lastName": "Daniels"
   }
 ]
}';

$arr_decoded = json_decode($arr_json, true);
$res_string = '';

foreach ($arr_decoded['contacts'] as $item) {
    list($name, $role, $permission) = getUserInfo($arr_decoded,$item['user']);
    $res_string .= $name . ' ' . $role . ' ' . $item['firstName'] . ' ' . $item['lastName'] . ' - ' . $permission . "\n";
}

echo $res_string;

// returns user name, role description and permission description
function getUserInfo($arr_decoded, $user_id) {

    foreach ($arr_decoded['users'] as $user) {
        if ($user['id'] == $user_id) {
            $name = $user['name'];
            $role = getUserRoleDesc($arr_decoded, $user['role']);
            $permission = getUserPermissionDesc($arr_decoded, $user['permissions']);
        }
    }

    return [$name, $role, $permission];
}

// returns user role description
function getUserRoleDesc($arr_decoded, $role_id) {

    foreach($arr_decoded['roles'] as $role) {
        if ($role['id'] == $role_id) {
            return $role['roleName'];
        }
    }
}

// returns user permission description
function getUserPermissionDesc($arr_decoded, $permission_id) {
    foreach ($arr_decoded['permissions'] as $permission) {
        if ($permission['id'] == $permission_id) {
            return $permission['value'];
        }
    }
}

?>