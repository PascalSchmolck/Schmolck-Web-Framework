
/**
 * Schmolck_Framework_Mail_Link
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */

function Schmolck_Framework_Mail_Link(name, domain) {
    location.href = 'mailto:' + name + '@' + domain;
}