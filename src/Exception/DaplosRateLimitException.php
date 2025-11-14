<?php

namespace YoanBernabeu\DaplosBundle\Exception;

/**
 * Exception lancée lorsque la limite de requêtes de l'API DAPLOS est atteinte.
 * 
 * Code HTTP concerné : 429 (Too Many Requests)
 */
class DaplosRateLimitException extends DaplosApiException
{
}


