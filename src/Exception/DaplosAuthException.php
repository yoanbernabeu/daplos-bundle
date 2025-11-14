<?php

namespace YoanBernabeu\DaplosBundle\Exception;

/**
 * Exception lancée lors d'erreurs d'authentification avec l'API DAPLOS.
 * 
 * Codes HTTP concernés : 401 (Unauthorized), 403 (Forbidden)
 */
class DaplosAuthException extends DaplosApiException
{
}


