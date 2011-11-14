<?php
    /**
     * Abstract base class which must be implemented by every controller
     */
    interface Controller
    {
        abstract function __construct(IRequest $request, Response $response);

        abstract function action_index();
    }
?>
