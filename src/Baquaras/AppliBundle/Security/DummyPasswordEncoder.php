<?php

namespace Baquaras\AppliBundle\Security;

use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

/**
 * WARNING!
 * This passwordEncoder is for dev's only! It allow anyone to log any account without password!
 *
 * This is only available in the "dev" env, and used in the "security_no_sso.yml" security file.
 */
class DummyPasswordEncoder implements PasswordEncoderInterface
{
  /**
   * Encodes the raw password.
   *
   * @param string $raw  The password to encode
   * @param string $salt The salt
   *
   * @return string The encoded password
   */
  function encodePassword($raw, $salt)
  {
    return 'foo';
  }

  /**
   * Checks a raw password against an encoded password.
   *
   * @param string $encoded An encoded password
   * @param string $raw     A raw password
   * @param string $salt    The salt
   *
   * @return Boolean true if the password is valid, false otherwise
   */
  function isPasswordValid($encoded, $raw, $salt)
  {
    return true;
  }
}
