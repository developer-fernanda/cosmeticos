<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa usar o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar estas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define( 'DB_NAME', 'cosmeticos' );

/** Usuário do banco de dados MySQL */
define( 'DB_USER', 'root' );

/** Senha do banco de dados MySQL */
define( 'DB_PASSWORD', '' );

/** Nome do host do MySQL */
define( 'DB_HOST', 'localhost' );

/** Charset do banco de dados a ser usado na criação das tabelas. */
define( 'DB_CHARSET', 'utf8mb4' );

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define( 'DB_COLLATE', '' );

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para invalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '=^OI.n1X&WS2Yu{wl[4NAeLWht,/qoFe{6z$t)SsipF;}}M${]p9ooC6ZnOl*xkE' );
define( 'SECURE_AUTH_KEY',  'UJ)r3Kpb}+Eqa-#;z}nA:a1[X+IF:948&BMoqTk{jfH^f&2!xje7(3wUnu##j>X{' );
define( 'LOGGED_IN_KEY',    'wOXIj#)@gHej_Cjx]=54(,^Myby8&@uDy fuP6-Gk`8F6~oROP,Nkk=!9QR Cmv-' );
define( 'NONCE_KEY',        'm?UT$qwMA v,F}g*)KO/2(9`$PbniTrLj4]ov(wEr6BSe`zfYB96js<1*(_IoJxz' );
define( 'AUTH_SALT',        '5O3|<2;fD:8yU&./duFwcW7.(aWUPAl><}IiZV.%!Pir#rbWfarfseM0]/(0h0yj' );
define( 'SECURE_AUTH_SALT', 'u_FG{~N,dtFW-?V:+gmQ;WnMjiS}T1|N*X( [(1#(%Gl|X[8i|&0=VH+{U%BCeY>' );
define( 'LOGGED_IN_SALT',   '](gQ**R~b_U@,%>H=<ig IKqF7nrD#SSR]~FKpwQ[|a|pQ,v7mz#? 2~Sq;C<2}K' );
define( 'NONCE_SALT',       ' !ywgfm;,LOK@z1TB([FYKt`.EHgV%S*i)h !YgHxyS^zwepX_Mmuq L:T@H`:mT' );

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * um prefixo único para cada um. Somente números, letras e sublinhados!
 */
$table_prefix = 'wp_';

/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Configura as variáveis e arquivos do WordPress. */
require_once ABSPATH . 'wp-settings.php';
