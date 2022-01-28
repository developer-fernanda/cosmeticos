<?php

/**
 * Utility class for validating CRC16 CCITT False
 *
 * @package Pix_For_WooCommerce/Classes/Gateway
 */
class WP_ICPFW_CRC16
{
    /**
     * Returns the ASCII value of the nth char in the given string
     *
     * @param string $texto The string
     * @param integer $ordem Char position
     * @return integer
     */
    public function byte($texto, $ordem)
    {
        return ord(substr($texto, $ordem, 1));
    }

    /**
     * Calculates CRC16 CCITT False with 0x1021 polynomial and 0xFFFF as initial value
     *
     * @see https://gist.github.com/tijnkooijmans/10981093
     *
     * @param string $texto The payload
     * @return string(4) The 4 bytes string containing the hex CRC16 representation
     */
    public function calculate($texto)
    {

        $response   = 0xFFFF;
        $polynomial = 0x1021;

        // Conforme seção 4.7.3 da especificação QR Code EMVCo-Merchant-Presented v.1.1
        if (($length = strlen($texto)) > 0) {
            for ($offset = 0; $offset < $length; $offset++) {
                $response ^= (ord($texto[$offset]) << 8);

                for ($bitwise = 0; $bitwise < 8; $bitwise++) {
                    if (($response <<= 1) & 0x10000) {
                        $response ^= $polynomial;
                    }

                    $response &= 0xFFFF;
                }
            }
        }
        return strtoupper( dechex( $response ) );
    }
}
