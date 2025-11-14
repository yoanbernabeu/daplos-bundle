<?php

namespace YoanBernabeu\DaplosBundle\Exception;

/**
 * Exception lancée lors d'erreurs serveur de l'API DAPLOS.
 *
 * Codes HTTP concernés : 500 (Internal Server Error), 502 (Bad Gateway), 503 (Service Unavailable)
 */
class DaplosServerException extends DaplosApiException
{
}
