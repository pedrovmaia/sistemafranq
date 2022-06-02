<?php
// DEFINE SISTEMA production ou dev ################
define('SYS_DEV', 'dev'); //Sistema em produção ou desenvolvimento

if (SYS_DEV == "dev") {

    // DEFINE A BASE DO SITE ####################
    if ($_SERVER['HTTP_HOST'] == 'localhost'):
        define('BASE', 'https://localhost/KnnIdiomas/sistema_franquia_svn.git/trunk'); //Url raiz do site no localhost
    else:
        define('BASE', 'https://www.matricom.com.br/knn/sistema-teste'); //Url raiz do site no servidor
    endif;

    /*
     * BANCO DE DADOS
     */
    if ($_SERVER['HTTP_HOST'] == 'localhost'):
        define('SIS_DB_HOST', 'matricom_teste.l70cnn1695.mysql.dbaas.com.br'); //Link do banco de dados no localhost
        define('SIS_DB_USER', 'matricom_teste'); //Usuário do banco de dados no localhost
        define('SIS_DB_PASS', 'matricom1!2@3#'); //Senha  do banco de dados no localhost
        define('SIS_DB_DBSA', 'matricom_teste'); //Nome  do banco de dados no localhost
    else:
        define('SIS_DB_HOST', 'matricom_teste.l70cnn1695.mysql.dbaas.com.br'); //Link do banco de dados no localhost
        define('SIS_DB_USER', 'matricom_teste'); //Usuário do banco de dados no localhost
        define('SIS_DB_PASS', 'matricom1!2@3#'); //Senha  do banco de dados no localhost
        define('SIS_DB_DBSA', 'matricom_teste'); //Nome  do banco de dados no localhost
    endif;

} elseif (SYS_DEV == "production") {

    // DEFINE A BASE DO SITE ####################
    if ($_SERVER['HTTP_HOST'] == 'localhost'):
        define('BASE', 'https://localhost/KnnIdiomas/sistema_franquia_svn.git/trunk'); //Url raiz do site no localhost
    else:
        define('BASE', 'https://www.matricom.com.br/knn/sistema'); //Url raiz do site no servidor
    endif;

    /*
     * BANCO DE DADOS
     */
    if ($_SERVER['HTTP_HOST'] == 'localhost'):
        define('SIS_DB_HOST', 'matricom.l70cnn1695.mysql.dbaas.com.br'); //Link do banco de dados no localhost
        define('SIS_DB_USER', 'matricom'); //UsuÃ¡rio do banco de dados no localhost
        define('SIS_DB_PASS', 'matricom1!2@3#'); //Senha  do banco de dados no localhost
        define('SIS_DB_DBSA', 'matricom'); //Nome  do banco de dados no localhost
    else:
        define('SIS_DB_HOST', 'matricom.l70cnn1695.mysql.dbaas.com.br'); //Link do banco de dados no localhost
        define('SIS_DB_USER', 'matricom'); //UsuÃ¡rio do banco de dados no localhost
        define('SIS_DB_PASS', 'matricom1!2@3#'); //Senha  do banco de dados no localhost
        define('SIS_DB_DBSA', 'matricom'); //Nome  do banco de dados no localhost
    endif;

}