<?php

namespace YoanBernabeu\DaplosBundle\Exception;

/**
 * Exception lancée lorsqu'une ressource n'est pas trouvée sur l'API DAPLOS.
 *
 * Code HTTP concerné : 404 (Not Found)
 */
class DaplosNotFoundException extends DaplosApiException
{
}
