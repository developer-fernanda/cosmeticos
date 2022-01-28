<?php

namespace FluentForm\App\Services\FluentConversational\Classes;

class Fonts
{
    public static function getFonts()
    {
        return [
            'system' => self::getSystemFonts(),
            'google' => self::getGoogleFonts()
        ];
    }

    public static function getAllFonts()
    {
        return array_merge(self::getSystemFonts(), self::getGoogleFonts());
    }

    public static function getSystemFonts()
    {
        return [
            'system-ui' => array(
                'fallback' => '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen,Ubuntu,Cantarell,"Fira Sans","Droid Sans","Helvetica Neue",sans-serif',
                'weights'  => array(
                    '300',
                    '400',
                    '700',
                ),
            ),
            'Helvetica' => array(
                'fallback' => 'Verdana, Arial, sans-serif',
                'weights'  => array(
                    '300',
                    '400',
                    '700',
                ),
            ),
            'Verdana'   => array(
                'fallback' => 'Helvetica, Arial, sans-serif',
                'weights'  => array(
                    '300',
                    '400',
                    '700',
                ),
            ),
            'Arial'     => array(
                'fallback' => 'Helvetica, Verdana, sans-serif',
                'weights'  => array('300', '400', '700',),
            ),
            'Times'     => array(
                'fallback' => 'Georgia, serif',
                'weights'  => array(
                    '300',
                    '400',
                    '700',
                ),
            ),
            'Georgia'   => array(
                'fallback' => 'Times, serif',
                'weights'  => array(
                    '300',
                    '400',
                    '700',
                ),
            ),
            'Courier'   => array(
                'fallback' => 'monospace',
                'weights'  => array(
                    '300',
                    '400',
                    '700',
                ),
            ),
        ];
    }

    public static function getGoogleFonts()
    {
        return array(
            'ABeeZee'                        => array(
                'variants' => array('regular', 'italic'),
                'category' => 'sans-serif',
            ),
            'Abel'                           => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Abhaya Libre'                   => array(
                'variants' => array('regular', '500', '600', '700', '800'),
                'category' => 'serif',
            ),
            'Abril Fatface'                  => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Aclonica'                       => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Acme'                           => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Actor'                          => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Adamina'                        => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Advent Pro'                     => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700'),
                'category' => 'sans-serif',
            ),
            'Aguafina Script'                => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Akaya Kanadaka'                 => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Akaya Telivigala'               => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Akronim'                        => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Aladin'                         => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Alata'                          => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Alatsi'                         => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Aldrich'                        => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Alef'                           => array(
                'variants' => array('regular', '700'),
                'category' => 'sans-serif',
            ),
            'Alegreya'                       => array(
                'variants' => array('regular', '500', '600', '700', '800', '900', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
                'category' => 'serif',
            ),
            'Alegreya SC'                    => array(
                'variants' => array('regular', 'italic', '500', '500italic', '700', '700italic', '800', '800italic', '900', '900italic'),
                'category' => 'serif',
            ),
            'Alegreya Sans'                  => array(
                'variants' => array('100', '100italic', '300', '300italic', 'regular', 'italic', '500', '500italic', '700', '700italic', '800', '800italic', '900', '900italic'),
                'category' => 'sans-serif',
            ),
            'Alegreya Sans SC'               => array(
                'variants' => array('100', '100italic', '300', '300italic', 'regular', 'italic', '500', '500italic', '700', '700italic', '800', '800italic', '900', '900italic'),
                'category' => 'sans-serif',
            ),
            'Aleo'                           => array(
                'variants' => array('300', '300italic', 'regular', 'italic', '700', '700italic'),
                'category' => 'serif',
            ),
            'Alex Brush'                     => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Alfa Slab One'                  => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Alice'                          => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Alike'                          => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Alike Angular'                  => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Allan'                          => array(
                'variants' => array('regular', '700'),
                'category' => 'display',
            ),
            'Allerta'                        => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Allerta Stencil'                => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Allura'                         => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Almarai'                        => array(
                'variants' => array('300', 'regular', '700', '800'),
                'category' => 'sans-serif',
            ),
            'Almendra'                       => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'serif',
            ),
            'Almendra Display'               => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Almendra SC'                    => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Amarante'                       => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Amaranth'                       => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'sans-serif',
            ),
            'Amatic SC'                      => array(
                'variants' => array('regular', '700'),
                'category' => 'handwriting',
            ),
            'Amethysta'                      => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Amiko'                          => array(
                'variants' => array('regular', '600', '700'),
                'category' => 'sans-serif',
            ),
            'Amiri'                          => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'serif',
            ),
            'Amita'                          => array(
                'variants' => array('regular', '700'),
                'category' => 'handwriting',
            ),
            'Anaheim'                        => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Andada'                         => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Andika'                         => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Andika New Basic'               => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'sans-serif',
            ),
            'Angkor'                         => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Annie Use Your Telescope'       => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Anonymous Pro'                  => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'monospace',
            ),
            'Antic'                          => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Antic Didone'                   => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Antic Slab'                     => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Anton'                          => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Antonio'                        => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700'),
                'category' => 'sans-serif',
            ),
            'Arapey'                         => array(
                'variants' => array('regular', 'italic'),
                'category' => 'serif',
            ),
            'Arbutus'                        => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Arbutus Slab'                   => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Architects Daughter'            => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Archivo'                        => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
                'category' => 'sans-serif',
            ),
            'Archivo Black'                  => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Archivo Narrow'                 => array(
                'variants' => array('regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
                'category' => 'sans-serif',
            ),
            'Aref Ruqaa'                     => array(
                'variants' => array('regular', '700'),
                'category' => 'serif',
            ),
            'Arima Madurai'                  => array(
                'variants' => array('100', '200', '300', 'regular', '500', '700', '800', '900'),
                'category' => 'display',
            ),
            'Arimo'                          => array(
                'variants' => array('regular', '500', '600', '700', 'italic', '500italic', '600italic', '700italic'),
                'category' => 'sans-serif',
            ),
            'Arizonia'                       => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Armata'                         => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Arsenal'                        => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'sans-serif',
            ),
            'Artifika'                       => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Arvo'                           => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'serif',
            ),
            'Arya'                           => array(
                'variants' => array('regular', '700'),
                'category' => 'sans-serif',
            ),
            'Asap'                           => array(
                'variants' => array('regular', '500', '600', '700', 'italic', '500italic', '600italic', '700italic'),
                'category' => 'sans-serif',
            ),
            'Asap Condensed'                 => array(
                'variants' => array('regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
                'category' => 'sans-serif',
            ),
            'Asar'                           => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Asset'                          => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Assistant'                      => array(
                'variants' => array('200', '300', 'regular', '500', '600', '700', '800'),
                'category' => 'sans-serif',
            ),
            'Astloch'                        => array(
                'variants' => array('regular', '700'),
                'category' => 'display',
            ),
            'Asul'                           => array(
                'variants' => array('regular', '700'),
                'category' => 'sans-serif',
            ),
            'Athiti'                         => array(
                'variants' => array('200', '300', 'regular', '500', '600', '700'),
                'category' => 'sans-serif',
            ),
            'Atma'                           => array(
                'variants' => array('300', 'regular', '500', '600', '700'),
                'category' => 'display',
            ),
            'Atomic Age'                     => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Aubrey'                         => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Audiowide'                      => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Autour One'                     => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Average'                        => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Average Sans'                   => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Averia Gruesa Libre'            => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Averia Libre'                   => array(
                'variants' => array('300', '300italic', 'regular', 'italic', '700', '700italic'),
                'category' => 'display',
            ),
            'Averia Sans Libre'              => array(
                'variants' => array('300', '300italic', 'regular', 'italic', '700', '700italic'),
                'category' => 'display',
            ),
            'Averia Serif Libre'             => array(
                'variants' => array('300', '300italic', 'regular', 'italic', '700', '700italic'),
                'category' => 'display',
            ),
            'B612'                           => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'sans-serif',
            ),
            'B612 Mono'                      => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'monospace',
            ),
            'Bad Script'                     => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Bahiana'                        => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Bahianita'                      => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Bai Jamjuree'                   => array(
                'variants' => array('200', '200italic', '300', '300italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
                'category' => 'sans-serif',
            ),
            'Ballet'                         => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Baloo 2'                        => array(
                'variants' => array('regular', '500', '600', '700', '800'),
                'category' => 'display',
            ),
            'Baloo Bhai 2'                   => array(
                'variants' => array('regular', '500', '600', '700', '800'),
                'category' => 'display',
            ),
            'Baloo Bhaina 2'                 => array(
                'variants' => array('regular', '500', '600', '700', '800'),
                'category' => 'display',
            ),
            'Baloo Chettan 2'                => array(
                'variants' => array('regular', '500', '600', '700', '800'),
                'category' => 'display',
            ),
            'Baloo Da 2'                     => array(
                'variants' => array('regular', '500', '600', '700', '800'),
                'category' => 'display',
            ),
            'Baloo Paaji 2'                  => array(
                'variants' => array('regular', '500', '600', '700', '800'),
                'category' => 'display',
            ),
            'Baloo Tamma 2'                  => array(
                'variants' => array('regular', '500', '600', '700', '800'),
                'category' => 'display',
            ),
            'Baloo Tammudu 2'                => array(
                'variants' => array('regular', '500', '600', '700', '800'),
                'category' => 'display',
            ),
            'Baloo Thambi 2'                 => array(
                'variants' => array('regular', '500', '600', '700', '800'),
                'category' => 'display',
            ),
            'Balsamiq Sans'                  => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'display',
            ),
            'Balthazar'                      => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Bangers'                        => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Barlow'                         => array(
                'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
                'category' => 'sans-serif',
            ),
            'Barlow Condensed'               => array(
                'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
                'category' => 'sans-serif',
            ),
            'Barlow Semi Condensed'          => array(
                'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
                'category' => 'sans-serif',
            ),
            'Barriecito'                     => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Barrio'                         => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Basic'                          => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Baskervville'                   => array(
                'variants' => array('regular', 'italic'),
                'category' => 'serif',
            ),
            'Battambang'                     => array(
                'variants' => array('regular', '700'),
                'category' => 'display',
            ),
            'Baumans'                        => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Bayon'                          => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Be Vietnam'                     => array(
                'variants' => array('100', '100italic', '300', '300italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic'),
                'category' => 'sans-serif',
            ),
            'Bebas Neue'                     => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Belgrano'                       => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Bellefair'                      => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Belleza'                        => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Bellota'                        => array(
                'variants' => array('300', '300italic', 'regular', 'italic', '700', '700italic'),
                'category' => 'display',
            ),
            'Bellota Text'                   => array(
                'variants' => array('300', '300italic', 'regular', 'italic', '700', '700italic'),
                'category' => 'display',
            ),
            'BenchNine'                      => array(
                'variants' => array('300', 'regular', '700'),
                'category' => 'sans-serif',
            ),
            'Benne'                          => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Bentham'                        => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Berkshire Swash'                => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Beth Ellen'                     => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Bevan'                          => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Big Shoulders Display'          => array(
                'variants' => array('100', '300', 'regular', '500', '600', '700', '800', '900'),
                'category' => 'display',
            ),
            'Big Shoulders Inline Display'   => array(
                'variants' => array('100', '300', 'regular', '500', '600', '700', '800', '900'),
                'category' => 'display',
            ),
            'Big Shoulders Inline Text'      => array(
                'variants' => array('100', '300', 'regular', '500', '600', '700', '800', '900'),
                'category' => 'display',
            ),
            'Big Shoulders Stencil Display'  => array(
                'variants' => array('100', '300', 'regular', '500', '600', '700', '800', '900'),
                'category' => 'display',
            ),
            'Big Shoulders Stencil Text'     => array(
                'variants' => array('100', '300', 'regular', '500', '600', '700', '800', '900'),
                'category' => 'display',
            ),
            'Big Shoulders Text'             => array(
                'variants' => array('100', '300', 'regular', '500', '600', '700', '800', '900'),
                'category' => 'display',
            ),
            'Bigelow Rules'                  => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Bigshot One'                    => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Bilbo'                          => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Bilbo Swash Caps'               => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'BioRhyme'                       => array(
                'variants' => array('200', '300', 'regular', '700', '800'),
                'category' => 'serif',
            ),
            'BioRhyme Expanded'              => array(
                'variants' => array('200', '300', 'regular', '700', '800'),
                'category' => 'serif',
            ),
            'Biryani'                        => array(
                'variants' => array('200', '300', 'regular', '600', '700', '800', '900'),
                'category' => 'sans-serif',
            ),
            'Bitter'                         => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
                'category' => 'serif',
            ),
            'Black And White Picture'        => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Black Han Sans'                 => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Black Ops One'                  => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Blinker'                        => array(
                'variants' => array('100', '200', '300', 'regular', '600', '700', '800', '900'),
                'category' => 'sans-serif',
            ),
            'Bodoni Moda'                    => array(
                'variants' => array('regular', '500', '600', '700', '800', '900', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
                'category' => 'serif',
            ),
            'Bokor'                          => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Bonbon'                         => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Boogaloo'                       => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Bowlby One'                     => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Bowlby One SC'                  => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Brawler'                        => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Bree Serif'                     => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Brygada 1918'                   => array(
                'variants' => array('regular', '500', '600', '700', 'italic', '500italic', '600italic', '700italic'),
                'category' => 'serif',
            ),
            'Bubblegum Sans'                 => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Bubbler One'                    => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Buda'                           => array(
                'variants' => array('300'),
                'category' => 'display',
            ),
            'Buenard'                        => array(
                'variants' => array('regular', '700'),
                'category' => 'serif',
            ),
            'Bungee'                         => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Bungee Hairline'                => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Bungee Inline'                  => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Bungee Outline'                 => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Bungee Shade'                   => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Butcherman'                     => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Butterfly Kids'                 => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Cabin'                          => array(
                'variants' => array('regular', '500', '600', '700', 'italic', '500italic', '600italic', '700italic'),
                'category' => 'sans-serif',
            ),
            'Cabin Condensed'                => array(
                'variants' => array('regular', '500', '600', '700'),
                'category' => 'sans-serif',
            ),
            'Cabin Sketch'                   => array(
                'variants' => array('regular', '700'),
                'category' => 'display',
            ),
            'Caesar Dressing'                => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Cagliostro'                     => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Cairo'                          => array(
                'variants' => array('200', '300', 'regular', '600', '700', '900'),
                'category' => 'sans-serif',
            ),
            'Caladea'                        => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'serif',
            ),
            'Calistoga'                      => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Calligraffitti'                 => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Cambay'                         => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'sans-serif',
            ),
            'Cambo'                          => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Candal'                         => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Cantarell'                      => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'sans-serif',
            ),
            'Cantata One'                    => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Cantora One'                    => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Capriola'                       => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Cardo'                          => array(
                'variants' => array('regular', 'italic', '700'),
                'category' => 'serif',
            ),
            'Carme'                          => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Carrois Gothic'                 => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Carrois Gothic SC'              => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Carter One'                     => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Castoro'                        => array(
                'variants' => array('regular', 'italic'),
                'category' => 'serif',
            ),
            'Catamaran'                      => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800', '900'),
                'category' => 'sans-serif',
            ),
            'Caudex'                         => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'serif',
            ),
            'Caveat'                         => array(
                'variants' => array('regular', '500', '600', '700'),
                'category' => 'handwriting',
            ),
            'Caveat Brush'                   => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Cedarville Cursive'             => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Ceviche One'                    => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Chakra Petch'                   => array(
                'variants' => array('300', '300italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
                'category' => 'sans-serif',
            ),
            'Changa'                         => array(
                'variants' => array('200', '300', 'regular', '500', '600', '700', '800'),
                'category' => 'sans-serif',
            ),
            'Changa One'                     => array(
                'variants' => array('regular', 'italic'),
                'category' => 'display',
            ),
            'Chango'                         => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Charm'                          => array(
                'variants' => array('regular', '700'),
                'category' => 'handwriting',
            ),
            'Charmonman'                     => array(
                'variants' => array('regular', '700'),
                'category' => 'handwriting',
            ),
            'Chathura'                       => array(
                'variants' => array('100', '300', 'regular', '700', '800'),
                'category' => 'sans-serif',
            ),
            'Chau Philomene One'             => array(
                'variants' => array('regular', 'italic'),
                'category' => 'sans-serif',
            ),
            'Chela One'                      => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Chelsea Market'                 => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Chenla'                         => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Cherry Cream Soda'              => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Cherry Swash'                   => array(
                'variants' => array('regular', '700'),
                'category' => 'display',
            ),
            'Chewy'                          => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Chicle'                         => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Chilanka'                       => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Chivo'                          => array(
                'variants' => array('300', '300italic', 'regular', 'italic', '700', '700italic', '900', '900italic'),
                'category' => 'sans-serif',
            ),
            'Chonburi'                       => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Cinzel'                         => array(
                'variants' => array('regular', '500', '600', '700', '800', '900'),
                'category' => 'serif',
            ),
            'Cinzel Decorative'              => array(
                'variants' => array('regular', '700', '900'),
                'category' => 'display',
            ),
            'Clicker Script'                 => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Coda'                           => array(
                'variants' => array('regular', '800'),
                'category' => 'display',
            ),
            'Coda Caption'                   => array(
                'variants' => array('800'),
                'category' => 'sans-serif',
            ),
            'Codystar'                       => array(
                'variants' => array('300', 'regular'),
                'category' => 'display',
            ),
            'Coiny'                          => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Combo'                          => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Comfortaa'                      => array(
                'variants' => array('300', 'regular', '500', '600', '700'),
                'category' => 'display',
            ),
            'Comic Neue'                     => array(
                'variants' => array('300', '300italic', 'regular', 'italic', '700', '700italic'),
                'category' => 'handwriting',
            ),
            'Coming Soon'                    => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Commissioner'                   => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800', '900'),
                'category' => 'sans-serif',
            ),
            'Concert One'                    => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Condiment'                      => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Content'                        => array(
                'variants' => array('regular', '700'),
                'category' => 'display',
            ),
            'Contrail One'                   => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Convergence'                    => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Cookie'                         => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Copse'                          => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Corben'                         => array(
                'variants' => array('regular', '700'),
                'category' => 'display',
            ),
            'Cormorant'                      => array(
                'variants' => array('300', '300italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
                'category' => 'serif',
            ),
            'Cormorant Garamond'             => array(
                'variants' => array('300', '300italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
                'category' => 'serif',
            ),
            'Cormorant Infant'               => array(
                'variants' => array('300', '300italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
                'category' => 'serif',
            ),
            'Cormorant SC'                   => array(
                'variants' => array('300', 'regular', '500', '600', '700'),
                'category' => 'serif',
            ),
            'Cormorant Unicase'              => array(
                'variants' => array('300', 'regular', '500', '600', '700'),
                'category' => 'serif',
            ),
            'Cormorant Upright'              => array(
                'variants' => array('300', 'regular', '500', '600', '700'),
                'category' => 'serif',
            ),
            'Courgette'                      => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Courier Prime'                  => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'monospace',
            ),
            'Cousine'                        => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'monospace',
            ),
            'Coustard'                       => array(
                'variants' => array('regular', '900'),
                'category' => 'serif',
            ),
            'Covered By Your Grace'          => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Crafty Girls'                   => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Creepster'                      => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Crete Round'                    => array(
                'variants' => array('regular', 'italic'),
                'category' => 'serif',
            ),
            'Crimson Pro'                    => array(
                'variants' => array('200', '300', 'regular', '500', '600', '700', '800', '900', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
                'category' => 'serif',
            ),
            'Crimson Text'                   => array(
                'variants' => array('regular', 'italic', '600', '600italic', '700', '700italic'),
                'category' => 'serif',
            ),
            'Croissant One'                  => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Crushed'                        => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Cuprum'                         => array(
                'variants' => array('regular', '500', '600', '700', 'italic', '500italic', '600italic', '700italic'),
                'category' => 'sans-serif',
            ),
            'Cute Font'                      => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Cutive'                         => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Cutive Mono'                    => array(
                'variants' => array('regular'),
                'category' => 'monospace',
            ),
            'DM Mono'                        => array(
                'variants' => array('300', '300italic', 'regular', 'italic', '500', '500italic'),
                'category' => 'monospace',
            ),
            'DM Sans'                        => array(
                'variants' => array('regular', 'italic', '500', '500italic', '700', '700italic'),
                'category' => 'sans-serif',
            ),
            'DM Serif Display'               => array(
                'variants' => array('regular', 'italic'),
                'category' => 'serif',
            ),
            'DM Serif Text'                  => array(
                'variants' => array('regular', 'italic'),
                'category' => 'serif',
            ),
            'Damion'                         => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Dancing Script'                 => array(
                'variants' => array('regular', '500', '600', '700'),
                'category' => 'handwriting',
            ),
            'Dangrek'                        => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Darker Grotesque'               => array(
                'variants' => array('300', 'regular', '500', '600', '700', '800', '900'),
                'category' => 'sans-serif',
            ),
            'David Libre'                    => array(
                'variants' => array('regular', '500', '700'),
                'category' => 'serif',
            ),
            'Dawning of a New Day'           => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Days One'                       => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Dekko'                          => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Dela Gothic One'                => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Delius'                         => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Delius Swash Caps'              => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Delius Unicase'                 => array(
                'variants' => array('regular', '700'),
                'category' => 'handwriting',
            ),
            'Della Respira'                  => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Denk One'                       => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Devonshire'                     => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Dhurjati'                       => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Didact Gothic'                  => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Diplomata'                      => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Diplomata SC'                   => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Do Hyeon'                       => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Dokdo'                          => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Domine'                         => array(
                'variants' => array('regular', '500', '600', '700'),
                'category' => 'serif',
            ),
            'Donegal One'                    => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Doppio One'                     => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Dorsa'                          => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Dosis'                          => array(
                'variants' => array('200', '300', 'regular', '500', '600', '700', '800'),
                'category' => 'sans-serif',
            ),
            'DotGothic16'                    => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Dr Sugiyama'                    => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Duru Sans'                      => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Dynalight'                      => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'EB Garamond'                    => array(
                'variants' => array('regular', '500', '600', '700', '800', 'italic', '500italic', '600italic', '700italic', '800italic'),
                'category' => 'serif',
            ),
            'Eagle Lake'                     => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'East Sea Dokdo'                 => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Eater'                          => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Economica'                      => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'sans-serif',
            ),
            'Eczar'                          => array(
                'variants' => array('regular', '500', '600', '700', '800'),
                'category' => 'serif',
            ),
            'El Messiri'                     => array(
                'variants' => array('regular', '500', '600', '700'),
                'category' => 'sans-serif',
            ),
            'Electrolize'                    => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Elsie'                          => array(
                'variants' => array('regular', '900'),
                'category' => 'display',
            ),
            'Elsie Swash Caps'               => array(
                'variants' => array('regular', '900'),
                'category' => 'display',
            ),
            'Emblema One'                    => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Emilys Candy'                   => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Encode Sans'                    => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800', '900'),
                'category' => 'sans-serif',
            ),
            'Encode Sans Condensed'          => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800', '900'),
                'category' => 'sans-serif',
            ),
            'Encode Sans Expanded'           => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800', '900'),
                'category' => 'sans-serif',
            ),
            'Encode Sans Semi Condensed'     => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800', '900'),
                'category' => 'sans-serif',
            ),
            'Encode Sans Semi Expanded'      => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800', '900'),
                'category' => 'sans-serif',
            ),
            'Engagement'                     => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Englebert'                      => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Enriqueta'                      => array(
                'variants' => array('regular', '500', '600', '700'),
                'category' => 'serif',
            ),
            'Epilogue'                       => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
                'category' => 'sans-serif',
            ),
            'Erica One'                      => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Esteban'                        => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Euphoria Script'                => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Ewert'                          => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Exo'                            => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
                'category' => 'sans-serif',
            ),
            'Exo 2'                          => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
                'category' => 'sans-serif',
            ),
            'Expletus Sans'                  => array(
                'variants' => array('regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
                'category' => 'display',
            ),
            'Fahkwang'                       => array(
                'variants' => array('200', '200italic', '300', '300italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
                'category' => 'sans-serif',
            ),
            'Fanwood Text'                   => array(
                'variants' => array('regular', 'italic'),
                'category' => 'serif',
            ),
            'Farro'                          => array(
                'variants' => array('300', 'regular', '500', '700'),
                'category' => 'sans-serif',
            ),
            'Farsan'                         => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Fascinate'                      => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Fascinate Inline'               => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Faster One'                     => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Fasthand'                       => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Fauna One'                      => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Faustina'                       => array(
                'variants' => array('regular', '500', '600', '700', 'italic', '500italic', '600italic', '700italic'),
                'category' => 'serif',
            ),
            'Federant'                       => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Federo'                         => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Felipa'                         => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Fenix'                          => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Finger Paint'                   => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Fira Code'                      => array(
                'variants' => array('300', 'regular', '500', '600', '700'),
                'category' => 'monospace',
            ),
            'Fira Mono'                      => array(
                'variants' => array('regular', '500', '700'),
                'category' => 'monospace',
            ),
            'Fira Sans'                      => array(
                'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
                'category' => 'sans-serif',
            ),
            'Fira Sans Condensed'            => array(
                'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
                'category' => 'sans-serif',
            ),
            'Fira Sans Extra Condensed'      => array(
                'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
                'category' => 'sans-serif',
            ),
            'Fjalla One'                     => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Fjord One'                      => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Flamenco'                       => array(
                'variants' => array('300', 'regular'),
                'category' => 'display',
            ),
            'Flavors'                        => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Fondamento'                     => array(
                'variants' => array('regular', 'italic'),
                'category' => 'handwriting',
            ),
            'Fontdiner Swanky'               => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Forum'                          => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Francois One'                   => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Frank Ruhl Libre'               => array(
                'variants' => array('300', 'regular', '500', '700', '900'),
                'category' => 'serif',
            ),
            'Fraunces'                       => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
                'category' => 'serif',
            ),
            'Freckle Face'                   => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Fredericka the Great'           => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Fredoka One'                    => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Freehand'                       => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Fresca'                         => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Frijole'                        => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Fruktur'                        => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Fugaz One'                      => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'GFS Didot'                      => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'GFS Neohellenic'                => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'sans-serif',
            ),
            'Gabriela'                       => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Gaegu'                          => array(
                'variants' => array('300', 'regular', '700'),
                'category' => 'handwriting',
            ),
            'Gafata'                         => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Galada'                         => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Galdeano'                       => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Galindo'                        => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Gamja Flower'                   => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Gayathri'                       => array(
                'variants' => array('100', 'regular', '700'),
                'category' => 'sans-serif',
            ),
            'Gelasio'                        => array(
                'variants' => array('regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
                'category' => 'serif',
            ),
            'Gentium Basic'                  => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'serif',
            ),
            'Gentium Book Basic'             => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'serif',
            ),
            'Geo'                            => array(
                'variants' => array('regular', 'italic'),
                'category' => 'sans-serif',
            ),
            'Geostar'                        => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Geostar Fill'                   => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Germania One'                   => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Gidugu'                         => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Gilda Display'                  => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Girassol'                       => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Give You Glory'                 => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Glass Antiqua'                  => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Glegoo'                         => array(
                'variants' => array('regular', '700'),
                'category' => 'serif',
            ),
            'Gloria Hallelujah'              => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Goblin One'                     => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Gochi Hand'                     => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Goldman'                        => array(
                'variants' => array('regular', '700'),
                'category' => 'display',
            ),
            'Gorditas'                       => array(
                'variants' => array('regular', '700'),
                'category' => 'display',
            ),
            'Gothic A1'                      => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800', '900'),
                'category' => 'sans-serif',
            ),
            'Gotu'                           => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Goudy Bookletter 1911'          => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Graduate'                       => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Grand Hotel'                    => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Grandstander'                   => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
                'category' => 'display',
            ),
            'Gravitas One'                   => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Great Vibes'                    => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Grenze'                         => array(
                'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
                'category' => 'serif',
            ),
            'Grenze Gotisch'                 => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800', '900'),
                'category' => 'display',
            ),
            'Griffy'                         => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Gruppo'                         => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Gudea'                          => array(
                'variants' => array('regular', 'italic', '700'),
                'category' => 'sans-serif',
            ),
            'Gugi'                           => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Gupter'                         => array(
                'variants' => array('regular', '500', '700'),
                'category' => 'serif',
            ),
            'Gurajada'                       => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Habibi'                         => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Hachi Maru Pop'                 => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Halant'                         => array(
                'variants' => array('300', 'regular', '500', '600', '700'),
                'category' => 'serif',
            ),
            'Hammersmith One'                => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Hanalei'                        => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Hanalei Fill'                   => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Handlee'                        => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Hanuman'                        => array(
                'variants' => array('regular', '700'),
                'category' => 'serif',
            ),
            'Happy Monkey'                   => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Harmattan'                      => array(
                'variants' => array('regular', '700'),
                'category' => 'sans-serif',
            ),
            'Headland One'                   => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Heebo'                          => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800', '900'),
                'category' => 'sans-serif',
            ),
            'Henny Penny'                    => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Hepta Slab'                     => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800', '900'),
                'category' => 'serif',
            ),
            'Herr Von Muellerhoff'           => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Hi Melody'                      => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Hind'                           => array(
                'variants' => array('300', 'regular', '500', '600', '700'),
                'category' => 'sans-serif',
            ),
            'Hind Guntur'                    => array(
                'variants' => array('300', 'regular', '500', '600', '700'),
                'category' => 'sans-serif',
            ),
            'Hind Madurai'                   => array(
                'variants' => array('300', 'regular', '500', '600', '700'),
                'category' => 'sans-serif',
            ),
            'Hind Siliguri'                  => array(
                'variants' => array('300', 'regular', '500', '600', '700'),
                'category' => 'sans-serif',
            ),
            'Hind Vadodara'                  => array(
                'variants' => array('300', 'regular', '500', '600', '700'),
                'category' => 'sans-serif',
            ),
            'Holtwood One SC'                => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Homemade Apple'                 => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Homenaje'                       => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'IBM Plex Mono'                  => array(
                'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
                'category' => 'monospace',
            ),
            'IBM Plex Sans'                  => array(
                'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
                'category' => 'sans-serif',
            ),
            'IBM Plex Sans Condensed'        => array(
                'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
                'category' => 'sans-serif',
            ),
            'IBM Plex Serif'                 => array(
                'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
                'category' => 'serif',
            ),
            'IM Fell DW Pica'                => array(
                'variants' => array('regular', 'italic'),
                'category' => 'serif',
            ),
            'IM Fell DW Pica SC'             => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'IM Fell Double Pica'            => array(
                'variants' => array('regular', 'italic'),
                'category' => 'serif',
            ),
            'IM Fell Double Pica SC'         => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'IM Fell English'                => array(
                'variants' => array('regular', 'italic'),
                'category' => 'serif',
            ),
            'IM Fell English SC'             => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'IM Fell French Canon'           => array(
                'variants' => array('regular', 'italic'),
                'category' => 'serif',
            ),
            'IM Fell French Canon SC'        => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'IM Fell Great Primer'           => array(
                'variants' => array('regular', 'italic'),
                'category' => 'serif',
            ),
            'IM Fell Great Primer SC'        => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Ibarra Real Nova'               => array(
                'variants' => array('regular', '500', '600', '700', 'italic', '500italic', '600italic', '700italic'),
                'category' => 'serif',
            ),
            'Iceberg'                        => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Iceland'                        => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Imbue'                          => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800', '900'),
                'category' => 'serif',
            ),
            'Imprima'                        => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Inconsolata'                    => array(
                'variants' => array('200', '300', 'regular', '500', '600', '700', '800', '900'),
                'category' => 'monospace',
            ),
            'Inder'                          => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Indie Flower'                   => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Inika'                          => array(
                'variants' => array('regular', '700'),
                'category' => 'serif',
            ),
            'Inknut Antiqua'                 => array(
                'variants' => array('300', 'regular', '500', '600', '700', '800', '900'),
                'category' => 'serif',
            ),
            'Inria Sans'                     => array(
                'variants' => array('300', '300italic', 'regular', 'italic', '700', '700italic'),
                'category' => 'sans-serif',
            ),
            'Inria Serif'                    => array(
                'variants' => array('300', '300italic', 'regular', 'italic', '700', '700italic'),
                'category' => 'serif',
            ),
            'Inter'                          => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800', '900'),
                'category' => 'sans-serif',
            ),
            'Irish Grover'                   => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Istok Web'                      => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'sans-serif',
            ),
            'Italiana'                       => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Italianno'                      => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Itim'                           => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Jacques Francois'               => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Jacques Francois Shadow'        => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Jaldi'                          => array(
                'variants' => array('regular', '700'),
                'category' => 'sans-serif',
            ),
            'JetBrains Mono'                 => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic'),
                'category' => 'monospace',
            ),
            'Jim Nightshade'                 => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Jockey One'                     => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Jolly Lodger'                   => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Jomhuria'                       => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Jomolhari'                      => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Josefin Sans'                   => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic'),
                'category' => 'sans-serif',
            ),
            'Josefin Slab'                   => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic'),
                'category' => 'serif',
            ),
            'Jost'                           => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
                'category' => 'sans-serif',
            ),
            'Joti One'                       => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Jua'                            => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Judson'                         => array(
                'variants' => array('regular', 'italic', '700'),
                'category' => 'serif',
            ),
            'Julee'                          => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Julius Sans One'                => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Junge'                          => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Jura'                           => array(
                'variants' => array('300', 'regular', '500', '600', '700'),
                'category' => 'sans-serif',
            ),
            'Just Another Hand'              => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Just Me Again Down Here'        => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'K2D'                            => array(
                'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic'),
                'category' => 'sans-serif',
            ),
            'Kadwa'                          => array(
                'variants' => array('regular', '700'),
                'category' => 'serif',
            ),
            'Kalam'                          => array(
                'variants' => array('300', 'regular', '700'),
                'category' => 'handwriting',
            ),
            'Kameron'                        => array(
                'variants' => array('regular', '700'),
                'category' => 'serif',
            ),
            'Kanit'                          => array(
                'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
                'category' => 'sans-serif',
            ),
            'Kantumruy'                      => array(
                'variants' => array('300', 'regular', '700'),
                'category' => 'sans-serif',
            ),
            'Karantina'                      => array(
                'variants' => array('300', 'regular', '700'),
                'category' => 'display',
            ),
            'Karla'                          => array(
                'variants' => array('200', '300', 'regular', '500', '600', '700', '800', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic'),
                'category' => 'sans-serif',
            ),
            'Karma'                          => array(
                'variants' => array('300', 'regular', '500', '600', '700'),
                'category' => 'serif',
            ),
            'Katibeh'                        => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Kaushan Script'                 => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Kavivanar'                      => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Kavoon'                         => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Kdam Thmor'                     => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Keania One'                     => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Kelly Slab'                     => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Kenia'                          => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Khand'                          => array(
                'variants' => array('300', 'regular', '500', '600', '700'),
                'category' => 'sans-serif',
            ),
            'Khmer'                          => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Khula'                          => array(
                'variants' => array('300', 'regular', '600', '700', '800'),
                'category' => 'sans-serif',
            ),
            'Kirang Haerang'                 => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Kite One'                       => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Kiwi Maru'                      => array(
                'variants' => array('300', 'regular', '500'),
                'category' => 'serif',
            ),
            'Knewave'                        => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'KoHo'                           => array(
                'variants' => array('200', '200italic', '300', '300italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
                'category' => 'sans-serif',
            ),
            'Kodchasan'                      => array(
                'variants' => array('200', '200italic', '300', '300italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
                'category' => 'sans-serif',
            ),
            'Kosugi'                         => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Kosugi Maru'                    => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Kotta One'                      => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Koulen'                         => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Kranky'                         => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Kreon'                          => array(
                'variants' => array('300', 'regular', '500', '600', '700'),
                'category' => 'serif',
            ),
            'Kristi'                         => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Krona One'                      => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Krub'                           => array(
                'variants' => array('200', '200italic', '300', '300italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
                'category' => 'sans-serif',
            ),
            'Kufam'                          => array(
                'variants' => array('regular', '500', '600', '700', '800', '900', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
                'category' => 'display',
            ),
            'Kulim Park'                     => array(
                'variants' => array('200', '200italic', '300', '300italic', 'regular', 'italic', '600', '600italic', '700', '700italic'),
                'category' => 'sans-serif',
            ),
            'Kumar One'                      => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Kumar One Outline'              => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Kumbh Sans'                     => array(
                'variants' => array('300', 'regular', '700'),
                'category' => 'sans-serif',
            ),
            'Kurale'                         => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'La Belle Aurore'                => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Lacquer'                        => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Laila'                          => array(
                'variants' => array('300', 'regular', '500', '600', '700'),
                'category' => 'sans-serif',
            ),
            'Lakki Reddy'                    => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Lalezar'                        => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Lancelot'                       => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Langar'                         => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Lateef'                         => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Lato'                           => array(
                'variants' => array('100', '100italic', '300', '300italic', 'regular', 'italic', '700', '700italic', '900', '900italic'),
                'category' => 'sans-serif',
            ),
            'League Script'                  => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Leckerli One'                   => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Ledger'                         => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Lekton'                         => array(
                'variants' => array('regular', 'italic', '700'),
                'category' => 'sans-serif',
            ),
            'Lemon'                          => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Lemonada'                       => array(
                'variants' => array('300', 'regular', '500', '600', '700'),
                'category' => 'display',
            ),
            'Lexend'                         => array(
                'variants' => array('100', '300', 'regular', '500', '600', '700', '800'),
                'category' => 'sans-serif',
            ),
            'Lexend Deca'                    => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Lexend Exa'                     => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Lexend Giga'                    => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Lexend Mega'                    => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Lexend Peta'                    => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Lexend Tera'                    => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Lexend Zetta'                   => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Libre Barcode 128'              => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Libre Barcode 128 Text'         => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Libre Barcode 39'               => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Libre Barcode 39 Extended'      => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Libre Barcode 39 Extended Text' => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Libre Barcode 39 Text'          => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Libre Barcode EAN13 Text'       => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Libre Baskerville'              => array(
                'variants' => array('regular', 'italic', '700'),
                'category' => 'serif',
            ),
            'Libre Caslon Display'           => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Libre Caslon Text'              => array(
                'variants' => array('regular', 'italic', '700'),
                'category' => 'serif',
            ),
            'Libre Franklin'                 => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
                'category' => 'sans-serif',
            ),
            'Life Savers'                    => array(
                'variants' => array('regular', '700', '800'),
                'category' => 'display',
            ),
            'Lilita One'                     => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Lily Script One'                => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Limelight'                      => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Linden Hill'                    => array(
                'variants' => array('regular', 'italic'),
                'category' => 'serif',
            ),
            'Literata'                       => array(
                'variants' => array('200', '300', 'regular', '500', '600', '700', '800', '900', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
                'category' => 'serif',
            ),
            'Liu Jian Mao Cao'               => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Livvic'                         => array(
                'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '900', '900italic'),
                'category' => 'sans-serif',
            ),
            'Lobster'                        => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Lobster Two'                    => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'display',
            ),
            'Londrina Outline'               => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Londrina Shadow'                => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Londrina Sketch'                => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Londrina Solid'                 => array(
                'variants' => array('100', '300', 'regular', '900'),
                'category' => 'display',
            ),
            'Long Cang'                      => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Lora'                           => array(
                'variants' => array('regular', '500', '600', '700', 'italic', '500italic', '600italic', '700italic'),
                'category' => 'serif',
            ),
            'Love Ya Like A Sister'          => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Loved by the King'              => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Lovers Quarrel'                 => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Luckiest Guy'                   => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Lusitana'                       => array(
                'variants' => array('regular', '700'),
                'category' => 'serif',
            ),
            'Lustria'                        => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'M PLUS 1p'                      => array(
                'variants' => array('100', '300', 'regular', '500', '700', '800', '900'),
                'category' => 'sans-serif',
            ),
            'M PLUS Rounded 1c'              => array(
                'variants' => array('100', '300', 'regular', '500', '700', '800', '900'),
                'category' => 'sans-serif',
            ),
            'Ma Shan Zheng'                  => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Macondo'                        => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Macondo Swash Caps'             => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Mada'                           => array(
                'variants' => array('200', '300', 'regular', '500', '600', '700', '900'),
                'category' => 'sans-serif',
            ),
            'Magra'                          => array(
                'variants' => array('regular', '700'),
                'category' => 'sans-serif',
            ),
            'Maiden Orange'                  => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Maitree'                        => array(
                'variants' => array('200', '300', 'regular', '500', '600', '700'),
                'category' => 'serif',
            ),
            'Major Mono Display'             => array(
                'variants' => array('regular'),
                'category' => 'monospace',
            ),
            'Mako'                           => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Mali'                           => array(
                'variants' => array('200', '200italic', '300', '300italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
                'category' => 'handwriting',
            ),
            'Mallanna'                       => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Mandali'                        => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Manjari'                        => array(
                'variants' => array('100', 'regular', '700'),
                'category' => 'sans-serif',
            ),
            'Manrope'                        => array(
                'variants' => array('200', '300', 'regular', '500', '600', '700', '800'),
                'category' => 'sans-serif',
            ),
            'Mansalva'                       => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Manuale'                        => array(
                'variants' => array('regular', '500', '600', '700', 'italic', '500italic', '600italic', '700italic'),
                'category' => 'serif',
            ),
            'Marcellus'                      => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Marcellus SC'                   => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Marck Script'                   => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Margarine'                      => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Markazi Text'                   => array(
                'variants' => array('regular', '500', '600', '700'),
                'category' => 'serif',
            ),
            'Marko One'                      => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Marmelad'                       => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Martel'                         => array(
                'variants' => array('200', '300', 'regular', '600', '700', '800', '900'),
                'category' => 'serif',
            ),
            'Martel Sans'                    => array(
                'variants' => array('200', '300', 'regular', '600', '700', '800', '900'),
                'category' => 'sans-serif',
            ),
            'Marvel'                         => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'sans-serif',
            ),
            'Mate'                           => array(
                'variants' => array('regular', 'italic'),
                'category' => 'serif',
            ),
            'Mate SC'                        => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Maven Pro'                      => array(
                'variants' => array('regular', '500', '600', '700', '800', '900'),
                'category' => 'sans-serif',
            ),
            'McLaren'                        => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Meddon'                         => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'MedievalSharp'                  => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Medula One'                     => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Meera Inimai'                   => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Megrim'                         => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Meie Script'                    => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Merienda'                       => array(
                'variants' => array('regular', '700'),
                'category' => 'handwriting',
            ),
            'Merienda One'                   => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Merriweather'                   => array(
                'variants' => array('300', '300italic', 'regular', 'italic', '700', '700italic', '900', '900italic'),
                'category' => 'serif',
            ),
            'Merriweather Sans'              => array(
                'variants' => array('300', 'regular', '500', '600', '700', '800', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic'),
                'category' => 'sans-serif',
            ),
            'Metal'                          => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Metal Mania'                    => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Metamorphous'                   => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Metrophobic'                    => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Michroma'                       => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Milonga'                        => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Miltonian'                      => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Miltonian Tattoo'               => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Mina'                           => array(
                'variants' => array('regular', '700'),
                'category' => 'sans-serif',
            ),
            'Miniver'                        => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Miriam Libre'                   => array(
                'variants' => array('regular', '700'),
                'category' => 'sans-serif',
            ),
            'Mirza'                          => array(
                'variants' => array('regular', '500', '600', '700'),
                'category' => 'display',
            ),
            'Miss Fajardose'                 => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Mitr'                           => array(
                'variants' => array('200', '300', 'regular', '500', '600', '700'),
                'category' => 'sans-serif',
            ),
            'Modak'                          => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Modern Antiqua'                 => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Mogra'                          => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Molengo'                        => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Molle'                          => array(
                'variants' => array('italic'),
                'category' => 'handwriting',
            ),
            'Monda'                          => array(
                'variants' => array('regular', '700'),
                'category' => 'sans-serif',
            ),
            'Monofett'                       => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Monoton'                        => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Monsieur La Doulaise'           => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Montaga'                        => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Montez'                         => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Montserrat'                     => array(
                'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
                'category' => 'sans-serif',
            ),
            'Montserrat Alternates'          => array(
                'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
                'category' => 'sans-serif',
            ),
            'Montserrat Subrayada'           => array(
                'variants' => array('regular', '700'),
                'category' => 'sans-serif',
            ),
            'Moul'                           => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Moulpali'                       => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Mountains of Christmas'         => array(
                'variants' => array('regular', '700'),
                'category' => 'display',
            ),
            'Mouse Memoirs'                  => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Mr Bedfort'                     => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Mr Dafoe'                       => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Mr De Haviland'                 => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Mrs Saint Delafield'            => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Mrs Sheppards'                  => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Mukta'                          => array(
                'variants' => array('200', '300', 'regular', '500', '600', '700', '800'),
                'category' => 'sans-serif',
            ),
            'Mukta Mahee'                    => array(
                'variants' => array('200', '300', 'regular', '500', '600', '700', '800'),
                'category' => 'sans-serif',
            ),
            'Mukta Malar'                    => array(
                'variants' => array('200', '300', 'regular', '500', '600', '700', '800'),
                'category' => 'sans-serif',
            ),
            'Mukta Vaani'                    => array(
                'variants' => array('200', '300', 'regular', '500', '600', '700', '800'),
                'category' => 'sans-serif',
            ),
            'Mulish'                         => array(
                'variants' => array('200', '300', 'regular', '500', '600', '700', '800', '900', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
                'category' => 'sans-serif',
            ),
            'MuseoModerno'                   => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800', '900'),
                'category' => 'display',
            ),
            'Mystery Quest'                  => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'NTR'                            => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Nanum Brush Script'             => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Nanum Gothic'                   => array(
                'variants' => array('regular', '700', '800'),
                'category' => 'sans-serif',
            ),
            'Nanum Gothic Coding'            => array(
                'variants' => array('regular', '700'),
                'category' => 'monospace',
            ),
            'Nanum Myeongjo'                 => array(
                'variants' => array('regular', '700', '800'),
                'category' => 'serif',
            ),
            'Nanum Pen Script'               => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Nerko One'                      => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Neucha'                         => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Neuton'                         => array(
                'variants' => array('200', '300', 'regular', 'italic', '700', '800'),
                'category' => 'serif',
            ),
            'New Rocker'                     => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'New Tegomin'                    => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'News Cycle'                     => array(
                'variants' => array('regular', '700'),
                'category' => 'sans-serif',
            ),
            'Newsreader'                     => array(
                'variants' => array('200', '300', 'regular', '500', '600', '700', '800', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic'),
                'category' => 'serif',
            ),
            'Niconne'                        => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Niramit'                        => array(
                'variants' => array('200', '200italic', '300', '300italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
                'category' => 'sans-serif',
            ),
            'Nixie One'                      => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Nobile'                         => array(
                'variants' => array('regular', 'italic', '500', '500italic', '700', '700italic'),
                'category' => 'sans-serif',
            ),
            'Nokora'                         => array(
                'variants' => array('regular', '700'),
                'category' => 'serif',
            ),
            'Norican'                        => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Nosifer'                        => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Notable'                        => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Nothing You Could Do'           => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Noticia Text'                   => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'serif',
            ),
            'Noto Sans'                      => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'sans-serif',
            ),
            'Noto Sans HK'                   => array(
                'variants' => array('100', '300', 'regular', '500', '700', '900'),
                'category' => 'sans-serif',
            ),
            'Noto Sans JP'                   => array(
                'variants' => array('100', '300', 'regular', '500', '700', '900'),
                'category' => 'sans-serif',
            ),
            'Noto Sans KR'                   => array(
                'variants' => array('100', '300', 'regular', '500', '700', '900'),
                'category' => 'sans-serif',
            ),
            'Noto Sans SC'                   => array(
                'variants' => array('100', '300', 'regular', '500', '700', '900'),
                'category' => 'sans-serif',
            ),
            'Noto Sans TC'                   => array(
                'variants' => array('100', '300', 'regular', '500', '700', '900'),
                'category' => 'sans-serif',
            ),
            'Noto Serif'                     => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'serif',
            ),
            'Noto Serif JP'                  => array(
                'variants' => array('200', '300', 'regular', '500', '600', '700', '900'),
                'category' => 'serif',
            ),
            'Noto Serif KR'                  => array(
                'variants' => array('200', '300', 'regular', '500', '600', '700', '900'),
                'category' => 'serif',
            ),
            'Noto Serif SC'                  => array(
                'variants' => array('200', '300', 'regular', '500', '600', '700', '900'),
                'category' => 'serif',
            ),
            'Noto Serif TC'                  => array(
                'variants' => array('200', '300', 'regular', '500', '600', '700', '900'),
                'category' => 'serif',
            ),
            'Nova Cut'                       => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Nova Flat'                      => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Nova Mono'                      => array(
                'variants' => array('regular'),
                'category' => 'monospace',
            ),
            'Nova Oval'                      => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Nova Round'                     => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Nova Script'                    => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Nova Slim'                      => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Nova Square'                    => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Numans'                         => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Nunito'                         => array(
                'variants' => array('200', '200italic', '300', '300italic', 'regular', 'italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
                'category' => 'sans-serif',
            ),
            'Nunito Sans'                    => array(
                'variants' => array('200', '200italic', '300', '300italic', 'regular', 'italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
                'category' => 'sans-serif',
            ),
            'Odibee Sans'                    => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Odor Mean Chey'                 => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Offside'                        => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Oi'                             => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Old Standard TT'                => array(
                'variants' => array('regular', 'italic', '700'),
                'category' => 'serif',
            ),
            'Oldenburg'                      => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Oleo Script'                    => array(
                'variants' => array('regular', '700'),
                'category' => 'display',
            ),
            'Oleo Script Swash Caps'         => array(
                'variants' => array('regular', '700'),
                'category' => 'display',
            ),
            'Open Sans'                      => array(
                'variants' => array('300', '300italic', 'regular', 'italic', '600', '600italic', '700', '700italic', '800', '800italic'),
                'category' => 'sans-serif',
            ),
            'Open Sans Condensed'            => array(
                'variants' => array('300', '300italic', '700'),
                'category' => 'sans-serif',
            ),
            'Oranienbaum'                    => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Orbitron'                       => array(
                'variants' => array('regular', '500', '600', '700', '800', '900'),
                'category' => 'sans-serif',
            ),
            'Oregano'                        => array(
                'variants' => array('regular', 'italic'),
                'category' => 'display',
            ),
            'Orelega One'                    => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Orienta'                        => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Original Surfer'                => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Oswald'                         => array(
                'variants' => array('200', '300', 'regular', '500', '600', '700'),
                'category' => 'sans-serif',
            ),
            'Over the Rainbow'               => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Overlock'                       => array(
                'variants' => array('regular', 'italic', '700', '700italic', '900', '900italic'),
                'category' => 'display',
            ),
            'Overlock SC'                    => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Overpass'                       => array(
                'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', 'regular', 'italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
                'category' => 'sans-serif',
            ),
            'Overpass Mono'                  => array(
                'variants' => array('300', 'regular', '600', '700'),
                'category' => 'monospace',
            ),
            'Ovo'                            => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Oxanium'                        => array(
                'variants' => array('200', '300', 'regular', '500', '600', '700', '800'),
                'category' => 'display',
            ),
            'Oxygen'                         => array(
                'variants' => array('300', 'regular', '700'),
                'category' => 'sans-serif',
            ),
            'Oxygen Mono'                    => array(
                'variants' => array('regular'),
                'category' => 'monospace',
            ),
            'PT Mono'                        => array(
                'variants' => array('regular'),
                'category' => 'monospace',
            ),
            'PT Sans'                        => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'sans-serif',
            ),
            'PT Sans Caption'                => array(
                'variants' => array('regular', '700'),
                'category' => 'sans-serif',
            ),
            'PT Sans Narrow'                 => array(
                'variants' => array('regular', '700'),
                'category' => 'sans-serif',
            ),
            'PT Serif'                       => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'serif',
            ),
            'PT Serif Caption'               => array(
                'variants' => array('regular', 'italic'),
                'category' => 'serif',
            ),
            'Pacifico'                       => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Padauk'                         => array(
                'variants' => array('regular', '700'),
                'category' => 'sans-serif',
            ),
            'Palanquin'                      => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700'),
                'category' => 'sans-serif',
            ),
            'Palanquin Dark'                 => array(
                'variants' => array('regular', '500', '600', '700'),
                'category' => 'sans-serif',
            ),
            'Pangolin'                       => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Paprika'                        => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Parisienne'                     => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Passero One'                    => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Passion One'                    => array(
                'variants' => array('regular', '700', '900'),
                'category' => 'display',
            ),
            'Pathway Gothic One'             => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Patrick Hand'                   => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Patrick Hand SC'                => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Pattaya'                        => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Patua One'                      => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Pavanam'                        => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Paytone One'                    => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Peddana'                        => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Peralta'                        => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Permanent Marker'               => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Petit Formal Script'            => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Petrona'                        => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
                'category' => 'serif',
            ),
            'Philosopher'                    => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'sans-serif',
            ),
            'Piazzolla'                      => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
                'category' => 'serif',
            ),
            'Piedra'                         => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Pinyon Script'                  => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Pirata One'                     => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Plaster'                        => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Play'                           => array(
                'variants' => array('regular', '700'),
                'category' => 'sans-serif',
            ),
            'Playball'                       => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Playfair Display'               => array(
                'variants' => array('regular', '500', '600', '700', '800', '900', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
                'category' => 'serif',
            ),
            'Playfair Display SC'            => array(
                'variants' => array('regular', 'italic', '700', '700italic', '900', '900italic'),
                'category' => 'serif',
            ),
            'Podkova'                        => array(
                'variants' => array('regular', '500', '600', '700', '800'),
                'category' => 'serif',
            ),
            'Poiret One'                     => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Poller One'                     => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Poly'                           => array(
                'variants' => array('regular', 'italic'),
                'category' => 'serif',
            ),
            'Pompiere'                       => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Pontano Sans'                   => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Poor Story'                     => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Poppins'                        => array(
                'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
                'category' => 'sans-serif',
            ),
            'Port Lligat Sans'               => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Port Lligat Slab'               => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Potta One'                      => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Pragati Narrow'                 => array(
                'variants' => array('regular', '700'),
                'category' => 'sans-serif',
            ),
            'Prata'                          => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Preahvihear'                    => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Press Start 2P'                 => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Pridi'                          => array(
                'variants' => array('200', '300', 'regular', '500', '600', '700'),
                'category' => 'serif',
            ),
            'Princess Sofia'                 => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Prociono'                       => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Prompt'                         => array(
                'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
                'category' => 'sans-serif',
            ),
            'Prosto One'                     => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Proza Libre'                    => array(
                'variants' => array('regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic'),
                'category' => 'sans-serif',
            ),
            'Public Sans'                    => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
                'category' => 'sans-serif',
            ),
            'Puritan'                        => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'sans-serif',
            ),
            'Purple Purse'                   => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Quando'                         => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Quantico'                       => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'sans-serif',
            ),
            'Quattrocento'                   => array(
                'variants' => array('regular', '700'),
                'category' => 'serif',
            ),
            'Quattrocento Sans'              => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'sans-serif',
            ),
            'Questrial'                      => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Quicksand'                      => array(
                'variants' => array('300', 'regular', '500', '600', '700'),
                'category' => 'sans-serif',
            ),
            'Quintessential'                 => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Qwigley'                        => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Racing Sans One'                => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Radley'                         => array(
                'variants' => array('regular', 'italic'),
                'category' => 'serif',
            ),
            'Rajdhani'                       => array(
                'variants' => array('300', 'regular', '500', '600', '700'),
                'category' => 'sans-serif',
            ),
            'Rakkas'                         => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Raleway'                        => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
                'category' => 'sans-serif',
            ),
            'Raleway Dots'                   => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Ramabhadra'                     => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Ramaraja'                       => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Rambla'                         => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'sans-serif',
            ),
            'Rammetto One'                   => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Ranchers'                       => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Rancho'                         => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Ranga'                          => array(
                'variants' => array('regular', '700'),
                'category' => 'display',
            ),
            'Rasa'                           => array(
                'variants' => array('300', 'regular', '500', '600', '700'),
                'category' => 'serif',
            ),
            'Rationale'                      => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Ravi Prakash'                   => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Recursive'                      => array(
                'variants' => array('300', 'regular', '500', '600', '700', '800', '900'),
                'category' => 'sans-serif',
            ),
            'Red Hat Display'                => array(
                'variants' => array('regular', 'italic', '500', '500italic', '700', '700italic', '900', '900italic'),
                'category' => 'sans-serif',
            ),
            'Red Hat Text'                   => array(
                'variants' => array('regular', 'italic', '500', '500italic', '700', '700italic'),
                'category' => 'sans-serif',
            ),
            'Red Rose'                       => array(
                'variants' => array('300', 'regular', '500', '600', '700'),
                'category' => 'display',
            ),
            'Redressed'                      => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Reem Kufi'                      => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Reenie Beanie'                  => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Reggae One'                     => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Revalia'                        => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Rhodium Libre'                  => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Ribeye'                         => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Ribeye Marrow'                  => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Righteous'                      => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Risque'                         => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Roboto'                         => array(
                'variants' => array('100', '100italic', '300', '300italic', 'regular', 'italic', '500', '500italic', '700', '700italic', '900', '900italic'),
                'category' => 'sans-serif',
            ),
            'Roboto Condensed'               => array(
                'variants' => array('300', '300italic', 'regular', 'italic', '700', '700italic'),
                'category' => 'sans-serif',
            ),
            'Roboto Mono'                    => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic'),
                'category' => 'monospace',
            ),
            'Roboto Slab'                    => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800', '900'),
                'category' => 'serif',
            ),
            'Rochester'                      => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Rock Salt'                      => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'RocknRoll One'                  => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Rokkitt'                        => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800', '900'),
                'category' => 'serif',
            ),
            'Romanesco'                      => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Ropa Sans'                      => array(
                'variants' => array('regular', 'italic'),
                'category' => 'sans-serif',
            ),
            'Rosario'                        => array(
                'variants' => array('300', 'regular', '500', '600', '700', '300italic', 'italic', '500italic', '600italic', '700italic'),
                'category' => 'sans-serif',
            ),
            'Rosarivo'                       => array(
                'variants' => array('regular', 'italic'),
                'category' => 'serif',
            ),
            'Rouge Script'                   => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Rowdies'                        => array(
                'variants' => array('300', 'regular', '700'),
                'category' => 'display',
            ),
            'Rozha One'                      => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Rubik'                          => array(
                'variants' => array('300', 'regular', '500', '600', '700', '800', '900', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
                'category' => 'sans-serif',
            ),
            'Rubik Mono One'                 => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Ruda'                           => array(
                'variants' => array('regular', '500', '600', '700', '800', '900'),
                'category' => 'sans-serif',
            ),
            'Rufina'                         => array(
                'variants' => array('regular', '700'),
                'category' => 'serif',
            ),
            'Ruge Boogie'                    => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Ruluko'                         => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Rum Raisin'                     => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Ruslan Display'                 => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Russo One'                      => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Ruthie'                         => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Rye'                            => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Sacramento'                     => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Sahitya'                        => array(
                'variants' => array('regular', '700'),
                'category' => 'serif',
            ),
            'Sail'                           => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Saira'                          => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
                'category' => 'sans-serif',
            ),
            'Saira Condensed'                => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800', '900'),
                'category' => 'sans-serif',
            ),
            'Saira Extra Condensed'          => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800', '900'),
                'category' => 'sans-serif',
            ),
            'Saira Semi Condensed'           => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800', '900'),
                'category' => 'sans-serif',
            ),
            'Saira Stencil One'              => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Salsa'                          => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Sanchez'                        => array(
                'variants' => array('regular', 'italic'),
                'category' => 'serif',
            ),
            'Sancreek'                       => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Sansita'                        => array(
                'variants' => array('regular', 'italic', '700', '700italic', '800', '800italic', '900', '900italic'),
                'category' => 'sans-serif',
            ),
            'Sansita Swashed'                => array(
                'variants' => array('300', 'regular', '500', '600', '700', '800', '900'),
                'category' => 'display',
            ),
            'Sarabun'                        => array(
                'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic'),
                'category' => 'sans-serif',
            ),
            'Sarala'                         => array(
                'variants' => array('regular', '700'),
                'category' => 'sans-serif',
            ),
            'Sarina'                         => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Sarpanch'                       => array(
                'variants' => array('regular', '500', '600', '700', '800', '900'),
                'category' => 'sans-serif',
            ),
            'Satisfy'                        => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Sawarabi Gothic'                => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Sawarabi Mincho'                => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Scada'                          => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'sans-serif',
            ),
            'Scheherazade'                   => array(
                'variants' => array('regular', '700'),
                'category' => 'serif',
            ),
            'Schoolbell'                     => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Scope One'                      => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Seaweed Script'                 => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Secular One'                    => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Sedgwick Ave'                   => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Sedgwick Ave Display'           => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Sen'                            => array(
                'variants' => array('regular', '700', '800'),
                'category' => 'sans-serif',
            ),
            'Sevillana'                      => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Seymour One'                    => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Shadows Into Light'             => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Shadows Into Light Two'         => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Shanti'                         => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Share'                          => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'display',
            ),
            'Share Tech'                     => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Share Tech Mono'                => array(
                'variants' => array('regular'),
                'category' => 'monospace',
            ),
            'Shippori Mincho'                => array(
                'variants' => array('regular', '500', '600', '700', '800'),
                'category' => 'serif',
            ),
            'Shippori Mincho B1'             => array(
                'variants' => array('regular', '500', '600', '700', '800'),
                'category' => 'serif',
            ),
            'Shojumaru'                      => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Short Stack'                    => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Shrikhand'                      => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Siemreap'                       => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Sigmar One'                     => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Signika'                        => array(
                'variants' => array('300', 'regular', '500', '600', '700'),
                'category' => 'sans-serif',
            ),
            'Signika Negative'               => array(
                'variants' => array('300', 'regular', '600', '700'),
                'category' => 'sans-serif',
            ),
            'Simonetta'                      => array(
                'variants' => array('regular', 'italic', '900', '900italic'),
                'category' => 'display',
            ),
            'Single Day'                     => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Sintony'                        => array(
                'variants' => array('regular', '700'),
                'category' => 'sans-serif',
            ),
            'Sirin Stencil'                  => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Six Caps'                       => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Skranji'                        => array(
                'variants' => array('regular', '700'),
                'category' => 'display',
            ),
            'Slabo 13px'                     => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Slabo 27px'                     => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Slackey'                        => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Smokum'                         => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Smythe'                         => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Sniglet'                        => array(
                'variants' => array('regular', '800'),
                'category' => 'display',
            ),
            'Snippet'                        => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Snowburst One'                  => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Sofadi One'                     => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Sofia'                          => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Solway'                         => array(
                'variants' => array('300', 'regular', '500', '700', '800'),
                'category' => 'serif',
            ),
            'Song Myung'                     => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Sonsie One'                     => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Sora'                           => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800'),
                'category' => 'sans-serif',
            ),
            'Sorts Mill Goudy'               => array(
                'variants' => array('regular', 'italic'),
                'category' => 'serif',
            ),
            'Source Code Pro'                => array(
                'variants' => array('200', '200italic', '300', '300italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '900', '900italic'),
                'category' => 'monospace',
            ),
            'Source Sans Pro'                => array(
                'variants' => array('200', '200italic', '300', '300italic', 'regular', 'italic', '600', '600italic', '700', '700italic', '900', '900italic'),
                'category' => 'sans-serif',
            ),
            'Source Serif Pro'               => array(
                'variants' => array('200', '200italic', '300', '300italic', 'regular', 'italic', '600', '600italic', '700', '700italic', '900', '900italic'),
                'category' => 'serif',
            ),
            'Space Grotesk'                  => array(
                'variants' => array('300', 'regular', '500', '600', '700'),
                'category' => 'sans-serif',
            ),
            'Space Mono'                     => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'monospace',
            ),
            'Spartan'                        => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800', '900'),
                'category' => 'sans-serif',
            ),
            'Special Elite'                  => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Spectral'                       => array(
                'variants' => array('200', '200italic', '300', '300italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic'),
                'category' => 'serif',
            ),
            'Spectral SC'                    => array(
                'variants' => array('200', '200italic', '300', '300italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic'),
                'category' => 'serif',
            ),
            'Spicy Rice'                     => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Spinnaker'                      => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Spirax'                         => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Squada One'                     => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Sree Krushnadevaraya'           => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Sriracha'                       => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Srisakdi'                       => array(
                'variants' => array('regular', '700'),
                'category' => 'display',
            ),
            'Staatliches'                    => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Stalemate'                      => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Stalinist One'                  => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Stardos Stencil'                => array(
                'variants' => array('regular', '700'),
                'category' => 'display',
            ),
            'Stick'                          => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Stint Ultra Condensed'          => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Stint Ultra Expanded'           => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Stoke'                          => array(
                'variants' => array('300', 'regular'),
                'category' => 'serif',
            ),
            'Strait'                         => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Stylish'                        => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Sue Ellen Francisco'            => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Suez One'                       => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Sulphur Point'                  => array(
                'variants' => array('300', 'regular', '700'),
                'category' => 'sans-serif',
            ),
            'Sumana'                         => array(
                'variants' => array('regular', '700'),
                'category' => 'serif',
            ),
            'Sunflower'                      => array(
                'variants' => array('300', '500', '700'),
                'category' => 'sans-serif',
            ),
            'Sunshiney'                      => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Supermercado One'               => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Sura'                           => array(
                'variants' => array('regular', '700'),
                'category' => 'serif',
            ),
            'Suranna'                        => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Suravaram'                      => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Suwannaphum'                    => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Swanky and Moo Moo'             => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Syncopate'                      => array(
                'variants' => array('regular', '700'),
                'category' => 'sans-serif',
            ),
            'Syne'                           => array(
                'variants' => array('regular', '500', '600', '700', '800'),
                'category' => 'sans-serif',
            ),
            'Syne Mono'                      => array(
                'variants' => array('regular'),
                'category' => 'monospace',
            ),
            'Syne Tactile'                   => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Tajawal'                        => array(
                'variants' => array('200', '300', 'regular', '500', '700', '800', '900'),
                'category' => 'sans-serif',
            ),
            'Tangerine'                      => array(
                'variants' => array('regular', '700'),
                'category' => 'handwriting',
            ),
            'Taprom'                         => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Tauri'                          => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Taviraj'                        => array(
                'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
                'category' => 'serif',
            ),
            'Teko'                           => array(
                'variants' => array('300', 'regular', '500', '600', '700'),
                'category' => 'sans-serif',
            ),
            'Telex'                          => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Tenali Ramakrishna'             => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Tenor Sans'                     => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Text Me One'                    => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Texturina'                      => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
                'category' => 'serif',
            ),
            'Thasadith'                      => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'sans-serif',
            ),
            'The Girl Next Door'             => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Tienne'                         => array(
                'variants' => array('regular', '700', '900'),
                'category' => 'serif',
            ),
            'Tillana'                        => array(
                'variants' => array('regular', '500', '600', '700', '800'),
                'category' => 'handwriting',
            ),
            'Timmana'                        => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Tinos'                          => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'serif',
            ),
            'Titan One'                      => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Titillium Web'                  => array(
                'variants' => array('200', '200italic', '300', '300italic', 'regular', 'italic', '600', '600italic', '700', '700italic', '900'),
                'category' => 'sans-serif',
            ),
            'Tomorrow'                       => array(
                'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
                'category' => 'sans-serif',
            ),
            'Trade Winds'                    => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Train One'                      => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Trirong'                        => array(
                'variants' => array('100', '100italic', '200', '200italic', '300', '300italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic', '800', '800italic', '900', '900italic'),
                'category' => 'serif',
            ),
            'Trispace'                       => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800'),
                'category' => 'sans-serif',
            ),
            'Trocchi'                        => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Trochut'                        => array(
                'variants' => array('regular', 'italic', '700'),
                'category' => 'display',
            ),
            'Truculenta'                     => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800', '900'),
                'category' => 'sans-serif',
            ),
            'Trykker'                        => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Tulpen One'                     => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Turret Road'                    => array(
                'variants' => array('200', '300', 'regular', '500', '700', '800'),
                'category' => 'display',
            ),
            'Ubuntu'                         => array(
                'variants' => array('300', '300italic', 'regular', 'italic', '500', '500italic', '700', '700italic'),
                'category' => 'sans-serif',
            ),
            'Ubuntu Condensed'               => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Ubuntu Mono'                    => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'monospace',
            ),
            'Ultra'                          => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Uncial Antiqua'                 => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Underdog'                       => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Unica One'                      => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'UnifrakturCook'                 => array(
                'variants' => array('700'),
                'category' => 'display',
            ),
            'UnifrakturMaguntia'             => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Unkempt'                        => array(
                'variants' => array('regular', '700'),
                'category' => 'display',
            ),
            'Unlock'                         => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Unna'                           => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'serif',
            ),
            'VT323'                          => array(
                'variants' => array('regular'),
                'category' => 'monospace',
            ),
            'Vampiro One'                    => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Varela'                         => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Varela Round'                   => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Varta'                          => array(
                'variants' => array('300', 'regular', '500', '600', '700'),
                'category' => 'sans-serif',
            ),
            'Vast Shadow'                    => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Vesper Libre'                   => array(
                'variants' => array('regular', '500', '700', '900'),
                'category' => 'serif',
            ),
            'Viaoda Libre'                   => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Vibes'                          => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Vibur'                          => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Vidaloka'                       => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Viga'                           => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Voces'                          => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Volkhov'                        => array(
                'variants' => array('regular', 'italic', '700', '700italic'),
                'category' => 'serif',
            ),
            'Vollkorn'                       => array(
                'variants' => array('regular', '500', '600', '700', '800', '900', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
                'category' => 'serif',
            ),
            'Vollkorn SC'                    => array(
                'variants' => array('regular', '600', '700', '900'),
                'category' => 'serif',
            ),
            'Voltaire'                       => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Waiting for the Sunrise'        => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Wallpoet'                       => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Walter Turncoat'                => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Warnes'                         => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Wellfleet'                      => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Wendy One'                      => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Wire One'                       => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'Work Sans'                      => array(
                'variants' => array('100', '200', '300', 'regular', '500', '600', '700', '800', '900', '100italic', '200italic', '300italic', 'italic', '500italic', '600italic', '700italic', '800italic', '900italic'),
                'category' => 'sans-serif',
            ),
            'Xanh Mono'                      => array(
                'variants' => array('regular', 'italic'),
                'category' => 'monospace',
            ),
            'Yanone Kaffeesatz'              => array(
                'variants' => array('200', '300', 'regular', '500', '600', '700'),
                'category' => 'sans-serif',
            ),
            'Yantramanav'                    => array(
                'variants' => array('100', '300', 'regular', '500', '700', '900'),
                'category' => 'sans-serif',
            ),
            'Yatra One'                      => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Yellowtail'                     => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Yeon Sung'                      => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Yeseva One'                     => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Yesteryear'                     => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Yrsa'                           => array(
                'variants' => array('300', 'regular', '500', '600', '700'),
                'category' => 'serif',
            ),
            'Yusei Magic'                    => array(
                'variants' => array('regular'),
                'category' => 'sans-serif',
            ),
            'ZCOOL KuaiLe'                   => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'ZCOOL QingKe HuangYou'          => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'ZCOOL XiaoWei'                  => array(
                'variants' => array('regular'),
                'category' => 'serif',
            ),
            'Zen Dots'                       => array(
                'variants' => array('regular'),
                'category' => 'display',
            ),
            'Zeyada'                         => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Zhi Mang Xing'                  => array(
                'variants' => array('regular'),
                'category' => 'handwriting',
            ),
            'Zilla Slab'                     => array(
                'variants' => array('300', '300italic', 'regular', 'italic', '500', '500italic', '600', '600italic', '700', '700italic'),
                'category' => 'serif',
            ),
            'Zilla Slab Highlight'           => array(
                'variants' => array('regular', '700'),
                'category' => 'display',
            )
        );
    }

}