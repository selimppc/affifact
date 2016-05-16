<?php
/**
 * Created by PhpStorm.
 * User: selimets
 * Date: 11/1/15
 * Time: 12:47 PM
 */
// Example adldap.php file.
return [
    'account_suffix' => "@etsb.com",

    'domain_controllers' => array("192.168.0.106"), // An array of domains may be provided for load balancing.

    'base_dn' => 'DC=domain,DC=local',
    'admin_username' => 'postmaster@etsb.com',
    'admin_password' => 'root',
    'real_primary_group' => true, // Returns the primary group (an educated guess).
    'use_ssl' => true, // If TLS is true this MUST be false.
    'use_tls' => false, // If SSL is true this MUST be false.
    'recursive_groups' => true,
];