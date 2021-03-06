--TEST--
ldap_mod_del() - ldap_mod_del() operations that should fail
--CREDITS--
Patrick Allaert <patrickallaert@php.net>
# Belgian PHP Testfest 2009
--SKIPIF--
<?php require_once('skipif.inc'); ?>
<?php require_once('skipifbindfailure.inc'); ?>
--FILE--
<?php
require "connect.inc";

$link = ldap_connect_and_bind($host, $port, $user, $passwd, $protocol_version);

// Too few parameters
var_dump(ldap_mod_del());
var_dump(ldap_mod_del($link));
var_dump(ldap_mod_del($link, "dc=my-domain,dc=com"));

// Too many parameters
var_dump(ldap_mod_del($link, "dc=my-domain,dc=com", array(), "Additional data"));

// DN not found
var_dump(ldap_mod_del($link, "dc=my-domain,dc=com", array()));

// Invalid DN
var_dump(ldap_mod_del($link, "weirdAttribute=val", array()));

// Invalid attributes
var_dump(ldap_mod_del($link, "dc=my-domain,dc=com", array('dc')));
?>
===DONE===
--CLEAN--
<?php
require "connect.inc";

$link = ldap_connect_and_bind($host, $port, $user, $passwd, $protocol_version);

ldap_delete($link, "dc=my-domain,dc=com");
?>
--EXPECTF--
Warning: Wrong parameter count for ldap_mod_del() in %s on line %d
NULL

Warning: Wrong parameter count for ldap_mod_del() in %s on line %d
NULL

Warning: Wrong parameter count for ldap_mod_del() in %s on line %d
NULL

Warning: Wrong parameter count for ldap_mod_del() in %s on line %d
NULL

Warning: ldap_mod_del(): Modify: No such object in %s on line %d
bool(false)

Warning: ldap_mod_del(): Modify: Invalid DN syntax in %s on line %d
bool(false)

Warning: ldap_mod_del(): Unknown attribute in the data in %s on line %d
bool(false)
===DONE===
